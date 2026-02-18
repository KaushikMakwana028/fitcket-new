<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Controller extends CI_Controller
{
    public $provider;

    public function __construct()
    {
        parent::__construct();

        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
        $this->load->model('general_model');

        $this->user = $this->session->userdata('user');

        // if (!$this->user || !$this->user['is_logged_in']) {
        //     redirect('login');
        // }
    }
}

