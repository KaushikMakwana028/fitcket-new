<div class="page-wrapper">
	<div class="page-content">
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Trips</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item">
							<a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Trip Details</li>
					</ol>
				</nav>
			</div>
		</div>

		<div class="main-body">
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<div class="card shadow-sm border-0">
						<div class="card-body">
							<h5 class="fw-bold text-primary mb-4">
								<i class="bx bx-car me-2"></i>Trip Summary
							</h5>

							<?php
							$start_km   = isset($trip['start_km']) ? (float)$trip['start_km'] : 0;
							$end_km     = isset($trip['end_km']) ? (float)$trip['end_km'] : 0;
							$total_km   = ($end_km > $start_km) ? round($end_km - $start_km, 2) : 0;

							$start_time = isset($trip['start_time']) ? strtotime($trip['start_time']) : 0;
							$end_time   = isset($trip['end_time']) ? strtotime($trip['end_time']) : 0;
							$total_hours = ($start_time && $end_time && $end_time > $start_time)
								? round(($end_time - $start_time) / 3600, 2)
								: 0;
							?>

							<div class="table-responsive">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<th>Start Time</th>
											<td>
												<?= isset($trip['start_time']) && !empty($trip['start_time']) 
													? date('h:i A', strtotime($trip['start_time'])) 
													: '—'; ?>
											</td>
										</tr>
										<tr>
											<th>End Time</th>
											<td>
												<?= isset($trip['end_time']) && !empty($trip['end_time']) 
													? date('h:i A', strtotime($trip['end_time'])) 
													: '—'; ?>
											</td>
										</tr>
										<tr>
											<th>Start KM</th>
											<td><?= isset($trip['start_km']) ? number_format($trip['start_km'], 2) : '—'; ?></td>
										</tr>
										<tr>
											<th>End KM</th>
											<td><?= isset($trip['end_km']) ? number_format($trip['end_km'], 2) : '—'; ?></td>
										</tr>
										<tr class="table-light">
											<th>Total KM</th>
											<td class="fw-bold text-success"><?= $total_km; ?> km</td>
										</tr>
										<tr class="table-light">
											<th>Total Hours</th>
											<td class="fw-bold text-success"><?= $total_hours; ?> hrs</td>
										</tr>
										<tr>
											<th>OTP Verified</th>
											<td>
												<?php if (isset($trip['otp_verified']) && $trip['otp_verified'] == 1): ?>
													<span class="badge bg-success">Verified</span>
												<?php else: ?>
													<span class="badge bg-danger">Not Verified</span>
												<?php endif; ?>
											</td>
										</tr>
										<tr>
											<th>Status</th>
											<td>
												<span class="badge bg-primary">
													<?= isset($trip['status']) ? ucfirst($trip['status']) : '—'; ?>
												</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="text-end mt-3">
								<a href="<?= base_url('driver/view/' . (isset($trip['user_id']) ? $trip['user_id'] : '')); ?>" 
									class="btn btn-outline-secondary">
									<i class="bx bx-arrow-back me-1"></i> Back to Trips
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
                                                </div>