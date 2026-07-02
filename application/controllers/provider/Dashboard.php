<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');



class Dashboard extends Provider_Controller

{



    public function __construct()

    {







        parent::__construct();







       



    }



 public function index()
{
    $provider_id = $this->provider['id'] ?? $this->provider['user_id'];
    $data['profile_notice'] = $this->get_profile_notice($provider_id);

    // -------- Total Customers ----------
    $this->db->select('COUNT(DISTINCT o.user_id) as total_customers');
    $this->db->from('order_items oi');
    $this->db->join('orders o', 'o.id = oi.order_id', 'inner');
    $this->db->where('oi.provider_id', $provider_id);
    $query = $this->db->get();
    $result = $query->row();
    $data['total_customers'] = $result ? $result->total_customers : 0;

    // -------- Total Bookings ----------
    $this->db->select('COUNT(oi.id) as total_bookings');
    $this->db->from('order_items oi');
    $this->db->join('orders o', 'o.id = oi.order_id', 'inner');
    $this->db->where('oi.provider_id', $provider_id);
    $query2 = $this->db->get();
    $result2 = $query2->row();
    $data['total_bookings'] = $result2 ? $result2->total_bookings : 0;

    // -------- Total Services ----------
    $data['total_service'] = $this->general_model->getCount('service', ['provider_id' => $provider_id]);

    // -------- Wallet Balance ----------
    $this->db->select('balance');
    $this->db->from('provider_wallet');
    $this->db->where('provider_id', $provider_id);
    $wallet = $this->db->get()->row();
    $data['wallet_balance'] = $wallet ? $wallet->balance : 0;

    // -------- Pending Payouts ----------
    $this->db->select('SUM(amount) as total_pending');
    $this->db->from('provider_payouts');
    $this->db->where('provider_id', $provider_id);
    $this->db->where('status', 'pending');
    $pending = $this->db->get()->row();
    $data['pending_payout'] = $pending ? $pending->total_pending : 0;

    // -------- Fulfilled Payouts ----------
    $this->db->select('SUM(amount) as total_success');
    $this->db->from('provider_payouts');
    $this->db->where('provider_id', $provider_id);
    $this->db->where('status', 'success');
    $success = $this->db->get()->row();
    $data['fulfilled_payout'] = $success ? $success->total_success : 0;

    // -------- QR Code (already in your code) ----------
    $data['qr_code_url'] = $this->generate_qr_code();
// echo "<pre>";
// print_r($data);
// die;
    // -------- Load Views ----------
    $this->load->view('provider/header');
    $this->load->view('provider/dashboard_view', $data);
    $this->load->view('provider/footer');
}

private function get_profile_notice($provider_id)
{
    $user = $this->general_model->getOne('users', ['id' => $provider_id]);
    $profile = $this->general_model->getOne('provider', ['provider_id' => $provider_id]);
    $tags_count = $this->db
        ->where('provider_id', $provider_id)
        ->count_all_results('expertise_tag');

    $missing = [];

    if (!$profile || (int) $profile->isActive !== 1) {
        $missing[] = 'active profile';
    }

    $user_fields = [
        'name' => 'partner name',
        'gym_name' => 'business name',
        'email' => 'email',
        'mobile' => 'mobile',
    ];

    foreach ($user_fields as $field => $label) {
        if (!$user || trim((string) ($user->{$field} ?? '')) === '') {
            $missing[] = $label;
        }
    }

    $profile_fields = [
        'service_type' => 'service type',
        'exp' => 'experience',
        'category' => 'category',
        'sub_category' => 'sub category',
        'description' => 'description',
        'address' => 'address',
        'city' => 'availability city',
        'language' => 'language',
        'day_price' => 'day price',
        'week_price' => 'week price',
        'month_price' => 'month price',
        'year_price' => 'year price',
    ];

    foreach ($profile_fields as $field => $label) {
        if (!$profile || trim((string) ($profile->{$field} ?? '')) === '') {
            $missing[] = $label;
        }
    }

    if ($tags_count < 1) {
        $missing[] = 'expertise tags';
    }

    return [
        'show' => !empty($missing),
        'missing' => array_values(array_unique($missing)),
    ];
}




}
