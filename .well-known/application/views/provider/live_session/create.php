<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Create Live Session</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/live_session') ?>">Live Sessions</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card radius-10">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-video-plus me-2"></i>Session Details</h6>
                    </div>
                    <div class="card-body">
                        <form id="createSessionForm" enctype="multipart/form-data">
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Session Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="e.g., Morning Yoga Flow" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Describe what participants will learn..."></textarea>
                            </div>

                            <div class="row">
                                <!-- Category -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category" id="category" required>
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $key => $name): ?>
                                            <option value="<?= $key ?>"><?= $name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Difficulty -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Difficulty Level</label>
                                    <select class="form-select" name="difficulty" id="difficulty">
                                        <option value="all-levels">All Levels</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Session Type -->
                            <div class="mb-3">
                                <label class="form-label">Session Type <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="session_type" id="type_group" value="group" checked>
                                        <label class="form-check-label" for="type_group">
                                            <i class="bx bx-group"></i> Group Session
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="session_type" id="type_one" value="one-on-one">
                                        <label class="form-check-label" for="type_one">
                                            <i class="bx bx-user"></i> One-on-One
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Max Participants (for group) -->
                            <div class="mb-3" id="max_participants_container">
                                <label class="form-label">Maximum Participants</label>
                                <input type="number" class="form-control" name="max_participants" id="max_participants" value="10" min="2" max="100">
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3"><i class="bx bx-calendar me-2"></i>Schedule</h6>

                            <div class="row">
                                <!-- Date -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="scheduled_date" id="scheduled_date" min="<?= date('Y-m-d') ?>" required>
                                </div>

                                <!-- Start Time -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="start_time" id="start_time" required>
                                </div>

                                <!-- End Time -->
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">End Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="end_time" id="end_time" required>
                                </div>
                            </div>

                            <!-- Duration Display -->
                            <div class="mb-3">
                                <div class="alert alert-info py-2 mb-0" id="duration_display" style="display: none;">
                                    <i class="bx bx-time"></i> Duration: <span id="duration_text">0 minutes</span>
                                </div>
                            </div>

                            <!-- Recurring -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_recurring" id="is_recurring">
                                    <label class="form-check-label" for="is_recurring">
                                        Make this a recurring session
                                    </label>
                                </div>
                            </div>

                            <!-- Recurring Options -->
                            <div id="recurring_options" style="display: none;">
                                <div class="card bg-light border-0 p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Repeat Pattern</label>
                                            <select class="form-select" name="recurring_pattern" id="recurring_pattern">
                                                <option value="daily">Daily</option>
                                                <option value="weekly">Weekly</option>
                                                <option value="monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">End Date</label>
                                            <input type="date" class="form-control" name="recurring_end_date" id="recurring_end_date" min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                                        </div>
                                    </div>
                                    <div id="weekly_days" style="display: none;">
                                        <label class="form-label">Repeat on</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']; ?>
                                            <?php foreach ($days as $day): ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="recurring_days[]" value="<?= $day ?>" id="day_<?= $day ?>">
                                                    <label class="form-check-label" for="day_<?= $day ?>"><?= ucfirst(substr($day, 0, 3)) ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3"><i class="bx bx-dollar-circle me-2"></i>Pricing</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="price" id="price" step="0.01" min="0" placeholder="0.00" required>
                                    </div>
                                    <small class="text-muted">Set to 0 for free session</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select" name="currency" id="currency">
                                        <option value="USD">USD ($)</option>
                                        <option value="EUR">EUR (€)</option>
                                        <option value="GBP">GBP (£)</option>
                                        <option value="INR">INR (₹)</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Requirements -->
                            <div class="mb-3">
                                <label class="form-label">Requirements (Optional)</label>
                                <textarea class="form-control" name="requirements" rows="3" placeholder="Enter each requirement on a new line..."></textarea>
                                <small class="text-muted">List what participants need (equipment, preparation, etc.)</small>
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-3">
                                <label class="form-label">Session Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp">
                                <small class="text-muted">Recommended: 1280x720px, Max 2MB</small>
                                <div id="thumbnail_preview" class="mt-2"></div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bx bx-save me-1"></i> Create Session
                                </button>
                                <a href="<?= base_url('provider/live_session') ?>" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="col-lg-4">
                <div class="card radius-10 sticky-top" style="top: 80px;">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bx bx-show me-2"></i>Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="session-preview-card">
                            <div class="preview-thumbnail bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="height: 150px;">
                                <img id="preview_image" src="" class="w-100 h-100 rounded" style="object-fit: cover; display: none;">
                                <i class="bx bx-image text-muted fs-1" id="preview_placeholder"></i>
                            </div>
                            <h6 id="preview_title" class="mb-2">Session Title</h6>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-primary" id="preview_category">Category</span>
                                <span class="badge bg-light text-dark" id="preview_difficulty">All Levels</span>
                                <span class="badge bg-light text-dark" id="preview_type">Group</span>
                            </div>
                            <p class="text-muted small mb-2">
                                <i class="bx bx-calendar"></i> <span id="preview_date">Select date</span>
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="bx bx-time"></i> <span id="preview_time">Select time</span>
                            </p>
                            <h5 class="text-primary mb-0" id="preview_price">$0.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL = '<?= base_url() ?>';

// Session type toggle
document.querySelectorAll('input[name="session_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const container = document.getElementById('max_participants_container');
        container.style.display = this.value === 'group' ? 'block' : 'none';
        updatePreview();
    });
});

// Recurring toggle
document.getElementById('is_recurring').addEventListener('change', function() {
    document.getElementById('recurring_options').style.display = this.checked ? 'block' : 'none';
});

document.getElementById('recurring_pattern').addEventListener('change', function() {
    document.getElementById('weekly_days').style.display = this.value === 'weekly' ? 'block' : 'none';
});

// Calculate duration
function calculateDuration() {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    
    if (startTime && endTime) {
        const start = new Date(`2000-01-01T${startTime}`);
        const end = new Date(`2000-01-01T${endTime}`);
        const diff = (end - start) / 1000 / 60;
        
        if (diff > 0) {
            const hours = Math.floor(diff / 60);
            const mins = diff % 60;
            let text = '';
            if (hours > 0) text += hours + ' hour' + (hours > 1 ? 's' : '') + ' ';
            if (mins > 0) text += mins + ' minutes';
            
            document.getElementById('duration_text').textContent = text.trim();
            document.getElementById('duration_display').style.display = 'block';
        } else {
            document.getElementById('duration_display').style.display = 'none';
        }
    }
    updatePreview();
}

document.getElementById('start_time').addEventListener('change', calculateDuration);
document.getElementById('end_time').addEventListener('change', calculateDuration);

// Thumbnail preview
document.getElementById('thumbnail').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_image').src = e.target.result;
            document.getElementById('preview_image').style.display = 'block';
            document.getElementById('preview_placeholder').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

// Update preview
function updatePreview() {
    // Title
    const title = document.getElementById('title').value || 'Session Title';
    document.getElementById('preview_title').textContent = title;
    
    // Category
    const category = document.getElementById('category');
    document.getElementById('preview_category').textContent = category.options[category.selectedIndex]?.text || 'Category';
    
    // Difficulty
    const difficulty = document.getElementById('difficulty');
    document.getElementById('preview_difficulty').textContent = difficulty.options[difficulty.selectedIndex]?.text || 'All Levels';
    
    // Type
    const type = document.querySelector('input[name="session_type"]:checked');
    document.getElementById('preview_type').textContent = type?.value === 'one-on-one' ? 'One-on-One' : 'Group';
    
    // Date
    const date = document.getElementById('scheduled_date').value;
    if (date) {
        document.getElementById('preview_date').textContent = new Date(date).toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }
    
    // Time
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    if (startTime && endTime) {
        document.getElementById('preview_time').textContent = formatTime(startTime) + ' - ' + formatTime(endTime);
    }
    
    // Price
    const price = parseFloat(document.getElementById('price').value) || 0;
    const currency = document.getElementById('currency').value;
    const symbols = { USD: '$', EUR: '€', GBP: '£', INR: '₹' };
    document.getElementById('preview_price').textContent = (symbols[currency] || '$') + price.toFixed(2);
}

function formatTime(timeStr) {
    const [hours, minutes] = timeStr.split(':');
    const h = parseInt(hours);
    return `${h > 12 ? h - 12 : h}:${minutes} ${h >= 12 ? 'PM' : 'AM'}`;
}

// Add event listeners for preview updates
['title', 'category', 'difficulty', 'scheduled_date', 'price', 'currency'].forEach(id => {
    document.getElementById(id)?.addEventListener('input', updatePreview);
    document.getElementById(id)?.addEventListener('change', updatePreview);
});

// Form submission
document.getElementById('createSessionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Creating...';
    
    const formData = new FormData(this);
    
    fetch(`${BASE_URL}provider/live_session/save`, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            alert('Error: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bx bx-save me-1"></i> Create Session';
        }
    })
    .catch(err => {
        console.error(err);
        alert('An error occurred. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bx bx-save me-1"></i> Create Session';
    });
});
</script>