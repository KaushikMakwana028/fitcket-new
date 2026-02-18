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
                        <li class="breadcrumb-item active" aria-current="page">Offer Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <!-- Card -->
        <div class="card">
            <div class="card-body p-4">

                <!-- Title -->
                <h5 class="card-title">Offer Setting</h5>
                <hr>

                <!-- Form -->
                <div class="form-body mt-4">
                    <form id="OfferForm" method="post" novalidate>
                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="<?= isset($offer['id']) ? $offer['id'] : '' ?>">

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">
                                Offer (%) <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="offer_percent"
                                    value="<?= isset($offer['offer_percent']) ? $offer['offer_percent'] : '0' ?>"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-5 col-form-label">
                                Minimum Amount for Offer <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" name="min_amount"
                                    value="<?= isset($offer['min_amount']) ? $offer['min_amount'] : '0.00' ?>"
                                    required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-success px-5 me-4">Update Offer</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Form -->

            </div>
        </div>
        <!-- End Card -->

        <!-- Persistent Note (red background) -->
        <div class="note-box bg-danger text-white mt-4" role="note" aria-label="Important note">
            <strong class="note-title">Note:</strong>
            Please double-check the offer settings. Incorrect values may impact discounts and payouts.
        </div>

    </div>
</div>
</div>

<style>
    /* Red note box for persistent note */
    .note-box {
        padding: 16px 18px;
        border-radius: 8px;
        font-weight: 500;
    }

    .note-box .note-title {
        margin-right: 6px;
    }
</style>
