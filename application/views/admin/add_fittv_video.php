<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bx bx-video-plus text-primary me-2"></i>Upload FITTV Video</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('admin/save_fittv_video') ?>" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Select Gender</label>
                            <select name="gender" id="genderSelect" class="form-select shadow-none border-secondary-subtle" required>
                                <option value="" disabled selected>Choose a gender...</option>
                                <option value="Boy">Boy</option>
                                <option value="Girl">Girl</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">Select Category</label>
                            <select name="category_id" id="categorySelect" class="form-select shadow-none border-secondary-subtle" required disabled>
                                <option value="" disabled selected>First choose a gender</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Video Title</label>
                            <input type="text" name="title" class="form-control shadow-none border-secondary-subtle" placeholder="Enter video title" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">Upload Video File</label>
                        <div class="upload-area border border-2 border-dashed border-primary rounded-3 p-4 text-center position-relative bg-light" style="transition: all 0.3s ease;">
                            <i class="bx bx-cloud-upload text-primary mb-2" style="font-size: 3rem;"></i>
                            <h6 class="fw-bold text-dark mb-1">Click to upload or drag and drop</h6>
                            <p class="text-muted small mb-0">Accepted formats: MP4, WEBM. Max size: 50MB.</p>
                            <input type="file" name="video" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="video/mp4,video/webm" required onchange="document.getElementById('fileNameLabel').textContent = this.files[0] ? this.files[0].name : 'No file selected';">
                        </div>
                        <div class="text-center mt-2">
                            <span id="fileNameLabel" class="badge bg-secondary rounded-pill px-3 py-2"><i class="bx bx-file me-1"></i> No file selected</span>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?= base_url('admin/fittv_videos') ?>" class="btn btn-light me-2 px-4 border shadow-sm">Cancel</a>
                        <button class="btn btn-primary px-4 shadow-sm"><i class="bx bx-cloud-upload me-1"></i> Upload Video</button>
                    </div>
                </form>
            </div>
        </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#genderSelect').on('change', function() {
        var gender = $(this).val();
        var categorySelect = $('#categorySelect');
        
        categorySelect.html('<option value="" disabled selected>Loading categories...</option>');
        categorySelect.prop('disabled', true);
        
        if(gender) {
            $.ajax({
                url: '<?= base_url("admin/fittv/get_categories_by_gender") ?>',
                type: 'POST',
                data: {gender: gender},
                dataType: 'json',
                success: function(response) {
                    categorySelect.empty();
                    if(response.length > 0) {
                        categorySelect.append('<option value="" disabled selected>Choose a category...</option>');
                        $.each(response, function(index, cat) {
                            categorySelect.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                        });
                        categorySelect.prop('disabled', false);
                    } else {
                        categorySelect.append('<option value="" disabled selected>No categories found</option>');
                    }
                },
                error: function() {
                    categorySelect.html('<option value="" disabled selected>Error loading categories</option>');
                }
            });
        }
    });
});
</script>