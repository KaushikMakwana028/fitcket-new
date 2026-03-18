<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Cricket extends User_Controller
{
    private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";
    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";

    public function __construct()
    {
        parent::__construct();

        $this->load->model('general_model');
        $this->load->database();

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

    private function getPoolWithMeta($poolId)
    {
        return $this->db
            ->select("
                pools.*,
                COALESCE(users.name, 'Host') as host_name,
                (
                    SELECT COUNT(*)
                    FROM pool_joins
                    WHERE pool_joins.pool_id = pools.id
                    AND pool_joins.status = 'success'
                ) as total_joined
            ", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->where('pools.id', (int) $poolId)
            ->get()
            ->row_array();
    }

    private function syncPoolJoinedCount($poolId)
    {
        if (!$this->db->field_exists('total_joined', 'pools')) {
            return;
        }

        $joinedCount = (int) $this->db
            ->where('pool_id', (int) $poolId)
            ->where('status', 'success')
            ->count_all_results('pool_joins');

        $this->db->where('id', (int) $poolId)->update('pools', [
            'total_joined' => $joinedCount
        ]);
    }

    private function upsertPoolJoin($pool, $user, $data)
    {
        $existing = $this->db->get_where('pool_joins', [
            'pool_id' => (int) $pool['id'],
            'user_id' => (int) $user['id']
        ])->row_array();

        $timestamp = date('Y-m-d H:i:s');
        $payload = array_merge([
            'pool_id' => (int) $pool['id'],
            'user_id' => (int) $user['id'],
            'host_user_id' => (int) $pool['user_id'],
            'amount' => (float) $pool['price'],
            'updated_at' => $timestamp
        ], $data);

        if ($existing) {
            if (empty($existing['created_at'])) {
                $payload['created_at'] = $timestamp;
            }

            $this->db->where('id', (int) $existing['id'])->update('pool_joins', $payload);
            return (int) $existing['id'];
        }

        $payload['created_at'] = $timestamp;
        $this->db->insert('pool_joins', $payload);

        return (int) $this->db->insert_id();
    }

    private function savePoolPaymentLog($poolJoinId, $pool, $user, $amount, $status, $txnid, $paymentMethod = 'razorpay', $razorpayOrderId = null, $razorpayPaymentId = null)
    {
        $existing = $this->db->get_where('pool_join_payments', [
            'pool_join_id' => (int) $poolJoinId,
            'status' => 'success'
        ])->row_array();

        if ($existing) {
            return;
        }

        $this->db->insert('pool_join_payments', [
            'pool_join_id' => (int) $poolJoinId,
            'pool_id' => (int) $pool['id'],
            'user_id' => (int) $user['id'],
            'amount' => (float) $amount,
            'payment_method' => $paymentMethod,
            'txnid' => $txnid,
            'razorpay_order_id' => $razorpayOrderId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    private function deletePendingPoolJoinByTxnid($txnid)
    {
        if (empty($txnid)) {
            return;
        }

        $this->db
            ->where('txnid', $txnid)
            ->where_in('status', ['pending', 'failed'])
            ->delete('pool_joins');
    }

    public function index()
    {
        $user = $this->getCurrentUser();

        $request = $this->db->get_where('host_requests', ['user_id' => $user['id']])->row_array();

        $data['user'] = $user;
        $data['request'] = $request;

        $data['live'] = [
            'team1' => 'India',
            'team2' => 'Australia',
            'score' => '145/3 (15.2)',
            'status' => 'LIVE'
        ];

        $data['upcoming'] = [
            ['teams' => 'India vs Pakistan', 'date' => '20 Mar 2026'],
            ['teams' => 'England vs SA', 'date' => '22 Mar 2026']
        ];

        $data['tournaments'] = [
            ['name' => 'IPL 2026', 'date' => 'Starts 25 Mar'],
            ['name' => 'Asia Cup', 'date' => 'June 2026'],
            ['name' => 'World Cup', 'date' => 'Oct 2026']
        ];

        $data['players'] = [
            'Virat Kohli',
            'Babar Azam',
            'Joe Root',
            'Steve Smith'
        ];

        $data['request_status'] = $request ? $request['status'] : null;
        $data['is_host'] = $user['is_host'];

        $this->load->view('header', $data);
        $this->load->view('cricket_view', $data);
        $this->load->view('footer', $data);
    }

    public function becomeHost()
    {
        $sessionUser = $this->session->userdata('user');
        $userId = $sessionUser['id'];

        $instagram = $this->input->post('instagram');

        $exists = $this->db->get_where('host_requests', ['user_id' => $userId])->row();

        if ($exists) {
            echo json_encode([
                'status' => 'error',
                'message' => 'You already applied!'
            ]);
            return;
        }

        $user = $this->db->get_where('users', ['id' => $userId])->row_array();

        $data = [
            'user_id' => $userId,
            'name' => $user['name'],
            'email' => $user['email'],
            'mobile' => $user['mobile'],
            'instagram_url' => $instagram,
            'status' => 'pending'
        ];

        $this->db->insert('host_requests', $data);

        echo json_encode([
            'status' => 'success'
        ]);
    }

    public function pool_view()
    {
        $user = $this->getCurrentUser();

        $data['pools'] = $this->db
            ->select("
                pools.*,
                COALESCE(users.name, 'Host') as host_name,
                (
                    SELECT COUNT(*)
                    FROM pool_joins
                    WHERE pool_joins.pool_id = pools.id
                    AND pool_joins.status = 'success'
                ) as total_joined
            ", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->order_by('pools.id', 'DESC')
            ->get()
            ->result_array();

        $joinedRows = $this->db
            ->select('pool_id')
            ->from('pool_joins')
            ->where('user_id', (int) $user['id'])
            ->where('status', 'success')
            ->get()
            ->result_array();

        $data['joined_pool_ids'] = array_map('intval', array_column($joinedRows, 'pool_id'));
        $data['user'] = $user;

        $this->load->view('header', $data);
        $this->load->view('pool_view', $data);
        $this->load->view('footer');
    }

    public function pool_add()
    {
        $user = $this->getCurrentUser();

        if ((int) $user['is_host'] !== 1) {
            redirect('cricket');
        }

        $data['user'] = $user;

        $this->load->view('header', $data);
        $this->load->view('pool_add', $data);
        $this->load->view('footer');
    }

    public function pool_store()
    {
        $user = $this->getCurrentUser();

        if ((int) $user['is_host'] !== 1) {
            echo "Unauthorized";
            return;
        }

        $data = [
            'user_id' => $user['id'],
            'pool_name' => trim((string) $this->input->post('pool_name')),
            'user_limit' => (int) $this->input->post('user_limit'),
            'price' => (float) $this->input->post('price'),
        ];

        if ($this->db->field_exists('total_joined', 'pools')) {
            $data['total_joined'] = 0;
        }

        $this->db->insert('pools', $data);

        redirect('pool');
    }

    public function pool_join($poolId = 0)
    {
        $user = $this->getCurrentUser();
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('pool');
            return;
        }

        if ((int) $pool['user_id'] === (int) $user['id']) {
            $this->session->set_flashdata('error', 'You cannot join your own pool.');
            redirect('pool');
            return;
        }

        $existingJoin = $this->db->get_where('pool_joins', [
            'pool_id' => (int) $pool['id'],
            'user_id' => (int) $user['id'],
            'status' => 'success'
        ])->row_array();

        if ($existingJoin) {
            $this->session->set_flashdata('success', 'You have already joined this pool.');
            redirect('pool');
            return;
        }

        if ((int) $pool['total_joined'] >= (int) $pool['user_limit']) {
            $this->session->set_flashdata('error', 'This pool is already full.');
            redirect('pool');
            return;
        }

        $amount = (float) $pool['price'];

        if ($amount <= 0) {
            $txnid = 'POOLFREE' . uniqid();

            $this->db->trans_start();

            $poolJoinId = $this->upsertPoolJoin($pool, $user, [
                'txnid' => $txnid,
                'status' => 'success',
                'razorpay_order_id' => null,
                'razorpay_payment_id' => null,
                'razorpay_signature' => null
            ]);

            $this->savePoolPaymentLog($poolJoinId, $pool, $user, 0, 'success', $txnid, 'free');
            $this->syncPoolJoinedCount($pool['id']);

            $this->db->trans_complete();

            $this->session->set_flashdata('success', 'You joined the pool successfully.');
            redirect('pool');
            return;
        }

        $txnid = 'POOL' . uniqid();
        $amountPaise = (int) round($amount * 100);

        $poolJoinId = $this->upsertPoolJoin($pool, $user, [
            'txnid' => $txnid,
            'status' => 'pending',
            'razorpay_order_id' => null,
            'razorpay_payment_id' => null,
            'razorpay_signature' => null
        ]);

        $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);
        $razorpayOrder = $api->order->create([
            'receipt' => $txnid,
            'amount' => $amountPaise,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $this->db->where('id', $poolJoinId)->update('pool_joins', [
            'razorpay_order_id' => $razorpayOrder['id'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $data = [
            'key' => $this->RAZORPAY_KEY_ID,
            'amount' => $amountPaise,
            'name' => 'Pool Join Payment',
            'description' => $pool['pool_name'],
            'image' => base_url('assets/logo.png'),
            'order_id' => $razorpayOrder['id'],
            'txnid' => $txnid,
            'prefill' => [
                'name' => $user['name'] ?? 'User',
                'email' => $user['email'] ?? '',
                'contact' => $user['mobile'] ?? ''
            ],
            'notes' => [
                'pool_id' => (int) $pool['id'],
                'pool_join_id' => $poolJoinId,
                'user_id' => (int) $user['id']
            ],
            'theme' => [
                'color' => '#3399cc'
            ]
        ];

        $this->load->view('header');
        $this->load->view('razorpay_redirect_pool', $data);
        $this->load->view('footer');
    }

    public function pool_razorpay_callback()
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

            $poolJoin = $this->db->get_where('pool_joins', ['txnid' => $txnid])->row_array();

            if (!$poolJoin) {
                throw new Exception('Pool join record not found.');
            }

            if ($poolJoin['status'] === 'success') {
                $this->session->set_flashdata('success', 'Payment already verified and pool joined.');
                redirect('pool');
                return;
            }

            $pool = $this->getPoolWithMeta($poolJoin['pool_id']);
            $user = $this->db->get_where('users', ['id' => $poolJoin['user_id']])->row_array();

            if (!$pool || !$user) {
                throw new Exception('Pool or user not found.');
            }

            $this->db->trans_start();

            $this->db->where('id', (int) $poolJoin['id'])->update('pool_joins', [
                'status' => 'success',
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $this->savePoolPaymentLog(
                $poolJoin['id'],
                $pool,
                $user,
                $poolJoin['amount'],
                'success',
                $txnid,
                'razorpay',
                $orderId,
                $paymentId
            );

            $this->syncPoolJoinedCount($poolJoin['pool_id']);

            $this->db->trans_complete();

            $this->session->set_flashdata('success', 'Payment successful. You have joined the pool.');
            redirect('pool');
        } catch (Exception $e) {
            if (!empty($txnid)) {
                $this->deletePendingPoolJoinByTxnid($txnid);
            }

            $this->session->set_flashdata('error', 'Pool payment verification failed. Please try again.');
            redirect('pool');
        }
    }

    public function pool_payment_cancel($txnid = '')
    {
        $this->deletePendingPoolJoinByTxnid($txnid);
        $this->session->set_flashdata('error', 'Pool payment was cancelled.');
        redirect('pool');
    }
}
