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
        $currentMonth = date('m'); 
        $currentYear = date('Y');

        // User counts (all-time)
        $data['total_customers'] = $this->general_model->getCount('users', ['role' => 0]);
        $data['total_partners'] = $this->general_model->getCount('users', ['role' => 2]);

        // Booking counts (monthly)
        $this->db->from('orders');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['total_bookings'] = (int) $this->db->count_all_results();

        $this->db->from('orders');
        $this->db->where('status', 'completed');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['completed_bookings'] = (int) $this->db->count_all_results();

        $this->db->from('orders');
        $this->db->where('status', 'pending');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['pending_bookings'] = (int) $this->db->count_all_results();

        $this->db->from('orders');
        $this->db->where('status', 'cancelled');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['cancelled_bookings'] = (int) $this->db->count_all_results();

        // Booking revenue (monthly)
        $this->db->select_sum('total');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('orders');
        $data['booking_revenue'] = (float) ($query->row()->total ?? 0);
        $data['monthly_bookings'] = $data['total_bookings'];

        // Commission logs (monthly)
        $this->db->select_sum('gross_amount');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('commission_log');
        $data['total_balance'] = (float) ($query->row()->gross_amount ?? 0);

        $this->db->select_sum('commission_amt');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('commission_log');
        $data['total_earning'] = (float) ($query->row()->commission_amt ?? 0);

        // Provider payouts (monthly)
        $this->db->select_sum('amount');
        $this->db->where('status', 'pending');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('provider_payouts');
        $data['pending_payout'] = (float) ($query->row()->amount ?? 0);

        $this->db->select_sum('amount');
        $this->db->where('status', 'success');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('provider_payouts');
        $data['fulfilled_payout'] = (float) ($query->row()->amount ?? 0);

        // Rent transactions (monthly)
        $this->db->select_sum('amount');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('rent_transactions');
        $data['total_collected'] = (float) ($query->row()->amount ?? 0);

        $this->db->select_sum('settled_amount');
        $this->db->where('settled', 1);
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('rent_transactions');
        $data['settled_amount'] = (float) ($query->row()->settled_amount ?? 0);

        $this->db->select_sum('amount');
        $this->db->where('settled', 0);
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('rent_transactions');
        $data['pending_amount'] = (float) ($query->row()->amount ?? 0);

        $this->db->select('SUM(amount - settled_amount) AS profit', false);
        $this->db->where('settled', 1);
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $query = $this->db->get('rent_transactions');
        $data['rent_profit'] = (float) ($query->row()->profit ?? 0);

        // Transaction counts (monthly)
        $this->db->from('rent_transactions');
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['total_transactions'] = (int) $this->db->count_all_results();

        $this->db->from('rent_transactions');
        $this->db->where('settled', 1);
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['settled_transactions'] = (int) $this->db->count_all_results();

        $this->db->from('rent_transactions');
        $this->db->where('settled', 0);
        $this->db->where('MONTH(created_at)', $currentMonth);
        $this->db->where('YEAR(created_at)', $currentYear);
        $data['pending_transactions'] = (int) $this->db->count_all_results();

        // Monthly revenue card value
        $data['grand_total'] = $data['rent_profit'] + $data['total_earning'];

        // Review stats (all-time)
        $data['total_reviews'] = $this->db->count_all('reviews');

        $this->db->select_avg('rating');
        $avg = $this->db->get('reviews')->row();
        $data['average_rating'] = round((float) ($avg->rating ?? 0), 1);

        $ratings = [1, 2, 3, 4, 5];
        $data['rating_counts'] = [];
        foreach ($ratings as $r) {
            $this->db->where('rating', $r);
            $data['rating_counts'][$r] = $this->db->count_all_results('reviews');
        }

        $this->load->view('admin/header');
        $this->load->view('admin/dashboard_view', $data);
        $this->load->view('admin/footer');
    }

    public function offer()
    {
        $query = $this->db->get('offer_settings');
        $data['offer'] = $query->row_array();

        $this->load->view('admin/header');
        $this->load->view('admin/offer_view', $data);
        $this->load->view('admin/footer');
    }

    public function save_offer()
    {
        $id = $this->input->post('id', true);
        $offer_percent = $this->input->post('offer_percent', true);
        $min_amount = $this->input->post('min_amount', true);

        $offer_percent = $offer_percent !== '' ? $offer_percent : 0;
        $min_amount = $min_amount !== '' ? $min_amount : 0;

        $data = [
            'offer_percent' => $offer_percent,
            'min_amount' => $min_amount,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($id)) {
            $this->db->where('id', $id);
            $result = $this->db->update('offer_settings', $data);
        } else {
            $result = $this->db->insert('offer_settings', $data);
        }

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Offer settings saved successfully.',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to save offer settings. Please try again.',
            ]);
        }
    }
}
