<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=swap');

    .cricket-admin-page {
        --bg: linear-gradient(180deg, #f5f8ff 0%, #eef3fb 100%);
        --card: #ffffff;
        --border: #dce4f2;
        --border-strong: #c9d6ee;
        --text: #182033;
        --muted: #6b7892;
        --navy: #12203d;
        --navy-2: #1a2a4f;
        --blue: #1683ff;
        --blue-soft: #e9f3ff;
        --green: #1bbb7b;
        --green-soft: #e9fbf4;
        --orange: #ffb020;
        --orange-soft: #fff5df;
        --red: #ff5f6d;
        --red-soft: #ffecee;
        --shadow: 0 18px 45px rgba(16, 35, 74, 0.08);
        --shadow-soft: 0 10px 28px rgba(16, 35, 74, 0.06);
        font-family: 'Space Grotesk', sans-serif;
        color: var(--text);
    }

    .cricket-admin-page *,
    .cricket-admin-page *::before,
    .cricket-admin-page *::after {
        box-sizing: border-box;
    }

    .cricket-admin-page .page-title,
    .cricket-admin-page .section-title,
    .cricket-admin-page .fixture-teams,
    .cricket-admin-page .stat-number,
    .cricket-admin-page .btn,
    .cricket-admin-page .table thead th {
        font-family: 'Barlow', sans-serif;
    }

    /* ── Dashboard Shell ── */
    .cricket-admin-page .dashboard-shell {
        background: var(--bg);
        padding: 24px;
        border-radius: 28px;
    }

    /* ── Hero Panel ── */
    .cricket-admin-page .hero-panel {
        background:
            radial-gradient(circle at top right, rgba(22, 131, 255, 0.16), transparent 28%),
            radial-gradient(circle at bottom left, rgba(27, 187, 123, 0.14), transparent 24%),
            linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 100%);
        border-radius: 28px;
        padding: 28px 30px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .cricket-admin-page .hero-panel::after {
        content: '';
        position: absolute;
        right: -40px;
        bottom: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    .cricket-admin-page .hero-copy {
        position: relative;
        z-index: 1;
        max-width: 720px;
    }

    .cricket-admin-page .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.88);
        font-size: 0.82rem;
        margin-bottom: 14px;
    }

    .cricket-admin-page .page-title {
        font-size: 2.15rem;
        line-height: 1.1;
        font-weight: 800;
        margin: 0 0 10px;
        letter-spacing: 0.02em;
    }

    .cricket-admin-page .page-subtitle {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.98rem;
        max-width: 640px;
        line-height: 1.5;
    }

    .cricket-admin-page .hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .cricket-admin-page .hero-btn {
        border: 0;
        border-radius: 16px;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.16);
        white-space: nowrap;
        cursor: pointer;
    }

    .cricket-admin-page .hero-btn:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .cricket-admin-page .hero-btn.primary {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
    }

    .cricket-admin-page .hero-btn.secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        box-shadow: none;
        border: 1px solid rgba(255, 255, 255, 0.14);
    }

    /* ── Alerts ── */
    .cricket-admin-page .alert {
        border: 0;
        border-radius: 18px;
        box-shadow: var(--shadow-soft);
        padding: 16px 20px;
        font-size: 0.95rem;
    }

    /* ── Pending Results ── */
    .cricket-admin-page .pending-results-block {
        margin-top: 16px;
    }

    .cricket-admin-page .pending-result-card .card-body {
        border-radius: 20px !important;
        border-left: 5px solid #d43749 !important;
        padding: 20px !important;
    }

    .cricket-admin-page .pending-result-card .pending-result-input {
        border-radius: 12px;
        border: 1px solid #ffccd1;
        padding: 12px 16px;
        font-size: 0.95rem;
        min-height: 48px;
    }

    .cricket-admin-page .pending-result-card .pending-result-input:focus {
        border-color: #d43749;
        box-shadow: 0 0 0 3px rgba(212, 55, 73, 0.12);
        outline: none;
    }

    .cricket-admin-page .pending-result-card .btn-save-result {
        border-radius: 12px;
        background: #d43749;
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(212, 55, 73, 0.3);
        color: #fff;
        white-space: nowrap;
        cursor: pointer;
        font-size: 0.95rem;
        min-height: 48px;
    }

    .cricket-admin-page .pending-result-card .btn-save-result:hover {
        background: #c02f40;
    }

    /* ── Stats Grid ── */
    .cricket-admin-page .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-top: 22px;
    }

    .cricket-admin-page .stat-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 22px;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
    }

    .cricket-admin-page .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--accent);
    }

    .cricket-admin-page .stat-card.total {
        --accent: linear-gradient(90deg, #2f80ed, #56ccf2);
    }

    .cricket-admin-page .stat-card.live {
        --accent: linear-gradient(90deg, #ff5f6d, #ff7f50);
    }

    .cricket-admin-page .stat-card.scheduled {
        --accent: linear-gradient(90deg, #1da1ff, #0066ff);
    }

    .cricket-admin-page .stat-card.completed {
        --accent: linear-gradient(90deg, #16c47f, #3ee089);
    }

    .cricket-admin-page .stat-label {
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--muted);
        font-size: 0.78rem;
        font-weight: 700;
    }

    .cricket-admin-page .stat-number {
        font-size: 2.2rem;
        line-height: 1;
        margin-top: 14px;
        font-weight: 800;
    }

    .cricket-admin-page .stat-hint {
        margin-top: 8px;
        font-size: 0.84rem;
        color: var(--muted);
        line-height: 1.4;
    }

    /* ── Filter & Matches Cards ── */
    .cricket-admin-page .filter-card,
    .cricket-admin-page .matches-card {
        margin-top: 22px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 26px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    .cricket-admin-page .filter-card {
        padding: 24px;
    }

    .cricket-admin-page .section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--blue);
        background: var(--blue-soft);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .cricket-admin-page .section-title {
        font-size: 1.35rem;
        font-weight: 800;
        margin: 0 0 6px;
        color: var(--text);
    }

    .cricket-admin-page .section-copy {
        color: var(--muted);
        margin: 0 0 18px;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .cricket-admin-page .form-label {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 0.92rem;
    }

    .cricket-admin-page .form-control,
    .cricket-admin-page .form-select {
        border-radius: 16px;
        min-height: 50px;
        border: 1px solid var(--border-strong);
        background: #f9fbff;
        box-shadow: none;
        font-size: 0.95rem;
    }

    .cricket-admin-page .form-control:focus,
    .cricket-admin-page .form-select:focus {
        border-color: #76afff;
        box-shadow: 0 0 0 4px rgba(22, 131, 255, 0.12);
        background: #fff;
        outline: none;
    }

    /* ── Matches Card Header ── */
    .cricket-admin-page .matches-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid var(--border);
    }

    .cricket-admin-page .matches-card-header .header-filters {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .cricket-admin-page .matches-card-header .search-wrap {
        position: relative;
    }

    .cricket-admin-page .matches-card-header .search-wrap i {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: 1.1rem;
        pointer-events: none;
    }

    .cricket-admin-page .matches-card-header .search-input {
        padding-left: 40px;
        border-radius: 12px;
        min-height: 42px;
        width: 220px;
        box-shadow: none;
        border: 1px solid var(--border-strong);
        font-size: 0.9rem;
        background: #f9fbff;
    }

    .cricket-admin-page .matches-card-header .status-select {
        border-radius: 12px;
        min-height: 42px;
        width: 150px;
        cursor: pointer;
        border: 1px solid var(--border-strong);
        box-shadow: none;
        font-size: 0.9rem;
        background: #f9fbff;
    }

    /* ── Table ── */
    .cricket-admin-page .matches-table-wrap {
        padding: 8px 18px 18px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .cricket-admin-page .table {
        margin-bottom: 0;
        --bs-table-bg: transparent;
        width: 100%;
    }

    .cricket-admin-page .table thead th {
        border: 0;
        color: var(--muted);
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 14px 12px;
        white-space: nowrap;
    }

    .cricket-admin-page .fixture-row td {
        padding: 16px 12px;
        border-top: 1px solid #edf2fb;
        vertical-align: middle;
    }

    .cricket-admin-page .fixture-row:hover {
        background: linear-gradient(90deg, rgba(22, 131, 255, 0.03), rgba(27, 187, 123, 0.03));
    }

    .cricket-admin-page .fixture-index {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: #f0f5ff;
        color: var(--navy);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .cricket-admin-page .fixture-main {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .cricket-admin-page .fixture-logos {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .cricket-admin-page .fixture-logo {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(180deg, #f8fbff 0%, #eef3fb 100%);
        border: 1px solid #e3ebfa;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
        flex-shrink: 0;
    }

    .cricket-admin-page .fixture-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .cricket-admin-page .fixture-logo .fallback-icon {
        font-size: 1.4rem;
        color: #9aa7c4;
    }

    .cricket-admin-page .fixture-vs {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.74rem;
        box-shadow: 0 8px 18px rgba(255, 95, 109, 0.25);
        flex-shrink: 0;
    }

    .cricket-admin-page .fixture-copy {
        min-width: 0;
    }

    .cricket-admin-page .fixture-teams {
        font-size: 1.16rem;
        font-weight: 800;
        line-height: 1.15;
        color: var(--text);
        word-break: break-word;
    }

    .cricket-admin-page .fixture-meta {
        margin-top: 6px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        color: var(--muted);
        font-size: 0.84rem;
    }

    .cricket-admin-page .fixture-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f4f7fd;
        border: 1px solid #e7edf8;
        white-space: nowrap;
        font-size: 0.82rem;
    }

    .cricket-admin-page .comp-pill {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: #f2f7ff;
        color: #2252a3;
        font-weight: 700;
        font-size: 0.88rem;
        white-space: nowrap;
    }

    .cricket-admin-page .schedule-block {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .cricket-admin-page .schedule-time {
        font-family: 'Barlow', sans-serif;
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--text);
        line-height: 1;
    }

    .cricket-admin-page .schedule-label {
        color: var(--muted);
        font-size: 0.85rem;
    }

    .cricket-admin-page .status-stack {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .cricket-admin-page .status-pill,
    .cricket-admin-page .admin-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        width: fit-content;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .cricket-admin-page .status-pill.live {
        background: var(--red-soft);
        color: #d43749;
    }

    .cricket-admin-page .status-pill.today {
        background: var(--orange-soft);
        color: #cc8400;
    }

    .cricket-admin-page .status-pill.upcoming,
    .cricket-admin-page .status-pill.scheduled {
        background: var(--blue-soft);
        color: #1668d8;
    }

    .cricket-admin-page .status-pill.completed {
        background: var(--green-soft);
        color: #13915f;
    }

    .cricket-admin-page .status-pill.cancelled {
        background: #eef1f7;
        color: #6f7b91;
    }

    .cricket-admin-page .admin-pill {
        background: #f7f9fd;
        color: var(--muted);
    }

    /* ── Actions ── */
    .cricket-admin-page .action-cluster {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }

    .cricket-admin-page .action-btn {
        min-width: 96px;
        border-radius: 14px;
        padding: 10px 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.92rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }

    .cricket-admin-page .action-btn:hover {
        transform: translateY(-1px);
    }

    .cricket-admin-page .action-btn.edit {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(0, 102, 255, 0.18);
    }

    .cricket-admin-page .action-btn.edit:hover {
        color: #fff;
        box-shadow: 0 14px 28px rgba(0, 102, 255, 0.25);
    }

    .cricket-admin-page .action-btn.delete {
        background: #fff1f3;
        color: #d8415b;
        border: 1px solid #ffd2d9;
    }

    .cricket-admin-page .action-btn.delete:hover {
        background: #ffe4e8;
        color: #c0354a;
    }

    /* ── Empty State ── */
    .cricket-admin-page .empty-state {
        padding: 52px 20px;
        text-align: center;
        color: var(--muted);
    }

    .cricket-admin-page .empty-state .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 24px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #edf5ff, #f5fffb);
        color: #1d74db;
        font-size: 2rem;
    }

    /* ── Footer / Pagination ── */
    .cricket-admin-page .card-footer {
        border-top: 1px solid var(--border);
        padding: 16px 22px 22px;
        background: #fff;
    }

    .cricket-admin-page .pagination .page-link {
        border-radius: 12px;
        margin-left: 6px;
        border: 1px solid var(--border);
        color: var(--text);
        min-width: 42px;
        text-align: center;
    }

    .cricket-admin-page .pagination .active .page-link {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        border-color: transparent;
        color: #fff;
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — TABLET (max 1199px)
       ══════════════════════════════════════════ */
    @media (max-width: 1199px) {
        .cricket-admin-page .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cricket-admin-page .matches-card-header .search-input {
            width: 180px;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — SMALL TABLET (max 991px)
       ══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .cricket-admin-page .dashboard-shell {
            padding: 16px;
            border-radius: 20px;
        }

        .cricket-admin-page .hero-panel {
            padding: 22px;
            border-radius: 22px;
            flex-direction: column;
            align-items: flex-start;
        }

        .cricket-admin-page .page-title {
            font-size: 1.7rem;
        }

        .cricket-admin-page .hero-actions {
            width: 100%;
        }

        .cricket-admin-page .hero-btn {
            flex: 1;
            justify-content: center;
            padding: 12px 16px;
            font-size: 0.92rem;
        }

        .cricket-admin-page .matches-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 14px;
        }

        .cricket-admin-page .matches-card-header .header-filters {
            width: 100%;
        }

        .cricket-admin-page .matches-card-header .search-input {
            flex: 1;
            width: 100%;
            min-width: 0;
        }

        .cricket-admin-page .matches-card-header .status-select {
            width: auto;
            min-width: 130px;
        }

        .cricket-admin-page .fixture-main {
            gap: 12px;
        }

        .cricket-admin-page .fixture-logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
        }

        .cricket-admin-page .fixture-vs {
            width: 26px;
            height: 26px;
            font-size: 0.65rem;
        }

        .cricket-admin-page .fixture-teams {
            font-size: 1.02rem;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — MOBILE (max 767px)
       ══════════════════════════════════════════ */
    @media (max-width: 767px) {
        .cricket-admin-page .dashboard-shell {
            padding: 12px;
            border-radius: 16px;
        }

        .cricket-admin-page .hero-panel {
            padding: 18px;
            border-radius: 18px;
            gap: 16px;
        }

        .cricket-admin-page .hero-tag {
            font-size: 0.75rem;
            padding: 6px 10px;
            margin-bottom: 10px;
        }

        .cricket-admin-page .page-title {
            font-size: 1.45rem;
        }

        .cricket-admin-page .page-subtitle {
            font-size: 0.88rem;
        }

        .cricket-admin-page .hero-actions {
            flex-direction: column;
            gap: 8px;
        }

        .cricket-admin-page .hero-btn {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.9rem;
            border-radius: 12px;
        }

        /* Stats Grid — 2 columns on mobile */
        .cricket-admin-page .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 16px;
        }

        .cricket-admin-page .stat-card {
            padding: 16px;
            border-radius: 18px;
        }

        .cricket-admin-page .stat-number {
            font-size: 1.7rem;
            margin-top: 10px;
        }

        .cricket-admin-page .stat-hint {
            font-size: 0.78rem;
            display: none;
        }

        /* Pending Results */
        .cricket-admin-page .pending-result-card .card-body {
            padding: 16px !important;
            flex-direction: column !important;
        }

        .cricket-admin-page .pending-result-card .fixture-logos {
            min-width: auto;
        }

        .cricket-admin-page .pending-result-card .fixture-logo {
            width: 40px !important;
            height: 40px !important;
        }

        /* Matches Card Header */
        .cricket-admin-page .matches-card-header {
            padding: 16px;
            gap: 12px;
        }

        .cricket-admin-page .section-title {
            font-size: 1.15rem;
        }

        .cricket-admin-page .section-copy {
            font-size: 0.85rem;
            margin-bottom: 12px;
        }

        .cricket-admin-page .matches-card-header .header-filters {
            flex-direction: column;
            gap: 8px;
        }

        .cricket-admin-page .matches-card-header .search-input,
        .cricket-admin-page .matches-card-header .status-select {
            width: 100% !important;
            min-width: 0;
        }

        /* ── Mobile Card Layout for Table ── */
        .cricket-admin-page .matches-table-wrap {
            padding: 12px;
        }

        .cricket-admin-page .table thead {
            display: none;
        }

        .cricket-admin-page .table,
        .cricket-admin-page .table tbody,
        .cricket-admin-page .table tr.fixture-row,
        .cricket-admin-page .table td {
            display: block;
            width: 100%;
        }

        .cricket-admin-page .fixture-row {
            border: 1px solid #edf2fb;
            border-radius: 20px;
            margin-bottom: 14px;
            background: #fff;
            box-shadow: 0 4px 16px rgba(16, 35, 74, 0.05);
            overflow: hidden;
        }

        .cricket-admin-page .fixture-row td {
            border-top: 0;
            padding: 0;
        }

        /* Mobile card inner layout */
        .cricket-admin-page .fixture-row td:nth-child(1) {
            /* Index — hide on mobile, we'll show it inline */
            display: none;
        }

        .cricket-admin-page .fixture-row td:nth-child(2) {
            /* Match info */
            padding: 16px 16px 12px;
        }

        .cricket-admin-page .fixture-row td:nth-child(3) {
            /* Competition */
            padding: 0 16px 10px;
        }

        .cricket-admin-page .fixture-row td:nth-child(4) {
            /* Schedule */
            padding: 0 16px 10px;
        }

        .cricket-admin-page .fixture-row td:nth-child(5) {
            /* Status */
            padding: 0 16px 12px;
        }

        .cricket-admin-page .fixture-row td:nth-child(6) {
            /* Actions */
            padding: 12px 16px 16px;
            border-top: 1px solid #f0f4fb;
        }

        .cricket-admin-page .fixture-main {
            flex-direction: row;
            align-items: center;
            gap: 12px;
        }

        .cricket-admin-page .fixture-logos {
            gap: 5px;
        }

        .cricket-admin-page .fixture-logo {
            width: 42px;
            height: 42px;
            border-radius: 14px;
        }

        .cricket-admin-page .fixture-vs {
            width: 24px;
            height: 24px;
            font-size: 0.6rem;
        }

        .cricket-admin-page .fixture-teams {
            font-size: 1rem;
        }

        .cricket-admin-page .fixture-meta {
            gap: 6px;
        }

        .cricket-admin-page .fixture-chip {
            padding: 4px 8px;
            font-size: 0.78rem;
        }

        /* Status pills inline on mobile */
        .cricket-admin-page .status-stack {
            flex-direction: row;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* Schedule inline on mobile */
        .cricket-admin-page .schedule-block {
            flex-direction: row;
            align-items: center;
            gap: 8px;
        }

        .cricket-admin-page .schedule-time {
            font-size: 0.95rem;
        }

        .cricket-admin-page .schedule-label {
            font-size: 0.82rem;
        }

        /* Action buttons full width on mobile */
        .cricket-admin-page .action-cluster {
            justify-content: stretch;
            gap: 8px;
        }

        .cricket-admin-page .action-btn {
            flex: 1;
            min-width: 0;
            padding: 10px 12px;
            font-size: 0.88rem;
            border-radius: 12px;
        }

        /* Pagination */
        .cricket-admin-page .card-footer {
            padding: 14px 16px;
        }

        .cricket-admin-page .pagination {
            flex-wrap: wrap;
            gap: 4px;
        }

        .cricket-admin-page .pagination .page-link {
            min-width: 36px;
            padding: 6px 10px;
            font-size: 0.85rem;
            margin-left: 4px;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — VERY SMALL MOBILE (max 400px)
       ══════════════════════════════════════════ */
    @media (max-width: 400px) {
        .cricket-admin-page .dashboard-shell {
            padding: 8px;
            border-radius: 12px;
        }

        .cricket-admin-page .hero-panel {
            padding: 14px;
            border-radius: 14px;
        }

        .cricket-admin-page .page-title {
            font-size: 1.25rem;
        }

        .cricket-admin-page .page-subtitle {
            font-size: 0.82rem;
        }

        .cricket-admin-page .stats-grid {
            gap: 8px;
        }

        .cricket-admin-page .stat-card {
            padding: 14px;
            border-radius: 14px;
        }

        .cricket-admin-page .stat-number {
            font-size: 1.5rem;
        }

        .cricket-admin-page .stat-label {
            font-size: 0.72rem;
        }

        .cricket-admin-page .fixture-row td:nth-child(2) {
            padding: 12px 12px 10px;
        }

        .cricket-admin-page .fixture-row td:nth-child(3),
        .cricket-admin-page .fixture-row td:nth-child(4),
        .cricket-admin-page .fixture-row td:nth-child(5) {
            padding: 0 12px 8px;
        }

        .cricket-admin-page .fixture-row td:nth-child(6) {
            padding: 10px 12px 14px;
        }

        .cricket-admin-page .fixture-logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
        }

        .cricket-admin-page .fixture-vs {
            width: 22px;
            height: 22px;
            font-size: 0.55rem;
        }

        .cricket-admin-page .fixture-teams {
            font-size: 0.92rem;
        }

        .cricket-admin-page .matches-table-wrap {
            padding: 8px;
        }

        .cricket-admin-page .matches-card-header {
            padding: 14px;
        }

        .cricket-admin-page .section-kicker {
            font-size: 0.72rem;
            padding: 4px 10px;
        }

        .cricket-admin-page .section-title {
            font-size: 1.05rem;
        }
    }
</style>

<div class="page-wrapper cricket-admin-page">
    <div class="page-content">
        <div class="container-fluid">
            <div class="dashboard-shell">
                <!-- Hero Panel -->
                <div class="hero-panel">
                    <div class="hero-copy">
                        <div class="hero-tag">
                            <i class="bx bx-radio-circle-marked"></i>
                            Cricket Match Center
                        </div>
                        <h4 class="page-title" style="color: #fff;">Cricket Matches</h4>
                        <p class="page-subtitle">Manage fixtures like a real match desk with cleaner scheduling, bold team visuals, and quick admin controls for every contest.</p>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= base_url('admin/cricket_matches') ?>" class="hero-btn secondary">
                            <i class="bx bx-refresh"></i> Refresh
                        </a>
                        <a href="<?= base_url('admin/cricket_matches/create') ?>" class="hero-btn primary">
                            <i class="bx bx-plus"></i> Add Match
                        </a>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mt-3"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mt-3"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <!-- Pending Results -->
                <?php if (!empty($pending_results)): ?>
                    <div class="pending-results-block mb-3 mt-3">
                        <?php foreach ($pending_results as $pending): ?>
                            <div class="card border-0 shadow-sm mb-3 pending-result-card" data-pending-id="<?= (int)$pending['id'] ?>">
                                <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="background: linear-gradient(135deg, #fff5f5, #fff); border-radius: 20px; border-left: 5px solid #d43749 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="fixture-logos" style="width: auto; background: transparent; padding: 0; min-width: auto;">
                                            <div class="fixture-logo" style="width: 42px; height: 42px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                <?php if (!empty($pending['home_logo'])): ?>
                                                    <img src="<?= base_url($pending['home_logo']) ?>" alt="<?= html_escape($pending['team_home'] ?? 'Home') ?>">
                                                <?php else: ?>
                                                    <i class="bx bx-cricket-ball fallback-icon"></i>
                                                <?php endif; ?>
                                            </div>
                                            <span class="fixture-vs" style="width: 24px; height: 24px; font-size: 0.6rem;">VS</span>
                                            <div class="fixture-logo" style="width: 42px; height: 42px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                                <?php if (!empty($pending['away_logo'])): ?>
                                                    <img src="<?= base_url($pending['away_logo']) ?>" alt="<?= html_escape($pending['team_away'] ?? 'Away') ?>">
                                                <?php else: ?>
                                                    <i class="bx bx-cricket-ball fallback-icon"></i>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.95rem;">Match Completed! Add Result</h6>
                                            <div class="text-muted" style="font-size: 0.82rem;"><?= html_escape($pending['team_home'] . ' vs ' . $pending['team_away']) ?></div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row gap-2 w-100" style="max-width: 100%;">
                                        <input type="text" class="form-control pending-result-input w-100" placeholder="e.g. RCB won by 7 wickets">
                                        <button class="btn btn-save-result flex-shrink-0">Save Result</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card total">
                        <div class="stat-label">Total Matches</div>
                        <div class="stat-number" id="statTotal"><?= (int) ($stats['total'] ?? 0) ?></div>
                        <div class="stat-hint">All fixtures in the schedule.</div>
                    </div>
                    <div class="stat-card live">
                        <div class="stat-label">Live</div>
                        <div class="stat-number" id="statLive"><?= (int) ($stats['live'] ?? 0) ?></div>
                        <div class="stat-hint">Currently in play.</div>
                    </div>
                    <div class="stat-card scheduled">
                        <div class="stat-label">Scheduled</div>
                        <div class="stat-number" id="statScheduled"><?= (int) ($stats['scheduled'] ?? 0) ?></div>
                        <div class="stat-hint">Upcoming fixtures.</div>
                    </div>
                    <div class="stat-card completed">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number" id="statCompleted"><?= (int) ($stats['completed'] ?? 0) ?></div>
                        <div class="stat-hint">Finished matches.</div>
                    </div>
                </div>

                <!-- Matches Card -->
                <div class="matches-card">
                    <div class="matches-card-header">
                        <div>
                            <div class="section-kicker"><i class="bx bx-trophy"></i> Fixtures Board</div>
                            <h5 class="section-title">Match Control Room</h5>
                            <p class="section-copy mb-0">Review every fixture with team identity, competition, match timing, and quick action controls.</p>
                        </div>
                        <div class="header-filters">
                            <div class="search-wrap">
                                <i class="bx bx-search"></i>
                                <input type="text" id="tableSearch" class="form-control search-input" value="<?= html_escape($search ?? '') ?>" placeholder="Search matches...">
                            </div>
                            <select id="tableStatus" class="form-select status-select">
                                <option value="" <?= empty($status_filter) ? 'selected' : '' ?>>All Status</option>
                                <option value="live" <?= ($status_filter ?? '') === 'live' ? 'selected' : '' ?>>Live</option>
                                <option value="today" <?= ($status_filter ?? '') === 'today' ? 'selected' : '' ?>>Today</option>
                                <option value="upcoming" <?= ($status_filter ?? '') === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                <option value="scheduled" <?= ($status_filter ?? '') === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                                <option value="completed" <?= ($status_filter ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= ($status_filter ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="matches-table-wrap">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:60px;">#</th>
                                        <th>Match</th>
                                        <th style="width:170px;">Competition</th>
                                        <th style="width:200px;">Schedule</th>
                                        <th style="width:160px;">Status</th>
                                        <th class="text-end" style="width:220px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($matches)): ?>
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <div class="empty-icon"><i class="bx bx-cricket-ball"></i></div>
                                                    <h6 class="mb-2">No cricket matches found yet</h6>
                                                    <div>Add your first fixture to start building the match board.</div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($matches as $index => $match): ?>
                                            <?php
                                            $bucketClass = strtolower((string) ($match['bucket'] ?? 'scheduled'));
                                            if (!in_array($bucketClass, ['live', 'today', 'upcoming', 'completed', 'cancelled', 'scheduled'], true)) {
                                                $bucketClass = 'scheduled';
                                            }

                                            $adminStatusClass = strtolower((string) ($match['admin_status'] ?? 'scheduled'));
                                            if (!in_array($adminStatusClass, ['live', 'today', 'upcoming', 'completed', 'cancelled', 'scheduled'], true)) {
                                                $adminStatusClass = 'scheduled';
                                            }
                                            ?>
                                            <tr class="fixture-row"
                                                data-match-id="<?= (int) $match['id'] ?>"
                                                data-start-at="<?= html_escape((string) ($match['start_at'] ?? '')) ?>"
                                                data-admin-status="<?= html_escape((string) ($match['admin_status'] ?? 'scheduled')) ?>">
                                                <td>
                                                    <span class="fixture-index"><?= $index + 1 ?></span>
                                                </td>
                                                <td>
                                                    <div class="fixture-main">
                                                        <div class="fixture-logos">
                                                            <div class="fixture-logo">
                                                                <?php if (!empty($match['home_logo'])): ?>
                                                                    <img src="<?= base_url($match['home_logo']) ?>" alt="<?= html_escape($match['team_home'] ?? 'Home') ?>">
                                                                <?php else: ?>
                                                                    <i class="bx bx-cricket-ball fallback-icon"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                            <span class="fixture-vs">VS</span>
                                                            <div class="fixture-logo">
                                                                <?php if (!empty($match['away_logo'])): ?>
                                                                    <img src="<?= base_url($match['away_logo']) ?>" alt="<?= html_escape($match['team_away'] ?? 'Away') ?>">
                                                                <?php else: ?>
                                                                    <i class="bx bx-cricket-ball fallback-icon"></i>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="fixture-copy">
                                                            <div class="fixture-teams"><?= html_escape($match['teams_text']) ?></div>
                                                            <div class="fixture-meta">
                                                                <span class="fixture-chip"><i class="bx bx-map"></i> <?= html_escape($match['venue'] ?: 'Venue TBA') ?></span>
                                                                <span class="fixture-chip"><i class="bx bx-calendar"></i> <?= html_escape($match['date_label'] ?? '') ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="comp-pill"><?= html_escape($match['competition_name'] ?: 'Friendly') ?></span>
                                                </td>
                                                <td>
                                                    <div class="schedule-block">
                                                        <div class="schedule-time"><?= html_escape($match['time_label'] ?: $match['start_label']) ?></div>
                                                        <div class="schedule-label"><?= html_escape($match['date_label'] ?: $match['start_label']) ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-stack">
                                                        <span class="status-pill <?= $bucketClass ?>" data-role="status-pill">
                                                            <i class="bx bx-radio-circle-marked"></i> <?= ucfirst($bucketClass) ?>
                                                        </span>
                                                        <span class="admin-pill" data-role="admin-pill">
                                                            <div class="fixture-result text-success fw-bold" style="font-size:0.85rem;">
                                                                 <?= html_escape($match['match_result']) ?>
                                                            </div>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="action-cluster">
                                                        <a href="<?= base_url('admin/cricket_matches/edit/' . (int) $match['id']) ?>" class="action-btn edit">
                                                            <i class="bx bx-edit-alt"></i> Edit
                                                        </a>
                                                        <a href="<?= base_url('admin/cricket_matches/delete/' . (int) $match['id']) ?>" class="action-btn delete" onclick="return confirm('Delete this cricket match?')">
                                                            <i class="bx bx-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($pagination)): ?>
                        <div class="card-footer d-flex justify-content-end">
                            <?= $pagination ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const rows = Array.from(document.querySelectorAll('.fixture-row[data-start-at]'));
        const durationMs = 10 * 60 * 60 * 1000;

        function toLocalDateKey(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function formatLabel(bucket) {
            if (bucket === 'live') return 'Live';
            if (bucket === 'today') return 'Today';
            if (bucket === 'upcoming') return 'Upcoming';
            if (bucket === 'completed') return 'Completed';
            if (bucket === 'cancelled') return 'Cancelled';
            return 'Scheduled';
        }

        function computeBucket(match, nextStartAt, now) {
            const adminStatus = (match.adminStatus || 'scheduled').toLowerCase();

            if (!match.startAt || Number.isNaN(match.startAt)) {
                return 'scheduled';
            }

            if (adminStatus === 'cancelled') {
                return 'cancelled';
            }

            let endAt = match.startAt + durationMs;
            if (nextStartAt && nextStartAt > match.startAt && nextStartAt < endAt) {
                endAt = nextStartAt;
            }

            if (adminStatus === 'completed' || endAt < now) {
                return 'completed';
            }

            if (adminStatus === 'live' || (match.startAt <= now && endAt >= now)) {
                return 'live';
            }

            if (toLocalDateKey(new Date(match.startAt)) === toLocalDateKey(new Date(now))) {
                return 'today';
            }

            if (match.startAt > now) {
                return 'upcoming';
            }

            return 'completed';
        }

        function updateStats(matches) {
            const totalEl = document.getElementById('statTotal');
            const liveEl = document.getElementById('statLive');
            const scheduledEl = document.getElementById('statScheduled');
            const completedEl = document.getElementById('statCompleted');

            if (!totalEl || !liveEl || !scheduledEl || !completedEl) {
                return;
            }

            let live = 0;
            let scheduled = 0;
            let completed = 0;

            matches.forEach(function(match) {
                if (match.bucket === 'live') {
                    live++;
                } else if (match.bucket === 'today' || match.bucket === 'upcoming') {
                    scheduled++;
                } else if (match.bucket === 'completed') {
                    completed++;
                }
            });

            totalEl.textContent = String(matches.length);
            liveEl.textContent = String(live);
            scheduledEl.textContent = String(scheduled);
            completedEl.textContent = String(completed);
        }

        function updateStatuses() {
            const now = Date.now();
            const matches = rows.map(function(row) {
                return {
                    row: row,
                    startAt: Date.parse(row.dataset.startAt),
                    adminStatus: row.dataset.adminStatus || 'scheduled',
                    bucket: 'scheduled'
                };
            });

            matches.forEach(function(match, index) {
                let nextStartAt = null;

                for (let nextIndex = index + 1; nextIndex < matches.length; nextIndex++) {
                    if (!Number.isNaN(matches[nextIndex].startAt)) {
                        nextStartAt = matches[nextIndex].startAt;
                        break;
                    }
                }

                match.bucket = computeBucket(match, nextStartAt, now);

                if (match.adminStatus !== 'cancelled' && match.adminStatus !== 'completed') {
                    let endAt = match.startAt + durationMs;
                    if (nextStartAt && nextStartAt > match.startAt && nextStartAt < endAt) {
                        endAt = nextStartAt;
                    }

                    let newAdminStatus = match.adminStatus;
                    if (now > endAt) {
                        newAdminStatus = 'completed';
                    } else if (now >= match.startAt && now <= endAt && match.adminStatus !== 'live') {
                        newAdminStatus = 'live';
                    }

                    if (newAdminStatus !== match.adminStatus) {
                        match.adminStatus = newAdminStatus;
                        match.row.dataset.adminStatus = newAdminStatus;

                        var adminPill = match.row.querySelector('[data-role="admin-pill"]');
                        if (adminPill) {
                            adminPill.innerHTML = '<i class="bx bx-cog"></i> ' + newAdminStatus.charAt(0).toUpperCase() + newAdminStatus.slice(1);
                        }

                        fetch('<?= base_url('admin/cricket_matches/auto_update_status') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: 'id=' + match.row.dataset.matchId + '&status=' + newAdminStatus
                        });
                    }
                }

                var statusPill = match.row.querySelector('[data-role="status-pill"]');
                if (statusPill) {
                    statusPill.className = 'status-pill ' + match.bucket;
                    statusPill.innerHTML = '<i class="bx bx-radio-circle-marked"></i> ' + formatLabel(match.bucket);
                }
            });

            updateStats(matches);
        }

        if (rows.length) {
            updateStatuses();
            window.setInterval(updateStatuses, 20000);
        }

        // ── Search & Filter ──
        var searchInput = document.getElementById('tableSearch');
        var statusSelect = document.getElementById('tableStatus');

        function fetchMatches(url) {
            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(res) {
                    return res.text();
                })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');

                    var newTbody = doc.querySelector('.matches-table-wrap tbody');
                    if (newTbody) {
                        document.querySelector('.matches-table-wrap tbody').innerHTML = newTbody.innerHTML;
                    }

                    var newPagination = doc.querySelector('.matches-card .card-footer');
                    var oldPagination = document.querySelector('.matches-card .card-footer');

                    if (newPagination && oldPagination) {
                        oldPagination.innerHTML = newPagination.innerHTML;
                    } else if (newPagination && !oldPagination) {
                        var card = document.querySelector('.matches-card');
                        card.appendChild(newPagination.cloneNode(true));
                    } else if (!newPagination && oldPagination) {
                        oldPagination.remove();
                    }

                    var newStats = doc.querySelector('.stats-grid');
                    if (newStats) {
                        var oldStats = document.querySelector('.stats-grid');
                        if (oldStats) oldStats.innerHTML = newStats.innerHTML;
                    }

                    window.history.pushState({}, '', url);

                    rows.length = 0;
                    Array.prototype.push.apply(rows, Array.from(document.querySelectorAll('.fixture-row[data-start-at]')));
                    updateStatuses();
                });
        }

        function updateTable() {
            var url = new URL(window.location.href);
            url.searchParams.set('search', searchInput.value);
            url.searchParams.set('status', statusSelect.value);
            url.searchParams.delete('page');
            fetchMatches(url);
        }

        if (searchInput) {
            var timeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(updateTable, 400);
            });
        }

        if (statusSelect) {
            statusSelect.addEventListener('change', updateTable);
        }

        // ── Event delegation ──
        document.addEventListener('click', function(e) {
            var pageLink = e.target.closest('.pagination a');
            if (pageLink) {
                e.preventDefault();
                fetchMatches(pageLink.href);
            }

            if (e.target.closest('.btn-save-result')) {
                var btn = e.target.closest('.btn-save-result');
                var card = btn.closest('.pending-result-card');
                var matchId = card.dataset.pendingId;
                var input = card.querySelector('.pending-result-input');
                var resultText = input.value.trim();

                if (!resultText) {
                    input.style.borderColor = 'red';
                    input.focus();
                    setTimeout(function() {
                        input.style.borderColor = '#ffccd1';
                    }, 2000);
                    return;
                }

                btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Saving...';
                btn.disabled = true;

                fetch('<?= base_url('admin/cricket_matches/save_result') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: 'id=' + matchId + '&match_result=' + encodeURIComponent(resultText)
                    })
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            card.style.transition = 'all 0.5s ease';
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(-20px)';
                            setTimeout(function() {
                                card.remove();
                                if (!document.querySelector('.pending-result-card')) {
                                    var block = document.querySelector('.pending-results-block');
                                    if (block) block.remove();
                                }
                            }, 500);
                        } else {
                            btn.innerHTML = 'Save Result';
                            btn.disabled = false;
                            alert('Error saving result');
                        }
                    })
                    .catch(function() {
                        btn.innerHTML = 'Save Result';
                        btn.disabled = false;
                        alert('Network error');
                    });
            }
        });
    })();
</script>