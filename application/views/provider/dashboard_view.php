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

  .profile-activation-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 14px 18px;
    margin-bottom: 18px;
    border: 1px solid rgba(255, 193, 7, 0.3);
    border-left: 5px solid #ffc107;
    border-radius: 14px;
    background: linear-gradient(135deg, #fff9e6, #fff);
    box-shadow: 0 10px 25px rgba(255, 193, 7, 0.12);
  }

  .profile-activation-alert .alert-copy {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #5f4700;
    font-weight: 600;
  }

  .profile-activation-alert .alert-icon {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 38px;
    border-radius: 12px;
    background: #ffc107;
    color: #fff;
    font-size: 20px;
  }

  .profile-activation-alert .btn {
    border-radius: 999px;
    padding: 8px 18px;
    font-weight: 700;
    white-space: nowrap;
  }

  @media (max-width: 767px) {
    .profile-activation-alert {
      align-items: flex-start;
      flex-direction: column;
    }
  }
</style>



<div class="page-wrapper">

  <div class="page-content">



    <!-- Top Cards -->

    <?php if (!empty($profile_notice['show'])): ?>
      <div class="profile-activation-alert">
        <div class="alert-copy">
          <span class="alert-icon"><i class="bx bx-info-circle"></i></span>
          <span>Your account is inactive. Please fill all information to activate your account.</span>
        </div>
        <a href="<?= base_url('provider/profile') ?>" class="btn btn-warning">
          Profile <i class="bx bx-right-arrow-alt ms-1"></i>
        </a>
      </div>
    <?php endif; ?>

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

            <canvas id="bookingChart" style="height:300px;"></canvas>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>
