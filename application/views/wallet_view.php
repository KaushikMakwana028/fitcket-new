<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:wght@400;500;600;700;800&display=swap');

    :root {
        --bg: #f0f4f9;
        --surface: #ffffff;
        --surface2: #f7f9fc;
        --border: #e4eaf3;
        --border2: #d0d9e8;

        --ink: #0f1c35;
        --ink2: #3b4d6b;
        --muted: #8494b0;

        --blue: #2563eb;
        --blue-lt: #eff4ff;
        --blue-mid: #bfcffd;

        --green: #059669;
        --green-lt: #ecfdf5;

        --red: #dc2626;
        --red-lt: #fff1f2;

        --amber: #d97706;
        --amber-lt: #fffbeb;

        --violet: #7c3aed;
        --violet-lt: #f5f3ff;

        --radius: 14px;
        --shadow-sm: 0 1px 3px rgba(15, 28, 53, 0.07), 0 1px 2px rgba(15, 28, 53, 0.04);
        --shadow: 0 4px 16px rgba(15, 28, 53, 0.08), 0 1px 4px rgba(15, 28, 53, 0.05);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .ww {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 24px 56px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--ink);
        background: var(--bg);
        min-height: 100vh;
    }

    /* ── Page Title ── */
    .ww-title {
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 26px;
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 26px;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.4px;
    }

    .ww-title-icon {
        width: 42px;
        height: 42px;
        background: var(--blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
    }

    /* ── Alerts ── */
    .ww-alert {
        padding: 13px 16px;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .ww-alert-success {
        background: var(--green-lt);
        color: var(--green);
        border: 1px solid #a7f3d0;
    }

    .ww-alert-error {
        background: var(--red-lt);
        color: var(--red);
        border: 1px solid #fecaca;
    }

    /* ── Stat Cards ── */
    .ww-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px 22px 20px;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.22s, transform 0.22s;
        animation: fadeUp 0.4s ease both;
    }

    .stat-card:hover {
        box-shadow: var(--shadow);
        transform: translateY(-2px);
    }

    .stat-card:nth-child(1) {
        animation-delay: 0s;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.07s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.13s;
    }

    /* Colored bottom bar */
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 0 0 var(--radius) var(--radius);
    }

    .stat-balance::after {
        background: linear-gradient(90deg, #2563eb, #60a5fa);
    }

    .stat-withdraw::after {
        background: linear-gradient(90deg, #dc2626, #f87171);
    }

    .stat-earned::after {
        background: linear-gradient(90deg, #059669, #34d399);
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-chip {
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        padding: 4px 10px;
        border-radius: 999px;
    }

    .stat-balance .stat-chip {
        background: var(--blue-lt);
        color: var(--blue);
    }

    .stat-withdraw .stat-chip {
        background: var(--red-lt);
        color: var(--red);
    }

    .stat-earned .stat-chip {
        background: var(--green-lt);
        color: var(--green);
    }

    .stat-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .stat-balance .stat-icon-box {
        background: var(--blue-lt);
    }

    .stat-withdraw .stat-icon-box {
        background: var(--red-lt);
    }

    .stat-earned .stat-icon-box {
        background: var(--green-lt);
    }

    .stat-label {
        font-size: 11.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.9px;
        color: var(--muted);
        margin-bottom: 7px;
    }

    .stat-value {
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1;
    }

    .stat-balance .stat-value {
        color: var(--blue);
    }

    .stat-withdraw .stat-value {
        color: var(--red);
    }

    .stat-earned .stat-value {
        color: var(--green);
    }

    .stat-cur {
        font-size: 14px;
        font-weight: 700;
        opacity: 0.65;
        margin-right: 2px;
        vertical-align: middle;
        position: relative;
        top: -2px;
    }

    /* ── Card Shell ── */
    .card-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 20px;
        overflow: hidden;
        animation: fadeUp 0.4s ease 0.2s both;
    }

    /* ── Withdraw ── */
    .withdraw-inner {
        padding: 24px 26px;
    }

    .sec-title {
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 3px;
    }

    .sec-sub {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .withdraw-form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .wf-field {
        flex: 1;
        min-width: 200px;
    }

    .wf-field label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--ink2);
        margin-bottom: 7px;
    }

    .wf-field select,
    .wf-field input {
        width: 100%;
        height: 46px;
        border: 1.5px solid var(--border2);
        border-radius: 11px;
        padding: 0 14px;
        font-size: 14px;
        font-weight: 500;
        color: var(--ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--surface);
        outline: none;
        transition: border-color 0.18s, box-shadow 0.18s;
        -webkit-appearance: none;
        appearance: none;
    }

    .wf-field select:focus,
    .wf-field input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .wf-field input::placeholder {
        color: var(--muted);
    }

    .wf-btn {
        height: 46px;
        padding: 0 26px;
        background: var(--blue);
        color: #fff;
        border: none;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        letter-spacing: 0.2px;
        transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        white-space: nowrap;
    }

    .wf-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
    }

    .withdraw-note {
        margin-top: 16px;
        font-size: 13px;
        color: var(--ink2);
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 11px 14px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.55;
    }

    .wn-icon {
        flex-shrink: 0;
        color: var(--blue);
        margin-top: 1px;
    }

    .withdraw-note a {
        color: var(--blue);
        font-weight: 600;
        text-decoration: none;
    }

    .withdraw-note a:hover {
        text-decoration: underline;
    }

    /* ── Txn Header ── */
    .txn-head {
        padding: 18px 22px 14px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .txn-head-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .txn-head-left h4 {
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: var(--ink);
    }

    .txn-badge {
        background: var(--blue-lt);
        color: var(--blue);
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 11px;
        border-radius: 999px;
    }

    /* ── Controls ── */
    .txn-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .type-chips {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .chip {
        height: 34px;
        padding: 0 15px;
        border-radius: 999px;
        border: 1.5px solid var(--border2);
        background: var(--surface);
        color: var(--ink2);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all 0.18s;
        white-space: nowrap;
    }

    .chip:hover {
        border-color: var(--blue);
        color: var(--blue);
        background: var(--blue-lt);
    }

    .chip.active {
        background: var(--blue);
        color: #fff;
        border-color: var(--blue);
    }

    .ctrl-divider {
        width: 1px;
        height: 22px;
        background: var(--border2);
    }

    .ctrl-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        white-space: nowrap;
    }

    .ctrl-select {
        height: 34px;
        border: 1.5px solid var(--border2);
        border-radius: 9px;
        padding: 0 30px 0 12px;
        font-size: 13px;
        font-weight: 600;
        color: var(--ink2);
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238494b0' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 10px center;
        -webkit-appearance: none;
        appearance: none;
        outline: none;
        cursor: pointer;
        transition: border-color 0.18s;
    }

    .ctrl-select:focus {
        border-color: var(--blue);
    }

    /* ── Table ── */
    .txn-table-wrap {
        overflow-x: auto;
    }

    .txn-table {
        width: 100%;
        border-collapse: collapse;
    }

    .txn-table th {
        background: var(--surface2);
        padding: 11px 20px;
        text-align: left;
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .txn-table td {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
        font-size: 13.5px;
        vertical-align: middle;
    }

    .txn-table tr:last-child td {
        border-bottom: none;
    }

    .txn-table tbody tr {
        transition: background 0.12s;
    }

    .txn-table tbody tr:hover td {
        background: #f8fbff;
    }

    .txn-num {
        color: var(--muted);
        font-size: 12px;
        font-weight: 600;
    }

    /* Type pills */
    .type-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .type-winning {
        background: var(--green-lt);
        color: var(--green);
    }

    .type-withdraw {
        background: var(--red-lt);
        color: var(--red);
    }

    .type-refund {
        background: var(--violet-lt);
        color: var(--violet);
    }

    /* Amounts */
    .amt {
        font-family: 'Bricolage Grotesque', sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: -0.2px;
    }

    .amt-credit {
        color: var(--green);
    }

    .amt-debit {
        color: var(--red);
    }

    .amt-refund {
        color: var(--violet);
    }

    /* Status */
    .txn-status {
        display: inline-block;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
    }

    .status-success,
    .status-approved,
    .status-completed {
        background: var(--green-lt);
        color: var(--green);
    }

    .status-pending {
        background: var(--amber-lt);
        color: var(--amber);
    }

    .status-failed,
    .status-rejected {
        background: var(--red-lt);
        color: var(--red);
    }

    .txn-date {
        color: var(--muted);
        font-size: 12.5px;
        white-space: nowrap;
    }

    .txn-empty {
        padding: 64px 20px;
        text-align: center;
        color: var(--muted);
        font-size: 14px;
        font-weight: 500;
    }

    .txn-empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    /* ── Footer / Pagination ── */
    .txn-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 22px;
        border-top: 1px solid var(--border);
        background: var(--surface2);
        flex-wrap: wrap;
        gap: 12px;
    }

    .pg-info {
        font-size: 12.5px;
        color: var(--muted);
    }

    .pg-info strong {
        color: var(--ink2);
    }

    .pg-btns {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .pg-btn {
        height: 32px;
        min-width: 32px;
        padding: 0 9px;
        border-radius: 8px;
        border: 1.5px solid var(--border2);
        background: var(--surface);
        color: var(--ink2);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        transition: all 0.16s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pg-btn:hover:not(:disabled):not(.pg-dots) {
        background: var(--blue-lt);
        color: var(--blue);
        border-color: var(--blue-mid);
    }

    .pg-btn.active {
        background: var(--blue);
        color: #fff;
        border-color: var(--blue);
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
    }

    .pg-btn:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    .pg-btn.pg-dots {
        cursor: default;
        border-color: transparent;
        background: transparent;
        color: var(--muted);
    }

    /* Hidden rows */
    .txn-row.hidden {
        display: none;
    }

    /* Fade-up */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ── Responsive ── */
    @media (max-width: 860px) {
        .ww-stats {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 560px) {
        .ww-stats {
            grid-template-columns: 1fr;
        }

        .ww {
            padding: 20px 14px 40px;
        }

        .txn-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .txn-controls {
            width: 100%;
        }

        .withdraw-form {
            flex-direction: column;
        }

        .wf-btn {
            width: 100%;
        }

        .txn-table thead {
            display: none;
        }

        .txn-table,
        .txn-table tbody,
        .txn-table tr,
        .txn-table td {
            display: block;
            width: 100%;
        }

        .txn-table tr {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .txn-table tr:last-child {
            border-bottom: none;
        }

        .txn-table td {
            padding: 5px 18px;
            border-bottom: none;
        }

        .txn-table td::before {
            content: attr(data-label);
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 3px;
        }
    }
</style>

<div class="ww">

    <!-- Title -->
    <div class="ww-title">
        <div class="ww-title-icon">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
        </div>
        My Wallet
    </div>

    <!-- Alerts -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="ww-alert ww-alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="ww-alert ww-alert-error">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- ══ Stat Cards (static — never filtered) ══ -->
    <div class="ww-stats">
        <div class="stat-card stat-balance">
            <div class="stat-top">
                <span class="stat-chip">Balance</span>
                <div class="stat-icon-box">💰</div>
            </div>
            <div class="stat-label">Available Winning Balance</div>
            <div class="stat-value"><span class="stat-cur">Rs</span><?= number_format($available_balance, 2) ?></div>
        </div>

        <div class="stat-card stat-withdraw">
            <div class="stat-top">
                <span class="stat-chip">Withdrawn</span>
                <div class="stat-icon-box">💸</div>
            </div>
            <div class="stat-label">Total Withdrawn</div>
            <div class="stat-value"><span class="stat-cur">Rs</span><?= number_format($total_withdraw, 2) ?></div>
        </div>

        <div class="stat-card stat-earned">
            <div class="stat-top">
                <span class="stat-chip">Earned</span>
                <div class="stat-icon-box">🏆</div>
            </div>
            <div class="stat-label">Total Winning Amount</div>
            <div class="stat-value"><span class="stat-cur">Rs</span><?= number_format($total_earned, 2) ?></div>
        </div>
    </div>

    <!-- ══ Withdraw Card ══ -->
    <div class="card-box">
        <div class="withdraw-inner">
            <div class="sec-title">Withdraw Winning Amount</div>
            <div class="sec-sub">Only real winning amounts can be withdrawn. Demo or testing balances are not eligible for withdrawal.</div>

            <form method="post" action="<?= base_url('wallet/withdraw') ?>" class="withdraw-form">
                <div class="wf-field">
                    <label for="bankAccountId">Withdraw To</label>
                    <select id="bankAccountId" name="bank_account_id" required>
                        <option value="">— Select bank account —</option>
                        <?php foreach (($bank_accounts ?? []) as $bank): ?>
                            <option value="<?= (int)$bank['id'] ?>">
                                <?= html_escape(($bank['bank_name'] ?? 'Bank') . '  ·  ' . ($bank['account_number'] ?? '')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="wf-field">
                    <label for="withdrawAmount">Withdraw Amount (Rs)</label>
                    <input type="number" id="withdrawAmount" name="amount"
                        min="1" step="0.01" max="<?= max(0, $available_balance) ?>"
                        placeholder="e.g. 500.00" required>
                </div>
                <button type="submit" class="wf-btn">Request Withdraw</button>
            </form>

            <div class="withdraw-note">
                <span class="wn-icon">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4m0 4h.01" />
                    </svg>
                </span>
                <span>
                    <?php if (!empty($bank_accounts)): ?>
                        Manage bank details from <a href="<?= base_url('manage_bank_account/' . $this->session->userdata('user')['id']) ?>">Manage Bank Account</a>. Admin will transfer your approved withdrawal amount to the selected account.
                    <?php else: ?>
                        Please add your bank details from <a href="<?= base_url('manage_bank_account/' . $this->session->userdata('user')['id']) ?>">Manage Bank Account</a> before requesting a withdrawal.
                    <?php endif; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- ══ Transaction History ══ -->
    <div class="card-box" style="animation-delay:0.28s">

        <div class="txn-head">
            <div class="txn-head-left">
                <h4>Transaction History</h4>
                <span class="txn-badge" id="visibleCount"><?= count($transactions) ?> records</span>
            </div>
            <div class="txn-controls">
                <div class="type-chips">
                    <button class="chip active" data-type="all">All</button>
                    <button class="chip" data-type="winning">Winnings</button>
                    <button class="chip" data-type="withdraw">Withdrawals</button>
                    <button class="chip" data-type="refund">Refunds</button>
                </div>
                <div class="ctrl-divider"></div>
                <span class="ctrl-label">Show</span>
                <select class="ctrl-select" id="perPageSel">
                    <option value="10" selected>10 rows</option>
                    <option value="25">25 rows</option>
                    <option value="50">50 rows</option>
                    <option value="100">100 rows</option>
                    <option value="all">View All</option>
                </select>
            </div>
        </div>

        <?php if (!empty($transactions)): ?>
            <div class="txn-table-wrap">
                <table class="txn-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date &amp; Time</th>
                        </tr>
                    </thead>
                    <tbody id="txnBody">
                        <?php $i = 1;
                        foreach ($transactions as $t):
                            $type = htmlspecialchars((string)$t['type']);
                            $statusClass = 'status-' . strtolower((string)$t['status']);
                        ?>
                            <tr class="txn-row" data-type="<?= $type ?>">
                                <td data-label="#"><span class="txn-num"><?= $i++ ?></span></td>

                                <td data-label="Type">
                                    <?php if ($t['type'] === 'winning'): ?>
                                        <span class="type-pill type-winning">
                                            <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Winning
                                        </span>
                                    <?php elseif ($t['type'] === 'refund'): ?>
                                        <span class="type-pill type-refund">
                                            <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                            </svg>
                                            Refund
                                        </span>
                                    <?php else: ?>
                                        <span class="type-pill type-withdraw">
                                            <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Withdrawal
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="Amount">
                                    <?php if ($t['type'] === 'winning'): ?>
                                        <span class="amt amt-credit">+ Rs <?= number_format($t['amount'], 2) ?></span>
                                    <?php elseif ($t['type'] === 'refund'): ?>
                                        <span class="amt amt-refund">+ Rs <?= number_format($t['amount'], 2) ?></span>
                                    <?php else: ?>
                                        <span class="amt amt-debit">− Rs <?= number_format($t['amount'], 2) ?></span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="Status">
                                    <span class="txn-status <?= $statusClass ?>"><?= ucfirst((string)$t['status']) ?></span>
                                </td>

                                <td data-label="Date" class="txn-date">
                                    <?= !empty($t['created_at']) ? date('d M Y, h:i A', strtotime($t['created_at'])) : '—' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="txn-footer">
                <div class="pg-info" id="pgInfo">
                    Showing <strong id="pgFrom">—</strong> to <strong id="pgTo">—</strong> of <strong id="pgTotal">—</strong> records
                </div>
                <div class="pg-btns" id="pgBtns"></div>
            </div>

        <?php else: ?>
            <div class="txn-empty">
                <div class="txn-empty-icon">📭</div>
                No winning or withdrawal records found yet.
            </div>
        <?php endif; ?>
    </div>

</div><!-- /.ww -->

<script>
    (function() {
        const perPageSel = document.getElementById('perPageSel');
        const pgFrom = document.getElementById('pgFrom');
        const pgTo = document.getElementById('pgTo');
        const pgTotal = document.getElementById('pgTotal');
        const pgBtns = document.getElementById('pgBtns');
        const badge = document.getElementById('visibleCount');
        const chips = document.querySelectorAll('.chip[data-type]');

        let activeType = 'all';
        let currentPage = 1;
        let perPage = 10;

        const allRows = () => Array.from(document.querySelectorAll('#txnBody .txn-row'));
        const filtered = () => allRows().filter(r => activeType === 'all' || r.dataset.type === activeType);

        function render() {
            const rows = filtered();
            const total = rows.length;
            const isAll = perPage === Infinity;
            const start = isAll ? 0 : (currentPage - 1) * perPage;
            const end = isAll ? total : Math.min(start + perPage, total);

            allRows().forEach(r => r.classList.add('hidden'));
            rows.slice(start, end).forEach(r => r.classList.remove('hidden'));

            badge.textContent = total + ' records';
            pgFrom.textContent = total === 0 ? 0 : start + 1;
            pgTo.textContent = isAll ? total : end;
            pgTotal.textContent = total;

            buildPages(total);
        }

        function buildPages(total) {
            pgBtns.innerHTML = '';
            if (perPage === Infinity || total <= perPage) return;

            const totalPages = Math.ceil(total / perPage);

            const makeBtn = (label, page, active, disabled, dots) => {
                const b = document.createElement('button');
                b.className = 'pg-btn' + (active ? ' active' : '') + (dots ? ' pg-dots' : '');
                b.textContent = label;
                b.disabled = !!disabled;
                if (!disabled && !active && !dots) b.onclick = () => {
                    currentPage = page;
                    render();
                };
                return b;
            };

            pgBtns.appendChild(makeBtn('‹', currentPage - 1, false, currentPage === 1));

            const pages = [];
            for (let p = 1; p <= totalPages; p++) {
                if (p === 1 || p === totalPages || Math.abs(p - currentPage) <= 1) pages.push(p);
                else if (pages[pages.length - 1] !== '…') pages.push('…');
            }
            pages.forEach(p => {
                if (p === '…') pgBtns.appendChild(makeBtn('…', 0, false, true, true));
                else pgBtns.appendChild(makeBtn(p, p, p === currentPage, false, false));
            });

            pgBtns.appendChild(makeBtn('›', currentPage + 1, false, currentPage === totalPages));
        }

        chips.forEach(chip => {
            chip.addEventListener('click', () => {
                chips.forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                activeType = chip.dataset.type;
                currentPage = 1;
                render();
            });
        });

        perPageSel.addEventListener('change', () => {
            perPage = perPageSel.value === 'all' ? Infinity : parseInt(perPageSel.value);
            currentPage = 1;
            render();
        });

        render();
    })();
</script>