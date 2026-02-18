<!-- application/views/my_sessions.php -->

<div class="container py-4">
    <h2 class="mb-4">My Booked Sessions</h2>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <?php if (empty($sessions)): ?>
        <div class="alert alert-info">
            <p>You haven't booked any sessions yet.</p>
            <a href="<?= base_url('session_booking') ?>" class="btn btn-primary">Browse Sessions</a>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($sessions as $session): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($session['thumbnail'])): ?>
                            <img src="<?= base_url('uploads/session_thumbnails/' . $session['thumbnail']) ?>" 
                                 class="card-img-top" style="height: 180px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                 style="height: 180px;">
                                <i class="fa fa-video fa-3x"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($session['title']) ?></h5>
                            <p class="text-muted mb-2">
                                <i class="fa fa-user"></i> <?= htmlspecialchars($session['provider_name']) ?>
                            </p>
                            <p class="mb-1">
                                <i class="fa fa-calendar"></i> 
                                <?= date('d M Y', strtotime($session['session_date'])) ?>
                            </p>
                            <p class="mb-2">
                                <i class="fa fa-clock"></i> 
                                <?= date('h:i A', strtotime($session['start_time'])) ?> - 
                                <?= date('h:i A', strtotime($session['end_time'])) ?>
                            </p>

                            <!-- Session Status Badge -->
                            <?php
                            $status = $session['session_status'];
                            $badge_class = [
                                'scheduled' => 'bg-primary',
                                'live'      => 'bg-success',
                                'completed' => 'bg-secondary',
                                'cancelled' => 'bg-danger'
                            ];
                            ?>
                            <span class="badge <?= $badge_class[$status] ?? 'bg-dark' ?> mb-3">
                                <?= strtoupper($status) ?>
                                <?php if ($status == 'live'): ?>
                                    <span class="pulse-dot"></span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="card-footer bg-white">
                            <?php if ($status == 'live'): ?>
                                <a href="<?= base_url('session_booking/join_session/' . $session['session_id']) ?>" 
                                   class="btn btn-success btn-block w-100">
                                    <i class="fa fa-play-circle"></i> Join Now
                                </a>
                            <?php elseif ($status == 'scheduled'): ?>
                                <button class="btn btn-secondary btn-block w-100" disabled>
                                    <i class="fa fa-hourglass-half"></i> Waiting to Start
                                </button>
                            <?php elseif ($status == 'completed'): ?>
                                <button class="btn btn-dark btn-block w-100" disabled>
                                    <i class="fa fa-check-circle"></i> Completed
                                </button>
                            <?php else: ?>
                                <button class="btn btn-danger btn-block w-100" disabled>
                                    <i class="fa fa-times-circle"></i> Cancelled
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.pulse-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: #fff;
    border-radius: 50%;
    margin-left: 5px;
    animation: pulse 1s infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}
</style>