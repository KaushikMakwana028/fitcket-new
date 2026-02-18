<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bank Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-gradient rounded-circle p-3 me-3">
                                <img src="<?= base_url('assets/images/bank.png');?>" alt="Bank" width="24"
                                    height="24">
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Bank Details</h5>
                                <p class="text-muted mb-0 small">Manage your banking information securely</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="bankDetailsForm" class="needs-validation" novalidate>
<input type="hidden" name="provider_id" id="providerId" value="<?= isset($bank_details->provider_id) && !empty($bank_details->provider_id) ? $bank_details->provider_id : ''; ?>">

    <div class="row g-4">

        <!-- Account Holder Name -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="accountHolderName"
                       name="accountHolderName"
                       placeholder="Enter account holder name"
                       value="<?= isset($bank_details) ? $bank_details->account_holder_name : ''; ?>"
                       required>
                <label for="accountHolderName">
                    <i class="bx bx-user me-2"></i>Account Holder Name *
                </label>
                <div class="invalid-feedback">Please provide a valid account holder name.</div>
            </div>
        </div>

        <!-- Bank Name -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="bankName"
                       name="bankName"
                       placeholder="Enter bank name"
                       value="<?= isset($bank_details) ? $bank_details->bank_name : ''; ?>"
                       required>
                <label for="bankName">
                    <i class="bx bx-building me-2"></i>Bank Name *
                </label>
                <div class="invalid-feedback">Please provide a valid bank name.</div>
            </div>
        </div>

        <!-- Account Number -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="accountNumber"
                       name="accountNumber"
                       placeholder="Enter account number"
                       value="<?= isset($bank_details) ? $bank_details->account_number : ''; ?>"
                       required pattern="[0-9]{9,18}">
                <label for="accountNumber">
                    <i class="bx bx-credit-card me-2"></i>Account Number *
                </label>
                <div class="invalid-feedback">Please provide a valid account number (9–18 digits).</div>
            </div>
        </div>

        <!-- Confirm Account Number -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="confirmAccountNumber"
                       name="confirmAccountNumber"
                       placeholder="Confirm account number"
                       value="<?= isset($bank_details) ? $bank_details->account_number : ''; ?>"
                       required>
                <label for="confirmAccountNumber">
                    <i class="bx bx-check-double me-2"></i>Confirm Account Number *
                </label>
                <div class="invalid-feedback">Account numbers do not match.</div>
            </div>
        </div>

        <!-- IFSC Code -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <input type="text" 
                       class="form-control text-uppercase" 
                       id="ifscCode"
                       name="ifscCode"
                       placeholder="Enter IFSC code"
                       value="<?= isset($bank_details) ? $bank_details->ifsc_code : ''; ?>"
                       required pattern="^[A-Z]{4}[0-9]{7}$">
                <label for="ifscCode">
                    <i class="bx bx-qr me-2"></i>IFSC Code *
                </label>
                <div class="invalid-feedback">Please provide a valid IFSC code (e.g., SBIN0001234).</div>
            </div>
        </div>

        <!-- Account Type -->
        <div class="col-12 col-md-6">
            <div class="form-floating">
                <select class="form-select" id="accountType" name="accountType" required>
                    <option value="" disabled <?= !isset($bank_details) ? 'selected' : ''; ?>>Choose account type</option>
                    <option value="savings" <?= isset($bank_details) && $bank_details->account_type == 'savings' ? 'selected' : ''; ?>>Savings Account</option>
                    <option value="current" <?= isset($bank_details) && $bank_details->account_type == 'current' ? 'selected' : ''; ?>>Current Account</option>
                    <option value="salary" <?= isset($bank_details) && $bank_details->account_type == 'salary' ? 'selected' : ''; ?>>Salary Account</option>
                </select>
                <label for="accountType">
                    <i class="bx bx-category me-2"></i>Account Type *
                </label>
                <div class="invalid-feedback">Please select an account type.</div>
            </div>
        </div>

        <!-- Branch Name -->
        <div class="col-12">
            <div class="form-floating">
                <input type="text" 
                       class="form-control" 
                       id="branchName"
                       name="branchName"
                       placeholder="Enter branch name"
                       value="<?= isset($bank_details) ? $bank_details->branch_name : ''; ?>">
                <label for="branchName">
                    <i class="bx bx-map me-2"></i>Branch Name (Optional)
                </label>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-start" role="alert">
                <i class="bx bx-shield-check fs-5 me-3 mt-1 text-info"></i>
                <div>
                    <h6 class="alert-heading mb-1">Security Notice</h6>
                    <small class="mb-0">Your banking information is encrypted and stored securely. We never share your financial details with third parties.</small>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-end">
                <button type="button" class="btn btn-outline-secondary px-4" onclick="window.history.back();">
                    <i class="bx bx-x me-2"></i>Cancel
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bx bx-save me-2"></i><?= isset($bank_details) ? 'Update Bank Details' : 'Save Bank Details'; ?>
                </button>
            </div>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient {
        background: linear-gradient(135deg, var(--bs-primary) 0%, rgba(var(--bs-primary-rgb), 0.8) 100%);
    }

    .form-floating>label {
        font-weight: 500;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .card {
        border: none;
        border-radius: 12px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .alert {
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .form-floating>label {
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .d-flex.flex-md-row {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }

    /* Input validation styles */
    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-valid {
        border-color: #198754;
    }

    /* Custom focus styles */
    .form-floating>.form-control:focus~label,
    .form-floating>.form-select:focus~label {
        color: var(--bs-primary);
    }

    /* Hover effects */
    .card:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease;
    }

    /* Loading state for submit button */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>