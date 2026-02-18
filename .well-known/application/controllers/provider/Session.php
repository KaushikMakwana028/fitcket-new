<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Live_session extends Provider_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    
    public function index()
    {
        $this->load->library('form_validation');
    $this->load->helper('form');
        
       $this->load->view('provider/header');
       $this->load->view('provider/session_form');
       $this->load->view('provider/footer');

    }
}