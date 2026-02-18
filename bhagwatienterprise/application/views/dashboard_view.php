<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				



			<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

					<div class="col">

						<div class="card radius-10">

							<div class="card-body">
    <div class="d-flex align-items-center">
        <div>
            <p class="mb-0 text-secondary">Total This Month Trips</p>
            <h4 class="my-2"><?= $total_month_trips ?></h4>
            <p class="mb-0 font-13 text-warning"><i class="align-middle"></i></p>
        </div>
        <div class="widgets-icons bg-light-warning text-warning ms-auto">
            <i class="bx bxs-car"></i> <!-- Trip Icon -->
        </div>
    </div>
</div>

						</div>

					</div>

					<div class="col">

						<div class="card radius-10">

							<div class="card-body">
    <div class="d-flex align-items-center">
        <div>
            <p class="mb-0 text-secondary">Total Drivers</p>
            <h4 class="my-2"><?= $total_drivers ?></h4>
            <p class="mb-0 font-13 text-success"><i class="align-middle"></i></p>
        </div>
        <div class="widgets-icons bg-light-success text-success ms-auto">
            <i class="bx bxs-user"></i> <!-- Driver Icon -->
        </div>
    </div>
</div>

						</div>

					</div>

					<div class="col">

						<div class="card radius-10">

							<div class="card-body">
    <div class="d-flex align-items-center">
        <div>
            <p class="mb-0 text-secondary">Total Companies</p>
            <h4 class="my-2"><?= $total_companies ?></h4>
            <p class="mb-0 font-13 text-danger"><i class="align-middle"></i></p>
        </div>
        <div class="widgets-icons bg-light-danger text-danger ms-auto">
            <i class="bx bxs-building"></i> <!-- Company Icon -->
        </div>
    </div>
</div>
						</div>

					</div>

					

					

			</div>

			<div class="row row-cols-1 row-cols-xl-2">

					<div class="card border-0 rounded-4 shadow-none mb-0 bg-transparent mb-0">
						<div class="card-body p-0">
						  <div class="d-flex flex-column gap-4">
							<div class="card rounded-4 mb-0">
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-1">
            <div>
                <h6 class="mb-4">Today's Trip Data</h6>
            </div>
        </div>

        <!-- Main Total Trips -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="mb-0 widgets-icons bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                <i class="bx bx-trip"></i> <!-- Icon for Total Trips -->
            </div>
            <div>
                <h3 class="mb-0"><?=$total_today_trips ?></h3>
                <p class="mb-0">Total Trips</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 g-3">
            <!-- Completed Trips -->
            <div class="col">
                <div class="border rounded-4 p-3">
                    <div class="fs-3 text-success"><i class="bx bx-check-circle"></i></div> <!-- Green icon -->
                    <h5 class="my-1"><?=$completed_trips_today ?></h5>
                    <p class="mb-0">Completed</p>
                </div>
            </div>

            <!-- Running Trips -->
            <div class="col">
                <div class="border rounded-4 p-3">
                    <div class="fs-3 text-warning"><i class="bx bx-loader-alt"></i></div> <!-- Yellow/Orange icon -->
                    <h5 class="mb-1"><?=$running_trips_today ?></h5>
                    <p class="mb-0">Running</p>
                </div>
            </div>
        </div><!--end row-->
    </div>
</div>

							
							
							
						  </div>
						</div>
					  </div>

					

			</div>

			

			</div>

			

			</div><!--end page content -->

		</div>
</div>
		<!--end page wrapper -->

        