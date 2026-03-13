<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold"><i class="bx bx-edit text-warning me-2"></i>Edit FITTV Video</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= base_url('admin/update_fittv_video') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $video->id ?>">
                    <input type="hidden" name="old_video" value="<?= $video->video ?>">
                    
                    <div class="row mb-4">
                        <?php 
                            // Find the video's current gender based on its category
                            $current_gender = '';
                            foreach($categories as $c) {
                                if($c->id == $video->category_id) {
                                    $current_gender = $c->gender;
                                    break;
                                }
                            }
                        ?>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Select Gender</label>
                            <select name="gender" id="genderSelect" class="form-select shadow-none border-secondary-subtle" required>
                                <option value="" disabled>Choose a gender...</option>
                                <option value="Boy" <?= $current_gender == 'Boy' ? 'selected' : '' ?>>Boy</option>
                                <option value="Girl" <?= $current_gender == 'Girl' ? 'selected' : '' ?>>Girl</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">Select Category</label>
                            <select name="category_id" id="categorySelect" class="form-select shadow-none border-secondary-subtle" required>
                                <?php foreach ($categories as $c) { ?>
                                    <?php if($c->gender == $current_gender) { ?>
                                        <option value="<?= $c->id ?>" <?= $video->category_id == $c->id ? 'selected' : '' ?>>
                                            <?= $c->name ?>
                                        </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Video Title</label>
                            <input type="text" name="title" class="form-control shadow-none border-secondary-subtle" value="<?= htmlspecialchars($video->title) ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="form-label fw-semibold d-block">Current Video</label>
                            <div class="bg-dark p-2 rounded-3 text-center border">
                                <video class="rounded shadow-sm w-100" style="max-height: 180px; object-fit: contain;" controls preload="none">
                                    <source src="<?= base_url('uploads/videos/' . $video->video) ?>">
                                </video>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold mb-3">Replace Video <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="upload-area border border-2 border-dashed border-primary rounded-3 p-4 text-center position-relative bg-light" style="transition: all 0.3s ease;">
                                <i class="bx bx-cloud-upload text-primary mb-2" style="font-size: 2.5rem;"></i>
                                <h6 class="fw-bold text-dark mb-1">Click or drag a new video to replace</h6>
                                <p class="text-muted small mb-0">Leave this blank to keep the current video.</p>
                                <input type="file" name="video" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" accept="video/mp4,video/webm" onchange="document.getElementById('editFileNameLabel').textContent = this.files[0] ? this.files[0].name : 'No file selected';">
                            </div>
                            <div class="text-center mt-2">
                                <span id="editFileNameLabel" class="badge bg-secondary rounded-pill px-3 py-2"><i class="bx bx-file me-1"></i> No file selected</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="<?= base_url('admin/fittv_videos') ?>" class="btn btn-light me-2 px-4 shadow-sm border">Cancel</a>
                        <button class="btn btn-success px-4 shadow-sm"><i class="bx bx-check-circle me-1"></i> Update Video</button>
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
        var currentCategoryId = '<?= $video->category_id ?>';
        
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
                        $.each(response, function(index, cat) {
                            var selected = (cat.id == currentCategoryId) ? 'selected' : '';
                            categorySelect.append('<option value="' + cat.id + '" ' + selected + '>' + cat.name + '</option>');
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