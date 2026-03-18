<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bx bx-rupee text-primary me-2"></i>FITTV Course Price</h5>
            </div>
            <div class="card-body p-4">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin/update_fittv_course_settings') ?>">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Course Title</label>
                            <input type="text" name="title" class="form-control shadow-none border-secondary-subtle"
                                value="<?= htmlspecialchars($settings['title'] ?? 'FITTV Premium Access') ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Course Price</label>
                            <input type="number" name="price" step="0.01" min="0"
                                class="form-control shadow-none border-secondary-subtle"
                                value="<?= htmlspecialchars($settings['price'] ?? 0) ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="is_active" class="form-select shadow-none border-secondary-subtle">
                                <option value="1" <?= (int) ($settings['is_active'] ?? 1) === 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= (int) ($settings['is_active'] ?? 1) === 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="5" class="form-control shadow-none border-secondary-subtle" required><?= htmlspecialchars($settings['description'] ?? 'Unlock full FITTV access to explore all workout categories and videos.') ?></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="<?= base_url('admin/fittv_videos') ?>" class="btn btn-light me-2 px-4 shadow-sm border">Cancel</a>
                        <button class="btn btn-primary px-4 shadow-sm"><i class="bx bx-save me-1"></i> Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
