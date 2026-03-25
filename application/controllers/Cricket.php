<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;

class Cricket extends User_Controller
{
    private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";
    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";
    private $poolAnswerOptions = ['yes', 'no'];
    private $cricketMatchDurationHours = 10;

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

    private function hasPoolScheduleColumns()
    {
        return $this->db->field_exists('match_start_at', 'pools')
            && $this->db->field_exists('join_close_at', 'pools');
    }

    private function hasCricketMatchesTable()
    {
        return $this->db->table_exists('cricket_matches');
    }

    private function getCricketLogoUrl($path)
    {
        $path = trim((string) $path);

        if ($path === '') {
            return '';
        }

        $path = str_replace('\\', '/', $path);

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (strpos($path, base_url()) === 0) {
            return $path;
        }

        return base_url(ltrim($path, '/'));
    }

    private function getCricketMatchEndAt($startAt, $nextStartAt = false)
    {
        if ($startAt === false) {
            return false;
        }

        $defaultEndAt = strtotime('+' . (int) $this->cricketMatchDurationHours . ' hours', $startAt);

        if ($nextStartAt !== false && $nextStartAt > $startAt && $nextStartAt < $defaultEndAt) {
            return $nextStartAt;
        }

        return $defaultEndAt;
    }

    private function getCricketMatchBucket(array $match, $nextStartAt = false)
    {
        $status = strtolower((string) ($match['admin_status'] ?? 'scheduled'));
        $startAt = strtotime((string) ($match['start_at'] ?? ''));
        $now = time();
        $today = date('Y-m-d');

        if ($startAt === false || $status === 'cancelled') {
            return 'hidden';
        }

        $endAt = $this->getCricketMatchEndAt($startAt, $nextStartAt);

        if ($status === 'completed' || $endAt < $now) {
            return 'completed';
        }

        if ($status === 'live' || ($startAt <= $now && $endAt >= $now)) {
            return 'live';
        }

        if (date('Y-m-d', $startAt) === $today) {
            return 'today';
        }

        if ($startAt > $now) {
            return 'upcoming';
        }

        return 'completed';
    }

    private function mapCricketMatchCard(array $match, $bucket)
    {
        $startAt = strtotime((string) ($match['start_at'] ?? ''));
        $scoreLine = $bucket === 'live'
            ? 'Match in progress'
            : ($startAt ? 'Starts at ' . date('g:i A', $startAt) : 'Schedule not set');

        return [
            'id' => (int) ($match['id'] ?? 0),
            'competition_name' => trim((string) ($match['competition_name'] ?? '')),
            'team1' => trim((string) ($match['team_home'] ?? 'Team A')),
            'team2' => trim((string) ($match['team_away'] ?? 'Team B')),
            'team1_logo' => $this->getCricketLogoUrl($match['home_logo'] ?? ''),
            'team2_logo' => $this->getCricketLogoUrl($match['away_logo'] ?? ''),
            'score' => $scoreLine,
            'venue' => trim((string) ($match['venue'] ?? '')),
            'bucket' => $bucket,
            'status' => strtolower((string) ($match['admin_status'] ?? 'scheduled')),
            'start_label' => $startAt ? date('d M Y, h:i A', $startAt) : 'Not scheduled',
            'date_label' => $startAt ? date('d M Y', $startAt) : 'Not scheduled',
            'time_label' => $startAt ? date('h:i A', $startAt) : '',
            'teams' => trim((string) ($match['team_home'] ?? '')) . ' vs ' . trim((string) ($match['team_away'] ?? '')),
            'match_result' => trim((string) ($match['match_result'] ?? '')),
        ];
    }

    private function getCricketPageMatches()
    {
        $result = [
            'live_match' => null,
            'primary_match' => null,
            'completed_matches' => [],
            'upcoming_matches' => [],
            'featured_match' => null,
        ];

        if (!$this->hasCricketMatchesTable()) {
            return $result;
        }

        $rows = $this->db
            ->from('cricket_matches')
            ->where('admin_status !=', 'cancelled')
            ->order_by('start_at', 'ASC')
            ->order_by('id', 'DESC')
            ->get()
            ->result_array();

        $liveMatches = [];
        $completedMatches = [];
        $upcomingMatches = [];
        $visibleMatches = [];

        $totalRows = count($rows);

        foreach ($rows as $index => $row) {
            $nextStartAt = false;

            for ($nextIndex = $index + 1; $nextIndex < $totalRows; $nextIndex++) {
                $candidateStartAt = strtotime((string) ($rows[$nextIndex]['start_at'] ?? ''));
                if ($candidateStartAt !== false) {
                    $nextStartAt = $candidateStartAt;
                    break;
                }
            }

            $bucket = $this->getCricketMatchBucket($row, $nextStartAt);

            if ($bucket === 'hidden') {
                continue;
            }

            $card = $this->mapCricketMatchCard($row, $bucket);

            if ($bucket !== 'completed') {
                $visibleMatches[] = $card;
            }

            if ($bucket === 'live') {
                $liveMatches[] = $card;
            } elseif ($bucket === 'completed') {
                $completedMatches[] = $card;
            } elseif ($bucket === 'today' || $bucket === 'upcoming') {
                $upcomingMatches[] = $card;
            }
        }

        $result['live_match'] = !empty($liveMatches) ? $liveMatches[0] : null;
        $result['completed_matches'] = array_slice(array_reverse($completedMatches), 0, 4);
        $result['upcoming_matches'] = array_slice($upcomingMatches, 0, 4);
        $result['primary_match'] = $result['live_match']
            ?: (!empty($upcomingMatches) ? $upcomingMatches[0] : null);

        $result['featured_match'] = null;
        if (!empty($result['primary_match'])) {
            $primaryId = (int) ($result['primary_match']['id'] ?? 0);

            foreach ($visibleMatches as $index => $matchCard) {
                if ((int) ($matchCard['id'] ?? 0) === $primaryId) {
                    $result['featured_match'] = $visibleMatches[$index + 1] ?? null;
                    break;
                }
            }
        }

        if (empty($result['featured_match'])) {
            $result['featured_match'] = $result['primary_match'];
        }

        return $result;
    }

    private function isPoolJoinClosed(array $pool)
    {
        $joinCloseAt = trim((string) ($pool['join_close_at'] ?? ''));
        $matchStartAt = trim((string) ($pool['match_start_at'] ?? ''));

        if ($joinCloseAt !== '') {
            return strtotime($joinCloseAt) <= time();
        }

        if ($matchStartAt !== '') {
            return strtotime($matchStartAt . ' -30 minutes') <= time();
        }

        return false;
    }

    private function getPoolMembersMap(array $poolIds)
    {
        if (empty($poolIds)) {
            return [];
        }

        $rows = $this->db
            ->select('pool_joins.pool_id, users.name')
            ->from('pool_joins')
            ->join('users', 'users.id = pool_joins.user_id', 'left')
            ->where_in('pool_joins.pool_id', $poolIds)
            ->where('pool_joins.status', 'success')
            ->order_by('users.name', 'ASC')
            ->get()
            ->result_array();

        $membersMap = [];

        foreach ($rows as $row) {
            $poolId = (int) $row['pool_id'];

            if (!isset($membersMap[$poolId])) {
                $membersMap[$poolId] = [];
            }

            $membersMap[$poolId][] = $row['name'] ?: 'User';
        }

        return $membersMap;
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

    private function hasJoinedPool($poolId, $userId)
    {
        return $this->db
            ->where('pool_id', (int) $poolId)
            ->where('user_id', (int) $userId)
            ->where('status', 'success')
            ->count_all_results('pool_joins') > 0;
    }

    private function getPoolQuestions($poolId)
    {
        if (!$this->db->table_exists('pool_questions')) {
            return [];
        }

        $query = $this->db
            ->where('pool_id', (int) $poolId)
            ->order_by('position', 'ASC')
            ->order_by('id', 'ASC')
            ->get('pool_questions');

        if (!$query) {
            return [];
        }

        return $query->result_array();
    }

    private function getUserPoolAnswersByQuestion($poolId, $userId)
    {
        if (!$this->db->table_exists('pool_question_answers')) {
            return [];
        }

        $rows = $this->db
            ->where('pool_id', (int) $poolId)
            ->where('user_id', (int) $userId)
            ->get('pool_question_answers')
            ->result_array();

        $answers = [];

        foreach ($rows as $row) {
            $answers[(int) $row['pool_question_id']] = $row;
        }

        return $answers;
    }

    private function hasUserSubmittedPoolAnswers($poolId, $userId)
    {
        if (!$this->db->table_exists('pool_question_answers')) {
            return false;
        }

        return $this->db
            ->where('pool_id', (int) $poolId)
            ->where('user_id', (int) $userId)
            ->count_all_results('pool_question_answers') > 0;
    }

    private function calculatePoolAnswerSummary(array $questions, array $userAnswers)
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
            $userAnswer = strtolower(trim((string) ($userAnswers[$questionId]['answer'] ?? '')));

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

        $matches = $this->getCricketPageMatches();
        $data['live_match'] = $matches['live_match'];
        $data['featured_match'] = $matches['featured_match'];
        $data['completed_matches'] = $matches['completed_matches'];
        $data['upcoming'] = $matches['upcoming_matches'];
        $primaryLiveCard = $matches['primary_match'] ?? $matches['featured_match'];
        $data['has_live'] = !empty($matches['live_match']);
        $data['live'] = [
            'team1' => $primaryLiveCard['team1'] ?? 'No Matches',
            'team2' => $primaryLiveCard['team2'] ?? 'Scheduled',
            'score' => $primaryLiveCard['score'] ?? 'Check back soon for fixtures',
            'status' => !empty($matches['live_match']) ? 'LIVE' : strtoupper((string) ($primaryLiveCard['bucket'] ?? 'today')),
            'team1_logo' => $primaryLiveCard['team1_logo'] ?? '',
            'team2_logo' => $primaryLiveCard['team2_logo'] ?? '',
            'competition_name' => $primaryLiveCard['competition_name'] ?? '',
            'venue' => $primaryLiveCard['venue'] ?? '',
            'start_label' => $primaryLiveCard['start_label'] ?? '',
        ];

        $featuredCard = $matches['featured_match'] ?? $matches['primary_match'];
        $data['has_featured'] = !empty($featuredCard);
        $data['featured'] = [
            'team1' => $featuredCard['team1'] ?? 'No Matches',
            'team2' => $featuredCard['team2'] ?? 'Scheduled',
            'score' => $featuredCard['score'] ?? 'Check back soon for fixtures',
            'status' => !empty($featuredCard['bucket']) && $featuredCard['bucket'] === 'live' ? 'LIVE NOW' : (!empty($featuredCard['bucket']) && $featuredCard['bucket'] === 'today' ? 'TODAY MATCH' : 'UPCOMING MATCH'),
            'team1_logo' => $featuredCard['team1_logo'] ?? '',
            'team2_logo' => $featuredCard['team2_logo'] ?? '',
            'competition_name' => $featuredCard['competition_name'] ?? '',
            'venue' => $featuredCard['venue'] ?? '',
            'start_label' => $featuredCard['start_label'] ?? '',
        ];
        $data['upcoming'] = array_map(function ($match) {
            $match['date'] = trim(($match['date_label'] ?? '') . (!empty($match['time_label']) ? ', ' . $match['time_label'] : ''));
            return $match;
        }, $data['upcoming']);

        $data['tournaments'] = [
            ['name' => 'IPL 2026', 'date' => 'Starts 25 Mar'],
            ['name' => 'Asia Cup', 'date' => 'June 2026'],
            ['name' => 'World Cup', 'date' => 'Oct 2026']
        ];

        $data['players'] = [
            [
                'name' => 'Virat Kohli',
                'image' => 'assets/images/cricket/VK.jpg'
            ],
            [
                'name' => 'AB de Villiers',
                'image' => 'assets/images/cricket/ABD.png'
            ],
            [
                'name' => 'Joe Root',
                'image' => 'assets/images/cricket/JR.jpeg'
            ],
            [
                'name' => 'Steve Smith',
                'image' => 'assets/images/cricket/SS.jpeg'
            ]
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

        if ($this->db->field_exists('isActive', 'pools') && $this->db->field_exists('created_at', 'pools')) {
            $this->db->where('created_at <=', date('Y-m-d H:i:s', strtotime('-24 hours')))
                ->where('isActive', 1)
                ->update('pools', ['isActive' => 0]);
        }

        $this->db->select("
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
            ->join('users', 'users.id = pools.user_id', 'left');

        if ($this->db->field_exists('isActive', 'pools')) {
            $this->db->where('pools.isActive', 1);
        }

        $data['pools'] = $this->db->order_by('pools.id', 'DESC')
            ->get()
            ->result_array();

        $poolIds = array_map('intval', array_column($data['pools'], 'id'));
        $data['pool_members'] = $this->getPoolMembersMap($poolIds);
        $data['pool_schedule_ready'] = $this->hasPoolScheduleColumns();

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

    public function pool_play($poolId = 0)
    {
        $user = $this->getCurrentUser();
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('pool');
            return;
        }

        if (!$this->hasJoinedPool($poolId, $user['id'])) {
            $this->session->set_flashdata('error', 'Join this pool first to answer questions.');
            redirect('pool');
            return;
        }

        $questions = $this->getPoolQuestions($poolId);

        if (empty($questions)) {
            $this->session->set_flashdata('error', 'Questions are not added for this pool yet.');
            redirect('pool');
            return;
        }

        $userAnswers = $this->getUserPoolAnswersByQuestion($poolId, $user['id']);
        $data['pool'] = $pool;
        $data['questions'] = $questions;
        $data['user_answers'] = $userAnswers;
        $data['summary'] = $this->calculatePoolAnswerSummary($questions, $userAnswers);
        $data['answer_options'] = $this->poolAnswerOptions;
        $data['answers_locked'] = $this->hasUserSubmittedPoolAnswers($poolId, $user['id']);

        $this->load->view('header', $data);
        $this->load->view('pool_questions_play_view', $data);
        $this->load->view('footer');
    }

    public function pool_submit_answers($poolId = 0)
    {
        $user = $this->getCurrentUser();
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('pool');
            return;
        }

        if (!$this->hasJoinedPool($poolId, $user['id'])) {
            $this->session->set_flashdata('error', 'Join this pool first to answer questions.');
            redirect('pool');
            return;
        }

        if (!$this->db->table_exists('pool_question_answers')) {
            $this->session->set_flashdata('error', 'Pool answer table is missing. Please update the database SQL first.');
            redirect('pool/play/' . (int) $poolId);
            return;
        }

        $questions = $this->getPoolQuestions($poolId);

        if (empty($questions)) {
            $this->session->set_flashdata('error', 'Questions are not available for this pool.');
            redirect('pool/play/' . (int) $poolId);
            return;
        }

        if ($this->hasUserSubmittedPoolAnswers($poolId, $user['id'])) {
            $this->session->set_flashdata('error', 'You have already submitted your answers for this pool. Answers cannot be changed now.');
            redirect('pool/play/' . (int) $poolId);
            return;
        }

        $submittedAnswers = $this->input->post('answers');
        $submittedAnswers = is_array($submittedAnswers) ? $submittedAnswers : [];
        $timestamp = date('Y-m-d H:i:s');

        $this->db->trans_start();

        foreach ($questions as $question) {
            $questionId = (int) $question['id'];
            $answer = strtolower(trim((string) ($submittedAnswers[$questionId] ?? '')));

            if (!in_array($answer, $this->poolAnswerOptions, true)) {
                continue;
            }

            $payload = [
                'pool_id' => (int) $poolId,
                'pool_question_id' => $questionId,
                'user_id' => (int) $user['id'],
                'answer' => $answer,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];

            $this->db->insert('pool_question_answers', $payload);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to save your answers right now. Please try again.');
            redirect('pool/play/' . (int) $poolId);
            return;
        }

        $this->session->set_flashdata('success', 'Your answers have been submitted successfully.');
        redirect('pool/play/' . (int) $poolId);
    }

    public function pool_add()
    {
        $user = $this->getCurrentUser();

        if ((int) $user['is_host'] !== 1) {
            redirect('cricket');
        }

        $data['user'] = $user;
        $data['pool_schedule_ready'] = $this->hasPoolScheduleColumns();

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

        if (!$this->hasPoolScheduleColumns()) {
            $this->session->set_flashdata('error', 'Please run the pool schedule SQL first to enable match time and auto-close.');
            redirect('pool/add');
            return;
        }

        $poolName = trim((string) $this->input->post('pool_name'));
        $description = trim((string) $this->input->post('description'));
        $userLimitRaw = trim((string) $this->input->post('user_limit'));
        $userLimit = $userLimitRaw === '' ? 0 : (int) $userLimitRaw;
        $price = (float) $this->input->post('price');
        $matchDate = trim((string) $this->input->post('match_date'));
        $matchTime = trim((string) $this->input->post('match_time'));

        if ($poolName === '' || strlen($poolName) < 3) {
            $this->session->set_flashdata('error', 'Pool name must be at least 3 characters.');
            redirect('pool/add');
            return;
        }

        if ($price < 0) {
            $this->session->set_flashdata('error', 'Entry price cannot be negative.');
            redirect('pool/add');
            return;
        }

        if ($userLimit < 0 || ($userLimit > 0 && $userLimit < 2)) {
            $this->session->set_flashdata('error', 'Players must be at least 2, or use 0 for unlimited.');
            redirect('pool/add');
            return;
        }

        if ($matchDate === '' || $matchTime === '') {
            $this->session->set_flashdata('error', 'Please select match date and match start time.');
            redirect('pool/add');
            return;
        }

        $matchStartAt = strtotime($matchDate . ' ' . $matchTime);

        if ($matchStartAt === false) {
            $this->session->set_flashdata('error', 'Invalid match date or time.');
            redirect('pool/add');
            return;
        }

        $joinCloseAt = strtotime('-30 minutes', $matchStartAt);

        if ($joinCloseAt <= time()) {
            $this->session->set_flashdata('error', 'Match start time must be at least 30 minutes in the future.');
            redirect('pool/add');
            return;
        }

        $data = [
            'user_id' => $user['id'],
            'pool_name' => $poolName,
            'user_limit' => $userLimit,
            'price' => $price,
            'match_start_at' => date('Y-m-d H:i:s', $matchStartAt),
            'join_close_at' => date('Y-m-d H:i:s', $joinCloseAt),
        ];

        if ($this->db->field_exists('description', 'pools')) {
            $data['description'] = $description;
        }

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

        if ((int) $pool['user_limit'] > 0 && (int) $pool['total_joined'] >= (int) $pool['user_limit']) {
            $this->session->set_flashdata('error', 'This pool is already full.');
            redirect('pool');
            return;
        }

        if ($this->isPoolJoinClosed($pool)) {
            $this->session->set_flashdata('error', 'This pool is closed. Joining stops 30 minutes before match start.');
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
