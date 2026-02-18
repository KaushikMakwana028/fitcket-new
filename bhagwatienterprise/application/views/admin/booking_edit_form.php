<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Bookings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Booking</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Booking</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form id="bookingForm" method="post" action="<?= base_url('admin/bookings/update/' . $booking->id) ?>">
                                <input type="hidden" name="id" value="<?= $booking->id ?>">
                                <input type="hidden" name="customer_id" value="<?= $booking->customer_id ?>">

                                <div class="mb-3">
                                    <label for="bookingDate" class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control" id="bookingDate" value="<?= $booking->booking_date ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="source" class="form-label">Source</label>
                                    <select name="source" class="form-control" id="source" required>
                                        <option value="">-- Select Source --</option>
                                        <option value="swiggy" <?= $booking->source == 'swiggy' ? 'selected' : '' ?>>Swiggy</option>
                                        <option value="zomato" <?= $booking->source == 'zomato' ? 'selected' : '' ?>>Zomato</option>
                                        <option value="eazydiner" <?= $booking->source == 'eazydiner' ? 'selected' : '' ?>>EazyDiner</option>
                                        <option value="walkin" <?= $booking->source == 'walkin' ? 'selected' : '' ?>>Walk-in</option>
                                        <option value="website" <?= $booking->source == 'website' ? 'selected' : '' ?>>Website</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="partySize" class="form-label">Party Size</label>
                                    <input type="number" name="party_size" class="form-control" id="partySize" value="<?= $booking->party_size ?>" placeholder="Enter party size">
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="confirmed" <?= $booking->status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="pending" <?= $booking->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="cancelled" <?= $booking->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="specialNotes" class="form-label">Special Notes</label>
                                    <textarea name="special_notes" class="form-control" id="specialNotes" placeholder="Enter any special notes"><?= htmlspecialchars($booking->special_notes) ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" id="submit_booking" type="submit">Update Booking</button>
                                </div>
                            </form>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>
