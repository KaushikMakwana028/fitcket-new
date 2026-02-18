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
            <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <div class="card-body p-4">
        <h5 class="card-title">Edit Company</h5>
        <hr>

        <form id="companyEditForm" method="post" novalidate>
          <input type="hidden" name="id" value="<?= isset($company->id) ? $company->id : ''; ?>">

          <!-- Company Name -->
          <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" id="company_name" 
                   placeholder="Enter company name" 
                   value="<?= isset($company->company_name) ? $company->company_name : ''; ?>" required>
            <div class="invalid-feedback">Please enter company name.</div>
          </div>

          <!-- Status -->
          <div class="mb-3">
            <label for="isActive" class="form-label">Status</label>
            <select name="isActive" id="isActive" class="form-select" required>
              <option value="1" <?= (isset($company->isActive) && $company->isActive == 1) ? 'selected' : ''; ?>>Active</option>
              <option value="0" <?= (isset($company->isActive) && $company->isActive == 0) ? 'selected' : ''; ?>>Inactive</option>
            </select>
            <div class="invalid-feedback">Please select status.</div>
          </div>

          <!-- Submit -->
          <div class="mb-3">
            <button class="btn btn-primary w-100" id="update_company" type="submit">Update Company</button>
          </div>
        </form>

      </div>
    </div>

  </div>
</div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#companyEditForm').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        if (!form.checkValidity()) {
            e.stopPropagation();
            $(form).addClass('was-validated');
            return false;
        }

        $.ajax({
            url: "<?= base_url('driver/update_company'); ?>",
            type: "POST",
            data: $(form).serialize(),
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
                        title: 'Company Updated!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "<?= base_url('company'); ?>";
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Server Error', 'Unable to update company now.', 'error');
            }
        });
    });
});
</script>
