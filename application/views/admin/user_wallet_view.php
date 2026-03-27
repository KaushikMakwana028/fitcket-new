<style>
    .user-wallet-page {
        padding: 28px;
        background: #f1f5f9;
        min-height: 100vh;
    }

    .page-header {
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -0.5px;
    }

    .page-header p {
        color: #64748b;
        font-size: 15px;
        margin: 0;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px 24px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.pending-stat::before {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
    }

    .stat-card.success-stat::before {
        background: linear-gradient(90deg, #10b981, #34d399);
    }

    .stat-card.credit-stat::before {
        background: linear-gradient(90deg, #6366f1, #818cf8);
    }

    .stat-card .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 14px;
    }

    .stat-card.pending-stat .stat-icon {
        background: #fef3c7;
        color: #d97706;
    }

    .stat-card.success-stat .stat-icon {
        background: #dcfce7;
        color: #16a34a;
    }

    .stat-card.credit-stat .stat-icon {
        background: #e0e7ff;
        color: #4f46e5;
    }

    .stat-card .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .wallet-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        overflow: hidden;
    }

    .wallet-card-header {
        padding: 22px 26px 0;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .wallet-card-header .header-left h4 {
        margin: 0 0 6px;
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
    }

    .wallet-card-header .header-left p {
        color: #94a3b8;
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .wallet-card-header .header-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        background: #fef3c7;
        color: #92400e;
        white-space: nowrap;
    }

    .wallet-card-body {
        padding: 22px 26px 26px;
    }

    .wallet-alert {
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 22px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        border: 1px solid transparent;
    }

    .wallet-alert-success {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }

    .wallet-alert-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .wallet-alert i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .wallet-table-wrap {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
    }

    .wallet-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    .wallet-table thead {
        background: #f8fafc;
    }

    .wallet-table th {
        padding: 14px 16px;
        text-align: left;
        color: #64748b;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        border-bottom: 2px solid #e2e8f0;
        white-space: nowrap;
    }

    .wallet-table td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
        font-size: 14px;
    }

    .wallet-table tbody tr {
        transition: background 0.15s;
    }

    .wallet-table tbody tr:hover {
        background: #f8fafc;
    }

    .wallet-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        color: #fff;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .user-avatar.av-1 {
        background: linear-gradient(135deg, #6366f1, #818cf8);
    }

    .user-avatar.av-2 {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
    }

    .user-avatar.av-3 {
        background: linear-gradient(135deg, #10b981, #34d399);
    }

    .user-avatar.av-4 {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
    }

    .user-avatar.av-5 {
        background: linear-gradient(135deg, #ef4444, #f87171);
    }

    .user-avatar.av-6 {
        background: linear-gradient(135deg, #8b5cf6, #a78bfa);
    }

    .user-info strong {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .user-info small {
        color: #94a3b8;
        font-size: 12px;
        display: block;
        line-height: 1.4;
    }

    .amount-cell {
        font-weight: 800;
        font-size: 16px;
        color: #0f172a;
        white-space: nowrap;
    }

    .amount-cell .currency {
        font-size: 13px;
        color: #94a3b8;
        font-weight: 600;
    }

    .bank-cell {
        font-size: 13px;
        line-height: 1.6;
        color: #475569;
    }

    .bank-cell .bank-name {
        font-weight: 700;
        color: #0f172a;
        display: block;
        margin-bottom: 2px;
    }

    .bank-cell .bank-detail {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: #64748b;
    }

    .bank-cell .no-bank {
        color: #cbd5e1;
        font-style: italic;
        font-size: 13px;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-chip.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-chip.success {
        background: #dcfce7;
        color: #166534;
    }

    .status-chip.failed,
    .status-chip.rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .wallet-btn {
        border: none;
        border-radius: 10px;
        padding: 9px 16px;
        font-weight: 700;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .wallet-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        color: #fff;
        text-decoration: none;
    }

    .wallet-btn-pay {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
    }

    .wallet-btn-manual {
        background: linear-gradient(135deg, #0f766e, #14b8a6);
    }

    .wallet-btn-danger {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
    }

    .empty-state .empty-icon {
        width: 72px;
        height: 72px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 32px;
        color: #cbd5e1;
    }

    .empty-state h5 {
        font-size: 16px;
        font-weight: 700;
        color: #64748b;
        margin: 0 0 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: #94a3b8;
        margin: 0;
    }

    .info-banner {
        margin-top: 18px;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border: 1px solid #bae6fd;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .info-banner .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #0ea5e9;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .info-banner .info-content {
        flex: 1;
    }

    .info-banner .info-content strong {
        display: block;
        font-size: 14px;
        color: #0c4a6e;
        margin-bottom: 4px;
    }

    .info-banner .info-content p {
        font-size: 13px;
        color: #0369a1;
        margin: 0;
        line-height: 1.6;
    }

    .date-cell {
        font-size: 13px;
        color: #64748b;
        white-space: nowrap;
    }

    .date-cell .date-main {
        font-weight: 600;
        color: #334155;
        display: block;
    }

    .date-cell .date-time {
        font-size: 12px;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .user-wallet-page {
            padding: 16px;
        }

        .stats-row {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .wallet-card-header {
            padding: 18px 18px 0;
            flex-direction: column;
        }

        .wallet-card-body {
            padding: 18px;
        }

        .action-row {
            flex-direction: column;
        }

        .wallet-btn {
            justify-content: center;
            padding: 10px 14px;
        }
    }
</style>

<div class="page-wrapper">
    <div class="page-content user-wallet-page">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="wallet-alert wallet-alert-success">
                <i class="bx bx-check-circle"></i>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="wallet-alert wallet-alert-error">
                <i class="bx bx-error-circle"></i>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="page-header">
            <h2>💰 Wallet Management</h2>
            <p>Manage user withdrawal requests, approve payouts, and track winning credits.</p>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card pending-stat">
                <div class="stat-icon">⏳</div>
                <div class="stat-value"><?= !empty($pending_withdraws) ? count($pending_withdraws) : 0 ?></div>
                <div class="stat-label">Pending Withdrawals</div>
            </div>
            <div class="stat-card success-stat">
                <div class="stat-icon">✅</div>
                <div class="stat-value">
                    <?php
                    $completed = 0;
                    if (!empty($all_withdraws)) {
                        foreach ($all_withdraws as $w) {
                            if (strtolower($w['status'] ?? '') === 'success') $completed++;
                        }
                    }
                    echo $completed;
                    ?>
                </div>
                <div class="stat-label">Completed Payouts</div>
            </div>
            <div class="stat-card credit-stat">
                <div class="stat-icon">🏆</div>
                <div class="stat-value"><?= !empty($recent_credits) ? count($recent_credits) : 0 ?></div>
                <div class="stat-label">Recent Credits</div>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="wallet-card">
            <div class="wallet-card-header">
                <div class="header-left">
                    <h4>Pending Withdrawals</h4>
                    <p>Review and process user withdrawal requests. Pay via RazorpayX or mark as manually paid.</p>
                </div>
                <?php if (!empty($pending_withdraws)): ?>
                    <div class="header-badge">⏳ <?= count($pending_withdraws) ?> Pending</div>
                <?php endif; ?>
            </div>
            <div class="wallet-card-body">
                <?php if (!empty($pending_withdraws)): ?>
                    <div class="wallet-table-wrap">
                        <table class="wallet-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Bank Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_withdraws as $index => $withdraw): ?>
                                    <?php $avClass = 'av-' . (($index % 6) + 1); ?>
                                    <?php $initial = strtoupper(substr($withdraw['user_name'] ?? 'U', 0, 1)); ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar <?= $avClass ?>"><?= $initial ?></div>
                                                <div class="user-info">
                                                    <strong><?= html_escape($withdraw['user_name'] ?? 'User') ?></strong>
                                                    <?php if (!empty($withdraw['user_mobile'])): ?>
                                                        <small>📱 <?= html_escape($withdraw['user_mobile']) ?></small>
                                                    <?php endif; ?>
                                                    <?php if (!empty($withdraw['user_email'])): ?>
                                                        <small>✉️ <?= html_escape($withdraw['user_email']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="amount-cell">
                                                <span class="currency">₹</span> <?= number_format((float) ($withdraw['amount'] ?? 0), 2) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="bank-cell">
                                                <?php if (!empty($withdraw['bank_name'])): ?>
                                                    <span class="bank-name">🏦 <?= html_escape($withdraw['bank_name']) ?></span>
                                                    <div class="bank-detail"><?= html_escape($withdraw['account_holder_name'] ?? '') ?></div>
                                                    <div class="bank-detail">A/C: <?= html_escape($withdraw['account_number']) ?></div>
                                                    <div class="bank-detail">IFSC: <?= html_escape($withdraw['ifsc_code']) ?></div>
                                                <?php else: ?>
                                                    <span class="no-bank">No bank details found</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-row">
                                                <a class="wallet-btn wallet-btn-pay"
                                                    href="<?= base_url('admin/user_wallet/approve_withdraw/' . (int) $withdraw['id']) ?>"
                                                    onclick="return confirm('Send this withdrawal via RazorpayX payout?')">
                                                    💳 Pay via Razorpay
                                                </a>
                                                <a class="wallet-btn wallet-btn-manual"
                                                    href="<?= base_url('admin/user_wallet/mark_paid_manual/' . (int) $withdraw['id']) ?>"
                                                    onclick="return confirm('Confirm this withdrawal was manually paid via bank transfer?')">
                                                    ✅ Mark Paid
                                                </a>
                                                <a class="wallet-btn wallet-btn-danger"
                                                    href="<?= base_url('admin/user_wallet/reject_withdraw/' . (int) $withdraw['id']) ?>"
                                                    onclick="return confirm('Reject this withdrawal and refund to user wallet?')">
                                                    ✕ Reject
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">🎉</div>
                        <h5>All Caught Up!</h5>
                        <p>No pending withdrawal requests at the moment.</p>
                    </div>
                <?php endif; ?>

                <div class="info-banner">
                    <div class="info-icon">ℹ</div>
                    <div class="info-content">
                        <strong>RazorpayX Setup Required</strong>
                        <p>Add <code>RAZORPAYX_SOURCE_ACCOUNT</code> in your server environment with your RazorpayX source account number. Your server IP must be allowlisted in RazorpayX for payouts. If money was sent directly from your bank, use "Mark Paid" to keep wallet records accurate.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdraw History -->
        <div class="wallet-card">
            <div class="wallet-card-header">
                <div class="header-left">
                    <h4>Withdrawal History</h4>
                    <p>Complete log of all user withdrawal requests and their current status.</p>
                </div>
            </div>
            <div class="wallet-card-body">
                <?php if (!empty($all_withdraws)): ?>
                    <div class="wallet-table-wrap">
                        <table class="wallet-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Bank Details</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_withdraws as $index => $withdraw): ?>
                                    <?php
                                    $status  = strtolower((string) ($withdraw['status'] ?? 'pending'));
                                    $avClass = 'av-' . (($index % 6) + 1);
                                    $initial = strtoupper(substr($withdraw['user_name'] ?? 'U', 0, 1));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar <?= $avClass ?>"><?= $initial ?></div>
                                                <div class="user-info">
                                                    <strong><?= html_escape($withdraw['user_name'] ?? 'User') ?></strong>
                                                    <?php if (!empty($withdraw['user_mobile'])): ?>
                                                        <small>📱 <?= html_escape($withdraw['user_mobile']) ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="amount-cell">
                                                <span class="currency">₹</span> <?= number_format((float) ($withdraw['amount'] ?? 0), 2) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-chip <?= html_escape($status) ?>">
                                                <?php if ($status === 'success'): ?>✅<?php elseif ($status === 'pending'): ?>⏳<?php else: ?>❌<?php endif; ?>
                                                <?= html_escape(ucfirst($status)) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="bank-cell">
                                                <?php if (!empty($withdraw['bank_name'])): ?>
                                                    <span class="bank-name"><?= html_escape($withdraw['bank_name']) ?></span>
                                                    <div class="bank-detail">A/C: <?= html_escape($withdraw['account_number']) ?></div>
                                                <?php else: ?>
                                                    <span class="no-bank">No bank details</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-cell">
                                                <?php if (!empty($withdraw['created_at'])): ?>
                                                    <span class="date-main"><?= date('d M Y', strtotime($withdraw['created_at'])) ?></span>
                                                    <span class="date-time"><?= date('h:i A', strtotime($withdraw['created_at'])) ?></span>
                                                <?php else: ?>
                                                    <span class="date-main">—</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <h5>No History Yet</h5>
                        <p>Withdrawal requests will appear here once users submit them.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Winning Credits -->
        <div class="wallet-card">
            <div class="wallet-card-header">
                <div class="header-left">
                    <h4>Recent Winning Credits</h4>
                    <p>Latest winning amounts credited to user wallets from pool settlements.</p>
                </div>
            </div>
            <div class="wallet-card-body">
                <?php if (!empty($recent_credits)): ?>
                    <div class="wallet-table-wrap">
                        <table class="wallet-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_credits as $index => $credit): ?>
                                    <?php
                                    $avClass = 'av-' . (($index % 6) + 1);
                                    $initial = strtoupper(substr($credit['user_name'] ?? 'U', 0, 1));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-avatar <?= $avClass ?>"><?= $initial ?></div>
                                                <div class="user-info">
                                                    <strong><?= html_escape($credit['user_name'] ?? 'User') ?></strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="amount-cell" style="color: #16a34a;">
                                                <span class="currency">₹</span> +<?= number_format((float) ($credit['amount'] ?? 0), 2) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-chip success">
                                                ✅ <?= html_escape(ucfirst((string) ($credit['status'] ?? 'Credited'))) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="date-cell">
                                                <?php if (!empty($credit['created_at'])): ?>
                                                    <span class="date-main"><?= date('d M Y', strtotime($credit['created_at'])) ?></span>
                                                    <span class="date-time"><?= date('h:i A', strtotime($credit['created_at'])) ?></span>
                                                <?php else: ?>
                                                    <span class="date-main">—</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">🏆</div>
                        <h5>No Credits Yet</h5>
                        <p>Winning credits will show here after pool settlements are completed.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>