<div class="page-wrapper">
    <div class="page-content">
        <!-- Page Header -->
        <div class="page-breadcrumb d-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Live Sessions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard') ?>"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Live Sessions</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="<?= base_url('provider/live_session/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Create New Session
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card radius-10 bg-gradient-cosmic">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <p class="mb-0 text-white">Today's Sessions</p>
                                <h4 class="my-1 text-white"><?= $stats['today_sessions'] ?? 0 ?></h4>
                            </div>
                            <div class="widgets-icons bg-white text-dark rounded-circle">
                                <i class="bx bx-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card radius-10 bg-gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <p class="mb-0 text-white">Upcoming Sessions</p>
                                <h4 class="my-1 text-white"><?= $stats['upcoming_sessions'] ?? 0 ?></h4>
                            </div>
                            <div class="widgets-icons bg-white text-dark rounded-circle">
                                <i class="bx bx-time"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <p class="mb-0 text-white">Completed</p>
                                <h4 class="my-1 text-white"><?= $stats['completed_sessions'] ?? 0 ?></h4>
                            </div>
                            <div class="widgets-icons bg-white text-dark rounded-circle">
                                <i class="bx bx-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card radius-10 bg-gradient-burning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <p class="mb-0 text-white">Monthly Earnings</p>
                                <h4 class="my-1 text-white">$<?= number_format($stats['monthly_earnings'] ?? 0, 2) ?></h4>
                            </div>
                            <div class="widgets-icons bg-white text-dark rounded-circle">
                                <i class="bx bx-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Session Alert -->
        <?php if (isset($live_session) && $live_session): ?>
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-3">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-white">
                    <i class="bx bx-broadcast bx-flashing"></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">You're LIVE!</h6>
                    <div class="text-white"><?= $live_session->title ?></div>
                </div>
                <div class="ms-auto">
                    <a href="<?= base_url('provider/live_session/room/' . $live_session->id) ?>" class="btn btn-light btn-sm me-2">
                        <i class="bx bx-video"></i> Go to Room
                    </a>
                    <button type="button" class="btn btn-outline-light btn-sm" onclick="endSession(<?= $live_session->id ?>)">
                        End Session
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Today's Sessions -->
        <?php if (!empty($today_sessions)): ?>
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Today's Sessions</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($today_sessions as $session): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border shadow-none h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-<?= $session->status === 'live' ? 'danger' : 'primary' ?>">
                                        <?= $session->status === 'live' ? '🔴 LIVE' : ucfirst($session->status) ?>
                                    </span>
                                    <span class="badge bg-light text-dark"><?= ucfirst($session->category) ?></span>
                                </div>
                                <h6 class="card-title"><?= htmlspecialchars($session->title) ?></h6>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bx bx-time"></i> <?= date('h:i A', strtotime($session->start_time)) ?> - <?= date('h:i A', strtotime($session->end_time)) ?>
                                </p>
                                <p class="card-text small text-muted mb-2">
                                    <i class="bx bx-user"></i> <?= $session->session_type === 'group' ? 'Group (Max ' . $session->max_participants . ')' : 'One-on-One' ?>
                                </p>
                                <p class="fw-bold text-primary mb-3">$<?= number_format($session->price, 2) ?></p>
                                
                                <div class="d-flex gap-2">
                                    <?php if ($session->status === 'scheduled'): ?>
                                        <button class="btn btn-success btn-sm flex-fill" onclick="startSession(<?= $session->id ?>)">
                                            <i class="bx bx-play"></i> Go Live
                                        </button>
                                        <a href="<?= base_url('provider/live_session/edit/' . $session->id) ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    <?php elseif ($session->status === 'live'): ?>
                                        <a href="<?= base_url('provider/live_session/room/' . $session->id) ?>" class="btn btn-danger btn-sm flex-fill">
                                            <i class="bx bx-video"></i> Enter Room
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Upcoming Sessions -->
        <div class="card radius-10">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Upcoming Sessions</h6>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-filter="all">All</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="scheduled">Scheduled</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="completed">Completed</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-filter="cancelled">Cancelled</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="sessions-table-container">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Session</th>
                                <th>Date & Time</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Bookings</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sessions-list">
                            <?php if (!empty($upcoming_sessions)): ?>
                                <?php foreach ($upcoming_sessions as $session): ?>
                                <tr data-session-id="<?= $session->id ?>">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($session->thumbnail): ?>
                                                <img src="<?= base_url($session->thumbnail) ?>" class="rounded" width="50" height="50" style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="bx bx-video text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ms-2">
                                                <h6 class="mb-0"><?= htmlspecialchars($session->title) ?></h6>
                                                <small class="text-muted"><?= ucfirst($session->category) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><?= date('M d, Y', strtotime($session->scheduled_date)) ?></div>
                                        <small class="text-muted"><?= date('h:i A', strtotime($session->start_time)) ?> - <?= date('h:i A', strtotime($session->end_time)) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <?= $session->session_type === 'group' ? 'Group' : 'One-on-One' ?>
                                        </span>
                                    </td>
                                    <td>$<?= number_format($session->price, 2) ?></td>
                                    <td>
                                        <span class="badge bg-info">0 / <?= $session->max_participants ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $statusColors = [
                                            'scheduled' => 'primary',
                                            'live' => 'danger',
                                            'completed' => 'success',
                                            'cancelled' => 'secondary'
                                        ];
                                        ?>
                                        <span class="badge bg-<?= $statusColors[$session->status] ?? 'secondary' ?>">
                                            <?= $session->status === 'live' ? '🔴 LIVE' : ucfirst($session->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php if ($session->status === 'scheduled'): ?>
                                                    <li><a class="dropdown-item" href="#" onclick="startSession(<?= $session->id ?>)"><i class="bx bx-play text-success"></i> Start Session</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('provider/live_session/edit/' . $session->id) ?>"><i class="bx bx-edit"></i> Edit</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-warning" href="#" onclick="cancelSession(<?= $session->id ?>)"><i class="bx bx-x-circle"></i> Cancel</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteSession(<?= $session->id ?>)"><i class="bx bx-trash"></i> Delete</a></li>
                                                <?php elseif ($session->status === 'live'): ?>
                                                    <li><a class="dropdown-item" href="<?= base_url('provider/live_session/room/' . $session->id) ?>"><i class="bx bx-video text-danger"></i> Go to Room</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="endSession(<?= $session->id ?>)"><i class="bx bx-stop-circle"></i> End Session</a></li>
                                                <?php else: ?>
                                                    <li><a class="dropdown-item" href="#" onclick="viewDetails(<?= $session->id ?>)"><i class="bx bx-show"></i> View Details</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-calendar-x fs-1 d-block mb-2"></i>
                                            No upcoming sessions. <a href="<?= base_url('provider/live_session/create') ?>">Create one now!</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div id="pagination-container" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Session Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bx bx-info-circle"></i> Cancelling will notify all booked users and process refunds.
                </div>
                <div class="mb-3">
                    <label class="form-label">Reason for cancellation</label>
                    <textarea class="form-control" id="cancelReason" rows="3" placeholder="Enter reason..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirmCancel">Cancel Session</button>
            </div>
        </div>
    </div>
</div>

<!-- Session Ended Modal -->
<div class="modal fade" id="sessionEndedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bx bx-check-circle"></i> Session Completed!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bx bx-party fs-1 text-success mb-3 d-block"></i>
                <h5>Great job!</h5>
                <div class="row mt-4">
                    <div class="col-4">
                        <h6 class="text-muted">Attendees</h6>
                        <h4 id="ended-attendees">0</h4>
                    </div>
                    <div class="col-4">
                        <h6 class="text-muted">Total Earned</h6>
                        <h4 id="ended-earnings">$0</h4>
                    </div>
                    <div class="col-4">
                        <h6 class="text-muted">Your Share</h6>
                        <h4 id="ended-share" class="text-success">$0</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL = '<?= base_url() ?>';
let currentFilter = 'all';
let currentPage = 1;
let cancelSessionId = null;

// Start Session
function startSession(sessionId) {
    if (!confirm('Are you ready to start this session? Users will be notified.')) return;
    
    fetch(`${BASE_URL}provider/live_session/start/${sessionId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('success', data.message);
            if (data.redirect) {
                setTimeout(() => window.location.href = data.redirect, 1000);
            }
        } else {
            showToast('error', data.message);
        }
    })
    .catch(err => {
        console.error(err);
        showToast('error', 'Failed to start session');
    });
}

// End Session
function endSession(sessionId) {
    if (!confirm('Are you sure you want to end this session?')) return;
    
    fetch(`${BASE_URL}provider/live_session/end/${sessionId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            // Show summary modal
            document.getElementById('ended-attendees').textContent = data.data.attendees;
            document.getElementById('ended-earnings').textContent = '$' + data.data.total_earnings;
            document.getElementById('ended-share').textContent = '$' + data.data.your_earnings;
            
            new bootstrap.Modal(document.getElementById('sessionEndedModal')).show();
            
            setTimeout(() => location.reload(), 3000);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(err => {
        console.error(err);
        showToast('error', 'Failed to end session');
    });
}

// Cancel Session
function cancelSession(sessionId) {
    cancelSessionId = sessionId;
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

document.getElementById('confirmCancel').addEventListener('click', function() {
    const reason = document.getElementById('cancelReason').value;
    
    const formData = new FormData();
    formData.append('reason', reason);
    
    fetch(`${BASE_URL}provider/live_session/cancel/${cancelSessionId}`, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('cancelModal')).hide();
        
        if (data.status === 'success') {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(err => {
        console.error(err);
        showToast('error', 'Failed to cancel session');
    });
});

// Delete Session
function deleteSession(sessionId) {
    if (!confirm('Are you sure you want to delete this session? This action cannot be undone.')) return;
    
    fetch(`${BASE_URL}provider/live_session/delete/${sessionId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('success', data.message);
            document.querySelector(`tr[data-session-id="${sessionId}"]`)?.remove();
        } else {
            showToast('error', data.message);
        }
    })
    .catch(err => {
        console.error(err);
        showToast('error', 'Failed to delete session');
    });
}

// Filter buttons
document.querySelectorAll('[data-filter]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        currentFilter = this.dataset.filter;
        loadSessions();
    });
});

// Load sessions
function loadSessions() {
    const params = new URLSearchParams({
        page: currentPage,
        status: currentFilter === 'all' ? '' : currentFilter
    });
    
    fetch(`${BASE_URL}provider/live_session/get_list?${params}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                renderSessions(data.data.sessions);
                renderPagination(data.data.pagination);
            }
        })
        .catch(err => console.error(err));
}

// Render sessions table
function renderSessions(sessions) {
    const tbody = document.getElementById('sessions-list');
    
    if (!sessions || sessions.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="text-muted">
                        <i class="bx bx-calendar-x fs-1 d-block mb-2"></i>
                        No sessions found.
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = sessions.map(session => {
        const statusColors = {
            scheduled: 'primary',
            live: 'danger',
            completed: 'success',
            cancelled: 'secondary'
        };
        
        return `
            <tr data-session-id="${session.id}">
                <td>
                    <div class="d-flex align-items-center">
                        ${session.thumbnail ? 
                            `<img src="${BASE_URL}${session.thumbnail}" class="rounded" width="50" height="50" style="object-fit: cover;">` :
                            `<div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bx bx-video text-muted"></i></div>`
                        }
                        <div class="ms-2">
                            <h6 class="mb-0">${session.title}</h6>
                            <small class="text-muted">${session.category}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <div>${new Date(session.scheduled_date).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}</div>
                    <small class="text-muted">${formatTime(session.start_time)} - ${formatTime(session.end_time)}</small>
                </td>
                <td><span class="badge bg-light text-dark">${session.session_type === 'group' ? 'Group' : 'One-on-One'}</span></td>
                <td>$${parseFloat(session.price).toFixed(2)}</td>
                <td><span class="badge bg-info">${session.participants_count || 0} / ${session.max_participants}</span></td>
                <td><span class="badge bg-${statusColors[session.status]}">${session.status === 'live' ? '🔴 LIVE' : session.status.charAt(0).toUpperCase() + session.status.slice(1)}</span></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu">
                            ${session.status === 'scheduled' ? `
                                <li><a class="dropdown-item" href="#" onclick="startSession(${session.id})"><i class="bx bx-play text-success"></i> Start Session</a></li>
                                <li><a class="dropdown-item" href="${BASE_URL}provider/live_session/edit/${session.id}"><i class="bx bx-edit"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-warning" href="#" onclick="cancelSession(${session.id})"><i class="bx bx-x-circle"></i> Cancel</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteSession(${session.id})"><i class="bx bx-trash"></i> Delete</a></li>
                            ` : session.status === 'live' ? `
                                <li><a class="dropdown-item" href="${BASE_URL}provider/live_session/room/${session.id}"><i class="bx bx-video text-danger"></i> Go to Room</a></li>
                                <li><a class="dropdown-item" href="#" onclick="endSession(${session.id})"><i class="bx bx-stop-circle"></i> End Session</a></li>
                            ` : `
                                <li><a class="dropdown-item" href="#"><i class="bx bx-show"></i> View Details</a></li>
                            `}
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
}

function formatTime(timeStr) {
    const [hours, minutes] = timeStr.split(':');
    const h = parseInt(hours);
    return `${h > 12 ? h - 12 : h}:${minutes} ${h >= 12 ? 'PM' : 'AM'}`;
}

function renderPagination(pagination) {
    const container = document.getElementById('pagination-container');
    if (pagination.total_pages <= 1) {
        container.innerHTML = '';
        return;
    }
    
    let html = '<nav><ul class="pagination pagination-sm justify-content-center">';
    
    for (let i = 1; i <= pagination.total_pages; i++) {
        html += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
            <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
        </li>`;
    }
    
    html += '</ul></nav>';
    container.innerHTML = html;
}

function goToPage(page) {
    currentPage = page;
    loadSessions();
}

function showToast(type, message) {
    // You can implement a toast notification here
    alert(message);
}

// Initial load
// loadSessions();
</script>