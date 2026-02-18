<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Service</h5>
            </div>
            <div class="card-body">
                <form id="edit_service_form" method="post" enctype="multipart/form-data" novalidate>
                    <!-- Hidden ID -->
                    <input type="hidden" name="service_id" value="<?= $service->id; ?>">

                    <!-- Service Title -->
                    <div class="mb-3">
                        <label for="service_title" class="form-label">Service Title</label>
                        <input type="text" class="form-control" id="service_title" name="service_title"
                            value="<?= htmlspecialchars($service->name); ?>" placeholder="Enter service title" required>
                    </div>

                    <!-- Service Image -->
                    <div class="mb-3">
                        <label for="service_image" class="form-label">Service Image</label>
                        <input type="file" class="form-control" id="service_image" name="service_image"
                            accept="image/*">
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3" id="preview_section">
                        <label class="form-label">Current Image</label><br>
                        <img id="image_preview"
                            src="<?= !empty($service->image) ? base_url($service->image) : base_url('assets/images/no-image.png'); ?>"
                            alt="Preview" style="max-width: 90px; border: 1px solid #ccc; padding: 5px;">
                    </div>

                    <!-- Service Description -->
                    <div class="mb-3">
                        <label for="service_description" class="form-label">Service Description</label>
                        <textarea class="form-control" id="service_description" name="service_description" rows="4"
                            placeholder="Enter service description"
                            required><?= htmlspecialchars($service->description); ?></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Service</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>