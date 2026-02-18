<!--start page wrapper -->

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

                        <li class="breadcrumb-item active" aria-current="page">Slider Details</li>

                    </ol>

                </nav>

            </div>

        </div>



        <!-- Slider Card -->

        <div class="card">

            <div class="card-body p-4">

                <h5 class="card-title">Add New Slider</h5>

                <hr>

                <div class="form-body mt-4">

                    <div class="row">

                        <div class="col">

                            <form id="SliderForm" method="post" enctype="multipart/form-data" novalidate>

                                

                                <!-- Title -->

                                <div class="mb-3">

                                    <label for="sliderTitle" class="form-label">Title</label>

                                    <input type="text" name="title" class="form-control" id="sliderTitle" placeholder="Enter Title ..." required>

                                    <div class="invalid-feedback">Please enter the title.</div>

                                </div>



                                <!-- Sub-Title -->

                                <div class="mb-3">

                                    <label for="sliderSubTitle" class="form-label">Sub-Title</label>

                                    <input type="text" name="sub_title" class="form-control" id="sliderSubTitle" placeholder="Enter Sub-Title ...">

                                </div>



                                <!-- Image Upload -->

                                <div class="mb-3">

                                    <label for="sliderImage" class="form-label">Image <span class="text-danger">*</span></label>

                                    <input type="file" name="slider_image" class="form-control" id="slider_image" accept="image/*" required>

                                    <div class="form-text text-danger">

                                        Please upload image in size <strong>824px * 550px</strong> for best view.

                                    </div>

                                    <div class="invalid-feedback">Please upload a valid image.</div>

                                </div>



                                <!-- Image Preview -->

                                <div class="mb-3">

                                    <label class="form-label">Preview</label><br>

                                    <img id="previewImage" src="<?= base_url('assets/images/no-image.png') ?>" alt="Preview"

                                         style="max-width: 90px; border: 1px solid #ccc; padding: 5px;" />

                                </div>



                                <!-- Page Link -->

                                <div class="mb-3">

                                    <label for="pageLink" class="form-label">Page Link (Optional)</label>

                                    <input type="text" name="page_link" class="form-control" id="pageLink" placeholder="Enter Page Link ...">

                                </div>



                                <!-- Display Order -->

                                <div class="mb-3">

                                    <label for="displayOrder" class="form-label">Display Order</label>

                                    <select class="form-select" name="display_order" id="displayOrder" required>

                                        <option value="">Select Display Order</option>

                                        <?php for ($i = 1; $i <= 10; $i++): ?>

                                            <option value="<?= $i ?>"><?= $i ?></option>

                                        <?php endfor; ?>

                                    </select>

                                    <div class="invalid-feedback">Please select a display order.</div>

                                </div>



                               

                                <div class="mb-3">

                                    <button type="submit" class="btn btn-primary w-100">Submit</button>

                                </div>



                            </form>

                        </div>

                    </div><!--end row-->

                </div>

            </div>

        </div>

    </div>





</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>



<script>

    document

	.getElementById("slider_image")

	.addEventListener("change", function (e) {

		const reader = new FileReader();

		reader.onload = function (event) {

			document.getElementById("previewImage").src = event.target.result;

		};

		if (e.target.files[0]) {

			reader.readAsDataURL(e.target.files[0]);

		}

	});

</script>

