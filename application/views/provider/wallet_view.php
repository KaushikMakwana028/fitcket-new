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

        <div class="card">
            <div class="card-body p-3 p-md-4">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title mb-4 text-center text-md-start">My Wallet</h4>
                    </div>
                </div>

                <!-- Wallet Balance Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="bg-success bg-gradient rounded-3 p-3 text-white text-center">
                            <h5 class="mb-2 fw-normal">Wallet Balance</h5>
                            <h2 class="mb-0 fw-bold">₹<?= number_format($wallet_balance, 2) ?></h2>
                        </div>
                    </div>
                </div>

                <!-- Alert Message -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bx bx-info-circle me-2 fs-5"></i>
                            <small>
                                You should have minimum ₹<?= number_format($wallet_min, 2) ?> in your wallet to keep
                                your wallet active.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Withdraw Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body p-3">
                                <h6 class="card-title mb-3">Withdraw Funds</h6>
                                <div class="mb-3">
                                    <label for="withdrawAmount" class="form-label fw-semibold">
                                        Eligible Withdraw Amount *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" id="withdrawAmount" min="1">
                                    </div>
                                    <!-- Error message should be outside input-group -->
                                    <small id="amountError" class="text-danger d-none"></small>
                                </div>

                                <button class="btn btn-primary w-100 py-2" id="withdrawBtn"
                                    data-id="<?= $this->provider['id'] ?>">
                                    <i class="bx bx-wallet me-2"></i>Withdraw Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0">Transaction History</h5>
                        </div>

                        <!-- Toggle Buttons -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="btn-group w-100" role="group" aria-label="History Toggle">
                                    <button type="button" class="btn btn-outline-primary active" id="bookingHistoryBtn"
                                        onclick="toggleHistory('booking')">
                                        <i class="bx bx-calendar me-1"></i>Booking History
                                        <span
                                            class="badge bg-secondary ms-2"><?= !empty($transactions) ? count($transactions) : 0 ?></span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" id="withdrawHistoryBtn"
                                        onclick="toggleHistory('withdraw')">
                                        <i class="bx bx-money me-1"></i>Withdraw History
                                        <span
                                            class="badge bg-secondary ms-2"><?= !empty($withdraw) ? count($withdraw) : 0 ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Booking History Section -->
                        <div id="bookingHistory" class="history-section">
                            <?php if (!empty($transactions)): ?>
                                <div class="row g-3">
                                    <?php foreach ($transactions as $txn): ?>
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="card h-100 border shadow-sm hover-shadow">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span
                                                            class="badge bg-success rounded-pill">₹<?= number_format($txn['amount'], 2) ?></span>
                                                        <small
                                                            class="text-muted"><?= date("M d, Y", strtotime($txn['date'])) ?></small>
                                                    </div>

                                                    <div class="mb-2">
                                                        <span class="badge bg-info text-dark rounded-pill px-2 py-1">
                                                            Booking
                                                        </span>
                                                    </div>

                                                    <p class="card-text small text-muted mb-2 lh-sm">
                                                        <?= $txn['reference'] ?>
                                                    </p>

                                                    <div class="text-end">
                                                        <small class="text-muted">
                                                            <?= date("h:i A", strtotime($txn['date'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bx bx-calendar fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No booking transactions found</h6>
                                    <p class="text-muted small">Your booking transaction history will appear here.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Withdraw History Section -->
                        <div id="withdrawHistory" class="history-section <?= !empty($withdraw) ? '' : 'd-none' ?>">
                            <?php if (!empty($withdraw)): ?>
                                <div class="row g-3">
                                    <?php foreach ($withdraw as $txn): ?>
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="card h-100 border shadow-sm hover-shadow">
                                                <div class="card-body p-3">
                                                    <!-- Amount and Date -->
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span class="badge bg-warning rounded-pill">
                                                            ₹<?= number_format($txn->amount, 2) ?>
                                                        </span>
                                                        <small class="text-muted">
                                                            <?= date("M d, Y", strtotime($txn->created_at)) ?>
                                                        </small>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="mb-2">
                                                        <?php if ($txn->status === "pending"): ?>
                                                            <span
                                                                class="badge bg-warning text-dark rounded-pill px-2 py-1">Pending</span>
                                                        <?php elseif ($txn->status === "success"): ?>
                                                            <span
                                                                class="badge bg-success text-white rounded-pill px-2 py-1">Success</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="badge bg-danger text-white rounded-pill px-2 py-1">Failed</span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Transaction ID -->
                                                    <p class="card-text small text-muted mb-2 lh-sm">
                                                        Transaction ID: <?= $txn->txn_id ?>
                                                    </p>

                                                    <!-- Note (if available) -->
                                                    <?php if (!empty($txn->note)): ?>
                                                        <p class="card-text small text-muted mb-2 lh-sm">
                                                            <?= htmlspecialchars($txn->note) ?>
                                                        </p>
                                                    <?php endif; ?>

                                                    <!-- Time -->
                                                    <div class="text-end">
                                                        <small class="text-muted">
                                                            <?= date("h:i A", strtotime($txn->created_at)) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="bx bx-money fs-1 text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No withdraw transactions found</h6>
                                    <p class="text-muted small">Your withdraw transaction history will appear here.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-gradient {
        background: linear-gradient(135deg, var(--bs-success) 0%, rgba(var(--bs-success-rgb), 0.8) 100%);
    }

    .card-body {
        word-wrap: break-word;
    }

    /* Toggle Button Styles */
    .btn-group .btn {
        transition: all 0.3s ease;
    }

    .btn-group .btn.active {
        background-color: var(--bs-primary);
        color: white;
        border-color: var(--bs-primary);
    }

    .btn-group .btn:not(.active) {
        background-color: transparent;
    }

    .btn-group .btn:not(.active):hover {
        background-color: var(--bs-primary);
        color: white;
    }

    .history-section {
        transition: opacity 0.3s ease;
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }

        .btn {
            font-size: 0.9rem;
        }

        .badge {
            font-size: 0.75rem;
        }

        h4.card-title {
            font-size: 1.25rem;
        }

        h5 {
            font-size: 1.1rem;
        }

        .btn-group .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-group .btn i {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .page-content {
            padding: 0.5rem;
        }

        .alert {
            font-size: 0.85rem;
        }

        .input-group-text {
            font-size: 0.9rem;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 0.25rem;
        }

        .btn-group .btn:last-child {
            margin-bottom: 0;
        }
    }

    @media (min-width: 992px) {
        .col-lg-4 {
            max-width: 33.333333%;
        }
    }
</style>
<script>
    function toggleHistory(type) {
        // Get buttons and sections
        const bookingBtn = document.getElementById('bookingHistoryBtn');
        const withdrawBtn = document.getElementById('withdrawHistoryBtn');
        const bookingSection = document.getElementById('bookingHistory');
        const withdrawSection = document.getElementById('withdrawHistory');

        if (type === 'booking') {
            // Show booking history
            bookingBtn.classList.add('active');
            withdrawBtn.classList.remove('active');
            bookingSection.classList.remove('d-none');
            withdrawSection.classList.add('d-none');
        } else {
            // Show withdraw history
            withdrawBtn.classList.add('active');
            bookingBtn.classList.remove('active');
            withdrawSection.classList.remove('d-none');
            bookingSection.classList.add('d-none');
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        const withdrawBtn = document.getElementById("withdrawBtn");
        const withdrawInput = document.getElementById("withdrawAmount");
        const amountError = document.getElementById("amountError");

        const walletBalance = parseFloat("<?= $wallet_balance ?>") || 0;
        const walletMin = parseFloat("<?= $wallet_min ?>") || 0; // Admin set min balance

        withdrawBtn.disabled = true;

        withdrawInput.addEventListener("input", function () {
            let amount = parseFloat(this.value);

            if (!amount || amount <= 0) {
                withdrawBtn.disabled = true;
                amountError.textContent = "Please enter a valid amount.";
                amountError.classList.remove("d-none");
            } else if (amount > walletBalance) {
                withdrawBtn.disabled = true;
                amountError.textContent = "Insufficient funds. Available balance: ₹" + walletBalance;
                amountError.classList.remove("d-none");
            } else if ((walletBalance - amount) < walletMin) {
                withdrawBtn.disabled = true;
                amountError.textContent = "You must maintain at least ₹" + walletMin + " in your wallet.";
                amountError.classList.remove("d-none");
            } else {
                withdrawBtn.disabled = false;
                amountError.textContent = "";
                amountError.classList.add("d-none");
            }
        });

        withdrawBtn.addEventListener("click", function () {
            let providerId = this.getAttribute("data-id");
            let amount = parseFloat(withdrawInput.value);

            if (!providerId || !amount || amount <= 0) {
                Swal.fire({
                    icon: "error",
                    title: "Missing",
                    text: "Please enter a valid amount."
                });
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to withdraw now?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Withdraw",
                cancelButtonText: "Cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    withdrawNow(providerId, amount);
                }
            });
        });

        function withdrawNow(providerId, amount) {
            $.ajax({
                url: "<?= base_url('provider/wallet/withdraw_request') ?>",
                method: "POST",
                data: { provider_id: providerId, amount: amount },
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        withdrawInput.value = "";
                        withdrawBtn.disabled = true;
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Failed",
                            text: res.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Something went wrong. Please try again."
                    });
                }
            });
        }
    });


</script>