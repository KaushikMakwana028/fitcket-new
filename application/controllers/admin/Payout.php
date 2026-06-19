<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Pay_out extends Admin_Controller

{
private $cf_client_id = "YOUR_CLIENT_ID";
private $cf_client_secret = "YOUR_CLIENT_SECRET";
private $cf_base_url = "https://payout-gamma.cashfree.com"; // sandbox


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
private function getToken()
{
    $url = $this->cf_base_url . "/payout/v1/authorize";

    $payload = [
        "clientId" => $this->cf_client_id,
        "clientSecret" => $this->cf_client_secret
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($res, true);

    return $data['data']['token'] ?? null;
}
private function addBeneficiary($token, $bank, $provider_id)
{
    $url = $this->cf_base_url . "/payout/v1/addBeneficiary";

    $beneId = "prov_" . $provider_id;

    $payload = [
        "beneId" => $beneId,
        "name" => $bank->account_holder_name,
        "email" => "test@test.com",
        "phone" => "9999999999",
        "bankAccount" => $bank->account_number,
        "ifsc" => $bank->ifsc_code,
        "address1" => "India"
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ]
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return json_decode($res, true);
}
private function sendPayout($token, $beneId, $amount)
{
    $url = $this->cf_base_url . "/payout/v1/requestTransfer";

    $transferId = uniqid("txn_");

    $payload = [
        "beneId" => $beneId,
        "amount" => $amount,
        "transferId" => $transferId,
        "transferMode" => "imps",
        "remarks" => "Payout"
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ]
    ]);

    $res = curl_exec($ch);
    curl_close($ch);

    return [
        'response' => json_decode($res, true),
        'transferId' => $transferId
    ];
}


   public function pay_out_process()
{
    $provider_id = $this->input->post('provider_id');
    $amount      = $this->input->post('payout_amount');
    $note        = $this->input->post('transaction_note');

   
    $provider = $this->general_model->getOne('users', ['id' => $provider_id]);
    $bank     = $this->general_model->getOne('provider_bank_details', ['provider_id' => $provider_id]);
    $wallet   = $this->general_model->getOne('provider_wallet', ['provider_id' => $provider_id]);

   
    if (empty($provider) || empty($bank) || empty($wallet)) {
        echo json_encode(['status' => 'error', 'message' => 'Provider or bank details not found']);
        return;
    }

    if ($amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid amount']);
        return;
    }

    if ($amount > $wallet->balance) {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient wallet balance']);
        return;
    }

    // =====================================================
    // ✅ STEP 1: Insert PENDING payout
    // =====================================================
    $payout_id = $this->general_model->insert('provider_payouts', [
        'provider_id' => $provider_id,
        'amount'      => $amount,
        'note'        => $note,
        'status'      => 'pending',
        'created_at'  => date('Y-m-d H:i:s')
    ]);

    // =====================================================
    // ✅ STEP 2: Get Cashfree Token
    // =====================================================
    $token = $this->getToken();

    if (!$token) {
        $this->general_model->update('provider_payouts', [
            'status' => 'failed'
        ], ['id' => $payout_id]);

        echo json_encode(['status' => 'error', 'message' => 'Token generation failed']);
        return;
    }

    // =====================================================
    // ✅ STEP 3: Check / Create Beneficiary
    // =====================================================
    if (empty($bank->beneficiary_id)) {

        $bene = $this->addBeneficiary($token, $bank, $provider_id);

        if (empty($bene) || $bene['status'] != "SUCCESS") {

            $this->general_model->update('provider_payouts', [
                'status' => 'failed'
            ], ['id' => $payout_id]);

            echo json_encode(['status' => 'error', 'message' => 'Beneficiary creation failed']);
            return;
        }

        $beneId = "prov_" . $provider_id;

        // save beneficiary
        $this->general_model->update('provider_bank_details', [
            'beneficiary_id' => $beneId
        ], ['provider_id' => $provider_id]);

    } else {
        $beneId = $bank->beneficiary_id;
    }

    // =====================================================
    // ✅ STEP 4: Send Payout
    // =====================================================
    $result = $this->sendPayout($token, $beneId, $amount);

    $res = $result['response'];

    // =====================================================
    // ✅ STEP 5: Handle Response
    // =====================================================
    if (!empty($res) && $res['status'] == "SUCCESS") {

        // 💰 Deduct wallet
        $new_balance = $wallet->balance - $amount;

        $this->general_model->update('provider_wallet', [
            'balance' => $new_balance
        ], ['provider_id' => $provider_id]);

        // ✅ Update payout success
        $this->general_model->update('provider_payouts', [
            'status' => 'success',
            'txn_id' => $result['transferId']
        ], ['id' => $payout_id]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Payout successful'
        ]);

    } else {

        // ❌ Mark failed
        $this->general_model->update('provider_payouts', [
            'status' => 'failed'
        ], ['id' => $payout_id]);

        echo json_encode([
            'status' => 'error',
            'message' => $res['message'] ?? 'Payout failed'
        ]);
    }
}





}