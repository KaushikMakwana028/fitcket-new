<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --primary-color: #6f42c1;
        --primary-dark: #5a32a3;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --text-muted: #6c757d;
        --bg-light: #f8f9fa;
        --white: #ffffff;
        --warning: #ffc107;
        --warning-dark: #e0a800;
        --border-color: #ececec;
        --success: #16a34a;
        --success-bg: #e9f9ee;
        --pending: #b45309;
        --pending-bg: #fef6e7;
        --danger: #dc2626;
        --danger-bg: #fdebea;
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-xl: 32px;
        --radius-pill: 50px;
    }

    .fkb-page {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        background: var(--bg-light);
        line-height: 1.6;
    }

    .fkb-page *,
    .fkb-page *::before,
    .fkb-page *::after {
        box-sizing: border-box;
    }

    .fkb-page select,
    .fkb-page button,
    .fkb-page input {
        font-family: 'Poppins', sans-serif;
    }

    .fkb-page *:focus-visible {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    .fkb-wrap {
        max-width: 980px;
        margin: 0 auto;
        padding: 48px 20px 70px;
    }

    /* ══════════════════════════════════════════
       HEADER
    ══════════════════════════════════════════ */
    .fkb-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .fkb-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.1);
        padding: 5px 14px;
        border-radius: var(--radius-pill);
        margin-bottom: 12px;
    }

    .fkb-header h2 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        color: var(--secondary-color);
        letter-spacing: -0.02em;
        margin: 0 0 6px;
    }

    .fkb-header p {
        color: var(--text-muted);
        font-size: 0.92rem;
        margin: 0;
        max-width: 460px;
    }

    .fkb-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--white);
        border: 1.5px solid var(--border-color);
        padding: 11px 20px;
        border-radius: var(--radius-pill);
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s;
        white-space: nowrap;
    }

    .fkb-back-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.06);
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════════
       STAT STRIP — signature element
    ══════════════════════════════════════════ */
    .fkb-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }

    .fkb-stat {
        background: var(--white);
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 18px;
        position: relative;
        overflow: hidden;
    }

    .fkb-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--bar-color, var(--primary-color));
    }

    .fkb-stat-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--secondary-color);
        line-height: 1.1;
        margin-bottom: 2px;
    }

    .fkb-stat-label {
        font-size: 0.76rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .fkb-stat--total {
        --bar-color: var(--primary-color);
    }

    .fkb-stat--confirmed {
        --bar-color: var(--success);
    }

    .fkb-stat--pending {
        --bar-color: var(--pending);
    }

    .fkb-stat--spent {
        --bar-color: var(--warning);
    }

    /* ══════════════════════════════════════════
       FILTER BAR
    ══════════════════════════════════════════ */
    .fkb-filter {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: var(--radius-lg);
        padding: 22px 24px;
        margin-bottom: 28px;
        box-shadow: 0 12px 30px rgba(111, 66, 193, 0.18);
        position: relative;
        overflow: hidden;
    }

    .fkb-filter::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
        top: -100px;
        right: -60px;
        pointer-events: none;
    }

    .fkb-filter-head {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
    }

    .fkb-filter-head i {
        color: var(--white);
        font-size: 1.05rem;
    }

    .fkb-filter-head h5 {
        margin: 0;
        color: var(--white);
        font-weight: 700;
        font-size: 1rem;
    }

    .fkb-filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
        position: relative;
        z-index: 1;
    }

    .fkb-filter-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .fkb-filter-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.92);
    }

    .fkb-select {
        padding: 11px 14px;
        border: 1.5px solid rgba(255, 255, 255, 0.25);
        border-radius: var(--radius-sm);
        background: rgba(255, 255, 255, 0.97);
        color: var(--text-dark);
        font-size: 0.86rem;
        font-weight: 500;
        transition: all 0.25s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236f42c1'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .fkb-select:focus {
        outline: none;
        border-color: var(--white);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.25);
    }

    .fkb-clear-btn {
        padding: 11px 18px;
        background: rgba(255, 255, 255, 0.16);
        border: 1.5px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--radius-sm);
        color: var(--white);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        height: fit-content;
    }

    .fkb-clear-btn:hover {
        background: rgba(255, 255, 255, 0.28);
        border-color: rgba(255, 255, 255, 0.55);
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════════
       BOOKING CARDS
    ══════════════════════════════════════════ */
    .fkb-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .fkb-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1.5px solid var(--border-color);
        padding: 22px 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .fkb-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--stripe-color, var(--primary-color));
        border-radius: var(--radius-lg) 0 0 var(--radius-lg);
    }

    .fkb-card:hover {
        box-shadow: 0 18px 40px rgba(111, 66, 193, 0.1);
        border-color: rgba(111, 66, 193, 0.2);
        transform: translateY(-3px);
    }

    .fkb-card--confirmed {
        --stripe-color: var(--success);
    }

    .fkb-card--pending {
        --stripe-color: var(--pending);
    }

    .fkb-card--failed,
    .fkb-card--cancelled {
        --stripe-color: var(--danger);
    }

    .fkb-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .fkb-card-id {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .fkb-card-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.15rem;
    }

    .fkb-card-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--secondary-color);
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .fkb-card-amount {
        font-size: 0.86rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .fkb-card-amount strong {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .fkb-status-pill {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 7px 16px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .fkb-status-pill::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .fkb-status-pill.confirmed {
        background: var(--success-bg);
        color: var(--success);
    }

    .fkb-status-pill.pending {
        background: var(--pending-bg);
        color: var(--pending);
    }

    .fkb-status-pill.failed,
    .fkb-status-pill.cancelled {
        background: var(--danger-bg);
        color: var(--danger);
    }

    .fkb-card-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        padding: 14px 0;
        border-top: 1.5px dashed var(--border-color);
        border-bottom: 1.5px dashed var(--border-color);
    }

    .fkb-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 9px;
    }

    .fkb-meta-item i {
        color: var(--primary-color);
        font-size: 0.95rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .fkb-meta-label {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 2px;
    }

    .fkb-meta-value {
        font-size: 0.86rem;
        color: var(--text-dark);
        font-weight: 600;
        line-height: 1.3;
    }

    .fkb-card-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .fkb-btn {
        background: none;
        border: 1.5px solid var(--border-color);
        padding: 9px 18px;
        border-radius: var(--radius-pill);
        font-weight: 600;
        font-size: 0.84rem;
        cursor: pointer;
        transition: all 0.25s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        color: var(--text-dark);
    }

    .fkb-btn-download {
        color: var(--primary-color);
        border-color: rgba(111, 66, 193, 0.3);
    }

    .fkb-btn-download:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(111, 66, 193, 0.25);
    }

    .fkb-btn-cancel {
        color: var(--accent-color);
        border-color: rgba(142, 68, 173, 0.25);
    }

    .fkb-btn-cancel:hover {
        background: var(--accent-color);
        color: var(--white);
        border-color: var(--accent-color);
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════════
       EMPTY STATE
    ══════════════════════════════════════════ */
    .fkb-empty {
        text-align: center;
        padding: 70px 24px;
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1.5px dashed var(--border-color);
    }

    .fkb-empty i {
        font-size: 2.4rem;
        color: rgba(111, 66, 193, 0.3);
        margin-bottom: 14px;
        display: block;
    }

    .fkb-empty h4 {
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 6px;
        font-size: 1.05rem;
    }

    .fkb-empty p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
    }

    /* ══════════════════════════════════════════
       PAGINATION
    ══════════════════════════════════════════ */
    .fkb-pagination-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 14px;
        margin: 34px 0 0;
    }

    .fkb-pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .fkb-page-link {
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid var(--border-color);
        background: var(--white);
        color: var(--text-dark);
        text-decoration: none;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.86rem;
        transition: all 0.25s;
    }

    .fkb-page-link:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.06);
    }

    .fkb-page-link.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .fkb-page-link.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    .fkb-pagination-info {
        font-size: 0.83rem;
        color: var(--text-muted);
    }

    /* ══════════════════════════════════════════
       MOBILE RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .fkb-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .fkb-filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .fkb-clear-btn {
            grid-column: span 2;
            justify-self: center;
        }
    }

    @media (max-width: 768px) {
        .fkb-wrap {
            padding: 32px 16px 60px;
        }

        .fkb-header {
            flex-direction: column;
        }

        .fkb-back-btn {
            order: -1;
            align-self: flex-start;
        }

        .fkb-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .fkb-stat {
            padding: 14px;
        }

        .fkb-stat-num {
            font-size: 1.25rem;
        }

        .fkb-filter {
            padding: 18px 16px;
        }

        .fkb-filter-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .fkb-clear-btn {
            grid-column: auto;
            width: 100%;
            justify-content: center;
            height: 42px;
        }

        .fkb-card {
            padding: 18px 16px;
        }

        .fkb-card-meta {
            grid-template-columns: 1fr 1fr;
            gap: 14px 10px;
        }

        .fkb-card-actions {
            justify-content: stretch;
        }

        .fkb-btn {
            flex: 1;
            justify-content: center;
        }

        .fkb-pagination-info {
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .fkb-stats {
            grid-template-columns: 1fr 1fr;
        }

        .fkb-card-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .fkb-status-pill {
            order: -1;
        }

        .fkb-card-meta {
            grid-template-columns: 1fr;
        }

        .fkb-card-id {
            width: 100%;
        }

        .fkb-card-title {
            font-size: 0.98rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .fkb-card,
        .fkb-btn,
        .fkb-back-btn,
        .fkb-clear-btn,
        .fkb-page-link {
            transition: none !important;
        }

        .fkb-card:hover,
        .fkb-btn:hover,
        .fkb-back-btn:hover {
            transform: none !important;
        }
    }
</style>

<div class="fkb-page">
    <div class="fkb-wrap">

        <!-- ═══ HEADER ═══ -->
        <div class="fkb-header">
            <div>
                <span class="fkb-eyebrow">My Account</span>
                <h2>Bookings &amp; Reservations</h2>
                <p>Track every pass, payment and gym visit in one place.</p>
            </div>
            <!-- <a href="<?= base_url('profile'); ?>" class="fkb-back-btn">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to Dashboard
            </a> -->
        </div>

        <?php
        // ── Summary stats (computed from $bookings if controller doesn't already pass them) ──
        $fkb_total_count = isset($total_rows) ? $total_rows : (is_array($bookings ?? null) ? count($bookings) : 0);
        $fkb_confirmed = 0;
        $fkb_pending = 0;
        $fkb_spent = 0;
        if (!empty($bookings)) {
            foreach ($bookings as $__b) {
                $st = strtolower($__b['status']);
                if ($st === 'success') {
                    $fkb_confirmed++;
                    $fkb_spent += $__b['total'];
                } elseif ($st === 'pending') {
                    $fkb_pending++;
                }
            }
        }
        ?>

        <!-- ═══ STAT STRIP ═══ -->
        <div class="fkb-stats">
            <div class="fkb-stat fkb-stat--total">
                <div class="fkb-stat-num"><?= $fkb_total_count; ?></div>
                <div class="fkb-stat-label">Total Bookings</div>
            </div>
            <div class="fkb-stat fkb-stat--confirmed">
                <div class="fkb-stat-num"><?= $fkb_confirmed; ?></div>
                <div class="fkb-stat-label">Confirmed</div>
            </div>
            <div class="fkb-stat fkb-stat--pending">
                <div class="fkb-stat-num"><?= $fkb_pending; ?></div>
                <div class="fkb-stat-label">Pending</div>
            </div>
            <div class="fkb-stat fkb-stat--spent">
                <div class="fkb-stat-num">₹<?= number_format($fkb_spent, 0); ?></div>
                <div class="fkb-stat-label">Total Spent</div>
            </div>
        </div>

        <!-- ═══ FILTER BAR ═══ -->
        <div class="fkb-filter">
            <div class="fkb-filter-head">
                <i class="bi bi-funnel" aria-hidden="true"></i>
                <h5>Filter Bookings</h5>
            </div>
            <div class="fkb-filter-grid">
                <div class="fkb-filter-group">
                    <label class="fkb-filter-label" for="statusFilter">Status</label>
                    <select class="fkb-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="success">Confirmed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
                <div class="fkb-filter-group">
                    <label class="fkb-filter-label" for="dateFilter">Date Range</label>
                    <select class="fkb-select" id="dateFilter">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                    </select>
                </div>
                <div class="fkb-filter-group">
                    <label class="fkb-filter-label" for="sortFilter">Sort By</label>
                    <select class="fkb-select" id="sortFilter">
                        <option value="date_desc">Newest First</option>
                        <option value="date_asc">Oldest First</option>
                        <option value="amount_desc">Highest Amount</option>
                        <option value="amount_asc">Lowest Amount</option>
                    </select>
                </div>
                <button class="fkb-clear-btn" onclick="clearFilters()" type="button">
                    <i class="bi bi-x-circle" aria-hidden="true"></i> Clear
                </button>
            </div>
        </div>

        <!-- ═══ RESULTS ═══ -->
        <div id="bookingResults">
            <div class="fkb-list" id="bookingList">
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
                        <?php
                        $statusClass = strtolower($b['status']);
                        if ($statusClass == 'success') $statusClass = 'confirmed';
                        ?>
                        <div class="fkb-card fkb-card--<?= $statusClass; ?>"
                            data-status="<?= $statusClass; ?>"
                            data-start="<?= date('Y-m-d', strtotime($b['created_at'])); ?>"
                            data-amount="<?= $b['total']; ?>"
                            data-gym="<?= htmlspecialchars($b['gym_name']); ?>"
                            data-booking="<?= date('jS F', strtotime($b['created_at'])); ?>"
                            data-validity="<?= ucfirst($b['duration']) . ' ' . $b['qty'] . ' - ' . date('jS F', strtotime($b['start_date'])); ?>"
                            data-expiry="<?= date('jS F', strtotime($b['end_date'])); ?>"
                            data-amount-text="₹<?= number_format($b['total'], 2); ?>"
                            data-status-text="<?= ucfirst($b['status']); ?>">
                            <div class="fkb-card-top">
                                <div class="fkb-card-id">
                                    <div class="fkb-card-icon"><i class="bi bi-building" aria-hidden="true"></i></div>
                                    <div>
                                        <div class="fkb-card-title"><?= htmlspecialchars($b['gym_name']); ?></div>
                                        <div class="fkb-card-amount">Amount paid: <strong>₹<?= number_format($b['total'], 2); ?></strong></div>
                                    </div>
                                </div>
                                <span class="fkb-status-pill <?= $statusClass; ?>">
                                    <?= ucfirst($b['status']); ?>
                                </span>
                            </div>

                            <div class="fkb-card-meta">
                                <div class="fkb-meta-item">
                                    <i class="bi bi-calendar-check" aria-hidden="true"></i>
                                    <div>
                                        <div class="fkb-meta-label">Booked On</div>
                                        <div class="fkb-meta-value"><?= date('jS F', strtotime($b['created_at'])); ?></div>
                                    </div>
                                </div>
                                <div class="fkb-meta-item">
                                    <i class="bi bi-ticket-perforated" aria-hidden="true"></i>
                                    <div>
                                        <div class="fkb-meta-label">Pass Validity</div>
                                        <div class="fkb-meta-value"><?= ucfirst($b['duration']); ?> <?= $b['qty']; ?> – <?= date('jS F', strtotime($b['start_date'])); ?></div>
                                    </div>
                                </div>
                                <div class="fkb-meta-item">
                                    <i class="bi bi-hourglass-split" aria-hidden="true"></i>
                                    <div>
                                        <div class="fkb-meta-label">Expires</div>
                                        <div class="fkb-meta-value"><?= date('jS F', strtotime($b['end_date'])); ?>, 11:59 PM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="fkb-card-actions">
                                <button class="fkb-btn fkb-btn-download print-invoice" type="button">
                                    <i class="bi bi-download" aria-hidden="true"></i> Invoice
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="fkb-empty">
                        <i class="bi bi-calendar-x" aria-hidden="true"></i>
                        <h4>No bookings yet</h4>
                        <p>Once you book a gym or class, it'll show up here.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ═══ PAGINATION ═══ -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <div class="fkb-pagination-wrap">
                    <ul class="fkb-pagination">
                        <li>
                            <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . max(1, $current_page - 1)); ?>"
                                class="fkb-page-link <?= ($current_page == 1) ? 'disabled' : ''; ?>">
                                <i class="bi bi-chevron-left" aria-hidden="true"></i>
                            </a>
                        </li>
                        <?php
                        $start = max(1, $current_page - 1);
                        $end = min($total_pages, $start + 2);
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <li>
                                <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . $i); ?>"
                                    class="fkb-page-link <?= ($i == $current_page) ? 'active' : ''; ?>">
                                    <?= $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        <li>
                            <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . min($total_pages, $current_page + 1)); ?>"
                                class="fkb-page-link <?= ($current_page == $total_pages) ? 'disabled' : ''; ?>">
                                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="fkb-pagination-info">
                        Showing <?= ($current_page - 1) * $limit + 1; ?>–<?= min($current_page * $limit, $total_rows); ?> of <?= $total_rows; ?> results
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
    function applyFilters() {
        let status = document.getElementById("statusFilter").value;
        let dateRange = document.getElementById("dateFilter").value;
        let sortBy = document.getElementById("sortFilter").value;
        let items = document.querySelectorAll(".fkb-card");

        items.forEach(item => {
            let itemStatus = item.dataset.status;
            let itemDate = new Date(item.dataset.start);
            let show = true;

            if (status && itemStatus !== status) show = false;

            if (dateRange) {
                let today = new Date();
                let startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay());
                let endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 6);

                let startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                let endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                let startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                let endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);

                switch (dateRange) {
                    case "today":
                        if (itemDate.toDateString() !== today.toDateString()) show = false;
                        break;
                    case "this_week":
                        if (itemDate < startOfWeek || itemDate > endOfWeek) show = false;
                        break;
                    case "this_month":
                        if (itemDate < startOfMonth || itemDate > endOfMonth) show = false;
                        break;
                    case "last_month":
                        if (itemDate < startOfLastMonth || itemDate > endOfLastMonth) show = false;
                        break;
                }
            }

            item.style.display = show ? "" : "none";
        });

        let container = document.getElementById("bookingList");
        let visibleItems = Array.from(items).filter(item => item.style.display !== "none");

        let sorted = visibleItems.sort((a, b) => {
            let aDate = new Date(a.dataset.start);
            let bDate = new Date(b.dataset.start);
            let aAmt = parseFloat(a.dataset.amount);
            let bAmt = parseFloat(b.dataset.amount);

            if (sortBy === "date_desc") return bDate - aDate;
            if (sortBy === "date_asc") return aDate - bDate;
            if (sortBy === "amount_desc") return bAmt - aAmt;
            if (sortBy === "amount_asc") return aAmt - bAmt;
            return 0;
        });

        sorted.forEach(item => container.appendChild(item));
    }

    function clearFilters() {
        document.getElementById("statusFilter").value = "";
        document.getElementById("dateFilter").value = "";
        document.getElementById("sortFilter").value = "date_desc";
        applyFilters();
    }

    document.querySelectorAll("#statusFilter, #dateFilter, #sortFilter")
        .forEach(el => el.addEventListener("change", applyFilters));

    $(document).on("click", ".fkb-page-link", function(e) {
        e.preventDefault();
        if ($(this).hasClass("disabled") || $(this).hasClass("active")) return;

        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            success: function(response) {
                $("#bookingResults").html($(response).find("#bookingResults").html());
                $('html, body').animate({
                    scrollTop: $("#bookingResults").offset().top - 100
                }, 300);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.print-invoice').forEach(btn => {
            btn.addEventListener('click', function() {
                let booking = this.closest('.fkb-card');

                let logoUrl = "<?= base_url('assets/images/logo_ficat.png'); ?>";
                let gym = booking.dataset.gym;
                let bookingDate = booking.dataset.booking;
                let validity = booking.dataset.validity;
                let expiry = booking.dataset.expiry;
                let amount = booking.dataset.amountText;
                let status = booking.dataset.statusText;

                let printContent = `
                    <div style="font-family: Arial; padding:30px; max-width:750px; margin:0 auto; border:1px solid #ddd; border-radius:10px;">
                        <div style="text-align:center; margin-bottom:20px;">
                            <img src="${logoUrl}" alt="Company Logo" style="max-height:80px; margin-bottom:10px;">
                            <h2 style="margin:5px 0; font-size:24px; font-weight:bold; color:#6f42c1;">
                                Booking Receipt
                            </h2>
                        </div>

                        <table cellspacing="0" cellpadding="10"
                               style="width:100%; border:1px solid #ddd; border-collapse:collapse; text-align:center; font-size:14px; margin-top:15px;">
                            <thead>
                                <tr style="background:#f9f9f9; font-weight:bold; border-bottom:1px solid #ddd;">
                                    <th style="border:1px solid #ddd;">Gym Name</th>
                                    <th style="border:1px solid #ddd;">Validity</th>
                                    <th style="border:1px solid #ddd;">Expiry</th>
                                    <th style="border:1px solid #ddd;">Amount</th>
                                    <th style="border:1px solid #ddd;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border:1px solid #ddd;">${gym}</td>
                                    <td style="border:1px solid #ddd;">${validity}</td>
                                    <td style="border:1px solid #ddd;">${expiry}</td>
                                    <td style="border:1px solid #ddd;">${amount}</td>
                                    <td style="border:1px solid #ddd;">${status}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 style="text-align:right; margin-top:20px; font-weight:bold; color:#6f42c1; border-top:2px solid #ddd; padding-top:10px;">
                            Grand Total: ${amount}
                        </h3>

                        <p style="font-size:12px; margin-top:25px; text-align:center; color:#555;">
                            Thank you for booking with us!<br>
                            Visit <a href="https://fitcket.com" target="_blank" style="color:#6f42c1; text-decoration:none;">fitcket.com</a> for more services.
                        </p>
                    </div>
                `;

                let win = window.open('', '_blank', 'width=800,height=600');
                win.document.write(`<html><head><title>Booking Receipt</title></head><body>${printContent}</body></html>`);
                win.document.close();
                win.print();
            });
        });
    });
</script>