<?php
$poolCount = (int) ($pool_total_count ?? count($all_pools ?? $pools ?? []));
$fullQuestionPools = 0;
$openQuestionPools = 0;

foreach (($all_pools ?? $pools ?? []) as $poolItem) {
    if ((int) $poolItem['question_count'] >= (int) $max_questions) {
        $fullQuestionPools++;
    } else {
        $openQuestionPools++;
    }
}

$currentPage = max(1, (int) ($pool_current_page ?? 1));
$totalPages = max(1, (int) ($pool_total_pages ?? 1));
$buildPoolPageUrl = function ($pageNumber) {
    return base_url('admin/pools?page=' . (int) $pageNumber);
};
?>

<style>
    .admin-pool-list {
        --pool-bg: #f4f7fb;
        --pool-card: #ffffff;
        --pool-border: #dce5f0;
        --pool-text: #17324d;
        --pool-muted: #6d7f92;
        --pool-primary: #1f6feb;
        --pool-dark: #173d67;
        --pool-accent: #35b7ff;
        background: linear-gradient(180deg, #f8fbff 0%, var(--pool-bg) 100%);
        min-height: calc(100vh - 70px);
        padding: 24px;
        border-radius: 28px;
    }

    .admin-pool-list .pool-hero {
        background: linear-gradient(135deg, var(--pool-dark), var(--pool-primary));
        border-radius: 24px;
        color: #fff;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(23, 61, 103, 0.18);
    }

    .admin-pool-list .pool-stat {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 18px;
        padding: 18px 20px;
        height: 100%;
    }

    .admin-pool-list .pool-stat-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .08em;
        opacity: .78;
        margin-bottom: 6px;
    }

    .admin-pool-list .pool-stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.1;
    }

    .admin-pool-list .pool-panel {
        background: var(--pool-card);
        border: 1px solid var(--pool-border);
        border-radius: 24px;
        box-shadow: 0 12px 28px rgba(23, 50, 77, 0.06);
    }

    .admin-pool-list .pool-table {
        min-width: 980px;
    }

    .admin-pool-list .pool-table thead th {
        background: #f8fbff;
        color: var(--pool-muted);
        text-transform: uppercase;
        letter-spacing: .08em;
        font-size: 12px;
        border: 0;
        padding: 16px;
    }

    .admin-pool-list .pool-table tbody td {
        padding: 18px 16px;
        border-color: #edf2f7;
        vertical-align: middle;
    }

    .admin-pool-list .pool-row-id {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef5ff;
        color: var(--pool-primary);
        font-weight: 700;
    }

    .admin-pool-list .pool-name {
        font-weight: 700;
        color: var(--pool-text);
    }

    .admin-pool-list .pool-subtext {
        color: var(--pool-muted);
        font-size: 13px;
    }

    .admin-pool-list .question-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 12px;
        font-weight: 700;
    }

    .admin-pool-list .question-pill.good {
        background: #eafaf1;
        color: #16784d;
    }

    .admin-pool-list .question-pill.warn {
        background: #fff5dd;
        color: #9a6700;
    }

    .admin-pool-list .action-stack {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        justify-content: flex-start;
    }

    .admin-pool-list .action-btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        padding: 0;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
        position: relative;
        box-shadow: 0 10px 18px rgba(23, 50, 77, 0.08);
    }

    .admin-pool-list .action-btn i {
        font-size: 18px;
        margin: 0;
    }

    .admin-pool-list .action-btn.manage {
        background: linear-gradient(135deg, var(--pool-primary), var(--pool-accent));
        border-color: transparent;
        color: #fff;
    }

    .admin-pool-list .action-btn.prize {
        width: 40px;
        min-width: 40px;
        height: 40px;
        padding: 0;
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        border-color: transparent;
        color: #fff;
        justify-content: center;
        border-radius: 12px;
    }

    .admin-pool-list .action-btn.board {
        background: #1f2937;
        border-color: #1f2937;
        color: #fff;
    }

    .admin-pool-list .action-btn::after {
        content: attr(data-label);
        position: absolute;
        left: 50%;
        bottom: calc(100% + 8px);
        transform: translateX(-50%);
        background: #17324d;
        color: #fff;
        font-size: 11px;
        line-height: 1;
        padding: 7px 9px;
        border-radius: 8px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
        white-space: nowrap;
    }

    .admin-pool-list .action-btn:hover::after {
        opacity: 1;
        transform: translateX(-50%) translateY(-2px);
    }

    .admin-pool-list .action-note {
        color: var(--pool-muted);
        font-size: 12px;
        font-weight: 600;
    }

    .admin-pool-list .pagination-wrap .page-link {
        border-radius: 12px;
        margin: 0 4px;
        border-color: var(--pool-border);
        color: var(--pool-dark);
        min-width: 42px;
        text-align: center;
    }

    .admin-pool-list .pagination-wrap .page-item.active .page-link {
        background: linear-gradient(135deg, var(--pool-dark), var(--pool-primary));
        border-color: transparent;
    }

    @media (max-width: 767.98px) {
        .admin-pool-list {
            padding: 16px;
        }

        .admin-pool-list .pool-hero {
            padding: 22px;
        }

        .admin-pool-list .hero-actions .btn {
            width: 100%;
        }

        .admin-pool-list .action-stack {
            justify-content: flex-start;
        }

        .admin-pool-list .action-btn {
            width: 38px;
            height: 38px;
        }

        .admin-pool-list .action-btn.prize {
            width: 38px;
            min-width: 38px;
            height: 38px;
        }
    }
</style>

<div class="page-wrapper p-4">
    <div class="page-content admin-pool-list">
        <div class="pool-hero mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="text-uppercase fw-semibold mb-2" style="letter-spacing:.12em; opacity:.78;">Pool Management</div>
                    <h3 class="mb-2 text-white">All Pools</h3>
                    <p class="mb-0 opacity-75">Manage questions here and use one combined leaderboard for all pools, users, and winners.</p>
                </div>
                <div class="hero-actions d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/pool/leaderboard') ?>" class="btn btn-light">
                        <i class="bx bx-bar-chart-alt-2"></i> View Leaderboard
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="pool-stat">
                        <div class="pool-stat-label">Total Pools</div>
                        <div class="pool-stat-value"><?= (int) $poolCount ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pool-stat">
                        <div class="pool-stat-label">Question Ready</div>
                        <div class="pool-stat-value"><?= (int) $fullQuestionPools ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pool-stat">
                        <div class="pool-stat-label">Need Questions</div>
                        <div class="pool-stat-value"><?= (int) $openQuestionPools ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pool-panel p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h4 class="mb-1 text-dark">Pool List</h4>
                    <div class="text-muted">Select a pool to see its shared match questions and answers. Leaderboard is now one global page for all pools.</div>
                </div>
                <span class="badge bg-primary fs-6"><?= (int) $poolCount ?> Pools</span>
            </div>

            <div class="table-responsive">
                <table class="table pool-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pool Details</th>
                            <th>Match</th>
                            <th>Host</th>
                            <th>Entry Price</th>
                            <th>User Limit</th>
                            <th>Questions</th>
                            <th width="290">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pools)) : ?>
                            <?php foreach ($pools as $index => $pool) : ?>
                                <?php $isReady = (int) $pool['question_count'] >= (int) $max_questions; ?>
                                <tr>
                                    <td><span class="pool-row-id"><?= $index + 1 ?></span></td>
                                    <td>
                                        <div class="pool-name"><?= html_escape($pool['pool_name']) ?></div>
                                        <div style="
                                            display:inline-block;
                                            background:#eef2ff;
                                            color:#4e54c8;
                                            padding:4px 10px;
                                            border-radius:8px;
                                            font-size:12px;
                                            font-weight:600;
                                            margin-top:4px;
                                        ">
                                            <?= html_escape($pool['team_home']) ?> vs <?= html_escape($pool['team_away']) ?>
                                        </div>

                                        <div class="pool-subtext">
                                            <?= date('d M, h:i A', strtotime($pool['match_time'])) ?>
                                        </div>
                                        <!-- <div class="pool-subtext">Pool ID: #<?= (int) $pool['id'] ?></div> -->
                                    </td>
                                    <td>
                                        <?= html_escape($pool['team_home']) ?> vs <?= html_escape($pool['team_away']) ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= html_escape($pool['host_name']) ?></div>
                                        <div class="pool-subtext">Host Name</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">Rs. <?= number_format((float) $pool['price'], 2) ?></div>
                                        <div class="pool-subtext">Entry amount</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= (int) $pool['user_limit'] ?></div>
                                        <div class="pool-subtext">Maximum users</div>
                                    </td>
                                    <td>
                                        <span class="question-pill <?= $isReady ? 'good' : 'warn' ?>">
                                            <i class="bx <?= $isReady ? 'bx-check-circle' : 'bx-time-five' ?>"></i>
                                            <?= (int) $pool['question_count'] ?>/<?= (int) $max_questions ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-stack">
                                            <?php $prizeInfo = $pool_prize_map[(int) $pool['id']] ?? null; ?>
                                            <a href="<?= base_url('admin/pool/prize/' . (int) $pool['id']) ?>" class="btn btn-sm action-btn prize" data-label="<?= $prizeInfo ? 'Edit Winner Amount' : 'Add Winner Amount' ?>" title="<?= $prizeInfo ? 'Edit Winner Amount' : 'Add Winner Amount' ?>">
                                                <i class="bx bx-trophy"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pool/users/' . (int) $pool['id']) ?>"
                                                class="btn btn-sm action-btn"
                                                style="background:#7c3aed;color:#fff;"
                                                data-label="View Users"
                                                title="View Users">
                                                <i class="bx bx-group"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pool/' . (int) $pool['id']) ?>" class="btn btn-sm action-btn manage" data-label="See Questions" title="See Questions">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pool/leaderboard') ?>" class="btn btn-sm action-btn board" data-label="Global Leaderboard" title="Global Leaderboard">
                                                <i class="bx bx-bar-chart-alt-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center text-danger py-5">No pools found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($totalPages > 1) : ?>
                <div class="pagination-wrap d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                    <div class="text-muted">
                        Showing <?= count($pools ?? []) ?> of <?= (int) $poolCount ?> pools
                    </div>
                    <nav aria-label="Pool list pagination">
                        <ul class="pagination mb-0">
                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage <= 1 ? '#' : $buildPoolPageUrl($currentPage - 1) ?>">Prev</a>
                            </li>
                            <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $buildPoolPageUrl($page) ?>"><?= $page ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage >= $totalPages ? '#' : $buildPoolPageUrl($currentPage + 1) ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>