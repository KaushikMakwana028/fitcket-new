<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class User_wallet extends Admin_Controller
{
    private $razorpayXKeyId = 'rzp_live_RCge2Oz6kUJE74';
    private $razorpayXKeySecret = 'Pw0gRqzQkzjl5pYW10pXXZeq';
    private $razorpayXSourceAccountNumber = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');

        $envKeyId = getenv('RAZORPAYX_KEY_ID');
        $envKeySecret = getenv('RAZORPAYX_KEY_SECRET');
        $envSourceAccount = getenv('RAZORPAYX_SOURCE_ACCOUNT');

        if (!empty($envKeyId)) {
            $this->razorpayXKeyId = $envKeyId;
        }

        if (!empty($envKeySecret)) {
            $this->razorpayXKeySecret = $envKeySecret;
        }

        if (!empty($envSourceAccount)) {
            $this->razorpayXSourceAccountNumber = $envSourceAccount;
        }
    }

    private function transactionColumnExists($column)
    {
        return $this->db->field_exists($column, 'transactions');
    }

    private function getOrCreateWallet($userId)
    {
        $wallet = $this->db->where('user_id', (int) $userId)->get('wallets')->row_array();

        if ($wallet) {
            return $wallet;
        }

        $this->db->insert('wallets', [
            'user_id' => (int) $userId,
            'balance' => 0,
        ]);

        return $this->db->where('user_id', (int) $userId)->get('wallets')->row_array();
    }

    private function getMatches()
    {
        if (!$this->db->table_exists('cricket_matches')) {
            return [];
        }

        return $this->db
            ->select('id, team_home, team_away, match_result, start_at, admin_status')
            ->from('cricket_matches')
            ->order_by('start_at', 'DESC')
            ->get()
            ->result_array();
    }

    private function poolQuestionsUseMatchId()
    {
        return $this->db->table_exists('pool_questions')
            && $this->db->field_exists('match_id', 'pool_questions');
    }

    private function getQuestionCorrectAnswerColumn()
    {
        if (!$this->db->table_exists('pool_questions')) {
            return "'' as correct_answer";
        }

        if ($this->db->field_exists('correct_answer', 'pool_questions')) {
            return 'pool_questions.correct_answer';
        }

        return "'' as correct_answer";
    }

    private function getPoolQuestionContext($poolId)
    {
        $pool = $this->db
            ->select('id, match_id')
            ->from('pools')
            ->where('id', (int) $poolId)
            ->get()
            ->row_array();

        return [
            'pool_id' => (int) ($pool['id'] ?? $poolId),
            'match_id' => (int) ($pool['match_id'] ?? 0),
        ];
    }

    private function getPoolQuestionsForSettlement($poolId)
    {
        if (!$this->db->table_exists('pool_questions')) {
            return [];
        }

        $context = $this->getPoolQuestionContext($poolId);

        $builder = $this->db
            ->select("
                pool_questions.id,
                pool_questions.pool_id,
                " . ($this->poolQuestionsUseMatchId() ? 'pool_questions.match_id,' : '') . "
                pool_questions.question,
                pool_questions.position,
                {$this->getQuestionCorrectAnswerColumn()}
            ", false)
            ->from('pool_questions');

        if ($this->poolQuestionsUseMatchId() && (int) $context['match_id'] > 0) {
            $builder->where('pool_questions.match_id', (int) $context['match_id']);
        } else {
            $builder->where('pool_questions.pool_id', (int) $context['pool_id']);
        }

        return $builder
            ->order_by('pool_questions.position', 'ASC')
            ->order_by('pool_questions.id', 'ASC')
            ->get()
            ->result_array();
    }

    private function calculateSummaryForSettlement(array $questions, array $answersByQuestion)
    {
        $summary = [
            'total' => count($questions),
            'answered' => 0,
            'checked' => 0,
            'right' => 0,
            'wrong' => 0,
        ];

        foreach ($questions as $question) {
            $questionId = (int) $question['id'];
            $adminAnswer = strtolower(trim((string) ($question['correct_answer'] ?? '')));
            $userAnswer = strtolower(trim((string) ($answersByQuestion[$questionId]['answer'] ?? '')));

            if ($userAnswer !== '') {
                $summary['answered']++;
            }

            if ($adminAnswer !== '' && $userAnswer !== '') {
                $summary['checked']++;

                if ($adminAnswer === $userAnswer) {
                    $summary['right']++;
                } else {
                    $summary['wrong']++;
                }
            }
        }

        return $summary;
    }

    private function getPoolAnswerRowsForSettlement($poolId, array $questions)
    {
        if (!$this->db->table_exists('pool_question_answers')) {
            return [];
        }

        $answerRows = $this->db
            ->select('pool_question_answers.*, users.name as user_name, users.email as user_email, users.mobile as user_mobile')
            ->from('pool_question_answers')
            ->join('users', 'users.id = pool_question_answers.user_id', 'left')
            ->where('pool_question_answers.pool_id', (int) $poolId)
            ->order_by('pool_question_answers.user_id', 'ASC')
            ->order_by('pool_question_answers.pool_question_id', 'ASC')
            ->get()
            ->result_array();

        if (empty($answerRows)) {
            return [];
        }

        $answersByUser = [];

        foreach ($answerRows as $answerRow) {
            $userId = (int) $answerRow['user_id'];
            $questionId = (int) $answerRow['pool_question_id'];

            if (!isset($answersByUser[$userId])) {
                $answersByUser[$userId] = [
                    'user_id' => $userId,
                    'user_name' => $answerRow['user_name'] ?: 'User',
                    'user_email' => $answerRow['user_email'] ?? '',
                    'user_mobile' => $answerRow['user_mobile'] ?? '',
                    'answers' => [],
                ];
            }

            $answersByUser[$userId]['answers'][$questionId] = $answerRow;
        }

        $rows = [];

        foreach ($answersByUser as $userRow) {
            $summary = $this->calculateSummaryForSettlement($questions, $userRow['answers']);
            $rows[] = array_merge($userRow, ['summary' => $summary]);
        }

        usort($rows, function ($left, $right) {
            if (($left['summary']['right'] ?? 0) === ($right['summary']['right'] ?? 0)) {
                if (($left['summary']['wrong'] ?? 0) === ($right['summary']['wrong'] ?? 0)) {
                    return strcmp((string) $left['user_name'], (string) $right['user_name']);
                }

                return ($left['summary']['wrong'] ?? 0) <=> ($right['summary']['wrong'] ?? 0);
            }

            return ($right['summary']['right'] ?? 0) <=> ($left['summary']['right'] ?? 0);
        });

        return $rows;
    }

    private function getMatchParticipants($matchId)
    {
        if ((int) $matchId <= 0 || !$this->db->table_exists('pools')) {
            return [];
        }

        $poolRows = $this->db
            ->select('id')
            ->from('pools')
            ->where('match_id', (int) $matchId)
            ->get()
            ->result_array();

        if (empty($poolRows)) {
            return [];
        }

        $winnerMap = [];

        foreach ($poolRows as $poolRow) {
            $poolId = (int) ($poolRow['id'] ?? 0);
            if ($poolId <= 0) {
                continue;
            }

            $questions = $this->getPoolQuestionsForSettlement($poolId);
            $poolUsers = $this->getPoolAnswerRowsForSettlement($poolId, $questions);

            if (empty($poolUsers)) {
                continue;
            }

            $hasChecked = false;
            foreach ($poolUsers as $userRow) {
                if ((int) ($userRow['summary']['checked'] ?? 0) > 0) {
                    $hasChecked = true;
                    break;
                }
            }

            if (!$hasChecked) {
                continue;
            }

            $topScore = (int) ($poolUsers[0]['summary']['right'] ?? 0);

            foreach ($poolUsers as $userRow) {
                if ((int) ($userRow['summary']['right'] ?? 0) !== $topScore) {
                    continue;
                }

                $userId = (int) ($userRow['user_id'] ?? 0);
                if ($userId <= 0) {
                    continue;
                }

                if (!isset($winnerMap[$userId])) {
                    $winnerMap[$userId] = [
                        'id' => $userId,
                        'name' => $userRow['user_name'] ?? 'User',
                        'email' => $userRow['user_email'] ?? '',
                        'mobile' => $userRow['user_mobile'] ?? '',
                        'winning_pools' => 0,
                        'top_score' => (int) ($userRow['summary']['right'] ?? 0),
                    ];
                }

                $winnerMap[$userId]['winning_pools']++;
                $winnerMap[$userId]['top_score'] = max(
                    $winnerMap[$userId]['top_score'],
                    (int) ($userRow['summary']['right'] ?? 0)
                );
            }
        }

        $winners = array_values($winnerMap);

        usort($winners, function ($left, $right) {
            if ((int) $left['winning_pools'] === (int) $right['winning_pools']) {
                if ((int) $left['top_score'] === (int) $right['top_score']) {
                    return strcmp((string) ($left['name'] ?? ''), (string) ($right['name'] ?? ''));
                }

                return (int) $right['top_score'] <=> (int) $left['top_score'];
            }

            return (int) $right['winning_pools'] <=> (int) $left['winning_pools'];
        });

        return $winners;
    }

    private function getLatestBankAccountsByUser(array $userIds)
    {
        if (empty($userIds) || !$this->db->table_exists('provider_bank_details')) {
            return [];
        }

        $rows = $this->db
            ->where_in('provider_id', $userIds)
            ->order_by('id', 'DESC')
            ->get('provider_bank_details')
            ->result_array();

        $map = [];
        foreach ($rows as $row) {
            $providerId = (int) ($row['provider_id'] ?? 0);
            if ($providerId > 0 && !isset($map[$providerId])) {
                $map[$providerId] = $row;
            }
        }

        return $map;
    }

    private function getLatestBankAccountByUserId($userId)
    {
        if ((int) $userId <= 0 || !$this->db->table_exists('provider_bank_details')) {
            return null;
        }

        return $this->db
            ->where('provider_id', (int) $userId)
            ->order_by('id', 'DESC')
            ->get('provider_bank_details')
            ->row_array();
    }

    private function razorpayXRequest($method, $endpoint, array $payload, array $headers = [])
    {
        $url = 'https://api.razorpay.com/v1/' . ltrim($endpoint, '/');

        $curl = curl_init($url);
        $defaultHeaders = [
            'Content-Type: application/json',
        ];

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_USERPWD => $this->razorpayXKeyId . ':' . $this->razorpayXKeySecret,
            CURLOPT_HTTPHEADER => array_merge($defaultHeaders, $headers),
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30,
        ]);

        $responseBody = curl_exec($curl);
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($responseBody === false || $curlError !== '') {
            throw new RuntimeException('Razorpay request failed: ' . $curlError);
        }

        $decoded = json_decode($responseBody, true);
        if ($httpCode < 200 || $httpCode >= 300) {
            $message = $decoded['error']['description'] ?? $decoded['error']['reason'] ?? $decoded['message'] ?? 'Unknown Razorpay error';
            throw new RuntimeException($message);
        }

        return is_array($decoded) ? $decoded : [];
    }

    private function createRazorpayContact(array $user, array $bankAccount)
    {
        $payload = [
            'name' => trim((string) ($bankAccount['account_holder_name'] ?? ($user['name'] ?? 'Winning User'))),
            'email' => trim((string) ($user['email'] ?? '')),
            'contact' => trim((string) ($user['mobile'] ?? '')),
            'type' => 'employee',
            'reference_id' => 'user_' . (int) ($user['id'] ?? 0),
            'notes' => [
                'user_id' => (string) (int) ($user['id'] ?? 0),
                'source' => 'fitcket_user_wallet',
            ],
        ];

        return $this->razorpayXRequest('POST', 'contacts', $payload);
    }

    private function createRazorpayFundAccount($contactId, array $bankAccount)
    {
        $payload = [
            'contact_id' => $contactId,
            'account_type' => 'bank_account',
            'bank_account' => [
                'name' => trim((string) ($bankAccount['account_holder_name'] ?? '')),
                'ifsc' => trim((string) ($bankAccount['ifsc_code'] ?? '')),
                'account_number' => trim((string) ($bankAccount['account_number'] ?? '')),
            ],
        ];

        return $this->razorpayXRequest('POST', 'fund_accounts', $payload);
    }

    private function createRazorpayPayout(array $transaction, array $user, array $bankAccount)
    {
        if ($this->razorpayXSourceAccountNumber === '') {
            throw new RuntimeException('RazorpayX source account number is missing. Set RAZORPAYX_SOURCE_ACCOUNT first.');
        }

        $contact = $this->createRazorpayContact($user, $bankAccount);
        $fundAccount = $this->createRazorpayFundAccount($contact['id'] ?? '', $bankAccount);
        $amountPaise = (int) round(((float) ($transaction['amount'] ?? 0)) * 100);

        if ($amountPaise < 100) {
            throw new RuntimeException('Withdraw amount must be at least Rs 1 for Razorpay payout.');
        }

        $idempotencyKey = 'fitcket-wd-' . (int) $transaction['id'] . '-' . substr(md5((string) microtime(true)), 0, 12);
        $referenceId = 'WD' . (int) $transaction['id'];

        $payload = [
            'account_number' => $this->razorpayXSourceAccountNumber,
            'fund_account_id' => $fundAccount['id'] ?? '',
            'amount' => $amountPaise,
            'currency' => 'INR',
            'mode' => 'IMPS',
            'purpose' => 'payout',
            'queue_if_low_balance' => true,
            'reference_id' => $referenceId,
            'narration' => 'Fitcket Winning',
            'notes' => [
                'transaction_id' => (string) (int) $transaction['id'],
                'user_id' => (string) (int) ($user['id'] ?? 0),
            ],
        ];

        return $this->razorpayXRequest('POST', 'payouts', $payload, [
            'X-Payout-Idempotency: ' . $idempotencyKey,
        ]);
    }

    private function getPendingWithdraws()
    {
        $selectFields = [
            'transactions.id',
            'transactions.wallet_id',
            'transactions.amount',
            'transactions.status',
            'transactions.created_at',
            'users.id as user_id',
            'users.name as user_name',
            'users.mobile as user_mobile',
            'users.email as user_email',
        ];

        foreach (['bank_name', 'account_number', 'ifsc_code', 'account_holder_name'] as $column) {
            if ($this->transactionColumnExists($column)) {
                $selectFields[] = 'transactions.' . $column;
            } else {
                $selectFields[] = "'' as {$column}";
            }
        }

        $rows = $this->db
            ->select(implode(",\n                ", $selectFields), false)
            ->from('transactions')
            ->join('wallets', 'wallets.id = transactions.wallet_id', 'inner')
            ->join('users', 'users.id = wallets.user_id', 'inner')
            ->where('transactions.type', 'withdraw')
            ->where('transactions.status', 'pending')
            ->order_by('transactions.id', 'DESC')
            ->get()
            ->result_array();

        $userIds = array_values(array_unique(array_map(function ($row) {
            return (int) ($row['user_id'] ?? 0);
        }, $rows)));

        $bankMap = $this->getLatestBankAccountsByUser($userIds);

        foreach ($rows as &$row) {
            $bank = $bankMap[(int) $row['user_id']] ?? [];
            $row['bank_name'] = $row['bank_name'] ?: ($bank['bank_name'] ?? '');
            $row['account_number'] = $row['account_number'] ?: ($bank['account_number'] ?? '');
            $row['ifsc_code'] = $row['ifsc_code'] ?: ($bank['ifsc_code'] ?? '');
            $row['account_holder_name'] = $row['account_holder_name'] ?: ($bank['account_holder_name'] ?? '');
        }
        unset($row);

        return $rows;
    }

    private function getRecentWinningCredits()
    {
        return $this->db
            ->select("
                transactions.id,
                transactions.amount,
                transactions.status,
                transactions.created_at,
                users.name as user_name
            ", false)
            ->from('transactions')
            ->join('wallets', 'wallets.id = transactions.wallet_id', 'inner')
            ->join('users', 'users.id = wallets.user_id', 'inner')
            ->where('transactions.type', 'winning')
            ->order_by('transactions.id', 'DESC')
            ->limit(10)
            ->get()
            ->result_array();
    }

    private function getAllWithdraws()
    {
        $selectFields = [
            'transactions.id',
            'transactions.wallet_id',
            'transactions.amount',
            'transactions.status',
            'transactions.created_at',
            'users.id as user_id',
            'users.name as user_name',
            'users.mobile as user_mobile',
            'users.email as user_email',
        ];

        foreach (['bank_name', 'account_number', 'ifsc_code', 'account_holder_name', 'remark', 'description'] as $column) {
            if ($this->transactionColumnExists($column)) {
                $selectFields[] = 'transactions.' . $column;
            } else {
                $selectFields[] = "'' as {$column}";
            }
        }

        $rows = $this->db
            ->select(implode(",\n                ", $selectFields), false)
            ->from('transactions')
            ->join('wallets', 'wallets.id = transactions.wallet_id', 'inner')
            ->join('users', 'users.id = wallets.user_id', 'inner')
            ->where('transactions.type', 'withdraw')
            ->order_by('transactions.id', 'DESC')
            ->get()
            ->result_array();

        $userIds = array_values(array_unique(array_map(function ($row) {
            return (int) ($row['user_id'] ?? 0);
        }, $rows)));

        $bankMap = $this->getLatestBankAccountsByUser($userIds);

        foreach ($rows as &$row) {
            $bank = $bankMap[(int) ($row['user_id'] ?? 0)] ?? [];
            $row['bank_name'] = $row['bank_name'] ?: ($bank['bank_name'] ?? '');
            $row['account_number'] = $row['account_number'] ?: ($bank['account_number'] ?? '');
            $row['ifsc_code'] = $row['ifsc_code'] ?: ($bank['ifsc_code'] ?? '');
            $row['account_holder_name'] = $row['account_holder_name'] ?: ($bank['account_holder_name'] ?? '');
        }
        unset($row);

        return $rows;
    }

    public function index()
    {
        $matches = $this->getMatches();
        $matchId = (int) $this->input->get('match_id');

        if ($matchId <= 0 && !empty($matches)) {
            $matchId = (int) $matches[0]['id'];
        }

        $data['matches'] = $matches;
        $data['selected_match_id'] = $matchId;
        $data['participants'] = $this->getMatchParticipants($matchId);
        $data['pending_withdraws'] = $this->getPendingWithdraws();
        $data['all_withdraws'] = $this->getAllWithdraws();
        $data['recent_credits'] = $this->getRecentWinningCredits();

        $this->load->view('admin/header');
        $this->load->view('admin/user_wallet_view', $data);
        $this->load->view('admin/footer');
    }

    public function credit_winning()
    {
        $matchId = (int) $this->input->post('match_id');
        $userId = (int) $this->input->post('user_id');
        $amount = (float) $this->input->post('amount');
        $note = trim((string) $this->input->post('note'));

        if ($userId <= 0 || $amount <= 0) {
            $this->session->set_flashdata('error', 'Please choose a winner and enter a valid amount.');
            redirect('admin/user_wallet?match_id=' . $matchId);
            return;
        }

        $user = $this->db->where('id', $userId)->get('users')->row_array();
        if (!$user) {
            $this->session->set_flashdata('error', 'Selected user not found.');
            redirect('admin/user_wallet?match_id=' . $matchId);
            return;
        }

        $wallet = $this->getOrCreateWallet($userId);
        if (!$wallet) {
            $this->session->set_flashdata('error', 'Unable to create wallet for this user.');
            redirect('admin/user_wallet?match_id=' . $matchId);
            return;
        }

        $transactionData = [
            'wallet_id' => (int) $wallet['id'],
            'type' => 'winning',
            'amount' => $amount,
            'status' => 'success',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->transactionColumnExists('match_id')) {
            $transactionData['match_id'] = $matchId;
        }

        if ($this->transactionColumnExists('remark')) {
            $transactionData['remark'] = $note !== '' ? $note : 'Admin winning credit';
        }

        if ($this->transactionColumnExists('description')) {
            $transactionData['description'] = $note !== '' ? $note : 'Admin winning credit';
        }

        $this->db->trans_start();

        $this->db->insert('transactions', $transactionData);
        $this->db->set('balance', 'balance + ' . $amount, false)
            ->where('id', (int) $wallet['id'])
            ->update('wallets');

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to credit winning amount right now.');
            redirect('admin/user_wallet?match_id=' . $matchId);
            return;
        }

        $this->session->set_flashdata('success', 'Winning amount credited successfully. User can now see it in wallet and withdraw it.');
        redirect('admin/user_wallet?match_id=' . $matchId);
    }

    public function approve_withdraw($transactionId = 0)
    {
        $transaction = $this->db
            ->where('id', (int) $transactionId)
            ->where('type', 'withdraw')
            ->where('status', 'pending')
            ->get('transactions')
            ->row_array();

        if (!$transaction) {
            $this->session->set_flashdata('error', 'Withdraw request not found or already processed.');
            redirect('admin/user_wallet');
            return;
        }

        $wallet = $this->db
            ->where('id', (int) $transaction['wallet_id'])
            ->get('wallets')
            ->row_array();

        $user = $wallet
            ? $this->db->where('id', (int) $wallet['user_id'])->get('users')->row_array()
            : null;

        $bankAccount = $user ? $this->getLatestBankAccountByUserId((int) $user['id']) : null;
        if (!empty($transaction['bank_name']) && !empty($transaction['account_number']) && !empty($transaction['ifsc_code'])) {
            $bankAccount = array_merge((array) $bankAccount, [
                'account_holder_name' => $transaction['account_holder_name'] ?? ($bankAccount['account_holder_name'] ?? ''),
                'bank_name' => $transaction['bank_name'],
                'account_number' => $transaction['account_number'],
                'ifsc_code' => $transaction['ifsc_code'],
            ]);
        }

        if (!$wallet || !$user) {
            $this->session->set_flashdata('error', 'User wallet not found for this withdraw request.');
            redirect('admin/user_wallet');
            return;
        }

        if (!$bankAccount) {
            $this->session->set_flashdata('error', 'User bank account details are missing.');
            redirect('admin/user_wallet');
            return;
        }

        try {
            $payout = $this->createRazorpayPayout($transaction, $user, $bankAccount);
        } catch (Throwable $exception) {
            $this->session->set_flashdata('error', 'Razorpay payout failed: ' . $exception->getMessage());
            redirect('admin/user_wallet');
            return;
        }

        $updateData = [
            'status' => 'success',
        ];

        if ($this->transactionColumnExists('remark')) {
            $updateData['remark'] = 'Razorpay payout ' . ($payout['id'] ?? '');
        }

        if ($this->transactionColumnExists('description')) {
            $updateData['description'] = 'Razorpay payout ' . ($payout['id'] ?? '') . ' approved by admin';
        }

        if ($this->transactionColumnExists('payment_id')) {
            $updateData['payment_id'] = $payout['id'] ?? null;
        }

        $this->db->where('id', (int) $transactionId)->update('transactions', $updateData);

        $this->session->set_flashdata('success', 'Withdraw approved successfully. Payout ID: ' . ($payout['id'] ?? 'N/A') . '. Request status updated to SUCCESS.');
        redirect('admin/user_wallet');
    }

    public function mark_paid_manual($transactionId = 0)
    {
        $transaction = $this->db
            ->where('id', (int) $transactionId)
            ->where('type', 'withdraw')
            ->where('status', 'pending')
            ->get('transactions')
            ->row_array();

        if (!$transaction) {
            $this->session->set_flashdata('error', 'Withdraw request not found or already processed.');
            redirect('admin/user_wallet');
            return;
        }

        $updateData = [
            'status' => 'success',
        ];

        if ($this->transactionColumnExists('remark')) {
            $updateData['remark'] = 'Manual payout completed by admin';
        }

        if ($this->transactionColumnExists('description')) {
            $updateData['description'] = 'Manual payout completed by admin';
        }

        if ($this->transactionColumnExists('payment_id')) {
            $updateData['payment_id'] = 'MANUAL-' . (int) $transactionId . '-' . date('YmdHis');
        }

        $this->db->where('id', (int) $transactionId)->update('transactions', $updateData);

        $this->session->set_flashdata('success', 'Withdraw marked as manually paid. No demo credit was added; this is recorded as a real external payout.');
        redirect('admin/user_wallet');
    }
private function cf_get_token()
{
    $this->config->load('cashfree');

    $url = $this->config->item('cashfree_base_url') . "authorize";

    $headers = [
        "X-Client-Id: " . $this->config->item('cashfree_client_id'),
        "X-Client-Secret: " . $this->config->item('cashfree_client_secret')
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $res = json_decode($response, true);
    return $res['data']['token'] ?? false;
}
private function cf_add_beneficiary($token, $user)
{
    $this->config->load('cashfree');

    $url = $this->config->item('cashfree_base_url') . "addBeneficiary";

    $data = [
        "beneId" => "USER_" . $user['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "phone" => $user['phone'],
        "bankAccount" => $user['bank_account'],
        "ifsc" => $user['ifsc'],
        "address1" => "India"
    ];

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
private function cf_transfer($token, $data)
{
    $this->config->load('cashfree');

    $url = $this->config->item('cashfree_base_url') . "requestTransfer";

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
    public function reject_withdraw($transactionId = 0)
    {
        $transaction = $this->db
            ->where('id', (int) $transactionId)
            ->where('type', 'withdraw')
            ->where('status', 'pending')
            ->get('transactions')
            ->row_array();

        if (!$transaction) {
            $this->session->set_flashdata('error', 'Withdraw request not found or already processed.');
            redirect('admin/user_wallet');
            return;
        }

        $this->db->trans_start();

        $this->db->where('id', (int) $transactionId)->update('transactions', [
            'status' => 'failed'
        ]);

        $this->db->set('balance', 'balance + ' . (float) $transaction['amount'], false)
            ->where('id', (int) $transaction['wallet_id'])
            ->update('wallets');

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to reject withdraw right now.');
            redirect('admin/user_wallet');
            return;
        }

        $this->session->set_flashdata('success', 'Withdraw rejected and amount returned to user wallet.');
        redirect('admin/user_wallet');
    }
}
