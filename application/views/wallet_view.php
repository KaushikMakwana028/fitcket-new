<style>
    .wallet-wrapper {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .wallet-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .wallet-alert {
        padding: 14px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .wallet-alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .wallet-alert-error {
        background: #fee2e2;
        color: #991b1b;
    }

    .wallet-stats {
        display: flex;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .stat-card {
        flex: 1;
        min-width: 220px;
        padding: 24px;
        border-radius: 16px;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .stat-balance {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-withdraw {
        background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
    }

    .stat-earned {
        background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
    }

    .stat-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
    }

    .card-box {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .withdraw-box {
        padding: 24px;
    }

    .withdraw-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .withdraw-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 18px;
    }

    .withdraw-note {
        margin-top: 14px;
        font-size: 13px;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .withdraw-form {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        align-items: end;
    }

    .withdraw-field {
        flex: 1;
        min-width: 220px;
    }

    .withdraw-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
    }

    .withdraw-field input {
        width: 100%;
        height: 48px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 15px;
    }

    .withdraw-field select {
        width: 100%;
        height: 48px;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 0 14px;
        font-size: 15px;
        background: #fff;
    }

    .withdraw-btn {
        height: 48px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
        color: #fff;
        padding: 0 22px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .transactions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
    }

    .transactions-header h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .transaction-count {
        background: #667eea;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 999px;
    }

    .txn-table {
        width: 100%;
        border-collapse: collapse;
    }

    .txn-table th,
    .txn-table td {
        padding: 16px 24px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }

    .txn-table th {
        background: #f8fafc;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
    }

    .txn-type-winning {
        color: #15803d;
        font-weight: 700;
    }

    .txn-type-withdraw {
        color: #dc2626;
        font-weight: 700;
    }

    .txn-amount-credit {
        color: #15803d;
        font-weight: 700;
    }

    .txn-amount-debit {
        color: #dc2626;
        font-weight: 700;
    }

    .txn-status {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-success,
    .status-approved,
    .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-failed,
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .txn-empty {
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .wallet-wrapper {
            padding: 0 15px;
        }

        .wallet-stats {
            flex-direction: column;
        }

        .withdraw-form {
            flex-direction: column;
            align-items: stretch;
        }

        .withdraw-btn {
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
            padding: 10px 0;
        }

        .txn-table td {
            padding: 8px 24px;
        }

        .txn-table td::before {
            content: attr(data-label);
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
    }
</style>

<div class="wallet-wrapper">
    <div class="wallet-title">
        <span>Wallet</span>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="wallet-alert wallet-alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="wallet-alert wallet-alert-error"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="wallet-stats">
        <div class="stat-card stat-balance">
            <div class="stat-label">Available Winning Balance</div>
            <div class="stat-value">Rs <?= number_format($available_balance, 2) ?></div>
        </div>

        <div class="stat-card stat-withdraw">
            <div class="stat-label">Total Withdraw</div>
            <div class="stat-value">Rs <?= number_format($total_withdraw, 2) ?></div>
        </div>

        <div class="stat-card stat-earned">
            <div class="stat-label">Winning Amount</div>
            <div class="stat-value">Rs <?= number_format($total_earned, 2) ?></div>
        </div>
    </div>

    <div class="card-box withdraw-box">
        <div class="withdraw-title">Withdraw Winning Amount</div>
        <div class="withdraw-subtitle">Only real winning amount can be withdrawn here. Testing balance or added demo money is not withdrawable.</div>

        <form method="post" action="<?= base_url('wallet/withdraw') ?>" class="withdraw-form">
            <div class="withdraw-field">
                <label for="bankAccountId">Withdraw To</label>
                <select id="bankAccountId" name="bank_account_id" required>
                    <option value="">Select bank account</option>
                    <?php foreach (($bank_accounts ?? []) as $bank): ?>
                        <option value="<?= (int) $bank['id'] ?>">
                            <?= html_escape(($bank['bank_name'] ?? 'Bank') . ' - ' . ($bank['account_number'] ?? '')) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="withdraw-field">
                <label for="withdrawAmount">Withdraw Amount</label>
                <input type="number" id="withdrawAmount" name="amount" min="1" step="0.01" max="<?= max(0, $available_balance) ?>" placeholder="Enter amount" required>
            </div>
            <button type="submit" class="withdraw-btn">Request Withdraw</button>
        </form>

        <div class="withdraw-note">
            <?php if (!empty($bank_accounts)): ?>
                Manage bank details from <a href="<?= base_url('manage_bank_account/' . $this->session->userdata('user')['id']) ?>">Manage Bank Account</a>. Admin will transfer your approved withdraw amount to the selected account.
            <?php else: ?>
                Add your bank details first from <a href="<?= base_url('manage_bank_account/' . $this->session->userdata('user')['id']) ?>">Manage Bank Account</a> to withdraw your winnings.
            <?php endif; ?>
        </div>
    </div>

    <div class="card-box">
        <div class="transactions-header">
            <h4>Winning and Withdraw History</h4>
            <span class="transaction-count"><?= count($transactions) ?> records</span>
        </div>

        <?php if (!empty($transactions)): ?>
            <table class="txn-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <?php $statusClass = 'status-' . strtolower((string) $t['status']); ?>
                        <tr>
                            <td data-label="Type">
                                <?php if ($t['type'] === 'winning'): ?>
                                    <span class="txn-type-winning">Winning</span>
                                <?php else: ?>
                                    <span class="txn-type-withdraw">Withdraw</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Amount">
                                <?php if ($t['type'] === 'winning'): ?>
                                    <span class="txn-amount-credit">+ Rs <?= number_format($t['amount'], 2) ?></span>
                                <?php else: ?>
                                    <span class="txn-amount-debit">- Rs <?= number_format($t['amount'], 2) ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Status">
                                <span class="txn-status <?= $statusClass ?>"><?= ucfirst((string) $t['status']) ?></span>
                            </td>
                            <td data-label="Date">
                                <?= !empty($t['created_at']) ? date('d M Y h:i A', strtotime($t['created_at'])) : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="txn-empty">No winning or withdraw records found.</div>
        <?php endif; ?>
    </div>
</div>
