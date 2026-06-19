<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');







class Dashboard extends Admin_Controller
{







    public function __construct()
    {







        parent::__construct();







        $this->load->library('form_validation');



        $this->load->library('session');



        $this->load->model('general_model');

        $this->load->helper(['url', 'form']);



        if (!$this->session->userdata('admin')) {



            redirect('admin');

        }





    }



  public function index()
{
    // 🔹 User Counts
    $data['total_customers'] = $this->general_model->getCount('users', ['role' => 0]);
    $data['total_partners']  = $this->general_model->getCount('users', ['role' => 2]);

    // 🔹 Booking Counts
    $data['total_bookings']    = $this->general_model->getCount('orders');
    $data['completed_bookings'] = $this->general_model->getCount('orders', ['status' => 'completed']);
    $data['pending_bookings']   = $this->general_model->getCount('orders', ['status' => 'pending']);
    $data['cancelled_bookings'] = $this->general_model->getCount('orders', ['status' => 'cancelled']);

    // 🔹 Booking Revenue
    $this->db->select_sum('total');
    $query = $this->db->get('orders');
    $data['booking_revenue'] = $query->row()->amount ?? 0;

    // 🔹 Monthly Bookings
    $this->db->where('MONTH(created_at)', date('m'));
    $this->db->where('YEAR(created_at)', date('Y'));
    $data['monthly_bookings'] = $this->general_model->getCount('orders');

    // 🔹 Commission Logs
    $this->db->select_sum('gross_amount');
    $query = $this->db->get('commission_log');
    $data['total_balance'] = $query->row()->gross_amount ?? 0;

    $this->db->select_sum('commission_amt');
    $query = $this->db->get('commission_log');
    $data['total_earning'] = $query->row()->commission_amt ?? 0;


    // 🔹 Provider Payouts
    $this->db->select_sum('amount');
    $this->db->where('status', 'pending');
    $query = $this->db->get('provider_payouts');
    $data['pending_payout'] = $query->row()->amount ?? 0;

    $this->db->select_sum('amount');
    $this->db->where('status', 'success');
    $query = $this->db->get('provider_payouts');
    $data['fulfilled_payout'] = $query->row()->amount ?? 0;

    // 🔹 Rent Transactions
    $this->db->select_sum('amount');
    $query = $this->db->get('rent_transactions');
    $data['total_collected'] = $query->row()->amount ?? 0;

    $this->db->select_sum('settled_amount');
    $this->db->where('settled', 1);
    $query = $this->db->get('rent_transactions');
    $data['settled_amount'] = $query->row()->settled_amount ?? 0;

    $this->db->select_sum('amount');
    $this->db->where('settled', 0);
    $query = $this->db->get('rent_transactions');
    $data['pending_amount'] = $query->row()->amount ?? 0;

    // Profit (only on settled transactions)
    $this->db->select("SUM(amount - settled_amount) AS profit", false);
    $this->db->where('settled', 1);
    $query = $this->db->get('rent_transactions');
    $data['rent_profit'] = $query->row()->profit ?? 0;

    // Transaction Counts
    $data['total_transactions']   = $this->general_model->getCount('rent_transactions');
    $data['settled_transactions'] = $this->general_model->getCount('rent_transactions', ['settled' => 1]);
    $data['pending_transactions'] = $this->general_model->getCount('rent_transactions', ['settled' => 0]);
        $data['grand_total'] = $data['rent_profit'] + $data['total_earning'];


    // Load View
    $this->load->view('admin/header');
    $this->load->view('admin/dashboard_view', $data);
    $this->load->view('admin/footer');
}

public function offer() {
    // Fetch existing offer settings
    $query = $this->db->get('offer_settings');
    $data['offer'] = $query->row_array(); 

    $this->load->view('admin/header');
    $this->load->view('admin/offer_view', $data);
    $this->load->view('admin/footer');
}

public function save_offer() {

   $id            = $this->input->post('id', TRUE);
    $offer_percent = $this->input->post('offer_percent', TRUE);
    $min_amount    = $this->input->post('min_amount', TRUE);

    // If values are empty, set default 0
    $offer_percent = $offer_percent !== "" ? $offer_percent : 0;
    $min_amount    = $min_amount !== "" ? $min_amount : 0;

    $data = [
        'offer_percent' => $offer_percent,
        'min_amount'    => $min_amount,
        'updated_at'    => date('Y-m-d H:i:s')
    ];

    if (!empty($id)) {
        $this->db->where('id', $id);
        $result = $this->db->update('offer_settings', $data);
    } else {
        $result = $this->db->insert('offer_settings', $data);
    }

    if ($result) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Offer settings saved successfully.'
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Failed to save offer settings. Please try again.'
        ]);
    }
}

}