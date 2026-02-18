<!-- application/views/provider/live_sessions_list.php -->

<div class="page-wrapper">
    <div class="page-content">
        
        <!-- Desktop Breadcrumb - Hidden on mobile -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Live Sessions</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard') ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active">Live Sessions</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="<?= base_url('provider/live_session/create') ?>" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Schedule New Session
                </a>
            </div>
        </div>

        <!-- Mobile Header - Visible only on mobile -->
        <div class="d-sm-none mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Live Sessions</h5>
                <a href="<?= base_url('provider/live_session/create') ?>" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus"></i> New Session
                </a>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0" style="font-size: 12px;">
                    <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard') ?>"><i
                                class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Live Sessions</li>
                </ol>
            </nav>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="card bg-gradient-cosmic text-white h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 small">Scheduled</p>
                                <h4 class="mb-0">
                                    <?= count(array_filter($sessions, function ($s) {
                                        return $s['status'] == 'scheduled'; })) ?>
                                </h4>
                            </div>
                            <div class="ms-auto d-none d-md-block">
                                <i class="bx bx-calendar" style="font-size: 40px; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-3 mb-md-0">
                <div class="card bg-gradient-burning text-white h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 small">Live Now</p>
                                <h4 class="mb-0">
                                    <?= count(array_filter($sessions, function ($s) {
                                        return $s['status'] == 'live'; })) ?>
                                </h4>
                            </div>
                            <div class="ms-auto d-none d-md-block">
                                <i class="bx bx-broadcast" style="font-size: 40px; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-gradient-lush text-white h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 small">Completed</p>
                                <h4 class="mb-0">
                                    <?= count(array_filter($sessions, function ($s) {
                                        return $s['status'] == 'completed'; })) ?>
                                </h4>
                            </div>
                            <div class="ms-auto d-none d-md-block">
                                <i class="bx bx-check-circle" style="font-size: 40px; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card bg-gradient-blues text-white h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 small">Total Bookings</p>
                                <h4 class="mb-0">
                                    <?= array_sum(array_column($sessions, 'booked_count')) ?>
                                </h4>
                            </div>
                            <div class="ms-auto d-none d-md-block">
                                <i class="bx bx-user-check" style="font-size: 40px; opacity: 0.5;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sessions Table -->
        <div class="card">
            <div class="card-header">
                <!-- Desktop Header -->
                <div class="d-none d-sm-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bx bx-video me-2"></i>All Sessions</h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm" id="statusFilter" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="live">Live</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <!-- Mobile Header -->
                <div class="d-sm-none">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0"><i class="bx bx-video me-1"></i>All Sessions</h6>
                    </div>
                    <select class="form-select form-select-sm" id="statusFilterMobile">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="live">Live</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0 p-sm-3">
                <!-- Desktop Table View -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover" id="sessionsTable">
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
                        <tbody>
                            <?php if (empty($sessions)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bx bx-calendar-x" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2 text-muted">No sessions scheduled yet</p>
                                        <a href="<?= base_url('provider/live_session/create') ?>"
                                            class="btn btn-primary btn-sm">
                                            Schedule Your First Session
                                        </a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($sessions as $session): ?>
                                    <tr data-status="<?= $session['status'] ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="session-icon bg-light-primary rounded p-2 me-3">
                                                    <i class="bx bx-video text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($session['title']) ?></h6>
                                                    <small class="text-muted"><?= $categories[$session['category']] ?? 'Uncategorized' ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?= date('M d, Y', strtotime($session['session_date'])) ?></strong><br>
                                                <small class="text-muted">
                                                    <?= date('h:i A', strtotime($session['start_time'])) ?> -
                                                    <?= date('h:i A', strtotime($session['end_time'])) ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($session['session_type'] == 'group'): ?>
                                                <span class="badge bg-info">Group (<?= $session['max_participants'] ?>)</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">One-on-One</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><strong>₹<?= number_format($session['price'], 2) ?></strong></td>
                                        <td>
                                            <span class="badge bg-success">
                                                <?= (int) $session['booked_count'] ?>
                                            </span>
                                            <?php if ($session['session_type'] === 'group'): ?>
                                                / <?= (int) $session['max_participants'] ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusBadges = [
                                                'scheduled' => 'bg-primary',
                                                'live' => 'bg-danger',
                                                'completed' => 'bg-success',
                                                'cancelled' => 'bg-secondary'
                                            ];
                                            ?>
                                            <span class="badge <?= $statusBadges[$session['status']] ?>">
                                                <?php if ($session['status'] == 'live'): ?>
                                                    <i class="bx bx-broadcast bx-flashing"></i>
                                                <?php endif; ?>
                                                <?= ucfirst($session['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <?php if ($session['status'] == 'scheduled'): ?>
                                                    <?php
                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $now = time();
                                                    $sessionDateTime = strtotime($session['session_date'] . ' ' . $session['start_time']);
                                                    $canStart = $now >= ($sessionDateTime - 15 * 60) && $session['booked_count'] > 0;
                                                    ?>
                                                    <a href="<?= base_url('provider/live_session/start_session/' . $session['id']) ?>"
                                                        class="btn btn-sm btn-success <?= !$canStart ? 'disabled' : '' ?>"
                                                        title="<?= $canStart ? 'Start Session' : 'Can start 15 min before scheduled time' ?>">
                                                        <i class="bx bx-play"></i>
                                                    </a>
                                                    <a href="<?= base_url('provider/live_session/edit/' . $session['id']) ?>"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="deleteSession(<?= $session['id'] ?>)">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                <?php elseif ($session['status'] == 'live'): ?>
                                                    <a href="<?= base_url('provider/live_session/start_session/' . $session['id']) ?>"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="bx bx-broadcast"></i> Rejoin
                                                    </a>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline-primary"
                                                        onclick="viewDetails(<?= $session['id'] ?>)">
                                                        <i class="bx bx-show"></i> Details
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="d-md-none">
                    <?php if (empty($sessions)): ?>
                        <div class="text-center py-5">
                            <i class="bx bx-calendar-x" style="font-size: 48px; color: #ccc;"></i>
                            <p class="mt-2 text-muted">No sessions scheduled yet</p>
                            <a href="<?= base_url('provider/live_session/create') ?>" class="btn btn-primary btn-sm">
                                Schedule Your First Session
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($sessions as $session): ?>
                            <?php
                            $statusBadges = [
                                'scheduled' => 'bg-primary',
                                'live' => 'bg-danger',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-secondary'
                            ];
                            date_default_timezone_set('Asia/Kolkata');
                            $now = time();
                            $sessionDateTime = strtotime($session['session_date'] . ' ' . $session['start_time']);
                            $canStart = $now >= ($sessionDateTime - 15 * 60) && $session['booked_count'] > 0;
                            ?>
                            <div class="session-card-mobile border-bottom p-3" data-status="<?= $session['status'] ?>">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($session['title']) ?></h6>
                                        <small class="text-muted"><?= $categories[$session['category']] ?? 'Uncategorized' ?></small>
                                    </div>
                                    <span class="badge <?= $statusBadges[$session['status']] ?>">
                                        <?php if ($session['status'] == 'live'): ?>
                                            <i class="bx bx-broadcast bx-flashing"></i>
                                        <?php endif; ?>
                                        <?= ucfirst($session['status']) ?>
                                    </span>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Date & Time</small>
                                        <strong class="small"><?= date('M d, Y', strtotime($session['session_date'])) ?></strong><br>
                                        <small><?= date('h:i A', strtotime($session['start_time'])) ?></small>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-muted d-block">Price</small>
                                        <strong class="small">₹<?= number_format($session['price'], 0) ?></strong>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-muted d-block">Bookings</small>
                                        <span class="badge bg-success small">
                                            <?= (int) $session['booked_count'] ?>
                                            <?php if ($session['session_type'] === 'group'): ?>
                                                /<?= (int) $session['max_participants'] ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <?php if ($session['session_type'] == 'group'): ?>
                                        <span class="badge bg-info">Group</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">One-on-One</span>
                                    <?php endif; ?>
                                    
                                    <div class="d-flex gap-1">
                                        <?php if ($session['status'] == 'scheduled'): ?>
                                            <a href="<?= base_url('provider/live_session/start_session/' . $session['id']) ?>"
                                                class="btn btn-sm btn-success <?= !$canStart ? 'disabled' : '' ?>">
                                                <i class="bx bx-play"></i>
                                            </a>
                                            <a href="<?= base_url('provider/live_session/edit/' . $session['id']) ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteSession(<?= $session['id'] ?>)">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        <?php elseif ($session['status'] == 'live'): ?>
                                            <a href="<?= base_url('provider/live_session/start_session/' . $session['id']) ?>"
                                                class="btn btn-sm btn-danger">
                                                <i class="bx bx-broadcast"></i> Rejoin
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="viewDetails(<?= $session['id'] ?>)">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button for Mobile -->
<a href="<?= base_url('provider/live_session/create') ?>" class="fab-button d-sm-none">
    <i class="bx bx-plus"></i>
</a>

<!-- Session Details Modal -->
<div class="modal fade" id="sessionDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Session Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="sessionDetailsContent">
                Loading...
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes bx-flashing {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    .bx-flashing {
        animation: bx-flashing 1s infinite;
    }

    .bg-gradient-cosmic {
        background: linear-gradient(to right, #8E2DE2, #4A00E0);
    }

    .bg-gradient-burning {
        background: linear-gradient(to right, #f12711, #f5af19);
    }

    .bg-gradient-lush {
        background: linear-gradient(to right, #56ab2f, #a8e063);
    }

    .bg-gradient-blues {
        background: linear-gradient(to right, #56CCF2, #2F80ED);
    }

    /* Mobile Specific Styles */
    @media (max-width: 575.98px) {
        .page-content {
            padding: 15px 10px;
        }
        
        .card-body.p-0 {
            padding: 0 !important;
        }
        
        .session-card-mobile {
            background: #fff;
        }
        
        .session-card-mobile:hover {
            background: #f8f9fa;
        }
    }

    /* Floating Action Button */
    .fab-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        z-index: 1000;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .fab-button:hover {
        transform: scale(1.1);
        color: white;
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
    }

    .fab-button i {
        font-size: 24px;
    }

    /* Card height fix */
    .card.h-100 {
        margin-bottom: 0;
    }

    /* Mobile stats cards */
    @media (max-width: 767.98px) {
        .card .card-body h4 {
            font-size: 1.25rem;
        }
        
        .card .card-body .small {
            font-size: 0.75rem;
        }
    }
</style>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
    $(document).ready(function () {
        // Status filter for desktop
        $('#statusFilter').change(function () {
            filterByStatus($(this).val());
            $('#statusFilterMobile').val($(this).val());
        });

        // Status filter for mobile
        $('#statusFilterMobile').change(function () {
            filterByStatus($(this).val());
            $('#statusFilter').val($(this).val());
        });

        function filterByStatus(status) {
            if (status) {
                // Desktop table
                $('tbody tr').hide();
                $('tbody tr[data-status="' + status + '"]').show();
                
                // Mobile cards
                $('.session-card-mobile').hide();
                $('.session-card-mobile[data-status="' + status + '"]').show();
            } else {
                $('tbody tr').show();
                $('.session-card-mobile').show();
            }
        }
    });

    function deleteSession(id) {
        Swal.fire({
            title: 'Delete Session?',
            text: 'This will also cancel all bookings and process refunds if any.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("provider/live_session/delete/") ?>' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    }
                });
            }
        });
    }

    function viewDetails(id) {
        $('#sessionDetailsModal').modal('show');
        // Load details via AJAX
    }
</script>