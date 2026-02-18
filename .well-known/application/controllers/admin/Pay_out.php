<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Pay_out extends Admin_Controller

{



    public function __construct()

    {

        parent::__construct();

    }



    public function index($id){



       $data['provider'] = $this->general_model->getOne('users', array('id' =>$id));

       $data['bank_details'] = $this->general_model->getOne('provider_bank_details', array('provider_id' => $id));

       $data['wallet_belence'] = $this->general_model->getOne('provider_wallet', array('provider_id' => $id));
       $data['amount'] = $this->general_model->getOne('provider_payouts', array('provider_id' => $id));






        $this->load->view('admin/header');

        $this->load->view('admin/payout_form',$data);

        $this->load->view('admin/footer');



    }



public function pay_out_process()
{
    $provider_id = $this->input->post('provider_id');
    $amount      = $this->input->post('payout_amount');

    if (empty($provider_id) || empty($amount) || $amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
        return;
    }

    // Check if there is a pending payout for this provider
    $this->db->where('provider_id', $provider_id);
    $this->db->where('status', 'pending');
    $pending = $this->db->get('provider_payouts')->row();

    if ($pending) {
        // Update status and updated_at
        $updateData = [
            'status'     => 'success', // or whichever status you want
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $pending->id);
        $this->db->update('provider_payouts', $updateData);

        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Payout updated successfully'
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to update payout'
            ]);
        }
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'No pending payout found for this provider'
        ]);
    }
}


public function payment(){
    echo "Hh";
    die;
    $this->load->view('admin/header');
    $this->load->view('admin/payment_view');
    $this->load->view('admin/header');

}




}