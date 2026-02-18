<style>
  /* Minimal extra CSS */

  .widgets-icons {

    width: 50px;

    height: 50px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    font-size: 24px;

    background: #fff;

  }

  .card p {

    margin-bottom: 0;

    font-size: 14px;

  }
</style>



<div class="page-wrapper">

  <div class="page-content">



    <!-- Top Cards -->

    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-4">

      <!-- Total Customers -->

      <div class="col">

        <div class="card bg-success text-white h-100">

          <div class="card-body d-flex justify-content-between align-items-center">

            <div>

              <p>Total Customers</p>

              <h4><?= $total_customers ?></h4>

            </div>

            <div class="widgets-icons text-success"><i class="bx bxs-user-account"></i></div>

          </div>

        </div>

      </div>



      <!-- Total Services -->

      <div class="col">

        <div class="card bg-info text-dark h-100">

          <div class="card-body d-flex justify-content-between align-items-center">

            <div>

              <p>Total Services</p>

              <h4><?= $total_service ?></h4>

            </div>

            <div class="widgets-icons text-dark"><i class="bx bxs-id-card"></i></div>

          </div>

        </div>

      </div>



      <!-- Total Booking -->

      <div class="col">

        <div class="card bg-danger text-white h-100">

          <div class="card-body d-flex justify-content-between align-items-center">

            <div>

              <p>Total Booking</p>

              <h4><?= $total_bookings ?></h4>

            </div>

            <div class="widgets-icons text-danger"><i class="bx bxs-calendar-check"></i></div>

          </div>

        </div>

      </div>



      <!-- Total Payment -->

      <div class="col">

        <div class="card bg-warning text-white h-100">

          <div class="card-body d-flex justify-content-between align-items-center">

            <div>

              <p>Wallet Balance </p>

              <h4>₹<?= number_format($wallet_balance, 2) ?></h4>

            </div>

            <div class="widgets-icons text-warning"><i class="bx bxs-credit-card"></i></div>

          </div>

        </div>

      </div>

    </div>



    <!-- QR Code + Service Data -->

    <div class="row g-3 mt-2">

      <!-- QR Code -->

      <div class="col-xl-6">

        <div class="card h-100 text-center">

          <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <h5>QR Code Of Your Profile</h5>

            <?php if (!empty($qr_code_url)): ?>
              <img src="<?= $qr_code_url ?>" class="img-fluid" style="max-width:250px;">
            <?php else: ?>
              <p class="text-muted">QR Code not available.</p>
            <?php endif; ?>

            <?php
            $profile_url = base_url('provider_details/' . ($this->provider['id'] ?? $this->provider['user_id']));
            ?>

            <button type="button" class="btn btn-primary mt-3 px-4" onclick="shareProfile('<?= $profile_url ?>')">
              <i class="bx bx-share me-2"></i>Share Profile
            </button>
          </div>

        </div>

      </div>



      <!-- Service Data -->

      <div class="col-xl-6">

        <div class="card h-100">

          <div class="card-body">

            <h6>Total Bookings Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">

              <div class="widgets-icons bg-light-primary text-primary rounded-circle"><i
                  class="bx bx-credit-card-alt"></i></div>

              <div>

                <h3>₹<?= number_format($wallet_balance ?? 0, 2) ?></h3>
                <p>Total Payment</p>


              </div>

            </div>

            <div class="row g-3">

              <div class="col-md-6">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-success"><i class="bx bx-credit-card"></i></div>
                  <h5>
                    ₹<?= number_format(($pending_payout ?? 0), 2) ?>
                  </h5>
                  <p>Pending Payout</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary"><i class="bx bx-check-circle"></i></div>
                  <h5>
                    ₹<?= number_format(($fulfilled_payout ?? 0), 2) ?>
                  </h5>
                  <p>Fulfill Payout</p>
                </div>
              </div>

            </div>


          </div>

        </div>

      </div>

    </div>

    <div class="row g-3 mt-2">

      <div class="col-12">

        <div class="card">

          <div class="card-body">

            <h6 class="mb-3">Bookings Overview (Jan - Dec)</h6>

            <canvas id="bookingChart" height="120"></canvas>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>