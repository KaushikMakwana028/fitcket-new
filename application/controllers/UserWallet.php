<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');

class UserWallet extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    private function getUserWallet($userId)
    {
        return $this->db
            ->where('user_id', $userId)
            ->get('wallets')
            ->row_array();
    }

    private function getOrCreateWallet($userId)
    {
        $wallet = $this->getUserWallet($userId);

        if ($wallet) {
            return $wallet;
        }

        $this->db->insert('wallets', [
            'user_id' => $userId,
            'balance' => 0
        ]);

        return $this->getUserWallet($userId);
    }

    private function getWalletTransactions($walletId)
    {
        return $this->db
            ->where('wallet_id', $walletId)
            ->where_in('type', ['winning', 'withdraw', 'refund'])
            ->order_by('id', 'DESC')
            ->get('transactions')
            ->result_array();
    }

    private function getUserBankAccounts($userId)
    {
        if (!$this->db->table_exists('provider_bank_details')) {
            return [];
        }

        return $this->db
            ->where('provider_id', $userId)
            ->order_by('id', 'DESC')
            ->get('provider_bank_details')
            ->result_array();
    }

    private function getUserBankAccount($userId, $bankId)
    {
        if ((int) $bankId <= 0 || !$this->db->table_exists('provider_bank_details')) {
            return null;
        }

        return $this->db
            ->where('id', (int) $bankId)
            ->where('provider_id', (int) $userId)
            ->get('provider_bank_details')
            ->row_array();
    }

    private function transactionColumnExists($column)
    {
        return $this->db->field_exists($column, 'transactions');
    }

    private function getWinningSummary($walletId)
    {
        $transactions = $this->getWalletTransactions($walletId);
        $totalWinning = 0;
        $totalWithdraw = 0;

        foreach ($transactions as $transaction) {
            $type = strtolower((string) ($transaction['type'] ?? ''));
            $status = strtolower((string) ($transaction['status'] ?? ''));
            $amount = (float) ($transaction['amount'] ?? 0);

            if ($type === 'winning' && $status === 'success') {
                $totalWinning += $amount;
            }

            if ($type === 'withdraw' && $status !== 'failed') {
                $totalWithdraw += $amount;
            }
        }

        return [
            'transactions' => $transactions,
            'total_winning' => $totalWinning,
            'total_withdraw' => $totalWithdraw,
            'available_balance' => max(0, $totalWinning - $totalWithdraw)
        ];
    }

    public function getCurrentUser()
    {
        $user = $this->session->userdata('user');

        if (!$user) {
            redirect('login');
        }

        return $user;
    }

    public function index()
    {
        $user = $this->getCurrentUser();
        $wallet = $this->getOrCreateWallet($user['id']);
        $summary = $this->getWinningSummary($wallet['id']);

        $data['wallet'] = $wallet;
        $data['transactions'] = $summary['transactions'];
        $data['available_balance'] = $summary['available_balance'];
        $data['total_earned'] = $summary['total_winning'];
        $data['total_withdraw'] = $summary['total_withdraw'];
        $data['bank_accounts'] = $this->getUserBankAccounts($user['id']);

        $this->load->view('header');
        $this->load->view('wallet_view', $data);
        $this->load->view('footer');
    }

    public function withdraw()
    {
        $user = $this->getCurrentUser();
        $amount = (float) $this->input->post('amount');
        $bankId = (int) $this->input->post('bank_account_id');

        if ($amount <= 0) {
            $this->session->set_flashdata('error', 'Please enter a valid withdraw amount.');
            redirect('wallet');
            return;
        }

        $bankAccount = $this->getUserBankAccount($user['id'], $bankId);
        if (!$bankAccount) {
            $this->session->set_flashdata('error', 'Please select your bank account before withdraw.');
            redirect('wallet');
            return;
        }

        $wallet = $this->getOrCreateWallet($user['id']);
        $summary = $this->getWinningSummary($wallet['id']);

        if ($summary['available_balance'] < $amount) {
            $this->session->set_flashdata('error', 'You can withdraw only from winning amount.');
            redirect('wallet');
            return;
        }

        if ((float) $wallet['balance'] < $amount) {
            $this->session->set_flashdata('error', 'Insufficient wallet balance.');
            redirect('wallet');
            return;
        }

        $this->db->trans_start();

        $transactionData = [
            'wallet_id' => $wallet['id'],
            'type' => 'withdraw',
            'amount' => $amount,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->transactionColumnExists('bank_detail_id')) {
            $transactionData['bank_detail_id'] = (int) $bankAccount['id'];
        }

        if ($this->transactionColumnExists('account_holder_name')) {
            $transactionData['account_holder_name'] = (string) ($bankAccount['account_holder_name'] ?? '');
        }

        if ($this->transactionColumnExists('bank_name')) {
            $transactionData['bank_name'] = (string) ($bankAccount['bank_name'] ?? '');
        }

        if ($this->transactionColumnExists('account_number')) {
            $transactionData['account_number'] = (string) ($bankAccount['account_number'] ?? '');
        }

        if ($this->transactionColumnExists('ifsc_code')) {
            $transactionData['ifsc_code'] = (string) ($bankAccount['ifsc_code'] ?? '');
        }

        if ($this->transactionColumnExists('account_type')) {
            $transactionData['account_type'] = (string) ($bankAccount['account_type'] ?? '');
        }

        if ($this->transactionColumnExists('branch_name')) {
            $transactionData['branch_name'] = (string) ($bankAccount['branch_name'] ?? '');
        }

        $this->db->insert('transactions', $transactionData);

        $this->db->set('balance', 'balance - ' . $amount, false)
            ->where('id', $wallet['id'])
            ->update('wallets');

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to submit withdraw request right now.');
            redirect('wallet');
            return;
        }

        $this->session->set_flashdata('success', 'Withdraw request submitted. Admin can now transfer this winning amount to your selected bank account.');
        redirect('wallet');
    }

    public function add_money()
    {
        $user = $this->getCurrentUser();
        $amount = (float) $this->input->post('amount');
        if ($amount <= 0) {
            echo json_encode(['status' => false, 'msg' => 'Invalid amount']);
            return;
        }

        $wallet = $this->getOrCreateWallet($user['id']);

        $this->db->insert('transactions', [
            'wallet_id' => $wallet['id'],
            'type' => 'credit',
            'amount' => $amount,
            'status' => 'pending'
        ]);

        $txnId = $this->db->insert_id();

        /*
        $api = new Api($key_id, $key_secret);
        */

        $this->db->where('id', $txnId)->update('transactions', [
            'status' => 'success'
        ]);

        $this->db->set('balance', 'balance + ' . $amount, false)
            ->where('id', $wallet['id'])
            ->update('wallets');

        echo json_encode(['status' => true]);
    }
}
