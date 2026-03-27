<?php
$matchCount = count($matches ?? []);
?>

<style>
    .cricket-question-list {
        --cq-bg: #f4f7fb;
        --cq-card: #ffffff;
        --cq-border: #dce5f0;
        --cq-text: #17324d;
        --cq-muted: #6d7f92;
        --cq-primary: #1f6feb;
        --cq-dark: #173d67;
        --cq-accent: #35b7ff;
        background: linear-gradient(180deg, #f8fbff 0%, var(--cq-bg) 100%);
        min-height: calc(100vh - 70px);
        padding: 24px;
        border-radius: 28px;
    }

    .cricket-question-list .hero {
        background: linear-gradient(135deg, var(--cq-dark), var(--cq-primary));
        border-radius: 24px;
        color: #fff;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(23, 61, 103, 0.18);
    }

    .cricket-question-list .panel {
        background: var(--cq-card);
        border: 1px solid var(--cq-border);
        border-radius: 24px;
        box-shadow: 0 12px 28px rgba(23, 50, 77, 0.06);
    }

    .cricket-question-list .match-card {
        border: 1px solid #e7eef8;
        border-radius: 20px;
        padding: 20px;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        height: 100%;
    }

    .cricket-question-list .match-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--cq-text);
    }

    .cricket-question-list .match-meta {
        color: var(--cq-muted);
        font-size: 14px;
    }

    .cricket-question-list .match-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eef5ff;
        color: var(--cq-primary);
        font-weight: 700;
        font-size: 13px;
    }

    .cricket-question-list .action-btn {
        border-radius: 14px;
        padding: 11px 16px;
        font-weight: 700;
    }
</style>

<div class="page-wrapper p-4">
    <div class="page-content cricket-question-list">
        <div class="hero mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <div class="text-uppercase fw-semibold mb-2" style="letter-spacing:.12em; opacity:.78;">Cricket Questions</div>
                    <h3 class="mb-2 text-white">Add Questions By Match</h3>
                    <p class="mb-0 opacity-75">Select a cricket match first. Questions and answer keys saved here will be shared across all pools linked to that match.</p>
                </div>
                <a href="<?= base_url('admin/cricket_matches') ?>" class="btn btn-light action-btn">
                    <i class="bx bx-arrow-back"></i> All Matches
                </a>
            </div>
        </div>

        <div class="panel p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h4 class="mb-1 text-dark">Select Match</h4>
                    <div class="text-muted">Choose one match and manage one shared question set for all related pools.</div>
                </div>
                <span class="badge bg-primary fs-6"><?= (int) $matchCount ?> Matches</span>
            </div>

            <div class="row g-4">
                <?php if (!empty($matches)) : ?>
                    <?php foreach ($matches as $match) : ?>
                        <div class="col-lg-6">
                            <div class="match-card">
                                <div class="d-flex justify-content-between gap-3 flex-wrap mb-3">
                                    <div>
                                        <div class="match-title"><?= html_escape(trim(($match['team_home'] ?? '') . ' vs ' . ($match['team_away'] ?? ''))) ?></div>
                                        <div class="match-meta mt-1"><?= html_escape($match['competition_name'] ?: 'Cricket Match') ?></div>
                                    </div>
                                    <span class="match-pill">
                                        <i class="bx bx-help-circle"></i>
                                        <?= (int) ($match['question_count'] ?? 0) ?>/<?= (int) $max_questions ?> Questions
                                    </span>
                                </div>
                                <div class="match-meta mb-3">
                                    <div><strong>Date:</strong> <?= !empty($match['start_at']) ? date('d M Y, h:i A', strtotime($match['start_at'])) : 'Not set' ?></div>
                                    <div><strong>Venue:</strong> <?= html_escape($match['venue'] ?: 'Venue TBA') ?></div>
                                    <div><strong>Linked Pools:</strong> <?= (int) ($match['linked_pool_count'] ?? 0) ?></div>
                                </div>
                                <a href="<?= base_url('admin/cricket_questions/' . (int) $match['id']) ?>" class="btn btn-primary action-btn">
                                    <i class="bx bx-edit"></i> Add Questions
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <div class="text-center text-muted py-5">No cricket matches found.</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
