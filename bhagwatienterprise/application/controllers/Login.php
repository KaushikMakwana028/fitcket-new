<?php

class Login extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();

        $this->load->library('session');

		$this->load->library('form_validation');



        $this->load->helper('url');

        $this->load->model('general_model');





       

    }



    public function index()
{
   
    // Validate mobile and password
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === true) {

        $password = md5($this->input->post('password'));
        $mobile = $this->input->post('mobile');

        // Match mobile, password and role
        $where = array(
            'mobile' => $mobile,
            'password' => $password,
            'role' => 1
        );

        $user = $this->general_model->getOne('users', $where);

        if ($user) {
            // Store session data
            $session = array(
                'id' => $user->id,
                'mobile' => $user->mobile
            );

            $this->session->set_userdata('admin', $session);
            $this->session->set_flashdata('success', 'You have logged in successfully!');
          
            redirect('dashboard', 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Invalid mobile number or password. Please try again.');
            redirect('login', 'refresh');
        }
    }

    // Load login view
    $this->load->view('admin/login_view');
}


    public function logout(){

    $this->session->unset_userdata('user'); // remove user session

    $this->session->set_flashdata('success', 'You have logged out successfully.');

    redirect('login');

    }

   

}