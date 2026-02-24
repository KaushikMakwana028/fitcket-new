<?php
$queryParams = $this->input->get();

if (!function_exists('admin_session_page_url')) {
    function admin_session_page_url($pageNo, $queryParams)
    {
        $params = $queryParams;
        $params['page'] = $pageNo;
        return base_url('admin/session/session_list?' . http_build_query($params));
    }
}

$liveCount = (int) ($status_counts['live'] ?? 0);
$scheduledCount = (int) ($status_counts['scheduled'] ?? 0);
$totalCount = $liveCount + $scheduledCount;
?>

<div class="page-wrapper">
    <div class="page-content admin-session-page">
        <div class="row g-3 mb-3">
            <div class="col-12 col-md-4">
                <div class="mini-stat stat-scheduled">
                    <div class="stat-title">Scheduled</div>
                    <div class="stat-number"><?= $scheduledCount ?></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="mini-stat stat-live">
                    <div class="stat-title">Live Now</div>
                    <div class="stat-number"><?= $liveCount ?></div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="mini-stat stat-total">
                    <div class="stat-title">Total Sessions</div>
                    <div class="stat-number"><?= $totalCount ?></div>
                </div>
            </div>
        </div>

        <div class="card session-main-card">
            <div class="card-header session-main-header">
                <h5 class="mb-0"><i class="bx bx-video me-2"></i>All Sessions</h5>
                <form method="get" class="session-controls-form" id="sessionControlsForm">
                    <div class="session-control-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Search provider or title"
                            value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <select id="statusFilter" name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="live" <?= (($status_filter ?? '') === 'live') ? 'selected' : '' ?>>Live</option>
                            <option value="scheduled" <?= (($status_filter ?? '') === 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        <?php if (!empty($search) || !empty($status_filter)): ?>
                            <a href="<?= base_url('admin/session/session_list') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 session-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Provider</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Recurring</th>
                                <th>Started At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sessions)): ?>
                                <?php $sr = (int) ($start_index ?? 1); ?>
                                <?php foreach ($sessions as $row): ?>
                                    <tr>
                                        <td><?= $sr++ ?></td>
                                        <td><?= htmlspecialchars($row->provider_name ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td class="session-title-cell"><?= htmlspecialchars($row->title ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= !empty($row->session_date) ? date('M d, Y', strtotime($row->session_date)) : '-' ?></td>
                                        <td><?= !empty($row->start_time) ? date('h:i A', strtotime($row->start_time)) : '-' ?></td>
                                        <td><strong>&#8377;<?= number_format((float) $row->price, 2) ?></strong></td>
                                        <td>
                                            <span class="badge badge-type">
                                                <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $row->session_type ?? '-')), ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($row->category_name ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <?php if (($row->status ?? '') === 'live'): ?>
                                                <span class="badge badge-live">Live</span>
                                            <?php else: ?>
                                                <span class="badge badge-scheduled">Scheduled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars(ucfirst($row->recurring ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= !empty($row->started_at) ? date('M d, Y h:i A', strtotime($row->started_at)) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">No sessions found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="session-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        Showing <?= (int) ($start_index ?? 0) ?> to <?= (int) ($end_index ?? 0) ?> of <?= (int) ($total_rows ?? 0) ?> entries
                    </div>
                    <?php if (($total_pages ?? 1) > 1): ?>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= ((int) $page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ((int) $page <= 1) ? '#' : admin_session_page_url(((int) $page - 1), $queryParams) ?>">&laquo;</a>
                            </li>
                            <?php
                            $currentPage = (int) $page;
                            $pages = (int) $total_pages;
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($pages, $currentPage + 2);
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= admin_session_page_url($i, $queryParams) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($currentPage >= $pages) ? '#' : admin_session_page_url($currentPage + 1, $queryParams) ?>">&raquo;</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-session-page {
        background: #f0f2f6;
    }

    .mini-stat {
        border-radius: 10px;
        color: #fff;
        padding: 14px 16px;
        min-height: 88px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
    }

    .stat-title {
        font-size: 13px;
        font-weight: 600;
        opacity: 0.95;
    }

    .stat-number {
        font-size: 34px;
        line-height: 1;
        font-weight: 700;
        margin-top: 4px;
    }

    .stat-scheduled {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
    }

    .stat-live {
        background: linear-gradient(135deg, #ff4d4f, #f43f5e);
    }

    .stat-total {
        background: linear-gradient(135deg, #38bdf8, #2563eb);
    }

    .session-main-card {
        border: 1px solid #dde3ee;
        border-radius: 12px;
        overflow: hidden;
    }

    .session-main-header {
        background: #fff;
        border-bottom: 1px solid #e8edf5;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .session-main-header h5 {
        color: #1f2937;
        font-weight: 700;
        font-size: 30px;
    }

    .session-controls-form {
        margin: 0;
    }

    .session-control-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .session-control-group input {
        width: 230px;
    }

    .session-control-group select {
        width: 150px;
    }

    .session-control-group .form-control,
    .session-control-group .form-select,
    .session-control-group .btn {
        height: 34px;
        font-size: 13px;
        border-radius: 8px;
    }

    .session-table thead th {
        background: #f7f9fc;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e5eaf2;
        white-space: nowrap;
    }

    .session-table tbody td {
        font-size: 14px;
        color: #1f2937;
        border-color: #edf1f7;
        white-space: nowrap;
        vertical-align: middle;
    }

    .session-title-cell {
        min-width: 200px;
        max-width: 270px;
    }

    .badge-type {
        background: #d3ecf9;
        color: #03658c;
        font-size: 12px;
        font-weight: 700;
        border-radius: 999px;
        padding: 5px 10px;
    }

    .badge-live {
        background: #ff4d4f;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border-radius: 999px;
        padding: 4px 10px;
    }

    .badge-scheduled {
        background: #1d9bf0;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border-radius: 999px;
        padding: 4px 10px;
    }

    .session-footer {
        border-top: 1px solid #e8edf5;
        background: #fff;
        padding: 10px 12px;
    }

    .pagination .page-link {
        border-radius: 7px;
        margin: 0 2px;
    }

    [data-bs-theme="dark"] .admin-session-page {
        background: #212529;
    }

    [data-bs-theme="dark"] .session-main-card {
        border-color: #334155;
        background: #212529;
    }

    [data-bs-theme="dark"] .session-main-header {
        background: #212529;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .session-main-header h5 {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .session-control-group .form-control,
    [data-bs-theme="dark"] .session-control-group .form-select {
        background: #1f2937;
        color: #e5e7eb;
        border-color: #475569;
    }

    [data-bs-theme="dark"] .session-control-group .form-control::placeholder {
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .session-table thead th {
        background: #212529;
        color: #cbd5e1;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .session-table tbody td {
        color: #e5e7eb;
        border-color: #334155;
        background: #212529;
    }

    [data-bs-theme="dark"] .session-table tbody tr:hover td {
        background: #162133;
    }

    [data-bs-theme="dark"] .session-footer {
        background: #212529;
        border-top-color: #334155;
    }

    [data-bs-theme="dark"] .session-footer .text-muted,
    [data-bs-theme="dark"] .session-footer .small {
        color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .pagination .page-link {
        background: #1f2937;
        border-color: #475569;
        color: #e5e7eb;
    }

    [data-bs-theme="dark"] .pagination .page-item.active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    @media (max-width: 768px) {
        .session-main-header {
            align-items: flex-start;
        }

        .session-control-group input,
        .session-control-group select {
            width: 100%;
        }

        .session-control-group .btn,
        .session-control-group a.btn {
            width: auto;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var statusFilter = document.getElementById('statusFilter');
        if (!statusFilter) return;

        statusFilter.addEventListener('change', function() {
            document.getElementById('sessionControlsForm').submit();
        });
    });
</script>
