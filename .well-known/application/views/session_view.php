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

        

        

        <div class="row">
           

            <!-- Sessions Grid -->
            <div class="col-lg-12">
                
                <!-- Results Info & Sort -->
                <div class="results-info">
                    <div class="d-flex align-items-center gap-3">
                        <span class="results-count">
                            Showing <strong>1-12</strong> of <strong>256</strong> sessions
                        </span>
                        <div class="view-toggle d-none d-md-flex">
                            <button class="view-btn active" title="Grid View">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="view-btn" title="List View">
                                <i class="fa fa-list"></i>
                            </button>
                        </div>
                    </div>
                    <select class="form-select sort-select">
                        <option selected>Sort by: Most Popular</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Rating: High to Low</option>
                        <option>Duration: Short to Long</option>
                    </select>
                </div>

                <!-- Quick Filters -->
                <div class="quick-filters">
                    <button class="quick-filter-btn active">
                        <i class="fa fa-fire me-1"></i>Trending
                    </button>
                    <button class="quick-filter-btn">
                        <i class="fa fa-bolt me-1"></i>Today
                    </button>
                    <button class="quick-filter-btn">
                        <i class="fa fa-calendar-week me-1"></i>This Week
                    </button>
                    <button class="quick-filter-btn">
                        <i class="fa fa-percent me-1"></i>Discounted
                    </button>
                    <button class="quick-filter-btn">
                        <i class="fa fa-gift me-1"></i>Free
                    </button>
                </div>

                <!-- Featured Session -->
                <div class="featured-session mb-4 fade-in">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <div class="featured-image">
                                <span class="featured-badge">
                                    <i class="fa fa-star me-1"></i>Featured
                                </span>
                                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800" alt="Featured Session">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="featured-content">
                                <span class="session-category">HIIT Training</span>
                                <h3 class="featured-title">30-Day Full Body Transformation Challenge</h3>
                                <p class="featured-description">
                                    Join our intensive 30-day program designed to transform your body and mind. 
                                    Led by expert trainer John Smith, this comprehensive program includes daily workouts, 
                                    nutrition guidance, and community support.
                                </p>
                                <div class="d-flex align-items-center gap-4 mb-3">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Starts Jan 15, 2025</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>45 mins/day</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-users"></i>
                                        <span>234 enrolled</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="session-price">₹1,999</span>
                                        <span class="original-price">₹3,999</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">
                                        <i class="fa fa-bolt me-2"></i>Enroll Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sessions Grid -->
                <div class="row g-4">
                    
                    <!-- Session Card 1 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500" alt="Session">
                                <span class="session-badge badge-live">
                                    <i class="fa fa-circle me-1"></i>Live
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Strength Training</span>
                                <h5 class="session-title">Power Lifting Fundamentals for Beginners</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Today, 6:00 PM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>45 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1567515004624-219c11d31f2e?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Mike Johnson</h6>
                                        <span>Certified Trainer</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.8</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹499 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 2 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500" alt="Session">
                                <span class="session-badge badge-upcoming">
                                    <i class="fa fa-clock me-1"></i>Upcoming
                                </span>
                                <span class="session-type-badge type-offline" title="Offline">
                                    <i class="fa fa-building"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Yoga</span>
                                <h5 class="session-title">Morning Vinyasa Flow - Sunrise Session</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Tomorrow, 6:00 AM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>60 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1594381898411-846e7d193883?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Sarah Williams</h6>
                                        <span>Yoga Expert</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.9</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹399 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 3 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500" alt="Session">
                                <span class="session-badge badge-recorded">
                                    <i class="fa fa-play me-1"></i>Recorded
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">HIIT</span>
                                <h5 class="session-title">20-Min Fat Burning HIIT Workout</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-video"></i>
                                        <span>On-demand</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>20 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>David Lee</h6>
                                        <span>HIIT Specialist</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.7</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹199 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Watch Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 4 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1549576490-b0b4831ef60a?w=500" alt="Session">
                                <span class="session-badge badge-live">
                                    <i class="fa fa-circle me-1"></i>Live
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Dance Fitness</span>
                                <h5 class="session-title">Zumba Party - High Energy Dance Session</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Today, 7:30 PM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>50 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Emily Rose</h6>
                                        <span>Zumba Instructor</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.9</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹349 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 5 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=500" alt="Session">
                                <span class="session-badge badge-upcoming">
                                    <i class="fa fa-clock me-1"></i>Upcoming
                                </span>
                                <span class="session-type-badge type-offline" title="Offline">
                                    <i class="fa fa-building"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Boxing</span>
                                <h5 class="session-title">Boxing Basics - Learn the Fundamentals</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Jan 12, 5:00 PM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>60 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>James Wilson</h6>
                                        <span>Boxing Coach</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.8</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹599 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 6 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?w=500" alt="Session">
                                <span class="session-badge badge-recorded">
                                    <i class="fa fa-play me-1"></i>Recorded
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Pilates</span>
                                <h5 class="session-title">Core Strengthening Pilates - Mat Work</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-video"></i>
                                        <span>On-demand</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>40 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Lisa Chen</h6>
                                        <span>Pilates Instructor</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.6</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹299 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Watch Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 7 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=500" alt="Session">
                                <span class="session-badge badge-live">
                                    <i class="fa fa-circle me-1"></i>Live
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Cardio</span>
                                <h5 class="session-title">Spin Class - Intense Cycling Workout</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Today, 8:00 PM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>45 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Tom Hardy</h6>
                                        <span>Cycling Coach</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.7</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹449 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 8 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=500" alt="Session">
                                <span class="session-badge badge-upcoming">
                                    <i class="fa fa-clock me-1"></i>Upcoming
                                </span>
                                <span class="session-type-badge type-offline" title="Offline">
                                    <i class="fa fa-building"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">CrossFit</span>
                                <h5 class="session-title">CrossFit WOD - Workout of the Day</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>Jan 13, 7:00 AM</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>60 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Chris Evans</h6>
                                        <span>CrossFit Coach</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.9</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        ₹699 <span>/session</span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Card 9 -->
                    <div class="col-md-6 col-xl-4">
                        <div class="session-card fade-in">
                            <div class="session-image">
                                <img src="https://images.unsplash.com/photo-1593476087123-36d1de271f08?w=500" alt="Session">
                                <span class="session-badge badge-recorded">
                                    <i class="fa fa-play me-1"></i>Recorded
                                </span>
                                <span class="session-type-badge type-online" title="Online">
                                    <i class="fa fa-wifi"></i>
                                </span>
                            </div>
                            <div class="session-body">
                                <span class="session-category">Stretching</span>
                                <h5 class="session-title">Full Body Stretch & Recovery Session</h5>
                                <div class="session-meta">
                                    <div class="session-meta-item">
                                        <i class="fa fa-video"></i>
                                        <span>On-demand</span>
                                    </div>
                                    <div class="session-meta-item">
                                        <i class="fa fa-clock"></i>
                                        <span>30 mins</span>
                                    </div>
                                </div>
                                <div class="session-instructor">
                                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=100" 
                                         alt="Instructor" class="instructor-avatar">
                                    <div class="instructor-info">
                                        <h6>Amy Parker</h6>
                                        <span>Flexibility Coach</span>
                                    </div>
                                    <div class="instructor-rating">
                                        <i class="fa fa-star"></i>
                                        <span>4.8</span>
                                    </div>
                                </div>
                                <div class="session-footer">
                                    <div class="session-price">
                                        Free <span class="text-success">
                                            <i class="fa fa-gift ms-2"></i>
                                        </span>
                                    </div>
                                    <button class="btn btn-primary btn-book">Watch Free</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fa fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>

   

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Price Range Slider
        document.getElementById('priceRange').addEventListener('input', function() {
            document.getElementById('priceValue').textContent = '₹' + Number(this.value).toLocaleString();
        });

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