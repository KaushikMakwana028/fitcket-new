<!-- application/views/provider/session_form.php -->
<style>
    .sticky-wrapper {
    position: sticky;
    top: 90px;
}

.session-preview-card {
    z-index: 2;
}

.tips-card {
    margin-top: 16px;
    z-index: 1;
}

</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Live Sessions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/live_session') ?>">Live Sessions</a></li>
                        <li class="breadcrumb-item active"><?= isset($session) ? 'Edit' : 'Create' ?> Session</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bx bx-video me-2"></i><?= isset($session) ? 'Edit' : 'Schedule New' ?> Live Session</h5>
                    </div>
                    <div class="card-body">
                        <form id="sessionForm" enctype="multipart/form-data">
                            <input type="hidden" name="session_id" value="<?= $session['id'] ?? '' ?>">
                            
                            <!-- Basic Info -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2"><i class="bx bx-info-circle me-1"></i> Basic Information</h6>
                                </div>
                                <div class="col-12 mb-3">
    <label class="form-label fw-bold">Session Thumbnail</label>
    <input type="file" class="form-control" name="thumbnail" accept="image/*">
    <small class="text-muted">Recommended size: 600×400 (JPG/PNG)</small>
</div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Session Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" 
                                           value="<?= $session['title'] ?? '' ?>" 
                                           placeholder="e.g., Morning Yoga Flow" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <select class="form-select" name="category">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $key => $cat): ?>
                                            <option value="<?= $key ?>" <?= (isset($session) && $session['category'] == $key) ? 'selected' : '' ?>>
                                                <?= $cat ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Session Type <span class="text-danger">*</span></label>
                                    <select class="form-select" name="session_type" id="sessionType">
                                        <option value="one_on_one" <?= (isset($session) && $session['session_type'] == 'one_on_one') ? 'selected' : '' ?>>
                                            One-on-One (Private)
                                        </option>
                                        <option value="group" <?= (isset($session) && $session['session_type'] == 'group') ? 'selected' : '' ?>>
                                            Group Session
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea class="form-control" name="description" rows="4" 
                                              placeholder="Describe what participants will learn/do in this session..."><?= $session['description'] ?? '' ?></textarea>
                                </div>
                            </div>

                            <!-- Schedule -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2"><i class="bx bx-calendar me-1"></i> Schedule</h6>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="session_date" 
                                           value="<?= $session['session_date'] ?? '' ?>" 
                                           min="<?= date('Y-m-d') ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="start_time" 
                                           value="<?= isset($session) ? substr($session['start_time'], 0, 5) : '' ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Duration (minutes) <span class="text-danger">*</span></label>
                                    <select class="form-select" name="duration" required>
                                        <option value="15" <?= (isset($session) && $session['duration_minutes'] == 15) ? 'selected' : '' ?>>15 minutes</option>
                                        <option value="30" <?= (isset($session) && $session['duration_minutes'] == 30) ? 'selected' : '' ?>>30 minutes</option>
                                        <option value="45" <?= (isset($session) && $session['duration_minutes'] == 45) ? 'selected' : '' ?>>45 minutes</option>
                                        <option value="60" <?= (isset($session) && $session['duration_minutes'] == 60) ? 'selected' : 'selected' ?>>60 minutes</option>
                                        <option value="90" <?= (isset($session) && $session['duration_minutes'] == 90) ? 'selected' : '' ?>>90 minutes</option>
                                        <option value="120" <?= (isset($session) && $session['duration_minutes'] == 120) ? 'selected' : '' ?>>120 minutes</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Recurring</label>
                                    <select class="form-select" name="recurring" id="recurringSelect">
                                        <option value="none" <?= (isset($session) && $session['recurring'] == 'none') ? 'selected' : '' ?>>No Repeat</option>
                                        <option value="daily" <?= (isset($session) && $session['recurring'] == 'daily') ? 'selected' : '' ?>>Daily</option>
                                        <option value="weekly" <?= (isset($session) && $session['recurring'] == 'weekly') ? 'selected' : '' ?>>Weekly</option>
                                        <option value="monthly" <?= (isset($session) && $session['recurring'] == 'monthly') ? 'selected' : '' ?>>Monthly</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3" id="recurringCountDiv" style="display: none;">
                                    <label class="form-label fw-bold">Number of Sessions</label>
                                    <input type="number" class="form-control" name="recurring_count" value="4" min="2" max="52">
                                </div>
                            </div>

                            <!-- Pricing & Capacity -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary border-bottom pb-2"><i class="bx bx-dollar me-1"></i> Pricing & Capacity</h6>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Price per Person (₹) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="price" 
                                               value="<?= $session['price'] ?? '' ?>" 
                                               placeholder="500" min="0" step="0.01" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3" id="maxParticipantsDiv">
                                    <label class="form-label fw-bold">Max Participants</label>
                                    <input type="number" class="form-control" name="max_participants" 
                                           value="<?= $session['max_participants'] ?? 1 ?>" 
                                           min="1" max="100">
                                    <small class="text-muted">For group sessions</small>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="bx bx-save me-1"></i> Save Session
                                        </button>
                                        <a href="<?= base_url('provider/live_session') ?>" class="btn btn-outline-secondary">
                                            <i class="bx bx-x me-1"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-12 col-lg-4">
    <div class="sticky-wrapper">

                <div class="card session-preview-card" >
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bx bx-show me-1"></i> Session Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="session-preview">
                            <div class="preview-thumbnail mb-3">
                               <div class="preview-thumbnail-wrapper">
    <img id="previewThumbnail"
         src="<?= base_url('assets/images/session-placeholder.jpg') ?>"
         class="img-fluid rounded w-100"
         style="height:180px; object-fit:cover;">
</div>
                                    <h5 class="mt-2 mb-0" id="previewTitle">Session Title</h5>

                            </div>
                            
                            <div class="preview-details">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-calendar text-primary me-2"></i>
                                    <span id="previewDate">-</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-time text-primary me-2"></i>
                                    <span id="previewTime">-</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-timer text-primary me-2"></i>
                                    <span id="previewDuration">60 minutes</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-user text-primary me-2"></i>
                                    <span id="previewType">One-on-One</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-dollar text-primary me-2"></i>
                                    <span class="fw-bold text-success" id="previewPrice">₹0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card mt-3 tips-card">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bx bx-bulb me-1"></i> Tips</h6>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 ps-3">
                            <li class="mb-2">Choose a clear, descriptive title</li>
                            <li class="mb-2">Set a competitive price based on session duration</li>
                            <li class="mb-2">For group sessions, limit participants for better engagement</li>
                            <li>Test your camera and microphone before going live</li>
                        </ul>
                    </div>
                </div>
                    </div>
</div>

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
$(document).ready(function() {
    // Session type change
    $('#sessionType').change(function() {
        if ($(this).val() === 'group') {
            $('#maxParticipantsDiv').show();
            $('input[name="max_participants"]').val(10);
        } else {
            $('#maxParticipantsDiv').hide();
            $('input[name="max_participants"]').val(1);
        }
        updatePreview();
    }).trigger('change');

    // Recurring change
    $('#recurringSelect').change(function() {
        if ($(this).val() !== 'none') {
            $('#recurringCountDiv').show();
        } else {
            $('#recurringCountDiv').hide();
        }
    });

    // Live preview updates
    $('input[name="title"]').on('input', function() {
        $('#previewTitle').text($(this).val() || 'Session Title');
    });

    $('input[name="session_date"]').change(function() {
        if ($(this).val()) {
            let date = new Date($(this).val());
            $('#previewDate').text(date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }));
        }
    });
$('input[name="thumbnail"]').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#previewThumbnail').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});
    $('input[name="start_time"]').change(function() {
        if ($(this).val()) {
            let time = $(this).val();
            let hours = parseInt(time.split(':')[0]);
            let minutes = time.split(':')[1];
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            $('#previewTime').text(hours + ':' + minutes + ' ' + ampm);
        }
    });

    $('select[name="duration"]').change(function() {
        $('#previewDuration').text($(this).val() + ' minutes');
    });

    $('input[name="price"]').on('input', function() {
        $('#previewPrice').text('₹' + ($(this).val() || 0));
    });

    function updatePreview() {
        let type = $('#sessionType').val() === 'group' ? 'Group Session' : 'One-on-One';
        let maxPart = $('input[name="max_participants"]').val();
        if ($('#sessionType').val() === 'group') {
            type += ' (Max ' + maxPart + ')';
        }
        $('#previewType').text(type);
    }

    $('#sessionType, input[name="max_participants"]').change(updatePreview);

    // Form submission
    $('#sessionForm').submit(function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: '<?= base_url("provider/live_session/save") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location.href = '<?= base_url("provider/live_session") ?>';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            },
            complete: function() {
                $('button[type="submit"]').prop('disabled', false).html('<i class="bx bx-save me-1"></i> Save Session');
            }
        });
    });

    // Trigger initial preview
    $('input[name="title"], input[name="session_date"], input[name="start_time"], select[name="duration"], input[name="price"]').trigger('change');
});
</script>