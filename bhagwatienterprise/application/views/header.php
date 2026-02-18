<!doctype html>

<html lang="en" data-bs-theme="light">



<head>

	<!-- Required meta tags -->

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--favicon-->

	<link rel="icon" href="" type="image/png">



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

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />



	<link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">



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







	<title>bhagwati Enterprise - Admin</title>

</head>



<body>

	<!--wrapper-->

	<div class="wrapper">

		<!--sidebar wrapper -->

		<div class="sidebar-wrapper" data-simplebar="true">

			<div class="sidebar-header">

				<div>

				</div>

				<div>

					<h4 class="logo-text">Admin Dashboard</h4>

				</div>

				<div class="mobile-toggle-icon ms-auto"><i class='bx bx-x'></i>

				</div>

			</div>

			<!--navigation-->

			<ul class="metismenu" id="menu">

				<li>

					<a href="<?= base_url('dashboard'); ?>" class="">

						<div class="parent-icon"><i class='bx bx-home-alt'></i>

						</div>

						<div class="menu-title">Dashboard</div>

					</a>



				</li>

				 <!-- Drivers -->
  <li>
    <a href="javascript:;" class="has-arrow">
      <div class="parent-icon"><i class="bx bx-id-card"></i></div>
      <div class="menu-title">Drivers</div>
    </a>
    <ul>
      <li><a href="<?= base_url('driver'); ?>"><i class='bx bx-list-ul'></i>All Drivers</a></li>
      <li><a href="<?= base_url('add_driver'); ?>"><i class='bx bx-plus-circle'></i>Add Driver</a></li>
    </ul>
  </li>				
  <li>
  <a href="javascript:;" class="has-arrow">
    <div class="parent-icon"><i class="bx bx-buildings"></i></div>
    <div class="menu-title">Company</div>
  </a>
  <ul>
    <li>
      <a href="<?= base_url('company'); ?>">
        <i class='bx bx-list-check'></i>All Companies
      </a>
    </li>
    <li>
      <a href="<?= base_url('add_company'); ?>">
        <i class='bx bx-plus-circle'></i>Add Company
      </a>
    </li>
  </ul>
</li>
	
  <!-- Bookings -->
  <li>
    <a href="javascript:;" class="has-arrow">
      <div class="parent-icon"><i class="bx bx-calendar-check"></i></div>
      <div class="menu-title">Bookings</div>
    </a>
    <ul>
      <li><a href="<?= base_url('booking'); ?>"><i class='bx bx-list-check'></i>All Booking</a></li>
    </ul>
  </li>
  

				









			</ul>

			<!--end navigation-->

		</div>

		<!--end sidebar wrapper -->

		<!--start header -->

		<header>

			<div class="topbar">

				<nav class="navbar navbar-expand gap-2 align-items-center">

					<div class="mobile-toggle-menu d-flex"><i class='bx bx-menu'></i>

					</div>

<div class="user-box dropdown px-3" style="margin-left: 80%;">
						<?php 
$admin = $this->session->userdata('admin');
$profile_image = !empty($admin['profile_image']) ? $admin['profile_image'] : base_url('assets/images/programmer.png');
$user_name = !empty($admin['name']) ? $admin['name'] : 'Bhagwati Enterprise';
?>

<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" 
   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
   
    <img src="<?= $profile_image; ?>" class="user-img" alt="user avatar">
    <div class="user-info">
        <p class="user-name mb-0"><?= $user_name; ?></p>
    </div>
</a>

						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('profile');?>"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
							</li>
							
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout');?>"><i class="bx bx-log-out-circle"></i><span>Logout</span></a>
							</li>
						</ul>
					</div>



				</nav>

			</div>

		</header>

		<!--end header -->

		<!--start page wrapper -->