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
                        <li class="breadcrumb-item active" aria-current="page">Payment Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Card -->
        <div class="card">
            <div class="card-body p-4">

                <!-- Title -->
                <h5 class="card-title">Payment Setting</h5>
                <hr>

                <!-- Form -->
                <div class="form-body mt-4">
                    <form id="PaymentForm" method="post" novalidate>
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?= isset($payment['id']) ? $payment['id'] : '' ?>">

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">
                                Wallet Minimum Amount to Maintain <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="wallet_min"
                                    value="<?= isset($payment['wallet_min']) ? $payment['wallet_min'] : '0.00' ?>"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">
                                Commission To Fitcket (%) <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="commission"
                                    value="<?= isset($payment['commission']) ? $payment['commission'] : '0.00' ?>"
                                    required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-success px-5 me-4">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- End Form -->

            </div>
        </div>
        <!-- End Card -->

        <!-- Persistent Note (not an alert) -->
        <div class="note-box bg-danger text-dark mt-4" role="note" aria-label="Important note">
            <strong class="note-title">Note:</strong>
            This information will directly impact the wallet payment, Rewards, payouts, and commission to Fitcket.
            <br>Please double check before you update it.
        </div>

    </div>
</div>
</div>
<style>
    /* Neutral note box (non-alert, not red) */
    .note-box {
        background: #f8fafc;
        /* soft neutral background */
        border: 1px solid #e5e7eb;
        /* light border */

        color: #334155;
        /* readable dark slate */
        padding: 16px 18px;
        border-radius: 8px;
    }

    .note-box .note-title {
        font-weight: 600;
        margin-right: 6px;
    }
</style>