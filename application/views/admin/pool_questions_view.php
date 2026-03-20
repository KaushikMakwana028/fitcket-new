<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="mb-0">Pool Questions</h5>
                    <small class="text-muted">
                        <?= html_escape($pool['pool_name']) ?> by <?= html_escape($pool['host_name']) ?>
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/pool/' . (int) $pool['id'] . '/leaderboard') ?>" class="btn btn-dark btn-sm">
                        <i class="bx bx-bar-chart-alt-2"></i> View Leaderboard
                    </a>
                    <a href="<?= base_url('admin/pools') ?>" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back To Pools
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small mb-1">Entry Price</div>
                            <div class="fw-bold">Rs. <?= number_format((float) $pool['price'], 2) ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small mb-1">User Limit</div>
                            <div class="fw-bold"><?= (int) $pool['user_limit'] ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 h-100">
                            <div class="text-muted small mb-1">Saved Questions</div>
                            <div class="fw-bold"><?= (int) $saved_question_count ?>/<?= (int) $max_questions ?></div>
                        </div>
                    </div>
                </div>

                <?php if (!$question_table_exists || !$answer_table_exists) : ?>
                    <div class="alert alert-warning">
                        Run the latest SQL from `database/pool_questions.sql` first. This feature needs both `pool_questions` and `pool_question_answers` tables.
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="border rounded p-3 h-100">
                            <h6 class="mb-3">Edit Questions</h6>
                            <form method="post" action="<?= base_url('admin/pool/' . (int) $pool['id'] . '/save_questions') ?>">
                                <div class="row">
                                    <?php for ($i = 0; $i < (int) $max_questions; $i++) : ?>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-semibold">Question <?= $i + 1 ?></label>
                                            <textarea
                                                name="questions[]"
                                                class="form-control pool-question-input"
                                                rows="2"
                                                maxlength="255"
                                                placeholder="Enter question <?= $i + 1 ?>"><?= html_escape($question_texts[$i] ?? '') ?></textarea>
                                        </div>
                                    <?php endfor; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <small class="text-muted">You can keep maximum <?= (int) $max_questions ?> questions in this pool.</small>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save"></i> Save Questions
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="border rounded p-3 h-100">
                            <h6 class="mb-3">Correct Answer Key</h6>
                            <form method="post" action="<?= base_url('admin/pool/' . (int) $pool['id'] . '/save_answer_key') ?>">
                                <?php if (!empty($questions)) : ?>
                                    <?php foreach ($questions as $index => $question) : ?>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Q<?= $index + 1 ?>. <?= html_escape($question['question']) ?>
                                            </label>
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
                                <?php else : ?>
                                    <div class="alert alert-light border mb-0">Add questions first, then set the correct answer as Yes or No whenever you want.</div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" <?= empty($questions) ? 'disabled' : '' ?>>
                                        <i class="bx bx-check-circle"></i> Save Answer Key
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0">
                    Leaderboard is now on a separate page for a cleaner view.
                    <a href="<?= base_url('admin/pool/' . (int) $pool['id'] . '/leaderboard') ?>" class="fw-semibold text-decoration-none">Open Pool Leaderboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputs = document.querySelectorAll('.pool-question-input');

        inputs.forEach(function(input) {
            input.addEventListener('input', function() {
                if (this.value.length > 255) {
                    this.value = this.value.slice(0, 255);
                }
            });
        });
    });
</script>
