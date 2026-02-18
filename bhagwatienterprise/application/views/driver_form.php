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
            <li class="breadcrumb-item active" aria-current="page">Add Driver</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <div class="card-body p-4">
        <h5 class="card-title">Add Driver</h5>
        <hr>

       <form id="driverForm" method="post" enctype="multipart/form-data" novalidate>
  <!-- Driver Name -->
  <div class="mb-3">
    <label for="driver_name" class="form-label">Driver Name</label>
    <input type="text" name="driver_name" class="form-control" id="driver_name" placeholder="Enter driver name" required>
    <div class="invalid-feedback">Please enter driver name.</div>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Driver Email</label>
    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
    <div class="invalid-feedback">Please enter email.</div>
  </div>

  <!-- Mobile -->
  <div class="mb-3">
    <label for="mobile" class="form-label">Mobile Number</label>
    <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile number" maxlength="10" required pattern="[0-9]{10}">
    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
  </div>
  <div class="mb-3">
    <label for="mobile" class="form-label">Location</label>
    <input type="text" name="location" class="form-control" id="mobile" placeholder="Enter location">
    <div class="invalid-feedback">Please enter a valid location.</div>
  </div>

  <div class="mb-3">
    <label for="company_id" class="form-label">Select Company</label>
    <select name="company_id" id="company_id" class="form-select" required>
      <option value="">-- Select Company --</option>
      <?php if (!empty($companies)): ?>
        <?php foreach ($companies as $company): ?>
          <option value="<?= $company->id; ?>">
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
    <input type="text" name="vehicle_name" class="form-control" id="vehicle_name" placeholder="Enter vehicle name" required>
    <div class="invalid-feedback">Please enter vehicle name.</div>
  </div>

  <!-- Vehicle Number -->
  <div class="mb-3">
    <label for="vehicle_number" class="form-label">Vehicle Number</label>
    <input type="text" name="vehicle_number" class="form-control" id="vehicle_number" placeholder="Enter vehicle number" required>
    <div class="invalid-feedback">Please enter vehicle number.</div>
  </div>

  <!-- Licence Number -->
  <div class="mb-3">
    <label for="licence_number" class="form-label">Licence Number</label>
    <input type="text" name="licence_number" class="form-control" id="licence_number" placeholder="Enter licence number" required>
    <div class="invalid-feedback">Please enter licence number.</div>
  </div>

  <!-- Profile Image -->
  <div class="mb-3">
    <label for="profile_image" class="form-label">Driver Profile Image</label>
    <input type="file" name="profile_image" class="form-control" id="profile_image" accept="image/png, image/jpeg, image/jpg" required>
    <div class="invalid-feedback">Please upload a valid profile image (JPG, PNG, JPEG).</div>
    <div class="mt-2 text-center">
      <img id="profilePreview" src="#" alt="Profile Preview" class="img-thumbnail" style="display:none; max-width:120px; border-radius:10px;">
    </div>
  </div>

  <!-- Password -->
  <div class="mb-3 position-relative">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
      <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" minlength="6" required>
      <button type="button" class="btn btn-outline-secondary" id="togglePassword">
        <i class="bx bx-show"></i>
      </button>
      <div class="invalid-feedback">Password must be at least 6 characters long.</div>
    </div>
  </div>

  <!-- Submit -->
  <div class="mb-3">
    <button class="btn btn-success w-100" id="submit_driver" type="submit">Save Driver</button>
  </div>
</form>


      </div>
    </div>

  </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- JavaScript -->
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
  const passwordInput = document.getElementById('password');
  const icon = this.querySelector('i');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.classList.remove('bx-show');
    icon.classList.add('bx-hide');
  } else {
    passwordInput.type = 'password';
    icon.classList.remove('bx-hide');
    icon.classList.add('bx-show');
  }
});

$(document).ready(function() {
  $('#driverForm').on('submit', function(e) {
    e.preventDefault(); // Prevent normal form submit

    var formData = new FormData(this); // Create FormData object (includes files automatically)

    $.ajax({
      url: '<?= base_url('driver/save_driver'); ?>', // <-- Change to your controller path
      type: 'POST',
      data: formData,
      contentType: false,  // Required for file upload
      processData: false,  // Required for file upload
      dataType: 'json',
      beforeSend: function() {
        $('#submit_driver').prop('disabled', true).text('Saving...');
      },
      success: function(response) {
        $('#submit_driver').prop('disabled', false).text('Save Driver');
        if (response.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message
          });
          $('#driverForm')[0].reset();
          $('#profilePreview').hide();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.message
          });
        }
      },
      error: function() {
        $('#submit_driver').prop('disabled', false).text('Save Driver');
        Swal.fire({
          icon: 'error',
          title: 'Server Error',
          text: 'Something went wrong. Please try again.'
        });
      }
    });
  });
});
document.getElementById('profile_image').addEventListener('change', function (e) {
  const file = e.target.files[0];
  const preview = document.getElementById('profilePreview');

  if (file) {
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!validTypes.includes(file.type)) {
      alert('Invalid file type. Please upload JPG, JPEG, or PNG image.');
      e.target.value = '';
      preview.style.display = 'none';
      return;
    }

    if (file.size > 2 * 1024 * 1024) {
      alert('File size exceeds 2 MB. Please upload a smaller image.');
      e.target.value = '';
      preview.style.display = 'none';
      return;
    }

    const reader = new FileReader();
    reader.onload = function (event) {
      preview.src = event.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  }
});
</script>












