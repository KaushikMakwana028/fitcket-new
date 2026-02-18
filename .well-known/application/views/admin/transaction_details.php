<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard'); ?>">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Settlement Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Settlement Card -->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Transaction Settlement</h5>
                <hr>

                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">

                            <!-- Settlement Form -->
                            <form id="settlementForm" method="post">

                               

                                <!-- Recipient Bank Details -->
                                <div class="mb-3">
                                    <label class="form-label">Recipient Name</label>
                                    <input type="text" class="form-control" value="<?= $recipient->recipient_name; ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" value="<?= $recipient->phone_number; ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" value="<?= $recipient->bank_name; ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" value="<?= $recipient->account_number; ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control" value="<?= $recipient->ifsc_code; ?>" readonly>
                                </div>

                                <!-- Transaction Info -->
                                <div class="mb-3">
                                    <label class="form-label">Transection Amount</label>
                                    <input type="text" class="form-control" value="₹ <?= $transaction->amount; ?>" readonly>
                                        <input type="hidden" name="transaction_id" value="<?= $transaction->id; ?>">

                                </div>

                                <!-- Enter Settlement Amount -->
                                <?php if ($transaction->settled == 0): ?>
                                    <div class="mb-3">
                                        <label class="form-label">Settlement Amount</label>
                                        <input type="number" name="settled_amount" class="form-control" placeholder="Enter settlement amount" id="amount">
                                    </div>
                                <?php else: ?>
                                    <div class="mb-3">
                                        <label class="form-label">Settled Amount</label>
                                        <input type="text" class="form-control" value="₹ <?= $transaction->settled_amount; ?>" readonly>
                                    </div>
                                <?php endif; ?>

                                <!-- Hidden Transaction ID -->
                                <input type="hidden" name="transaction_id" value="<?= $transaction->id; ?>">

                                <!-- Submit Button -->
                                <?php if ($transaction->settled == 0): ?>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bx bx-check-circle"></i> Settle Payment
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-success text-center">
                                        ✅ Payment Already Settled on <?= date("d M Y, h:i A", strtotime($transaction->settled_at)); ?>
                                    </div>
                                <?php endif; ?>

                            </form>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>
