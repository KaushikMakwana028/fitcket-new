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
                        <!-- <li class="breadcrumb-item active" aria-current="page">Add New Song</li> -->
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Song Form Card -->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Contact-Us</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form id="AboutForm" method="post" enctype="multipart/form-data" novalidate>
                                <!-- Page Title -->
                                <div class="mb-3">
                                    <label for="songName" class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" id="songName"
                                        placeholder="Enter page title"
                                        value="<?php echo isset($page_data->title) ? htmlspecialchars($page_data->title) : ''; ?>"
                                        required>
                                    <div class="invalid-feedback">Please enter the title.</div>
                                </div>

                                <!-- Page Content with CKEditor -->
                                <div class="mb-3">
                                    <label for="songLyrics" class="form-label">Description</label>
                                    <textarea name="content" class="form-control" id="songLyrics" rows="6"
                                        placeholder="Enter Page Details"><?php echo isset($page_data->content) ? htmlspecialchars($page_data->content) : ''; ?></textarea>
                                    <div class="invalid-feedback">Please enter the page description.</div>
                                </div>

                                <!-- Hidden ID if needed -->
                                <input type="hidden" name="page_id"
                                    value="<?php echo isset($page_data->id) ? $page_data->id : ''; ?>">

                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Save</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('songLyrics');


    $(document).ready(function () {
    $("#AboutForm").on("submit", function (e) {
        e.preventDefault();

        // Update CKEditor textarea
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        // Get field values
        var title = $("input[name='title']").val().trim();
        var content = $("textarea[name='content']").val().trim();

        // Basic validation
        if (title === "") {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please enter the title.' });
            return false;
        }
        if (content === "") {
            Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please enter the description.' });
            return false;
        }

        // Proceed with AJAX only if validation passes
        var form = $(this)[0];
        var formData = new FormData(form);

        $.ajax({
            url: "<?= base_url('admin/page/save_contact'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                Swal.fire({
                    title: 'Please wait...',
                    text: 'Saving page details',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function (res) {
                Swal.close();
                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message || 'Page saved successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Something went wrong!' });
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Request Failed', text: 'Could not save page. Please try again!' });
                console.error(error);
            }
        });
    });
});

</script>