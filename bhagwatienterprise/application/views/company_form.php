<div class="page-wrapper">
  <div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Company</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item">
              <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Add Company</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <div class="card-body p-4">
        <h5 class="card-title">Add Company</h5>
        <hr>

        <form id="companyForm" method="post" novalidate>
          <!-- Driver Name -->
          <div class="mb-3">
            <label for="driver_name" class="form-label">company Name</label>
            <input type="text" name="company_name" class="form-control" id="company_name" placeholder="Enter company name" required>
            <div class="invalid-feedback">Please enter company name.</div>
          </div>

        

          <!-- Submit -->
          <div class="mb-3">
            <button class="btn btn-success w-100" id="submit_driver" type="submit">Save Company</button>
          </div>
        </form>

      </div>
    </div>

  </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
$(document).ready(function () {
  $('#companyForm').on('submit', function (e) {
    e.preventDefault();

    // Bootstrap validation check
    if (!this.checkValidity()) {
      e.stopPropagation();
      $(this).addClass('was-validated');
      return;
    }

    $.ajax({
      url: "<?= base_url('driver/save_company'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function () {
        Swal.fire({
          title: 'Saving...',
          text: 'Please wait while we save the company details.',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
      },
      success: function (response) {
        Swal.close();
        if (response.status === "success") {
          Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: response.message,
            confirmButtonColor: '#28a745'
          }).then(() => {
            $('#companyForm')[0].reset();
            $('#companyForm').removeClass('was-validated');
          });
        } else if (response.status === "exists") {
          Swal.fire({
            icon: 'warning',
            title: 'Already Exists',
            text: response.message,
            confirmButtonColor: '#ffc107'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#dc3545'
          });
        }
      },
      error: function () {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Server Error!',
          text: 'Please check your internet connection or contact support.',
          confirmButtonColor: '#dc3545'
        });
      }
    });
  });
});
</script>
