<?php
$completionPercent = (int) round(((int) $saved_question_count / max(1, (int) $max_questions)) * 100);
$pageMode = $page_mode ?? 'view';
$isManageMode = $pageMode === 'manage';
$titleText = $isManageMode
    ? trim((string) (($match['team_home'] ?? '') . ' vs ' . ($match['team_away'] ?? '')))
    : ($pool['pool_name'] ?? 'Pool Questions');
$heroKicker = $isManageMode ? 'Match Questions Workspace' : 'Pool Questions Preview';
$heroDescription = $isManageMode
    ? 'Add and update one shared question set for this match. Every pool linked to this match will use the same questions and answer key.'
    : 'This pool uses the shared question set from its linked match. You can review the saved questions and final answer key here.';
$primaryBackUrl = $isManageMode ? base_url('admin/cricket_questions') : base_url('admin/pools');
$primaryBackLabel = $isManageMode ? 'All Matches' : 'All Pools';
?>

<style>
    .admin-pool-questions {
        --pq-bg: #f4f7fb;
        --pq-card: #ffffff;
        --pq-border: #dce5f0;
        --pq-text: #17324d;
        --pq-muted: #6d7f92;
        --pq-primary: #1f6feb;
        --pq-primary-dark: #173d67;
        --pq-accent: #35b7ff;
        --pq-success: #169b62;
        --pq-warning: #d18b00;
        background: linear-gradient(180deg, #f8fbff 0%, var(--pq-bg) 100%);
        min-height: calc(100vh - 70px);
        padding: 24px;
        border-radius: 28px;
    }

    .admin-pool-questions .question-hero {
        background: linear-gradient(135deg, #112d4e, #1f6feb 58%, #39b8ff);
        color: #fff;
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 20px 46px rgba(23, 61, 103, 0.2);
        position: relative;
        overflow: hidden;
    }

    .admin-pool-questions .question-hero::before,
    .admin-pool-questions .question-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .admin-pool-questions .question-hero::before {
        width: 220px;
        height: 220px;
        top: -90px;
        right: -80px;
    }

    .admin-pool-questions .question-hero::after {
        width: 160px;
        height: 160px;
        bottom: -70px;
        left: 28%;
    }

    .admin-pool-questions .hero-kicker,
    .admin-pool-questions .question-hero h3,
    .admin-pool-questions .question-hero p,
    .admin-pool-questions .hero-actions,
    .admin-pool-questions .hero-progress-card,
    .admin-pool-questions .hero-stat {
        position: relative;
        z-index: 1;
    }

    .admin-pool-questions .hero-kicker {
        text-transform: uppercase;
        letter-spacing: .14em;
        font-size: 12px;
        font-weight: 700;
        opacity: .82;
    }

    .admin-pool-questions .hero-actions .btn {
        border-radius: 14px;
        padding: 10px 14px;
        font-weight: 600;
    }

    .admin-pool-questions .hero-progress-card,
    .admin-pool-questions .hero-stat {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 20px;
        padding: 18px 20px;
        height: 100%;
        backdrop-filter: blur(6px);
    }

    .admin-pool-questions .hero-progress-card {
        min-height: 100%;
    }

    .admin-pool-questions .hero-stat-label,
    .admin-pool-questions .hero-progress-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        opacity: .82;
        margin-bottom: 6px;
    }

    .admin-pool-questions .hero-stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.1;
    }

    .admin-pool-questions .hero-progress-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .admin-pool-questions .hero-progress-value {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
    }

    .admin-pool-questions .hero-progress-bar {
        width: 100%;
        height: 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        overflow: hidden;
        margin-bottom: 10px;
    }

    .admin-pool-questions .hero-progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #d7f9ff, #ffffff);
    }

    .admin-pool-questions .content-panel {
        background: transparent;
    }

    .admin-pool-questions .workspace-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(360px, .95fr);
        gap: 22px;
        align-items: start;
    }

    .admin-pool-questions .section-card {
        background: var(--pq-card);
        border: 1px solid var(--pq-border);
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 12px 28px rgba(23, 50, 77, 0.06);
    }

    .admin-pool-questions .section-header {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .admin-pool-questions .section-title {
        color: var(--pq-text);
        font-weight: 800;
        margin-bottom: 4px;
    }

    .admin-pool-questions .section-subtitle {
        color: var(--pq-muted);
        font-size: 14px;
        margin-bottom: 0;
    }

    .admin-pool-questions .section-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 9px 12px;
        background: #eef5ff;
        color: var(--pq-primary);
        font-weight: 700;
        font-size: 12px;
        white-space: nowrap;
    }

    .admin-pool-questions .question-box {
        background: linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
        border: 1px solid #e3edf8;
        border-radius: 20px;
        padding: 18px;
        margin-bottom: 14px;
    }

    .admin-pool-questions .question-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--pq-text);
        font-weight: 700;
        margin-bottom: 12px;
    }

    .admin-pool-questions .question-index {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eaf2ff;
        color: var(--pq-primary);
        font-size: 13px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .admin-pool-questions .pool-question-input,
    .admin-pool-questions .form-select {
        border-radius: 14px;
        border: 1px solid var(--pq-border);
        min-height: 50px;
        box-shadow: none;
        background: #fff;
    }

    .admin-pool-questions .pool-question-input:focus,
    .admin-pool-questions .form-select:focus {
        border-color: var(--pq-primary);
        box-shadow: 0 0 0 4px rgba(31, 111, 235, 0.08);
    }

    .admin-pool-questions .pool-question-input {
        min-height: 92px;
        resize: vertical;
    }

    .admin-pool-questions .question-helper {
        color: var(--pq-muted);
        font-size: 12px;
        text-align: right;
        font-weight: 600;
        margin-top: 8px;
    }

    .admin-pool-questions .answer-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-height: 720px;
        overflow-y: auto;
        padding-right: 6px;
    }

    .admin-pool-questions .answer-card {
        background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid #e4edf7;
        border-radius: 20px;
        padding: 18px;
    }

    .admin-pool-questions .answer-card.active {
        border-color: #cddffd;
        box-shadow: 0 10px 18px rgba(31, 111, 235, 0.08);
    }

    .admin-pool-questions .answer-title {
        color: var(--pq-text);
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.55;
        font-size: 14px;
        word-break: break-word;
    }

    .admin-pool-questions .answer-card .form-select {
        min-height: 52px;
        font-weight: 600;
    }

    .admin-pool-questions .answer-panel-card {
        position: sticky;
        top: 24px;
    }

    .admin-pool-questions .answer-panel-footer {
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #e7eef8;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0), #fff 30%);
    }

    .admin-pool-questions .answer-empty {
        background: linear-gradient(135deg, #f9fbff, #eef5ff);
        border: 1px dashed #cfe0f8;
        border-radius: 18px;
        padding: 22px;
        color: var(--pq-muted);
    }

    .admin-pool-questions .submit-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .admin-pool-questions .submit-row .btn {
        border-radius: 14px;
        padding: 11px 16px;
        font-weight: 700;
    }

    .admin-pool-questions .helper-panel {
        margin-top: 22px;
        background: #fff;
        border: 1px solid var(--pq-border);
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 12px 28px rgba(23, 50, 77, 0.06);
    }

    .admin-pool-questions .helper-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .admin-pool-questions .helper-item {
        background: linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
        border: 1px solid #e3edf8;
        border-radius: 18px;
        padding: 16px;
    }

    .admin-pool-questions .helper-item h6 {
        margin-bottom: 6px;
        color: var(--pq-text);
        font-weight: 700;
    }

    .admin-pool-questions .helper-item p {
        margin-bottom: 0;
        color: var(--pq-muted);
        font-size: 13px;
        line-height: 1.55;
    }

    .admin-pool-questions .info-banner {
        border-radius: 18px;
        border: 1px solid #cfe1ff;
        background: linear-gradient(135deg, #eef5ff, #f8fbff);
        color: var(--pq-text);
        box-shadow: 0 10px 20px rgba(31, 111, 235, 0.05);
    }

    @media (max-width: 991.98px) {
        .admin-pool-questions .workspace-grid,
        .admin-pool-questions .helper-grid {
            grid-template-columns: 1fr;
        }

        .admin-pool-questions .answer-list {
            max-height: none;
            overflow: visible;
        }

        .admin-pool-questions .answer-panel-card {
            position: static;
        }
    }

    @media (max-width: 767.98px) {
        .admin-pool-questions {
            padding: 16px;
        }

        .admin-pool-questions .question-hero {
            padding: 22px;
        }

        .admin-pool-questions .hero-actions {
            width: 100%;
        }

        .admin-pool-questions .hero-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .admin-pool-questions .section-header {
            flex-direction: column;
            align-items: start;
        }

    }
</style>

<div class="page-wrapper p-4">
    <div class="page-content admin-pool-questions">
        <div class="question-hero mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="hero-kicker mb-2"><?= html_escape($heroKicker) ?></div>
                    <h3 class="mb-2 text-white"><?= html_escape($titleText) ?></h3>
                    <p class="mb-0 opacity-75"><?= html_escape($heroDescription) ?></p>
                </div>
                <div class="hero-actions d-flex gap-2 flex-wrap">
                    <?php if (!$isManageMode) : ?>
                        <a href="<?= base_url('admin/pool/leaderboard') ?>" class="btn btn-light">
                            <i class="bx bx-bar-chart-alt-2"></i> Global Leaderboard
                        </a>
                    <?php endif; ?>
                    <a href="<?= $primaryBackUrl ?>" class="btn btn-outline-light">
                        <i class="bx bx-arrow-back"></i> <?= html_escape($primaryBackLabel) ?>
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="hero-progress-card">
                        <div class="hero-progress-top">
                            <div>
                                <div class="hero-progress-label">Question Completion</div>
                                <div class="hero-progress-value"><?= (int) $completionPercent ?>%</div>
                            </div>
                            <div class="text-end">
                                <div class="small opacity-75"><?= $isManageMode ? 'Linked Pools' : 'Host' ?></div>
                                <div class="fw-bold"><?= $isManageMode ? (int) ($match['linked_pool_count'] ?? 0) : html_escape($pool['host_name']) ?></div>
                            </div>
                        </div>
                        <div class="hero-progress-bar">
                            <div class="hero-progress-fill" style="width: <?= (int) $completionPercent ?>%"></div>
                        </div>
                        <div class="small opacity-75"><?= (int) $saved_question_count ?> of <?= (int) $max_questions ?> questions saved</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="hero-stat">
                        <div class="hero-stat-label"><?= $isManageMode ? 'Competition' : 'Entry Price' ?></div>
                        <div class="hero-stat-value"><?= $isManageMode ? html_escape($match['competition_name'] ?: 'Match') : 'Rs. ' . number_format((float) $pool['price'], 2) ?></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="hero-stat">
                        <div class="hero-stat-label"><?= $isManageMode ? 'Match Date' : 'User Limit' ?></div>
                        <div class="hero-stat-value"><?= $isManageMode ? (!empty($match['start_at']) ? date('d M', strtotime($match['start_at'])) : 'N/A') : (int) $pool['user_limit'] ?></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Answer Key</div>
                        <div class="hero-stat-value"><?= !empty($questions) ? count($questions) : 0 ?> Ready</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-panel">
            <?php if (!$question_table_exists || !$answer_table_exists) : ?>
                <div class="alert alert-warning mb-4">
                   <i class="fas fa-exclamation-triangle"></i> Pool Questions Not Ready!
                </div>
            <?php endif; ?>

            <div class="workspace-grid">
                <div class="section-card">
                    <div class="section-header">
                        <div>
                            <h4 class="section-title"><?= $isManageMode ? 'Question Builder' : 'Questions' ?></h4>
                            <p class="section-subtitle"><?= $isManageMode ? 'These questions are shared for every pool connected to this same match. Add once here and all linked pools will use them.' : 'This pool can only view the shared match questions here. Editing is available from Cricket > Add Questions.' ?></p>
                        </div>
                        <span class="section-chip">
                            <i class="bx bx-layer"></i>
                            <?= (int) $max_questions ?> slots
                        </span>
                    </div>

                    <?php if ($isManageMode) : ?>
                        <form method="post" action="<?= base_url('admin/cricket_questions/' . (int) ($match['id'] ?? 0) . '/save_questions') ?>">
                            <?php for ($i = 0; $i < (int) $max_questions; $i++) : ?>
                                <?php $currentQuestion = (string) ($question_texts[$i] ?? ''); ?>
                                <div class="question-box">
                                    <label class="question-label" for="question_<?= $i ?>">
                                        <span class="question-index"><?= $i + 1 ?></span>
                                        <span>Question <?= $i + 1 ?></span>
                                    </label>
                                    <textarea
                                        id="question_<?= $i ?>"
                                        name="questions[]"
                                        class="form-control pool-question-input"
                                        rows="3"
                                        maxlength="255"
                                        placeholder="Type question <?= $i + 1 ?> here..."><?= html_escape($currentQuestion) ?></textarea>
                                    <div class="question-helper">
                                        <span class="question-char-count"><?= strlen($currentQuestion) ?></span>/255 characters
                                    </div>
                                </div>
                            <?php endfor; ?>

                            <div class="submit-row">
                                <small class="text-muted">Question order here will be used for players and answer checking.</small>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Save Questions
                                </button>
                            </div>
                        </form>
                    <?php else : ?>
                        <?php for ($i = 0; $i < (int) $max_questions; $i++) : ?>
                            <?php $currentQuestion = (string) ($question_texts[$i] ?? ''); ?>
                            <div class="question-box">
                                <label class="question-label">
                                    <span class="question-index"><?= $i + 1 ?></span>
                                    <span>Question <?= $i + 1 ?></span>
                                </label>
                                <textarea class="form-control pool-question-input" rows="3" readonly><?= html_escape($currentQuestion) ?></textarea>
                                <div class="question-helper">
                                    <?= trim($currentQuestion) !== '' ? 'Shared match question' : 'No question saved for this slot' ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>

                <div class="section-card answer-panel-card">
                    <div class="section-header">
                        <div>
                            <h4 class="section-title"><?= $isManageMode ? 'Answer Key Panel' : 'Answer Key' ?></h4>
                            <p class="section-subtitle"><?= $isManageMode ? 'This answer key is also shared match-wise, so all pools of the same match will use the same correct answers.' : 'Final answers are read-only here. To manage them, use Cricket > Add Questions.' ?></p>
                        </div>
                        <span class="section-chip">
                            <i class="bx bx-check-shield"></i>
                            <?= !empty($questions) ? count($questions) : 0 ?> saved
                        </span>
                    </div>

                    <?php if ($isManageMode) : ?>
                        <form method="post" action="<?= base_url('admin/cricket_questions/' . (int) ($match['id'] ?? 0) . '/save_answer_key') ?>">
                            <?php if (!empty($questions)) : ?>
                                <div class="answer-list">
                                    <?php foreach ($questions as $index => $question) : ?>
                                        <div class="answer-card <?= (($question['correct_answer'] ?? '') !== '') ? 'active' : '' ?>">
                                            <div class="answer-title">Q<?= $index + 1 ?>. <?= html_escape($question['question']) ?></div>
                                            <select name="correct_answers[<?= (int) $question['id'] ?>]" class="form-select">
                                                <option value="">Select later</option>
                                                <?php foreach ($answer_options as $option) : ?>
                                                    <option value="<?= $option ?>" <?= (($question['correct_answer'] ?? '') === $option) ? 'selected' : '' ?>>
                                                        <?= ucfirst($option) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="answer-empty">
                                    Add questions first, then the answer key panel will automatically populate here.
                                </div>
                            <?php endif; ?>

                            <div class="submit-row answer-panel-footer">
                                <small class="text-muted">Choose `Yes` or `No` only for the questions you want to finalize now.</small>
                                <button type="submit" class="btn btn-success" <?= empty($questions) ? 'disabled' : '' ?>>
                                    <i class="bx bx-check-circle"></i> Save Answer Key
                                </button>
                            </div>
                        </form>
                    <?php else : ?>
                        <?php if (!empty($questions)) : ?>
                            <div class="answer-list">
                                <?php foreach ($questions as $index => $question) : ?>
                                    <div class="answer-card <?= (($question['correct_answer'] ?? '') !== '') ? 'active' : '' ?>">
                                        <div class="answer-title">Q<?= $index + 1 ?>. <?= html_escape($question['question']) ?></div>
                                        <input type="text" class="form-control" value="<?= html_escape(($question['correct_answer'] ?? '') !== '' ? ucfirst($question['correct_answer']) : 'Not set') ?>" readonly>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <div class="answer-empty">
                                No shared match questions are available for this pool yet.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="helper-panel">
                <div class="section-header mb-3">
                    <div>
                        <h4 class="section-title mb-1">Quick Guide</h4>
                        <p class="section-subtitle">A cleaner workflow so you can finish each pool faster.</p>
                    </div>
                </div>
                <div class="helper-grid">
                    <div class="helper-item">
                        <h6>1. Draft Clearly</h6>
                        <p>Keep each question short and direct so users can answer quickly on mobile.</p>
                    </div>
                    <div class="helper-item">
                        <h6>2. Match-Based Flow</h6>
                        <p><?= $isManageMode ? 'Save the question list before setting answers. Only saved questions appear in the answer panel.' : 'Questions are controlled match-wise from Cricket > Add Questions, then automatically reused across linked pools.' ?></p>
                    </div>
                    <div class="helper-item">
                        <h6>3. Review With Confidence</h6>
                        <p><?= $isManageMode ? 'Use the single global leaderboard to review winners, users, and performance across all pools.' : 'This page is read-only for pools, so question editing stays centralized under the Cricket question manager.' ?></p>
                    </div>
                </div>
            </div>

            <div class="alert info-banner mt-4 mb-0">
                One combined leaderboard is available on a separate page for a cleaner experience.
                <a href="<?= base_url('admin/pool/leaderboard') ?>" class="fw-semibold text-decoration-none">Open Global Leaderboard</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputs = document.querySelectorAll('.pool-question-input');

        inputs.forEach(function(input) {
            var counter = input.parentElement.querySelector('.question-char-count');

            var updateCount = function() {
                if (input.value.length > 255) {
                    input.value = input.value.slice(0, 255);
                }

                if (counter) {
                    counter.textContent = input.value.length;
                }
            };

            input.addEventListener('input', updateCount);
            updateCount();
        });
    });
</script>
