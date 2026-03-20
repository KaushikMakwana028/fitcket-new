<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Pool extends Admin_Controller
{
    private $maxQuestionsPerPool = 10;
    private $answerOptions = ['yes', 'no'];
    private $leaderboardPerPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    private function getQuestionCountSelect()
    {
        if (!$this->db->table_exists('pool_questions')) {
            return '0 as question_count';
        }

        return '(
            SELECT COUNT(*)
            FROM pool_questions
            WHERE pool_questions.pool_id = pools.id
        ) as question_count';
    }

    private function getAnswerCountSelect()
    {
        if (!$this->db->table_exists('pool_question_answers')) {
            return '0 as answer_count';
        }

        return '(
            SELECT COUNT(*)
            FROM pool_question_answers
            WHERE pool_question_answers.pool_id = pools.id
        ) as answer_count';
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

    private function calculateSummaryForRows(array $questions, array $answersByQuestion)
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

    private function getPoolQuestions($poolId)
    {
        if (!$this->db->table_exists('pool_questions')) {
            return [];
        }

        return $this->db
            ->select("
                pool_questions.id,
                pool_questions.pool_id,
                pool_questions.question,
                pool_questions.position,
                {$this->getQuestionCorrectAnswerColumn()}
            ", false)
            ->from('pool_questions')
            ->where('pool_questions.pool_id', (int) $poolId)
            ->order_by('pool_questions.position', 'ASC')
            ->order_by('pool_questions.id', 'ASC')
            ->get()
            ->result_array();
    }

    private function getPoolAnswerRows($poolId, array $questions)
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
            $summary = $this->calculateSummaryForRows($questions, $userRow['answers']);
            $rows[] = array_merge($userRow, ['summary' => $summary]);
        }

        usort($rows, function ($left, $right) {
            if ($left['summary']['right'] === $right['summary']['right']) {
                if ($left['summary']['wrong'] === $right['summary']['wrong']) {
                    return strcmp((string) $left['user_name'], (string) $right['user_name']);
                }

                return $left['summary']['wrong'] <=> $right['summary']['wrong'];
            }

            return $right['summary']['right'] <=> $left['summary']['right'];
        });

        return $rows;
    }

    private function buildLeaderboard(array $answerRows)
    {
        $leaderboard = [];
        $rank = 1;

        foreach ($answerRows as $row) {
            $leaderboard[] = [
                'rank' => $rank++,
                'user_id' => $row['user_id'] ?? 0,
                'user_name' => $row['user_name'],
                'user_email' => $row['user_email'],
                'user_mobile' => $row['user_mobile'] ?? '',
                'pool_id' => $row['pool_id'] ?? 0,
                'pool_name' => $row['pool_name'] ?? '',
                'host_name' => $row['host_name'] ?? '',
                'entry_price' => $row['entry_price'] ?? 0,
                'user_limit' => $row['user_limit'] ?? 0,
                'total_questions' => $row['summary']['total'] ?? 0,
                'right' => $row['summary']['right'],
                'wrong' => $row['summary']['wrong'],
                'checked' => $row['summary']['checked'],
            ];
        }

        return $leaderboard;
    }

    private function getFilteredLeaderboard($poolId, array $questions)
    {
        if ((int) $poolId > 0) {
            $answerRows = $this->getPoolAnswerRows($poolId, $questions);
        } else {
            $answerRows = $this->getAllPoolAnswerRows();
        }

        $leaderboard = $this->buildLeaderboard($answerRows);
        $search = trim((string) $this->input->get('search'));
        $resultFilter = trim((string) $this->input->get('result'));
        $poolFilter = (int) $this->input->get('pool');

        if ($search !== '') {
            $leaderboard = array_values(array_filter($leaderboard, function ($row) use ($search) {
                $needle = strtolower($search);

                return strpos(strtolower((string) $row['user_name']), $needle) !== false
                    || strpos(strtolower((string) $row['user_email']), $needle) !== false
                    || strpos(strtolower((string) $row['user_mobile']), $needle) !== false
                    || strpos(strtolower((string) $row['pool_name']), $needle) !== false
                    || strpos(strtolower((string) $row['host_name']), $needle) !== false;
            }));
        }

        if ($poolFilter > 0 && (int) $poolId === 0) {
            $leaderboard = array_values(array_filter($leaderboard, function ($row) use ($poolFilter) {
                return (int) $row['pool_id'] === $poolFilter;
            }));
        }

        if ($resultFilter === 'checked') {
            $leaderboard = array_values(array_filter($leaderboard, function ($row) {
                return (int) $row['checked'] > 0;
            }));
        } elseif ($resultFilter === 'pending') {
            $leaderboard = array_values(array_filter($leaderboard, function ($row) {
                return (int) $row['checked'] === 0;
            }));
        }

        foreach ($leaderboard as $index => &$row) {
            $row['rank'] = $index + 1;
        }
        unset($row);

        return $leaderboard;
    }

    private function getAllPoolAnswerRows()
    {
        if (!$this->db->table_exists('pool_question_answers')) {
            return [];
        }

        $answerRows = $this->db
            ->select("
                pool_question_answers.*,
                users.name as user_name,
                users.email as user_email,
                users.mobile as user_mobile,
                pools.pool_name,
                pools.price as entry_price,
                pools.user_limit,
                COALESCE(host_users.name, 'Host') as host_name
            ", false)
            ->from('pool_question_answers')
            ->join('users', 'users.id = pool_question_answers.user_id', 'left')
            ->join('pools', 'pools.id = pool_question_answers.pool_id', 'left')
            ->join('users as host_users', 'host_users.id = pools.user_id', 'left')
            ->order_by('pool_question_answers.pool_id', 'ASC')
            ->order_by('pool_question_answers.user_id', 'ASC')
            ->order_by('pool_question_answers.pool_question_id', 'ASC')
            ->get()
            ->result_array();

        if (empty($answerRows)) {
            return [];
        }

        $poolIds = array_values(array_unique(array_map(function ($row) {
            return (int) $row['pool_id'];
        }, $answerRows)));
        $questionsByPool = [];

        foreach ($poolIds as $poolId) {
            $questionsByPool[$poolId] = $this->getPoolQuestions($poolId);
        }

        $answersByPoolUser = [];

        foreach ($answerRows as $answerRow) {
            $poolId = (int) $answerRow['pool_id'];
            $userId = (int) $answerRow['user_id'];
            $questionId = (int) $answerRow['pool_question_id'];
            $groupKey = $poolId . ':' . $userId;

            if (!isset($answersByPoolUser[$groupKey])) {
                $answersByPoolUser[$groupKey] = [
                    'pool_id' => $poolId,
                    'pool_name' => $answerRow['pool_name'] ?: 'Pool',
                    'host_name' => $answerRow['host_name'] ?: 'Host',
                    'entry_price' => $answerRow['entry_price'] ?? 0,
                    'user_limit' => $answerRow['user_limit'] ?? 0,
                    'user_id' => $userId,
                    'user_name' => $answerRow['user_name'] ?: 'User',
                    'user_email' => $answerRow['user_email'] ?? '',
                    'user_mobile' => $answerRow['user_mobile'] ?? '',
                    'answers' => [],
                ];
            }

            $answersByPoolUser[$groupKey]['answers'][$questionId] = $answerRow;
        }

        $rows = [];

        foreach ($answersByPoolUser as $groupedRow) {
            $questions = $questionsByPool[(int) $groupedRow['pool_id']] ?? [];
            $summary = $this->calculateSummaryForRows($questions, $groupedRow['answers']);
            $rows[] = array_merge($groupedRow, ['summary' => $summary]);
        }

        usort($rows, function ($left, $right) {
            if ($left['summary']['right'] === $right['summary']['right']) {
                if ($left['summary']['wrong'] === $right['summary']['wrong']) {
                    if ($left['summary']['checked'] === $right['summary']['checked']) {
                        return strcmp(
                            strtolower((string) $left['user_name']),
                            strtolower((string) $right['user_name'])
                        );
                    }

                    return $right['summary']['checked'] <=> $left['summary']['checked'];
                }

                return $left['summary']['wrong'] <=> $right['summary']['wrong'];
            }

            return $right['summary']['right'] <=> $left['summary']['right'];
        });

        return $rows;
    }

    private function getLeaderboardPools()
    {
        return $this->db
            ->select("pools.id, pools.pool_name, COALESCE(users.name, 'Host') as host_name", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->order_by('pools.pool_name', 'ASC')
            ->get()
            ->result_array();
    }

    private function getPoolWithMeta($poolId)
    {
        return $this->db
            ->select("
                pools.*,
                COALESCE(users.name, 'Host') as host_name,
                {$this->getQuestionCountSelect()}
            ", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->where('pools.id', (int) $poolId)
            ->get()
            ->row_array();
    }

    public function index()
    {
        $data['pools'] = $this->db
            ->select("
                pools.*,
                COALESCE(users.name, 'Host') as host_name,
                {$this->getQuestionCountSelect()},
                {$this->getAnswerCountSelect()}
            ", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->order_by('pools.id', 'DESC')
            ->get()
            ->result_array();

        $data['max_questions'] = $this->maxQuestionsPerPool;

        $this->load->view('admin/header');
        $this->load->view('admin/pool_list_view', $data);
        $this->load->view('admin/footer');
    }

    public function questions($poolId = 0)
    {
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('admin/pools');
            return;
        }

        $questions = [];

        if ($this->db->table_exists('pool_questions')) {
            $questions = $this->getPoolQuestions($poolId);
        }

        $questionTexts = array_fill(0, $this->maxQuestionsPerPool, '');

        foreach ($questions as $index => $question) {
            if ($index < $this->maxQuestionsPerPool) {
                $questionTexts[$index] = $question['question'];
            }
        }

        $data['pool'] = $pool;
        $data['question_texts'] = $questionTexts;
        $data['saved_question_count'] = count(array_filter($questionTexts, function ($question) {
            return trim((string) $question) !== '';
        }));
        $data['max_questions'] = $this->maxQuestionsPerPool;
        $data['question_table_exists'] = $this->db->table_exists('pool_questions');
        $data['answer_table_exists'] = $this->db->table_exists('pool_question_answers');
        $data['answer_options'] = $this->answerOptions;
        $data['questions'] = $questions;
        $data['answer_rows'] = $this->getPoolAnswerRows($poolId, $questions);
        $data['leaderboard'] = $this->buildLeaderboard($data['answer_rows']);

        $this->load->view('admin/header');
        $this->load->view('admin/pool_questions_view', $data);
        $this->load->view('admin/footer');
    }

    public function leaderboard($poolId = 0)
    {
        if ((int) $poolId > 0) {
            redirect('admin/pool/leaderboard');
            return;
        }

        $pool = null;
        $questions = [];
        $leaderboard = $this->getFilteredLeaderboard(0, []);
        $topThree = array_slice($leaderboard, 0, 3);
        $remainingRows = array_slice($leaderboard, 3);
        $currentPage = max(1, (int) $this->input->get('page'));
        $perPage = $this->leaderboardPerPage;
        $totalRows = count($remainingRows);
        $totalPages = max(1, (int) ceil($totalRows / $perPage));

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $perPage;
        $paginatedRows = array_slice($remainingRows, $offset, $perPage);
        $queryParams = $this->input->get();
        unset($queryParams['page']);

        $data['pool'] = $pool;
        $data['questions'] = $questions;
        $data['leaderboard'] = $leaderboard;
        $data['top_three'] = $topThree;
        $data['table_rows'] = $paginatedRows;
        $data['search'] = trim((string) $this->input->get('search'));
        $data['result_filter'] = trim((string) $this->input->get('result'));
        $data['pool_filter'] = (int) $this->input->get('pool');
        $data['pool_options'] = $this->getLeaderboardPools();
        $data['participants_count'] = count($leaderboard);
        $data['top_score'] = !empty($leaderboard) ? max(array_column($leaderboard, 'right')) : 0;
        $data['checked_count'] = count(array_filter($leaderboard, function ($row) {
            return (int) $row['checked'] > 0;
        }));
        $data['per_page'] = $perPage;
        $data['current_page'] = $currentPage;
        $data['total_pages'] = $totalPages;
        $data['remaining_count'] = $totalRows;
        $data['query_params'] = $queryParams;

        $this->load->view('admin/header');
        $this->load->view('admin/pool_leaderboard_view', $data);
        $this->load->view('admin/footer');
    }

    public function save_questions($poolId = 0)
    {
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('admin/pools');
            return;
        }

        if (!$this->db->table_exists('pool_questions')) {
            $this->session->set_flashdata('error', 'Please create the pool_questions table first using the provided SQL query.');
            redirect('admin/pool/' . (int) $poolId);
            return;
        }

        $postedQuestions = $this->input->post('questions');
        $postedQuestions = is_array($postedQuestions) ? $postedQuestions : [];

        $cleanQuestions = [];

        foreach ($postedQuestions as $question) {
            $question = trim((string) $question);

            if ($question !== '') {
                $cleanQuestions[] = $question;
            }
        }

        if (count($cleanQuestions) > $this->maxQuestionsPerPool) {
            $this->session->set_flashdata('error', 'You can add only ' . $this->maxQuestionsPerPool . ' questions in one pool.');
            redirect('admin/pool/' . (int) $poolId);
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $existingQuestions = $this->getPoolQuestions($poolId);

        $this->db->trans_start();

        foreach ($cleanQuestions as $index => $question) {
            $payload = [
                'question' => $question,
                'position' => $index + 1,
                'updated_at' => $timestamp,
            ];

            if (isset($existingQuestions[$index])) {
                $this->db->where('id', (int) $existingQuestions[$index]['id'])->update('pool_questions', $payload);
            } else {
                $payload['pool_id'] = (int) $poolId;
                $payload['created_at'] = $timestamp;
                $this->db->insert('pool_questions', $payload);
            }
        }

        if (count($existingQuestions) > count($cleanQuestions)) {
            for ($index = count($cleanQuestions); $index < count($existingQuestions); $index++) {
                $this->db->where('id', (int) $existingQuestions[$index]['id'])->delete('pool_questions');
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to save pool questions right now. Please try again.');
            redirect('admin/pool/' . (int) $poolId);
            return;
        }

        $this->session->set_flashdata('success', 'Pool questions saved successfully.');
        redirect('admin/pool/' . (int) $poolId);
    }

    public function save_answer_key($poolId = 0)
    {
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('admin/pools');
            return;
        }

        if (!$this->db->table_exists('pool_questions') || !$this->db->field_exists('correct_answer', 'pool_questions')) {
            $this->session->set_flashdata('error', 'Correct answer column is missing. Please run the latest pool SQL query first.');
            redirect('admin/pool/' . (int) $poolId);
            return;
        }

        $questions = $this->getPoolQuestions($poolId);
        $submittedAnswers = $this->input->post('correct_answers');
        $submittedAnswers = is_array($submittedAnswers) ? $submittedAnswers : [];

        $this->db->trans_start();

        foreach ($questions as $question) {
            $questionId = (int) $question['id'];
            $answer = strtolower(trim((string) ($submittedAnswers[$questionId] ?? '')));

            if (!in_array($answer, $this->answerOptions, true)) {
                $answer = null;
            }

            $this->db->where('id', $questionId)->update('pool_questions', [
                'correct_answer' => $answer,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to save correct answers right now. Please try again.');
            redirect('admin/pool/' . (int) $poolId);
            return;
        }

        $this->session->set_flashdata('success', 'Correct answers updated successfully.');
        redirect('admin/pool/' . (int) $poolId);
    }
}
