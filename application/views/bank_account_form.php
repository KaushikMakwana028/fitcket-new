<style>
    .main-container {
        background: white;
        border-radius: 12px;
        padding: 30px 20px;
        max-width: 800px;
        margin: auto;
    }
    .section-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .accounts-list, .form-container {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        margin-bottom: 30px;
    }
    .account-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
    .account-item:last-child {
        border-bottom: none;
    }
    .account-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .account-icon {
        width: 40px;
        height: 40px;
        background: #e5e7eb;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        color: #6b7280;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border-radius: 8px;
        border: 1px solid #ced4da;
    }
    .submit-btn {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="section-header">
        <h2>Manage Bank Accounts</h2>
        <p>Add or update your bank account details</p>
    </div>

    <div class="accounts-list mb-4">
        <?php if (!empty($bank_accounts)): ?>
            <?php foreach ($bank_accounts as $acc): ?>
                <div class="account-item d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                    <div class="account-info d-flex align-items-center">
                        <div class="account-icon me-3"><i class="bi bi-bank fs-3"></i></div>
                        <div>
                            <strong><?= $acc->bank_name; ?></strong><br>
                            <?= $acc->account_number; ?> • IFSC: <?= $acc->ifsc_code; ?> <br>
                            <small>Type: <?= ucfirst($acc->account_type); ?> | Branch: <?= $acc->branch_name; ?></small>
                        </div>
                    </div>
                    <div>
                       <div class="d-flex gap-2">
    <button class="btn btn-sm btn-outline-primary edit-account" data-account='<?= json_encode($acc); ?>'>
        <i class="bi bi-pencil"></i> <span class="d-none d-md-inline">Edit</span>
    </button>
    <button class="btn btn-sm btn-outline-danger delete-account" data-id="<?= $acc->id; ?>">
        <i class="bi bi-trash"></i> <span class="d-none d-md-inline">Remove</span>
    </button>
</div>


                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">No bank account added yet.</p>
        <?php endif; ?>
    </div>

    <!-- Empty Form -->
    <div class="form-container">
        <form id="bankDetailsForm" method="post" novalidate>
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="provider_id" value="<?= $this->user['id']; ?>">

            <div class="form-group mb-3">
                <label for="accountHolderName">Account Holder Name</label>
                <input type="text" class="form-control" name="accountHolderName" id="accountHolderName" placeholder="Enter account holder name" required>
                <div class="invalid-feedback">Please enter account holder name.</div>
            </div>

            <div class="form-group mb-3">
                <label for="bankName">Bank Name</label>
                <input type="text" class="form-control" name="bankName" id="bankName" placeholder="Enter bank name" required>
                <div class="invalid-feedback">Please enter bank name.</div>
            </div>

            <div class="form-group mb-3">
                <label for="accountNumber">Account Number</label>
                <input type="text" class="form-control" name="accountNumber" id="accountNumber" placeholder="Enter account number" required>
                <div class="invalid-feedback">Please enter account number.</div>
            </div>

            <div class="form-group mb-3">
                <label for="ifscCode">IFSC Code</label>
                <input type="text" class="form-control" name="ifscCode" id="ifscCode" placeholder="Enter IFSC code" required>
                <div class="invalid-feedback">Please enter IFSC code.</div>
            </div>

            <div class="form-group mb-3">
                <label for="accountType">Account Type</label>
                <select name="accountType" id="accountType" class="form-control" required>
                    <option value="">-- Select Account Type --</option>
                    <option value="savings">Saving</option>
                    <option value="current">Current</option>
                </select>
                <div class="invalid-feedback">Please select account type.</div>
            </div>

            <div class="form-group mb-3">
                <label for="branchName">Branch Name</label>
                <input type="text" class="form-control" name="branchName" id="branchName" placeholder="Enter branch name" required>
                <div class="invalid-feedback">Please enter branch name.</div>
            </div>

            <div class="d-flex justify-content-center mt-3 gap-2 mb-5">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Save Bank Details
    </button>
    <button type="reset" id="resetForm" class="btn btn-danger">
        <i class="bi bi-arrow-counterclockwise"></i> Reset
    </button>
</div>


        </form>
    </div>
</div>

