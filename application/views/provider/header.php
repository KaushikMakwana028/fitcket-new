<!doctype html>

<html lang="en" data-bs-theme="light">



<head>

	<!-- Required meta tags -->

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--favicon-->

	<link rel="icon" href="<?= base_url('assets/images/dumbbell_8729453.png') ?>" type="image/png">



	<!--plugins-->

	<link href="<?= base_url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') ?>" rel="stylesheet">

	<link href="<?= base_url('assets/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet">

	<link href="<?= base_url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet">

	<link href="<?= base_url('assets/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet">



	<!-- loader-->

	<link href="<?= base_url('assets/css/pace.min.css') ?>" rel="stylesheet" />

	<script src="<?= base_url('assets/js/pace.min.js') ?>"></script>



	<!-- Bootstrap CSS -->

	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

	<link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css"
		rel="stylesheet" />



	<!-- Tagify CSS -->

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">



	<!-- Google Fonts (CDN) -->

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">



	<!-- App Styles -->

	<link href="<?= base_url('assets/sass/app.css') ?>" rel="stylesheet">

	<link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">

	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">



	<!-- Theme Style CSS -->

	<link rel="stylesheet" href="<?= base_url('assets/sass/dark-theme.css') ?>">

	<link rel="stylesheet" href="<?= base_url('assets/sass/semi-dark.css') ?>">

	<link rel="stylesheet" href="<?= base_url('assets/sass/bordered-theme.css') ?>">





	<title><?= isset($this->provider['gym_name']) ? $this->provider['gym_name'] : 'Dashboard'; ?></title>

	<script>

		(function () {

			var savedTheme = localStorage.getItem('theme') || 'light';

			document.documentElement.setAttribute('data-bs-theme', savedTheme);

		})();

	</script>

	<style>
		.user-img {

			transition: transform 0.3s ease-in-out;

		}

		.user-img:hover {

			transform: scale(2);
			/* Zooms image */

			z-index: 1000;

		}
	</style>

</head>



<body>

	<!--wrapper-->

	<div class="wrapper">

		<!--sidebar wrapper -->

		<div class="sidebar-wrapper" data-simplebar="true">

			<div class="sidebar-header">

				<div>

					<img src="<?= base_url('assets/images/logo_ficat.png'); ?>" class="logo-icon img-fluid  mt-2"
						alt="logo icon" style="width:100%;">

				</div>

				<div>

					<h4 class="logo-text"></h4>

				</div>

				<div class="mobile-toggle-icon ms-auto"><i class='bx bx-x'></i>

				</div>

			</div>

			<!--navigation-->

			<ul class="metismenu" id="menu">

				<li>

					<a href="<?= base_url('provider/dashboard'); ?>" class="">

						<div class="parent-icon"><i class='bx bx-home-alt'></i>

						</div>

						<div class="menu-title">Dashboard</div>

					</a>



				</li>

				<li>

					<a href="<?= base_url('wallet'); ?>" class="">

						<div class="parent-icon"><i class="bx bx-wallet"></i></div>

						<div class="menu-title">Wallet</div>

					</a>

				</li>



				<li>

					<a href="javascript:;" class="has-arrow">

						<div class="parent-icon"><i class="bx bx-cog"></i></div>

						<div class="menu-title">Service</div>

					</a>

					<ul>

						<li> <a href="<?= base_url('service'); ?>"><i class='bx bx-list-ul'></i>All Services</a></li>

						<li> <a href="<?= base_url('add_service'); ?>"><i class='bx bx-plus'></i>Add Service</a></li>

					</ul>
					

				</li>
				<li>
    <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="bx bx-image"></i></div>
        <div class="menu-title">Gym Gallery</div>
    </a>
    <ul>
        <li>
            <a href="<?= base_url('image'); ?>">
                <i class='bx bx-list-ul'></i>All Images
            </a>
        </li>
        <li>
            <a href="<?= base_url('add_image'); ?>">
                <i class='bx bx-plus'></i>Add Image
            </a>
        </li>
    </ul>
</li>




				<li>

					<a href="<?= base_url('customer'); ?>" class="">

						<div class="parent-icon"><i class="bx bx-user"></i></div>

						<div class="menu-title">Customers</div>

					</a>



				</li>



				<li>

					<a href="javascript:;" class="has-arrow">

						<div class="parent-icon"><i class="bx bx-book-bookmark"></i></div>

						<div class="menu-title">Bookings</div>

					</a>

					<ul>

						<li> <a href="<?= base_url('booking'); ?>"><i class='bx bx-calendar'></i>All Bookings</a></li>

						<!-- <li> <a "><i class='bx bx-calendar-plus'></i>Add

								Booking</a></li> -->

					</ul>

				</li>



				<!-- <li>

					<a href="javascript:;" class="has-arrow">

						<div class="parent-icon"><i class="bx bx-dumbbell"></i></div>

						<div class="menu-title">Trainers</div>

					</a>

					<ul>

						<li> <a href="<?= base_url('trainer'); ?>"><i class='bx bx-id-card'></i>All Trainer</a></li>

						<li> <a href="<?= base_url('add_trainer'); ?>"><i class='bx bx-user-plus'></i>Add Trainer</a>

						</li>

					</ul>

				</li> -->

<li>

					<a href="<?= base_url('provider/live_session'); ?>" class="">

						<div class="parent-icon"><i class="bx bx-user-voice"></i></div>

						<div class="menu-title">Live Session</div>

					</a>

</li>

				<li>

					<a href="<?= base_url('scheduled'); ?>" class="">

						<div class="parent-icon"><i class="bx bx-time-five"></i></div>

						<div class="menu-title">Schedule</div>

					</a>

				</li>
				<li>
    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('offers'); ?>">
        <i class="bx bxs-discount fs-5"></i>
       <div class="menu-title">Offer</div>
    </a>
</li>

<li>
    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('certification'); ?>">
        <i class="bx bxs-certification fs-5"></i>
       <div class="menu-title">Certificate</div>
    </a>
</li>

				<li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('bank_details'); ?>"><i
							class="bx bxs-bank fs-5"></i><span>Bank Details</span></a></li>



				<div class="dropdown-divider mb-0"></div>

				</li>





			</ul>

			<!--end navigation-->

		</div>

		<!--end sidebar wrapper -->

		<!--start header -->

		<header>

			<div class="topbar">



				<nav class="navbar navbar-expand gap-2 align-items-center">



					<div class="mobile-toggle-menu d-flex"><i class="bx bx-menu"></i>



					</div>
					<?php if ($this->session->userdata('admin_as_partner')): ?>
						<div class="impersonation-notice" style="display:inline-block;margin-left:10px;">
							<a href="<?= base_url('admin/partner/backToAdmin'); ?>" class="btn btn-warning btn-sm"
								id="backToAdminBtn">
								<i class="bx bx-arrow-back"></i> Back to Admin Panel
							</a>
							<small class="ms-2 text-muted">You are viewing as partner (impersonated)</small>
						</div>
					<?php endif; ?>








					<!-- <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">



						 <a href="avascript:;" class="btn d-flex align-items-center"><i class="bx bx-search"></i>Search</a>



					  </div> -->







					<div class="top-menu ms-auto">



						<ul class="navbar-nav align-items-center gap-1">



							<li class="nav-item dark-mode d-lg-none d-sm-flex">

								<a class="nav-link dark-mode-icon" href="javascript:;"><i class="bx bx-moon"></i>

								</a>

							</li>



							<li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">







								<ul class="dropdown-menu dropdown-menu-end">






								</ul>



							</li>



							<li class="nav-item dark-mode d-none d-sm-flex">



								<a class="nav-link dark-mode-icon" href="javascript:;"><i class="bx bx-moon"></i>



								</a>



							</li>







							<li class="nav-item dropdown dropdown-app">





								<div class="dropdown-menu dropdown-menu-end p-0">



									<div class="app-container p-2 my-2 ps">



										<div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Slack</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Behance</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">






														<div class="app-name">



															<p class="mb-0 mt-1">Dribble</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Outlook</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">GitHub</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Stack</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Stack</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Twitter</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Calendar</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



													

														<div class="app-name">



															<p class="mb-0 mt-1">Spotify</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Photos</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Photos</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">linkedin</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Dribble</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">YouTube</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">News</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Envato</p>



														</div>



													</div>



												</a>



											</div>



											<div class="col">



												<a href="javascript:;">



													<div class="app-box text-center">



														



														<div class="app-name">



															<p class="mb-0 mt-1">Safari</p>



														</div>



													</div>



												</a>



											</div>







										</div><!--end row-->







										<div class="ps__rail-x" style="left: 0px; bottom: 0px;">

											<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>

										</div>

										<div class="ps__rail-y" style="top: 0px; right: 0px;">

											<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>

										</div>

									</div>



								</div>



							</li>







							<li class="nav-item dropdown dropdown-large">







								<div class="dropdown-menu dropdown-menu-end">



									<a href="javascript:;">



										<div class="msg-header">



											<p class="msg-header-title">Notifications</p>



											<p class="msg-header-badge">8 New</p>



										</div>



									</a>



									<div class="header-notifications-list ps">



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="user-online">



													<img src="https://mydemo.visiontechnolabs.com/assets/images/avatars/avatar-2.png"
														alt="Admin" class="rounded-circle p-1 bg-primary" width="110"
														id="avatar-image" style="cursor:pointer;">



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">Daisy Anderson<span
															class="msg-time float-end">5 sec



															ago</span></h6>



													<p class="msg-info">The standard chunk of lorem</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="notify bg-light-danger text-danger">dc



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">New Orders <span class="msg-time float-end">2

															min



															ago</span></h6>



													<p class="msg-info">You have recived new orders</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="user-online">



													<img src="assets/images/avatars/avatar-2.png" class="msg-avatar"
														alt="user avatar">



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">Althea Cabardo <span
															class="msg-time float-end">14



															sec ago</span></h6>



													<p class="msg-info">Many desktop publishing packages</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												


												<div class="flex-grow-1">



													<h6 class="msg-name">Account Created<span
															class="msg-time float-end">28 min



															ago</span></h6>



													<p class="msg-info">Successfully created new email</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="notify bg-light-info text-info">Ss



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">New Product Approved <span
															class="msg-time float-end">2 hrs ago</span></h6>



													<p class="msg-info">Your new product has approved</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="user-online">



													<img src="assets/images/avatars/avatar-4.png" class="msg-avatar"
														alt="user avatar">



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">Katherine Pechon <span
															class="msg-time float-end">15



															min ago</span></h6>



													<p class="msg-info">Making this the first true generator</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="notify bg-light-success text-success"><i
														class="bx bx-check-square"></i>



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">Your item is shipped <span
															class="msg-time float-end">5 hrs



															ago</span></h6>



													<p class="msg-info">Successfully shipped your item</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="notify bg-light-primary">



													<img src="assets/images/app/github.png" width="25"
														alt="user avatar">



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">New 24 authors<span
															class="msg-time float-end">1 day



															ago</span></h6>



													<p class="msg-info">24 new authors joined last week</p>



												</div>



											</div>



										</a>



										<a class="dropdown-item" href="javascript:;">



											<div class="d-flex align-items-center">



												<div class="user-online">



													<img src="assets/images/avatars/avatar-8.png" class="msg-avatar"
														alt="user avatar">



												</div>



												<div class="flex-grow-1">



													<h6 class="msg-name">Peter Costanzo <span
															class="msg-time float-end">6 hrs



															ago</span></h6>



													<p class="msg-info">It was popularised in the 1960s</p>



												</div>



											</div>



										</a>



										<div class="ps__rail-x" style="left: 0px; bottom: 0px;">

											<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>

										</div>

										<div class="ps__rail-y" style="top: 0px; right: 0px;">

											<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>

										</div>

									</div>



									<a href="javascript:;">



										<div class="text-center msg-footer">



											<button class="btn btn-primary w-100">View All Notifications</button>



										</div>



									</a>



								</div>



							</li>



							<li class="nav-item dropdown dropdown-large">



								<!-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>



									<i class='bx bx-shopping-bag'></i>



								</a> -->



								<div class="dropdown-menu dropdown-menu-end">



									<a href="javascript:;">



										<div class="msg-header">



											<p class="msg-header-title">My Cart</p>



											<p class="msg-header-badge">10 Items</p>



										</div>



									</a>



									<div class="header-message-list ps">







									</div>



							</li>



						</ul>



					</div>



					<div class="user-box dropdown px-3">

						<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
							href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">



							<img src="<?= $this->provider_image ?>"
								class="user-img rounded-circle img-thumbnail transition"
								style="width:40px; height:40px; object-fit:cover;" alt="user avatar">



							<div class="user-info">

								<p class="user-name mb-0"><?= $this->provider['gym_name'] ?? 'Unknown Gym' ?></p>

								<p class="designattion mb-0"><?= $this->provider['name'] ?? 'User' ?></p>

							</div>

						</a>





						<ul class="dropdown-menu dropdown-menu-end">

							<li><a class="dropdown-item d-flex align-items-center"
									href="<?= base_url('provider/profile'); ?>"><i
										class="bx bx-user fs-5"></i><span>Profile</span></a></li>





							<li><a class="dropdown-item d-flex align-items-center"
									href="<?= base_url('provider/logout'); ?>"><i
										class="bx bx-log-out fs-5"></i><span>Logout</span></a></li>

						</ul>



					</div>



				</nav>



			</div>



		</header>

		<!--end header -->

		<!--start page wrapper -->