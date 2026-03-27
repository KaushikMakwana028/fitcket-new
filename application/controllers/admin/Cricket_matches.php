<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Cricket_matches extends Admin_Controller
{
    private $perPage = 10;
    private $cricketMatchDurationHours = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
        $this->load->library('pagination');
    }

    private function ensureMatchesTable()
    {
        if ($this->db->table_exists('cricket_matches')) {
            return true;
        }

        $this->session->set_flashdata('error', 'Please run the cricket matches SQL first.');
        redirect('admin/cricket_matches');
        return false;
    }

    private function getMatchEndAt($startAt, $nextStartAt = false)
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

    private function getMatchBucket(array $match, $nextStartAt = false)
    {
        $status = strtolower((string) ($match['admin_status'] ?? 'scheduled'));
        $startAt = strtotime((string) ($match['start_at'] ?? ''));
        $now = time();
        $today = date('Y-m-d');

        if ($startAt === false) {
            return 'unknown';
        }

        $endAt = $this->getMatchEndAt($startAt, $nextStartAt);

        if ($status === 'cancelled') {
            return 'cancelled';
        }

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

    private function prepareMatchRow(array $match, $nextStartAt = false)
    {
        $startAt = !empty($match['start_at']) ? strtotime($match['start_at']) : false;
        $effectiveEndAt = $this->getMatchEndAt($startAt, $nextStartAt);
        $match['bucket'] = $this->getMatchBucket($match, $nextStartAt);
        $match['teams_text'] = trim((string) $match['team_home']) . ' vs ' . trim((string) $match['team_away']);
        $match['start_label'] = $startAt ? date('d M Y, h:i A', $startAt) : 'Not set';
        $match['date_label'] = $startAt ? date('d M Y', $startAt) : 'Not set';
        $match['time_label'] = $startAt ? date('h:i A', $startAt) : '';
        $match['end_label'] = $effectiveEndAt ? date('d M Y, h:i A', $effectiveEndAt) : 'Auto';
        return $match;
    }

    private function sortPreparedMatches(array $matches)
    {
        $bucketPriority = [
            'live' => 1,
            'today' => 2,
            'upcoming' => 3,
            'scheduled' => 4,
            'cancelled' => 5,
            'completed' => 6,
            'unknown' => 7,
        ];

        usort($matches, function ($left, $right) use ($bucketPriority) {
            $leftBucket = strtolower((string) ($left['bucket'] ?? 'unknown'));
            $rightBucket = strtolower((string) ($right['bucket'] ?? 'unknown'));

            $leftPriority = $bucketPriority[$leftBucket] ?? 999;
            $rightPriority = $bucketPriority[$rightBucket] ?? 999;

            if ($leftPriority !== $rightPriority) {
                return $leftPriority <=> $rightPriority;
            }

            $leftStartAt = !empty($left['start_at']) ? strtotime((string) $left['start_at']) : false;
            $rightStartAt = !empty($right['start_at']) ? strtotime((string) $right['start_at']) : false;

            if ($leftStartAt === false && $rightStartAt === false) {
                return ((int) ($right['id'] ?? 0)) <=> ((int) ($left['id'] ?? 0));
            }

            if ($leftStartAt === false) {
                return 1;
            }

            if ($rightStartAt === false) {
                return -1;
            }

            if ($leftBucket === 'completed') {
                return $rightStartAt <=> $leftStartAt;
            }

            return $leftStartAt <=> $rightStartAt;
        });

        return $matches;
    }

    private function buildUploadPath()
    {
        $relativePath = 'uploads/matches/';
        $absolutePath = FCPATH . $relativePath;

        if (!is_dir($absolutePath)) {
            @mkdir($absolutePath, 0777, true);
        }

        return [$absolutePath, $relativePath];
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

    private function settlePoolWinnings($poolId)
    {
        $questions = $this->getPoolQuestionsForSettlement($poolId);
        $poolUsers = $this->getPoolAnswerRowsForSettlement($poolId, $questions);

        if (empty($poolUsers)) {
            return ['winners' => 0, 'credited' => 0];
        }

        $hasChecked = false;
        foreach ($poolUsers as $userRow) {
            if ((int) ($userRow['summary']['checked'] ?? 0) > 0) {
                $hasChecked = true;
                break;
            }
        }

        if (!$hasChecked) {
            return ['winners' => 0, 'credited' => 0];
        }

        $topScore = (int) ($poolUsers[0]['summary']['right'] ?? 0);
        $winners = array_values(array_filter($poolUsers, function ($userRow) use ($topScore) {
            return (int) ($userRow['summary']['right'] ?? 0) === $topScore;
        }));

        if (empty($winners)) {
            return ['winners' => 0, 'credited' => 0];
        }

        $pool = $this->db->where('id', (int) $poolId)->get('pools')->row_array();
        if (!$pool || (float) ($pool['price'] ?? 0) <= 0) {
            return ['winners' => count($winners), 'credited' => 0];
        }

        $totalPrize = (float) $pool['price'] * count($poolUsers);
        $winningAmount = $totalPrize / count($winners);

        if ($winningAmount <= 0) {
            return ['winners' => count($winners), 'credited' => 0];
        }

        $creditedCount = 0;

        foreach ($winners as $winner) {
            $userId = (int) $winner['user_id'];
            $wallet = $this->db->where('user_id', $userId)->get('wallets')->row_array();

            if (!$wallet) {
                $this->db->insert('wallets', [
                    'user_id' => $userId,
                    'balance' => 0,
                ]);

                $wallet = $this->db->where('user_id', $userId)->get('wallets')->row_array();
            }

            if (!$wallet) {
                continue;
            }

            $alreadyPaid = $this->db
                ->where('wallet_id', $wallet['id'])
                ->where('pool_id', (int) $poolId)
                ->where('type', 'winning')
                ->where('status', 'success')
                ->get('transactions')
                ->row_array();

            if ($alreadyPaid) {
                continue;
            }

            $this->db->trans_start();

            $this->db->set('balance', 'balance + ' . $winningAmount, false)
                ->where('id', $wallet['id'])
                ->update('wallets');

            $this->db->insert('transactions', [
                'wallet_id' => $wallet['id'],
                'type' => 'winning',
                'amount' => $winningAmount,
                'status' => 'success',
                'pool_id' => (int) $poolId,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status() !== false) {
                $creditedCount++;
            }
        }

        return [
            'winners' => count($winners),
            'credited' => $creditedCount,
        ];
    }

    private function settleMatchWinnings($matchId)
    {
        if (!$this->db->table_exists('pools')) {
            return ['pools' => 0, 'winners' => 0, 'credited' => 0];
        }

        $poolRows = $this->db
            ->select('id')
            ->from('pools')
            ->where('match_id', (int) $matchId)
            ->get()
            ->result_array();

        $summary = [
            'pools' => count($poolRows),
            'winners' => 0,
            'credited' => 0,
        ];

        foreach ($poolRows as $poolRow) {
            $poolSummary = $this->settlePoolWinnings((int) $poolRow['id']);
            $summary['winners'] += (int) ($poolSummary['winners'] ?? 0);
            $summary['credited'] += (int) ($poolSummary['credited'] ?? 0);
        }

        return $summary;
    }

    private function uploadLogo($fieldName, $existingPath = '')
    {
        if (empty($_FILES[$fieldName]['name'])) {
            return $existingPath;
        }

        list($absolutePath, $relativePath) = $this->buildUploadPath();

        $config = [
            'upload_path' => $absolutePath,
            'allowed_types' => 'jpg|jpeg|png|webp|gif',
            'max_size' => 4096,
            'encrypt_name' => true,
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($fieldName)) {
            throw new RuntimeException(strip_tags($this->upload->display_errors('', '')));
        }

        if ($existingPath !== '' && is_file(FCPATH . ltrim($existingPath, '/'))) {
            @unlink(FCPATH . ltrim($existingPath, '/'));
        }

        $uploadData = $this->upload->data();
        return $relativePath . $uploadData['file_name'];
    }

    private function collectPayload($existing = [])
    {
        $competitionName = trim((string) $this->input->post('competition_name'));
        $teamHome = trim((string) $this->input->post('team_home'));
        $teamAway = trim((string) $this->input->post('team_away'));
        $venue = trim((string) $this->input->post('venue'));
        $startDate = trim((string) $this->input->post('start_date'));
        $startTime = trim((string) $this->input->post('start_time'));
        $adminStatus = trim((string) $this->input->post('admin_status'));

        if ($teamHome === '' || $teamAway === '') {
            throw new RuntimeException('Please enter both team names.');
        }

        if ($startDate === '' || $startTime === '') {
            throw new RuntimeException('Please select match start date and time.');
        }

        if (!in_array($adminStatus, ['scheduled', 'live', 'completed', 'cancelled'], true)) {
            $adminStatus = 'scheduled';
        }

        if ($adminStatus === 'completed') {
            $oldStatus = $existing['admin_status'] ?? 'scheduled';
            if ($oldStatus !== 'live' && $oldStatus !== 'completed') {
                throw new RuntimeException('Match must be set to Live before it can be marked as Completed.');
            }
        }

        $startAt = strtotime($startDate . ' ' . $startTime);

        if ($startAt === false) {
            throw new RuntimeException('Invalid match start date or time.');
        }

        $payload = [
            'competition_name' => $competitionName,
            'team_home' => $teamHome,
            'team_away' => $teamAway,
            'venue' => $venue,
            'start_at' => date('Y-m-d H:i:s', $startAt),
            'admin_status' => $adminStatus,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $payload['home_logo'] = $this->uploadLogo('home_logo', (string) ($existing['home_logo'] ?? ''));
        $payload['away_logo'] = $this->uploadLogo('away_logo', (string) ($existing['away_logo'] ?? ''));

        return $payload;
    }

    public function index()
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        $search = trim((string) $this->input->get('search'));
        $status = trim((string) $this->input->get('status'));
        $page = max(0, (int) $this->input->get('page'));

        if ($this->input->get('page') === null) {
            $_GET['page'] = '0';
        }

        $builder = $this->db->from('cricket_matches');

        if ($search !== '') {
            $builder->group_start()
                ->like('competition_name', $search)
                ->or_like('team_home', $search)
                ->or_like('team_away', $search)
                ->or_like('venue', $search)
                ->group_end();
        }

        $matches = $builder
            ->order_by('start_at', 'ASC')
            ->order_by('id', 'DESC')
            ->get()
            ->result_array();

        $preparedMatches = [];
        $totalMatches = count($matches);

        foreach ($matches as $index => $match) {
            $nextStartAt = false;

            for ($nextIndex = $index + 1; $nextIndex < $totalMatches; $nextIndex++) {
                $candidateStartAt = strtotime((string) ($matches[$nextIndex]['start_at'] ?? ''));
                if ($candidateStartAt !== false) {
                    $nextStartAt = $candidateStartAt;
                    break;
                }
            }

            $preparedMatches[] = $this->prepareMatchRow($match, $nextStartAt);
        }

        $preparedMatches = $this->sortPreparedMatches($preparedMatches);

        if ($status !== '') {
            $preparedMatches = array_values(array_filter($preparedMatches, function ($match) use ($status) {
                return strtolower((string) ($match['bucket'] ?? '')) === $status;
            }));
        }

        $totalRows = count($preparedMatches);
        $data['matches'] = array_slice($preparedMatches, $page, $this->perPage);
        $data['search'] = $search;
        $data['status_filter'] = $status;

        $config['base_url'] = base_url('admin/cricket_matches');
        $config['total_rows'] = $totalRows;
        $config['per_page'] = $this->perPage;
        $config['cur_page'] = (string) $page;
        $config['reuse_query_string'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['full_tag_open'] = '<ul class="pagination mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['stats'] = [
            'total' => (int) $this->db->count_all('cricket_matches'),
            'live' => (int) $this->db->where('admin_status', 'live')->count_all_results('cricket_matches'),
            'scheduled' => (int) $this->db->where('admin_status', 'scheduled')->count_all_results('cricket_matches'),
            'completed' => (int) $this->db->where('admin_status', 'completed')->count_all_results('cricket_matches'),
        ];

        $data['pending_results'] = $this->db
            ->where('admin_status', 'completed')
            ->group_start()
                ->where('match_result', null)
                ->or_where('match_result', '')
            ->group_end()
            ->order_by('updated_at', 'DESC')
            ->get('cricket_matches')
            ->result_array();

        $this->load->view('admin/header');
        $this->load->view('admin/cricket_matches_view', $data);
        $this->load->view('admin/footer');
    }

    public function create()
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        $data['page_title'] = 'Add Cricket Match';
        $data['match'] = [
            'id' => 0,
            'competition_name' => '',
            'team_home' => '',
            'team_away' => '',
            'home_logo' => '',
            'away_logo' => '',
            'venue' => '',
            'start_at' => '',
            'admin_status' => 'scheduled',
        ];

        $this->load->view('admin/header');
        $this->load->view('admin/cricket_match_form', $data);
        $this->load->view('admin/footer');
    }

    public function store()
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        try {
            $payload = $this->collectPayload();
            $payload['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('cricket_matches', $payload);
            $this->session->set_flashdata('success', 'Cricket match added successfully.');
        } catch (Throwable $exception) {
            $this->session->set_flashdata('error', $exception->getMessage());
            redirect('admin/cricket_matches/create');
            return;
        }

        redirect('admin/cricket_matches');
    }

    public function edit($id = 0)
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        $match = $this->db->get_where('cricket_matches', ['id' => (int) $id])->row_array();

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_matches');
            return;
        }

        $data['page_title'] = 'Edit Cricket Match';
        $data['match'] = $match;

        $this->load->view('admin/header');
        $this->load->view('admin/cricket_match_form', $data);
        $this->load->view('admin/footer');
    }

    public function update($id = 0)
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        $match = $this->db->get_where('cricket_matches', ['id' => (int) $id])->row_array();

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_matches');
            return;
        }

        try {
            $payload = $this->collectPayload($match);
            $this->db->where('id', (int) $id)->update('cricket_matches', $payload);
            $this->session->set_flashdata('success', 'Cricket match updated successfully.');
        } catch (Throwable $exception) {
            $this->session->set_flashdata('error', $exception->getMessage());
            redirect('admin/cricket_matches/edit/' . (int) $id);
            return;
        }

        redirect('admin/cricket_matches');
    }

    public function delete($id = 0)
    {
        if (!$this->ensureMatchesTable()) {
            return;
        }

        $match = $this->db->get_where('cricket_matches', ['id' => (int) $id])->row_array();

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_matches');
            return;
        }

        foreach (['home_logo', 'away_logo'] as $logoField) {
            $logoPath = trim((string) ($match[$logoField] ?? ''));

            if ($logoPath !== '' && is_file(FCPATH . ltrim($logoPath, '/'))) {
                @unlink(FCPATH . ltrim($logoPath, '/'));
            }
        }

        $this->db->where('id', (int) $id)->delete('cricket_matches');
        $this->session->set_flashdata('success', 'Cricket match deleted successfully.');
        redirect('admin/cricket_matches');
    }

    public function auto_update_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = (int) $this->input->post('id');
        $status = trim((string) $this->input->post('status'));

        if ($id > 0 && in_array($status, ['scheduled', 'live', 'completed', 'cancelled'])) {
            if ($status === 'completed') {
                $match = $this->db->get_where('cricket_matches', ['id' => $id])->row_array();
                if ($match && $match['admin_status'] !== 'live' && $match['admin_status'] !== 'completed') {
                    echo json_encode(['success' => false, 'message' => 'Match must be Live before it can be Completed.']);
                    return;
                }
            }
            
            $this->db->where('id', $id)->update('cricket_matches', [
                'admin_status' => $status, 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function save_result()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id = (int) $this->input->post('id');
        $result = trim((string) $this->input->post('match_result'));

        if ($id > 0 && $result !== '') {
            $this->db->where('id', $id)->update('cricket_matches', [
                'match_result' => $result,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $message = 'Result saved successfully.';
            $settlement = ['pools' => 0, 'winners' => 0, 'credited' => 0];
            $message .= ' Winner amount payout will happen after answer key is saved from pool questions.';

            echo json_encode([
                'success' => true,
                'message' => $message,
                'settlement' => $settlement,
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }
}
