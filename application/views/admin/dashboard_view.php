<style>
  .card {
    border-radius: 16px;
    transition: all 0.2s ease;
  }

  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  }

  .widgets-icons {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    border-radius: 12px;
  }

  .bg-light-success {
    background-color: rgba(0, 200, 0, 0.1);
  }

  .bg-light-info {
    background-color: rgba(0, 150, 255, 0.1);
  }

  .bg-light-danger {
    background-color: rgba(255, 0, 0, 0.1);
  }

  .bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1);
  }

  .bg-light-primary {
    background-color: rgba(13, 110, 253, 0.1);
  }

  .rounded-3 {
    border-radius: 12px;
  }

  .gap-2 {
    gap: 0.5rem;
  }

  .gap-3 {
    gap: 1rem;
  }

  .fw-semibold {
    font-weight: 600;
  }

  .rating-stars {
    display: inline-flex;
    align-items: center;
    gap: 1px;
    white-space: nowrap;
    line-height: 1;
  }
</style>

<div class="page-wrapper">
  <div class="page-content">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-4 mb-4">
      <div class="col">
        <div class="card radius-10 h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Total Customers</p>
                <h4 class="my-1"><?= $total_customers ?></h4>
                <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>34 from last week</p>
              </div>
              <div class="widgets-icons bg-light-success text-success ms-auto">
                <i class="bx bxs-user-account"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card radius-10 h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Total Partner</p>
                <h4 class="my-1"><?= $total_partners ?></h4>
                <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>24 from last week</p>
              </div>
              <div class="widgets-icons bg-light-info text-info ms-auto">
                <i class="bx bxs-user-badge"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card radius-10 h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Monthly Booking</p>
                <h4 class="my-1"><?= $total_bookings ?></h4>
                <p class="mb-0 font-13 text-danger"><i class="bx bxs-down-arrow align-middle"></i>34 from last week</p>
              </div>
              <div class="widgets-icons bg-light-danger text-danger ms-auto">
                <i class="bx bxs-book-bookmark"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card radius-10 h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-secondary">Monthly Revenue</p>
                <h4 class="my-1">&#8377; <?= number_format($grand_total, 2); ?></h4>
                <p class="mb-0 font-13 text-success"><i class="bx bxs-up-arrow align-middle"></i>12.2% from last week</p>
              </div>
              <div class="widgets-icons bg-light-warning text-warning ms-auto">
                <i class="bx bx-rupee"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card radius-10 h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-1 text-secondary">Total Reviews</p>
                <h3 class="mb-1 fw-bold"><?= $total_reviews ?? 0 ?></h3>
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-semibold"><?= number_format($average_rating ?? 0, 1) ?></span>
                  <span class="rating-stars">
                    <?php
                    $avgRating = (float) ($average_rating ?? 0);
                    $fullStars = (int) floor($avgRating);
                    $fraction = $avgRating - $fullStars;
                    $halfStars = 0;
                    if ($fraction >= 0.75) {
                      $fullStars++;
                    } elseif ($fraction >= 0.25) {
                      $halfStars = 1;
                    }
                    $emptyStars = max(0, 5 - $fullStars - $halfStars);
                    for ($i = 0; $i < $fullStars; $i++): ?>
                      <i class="bx bxs-star text-warning"></i>
                    <?php endfor; ?>
                    <?php for ($i = 0; $i < $halfStars; $i++): ?>
                      <i class="bx bxs-star-half text-warning"></i>
                    <?php endfor; ?>
                    <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                      <i class="bx bx-star text-muted"></i>
                    <?php endfor; ?>
                  </span>
                </div>
              </div>
              <div class="widgets-icons bg-light-primary text-primary ms-auto">
                <i class="bx bxs-star"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-xl-6">
        <div class="card radius-10 border-0 shadow-sm">
          <div class="card-body">
            <h6 class="mb-4">Monthly Payments Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-light-primary text-primary rounded-circle">
                <i class="bx bx-credit-card-alt"></i>
              </div>
              <div>
                <h3 class="mb-0">&#8377;<?= number_format($total_balance, 2) ?></h3>
                <p class="mb-0 text-secondary">This Month Collected Payment</p>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-success mb-2"><i class="bx bx-credit-card"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($pending_payout, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Pending Payout</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary mb-2"><i class="bx bx-check-circle"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($fulfilled_payout, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Fulfill Payout</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-danger mb-2"><i class="bx bx-trending-up"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($total_earning, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Total Earning</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="card radius-10 border-0 shadow-sm">
          <div class="card-body">
            <h6 class="mb-4">Monthly Pay Any Gym Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-light-primary text-primary rounded-circle">
                <i class="bx bx-credit-card-alt"></i>
              </div>
              <div>
                <h3 class="mb-0">&#8377;<?= number_format($total_collected, 2) ?></h3>
                <p class="mb-0 text-secondary">This Month Collected Payment</p>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary mb-2"><i class="bx bx-check-circle"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($settled_amount, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Fulfilled Settlement</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-warning mb-2"><i class="bx bx-time-five"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($pending_amount, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Pending Settlement</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-danger mb-2"><i class="bx bx-trending-up"></i></div>
                  <h5 class="mb-1">&#8377;<?= number_format($rent_profit, 2) ?></h5>
                  <p class="mb-0 text-secondary small">Total Earning</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-12">
        <div class="card radius-10 border-0 shadow-sm">
          <div class="card-body">
            <h6 class="mb-4">Rating Breakdown</h6>

            <?php for ($i = 5; $i >= 1; $i--):
              $count = isset($rating_counts[$i]) ? $rating_counts[$i] : 0;
              $total = isset($total_reviews) && $total_reviews > 0 ? $total_reviews : 1;
              $percent = ($count / $total) * 100;
            ?>
              <div class="d-flex align-items-center mb-3">
                <div style="width: 50px;" class="fw-semibold"><?= $i ?> &#9733;</div>
                <div class="progress flex-grow-1 mx-3" style="height: 8px;">
                  <div class="progress-bar bg-warning" style="width: <?= $percent ?>%;" role="progressbar"></div>
                </div>
                <div style="width: 40px; text-align: right;" class="text-secondary"><?= $count ?></div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
