<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Payment extends Admin_Controller
{



    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/payment_view');
        $this->load->view('admin/footer');
    }
    public function payouts_list()
    {
        $limit = $this->input->post('limit') ?? 5;
        $offset = $this->input->post('offset') ?? 0;

        // Fetch payouts with provider details (all providers, no restriction)
        $this->db->select("p.id, p.provider_id, p.amount, p.status, p.created_at as request_date, u.gym_name, u.mobile");
        $this->db->from("provider_payouts p");
        $this->db->join("users u", "u.id = p.provider_id", "left");
        $this->db->order_by("p.id", "DESC");
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        // Count total records (all providers)
        $total = $this->db->count_all("provider_payouts");

        echo json_encode([
            'data' => $query->result(),
            'total' => $total
        ]);
    }

    public function payment_setting()
    {
         $query = $this->db->get('payment_settings');
        $data['payment'] = $query->row_array(); 

        $this->load->view('admin/header');
        $this->load->view('admin/payment_setting_view', $data);
        $this->load->view('admin/footer');
    }
   public function save() {
        $id         = $this->input->post('id', TRUE);
        $wallet_min = $this->input->post('wallet_min', TRUE);
        $commission = $this->input->post('commission', TRUE);

        if ($wallet_min === "" || $commission === "") {
            echo json_encode([
                'status'  => 'error',
                'message' => 'All fields are required.'
            ]);
            return;
        }

        $data = [
            'wallet_min' => $wallet_min,
            'commission' => $commission,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($id)) {
            
            $this->db->where('id', $id);
            $result = $this->db->update('payment_settings', $data);
        } else {
           
            $result = $this->db->insert('payment_settings', $data);
        }

        if ($result) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Payment settings saved successfully.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to save settings. Please try again.'
            ]);
        }
    }

}