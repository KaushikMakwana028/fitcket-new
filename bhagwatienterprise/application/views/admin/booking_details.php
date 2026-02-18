<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><a href="">Bookings</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bookings Details</li>
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
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="w-100">
                                        <!-- Full Name -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Full Name</div>
                                            <div class="col text-start"><?= $customer->full_name ?></div>
                                        </div>
                                        <hr>

                                        <!-- Mobile Number -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Mobile Number</div>
                                            <div class="col text-start">+91<?= $customer->mobile_number ?></div>
                                        </div>
                                        <hr>

                                        <!-- Location -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Location</div>
                                            <div class="col text-start"><?= $customer->location ?></div>
                                        </div>
                                        <hr>

                                        <!-- Tag -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Tag</div>
                                            <div class="col text-start">
    <?php
    $tag = strtolower(trim($customer->tag));
    if ($tag == 'high-value') {
        echo '<div class="d-flex align-items-center text-success">
                <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                <span>High-value</span>
              </div>';
    } elseif ($tag == 'repeat') {
        echo '<div class="d-flex align-items-center text-warning">
                <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                <span>Repeat</span>
              </div>';
    } else {
        echo '<div class="d-flex align-items-center text-danger">
                <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                <span>New</span>
              </div>';
    }
    ?>
</div>

                                        </div>
                                        <hr>

                                        <!-- Order Information -->
                                        <h5 class="text-center fw-bold my-5">Booking Information</h5>

                                        <?php
                                        $source_colors = [
                                            'zomato' => 'text-danger',
                                            'swiggy' => 'text-warning',
                                            'eazydiner' => 'text-info',
                                            'walkin' => 'text-success',
                                        ];
                                        $source_color = $source_colors[strtolower($booking->source)] ?? 'text-muted';
                                        ?>
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Booking Source</div>
                                            <div class="col text-start">
                                                <div class="d-flex align-items-center <?= $source_color ?>">
                                                    <i
                                                        class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                                    <span><?= ucfirst($booking->source) ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Booking Date -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Booking Date</div>
                                            <div class="col text-start"><?= $booking->booking_date ?></div>
                                        </div>
                                        <hr>

                                        <!-- Booking Status -->
                                        <?php
                                        $status_class = strtolower($booking->status) === 'confirmed' ? 'text-success bg-light-success' : 'text-danger bg-light-danger';
                                        $status_label = ucfirst($booking->status);
                                        ?>
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Booking Status</div>
                                            <div class="col text-start">
                                                <div
                                                    class="badge rounded-pill <?= $status_class ?> p-2 text-uppercase px-3">
                                                    <i class="bx bxs-circle me-1"></i><?= $status_label ?>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- Total Spent -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Total Spent</div>
                                            <div class="col text-start">₹<?= number_format(10000) ?></div>
                                        </div>
                                        <hr>

                                        <!-- Party Size -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Party Size</div>
                                            <div class="col text-start"><?= $booking->party_size ?></div>
                                        </div>
                                        <hr>

                                        <!-- Special Notes -->
                                        <div class="row my-2">
                                            <div class="col d-flex fw-bold">Special Notes</div>
                                            <div class="col text-start">
                                                <?= !empty($booking->special_notes) ? $booking->special_notes : 'N/A' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="w-100 d-flex justify-content-between mt-4">
                                        <a href="https://wa.me/91<?= $customer->mobile_number ?>" target="_blank"
                                            class="btn btn-success w-100 radius-30 fw-bold shadow-sm me-2">
                                            <i class="lni lni-whatsapp"></i> <span>WhatsApp</span>
                                        </a>
                                        <a href="tel:+91<?= $customer->mobile_number ?>"
                                            class="btn btn-primary w-100 radius-30 fw-bold shadow-sm ms-2">
                                            <i class="lni lni-phone"></i> <span>Call</span>
                                        </a>
                                    </div>

                                </div> <!-- end center box -->
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end main-body -->
        </div> <!-- end container -->
    </div> <!-- end page-content -->
</div> <!-- end page-wrapper -->