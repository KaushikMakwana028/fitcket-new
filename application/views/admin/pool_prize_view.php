<?php
$winnerCount = (int) ($prize['winner_count'] ?? 0);
?>

<style>
    .pool-prize-page {
        padding: 24px;
    }

    .pool-prize-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        padding: 24px;
        margin-bottom: 24px;
    }

    .pool-prize-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .pool-prize-input label {
        display: block;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1e293b;
    }

    .pool-prize-input input {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 12px 14px;
    }

    .pool-prize-btn {
        border: none;
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #0f766e, #14b8a6);
    }

    .pool-prize-meta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 12px;
        font-weight: 700;
        background: #ecfeff;
        color: #0f766e;
    }

    .pool-prize-note {
        border: 1px solid #dbeafe;
        background: #f8fbff;
        border-radius: 16px;
        padding: 16px;
        color: #334155;
    }

    .pool-prize-table {
        width: 100%;
        border-collapse: collapse;
    }

    .pool-prize-table th,
    .pool-prize-table td {
        padding: 12px 10px;
        border-bottom: 1px solid #e2e8f0;
    }
</style>

<div class="page-wrapper">
    <div class="page-content pool-prize-page">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="pool-prize-card">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
                <div>
                    <div class="text-uppercase fw-semibold text-muted mb-2" style="letter-spacing:.12em;">Pool Prize Setup</div>
                    <h3 class="mb-2"><?= html_escape($pool['pool_name'] ?? 'Pool') ?></h3>
                    <p class="mb-0 text-muted">Set rank-wise winner amount for this pool. After answer key save, the amount will go automatically into winner wallets.</p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= base_url('admin/pools') ?>" class="btn btn-outline-secondary">Back To Pools</a>
                    <a href="<?= base_url('admin/pool/' . (int) ($pool['id'] ?? 0)) ?>" class="btn btn-outline-primary">See Questions</a>
                </div>
            </div>

            <div class="pool-prize-grid mb-4">
                <div class="pool-prize-meta">Entry: Rs. <?= number_format((float) ($pool['price'] ?? 0), 2) ?></div>
                <div class="pool-prize-meta">User Limit: <?= (int) ($pool['user_limit'] ?? 0) ?></div>
                <div class="pool-prize-meta">Saved Winners: <?= (int) ($prize['winner_count'] ?? 0) ?></div>
                <div class="pool-prize-meta">Paid Logs: <?= (int) ($prize_log_count ?? 0) ?></div>
            </div>

            <form method="post" action="<?= base_url('admin/pool/prize/' . (int) ($pool['id'] ?? 0) . '/save') ?>">
                <div class="pool-prize-input mb-4" style="max-width:240px;">
                    <label for="winner_count">Winner Count</label>
                    <input type="number" min="1" max="100" name="winner_count" id="winner_count" value="<?= $winnerCount > 0 ? $winnerCount : '' ?>" placeholder="Enter winner count" required>
                </div>

                <div id="prizeAmountRows" class="pool-prize-grid"></div>

                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <button type="submit" class="pool-prize-btn">Save Winner Amount</button>
                </div>
            </form>

            <div class="pool-prize-note mt-4">
                Flow: admin enters winner count, fills rank-wise amount, saves it once, and then answer-key save will automatically credit that amount to top ranked users.
            </div>
        </div>

        <div class="pool-prize-card">
            <h4 class="mb-3">Top 10 Preview</h4>
            <?php if (!empty($prize_preview_rows)): ?>
                <table class="pool-prize-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>User</th>
                            <th>Right</th>
                            <th>Wrong</th>
                            <th>Checked</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prize_preview_rows as $index => $row): ?>
                            <tr>
                                <td>#<?= $index + 1 ?></td>
                                <td><?= html_escape($row['user_name'] ?? 'User') ?></td>
                                <td><?= (int) ($row['summary']['right'] ?? 0) ?></td>
                                <td><?= (int) ($row['summary']['wrong'] ?? 0) ?></td>
                                <td><?= (int) ($row['summary']['checked'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="mb-0 text-muted">No joined users found for this pool yet.</p>
            <?php endif; ?>

            <?php if (!(bool) ($prize_has_checked ?? false)): ?>
                <div class="pool-prize-note mt-4">
                    Answer key is not fully set yet. Winner amount can be saved now, but wallet credit will happen only after answer key save.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    (function () {
        const winnerCountInput = document.getElementById('winner_count');
        const rowsWrap = document.getElementById('prizeAmountRows');
        const savedAmounts = <?= json_encode($prize_amounts ?? []) ?>;

        function renderPrizeRows() {
            const winnerCount = parseInt(winnerCountInput.value || '0', 10);
            rowsWrap.innerHTML = '';

            if (!winnerCount || winnerCount < 1) {
                return;
            }

            for (let rank = 1; rank <= winnerCount; rank += 1) {
                const item = document.createElement('div');
                item.className = 'pool-prize-input';
                item.innerHTML = `
                    <label for="amount_${rank}">${rank}${rank === 1 ? 'st' : rank === 2 ? 'nd' : rank === 3 ? 'rd' : 'th'} Winner Amount</label>
                    <input type="number" min="0.01" step="0.01" name="amounts[${rank}]" id="amount_${rank}" value="${savedAmounts[rank] || ''}" placeholder="Enter amount for rank ${rank}" required>
                `;
                rowsWrap.appendChild(item);
            }
        }

        winnerCountInput.addEventListener('input', renderPrizeRows);
        renderPrizeRows();
    })();
</script>
