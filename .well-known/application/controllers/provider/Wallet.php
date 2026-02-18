<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');







class Wallet extends Provider_Controller

{







    public function __construct()

    {







        parent::__construct();



 }



 public function index()
{
    $provider_id = $this->provider['id'];

    // 1. Get wallet balance from provider_wallet table
    $wallet = $this->db->get_where('provider_wallet', ['provider_id' => $provider_id])->row();
    $wallet_balance = $wallet ? $wallet->balance : 0;

    // 2. Get withdrawals
    $withdraw = $this->general_model->getAll('provider_payouts', ['provider_id' => $provider_id]);

    // 3. Get wallet credit history (latest first)
    $credits = $this->db->select('o.total, o.created_at, o.txnid as booking_id')
                        ->from('orders o')
                        ->join('order_items oi', 'oi.order_id = o.id')
                        ->where('oi.provider_id', $provider_id)
                        ->where('o.status', 'success')
                        ->order_by('o.created_at', 'DESC') // latest first
                        ->get()
                        ->result();

    $transactions = [];
    foreach ($credits as $c) {
        $transactions[] = [
            'amount'    => $c->total,
            'type'      => 'Credit',
            'date'      => $c->created_at,
            'reference' => 'Booking ID: '.$c->booking_id
        ];
    }

    // 4. Get wallet minimum setting
    $query2 = $this->db->query("SELECT wallet_min FROM payment_settings LIMIT 1");
    $wallet_min = ($query2->num_rows() > 0) ? $query2->row()->wallet_min : 0.00;

    $data = [
        'wallet_balance' => $wallet_balance,
        'wallet_min'     => $wallet_min,
        'transactions'   => $transactions,
        'withdraw'       => $withdraw
    ];

    $this->load->view('provider/header');
    $this->load->view('provider/wallet_view', $data);
    $this->load->view('provider/footer');
}





   public function scheduled()

{

    $provider_id = $this->provider['id'];



    // Fetch provider schedules and index by day

    $query = $this->db->get_where('provider_schedules', ['provider_id' => $provider_id])->result();

    $schedules = [];

    foreach ($query as $row) {

        $schedules[strtolower($row->day)] = $row;  // index by day name

    }



    $data['schedules'] = $schedules;

// echo "<pre>";
// print_r($data['schedules']);
// die;

    $this->load->view('provider/header');

    $this->load->view('provider/schedule_view', $data); // Pass data to view

    $this->load->view('provider/footer');

}



    public function save_schedule()

{

    $provider_id = $this->provider['id']; 

    $status = $this->input->post('status');  

    $from   = $this->input->post('from');    

    $to     = $this->input->post('to');      



    foreach ($status as $day => $dayStatus) {

        $data = [

            'provider_id' => $provider_id,

            'day'         => $day,

            'status'      => $dayStatus,

            'start_time'  => ($dayStatus == 'open') ? $from[$day] : null,

            'end_time'    => ($dayStatus == 'open') ? $to[$day] : null

        ];




        $existing = $this->db->get_where('provider_schedules', [

            'provider_id' => $provider_id,

            'day'         => $day

        ])->row();



        if ($existing) {

            $this->db->where('id', $existing->id)->update('provider_schedules', $data);

        } else {

            $this->db->insert('provider_schedules', $data);

        }

    }



    echo json_encode(['status' => 'success']);

}

public function withdraw_request()
{
    $provider_id = $this->input->post('provider_id');
    $amount      = $this->input->post('amount');

    $bankDetails = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row_array();

    if (!$bankDetails) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Please add bank details first.'
        ]);
        return;
    }

    $wallet = $this->db->get_where('provider_wallet', ['provider_id' => $provider_id])->row_array();

    if (!$wallet) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Wallet not found for this provider.'
        ]);
        return;
    }

    if ($wallet['balance'] < $amount) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Insufficient wallet balance.'
        ]);
        return;
    }

    
    $newBalance = $wallet['balance'] - $amount;
    $this->db->where('provider_id', $provider_id);
    $this->db->update('provider_wallet', [
        'balance'    => $newBalance,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    $transaction_id = 'TXN' . uniqid();
    $data = [
        'provider_id' => $provider_id,
        'amount'      => $amount,
        'txn_id'      => $transaction_id,
        'status'      => 'pending',
        'created_at'  => date('Y-m-d H:i:s')
    ];

    $this->db->insert('provider_payouts', $data);

    if ($this->db->affected_rows() > 0) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Withdraw request submitted successfully.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Failed to submit withdraw request. Please try again.'
        ]);
    }
}




}