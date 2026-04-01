<?php
$total_questions = count($questions);
$answered = 0;
foreach ($questions as $q) {
    $qid = (int)$q['id'];
    if (!empty($answers[$qid]['answer'])) $answered++;
}
$progress = $total_questions > 0 ? round(($answered / $total_questions) * 100) : 0;
?>

<div class="page-wrapper">
    <div class="page-content">

        <!-- ============ HEADER ============ -->
        <div class="ea-header">
            <div class="ea-header-left">
                <a href="<?= base_url('admin/pool/users/' . $pool['id']) ?>" class="ea-back-btn">
                    <i class="bx bx-arrow-back"></i>
                </a>
                <div class="ea-header-icon">
                    <i class="bx bx-edit-alt"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold ea-title">Edit Answers</h4>
                    <p class="mb-0 ea-subtitle">
                        Pool: <strong><?= html_escape($pool['pool_name']) ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- ============ USER INFO CARD ============ -->
        <div class="ea-user-card">
            <div class="ea-user-left">
                <div class="ea-user-avatar">
                    <?= strtoupper(substr($user['name'], 0, 2)) ?>
                </div>
                <div class="ea-user-info">
                    <h5 class="ea-user-name"><?= html_escape($user['name']) ?></h5>
                    <div class="ea-user-meta">
                        <?php if (!empty($user['email'])) : ?>
                            <span class="ea-meta-item">
                                <i class="bx bx-envelope"></i> <?= html_escape($user['email']) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($user['mobile'])) : ?>
                            <span class="ea-meta-item">
                                <i class="bx bx-phone"></i> <?= html_escape($user['mobile']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="ea-user-right">
                <div class="ea-progress-wrap">
                    <svg viewBox="0 0 36 36" class="ea-ring-svg">
                        <path class="ea-ring-bg" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path class="ea-ring-fill" id="progressRing" stroke-dasharray="<?= $progress ?>, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <text x="18" y="20.35" class="ea-ring-text" id="progressText"><?= $progress ?>%</text>
                    </svg>
                    <div class="ea-progress-detail">
                        <span class="ea-progress-number" id="progressLabel"><?= $answered ?>/<?= $total_questions ?></span>
                        <span class="ea-progress-sub">Completed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ FORM ============ -->
        <form method="post" action="<?= base_url('admin/pool/update_user_answers') ?>" id="answersForm">
            <input type="hidden" name="pool_id" value="<?= $pool['id'] ?>">
            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

            <?php if (!empty($questions)) : ?>

                <div class="ea-questions-wrap">
                    <?php foreach ($questions as $index => $q):
                        $qid = (int)$q['id'];
                        $selected = $answers[$qid]['answer'] ?? '';
                        $is_answered = !empty($selected);
                    ?>
                        <div class="ea-card <?= $is_answered ? 'ea-card-done' : '' ?>" data-index="<?= $index ?>" data-qid="<?= $qid ?>">

                            <div class="ea-card-left">
                                <div class="ea-num <?= $is_answered ? 'ea-num-done' : '' ?>">
                                    <?php if ($is_answered) : ?>
                                        <i class="bx bx-check"></i>
                                    <?php else : ?>
                                        <?= $index + 1 ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="ea-card-body">
                                <div class="ea-card-top">
                                    <span class="ea-q-label">Question <?= $index + 1 ?></span>
                                    <span class="ea-badge <?= $is_answered ? 'ea-badge-done' : 'ea-badge-pending' ?>">
                                        <?php if ($is_answered) : ?>
                                            <i class="bx bx-check-circle"></i> Answered
                                        <?php else : ?>
                                            <i class="bx bx-time-five"></i> Pending
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <p class="ea-question"><?= html_escape($q['question']) ?></p>

                                <div class="ea-answers">
                                    <label class="ea-ans <?= $selected == 'yes' ? 'ea-ans-yes-active' : '' ?>">
                                        <input type="radio" name="answers[<?= $qid ?>]" value="yes" <?= $selected == 'yes' ? 'checked' : '' ?>>
                                        <div class="ea-ans-inner ea-ans-yes">
                                            <i class="bx bx-check-circle"></i>
                                            <span>Yes</span>
                                        </div>
                                    </label>

                                    <label class="ea-ans <?= $selected == 'no' ? 'ea-ans-no-active' : '' ?>">
                                        <input type="radio" name="answers[<?= $qid ?>]" value="no" <?= $selected == 'no' ? 'checked' : '' ?>>
                                        <div class="ea-ans-inner ea-ans-no">
                                            <i class="bx bx-x-circle"></i>
                                            <span>No</span>
                                        </div>
                                    </label>

                                    <button type="button" class="ea-reset-btn <?= $is_answered ? '' : 'ea-hidden' ?>" title="Clear answer">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- ============ SUBMIT SECTION ============ -->
                <div class="ea-submit-section">
                    <div class="ea-submit-left">
                        <div class="ea-submit-stat">
                            <span class="ea-dot ea-dot-green"></span>
                            <span><strong id="answeredCount"><?= $answered ?></strong> Answered</span>
                        </div>
                        <div class="ea-submit-stat">
                            <span class="ea-dot ea-dot-gray"></span>
                            <span><strong id="unansweredCount"><?= $total_questions - $answered ?></strong> Unanswered</span>
                        </div>
                    </div>
                    <div class="ea-submit-right">
                        <a href="<?= base_url('admin/pool/users/' . $pool['id']) ?>" class="ea-btn-cancel" id="cancelBtn">
                            <i class="bx bx-x"></i> Cancel
                        </a>
                        <button type="submit" class="ea-btn-submit" id="saveBtn">
                            <i class="bx bx-check-double"></i> Save All Answers
                        </button>
                    </div>
                </div>

            <?php else : ?>
                <div class="ea-empty">
                    <div class="ea-empty-icon">
                        <i class="bx bx-help-circle"></i>
                    </div>
                    <h5>No Questions Available</h5>
                    <p>This pool doesn't have any questions yet.</p>
                    <a href="<?= base_url('admin/pool/users/' . $pool['id']) ?>" class="ea-btn-cancel mt-3">
                        <i class="bx bx-arrow-back"></i> Go Back
                    </a>
                </div>
            <?php endif; ?>

        </form>
    </div>
</div>

<style>
    /* ============================================
       EDIT ANSWERS - CLEAN MODERN UI
       ============================================ */

    /* --- VARIABLES --- */
    :root {
        --ea-primary: #6366f1;
        --ea-primary-soft: #eef2ff;
        --ea-green: #22c55e;
        --ea-green-soft: #dcfce7;
        --ea-green-dark: #15803d;
        --ea-red: #ef4444;
        --ea-red-soft: #fef2f2;
        --ea-red-dark: #dc2626;
        --ea-orange: #f59e0b;
        --ea-orange-soft: #fff7ed;
        --ea-dark: #1e293b;
        --ea-gray: #64748b;
        --ea-light-gray: #94a3b8;
        --ea-border: #e2e8f0;
        --ea-bg: #f8fafc;
        --ea-white: #ffffff;
        --ea-radius: 16px;
        --ea-radius-md: 12px;
        --ea-radius-sm: 10px;
    }

    /* --- HEADER --- */
    .ea-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ea-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ea-title {
        font-size: 22px;
        color: var(--ea-dark);
        letter-spacing: -0.3px;
    }

    .ea-subtitle {
        font-size: 13px;
        color: var(--ea-light-gray);
        margin-top: 2px;
    }

    .ea-subtitle strong {
        color: var(--ea-dark);
    }

    .ea-back-btn {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ea-white);
        border: 1.5px solid var(--ea-border);
        border-radius: var(--ea-radius-md);
        color: var(--ea-gray);
        font-size: 20px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .ea-back-btn:hover {
        background: var(--ea-primary-soft);
        border-color: #c7d2fe;
        color: var(--ea-primary);
        transform: translateX(-2px);
    }

    .ea-header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #f59e0b, #f97316);
        border-radius: var(--ea-radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.25);
    }

    /* --- USER CARD --- */
    .ea-user-card {
        background: var(--ea-white);
        border: 1.5px solid var(--ea-border);
        border-radius: var(--ea-radius);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 28px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        flex-wrap: wrap;
    }

    .ea-user-left {
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
        min-width: 220px;
    }

    .ea-user-avatar {
        width: 56px;
        height: 56px;
        border-radius: var(--ea-radius-md);
        background: linear-gradient(135deg, var(--ea-primary), #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 19px;
        font-weight: 800;
        letter-spacing: 1px;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
        flex-shrink: 0;
    }

    .ea-user-name {
        font-size: 17px;
        font-weight: 700;
        color: var(--ea-dark);
        margin: 0 0 4px 0;
    }

    .ea-user-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .ea-meta-item {
        font-size: 13px;
        color: var(--ea-gray);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .ea-meta-item i {
        font-size: 15px;
        color: var(--ea-light-gray);
    }

    /* --- PROGRESS RING --- */
    .ea-user-right {
        flex-shrink: 0;
    }

    .ea-progress-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
        background: var(--ea-bg);
        padding: 14px 20px;
        border-radius: var(--ea-radius-md);
        border: 1px solid var(--ea-border);
    }

    .ea-ring-svg {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
    }

    .ea-ring-bg {
        fill: none;
        stroke: var(--ea-border);
        stroke-width: 3;
    }

    .ea-ring-fill {
        fill: none;
        stroke: var(--ea-primary);
        stroke-width: 3;
        stroke-linecap: round;
        transition: stroke-dasharray 0.5s ease, stroke 0.3s ease;
    }

    .ea-ring-text {
        fill: var(--ea-dark);
        font-size: 9px;
        font-weight: 800;
        text-anchor: middle;
        font-family: inherit;
    }

    .ea-progress-detail {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .ea-progress-number {
        font-size: 20px;
        font-weight: 800;
        color: var(--ea-dark);
        line-height: 1;
    }

    .ea-progress-sub {
        font-size: 11px;
        color: var(--ea-light-gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* --- QUESTIONS --- */
    .ea-questions-wrap {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 28px;
    }

    /* FIX: Cards are visible by default — animation class is added via JS only on load */
    .ea-card {
        background: var(--ea-white);
        border: 2px solid var(--ea-border);
        border-radius: var(--ea-radius);
        padding: 24px;
        display: flex;
        gap: 18px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
        opacity: 1;
        /* Always visible by default — JS will handle entrance animation */
    }

    /* FIX: Entrance animation only applied via JS-added class */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ea-card.ea-animating {
        animation: slideUp 0.4s ease forwards;
        opacity: 0;
    }

    /* Animation delays only when .ea-animating is present */
    .ea-card.ea-animating[data-index="0"] {
        animation-delay: 0.02s;
    }

    .ea-card.ea-animating[data-index="1"] {
        animation-delay: 0.04s;
    }

    .ea-card.ea-animating[data-index="2"] {
        animation-delay: 0.06s;
    }

    .ea-card.ea-animating[data-index="3"] {
        animation-delay: 0.08s;
    }

    .ea-card.ea-animating[data-index="4"] {
        animation-delay: 0.10s;
    }

    .ea-card.ea-animating[data-index="5"] {
        animation-delay: 0.12s;
    }

    .ea-card.ea-animating[data-index="6"] {
        animation-delay: 0.14s;
    }

    .ea-card.ea-animating[data-index="7"] {
        animation-delay: 0.16s;
    }

    .ea-card.ea-animating[data-index="8"] {
        animation-delay: 0.18s;
    }

    .ea-card.ea-animating[data-index="9"] {
        animation-delay: 0.20s;
    }

    .ea-card.ea-animating[data-index="10"] {
        animation-delay: 0.22s;
    }

    .ea-card.ea-animating[data-index="11"] {
        animation-delay: 0.24s;
    }

    .ea-card.ea-animating[data-index="12"] {
        animation-delay: 0.26s;
    }

    .ea-card.ea-animating[data-index="13"] {
        animation-delay: 0.28s;
    }

    .ea-card.ea-animating[data-index="14"] {
        animation-delay: 0.30s;
    }

    .ea-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--ea-border);
        border-radius: 4px 0 0 4px;
        transition: background 0.3s ease;
    }

    .ea-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.06);
        transform: translateY(-1px);
    }

    .ea-card-done {
        border-color: #bbf7d0;
        background: linear-gradient(135deg, #fefffe 0%, #f7fdf9 100%);
    }

    .ea-card-done::before {
        background: var(--ea-green);
    }

    .ea-card-done:hover {
        border-color: #86efac;
        box-shadow: 0 4px 16px rgba(34, 197, 94, 0.08);
    }

    /* Pulse when just answered */
    @keyframes cardPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.25);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }

    .ea-card.ea-just-done {
        animation: cardPulse 0.6s ease !important;
        opacity: 1 !important;
    }

    /* --- QUESTION NUMBER --- */
    .ea-card-left {
        flex-shrink: 0;
    }

    .ea-num {
        width: 42px;
        height: 42px;
        border-radius: var(--ea-radius-sm);
        background: var(--ea-bg);
        border: 1.5px solid var(--ea-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        color: var(--ea-light-gray);
        transition: all 0.3s ease;
    }

    .ea-num-done {
        background: var(--ea-green-soft);
        border-color: #a7f3d0;
        color: var(--ea-green-dark);
        font-size: 20px;
    }

    /* --- CARD BODY --- */
    .ea-card-body {
        flex: 1;
        min-width: 0;
    }

    .ea-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .ea-q-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--ea-light-gray);
    }

    .ea-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
    }

    .ea-badge i {
        font-size: 13px;
    }

    .ea-badge-done {
        background: var(--ea-green-soft);
        color: var(--ea-green-dark);
    }

    .ea-badge-pending {
        background: var(--ea-orange-soft);
        color: #c2410c;
    }

    .ea-question {
        font-size: 15px;
        font-weight: 600;
        color: var(--ea-dark);
        line-height: 1.6;
        margin: 0 0 16px 0;
        word-break: break-word;
    }

    /* --- ANSWER BUTTONS --- */
    .ea-answers {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ea-ans {
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }

    .ea-ans input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .ea-ans-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 10px 28px;
        border-radius: var(--ea-radius-sm);
        border: 2px solid var(--ea-border);
        font-size: 14px;
        font-weight: 600;
        color: var(--ea-gray);
        background: var(--ea-white);
        transition: all 0.25s ease;
        user-select: none;
    }

    .ea-ans-inner i {
        font-size: 18px;
    }

    .ea-ans-inner:hover {
        border-color: #c7d2fe;
        background: #fafaff;
        transform: translateY(-1px);
    }

    /* Yes Active */
    .ea-ans-yes-active .ea-ans-yes {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border-color: var(--ea-green);
        color: var(--ea-green-dark);
        box-shadow: 0 3px 12px rgba(34, 197, 94, 0.15);
        transform: translateY(-1px);
    }

    /* No Active */
    .ea-ans-no-active .ea-ans-no {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-color: var(--ea-red);
        color: var(--ea-red-dark);
        box-shadow: 0 3px 12px rgba(239, 68, 68, 0.15);
        transform: translateY(-1px);
    }

    /* --- RESET BUTTON --- */
    .ea-reset-btn {
        width: 38px;
        height: 38px;
        border-radius: var(--ea-radius-sm);
        border: 1.5px solid var(--ea-border);
        background: var(--ea-white);
        color: var(--ea-light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: background 0.3s ease, border-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        flex-shrink: 0;
    }

    .ea-reset-btn:hover {
        background: var(--ea-red-soft);
        border-color: #fca5a5;
        color: var(--ea-red);
        transform: rotate(180deg);
    }

    .ea-hidden {
        display: none !important;
    }

    /* --- SUBMIT SECTION --- */
    .ea-submit-section {
        background: var(--ea-white);
        border: 2px solid var(--ea-border);
        border-radius: var(--ea-radius);
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        margin-bottom: 40px;
    }

    .ea-submit-left {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .ea-submit-stat {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 14px;
        color: var(--ea-gray);
    }

    .ea-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .ea-dot-green {
        background: var(--ea-green);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
    }

    .ea-dot-gray {
        background: var(--ea-border);
    }

    .ea-submit-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ea-btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 24px;
        border-radius: var(--ea-radius-sm);
        font-size: 14px;
        font-weight: 600;
        color: var(--ea-gray);
        background: var(--ea-bg);
        border: 1.5px solid var(--ea-border);
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ea-btn-cancel:hover {
        background: #e2e8f0;
        color: var(--ea-dark);
    }

    .ea-btn-cancel i {
        font-size: 18px;
    }

    .ea-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        border-radius: var(--ea-radius-sm);
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, var(--ea-primary), #8b5cf6);
        border: none;
        cursor: pointer;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.25);
    }

    .ea-btn-submit:hover {
        box-shadow: 0 6px 24px rgba(99, 102, 241, 0.35);
        transform: translateY(-2px);
    }

    .ea-btn-submit:active {
        transform: translateY(0);
    }

    .ea-btn-submit i {
        font-size: 18px;
    }

    @keyframes btnPulse {

        0%,
        100% {
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.25);
        }

        50% {
            box-shadow: 0 4px 28px rgba(99, 102, 241, 0.45);
        }
    }

    .ea-btn-submit.ea-has-changes {
        animation: btnPulse 1.8s infinite;
    }

    /* --- EMPTY STATE --- */
    .ea-empty {
        text-align: center;
        padding: 60px 24px;
        background: var(--ea-white);
        border-radius: var(--ea-radius);
        border: 2px dashed var(--ea-border);
        margin-bottom: 40px;
    }

    .ea-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--ea-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 36px;
        color: #cbd5e1;
    }

    .ea-empty h5 {
        color: var(--ea-dark);
        font-weight: 700;
        margin-bottom: 6px;
    }

    .ea-empty p {
        color: var(--ea-light-gray);
        font-size: 14px;
        margin: 0;
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .ea-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .ea-user-card {
            flex-direction: column;
            padding: 20px;
            text-align: center;
        }

        .ea-user-left {
            flex-direction: column;
            align-items: center;
            min-width: unset;
            width: 100%;
        }

        .ea-user-meta {
            justify-content: center;
        }

        .ea-user-right {
            width: 100%;
        }

        .ea-progress-wrap {
            width: 100%;
            justify-content: center;
        }

        .ea-card {
            flex-direction: column;
            gap: 12px;
            padding: 18px;
        }

        .ea-num {
            width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .ea-question {
            font-size: 14px;
        }

        .ea-answers {
            flex-direction: row;
        }

        .ea-ans {
            flex: 1;
        }

        .ea-ans-inner {
            width: 100%;
            justify-content: center;
            padding: 10px 16px;
        }

        .ea-submit-section {
            flex-direction: column;
            padding: 20px;
            gap: 14px;
        }

        .ea-submit-left {
            width: 100%;
            justify-content: center;
        }

        .ea-submit-right {
            width: 100%;
        }

        .ea-btn-cancel,
        .ea-btn-submit {
            flex: 1;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-content {
            padding: 12px !important;
        }

        .ea-user-avatar {
            width: 48px;
            height: 48px;
            font-size: 16px;
        }

        .ea-card {
            padding: 14px;
        }

        .ea-ans-inner {
            padding: 8px 12px;
            font-size: 13px;
            gap: 5px;
        }

        .ea-ans-inner i {
            font-size: 16px;
        }

        .ea-btn-cancel,
        .ea-btn-submit {
            padding: 10px 16px;
            font-size: 13px;
        }
    }

    /* --- PRINT --- */
    @media print {

        .ea-submit-section,
        .ea-reset-btn,
        .ea-back-btn {
            display: none !important;
        }

        .ea-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ddd;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const totalQuestions = <?= $total_questions ?>;
        let hasChanges = false;

        // ===== FIX: Run entrance animation ONCE via JS, then remove class so it never re-triggers =====
        document.querySelectorAll('.ea-card').forEach(function(card) {
            card.classList.add('ea-animating');
            card.addEventListener('animationend', function handler() {
                card.classList.remove('ea-animating');
                card.style.opacity = '1';
                card.removeEventListener('animationend', handler);
            });
        });

        // Attach events to all answer radios
        document.querySelectorAll('.ea-ans input[type="radio"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                handleAnswer(this);
            });
        });

        // Attach events to all reset buttons
        document.querySelectorAll('.ea-reset-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                handleReset(this);
            });
        });

        // ===== HANDLE ANSWER SELECTION =====
        function handleAnswer(radio) {
            const card = radio.closest('.ea-card');
            const qid = card.getAttribute('data-qid');
            const allLabels = card.querySelectorAll('.ea-ans');
            const numEl = card.querySelector('.ea-num');
            const badgeEl = card.querySelector('.ea-badge');
            const resetBtn = card.querySelector('.ea-reset-btn');
            const value = radio.value;

            // FIX: Remove any hidden empty input left by a previous reset
            const hiddenInput = card.querySelector('input[type="hidden"][name="answers[' + qid + ']"]');
            if (hiddenInput) hiddenInput.remove();

            // Reset all label active styles
            allLabels.forEach(function(label) {
                label.classList.remove('ea-ans-yes-active', 'ea-ans-no-active');
            });

            // Apply active style to selected label
            if (value === 'yes') {
                radio.closest('.ea-ans').classList.add('ea-ans-yes-active');
            } else {
                radio.closest('.ea-ans').classList.add('ea-ans-no-active');
            }

            // FIX: Ensure card stays visible — force opacity before class changes
            card.style.opacity = '1';

            // Update card done state + pulse animation
            card.classList.add('ea-card-done');
            card.classList.remove('ea-just-done');
            void card.offsetWidth; // reflow to restart animation
            card.classList.add('ea-just-done');

            // Remove ea-just-done after animation so it doesn't block future hovers
            card.addEventListener('animationend', function cleanup() {
                card.classList.remove('ea-just-done');
                card.removeEventListener('animationend', cleanup);
            });

            // Update number badge
            numEl.classList.add('ea-num-done');
            numEl.innerHTML = '<i class="bx bx-check"></i>';

            // Update status badge
            badgeEl.className = 'ea-badge ea-badge-done';
            badgeEl.innerHTML = '<i class="bx bx-check-circle"></i> Answered';

            // Show reset button
            resetBtn.classList.remove('ea-hidden');

            markChanged();
            updateCounts();
        }

        // ===== HANDLE RESET =====
        function handleReset(btn) {
            const card = btn.closest('.ea-card');
            const qid = card.getAttribute('data-qid');
            const index = card.getAttribute('data-index');
            const radios = card.querySelectorAll('input[type="radio"]');
            const allLabels = card.querySelectorAll('.ea-ans');
            const numEl = card.querySelector('.ea-num');
            const badgeEl = card.querySelector('.ea-badge');

            // Uncheck all radios
            radios.forEach(function(r) {
                r.checked = false;
            });

            // Remove active styles
            allLabels.forEach(function(label) {
                label.classList.remove('ea-ans-yes-active', 'ea-ans-no-active');
            });

            // FIX: Ensure card stays visible before removing done classes
            card.style.opacity = '1';

            // Remove done state (no animation re-trigger since ea-animating is gone)
            card.classList.remove('ea-card-done', 'ea-just-done');

            // Reset number
            numEl.classList.remove('ea-num-done');
            numEl.textContent = parseInt(index) + 1;

            // Reset badge
            badgeEl.className = 'ea-badge ea-badge-pending';
            badgeEl.innerHTML = '<i class="bx bx-time-five"></i> Pending';

            // Hide reset button
            btn.classList.add('ea-hidden');

            // FIX: Remove any existing hidden input first to avoid duplicates
            const existingHidden = card.querySelector('input[type="hidden"][name="answers[' + qid + ']"]');
            if (existingHidden) existingHidden.remove();

            // Add hidden input so server knows this answer was cleared
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'answers[' + qid + ']';
            hidden.value = '';
            card.querySelector('.ea-answers').appendChild(hidden);

            markChanged();
            updateCounts();
        }

        // ===== UPDATE PROGRESS COUNTS =====
        function updateCounts() {
            const answered = document.querySelectorAll('.ea-card-done').length;
            const unanswered = totalQuestions - answered;
            const progress = totalQuestions > 0 ? Math.round((answered / totalQuestions) * 100) : 0;

            const acEl = document.getElementById('answeredCount');
            const ucEl = document.getElementById('unansweredCount');
            if (acEl) acEl.textContent = answered;
            if (ucEl) ucEl.textContent = unanswered;

            const ring = document.getElementById('progressRing');
            const ringText = document.getElementById('progressText');
            const label = document.getElementById('progressLabel');

            if (ring) ring.setAttribute('stroke-dasharray', progress + ', 100');
            if (ringText) ringText.textContent = progress + '%';
            if (label) label.textContent = answered + '/' + totalQuestions;

            // Color ring based on progress level
            if (ring) {
                if (progress === 100) {
                    ring.style.stroke = '#22c55e';
                } else if (progress >= 50) {
                    ring.style.stroke = '#6366f1';
                } else if (progress > 0) {
                    ring.style.stroke = '#f59e0b';
                } else {
                    ring.style.stroke = '#e2e8f0';
                }
            }
        }

        // ===== MARK UNSAVED CHANGES =====
        function markChanged() {
            if (!hasChanges) {
                hasChanges = true;
                const saveBtn = document.getElementById('saveBtn');
                if (saveBtn) saveBtn.classList.add('ea-has-changes');
            }
        }

        // ===== WARN BEFORE LEAVING WITH UNSAVED CHANGES =====
        window.addEventListener('beforeunload', function(e) {
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // FIX: Cancel button should also bypass the beforeunload warning
        var cancelBtn = document.getElementById('cancelBtn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                hasChanges = false;
            });
        }

        // ===== FORM SUBMIT =====
        var form = document.getElementById('answersForm');
        if (form) {
            form.addEventListener('submit', function() {
                hasChanges = false;
                var saveBtn = document.getElementById('saveBtn');
                if (saveBtn) {
                    saveBtn.disabled = true;
                    saveBtn.classList.remove('ea-has-changes');
                    saveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
                }
            });
        }

        // ===== CTRL+S SHORTCUT =====
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                if (form) form.submit();
            }
        });

    });
</script>