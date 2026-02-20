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
        $this->db->where('provider_id', $provider_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5); // show latest 5
        $notifications = $this->db->get('provider_notifications')->result();

        $data['notifications'] = $notifications;

        // Unread count
        $this->db->where('provider_id', $provider_id);
        $this->db->where('is_read', 0);
        $data['unread_count'] = $this->db->count_all_results('provider_notifications');
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
        // Add debug logging
        log_message('debug', 'delete_notification called with POST: ' . json_encode($this->input->post()));

        if (!$this->provider) {
            echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
            return;
        }

        $id = (int)$this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        // Make sure you're using the correct provider ID field
        $provider_id = $this->provider['id'] ?? $this->provider['user_id'] ?? null;

        if (!$provider_id) {
            echo json_encode(['status' => 'error', 'message' => 'Provider ID not found']);
            return;
        }

        $this->db->where('id', $id);
        $this->db->where('provider_id', $provider_id);
        $deleted = $this->db->delete('provider_notifications');

        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'DB delete failed',
                'affected_rows' => $this->db->affected_rows()
            ]);
        }
    }
}
