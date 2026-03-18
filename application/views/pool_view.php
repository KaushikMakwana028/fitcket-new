<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #4e54c8;
        --primary-light: #8f94fb;
        --primary-ultra: #f0f1ff;
        --accent: #e94560;
        --accent-light: #ff6b81;
        --success: #00b894;
        --success-light: #e6f9f4;
        --warning: #f39c12;
        --warning-light: #fef9e7;
        --danger: #e74c3c;
        --danger-light: #fdf0ef;
        --gold: #f1c40f;
        --dark: #1a1a2e;
        --text-primary: #1a1a2e;
        --text-secondary: #6c757d;
        --text-muted: #adb5bd;
        --bg: #f0f2f8;
        --card-bg: #ffffff;
        --border: #e8ecf1;
        --hover-bg: #fafbff;
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 12px 48px rgba(0, 0, 0, 0.12);
        --radius-sm: 10px;
        --radius-md: 14px;
        --radius-lg: 18px;
        --radius-xl: 22px;
    }

    .pools-page {
        font-family: 'Poppins', sans-serif;
        background: var(--bg);
        min-height: 100vh;
        padding: 24px 0 40px;
        color: var(--text-primary);
    }

    .pools-page * {
        box-sizing: border-box;
    }

    /* ========== PAGE HEADER ========== */
    .pools-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    .pools-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pools-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        box-shadow: 0 4px 16px rgba(78, 84, 200, 0.3);
        flex-shrink: 0;
    }

    .pools-header-info h3 {
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        color: var(--text-primary);
    }

    .pools-header-info .pools-subtitle {
        font-size: 0.78rem;
        color: var(--text-secondary);
        margin-top: 1px;
    }

    .add-pool-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border-radius: 50px;
        background: linear-gradient(135deg, var(--accent), var(--accent-light));
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(233, 69, 96, 0.3);
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
    }

    .add-pool-btn .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .add-pool-btn:hover .btn-shine {
        left: 100%;
    }

    .add-pool-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(233, 69, 96, 0.4);
        color: #fff;
        text-decoration: none;
    }

    .add-pool-btn:active {
        transform: translateY(0);
    }

    /* ========== STATS ROW ========== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-card .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .stat-icon.total {
        background: var(--primary-ultra);
        color: var(--primary);
    }

    .stat-icon.active-pools {
        background: var(--success-light);
        color: var(--success);
    }

    .stat-icon.full-pools {
        background: var(--warning-light);
        color: var(--warning);
    }

    .stat-icon.total-players {
        background: var(--danger-light);
        color: var(--accent);
    }

    .stat-card .stat-number {
        font-weight: 700;
        font-size: 1.25rem;
        line-height: 1;
        color: var(--text-primary);
    }

    .stat-card .stat-label {
        font-size: 0.68rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 2px;
    }

    /* ========== SEARCH & FILTER BAR ========== */
    .filter-section {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
    }

    .filter-row-1 {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-box .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.85rem;
        pointer-events: none;
    }

    .search-box input {
        width: 100%;
        padding: 10px 14px 10px 40px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.84rem;
        outline: none;
        transition: all 0.3s ease;
        background: #fff;
        color: var(--text-primary);
    }

    .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(78, 84, 200, 0.1);
    }

    .search-box input::placeholder {
        color: var(--text-muted);
    }

    .sort-select {
        min-width: 160px;
        padding: 10px 14px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.84rem;
        outline: none;
        background: #fff;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
    }

    .sort-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(78, 84, 200, 0.1);
    }

    .filter-row-2 {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-right: 4px;
    }

    .filter-chip {
        padding: 6px 14px;
        border-radius: 20px;
        border: 2px solid var(--border);
        background: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        user-select: none;
    }

    .filter-chip:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .filter-chip.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .filter-chip .chip-count {
        background: rgba(0, 0, 0, 0.1);
        padding: 1px 6px;
        border-radius: 10px;
        font-size: 0.68rem;
        font-weight: 600;
    }

    .filter-chip.active .chip-count {
        background: rgba(255, 255, 255, 0.25);
    }

    .price-filter {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
    }

    .price-input {
        width: 80px;
        padding: 6px 10px;
        border: 2px solid var(--border);
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.78rem;
        outline: none;
        text-align: center;
        transition: all 0.3s ease;
    }

    .price-input:focus {
        border-color: var(--primary);
    }

    .price-separator {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .results-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
        padding: 0 4px;
    }

    .results-count {
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .results-count span {
        font-weight: 700;
        color: var(--primary);
    }

    .view-toggle {
        display: flex;
        gap: 4px;
        background: var(--card-bg);
        border-radius: 10px;
        padding: 3px;
        border: 1px solid var(--border);
    }

    .view-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .view-btn.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 2px 8px rgba(78, 84, 200, 0.3);
    }

    /* ========== POOL CARDS (CARD VIEW) ========== */
    .pools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 14px;
    }

    .pool-card {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        position: relative;
    }

    .pool-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .pool-card-accent {
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
    }

    .pool-card-accent.full {
        background: linear-gradient(90deg, var(--warning), #e67e22);
    }

    .pool-card-accent.almost-full {
        background: linear-gradient(90deg, #e74c3c, var(--accent));
    }

    .pool-card-body {
        padding: 18px;
    }

    .pool-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 14px;
        gap: 12px;
    }

    .pool-name-section {
        flex: 1;
        min-width: 0;
    }

    .pool-name {
        font-weight: 700;
        font-size: 1rem;
        color: var(--text-primary);
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pool-host {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.74rem;
        color: var(--text-secondary);
    }

    .pool-host .host-avatar {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.5rem;
        font-weight: 600;
    }

    .pool-card-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        flex-shrink: 0;
    }

    .pool-price-tag {
        background: linear-gradient(135deg, var(--success), #27ae60);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .pool-price-tag.free {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .pool-card-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }

    .pool-stat {
        background: #f8f9fa;
        border-radius: var(--radius-sm);
        padding: 10px 12px;
        text-align: center;
    }

    .pool-stat .stat-val {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-primary);
        line-height: 1;
    }

    .pool-stat .stat-lbl {
        font-size: 0.68rem;
        color: var(--text-secondary);
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Progress Bar */
    .pool-progress-section {
        margin-bottom: 14px;
    }

    .progress-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .progress-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .progress-percent {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--primary);
    }

    .progress-bar-bg {
        width: 100%;
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transition: width 0.6s ease;
        min-width: 2px;
    }

    .progress-bar-fill.warning {
        background: linear-gradient(90deg, var(--warning), #e67e22);
    }

    .progress-bar-fill.danger {
        background: linear-gradient(90deg, var(--danger), var(--accent));
    }

    .progress-bar-fill.full {
        background: linear-gradient(90deg, var(--success), #27ae60);
    }

    /* Pool Card Footer */
    .pool-card-footer {
        display: flex;
        gap: 8px;
    }

    .pool-join-btn {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Poppins', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .pool-join-btn.join {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        box-shadow: 0 3px 12px rgba(78, 84, 200, 0.25);
    }

    .pool-join-btn.join:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 18px rgba(78, 84, 200, 0.35);
        color: #fff;
    }

    .pool-join-btn.full {
        background: #e9ecef;
        color: var(--text-muted);
        cursor: not-allowed;
        pointer-events: none;
    }

    .pool-join-btn.joined {
        background: var(--success-light);
        color: var(--success);
        cursor: default;
    }

    .pool-view-btn {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        border: 2px solid var(--border);
        background: #fff;
        color: var(--text-secondary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        flex-shrink: 0;
    }

    .pool-view-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-ultra);
    }

    /* Pool Status Badge */
    .pool-status-badge {
        position: static;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1.2;
    }

    .pool-status-badge.open {
        background: var(--success-light);
        color: var(--success);
    }

    .pool-status-badge.almost-full {
        background: var(--warning-light);
        color: var(--warning);
    }

    .pool-status-badge.full {
        background: var(--danger-light);
        color: var(--danger);
    }

    /* ========== TABLE VIEW ========== */
    .pools-table-card {
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        display: none;
    }

    .pools-table-card.active {
        display: block;
    }

    .pools-grid.active {
        display: grid;
    }

    .pools-grid {
        display: none;
    }

    .pools-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.85rem;
    }

    .pools-table thead th {
        background: linear-gradient(135deg, #f8f9fe, #f0f1fa);
        padding: 14px 16px;
        font-weight: 600;
        font-size: 0.74rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-secondary);
        border-bottom: 2px solid var(--border);
        white-space: nowrap;
        position: sticky;
        top: 0;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }

    .pools-table thead th:hover {
        color: var(--primary);
    }

    .pools-table thead th .sort-icon {
        margin-left: 4px;
        font-size: 0.65rem;
        opacity: 0.4;
        transition: opacity 0.2s ease;
    }

    .pools-table thead th:hover .sort-icon {
        opacity: 1;
    }

    .pools-table tbody tr {
        transition: all 0.2s ease;
    }

    .pools-table tbody tr:hover {
        background: var(--hover-bg);
    }

    .pools-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f2f3f7;
        vertical-align: middle;
    }

    .pools-table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-pool-name {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-pool-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .table-pool-title {
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-primary);
    }

    .table-host {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .table-host-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.6rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .table-price {
        font-weight: 700;
        color: var(--success);
    }

    .table-price.free {
        color: #3498db;
    }

    .table-progress {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .table-progress-bar {
        flex: 1;
        height: 5px;
        border-radius: 3px;
        background: #e9ecef;
        min-width: 60px;
        overflow: hidden;
    }

    .table-progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.4s ease;
    }

    .table-progress-text {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .table-action-btn {
        padding: 6px 16px;
        border-radius: 8px;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-size: 0.76rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .table-action-btn.join {
        background: var(--primary);
        color: #fff;
    }

    .table-action-btn.join:hover {
        background: var(--primary-light);
        color: #fff;
    }

    .table-action-btn.full {
        background: #e9ecef;
        color: var(--text-muted);
        pointer-events: none;
    }

    .table-action-btn.joined {
        background: var(--success-light);
        color: var(--success);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--primary-ultra);
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
        color: var(--text-primary);
        margin-bottom: 4px;
    }

    .empty-state .empty-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    /* ========== NO RESULTS ========== */
    .no-results {
        display: none;
        text-align: center;
        padding: 40px 20px;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .no-results .nr-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .no-results .nr-title {
        font-weight: 600;
        font-size: 1rem;
        color: var(--text-primary);
        margin-bottom: 4px;
    }

    .no-results .nr-text {
        font-size: 0.82rem;
        color: var(--text-secondary);
    }

    .no-results .clear-filter-btn {
        margin-top: 14px;
        padding: 8px 20px;
        border-radius: 8px;
        border: 2px solid var(--primary);
        background: transparent;
        color: var(--primary);
        font-family: 'Poppins', sans-serif;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .no-results .clear-filter-btn:hover {
        background: var(--primary);
        color: #fff;
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .delay-1 {
        animation-delay: 0.05s;
    }

    .delay-2 {
        animation-delay: 0.12s;
    }

    .delay-3 {
        animation-delay: 0.2s;
    }

    .delay-4 {
        animation-delay: 0.28s;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .pools-page {
            padding: 16px 0 30px;
        }

        .pools-header {
            margin-bottom: 18px;
        }

        .pools-header-info h3 {
            font-size: 1.2rem;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .stat-card {
            padding: 12px;
        }

        .stat-card .stat-number {
            font-size: 1.1rem;
        }

        .filter-row-1 {
            flex-direction: column;
        }

        .sort-select {
            min-width: 100%;
        }

        .filter-row-2 {
            flex-direction: column;
            align-items: flex-start;
        }

        .price-filter {
            margin-left: 0;
            margin-top: 6px;
        }

        .pools-grid {
            grid-template-columns: 1fr;
        }

        .pool-card-stats {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .pools-header-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .add-pool-btn {
            padding: 8px 18px;
            font-size: 0.8rem;
        }

        .stat-card .stat-icon {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
// Calculate stats
$joinedPoolIds = array_map('intval', $joined_pool_ids ?? []);
$totalPools = count($pools ?? []);
$totalPlayers = 0;
$fullPools = 0;
$activePools = 0;

if (!empty($pools)) {
    foreach ($pools as $p) {
        $totalPlayers += $p['total_joined'];
        if ($p['total_joined'] >= $p['user_limit']) {
            $fullPools++;
        } else {
            $activePools++;
        }
    }
}
?>

<div class="pools-page">
    <div class="container">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- ========== HEADER ========== -->
        <div class="pools-header animate-in delay-1">
            <div class="pools-header-left">
                <div class="pools-header-icon">🏏</div>
                <div class="pools-header-info">
                    <h3>All Pools</h3>
                    <div class="pools-subtitle">All host-created pools are listed here</div>
                </div>
            </div>
            <?php if ($user['is_host'] == 1): ?>
                <a href="<?= base_url('pool/add') ?>" class="add-pool-btn">
                    <span class="btn-shine"></span>
                    <i class="fas fa-plus"></i>
                    Add Pool
                </a>
            <?php endif; ?>
        </div>

        <!-- ========== STATS ========== -->
        <div class="stats-row animate-in delay-2">
            <div class="stat-card">
                <div class="stat-icon total"><i class="fas fa-layer-group"></i></div>
                <div>
                    <div class="stat-number"><?= $totalPools ?></div>
                    <div class="stat-label">Total Pools</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon active-pools"><i class="fas fa-door-open"></i></div>
                <div>
                    <div class="stat-number"><?= $activePools ?></div>
                    <div class="stat-label">Open Pools</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon full-pools"><i class="fas fa-lock"></i></div>
                <div>
                    <div class="stat-number"><?= $fullPools ?></div>
                    <div class="stat-label">Full Pools</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon total-players"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-number"><?= $totalPlayers ?></div>
                    <div class="stat-label">Total Players</div>
                </div>
            </div>
        </div>

        <!-- ========== FILTERS ========== -->
        <div class="filter-section animate-in delay-3">
            <div class="filter-row-1">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Search pools by name or host..." oninput="applyFilters()">
                </div>
                <select class="sort-select" id="sortSelect" onchange="applyFilters()">
                    <option value="default">Sort By</option>
                    <option value="name-asc">Name A-Z</option>
                    <option value="name-desc">Name Z-A</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="joined-high">Most Joined</option>
                    <option value="joined-low">Least Joined</option>
                    <option value="spots-left">Spots Left</option>
                </select>
            </div>
            <div class="filter-row-2">
                <span class="filter-label"><i class="fas fa-filter"></i> Filter:</span>
                <button class="filter-chip active" data-filter="all" onclick="setFilter('all', this)">
                    All <span class="chip-count"><?= $totalPools ?></span>
                </button>
                <button class="filter-chip" data-filter="open" onclick="setFilter('open', this)">
                    <i class="fas fa-door-open"></i> Open <span class="chip-count"><?= $activePools ?></span>
                </button>
                <button class="filter-chip" data-filter="full" onclick="setFilter('full', this)">
                    <i class="fas fa-lock"></i> Full <span class="chip-count"><?= $fullPools ?></span>
                </button>

                <div class="price-filter">
                    <span class="filter-label">Price:</span>
                    <input type="number" class="price-input" id="priceMin" placeholder="Min" oninput="applyFilters()">
                    <span class="price-separator">—</span>
                    <input type="number" class="price-input" id="priceMax" placeholder="Max" oninput="applyFilters()">
                </div>
            </div>
        </div>

        <!-- ========== RESULTS INFO ========== -->
        <div class="results-info animate-in delay-4">
            <div class="results-count">
                Showing <span id="visibleCount"><?= $totalPools ?></span> of <span><?= $totalPools ?></span> pools
            </div>
            <div class="view-toggle">
                <button class="view-btn active" id="cardViewBtn" onclick="switchView('card')" title="Card View">
                    <i class="fas fa-th-large"></i>
                </button>
                <button class="view-btn" id="tableViewBtn" onclick="switchView('table')" title="Table View">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>

        <?php if (!empty($pools)): ?>

            <!-- ========== CARD VIEW ========== -->
            <div class="pools-grid active" id="cardView">
                <?php foreach ($pools as $p):
                    $percent = $p['user_limit'] > 0 ? round(($p['total_joined'] / $p['user_limit']) * 100) : 0;
                    $spotsLeft = $p['user_limit'] - $p['total_joined'];
                    $isFull = $spotsLeft <= 0;
                    $isAlmostFull = !$isFull && $percent >= 80;
                    $hasJoined = in_array((int) $p['id'], $joinedPoolIds, true);

                    if ($hasJoined) {
                        $accentClass = '';
                        $barClass = 'full';
                        $statusText = 'JOINED';
                        $statusClass = 'open';
                    } elseif ($isFull) {
                        $accentClass = 'full';
                        $barClass = 'full';
                        $statusText = 'FULL';
                        $statusClass = 'full';
                    } elseif ($isAlmostFull) {
                        $accentClass = 'almost-full';
                        $barClass = 'danger';
                        $statusText = 'ALMOST FULL';
                        $statusClass = 'almost-full';
                    } else {
                        $accentClass = '';
                        $barClass = $percent >= 50 ? 'warning' : '';
                        $statusText = 'OPEN';
                        $statusClass = 'open';
                    }
                ?>
                    <div class="pool-card"
                        data-name="<?= strtolower($p['pool_name']) ?>"
                        data-host="<?= strtolower($p['host_name']) ?>"
                        data-price="<?= $p['price'] ?>"
                        data-joined="<?= $p['total_joined'] ?>"
                        data-limit="<?= $p['user_limit'] ?>"
                        data-spots="<?= $spotsLeft ?>"
                        data-status="<?= $isFull ? 'full' : 'open' ?>">

                        <div class="pool-card-accent <?= $accentClass ?>"></div>

                        <div class="pool-card-body">
                            <div class="pool-card-top">
                                <div class="pool-name-section">
                                    <div class="pool-name"><?= $p['pool_name'] ?></div>
                                    <div class="pool-host">
                                        <span class="host-avatar"><?= strtoupper(substr($p['host_name'], 0, 1)) ?></span>
                                        <?= $p['host_name'] ?>
                                    </div>
                                </div>
                                <div class="pool-card-meta">
                                    <span class="pool-status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                                    <div class="pool-price-tag <?= $p['price'] == 0 ? 'free' : '' ?>">
                                    <?= $p['price'] == 0 ? 'FREE' : '₹' . number_format($p['price']) ?>
                                </div>
                            </div>

                            </div>
                            <div class="pool-card-stats">
                                <div class="pool-stat">
                                    <div class="stat-val"><?= $p['user_limit'] ?></div>
                                    <div class="stat-lbl">Limit</div>
                                </div>
                                <div class="pool-stat">
                                    <div class="stat-val"><?= $p['total_joined'] ?></div>
                                    <div class="stat-lbl">Joined</div>
                                </div>
                            </div>

                            <div class="pool-progress-section">
                                <div class="progress-header">
                                    <span class="progress-label"><?= $spotsLeft > 0 ? $spotsLeft . ' spots left' : 'No spots left' ?></span>
                                    <span class="progress-percent"><?= $percent ?>%</span>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill <?= $barClass ?>" style="width: <?= $percent ?>%"></div>
                                </div>
                            </div>

                            <div class="pool-card-footer">
                                <?php if ($hasJoined): ?>
                                    <button class="pool-join-btn joined" disabled>
                                        <i class="fas fa-check"></i> Joined
                                    </button>
                                <?php elseif ($isFull): ?>
                                    <button class="pool-join-btn full" disabled>
                                        <i class="fas fa-lock"></i> Pool Full
                                    </button>
                                <?php else: ?>
                                    <a href="<?= base_url('pool/join/' . $p['id']) ?>" class="pool-join-btn join">
                                        <i class="fas fa-sign-in-alt"></i> Join Pool
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('pool/view/' . $p['id']) ?>" class="pool-view-btn" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ========== TABLE VIEW ========== -->
            <div class="pools-table-card" id="tableView">
                <div style="overflow-x:auto;">
                    <table class="pools-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pool Name <i class="fas fa-sort sort-icon"></i></th>
                                <th>Host <i class="fas fa-sort sort-icon"></i></th>
                                <th>Price <i class="fas fa-sort sort-icon"></i></th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pools as $i => $p):
                                $percent = $p['user_limit'] > 0 ? round(($p['total_joined'] / $p['user_limit']) * 100) : 0;
                                $spotsLeft = $p['user_limit'] - $p['total_joined'];
                                $isFull = $spotsLeft <= 0;
                                $hasJoined = in_array((int) $p['id'], $joinedPoolIds, true);
                                $barClass = $isFull ? 'full' : ($percent >= 80 ? 'danger' : ($percent >= 50 ? 'warning' : ''));
                                $fillColor = $isFull ? 'var(--success)' : ($percent >= 80 ? 'var(--danger)' : ($percent >= 50 ? 'var(--warning)' : 'var(--primary)'));
                            ?>
                                <tr data-name="<?= strtolower($p['pool_name']) ?>"
                                    data-host="<?= strtolower($p['host_name']) ?>"
                                    data-price="<?= $p['price'] ?>"
                                    data-joined="<?= $p['total_joined'] ?>"
                                    data-limit="<?= $p['user_limit'] ?>"
                                    data-spots="<?= $spotsLeft ?>"
                                    data-status="<?= $isFull ? 'full' : 'open' ?>">

                                    <td style="color:var(--text-muted); font-weight:600;"><?= $i + 1 ?></td>

                                    <td>
                                        <div class="table-pool-name">
                                            <div class="table-pool-icon">🏏</div>
                                            <span class="table-pool-title"><?= $p['pool_name'] ?></span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="table-host">
                                            <span class="table-host-avatar"><?= strtoupper(substr($p['host_name'], 0, 1)) ?></span>
                                            <?= $p['host_name'] ?>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="table-price <?= $p['price'] == 0 ? 'free' : '' ?>">
                                            <?= $p['price'] == 0 ? 'Free' : '₹' . number_format($p['price']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="table-progress">
                                            <div class="table-progress-bar">
                                                <div class="table-progress-fill" style="width:<?= $percent ?>%; background:<?= $fillColor ?>"></div>
                                            </div>
                                            <span class="table-progress-text"><?= $p['total_joined'] ?>/<?= $p['user_limit'] ?></span>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if ($hasJoined): ?>
                                            <span class="pool-status-badge open" style="position:static;">JOINED</span>
                                        <?php elseif ($isFull): ?>
                                            <span class="pool-status-badge full" style="position:static;">FULL</span>
                                        <?php elseif ($percent >= 80): ?>
                                            <span class="pool-status-badge almost-full" style="position:static;">FILLING</span>
                                        <?php else: ?>
                                            <span class="pool-status-badge open" style="position:static;">OPEN</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($hasJoined): ?>
                                            <span class="table-action-btn full"><i class="fas fa-check"></i> Joined</span>
                                        <?php elseif ($isFull): ?>
                                            <span class="table-action-btn full"><i class="fas fa-lock"></i> Full</span>
                                        <?php else: ?>
                                            <a href="<?= base_url('pool/join/' . $p['id']) ?>" class="table-action-btn join">
                                                <i class="fas fa-sign-in-alt"></i> Join
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-swimming-pool"></i></div>
                <div class="empty-title">No Pools Available</div>
                <div class="empty-text">No host has created a pool yet. Once any host creates one, it will appear here.</div>
            </div>
        <?php endif; ?>

        <!-- NO RESULTS MESSAGE -->
        <div class="no-results" id="noResults">
            <div class="nr-icon">🔍</div>
            <div class="nr-title">No pools match your filters</div>
            <div class="nr-text">Try adjusting your search or filter criteria</div>
            <button class="clear-filter-btn" onclick="clearAllFilters()">
                <i class="fas fa-undo"></i> Clear All Filters
            </button>
        </div>

    </div>
</div>

<script>
    let currentFilter = 'all';
    let currentView = 'card';

    // ========== VIEW TOGGLE ==========
    function switchView(view) {
        currentView = view;
        const cardView = document.getElementById('cardView');
        const tableView = document.getElementById('tableView');
        const cardBtn = document.getElementById('cardViewBtn');
        const tableBtn = document.getElementById('tableViewBtn');

        if (view === 'card') {
            cardView?.classList.add('active');
            tableView?.classList.remove('active');
            cardBtn?.classList.add('active');
            tableBtn?.classList.remove('active');
        } else {
            cardView?.classList.remove('active');
            tableView?.classList.add('active');
            cardBtn?.classList.remove('active');
            tableBtn?.classList.add('active');
        }
    }

    // ========== FILTER CHIPS ==========
    function setFilter(filter, btn) {
        currentFilter = filter;
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        applyFilters();
    }

    // ========== MAIN FILTER FUNCTION ==========
    function applyFilters() {
        const search = document.getElementById('searchInput').value.toLowerCase().trim();
        const sort = document.getElementById('sortSelect').value;
        const priceMin = parseFloat(document.getElementById('priceMin').value) || 0;
        const priceMax = parseFloat(document.getElementById('priceMax').value) || Infinity;

        // Get all pool elements
        const cards = document.querySelectorAll('.pool-card');
        const rows = document.querySelectorAll('.pools-table tbody tr');

        let visibleCount = 0;

        // Filter function
        function shouldShow(el) {
            const name = el.dataset.name || '';
            const host = el.dataset.host || '';
            const price = parseFloat(el.dataset.price) || 0;
            const status = el.dataset.status || '';

            const matchesSearch = name.includes(search) || host.includes(search);
            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesPrice = price >= priceMin && price <= priceMax;

            return matchesSearch && matchesFilter && matchesPrice;
        }

        // Apply to cards
        cards.forEach(card => {
            const show = shouldShow(card);
            card.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        // Apply to table rows
        rows.forEach(row => {
            row.style.display = shouldShow(row) ? '' : 'none';
        });

        // Sort
        if (sort !== 'default') {
            sortElements(sort);
        }

        // Update count
        document.getElementById('visibleCount').textContent = visibleCount;

        // Show/hide no results
        const noResults = document.getElementById('noResults');
        const cardView = document.getElementById('cardView');
        const tableView = document.getElementById('tableView');

        if (visibleCount === 0) {
            noResults.style.display = 'block';
            if (cardView) cardView.style.display = 'none';
            if (tableView) tableView.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            if (currentView === 'card' && cardView) {
                cardView.style.display = 'grid';
            } else if (currentView === 'table' && tableView) {
                tableView.style.display = 'block';
            }
        }
    }

    // ========== SORT ==========
    function sortElements(sort) {
        const grid = document.getElementById('cardView');
        if (!grid) return;

        const cards = Array.from(grid.querySelectorAll('.pool-card'));

        cards.sort((a, b) => {
            switch (sort) {
                case 'name-asc':
                    return (a.dataset.name || '').localeCompare(b.dataset.name || '');
                case 'name-desc':
                    return (b.dataset.name || '').localeCompare(a.dataset.name || '');
                case 'price-low':
                    return (parseFloat(a.dataset.price) || 0) - (parseFloat(b.dataset.price) || 0);
                case 'price-high':
                    return (parseFloat(b.dataset.price) || 0) - (parseFloat(a.dataset.price) || 0);
                case 'joined-high':
                    return (parseInt(b.dataset.joined) || 0) - (parseInt(a.dataset.joined) || 0);
                case 'joined-low':
                    return (parseInt(a.dataset.joined) || 0) - (parseInt(b.dataset.joined) || 0);
                case 'spots-left':
                    return (parseInt(b.dataset.spots) || 0) - (parseInt(a.dataset.spots) || 0);
                default:
                    return 0;
            }
        });

        cards.forEach(card => grid.appendChild(card));
    }

    // ========== CLEAR FILTERS ==========
    function clearAllFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('sortSelect').value = 'default';
        document.getElementById('priceMin').value = '';
        document.getElementById('priceMax').value = '';

        currentFilter = 'all';
        document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
        document.querySelector('.filter-chip[data-filter="all"]')?.classList.add('active');

        applyFilters();

        // Restore view
        if (currentView === 'card') {
            document.getElementById('cardView')?.classList.add('active');
        } else {
            document.getElementById('tableView')?.classList.add('active');
        }
    }

    // Initialize card view as default
    document.addEventListener('DOMContentLoaded', () => {
        switchView('card');
    });
</script>
