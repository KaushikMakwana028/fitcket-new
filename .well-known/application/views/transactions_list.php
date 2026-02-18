<div class="transactions-list" id="transactions-list">
    <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $t): ?>
            <div class="transaction-card">
                <div class="transaction-header">
                    <span class="transaction-date">
                        <?= date('M d, Y', strtotime($t['created_at'])); ?>
                    </span>
                    <span class="status-badge status-<?= $t['status']; ?>">
                        <?= ucfirst($t['status']); ?>
                    </span>
                </div>
                <div class="transaction-body">
                    <div>
                        <p class="transaction-amount">₹<?= number_format($t['amount']); ?></p>
                    </div>
                    <div class="transaction-actions">
                        <a href="<?= base_url('rent_payment/details?id=' . $t['id']); ?>"
                           class="btn btn-sm transaction-btn">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</div>
