<style>
    :root {
        --primary-color: #6f42c1;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --bg-light: #f8f9fa;
    }


    #heroCarousel {
        position: relative;
        margin-bottom: 120px;
    }

    .swiper {
        padding: 10px 5px 40px;
    }

    .swiper-slide {
        height: auto;
    }

    .carousel-item {
        height: 500px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .carousel-caption {
        position: absolute;
        bottom: 17%;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        padding: 30px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 15px;
        max-width: 85%;
        z-index: 2;
        backdrop-filter: blur(10px);
    }

    .carousel-caption h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .carousel-caption p {
        font-size: 1.2rem;
        margin-bottom: 25px;
        color: rgba(255, 255, 255, 0.9);
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }

    .btn-outline-light {
        border: 2px solid white;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    /* Search Bar Improvements */
    .search-bar-container {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        max-width: 900px;
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        z-index: 100;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
    }

    .search-input-group {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-input-group .input-group-text {
        background: var(--bg-light);
        border: 1px solid #e0e0e0;
        color: var(--primary-color);
        border-radius: 10px 0 0 10px;
    }

    .search-input-group .form-control {
        border: 1px solid #e0e0e0;
        border-left: none;
        padding: 12px 15px;
        border-radius: 0 10px 10px 0;
        font-size: 0.95rem;
    }

    .search-input-group .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        border-color: var(--primary-color);
    }

    .search-btn {
        background: var(--primary-color);
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .search-btn:hover {
        background: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
    }

    /* Service Cards */
    .services-section {
        padding: 80px 0 60px;
        background-color: white;
    }

    .service-card {
        display: flex;
        align-items: center;
        padding: 25px;
        border-radius: 15px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-color);
    }

    .service-icon {
        margin-right: 20px;
        flex-shrink: 0;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .service-title {
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .service-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* Expert Cards */
    .experts-section {
        padding: 60px 0;
    }

    .expert-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
    }

    .expert-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .expert-left {
        display: flex;
        align-items: center;
        padding: 30px;
    }

    .expert-logo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
        background: var(--primary-color);
        overflow: hidden;
    }

    .expert-title {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .expert-services {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .expert-footer {
        padding: 20px 30px;
        background: var(--bg-light);
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .expert-footer span {
        color: var(--primary-color);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .view-more-btn {
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .view-more-btn:hover {
        transform: translateX(5px);
    }

    .view-more-text {
        color: var(--primary-color) !important;
        font-weight: 600;
    }

    /* Edemand Banner */
    .edemand-banner {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 20px;
        padding: 50px;
        color: white;
        display: flex;
        align-items: center;
        margin: 60px 0;
    }

    .banner-text {
        flex: 1;
    }

    .banner-text h2 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 2.5rem;
    }

    .banner-text p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        line-height: 1.6;
        opacity: 0.9;
    }

    .buy-btn {
        background: #ffc107;
        color: #212529;
        border: none;
        padding: 16px 40px;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .buy-btn:hover {
        background: #e0a800;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    /* Section Headings */
    h2.fw-bold {
        color: var(--secondary-color);
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 800;
    }

    .text-primary {
        color: var(--primary-color) !important;
        /* font-size: 1.1rem;
            margin-bottom: 30px !important; */
    }

    /* Mobile Responsive Design */
    @media (max-width: 768px) {
        #heroCarousel {
            margin-bottom: 180px;
            /* More space for mobile search bar */
        }

        .carousel-item {
            height: 350px;
        }

        .carousel-caption {
            bottom: 25%;
            padding: 20px;
            max-width: 90%;
            display: none;
        }

        .carousel-caption h1 {
            font-size: 1.8rem;
            margin-bottom: 12px;
        }

        .carousel-caption p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .carousel-caption .btn {
            display: block;
            width: 100%;
            margin: 8px 0;
            padding: 12px;
            font-size: 1rem;
        }

        /* Mobile Search Bar */
        .search-bar-container {
            bottom: -200px;
            width: 90%;
            padding: 20px;
            flex-direction: column;
            gap: 15px;
        }

        .search-input-group {
            width: 100%;
            min-width: unset;
        }

        .search-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1rem;
        }

        /* Mobile Services */
        .services-section {
            padding: 100px 0 60px;
        }

        .service-card {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .service-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }

        /* Mobile Expert Cards */
        .expert-left {
            flex-direction: column;
            text-align: center;
            padding: 25px;
        }

        .expert-logo {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .expert-footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
            padding: 20px;
        }

        /* Mobile Banner */
        .edemand-banner {
            padding: 30px 20px;
            text-align: center;
            flex-direction: column;
        }

        .banner-text h2 {
            font-size: 1.8rem;
        }

        .banner-text p {
            font-size: 1rem;
        }

        .buy-btn {
            width: 100%;
            padding: 15px;
        }

        /* Mobile Typography */
        h2.fw-bold {
            font-size: 2rem;
            text-align: center;
        }

        .text-primary {
            /* font-size: 1rem; */
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .carousel-item {
            height: 300px;
        }

        .carousel-caption {
            bottom: 20%;
            padding: 15px;
            display: none;
        }

        .carousel-caption h1 {
            font-size: 1.5rem;
        }

        .carousel-caption p {
            font-size: 0.9rem;
        }

        .search-bar-container {
            bottom: -190px;
            width: 95%;
            padding: 15px;
        }

        .service-card {
            padding: 15px;
        }

        .expert-left {
            padding: 20px;
        }

        .edemand-banner {
            padding: 25px 15px;
        }

        .banner-text h2 {
            font-size: 1.6rem;
        }

        h2.fw-bold {
            font-size: 1.8rem;
        }
    }

    /* Additional Mobile Fixes */
    @media (max-width: 576px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .row {
            margin-left: -10px;
            margin-right: -10px;
        }

        .row>* {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
</style>
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php $first = true; ?>
        <?php foreach ($sliders as $slide): ?>
            <div class="carousel-item <?= $first ? 'active' : '' ?>"
                style="background-image: url('<?= base_url('uploads/slider/' . $slide->slider_image); ?>');">
                <div class="carousel-caption">
                    <h1><?= htmlspecialchars($slide->slider_title) ?></h1>
                    <p><?= htmlspecialchars($slide->sub_title) ?></p>
                    <div class="mt-3 d-flex flex-wrap justify-content-center">
                        <a href="<?= base_url('providers'); ?>" class="btn btn-warning me-2 mb-2">Book Now</a>
                        <a href="<?= base_url('services'); ?>" class="btn btn-outline-light mb-2">Explore Services</a>
                    </div>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

    <!-- Improved Floating Search Bar -->
    <div class="search-bar-container">
        <div class="search-input-group">
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                <input type="text" id="locationInput" class="form-control" placeholder="Your location"
                    value="<?= !empty($user_location) ? $user_location : ''; ?>">
            </div>
        </div>
        <div class="search-input-group">
            <div class="input-group">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search Service">
            </div>
        </div>
        <button class="search-btn">Search</button>
    </div>
</div>


<!-- Category Section (Slider) -->
<section class="services-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold">Choose Your Category</h2>
                <p class="text-primary">Discover tailored services for your needs</p>
            </div>
            <!-- <a href="#" class="text-dark fw-semibold d-none d-md-block">View All</a> -->
        </div>

        <div class="swiper categorySwiper">
            <div class="swiper-wrapper">
                <?php foreach ($category as $cat): ?>
                    <div class="swiper-slide">
                        <div class="service-card">
                            <div class="service-icon">
                                <img src="<?= base_url($cat->image); ?>" alt="<?= $cat->name; ?>"
                                    style="width:60px; height:60px; border-radius:50%; object-fit:cover;">
                            </div>
                            <div>
                                <div class="service-title"><?= strtoupper($cat->name); ?></div>
                                <div class="service-subtitle">2 Providers</div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>



<!-- Nearest Providers Section (Slider) -->
<section class="experts-section bg-light">
    <div class="container">
        <h2 class="fw-bold">Nearest Providers</h2>
        <p class="text-primary mb-4">Providers closest to your location!</p>

        <div class="swiper nearestSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($nearest_providers as $np): ?>
                    <div class="swiper-slide">
                        <div class="expert-card">
                            <div class="expert-left">
                               <div class="expert-logo">
    <img 
        src="<?= base_url(!empty($np->profile_image) ? $np->profile_image : 'assets/images/3d-cartoon-fitness-man.jpg') ?>" 
        alt="<?= $np->gym_name ?: $np->name ?>" 
        class="img-fluid rounded-circle" 
        style="width:60px; height:60px; object-fit:cover;"
    >
</div>

                                <div>
                                    <div class="expert-title"><?= $np->gym_name ?: $np->name ?></div>
                                    <div class="expert-services"><?= $np->total_services ?> Services</div>
                                </div>
                            </div>
                            <div class="expert-footer">
                                <span>
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                    <?php if (!is_null($np->distance)): ?>
                                        <?= round($np->distance, 1) ?> Km
                                    <?php else: ?>
                                        <span> N/A</span>
                                    <?php endif; ?>
                                </span>
                                <a href="<?= site_url('provider_details/' . $np->provider_id) ?>" class="view-more-btn">
                                    <span class="text-warning"><i class="fa fa-chevron-right"></i></span>
                                    <span class="view-more-text">View More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>


<!-- Improved Edemand Banner -->
<section class="container">
    <div class="edemand-banner">
        <div class="banner-text">
            <h2>Want to Become a Service Provider?</h2>
            <p>Join our platform and grow your business by reaching thousands of customers effortlessly. Start offering
                your services online with ease and flexibility.</p>
            <a class="buy-btn btn" href="<?= base_url('provider/sing_up'); ?>">Become a Provider</a>

        </div>
    </div>
</section>

<!-- Gym Section (Slider) -->
<section class="experts-section">
    <div class="container">
        <h2 class="fw-bold">Popular Gym</h2>
        <p class="text-primary">Trusted Professionals Ready To Assist You Anytime, Anywhere!</p>

        <div class="swiper gymSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($gym_providers as $provider): ?>
                    <div class="swiper-slide">
                        <div class="expert-card">
                            <div class="expert-left">
                                <div class="expert-logo bg-primary">
                                    <img src="<?= !empty($provider->profile_image) ? base_url($provider->profile_image) : base_url('assets/images/3d-cartoon-fitness-man.jpg'); ?>"
                                        alt="<?= $provider->gym_name; ?>" class="img-fluid rounded-circle"
                                        style="width:60px;height:60px;object-fit:cover;">
                                </div>
                                <div>
                                    <div class="expert-title"><?= $provider->gym_name; ?></div>
                                    <div class="expert-services"><?= $provider->total_services ?? '0'; ?> Services</div>
                                </div>
                            </div>
                            <div class="expert-footer">
                                <span>
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                    <?= isset($provider->distance) ? round($provider->distance, 1) . ' Km' : 'N/A' ?>
                                </span>
                                <a href="<?= site_url('provider_details/' . $provider->provider_id) ?>"
                                    class="view-more-btn">
                                    <span class="text-warning"><i class="fa fa-chevron-right"></i></span>
                                    <span class="view-more-text">View More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<section class="container">
    <div class="edemand-banner">
        <div class="banner-text">
            <h2>FitPro Gym – Special Offer!</h2>
            <p>Get 20% off on your first membership. Join today and start your fitness journey with professional
                trainers and modern facilities.</p>
            <a class="buy-btn btn" href="<?= base_url('services'); ?>">Book Now</a>

        </div>
    </div>
</section>


<!-- Trainer Section (Slider) -->
<section class="experts-section bg-light">
    <div class="container">
        <h2 class="fw-bold">Popular Trainer</h2>
        <p class="text-primary">Trusted Professionals Ready To Assist You Anytime, Anywhere!</p>

        <div class="swiper trainerSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($trainer_providers as $provider): ?>
                    <div class="swiper-slide">
                        <div class="expert-card">
                            <div class="expert-left">
                                <div class="expert-logo bg-dark">
                                    <img src="<?= !empty($provider->profile_image) ? base_url($provider->profile_image) : base_url('assets/images/3d-cartoon-fitness-man.jpg'); ?>"
                                        alt="<?= $provider->name; ?>" class="img-fluid rounded-circle"
                                        style="width:60px;height:60px;object-fit:cover;">
                                </div>
                                <div>
                                    <div class="expert-title"><?= $provider->gym_name; ?></div>
                                    <div class="expert-services"><?= $provider->total_services ?? '0'; ?> Services</div>
                                </div>
                            </div>
                            <div class="expert-footer">
                                <span>
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                    <?= isset($provider->distance) ? round($provider->distance, 1) . ' Km' : 'N/A' ?>
                                </span>
                                <a href="<?= site_url('provider_details/' . $provider->provider_id) ?>"
                                    class="view-more-btn">
                                    <span class="text-warning"><i class="fa fa-chevron-right"></i></span>
                                    <span class="view-more-text">View More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>