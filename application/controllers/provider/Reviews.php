<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Reviews extends Provider_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function review_list()
    {
        // Logged in provider ID (provider table ID)
        $provider_id = $this->provider['id'] ?? null;

        $this->db->select('
            reviews.id,
            reviews.rating,
            reviews.review_text,
            reviews.created_at,
            u.name as user_name
        ');

        $this->db->from('reviews');
        $this->db->join('users as u', 'u.id = reviews.user_id', 'left');

        // ✅ FILTER ONLY THIS PROVIDER REVIEWS
        $this->db->where('reviews.provider_id', $provider_id);

        $this->db->order_by('reviews.id', 'DESC');

        $data['reviews'] = $this->db->get()->result();

        // Load provider layout
        $this->load->view('provider/header');
        $this->load->view('provider/review_list', $data);
        $this->load->view('provider/footer');
    }
}