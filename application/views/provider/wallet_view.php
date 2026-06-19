<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Wallet</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                <h5 class="mb-1 font-weight-bold">My Wallet</h5>
                                <p class="mb-0 text-secondary">Manage your earnings and withdraw funds</p>
                            </div>
                        </div>

                        <!-- Balance Overview -->
                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-primary">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Available Balance</p>
                                                <h4 class="my-1 text-primary">₹<?= number_format($wallet_balance, 2) ?></h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-gradient-cosmic text-white ms-auto">
                                                <i class='bx bx-wallet'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-warning">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Minimum Required</p>
                                                <h4 class="my-1 text-warning">₹<?= number_format($wallet_min, 2) ?></h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                                <i class='bx bx-info-circle'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-success">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Bookings</p>
                                                <h4 class="my-1 text-success"><?= !empty($transactions) ? count($transactions) : 0 ?></h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class='bx bx-calendar-check'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-danger">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Withdrawals</p>
                                                <h4 class="my-1 text-danger"><?= !empty($withdraw) ? count($withdraw) : 0 ?></h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                <i class='bx bx-money'></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert Notice -->
                        <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2 mb-4">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-warning"><i class='bx bx-info-circle'></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-warning">Important Notice</h6>
                                    <div class="text-secondary">You must maintain a minimum balance of ₹<?= number_format($wallet_min, 2) ?> to keep your wallet active and continue receiving bookings.</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <!-- Withdraw Section -->
                        <div class="row">
                            <div class="col-12 col-lg-5 col-xl-4">
                                <div class="card radius-10 border shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="font-30 text-primary"><i class='bx bx-wallet'></i></div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">Withdraw Funds</h6>
                                                <p class="mb-0 text-secondary small">Request a withdrawal</p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="withdrawAmount" class="form-label">Withdrawal Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-transparent">
                                                    <i class='bx bx-rupee'></i>
                                                </span>
                                                <input type="number"
                                                    class="form-control border-start-0"
                                                    id="withdrawAmount"
                                                    placeholder="Enter amount"
                                                    min="1"
                                                    step="0.01">
                                            </div>
                                            <small id="amountError" class="text-danger d-none mt-1"></small>
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    Max: ₹<?= number_format(max(0, $wallet_balance - $wallet_min), 2) ?>
                                                </small>
                                                <?php if (max(0, $wallet_balance - $wallet_min) > 0): ?>
                                                    <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" onclick="setMaxAmount()">
                                                        Use Max
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button class="btn btn-primary radius-10"
                                                id="withdrawBtn"
                                                data-id="<?= $this->provider['id'] ?>"
                                                disabled>
                                                <i class='bx bx-send me-1'></i>Request Withdrawal
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Stats -->
                                <div class="card radius-10 border shadow-none mt-3">
                                    <div class="card-body">
                                        <h6 class="mb-3">Wallet Status</h6>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="mb-0 text-secondary">Current Balance</p>
                                            <h6 class="mb-0 text-primary">₹<?= number_format($wallet_balance, 2) ?></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <p class="mb-0 text-secondary">Minimum Required</p>
                                            <h6 class="mb-0 text-warning">₹<?= number_format($wallet_min, 2) ?></h6>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="mb-0 text-secondary">Available to Withdraw</p>
                                            <h6 class="mb-0 text-success">₹<?= number_format(max(0, $wallet_balance - $wallet_min), 2) ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction History -->
                            <div class="col-12 col-lg-7 col-xl-8">
                                <div class="card radius-10 border shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="font-30 text-primary"><i class='bx bx-history'></i></div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">Transaction History</h6>
                                                <p class="mb-0 text-secondary small">View all transactions</p>
                                            </div>
                                        </div>

                                        <!-- Nav Tabs -->
                                        <ul class="nav nav-tabs nav-primary mb-3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#bookingTab" role="tab" aria-selected="true">
                                                    <div class="d-flex align-items-center">
                                                        <div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i></div>
                                                        <div class="tab-title">Bookings
                                                            <span class="badge bg-primary rounded-pill ms-1"><?= !empty($transactions) ? count($transactions) : 0 ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#withdrawTab" role="tab" aria-selected="false">
                                                    <div class="d-flex align-items-center">
                                                        <div class="tab-icon"><i class='bx bx-money font-18 me-1'></i></div>
                                                        <div class="tab-title">Withdrawals
                                                            <span class="badge bg-danger rounded-pill ms-1"><?= !empty($withdraw) ? count($withdraw) : 0 ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab Content -->
                                        <div class="tab-content py-3">
                                            <!-- Booking History Tab -->
                                            <div class="tab-pane fade show active" id="bookingTab" role="tabpanel">
                                                <?php if (!empty($transactions)): ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Reference</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($transactions as $txn): ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="recent-product-img">
                                                                                    <div class="bg-light-success text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                                        <i class='bx bx-plus font-22'></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ms-2">
                                                                                    <h6 class="mb-0 font-14"><?= date("M d, Y", strtotime($txn['date'])) ?></h6>
                                                                                    <p class="mb-0 text-secondary font-13"><?= date("h:i A", strtotime($txn['date'])) ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p class="mb-0 text-secondary"><?= htmlspecialchars($txn['reference']) ?></p>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <h6 class="mb-0 text-success">+₹<?= number_format($txn['amount'], 2) ?></h6>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-center py-5">
                                                        <div class="mb-3">
                                                            <i class='bx bx-receipt font-50 text-secondary'></i>
                                                        </div>
                                                        <h6 class="text-secondary">No Booking Transactions</h6>
                                                        <p class="text-secondary small mb-0">Your booking transactions will appear here</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Withdraw History Tab -->
                                            <div class="tab-pane fade" id="withdrawTab" role="tabpanel">
                                                <?php if (!empty($withdraw)): ?>
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Transaction ID</th>
                                                                    <th>Status</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($withdraw as $txn): ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="recent-product-img">
                                                                                    <div class="bg-light-danger text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                                        <i class='bx bx-minus font-22'></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="ms-2">
                                                                                    <h6 class="mb-0 font-14"><?= date("M d, Y", strtotime($txn->created_at)) ?></h6>
                                                                                    <p class="mb-0 text-secondary font-13"><?= date("h:i A", strtotime($txn->created_at)) ?></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p class="mb-0 text-secondary font-13"><?= htmlspecialchars($txn->txn_id) ?></p>
                                                                            <?php if (!empty($txn->note)): ?>
                                                                                <p class="mb-0 text-secondary font-12"><?= htmlspecialchars($txn->note) ?></p>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($txn->status === "pending"): ?>
                                                                                <span class="badge bg-warning text-dark">Pending</span>
                                                                            <?php elseif ($txn->status === "success"): ?>
                                                                                <span class="badge bg-success">Success</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-danger">Failed</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <h6 class="mb-0 text-danger">-₹<?= number_format($txn->amount, 2) ?></h6>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-center py-5">
                                                        <div class="mb-3">
                                                            <i class='bx bx-money-withdraw font-50 text-secondary'></i>
                                                        </div>
                                                        <h6 class="text-secondary">No Withdrawal Transactions</h6>
                                                        <p class="text-secondary small mb-0">Your withdrawal transactions will appear here</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ========== Custom Styles for Wallet Page ========== */

    /* Widget Icons */
    .widgets-icons-2 {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
    }

    /* Light backgrounds for icons */
    .bg-light-success {
        background-color: rgba(23, 160, 134, 0.18) !important;
    }

    .bg-light-danger {
        background-color: rgba(241, 85, 108, 0.18) !important;
    }

    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.18) !important;
    }

    .bg-light-info {
        background-color: rgba(23, 162, 184, 0.18) !important;
    }

    /* Card hover effect */
    .card:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    /* Input group styling */
    .input-group-text {
        border-right: 0;
    }

    .border-start-0 {
        border-left: 0 !important;
    }

    /* Table styling */
    .table-responsive {
        max-height: 450px;
        overflow-y: auto;
    }

    .table-responsive::-webkit-scrollbar {
        width: 5px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: transparent;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Tab customization */
    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        padding: 0.75rem 1.25rem;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 2px solid;
    }

    .nav-primary .nav-link.active {
        border-bottom-color: var(--bs-primary);
        color: var(--bs-primary);
    }

    /* Badge in tabs */
    .nav-link .badge {
        font-size: 0.7rem;
        padding: 0.25em 0.5em;
    }

    /* Button styling */
    .btn-primary {
        padding: 0.625rem 1.25rem;
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Alert styling */
    .alert .font-35 {
        font-size: 35px;
    }

    /* Responsive */
    @media (max-width: 575.98px) {
        .widgets-icons-2 {
            width: 45px;
            height: 45px;
            font-size: 22px;
        }

        .card-body {
            padding: 1rem !important;
        }

        .font-30 {
            font-size: 24px !important;
        }

        .font-35 {
            font-size: 28px !important;
        }

        .nav-tabs .nav-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .table-responsive {
            max-height: 350px;
        }

        .font-14 {
            font-size: 13px !important;
        }

        .font-13 {
            font-size: 12px !important;
        }

        h4 {
            font-size: 1.25rem !important;
        }

        h5 {
            font-size: 1.1rem !important;
        }

        h6 {
            font-size: 0.95rem !important;
        }
    }

    @media (max-width: 767.98px) {
        .row-cols-md-2>* {
            width: 100%;
        }

        .alert .d-flex {
            flex-direction: column;
            text-align: center;
        }

        .alert .ms-3 {
            margin-left: 0 !important;
            margin-top: 1rem;
        }
    }

    @media (max-width: 991.98px) {

        .col-lg-5,
        .col-lg-7 {
            width: 100%;
        }

        .card.mt-3 {
            margin-top: 1rem !important;
        }
    }

    /* Dark theme compatibility */
    @media (prefers-color-scheme: dark) {
        .table-light {
            --bs-table-bg: rgba(255, 255, 255, 0.05);
            --bs-table-color: inherit;
        }

        .bg-transparent {
            background-color: transparent !important;
        }
    }

    /* Print styles */
    @media print {

        .page-breadcrumb,
        .btn,
        .alert,
        .nav-tabs {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        .table-responsive {
            max-height: none !important;
            overflow: visible !important;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tab-pane {
        animation: fadeIn 0.3s ease;
    }

    /* Additional utility classes */
    .font-12 {
        font-size: 12px;
    }

    .font-13 {
        font-size: 13px;
    }

    .font-14 {
        font-size: 14px;
    }

    .font-18 {
        font-size: 18px;
    }

    .font-22 {
        font-size: 22px;
    }

    .font-50 {
        font-size: 50px;
    }
</style>

<script>
    /**
     * Set maximum withdrawable amount
     */
    function setMaxAmount() {
        const maxAmount = <?= max(0, $wallet_balance - $wallet_min) ?>;
        const input = document.getElementById('withdrawAmount');
        input.value = maxAmount.toFixed(2);
        input.dispatchEvent(new Event('input'));
    }

    /**
     * Wallet functionality
     */
    document.addEventListener("DOMContentLoaded", function() {
        const withdrawBtn = document.getElementById("withdrawBtn");
        const withdrawInput = document.getElementById("withdrawAmount");
        const amountError = document.getElementById("amountError");

        const walletBalance = parseFloat("<?= $wallet_balance ?>") || 0;
        const walletMin = parseFloat("<?= $wallet_min ?>") || 0;
        const maxWithdraw = Math.max(0, walletBalance - walletMin);

        /**
         * Validate withdrawal amount
         */
        withdrawInput.addEventListener("input", function() {
            let amount = parseFloat(this.value);

            // Reset
            withdrawBtn.disabled = true;
            amountError.classList.add("d-none");
            this.classList.remove("is-invalid", "is-valid");

            // Validations
            if (!amount || amount <= 0) {
                showError("Please enter a valid amount");
                return;
            }

            if (amount > walletBalance) {
                showError(`Insufficient balance. Available: ₹${walletBalance.toFixed(2)}`);
                return;
            }

            if ((walletBalance - amount) < walletMin) {
                showError(`You must maintain minimum ₹${walletMin.toFixed(2)} balance`);
                return;
            }

            if (amount > maxWithdraw) {
                showError(`Maximum withdrawable: ₹${maxWithdraw.toFixed(2)}`);
                return;
            }

            // Valid
            withdrawBtn.disabled = false;
            this.classList.add("is-valid");
        });

        /**
         * Show error
         */
        function showError(message) {
            amountError.textContent = message;
            amountError.classList.remove("d-none");
            withdrawInput.classList.add("is-invalid");
        }

        /**
         * Handle withdrawal
         */
        withdrawBtn.addEventListener("click", function() {
            const providerId = this.getAttribute("data-id");
            const amount = parseFloat(withdrawInput.value);

            if (!providerId || !amount || amount <= 0) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Amount",
                    text: "Please enter a valid withdrawal amount",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                title: "Confirm Withdrawal",
                html: `
                    <div class="text-start">
                        <p class="mb-2">Withdrawal Amount:</p>
                        <h3 class="text-primary mb-3">₹${amount.toFixed(2)}</h3>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Current Balance:</span>
                            <strong>₹${walletBalance.toFixed(2)}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>After Withdrawal:</span>
                            <strong>₹${(walletBalance - amount).toFixed(2)}</strong>
                        </div>
                    </div>
                `,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: '<i class="bx bx-check me-1"></i> Confirm',
                cancelButtonText: '<i class="bx bx-x me-1"></i> Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    processWithdrawal(providerId, amount);
                }
            });
        });

        /**
         * Process withdrawal
         */
        function processWithdrawal(providerId, amount) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process your request',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= base_url('provider/wallet/withdraw_request') ?>",
                method: "POST",
                data: {
                    provider_id: providerId,
                    amount: amount
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: res.message || "Withdrawal request submitted successfully",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            withdrawInput.value = "";
                            withdrawInput.classList.remove("is-valid");
                            withdrawBtn.disabled = true;
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Request Failed",
                            text: res.message || "Unable to process withdrawal",
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong. Please try again",
                        confirmButtonText: "OK"
                    });
                }
            });
        }

        /**
         * Format on blur
         */
        withdrawInput.addEventListener("blur", function() {
            if (this.value) {
                let amount = parseFloat(this.value);
                if (!isNaN(amount)) {
                    this.value = amount.toFixed(2);
                }
            }
        });
    });
</script>