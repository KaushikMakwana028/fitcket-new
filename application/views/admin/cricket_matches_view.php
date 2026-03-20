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

    .cricket-admin-page .page-title,
    .cricket-admin-page .section-title,
    .cricket-admin-page .fixture-teams,
    .cricket-admin-page .stat-number,
    .cricket-admin-page .btn,
    .cricket-admin-page .table thead th {
        font-family: 'Barlow', sans-serif;
    }

    .cricket-admin-page .dashboard-shell {
        background: var(--bg);
        padding: 24px;
        border-radius: 28px;
    }

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
        line-height: 1;
        font-weight: 800;
        margin: 0 0 10px;
        letter-spacing: 0.02em;
    }

    .cricket-admin-page .page-subtitle {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.98rem;
        max-width: 640px;
    }

    .cricket-admin-page .hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
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
    }

    .cricket-admin-page .hero-btn:hover {
        transform: translateY(-2px);
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

    .cricket-admin-page .alert {
        border: 0;
        border-radius: 18px;
        box-shadow: var(--shadow-soft);
    }

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
        inset: 0 auto auto 0;
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
    }

    .cricket-admin-page .filter-card,
    .cricket-admin-page .matches-card {
        margin-top: 22px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 26px;
        box-shadow: var(--shadow-soft);
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
    }

    .cricket-admin-page .filter-actions {
        display: flex;
        gap: 12px;
    }

    .cricket-admin-page .filter-btn,
    .cricket-admin-page .reset-btn {
        min-height: 50px;
        border-radius: 16px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .cricket-admin-page .filter-btn {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
        border: 0;
    }

    .cricket-admin-page .reset-btn {
        border: 1px solid var(--border-strong);
        background: #fff;
        color: var(--text);
    }

    .cricket-admin-page .matches-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 22px 24px 18px;
        border-bottom: 1px solid var(--border);
    }

    .cricket-admin-page .matches-table-wrap {
        padding: 8px 18px 18px;
    }

    .cricket-admin-page .table {
        margin-bottom: 0;
        --bs-table-bg: transparent;
    }

    .cricket-admin-page .table thead th {
        border: 0;
        color: var(--muted);
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 14px 12px;
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
    }

    .cricket-admin-page .fixture-copy {
        min-width: 0;
    }

    .cricket-admin-page .fixture-teams {
        font-size: 1.16rem;
        font-weight: 800;
        line-height: 1.05;
        color: var(--text);
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
    }

    .cricket-admin-page .comp-pill {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: #f2f7ff;
        color: #2252a3;
        font-weight: 700;
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
    }

    .cricket-admin-page .action-btn:hover {
        transform: translateY(-1px);
    }

    .cricket-admin-page .action-btn.edit {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
        box-shadow: 0 12px 24px rgba(0, 102, 255, 0.18);
    }

    .cricket-admin-page .action-btn.delete {
        background: #fff1f3;
        color: #d8415b;
        border: 1px solid #ffd2d9;
    }

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

    .cricket-admin-page .card-footer {
        border-top: 1px solid var(--border);
        padding: 16px 22px 22px;
        border-bottom-left-radius: 26px;
        border-bottom-right-radius: 26px;
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

    @media (max-width: 1199px) {
        .cricket-admin-page .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .cricket-admin-page .dashboard-shell {
            padding: 18px;
            border-radius: 20px;
        }

        .cricket-admin-page .hero-panel {
            padding: 22px;
            border-radius: 22px;
            flex-direction: column;
            align-items: flex-start;
        }

        .cricket-admin-page .matches-card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .cricket-admin-page .fixture-main {
            align-items: flex-start;
        }
    }

    @media (max-width: 767px) {
        .cricket-admin-page .stats-grid {
            grid-template-columns: 1fr;
        }

        .cricket-admin-page .filter-actions {
            flex-direction: column;
        }

        .cricket-admin-page .action-cluster {
            justify-content: flex-start;
        }

        .cricket-admin-page .fixture-main {
            flex-direction: column;
        }

        .cricket-admin-page .fixture-logos {
            width: 100%;
        }

        .cricket-admin-page .table thead {
            display: none;
        }

        .cricket-admin-page .table,
        .cricket-admin-page .table tbody,
        .cricket-admin-page .table tr,
        .cricket-admin-page .table td {
            display: block;
            width: 100%;
        }

        .cricket-admin-page .fixture-row {
            border: 1px solid #edf2fb;
            border-radius: 20px;
            margin-bottom: 14px;
            background: #fff;
        }

        .cricket-admin-page .fixture-row td {
            border-top: 0;
            padding: 10px 14px;
        }

        .cricket-admin-page .fixture-row td:last-child {
            padding-bottom: 16px;
        }
    }
</style>

<div class="page-wrapper cricket-admin-page">
    <div class="page-content">
        <div class="container-fluid">
            <div class="dashboard-shell">
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

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success mt-4"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger mt-4"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>

                <div class="stats-grid">
                    <div class="stat-card total">
                        <div class="stat-label">Total Matches</div>
                        <div class="stat-number"><?= (int) ($stats['total'] ?? 0) ?></div>
                        <div class="stat-hint">All fixtures in the cricket schedule.</div>
                    </div>
                    <div class="stat-card live">
                        <div class="stat-label">Live</div>
                        <div class="stat-number"><?= (int) ($stats['live'] ?? 0) ?></div>
                        <div class="stat-hint">Matches currently in play.</div>
                    </div>
                    <div class="stat-card scheduled">
                        <div class="stat-label">Scheduled</div>
                        <div class="stat-number"><?= (int) ($stats['scheduled'] ?? 0) ?></div>
                        <div class="stat-hint">Upcoming fixtures waiting to start.</div>
                    </div>
                    <div class="stat-card completed">
                        <div class="stat-label">Completed</div>
                        <div class="stat-number"><?= (int) ($stats['completed'] ?? 0) ?></div>
                        <div class="stat-hint">Finished matches kept for reference.</div>
                    </div>
                </div>

                <div class="filter-card">
                    <div class="section-kicker"><i class="bx bx-search-alt"></i> Match Filters</div>
                    <h5 class="section-title">Find Fixtures Fast</h5>
                    <p class="section-copy">Search by competition, team, or venue and narrow the board by current match status.</p>

                    <form method="get" action="<?= base_url('admin/cricket_matches') ?>" class="row g-3 align-items-end">
                        <div class="col-lg-6">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" value="<?= html_escape($search ?? '') ?>" placeholder="Competition, team, or venue">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <?php foreach (['today' => 'Today', 'upcoming' => 'Upcoming', 'live' => 'Live', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label): ?>
                                    <option value="<?= $value ?>" <?= ($status_filter ?? '') === $value ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <div class="filter-actions">
                                <button type="submit" class="btn filter-btn w-100"><i class="bx bx-search"></i> Filter</button>
                                <a href="<?= base_url('admin/cricket_matches') ?>" class="reset-btn w-100">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="matches-card">
                    <div class="matches-card-header">
                        <div>
                            <div class="section-kicker"><i class="bx bx-trophy"></i> Fixtures Board</div>
                            <h5 class="section-title">Match Control Room</h5>
                            <p class="section-copy">Review every fixture with team identity, competition, match timing, and quick action controls.</p>
                        </div>
                    </div>

                    <div class="matches-table-wrap">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:72px;">#</th>
                                        <th>Match</th>
                                        <th style="width:180px;">Competition</th>
                                        <th style="width:220px;">Schedule</th>
                                        <th style="width:170px;">Status</th>
                                        <th class="text-end" style="width:230px;">Action</th>
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
                                            <tr class="fixture-row">
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
                                                                <span class="fixture-chip"><i class="bx bx-map"></i> <?= html_escape($match['venue'] ?: 'Venue not added') ?></span>
                                                                <span class="fixture-chip"><i class="bx bx-calendar"></i> <?= html_escape($match['date_label'] ?? '') ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="comp-pill"><?= html_escape($match['competition_name'] ?: 'Friendly Match') ?></span>
                                                </td>
                                                <td>
                                                    <div class="schedule-block">
                                                        <div class="schedule-time"><?= html_escape($match['time_label'] ?: $match['start_label']) ?></div>
                                                        <div class="schedule-label"><?= html_escape($match['date_label'] ?: $match['start_label']) ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-stack">
                                                        <span class="status-pill <?= $bucketClass ?>">
                                                            <i class="bx bx-radio-circle-marked"></i> <?= ucfirst($bucketClass) ?>
                                                        </span>
                                                        <span class="admin-pill">
                                                            <i class="bx bx-cog"></i> <?= ucfirst((string) ($match['admin_status'] ?? 'scheduled')) ?>
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
                        <div class="card-footer bg-white d-flex justify-content-end">
                            <?= $pagination ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
