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





        $this->load->view('admin/header');

        $this->load->view('admin/payout_form',$data);

        $this->load->view('admin/footer');



    }



   public function pay_out_process() {

    

    $provider_id = $this->input->post('provider_id');

    $amount = $this->input->post('payout_amount');

    $note = $this->input->post('transaction_note');



    $provider = $this->general_model->getOne('users', ['id' => $provider_id]);

    $bank = $this->general_model->getOne('provider_bank_details', ['provider_id' => $provider_id]);

    $wallet = $this->general_model->getOne('provider_wallet', ['provider_id' => $provider_id]);



    if (empty($provider) || empty($bank) || empty($wallet)) {

        echo json_encode(['status' => 'error', 'message' => 'Provider or bank details not found']);

        return;

    }



    if ($amount > $wallet->balance) {

        echo json_encode(['status' => 'error', 'message' => 'Insufficient wallet balance']);

        return;

    }



    // Step 1: Generate OAuth token

    $token_url = "https://accounts.payu.in/oauth/token";

    $client_id = "c04e87601e13ad6b947cd23494547b1a9bce1dec99419ae37c8b2864a4947560";

    $client_secret = "5179edf1963a57e5219836d8cf7f54b85a02cd762c84777b30fb067495e49a63";



    $token_payload = [

        "client_id" => $client_id,

        "client_secret" => $client_secret,

        "grant_type" => "client_credentials"

    ];



    $ch = curl_init($token_url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($token_payload));

    $token_result = curl_exec($ch);

    curl_close($ch);



    $token_response = json_decode($token_result, true);

    if (empty($token_response['access_token'])) {

        echo json_encode(['status' => 'error', 'message' => 'Failed to get PayU token']);

        return;

    }

    $auth_token = $token_response['access_token'];



    // Step 2: Make payout request

    $api_url = "https://payout.payu.in/api/payout";

    $payload = [

        "account_number"   => $bank->account_number,

        "ifsc"             => $bank->ifsc_code,

        "amount"           => $amount,

        "purpose"          => "payout",

        "remarks"          => $note,

        "transfer_mode"    => "IMPS", // or NEFT/RTGS

        "beneficiary_name" => $bank->account_holder_name

    ];



    $ch = curl_init($api_url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [

        "Authorization: Bearer ".$auth_token,

        "Content-Type: application/json"

    ]);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $result = curl_exec($ch);

    curl_close($ch);

// echo $result; exit;



    $response = json_decode($result, true);



    // Step 3: Handle response

    if (!empty($response['status']) && $response['status'] == 'success') {

        // Update wallet balance

        $new_balance = $wallet->balance - $amount;

        $this->general_model->update('provider_wallet', ['balance' => $new_balance], ['provider_id' => $provider_id]);



        // Log payout

        $this->general_model->insert('provider_payouts', [

            'provider_id' => $provider_id,

            'amount'      => $amount,

            'txn_id'      => $response['transaction_id'],

            'note'        => $note,

            'created_at'  => date('Y-m-d H:i:s')

        ]);



        echo json_encode(['status' => 'success', 'txn_id' => $response['transaction_id']]);

    } else {

        echo json_encode(['status' => 'error', 'message' => $response['message'] ?? 'PayU API failed']);

    }

}






}