<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');







class Customers extends Admin_Controller

{



    public function __construct()

    {

        parent::__construct();



    }





   public function index()

{

    $this->load->view('admin/header');

    $this->load->view('admin/customer_view');

    $this->load->view('admin/footer');

}



public function fetch_customers()
{
    $this->load->database();

    $limit = 10; // records per page
    $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
    $offset = ($page - 1) * $limit;

    $search = $this->input->get('search');

    // ---------- COUNT QUERY ----------
    $this->db->from('users');
$this->db->where('role', 0);

if (!empty($search)) {
    $this->db->group_start()
             ->like('name', $search)
             ->or_like('email', $search)
             ->or_like('mobile', $search)
             ->group_end();
}
$total = $this->db->count_all_results();

// ---------- DATA QUERY ----------
$this->db->from('users');
$this->db->where('role', 0);

if (!empty($search)) {
    $this->db->group_start()
             ->like('name', $search)
             ->or_like('email', $search)
             ->or_like('mobile', $search)
             ->group_end();
}
$this->db->limit($limit, $offset);
$query = $this->db->get();
    $data['customers'] = $query->result_array();
    $data['total'] = $total;
    $data['limit'] = $limit;
    $data['page'] = $page;

    echo json_encode($data);
}


 public function togglePartnerStatus()

{

    $partnerId = $this->input->post('partner_id');

    $status = $this->input->post('status');



    $this->db->trans_start();

    $this->db->where('id', $partnerId)->update('users', ['isActive' => $status]);

    $this->db->where('provider_id', $partnerId)->update('provider', ['isActive' => $status]);

    $this->db->trans_complete();



    if ($this->db->trans_status() === FALSE) {

        echo json_encode(['status' => 'error', 'message' => 'Failed to update user status.']);

    } else {

        echo json_encode(['status' => 'success']);

    }

}





}