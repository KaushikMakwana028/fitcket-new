<style>
    .radio-pill-group {
        background-color: #f1f3f5;
        border-radius: 9999px;
        display: flex;
        justify-content: space-between;
        padding: 0px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .radio-pill-group input[type="radio"] {
        display: none;
    }

    .radio-pill-group label {
        flex: 1;
        text-align: center;
        padding: 12px 0;
        border-radius: 9999px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .radio-pill-group input[type="radio"]:checked+label {
        background-color: #3b6ef5;
        color: white;
        box-shadow: 0 0 10px rgba(59, 110, 245, 0.4);
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Event</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Event</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Event</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form id="eventForm" method="post">
                                <!-- <div class="row">
                                    <div class="col-12 px-0 mb-5">
                                        <div class="radio-pill-group">
                                            <input type="radio" id="new_cust_form" name="newRedio" value="new" checked>
                                            <label for="new_cust_form">New Customer</label>
                                            <input type="radio" id="exe_cust_form" name="newRedio" value="exesting">
                                            <label for="exe_cust_form">Exsting Customer</label>
                                         </div>
                                    </div>
                                </div> -->
                                <!-- <div class="mb-3 " id="cust_section" style="display:none;">
                                    <label for="inputProductDescription" class="form-label">Please Select
                                        Customer</label>
                                    <select class="form-control" id="cust_id" name="customer_id">
                                        <option value="">Select Customer</option>
                                    </select>
                                    <div class="invalid-feedback">Please select customer id.</div>
                                </div> -->

                                <div class="mb-3">
                                    <label for="cust_name" class="form-label">Event Name</label>
                                    <input type="text" name="name" class="form-control" id="cust_name"
                                        value="<?= htmlspecialchars($event->name) ?>" placeholder="Enter name" required>
                                </div>
                                <!-- Mobile -->
                                <div class="mb-3">
                                    <label for="mob" class="form-label">Mobile</label>
                                    <input type="text" name="mobile" class="form-control" id="mob"
                                        value="<?= htmlspecialchars($event->mobile) ?>"
                                        placeholder="Enter mobile number" required>
                                </div>
                                <!-- <div class="mb-3">
                                    <label for="customerPhone" class="form-label">Customer Location</label>
                                    <input type="text" name="location" class="form-control" id="location"
                                        placeholder="Enter location" required>
                                </div> -->

                                <!-- Booking Date -->
                                <!-- Booking Date -->
                                <div class="mb-3">
                                    <label for="bookingDate" class="form-label">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control" id="bookingDate"
                                        value="<?= $event->booking_date ?>" required>
                                </div>

                                <!-- Package Selection -->
                                <div class="mb-3">
                                    <label for="package" class="form-label">Package Selection</label>
                                    <select class="form-select" name="package" id="package" required>
                                        <option value="">Select Package</option>
                                        <?php if (!empty($package)): ?>
                                            <?php foreach ($package as $p): ?>
                                                <option value="<?= $p->id ?>" <?= $p->id == $event->package_id ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($p->name) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                               <!-- Party Size -->
<div class="mb-3">
    <label for="partySize" class="form-label">Number of Attendees</label>
    <input type="number" name="size" class="form-control" id="partySize" min="1"
        value="<?= $event->attendees ?>" placeholder="Enter number of guests" required>
</div>

                               <!-- Special Notes -->
<div class="mb-3">
    <label for="notes" class="form-label">Special Notes</label>
    <textarea name="special_notes" class="form-control" id="notes"
        placeholder="Any special requests..."><?= htmlspecialchars($event->special_notes) ?></textarea>
</div>
                               <!-- Booking Status -->
<div class="mb-3">
    <label for="status" class="form-label">Payment Status</label>
    <select class="form-select" name="status" id="status" required>
        <option value="paid" <?= $event->payment_status === 'paid' ? 'selected' : '' ?>>Paid</option>
        <option value="partial" <?= $event->payment_status === 'partial' ? 'selected' : '' ?>>Partial</option>
        <option value="pending" <?= $event->payment_status === 'pending' ? 'selected' : '' ?>>Pending</option>
    </select>
</div>
<input type="hidden" name="event_id" value="<?= $event->id ?>">

                                <!-- <div class="mb-3">
                                    <label for="customerPhone" class="form-label">Total spent</label>
                                    <input type="text" name="phone" class="form-control" id="customerPhone"
                                        placeholder="Enter amount" required>
                                </div> -->
                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button class="btn btn-success w-100" id="update_event" type="submit">Update
                                        Event</button>
                                </div>
                            </form>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>