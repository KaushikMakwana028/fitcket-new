<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard'); ?>">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('slider'); ?>">Slider</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Slider</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Slider</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form
                                id="SliderForm"
                                method="post"
                                enctype="multipart/form-data"
                                novalidate
                                data-mode="edit"
                                data-action="<?= site_url('update_slider'); ?>">
                                <input type="hidden" name="id" value="<?= $slider->id; ?>">

                                <div class="mb-3">
                                    <label for="sliderTitle" class="form-label">Title</label>
                                    <input
                                        type="text"
                                        name="title"
                                        class="form-control"
                                        id="sliderTitle"
                                        placeholder="Enter Title ..."
                                        value="<?= html_escape($slider->slider_title); ?>"
                                        required>
                                    <div class="invalid-feedback">Please enter the title.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="sliderSubTitle" class="form-label">Sub-Title</label>
                                    <input
                                        type="text"
                                        name="sub_title"
                                        class="form-control"
                                        id="sliderSubTitle"
                                        placeholder="Enter Sub-Title ..."
                                        value="<?= html_escape($slider->sub_title); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="sliderImage" class="form-label">Image</label>
                                    <input type="file" name="slider_image" class="form-control" id="slider_image" accept="image/*">
                                    <div class="form-text text-danger">
                                        Leave empty to keep the current image. Recommended size <strong>824px * 550px</strong>.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Preview</label><br>
                                    <img
                                        id="previewImage"
                                        src="<?= !empty($slider->slider_image) ? base_url('uploads/slider/' . $slider->slider_image) : base_url('assets/images/no-image.png'); ?>"
                                        alt="Preview"
                                        style="max-width: 90px; border: 1px solid #ccc; padding: 5px;" />
                                </div>

                                <!-- <div class="mb-3">
                                    <label for="pageLink" class="form-label">Page Link (Optional)</label>
                                    <input
                                        type="text"
                                        name="page_link"
                                        class="form-control"
                                        id="pageLink"
                                        placeholder="Enter Page Link ..."
                                        value="<?= html_escape($slider->page_link); ?>">
                                </div> -->

                                <div class="mb-3">
                                    <label for="displayOrder" class="form-label">Display Order</label>
                                    <select class="form-select" name="display_order" id="displayOrder" required>
                                        <option value="">Select Display Order</option>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>" <?= (int) $slider->display_order === $i ? 'selected' : ''; ?>><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a display order.</div>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100" id="sliderSubmitBtn">Update Slider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("slider_image").addEventListener("change", function(e) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById("previewImage").src = event.target.result;
        };
        if (e.target.files[0]) {
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>