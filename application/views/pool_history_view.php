<?php
// application/views/pool_history_view.php
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

    :root {
        --ph-primary: #4361ee;
        --ph-primary-light: #eef1ff;
        --ph-success: #10b981;
        --ph-success-light: #ecfdf5;
        --ph-danger: #ef4444;
        --ph-danger-light: #fef2f2;
        --ph-warning: #f59e0b;
        --ph-warning-light: #fffbeb;
        --ph-gray: #6b7280;
        --ph-gray-light: #f3f4f6;
        --ph-dark: #1e293b;
        --ph-bg: #f0f4ff;
        --ph-card-bg: #ffffff;
        --ph-border: #e2e8f0;
        --ph-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
        --ph-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
        --ph-shadow-lg: 0 10px 25px -3px rgba(67, 97, 238, 0.12), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --ph-radius: 16px;
        --ph-radius-sm: 12px;
        --ph-radius-xs: 8px;
    }

    * {
        box-sizing: border-box;
    }

    .ph-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--ph-bg);
        min-height: 100vh;
        padding: 40px 0 60px;
    }

    .ph-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ── Header ── */
    .ph-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .ph-header-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--ph-primary), #7c3aed);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
    }

    .ph-header-icon svg {
        width: 30px;
        height: 30px;
        color: #fff;
    }

    .ph-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--ph-dark);
        margin: 0 0 6px;
        letter-spacing: -0.5px;
    }

    .ph-sub {
        color: var(--ph-gray);
        font-size: 15px;
        font-weight: 500;
        margin: 0;
    }

    /* ── Overall Stats Grid ── */
    .ph-stats {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 35px;
    }

    .ph-box {
        background: var(--ph-card-bg);
        border-radius: var(--ph-radius-sm);
        padding: 18px 10px;
        text-align: center;
        border: 1px solid var(--ph-border);
        box-shadow: var(--ph-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .ph-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 3px 3px 0 0;
    }

    .ph-box:nth-child(1)::before {
        background: var(--ph-primary);
    }

    .ph-box:nth-child(2)::before {
        background: #8b5cf6;
    }

    .ph-box:nth-child(3)::before {
        background: var(--ph-warning);
    }

    .ph-box:nth-child(4)::before {
        background: var(--ph-gray);
    }

    .ph-box:nth-child(5)::before {
        background: var(--ph-success);
    }

    .ph-box:nth-child(6)::before {
        background: var(--ph-danger);
    }

    .ph-box:hover {
        transform: translateY(-2px);
        box-shadow: var(--ph-shadow-md);
    }

    .ph-box-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .ph-box-icon svg {
        width: 18px;
        height: 18px;
    }

    .ph-box:nth-child(1) .ph-box-icon {
        background: var(--ph-primary-light);
        color: var(--ph-primary);
    }

    .ph-box:nth-child(2) .ph-box-icon {
        background: #f3f0ff;
        color: #8b5cf6;
    }

    .ph-box:nth-child(3) .ph-box-icon {
        background: var(--ph-warning-light);
        color: var(--ph-warning);
    }

    .ph-box:nth-child(4) .ph-box-icon {
        background: var(--ph-gray-light);
        color: var(--ph-gray);
    }

    .ph-box:nth-child(5) .ph-box-icon {
        background: var(--ph-success-light);
        color: var(--ph-success);
    }

    .ph-box:nth-child(6) .ph-box-icon {
        background: var(--ph-danger-light);
        color: var(--ph-danger);
    }

    .ph-num {
        font-weight: 800;
        font-size: 22px;
        color: var(--ph-dark);
        line-height: 1;
        margin-bottom: 4px;
    }

    .ph-label {
        font-size: 11px;
        color: var(--ph-gray);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ── Section Title ── */
    .ph-section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--ph-dark);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ph-section-title svg {
        width: 20px;
        height: 20px;
        color: var(--ph-primary);
    }

    .ph-pool-count {
        font-size: 12px;
        font-weight: 700;
        background: var(--ph-primary);
        color: #fff;
        padding: 2px 10px;
        border-radius: 20px;
        margin-left: 4px;
    }

    /* ── Pool Card ── */
    .ph-card {
        background: var(--ph-card-bg);
        border-radius: var(--ph-radius);
        border: 1px solid var(--ph-border);
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: var(--ph-shadow);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .ph-card:hover {
        box-shadow: var(--ph-shadow-lg);
        transform: translateY(-1px);
    }

    .ph-head {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--ph-border);
        gap: 12px;
    }

    .ph-head-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        flex: 1;
    }

    .ph-pool-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--ph-primary-light), #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ph-pool-icon svg {
        width: 20px;
        height: 20px;
        color: var(--ph-primary);
    }

    .ph-name {
        font-weight: 700;
        font-size: 15px;
        color: var(--ph-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ph-score-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 25px;
        white-space: nowrap;
        min-width: fit-content;
    }

    .ph-score-badge.good {
        background: var(--ph-success-light);
        color: var(--ph-success);
    }

    .ph-score-badge.avg {
        background: var(--ph-warning-light);
        color: var(--ph-warning);
    }

    .ph-score-badge.poor {
        background: var(--ph-danger-light);
        color: var(--ph-danger);
    }

    /* ── Progress Bar ── */
    .ph-progress-wrap {
        padding: 0 20px;
        padding-top: 16px;
    }

    .ph-progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .ph-progress-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--ph-gray);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .ph-progress-val {
        font-size: 12px;
        font-weight: 700;
        color: var(--ph-dark);
    }

    .ph-progress-bar {
        width: 100%;
        height: 6px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .ph-progress-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .ph-progress-fill.good {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .ph-progress-fill.avg {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .ph-progress-fill.poor {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    /* ── Stat Row ── */
    .ph-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        padding: 16px 20px;
    }

    .ph-stat {
        text-align: center;
        border-radius: var(--ph-radius-xs);
        padding: 12px 8px;
        position: relative;
    }

    .ph-stat.attempted {
        background: var(--ph-warning-light);
    }

    .ph-stat.skipped {
        background: var(--ph-gray-light);
    }

    .ph-stat.correct {
        background: var(--ph-success-light);
    }

    .ph-stat.wrong {
        background: var(--ph-danger-light);
    }

    .ph-stat-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
    }

    .ph-stat-icon svg {
        width: 14px;
        height: 14px;
    }

    .ph-stat.attempted .ph-stat-icon {
        background: rgba(245, 158, 11, 0.15);
        color: var(--ph-warning);
    }

    .ph-stat.skipped .ph-stat-icon {
        background: rgba(107, 114, 128, 0.12);
        color: var(--ph-gray);
    }

    .ph-stat.correct .ph-stat-icon {
        background: rgba(16, 185, 129, 0.15);
        color: var(--ph-success);
    }

    .ph-stat.wrong .ph-stat-icon {
        background: rgba(239, 68, 68, 0.15);
        color: var(--ph-danger);
    }

    .ph-stat-num {
        font-weight: 800;
        font-size: 18px;
        line-height: 1;
        margin-bottom: 3px;
    }

    .ph-stat.attempted .ph-stat-num {
        color: var(--ph-warning);
    }

    .ph-stat.skipped .ph-stat-num {
        color: var(--ph-gray);
    }

    .ph-stat.correct .ph-stat-num {
        color: var(--ph-success);
    }

    .ph-stat.wrong .ph-stat-num {
        color: var(--ph-danger);
    }

    .ph-stat-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .ph-stat.attempted .ph-stat-label {
        color: #b45309;
    }

    .ph-stat.skipped .ph-stat-label {
        color: #6b7280;
    }

    .ph-stat.correct .ph-stat-label {
        color: #047857;
    }

    .ph-stat.wrong .ph-stat-label {
        color: #b91c1c;
    }

    /* ── Empty State ── */
    .ph-empty {
        text-align: center;
        padding: 60px 20px;
        background: var(--ph-card-bg);
        border-radius: var(--ph-radius);
        border: 2px dashed var(--ph-border);
    }

    .ph-empty-icon {
        width: 80px;
        height: 80px;
        background: var(--ph-primary-light);
        border-radius: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .ph-empty-icon svg {
        width: 36px;
        height: 36px;
        color: var(--ph-primary);
        opacity: 0.7;
    }

    .ph-empty h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--ph-dark);
        margin: 0 0 6px;
    }

    .ph-empty p {
        font-size: 14px;
        color: var(--ph-gray);
        margin: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .ph-wrap {
            padding: 20px 0 50px;
        }

        .ph-container {
            padding: 0 16px;
        }

        .ph-header-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
        }

        .ph-header-icon svg {
            width: 24px;
            height: 24px;
        }

        .ph-title {
            font-size: 22px;
        }

        .ph-sub {
            font-size: 13px;
        }

        .ph-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .ph-box {
            padding: 14px 8px;
        }

        .ph-box-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .ph-box-icon svg {
            width: 15px;
            height: 15px;
        }

        .ph-num {
            font-size: 18px;
        }

        .ph-card {
            border-radius: var(--ph-radius-sm);
        }

        .ph-head {
            padding: 14px 16px;
        }

        .ph-pool-icon {
            width: 36px;
            height: 36px;
            min-width: 36px;
            border-radius: 10px;
        }

        .ph-pool-icon svg {
            width: 18px;
            height: 18px;
        }

        .ph-name {
            font-size: 14px;
        }

        .ph-score-badge {
            font-size: 12px;
            padding: 5px 10px;
        }

        .ph-progress-wrap {
            padding: 0 16px;
            padding-top: 14px;
        }

        .ph-row {
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            padding: 14px 16px;
        }

        .ph-stat {
            padding: 10px 4px;
        }

        .ph-stat-icon {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            margin-bottom: 5px;
        }

        .ph-stat-icon svg {
            width: 12px;
            height: 12px;
        }

        .ph-stat-num {
            font-size: 15px;
        }

        .ph-stat-label {
            font-size: 9px;
        }
    }

    @media (max-width: 420px) {
        .ph-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .ph-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .ph-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .ph-score-badge {
            align-self: flex-start;
        }
    }

    /* ── Animation ── */
    @keyframes phFadeUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .ph-animate {
        animation: phFadeUp 0.4s ease forwards;
        opacity: 0;
    }

    .ph-card:nth-child(1) {
        animation-delay: 0.05s;
    }

    .ph-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .ph-card:nth-child(3) {
        animation-delay: 0.15s;
    }

    .ph-card:nth-child(4) {
        animation-delay: 0.2s;
    }

    .ph-card:nth-child(5) {
        animation-delay: 0.25s;
    }

    .ph-card:nth-child(6) {
        animation-delay: 0.3s;
    }

    .ph-card:nth-child(7) {
        animation-delay: 0.35s;
    }

    .ph-card:nth-child(8) {
        animation-delay: 0.4s;
    }

    .ph-card:nth-child(9) {
        animation-delay: 0.45s;
    }

    .ph-card:nth-child(10) {
        animation-delay: 0.5s;
    }
</style>

<div class="ph-wrap">
    <div class="ph-container">

        <!-- ── Header ── -->
        <div class="ph-header">
            <div class="ph-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="ph-title">My Pool History</h1>
            <p class="ph-sub">Quick overview of your performance across all pools</p>
        </div>

        <!-- ── Overall Stats ── -->
        <?php if (!empty($overall)): ?>
            <div class="ph-stats">

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['pools'] ?></div>
                    <div class="ph-label">Pools</div>
                </div>

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['questions'] ?></div>
                    <div class="ph-label">Questions</div>
                </div>

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['attempted'] ?></div>
                    <div class="ph-label">Attempted</div>
                </div>

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 010 1.954l-7.108 4.061A1.125 1.125 0 013 16.811V8.69zM12.75 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 010 1.954l-7.108 4.061a1.125 1.125 0 01-1.683-.977V8.69z" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['not_attempted'] ?></div>
                    <div class="ph-label">Skipped</div>
                </div>

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['correct'] ?></div>
                    <div class="ph-label">Correct</div>
                </div>

                <div class="ph-box">
                    <div class="ph-box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ph-num"><?= $overall['wrong'] ?></div>
                    <div class="ph-label">Wrong</div>
                </div>

            </div>
        <?php endif; ?>

        <!-- ── Pool List ── -->
        <?php if (empty($history)): ?>

            <div class="ph-empty">
                <div class="ph-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <h3>No Pool History Found</h3>
                <p>Start attempting pools to see your performance here.</p>
            </div>

        <?php else: ?>

            <div class="ph-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
                Pool Results
                <span class="ph-pool-count"><?= count($history) ?></span>
            </div>

            <?php foreach ($history as $pool):
                $pct = ($pool['total_questions'] > 0)
                    ? round(($pool['correct_answers'] / $pool['total_questions']) * 100)
                    : 0;

                if ($pct >= 70) $grade = 'good';
                elseif ($pct >= 40) $grade = 'avg';
                else $grade = 'poor';
            ?>

                <div class="ph-card ph-animate">

                    <div class="ph-head">
                        <div class="ph-head-left">
                            <div class="ph-pool-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="ph-name"><?= html_escape($pool['pool_name']) ?></div>
                        </div>
                        <div class="ph-score-badge <?= $grade ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <?php if ($grade === 'good'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                <?php elseif ($grade === 'avg'): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                <?php endif; ?>
                            </svg>
                            <?= $pool['correct_answers'] ?>/<?= $pool['total_questions'] ?>
                            (<?= $pct ?>%)
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div class="ph-progress-wrap">
                        <div class="ph-progress-info">
                            <span class="ph-progress-label">Accuracy</span>
                            <span class="ph-progress-val"><?= $pct ?>%</span>
                        </div>
                        <div class="ph-progress-bar">
                            <div class="ph-progress-fill <?= $grade ?>" style="width:<?= $pct ?>%"></div>
                        </div>
                    </div>

                    <div class="ph-row">

                        <div class="ph-stat attempted">
                            <div class="ph-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                </svg>
                            </div>
                            <div class="ph-stat-num"><?= $pool['attempted'] ?></div>
                            <div class="ph-stat-label">Attempted</div>
                        </div>

                        <div class="ph-stat skipped">
                            <div class="ph-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.689c0-.864.933-1.406 1.683-.977l7.108 4.061a1.125 1.125 0 010 1.954l-7.108 4.061A1.125 1.125 0 013 16.811V8.69z" />
                                </svg>
                            </div>
                            <div class="ph-stat-num"><?= $pool['not_attempted'] ?></div>
                            <div class="ph-stat-label">Skipped</div>
                        </div>

                        <div class="ph-stat correct">
                            <div class="ph-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="ph-stat-num"><?= $pool['correct_answers'] ?></div>
                            <div class="ph-stat-label">Correct</div>
                        </div>

                        <div class="ph-stat wrong">
                            <div class="ph-stat-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="ph-stat-num"><?= $pool['wrong_answers'] ?></div>
                            <div class="ph-stat-label">Wrong</div>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>