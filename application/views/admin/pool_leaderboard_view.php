<?php
$isGlobalLeaderboard = empty($pool);
$baseLeaderboardUrl = $isGlobalLeaderboard
    ? base_url('admin/pool/leaderboard')
    : base_url('admin/pool/' . (int) $pool['id'] . '/leaderboard');
$heroTitle = $isGlobalLeaderboard ? 'All Pool Leaderboard' : $pool['pool_name'];
$heroDescription = $isGlobalLeaderboard
    ? 'One combined leaderboard with user, pool, host, and result details from every pool.'
    : 'One clean leaderboard view for this pool with the top 3 highlighted separately.';
$buildPageUrl = function ($pageNumber) use ($query_params, $baseLeaderboardUrl) {
    $params = $query_params;
    $params['page'] = $pageNumber;
    $query = http_build_query($params);

    return $baseLeaderboardUrl . ($query !== '' ? '?' . $query : '');
};
?>

<style>
    .admin-pool-leaderboard {
        --pl-bg: #f4f7fb;
        --pl-card: #ffffff;
        --pl-border: #dfe7f1;
        --pl-text: #17324d;
        --pl-muted: #6d7f92;
        --pl-primary: #1f6feb;
        --pl-primary-dark: #173d67;
        --pl-accent: #39b8ff;
        background: linear-gradient(180deg, #f7faff 0%, var(--pl-bg) 100%);
        min-height: calc(100vh - 70px);
        padding: 24px;
        border-radius: 28px;
    }

    .admin-pool-leaderboard .leaderboard-hero {
        background: linear-gradient(135deg, var(--pl-primary-dark), var(--pl-primary));
        color: #fff;
        border-radius: 26px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(23, 61, 103, 0.18);
        position: relative;
        overflow: hidden;
    }

    .admin-pool-leaderboard .leaderboard-hero::after {
        content: "";
        position: absolute;
        right: -70px;
        bottom: -70px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.16), transparent 68%);
    }

    .admin-pool-leaderboard .leaderboard-hero h2,
    .admin-pool-leaderboard .leaderboard-hero p,
    .admin-pool-leaderboard .leaderboard-hero .hero-kicker {
        color: #fff;
        position: relative;
        z-index: 1;
    }

    .admin-pool-leaderboard .hero-kicker {
        letter-spacing: 0.14em;
        text-transform: uppercase;
        font-size: 12px;
        opacity: 0.78;
        font-weight: 700;
    }

    .admin-pool-leaderboard .hero-actions,
    .admin-pool-leaderboard .hero-stat {
        position: relative;
        z-index: 1;
    }

    .admin-pool-leaderboard .hero-stat {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 18px;
        padding: 18px 20px;
        height: 100%;
    }

    .admin-pool-leaderboard .hero-stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        opacity: 0.8;
        margin-bottom: 6px;
    }

    .admin-pool-leaderboard .hero-stat-value {
        font-size: 30px;
        font-weight: 700;
        line-height: 1.1;
    }

    .admin-pool-leaderboard .leaderboard-panel {
        background: var(--pl-card);
        border: 1px solid var(--pl-border);
        border-radius: 22px;
        box-shadow: 0 12px 28px rgba(23, 50, 77, 0.06);
    }

    .admin-pool-leaderboard .leaderboard-filter .form-control,
    .admin-pool-leaderboard .leaderboard-filter .form-select {
        min-height: 48px;
        border-radius: 14px;
        border-color: var(--pl-border);
    }

    .admin-pool-leaderboard .leaderboard-podium {
        border-radius: 22px;
        color: #17324d;
        padding: 22px;
        height: 100%;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(23, 50, 77, 0.08);
    }

    .admin-pool-leaderboard .leaderboard-podium::before {
        content: "";
        position: absolute;
        top: -45px;
        right: -35px;
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.16);
    }

    .admin-pool-leaderboard .leaderboard-podium.first {
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.42), transparent 36%),
            linear-gradient(145deg, #fff8db 0%, #f7db7a 26%, #efc14d 58%, #d39a24 100%);
        box-shadow: 0 18px 34px rgba(211, 154, 36, 0.24);
    }

    .admin-pool-leaderboard .leaderboard-podium.second {
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.38), transparent 36%),
            linear-gradient(145deg, #ffffff 0%, #e7edf5 28%, #c7d2df 60%, #a5b4c7 100%);
        box-shadow: 0 18px 34px rgba(148, 163, 184, 0.22);
    }

    .admin-pool-leaderboard .leaderboard-podium.third {
        background:
            radial-gradient(circle at top right, rgba(255, 255, 255, 0.34), transparent 36%),
            linear-gradient(145deg, #f8e0d2 0%, #ddb294 28%, #c78d69 60%, #aa6d4b 100%);
        box-shadow: 0 18px 34px rgba(170, 109, 75, 0.22);
    }

    .admin-pool-leaderboard .podium-rank {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.42);
        font-size: 24px;
        font-weight: 800;
        color: #17324d;
        box-shadow: inset 0 0 0 1px rgba(23, 50, 77, 0.06);
    }

    .admin-pool-leaderboard .podium-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 14px;
        position: relative;
        z-index: 1;
    }

    .admin-pool-leaderboard .podium-meta-item {
        background: rgba(255, 255, 255, 0.36);
        border: 1px solid rgba(255, 255, 255, 0.42);
        border-radius: 14px;
        padding: 10px 12px;
        min-width: 120px;
        color: #17324d;
        box-shadow: inset 0 0 0 1px rgba(23, 50, 77, 0.04);
    }

    .admin-pool-leaderboard .podium-meta-item .small,
    .admin-pool-leaderboard .leaderboard-podium .opacity-75,
    .admin-pool-leaderboard .leaderboard-podium .small {
        color: rgba(23, 50, 77, 0.72) !important;
    }

    .admin-pool-leaderboard .leaderboard-podium h4,
    .admin-pool-leaderboard .leaderboard-podium .fw-bold {
        color: #17324d;
    }

    .admin-pool-leaderboard .searchable-select {
        position: relative;
    }

    .admin-pool-leaderboard .searchable-select-trigger {
        min-height: 48px;
        border-radius: 14px;
        border: 1px solid var(--pl-border);
        width: 100%;
        padding: 12px 42px 12px 14px;
        background: #fff;
        text-align: left;
        color: #17324d;
        font-weight: 500;
    }

    .admin-pool-leaderboard .searchable-select-toggle {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        color: var(--pl-muted);
        pointer-events: none;
    }

    .admin-pool-leaderboard .searchable-select-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid var(--pl-border);
        border-radius: 16px;
        box-shadow: 0 18px 30px rgba(23, 50, 77, 0.12);
        max-height: 240px;
        overflow-y: auto;
        padding: 8px;
        z-index: 20;
        display: none;
    }

    .admin-pool-leaderboard .searchable-select-search {
        padding: 6px 6px 10px;
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 2;
    }

    .admin-pool-leaderboard .searchable-select-search input {
        width: 100%;
        min-height: 42px;
        border-radius: 12px;
        border: 1px solid var(--pl-border);
        padding: 10px 12px;
    }

    .admin-pool-leaderboard .searchable-select.open .searchable-select-menu {
        display: block;
    }

    .admin-pool-leaderboard .searchable-option {
        border-radius: 12px;
        padding: 10px 12px;
        cursor: pointer;
        transition: background .18s ease;
    }

    .admin-pool-leaderboard .searchable-option:hover,
    .admin-pool-leaderboard .searchable-option.active {
        background: #eef5ff;
    }

    .admin-pool-leaderboard .searchable-option-title {
        font-weight: 700;
        color: #17324d;
        line-height: 1.3;
    }

    .admin-pool-leaderboard .searchable-option-subtitle {
        color: var(--pl-muted);
        font-size: 12px;
        margin-top: 2px;
    }

    .admin-pool-leaderboard .searchable-empty {
        padding: 12px;
        color: var(--pl-muted);
        font-size: 13px;
    }

    .admin-pool-leaderboard .leaderboard-table-wrap {
        overflow-x: auto;
    }

    .admin-pool-leaderboard .leaderboard-table {
        min-width: 1300px;
    }

    .admin-pool-leaderboard .leaderboard-table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--pl-muted);
        background: #f8fbff;
        border: 0;
        padding: 14px 16px;
    }

    .admin-pool-leaderboard .leaderboard-table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-color: #edf2f7;
    }

    .admin-pool-leaderboard .rank-chip {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--pl-primary), var(--pl-accent));
        color: #fff;
        font-weight: 700;
        box-shadow: 0 10px 20px rgba(31, 111, 235, 0.18);
    }

    .admin-pool-leaderboard .player-cell {
        min-width: 220px;
    }

    .admin-pool-leaderboard .player-name {
        font-weight: 700;
        color: var(--pl-text);
    }

    .admin-pool-leaderboard .subtext {
        color: var(--pl-muted);
        font-size: 13px;
    }

    .admin-pool-leaderboard .info-pill,
    .admin-pool-leaderboard .table-badge,
    .admin-pool-leaderboard .status-pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 8px 12px;
        font-weight: 700;
    }

    .admin-pool-leaderboard .info-pill,
    .admin-pool-leaderboard .table-badge.primary {
        background: #eef5ff;
        color: var(--pl-primary);
    }

    .admin-pool-leaderboard .table-badge.success,
    .admin-pool-leaderboard .status-pill.checked {
        background: #eafaf1;
        color: #16784d;
    }

    .admin-pool-leaderboard .table-badge.danger {
        background: #fff0ef;
        color: #ca4337;
    }

    .admin-pool-leaderboard .status-pill.pending {
        background: #fff5dd;
        color: #9a6700;
    }

    .admin-pool-leaderboard .pagination-wrap .page-link {
        border-radius: 12px;
        margin: 0 4px;
        border-color: var(--pl-border);
        color: var(--pl-primary-dark);
        min-width: 42px;
        text-align: center;
    }

    .admin-pool-leaderboard .pagination-wrap .page-item.active .page-link {
        background: linear-gradient(135deg, var(--pl-primary-dark), var(--pl-primary));
        border-color: transparent;
    }

    .admin-pool-leaderboard.is-loading {
        opacity: .72;
        pointer-events: none;
        transition: opacity .18s ease;
    }

    .admin-pool-leaderboard .empty-state {
        text-align: center;
        padding: 56px 20px;
        color: var(--pl-muted);
    }

    @media (max-width: 991.98px) {
        .admin-pool-leaderboard .leaderboard-hero {
            padding: 22px;
        }
    }

    @media (max-width: 767.98px) {
        .admin-pool-leaderboard {
            padding: 16px;
        }

        .admin-pool-leaderboard .hero-actions {
            width: 100%;
        }

        .admin-pool-leaderboard .hero-actions .btn {
            width: 100%;
        }

        .admin-pool-leaderboard .hero-stat-value {
            font-size: 24px;
        }
    }
</style>

<div class="page-wrapper p-4">
    <div class="page-content admin-pool-leaderboard" id="leaderboardRoot" data-base-url="<?= html_escape($baseLeaderboardUrl) ?>">
        <div class="leaderboard-hero mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="hero-kicker mb-2"><?= $isGlobalLeaderboard ? 'Combined Leaderboard' : 'Pool Leaderboard' ?></div>
                    <h2 class="mb-2"><?= html_escape($heroTitle) ?></h2>
                    <p class="mb-0 opacity-75"><?= html_escape($heroDescription) ?></p>
                </div>
                <div class="hero-actions d-flex gap-2 flex-wrap">
                    <?php if (!$isGlobalLeaderboard) : ?>
                        <a href="<?= base_url('admin/pool/' . (int) $pool['id']) ?>" class="btn btn-light">
                            <i class="bx bx-edit"></i> Manage Pool
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/pools') ?>" class="btn btn-outline-light">
                        <i class="bx bx-arrow-back"></i> All Pools
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Participants</div>
                        <div class="hero-stat-value"><?= (int) $participants_count ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Top Score</div>
                        <div class="hero-stat-value"><?= (int) $top_score ?> Right</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hero-stat">
                        <div class="hero-stat-label">Checked Entries</div>
                        <div class="hero-stat-value"><?= (int) $checked_count ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="leaderboard-panel p-4 mb-4 leaderboard-filter">
            <form method="get" class="row g-3 align-items-end" id="leaderboardFilterForm">
                <div class="<?= $isGlobalLeaderboard ? 'col-lg-4' : 'col-lg-5' ?>">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" id="leaderboardSearchInput" placeholder="User, email, mobile, pool, or host" value="<?= html_escape($search) ?>">
                </div>
                <?php if ($isGlobalLeaderboard) : ?>
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">Pool</label>
                        <?php
                        $selectedPoolLabel = 'All Pools';
                        foreach ($pool_options as $poolOption) {
                            if ((int) $pool_filter === (int) $poolOption['id']) {
                                $selectedPoolLabel = $poolOption['pool_name'] . ' - ' . $poolOption['host_name'];
                                break;
                            }
                        }
                        ?>
                        <div class="searchable-select" id="poolSearchableSelect">
                            <input type="hidden" name="pool" id="leaderboardPoolValue" value="<?= (int) $pool_filter ?>">
                            <button type="button" class="searchable-select-trigger" id="leaderboardPoolTrigger"><?= html_escape($selectedPoolLabel) ?></button>
                            <span class="searchable-select-toggle"><i class="bx bx-chevron-down"></i></span>
                            <div class="searchable-select-menu" id="leaderboardPoolMenu">
                                <div class="searchable-select-search">
                                    <input type="text" id="leaderboardPoolSearch" placeholder="Search pool name...">
                                </div>
                                <div class="searchable-option <?= (int) $pool_filter === 0 ? 'active' : '' ?>" data-value="0" data-label="All Pools">
                                    <div class="searchable-option-title">All Pools</div>
                                    <div class="searchable-option-subtitle">Show all pools together</div>
                                </div>
                                <?php foreach ($pool_options as $poolOption) : ?>
                                    <?php $poolLabel = $poolOption['pool_name'] . ' - ' . $poolOption['host_name']; ?>
                                    <div class="searchable-option <?= (int) $pool_filter === (int) $poolOption['id'] ? 'active' : '' ?>" data-value="<?= (int) $poolOption['id'] ?>" data-label="<?= html_escape($poolLabel) ?>">
                                        <div class="searchable-option-title"><?= html_escape($poolOption['pool_name']) ?></div>
                                        <div class="searchable-option-subtitle"><?= html_escape($poolOption['host_name']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="searchable-empty d-none" id="leaderboardPoolEmpty">No matching pools found.</div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Result Filter</label>
                    <select name="result" class="form-select leaderboard-auto-filter">
                        <option value="">All</option>
                        <option value="checked" <?= $result_filter === 'checked' ? 'selected' : '' ?>>Checked Score</option>
                        <option value="pending" <?= $result_filter === 'pending' ? 'selected' : '' ?>>Pending Score</option>
                    </select>
                </div>
                <div class="<?= $isGlobalLeaderboard ? 'col-lg-2' : 'col-lg-4' ?> d-flex gap-2 flex-wrap">
                    <a href="<?= $baseLeaderboardUrl ?>" class="btn btn-outline-secondary px-4">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <?php if (!empty($top_three)) : ?>
            <div class="row g-4 mb-4">
                <?php foreach ($top_three as $index => $leader) : ?>
                    <?php
                    $cardClass = $index === 0 ? 'first' : ($index === 1 ? 'second' : 'third');
                    $label = $index === 0 ? 'Champion' : ($index === 1 ? 'Runner Up' : 'Third Place');
                    ?>
                    <div class="col-lg-4">
                        <div class="leaderboard-podium <?= $cardClass ?>">
                            <div class="d-flex justify-content-between align-items-start gap-3 position-relative">
                                <div>
                                    <div class="small text-uppercase fw-semibold mb-2" style="letter-spacing:.12em; opacity:.86;"><?= $label ?></div>
                                    <h4 class="mb-1"><?= html_escape($leader['user_name']) ?></h4>
                                    <div class="opacity-75"><?= html_escape($leader['user_email'] ?: 'No email') ?></div>
                                </div>
                                <div class="podium-rank">#<?= (int) $leader['rank'] ?></div>
                            </div>
                            <div class="podium-meta">
                                <div class="podium-meta-item">
                                    <div class="small opacity-75">Pool</div>
                                    <div class="fw-bold"><?= html_escape($leader['pool_name']) ?></div>
                                </div>
                                <div class="podium-meta-item">
                                    <div class="small opacity-75">Host</div>
                                    <div class="fw-bold"><?= html_escape($leader['host_name']) ?></div>
                                </div>
                                <div class="podium-meta-item">
                                    <div class="small opacity-75">Right</div>
                                    <div class="fw-bold"><?= (int) $leader['right'] ?></div>
                                </div>
                                <div class="podium-meta-item">
                                    <div class="small opacity-75">Checked</div>
                                    <div class="fw-bold"><?= (int) $leader['checked'] ?>/<?= (int) $leader['total_questions'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="leaderboard-panel p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="mb-1 text-dark">Ranking Table</h4>
                    <div class="text-muted">Top 3 are highlighted above. This table starts from rank 4 and includes full pool details.</div>
                </div>
                <span class="badge bg-dark fs-6"><?= count($leaderboard) ?> Users</span>
            </div>

            <?php if (!empty($table_rows)) : ?>
                <div class="leaderboard-table-wrap">
                    <table class="table leaderboard-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>User</th>
                                <th>Mobile</th>
                                <th>Pool</th>
                                <th>Host</th>
                                <th>Entry</th>
                                <th>Limit</th>
                                <th>Email</th>
                                <th>Right</th>
                                <th>Wrong</th>
                                <th>Checked</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table_rows as $leader) : ?>
                                <tr>
                                    <td><span class="rank-chip"><?= (int) $leader['rank'] ?></span></td>
                                    <td class="player-cell">
                                        <div class="player-name"><?= html_escape($leader['user_name']) ?></div>
                                        <div class="subtext">User ID: #<?= (int) $leader['user_id'] ?></div>
                                    </td>
                                    <td><span class="info-pill"><?= html_escape($leader['user_mobile'] ?: 'N/A') ?></span></td>
                                    <td>
                                        <div class="fw-semibold"><?= html_escape($leader['pool_name']) ?></div>
                                        <div class="subtext">Pool ID: #<?= (int) $leader['pool_id'] ?></div>
                                    </td>
                                    <td><?= html_escape($leader['host_name']) ?></td>
                                    <td>Rs. <?= number_format((float) $leader['entry_price'], 2) ?></td>
                                    <td><?= (int) $leader['user_limit'] ?></td>
                                    <td class="text-muted"><?= html_escape($leader['user_email'] ?: 'N/A') ?></td>
                                    <td><span class="table-badge success"><?= (int) $leader['right'] ?></span></td>
                                    <td><span class="table-badge danger"><?= (int) $leader['wrong'] ?></span></td>
                                    <td><span class="table-badge primary"><?= (int) $leader['checked'] ?>/<?= (int) $leader['total_questions'] ?></span></td>
                                    <td>
                                        <span class="status-pill <?= (int) $leader['checked'] > 0 ? 'checked' : 'pending' ?>">
                                            <?= (int) $leader['checked'] > 0 ? 'Checked' : 'Pending' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ((int) $total_pages > 1) : ?>
                    <div class="pagination-wrap d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div class="text-muted">
                            Showing <?= count($table_rows) ?> of <?= (int) $remaining_count ?> rows after top 3 cards
                        </div>
                        <nav aria-label="Leaderboard pagination">
                            <ul class="pagination mb-0">
                                <li class="page-item <?= (int) $current_page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= (int) $current_page <= 1 ? '#' : $buildPageUrl($current_page - 1) ?>">Prev</a>
                                </li>
                                <?php for ($page = 1; $page <= (int) $total_pages; $page++) : ?>
                                    <li class="page-item <?= (int) $page === (int) $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= $buildPageUrl($page) ?>"><?= (int) $page ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= (int) $current_page >= (int) $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= (int) $current_page >= (int) $total_pages ? '#' : $buildPageUrl($current_page + 1) ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            <?php elseif (!empty($leaderboard)) : ?>
                <div class="empty-state">
                    <h5 class="mb-2">Only top 3 users are available right now</h5>
                    <div>More rows will appear in the table automatically when additional users join the ranking.</div>
                </div>
            <?php else : ?>
                <div class="empty-state">
                    <h5 class="mb-2">No leaderboard data found</h5>
                    <div>Once users answer pool questions, ranking will appear here.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    (function() {
        let leaderboardSearchTimer = null;

        function attachLeaderboardInteractions() {
            const root = document.getElementById('leaderboardRoot');
            const form = document.getElementById('leaderboardFilterForm');

            if (!root || !form) {
                return;
            }

            const searchInput = document.getElementById('leaderboardSearchInput');
            const autoFilters = form.querySelectorAll('.leaderboard-auto-filter');
            const paginationLinks = root.querySelectorAll('.pagination-wrap .page-link');
            const searchableSelect = document.getElementById('poolSearchableSelect');
            const searchableInput = document.getElementById('leaderboardPoolSearch');
            const searchableTrigger = document.getElementById('leaderboardPoolTrigger');
            const searchableValue = document.getElementById('leaderboardPoolValue');
            const searchableMenu = document.getElementById('leaderboardPoolMenu');
            const searchableOptions = searchableMenu ? searchableMenu.querySelectorAll('.searchable-option') : [];
            const searchableEmpty = document.getElementById('leaderboardPoolEmpty');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                loadLeaderboard(form.action || window.location.pathname, new FormData(form));
            });

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    window.clearTimeout(leaderboardSearchTimer);
                    leaderboardSearchTimer = window.setTimeout(function() {
                        loadLeaderboard(form.action || window.location.pathname, new FormData(form));
                    }, 350);
                });
            }

            autoFilters.forEach(function(filter) {
                filter.addEventListener('change', function() {
                    loadLeaderboard(form.action || window.location.pathname, new FormData(form));
                });
            });

            if (searchableSelect && searchableInput && searchableTrigger && searchableValue && searchableMenu) {
                searchableTrigger.addEventListener('click', function() {
                    searchableSelect.classList.toggle('open');
                    if (searchableSelect.classList.contains('open')) {
                        searchableInput.focus();
                        filterPoolOptions();
                    }
                });

                searchableInput.addEventListener('focus', function() {
                    searchableSelect.classList.add('open');
                    filterPoolOptions();
                });

                searchableInput.addEventListener('input', function() {
                    searchableSelect.classList.add('open');
                    filterPoolOptions();
                });

                searchableOptions.forEach(function(option) {
                    option.addEventListener('click', function() {
                        searchableValue.value = option.dataset.value || '0';
                        searchableTrigger.textContent = option.dataset.label || 'All Pools';
                        searchableInput.value = '';
                        searchableOptions.forEach(function(item) {
                            item.classList.remove('active');
                        });
                        option.classList.add('active');
                        searchableSelect.classList.remove('open');
                        loadLeaderboard(form.action || window.location.pathname, new FormData(form));
                    });
                });

                document.addEventListener('click', function(event) {
                    if (!searchableSelect.contains(event.target)) {
                        searchableSelect.classList.remove('open');
                        searchableInput.value = '';
                        filterPoolOptions();
                    }
                });

                function filterPoolOptions() {
                    const needle = searchableInput.value.toLowerCase().trim();
                    let visibleCount = 0;

                    searchableOptions.forEach(function(option) {
                        const label = (option.dataset.label || '').toLowerCase();
                        const matches = needle === '' || label.indexOf(needle) !== -1;
                        option.classList.toggle('d-none', !matches);

                        if (matches) {
                            visibleCount++;
                        }
                    });

                    if (searchableEmpty) {
                        searchableEmpty.classList.toggle('d-none', visibleCount !== 0);
                    }
                }
            }

            paginationLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    const href = link.getAttribute('href');

                    if (!href || href === '#') {
                        event.preventDefault();
                        return;
                    }

                    event.preventDefault();
                    loadLeaderboard(href);
                });
            });
        }

        function loadLeaderboard(url, formData) {
            const root = document.getElementById('leaderboardRoot');

            if (!root) {
                return;
            }

            let requestUrl = url;

            if (formData instanceof FormData) {
                const params = new URLSearchParams(formData);
                requestUrl = (root.dataset.baseUrl || url) + '?' + params.toString();
            }

            root.classList.add('is-loading');

            fetch(requestUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function(response) {
                    return response.text();
                })
                .then(function(html) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const nextRoot = doc.getElementById('leaderboardRoot');

                    if (!nextRoot) {
                        window.location.href = requestUrl;
                        return;
                    }

                    root.innerHTML = nextRoot.innerHTML;
                    if (window.history && window.history.pushState) {
                        window.history.pushState({}, '', requestUrl);
                    }
                    attachLeaderboardInteractions();
                })
                .catch(function() {
                    window.location.href = requestUrl;
                })
                .finally(function() {
                    root.classList.remove('is-loading');
                });
        }

        window.addEventListener('popstate', function() {
            loadLeaderboard(window.location.href);
        });

        attachLeaderboardInteractions();
    })();
</script>
