<div class="page-wrapper">
  <div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Trips</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item">
              <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Trip</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="card">
      <div class="card-body p-4">
        <h5 class="card-title">Edit Trip Details</h5>
        <hr>

        <form id="tripEditForm" method="post" novalidate>
          <input type="hidden" name="id" value="<?= isset($trip['id']) ? $trip['id'] : ''; ?>">

          <div class="row g-3">
            <!-- Driver Name -->
            <div class="col-md-4">
              <label for="driver_name" class="form-label">Driver Name</label>
              <input type="text" name="driver_name" class="form-control" id="driver_name"
                     placeholder="Enter driver name"
                     value="<?= isset($trip['driver_name']) ? $trip['driver_name'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter driver name.</div>
            </div>

            <!-- Vehicle Name -->
            <div class="col-md-4">
              <label for="vehicle_name" class="form-label">Vehicle Name</label>
              <input type="text" name="vehicle_name" class="form-control" id="vehicle_name"
                     placeholder="Enter vehicle name"
                     value="<?= isset($trip['vehicle_name']) ? $trip['vehicle_name'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter vehicle name.</div>
            </div>

            <!-- Vehicle Number -->
            <div class="col-md-4">
              <label for="vehicle_number" class="form-label">Vehicle Number</label>
              <input type="text" name="vehicle_number" class="form-control" id="vehicle_number"
                     placeholder="Enter vehicle number"
                     value="<?= isset($trip['vehicle_number']) ? $trip['vehicle_number'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter vehicle number.</div>
            </div>

            <!-- Licence Number -->
            <div class="col-md-4">
              <label for="licence_number" class="form-label">Licence Number</label>
              <input type="text" name="licence_number" class="form-control" id="licence_number"
                     placeholder="Enter licence number"
                     value="<?= isset($trip['licence_number']) ? $trip['licence_number'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter licence number.</div>
            </div>

            <!-- Driver Mobile -->
            <div class="col-md-4">
              <label for="driver_mobile" class="form-label">Driver Mobile</label>
              <input type="text" name="driver_mobile" class="form-control" id="driver_mobile"
                     placeholder="Enter driver mobile" maxlength="10"
                     value="<?= isset($trip['driver_mobile']) ? $trip['driver_mobile'] : ''; ?>" required pattern="[0-9]{10}">
              <div class="invalid-feedback">Please enter valid 10-digit mobile number.</div>
            </div>

            <!-- Trip Start Date -->
            <div class="col-md-4">
              <label for="trip_date" class="form-label">Trip Start Date</label>
              <input type="date" name="trip_date" class="form-control" id="trip_date"
                     value="<?= isset($trip['trip_date']) ? $trip['trip_date'] : ''; ?>" required>
              <div class="invalid-feedback">Please select trip date.</div>
            </div>

            <!-- From Location -->
            <div class="col-md-6">
              <label for="from_location" class="form-label">From Location</label>
              <input type="text" name="from_location" class="form-control" id="from_location"
                     placeholder="Enter starting location"
                     value="<?= isset($trip['from_location']) ? $trip['from_location'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter from location.</div>
            </div>

            <!-- To Location -->
            <div class="col-md-6">
              <label for="to_location" class="form-label">To Location</label>
              <input type="text" name="to_location" class="form-control" id="to_location"
                     placeholder="Enter destination location"
                     value="<?= isset($trip['to_location']) ? $trip['to_location'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter to location.</div>
            </div>

            <!-- Start KM -->
            <div class="col-md-3">
              <label for="start_km" class="form-label">Start KM</label>
              <input type="number" step="0.01" name="start_km" class="form-control" id="start_km"
                     placeholder="Enter start km"
                     value="<?= isset($trip['start_km']) ? $trip['start_km'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter start km.</div>
            </div>

            <!-- End KM -->
            <div class="col-md-3">
              <label for="end_km" class="form-label">End KM</label>
              <input type="number" step="0.01" name="end_km" class="form-control" id="end_km"
                     placeholder="Enter end km"
                     value="<?= isset($trip['end_km']) ? $trip['end_km'] : ''; ?>">
              <div class="invalid-feedback">Please enter end km.</div>
            </div>

            <!-- Start Time -->
            <div class="col-md-3">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="time" name="start_time" class="form-control" id="start_time"
                     value="<?= isset($trip['start_time']) ? $trip['start_time'] : ''; ?>" required>
              <div class="invalid-feedback">Please select start time.</div>
            </div>

            <!-- End Time -->
            <div class="col-md-3">
              <label for="end_time" class="form-label">End Time</label>
              <input type="time" name="end_time" class="form-control" id="end_time"
                     value="<?= isset($trip['end_time']) ? $trip['end_time'] : ''; ?>">
              <div class="invalid-feedback">Please select end time.</div>
            </div>

            <!-- Customer Name -->
            <div class="col-md-6">
              <label for="customer_name" class="form-label">Customer Name</label>
              <input type="text" name="customer_name" class="form-control" id="customer_name"
                     placeholder="Enter customer name"
                     value="<?= isset($trip['customer_name']) ? $trip['customer_name'] : ''; ?>" required>
              <div class="invalid-feedback">Please enter customer name.</div>
            </div>

            <!-- Customer Mobile -->
            <div class="col-md-6">
              <label for="customer_mobile" class="form-label">Customer Mobile</label>
              <input type="text" name="customer_mobile" class="form-control" id="customer_mobile"
                     placeholder="Enter customer mobile" maxlength="10"
                     value="<?= isset($trip['customer_mobile']) ? $trip['customer_mobile'] : ''; ?>" required pattern="[0-9]{10}">
              <div class="invalid-feedback">Please enter valid customer mobile.</div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-4">
            <button class="btn btn-primary w-100" type="submit" id="update_trip">Update Trip</button>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
$(document).ready(function () {

  $('#tripEditForm').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    if (!form.checkValidity()) {
      e.stopPropagation();
      $(form).addClass('was-validated');
      return;
    }

    $.ajax({
      url: "<?= base_url('driver/update_trip') ?>",  
      type: "POST",
      data: $(form).serialize(),
      dataType: "json",
      beforeSend: function () {
        $('#update_trip').prop('disabled', true).text('Updating...');
      },
      success: function (response) {
        $('#update_trip').prop('disabled', false).text('Update Trip');

        if (response.status) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "<?= base_url('booking') ?>"; 
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function () {
        $('#update_trip').prop('disabled', false).text('Update Trip');
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Something went wrong. Please try again.'
        });
      }
    });
  });

});
</script>

