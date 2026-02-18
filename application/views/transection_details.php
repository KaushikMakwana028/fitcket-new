 <style>
        :root {
            --primary-color: #6f42c1;
            --secondary-color: #1a1a1a;
            --accent-color: #8e44ad;
            --text-dark: #2d3436;
            --bg-light: #f8f9fa;
        }

        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        } */

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            min-height: 100vh;
        }

        .mobile-container {
            max-width: 375px;
            margin: 0 auto;
            background: white;
            min-height: 100vh;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 20px;
            position: relative;
            border-radius: 0 0 20px 20px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .header-title {
            font-size: 20px;
            font-weight: 600;
        }

        .download-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .download-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .status-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .checkmark {
            width: 24px;
            height: 24px;
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
        }

        .transaction-title {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
        }

        .order-info {
            background: var(--bg-light);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id {
            color: var(--text-dark);
            font-size: 14px;
        }

        .copy-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            padding: 4px;
        }

        .timestamp {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .detail-card {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .detail-value {
            color: var(--text-dark);
            font-size: 14px;
            font-weight: 600;
            text-align: right;
            flex: 1;
            margin-left: 20px;
        }

        .amount-section {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 28px;
            font-weight: 700;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            padding: 20px;
            gap: 12px;
            display: flex;
            flex-direction: column;
            margin-bottom: 64px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--accent-color);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
        }

        .footer {
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
            background: var(--bg-light);
        }

        @media (max-width: 375px) {
            .f{

            }
            .mobile-container {
                max-width: 100%;
                box-shadow: none;
            }
        }
    </style>
     <div class="mobile-container mt-2">
    <!-- Header -->
    <div class="header">
        <div class="header-top">
            <div class="header-title text-center">Transaction Details</div>
        </div>
        
        <div class="status-icon">
            <?php if ($transaction['status'] === 'success'): ?>
                <div class="checkmark">✓</div>
            <?php else: ?>
                <div class="checkmark" style="color:red;">✕</div>
            <?php endif; ?>
        </div>
        
        <div class="transaction-title">
            Fund Transfer to Account<br>
            <?= $transaction['recipient_name']; ?> (<?= $transaction['bank_name']; ?>)
        </div>
    </div>

    <!-- Content -->
    <div class="content" id="receipt-content">
        <!-- Order ID -->
        <div class="order-info">
            <div class="order-id">Transaction ID: <?= $transaction['txnid']; ?></div>
            <button class="copy-btn" onclick="navigator.clipboard.writeText('<?= $transaction['txnid']; ?>')">📋</button>
        </div>

        <!-- Timestamp -->
        <div class="timestamp">
            <?= date('D, d M Y, h:i A', strtotime($transaction['created_at'])); ?>
        </div>

        <!-- Amount Section -->
        <div class="amount-section">
            <div class="amount-label">Total Amount</div>
            <div class="amount-value">₹<?= number_format($transaction['amount'], 2); ?></div>
        </div>

        <!-- Transaction Details -->
        <div class="section-title">Transaction Details</div>
        <div class="detail-card">
            <div class="detail-row">
                <div class="detail-label">Sender Name</div>
                <div class="detail-value"><?= $transaction['name']; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Receiver Name</div>
                <div class="detail-value"><?= $transaction['recipient_name']; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Bank</div>
                <div class="detail-value"><?= $transaction['bank_name']; ?> (<?= $transaction['ifsc_code']; ?>)</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Account No.</div>
                <div class="detail-value">****<?= substr($transaction['account_number'], -4); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status</div>
                <div class="detail-value">
                    <span class="status-badge status-<?= $transaction['status']; ?>">
                        <?= ucfirst($transaction['status']); ?>
                    </span>
                </div>
            </div>
           
            <div class="detail-row">
    <div class="detail-label">Settlement</div>
    <div class="detail-value">
        <?php if ($transaction['settled'] == 1): ?>
            <span class="badge bg-success">
                Success (<?= date("d M Y, h:i A", strtotime($transaction['settled_at'])) ?>)
            </span>
        <?php else: ?>
            <span class="badge bg-danger">Pending</span>
        <?php endif; ?>
    </div>
</div>

        </div>

        <!-- Billing Details -->
        <div class="section-title">Billing Details</div>
        <div class="detail-card">
            <div class="detail-row">
                <div class="detail-label">Mobile No.</div>
                <div class="detail-value"><?= $transaction['mobile']; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Email ID</div>
                <div class="detail-value"><?= $transaction['email']; ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Transaction Fee</div>
                <div class="detail-value">2% + GST</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Processing Time</div>
                <div class="detail-value">Instant</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons mb-5">
        <button class="btn btn-primary" onclick="printReceipt()">
            <i class="fas fa-print"></i> Download Receipt
        </button>
        <a href="<?= base_url('contact-us'); ?>" class="btn btn-secondary mb-3">Need Help?</a>

    </div>
</div>

<script>
function printReceipt() {
    var content = document.getElementById("receipt-content").innerHTML;
    var myWindow = window.open("", "Print Receipt", "width=600,height=800");
    myWindow.document.write(`
        <html>
        <head>
            <title>Transaction Receipt</title>
            <style>
                body { font-family: Arial, sans-serif; padding:20px; color:#333; }
                .logo { text-align:center; margin-bottom:20px; }
                .logo img { max-width:120px; }
                h2 { text-align:center; margin-bottom:20px; border-bottom:1px solid #ddd; padding-bottom:10px; }
                table { width:100%; border-collapse:collapse; margin-bottom:15px; }
                td { padding:8px; vertical-align:top; }
                .label { font-weight:bold; color:#555; width:40%; }
                .value { color:#222; text-align:right; }
                .amount { text-align:center; font-size:18px; font-weight:bold; margin:20px 0; }
                .section-title { font-weight:bold; margin:15px 0 5px; text-decoration:underline; }
            </style>
        </head>
        <body>
            <div class="logo">
                <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="Company Logo">
            </div>
            <h2>Transaction Receipt</h2>

            <!-- Transaction Details -->
            <div class="section-title">Transaction Details</div>
            <table>
                <tr><td class="label">Transaction ID</td><td class="value"><?= $transaction['txnid']; ?></td></tr>
                <tr><td class="label">Date & Time</td><td class="value"><?= date('D, d M Y, h:i A', strtotime($transaction['created_at'])); ?></td></tr>
                <tr><td class="label">Sender Name</td><td class="value"><?= $transaction['name']; ?></td></tr>
                <tr><td class="label">Receiver Name</td><td class="value"><?= $transaction['recipient_name']; ?></td></tr>
                <tr><td class="label">Bank</td><td class="value"><?= $transaction['bank_name']; ?> (<?= $transaction['ifsc_code']; ?>)</td></tr>
                <tr><td class="label">Account No.</td><td class="value">****<?= substr($transaction['account_number'], -4); ?></td></tr>
                <tr><td class="label">Status</td><td class="value"><b><?= ucfirst($transaction['status']); ?></b></td></tr>
                 <tr><td class="label">Remark</td><td class="value"><?= ucfirst($transaction['remark']); ?></td></tr>

            </table>

            <!-- Billing Details -->
            <div class="section-title">Billing Details</div>
            <table>
                <tr><td class="label">Mobile No.</td><td class="value"><?= $transaction['mobile']; ?></td></tr>
                <tr><td class="label">Email ID</td><td class="value"><?= $transaction['email']; ?></td></tr>
                <tr><td class="label">Transaction Fee</td><td class="value">2% + GST</td></tr>
                <tr><td class="label">Processing Time</td><td class="value">Instant</td></tr>
            </table>

            <div class="amount">Amount Paid: ₹<?= number_format($transaction['amount'], 2); ?></div>
        </body>
        </html>
    `);
    myWindow.document.close();
    myWindow.print();
}
</script>

