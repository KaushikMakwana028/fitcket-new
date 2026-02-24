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
        $provider_ids_for_notifications = $this->getProviderIdsForNotifications();

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

        // -------- Provider Notifications ----------
        $this->db->where_in('provider_id', $provider_ids_for_notifications);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5); // show latest 5
        $notifications = $this->db->get('provider_notifications')->result();

        $data['notifications'] = $notifications;

        // Unread count
        $this->db->where_in('provider_id', $provider_ids_for_notifications);
        $this->db->where('is_read', 0);
        $data['unread_count'] = $this->db->count_all_results('provider_notifications');

        // ================== REVIEW DATA ==================
        $provider_id = $this->provider['id'] ?? null;

        // Total Reviews
        $this->db->where('provider_id', $provider_id);
        $data['total_reviews'] = $this->db->count_all_results('reviews');

        // Average Rating
        $this->db->select_avg('rating');
        $this->db->where('provider_id', $provider_id);
        $avg = $this->db->get('reviews')->row();
        $data['average_rating'] = round($avg->rating ?? 0, 1);
        // -------- Load Views ----------
        $this->load->view('provider/header');
        $this->load->view('provider/dashboard_view', $data);
        $this->load->view('provider/footer');
    }

    public function mark_notification_read($id)
    {
        $provider_id = $this->provider['id'] ?? $this->provider['user_id'];

        $this->db->where('id', $id);
        $this->db->where('provider_id', $provider_id);
        $this->db->update('provider_notifications', [
            'is_read' => 1
        ]);

        redirect('provider/dashboard');
    }

    public function delete_notification()
    {
        $this->output->set_content_type('application/json');

        if (!$this->provider) {
            return $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Not logged in'
            ]));
        }

        $id = (int)$this->input->post('id');

        if (!$id) {
            return $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Invalid ID'
            ]));
        }

        $provider_ids = $this->getProviderIdsForNotifications();

        if (empty($provider_ids)) {
            return $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Provider ID not found'
            ]));
        }

        $this->db->where('id', $id);
        $this->db->where_in('provider_id', $provider_ids);
        $this->db->delete('provider_notifications');
        $affected = (int)$this->db->affected_rows();

        if ($affected > 0) {
            return $this->output->set_output(json_encode([
                'status' => 'success'
            ]));
        }

        return $this->output->set_output(json_encode([
            'status' => 'error',
            'message' => 'Notification not found or already deleted'
        ]));
    }

    public function get_notifications()
    {
        $this->output->set_content_type('application/json');

        if (!$this->provider) {
            return $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Not logged in',
            ]));
        }

        $provider_ids = $this->getProviderIdsForNotifications();

        $this->db->select('id, title, message, created_at, is_read');
        $this->db->from('provider_notifications');
        $this->db->where_in('provider_id', $provider_ids);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $notifications = $this->db->get()->result_array();

        $this->db->from('provider_notifications');
        $this->db->where_in('provider_id', $provider_ids);
        $this->db->where('is_read', 0);
        $unread_count = (int) $this->db->count_all_results();

        return $this->output->set_output(json_encode([
            'status' => 'success',
            'notifications' => $notifications,
            'unread_count' => $unread_count,
        ]));
    }

    private function getProviderIdsForNotifications()
    {
        $ids = [];

        if (!empty($this->provider['id'])) {
            $ids[] = (int) $this->provider['id'];
        }
        if (!empty($this->provider['user_id'])) {
            $ids[] = (int) $this->provider['user_id'];
        }

        $ids = array_values(array_unique(array_filter($ids)));
        if (empty($ids)) {
            return [0];
        }

        // Expand mapping through provider table in both directions.
        $this->db->select('id, provider_id');
        $this->db->from('provider');
        $this->db->group_start();
        $this->db->where_in('id', $ids);
        $this->db->or_where_in('provider_id', $ids);
        $this->db->group_end();
        $rows = $this->db->get()->result();

        foreach ($rows as $row) {
            if (!empty($row->id)) {
                $ids[] = (int) $row->id;
            }
            if (!empty($row->provider_id)) {
                $ids[] = (int) $row->provider_id;
            }
        }

        $ids = array_values(array_unique(array_filter($ids)));
        return !empty($ids) ? $ids : [0];
    }
}
