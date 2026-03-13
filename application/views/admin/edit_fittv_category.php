<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bx bx-edit text-warning me-2"></i>Edit FITTV Category</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('admin/update_fittv_category') ?>">
                    <input type="hidden" name="id" value="<?= $category->id ?>">
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select shadow-none border-secondary-subtle">
                                <option value="Boy" <?= $category->gender == 'Boy' ? 'selected' : '' ?>>Boy</option>
                                <option value="Girl" <?= $category->gender == 'Girl' ? 'selected' : '' ?>>Girl</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control shadow-none border-secondary-subtle" value="<?= htmlspecialchars($category->name) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="isActive" class="form-select shadow-none border-secondary-subtle">
                                <option value="1" <?= $category->isActive ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= !$category->isActive ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?= base_url('admin/fittv_category') ?>" class="btn btn-light me-2 px-4 border shadow-sm">Cancel</a>
                        <button class="btn btn-success px-4 shadow-sm"><i class="bx bx-check-circle me-1"></i> Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>