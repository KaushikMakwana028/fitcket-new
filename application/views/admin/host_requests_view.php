<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --primary: #4e54c8;
        --primary-light: #8f94fb;
        --success: #00b894;
        --success-light: #e6f9f4;
        --danger: #e74c3c;
        --danger-light: #fdf0ef;
        --warning: #f39c12;
        --warning-light: #fef9e7;
        --dark: #2c3e50;
        --text-secondary: #7f8c8d;
        --bg: #f0f2f8;
        --card-bg: #ffffff;
        --border: #e8ecf1;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .page-wrapper {
        font-family: 'Poppins', sans-serif;
        background: var(--bg);
        min-height: 100vh;
    }

    .page-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* ========== PAGE HEADER ========== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-header-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        box-shadow: 0 4px 15px rgba(78, 84, 200, 0.3);
    }

    .page-header h4 {
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--dark);
        margin: 0;
    }

    .page-header .subtitle {
        font-size: 0.82rem;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* ========== STATS CARDS ========== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-icon.total {
        background: linear-gradient(135deg, #e8eaf6, #c5cae9);
        color: var(--primary);
    }

    .stat-icon.pending {
        background: var(--warning-light);
        color: var(--warning);
    }

    .stat-icon.accepted {
        background: var(--success-light);
        color: var(--success);
    }

    .stat-icon.rejected {
        background: var(--danger-light);
        color: var(--danger);
    }

    .stat-info .stat-number {
        font-weight: 700;
        font-size: 1.4rem;
        color: var(--dark);
        line-height: 1;
    }

    .stat-info .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ========== SEARCH & FILTER BAR ========== */
    .filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 220px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 11px 16px 11px 42px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.88rem;
        outline: none;
        transition: all 0.3s ease;
        background: var(--card-bg);
    }

    .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.1);
    }

    .search-box input::placeholder {
        color: #adb5bd;
    }

    .search-box .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        font-size: 0.9rem;
    }

    .filter-btn {
        padding: 10px 20px;
        border: 2px solid var(--border);
        border-radius: 12px;
        background: var(--card-bg);
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-btn:hover,
    .filter-btn.active {
        border-color: var(--primary);
        color: var(--primary);
        background: #f0f1ff;
    }

    /* ========== TABLE CARD ========== */
    .card {
        background: var(--card-bg);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-body {
        padding: 0;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    /* ========== TABLE ========== */
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        font-size: 0.88rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #f8f9fe, #f0f1fa);
        padding: 16px 18px;
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-secondary);
        border: none;
        border-bottom: 2px solid var(--border);
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table thead th:first-child {
        padding-left: 24px;
    }

    .table thead th:last-child {
        padding-right: 24px;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #fafbff;
    }

    .table tbody td {
        padding: 16px 18px;
        border: none;
        border-bottom: 1px solid #f2f3f7;
        vertical-align: middle;
        color: var(--dark);
    }

    .table tbody td:first-child {
        padding-left: 24px;
    }

    .table tbody td:last-child {
        padding-right: 24px;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Row Number */
    .row-number {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f0f1fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--primary);
    }

    /* User Cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--dark);
    }

    /* Email & Mobile */
    .email-text {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    .email-text i {
        font-size: 0.75rem;
        color: #adb5bd;
    }

    .mobile-text {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: var(--dark);
    }

    .mobile-text i {
        font-size: 0.75rem;
        color: var(--success);
    }

    /* Instagram Link */
    .insta-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .insta-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(131, 58, 180, 0.4);
        color: #fff;
    }

    .insta-link i {
        font-size: 0.85rem;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.76rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    .status-badge .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .status-badge.pending {
        background: var(--warning-light);
        color: #d68910;
    }

    .status-badge.pending .status-dot {
        background: var(--warning);
        animation: blink 1.5s infinite;
    }

    .status-badge.accepted {
        background: var(--success-light);
        color: #1e8449;
    }

    .status-badge.accepted .status-dot {
        background: var(--success);
    }

    .status-badge.rejected {
        background: var(--danger-light);
        color: #c0392b;
    }

    .status-badge.rejected .status-dot {
        background: var(--danger);
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.4;
        }
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.accept-btn {
        background: var(--success-light);
        color: var(--success);
    }

    .action-btn.accept-btn:hover {
        background: var(--success);
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 184, 148, 0.4);
    }

    .action-btn.reject-btn {
        background: var(--danger-light);
        color: var(--danger);
    }

    .action-btn.reject-btn:hover {
        background: var(--danger);
        color: #fff;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }

    .action-btn.pending-btn {
        background: var(--warning-light);
        color: var(--warning);
    }

    .action-btn.pending-btn:hover {
        background: var(--warning);
        color: #fff;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.4);
    }

    /* Tooltip */
    .action-btn::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%) scale(0.8);
        background: var(--dark);
        color: #fff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover::after {
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }

    .empty-state .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f0f1fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
        color: var(--primary);
    }

    .empty-state .empty-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .empty-state .empty-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    /* ========== CONFIRM MODAL ========== */
    .confirm-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .confirm-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .confirm-box {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        width: 90%;
        max-width: 380px;
        text-align: center;
        transform: scale(0.9);
        transition: all 0.3s ease;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .confirm-overlay.show .confirm-box {
        transform: scale(1);
    }

    .confirm-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.6rem;
    }

    .confirm-icon.accept {
        background: var(--success-light);
        color: var(--success);
    }

    .confirm-icon.reject {
        background: var(--danger-light);
        color: var(--danger);
    }

    .confirm-icon.pending {
        background: var(--warning-light);
        color: var(--warning);
    }

    .confirm-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--dark);
        margin-bottom: 6px;
    }

    .confirm-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 22px;
    }

    .confirm-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .confirm-actions .cbtn {
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .confirm-actions .cbtn:hover {
        transform: translateY(-2px);
    }

    .cbtn.cancel {
        background: #f0f2f5;
        color: var(--text-secondary);
    }

    .cbtn.cancel:hover {
        background: #e2e5ea;
    }

    .cbtn.proceed-accept {
        background: var(--success);
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 184, 148, 0.3);
    }

    .cbtn.proceed-reject {
        background: var(--danger);
        color: #fff;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .cbtn.proceed-pending {
        background: var(--warning);
        color: #fff;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .page-content {
            padding: 20px 14px;
        }

        .page-header h4 {
            font-size: 1.2rem;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .stat-card {
            padding: 14px;
        }

        .stat-info .stat-number {
            font-size: 1.1rem;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            min-width: 100%;
        }

        .filter-btn-group {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .filter-btn {
            flex-shrink: 0;
            font-size: 0.8rem;
            padding: 8px 14px;
        }

        .table thead th {
            padding: 12px 14px;
            font-size: 0.72rem;
        }

        .table tbody td {
            padding: 12px 14px;
            font-size: 0.82rem;
        }

        .user-cell {
            gap: 8px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            font-size: 0.8rem;
            border-radius: 10px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
            border-radius: 8px;
        }
    }

    @media (max-width: 480px) {
        .stats-row {
            grid-template-columns: 1fr 1fr;
        }

        .page-header-icon {
            width: 42px;
            height: 42px;
            font-size: 1.1rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="page-wrapper">
    <div class="page-content">

        <!-- ========== PAGE HEADER ========== -->
        <div class="page-header">
            <div class="page-header-left">
                <div class="page-header-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h4>Host Requests</h4>
                    <div class="subtitle">Manage and review host applications</div>
                </div>
            </div>
        </div>

        <!-- ========== STATS ROW ========== -->
        <?php
        $total = count($requests ?? []);
        $pendingCount = 0;
        $acceptedCount = 0;
        $rejectedCount = 0;
        if (!empty($requests)) {
            foreach ($requests as $r) {
                if ($r['status'] == 'pending') $pendingCount++;
                elseif ($r['status'] == 'accepted') $acceptedCount++;
                else $rejectedCount++;
            }
        }
        ?>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-layer-group"></i></div>
                <div class="stat-info">
                    <div class="stat-number"><?= $total ?></div>
                    <div class="stat-label">Total</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
                <div class="stat-info">
                    <div class="stat-number"><?= $pendingCount ?></div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon accepted"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-number"><?= $acceptedCount ?></div>
                    <div class="stat-label">Accepted</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rejected"><i class="fas fa-times-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-number"><?= $rejectedCount ?></div>
                    <div class="stat-label">Rejected</div>
                </div>
            </div>
        </div>

        <!-- ========== FILTER BAR ========== -->
        <div class="filter-bar">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search by name, email or mobile..." onkeyup="filterTable()">
            </div>
            <div class="filter-btn-group" style="display:flex; gap:8px;">
                <button class="filter-btn active" onclick="filterStatus('all', this)">All</button>
                <button class="filter-btn" onclick="filterStatus('pending', this)">
                    <i class="fas fa-clock"></i> Pending
                </button>
                <button class="filter-btn" onclick="filterStatus('accepted', this)">
                    <i class="fas fa-check"></i> Accepted
                </button>
                <button class="filter-btn" onclick="filterStatus('rejected', this)">
                    <i class="fas fa-times"></i> Rejected
                </button>
            </div>
        </div>

        <!-- ========== TABLE CARD ========== -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="requestsTable">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Instagram</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($requests)): ?>
                                <?php foreach ($requests as $i => $r): ?>
                                    <tr data-status="<?= $r['status'] ?>">

                                        <td>
                                            <div class="row-number"><?= $i + 1 ?></div>
                                        </td>

                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar">
                                                    <?= strtoupper(substr($r['name'], 0, 1)) ?>
                                                </div>
                                                <div class="user-name"><?= $r['name'] ?></div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="email-text">
                                                <i class="fas fa-envelope"></i>
                                                <?= $r['email'] ?>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="mobile-text">
                                                <i class="fas fa-phone"></i>
                                                <?= $r['mobile'] ?>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="<?= $r['instagram_url'] ?>" target="_blank" class="insta-link">
                                                <i class="fab fa-instagram"></i>
                                                Profile
                                            </a>
                                        </td>

                                        <td>
                                            <?php if ($r['status'] == 'pending'): ?>
                                                <span class="status-badge pending">
                                                    <span class="status-dot"></span>
                                                    Pending
                                                </span>
                                            <?php elseif ($r['status'] == 'accepted'): ?>
                                                <span class="status-badge accepted">
                                                    <span class="status-dot"></span>
                                                    Accepted
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge rejected">
                                                    <span class="status-dot"></span>
                                                    Rejected
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="action-group">
                                                <a href="javascript:void(0)"
                                                    class="action-btn accept-btn"
                                                    data-tooltip="Accept"
                                                    onclick="confirmAction('accept', '<?= $r['id'] ?>', '<?= addslashes($r['name']) ?>')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="action-btn reject-btn"
                                                    data-tooltip="Reject"
                                                    onclick="confirmAction('reject', '<?= $r['id'] ?>', '<?= addslashes($r['name']) ?>')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    class="action-btn pending-btn"
                                                    data-tooltip="Pending"
                                                    onclick="confirmAction('pending', '<?= $r['id'] ?>', '<?= addslashes($r['name']) ?>')">
                                                    <i class="fas fa-clock"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-inbox"></i>
                                            </div>
                                            <div class="empty-title">No Requests Found</div>
                                            <div class="empty-text">There are no host requests to display at the moment.</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ========== CONFIRMATION MODAL ========== -->
<div class="confirm-overlay" id="confirmOverlay">
    <div class="confirm-box">
        <div class="confirm-icon" id="confirmIcon">
            <i id="confirmIconI"></i>
        </div>
        <div class="confirm-title" id="confirmTitle"></div>
        <div class="confirm-text" id="confirmText"></div>
        <div class="confirm-actions">
            <button class="cbtn cancel" onclick="closeConfirm()">Cancel</button>
            <a href="#" class="cbtn" id="confirmProceed">Confirm</a>
        </div>
    </div>
</div>

<script>
    // ========== CONFIRMATION DIALOG ==========
    function confirmAction(action, id, name) {
        const overlay = document.getElementById('confirmOverlay');
        const icon = document.getElementById('confirmIcon');
        const iconI = document.getElementById('confirmIconI');
        const title = document.getElementById('confirmTitle');
        const text = document.getElementById('confirmText');
        const proceed = document.getElementById('confirmProceed');

        // Reset classes
        icon.className = 'confirm-icon';
        proceed.className = 'cbtn';

        if (action === 'accept') {
            icon.classList.add('accept');
            iconI.className = 'fas fa-check';
            title.textContent = 'Accept Request?';
            text.textContent = `Are you sure you want to accept the host request from "${name}"? They will be granted host privileges.`;
            proceed.classList.add('proceed-accept');
            proceed.href = `<?= base_url('admin/host_requests/accept/') ?>${id}`;
        } else if (action === 'reject') {
            icon.classList.add('reject');
            iconI.className = 'fas fa-times';
            title.textContent = 'Reject Request?';
            text.textContent = `Are you sure you want to reject the host request from "${name}"? This action can be changed later.`;
            proceed.classList.add('proceed-reject');
            proceed.href = `<?= base_url('admin/host_requests/reject/') ?>${id}`;
        } else {
            icon.classList.add('pending');
            iconI.className = 'fas fa-clock';
            title.textContent = 'Set to Pending?';
            text.textContent = `Are you sure you want to set the request from "${name}" back to pending status?`;
            proceed.classList.add('proceed-pending');
            proceed.href = `<?= base_url('admin/host_requests/pending/') ?>${id}`;
        }

        proceed.textContent = 'Confirm';
        overlay.classList.add('show');
    }

    function closeConfirm() {
        document.getElementById('confirmOverlay').classList.remove('show');
    }

    // Close on overlay click
    document.getElementById('confirmOverlay').addEventListener('click', function(e) {
        if (e.target === this) closeConfirm();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeConfirm();
    });

    // ========== SEARCH FILTER ==========
    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#requestsTable tbody tr[data-status]');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matchesSearch = text.includes(input);
            const currentFilter = document.querySelector('.filter-btn.active')?.dataset?.filter || 'all';
            const matchesFilter = currentFilter === 'all' || row.dataset.status === currentFilter;

            row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
        });
    }

    // ========== STATUS FILTER ==========
    function filterStatus(status, btn) {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
            b.dataset.filter = '';
        });
        btn.classList.add('active');
        btn.dataset.filter = status;

        const rows = document.querySelectorAll('#requestsTable tbody tr[data-status]');
        const searchVal = document.getElementById('searchInput').value.toLowerCase();

        rows.forEach(row => {
            const matchesFilter = status === 'all' || row.dataset.status === status;
            const matchesSearch = row.textContent.toLowerCase().includes(searchVal);

            row.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
        });
    }

    // Set initial data-filter attributes
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.classList.contains('active')) btn.dataset.filter = 'all';
    });
</script>