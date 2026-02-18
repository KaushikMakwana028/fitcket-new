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
    $limit  = (int) $this->input->post('limit');
    $offset = (int) $this->input->post('offset');
    $search = trim($this->input->post('search'));

    // ✅ MAIN QUERY
    $this->db->select('
        users.id, 
        users.name as partner_name, 
        users.gym_name, 
        users.mobile, 
        users.isActive as user_isActive, 
        COALESCE(provider.profile_image, "") as profile_image, 
        COALESCE(provider.address, "") as address, 
        provider.isActive as provider_isActive,
        COALESCE(provider_wallet.balance, 0) as wallet_balance
    ');
    $this->db->from('users');
    $this->db->join('provider', 'provider.provider_id = users.id', 'left');
    $this->db->join('provider_wallet', 'provider_wallet.provider_id = users.id', 'left');
    $this->db->where('users.role', 2);

    // Apply search filter
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('users.name', $search);
        $this->db->or_like('users.gym_name', $search);
        $this->db->or_like('users.mobile', $search);
        $this->db->group_end();
    }

    $this->db->order_by('users.id', 'DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    
    $data['partners'] = $query->result();

    // ✅ COUNT QUERY (separate, clean)
    $this->db->select('COUNT(users.id) as total');
    $this->db->from('users');
    $this->db->where('users.role', 2);

    // Apply same search filter for count
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('users.name', $search);
        $this->db->or_like('users.gym_name', $search);
        $this->db->or_like('users.mobile', $search);
        $this->db->group_end();
    }

    $count_result = $this->db->get()->row();
    $data['total'] = (int) ($count_result->total ?? 0);

    // ✅ Add base_url to images
    foreach ($data['partners'] as &$partner) {
        if (!empty($partner->profile_image) && !preg_match('/^http/', $partner->profile_image)) {
            $partner->profile_image = base_url($partner->profile_image);
        } else if (empty($partner->profile_image)) {
            $partner->profile_image = base_url('assets/images/default-user.png');
        }
    }

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