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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

<style>
    .pq-page {
        --c-bg: #eef2f8;
        --c-surface: #ffffff;
        --c-surface-2: #f5f8fc;
        --c-border: #e0e8f2;
        --c-border-2: #c9d8ec;
        --c-text: #0f1f35;
        --c-text-2: #3a5068;
        --c-text-3: #6b849e;
        --c-text-4: #9db4c8;
        --c-blue: #1a52b8;
        --c-blue-bg: #e5effe;
        --c-blue-mid: #2762e9;
        --c-teal: #0b9467;
        --c-teal-bg: #d5f5ea;
        --c-amber-bg: #fff3d4;
        --c-r-sm: 8px;
        --c-r-md: 13px;
        --c-r-lg: 16px;
        --c-r-xl: 18px;
        --c-sh: 0 1px 3px rgba(15, 31, 53, .06), 0 6px 20px rgba(15, 31, 53, .07);
        --fn-h: 'Sora', sans-serif;
        --fn-b: 'Plus Jakarta Sans', sans-serif;

        font-family: var(--fn-b);
        background: var(--c-bg);
        min-height: 100%;
        /* KEY FIX: contain layout within the content area — no overflow push */
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        padding: 14px;
        box-sizing: border-box;
    }

    .pq-page-shell {
        width: 100%;
    }

    .pq-page *,
    .pq-page *::before,
    .pq-page *::after {
        box-sizing: border-box;
    }

    /* ── HERO ─────────────────────────────────────────────── */
    .pq-hero {
        background: linear-gradient(130deg, #122d5c 0%, #1a52b8 55%, #1e6dd4 100%);
        border-radius: var(--c-r-xl);
        padding: 20px 22px;
        margin-bottom: 14px;
        position: relative;
        overflow: hidden;
    }

    .pq-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255, 255, 255, .04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, .04) 1px, transparent 1px);
        background-size: 26px 26px;
        pointer-events: none;
    }

    .pq-hero::after {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, .08) 0%, transparent 70%);
        top: -140px;
        right: -60px;
        pointer-events: none;
    }

    .pq-hero__inner {
        position: relative;
        z-index: 1;
    }

    .pq-hero__top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .pq-hero__kicker {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .55);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .pq-hero__kicker-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .5);
        flex-shrink: 0;
    }

    .pq-hero__title {
        font-family: var(--fn-h);
        font-size: 19px;
        font-weight: 800;
        color: #fff;
        margin: 0 0 5px;
        line-height: 1.25;
    }

    .pq-hero__desc {
        font-size: 12px;
        color: rgba(255, 255, 255, .5);
        margin: 0;
        max-width: 520px;
        line-height: 1.5;
    }

    .pq-hero__actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: flex-start;
        flex-shrink: 0;
    }

    /* ── BUTTONS ────────────────────────────────────────────── */
    .pq-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: var(--c-r-md);
        padding: 9px 15px;
        font-family: var(--fn-b);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: background .15s, border-color .15s, color .15s;
        white-space: nowrap;
        line-height: 1;
    }

    .pq-btn--ghost {
        background: rgba(255, 255, 255, .11);
        border-color: rgba(255, 255, 255, .18);
        color: rgba(255, 255, 255, .88);
    }

    .pq-btn--ghost:hover {
        background: rgba(255, 255, 255, .18);
        color: #fff;
    }

    .pq-btn--primary {
        background: var(--c-blue-mid);
        border-color: var(--c-blue-mid);
        color: #fff;
    }

    .pq-btn--primary:hover {
        background: #1d53d4;
        border-color: #1d53d4;
        color: #fff;
    }

    .pq-btn--success {
        background: var(--c-teal);
        border-color: var(--c-teal);
        color: #fff;
    }

    .pq-btn--success:hover {
        background: #098058;
        color: #fff;
    }

    .pq-btn--success:disabled {
        opacity: .42;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ── HERO STATS ─────────────────────────────────────────── */
    .pq-hstats {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr;
        gap: 8px;
        align-items: stretch;
    }

    .pq-hstat {
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: var(--c-r-lg);
        padding: 12px 14px;
    }

    .pq-hstat__lbl {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .42);
        margin-bottom: 8px;
    }

    .pq-hstat__val {
        font-family: var(--fn-h);
        font-size: 17px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .pq-hstat__sub {
        font-size: 11px;
        color: rgba(255, 255, 255, .38);
        margin-top: 4px;
    }

    /* Progress stat */
    .pq-hstat--prog .pq-hstat__row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 10px;
        margin-bottom: 10px;
    }

    .pq-hstat--prog .pq-hstat__pct {
        font-family: var(--fn-h);
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }

    .pq-hstat--prog .pq-aside-lbl {
        font-size: 10px;
        color: rgba(255, 255, 255, .4);
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: 3px;
        text-align: right;
    }

    .pq-hstat--prog .pq-aside-val {
        font-size: 13px;
        font-weight: 700;
        color: rgba(255, 255, 255, .75);
        text-align: right;
    }

    .pq-prog {
        width: 100%;
        height: 5px;
        border-radius: 99px;
        background: rgba(255, 255, 255, .14);
        overflow: hidden;
        margin-bottom: 7px;
    }

    .pq-prog__fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, #6ee7c7 0%, #93c5fd 100%);
    }

    /* ── ALERT ──────────────────────────────────────────────── */
    .pq-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: var(--c-r-md);
        padding: 11px 15px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 16px;
        border: 1px solid;
    }

    .pq-alert--warn {
        background: var(--c-amber-bg);
        border-color: #e3c55c;
        color: #7a4900;
    }

    /* ── WORKSPACE ──────────────────────────────────────────── */
    .pq-workspace {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, .95fr);
        gap: 12px;
        align-items: start;
    }

    /* ── CARD ───────────────────────────────────────────────── */
    .pq-card {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--c-r-xl);
        padding: 16px;
        box-shadow: var(--c-sh);
        min-width: 0;
    }

    .pq-card--sticky {
        position: static;
    }

    .pq-card__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--c-border);
    }

    .pq-card__title {
        font-family: var(--fn-h);
        font-size: 14px;
        font-weight: 800;
        color: var(--c-text);
        margin: 0 0 3px;
    }

    .pq-card__sub {
        font-size: 11px;
        color: var(--c-text-3);
        margin: 0;
        line-height: 1.45;
        max-width: 280px;
    }

    /* ── BADGE ──────────────────────────────────────────────── */
    .pq-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .pq-badge--blue {
        background: var(--c-blue-bg);
        color: var(--c-blue);
    }

    .pq-badge--teal {
        background: var(--c-teal-bg);
        color: var(--c-teal);
    }

    /* ── QUESTION BOX ───────────────────────────────────────── */
    .pq-qbox {
        background: var(--c-surface-2);
        border: 1px solid var(--c-border);
        border-radius: var(--c-r-lg);
        padding: 12px;
        margin-bottom: 8px;
        transition: border-color .14s, background .14s;
    }

    .pq-qbox:last-of-type {
        margin-bottom: 0;
    }

    .pq-qbox:focus-within {
        border-color: var(--c-blue-mid);
        background: #fbfdff;
    }

    .pq-qlabel {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 9px;
    }

    .pq-qnum {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        background: var(--c-blue-bg);
        color: var(--c-blue);
        font-size: 11px;
        font-weight: 800;
        font-family: var(--fn-h);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .pq-qlabel span {
        font-size: 12px;
        font-weight: 600;
        color: var(--c-text-2);
    }

    .pq-textarea {
        width: 100%;
        border-radius: var(--c-r-sm);
        border: 1px solid var(--c-border-2);
        background: var(--c-surface);
        padding: 8px 11px;
        font-family: var(--fn-b);
        font-size: 12px;
        color: var(--c-text);
        resize: vertical;
        min-height: 62px;
        outline: none;
        transition: border-color .14s, box-shadow .14s;
        line-height: 1.5;
        display: block;
    }

    .pq-textarea:focus {
        border-color: var(--c-blue-mid);
        box-shadow: 0 0 0 3px rgba(39, 98, 233, .10);
    }

    .pq-textarea[readonly] {
        background: var(--c-surface-2);
        color: var(--c-text-2);
        cursor: default;
    }

    .pq-char-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
    }

    .pq-char-hint {
        font-size: 11px;
        color: var(--c-text-4);
        font-weight: 500;
    }

    .pq-qstatus {
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .pq-qstatus--set {
        background: var(--c-teal-bg);
        color: var(--c-teal);
    }

    .pq-qstatus--empty {
        background: var(--c-border);
        color: var(--c-text-4);
    }

    /* ── ANSWER LIST ────────────────────────────────────────── */
    .pq-alist {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: none;
        overflow: visible;
        padding-right: 0;
    }

    .pq-acard {
        background: var(--c-surface-2);
        border: 1px solid var(--c-border);
        border-radius: var(--c-r-md);
        padding: 11px;
        transition: border-color .14s, background .14s;
    }

    .pq-acard--active {
        background: #f3f8ff;
        border-color: #b2cef7;
    }

    .pq-acard__q {
        font-size: 11px;
        font-weight: 600;
        color: var(--c-text-2);
        margin-bottom: 7px;
        line-height: 1.4;
        word-break: break-word;
    }

    .pq-acard__q em {
        font-style: normal;
        color: var(--c-blue);
        font-weight: 700;
        margin-right: 3px;
    }

    .pq-select {
        width: 100%;
        border-radius: var(--c-r-sm);
        border: 1px solid var(--c-border-2);
        background: var(--c-surface);
        padding: 7px 32px 7px 11px;
        font-family: var(--fn-b);
        font-size: 12px;
        font-weight: 600;
        color: var(--c-text);
        outline: none;
        cursor: pointer;
        transition: border-color .14s, box-shadow .14s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%236b849e' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 9px center;
    }

    .pq-select:focus {
        border-color: var(--c-blue-mid);
        box-shadow: 0 0 0 3px rgba(39, 98, 233, .10);
    }

    .pq-input-ro {
        width: 100%;
        border-radius: var(--c-r-sm);
        border: 1px solid var(--c-border);
        background: var(--c-surface-2);
        padding: 7px 11px;
        font-family: var(--fn-b);
        font-size: 12px;
        font-weight: 600;
        color: var(--c-text-2);
        display: block;
    }

    .pq-empty {
        background: var(--c-surface-2);
        border: 1px dashed var(--c-border-2);
        border-radius: var(--c-r-md);
        padding: 20px 16px;
        text-align: center;
    }

    .pq-empty__icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--c-blue-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }

    .pq-empty p {
        font-size: 12px;
        color: var(--c-text-3);
        margin: 0;
        line-height: 1.55;
    }

    /* ── FORM FOOTER ────────────────────────────────────────── */
    .pq-form-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--c-border);
    }

    .pq-form-foot small {
        font-size: 11px;
        color: var(--c-text-4);
    }

    /* ── GUIDE ──────────────────────────────────────────────── */
    .pq-guide {
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: var(--c-r-xl);
        padding: 16px;
        margin-top: 12px;
        box-shadow: var(--c-sh);
    }

    .pq-guide__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 14px;
        padding-bottom: 13px;
        border-bottom: 1px solid var(--c-border);
    }

    .pq-guide__title {
        font-family: var(--fn-h);
        font-size: 13px;
        font-weight: 800;
        color: var(--c-text);
        margin: 0;
    }

    .pq-guide__grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
    }

    .pq-guide__item {
        background: var(--c-surface-2);
        border: 1px solid var(--c-border);
        border-radius: var(--c-r-md);
        padding: 11px;
    }

    .pq-guide__step {
        width: 24px;
        height: 24px;
        border-radius: 7px;
        background: var(--c-text);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        font-family: var(--fn-h);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }

    .pq-guide__item h6 {
        font-size: 12px;
        font-weight: 700;
        color: var(--c-text);
        margin: 0 0 4px;
    }

    .pq-guide__item p {
        font-size: 11px;
        color: var(--c-text-3);
        margin: 0;
        line-height: 1.6;
    }

    /* ── INFO STRIP ─────────────────────────────────────────── */
    .pq-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
        background: var(--c-blue-bg);
        border: 1px solid #b5cef8;
        border-radius: var(--c-r-md);
        padding: 10px 13px;
        margin-top: 12px;
    }

    .pq-strip span {
        font-size: 12px;
        color: var(--c-blue);
        font-weight: 500;
    }

    .pq-strip a {
        font-size: 12px;
        font-weight: 700;
        color: var(--c-blue);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .pq-strip a:hover {
        text-decoration: underline;
    }

    /* ── RESPONSIVE ─────────────────────────────────────────── */
    @media (max-width: 1100px) {
        .pq-hstats {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .pq-hstat--prog {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 900px) {
        .pq-workspace {
            grid-template-columns: 1fr;
        }

        .pq-card--sticky {
            position: static;
        }

        .pq-alist {
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .pq-page {
            padding: 12px;
        }

        .pq-hero {
            padding: 16px 18px;
        }

        .pq-hero__title {
            font-size: 17px;
        }

        .pq-hstats {
            grid-template-columns: 1fr 1fr;
        }

        .pq-hstat--prog {
            grid-column: 1 / -1;
        }

        .pq-guide__grid {
            grid-template-columns: 1fr;
        }

        .pq-hero__actions {
            width: 100%;
        }

        .pq-hero__actions .pq-btn {
            flex: 1;
            justify-content: center;
        }

        .pq-form-foot {
            flex-direction: column;
            align-items: stretch;
        }

        .pq-form-foot .pq-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid pq-page-shell">
            <div class="pq-page">

                <!-- HERO -->
                <div class="pq-hero">
                    <div class="pq-hero__inner">
                        <div class="pq-hero__top">
                            <div>
                                <div class="pq-hero__kicker">
                                    <span class="pq-hero__kicker-dot"></span>
                                    <?= html_escape($heroKicker) ?>
                                </div>
                                <h2 class="pq-hero__title"><?= html_escape($titleText) ?></h2>
                                <p class="pq-hero__desc"><?= html_escape($heroDescription) ?></p>
                            </div>
                            <div class="pq-hero__actions">
                                <?php if (!$isManageMode) : ?>
                                    <a href="<?= base_url('admin/pool/leaderboard') ?>" class="pq-btn pq-btn--ghost">
                                        <i class="bx bx-bar-chart-alt-2"></i> Leaderboard
                                    </a>
                                <?php endif; ?>
                                <a href="<?= $primaryBackUrl ?>" class="pq-btn pq-btn--ghost">
                                    <i class="bx bx-arrow-back"></i> <?= html_escape($primaryBackLabel) ?>
                                </a>
                            </div>
                        </div>

                        <div class="pq-hstats">
                            <div class="pq-hstat pq-hstat--prog">
                                <div class="pq-hstat__lbl">Question Completion</div>
                                <div class="pq-hstat__row">
                                    <div class="pq-hstat__pct"><?= (int) $completionPercent ?>%</div>
                                    <div>
                                        <div class="pq-aside-lbl"><?= $isManageMode ? 'Linked Pools' : 'Host' ?></div>
                                        <div class="pq-aside-val"><?= $isManageMode ? (int) ($match['linked_pool_count'] ?? 0) : html_escape($pool['host_name']) ?></div>
                                    </div>
                                </div>
                                <div class="pq-prog">
                                    <div class="pq-prog__fill" style="width:<?= (int) $completionPercent ?>%"></div>
                                </div>
                                <div class="pq-hstat__sub"><?= (int) $saved_question_count ?> of <?= (int) $max_questions ?> questions saved</div>
                            </div>

                            <div class="pq-hstat">
                                <div class="pq-hstat__lbl"><?= $isManageMode ? 'Competition' : 'Entry Price' ?></div>
                                <div class="pq-hstat__val" style="font-size:17px; margin-top:6px;">
                                    <?= $isManageMode ? html_escape($match['competition_name'] ?: 'Match') : 'Rs.&nbsp;' . number_format((float) $pool['price'], 2) ?>
                                </div>
                            </div>

                            <div class="pq-hstat">
                                <div class="pq-hstat__lbl"><?= $isManageMode ? 'Match Date' : 'User Limit' ?></div>
                                <div class="pq-hstat__val" style="font-size:17px; margin-top:6px;">
                                    <?= $isManageMode ? (!empty($match['start_at']) ? date('d M', strtotime($match['start_at'])) : 'N/A') : (int) $pool['user_limit'] ?>
                                </div>
                            </div>

                            <div class="pq-hstat">
                                <div class="pq-hstat__lbl">Answer Key</div>
                                <div class="pq-hstat__val" style="font-size:17px; margin-top:6px;">
                                    <?= !empty($questions) ? count($questions) : 0 ?> Ready
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DB WARNING -->
                <?php if (!$question_table_exists || !$answer_table_exists) : ?>
                    <div class="pq-alert pq-alert--warn">
                        <i class="bx bx-error-circle" style="font-size:16px; flex-shrink:0;"></i>
                        Pool Questions database tables are not set up yet. Some features may be unavailable.
                    </div>
                <?php endif; ?>

                <!-- WORKSPACE -->
                <div class="pq-workspace">

                    <!-- Left: Questions -->
                    <div class="pq-card">
                        <div class="pq-card__head">
                            <div>
                                <h3 class="pq-card__title"><?= $isManageMode ? 'Question Builder' : 'Match Questions' ?></h3>
                                <p class="pq-card__sub">
                                    <?= $isManageMode
                                        ? 'Shared across all pools for this match. Save once, applied everywhere.'
                                        : 'Read-only. Edit from Cricket &rsaquo; Add Questions.' ?>
                                </p>
                            </div>
                            <span class="pq-badge pq-badge--blue">
                                <i class="bx bx-layer" style="font-size:11px;"></i>
                                <?= (int) $max_questions ?> slots
                            </span>
                        </div>

                        <?php if ($isManageMode) : ?>
                            <form method="post" action="<?= base_url('admin/cricket_questions/' . (int) ($match['id'] ?? 0) . '/save_questions') ?>">
                                <?php for ($i = 0; $i < (int) $max_questions; $i++) : ?>
                                    <?php $cq = (string) ($question_texts[$i] ?? ''); ?>
                                    <div class="pq-qbox">
                                        <div class="pq-qlabel">
                                            <span class="pq-qnum"><?= $i + 1 ?></span>
                                            <span>Question <?= $i + 1 ?></span>
                                        </div>
                                        <textarea id="question_<?= $i ?>" name="questions[]"
                                            class="pq-textarea pool-question-input"
                                            rows="3" maxlength="255"
                                            placeholder="Type question <?= $i + 1 ?> here…"><?= html_escape($cq) ?></textarea>
                                        <div class="pq-char-row">
                                            <span class="pq-char-hint"><span class="question-char-count"><?= strlen($cq) ?></span> / 255</span>
                                            <span class="pq-qstatus <?= trim($cq) !== '' ? 'pq-qstatus--set' : 'pq-qstatus--empty' ?>">
                                                <?= trim($cq) !== '' ? 'Saved' : 'Empty' ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <div class="pq-form-foot">
                                    <small>Question order is used for players and answer checking.</small>
                                    <button type="submit" class="pq-btn pq-btn--primary">
                                        <i class="bx bx-save"></i> Save Questions
                                    </button>
                                </div>
                            </form>
                        <?php else : ?>
                            <?php for ($i = 0; $i < (int) $max_questions; $i++) : ?>
                                <?php $cq = (string) ($question_texts[$i] ?? ''); ?>
                                <div class="pq-qbox">
                                    <div class="pq-qlabel">
                                        <span class="pq-qnum"><?= $i + 1 ?></span>
                                        <span>Question <?= $i + 1 ?></span>
                                    </div>
                                    <textarea class="pq-textarea" rows="3" readonly><?= html_escape($cq) ?></textarea>
                                    <div class="pq-char-row">
                                        <span class="pq-char-hint"><?= trim($cq) !== '' ? 'Shared match question' : 'No question saved for this slot' ?></span>
                                        <span class="pq-qstatus <?= trim($cq) !== '' ? 'pq-qstatus--set' : 'pq-qstatus--empty' ?>">
                                            <?= trim($cq) !== '' ? 'Saved' : 'Empty' ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Answer Key -->
                    <div class="pq-card pq-card--sticky">
                        <div class="pq-card__head">
                            <div>
                                <h3 class="pq-card__title"><?= $isManageMode ? 'Answer Key Panel' : 'Answer Key' ?></h3>
                                <p class="pq-card__sub">
                                    <?= $isManageMode
                                        ? 'Shared match-wide. All linked pools use the same correct answers.'
                                        : 'Read-only. Manage from Cricket &rsaquo; Add Questions.' ?>
                                </p>
                            </div>
                            <span class="pq-badge pq-badge--teal">
                                <i class="bx bx-check-shield" style="font-size:11px;"></i>
                                <?= !empty($questions) ? count($questions) : 0 ?> saved
                            </span>
                        </div>

                        <?php if ($isManageMode) : ?>
                            <form method="post" action="<?= base_url('admin/cricket_questions/' . (int) ($match['id'] ?? 0) . '/save_answer_key') ?>">
                                <?php if (!empty($questions)) : ?>
                                    <div class="pq-alist">
                                        <?php foreach ($questions as $index => $question) : ?>
                                            <div class="pq-acard <?= (($question['correct_answer'] ?? '') !== '') ? 'pq-acard--active' : '' ?>">
                                                <div class="pq-acard__q">
                                                    <em>Q<?= $index + 1 ?>.</em><?= html_escape($question['question']) ?>
                                                </div>
                                                <select name="correct_answers[<?= (int) $question['id'] ?>]" class="pq-select">
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
                                    <div class="pq-empty">
                                        <div class="pq-empty__icon">
                                            <i class="bx bx-list-ul" style="color:var(--c-blue); font-size:16px;"></i>
                                        </div>
                                        <p>Add questions first — the answer key will populate here automatically.</p>
                                    </div>
                                <?php endif; ?>
                                <div class="pq-form-foot">
                                    <small>Finalize only answers you are certain about.</small>
                                    <button type="submit" class="pq-btn pq-btn--success" <?= empty($questions) ? 'disabled' : '' ?>>
                                        <i class="bx bx-check-circle"></i> Save Answer Key
                                    </button>
                                </div>
                            </form>
                        <?php else : ?>
                            <?php if (!empty($questions)) : ?>
                                <div class="pq-alist">
                                    <?php foreach ($questions as $index => $question) : ?>
                                        <div class="pq-acard <?= (($question['correct_answer'] ?? '') !== '') ? 'pq-acard--active' : '' ?>">
                                            <div class="pq-acard__q">
                                                <em>Q<?= $index + 1 ?>.</em><?= html_escape($question['question']) ?>
                                            </div>
                                            <input type="text" class="pq-input-ro"
                                                value="<?= html_escape(($question['correct_answer'] ?? '') !== '' ? ucfirst($question['correct_answer']) : 'Not set') ?>"
                                                readonly>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="pq-empty">
                                    <div class="pq-empty__icon">
                                        <i class="bx bx-info-circle" style="color:var(--c-blue); font-size:16px;"></i>
                                    </div>
                                    <p>No shared match questions are available for this pool yet.</p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- GUIDE -->
                <div class="pq-guide">
                    <div class="pq-guide__head">
                        <h4 class="pq-guide__title">Quick Guide</h4>
                        <span class="pq-badge pq-badge--blue" style="font-size:10px; padding:4px 9px;">3 steps</span>
                    </div>
                    <div class="pq-guide__grid">
                        <div class="pq-guide__item">
                            <div class="pq-guide__step">1</div>
                            <h6>Draft Clearly</h6>
                            <p>Keep each question short and direct so users can answer quickly on mobile.</p>
                        </div>
                        <div class="pq-guide__item">
                            <div class="pq-guide__step">2</div>
                            <h6>Match-Based Flow</h6>
                            <p><?= $isManageMode
                                    ? 'Save questions first. Only saved questions appear in the answer panel.'
                                    : 'Questions are managed from Cricket &rsaquo; Add Questions, reused across all linked pools.' ?></p>
                        </div>
                        <div class="pq-guide__item">
                            <div class="pq-guide__step">3</div>
                            <h6>Review with Confidence</h6>
                            <p><?= $isManageMode
                                    ? 'Use the global leaderboard to review winners and pool performance.'
                                    : 'This page is read-only for pools, keeping management centralized.' ?></p>
                        </div>
                    </div>
                </div>

                <!-- INFO STRIP -->
                <div class="pq-strip">
                    <span>One combined leaderboard available for all pools on a separate page.</span>
                    <a href="<?= base_url('admin/pool/leaderboard') ?>">
                        Open Global Leaderboard <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.pool-question-input').forEach(function(input) {
            var box = input.closest('.pq-qbox');
            var counter = box && box.querySelector('.question-char-count');
            var status = box && box.querySelector('.pq-qstatus');

            function update() {
                if (input.value.length > 255) input.value = input.value.slice(0, 255);
                if (counter) counter.textContent = input.value.length;
                if (status) {
                    var f = input.value.trim() !== '';
                    status.textContent = f ? 'Saved' : 'Empty';
                    status.className = 'pq-qstatus ' + (f ? 'pq-qstatus--set' : 'pq-qstatus--empty');
                }
            }
            input.addEventListener('input', update);
            update();
        });
    });
</script>