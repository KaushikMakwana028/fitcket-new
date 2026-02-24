<?php
$queryParams = $this->input->get();

if (!function_exists('admin_live_session_page_url')) {
    function admin_live_session_page_url($pageNo, $queryParams)
    {
        $params = $queryParams;
        $params['page'] = $pageNo;
        return base_url('admin/session/live_sessions?' . http_build_query($params));
    }
}

?>

<div class="page-wrapper">
    <div class="page-content admin-live-page">
        <div class="card live-main-card">
            <div class="card-header live-main-header">
                <h5 class="mb-0"><i class="bx bx-broadcast me-2"></i>Live Sessions</h5>
                <form method="get" class="live-controls-form">
                    <div class="live-control-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Search provider or title"
                            value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-success btn-sm">Search</button>
                        <?php if (!empty($search)): ?>
                            <a href="<?= base_url('admin/session/live_sessions') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 live-table">
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
                                        <td class="live-title-cell"><?= htmlspecialchars($row->title ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= !empty($row->session_date) ? date('M d, Y', strtotime($row->session_date)) : '-' ?></td>
                                        <td><?= !empty($row->start_time) ? date('h:i A', strtotime($row->start_time)) : '-' ?></td>
                                        <td><strong>&#8377;<?= number_format((float) $row->price, 2) ?></strong></td>
                                        <td><span class="badge badge-type"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $row->session_type ?? '-')), ENT_QUOTES, 'UTF-8') ?></span></td>
                                        <td><?= htmlspecialchars($row->category_name ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><span class="badge badge-live">Live</span></td>
                                        <td><?= htmlspecialchars(ucfirst($row->recurring ?? '-'), ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= !empty($row->started_at) ? date('M d, Y h:i A', strtotime($row->started_at)) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">No live sessions found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="live-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        Showing <?= (int) ($start_index ?? 0) ?> to <?= (int) ($end_index ?? 0) ?> of <?= (int) ($total_rows ?? 0) ?> entries
                    </div>
                    <?php if (($total_pages ?? 1) > 1): ?>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= ((int) $page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ((int) $page <= 1) ? '#' : admin_live_session_page_url(((int) $page - 1), $queryParams) ?>">&laquo;</a>
                            </li>
                            <?php
                            $currentPage = (int) $page;
                            $pages = (int) $total_pages;
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($pages, $currentPage + 2);
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= admin_live_session_page_url($i, $queryParams) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($currentPage >= $pages) ? '#' : admin_live_session_page_url($currentPage + 1, $queryParams) ?>">&raquo;</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-live-page {
        background: #f0f2f6;
    }

    .live-main-card {
        border: 1px solid #dde3ee;
        border-radius: 12px;
        overflow: hidden;
    }

    .live-main-header {
        background: #fff;
        border-bottom: 1px solid #e8edf5;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .live-main-header h5 {
        color: #1f2937;
        font-weight: 700;
        font-size: 20px;
    }

    .live-controls-form {
        margin: 0;
    }

    .live-control-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .live-control-group input {
        width: 250px;
    }

    .live-control-group .form-control,
    .live-control-group .btn {
        height: 34px;
        font-size: 13px;
        border-radius: 8px;
    }

    .live-table thead th {
        background: #f7f9fc;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e5eaf2;
        white-space: nowrap;
    }

    .live-table tbody td {
        font-size: 14px;
        color: #1f2937;
        border-color: #edf1f7;
        white-space: nowrap;
        vertical-align: middle;
    }

    .live-title-cell {
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

    .live-footer {
        border-top: 1px solid #e8edf5;
        background: #fff;
        padding: 10px 12px;
    }

    .pagination .page-link {
        border-radius: 7px;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background: #198754;
        border-color: #198754;
    }

    [data-bs-theme="dark"] .admin-live-page {
        background: #212529;
    }

    [data-bs-theme="dark"] .live-main-card {
        border-color: #334155;
        background: #0f172a;
    }

    [data-bs-theme="dark"] .live-main-header {
        background: #212529;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .live-main-header h5 {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .live-control-group .form-control {
        background: #212529;
        color: #e5e7eb;
        border-color: #475569;
    }

    [data-bs-theme="dark"] .live-control-group .form-control::placeholder {
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .live-table thead th {
        background: #212529;
        color: #cbd5e1;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .live-table tbody td {
        color: #e5e7eb;
        border-color: #334155;
        background: #212529;
    }

    [data-bs-theme="dark"] .live-table tbody tr:hover td {
        background: #212529;
    }

    [data-bs-theme="dark"] .live-footer {
        background: #212529;
        border-top-color: #334155;
    }

    [data-bs-theme="dark"] .live-footer .text-muted,
    [data-bs-theme="dark"] .live-footer .small {
        color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .pagination .page-link {
        background: #1f2937;
        border-color: #475569;
        color: #e5e7eb;
    }

    [data-bs-theme="dark"] .pagination .page-item.active .page-link {
        background: #22c55e;
        border-color: #22c55e;
        color: #052e16;
    }

    @media (max-width: 768px) {
        .live-main-header {
            align-items: flex-start;
        }

        .live-control-group input {
            width: 100%;
        }
    }
</style>
