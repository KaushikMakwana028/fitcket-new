<?php



defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 


require_once(APPPATH . 'core/Admin_Controller.php');







class Settlement extends Admin_Controller
{







    public function __construct()
    {



       parent::__construct();







      

        if (!$this->session->userdata('admin')) {



            redirect('admin');

        }

     }
    public function index(){
    $this->load->view('admin/header.php');
    $this->load->view('admin/settlment_view.php');
    $this->load->view('admin/footer.php');

}
 public function settlement_history(){
    $this->load->view('admin/header.php');
    $this->load->view('admin/settlement_history');
    $this->load->view('admin/footer.php');

}
public function fetch_transactions()
{
    $page   = (int) $this->input->post('page');
    $search = trim($this->input->post('search'));
    $filter = trim($this->input->post('filter')); 

    $limit  = 10; 
    $offset = ($page - 1) * $limit;

    // Base query with joins
    $this->db->from('rent_transactions rt');
    $this->db->join('users u', 'u.id = rt.user_id', 'left');
    $this->db->join('rent_recipients r', 'r.id = rt.recipient_id', 'left');

    // 🔎 Search condition
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('u.name', $search);
        $this->db->or_like('u.mobile', $search);
        $this->db->or_like('r.recipient_name', $search);
        $this->db->or_like('r.account_number', $search);
        $this->db->or_like('r.phone_number', $search);
        $this->db->group_end();
    }

    // ✅ Settlement filter
    if ($filter === 'pending') {
    $this->db->where('rt.settled', '0');
} elseif ($filter === 'success') {
    $this->db->where('rt.settled', '1');
}

    // Count total
    $total = $this->db->count_all_results('', false); // false = don’t reset query

    // Fetch data
    $this->db->select('rt.*, u.name as user_name, u.mobile, r.recipient_name, r.account_number, r.phone_number');
    $this->db->order_by('rt.created_at', 'DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    $data = $query->result_array();

    // Format data before returning
    foreach ($data as &$row) {
        $row['formatted_date']   = date("d M Y, h:i A", strtotime($row['created_at']));
        $row['settlement_status'] = ($row['settled'] == 1) ? 'Success' : 'Pending';
    }

    $total_pages = ceil($total / $limit);

    echo json_encode([
        'status'       => 'success',
        'data'         => $data,
        'total_pages'  => $total_pages,
        'current_page' => $page
    ]);
}
public function transaction_details($id)
{
    // Get transaction
    $this->db->select('*');
    $this->db->from('rent_transactions');
    $this->db->where('id', $id);
    $transaction = $this->db->get()->row();

    if (!$transaction) {
        show_404();
        return;
    }

    // Get recipient details
    $recipient = $this->db->get_where('rent_recipients', ['id' => $transaction->recipient_id])->row();

    // Get user details
    $user = $this->db->get_where('users', ['id' => $transaction->user_id])->row();

    // Merge all into one array
    $data = [
        'transaction' => $transaction,
        'recipient'   => $recipient,
        'user'        => $user
    ];
// echo "<pre>";
// print_r($data);
// die;
    // Load views with data
    $this->load->view('admin/header.php');
    $this->load->view('admin/transaction_details', $data);
    $this->load->view('admin/footer.php');
}

public function settle_transaction()
{
    $id     = $this->input->post('transaction_id');
    $amount = $this->input->post('settled_amount');

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        return;
    }

    log_message('info', '💰 SETTLEMENT START - TXN ID: ' . $id);

    // Get transaction + user
    $transaction = $this->db
        ->select('rt.*, u.id as user_id, u.name')
        ->from('rent_transactions rt')
        ->join('users u', 'u.id = rt.user_id', 'left')
        ->where('rt.id', $id)
        ->get()
        ->row();

    if (!$transaction) {
        log_message('error', '❌ TRANSACTION NOT FOUND - ID: ' . $id);
        echo json_encode(['status' => 'error', 'message' => 'Transaction not found']);
        return;
    }

    // Prevent double settlement
    if ($transaction->settled == 1) {
        echo json_encode(['status' => 'error', 'message' => 'Already settled']);
        return;
    }

    // Update transaction
    $update = [
        'settled'         => 1,
        'settled_amount'  => $amount,
        'settled_at'      => date('Y-m-d H:i:s')
    ];

    $this->db->where('id', $id);
    $updated = $this->db->update('rent_transactions', $update);

    if (!$updated) {
        log_message('error', '❌ DB UPDATE FAILED - TXN ID: ' . $id);
        echo json_encode(['status' => 'error', 'message' => 'DB update failed']);
        return;
    }

    log_message('info', '✅ TRANSACTION SETTLED - TXN ID: ' . $id);

    // 🔔 Prevent duplicate notification
    $alreadySent = $this->db
        ->where('user_id', $transaction->user_id)
        ->where('type', 'transaction_settled')
        ->where('reference_id', $id)
        ->get('user_notifications')
        ->row();

    if (!$alreadySent) {

        // Save notification
        $this->db->insert('user_notifications', [
            'user_id'      => $transaction->user_id,
            'type'         => 'transaction_settled',
            'reference_id' => $id,
            'title'        => 'Payment Settled',
            'message'      => 'Your payment of ₹' . number_format($amount) . ' has been settled successfully.',
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        $notification_id = $this->db->insert_id();
        log_message('info', '🔔 NOTIFICATION SAVED - ID: ' . $notification_id);

        // Push notification
        try {
            $push = $this->send_expo_push(
                $transaction->user_id,
                'Payment Settled',
                'Your payment of ₹' . number_format($amount) . ' has been settled successfully.',
                [
                    'type'            => 'transaction_settled',
                    'transaction_id'  => $id,
                    'notification_id' => $notification_id
                ]
            );

            log_message('info', '📱 PUSH RESULT: ' . json_encode($push));

        } catch (Exception $e) {
            log_message('error', '❌ PUSH ERROR: ' . $e->getMessage());
        }
    }

    echo json_encode(['status' => 'success']);
}


public function fetch_transactions_history()
{
    $page   = $this->input->post('page') ?: 1;
    $search = $this->input->post('search');
    $filter = $this->input->post('filter');
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $this->db->select('t.*, r.recipient_name, r.phone_number'); 
    $this->db->from('rent_transactions t');
    $this->db->join('rent_recipients r', 'r.id = t.recipient_id', 'left');

    $this->db->where('t.settled', 1);

    if ($search) {
        $this->db->group_start();
        $this->db->like('r.recipient_name', $search);
        $this->db->or_like('r.phone_number', $search);
        $this->db->group_end();
    }

    if ($filter !== "") {
        $this->db->where('t.status', $filter);
    }

    
    
    $total = $this->db->count_all_results('', false);
    $this->db->order_by('t.id', 'DESC');


    $this->db->limit($limit, $offset);
    $query = $this->db->get();

    $data = $query->result_array();

    echo json_encode([
        'status' => 'success',
        'data' => $data,
        'total_pages' => ceil($total / $limit)
    ]);
}






private function send_expo_push($user_id, $title, $message, $data = [])
{
    log_message('info', '📱 Push attempt for user: ' . $user_id);

    $tokenRow = $this->db
        ->where('user_id', $user_id)
        ->where('is_active', 1)
        ->get('user_tokens')
        ->row();

    if (!$tokenRow || empty($tokenRow->expo_token)) {
        log_message('error', '❌ Expo token missing for user: ' . $user_id);
        return false;
    }

    $expo_token = trim($tokenRow->expo_token);

    // ✅ Relaxed validation (Expo changed formats)
    if (!str_starts_with($expo_token, 'ExponentPushToken')) {
        log_message('error', '❌ Invalid Expo token: ' . $expo_token);
        return false;
    }

    $payload = [
        'to'    => $expo_token,
        'title' => $title,
        'body'  => $message,
        'sound' => 'default',
        'data'  => $data
    ];

    $ch = curl_init('https://exp.host/--/api/v2/push/send');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_SSL_VERIFYPEER => false // 🔥 important on many servers
    ]);

    $result   = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    log_message('info', '📥 Expo response: ' . $result);

    $response = json_decode($result, true);

    // ✅ Expo success check
    return (
        $httpCode === 200 &&
        isset($response['data'][0]['status']) &&
        $response['data'][0]['status'] === 'ok'
    );
}











}