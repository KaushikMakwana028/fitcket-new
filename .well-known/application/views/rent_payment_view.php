<style>
    /* Your existing styles remain unchanged */
    /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        } */

    /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
         */
    /* .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        } */

    .header {
        background: var(--gradient-primary);
    color: #fff;
        padding: 30px;
        text-align: center;
    }

    .header h1 {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .header p {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .form-container {
        padding: 40px;
    }

    .form-grid {
        display: grid;
        gap: 25px;
    }

    .form-group {
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #e1e5e9;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2196F3;
        background: white;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .saved-recipients {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .saved-recipients h3 {
        margin-bottom: 15px;
        color: #333;
        font-size: 1.1rem;
    }

    .recipient-card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #e1e5e9;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .recipient-card:hover {
        border-color: #2196F3;
        box-shadow: 0 2px 8px rgba(33, 150, 243, 0.1);
    }

    .recipient-card.selected {
        border-color: #2196F3;
        background: #f3f8ff;
    }

    .amount-display {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin: 25px 0;
    }

    .amount-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .amount-row:last-child {
        margin-bottom: 0;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .checkbox-container input[type="checkbox"] {
        width: auto;
        margin-right: 10px;
        transform: scale(1.2);
    }

    .pay-button {
       background: var(--gradient-primary);
    color: #fff;
        border: none;
        padding: 18px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 12px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }

    .pay-button:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
    }

    .pay-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .security-info {
        background: #e8f5e8;
        padding: 20px;
        border-radius: 12px;
        margin-top: 25px;
        border-left: 4px solid #4CAF50;
    }

    .security-info h4 {
        color: #2e7d32;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .loading-spinner {
        background: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #2196F3;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .error-message {
        background: #ffebee;
        color: #c62828;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #f44336;
        display: none;
    }

    /* New styles for recipients and transactions sections */
    .recipients-section,
    .transactions-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        border: 1px solid #e1e5e9;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e1e5e9;
    }

    .section-title {
        color: #333;
        font-size: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .add-recipient-btn {
        background: linear-gradient(135deg, #4CAF50, #45a049);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .add-recipient-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .recipients-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 15px;
    }

    .recipient-item {
        background: white;
        padding: 18px;
        border-radius: 12px;
        border: 2px solid #e1e5e9;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .recipient-item:hover {
        border-color: #2196F3;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
        transform: translateY(-2px);
    }

    .recipient-item.active {
        border-color: #4CAF50;
        background: #f1f8e9;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
    }

    .recipient-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .recipient-name {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
    }

    .recipient-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 5px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .edit-btn {
        color: #2196F3;
    }

    .delete-btn {
        color: #f44336;
    }

    .action-btn:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    .recipient-details {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }

    .recipient-bank {
        font-weight: 500;
        margin-bottom: 4px;
    }

    .recipient-account {
        font-family: monospace;
        background: #f5f5f5;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 4px;
    }

    .transactions-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
        border-radius: 12px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #2196F3, #21CBF3);
        color: white;
        font-weight: 600;
        border: none;
        padding: 15px 12px;
        font-size: 0.9rem;
    }

    .table tbody td {
        padding: 12px;
        border-color: #f0f0f0;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
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

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-top: 1px solid #e1e5e9;
    }

    .pagination-info {
        color: #666;
        font-size: 0.9rem;
    }

    .pagination-controls {
        display: flex;
        gap: 10px;
    }

    .page-btn {
        background: white;
        border: 1px solid #e1e5e9;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .page-btn:hover:not(:disabled) {
        background: #f8f9fa;
        border-color: #2196F3;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-btn.active {
        background: var(--gradient-primary);
    color: #fff;
        border-color: #2196F3;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        /* body {
            padding: 10px;
        } */

        .container {
            border-radius: 15px;
        }

        .header {
            padding: 25px 20px;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .form-container {
            padding: 25px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .amount-display {
            padding: 20px;
        }

        .pay-button {
            padding: 16px 30px;
            font-size: 1rem;
        }

        .recipients-grid {
            grid-template-columns: 1fr;
        }

        .recipients-section,
        .transactions-section {
            padding: 20px 15px;
        }

        .section-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .pagination-container {
            flex-direction: column;
            gap: 15px;
        }

        .pagination-controls {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .header h1 {
            font-size: 1.3rem;
        }

        .header p {
            font-size: 1rem;
        }

        .form-container {
            padding: 20px 15px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 12px;
            font-size: 0.95rem;
        }

        .amount-display {
            padding: 15px;
        }

        .pay-button {
            padding: 14px 25px;
            font-size: 0.95rem;
        }

        .recipients-section,
        .transactions-section {
            padding: 15px 10px;
        }

        .recipient-item {
            padding: 15px;
        }

        .table thead th,
        .table tbody td {
            padding: 10px 8px;
            font-size: 0.8rem;
        }
    }

    /* ✅ Responsive Fix for very small screens */
    @media (max-width: 420px) {
        .abc {}

        .pagination-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 10px;
            padding: 9px;
        }

        .pagination-info {
            font-size: 0.8rem;
        }

        .pagination-controls {
            flex-wrap: wrap;
            /* allow buttons to break line if needed */
            justify-content: center;
            gap: 6px;
        }

        .page-btn {
            padding: 6px 10px;
            /* smaller buttons for mobile */
            font-size: 0.8rem;
        }
    }

    .repay-btn {
        background: #6f42c1;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .repay-btn:hover {
        background: #59359c;
    }

   .transactions-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.transaction-card {
    background: #fff;
    border: 1px solid #e1e5e9;
    border-radius: 10px;
    padding: 11px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    transition: 0.3s;
}

.transaction-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.transaction-header {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 8px;
}

.transaction-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.transaction-recipient {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
}

.transaction-amount {
    margin: 0;
    font-size: 1rem;
    font-weight: bold;
    color: #6f42c1;
}

/* Right side (Status + Button) */
.transaction-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ✅ Status Badges */
.status-badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-left: 85%;
}

.status-success {
    background: #e8f5e9;
    color: #2e7d32;
}

.status-pending {
    background: #fff3e0;
    color: #ef6c00;
}

.status-failed {
    background: #ffebee;
    color: #c62828;
}

/* Button fix */
.transaction-btn {
    width: auto !important;
    display: inline-block;
    white-space: nowrap;
    color: #6f42c1;
}
@media (max-width: 576px) {
    
    .status-badge {
        margin-left: 45% !important;
    }
}

.filter-bar {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 5px;
}
.filter-bar .btn-group {
    flex-wrap: nowrap;
    overflow-x: auto;
}
.filter-bar .btn {
    flex: 1 1 auto;
    min-width: 90px;
}

.filter-bar {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 8px;
    scrollbar-width: thin;
    scrollbar-color: #6f42c1 transparent;
}

.filter-bar::-webkit-scrollbar {
    height: 6px;
}
.filter-bar::-webkit-scrollbar-thumb {
    background: #6f42c1;
    border-radius: 10px;
}

.filter-bar .btn-group {
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 0.5rem;
    padding: 5px 2px;
}

.filter-bar .btn {
    flex: 0 0 auto;
    min-width: 110px;
    border-radius: 50px; /* pill style */
    font-size: 0.85rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
}

.filter-bar .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.filter-bar .btn.active {
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}


</style>
<div class="container mb-5">
    <div
        style=" margin: 0 auto; background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); overflow: hidden;">
        <div class="header mt-3">
            <h1><i class="fas fa-home"></i> Pay to gym</h1>
            <p>Secure & convenient rent payment with credit/debit cards</p>
        </div>

        <div class="form-container">
            <div class="error-message" id="error-message"></div>

            <!-- Recipients Section -->
            <div class="recipients-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-users"></i>
                        Saved Recipients
                    </h3>
                    <!-- ❌ Removed Add New Button -->
                </div>

                <div class="recipients-grid" id="recipients-grid">
                    
                    <?php if (!empty($recipients)): ?>
                        <?php foreach ($recipients as $r): ?>
                            <div class="recipient-item" data-account="<?= $r['account_number']; ?>"
                                data-ifsc="<?= $r['ifsc_code']; ?>" data-bank="<?= $r['bank_name']; ?>">

                                <div class="recipient-header">
                                    <div class="recipient-name"><?= $r['recipient_name']; ?></div>
                                    <div class="recipient-actions">
                                        <button class="action-btn repay-btn" title="Repay">
                                            <i class="fas fa-undo-alt"></i> Repay
                                        </button>
                                        <button class="action-btn remove-btn-reception" title="Remove" data-id="<?= $r['id']; ?>">
                                            <i class="fas fa-trash-alt text-danger fw-bold"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="recipient-details">
                                    <div class="recipient-bank"><?= $r['bank_name']; ?></div>
                                    <div class="recipient-account">****<?= substr($r['account_number'], -4); ?></div>
                                    <div>IFSC: <?= $r['ifsc_code']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No recipients saved.</p>
                    <?php endif; ?>
                </div>


            </div>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form id="bank-payment-form" method="POST" action="<?= base_url('pay_any_gym') ?>">
                <div class="form-grid">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i> Recipient Name *
                            </label>
                            <input type="text" id="name" name="name" value="<?= set_value('name'); ?>"
                                class="form-control <?= form_error('name') ? 'is-invalid' : ''; ?>">
                            <?= form_error('name', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">
                                <i class="fas fa-phone"></i> Mobile Number *
                            </label>
                            <input type="text" id="mobile_number" name="mobile_number"
                                value="<?= set_value('mobile_number'); ?>"
                                class="form-control <?= form_error('mobile_number') ? 'is-invalid' : ''; ?>">
                            <?= form_error('mobile_number', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="account_number">
                                <i class="fas fa-university"></i> Account Number *
                            </label>
                            <input type="text" id="account_number" name="account_number"
                                value="<?= set_value('account_number'); ?>"
                                class="form-control <?= form_error('account_number') ? 'is-invalid' : ''; ?>">
                            <?= form_error('account_number', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="confirm_account_number">
                                <i class="fas fa-check"></i> Confirm Account Number *
                            </label>
                            <input type="text" id="confirm_account_number" name="confirm_account_number"
                                value="<?= set_value('confirm_account_number'); ?>"
                                class="form-control <?= form_error('confirm_account_number') ? 'is-invalid' : ''; ?>">
                            <?= form_error('confirm_account_number', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="ifsc_code">
                                <i class="fas fa-code"></i> IFSC Code *
                            </label>
                            <input type="text" id="ifsc_code" name="ifsc_code" maxlength="11"
                                value="<?= set_value('ifsc_code'); ?>" style="text-transform: uppercase;"
                                class="form-control <?= form_error('ifsc_code') ? 'is-invalid' : ''; ?>">
                            <?= form_error('ifsc_code', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="bank_name">
                                <i class="fas fa-building"></i> Bank Name *
                            </label>
                            <input type="text" id="bank_name" name="bank_name" value="<?= set_value('bank_name'); ?>"
                                class="form-control <?= form_error('bank_name') ? 'is-invalid' : ''; ?>">
                            <?= form_error('bank_name', '<div class="invalid-feedback">', '</div>'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <label for="transfer_amount">
                                <i class="fas fa-rupee-sign"></i> Amount *
                            </label>
                            <input type="number" id="transfer_amount" name="transfer_amount"
                                value="<?= set_value('transfer_amount'); ?>" min="1" step="0.01"
                                class="form-control <?= form_error('transfer_amount') ? 'is-invalid' : ''; ?>">
                            <?= form_error('transfer_amount', '<div class="invalid-feedback">', '</div>'); ?>
                            <small class="text-danger fw-bold ms-2">Your money settles within a minute.</small>
                        </div>
                        <div class="form-group" style="flex: 1;">
                <label for="remark">
                    <i class="fas fa-comment-dots"></i> Remark *
                </label>
                <textarea id="remark" name="remark" rows="3"
                    class="form-control <?= form_error('remark') ? 'is-invalid' : ''; ?>"><?= set_value('remark'); ?></textarea>
                <?= form_error('remark', '<div class="invalid-feedback">', '</div>'); ?>
            </div>
                    </div>
                    

                </div>

                <button type="submit" class="pay-button mt-5" id="submit-button">
                    <i class="fas fa-credit-card"></i> Pay Securely
                </button>
            </form>


            <!-- Recent Transactions Section -->
            <div class="transactions-section mt-5">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-history"></i>
                        Recent Transactions
                    </h3>
                </div>
<div class="filter-bar mb-3">
    <div class="btn-group d-flex flex-wrap gap-2 justify-content-center" role="group">
        <button class="btn filter-btn <?= ($filter=='')?'btn-primary active':'btn-outline-primary' ?>" data-filter="">
            <i class="fas fa-list"></i> All
        </button>
        <button class="btn filter-btn <?= ($filter=='today')?'btn-primary active':'btn-outline-primary' ?>" data-filter="today">
            <i class="fas fa-calendar-day"></i> Today
        </button>
        <button class="btn filter-btn <?= ($filter=='month')?'btn-primary active':'btn-outline-primary' ?>" data-filter="month">
            <i class="fas fa-calendar-alt"></i> This Month
        </button>
        <button class="btn filter-btn <?= ($filter=='largest')?'btn-primary active':'btn-outline-primary' ?>" data-filter="largest">
            <i class="fas fa-arrow-up"></i> Largest
        </button>
        <button class="btn filter-btn <?= ($filter=='smallest')?'btn-primary active':'btn-outline-primary' ?>" data-filter="smallest">
            <i class="fas fa-arrow-down"></i> Smallest
        </button>
        <button class="btn filter-btn <?= ($filter=='pending')?'btn-warning active':'btn-outline-warning' ?>" data-filter="pending">
            <i class="fas fa-clock"></i> Pending
        </button>
        <button class="btn filter-btn <?= ($filter=='success')?'btn-success active':'btn-outline-success' ?>" data-filter="success">
            <i class="fas fa-check-circle"></i> Success
        </button>
    </div>
</div>

                <!-- ✅ Transactions as Cards -->
              <div id="transactions-container">
    <?php $this->load->view('transactions_partial', $transactions ? get_defined_vars() : []); ?>
</div>


            </div>

            <div class="security-info mb-5">
                <h4>
                    <i class="fas fa-shield-alt"></i>
                    100% Secure Payment
                </h4>
                <p>All transactions made through credit card are subject to a 2% processing fee plus applicable GST on the fee.
The beneficiary will receive the payment amount net of these charges.</p>
            </div>
        </div>
    </div>

    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Processing your payment...</p>
        </div>
    </div>
</div>