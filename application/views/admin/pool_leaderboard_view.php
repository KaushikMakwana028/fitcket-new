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
        --pl-gold: #f7b500;
        --pl-silver: #97a6ba;
        --pl-bronze: #b97850;
        background: linear-gradient(180deg, #f7faff 0%, var(--pl-bg) 100%);
        min-height: calc(100vh - 70px);
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

    .admin-pool-leaderboard .hero-actions {
        position: relative;
        z-index: 1;
    }

    .admin-pool-leaderboard .hero-stat {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 18px;
        padding: 18px 20px;
        height: 100%;
        position: relative;
        z-index: 1;
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
        color: #fff;
        padding: 22px;
        height: 100%;
        position: relative;
        overflow: hidden;
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
        background: linear-gradient(135deg, #f7b500, #f28f16);
    }

    .admin-pool-leaderboard .leaderboard-podium.second {
        background: linear-gradient(135deg, #8c9db3, #61758f);
    }

    .admin-pool-leaderboard .leaderboard-podium.third {
        background: linear-gradient(135deg, #c88962, #9d5d37);
    }

    .admin-pool-leaderboard .leaderboard-table-wrap {
        overflow-x: auto;
    }

    .admin-pool-leaderboard .leaderboard-table {
        min-width: 760px;
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
    <div class="page-content admin-pool-leaderboard">
        <div class="leaderboard-hero mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="hero-kicker mb-2">Pool Leaderboard</div>
                    <h2 class="mb-2"><?= html_escape($pool['pool_name']) ?></h2>
                    <p class="mb-0 opacity-75">Highest right answers appear at the top. Use filters to quickly find users.</p>
                </div>
                <div class="hero-actions d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/pool/' . (int) $pool['id']) ?>" class="btn btn-light">
                        <i class="bx bx-edit"></i> Manage Pool
                    </a>
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
            <form method="get" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold">Search User</label>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="<?= html_escape($search) ?>">
                </div>
                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Result Filter</label>
                    <select name="result" class="form-select">
                        <option value="">All</option>
                        <option value="checked" <?= $result_filter === 'checked' ? 'selected' : '' ?>>Checked Score</option>
                        <option value="pending" <?= $result_filter === 'pending' ? 'selected' : '' ?>>Pending Score</option>
                    </select>
                </div>
                <div class="col-lg-4 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bx bx-search"></i> Filter
                    </button>
                    <a href="<?= base_url('admin/pool/' . (int) $pool['id'] . '/leaderboard') ?>" class="btn btn-outline-secondary px-4">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <?php if (!empty($leaderboard)) : ?>
            <div class="row g-4 mb-4">
                <?php $topThree = array_slice($leaderboard, 0, 3); ?>
                <?php foreach ($topThree as $index => $leader) : ?>
                    <?php
                    $cardClass = $index === 0 ? 'first' : ($index === 1 ? 'second' : 'third');
                    $label = $index === 0 ? 'Champion' : ($index === 1 ? 'Runner Up' : 'Third Place');
                    ?>
                    <div class="col-lg-4">
                        <div class="leaderboard-podium <?= $cardClass ?>">
                            <div class="small text-uppercase fw-semibold mb-2 position-relative" style="letter-spacing:.12em; opacity:.86;"><?= $label ?></div>
                            <h4 class="mb-1 position-relative"><?= html_escape($leader['user_name']) ?></h4>
                            <div class="position-relative opacity-75 mb-3"><?= html_escape($leader['user_email']) ?></div>
                            <div class="row g-3 position-relative">
                                <div class="col-4">
                                    <div class="small opacity-75">Rank</div>
                                    <div class="fs-4 fw-bold">#<?= (int) $leader['rank'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="small opacity-75">Right</div>
                                    <div class="fs-4 fw-bold"><?= (int) $leader['right'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="small opacity-75">Wrong</div>
                                    <div class="fs-4 fw-bold"><?= (int) $leader['wrong'] ?></div>
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
                    <div class="text-muted">Highest right answers are shown first.</div>
                </div>
                <span class="badge bg-dark fs-6"><?= count($leaderboard) ?> Users</span>
            </div>

            <?php if (!empty($leaderboard)) : ?>
                <div class="leaderboard-table-wrap">
                    <table class="table leaderboard-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Right</th>
                                <th>Wrong</th>
                                <th>Checked</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaderboard as $leader) : ?>
                                <tr>
                                    <td><span class="rank-chip"><?= (int) $leader['rank'] ?></span></td>
                                    <td class="fw-semibold"><?= html_escape($leader['user_name']) ?></td>
                                    <td class="text-muted"><?= html_escape($leader['user_email']) ?></td>
                                    <td><span class="badge bg-success"><?= (int) $leader['right'] ?></span></td>
                                    <td><span class="badge bg-danger"><?= (int) $leader['wrong'] ?></span></td>
                                    <td><span class="badge bg-primary"><?= (int) $leader['checked'] ?>/<?= count($questions) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
