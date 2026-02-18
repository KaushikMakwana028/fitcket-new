<?php
// Assume $event and $package are passed to this view.
?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><a href="">Bookings</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="">
            <div class="main-body">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center fw-bold my-5">Customer Information</h5>
                                <div class="d-flex flex-column">
                                    <div class="w-100">

                                        <!-- Full Name -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Full Name</div>
                                            <div class="col text-start"><?= $event->name ?></div>
                                        </div>
                                        <hr>

                                        <!-- Mobile Number -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Mobile Number</div>
                                            <div class="col text-start">+91<?= $event->mobile ?></div>
                                        </div>
                                        <hr>

                                        <!-- Booking Date -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Booking Date</div>
                                            <div class="col text-start"><?= $event->booking_date ?></div>
                                        </div>
                                        <hr>

                                        <!-- Package Name -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Package</div>
                                            <div class="col text-start"><?= $package->name ?></div>
                                        </div>
                                        <hr>

                                        <!-- Package Price -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Total Price</div>
                                            <div class="col text-start">₹<?= number_format($package->price) ?></div>
                                        </div>
                                        <hr>

                                        <!-- Inclusions -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Inclusions</div>
                                            <div class="col text-start" style="white-space: pre-line;">
                                                <?= $package->inclusion ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- Attendees -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Attendees</div>
                                            <div class="col text-start"><?= $event->attendees ?></div>
                                        </div>
                                        <hr>

                                        <!-- Payment Status -->
                                        <?php
                                        $paymentClass = strtolower($event->payment_status) === 'paid' ? 'text-success bg-light-success' :
                                                        (strtolower($event->payment_status) === 'partial' ? 'text-info bg-light-info' : 'text-danger bg-light-danger');
                                        ?>
                                        <div class="row my-2">
                                            <div class="col fw-bold">Payment Status</div>
                                            <div class="col text-start">
                                                <div class="badge rounded-pill <?= $paymentClass ?> p-2 text-uppercase px-3">
                                                    <i class="bx bxs-circle me-1"></i><?= ucfirst($event->payment_status) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <!-- Special Notes -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Special Notes</div>
                                            <div class="col text-start"><?= !empty($event->special_notes) ? $event->special_notes : 'N/A' ?></div>
                                        </div>
                                        <hr>

                                        <!-- Created On -->
                                        <div class="row my-2">
                                            <div class="col fw-bold">Created On</div>
                                            <div class="col text-start"><?= date("d M Y, h:i A", strtotime($event->created_on)) ?></div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="w-100 d-flex justify-content-between mt-4">
                                            <a href="https://wa.me/91<?= $event->mobile ?>" target="_blank"
                                                class="btn btn-success w-100 radius-30 fw-bold shadow-sm me-2">
                                                <i class="lni lni-whatsapp"></i> <span>WhatsApp</span>
                                            </a>
                                            <a href="tel:+91<?= $event->mobile ?>"
                                                class="btn btn-primary w-100 radius-30 fw-bold shadow-sm ms-2">
                                                <i class="lni lni-phone"></i> <span>Call</span>
                                            </a>
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
