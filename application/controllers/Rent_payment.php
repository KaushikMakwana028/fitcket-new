<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); 

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Rent_payment extends User_Controller
{
    private $razorpay_key_id;
    private $razorpay_key_secret;
    private $api;

    public function __construct()
    {
        parent::__construct();

        $this->razorpay_key_id = 'rzp_live_RCge2Oz6kUJE74';
        $this->razorpay_key_secret = 'Pw0gRqzQkzjl5pYW10pXXZeq';
        $this->api = new Api($this->razorpay_key_id, $this->razorpay_key_secret);
        $this->load->model('General_model');
//         echo date('h:i A'); // 12-hour format → 07:50 PM
// echo date('H:i'); 
// die;
    }

public function index()
{
    if (!$this->user['id']) {
        $current_url = urlencode(current_url());
        redirect('login?redirect=' . $current_url);
        exit;
    }

    $user_id = $this->user['id'];

    $recipients = $this->db->query("
    SELECT rr.*
    FROM rent_recipients rr
    INNER JOIN (
        SELECT MIN(id) AS id
        FROM rent_recipients
        WHERE user_id = ? AND isActive = 1
        GROUP BY account_number
    ) x ON rr.id = x.id
    ORDER BY RAND()
    LIMIT 4
", [$user_id])->result_array();



    $filter = $this->input->get('filter') ?? '';

    $per_page = 5;
    $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
    if ($page < 1) { $page = 1; }
    $offset = ($page - 1) * $per_page;

    $where = "WHERE t.user_id = ?";
    $params = [$user_id];

    // ✅ Apply filters
    if ($filter === "today") {
        $where .= " AND DATE(t.created_at) = CURDATE()";
    } elseif ($filter === "month") {
        $where .= " AND MONTH(t.created_at) = MONTH(CURDATE()) AND YEAR(t.created_at) = YEAR(CURDATE())";
    } elseif ($filter === "pending") {
        $where .= " AND t.status = 'pending'";
    } elseif ($filter === "success") {
        $where .= " AND t.status = 'success'";
    }

    $total_transactions = $this->db->query("
        SELECT COUNT(*) as cnt
        FROM rent_transactions t
        $where
    ", $params)->row()->cnt;

    
    $order = "ORDER BY t.created_at DESC";
    if ($filter === "largest") {
        $order = "ORDER BY t.amount DESC";
    } elseif ($filter === "smallest") {
        $order = "ORDER BY t.amount ASC";
    }

    $transactions = $this->db->query("
        SELECT t.*, r.recipient_name, r.bank_name 
        FROM rent_transactions t
        LEFT JOIN rent_recipients r ON t.recipient_id = r.id
        $where
        $order
        LIMIT ? OFFSET ?
    ", array_merge($params, [$per_page, $offset]))->result_array();

    $data = [
        'recipients'         => $recipients,
        'transactions'       => $transactions,
        'total_transactions' => $total_transactions,
        'per_page'           => $per_page,
        'current_page'       => $page,
        'filter'             => $filter
    ];

    if ($this->input->is_ajax_request()) {
        // only transactions + pagination (not recipients) for AJAX refresh
        $this->load->view('transactions_partial', $data);
    } else {
        $this->load->view('header');
        $this->load->view('rent_payment_view', $data);
        $this->load->view('footer');
    }
}

public function remove_recipient()
{
    // if (!$this->input->is_ajax_request()) {
    //     show_404();
    //     return;
    // }

    $id = $this->input->post('id');
    $user_id = $this->user['id'];

    if ($id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $updated = $this->db->update('rent_recipients', ['isActive' => 0]);

        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error']);
    }
}





    public function pay()
    {
        $this->load->library('form_validation');

    // Validation rules
  $this->form_validation->set_rules('name', 'Recipient Name', 'required|trim');
$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
$this->form_validation->set_rules('account_number', 'Account Number', 'required|numeric');
$this->form_validation->set_rules('confirm_account_number', 'Confirm Account Number', 'required|matches[account_number]');
$this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|min_length[11]|max_length[11]');
$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
$this->form_validation->set_rules('transfer_amount', 'Amount', 'required|numeric|greater_than[0]');
$this->form_validation->set_rules('remark', 'Remark', 'required|trim');


    $this->form_validation->set_error_delimiters('<div class="invalid-feedback d-block">', '</div>');

    if ($this->form_validation->run() == FALSE) {
           return $this->index();

    }
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile_number');
        $account_number = $this->input->post('account_number');
        $confirm_account = $this->input->post('confirm_account_number');
        $ifsc_code = $this->input->post('ifsc_code');
        $bank_name = $this->input->post('bank_name');
        $amount = floatval($this->input->post('transfer_amount'));
        $remark = $this->input->post('remark');

        if ($account_number !== $confirm_account) {
            $this->session->set_flashdata('error', 'Account numbers do not match.');
                return $this->index();

        }

        if ($amount <= 0) {
            $this->session->set_flashdata('error', 'Invalid amount.');
                return $this->index();

        }

        $amount_paise = intval($amount * 100);
    //    $amount_paise = intval(1 * 100);

$txnid = uniqid();

        // Insert recipient & rent transaction
        $recipient_data = [
            'user_id' => $this->user['id'],
            'recipient_name' => $name,
            'phone_number' => $mobile,
            'account_number' => $account_number,
            'ifsc_code' => $ifsc_code,
            'bank_name' => $bank_name,
            'remark' => $remark,
            'is_verified' => 0,
            'is_default' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('rent_recipients', $recipient_data);
        $recipient_id = $this->db->insert_id();

        $rent_data = [
            'user_id' => $this->user['id'],
            'recipient_id' => $recipient_id,
            'amount' => $amount,
            'txnid' => $txnid,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('rent_transactions', $rent_data);

        // Razorpay Order
        $razorpayOrder = $this->api->order->create([
            'receipt' => $txnid,
            'amount' => $amount_paise,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $data = [
            "key" => $this->razorpay_key_id,
            "amount" => $amount_paise,
            "name" => "Pay Any Gym",
            "description" => "Transaction #$txnid",
            "image" => base_url('assets/logo.png'),
            "prefill" => [
                "name" => $this->user['name'],
                "email" => $this->user['email'],
                "contact" => $this->user['mobile']
            ],
            "notes" => [
                "txnid" => $txnid,
                "recipient_id" => $recipient_id,
                "remark" => $remark
            ],
            "theme" => [
                "color" => "#3399cc"
            ],
            "order_id" => $razorpayOrder['id'],
            "txnid" => $txnid
        ];

        $this->load->view('header');
        $this->load->view('rezorpay_rent', $data);
        $this->load->view('footer');
    }
public function details()
{
    $id = $this->input->get('id'); 

if (!$id) {
    show_error('Transaction ID is required', 400);
}

$transaction = $this->db->query("
    SELECT 
        t.id, t.txnid, t.amount, t.status, t.settled,t.settled_at,t.created_at,
        r.recipient_name, r.bank_name, r.account_number, r.remark,r.ifsc_code
    FROM rent_transactions t
    LEFT JOIN rent_recipients r ON t.recipient_id = r.id
    WHERE t.id = ? AND t.user_id = ?
", [$id, $this->user['id']])->row_array();

if (!$transaction) {
    show_404(); 
}

// ✅ Fetch logged-in user details
$user = $this->db->query("
    SELECT id AS user_id, name, email, mobile 
    FROM users 
    WHERE id = ?
", [$this->user['id']])->row_array();

// ✅ Merge user info into transaction array
if ($user) {
    $transaction = array_merge($transaction, $user);
}

$data['transaction'] = $transaction;
// echo "<pre>";
// print_r($data['transaction']);
// die;

$this->load->view('header');
$this->load->view('transection_details', $data);
$this->load->view('footer');



}
    public function razorpay_callback()
    {
        $payment_id = $this->input->post('razorpay_payment_id');
        $order_id = $this->input->post('razorpay_order_id');
        $signature = $this->input->post('razorpay_signature');
        $txnid = $this->input->post('txnid');

        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $order_id,
                'razorpay_payment_id' => $payment_id,
                'razorpay_signature' => $signature
            ]);

            $this->db->where('txnid', $txnid)->update('rent_transactions', [
                'status' => 'success',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $this->session->set_flashdata('success', 'payment successful! ID: ' . $payment_id);
            redirect('rent_payment/success?txnid=' . urlencode($txnid));
        } catch (Exception $e) {
            $this->db->where('txnid', $txnid)->update('rent_transactions', ['status' => 'failed']);
            $this->session->set_flashdata('error', 'Payment verification failed!');
            redirect('rent_payment');
        }
    }

    public function success()
    {
        $txnid = $this->input->get('txnid');

        if (!$txnid) {
            show_error('Transaction ID missing.');
            return;
        }

        $transaction = $this->db->get_where('rent_transactions', ['txnid' => $txnid])->row_array();

        if (!$transaction) {
            show_error('Transaction not found.');
            return;
        }

        // Set flash success message if not already set
        if (!$this->session->flashdata('success')) {
            $this->session->set_flashdata('success', 'Payment of ₹' . number_format($transaction['amount'], 2) . ' was successful!');
        }

        $data['transaction'] = $transaction;

        $this->load->view('header');
        $this->load->view('rent_success', $data);
        $this->load->view('footer');
    }

}
