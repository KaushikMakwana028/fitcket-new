<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bx bx-plus-circle text-primary me-2"></i>Add FITTV Category</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('admin/save_fittv_category') ?>">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Select Gender</label>
                            <select name="gender" class="form-select shadow-none border-secondary-subtle">
                                <option value="Boy">Boy</option>
                                <option value="Girl">Girl</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control shadow-none border-secondary-subtle" placeholder="Enter category name" required>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?= base_url('admin/fittv_category') ?>" class="btn btn-light me-2 px-4 shadow-sm border">Cancel</a>
                        <button class="btn btn-primary px-4 shadow-sm"><i class="bx bx-save me-1"></i> Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>