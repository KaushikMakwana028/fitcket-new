<div class="page-wrapper">
  <div class="page-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Drivers</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item">
              <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Driver</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <div class="card-body p-4">
        <h5 class="card-title">Edit Driver</h5>
        <hr>

        <form id="driverEditForm" method="post" enctype="multipart/form-data" novalidate>
  <input type="hidden" name="id" value="<?= isset($driver['id']) ? $driver['id'] : ''; ?>">
  <input type="hidden" name="old_image" value="<?= isset($driver['profile_image']) ? $driver['profile_image'] : ''; ?>">

  <!-- Driver Name -->
  <div class="mb-3">
    <label for="driver_name" class="form-label">Driver Name</label>
    <input type="text" name="driver_name" class="form-control" id="driver_name"
           value="<?= isset($driver['name']) ? $driver['name'] : ''; ?>" required>
    <div class="invalid-feedback">Please enter driver name.</div>
  </div>

  <!-- Driver Email -->
  <div class="mb-3">
    <label for="email" class="form-label">Driver Email</label>
    <input type="email" name="email" class="form-control" id="email"
           value="<?= isset($driver['email']) ? $driver['email'] : ''; ?>" required>
    <div class="invalid-feedback">Please enter email.</div>
  </div>

  <!-- Mobile -->
  <div class="mb-3">
    <label for="mobile" class="form-label">Mobile Number</label>
    <input type="text" name="mobile" class="form-control" id="mobile"
           value="<?= isset($driver['mobile']) ? $driver['mobile'] : ''; ?>"
           maxlength="10" required pattern="[0-9]{10}">
    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
  </div>
  <!-- Email -->
  <div class="mb-3">
    <label for="locaiton" class="form-label">Location</label>
    <input type="text" name="location" class="form-control" id="location"
           value="<?= isset($driver['location']) ? $driver['location'] : ''; ?>">
    <div class="invalid-feedback">Please enter a valid locaiton.</div>
  </div>

  <!-- Company -->
  <div class="mb-3">
    <label for="company_id" class="form-label">Select Company</label>
    <select name="company_id" id="company_id" class="form-select" required>
      <option value="">-- Select Company --</option>
      <?php if (!empty($companies)): ?>
        <?php foreach ($companies as $company): ?>
          <option value="<?= $company->id; ?>"
            <?= (isset($driver['company_id']) && $driver['company_id'] == $company->id) ? 'selected' : ''; ?>>
            <?= ucfirst($company->company_name); ?>
          </option>
        <?php endforeach; ?>
      <?php endif; ?>
    </select>
    <div class="invalid-feedback">Please select a company.</div>
  </div>

  <!-- Vehicle Name -->
  <div class="mb-3">
    <label for="vehicle_name" class="form-label">Vehicle Name</label>
    <input type="text" name="vehicle_name" class="form-control" id="vehicle_name"
           value="<?= isset($driver['vehical_name']) ? $driver['vehical_name'] : ''; ?>" required>
    <div class="invalid-feedback">Please enter vehicle name.</div>
  </div>

  <!-- Vehicle Number -->
  <div class="mb-3">
    <label for="vehicle_number" class="form-label">Vehicle Number</label>
    <input type="text" name="vehicle_number" class="form-control" id="vehicle_number"
           value="<?= isset($driver['vehical_number']) ? $driver['vehical_number'] : ''; ?>" required>
    <div class="invalid-feedback">Please enter vehicle number.</div>
  </div>

  <!-- Licence Number -->
  <div class="mb-3">
    <label for="licence_number" class="form-label">Licence Number</label>
    <input type="text" name="licence_number" class="form-control" id="licence_number"
           value="<?= isset($driver['licence_no']) ? $driver['licence_no'] : ''; ?>" required>
    <div class="invalid-feedback">Please enter licence number.</div>
  </div>

  <!-- Profile Image -->
  <div class="mb-3">
    <label for="profile_image" class="form-label">Profile Image</label>
    <input type="file" name="profile_image" class="form-control" id="profile_image" accept="image/png, image/jpeg, image/jpg">
    <div class="mt-2 text-center">
      <?php if (!empty($driver['profile_image'])): ?>
        <img id="profilePreview" 
     src="<?= base_url($driver['profile_image']); ?>" 
     class="img-thumbnail" 
     style="max-width:120px; border-radius:10px;">

      <?php else: ?>
        <img id="profilePreview" src="#" alt="Profile Preview" style="display:none; max-width:120px; border-radius:10px;">
      <?php endif; ?>
    </div>
  </div>

  <!-- Password -->
  <div class="mb-3 position-relative">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
      <input type="password" name="password" class="form-control" id="password" minlength="6">
      <button type="button" class="btn btn-outline-secondary" id="togglePassword">
        <i class="bx bx-show"></i>
      </button>
    </div>
    <small class="text-muted">Leave blank to keep current password.</small>
  </div>

  <!-- Submit -->
  <div class="mb-3">
    <button class="btn btn-primary w-100" id="update_driver" type="submit">Update Driver</button>
  </div>
</form>


      </div>
    </div>

  </div>
</div>


<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
$(document).ready(function() {
  $('#driverEditForm').on('submit', function(e) {
    e.preventDefault();

    const form = this;
    if (!form.checkValidity()) {
      e.stopPropagation();
      $(form).addClass('was-validated');
      return false;
    }

    const formData = new FormData(form);

    $.ajax({
      url: "<?= base_url('driver/update_driver'); ?>",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      beforeSend: function() {
        Swal.fire({
          title: 'Updating...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
      },
      success: function(res) {
        Swal.close();
        if (res.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Driver Updated!',
            text: res.message,
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            window.location.href = "<?= base_url('driver'); ?>";
          });
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      },
      error: function() {
        Swal.close();
        Swal.fire('Server Error', 'Unable to update driver now.', 'error');
      }
    });
  });

  // Live image preview
  $('#profile_image').on('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#profilePreview').attr('src', e.target.result).show();
      };
      reader.readAsDataURL(file);
    }
  });
});
</script>
