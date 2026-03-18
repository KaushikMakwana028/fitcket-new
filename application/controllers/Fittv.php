<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Fittv extends User_Controller
{
    private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";
    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');

        $user = $this->session->userdata('user');
        if (!$user || !isset($user['is_logged_in']) || $user['is_logged_in'] !== true) {
            $current_url = current_url();
            redirect('login?redirect=' . urlencode($current_url));
        }
    }

    private function getCurrentUser()
    {
        $sessionUser = $this->session->userdata('user');

        return $this->db->get_where('users', ['id' => $sessionUser['id']])->row_array();
    }

    private function getCourseSettings()
    {
        $settings = $this->db->get_where('fittv_course_settings', ['id' => 1])->row_array();

        if (!$settings) {
            $settings = [
                'id' => 1,
                'title' => 'FITTV Premium Access',
                'description' => 'Unlock full FITTV access to explore all workout categories and videos.',
                'price' => 0,
                'is_active' => 1
            ];
        }

        return $settings;
    }

    private function userHasAccess($userId)
    {
        return $this->db
            ->where('user_id', (int) $userId)
            ->where('status', 'success')
            ->count_all_results('fittv_payments') > 0;
    }

    private function requireFittvAccess()
    {
        $user = $this->getCurrentUser();

        if (!$this->userHasAccess($user['id'])) {
            $this->session->set_flashdata('error', 'Please complete FITTV payment first.');
            redirect('fittv');
            exit;
        }

        return $user;
    }

    private function completeFreeAccess($user, $settings)
    {
        $existing = $this->db->get_where('fittv_payments', [
            'user_id' => (int) $user['id'],
            'status' => 'success'
        ])->row_array();

        if (!$existing) {
            $this->db->insert('fittv_payments', [
                'user_id' => (int) $user['id'],
                'amount' => 0,
                'course_price' => 0,
                'payment_method' => 'free',
                'txnid' => 'FITTVFREE' . uniqid(),
                'status' => 'success',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $this->session->set_flashdata('success', 'FITTV access activated successfully.');
        redirect('fittv/access');
    }

    public function index()
    {
        $user = $this->getCurrentUser();
        $settings = $this->getCourseSettings();

        $data['user'] = $user;
        $data['settings'] = $settings;
        $data['has_access'] = $this->userHasAccess($user['id']);

        $this->load->view('header', $data);
        $this->load->view('fittv_landing_view', $data);
        $this->load->view('footer');
    }

    public function access()
    {
        $this->requireFittvAccess();

        $this->load->view('header');
        $this->load->view('fittv_gender_select_view');
        $this->load->view('footer');
    }

    public function pay()
    {
        $user = $this->getCurrentUser();
        $settings = $this->getCourseSettings();

        if (!$settings['is_active']) {
            $this->session->set_flashdata('error', 'FITTV course is currently unavailable.');
            redirect('fittv');
            return;
        }

        if ($this->userHasAccess($user['id'])) {
            redirect('fittv/access');
            return;
        }

        $amount = (float) $settings['price'];

        if ($amount <= 0) {
            $this->completeFreeAccess($user, $settings);
            return;
        }

        $txnid = 'FITTV' . uniqid();
        $amountPaise = (int) round($amount * 100);

        $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);
        $razorpayOrder = $api->order->create([
            'receipt' => $txnid,
            'amount' => $amountPaise,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $this->session->set_userdata('pending_fittv_payment', [
            'txnid' => $txnid,
            'user_id' => (int) $user['id'],
            'amount' => $amount,
            'order_id' => $razorpayOrder['id'],
            'course_price' => $amount,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $data = [
            'key' => $this->RAZORPAY_KEY_ID,
            'amount' => $amountPaise,
            'name' => 'FITTV Access',
            'description' => $settings['title'],
            'image' => base_url('assets/logo.png'),
            'order_id' => $razorpayOrder['id'],
            'txnid' => $txnid,
            'prefill' => [
                'name' => $user['name'] ?? 'User',
                'email' => $user['email'] ?? '',
                'contact' => $user['mobile'] ?? ''
            ],
            'notes' => [
                'user_id' => (int) $user['id'],
                'txnid' => $txnid,
                'type' => 'fittv_access'
            ],
            'theme' => [
                'color' => '#e24a6b'
            ]
        ];

        $this->load->view('header');
        $this->load->view('razorpay_redirect_fittv', $data);
        $this->load->view('footer');
    }

    public function razorpay_callback()
    {
        $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);

        $paymentId = $this->input->post('razorpay_payment_id');
        $orderId = $this->input->post('razorpay_order_id');
        $signature = $this->input->post('razorpay_signature');
        $txnid = $this->input->post('txnid');

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ]);

            $pending = $this->session->userdata('pending_fittv_payment');

            if (
                !$pending ||
                empty($pending['txnid']) ||
                $pending['txnid'] !== $txnid ||
                $pending['order_id'] !== $orderId
            ) {
                throw new Exception('Pending FITTV payment not found.');
            }

            $alreadyPaid = $this->db->get_where('fittv_payments', [
                'user_id' => (int) $pending['user_id'],
                'status' => 'success'
            ])->row_array();

            if (!$alreadyPaid) {
                $this->db->insert('fittv_payments', [
                    'user_id' => (int) $pending['user_id'],
                    'amount' => (float) $pending['amount'],
                    'course_price' => (float) $pending['course_price'],
                    'payment_method' => 'razorpay',
                    'txnid' => $txnid,
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                    'status' => 'success',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->session->unset_userdata('pending_fittv_payment');
            $this->session->set_flashdata('success', 'FITTV payment successful. Access granted.');
            redirect('fittv/access');
        } catch (Exception $e) {
            $this->session->unset_userdata('pending_fittv_payment');
            $this->session->set_flashdata('error', 'FITTV payment verification failed. Please try again.');
            redirect('fittv');
        }
    }

    public function payment_cancel()
    {
        $this->session->unset_userdata('pending_fittv_payment');
        $this->session->set_flashdata('error', 'FITTV payment was cancelled.');
        redirect('fittv');
    }

    public function gender($gender)
    {
        $this->requireFittvAccess();

        $categories = $this->general_model->getAll(
            'fittv_categories',
            ['gender' => $gender, 'isActive' => 1]
        );

        $data['gender'] = $gender;
        $data['categories'] = $categories;

        $this->load->view('header');
        $this->load->view('fittv_view', $data);
        $this->load->view('footer');
    }

    public function videos($category_id)
    {
        $this->requireFittvAccess();

        $category = $this->general_model->getOne(
            'fittv_categories',
            ['id' => $category_id]
        );

        if (!$category) {
            redirect('fittv/access');
        }

        $data['videos'] = $this->general_model->getAll(
            'fittv_videos',
            ['category_id' => $category_id]
        );
        $data['category'] = $category;
        $data['gender'] = $category->gender;

        $this->load->view('header');
        $this->load->view('fittv_user_videos_view', $data);
        $this->load->view('footer');
    }
}
