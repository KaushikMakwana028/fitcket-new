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
    header('Content-Type: application/json');

    try {

        $provider_id = $this->input->post('provider_id');
        $amount      = $this->input->post('payout_amount');
        $note        = $this->input->post('transaction_note');

        /* ================= VALIDATION ================= */
        if (empty($provider_id) || empty($amount) || $amount <= 0) {
            throw new Exception('Invalid payout data');
        }

        /* ================= CHECK PENDING PAYOUT ================= */
        $pending = $this->db
            ->where('provider_id', $provider_id)
            ->where('status', 'pending')
            ->get('provider_payouts')
            ->row();

        if (!$pending) {
            throw new Exception('No pending payout found for this provider');
        }

        /* ================= START TRANSACTION ================= */
        $this->db->trans_start();

        /* ---------- UPDATE PAYOUT ---------- */
        $this->db->where('id', $pending->id)->update('provider_payouts', [
            'status'           => 'success',
            // 'settled_amount'   => $amount,
            'note' => $note,
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

        $db_error = $this->db->error();
        if (!empty($db_error['message'])) {
            throw new Exception($db_error['message']);
        }

        /* ---------- INSERT NOTIFICATION ---------- */
        $this->db->insert('provider_notifications', [
            'provider_id' => $provider_id,
            'type'        => 'payout',
            'payout_id'   => $pending->id,
            'title'       => 'Payout Settled',
            'message'     => '₹' . number_format($amount, 2) . ' has been credited to your account.',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $db_error = $this->db->error();
        if (!empty($db_error['message'])) {
            throw new Exception($db_error['message']);
        }

        $notification_id = $this->db->insert_id();

        /* ================= COMPLETE TRANSACTION ================= */
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Database transaction failed');
        }

        /* ================= PUSH NOTIFICATION (NON BLOCKING) ================= */
        try {
            // $notification_id = $this->db->insert_id();

// ✅ 7. Send Expo Push Notification (TESTING)
$this->send_expo_push(
    $provider_id,
    'Payout Settled 💰',
    '₹' . number_format($amount, 2) . ' credited to your account.',
    [
        'type' => 'payout',
        'notification_id' => $notification_id,
        'payout_id' => $pending->id
    ]
);

        } catch (Exception $e) {
            log_message('error', 'Payout push failed: ' . $e->getMessage());
        }

        /* ================= SUCCESS RESPONSE ================= */
        echo json_encode([
            'status'  => 'success',
            'message' => 'Payout settled successfully'
        ]);

    } catch (Exception $e) {

        /* ================= ROLLBACK IF FAILED ================= */
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        }

        log_message('error', 'Payout error: ' . $e->getMessage());

        echo json_encode([
            'status'  => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

private function send_expo_push($provider_id, $title, $message, $data = [])
{
    log_message('info', '📱 Attempting to send Expo push to provider: ' . $provider_id);
    
    // Get token from database
    $tokenRow = $this->db
        ->where('provider_id', $provider_id)
        ->where('is_active', 1)
        ->get('provider_tokens')
        ->row();

    if (!$tokenRow) {
        log_message('error', '❌ No token record found for provider: ' . $provider_id);
        return false;
    }

    if (empty($tokenRow->expo_token)) {
        log_message('error', '❌ Expo token is empty for provider: ' . $provider_id);
        return false;
    }

    $expo_token = $tokenRow->expo_token;
    log_message('info', '✅ Found Expo token: ' . substr($expo_token, 0, 30) . '...');

    // Validate token format
    if (!preg_match('/^ExponentPushToken\[.+\]$/', $expo_token)) {
        log_message('error', '❌ Invalid Expo token format: ' . $expo_token);
        return false;
    }

    // Prepare payload
    $payload = [
        'to' => $expo_token,
        'title' => $title,
        'body' => $message,
        'sound' => 'default',
        'priority' => 'high',
        'channelId' => 'default',
        'ttl' => 2419200,
        'data' => $data
    ];

    log_message('info', '📤 Sending payload: ' . json_encode($payload));

    // Send to Expo
    $ch = curl_init('https://exp.host/--/api/v2/push/send');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        log_message('error', '❌ Expo Push cURL Error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    log_message('info', '📥 Expo API Response Code: ' . $httpCode);
    log_message('info', '📥 Expo API Response: ' . $result);

    if ($httpCode !== 200) {
        log_message('error', '❌ Expo Push HTTP Error: ' . $httpCode);
        return false;
    }

    $response = json_decode($result, true);

    if (!empty($response['data'][0]['status']) && $response['data'][0]['status'] === 'error') {
        log_message('error', '❌ Expo Push Error: ' . json_encode($response['data'][0]));
        return false;
    }

    log_message('info', '✅ Expo push notification sent successfully to provider: ' . $provider_id);
    return true;
}


public function payment(){
    echo "Hh";
    die;
    $this->load->view('admin/header');
    $this->load->view('admin/payment_view');
    $this->load->view('admin/header');

}




}