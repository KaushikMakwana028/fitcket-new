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

    if ($id) {
        $data = [
            'settled'    => 1,
            'settled_amount	'  => $amount,
            'settled_at	' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $updated = $this->db->update('rent_transactions', $data);

        if ($updated) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'DB update failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
    }
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


















}