<?php
$completionPercent = (int) round(((int) $summary['answered'] / max(1, (int) $summary['total'])) * 100);
?>

<style>
    .pool-question-page {
        --pp-bg: #f4f7fb;
        --pp-card: #ffffff;
        --pp-border: #dde6f2;
        --pp-text: #17324d;
        --pp-muted: #6d7f92;
        --pp-primary: #4e54c8;
        --pp-primary-light: #8f94fb;
        --pp-success: #1c9d68;
        --pp-success-soft: #e7f8f0;
        --pp-danger: #d84d4d;
        --pp-danger-soft: #fff1f0;
        --pp-warning: #d18b00;
        --pp-warning-soft: #fff6df;
        background: linear-gradient(180deg, #f8fbff 0%, var(--pp-bg) 100%);
        min-height: 100vh;
        padding: 28px 0 46px;
    }

    .pool-question-shell {
        max-width: 1120px;
        margin: 0 auto;
    }

    .pool-alert {
        border-radius: 18px;
        border: 1px solid transparent;
        box-shadow: 0 10px 18px rgba(23, 50, 77, 0.05);
        font-weight: 700;
    }

    .pool-play-hero {
        background: linear-gradient(135deg, #2b2f77, var(--pp-primary) 52%, var(--pp-primary-light));
        color: #fff;
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 22px 44px rgba(78, 84, 200, 0.22);
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .pool-play-hero::before,
    .pool-play-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .pool-play-hero::before {
        width: 240px;
        height: 240px;
        top: -90px;
        right: -80px;
    }

    .pool-play-hero::after {
        width: 180px;
        height: 180px;
        left: 28%;
        bottom: -80px;
    }

    .pool-play-hero>* {
        position: relative;
        z-index: 1;
    }

    .hero-kicker {
        text-transform: uppercase;
        letter-spacing: .14em;
        font-size: 12px;
        font-weight: 700;
        opacity: .78;
        margin-bottom: 10px;
    }

    .hero-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 22px;
    }

    .hero-title h2 {
        margin-bottom: 6px;
        font-size: 2rem;
        font-weight: 800;
    }

    .hero-title p {
        margin-bottom: 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 15px;
    }

    .hero-actions .btn {
        border-radius: 14px;
        padding: 10px 16px;
        font-weight: 700;
    }

    .hero-progress-card,
    .hero-stat {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 20px;
        padding: 18px 20px;
        height: 100%;
        backdrop-filter: blur(6px);
    }

    .hero-progress-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .hero-progress-label,
    .hero-stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        opacity: .82;
        margin-bottom: 6px;
    }

    .hero-progress-value,
    .hero-stat-value {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
    }

    .hero-progress-bar {
        width: 100%;
        height: 10px;
        border-radius: 999px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.16);
        margin-bottom: 10px;
    }

    .hero-progress-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #e9f2ff, #ffffff);
    }

    .pool-main-card {
        background: var(--pp-card);
        border: 1px solid var(--pp-border);
        border-radius: 28px;
        box-shadow: 0 16px 34px rgba(23, 50, 77, 0.07);
        padding: 24px;
    }

    .pool-question-block {
        border: 1px solid var(--pp-border);
        border-radius: 22px;
        padding: 20px;
        background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
        box-shadow: 0 10px 22px rgba(23, 50, 77, 0.04);
        margin-bottom: 18px;
    }

    .question-top {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 12px;
        margin-bottom: 16px;
    }

    .question-meta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--pp-primary);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .question-index {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef1ff;
        color: var(--pp-primary);
        font-weight: 800;
        font-size: 13px;
    }

    .question-text {
        font-size: 1.05rem;
        line-height: 1.55;
        color: var(--pp-text);
        font-weight: 700;
        margin-bottom: 0;
    }

    .pool-answer-badge {
        font-size: 12px;
        padding: 8px 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pool-question-option {
        border: 1px solid var(--pp-border);
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.22s ease;
        background: #fff;
        min-height: 64px;
    }

    .pool-question-option:hover {
        border-color: var(--pp-primary);
        background: #f8fbff;
        transform: translateY(-1px);
        box-shadow: 0 10px 18px rgba(78, 84, 200, 0.08);
    }

    .pool-question-option input {
        cursor: pointer;
    }

    .pool-question-option.selected {
        border-color: var(--pp-primary);
        background: #eef1ff;
        box-shadow: 0 10px 18px rgba(78, 84, 200, 0.08);
    }

    .pool-question-option.disabled {
        cursor: default;
        opacity: .92;
    }

    .pool-question-option.disabled:hover {
        transform: none;
    }

    .correct-answer-note {
        margin-top: 14px;
        background: #f7faff;
        border: 1px dashed #d9e6f7;
        border-radius: 14px;
        padding: 12px 14px;
        font-size: 13px;
        color: var(--pp-muted);
    }

    .submit-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #e9eff7;
    }

    .submit-area .btn {
        border-radius: 16px;
        padding: 12px 18px;
        font-weight: 700;
    }

    @media (max-width: 767.98px) {
        .pool-question-page {
            padding: 18px 0 34px;
        }

        .pool-play-hero,
        .pool-main-card {
            padding: 20px;
        }

        .hero-actions {
            width: 100%;
        }

        .hero-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .hero-title h2 {
            font-size: 1.6rem;
        }

        .question-top {
            flex-direction: column;
            align-items: start;
        }
    }
</style>

<div class="pool-question-page">
    <div class="container pool-question-shell">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success pool-alert"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger pool-alert"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($answers_locked)): ?>
            <div class="alert alert-info pool-alert">
                You already submitted your answers for this pool. Answers are locked now and cannot be changed.
            </div>
        <?php endif; ?>

        <div class="pool-play-hero">
            <div class="hero-summary">
                <div class="hero-title">
                    <div class="hero-kicker">Joined Pool</div>
                    <h2><?= html_escape($pool['pool_name']) ?></h2>
                    <p>Review your answers, track your score, and keep the full question set in one cleaner view.</p>
                </div>
                <div class="hero-actions">
                    <a href="<?= base_url('pool') ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i> Back To Pools
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-5">
                    <div class="hero-progress-card">
                        <div class="hero-progress-top">
                            <div>
                                <div class="hero-progress-label">Answer Progress</div>
                                <div class="hero-progress-value"><?= (int) $completionPercent ?>%</div>
                            </div>
                            <div class="text-end">
                                <div class="small opacity-75">Pool Status</div>
                                <div class="fw-bold"><?= !empty($answers_locked) ? 'Locked' : 'Open' ?></div>
                            </div>
                        </div>
                        <div class="hero-progress-bar">
                            <div class="hero-progress-fill" style="width: <?= (int) $completionPercent ?>%"></div>
                        </div>
                        <div class="small opacity-75"><?= (int) $summary['answered'] ?> of <?= (int) $summary['total'] ?> questions answered</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Total</div>
                        <div class="hero-stat-value"><?= (int) $summary['total'] ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Right</div>
                        <div class="hero-stat-value"><?= (int) $summary['right'] ?></div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Wrong</div>
                        <div class="hero-stat-value"><?= (int) $summary['wrong'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pool-main-card">
            <form method="post" action="<?= base_url('pool/play/' . (int) $pool['id'] . '/submit') ?>">
                <?php foreach ($questions as $index => $question) : ?>
                    <?php
                    $questionId = (int) $question['id'];
                    $savedAnswer = strtolower((string) ($user_answers[$questionId]['answer'] ?? ''));
                    $correctAnswer = strtolower((string) ($question['correct_answer'] ?? ''));
                    $statusClass = 'bg-secondary';
                    $statusLabel = 'Pending';
                    $statusIcon = 'fa-clock';

                    if ($savedAnswer !== '' && $correctAnswer !== '') {
                        if ($savedAnswer === $correctAnswer) {
                            $statusClass = 'bg-success';
                            $statusLabel = 'Right';
                            $statusIcon = 'fa-check';
                        } else {
                            $statusClass = 'bg-danger';
                            $statusLabel = 'Wrong';
                            $statusIcon = 'fa-xmark';
                        }
                    } elseif ($savedAnswer !== '') {
                        $statusClass = 'bg-warning text-dark';
                        $statusLabel = 'Submitted';
                        $statusIcon = 'fa-paper-plane';
                    }
                    ?>
                    <div class="pool-question-block">
                        <div class="question-top">
                            <div>
                                <div class="question-meta">
                                    <span class="question-index"><?= $index + 1 ?></span>
                                    <span>Question <?= $index + 1 ?></span>
                                </div>
                                <p class="question-text"><?= html_escape($question['question']) ?></p>
                            </div>
                            <span class="pool-answer-badge <?= $statusClass ?>">
                                <i class="fas <?= $statusIcon ?>"></i>
                                <?= $statusLabel ?>
                            </span>
                        </div>

                        <div class="row g-3">
                            <?php foreach ($answer_options as $option) : ?>
                                <?php
                                $isSelected = $savedAnswer === $option;
                                $optionClasses = 'pool-question-option w-100';
                                if ($isSelected) {
                                    $optionClasses .= ' selected';
                                }
                                if (!empty($answers_locked)) {
                                    $optionClasses .= ' disabled';
                                }
                                ?>
                                <div class="col-md-6">
                                    <label class="<?= $optionClasses ?>">
                                        <input
                                            type="radio"
                                            name="answers[<?= $questionId ?>]"
                                            value="<?= $option ?>"
                                            <?= $isSelected ? 'checked' : '' ?>
                                            <?= !empty($answers_locked) ? 'disabled' : '' ?>>
                                        <span class="fw-semibold"><?= ucfirst($option) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($correctAnswer !== '') : ?>
                            <div class="correct-answer-note">
                                Correct answer: <strong><?= ucfirst($correctAnswer) ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div class="submit-area">
                    <div class="text-muted">Select one answer per question before submitting.</div>
                    <?php if (empty($answers_locked)) : ?>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-1"></i> Submit Answers
                        </button>
                    <?php else : ?>
                        <button type="button" class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-lock me-1"></i> Answers Locked
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>