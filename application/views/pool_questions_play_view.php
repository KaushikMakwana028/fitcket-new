<style>
    .pool-question-page {
        background: #f4f7fb;
        min-height: 100vh;
        padding: 28px 0 40px;
    }

    .pool-question-shell {
        max-width: 980px;
        margin: 0 auto;
    }

    .pool-question-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        border: 1px solid #e8edf5;
    }

    .pool-question-option {
        border: 1px solid #dbe4f0;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .pool-question-option:hover {
        border-color: #0d6efd;
        background: #f8fbff;
    }

    .pool-answer-badge {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-block;
    }
</style>

<div class="pool-question-page">
    <div class="container pool-question-shell">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php if (!empty($answers_locked)): ?>
            <div class="alert alert-info">
                You already submitted your answers for this pool. Answers are locked now and cannot be changed.
            </div>
        <?php endif; ?>

        <div class="pool-question-card p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="mb-1"><?= html_escape($pool['pool_name']) ?></h2>
                    <div class="text-muted">Answer all questions for this joined pool.</div>
                </div>
                <a href="<?= base_url('pool') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back To Pools
                </a>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted small">Total Questions</div>
                        <div class="fw-bold fs-5"><?= (int) $summary['total'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted small">Answered</div>
                        <div class="fw-bold fs-5"><?= (int) $summary['answered'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted small">Right Answers</div>
                        <div class="fw-bold fs-5 text-success"><?= (int) $summary['right'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded p-3 h-100">
                        <div class="text-muted small">Wrong Answers</div>
                        <div class="fw-bold fs-5 text-danger"><?= (int) $summary['wrong'] ?></div>
                    </div>
                </div>
            </div>

            <form method="post" action="<?= base_url('pool/play/' . (int) $pool['id'] . '/submit') ?>">
                <?php foreach ($questions as $index => $question) : ?>
                    <?php
                    $questionId = (int) $question['id'];
                    $savedAnswer = strtolower((string) ($user_answers[$questionId]['answer'] ?? ''));
                    $correctAnswer = strtolower((string) ($question['correct_answer'] ?? ''));
                    $statusClass = 'secondary';
                    $statusLabel = 'Pending';

                    if ($savedAnswer !== '' && $correctAnswer !== '') {
                        if ($savedAnswer === $correctAnswer) {
                            $statusClass = 'success';
                            $statusLabel = 'Right';
                        } else {
                            $statusClass = 'danger';
                            $statusLabel = 'Wrong';
                        }
                    } elseif ($savedAnswer !== '') {
                        $statusClass = 'warning text-dark';
                        $statusLabel = 'Submitted';
                    }
                    ?>
                    <div class="border rounded-4 p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap mb-3">
                            <div>
                                <div class="text-primary fw-semibold mb-1">Question <?= $index + 1 ?></div>
                                <h5 class="mb-0"><?= html_escape($question['question']) ?></h5>
                            </div>
                            <span class="pool-answer-badge bg-<?= $statusClass ?>"><?= $statusLabel ?></span>
                        </div>

                        <div class="row g-3">
                            <?php foreach ($answer_options as $option) : ?>
                                <div class="col-md-6">
                                    <label class="pool-question-option w-100">
                                        <input
                                            type="radio"
                                            name="answers[<?= $questionId ?>]"
                                            value="<?= $option ?>"
                                            <?= $savedAnswer === $option ? 'checked' : '' ?>
                                            <?= !empty($answers_locked) ? 'disabled' : '' ?>>
                                        <span class="fw-semibold"><?= ucfirst($option) ?></span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($correctAnswer !== '') : ?>
                            <div class="mt-3 small text-muted">
                                Correct answer: <strong><?= ucfirst($correctAnswer) ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($answers_locked)) : ?>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-paper-plane me-1"></i> Submit Answers
                        </button>
                    </div>
                <?php else : ?>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary btn-lg px-4" disabled>
                            <i class="fas fa-lock me-1"></i> Answers Locked
                        </button>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
