<div class="page-wrapper">

  <div class="page-content">





    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">



      <!-- Total Customers -->

      <div class="col">

        <div class="card radius-10">

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



      <!-- Total Partner -->

      <div class="col">

        <div class="card radius-10">

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



      <!-- Total Booking -->

      <div class="col">

        <div class="card radius-10">

          <div class="card-body">

            <div class="d-flex align-items-center">

              <div>

                <p class="mb-0 text-secondary">Total Booking</p>

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



      <!-- Payment -->

      <div class="col">

        <div class="card radius-10">

          <div class="card-body">

            <div class="d-flex align-items-center">

              <div>

                <p class="mb-0 text-secondary">Total Revenue</p>

                <h4 class="my-1">

                  ₹ <?= number_format($grand_total, 2); ?>

                </h4>



                <p class="mb-0 font-13 text-success"><i class="bx bxs-down-arrow align-middle"></i>12.2% from last week
                </p>

              </div>

              <div class="widgets-icons bg-light-warning text-warning ms-auto">

                <i class="bx bx-rupee"></i> <!-- 💰 Icon for Payment -->

              </div>

            </div>

          </div>

        </div>

      </div>



    </div>
    <!-- transection data -->
    <div class="row">
      <div class="col-xl-6">
        <div class="card radius-10">
          <div class="card-body">
            <h6>Total Payments Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-light-primary text-primary rounded-circle">
                <i class="bx bx-credit-card-alt"></i>
              </div>
              <div>
                <h3><?= $total_balance ?></h3>
                <p>Total Collected Payment</p>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-success"><i class="bx bx-credit-card"></i></div>
                  <h5>₹<?= number_format($pending_payout, 2) ?></h5>
                  <p>Pending Payout</p>
                </div>
              </div>

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary"><i class="bx bx-shower"></i></div>
                  <h5>₹<?= number_format($fulfilled_payout, 2) ?></h5>
                  <p>Fulfill Payout</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-danger"><i class="bx bx-trending-up"></i></div>
                  <h5>₹<?= number_format($total_earning, 2) ?></h5>
                  <p>Total Earning

                  </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="card radius-10">
          <div class="card-body">
            <h6>Total Pay Any Gym Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-light-primary text-primary rounded-circle">
                <i class="bx bx-credit-card-alt"></i>
              </div>
              <div>
                <h3><?= $total_collected ?></h3>
                <p>Total Collected Payment</p>
              </div>
            </div>

            <div class="row g-3">

              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary"><i class="bx bx-check-circle"></i></div>
                  <h5>₹<?= number_format($settled_amount, 2) ?></h5>
                  <p>Fulfilled Settlement</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-warning"><i class="bx bx-time-five"></i></div>
                  <h5>₹<?= number_format($pending_amount, 2) ?></h5>
                  <p>Pending Settlement</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-danger"><i class="bx bx-trending-up"></i></div>
                  <h5>₹<?= number_format($rent_profit, 2) ?></h5>
                  <p>Total Earning</p>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>




  </div>

</div><!--end page content -->

</div>