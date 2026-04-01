<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Pool extends Admin_Controller
{
    private $maxQuestionsPerPool = 10;
    private $answerOptions = ['yes', 'no'];
    private $leaderboardPerPage = 10;
    private $poolListPerPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    private function prizeTablesReady()
    {
        return $this->db->table_exists('pool_prizes')
            && $this->db->table_exists('pool_prize_items')
            && $this->db->table_exists('pool_prize_logs');
    }

    private function transactionColumnExists($column)
    {
        return $this->db->field_exists($column, 'transactions');
    }

    private function getAdminId()
    {
        $admin = $this->session->userdata('admin');
        return (int) ($admin['id'] ?? 0);
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

    private function getPoolPrize($poolId)
    {
        if (!$this->prizeTablesReady()) {
            return null;
        }

        return $this->db
            ->where('pool_id', (int) $poolId)
            ->get('pool_prizes')
            ->row_array();
    }

    private function getPoolPrizeItems($prizeId)
    {
        if (!$this->prizeTablesReady() || (int) $prizeId <= 0) {
            return [];
        }

        return $this->db
            ->where('prize_id', (int) $prizeId)
            ->order_by('rank_no', 'ASC')
            ->get('pool_prize_items')
            ->result_array();
    }

    private function getPoolPrizeSummaryMap(array $poolIds)
    {
        if (!$this->prizeTablesReady() || empty($poolIds)) {
            return [];
        }

        $rows = $this->db
            ->select('pool_id, winner_count, status')
            ->where_in('pool_id', $poolIds)
            ->get('pool_prizes')
            ->result_array();

        $map = [];

        foreach ($rows as $row) {
            $map[(int) ($row['pool_id'] ?? 0)] = [
                'winner_count' => (int) ($row['winner_count'] ?? 0),
                'status' => (string) ($row['status'] ?? 'draft'),
            ];
        }

        return $map;
    }

    private function getPoolPrizeLogCount($prizeId)
    {
        if (!$this->prizeTablesReady() || (int) $prizeId <= 0) {
            return 0;
        }

        return (int) $this->db
            ->where('prize_id', (int) $prizeId)
            ->count_all_results('pool_prize_logs');
    }

    private function buildPoolPrizeLeaderboard($poolId)
    {
        $questions = $this->getPoolQuestions($poolId);
        $rows = $this->getPoolAnswerRows($poolId, $questions);

        $hasChecked = false;
        foreach ($rows as $row) {
            if ((int) ($row['summary']['checked'] ?? 0) > 0) {
                $hasChecked = true;
                break;
            }
        }

        return [
            'questions' => $questions,
            'rows' => $rows,
            'has_checked' => $hasChecked,
        ];
    }

    private function settlePoolPrize($poolId)
    {
        $summary = [
            'configured' => false,
            'winners' => 0,
            'credited' => 0,
        ];

        $prize = $this->getPoolPrize($poolId);
        if (!$prize) {
            return $summary;
        }

        $summary['configured'] = true;

        $winnerCount = (int) ($prize['winner_count'] ?? 0);
        if ($winnerCount <= 0) {
            return $summary;
        }

        $items = $this->getPoolPrizeItems((int) $prize['id']);
        if (count($items) < $winnerCount) {
            return $summary;
        }

        $leaderboard = $this->buildPoolPrizeLeaderboard($poolId);
        $poolUsers = $leaderboard['rows'];

        if (empty($poolUsers) || !$leaderboard['has_checked']) {
            return $summary;
        }

        $winners = array_slice($poolUsers, 0, min($winnerCount, count($poolUsers)));
        $summary['winners'] = count($winners);

        $itemsByRank = [];
        foreach ($items as $item) {
            $itemsByRank[(int) ($item['rank_no'] ?? 0)] = (float) ($item['amount'] ?? 0);
        }

        foreach ($winners as $index => $winner) {
            $rankNo = $index + 1;
            $amount = (float) ($itemsByRank[$rankNo] ?? 0);
            $userId = (int) ($winner['user_id'] ?? 0);

            if ($userId <= 0 || $amount <= 0) {
                continue;
            }

            $alreadyPaid = $this->db
                ->where('prize_id', (int) $prize['id'])
                ->where('pool_id', (int) $poolId)
                ->where('rank_no', $rankNo)
                ->where('status', 'success')
                ->get('pool_prize_logs')
                ->row_array();

            if ($alreadyPaid) {
                continue;
            }

            $wallet = $this->getOrCreateWallet($userId);
            if (!$wallet) {
                continue;
            }

            $transactionData = [
                'wallet_id' => (int) $wallet['id'],
                'type' => 'winning',
                'amount' => $amount,
                'status' => 'success',
                'pool_id' => (int) $poolId,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->transactionColumnExists('match_id')) {
                $transactionData['match_id'] = (int) ($prize['match_id'] ?? 0);
            }

            if ($this->transactionColumnExists('remark')) {
                $transactionData['remark'] = 'Pool rank prize #' . $rankNo;
            }

            if ($this->transactionColumnExists('description')) {
                $transactionData['description'] = 'Pool prize credited for rank #' . $rankNo;
            }

            $this->db->trans_start();

            $this->db->insert('transactions', $transactionData);
            $transactionId = (int) $this->db->insert_id();

            $this->db->set('balance', 'balance + ' . $amount, false)
                ->where('id', (int) $wallet['id'])
                ->update('wallets');

            $this->db->insert('pool_prize_logs', [
                'prize_id' => (int) $prize['id'],
                'pool_id' => (int) $poolId,
                'user_id' => $userId,
                'rank_no' => $rankNo,
                'amount' => $amount,
                'wallet_id' => (int) $wallet['id'],
                'transaction_id' => $transactionId,
                'status' => 'success',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status() !== false) {
                $summary['credited']++;
            }
        }

        $updateData = [
            'status' => $summary['credited'] > 0 ? 'settled' : (string) ($prize['status'] ?? 'active'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($summary['credited'] > 0) {
            $updateData['settled_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('id', (int) $prize['id'])->update('pool_prizes', $updateData);

        return $summary;
    }

    private function poolQuestionsUseMatchId()
    {
        return $this->db->table_exists('pool_questions')
            && $this->db->field_exists('match_id', 'pool_questions');
    }

    private function poolAnswersUseMatchId()
    {
        return $this->db->table_exists('pool_question_answers')
            && $this->db->field_exists('match_id', 'pool_question_answers');
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

    private function getQuestionCountSelect()
    {
        if (!$this->db->table_exists('pool_questions')) {
            return '0 as question_count';
        }

        if ($this->poolQuestionsUseMatchId()) {
            return '(
                SELECT COUNT(*)
                FROM pool_questions
                WHERE pool_questions.match_id = pools.match_id
            ) as question_count';
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

    private function getDefaultPoolIdForMatch($matchId)
    {
        if (!$this->db->table_exists('pools') || (int) $matchId <= 0) {
            return 0;
        }

        $pool = $this->db
            ->select('id')
            ->from('pools')
            ->where('match_id', (int) $matchId)
            ->order_by('id', 'ASC')
            ->get()
            ->row_array();

        return (int) ($pool['id'] ?? 0);
    }

    private function ensureQuestionAnchorPoolForMatch($matchId)
    {
        $existingPoolId = $this->getDefaultPoolIdForMatch($matchId);
        if ($existingPoolId > 0) {
            return $existingPoolId;
        }

        if (!$this->db->table_exists('pools') || !$this->db->table_exists('cricket_matches')) {
            return 0;
        }

        $match = $this->db
            ->select('id, team_home, team_away, start_at')
            ->from('cricket_matches')
            ->where('id', (int) $matchId)
            ->get()
            ->row_array();

        if (!$match) {
            return 0;
        }

        $adminId = (int) ($this->admin['id'] ?? 0);
        $matchStartAt = !empty($match['start_at']) ? $match['start_at'] : null;
        $joinCloseAt = $matchStartAt ? date('Y-m-d H:i:s', strtotime($matchStartAt . ' -30 minutes')) : null;

        $payload = [
            'user_id' => $adminId > 0 ? $adminId : 1,
            'match_id' => (int) $matchId,
            'pool_name' => trim((string) (($match['team_home'] ?? 'Team A') . ' vs ' . ($match['team_away'] ?? 'Team B'))) . ' Question Anchor',
            'description' => 'Auto-created hidden pool for shared cricket match questions.',
            'user_limit' => 0,
            'price' => 0,
            'match_start_at' => $matchStartAt,
            'join_close_at' => $joinCloseAt,
            'isActive' => 0,
            'total_joined' => 0,
        ];

        $this->db->insert('pools', $payload);

        return (int) $this->db->insert_id();
    }

    private function getQuestionCountForMatch($matchId)
    {
        if (!$this->db->table_exists('pool_questions') || (int) $matchId <= 0) {
            return 0;
        }

        $builder = $this->db->from('pool_questions');

        if ($this->poolQuestionsUseMatchId()) {
            $builder->where('match_id', (int) $matchId);
        } else {
            $defaultPoolId = $this->getDefaultPoolIdForMatch($matchId);

            if ($defaultPoolId <= 0) {
                return 0;
            }

            $builder->where('pool_id', $defaultPoolId);
        }

        return (int) $builder->count_all_results();
    }

    private function getQuestionsByMatchId($matchId)
    {
        if (!$this->db->table_exists('pool_questions') || (int) $matchId <= 0) {
            return [];
        }

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

        if ($this->poolQuestionsUseMatchId()) {
            $builder->where('pool_questions.match_id', (int) $matchId);
        } else {
            $defaultPoolId = $this->getDefaultPoolIdForMatch($matchId);

            if ($defaultPoolId <= 0) {
                return [];
            }

            $builder->where('pool_questions.pool_id', $defaultPoolId);
        }

        return $builder
            ->order_by('pool_questions.position', 'ASC')
            ->order_by('pool_questions.id', 'ASC')
            ->get()
            ->result_array();
    }

    private function getMatchQuestionTextSlots(array $questions)
    {
        $questionTexts = array_fill(0, $this->maxQuestionsPerPool, '');

        foreach ($questions as $index => $question) {
            if ($index < $this->maxQuestionsPerPool) {
                $questionTexts[$index] = $question['question'];
            }
        }

        return $questionTexts;
    }

    private function getQuestionWorkspaceData(array $questions)
    {
        $questionTexts = $this->getMatchQuestionTextSlots($questions);

        return [
            'question_texts' => $questionTexts,
            'saved_question_count' => count(array_filter($questionTexts, function ($question) {
                return trim((string) $question) !== '';
            })),
        ];
    }

    private function getMatchWithMeta($matchId)
    {
        return $this->db
            ->select("
                cricket_matches.*,
                COUNT(DISTINCT pools.id) as linked_pool_count
            ", false)
            ->from('cricket_matches')
            ->join('pools', 'pools.match_id = cricket_matches.id', 'left')
            ->where('cricket_matches.id', (int) $matchId)
            ->group_by('cricket_matches.id')
            ->get()
            ->row_array();
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
                'team_home' => $row['team_home'] ?? '',
                'team_away' => $row['team_away'] ?? '',
                'match_time' => $row['match_time'] ?? '',
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

    COALESCE(host_users.name, 'Host') as host_name,

    IFNULL(cricket_matches.team_home, '') as team_home,
    IFNULL(cricket_matches.team_away, '') as team_away,
    IFNULL(cricket_matches.start_at, '') as match_time
", false)
            ->from('pool_question_answers')
            ->join('users', 'users.id = pool_question_answers.user_id', 'left')
            ->join('pools', 'pools.id = pool_question_answers.pool_id', 'left')
            ->join('cricket_matches', 'cricket_matches.id = pools.match_id', 'left')
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

                    // 🔥 ADD THIS (IMPORTANT FIX)
                    'team_home' => $answerRow['team_home'] ?? '',
                    'team_away' => $answerRow['team_away'] ?? '',
                    'match_time' => !empty($answerRow['match_time']) ? $answerRow['match_time'] : null,

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
            $rows[] = array_merge($groupedRow, [
                'summary' => $summary,

                // 🔥 FORCE INCLUDE (FINAL FIX)
                'team_home' => $groupedRow['team_home'] ?? '',
                'team_away' => $groupedRow['team_away'] ?? '',
                'match_time' => $groupedRow['match_time'] ?? '',
            ]);
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

    public function declare_winner($poolId)
    {
        $pool = $this->db->where('id', $poolId)->get('pools')->row_array();
        if (!$pool) return;

        $totalJoined = (int)($pool['total_joined'] ?? 0);

        // 🚨 ONLY 1 PLAYER OR LESS → REFUND
        if ($totalJoined <= 1) {
            $refundAmount = (float)($pool['price'] ?? 0);

            if ($refundAmount > 0) {
                // Refund anyone who joined (even if they didn't answer)
                $joinedUsers = $this->db->where('pool_id', $poolId)->where('status', 'success')->get('pool_joins')->result_array();

                foreach ($joinedUsers as $user) {
                    $userId = (int)$user['user_id'];
                    $wallet = $this->getOrCreateWallet($userId);

                    if ($wallet) {
                        $alreadyRefunded = $this->db
                            ->where('wallet_id', $wallet['id'])
                            ->where('pool_id', $poolId)
                            ->where('type', 'refund')
                            ->where('status', 'success')
                            ->get('transactions')
                            ->row_array();

                        if (!$alreadyRefunded) {
                            $this->db->trans_start();

                            $this->db->set('balance', 'balance + ' . $refundAmount, false)
                                ->where('id', $wallet['id'])
                                ->update('wallets');

                            $this->db->insert('transactions', [
                                'wallet_id' => $wallet['id'],
                                'type' => 'refund',
                                'amount' => $refundAmount,
                                'status' => 'success',
                                'pool_id' => $poolId,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);

                            $this->db->trans_complete();
                        }
                    }
                }
            }

            // 🔥 mark refunded
            $this->db->where('id', $poolId)->update('pools', [
                'is_refunded' => 1
            ]);

            return;
        }

        // 🔥 GET USERS OF THIS POOL
        $rows = $this->getAllPoolAnswerRows();

        $poolUsers = array_values(array_filter($rows, function ($r) use ($poolId) {
            return isset($r['pool_id']) && (int)$r['pool_id'] === (int)$poolId;
        }));

        if (empty($poolUsers)) return;

        // 🔥 SORT USERS
        usort($poolUsers, function ($a, $b) {
            $aRight = $a['summary']['right'] ?? 0;
            $bRight = $b['summary']['right'] ?? 0;

            if ($bRight === $aRight) {
                return ($a['summary']['wrong'] ?? 0) <=> ($b['summary']['wrong'] ?? 0);
            }

            return $bRight <=> $aRight;
        });

        $topScore = $poolUsers[0]['summary']['right'] ?? 0;

        // 🔥 CHECK ANSWERS
        $hasChecked = false;
        foreach ($poolUsers as $u) {
            if (($u['summary']['checked'] ?? 0) > 0) {
                $hasChecked = true;
                break;
            }
        }

        if (!$hasChecked) return;

        // 🔥 WINNERS
        $winners = array_filter($poolUsers, function ($u) use ($topScore) {
            return ($u['summary']['right'] ?? 0) === $topScore;
        });

        if (empty($winners)) return;

        if (empty($pool['price'])) return;

        $totalPrize = (float)$pool['price'] * $totalJoined;
        $winningAmount = $totalPrize / count($winners);

        if ($winningAmount <= 0) return;

        foreach ($winners as $winner) {

            $userId = (int)$winner['user_id'];
            $wallet = $this->getOrCreateWallet($userId);

            if (!$wallet) continue;

            $alreadyPaid = $this->db
                ->where('wallet_id', $wallet['id'])
                ->where('pool_id', $poolId)
                ->where('type', 'winning')
                ->where('status', 'success')
                ->get('transactions')
                ->row_array();

            if ($alreadyPaid) continue;

            $this->db->trans_start();

            $this->db->set('balance', 'balance + ' . $winningAmount, false)
                ->where('id', $wallet['id'])
                ->update('wallets');

            $this->db->insert('transactions', [
                'wallet_id' => $wallet['id'],
                'type' => 'winning',
                'amount' => $winningAmount,
                'status' => 'success',
                'pool_id' => $poolId,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $this->db->trans_complete();
        }
    }
    
    public function test_winner($poolId)
    {
        $summary = $this->declare_winner($poolId);
        echo "Winner settlement completed for Pool ID: " . $poolId . ' | credited: ' . (int) ($summary['credited'] ?? 0);
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
        $allPools = $this->db
            ->select("
            pools.*,
            COALESCE(users.name, 'Host') as host_name,
            cricket_matches.team_home,
            cricket_matches.team_away,
            cricket_matches.start_at as match_time,
            {$this->getQuestionCountSelect()},
            {$this->getAnswerCountSelect()}
        ", false)
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')

            // 🔥 IMPORTANT (NEW)
            ->join('cricket_matches', 'cricket_matches.id = pools.match_id', 'left')

            ->order_by('pools.id', 'DESC')
            ->get()
            ->result_array();

        $currentPage = max(1, (int) $this->input->get('page'));
        $perPage = $this->poolListPerPage;
        $totalPools = count($allPools);
        $totalPages = max(1, (int) ceil($totalPools / $perPage));

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $perPage;

        $data['all_pools'] = $allPools;
        $data['pools'] = array_slice($allPools, $offset, $perPage);
        $data['pool_total_count'] = $totalPools;
        $data['pool_current_page'] = $currentPage;
        $data['pool_total_pages'] = $totalPages;
        $data['pool_per_page'] = $perPage;
        $data['pool_prize_map'] = $this->getPoolPrizeSummaryMap(array_column($data['pools'], 'id'));
        $data['max_questions'] = $this->maxQuestionsPerPool;

        $this->load->view('admin/header');
        $this->load->view('admin/pool_list_view', $data);
        $this->load->view('admin/footer');
    }

    public function prize($poolId = 0)
    {
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('admin/pools');
            return;
        }

        if (!$this->prizeTablesReady()) {
            $this->session->set_flashdata('error', 'Please create the pool prize tables first using the provided SQL query.');
            redirect('admin/pools');
            return;
        }

        $prize = $this->getPoolPrize($poolId);
        $items = $prize ? $this->getPoolPrizeItems((int) $prize['id']) : [];
        $itemAmounts = [];

        foreach ($items as $item) {
            $itemAmounts[(int) ($item['rank_no'] ?? 0)] = (float) ($item['amount'] ?? 0);
        }

        $leaderboard = $this->buildPoolPrizeLeaderboard($poolId);

        $data['pool'] = $pool;
        $data['prize'] = $prize;
        $data['prize_amounts'] = $itemAmounts;
        $data['prize_log_count'] = $prize ? $this->getPoolPrizeLogCount((int) $prize['id']) : 0;
        $data['prize_preview_rows'] = array_slice($leaderboard['rows'], 0, 10);
        $data['prize_has_checked'] = $leaderboard['has_checked'];

        $this->load->view('admin/header');
        $this->load->view('admin/pool_prize_view', $data);
        $this->load->view('admin/footer');
    }

    public function save_prize($poolId = 0)
    {
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found.');
            redirect('admin/pools');
            return;
        }

        if (!$this->prizeTablesReady()) {
            $this->session->set_flashdata('error', 'Please create the pool prize tables first using the provided SQL query.');
            redirect('admin/pools');
            return;
        }

        $winnerCount = (int) $this->input->post('winner_count');
        $postedAmounts = $this->input->post('amounts');
        $postedAmounts = is_array($postedAmounts) ? $postedAmounts : [];

        if ($winnerCount <= 0) {
            $this->session->set_flashdata('error', 'Please enter a valid winner count.');
            redirect('admin/pool/prize/' . (int) $poolId);
            return;
        }

        $amountRows = [];

        for ($rankNo = 1; $rankNo <= $winnerCount; $rankNo++) {
            $amount = (float) ($postedAmounts[$rankNo] ?? 0);

            if ($amount <= 0) {
                $this->session->set_flashdata('error', 'Please enter a valid amount for rank #' . $rankNo . '.');
                redirect('admin/pool/prize/' . (int) $poolId);
                return;
            }

            $amountRows[$rankNo] = $amount;
        }

        $existingPrize = $this->getPoolPrize($poolId);
        if ($existingPrize && $this->getPoolPrizeLogCount((int) $existingPrize['id']) > 0) {
            $this->session->set_flashdata('error', 'Prize setup cannot be changed after winner amount is already credited.');
            redirect('admin/pool/prize/' . (int) $poolId);
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $this->db->trans_start();

        if ($existingPrize) {
            $prizeId = (int) $existingPrize['id'];
            $this->db->where('id', $prizeId)->update('pool_prizes', [
                'winner_count' => $winnerCount,
                'status' => 'active',
                'updated_at' => $timestamp,
                'settled_at' => null,
            ]);

            $this->db->where('prize_id', $prizeId)->delete('pool_prize_items');
        } else {
            $this->db->insert('pool_prizes', [
                'pool_id' => (int) $poolId,
                'match_id' => (int) ($pool['match_id'] ?? 0),
                'winner_count' => $winnerCount,
                'status' => 'active',
                'created_by' => $this->getAdminId(),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
            $prizeId = (int) $this->db->insert_id();
        }

        foreach ($amountRows as $rankNo => $amount) {
            $this->db->insert('pool_prize_items', [
                'prize_id' => $prizeId,
                'rank_no' => (int) $rankNo,
                'amount' => $amount,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Unable to save winner amount right now. Please try again.');
            redirect('admin/pool/prize/' . (int) $poolId);
            return;
        }

        $this->session->set_flashdata('success', 'Winner amount setup saved successfully. Wallet credit will happen after answer key is saved.');
        redirect('admin/pool/prize/' . (int) $poolId);
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

        $workspaceData = $this->getQuestionWorkspaceData($questions);

        $data['pool'] = $pool;
        $data['question_texts'] = $workspaceData['question_texts'];
        $data['saved_question_count'] = $workspaceData['saved_question_count'];
        $data['max_questions'] = $this->maxQuestionsPerPool;
        $data['question_table_exists'] = $this->db->table_exists('pool_questions');
        $data['answer_table_exists'] = $this->db->table_exists('pool_question_answers');
        $data['answer_options'] = $this->answerOptions;
        $data['questions'] = $questions;
        $data['answer_rows'] = $this->getPoolAnswerRows($poolId, $questions);
        $data['leaderboard'] = $this->buildLeaderboard($data['answer_rows']);
        $data['page_mode'] = 'view';
        $data['match'] = null;

        $this->load->view('admin/header');
        $this->load->view('admin/pool_questions_view', $data);
        $this->load->view('admin/footer');
    }

    public function question_matches()
    {
        $matches = $this->db
            ->select("
                cricket_matches.*,
                COUNT(DISTINCT pools.id) as linked_pool_count
            ", false)
            ->from('cricket_matches')
            ->join('pools', 'pools.match_id = cricket_matches.id', 'left')
            ->group_by('cricket_matches.id')
            ->order_by('cricket_matches.start_at', 'DESC')
            ->get()
            ->result_array();

        foreach ($matches as &$match) {
            $match['question_count'] = $this->getQuestionCountForMatch((int) $match['id']);
        }
        unset($match);

        $data['matches'] = $matches;
        $data['max_questions'] = $this->maxQuestionsPerPool;

        $this->load->view('admin/header');
        $this->load->view('admin/cricket_question_matches_view', $data);
        $this->load->view('admin/footer');
    }

    public function match_questions($matchId = 0)
    {
        $match = $this->getMatchWithMeta($matchId);

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_questions');
            return;
        }

        $questions = $this->getQuestionsByMatchId($matchId);
        $workspaceData = $this->getQuestionWorkspaceData($questions);

        $data['pool'] = [
            'pool_name' => trim((string) ($match['team_home'] ?? '')) . ' vs ' . trim((string) ($match['team_away'] ?? '')),
            'host_name' => 'Match Based',
            'price' => 0,
            'user_limit' => (int) ($match['linked_pool_count'] ?? 0),
            'id' => 0,
        ];
        $data['match'] = $match;
        $data['question_texts'] = $workspaceData['question_texts'];
        $data['saved_question_count'] = $workspaceData['saved_question_count'];
        $data['max_questions'] = $this->maxQuestionsPerPool;
        $data['question_table_exists'] = $this->db->table_exists('pool_questions');
        $data['answer_table_exists'] = $this->db->table_exists('pool_question_answers');
        $data['answer_options'] = $this->answerOptions;
        $data['questions'] = $questions;
        $data['answer_rows'] = [];
        $data['leaderboard'] = [];
        $data['page_mode'] = 'manage';

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
        // 🔥 AUTO DECLARE WINNER FOR EACH POOL
        // $uniquePools = array_unique(array_column($leaderboard, 'pool_id'));

        // foreach ($uniquePools as $pid) {
        //     if ($pid > 0) {
        //         $this->declare_winner($pid);
        //     }
        // }
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
        $context = $this->getPoolQuestionContext($poolId);

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
                if ($this->poolQuestionsUseMatchId()) {
                    $payload['match_id'] = (int) $context['match_id'];
                }
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

        $settlement = $this->declare_winner($poolId);
        $message = 'Correct answers updated successfully.';

        if (!(bool) ($settlement['configured'] ?? false)) {
            $message .= ' Prize amount is not set for this pool yet.';
        } elseif ((int) ($settlement['credited'] ?? 0) > 0) {
            $message .= ' Winner amount credited to ' . (int) ($settlement['credited'] ?? 0) . ' user wallet(s).';
        } else {
            $message .= ' Winner amount setup is ready, but no new wallet credit was made.';
        }

        $this->session->set_flashdata('success', $message);
        redirect('admin/pool/' . (int) $poolId);
    }

    public function save_match_questions($matchId = 0)
    {
        $match = $this->getMatchWithMeta($matchId);

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_questions');
            return;
        }

        if (!$this->db->table_exists('pool_questions')) {
            $this->session->set_flashdata('error', 'Please create the pool_questions table first using the provided SQL query.');
            redirect('admin/cricket_questions/' . (int) $matchId);
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
            $this->session->set_flashdata('error', 'You can add only ' . $this->maxQuestionsPerPool . ' questions in one match.');
            redirect('admin/cricket_questions/' . (int) $matchId);
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $existingQuestions = $this->getQuestionsByMatchId($matchId);
        $defaultPoolId = $this->ensureQuestionAnchorPoolForMatch($matchId);

        if ($defaultPoolId <= 0) {
            $this->session->set_flashdata('error', 'Unable to create a question anchor pool for this match right now.');
            redirect('admin/cricket_questions/' . (int) $matchId);
            return;
        }

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
                $payload['pool_id'] = $defaultPoolId;
                if ($this->poolQuestionsUseMatchId()) {
                    $payload['match_id'] = (int) $matchId;
                }
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
            $this->session->set_flashdata('error', 'Unable to save match questions right now. Please try again.');
            redirect('admin/cricket_questions/' . (int) $matchId);
            return;
        }

        $this->session->set_flashdata('success', 'Match questions saved successfully.');
        redirect('admin/cricket_questions/' . (int) $matchId);
    }

    public function save_match_answer_key($matchId = 0)
    {
        $match = $this->getMatchWithMeta($matchId);

        if (!$match) {
            $this->session->set_flashdata('error', 'Match not found.');
            redirect('admin/cricket_questions');
            return;
        }

        if (!$this->db->table_exists('pool_questions') || !$this->db->field_exists('correct_answer', 'pool_questions')) {
            $this->session->set_flashdata('error', 'Correct answer column is missing. Please run the latest pool SQL query first.');
            redirect('admin/cricket_questions/' . (int) $matchId);
            return;
        }

        $questions = $this->getQuestionsByMatchId($matchId);
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
            $this->session->set_flashdata('error', 'Unable to save match answer key right now. Please try again.');
            redirect('admin/cricket_questions/' . (int) $matchId);
            return;
        }

        $poolIds = $this->db
            ->select('id')
            ->from('pools')
            ->where('match_id', (int) $matchId)
            ->get()
            ->result_array();

        $configuredPools = 0;
        $creditedCount = 0;

        foreach ($poolIds as $poolRow) {
            $settlement = $this->declare_winner((int) $poolRow['id']);
            if ((bool) ($settlement['configured'] ?? false)) {
                $configuredPools++;
            }
            $creditedCount += (int) ($settlement['credited'] ?? 0);
        }

        $message = 'Match answer key updated successfully.';
        if ($configuredPools === 0) {
            $message .= ' No pool prize setup found yet.';
        } elseif ($creditedCount > 0) {
            $message .= ' Winner amount credited to ' . $creditedCount . ' user wallet(s).';
        } else {
            $message .= ' Prize setup is ready, but no new wallet credit was made.';
        }

        $this->session->set_flashdata('success', $message);
        redirect('admin/cricket_questions/' . (int) $matchId);
    }

    public function users($poolId = 0)
    {
        if ((int)$poolId <= 0) {
            redirect('admin/pools');
            return;
        }

        // 🔥 Get pool info
        $pool = $this->db
            ->select('pools.*, users.name as host_name')
            ->from('pools')
            ->join('users', 'users.id = pools.user_id', 'left')
            ->where('pools.id', (int)$poolId)
            ->get()
            ->row_array();

        if (!$pool) {
            $this->session->set_flashdata('error', 'Pool not found');
            redirect('admin/pools');
            return;
        }

        // 🔥 Get users who joined this pool
        $users = $this->db
            ->select('users.id, users.name, users.email, users.mobile')
            ->from('pool_question_answers')
            ->join('users', 'users.id = pool_question_answers.user_id', 'left')
            ->where('pool_question_answers.pool_id', (int)$poolId)
            ->group_by('users.id')
            ->order_by('users.name', 'ASC')
            ->get()
            ->result_array();

        $data['pool'] = $pool;
        $data['users'] = $users;

        $this->load->view('admin/header');
        $this->load->view('admin/pool_users_view', $data);
        $this->load->view('admin/footer');
    }

    public function edit_user_answers($poolId = 0, $userId = 0)
    {
        if ($poolId <= 0 || $userId <= 0) {
            redirect('admin/pools');
            return;
        }

        // 🔥 Pool
        $pool = $this->getPoolWithMeta($poolId);

        if (!$pool) {
            redirect('admin/pools');
            return;
        }

        // 🔥 Questions
        $questions = $this->getPoolQuestions($poolId);

        // 🔥 User answers (same like Cricket.php logic)
        $answers = $this->db
            ->where('pool_id', $poolId)
            ->where('user_id', $userId)
            ->get('pool_question_answers')
            ->result_array();

        $answersMap = [];
        foreach ($answers as $a) {
            $answersMap[$a['pool_question_id']] = $a;
        }

        $user = $this->db->where('id', $userId)->get('users')->row_array();

        $data['pool'] = $pool;
        $data['questions'] = $questions;
        $data['answers'] = $answersMap;
        $data['user'] = $user;
        $data['answer_options'] = ['yes', 'no'];

        $this->load->view('admin/header');
        $this->load->view('admin/edit_user_answers_view', $data);
        $this->load->view('admin/footer');
    }

    public function update_user_answers()
    {
        $poolId = (int)$this->input->post('pool_id');
        $userId = (int)$this->input->post('user_id');
        $answers = $this->input->post('answers');

        if (!$poolId || !$userId) {
            redirect('admin/pools');
            return;
        }

        $questions = $this->getPoolQuestions($poolId);

        $timestamp = date('Y-m-d H:i:s');

        $this->db->trans_start();

        foreach ($questions as $q) {

            $qid = (int)$q['id'];
            $answer = strtolower(trim($answers[$qid] ?? ''));

            if (!in_array($answer, ['yes', 'no'])) {
                continue;
            }

            // 🔥 check exist
            $existing = $this->db
                ->where('pool_id', $poolId)
                ->where('user_id', $userId)
                ->where('pool_question_id', $qid)
                ->get('pool_question_answers')
                ->row_array();

            if ($existing) {
                // UPDATE
                $this->db->where('id', $existing['id'])->update('pool_question_answers', [
                    'answer' => $answer,
                    'updated_at' => $timestamp
                ]);
            } else {
                // INSERT
                $this->db->insert('pool_question_answers', [
                    'pool_id' => $poolId,
                    'user_id' => $userId,
                    'pool_question_id' => $qid,
                    'answer' => $answer,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ]);
            }
        }

        $this->db->trans_complete();

        // 🔥 OPTIONAL: Recalculate winner
        $this->declare_winner($poolId);

        $this->session->set_flashdata('success', 'User answers updated successfully');

        redirect('admin/pool/users/' . $poolId);
    }
}
