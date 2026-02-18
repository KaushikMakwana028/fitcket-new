<?php
// application/controllers/api/Session_booking.php
require_once(APPPATH . 'core/User_Controller.php');


defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Session_booking extends User_Controller
{
      private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";
    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";

    public function __construct()
    {
       
        parent::__construct();
        $this->load->model('Live_session_model');
    }

    public function index()
{
    // Fetch public sessions
    $sessions = $this->Live_session_model->getPublicSessions();
    
    // ✅ Add availability info for each session
    foreach ($sessions as &$session) {
        $session['availability'] = $this->Live_session_model->checkAvailability($session['id']);
        
        // Check if current user has already booked
        if ($this->user && isset($this->user['id'])) {
            $session['user_booked'] = $this->db->get_where('session_orders', [
                'user_id' => $this->user['id'],
                'session_id' => $session['id'],
                'status' => 'success'
            ])->row_array() ? true : false;
        } else {
            $session['user_booked'] = false;
        }
    }
    
    $data['sessions'] = $sessions;

    // Load views
    $this->load->view('header');
    $this->load->view('session_view', $data);
    $this->load->view('footer');
}

public function pay($session_id)
{
    if (!$this->user['id']) {
        $current_url = urlencode(current_url());
        redirect('login?redirect=' . $current_url);
        exit;
    }

    $session = $this->Live_session_model->getSessionById($session_id);

    if (!$session) {
        $this->session->set_flashdata('error', 'Session not found');
        redirect('sessions');
        return;
    }

    // ✅ Check if user already booked this session
    $existing_booking = $this->db->get_where('session_orders', [
        'user_id' => $this->user['id'],
        'session_id' => $session_id,
        'status' => 'success'
    ])->row_array();
    
    if ($existing_booking) {
        $this->session->set_flashdata('error', 'You have already booked this session');
        redirect('session_booking/my_sessions');
        return;
    }

    // ✅ Check availability
    $availability = $this->Live_session_model->checkAvailability($session_id);
    
    if (!$availability['available']) {
        $this->session->set_flashdata('error', 'Sorry, this session is fully booked');
        redirect('sessions');
        return;
    }

    // FREE SESSION
    if ($session['price'] <= 0) {
        $this->bookFreeSession($session);
        return;
    }

    // ✅ Generate unique Agora UID
    $agora_uid = $this->generateAgoraUID($this->user['id'], $session_id);
    
    $txnid = 'SES' . uniqid();
    $amount = intval($session['price'] * 100);

    // ✅ Use transaction to prevent race conditions
    $this->db->trans_start();
    
    // Double-check availability within transaction
    $availability = $this->Live_session_model->checkAvailability($session_id);
    
    if (!$availability['available']) {
        $this->db->trans_complete();
        $this->session->set_flashdata('error', 'Sorry, this session was just fully booked');
        redirect('sessions');
        return;
    }

    // Create order
    $this->db->insert('session_orders', [
        'user_id'     => $this->user['id'],
        'session_id'  => $session['id'],
        'provider_id' => $session['provider_id'],
        'amount'      => $session['price'],
        'agora_uid'   => $agora_uid,
        'txnid'       => $txnid,
        'status'      => 'pending',
        'created_at'  => date('Y-m-d H:i:s')
    ]);
    $order_id = $this->db->insert_id();
    
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('error', 'Booking failed. Please try again.');
        redirect('sessions');
        return;
    }

    // Razorpay Order
    $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);
    $razorpayOrder = $api->order->create([
        'receipt' => $txnid,
        'amount' => $amount,
        'currency' => 'INR',
        'payment_capture' => 1
    ]);

    $data = [
        "key" => $this->RAZORPAY_KEY_ID,
        "amount" => $amount,
        "name" => "Session Booking",
        "description" => $session['title'],
        "image" => base_url('assets/logo.png'),
        "prefill" => [
            "name" => $this->user['name'],
            "email" => $this->user['email'],
            "contact" => $this->user['mobile']
        ],
        "order_id" => $razorpayOrder['id'],
        "txnid" => $txnid
    ];

    $this->load->view('header');
    $this->load->view('razorpay_redirect_session', $data);
    $this->load->view('footer');
}

/**
 * ✅ Generate unique Agora UID for user/session combination
 */
private function generateAgoraUID($user_id, $session_id)
{
    // Combine user_id and session_id to create unique UID
    // Keep within Agora's 32-bit unsigned integer limit (2,147,483,647)
    $combined = intval($user_id . str_pad($session_id % 10000, 4, '0', STR_PAD_LEFT));
    
    // Ensure it's positive and within limit
    return abs($combined) % 2147483647;
}

/**
 * ✅ Book free session with capacity check
 */
private function bookFreeSession($session)
{
    // Check availability
    $availability = $this->Live_session_model->checkAvailability($session['id']);
    
    if (!$availability['available']) {
        $this->session->set_flashdata('error', 'Sorry, this session is fully booked');
        redirect('sessions');
        return;
    }
    
    // Check duplicate booking
    $existing = $this->db->get_where('session_orders', [
        'user_id' => $this->user['id'],
        'session_id' => $session['id'],
        'status' => 'success'
    ])->row_array();
    
    if ($existing) {
        $this->session->set_flashdata('error', 'You have already booked this session');
        redirect('session_booking/my_sessions');
        return;
    }
    
    $agora_uid = $this->generateAgoraUID($this->user['id'], $session['id']);
    $txnid = 'FREE' . uniqid();
    
    $this->db->trans_start();
    
    $this->db->insert('session_orders', [
        'user_id'     => $this->user['id'],
        'session_id'  => $session['id'],
        'provider_id' => $session['provider_id'],
        'amount'      => 0,
        'agora_uid'   => $agora_uid,
        'txnid'       => $txnid,
        'status'      => 'success',
        'created_at'  => date('Y-m-d H:i:s')
    ]);
    
    $order_id = $this->db->insert_id();
    
    // ✅ Increment participant count
    $this->Live_session_model->incrementParticipantCount($session['id']);
    
    // Notification to provider
    $this->db->insert('provider_notifications', [
        'provider_id'      => $session['provider_id'],
        'type'             => 'session',
        'session_order_id' => $order_id,
        'title'            => 'New Session Booked',
        'message'          => 'A user has booked your free session.',
        'created_at'       => date('Y-m-d H:i:s')
    ]);
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('error', 'Booking failed. Please try again.');
        redirect('sessions');
        return;
    }
    
    redirect('session_booking/success?txnid=' . urlencode($txnid));
}

/**
 * ✅ Updated Razorpay Callback with participant count
 */
public function razorpay_callback()
{
    $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);

    $payment_id = $this->input->post('razorpay_payment_id');
    $order_id   = $this->input->post('razorpay_order_id');
    $signature  = $this->input->post('razorpay_signature');
    $txnid      = $this->input->post('txnid');

    try {
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ]);

        $this->db->trans_start();
        
        // Mark order success
        $this->db->where('txnid', $txnid)
                 ->update('session_orders', ['status' => 'success']);

        $order = $this->db->get_where('session_orders', ['txnid' => $txnid])->row();
        
        // ✅ Increment participant count
        $this->Live_session_model->incrementParticipantCount($order->session_id);
        
        // Provider notification
        $this->db->insert('provider_notifications', [
            'provider_id'      => $order->provider_id,
            'type'             => 'session',
            'session_order_id' => $order->id,
            'title'            => 'New Session Booked',
            'message'          => 'A user has booked your live session.',
            'created_at'       => date('Y-m-d H:i:s')
        ]);

        // 20% platform commission
        $commission_rate = 20;
        $commission = ($order->amount * $commission_rate) / 100;
        $provider_amount = $order->amount - $commission;

        // Provider wallet update
        $wallet = $this->db->get_where('provider_wallet', [
            'provider_id' => $order->provider_id
        ])->row();

        if ($wallet) {
            $this->db->where('provider_id', $order->provider_id)
                     ->update('provider_wallet', [
                         'balance' => $wallet->balance + $provider_amount
                     ]);
        } else {
            $this->db->insert('provider_wallet', [
                'provider_id' => $order->provider_id,
                'balance' => $provider_amount
            ]);
        }

        // Save payment log
        $this->db->insert('session_payments', [
            'order_id' => $order->id,
            'razorpay_payment_id' => $payment_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        $this->db->trans_complete();

        redirect('session_booking/success?txnid=' . urlencode($txnid));

    } catch (Exception $e) {
        $this->db->where('txnid', $txnid)
                 ->update('session_orders', ['status' => 'failed']);
        redirect('session_booking/failed');
    }
}
    public function success()
{
    $txnid = $this->input->get('txnid');

    if (!$txnid) {
        show_error('Transaction ID missing.');
        return;
    }

    // Fetch session order
    $order = $this->db
        ->get_where('session_orders', ['txnid' => $txnid, 'status' => 'success'])
        ->row_array();

    if (!$order) {
        show_error('Session order not found.');
        return;
    }

    // Fetch user
    $user = $this->db->get_where('users', ['id' => $order['user_id']])->row_array();
    if ($user) {
        $user['is_logged_in'] = true;
        $this->session->set_userdata('user', $user);
    }

    // Fetch session details
  $session = $this->db
    ->select('ls.*, u.gym_name')
    ->from('live_sessions ls')
    ->join('users u', 'u.id = ls.provider_id', 'left')
    ->where('ls.id', $order['session_id'])
    ->get()
    ->row_array();


    $data = [
        'order'   => $order,
        'user'    => $user,
        'session' => $session
    ];
// echo "<pre>";
// print_r($data);
// die;
    $this->load->view('header');
    $this->load->view('session_success', $data);
    $this->load->view('footer');
}


    
        public function my_sessions()
    {
            // echo "h";
            // die;
        $this->db->select('so.*, ls.title, ls.description, ls.session_date, ls.start_time, ls.end_time, ls.status as session_status, ls.room_id, ls.thumbnail, u.gym_name as provider_name')
            ->from('session_orders so')
            ->join('live_sessions ls', 'ls.id = so.session_id', 'left')
            ->join('users u', 'u.id = so.provider_id', 'left')
            ->where('so.user_id', $this->user['id'])
            ->where('so.status', 'success')
            ->order_by('ls.session_date', 'ASC')
            ->order_by('ls.start_time', 'ASC');

        $data['sessions'] = $this->db->get()->result_array();

        $this->load->view('header');
        $this->load->view('my_sessions', $data);
        $this->load->view('footer');
    }

    public function join_session($session_id)
    {
        // 1. Verify user has paid
        $booking = $this->db->get_where('session_orders', [
            'user_id'    => $this->user['id'],
            'session_id' => $session_id,
            'status'     => 'success'
        ])->row_array();   // ✅ ARRAY

        if (!$booking) {
            $this->session->set_flashdata('error', 'You have not booked this session.');
            redirect('session_booking/my_sessions');
        }

        $agora_uid = (int) $booking['agora_uid'];

        // 2. Get session
        $session = $this->Live_session_model->getSessionById($session_id); // already array

        if (!$session) {
            $this->session->set_flashdata('error', 'Session not found.');
            redirect('session_booking/my_sessions');
        }

        // 3. Check live status
        if ($session['status'] !== 'live') {
            $this->session->set_flashdata(
                'error',
                'Session is not live yet. Please wait for the provider to start.'
            );
            redirect('session_booking/my_sessions');
        }

        // 4. Generate Agora token
        $this->load->library('Agora_lib');

        $token = $this->agora_lib->generateToken(
            $session['room_id'],      // ✅ array
            $agora_uid,
            Agora_lib::ROLE_SUBSCRIBER,
            7200
        );

        // 5. Attendance log
        $this->db->insert('session_attendance', [
            'order_id'   => $booking['id'],
            'session_id' => $session_id,
            'user_id'    => $this->user['id'],
            'joined_at'  => date('Y-m-d H:i:s')
        ]);

        // 6. View data
        $data = [
            'session'   => $session,
            'token'     => $token,
            'app_id'    => $this->agora_lib->getAppID(),
            'channel'   => $session['room_id'],
            'uid'       => $agora_uid,
            'user_name' => $this->user['name'],
            'user_type' => 'user'
        ];

        $this->load->view('header');
        $this->load->view('user_live_room', $data);
        $this->load->view('footer');
    }


/**
 * Leave session (AJAX)
 */
public function leave_session()
{
    $session_id = $this->input->post('session_id');
    
    $this->db->where('session_id', $session_id)
             ->where('user_id', $this->user['id'])
             ->update('session_attendance', [
                 'left_at' => date('Y-m-d H:i:s')
             ]);

    echo json_encode(['status' => 'success']);
}
/**
     * FREE SESSION AUTO BOOK
     */
    // private function bookFreeSession($session)
    // {
    //     $this->db->insert('session_orders', [
    //         'user_id'     => $this->user['id'],
    //         'session_id'  => $session['id'],
    //         'provider_id' => $session['provider_id'],
    //         'amount'      => 0,
    //         'txnid'       => 'FREE' . uniqid(),
    //         'status'      => 'success',
    //         'created_at'  => date('Y-m-d H:i:s')
    //     ]);

    //     redirect('session/success');
    // }

}