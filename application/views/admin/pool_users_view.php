<?php
// =============================================
// BACKEND LOGIC
// =============================================
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc';

$allowed_per_page = [5, 10, 25, 50, 100];
if (!in_array($per_page, $allowed_per_page)) $per_page = 10;

$allowed_sort = ['name', 'email', 'mobile'];
if (!in_array($sort_by, $allowed_sort)) $sort_by = 'name';
$sort_order = ($sort_order === 'desc') ? 'desc' : 'asc';

$filtered_users = $users;
if (!empty($search)) {
    $filtered_users = array_filter($users, function ($user) use ($search) {
        return (
            stripos($user['name'], $search) !== false ||
            stripos($user['email'], $search) !== false ||
            stripos($user['mobile'], $search) !== false
        );
    });
}

usort($filtered_users, function ($a, $b) use ($sort_by, $sort_order) {
    $cmp = strcasecmp($a[$sort_by], $b[$sort_by]);
    return $sort_order === 'desc' ? -$cmp : $cmp;
});

$total_records = count($filtered_users);
$total_pages = max(1, ceil($total_records / $per_page));
$current_page = min($current_page, $total_pages);
$offset = ($current_page - 1) * $per_page;
$paginated_users = array_slice($filtered_users, $offset, $per_page);
$showing_from = $total_records > 0 ? $offset + 1 : 0;
$showing_to = min($offset + $per_page, $total_records);

function build_url($params = [])
{
    $defaults = [
        'search' => isset($_GET['search']) ? $_GET['search'] : '',
        'per_page' => isset($_GET['per_page']) ? $_GET['per_page'] : 10,
        'page' => isset($_GET['page']) ? $_GET['page'] : 1,
        'sort_by' => isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name',
        'sort_order' => isset($_GET['sort_order']) ? $_GET['sort_order'] : 'asc',
    ];
    $merged = array_merge($defaults, $params);
    if (empty($merged['search'])) unset($merged['search']);
    return '?' . http_build_query($merged);
}

function get_sort_icon($col, $cur_sort, $cur_order)
{
    if ($cur_sort !== $col) return '<i class="bx bx-transfer-alt" style="font-size:12px;opacity:0.3;transform:rotate(90deg);"></i>';
    return $cur_order === 'asc'
        ? '<i class="bx bx-up-arrow-alt text-success" style="font-size:14px;"></i>'
        : '<i class="bx bx-down-arrow-alt text-danger" style="font-size:14px;"></i>';
}

function toggle_order($col, $cur_sort, $cur_order)
{
    if ($cur_sort !== $col) return 'asc';
    return $cur_order === 'asc' ? 'desc' : 'asc';
}

$avatar_colors = ['#6366f1', '#ec4899', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ef4444', '#14b8a6', '#f97316', '#06b6d4'];
?>

<div class="page-wrapper p-4">
    <div class="page-content">

        <!-- ============ PAGE HEADER ============ -->
        <div class="pu-header">
            <div class="pu-header-left">
                <div class="pu-header-icon">
                    <i class="bx bx-user-pin"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">Pool Users</h4>
                    <p class="mb-0 text-muted" style="font-size:13px;">
                        Manage participants of <strong class="text-dark"><?= html_escape($pool['pool_name']) ?></strong>
                    </p>
                </div>
            </div>
            <a href="<?= base_url('admin/pool') ?>" class="btn btn-dark btn-sm px-3">
                <i class="bx bx-arrow-back me-1"></i> Back
            </a>
        </div>

        <!-- ============ STATS ROW ============ -->
        <div class="row g-3 mt-3 mb-4">
            <div class="col-lg-4 col-sm-6">
                <div class="pu-stat-card pu-stat-purple">
                    <div class="pu-stat-icon">
                        <i class="bx bx-group"></i>
                    </div>
                    <div class="pu-stat-info">
                        <span class="pu-stat-value"><?= count($users) ?></span>
                        <span class="pu-stat-label">Total Participants</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="pu-stat-card pu-stat-blue">
                    <div class="pu-stat-icon">
                        <i class="bx bx-filter"></i>
                    </div>
                    <div class="pu-stat-info">
                        <span class="pu-stat-value"><?= $total_records ?></span>
                        <span class="pu-stat-label">Matching Results</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="pu-stat-card pu-stat-green">
                    <div class="pu-stat-icon">
                        <i class="bx bx-spreadsheet"></i>
                    </div>
                    <div class="pu-stat-info">
                        <span class="pu-stat-value"><?= $showing_from ?>–<?= $showing_to ?></span>
                        <span class="pu-stat-label">Page <?= $current_page ?> of <?= $total_pages ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ MAIN TABLE CARD ============ -->
        <div class="pu-main-card">

            <!-- Search & Filter Bar -->
            <div class="pu-filter-bar">
                <form method="GET" action="" id="filterForm" class="pu-filter-form">
                    <input type="hidden" name="sort_by" value="<?= html_escape($sort_by) ?>">
                    <input type="hidden" name="sort_order" value="<?= html_escape($sort_order) ?>">
                    <input type="hidden" name="page" value="1">

                    <div class="pu-search-box">
                        <i class="bx bx-search"></i>
                        <input type="text"
                            name="search"
                            placeholder="Type to search users..."
                            value="<?= html_escape($search) ?>"
                            id="searchInput"
                            autocomplete="off">
                        <?php if (!empty($search)) : ?>
                            <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>" class="pu-search-clear">
                                <i class="bx bx-x"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="pu-filter-controls">
                        <select name="per_page" class="pu-select" onchange="this.form.submit()">
                            <?php foreach ($allowed_per_page as $pp) : ?>
                                <option value="<?= $pp ?>" <?= $per_page == $pp ? 'selected' : '' ?>>
                                    <?= $pp ?> per page
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="pu-btn pu-btn-search">
                            <i class="bx bx-search-alt"></i> Search
                        </button>
                    </div>
                </form>

                <?php if (!empty($search)) : ?>
                    <div class="pu-active-filter">
                        <span>Results for:</span>
                        <span class="pu-filter-tag">
                            "<?= html_escape($search) ?>"
                            <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>"><i class="bx bx-x"></i></a>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Table -->
            <?php if (!empty($paginated_users)) : ?>
                <div class="pu-table-wrap">
                    <table class="pu-table" id="usersTable">
                        <thead>
                            <tr>
                                <th class="pu-th-num">#</th>
                                <th>
                                    <a href="<?= build_url(['sort_by' => 'name', 'sort_order' => toggle_order('name', $sort_by, $sort_order), 'page' => $current_page]) ?>" class="pu-sort-link">
                                        User <?= get_sort_icon('name', $sort_by, $sort_order) ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?= build_url(['sort_by' => 'email', 'sort_order' => toggle_order('email', $sort_by, $sort_order), 'page' => $current_page]) ?>" class="pu-sort-link">
                                        Email <?= get_sort_icon('email', $sort_by, $sort_order) ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?= build_url(['sort_by' => 'mobile', 'sort_order' => toggle_order('mobile', $sort_by, $sort_order), 'page' => $current_page]) ?>" class="pu-sort-link">
                                        Mobile <?= get_sort_icon('mobile', $sort_by, $sort_order) ?>
                                    </a>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paginated_users as $i => $user) :
                                $color = $avatar_colors[($offset + $i) % count($avatar_colors)];
                                $initials = strtoupper(substr($user['name'], 0, 2));
                            ?>
                                <tr>
                                    <td class="pu-td-num"><?= $offset + $i + 1 ?></td>
                                    <td>
                                        <div class="pu-user-cell">
                                            <div class="pu-avatar" style="background:<?= $color ?>;">
                                                <?= $initials ?>
                                            </div>
                                            <span class="pu-user-name"><?= html_escape($user['name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="pu-td-email"><?= html_escape($user['email']) ?></td>
                                    <td class="pu-td-mobile"><?= html_escape($user['mobile']) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/pool/edit_user_answers/' . $pool['id'] . '/' . $user['id']) ?>"
                                            class="pu-btn-edit" title="Edit Answers">
                                            <i class="bx bx-pencil"></i>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ============ PAGINATION ============ -->
                <div class="pu-pagination-bar">
                    <div class="pu-pagination-info">
                        Showing <b><?= $showing_from ?></b>–<b><?= $showing_to ?></b> of <b><?= $total_records ?></b>
                        <?php if (!empty($search)) : ?>
                            <span class="text-muted">(filtered)</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($total_pages > 1) : ?>
                        <div class="pu-pagination">
                            <!-- Prev -->
                            <?php if ($current_page > 1) : ?>
                                <a href="<?= build_url(['page' => $current_page - 1]) ?>" class="pu-page-btn">
                                    <i class="bx bx-chevron-left"></i>
                                </a>
                            <?php else : ?>
                                <span class="pu-page-btn disabled"><i class="bx bx-chevron-left"></i></span>
                            <?php endif; ?>

                            <?php
                            $range = 2;
                            $start = max(1, $current_page - $range);
                            $end = min($total_pages, $current_page + $range);

                            if ($end - $start < $range * 2) {
                                if ($start == 1) $end = min($total_pages, $start + $range * 2);
                                elseif ($end == $total_pages) $start = max(1, $end - $range * 2);
                            }

                            if ($start > 1) : ?>
                                <a href="<?= build_url(['page' => 1]) ?>" class="pu-page-btn">1</a>
                                <?php if ($start > 2) : ?>
                                    <span class="pu-page-dots">…</span>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for ($p = $start; $p <= $end; $p++) : ?>
                                <?php if ($p == $current_page) : ?>
                                    <span class="pu-page-btn active"><?= $p ?></span>
                                <?php else : ?>
                                    <a href="<?= build_url(['page' => $p]) ?>" class="pu-page-btn"><?= $p ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if ($end < $total_pages) : ?>
                                <?php if ($end < $total_pages - 1) : ?>
                                    <span class="pu-page-dots">…</span>
                                <?php endif; ?>
                                <a href="<?= build_url(['page' => $total_pages]) ?>" class="pu-page-btn"><?= $total_pages ?></a>
                            <?php endif; ?>

                            <!-- Next -->
                            <?php if ($current_page < $total_pages) : ?>
                                <a href="<?= build_url(['page' => $current_page + 1]) ?>" class="pu-page-btn">
                                    <i class="bx bx-chevron-right"></i>
                                </a>
                            <?php else : ?>
                                <span class="pu-page-btn disabled"><i class="bx bx-chevron-right"></i></span>
                            <?php endif; ?>
                        </div>

                        <!-- Quick Jump -->
                        <div class="pu-jump">
                            <span>Page</span>
                            <input type="number" min="1" max="<?= $total_pages ?>" value="<?= $current_page ?>" id="jumpPage">
                            <button onclick="jumpToPage()" class="pu-jump-btn">Go</button>
                        </div>
                    <?php endif; ?>
                </div>

            <?php else : ?>
                <!-- ============ EMPTY STATE ============ -->
                <div class="pu-empty">
                    <div class="pu-empty-icon">
                        <?php if (!empty($search)) : ?>
                            <i class="bx bx-search-alt"></i>
                        <?php else : ?>
                            <i class="bx bx-user-x"></i>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($search)) : ?>
                        <h5>No matches found</h5>
                        <p>Try different keywords or <a href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>">clear search</a></p>
                    <?php else : ?>
                        <h5>No participants yet</h5>
                        <p>Users who join this pool will show up here.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<!-- ============ STYLES ============ -->
<style>
    /* ---------- HEADER ---------- */
    .pu-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pu-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pu-header-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }

    /* ---------- STAT CARDS ---------- */
    .pu-stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #f0f0f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .pu-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .pu-stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .pu-stat-purple .pu-stat-icon {
        background: #ede9fe;
        color: #7c3aed;
    }

    .pu-stat-blue .pu-stat-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .pu-stat-green .pu-stat-icon {
        background: #d1fae5;
        color: #059669;
    }

    .pu-stat-info {
        display: flex;
        flex-direction: column;
    }

    .pu-stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }

    .pu-stat-label {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ---------- MAIN CARD ---------- */
    .pu-main-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    /* ---------- FILTER BAR ---------- */
    .pu-filter-bar {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .pu-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .pu-search-box {
        flex: 1;
        min-width: 220px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .pu-search-box i.bx-search {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 18px;
        pointer-events: none;
    }

    .pu-search-box input {
        width: 100%;
        padding: 10px 40px 10px 42px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }

    .pu-search-box input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .pu-search-box input::placeholder {
        color: #cbd5e1;
    }

    .pu-search-clear {
        position: absolute;
        right: 12px;
        color: #94a3b8;
        font-size: 20px;
        text-decoration: none;
        display: flex;
        transition: color 0.2s;
    }

    .pu-search-clear:hover {
        color: #ef4444;
    }

    .pu-filter-controls {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .pu-select {
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13px;
        outline: none;
        background: #fff;
        color: #475569;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .pu-select:focus {
        border-color: #6366f1;
    }

    .pu-btn {
        padding: 10px 18px;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .pu-btn-search {
        background: #6366f1;
        color: #fff;
    }

    .pu-btn-search:hover {
        background: #4f46e5;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .pu-active-filter {
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
    }

    .pu-filter-tag {
        background: #ede9fe;
        color: #6366f1;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .pu-filter-tag a {
        color: #6366f1;
        display: flex;
        font-size: 16px;
        transition: color 0.2s;
        text-decoration: none;
    }

    .pu-filter-tag a:hover {
        color: #ef4444;
    }

    /* ---------- TABLE ---------- */
    .pu-table-wrap {
        overflow-x: auto;
    }

    .pu-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pu-table thead tr {
        background: #f8fafc;
    }

    .pu-table th {
        padding: 14px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .pu-th-num {
        width: 50px;
        text-align: center;
    }

    .pu-sort-link {
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s;
    }

    .pu-sort-link:hover {
        color: #6366f1;
    }

    .pu-table td {
        padding: 14px 20px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .pu-table tbody tr {
        transition: background 0.15s;
    }

    .pu-table tbody tr:hover {
        background: #f8f7ff;
    }

    .pu-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pu-td-num {
        text-align: center;
        font-weight: 600;
        color: #94a3b8;
        font-size: 13px;
    }

    /* User Cell */
    .pu-user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pu-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: 0.5px;
    }

    .pu-user-name {
        font-weight: 600;
        color: #1e293b;
    }

    .pu-td-email {
        color: #64748b;
        font-size: 13px;
    }

    .pu-td-mobile {
        font-family: 'SF Mono', 'Fira Code', monospace;
        color: #475569;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    /* Edit Button */
    .pu-btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 16px;
        background: #f0fdf4;
        color: #16a34a;
        border: 1.5px solid #bbf7d0;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pu-btn-edit:hover {
        background: #16a34a;
        color: #fff;
        border-color: #16a34a;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
        transform: translateY(-1px);
    }

    /* ---------- PAGINATION ---------- */
    .pu-pagination-bar {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        border-top: 1px solid #f1f5f9;
        background: #fafbfc;
    }

    .pu-pagination-info {
        font-size: 13px;
        color: #64748b;
    }

    .pu-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pu-page-btn {
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        transition: all 0.2s;
        cursor: pointer;
        padding: 0 6px;
    }

    .pu-page-btn:hover:not(.active):not(.disabled) {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
        transform: translateY(-1px);
    }

    .pu-page-btn.active {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    .pu-page-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pu-page-dots {
        padding: 0 4px;
        color: #94a3b8;
        font-size: 14px;
        user-select: none;
    }

    /* Quick Jump */
    .pu-jump {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #64748b;
    }

    .pu-jump input {
        width: 52px;
        padding: 6px 8px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        text-align: center;
        outline: none;
        transition: border-color 0.2s;
    }

    .pu-jump input:focus {
        border-color: #6366f1;
    }

    .pu-jump-btn {
        padding: 6px 14px;
        background: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .pu-jump-btn:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
    }

    /* ---------- EMPTY STATE ---------- */
    .pu-empty {
        text-align: center;
        padding: 60px 24px;
    }

    .pu-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 36px;
        color: #94a3b8;
    }

    .pu-empty h5 {
        color: #334155;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .pu-empty p {
        color: #94a3b8;
        font-size: 14px;
        margin: 0;
    }

    .pu-empty a {
        color: #6366f1;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 768px) {
        .pu-filter-form {
            flex-direction: column;
        }

        .pu-search-box {
            min-width: 100%;
        }

        .pu-filter-controls {
            width: 100%;
            justify-content: space-between;
        }

        .pu-select {
            flex: 1;
        }

        .pu-pagination-bar {
            flex-direction: column;
            text-align: center;
        }

        .pu-stat-card {
            padding: 16px;
        }

        .pu-table th,
        .pu-table td {
            padding: 10px 14px;
        }

        .pu-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* ---------- ANIMATIONS ---------- */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pu-table tbody tr {
        animation: slideUp 0.25s ease forwards;
        opacity: 0;
    }

    .pu-table tbody tr:nth-child(1) {
        animation-delay: 0.03s;
    }

    .pu-table tbody tr:nth-child(2) {
        animation-delay: 0.06s;
    }

    .pu-table tbody tr:nth-child(3) {
        animation-delay: 0.09s;
    }

    .pu-table tbody tr:nth-child(4) {
        animation-delay: 0.12s;
    }

    .pu-table tbody tr:nth-child(5) {
        animation-delay: 0.15s;
    }

    .pu-table tbody tr:nth-child(6) {
        animation-delay: 0.18s;
    }

    .pu-table tbody tr:nth-child(7) {
        animation-delay: 0.21s;
    }

    .pu-table tbody tr:nth-child(8) {
        animation-delay: 0.24s;
    }

    .pu-table tbody tr:nth-child(9) {
        animation-delay: 0.27s;
    }

    .pu-table tbody tr:nth-child(10) {
        animation-delay: 0.30s;
    }
</style>

<!-- ============ JAVASCRIPT ============ -->
<script>
    function jumpToPage() {
        var input = document.getElementById('jumpPage');
        var page = parseInt(input.value);
        var max = <?= $total_pages ?>;
        if (isNaN(page) || page < 1) page = 1;
        if (page > max) page = max;
        var url = new URL(window.location.href);
        url.searchParams.set('page', page);
        window.location.href = url.toString();
    }

    document.getElementById('jumpPage')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            jumpToPage();
        }
    });

    // Ctrl+K shortcut for search
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            var el = document.getElementById('searchInput');
            el.focus();
            el.select();
        }
    });
</script>