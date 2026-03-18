<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Fittv extends User_Controller
{
    private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";
    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";
    private $fittvPaymentColumns = null;

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

    private function getFittvPaymentColumns()
    {
        if ($this->fittvPaymentColumns === null) {
            $this->fittvPaymentColumns = $this->db->list_fields('fittv_payments');
        }

        return $this->fittvPaymentColumns;
    }

    private function sanitizeFittvPaymentPayload(array $payload)
    {
        $columns = $this->getFittvPaymentColumns();

        if (empty($columns)) {
            return $payload;
        }

        return array_intersect_key($payload, array_flip($columns));
    }

    private function insertFittvPayment(array $payload)
    {
        $payload = $this->sanitizeFittvPaymentPayload($payload);
        $result = $this->db->insert('fittv_payments', $payload);

        if (!$result) {
            $error = $this->db->error();
            log_message('error', 'FITTV payment insert failed: ' . json_encode($error));
        }

        return $result;
    }

    private function updateFittvPaymentBy(array $where, array $payload)
    {
        $payload = $this->sanitizeFittvPaymentPayload($payload);

        foreach ($where as $key => $value) {
            $this->db->where($key, $value);
        }

        $result = $this->db->update('fittv_payments', $payload);

        if (!$result) {
            $error = $this->db->error();
            log_message('error', 'FITTV payment update failed: ' . json_encode($error));
        }

        return $result;
    }

    private function ensureFittvSuccessPayment(array $paymentData)
    {
        $existing = $this->db->get_where('fittv_payments', [
            'user_id' => (int) $paymentData['user_id'],
            'status' => 'success'
        ])->row_array();

        if ($existing) {
            return true;
        }

        $updatePayload = [
            'amount' => (float) $paymentData['amount'],
            'course_price' => (float) $paymentData['course_price'],
            'payment_method' => 'razorpay',
            'razorpay_order_id' => $paymentData['razorpay_order_id'],
            'razorpay_payment_id' => $paymentData['razorpay_payment_id'],
            'razorpay_signature' => $paymentData['razorpay_signature'],
            'status' => 'success',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $updated = $this->updateFittvPaymentBy(['txnid' => $paymentData['txnid']], $updatePayload);

        if ($updated && $this->db->affected_rows() > 0) {
            return true;
        }

        $insertPayload = array_merge($updatePayload, [
            'user_id' => (int) $paymentData['user_id'],
            'txnid' => $paymentData['txnid'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->insertFittvPayment($insertPayload);
    }

    private function upsertPendingFittvPayment($user, $settings, $txnid, $amount, $orderId = null)
    {
        $payload = [
            'user_id' => (int) $user['id'],
            'amount' => (float) $amount,
            'course_price' => (float) $amount,
            'payment_method' => 'razorpay',
            'txnid' => $txnid,
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => null,
            'razorpay_signature' => null,
            'status' => 'pending',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $existing = $this->db->get_where('fittv_payments', [
            'user_id' => (int) $user['id'],
            'status' => 'pending'
        ])->row_array();

        if ($existing) {
            $where = !empty($existing['txnid'])
                ? ['txnid' => $existing['txnid']]
                : [
                    'user_id' => (int) $user['id'],
                    'status' => 'pending'
                ];

            $this->updateFittvPaymentBy($where, $payload);
            return !empty($existing['id']) ? (int) $existing['id'] : 0;
        }

        $payload['created_at'] = date('Y-m-d H:i:s');
        $this->insertFittvPayment($payload);
        return (int) $this->db->insert_id();
    }

    private function deletePendingFittvPaymentByTxnid($txnid = '')
    {
        if (empty($txnid)) {
            return;
        }

        $this->db
            ->where('txnid', $txnid)
            ->where('status', 'pending')
            ->delete('fittv_payments');
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
            $this->insertFittvPayment([
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
        $this->upsertPendingFittvPayment($user, $settings, $txnid, $amount);

        try {
            $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);
            $razorpayOrder = $api->order->create([
                'receipt' => $txnid,
                'amount' => $amountPaise,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);
        } catch (Exception $e) {
            log_message('error', 'FITTV payment initialization failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'Unable to start FITTV payment right now. Please try again in a moment.');
            redirect('fittv');
            return;
        }

        $this->updateFittvPaymentBy([
            'txnid' => $txnid,
            'status' => 'pending'
        ], [
            'razorpay_order_id' => $razorpayOrder['id'],
            'updated_at' => date('Y-m-d H:i:s')
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

            $pending = $this->db->get_where('fittv_payments', ['txnid' => $txnid])->row_array();

            if (!$pending) {
                $user = $this->getCurrentUser();
                $settings = $this->getCourseSettings();

                if (!$user) {
                    throw new Exception('Pending FITTV payment not found and user session missing.');
                }

                $pending = [
                    'user_id' => (int) $user['id'],
                    'amount' => (float) ($settings['price'] ?? 0),
                    'course_price' => (float) ($settings['price'] ?? 0),
                    'txnid' => $txnid,
                    'status' => 'pending'
                ];
            }

            if (
                !empty($pending['razorpay_order_id']) &&
                $pending['razorpay_order_id'] !== $orderId
            ) {
                throw new Exception('FITTV payment order mismatch.');
            }

            if ($pending['status'] === 'success') {
                $this->session->set_flashdata('success', 'FITTV payment already verified. Access granted.');
                redirect('fittv/access');
                return;
            }

            $saved = $this->ensureFittvSuccessPayment([
                'user_id' => (int) $pending['user_id'],
                'amount' => (float) $pending['amount'],
                'course_price' => (float) $pending['course_price'],
                'txnid' => $txnid,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ]);

            if (!$saved) {
                throw new Exception('Unable to save FITTV payment success record.');
            }

            $this->session->set_flashdata('success', 'FITTV payment successful. Access granted.');
            redirect('fittv/access');
        } catch (Exception $e) {
            log_message('error', 'FITTV payment verification failed: ' . $e->getMessage());
            if (!empty($txnid)) {
                $this->deletePendingFittvPaymentByTxnid($txnid);
            }
            $this->session->set_flashdata('error', 'FITTV payment verification failed. Please try again.');
            redirect('fittv');
        }
    }

    public function payment_cancel($txnid = '')
    {
        $this->deletePendingFittvPaymentByTxnid($txnid);
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
