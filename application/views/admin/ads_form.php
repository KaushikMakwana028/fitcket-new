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
                        <li class="breadcrumb-item active" aria-current="page">Add Ad Banner</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Banner Form Card -->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Upload New Ad Banner</h5>
                <hr>

                <form id="AdBannerForm" method="post" enctype="multipart/form-data" novalidate>
                    
                    <!-- Provider ID (hidden, auto from session/login) -->
                    <input type="hidden" name="provider_id" value="<?= $this->session->userdata('provider_id'); ?>">

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="bannerTitle" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" id="bannerTitle" placeholder="Enter Banner Title ..." required>
                        <div class="invalid-feedback">Please enter the title.</div>
                    </div>

                    <!-- Banner Image -->
                    <div class="mb-3">
                        <label for="bannerImage" class="form-label">Banner Image <span class="text-danger">*</span></label>
                        <input type="file" name="banner_image" class="form-control" id="bannerImage" accept="image/*" required>
                        <div class="form-text text-danger">
                            Recommended size: <strong>1200px * 400px</strong> for best display.
                        </div>
                        <div class="invalid-feedback">Please upload a valid banner image.</div>
                    </div>

                    <!-- Preview -->
                    <div class="mb-3">
                        <label class="form-label">Preview</label><br>
                        <img id="previewImage" src="<?= base_url('assets/images/no-image.png') ?>" 
                             alt="Preview" style="max-width: 100px; border: 1px solid #ccc; padding: 5px;" />
                    </div>

                    <!-- Redirect URL -->
                    <div class="mb-3">
                        <label for="redirectUrl" class="form-label">Redirect URL (Optional)</label>
                        <input type="url" name="redirect_url" class="form-control" id="redirectUrl" placeholder="https://example.com">
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" id="startDate" required>
                        <div class="invalid-feedback">Please select a start date.</div>
                    </div>

                    <!-- End Date -->
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" id="endDate" required>
                        <div class="invalid-feedback">Please select an end date.</div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="pending" selected>Pending</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-upload"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Preview Script -->
<script>
    document.getElementById("bannerImage").addEventListener("change", function (e) {
        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById("previewImage").src = event.target.result;
        };
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
