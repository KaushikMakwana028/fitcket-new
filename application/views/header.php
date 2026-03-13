<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FITCKET your onestop destintion to serch & book trainer</title>
  <link rel="icon" href="<?= base_url('assets/images/dumbbell_8729453.png') ?>" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">



  <style>
    :root {
      --primary-color: #6f42c1;
      --secondary-color: #1a1a1a;
      --accent-color: #8e44ad;
      --text-dark: #2d3436;
      --bg-light: #f8f9fa;
      --gradient-primary: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
      --shadow-light: 0 2px 15px rgba(111, 66, 193, 0.1);
      --shadow-medium: 0 4px 25px rgba(111, 66, 193, 0.15);
      --shadow-strong: 0 8px 30px rgba(111, 66, 193, 0.2);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Enhanced Top Bar */
    .top-bar {
      background: var(--gradient-primary);
      color: #fff;
      font-size: 0.9rem;
      padding: 12px 0;
      font-weight: 500;
      position: relative;
      overflow: hidden;
    }

    .top-bar::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
      0% {
        left: -100%;
      }

      100% {
        left: 100%;
      }
    }

    .top-bar .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .top-bar a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      padding: 8px 16px;
      border-radius: 25px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    .top-bar a:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .top-bar a i {
      font-size: 1.1rem;
    }

    /* Enhanced Main Navigation */
    .main-navbar {
      background: #fff;
      box-shadow: var(--shadow-light);
      border-bottom: 1px solid rgba(111, 66, 193, 0.1);
      position: sticky;
      top: 0;
      z-index: 1030;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }

    .main-navbar.scrolled {
      box-shadow: var(--shadow-medium);
    }

    .navbar-brand img {
      transition: transform 0.3s ease;
      filter: drop-shadow(0 2px 8px rgba(111, 66, 193, 0.2));
    }

    .navbar-brand:hover img {
      transform: scale(1.05);
    }

    /* Enhanced Navigation Links */
    .navbar-nav .nav-link {
      font-weight: 500;
      color: var(--text-dark) !important;
      padding: 12px 18px !important;
      margin: 0 3px;
      border-radius: 25px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      font-size: 0.95rem;
    }

    .navbar-nav .nav-link::before {
      content: '';
      position: absolute;
      bottom: 5px;
      left: 50%;
      width: 0;
      height: 3px;
      background: var(--gradient-primary);
      transition: all 0.3s ease;
      transform: translateX(-50%);
      border-radius: 2px;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--primary-color) !important;
      background: rgba(111, 66, 193, 0.08);
      transform: translateY(-2px);
    }

    .navbar-nav .nav-link:hover::before,
    .navbar-nav .nav-link.active::before {
      width: 60%;
    }

    /* Enhanced Cart Icon */
    .cart-icon {
      position: relative;
      transition: transform 0.3s ease;
    }

    .cart-icon:hover {
      transform: scale(1.05);
    }

    .cart-icon a {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
      border-radius: 50%;
      background: linear-gradient(145deg, rgba(111, 66, 193, 0.1), rgba(142, 68, 173, 0.15));
      transition: all 0.3s ease;
      position: relative;
      text-decoration: none;
    }

    .cart-icon a:hover {
      background: var(--gradient-primary);
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
    }

    .cart-icon a i {
      font-size: 20px !important;
      color: var(--primary-color) !important;
      transition: all 0.3s ease;
    }

    .cart-icon a:hover i {
      color: #fff !important;
      transform: scale(1.1);
    }

    .cart-badge {
      position: absolute;
      top: 2px;
      right: 2px;
      background: linear-gradient(45deg, #ff6b6b, #ee5a52);
      color: #fff;
      font-size: 0.7rem;
      font-weight: 700;
      border-radius: 50%;
      min-width: 18px;
      height: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: pulse 2s infinite;
      border: 2px solid #fff;
      box-shadow: 0 3px 12px rgba(255, 107, 107, 0.5);
      z-index: 10;
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
        box-shadow: 0 3px 12px rgba(255, 107, 107, 0.5);
      }

      50% {
        transform: scale(1.15);
        box-shadow: 0 5px 20px rgba(255, 107, 107, 0.7);
      }
    }

    /* Enhanced Account Button */
    .account-btn {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      border: none !important;
      padding: 10px 20px !important;
      border-radius: 25px !important;
      font-weight: 600 !important;
      transition: all 0.3s ease !important;
      box-shadow: var(--shadow-light) !important;
      font-size: 0.9rem !important;
    }

    .account-btn:hover {
      transform: translateY(-2px) !important;
      box-shadow: var(--shadow-medium) !important;
      background: linear-gradient(135deg, #8e44ad 0%, #6f42c1 100%) !important;
    }

    .btn-outline-primary {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      border: 2px solid transparent !important;
      padding: 10px 20px !important;
      border-radius: 25px !important;
      font-weight: 600 !important;
      transition: all 0.3s ease !important;
      box-shadow: var(--shadow-light) !important;
    }

    .btn-outline-primary:hover {
      transform: translateY(-2px) !important;
      box-shadow: var(--shadow-medium) !important;
      background: linear-gradient(135deg, #8e44ad 0%, #6f42c1 100%) !important;
    }

    /* Enhanced Mobile Menu Button */
    .mobile-menu-btn {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      border: none !important;
      padding: 10px 14px !important;
      border-radius: 12px !important;
      transition: all 0.3s ease !important;
      box-shadow: var(--shadow-light) !important;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .mobile-menu-btn:hover {
      transform: translateY(-2px) scale(1.05) !important;
      box-shadow: var(--shadow-medium) !important;
    }

    .mobile-menu-btn i {
      font-size: 1.1rem;
    }

    /* Enhanced Offcanvas */
    .offcanvas {
      width: 300px !important;
    }

    .offcanvas-header {
      background: var(--gradient-primary);
      color: #fff;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 20px;
    }

    .offcanvas-header .btn-close {
      filter: invert(1);
      opacity: 0.8;
      transition: all 0.3s ease;
    }

    .offcanvas-header .btn-close:hover {
      opacity: 1;
      transform: rotate(90deg);
    }

    .offcanvas-body {
      background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
      padding: 15px;
    }

    .offcanvas .nav-link {
      padding: 14px 18px !important;
      margin: 6px 0 !important;
      border-radius: 12px !important;
      color: var(--text-dark) !important;
      font-weight: 500 !important;
      transition: all 0.3s ease !important;
      border: 1px solid transparent;
    }

    .offcanvas .nav-link:hover {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      transform: translateX(8px) !important;
      border-color: rgba(111, 66, 193, 0.2);
    }

    .offcanvas .nav-link i {
      width: 24px;
      text-align: center;
    }

    /* ============================================
       FIXED: Enhanced Bottom Menu - Now shows on Tablet
       ============================================ */
    .mobile-bottom-menu {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: rgba(255, 255, 255, 0.98);
      border-top: 1px solid rgba(111, 66, 193, 0.15);
      box-shadow: 0 -5px 30px rgba(111, 66, 193, 0.15);
      display: none;
      /* Hidden by default */
      justify-content: space-around;
      align-items: center;
      padding: 8px 5px max(8px, env(safe-area-inset-bottom));
      z-index: 1050;
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
    }

    .mobile-bottom-menu a {
      text-decoration: none;
      color: #6c757d;
      font-size: 0.7rem;
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 6px 8px;
      border-radius: 14px;
      min-width: 55px;
      position: relative;
    }

    .mobile-bottom-menu a::before {
      content: '';
      position: absolute;
      top: -8px;
      left: 50%;
      transform: translateX(-50%) scaleX(0);
      width: 30px;
      height: 3px;
      background: var(--gradient-primary);
      border-radius: 0 0 3px 3px;
      transition: transform 0.3s ease;
    }

    .mobile-bottom-menu a i {
      font-size: 1.15rem;
      margin-bottom: 4px;
      background: linear-gradient(145deg, #f1f3f5, #e9ecef);
      padding: 10px;
      border-radius: 14px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      width: 42px;
      height: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .mobile-bottom-menu a span {
      margin-top: 3px;
      letter-spacing: 0.3px;
    }

    .mobile-bottom-menu a.active,
    .mobile-bottom-menu a:hover {
      color: var(--primary-color);
    }

    .mobile-bottom-menu a.active::before,
    .mobile-bottom-menu a:hover::before {
      transform: translateX(-50%) scaleX(1);
    }

    .mobile-bottom-menu a.active i,
    .mobile-bottom-menu a:hover i {
      background: var(--gradient-primary);
      color: #fff;
      box-shadow: 0 5px 20px rgba(111, 66, 193, 0.4);
      transform: translateY(-3px) scale(1.05);
    }

    /* Dropdown Enhancements */
    .dropdown-menu {
      border: none !important;
      box-shadow: var(--shadow-strong) !important;
      border-radius: 16px !important;
      padding: 10px !important;
      margin-top: 10px !important;
      min-width: 200px;
      animation: dropdownFade 0.3s ease;
    }

    @keyframes dropdownFade {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown-item {
      border-radius: 10px !important;
      padding: 12px 16px !important;
      font-weight: 500 !important;
      transition: all 0.3s ease !important;
      margin: 3px 0;
    }

    .dropdown-item:hover {
      background: var(--gradient-primary) !important;
      color: #fff !important;
      transform: translateX(5px) !important;
    }

    .dropdown-item i {
      width: 20px;
      text-align: center;
    }

    .dropdown-divider {
      margin: 8px 0;
      border-color: rgba(111, 66, 193, 0.1);
    }

    /* ==============================================
       RESPONSIVE BREAKPOINTS - FIXED TABLET VIEW
       ============================================== */

    /* Mobile: 0px - 767px (Show bottom menu) */
    @media (max-width: 767px) {
      .top-bar {
        display: none !important;
      }

      .mobile-bottom-menu {
        display: flex !important;
      }

      .main-navbar .container {
        padding: 10px 15px;
      }

      .navbar-brand img {
        width: 85px !important;
        height: 42px !important;
      }

      .cart-icon a {
        padding: 10px;
      }

      .cart-icon a i {
        font-size: 18px !important;
      }

      .cart-badge {
        top: 0;
        right: 0;
        min-width: 16px;
        height: 16px;
        font-size: 0.65rem;
      }

      body {
        padding-bottom: 80px;
        /* Space for bottom menu */
      }
    }

    /* Tablet: 768px - 1024px (Show bottom menu) */
    @media (min-width: 768px) and (max-width: 1024px) {
      .mobile-bottom-menu {
        display: flex !important;
      }

      .mobile-bottom-menu a {
        font-size: 0.75rem;
        min-width: 70px;
        padding: 8px 12px;
      }

      .mobile-bottom-menu a i {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
        padding: 12px;
      }

      .top-bar {
        display: none !important;
      }

      .main-navbar .container {
        padding: 12px 20px;
      }

      .navbar-brand img {
        width: 95px !important;
        height: 48px !important;
      }

      .cart-icon a {
        padding: 14px;
      }

      .cart-icon a i {
        font-size: 22px !important;
      }

      .cart-badge {
        top: 4px;
        right: 4px;
        min-width: 20px;
        height: 20px;
        font-size: 0.75rem;
      }

      body {
        padding-bottom: 90px;
        /* Space for bottom menu */
      }

      .mobile-menu-btn {
        padding: 12px 16px !important;
      }

      .mobile-menu-btn i {
        font-size: 1.2rem;
      }
    }

    /* Desktop: 1025px and above (Hide bottom menu, show top bar) */
    @media (min-width: 1025px) {
      .mobile-bottom-menu {
        display: none !important;
      }

      .top-bar {
        display: block !important;
      }

      .top-bar .container {
        padding: 0 40px;
      }

      .main-navbar .container {
        max-width: 1200px;
        padding: 8px 20px;
      }

      .navbar-brand img {
        width: 100px;
        height: 50px;
      }

      body {
        padding-bottom: 0;
      }
    }

    /* Small Mobile: under 480px */
    @media (max-width: 480px) {
      .navbar-brand img {
        width: 75px !important;
        height: 38px !important;
      }

      .mobile-bottom-menu a {
        font-size: 0.65rem;
        padding: 5px 6px;
        min-width: 50px;
      }

      .mobile-bottom-menu a i {
        width: 38px;
        height: 38px;
        font-size: 1rem;
        padding: 9px;
        border-radius: 12px;
      }

      .mobile-bottom-menu a span {
        margin-top: 2px;
      }

      .cart-icon a {
        padding: 8px;
      }

      .cart-icon a i {
        font-size: 16px !important;
      }

      .mobile-menu-btn {
        padding: 8px 12px !important;
      }

      .form-control {
        font-size: 16px;
      }
    }

    /* Extra small screens */
    @media (max-width: 360px) {
      .mobile-bottom-menu a {
        font-size: 0.6rem;
        min-width: 45px;
        padding: 4px 5px;
      }

      .mobile-bottom-menu a i {
        width: 34px;
        height: 34px;
        font-size: 0.9rem;
        padding: 8px;
      }

      .navbar-brand img {
        width: 65px !important;
        height: 32px !important;
      }
    }

    /* Landscape orientation adjustments */
    @media (max-height: 500px) and (orientation: landscape) {
      .mobile-bottom-menu {
        padding: 5px 5px max(5px, env(safe-area-inset-bottom));
      }

      .mobile-bottom-menu a i {
        width: 32px;
        height: 32px;
        padding: 6px;
        font-size: 0.9rem;
      }

      .mobile-bottom-menu a {
        font-size: 0.6rem;
      }

      body {
        padding-bottom: 60px;
      }
    }

    /* Additional UI Elements */
    footer .bi {
      font-size: 1.2rem;
    }

    .text-primary {
      color: var(--primary-color) !important;
    }

    .bg-primary {
      background-color: var(--primary-color) !important;
    }

    .border-primary {
      border-color: var(--primary-color) !important;
    }

    .btn-primary {
      background-color: var(--primary-color) !important;
      border-color: var(--primary-color) !important;
    }

    a,
    a:focus,
    a:hover {
      color: var(--primary-color);
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* Login/Register Page Styles */
    .login-box {
      max-width: 400px;
      margin: 100px auto;
      padding: 30px;
      background: white;
      border-radius: 16px;
      box-shadow: var(--shadow-medium);
      text-align: center;
      width: 90%;
      margin: 20px auto;
    }

    .login-logo img {
      width: 100px;
      margin-bottom: 10px;
      max-width: 80px;
    }

    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.15);
      border-color: var(--primary-color);
    }

    .btn-primary {
      width: 100%;
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-primary:hover {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
    }

    .signup-link {
      margin-top: 15px;
      font-size: 0.9rem;
    }

    .signup-link a {
      color: var(--primary-color);
      text-decoration: none;
    }

    .signup-link a:hover {
      color: var(--accent-color);
    }

    .text-muted {
      color: var(--text-dark) !important;
    }

    .register-box {
      max-width: 500px;
      margin: 80px auto;
      padding: 30px;
      background: #fff;
      border-radius: 16px;
      box-shadow: var(--shadow-medium);
    }

    .register-logo img {
      height: 50px;
    }

    .bottom-text {
      font-size: 0.9rem;
      margin-top: 15px;
    }

    /* Responsive Design for Login/Register */
    @media (max-width: 768px) {
      .login-box {
        margin: 10px auto;
        padding: 25px 20px;
        max-width: 95%;
      }

      .login-logo img {
        max-width: 70px;
      }
    }

    @media (max-width: 480px) {
      .login-box {
        padding: 20px 15px;
        margin: 5px auto;
        border-radius: 12px;
      }

      .login-logo img {
        max-width: 60px;
      }

      .btn-primary {
        padding: 12px;
        font-size: 16px;
      }

      .signup-link {
        font-size: 0.85rem;
      }
    }

    @media (max-width: 320px) {
      .login-box {
        padding: 15px 10px;
      }

      .login-logo img {
        max-width: 50px;
      }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
      .login-box {
        margin: 50px auto;
      }
    }

    @media (min-width: 1200px) {
      .login-box {
        margin: 120px auto;
      }
    }

    @media (max-height: 600px) {
      .login-box {
        margin: 20px auto;
      }

      body {
        align-items: flex-start;
        padding-top: 20px;
      }
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Selection color */
    ::selection {
      background: rgba(111, 66, 193, 0.2);
      color: var(--primary-color);
    }
  </style>
</head>

<body>
  <!-- Enhanced Top Bar -->
  <div class="top-bar">
    <div class="container d-flex justify-content-center">
      <a href="<?= base_url('provider/sing_up'); ?>">
        <i class="fas fa-user-plus"></i>
        <span>Become a Provider</span>
      </a>
    </div>
  </div>

  <!-- Enhanced Main Navigation -->
  <nav class="navbar navbar-expand-lg main-navbar">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Logo -->
      <a class="navbar-brand" href="<?= base_url(); ?>">
        <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="FITCKET Logo" style="width:100px;height:50px">
      </a>

      <!-- Mobile & Tablet Right Section -->
      <div class="d-flex d-lg-none align-items-center gap-3">
        <!-- Cart Icon -->
        <div class="cart-icon">
          <a href="<?= !empty($this->user['id']) ? base_url('cart/view') : base_url('login'); ?>">
            <i class="fas fa-shopping-cart text-primary"></i>
            <span class="cart-badge cartCount">0</span>
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="btn mobile-menu-btn" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Toggle menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <!-- Desktop Navigation -->
      <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
        <?php $segment = $this->uri->segment(1); ?>
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link <?= ($segment == '' ? 'active' : '') ?>" href="<?= base_url(); ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'services' ? 'active' : '') ?>" href="<?= base_url('services'); ?>">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'providers' ? 'active' : '') ?>" href="<?= base_url('providers'); ?>">Providers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'pay_to_gym' ? 'active' : '') ?>" href="<?= base_url('pay_to_gym'); ?>">Pay at Gym</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'session_booking' ? 'active' : '') ?>" href="<?= base_url('session_booking'); ?>">Session</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'fittv' ? 'active' : '') ?>" href="<?= base_url('fittv'); ?>">
              FITTV
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'about-us' ? 'active' : '') ?>" href="<?= base_url('about-us'); ?>">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($segment == 'contact' ? 'active' : '') ?>" href="<?= base_url('contact-us'); ?>">Contact Us</a>
          </li>
        </ul>

        <!-- Desktop Right Section -->
        <div class="d-flex align-items-center gap-3">
          <!-- Cart Icon -->
          <div class="cart-icon">
            <a href="<?= !empty($this->user['id']) ? base_url('cart/view') : base_url('login'); ?>">
              <i class="fas fa-shopping-cart text-primary"></i>
              <span class="cart-badge cartCount">0</span>
            </a>
          </div>

          <!-- Account Section -->
          <div class="dropdown">
            <?php $is_logged_in = isset($this->user); ?>
            <?php if ($is_logged_in): ?>
              <button class="account-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-2"></i>Account
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= base_url('profile'); ?>"><i class="fas fa-user-circle me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('bookings/' . $this->user['id']); ?>"><i class="fas fa-calendar-check me-2"></i>My Bookings</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              </ul>
            <?php else: ?>
              <a href="<?= base_url('login'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Login
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Enhanced Mobile Offcanvas Menu -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="mobileMenuLabel">
        <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="FITCKET Logo" style="width:100px;height:40px">
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>"><i class="fas fa-home me-2"></i>Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('fittv'); ?>">
            <i class="fas fa-play-circle me-2"></i>FITTV
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('about-us'); ?>"><i class="fas fa-info-circle me-2"></i>About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('contact-us'); ?>"><i class="fas fa-envelope me-2"></i>Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('provider/sing_up'); ?>"><i class="fas fa-user-plus me-2"></i>Become Provider</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('refund-policy'); ?>"><i class="fas fa-undo-alt me-2"></i>Refund Policy</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('terms-condition'); ?>"><i class="fas fa-file-contract me-2"></i>Terms & Conditions</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Enhanced Bottom Sticky Menu (Now shows on Mobile AND Tablet) -->
  <div class="mobile-bottom-menu">
    <a href="<?= base_url(); ?>" class="<?= ($segment == '' ? 'active' : '') ?>">
      <i class="fas fa-home"></i>
      <span>Home</span>
    </a>
    <a href="<?= base_url('providers'); ?>" class="<?= ($segment == 'providers' ? 'active' : '') ?>">
      <i class="fas fa-users"></i>
      <span>Providers</span>
    </a>
    <a href="<?= base_url('pay_to_gym'); ?>" class="<?= ($segment == 'pay_to_gym' ? 'active' : '') ?>">
      <i class="fas fa-dumbbell"></i>
      <span>Pay at Gym</span>
    </a>
    <a href="<?= base_url('services'); ?>" class="<?= ($segment == 'services' ? 'active' : '') ?>">
      <i class="fas fa-cogs"></i>
      <span>Services</span>
    </a>

    <a href="<?= base_url('fittv'); ?>" class="<?= ($segment == 'fittv' ? 'active' : '') ?>">
      <i class="fas fa-play-circle"></i>
      <span>FITTV</span>
    </a>
    <a href="<?= $is_logged_in ? base_url('profile') : base_url('login'); ?>" class="<?= ($segment == 'profile' ? 'active' : '') ?>">
      <i class="fas fa-user"></i>
      <span>Profile</span>
    </a>
  </div>