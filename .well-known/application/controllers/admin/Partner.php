<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');







class Partner extends Admin_Controller

{



    public function __construct()

    {

        parent::__construct();



    }





   public function index()

{

    $this->load->view('admin/header');

    $this->load->view('admin/partner_view');

    $this->load->view('admin/footer');

}



public function fetchPartners()

{

    $limit  = $this->input->post('limit');

    $offset = $this->input->post('offset');

    $search = $this->input->post('search');



    $this->db->select('

        users.id, 

        users.name as partner_name, 

        users.gym_name, 

        users.mobile, 

        users.isActive as user_isActive, 

        provider.profile_image, 

        provider.address, 

        provider.isActive as provider_isActive,

        IFNULL(provider_wallet.balance, 0) as wallet_balance

    ');

    $this->db->from('users');

    $this->db->join('provider', 'provider.provider_id = users.id', 'left');

    $this->db->join('provider_wallet', 'provider_wallet.provider_id = users.id', 'left'); // fetch wallet

    $this->db->where('users.role', 2);



    if (!empty($search)) {

        $this->db->group_start();

        $this->db->like('users.name', $search);

        $this->db->or_like('users.gym_name', $search);

        $this->db->or_like('users.mobile', $search);

        $this->db->group_end();

    }



    $this->db->limit($limit, $offset);

    $query = $this->db->get();

    $data['partners'] = $query->result();



    // Count total records for pagination

    $this->db->select('COUNT(*) as total');

    $this->db->from('users');

    $this->db->where('users.role', 2);

    if (!empty($search)) {

        $this->db->group_start();

        $this->db->like('users.name', $search);

        $this->db->or_like('users.gym_name', $search);

        $this->db->or_like('users.mobile', $search);

        $this->db->group_end();

    }

    $total = $this->db->get()->row()->total;



    $data['total'] = $total;



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

        echo json_encode(['status' => 'error', 'message' => 'Failed to update partner status.']);

    } else {

        echo json_encode(['status' => 'success']);

    }

}

public function loginAsPartner($partnerId)
{
    // Ensure only admin can impersonate
    if (!$this->admin) {
        $this->session->set_flashdata('error', 'Unauthorized access.');
        redirect('admin/login');
    }

    // Fetch partner details
    $partner = $this->db->get_where('users', ['id' => $partnerId, 'role' => 2])->row();

    if ($partner) {
        $partnerArray = (array) $partner;

        // Backup current admin session
        $this->session->set_userdata('admin_backup', $this->admin);
        $this->session->set_userdata('admin_as_partner', true);
        $this->session->set_userdata('provider', $partnerArray);

        // Regenerate session ID for security
        $this->session->sess_regenerate(TRUE);

        redirect('provider/dashboard');
    } else {
        $this->session->set_flashdata('error', 'Partner not found.');
        redirect('admin/partner');
    }
}

public function backToAdmin()
{
    if ($this->session->userdata('admin_as_partner') && $this->session->userdata('admin_backup')) {
        $admin_backup = $this->session->userdata('admin_backup');

        // Restore admin session
        $this->session->set_userdata('admin', $admin_backup);

        // Cleanup partner impersonation
        $this->session->unset_userdata('provider');
        $this->session->unset_userdata('admin_backup');
        $this->session->unset_userdata('admin_as_partner');

        // Regenerate session ID for security
        $this->session->sess_regenerate(TRUE);

        $this->session->set_flashdata('success', 'You are back in Admin Panel.');
        redirect('admin/dashboard');
    } else {
        redirect('admin/login');
    }
}






}