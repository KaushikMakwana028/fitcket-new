<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Provider_Controller extends CI_Controller

{

    public $provider;

    public $bookings_by_month = []; 





    public function __construct()

    {

        parent::__construct();



        $this->load->library(['form_validation', 'session']);

        $this->load->helper(['url', 'form']);

        $this->load->model('general_model');



        $this->provider = $this->session->userdata('provider');



        if (!$this->provider) {

            redirect('provider/login');

        }

// print_r($this->provider);

// die;
// print_r($_SESSION);

// die;

$provider_id = $this->provider['id'] ?? $this->provider['user_id'];

// echo $provider_id;
// die;

        $provider_data = $this->general_model->getOne('provider', ['provider_id' => $provider_id]);



        // Store image and make it accessible everywhere

        $this->provider_image = !empty($provider_data->profile_image) 

            ? base_url($provider_data->profile_image) 

            : base_url('assets/images/3d-cartoon-fitness-man.jpg'); 



             // Prepare booking stats globally

        $this->db->select('MONTH(o.created_at) as month, COUNT(oi.id) as total');

        $this->db->from('order_items oi');

        $this->db->join('orders o', 'o.id = oi.order_id', 'inner');

        $this->db->where('oi.provider_id', $provider_id);

        $this->db->group_by('MONTH(o.created_at)');

        $query = $this->db->get();

        $results = $query->result();



        $bookings_by_month = array_fill(1, 12, 0); 

        foreach ($results as $row) {

            $bookings_by_month[(int) $row->month] = (int) $row->total;

        }



        $this->bookings_by_month = array_values($bookings_by_month);

        $this->load->vars(['bookings_by_month' => $this->bookings_by_month]); 
        // echo "h";die;

    }



  
public function generate_qr_code()
{
    
    $provider_id = $this->provider['id'] ?? $this->provider['user_id'];
    // echo $provider_id;
    // die;

    $this->load->library('ciqrcode');

   
    $qr_data = base_url('provider_details/' . $provider_id);

    $qr_directory = FCPATH . 'uploads/qr_codes/';

    if (!is_dir($qr_directory)) {
        mkdir($qr_directory, 0777, true);
    }

    $qr_filename = 'qr_' . $provider_id . '.png';
    $qr_path = $qr_directory . $qr_filename;

    $params['data'] = $qr_data;
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = $qr_path;

    $this->ciqrcode->generate($params);

    // Return the public URL to access the QR code
    return base_url('uploads/qr_codes/' . $qr_filename);
}

}



