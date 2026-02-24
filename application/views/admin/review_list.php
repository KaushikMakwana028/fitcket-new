<?php
$queryParams = $this->input->get();

if (!function_exists('admin_review_page_url')) {
    function admin_review_page_url($pageNo, $queryParams)
    {
        $params = $queryParams;
        $params['page'] = $pageNo;
        return base_url('admin/reviews?' . http_build_query($params));
    }
}
?>

<div class="page-wrapper">
    <div class="page-content admin-review-page">
        <div class="card review-main-card">
            <div class="card-header review-main-header">
                <h5 class="mb-0"><i class="bx bx-star me-2"></i>Reviews</h5>
                <form method="get" class="review-controls-form">
                    <div class="review-control-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control form-control-sm"
                            placeholder="Search user, provider, review..."
                            value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                        <?php if (!empty($search)): ?>
                            <a href="<?= base_url('admin/reviews') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 review-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Provider Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reviews)): ?>
                                <?php $sr = (int) ($start_index ?? 1); ?>
                                <?php foreach ($reviews as $row): ?>
                                    <tr>
                                        <td><?= $sr++ ?></td>
                                        <td><?= htmlspecialchars($row->user_name ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($row->provider_name ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <span class="badge rating-badge">
                                                <?= (int) ($row->rating ?? 0) ?> &#9733;
                                            </span>
                                        </td>
                                        <td class="review-text-cell"><?= htmlspecialchars($row->review_text ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= !empty($row->created_at) ? date('d M Y', strtotime($row->created_at)) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No reviews found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="review-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        Showing <?= (int) ($start_index ?? 0) ?> to <?= (int) ($end_index ?? 0) ?> of <?= (int) ($total_rows ?? 0) ?> entries
                    </div>
                    <?php if (($total_pages ?? 1) > 1): ?>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= ((int) $page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ((int) $page <= 1) ? '#' : admin_review_page_url(((int) $page - 1), $queryParams) ?>">&laquo;</a>
                            </li>
                            <?php
                            $currentPage = (int) $page;
                            $pages = (int) $total_pages;
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($pages, $currentPage + 2);
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= admin_review_page_url($i, $queryParams) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($currentPage >= $pages) ? '#' : admin_review_page_url($currentPage + 1, $queryParams) ?>">&raquo;</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-review-page {
        background: #f0f2f6;
    }

    .review-main-card {
        border: 1px solid #dde3ee;
        border-radius: 12px;
        overflow: hidden;
    }

    .review-main-header {
        background: #fff;
        border-bottom: 1px solid #e8edf5;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .review-main-header h5 {
        color: #1f2937;
        font-weight: 700;
        font-size: 20px;
    }

    .review-control-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .review-control-group input {
        width: 280px;
    }

    .review-control-group .form-control,
    .review-control-group .btn {
        height: 34px;
        font-size: 13px;
        border-radius: 8px;
    }

    .review-table thead th {
        background: #f7f9fc;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 1px solid #e5eaf2;
        white-space: nowrap;
    }

    .review-table tbody td {
        font-size: 14px;
        color: #1f2937;
        border-color: #edf1f7;
        vertical-align: middle;
    }

    .review-text-cell {
        min-width: 280px;
        max-width: 440px;
        white-space: normal;
    }

    .rating-badge {
        background: #facc15;
        color: #1f2937;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 10px;
    }

    .review-footer {
        border-top: 1px solid #e8edf5;
        background: #fff;
        padding: 10px 12px;
    }

    .pagination .page-link {
        border-radius: 7px;
        margin: 0 2px;
    }

    [data-bs-theme="dark"] .admin-review-page {
        background: #212529;
    }

    [data-bs-theme="dark"] .review-main-card {
        border-color: #334155;
        background: #212529;
    }

    [data-bs-theme="dark"] .review-main-header {
        background: #212529;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .review-main-header h5 {
        color: #e2e8f0;
    }

    [data-bs-theme="dark"] .review-control-group .form-control {
        background: #1f2937;
        color: #e5e7eb;
        border-color: #475569;
    }

    [data-bs-theme="dark"] .review-control-group .form-control::placeholder {
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .review-table thead th {
        background: #212529;
        color: #cbd5e1;
        border-bottom-color: #334155;
    }

    [data-bs-theme="dark"] .review-table tbody td {
        color: #e5e7eb;
        border-color: #334155;
        background: #212529;
    }

    [data-bs-theme="dark"] .review-table tbody tr:hover td {
        background: #162133;
    }

    [data-bs-theme="dark"] .review-footer {
        background: #212529;
        border-top-color: #334155;
    }

    [data-bs-theme="dark"] .review-footer .text-muted,
    [data-bs-theme="dark"] .review-footer .small {
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
        .review-control-group input {
            width: 100%;
        }
    }
</style>
