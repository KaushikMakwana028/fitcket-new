    <?php
    // cricket_question_matches_view.php
    // All CSS is scoped under .cqm-root — nothing leaks to sidebar/header

    $maxQ    = (int)($max_questions ?? 10);
    $matches = $matches ?? [];
    $search  = $search ?? '';
    $stats   = $stats ?? ['total' => 0, 'live' => 0, 'today' => 0, 'upcoming' => 0, 'completed' => 0];
    $totalRows   = (int)($total_rows ?? 0);
    $perPage     = (int)($per_page ?? 12);
    $currentPage = (int)($current_page ?? 0);
    $pagination  = $pagination ?? '';

    // ── helpers ──────────────────────────────────────────────────
    function cqm_bucket(array $m): string
    {
        $now   = time();
        $ts    = strtotime((string)($m['start_at'] ?? '')) ?: 0;
        $s     = strtolower((string)($m['admin_status'] ?? ''));
        if ($s === 'live' || ($ts > 0 && $ts <= $now && $ts >= ($now - 8 * 3600) && $s !== 'completed')) return 'live';
        if ($ts >= mktime(0, 0, 0) && $ts <= mktime(23, 59, 59) && $s !== 'completed') return 'today';
        if ($ts > $now && $s !== 'completed') return 'upcoming';
        return 'completed';
    }
    function cqm_badge_state(int $c, int $x): string
    {
        if ($c === 0) return 'empty';
        if ($c >= $x)  return 'full';
        return 'partial';
    }
    function cqm_pct(int $c, int $x): int
    {
        return $x > 0 ? (int)min(100, round($c / $x * 100)) : 0;
    }
    ?>
    <style>
        /* ── Import scoped to .cqm-root only ───────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        .cqm-root {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0e1f3d;
            /* NO background, NO min-height, NO overflow — let the admin layout handle that */
            padding: 20px 24px 40px;
            width: 100%;
            max-width: 100%;
        }

        .cqm-root *,
        .cqm-root *::before,
        .cqm-root *::after {
            box-sizing: border-box;
        }

        /* ── Hero ────────────────────────────────────────────────────
    Key fix: no negative margins, no overflow:hidden, no 100vw.
    Uses border-radius so it sits cleanly inside the content area.
    */
        .cqm-hero {
            border-radius: 16px;
            background: linear-gradient(130deg, #0b1e42 0%, #1352b8 55%, #2b8fff 100%);
            padding: 28px 26px 24px;
            color: #fff;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            /* only clips the decorative blobs inside */
        }

        .cqm-hero-orb {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
            pointer-events: none;
        }

        .cqm-hero-orb-a {
            width: 180px;
            height: 180px;
            top: -55px;
            right: -40px;
        }

        .cqm-hero-orb-b {
            width: 110px;
            height: 110px;
            bottom: -45px;
            right: 90px;
        }

        .cqm-hero-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        .cqm-hero-eyebrow {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            opacity: 0.6;
            margin-bottom: 7px;
        }

        .cqm-hero h1 {
            font-size: clamp(18px, 2.5vw, 26px);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 7px;
            color: #fff;
        }

        .cqm-hero p {
            font-size: 13px;
            opacity: 0.7;
            line-height: 1.6;
            max-width: 420px;
            color: #fff;
            margin: 0;
        }

        .cqm-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #fff !important;
            border-radius: 100px;
            padding: 7px 16px;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none !important;
            transition: background 0.17s;
            flex-shrink: 0;
            align-self: flex-start;
        }

        .cqm-btn-back:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #fff !important;
        }

        /* hero stat pills */
        .cqm-hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .cqm-stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
        }

        .cqm-stat-pill .cqm-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .cqm-dot-live {
            background: #4ade80;
            box-shadow: 0 0 5px #4ade8088;
        }

        .cqm-dot-today {
            background: #fbbf24;
        }

        .cqm-dot-upcoming {
            background: #60a5fa;
        }

        .cqm-dot-done {
            background: rgba(255, 255, 255, 0.4);
        }

        /* ── Panel ───────────────────────────────────────────────────*/
        .cqm-panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #dce6f5;
            box-shadow: 0 1px 12px rgba(11, 30, 66, 0.07);
            padding: 20px;
        }

        .cqm-panel-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        .cqm-panel-top h2 {
            font-size: 15px;
            font-weight: 700;
            color: #0e1f3d;
            margin-bottom: 2px;
        }

        .cqm-panel-top p {
            font-size: 12px;
            color: #7a8eaa;
            margin: 0;
        }

        .cqm-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e8f1ff;
            color: #1352b8;
            border-radius: 100px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ── Search bar ──────────────────────────────────────────────*/
        .cqm-search-form {
            margin-bottom: 18px;
        }

        .cqm-search-inner {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f3f6fc;
            border: 1.5px solid #dce6f5;
            border-radius: 10px;
            padding: 8px 13px;
            transition: border-color 0.17s;
        }

        .cqm-search-inner:focus-within {
            border-color: #1352b8;
        }

        .cqm-search-inner input {
            background: transparent;
            border: none;
            outline: none;
            font-size: 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0e1f3d;
            flex: 1;
            min-width: 0;
        }

        .cqm-search-inner input::placeholder {
            color: #9aabc0;
        }

        .cqm-search-btn {
            background: #1352b8;
            border: none;
            border-radius: 7px;
            color: #fff;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background 0.16s;
            white-space: nowrap;
        }

        .cqm-search-btn:hover {
            background: #0e44a0;
        }

        /* ── Section headers (Live / Today / Upcoming / Completed) ───*/
        .cqm-section-hdr {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0 12px;
        }

        .cqm-section-hdr:first-child {
            margin-top: 0;
        }

        .cqm-section-hdr span {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .cqm-section-hdr hr {
            flex: 1;
            border: none;
            border-top: 1.5px solid #edf1f9;
            margin: 0;
        }

        .cqm-hdr-live span {
            color: #059669;
        }

        .cqm-hdr-today span {
            color: #d97706;
        }

        .cqm-hdr-upcoming span {
            color: #2563eb;
        }

        .cqm-hdr-completed span {
            color: #6b7e99;
        }

        /* ── Cards grid ──────────────────────────────────────────────*/
        .cqm-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 270px), 1fr));
            gap: 12px;
            margin-bottom: 4px;
        }

        /* ── Card ────────────────────────────────────────────────────*/
        .cqm-card {
            background: #fff;
            border: 1.5px solid #dce6f5;
            border-radius: 14px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: box-shadow 0.2s, border-color 0.2s, transform 0.17s;
            animation: cqmFadeUp 0.3s ease both;
        }

        @keyframes cqmFadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cqm-card:nth-child(1) {
            animation-delay: .03s
        }

        .cqm-card:nth-child(2) {
            animation-delay: .06s
        }

        .cqm-card:nth-child(3) {
            animation-delay: .09s
        }

        .cqm-card:nth-child(4) {
            animation-delay: .12s
        }

        .cqm-card:nth-child(5) {
            animation-delay: .15s
        }

        .cqm-card:nth-child(6) {
            animation-delay: .18s
        }

        .cqm-card:nth-child(n+7) {
            animation-delay: .21s
        }

        .cqm-card-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            opacity: 0;
            transition: opacity 0.2s;
            border-radius: 14px 14px 0 0;
        }

        .cqm-card:hover {
            box-shadow: 0 5px 24px rgba(11, 30, 66, 0.11);
            border-color: #a8c1ef;
            transform: translateY(-2px);
        }

        .cqm-card:hover .cqm-card-bar {
            opacity: 1;
        }

        /* status-based left accent */
        .cqm-card[data-bucket="live"] {
            border-left: 3px solid #10b981;
        }

        .cqm-card[data-bucket="today"] {
            border-left: 3px solid #f59e0b;
        }

        .cqm-card[data-bucket="upcoming"] {
            border-left: 3px solid #3b82f6;
        }

        .cqm-card[data-bucket="completed"] {
            border-left: 3px solid #d1d9e6;
        }

        .cqm-card[data-bucket="live"] .cqm-card-bar {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        .cqm-card[data-bucket="today"] .cqm-card-bar {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .cqm-card[data-bucket="upcoming"] .cqm-card-bar {
            background: linear-gradient(90deg, #1352b8, #2b8fff);
        }

        .cqm-card[data-bucket="completed"] .cqm-card-bar {
            background: linear-gradient(90deg, #94a3b8, #cbd5e1);
        }

        /* bucket badge top-right */
        .cqm-bucket-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 100px;
            padding: 3px 9px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.04em;
            flex-shrink: 0;
        }

        .cqm-bb-live {
            background: #d1fae5;
            color: #065f46;
        }

        .cqm-bb-today {
            background: #fef3c7;
            color: #92400e;
        }

        .cqm-bb-upcoming {
            background: #dbeafe;
            color: #1e40af;
        }

        .cqm-bb-completed {
            background: #f1f5f9;
            color: #64748b;
        }

        /* card head */
        .cqm-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 10px;
        }

        .cqm-team-name {
            font-size: 14.5px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            flex: 1;
        }

        .cqm-comp {
            font-size: 11px;
            color: #7a8eaa;
            margin-top: 2px;
            font-weight: 500;
        }

        /* q-count badge */
        .cqm-qbadge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 9px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .cqm-qb-full {
            background: #dcfce7;
            color: #166534;
        }

        .cqm-qb-partial {
            background: #fef9c3;
            color: #854d0e;
        }

        .cqm-qb-empty {
            background: #f1f5f9;
            color: #64748b;
        }

        /* progress */
        .cqm-prog {
            background: #edf1f9;
            border-radius: 99px;
            height: 4px;
            margin-bottom: 12px;
            overflow: hidden;
        }

        .cqm-prog-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #1352b8, #2b8fff);
            transition: width 0.4s ease;
        }

        .cqm-prog-fill.cqm-pf-full {
            background: linear-gradient(90deg, #10b981, #34d399);
        }

        /* meta */
        .cqm-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px 10px;
            margin-bottom: 13px;
            flex: 1;
        }

        .cqm-mi {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .cqm-mi-full {
            grid-column: 1 / -1;
        }

        .cqm-ml {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #9aabc0;
        }

        .cqm-mv {
            font-size: 12px;
            font-weight: 500;
            color: #1a2f50;
            line-height: 1.4;
        }

        .cqm-pool-tag {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: #e8f1ff;
            color: #1352b8;
            border-radius: 5px;
            padding: 1px 7px;
            font-size: 11px;
            font-weight: 700;
        }

        .cqm-pool-toggle {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e8f1ff;
            color: #1352b8;
            border: 0;
            border-radius: 7px;
            padding: 4px 8px;
            font-size: 11px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background 0.16s, transform 0.12s;
        }

        .cqm-pool-toggle:hover {
            background: #d8e8ff;
        }

        .cqm-pool-toggle:active {
            transform: scale(0.98);
        }

        .cqm-pool-toggle svg {
            flex-shrink: 0;
        }

        .cqm-pool-modal {
            position: fixed;
            inset: 0;
            z-index: 1200;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cqm-pool-modal.is-open {
            display: flex;
        }

        .cqm-pool-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(7, 20, 45, 0.52);
            backdrop-filter: blur(4px);
        }

        .cqm-pool-modal-card {
            position: relative;
            width: min(100%, 720px);
            max-height: min(84vh, 780px);
            overflow: hidden;
            border-radius: 18px;
            background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
            border: 1px solid #d8e5f7;
            box-shadow: 0 30px 80px rgba(10, 29, 61, 0.22);
            animation: cqmFadeUp 0.22s ease both;
        }

        .cqm-pool-modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 18px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            background: linear-gradient(130deg, #0b1e42 0%, #1352b8 55%, #2b8fff 100%);
            color: #fff;
        }

        .cqm-pool-modal-title {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.25;
            margin: 0 0 3px;
            color: #fff;
        }

        .cqm-pool-modal-subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .cqm-pool-modal-close {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            cursor: pointer;
            transition: background 0.16s;
            flex-shrink: 0;
        }

        .cqm-pool-modal-close:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        .cqm-pool-modal-body {
            padding: 16px 18px 18px;
            overflow-y: auto;
            max-height: calc(min(84vh, 780px) - 88px);
        }

        .cqm-pool-list-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .cqm-pool-list-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1352b8;
        }

        .cqm-pool-list-note {
            font-size: 10px;
            color: #6f84a3;
            text-align: right;
        }

        .cqm-pool-list-grid {
            display: grid;
            gap: 10px;
        }

        .cqm-pool-chip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 13px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid #dbe7fb;
            box-shadow: 0 8px 22px rgba(17, 52, 103, 0.05);
        }

        .cqm-pool-chip-main {
            min-width: 0;
        }

        .cqm-pool-chip-name {
            font-size: 12px;
            font-weight: 700;
            color: #163158;
            line-height: 1.35;
            word-break: break-word;
        }

        .cqm-pool-chip-host {
            font-size: 11px;
            color: #6f84a3;
            margin-top: 2px;
        }

        .cqm-pool-chip-badge {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 999px;
            background: #eef4ff;
            color: #1352b8;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        body.cqm-modal-open {
            overflow: hidden;
        }

        /* CTA */
        .cqm-btn-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 9px;
            background: #1352b8;
            color: #fff !important;
            border: none;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            text-decoration: none !important;
            transition: background 0.16s, transform 0.12s;
        }

        .cqm-btn-cta:hover {
            background: #0d44a0;
            color: #fff !important;
            text-decoration: none !important;
        }

        .cqm-btn-cta:active {
            transform: scale(0.98);
        }

        /* empty state */
        .cqm-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 48px 20px;
            color: #7a8eaa;
        }

        .cqm-empty-ico {
            width: 48px;
            height: 48px;
            background: #e8f1ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 11px;
        }

        .cqm-empty strong {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #1a2f50;
            margin-bottom: 4px;
        }

        .cqm-empty span {
            font-size: 12px;
        }

        /* ── Pagination ───────────────────────────────────────────── */
        .cqm-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #edf1f9;
        }

        .cqm-page-info {
            font-size: 12px;
            color: #7a8eaa;
        }

        .cqm-page-info strong {
            color: #0e1f3d;
        }

        .cqm-pagination .pagination {
            margin: 0 !important;
            gap: 3px;
        }

        .cqm-pagination .page-link {
            border-radius: 7px !important;
            font-size: 12.5px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 5px 10px;
            border-color: #dce6f5 !important;
            color: #1352b8;
        }

        .cqm-pagination .page-item.active .page-link {
            background: #1352b8 !important;
            border-color: #1352b8 !important;
            color: #fff;
        }

        .cqm-pagination .page-item.disabled .page-link {
            color: #c5cfe0;
        }

        /* ── Responsive ───────────────────────────────────────────── */
        @media (max-width: 768px) {
            .cqm-root {
                padding: 14px 12px 32px;
            }

            .cqm-hero {
                padding: 20px 16px 18px;
            }

            .cqm-panel {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .cqm-meta {
                grid-template-columns: 1fr;
            }

            .cqm-mi-full {
                grid-column: 1;
            }

            .cqm-panel-top {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="cqm-root">

                    <!-- ── Hero ────────────────────────────────────────────── -->
                    <div class="cqm-hero">
                        <div class="cqm-hero-orb cqm-hero-orb-a"></div>
                        <div class="cqm-hero-orb cqm-hero-orb-b"></div>

                        <div class="cqm-hero-row">
                            <div>
                                <div class="cqm-hero-eyebrow">&#9679; Cricket Admin</div>
                                <h1>Add Questions by Match</h1>
                                <p>Questions and answer keys saved here are shared across all pools linked to that match.</p>
                            </div>
                            <a href="<?= base_url('admin/cricket_matches') ?>" class="cqm-btn-back">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 12H5" />
                                    <polyline points="12 19 5 12 12 5" />
                                </svg>
                                All Matches
                            </a>
                        </div>

                        <div class="cqm-hero-stats">
                            <?php if ($stats['live'] > 0): ?>
                                <span class="cqm-stat-pill">
                                    <span class="cqm-dot cqm-dot-live"></span>
                                    <?= $stats['live'] ?> Live
                                </span>
                            <?php endif; ?>
                            <?php if ($stats['today'] > 0): ?>
                                <span class="cqm-stat-pill">
                                    <span class="cqm-dot cqm-dot-today"></span>
                                    <?= $stats['today'] ?> Today
                                </span>
                            <?php endif; ?>
                            <?php if ($stats['upcoming'] > 0): ?>
                                <span class="cqm-stat-pill">
                                    <span class="cqm-dot cqm-dot-upcoming"></span>
                                    <?= $stats['upcoming'] ?> Upcoming
                                </span>
                            <?php endif; ?>
                            <span class="cqm-stat-pill">
                                <span class="cqm-dot cqm-dot-done"></span>
                                <?= $stats['total'] ?> Total
                            </span>
                        </div>
                    </div>

                    <!-- ── Panel ───────────────────────────────────────────── -->
                    <div class="cqm-panel">

                        <div class="cqm-panel-top">
                            <div>
                                <h2>Select a Match</h2>
                                <p>Choose one match to manage its shared question set.</p>
                            </div>
                            <span class="cqm-count-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" y1="8" x2="12" y2="12" />
                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                </svg>
                                <?= (int)$totalRows ?> Matches
                            </span>
                        </div>

                        <!-- Search -->
                        <form method="get" action="<?= base_url('admin/cricket_questions') ?>" class="cqm-search-form">
                            <input type="hidden" name="page" value="0">
                            <div class="cqm-search-inner">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9aabc0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                                <input
                                    type="text"
                                    name="search"
                                    value="<?= html_escape($search) ?>"
                                    placeholder="Search by team, competition, or venue…"
                                    autocomplete="off">
                                <?php if ($search !== ''): ?>
                                    <a href="<?= base_url('admin/cricket_questions') ?>" style="color:#9aabc0;text-decoration:none;font-size:18px;line-height:1;flex-shrink:0;" title="Clear">&times;</a>
                                <?php endif; ?>
                                <button type="submit" class="cqm-search-btn">Search</button>
                            </div>
                        </form>

                        <?php
                        // ── Group current page matches by bucket ───────────────
                        $groups = ['live' => [], 'today' => [], 'upcoming' => [], 'completed' => []];
                        foreach ($matches as $m) {
                            $b = cqm_bucket($m);
                            $groups[$b][] = $m;
                        }
                        $groupMeta = [
                            'live'      => ['label' => '🔴 Live Now',    'hdr_cls' => 'cqm-hdr-live',      'dot' => '#10b981'],
                            'today'     => ['label' => '📅 Today',       'hdr_cls' => 'cqm-hdr-today',     'dot' => '#f59e0b'],
                            'upcoming'  => ['label' => '🕐 Upcoming',    'hdr_cls' => 'cqm-hdr-upcoming',  'dot' => '#3b82f6'],
                            'completed' => ['label' => '✅ Completed',   'hdr_cls' => 'cqm-hdr-completed', 'dot' => '#94a3b8'],
                        ];
                        $anyMatch = false;
                        foreach ($groups as $g) {
                            if (!empty($g)) {
                                $anyMatch = true;
                                break;
                            }
                        }
                        ?>

                        <?php if (!$anyMatch): ?>
                            <div class="cqm-grid">
                                <div class="cqm-empty">
                                    <div class="cqm-empty-ico">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1352b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8" />
                                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                        </svg>
                                    </div>
                                    <strong><?= $search ? 'No matches found' : 'No cricket matches' ?></strong>
                                    <span><?= $search ? 'Try a different search term.' : 'Add matches from the cricket matches panel.' ?></span>
                                </div>
                            </div>
                        <?php else: ?>

                            <?php foreach ($groupMeta as $bucket => $meta):
                                if (empty($groups[$bucket])) continue;
                            ?>
                                <!-- Section header -->
                                <div class="cqm-section-hdr <?= $meta['hdr_cls'] ?>">
                                    <span><?= $meta['label'] ?></span>
                                    <hr>
                                    <span style="font-size:11px;font-weight:600;color:#9aabc0;white-space:nowrap;"><?= count($groups[$bucket]) ?></span>
                                </div>

                                <div class="cqm-grid">
                                    <?php foreach ($groups[$bucket] as $m):
                                        $qc   = (int)($m['question_count'] ?? 0);
                                        $pct  = cqm_pct($qc, $maxQ);
                                        $bSt  = cqm_badge_state($qc, $maxQ);
                                        $pfCls = ($bSt === 'full') ? 'cqm-pf-full' : '';
                                        $teams = trim(($m['team_home'] ?? '') . ' vs ' . ($m['team_away'] ?? ''));

                                        if ($bSt === 'full'):
                                            $qIcon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
                                            $qBCls = 'cqm-qb-full';
                                        elseif ($bSt === 'partial'):
                                            $qIcon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                                            $qBCls = 'cqm-qb-partial';
                                        else:
                                            $qIcon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>';
                                            $qBCls = 'cqm-qb-empty';
                                        endif;

                                        $isEdit   = $qc > 0;
                                        $btnLabel = $isEdit ? 'Edit Questions' : 'Add Questions';
                                        $btnIcon  = $isEdit
                                            ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>'
                                            : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';

                                        // bucket badge
                                        $bbLabel = ['live' => 'LIVE', 'today' => 'TODAY', 'upcoming' => 'UPCOMING', 'completed' => 'DONE'][$bucket];
                                        $bbCls   = ['live' => 'cqm-bb-live', 'today' => 'cqm-bb-today', 'upcoming' => 'cqm-bb-upcoming', 'completed' => 'cqm-bb-completed'][$bucket];
                                    ?>
                                        <div class="cqm-card" data-bucket="<?= $bucket ?>">
                                            <div class="cqm-card-bar"></div>

                                            <div class="cqm-card-head">
                                                <div>
                                                    <div class="cqm-team-name"><?= html_escape($teams) ?></div>
                                                    <div class="cqm-comp"><?= html_escape($m['competition_name'] ?: 'Cricket Match') ?></div>
                                                </div>
                                                <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0;">
                                                    <span class="cqm-bucket-badge <?= $bbCls ?>"><?= $bbLabel ?></span>
                                                    <span class="cqm-qbadge <?= $qBCls ?>"><?= $qIcon ?> <?= $qc ?>/<?= $maxQ ?></span>
                                                </div>
                                            </div>

                                            <div class="cqm-prog">
                                                <div class="cqm-prog-fill <?= $pfCls ?>" style="width:<?= $pct ?>%"></div>
                                            </div>

                                            <div class="cqm-meta">
                                                <div class="cqm-mi">
                                                    <span class="cqm-ml">Date</span>
                                                    <span class="cqm-mv"><?= !empty($m['start_at']) ? date('d M Y, h:i A', strtotime($m['start_at'])) : 'Not set' ?></span>
                                                </div>
                                                <div class="cqm-mi">
                                                    <span class="cqm-ml">Linked Pools</span>
                                                    <span class="cqm-mv">
                                                        <button
                                                            type="button"
                                                            class="cqm-pool-toggle"
                                                            data-linked-pools='<?= html_escape(json_encode(array_values($m["linked_pools"] ?? []), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)) ?>'>
                                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82L4.21 7.2a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.01A1.65 1.65 0 0 0 10 3.25V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.01a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.01a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                                            </svg>
                                                            <?= (int)($m['linked_pool_count'] ?? 0) ?> pools
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="cqm-mi cqm-mi-full">
                                                    <span class="cqm-ml">Venue</span>
                                                    <span class="cqm-mv"><?= html_escape($m['venue'] ?: 'Venue TBA') ?></span>
                                                </div>
                                            </div>

                                            <a href="<?= base_url('admin/cricket_questions/' . (int)$m['id']) ?>" class="cqm-btn-cta">
                                                <?= $btnIcon ?> <?= $btnLabel ?>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div><!-- /cqm-grid -->

                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- ── Pagination ─────────────────────────────────── -->
                        <?php if ($totalRows > $perPage): ?>
                            <div class="cqm-pagination">
                                <div class="cqm-page-info">
                                    Showing
                                    <strong><?= min($currentPage + 1, $totalRows) ?>–<?= min($currentPage + $perPage, $totalRows) ?></strong>
                                    of <strong><?= $totalRows ?></strong> matches
                                </div>
                                <nav><?= $pagination ?></nav>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div id="cqm-pool-modal" class="cqm-pool-modal" aria-hidden="true">
                    <div class="cqm-pool-modal-backdrop" data-modal-close="true"></div>
                    <div class="cqm-pool-modal-card" role="dialog" aria-modal="true" aria-labelledby="cqm-pool-modal-title">
                        <div class="cqm-pool-modal-head">
                            <div>
                                <h3 id="cqm-pool-modal-title" class="cqm-pool-modal-title">Linked Pools</h3>
                                <p id="cqm-pool-modal-subtitle" class="cqm-pool-modal-subtitle">All linked pool and host details</p>
                            </div>
                            <button type="button" class="cqm-pool-modal-close" data-modal-close="true" aria-label="Close">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="cqm-pool-modal-body">
                            <div class="cqm-pool-list-head">
                                <div class="cqm-pool-list-title">Pool Directory</div>
                                <div id="cqm-pool-modal-count" class="cqm-pool-list-note"></div>
                            </div>
                            <div id="cqm-pool-modal-grid" class="cqm-pool-list-grid"></div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = document.getElementById('cqm-pool-modal');
                        var modalTitle = document.getElementById('cqm-pool-modal-title');
                        var modalSubtitle = document.getElementById('cqm-pool-modal-subtitle');
                        var modalCount = document.getElementById('cqm-pool-modal-count');
                        var modalGrid = document.getElementById('cqm-pool-modal-grid');

                        function closeModal() {
                            modal.classList.remove('is-open');
                            modal.setAttribute('aria-hidden', 'true');
                            document.body.classList.remove('cqm-modal-open');
                        }

                        document.querySelectorAll('.cqm-pool-toggle').forEach(function(button) {
                            button.addEventListener('click', function() {
                                var card = button.closest('.cqm-card');
                                if (!card) {
                                    return;
                                }

                                var matchNameEl = card.querySelector('.cqm-team-name');
                                var competitionEl = card.querySelector('.cqm-comp');
                                var matchName = matchNameEl ? matchNameEl.textContent.trim() : 'Linked Pools';
                                var competition = competitionEl ? competitionEl.textContent.trim() : 'Cricket Match';
                                var linkedPools = [];

                                try {
                                    linkedPools = JSON.parse(button.getAttribute('data-linked-pools') || '[]');
                                } catch (e) {
                                    linkedPools = [];
                                }

                                modalTitle.textContent = matchName + ' Linked Pools';
                                modalSubtitle.textContent = competition + ' - shared questions apply to every pool below';
                                modalCount.textContent = linkedPools.length + ' pool' + (linkedPools.length === 1 ? '' : 's');
                                modalGrid.innerHTML = '';

                                if (!linkedPools.length) {
                                    modalGrid.innerHTML = '<div class="cqm-empty" style="padding:28px 12px;"><strong style="font-size:13px;">No linked pools yet</strong><span>This match does not have any visible pools connected right now.</span></div>';
                                } else {
                                    linkedPools.forEach(function(pool) {
                                        var item = document.createElement('div');
                                        item.className = 'cqm-pool-chip';
                                        item.innerHTML =
                                            '<div class="cqm-pool-chip-main">' +
                                            '<div class="cqm-pool-chip-name"></div>' +
                                            '<div class="cqm-pool-chip-host"></div>' +
                                            '</div>' +
                                            '<span class="cqm-pool-chip-badge"></span>';

                                        item.querySelector('.cqm-pool-chip-name').textContent = pool.pool_name || 'Pool';
                                        item.querySelector('.cqm-pool-chip-host').textContent = 'Host: ' + (pool.host_name || 'Host');
                                        var joinedUsers = parseInt(pool.joined_users || 0, 10);
                                        item.querySelector('.cqm-pool-chip-badge').textContent = joinedUsers + ' user' + (joinedUsers === 1 ? '' : 's');
                                        modalGrid.appendChild(item);
                                    });
                                }

                                modal.classList.add('is-open');
                                modal.setAttribute('aria-hidden', 'false');
                                document.body.classList.add('cqm-modal-open');
                            });
                        });

                        modal.querySelectorAll('[data-modal-close="true"]').forEach(function(node) {
                            node.addEventListener('click', closeModal);
                        });

                        document.addEventListener('keydown', function(event) {
                            if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                                closeModal();
                            }
                        });
                    });
                </script>
            </div>
        </div>