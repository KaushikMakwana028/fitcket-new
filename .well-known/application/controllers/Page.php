<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');



class Page extends User_Controller

{



    public function __construct()

    {

        parent::__construct();

    }



    public function index()

    {



        $this->load->view('header');

        $this->load->view('about_us');

        $this->load->view('footer');



    }



    public function contact_us()

    {

        $this->load->view('header');

        $this->load->view('contact_us');

        $this->load->view('footer');

    }



    public function terms_condition(){

    $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'terms-condition'));

// echo "<pre>";

// print_r($data['page_data']);

// die;

        $this->load->view('header');

        $this->load->view('terms_condition',$data);

        $this->load->view('footer');

    }

   public function privacy_policy(){

    $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'privacy-policy'));



    $this->load->view('header');

    $this->load->view('privacy_policy', $data);

    $this->load->view('footer');

}

    public function refund_policy(){

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'refund-policy'));



        $this->load->view('header');

        $this->load->view('refund_policy',$data);

        $this->load->view('footer');

    }

    public function submit_query()
    {
        $data = [
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name'  => $this->input->post('last_name', TRUE),
            'email'      => $this->input->post('email', TRUE),
            'phone'      => $this->input->post('phone', TRUE),
            'subject'    => $this->input->post('subject', TRUE),
            'message'    => $this->input->post('message', TRUE),
            'newsletter' => $this->input->post('newsletter') ? 1 : 0,
        ];

        if (empty($data['first_name']) || empty($data['email']) || empty($data['message'])) {
            echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
            return;
        }

        $this->db->insert('contact_queries', $data);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
        }
    }
public function delete_account(){
      $this->load->view('header');

        $this->load->view('delete_account');

        $this->load->view('footer');

}
public function get_review()
{
    $user_id     = $this->input->post('user_id');
    $provider_id = $this->input->post('provider_id');

    $review = $this->db
        ->where('user_id', $user_id)
        ->where('provider_id', $provider_id)
        ->get('reviews')
        ->row();

    if ($review) {
        echo json_encode([
            'status' => true,
            'exists' => true,
            'data'   => $review
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'exists' => false
        ]);
    }
}

public function save_review()
{
    $user_id     = $this->input->post('user_id');
    $provider_id = $this->input->post('provider_id');

    $data = [
        'rating'      => $this->input->post('rating'),
        'review_text' => $this->input->post('review_text'),
    ];

    // check existing review
    $exists = $this->db
        ->where('user_id', $user_id)
        ->where('provider_id', $provider_id)
        ->get('reviews')
        ->row();

    if ($exists) {
        // UPDATE
        $this->db
            ->where('user_id', $user_id)
            ->where('provider_id', $provider_id)
            ->update('reviews', $data);

        echo json_encode([
            'status' => true,
            'message' => 'Review updated successfully'
        ]);
    } else {
        // INSERT
        $data['user_id']     = $user_id;
        $data['provider_id'] = $provider_id;
        $data['created_at']  = date('Y-m-d H:i:s');

        $this->db->insert('reviews', $data);

        echo json_encode([
            'status' => true,
            'message' => 'Review submitted successfully'
        ]);
    }
}

public function session(){
    $this->load->view('header');
    $this->load->view('session_view');
    $this->load->view('footer');

}

}