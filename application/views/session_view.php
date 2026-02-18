 <style>
        :root {
            --primary-color: #6c5ce7;
            --primary-dark: #5a4fcf;
            --primary-light: #a29bfe;
            --secondary-color: #2d3436;
            --accent-color: #fd79a8;
            --warning-color: #fdcb6e;
            --success-color: #00b894;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #2d3436;
            --text-muted: #636e72;
            --border-color: #e9ecef;
            --border-radius: 12px;
            --shadow: 0 4px 20px rgba(108, 92, 231, 0.08);
            --shadow-hover: 0 8px 30px rgba(108, 92, 231, 0.15);
            --shadow-lg: 0 10px 40px rgba(108, 92, 231, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        
        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            color: var(--white);
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        /* Breadcrumb */
        .breadcrumb-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 0.75rem 1rem;
            margin-top: -1.5rem;
            position: relative;
            z-index: 10;
            border: 1px solid var(--border-color);
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .breadcrumb-item a:hover {
            background: var(--primary-light);
            color: var(--white);
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        /* Filter Section */
        .filter-section {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-title i {
            color: var(--primary-color);
        }

        .filter-group {
            margin-bottom: 1rem;
        }

        .filter-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.15);
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* Session Card */
        .session-card {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
            position: relative;
            border: 1px solid var(--border-color);
        }

        .session-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .session-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .session-card:hover::before {
            transform: scaleX(1);
        }

        .session-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .session-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .session-card:hover .session-image img {
            transform: scale(1.1);
        }

        .session-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-live {
            background: var(--accent-color);
            color: var(--white);
            animation: pulse 2s infinite;
        }

        .badge-upcoming {
            background: var(--warning-color);
            color: var(--text-dark);
        }

        .badge-recorded {
            background: var(--success-color);
            color: var(--white);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .session-type-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1rem;
        }

        .type-online {
            background: var(--gradient-info);
        }

        .type-offline {
            background: var(--gradient-warning);
        }

        .session-body {
            padding: 1.25rem;
        }

        .session-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .session-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .session-title:hover {
            color: var(--primary-color);
        }

        .session-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .session-meta-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .session-meta-item i {
            color: var(--primary-color);
        }

        .session-instructor {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--light-bg);
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .instructor-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .instructor-info h6 {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.15rem;
            color: var(--text-dark);
        }

        .instructor-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .instructor-rating {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            color: var(--warning-color);
            font-weight: 600;
        }

        .session-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .session-price {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .session-price span {
            font-size: 0.85rem;
            font-weight: 400;
            color: var(--text-muted);
        }

        .session-price .original-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 400;
            margin-left: 0.5rem;
        }

        .btn-book {
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
        }

        /* Stats Cards */
        .stats-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
            border-top: 4px solid transparent;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stats-card.purple { border-top-color: #667eea; }
        .stats-card.pink { border-top-color: #f5576c; }
        .stats-card.green { border-top-color: #00b894; }
        .stats-card.orange { border-top-color: #fdcb6e; }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: var(--white);
        }

        .stats-card.purple .stats-icon { background: var(--gradient-primary); }
        .stats-card.pink .stats-icon { background: var(--gradient-warning); }
        .stats-card.green .stats-icon { background: var(--gradient-success); }
        .stats-card.orange .stats-icon { background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); }

        .stats-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stats-label {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Category Pills */
        .category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .category-pill {
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            border: 2px solid var(--border-color);
            background: var(--white);
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .category-pill:hover,
        .category-pill.active {
            background: var(--gradient-primary);
            border-color: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .category-pill i {
            font-size: 1rem;
        }

        /* Sidebar Filter */
        .sidebar-filter {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            position: sticky;
            top: 1rem;
        }

        .sidebar-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary-light);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-title i {
            color: var(--primary-color);
        }

        .filter-item {
            margin-bottom: 1.25rem;
        }

        .filter-item-title {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .form-check {
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.25rem;
            border-radius: 6px;
            transition: var(--transition);
        }

        .form-check:hover {
            background: var(--light-bg);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: var(--text-dark);
            cursor: pointer;
        }

        .price-range-display {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .form-range::-webkit-slider-thumb {
            background: var(--primary-color);
        }

        /* Pagination */
        .pagination {
            gap: 0.5rem;
        }

        .page-link {
            border-radius: 8px;
            border: none;
            color: var(--primary-color);
            background: var(--white);
            box-shadow: var(--shadow);
            padding: 0.6rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .page-link:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--gradient-primary);
            color: var(--white);
        }

        /* Results Info */
        .results-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .results-count {
            font-weight: 500;
            color: var(--text-muted);
        }

        .results-count strong {
            color: var(--primary-color);
        }

        .sort-select {
            min-width: 200px;
        }

        /* View Toggle */
        .view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            background: var(--white);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .view-btn:hover,
        .view-btn.active {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--white);
        }

        /* Featured Session */
        .featured-session {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            position: relative;
        }

        .featured-session::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
        }

        .featured-badge {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            padding: 0.5rem 1rem;
            background: var(--gradient-primary);
            color: var(--white);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .featured-image {
            height: 300px;
            overflow: hidden;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .featured-content {
            padding: 2rem;
        }

        .featured-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .featured-description {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Quick Filters */
        .quick-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .quick-filter-btn {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            border: 2px solid var(--border-color);
            background: var(--white);
            color: var(--text-dark);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .quick-filter-btn:hover,
        .quick-filter-btn.active {
            border-color: var(--primary-color);
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-color);
        }

        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: var(--white);
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 1.25rem;
            font-size: 1.1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--white);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .sidebar-filter {
                position: static;
                margin-bottom: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 767px) {
            .hero-section {
                padding: 2rem 0;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .results-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .sort-select {
                width: 100%;
            }

            .category-pills {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 0.5rem;
            }

            .category-pill {
                flex-shrink: 0;
            }

            .session-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .featured-content {
                padding: 1.5rem;
            }

            .featured-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 575px) {
            .session-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-book {
                width: 100%;
            }

            .breadcrumb-container {
                margin-top: -1rem;
            }

            .filter-section {
                padding: 1rem;
            }
        }

        /* Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .session-card:nth-child(1) { animation-delay: 0.1s; }
        .session-card:nth-child(2) { animation-delay: 0.2s; }
        .session-card:nth-child(3) { animation-delay: 0.3s; }
        .session-card:nth-child(4) { animation-delay: 0.4s; }
        .session-card:nth-child(5) { animation-delay: 0.5s; }
        .session-card:nth-child(6) { animation-delay: 0.6s; }
        /* Fully Booked Badge */
.session-badge.badge-full {
    background: rgba(220, 53, 69, 0.9);
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 3;
    padding: 8px 16px;
    font-size: 16px;
    font-weight: 600;
}

/* Already Booked Badge */
.session-badge.badge-booked {
    background: rgba(40, 167, 69, 0.9);
    color: white;
    position: absolute;
    bottom: 10px;
    right: 10px;
    z-index: 3;
}

/* Dimmed card when full */
.session-card.session-full {
    opacity: 0.7;
}

.session-card.session-full .session-image::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 2;
}

/* Availability text colors */
.text-danger {
    color: #dc3545 !important;
}

.text-success {
    color: #28a745 !important;
}
    </style>


    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title">Explore Our Sessions</h1>
                <p class="hero-subtitle">Join live classes, access recorded sessions, and transform your fitness journey</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-4">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb-container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fa fa-home me-1"></i>Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fa fa-calendar-alt me-1"></i>Sessions
                    </li>
                </ol>
            </nav>
        </div>

        

        

       <div class="row g-4">

<?php if (!empty($sessions)): ?>
<?php foreach ($sessions as $session): ?>

<?php
    // Badge logic
    $badgeClass = 'badge-upcoming';
    $badgeIcon  = 'fa-clock';
    $badgeText  = 'Upcoming';

    if ($session['session_date'] == date('Y-m-d')) {
        $badgeClass = 'badge-live';
        $badgeIcon  = 'fa-circle';
        $badgeText  = 'Live';
    }

    // Price text
    $priceText = ($session['price'] > 0)
        ? '₹' . number_format($session['price'])
        : 'Free';

    // Thumbnail
    $image = !empty($session['thumbnail'])
        ? base_url('uploads/session_thumbnails/' . $session['thumbnail'])
        : base_url('assets/img/session-default.jpg');
    
    // ✅ Availability
    $availability = $session['availability'];
    $isFullyBooked = !$availability['available'];
    $userBooked = $session['user_booked'];
?>

<div class="col-md-6 col-xl-4">
    <div class="session-card fade-in <?= $isFullyBooked ? 'session-full' : '' ?>">

        <div class="session-image">
            <img src="<?= $image ?>" alt="<?= htmlspecialchars($session['title']) ?>">

            <span class="session-badge <?= $badgeClass ?>">
                <i class="fa <?= $badgeIcon ?> me-1"></i><?= $badgeText ?>
            </span>

            <span class="session-type-badge type-online" title="Online">
                <i class="fa fa-wifi"></i>
            </span>
            
            <!-- ✅ Fully Booked Badge -->
            <?php if ($isFullyBooked): ?>
            <span class="session-badge badge-full">
                <i class="fa fa-lock me-1"></i>Fully Booked
            </span>
            <?php endif; ?>
            
            <!-- ✅ Already Booked Badge -->
            <?php if ($userBooked): ?>
            <span class="session-badge badge-booked">
                <i class="fa fa-check-circle me-1"></i>Booked
            </span>
            <?php endif; ?>
        </div>

        <div class="session-body">

            <span class="session-category">
                <?= htmlspecialchars($session['category'] ?? 'General') ?>
            </span>

            <h5 class="session-title">
                <?= htmlspecialchars($session['title']) ?>
            </h5>

            <!-- PROVIDER INFO -->
            <?php
                $providerImage = !empty($session['profile_image'])
                    ? base_url($session['profile_image'])
                    : base_url('assets/images/no-image.png');
            ?>
            <div class="session-provider d-flex align-items-center mb-3">
                <img src="<?= $providerImage ?>"
                     class="rounded-circle me-2"
                     width="36"
                     height="36"
                     alt="<?= htmlspecialchars($session['gym_name']) ?>">

                <span class="provider-name fw-semibold">
                    <?= htmlspecialchars($session['gym_name'] ?? 'Unknown Provider') ?>
                </span>
            </div>
            
            <div class="session-meta">
                <div class="session-meta-item">
                    <i class="fa fa-calendar-alt"></i>
                    <span>
                        <?= date('M d, Y', strtotime($session['session_date'])) ?>,
                        <?= date('h:i A', strtotime($session['start_time'])) ?>
                    </span>
                </div>

                <div class="session-meta-item">
                    <i class="fa fa-clock"></i>
                    <span><?= $session['duration_minutes'] ?> mins</span>
                </div>
                
                <!-- ✅ Show availability for group sessions -->
                <?php if ($session['session_type'] == 'group'): ?>
                <div class="session-meta-item">
                    <i class="fa fa-users"></i>
                    <span>
                        <?php if ($isFullyBooked): ?>
                            <strong class="text-danger">Fully Booked</strong>
                        <?php else: ?>
                            <strong class="text-success"><?= $availability['available_spots'] ?></strong> 
                            / <?= $session['max_participants'] ?> spots left
                        <?php endif; ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div class="session-footer">
                <div class="session-price">
                    <?= $priceText ?>
                    <?php if ($session['price'] > 0): ?>
                        <span>/session</span>
                    <?php endif; ?>
                </div>

                <!-- ✅ Updated button logic -->
                <?php if ($userBooked): ?>
                    <a href="<?= base_url('session_booking/my_sessions') ?>" 
                       class="btn btn-success btn-book">
                        <i class="fa fa-check-circle me-1"></i> View Booking
                    </a>
                <?php elseif ($isFullyBooked): ?>
                    <button class="btn btn-secondary btn-book" disabled>
                        <i class="fa fa-lock me-1"></i> Fully Booked
                    </button>
                <?php else: ?>
                    <a href="<?= base_url('session_booking/pay/' . $session['id']) ?>"
                       class="btn btn-primary btn-book">
                        <?= ($session['price'] > 0) ? 'Book Now' : 'Join Free' ?>
                    </a>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<?php endforeach; ?>
<?php else: ?>
    <div class="col-12 text-center py-5">
        <h5>No sessions available</h5>
    </div>
<?php endif; ?>

</div>

    </div>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Price Range Slider
        // document.getElementById('priceRange').addEventListener('input', function() {
        //     document.getElementById('priceValue').textContent = '₹' + Number(this.value).toLocaleString();
        // });

        // Category Pill Toggle
        document.querySelectorAll('.category-pill').forEach(pill => {
            pill.addEventListener('click', function() {
                document.querySelectorAll('.category-pill').forEach(p => p.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Quick Filter Toggle
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.quick-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // View Toggle
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>