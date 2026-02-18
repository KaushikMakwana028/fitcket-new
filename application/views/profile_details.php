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
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            line-height: 1.6;
        } */

    /* Breadcrumb Styles */
    .breadcrumb-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 0.75rem 1rem;
        margin: 0.75rem;
        border: 1px solid var(--border-color);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
    }

    .breadcrumb-item a:hover {
        background: var(--primary-light);
        color: var(--white);
    }

    .breadcrumb-item.active {
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
    }

    @media (min-width: 576px) {
        .breadcrumb-container {
            margin: 1rem;
            padding: 1rem 1.25rem;
        }

    }

    @media (min-width: 768px) {
        .breadcrumb-container {
            margin: 1rem auto;
            max-width: 95%;
        }
    }

    @media (min-width: 992px) {
        .breadcrumb-container {
            max-width: 1170px;
        }
    }

    /* .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            margin: 2rem auto;
            padding: 2rem;
            max-width: 1200px;
        } */

    .provider-card {
        border-radius: var(--border-radius);
        border: none;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        background: white;
        transform: translateY(0);
        transition: var(--transition);
        position: relative;
    }

    .provider-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .provider-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .provider-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        transition: var(--transition);
    }

    .provider-img:hover {
        transform: scale(1.02);
    }

    .star-rating {
        color: #ffd700;
        font-size: 16px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .service-box {
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .service-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient-success);
        opacity: 0;
        transition: var(--transition);
    }

    .service-box:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .service-box:hover::before {
        opacity: 1;
    }

    .service-img {
        width: 100px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .service-img:hover {
        transform: scale(1.05);
    }

    .custom-tabs {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        padding: 1rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 2rem;
    }

    .custom-tabs .nav-link {
        background: white;
        border-radius: 8px;
        color: var(--secondary-color);
        font-weight: 600;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        border: 2px solid transparent;
        margin: 0 0.25rem;
        position: relative;
        overflow: hidden;
    }

    .custom-tabs .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--gradient-primary);
        transition: var(--transition);
        z-index: -1;
    }

    .custom-tabs .nav-link:hover::before,
    .custom-tabs .nav-link.active::before {
        left: 0;
    }

    .custom-tabs .nav-link.active {
        color: white !important;
        border-color: var(--primary-color);
        box-shadow: var(--shadow-md);
        background-color: var(--primary-color);
    }

    .custom-tabs .nav-link:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        background: white;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .badge {
        /* padding: 0.5rem 1rem; */
        border-radius: 20px;
        font-weight: 500;
        transition: var(--transition);
        border: 1px solid transparent;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    .badge.bg-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        color: var(--primary-color) !important;
        border-color: var(--primary-color);
    }

    .badge.bg-info {
        /* background: var(--gradient-success) !important; */
        border: none;
    }

    .list-group-item {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 8px !important;
        margin-bottom: 0.5rem;
        transition: var(--transition);
        background: white;
        position: relative;
        overflow: hidden;
    }

    .list-group-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient-primary);
        opacity: 0;
        transition: var(--transition);
    }

    .list-group-item:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: translateX(5px);
    }

    .list-group-item:hover::before {
        opacity: 1;
    }

    .list-group-item input[type="radio"]:checked+* {
        font-weight: 600;
        color: var(--primary-color);
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: var(--transition);
        z-index: -1;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: var(--gradient-primary);
        border: none;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: white;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }

    .input-group .form-control {
        border: 2px solid rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-control {
        border-radius: 8px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        background: white;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        background: white;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 0.25rem;
        border: none;
        color: var(--primary-color);
        background: white;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .pagination .page-link:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-primary);
        border: none;
        box-shadow: var(--shadow-md);
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .bg-primary {
        background: var(--gradient-primary) !important;
    }

    .card-header {
        background: var(--gradient-primary) !important;
        border-bottom: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    /* Animation classes */
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

    /* Stagger animation for cards */
    .service-box:nth-child(1) {
        animation-delay: 0.1s;
    }

    .service-box:nth-child(2) {
        animation-delay: 0.2s;
    }

    .service-box:nth-child(3) {
        animation-delay: 0.3s;
    }

    .service-box:nth-child(4) {
        animation-delay: 0.4s;
    }

    .badge:nth-child(1) {
        animation-delay: 0.1s;
    }

    .badge:nth-child(2) {
        animation-delay: 0.2s;
    }

    .badge:nth-child(3) {
        animation-delay: 0.3s;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        /* .container {
                margin: 1rem;
                padding: 1rem;
            } */

        .custom-tabs .nav-link {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
        }

        .provider-img {
            height: 150px;
        }
    }

    /* Loading animation */
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(102, 126, 234, 0.3);
        border-left-color: var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Enhanced map styling */
    .map-container {
        position: relative;
        overflow: hidden;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .map-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        pointer-events: none;
        z-index: 1;
    }

    /* Schedule cards enhancement */
    .schedule-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .schedule-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gradient-success);
        opacity: 0;
        transition: var(--transition);
    }

    .schedule-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .schedule-card:hover::before {
        opacity: 1;
    }

    /* Contact info icons */
    .contact-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        transition: var(--transition);
    }

    .contact-icon.user {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .contact-icon.email {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }

    .contact-icon.phone {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .contact-icon.location {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
    }

    .contact-icon:hover {
        transform: scale(1.1) rotate(5deg);
    }

    /* Review Card Styles */
    .review-card {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .review-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .reviewer-name {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reviewer-name i {
        color: #007bff;
        font-size: 1.2rem;
    }

    .review-stars {
        color: #ffc107;
        font-size: 1rem;
    }

    .review-stars i {
        margin: 0 2px;
    }

    .review-text {
        color: #555;
        line-height: 1.6;
        margin: 0;
        word-wrap: break-word;
    }

    .review-date {
        color: #999;
        font-size: 0.85rem;
        margin-top: 10px;
        display: block;
    }

    /* Star Rating Input Styles */
    .star-rating-input {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .star-rating-input label {
        cursor: pointer;
        color: #ffc107;
        font-weight: 500;
    }

    /* Scroll Container */
    .reviews-scroll-container {
        padding-right: 10px;
        max-height: 600px;
        overflow-y: auto;
    }

    .reviews-scroll-container::-webkit-scrollbar {
        width: 8px;
    }

    .reviews-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .reviews-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .reviews-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* =============== Certificate Btn ==================== */

    .certificate-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 50px;
        text-decoration: none;
        color: #fff;
        background: var(--gradient-primary);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .certificate-btn i {
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .certificate-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        color: #fff;
    }

    .certificate-btn:hover i {
        transform: translateX(3px);
    }

    .certificate-btn:active {
        transform: scale(0.96);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-card {
            padding: 15px;
        }

        .reviews-scroll-container {
            max-height: 500px !important;
        }
    }

    @media (max-width: 576px) {
        .reviewer-name {
            font-size: 0.95rem;
        }

        .review-stars {
            font-size: 0.9rem;
        }

        .review-text {
            font-size: 0.9rem;
        }

        .header-section {
            flex-direction: column !important;
            gap: 10px;
        }

        .header-section .btn {
            width: 100%;
        }
    }

    /* ========== NEW SECTIONS STYLES ========== */

    /* Gallery Styles */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1rem 0;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        aspect-ratio: 1;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: var(--transition);
        z-index: 1;
    }

    .gallery-item:hover::before {
        opacity: 1;
    }

    /* Certification Styles */
    .certification-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
        position: relative;
        overflow: hidden;
    }

    .certification-card::before {
        content: '\f0a3';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 3rem;
        color: var(--primary-light);
        opacity: 0.2;
    }

    .certification-card:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .certification-title {
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .certification-issuer {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .certification-year {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: var(--gradient-primary);
        color: white;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    /* Experience Badge */
    .experience-badge {
        background: var(--gradient-success);
        color: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .experience-badge:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-hover);
    }

    .experience-number {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .experience-text {
        font-size: 1.1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Language Chips */
    .language-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: white;
        border: 2px solid var(--primary-light);
        border-radius: 50px;
        color: var(--primary-color);
        font-weight: 600;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .language-chip:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .language-chip i {
        font-size: 1.2rem;
    }

    /* Service Type Toggle */
    .service-type-container {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .service-type-badge {
        flex: 1;
        min-width: 200px;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .service-type-badge.online {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .service-type-badge.offline {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .service-type-badge:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .service-type-badge i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .service-type-badge h5 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .service-type-badge p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.25rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border-top: 3px solid var(--primary-color);
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
    }

    .info-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .info-card-title {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .info-card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .service-type-badge {
            min-width: 100%;
        }

        .experience-number {
            font-size: 2rem;
        }
    }
</style>

<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>">
                    <i class="fas fa-home me-1"></i>Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('providers'); ?>">
                    <i class="fas fa-users me-1"></i>Providers
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-user me-1"></i>Provider Details
            </li>

        </ol>
    </nav>
</div>

<div class="container py-4">
    <div class="row g-3">
        <!-- Left Card -->
        <div class="col-lg-4 col-md-12">
            <div class="provider-card shadow-sm fade-in">
                <!-- Hidden Provider ID -->
                <input type="hidden" name="provider_id" value="<?= $provider->provider_id; ?>">

                <!-- Gym Image -->
                <img src="<?= base_url($provider->profile_image); ?>" class="provider-img mx-auto d-block"
                    alt="<?= $provider->gym_name; ?>">

                <div class="card shadow-sm border-0 p-3">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0"><?= $provider->gym_name; ?></h5>
                        <a href="#" class="text-primary fw-bold small"><?= $provider->service_count; ?> Services</a>
                    </div>

                    <!-- Location -->
                    <div class="text-muted mb-3">
                        <i class="fa fa-location-dot me-2 text-primary"></i>
                        <?= $city; ?>, <?= $state; ?>
                    </div>

                    <!-- Description -->
                    <p class="text-muted small mb-2 text-truncate-3"
                        style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        <?= $provider->description; ?>
                    </p>
                    <a href="#about" class="text-primary fw-bold small d-inline-block" onclick="openAboutTab()">Read
                        More</a>

                    <!-- Expertise Tags -->
                    <?php
                    $tags = [];
                    if (isset($provider->expertise_tags) && !empty($provider->expertise_tags)) {
                        $tags = explode(',', $provider->expertise_tags);
                    }
                    ?>

                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">Expertise</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php if (!empty($tags)): ?>
                                <?php foreach ($tags as $tag): ?>
                                    <span class="badge rounded-pill bg-light text-primary border px-3 py-2 fade-in">
                                        <?= htmlspecialchars(trim($tag)); ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">No expertise added</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="col-lg-8 col-md-12">
            <!-- Tabs -->
            <ul class="nav nav-pills custom-tabs mb-3 justify-content-between d-flex gap-2" id="providerTabs"
                role="tablist">
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100 active" id="pricing-tab" data-bs-toggle="pill"
                        data-bs-target="#pricing-section" type="button">
                        <i class="fa fa-tags me-2"></i>Pricing
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="services-tab" data-bs-toggle="pill" data-bs-target="#services"
                        type="button">
                        <i class="fa fa-dumbbell me-2"></i>Services
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="about-tab" data-bs-toggle="pill" data-bs-target="#about"
                        type="button">
                        <i class="fa fa-info-circle me-2"></i>About
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="schedule-tab" data-bs-toggle="pill" data-bs-target="#schedule"
                        type="button">
                        <i class="fa fa-clock me-2"></i>Schedule
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="review-tab"
                        data-bs-toggle="pill" data-bs-target="#review" type="button">
                        <i class="fa-solid fa-comments me-2"></i> Review
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="gallery-tab"
                        data-bs-toggle="pill" data-bs-target="#gallery" type="button">
                        <i class="fa-solid fa-images me-2"></i> Gallery
                    </button>
                </li>
                <li class="nav-item flex-fill text-center">
                    <button class="nav-link w-100" id="certification-tab"
                        data-bs-toggle="pill" data-bs-target="#certification" type="button">
                        <i class="fa-solid fa-certificate me-2"></i> Certificates
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="tabContentArea">
                <!-- Pricing Section -->
                <div class="tab-pane fade show active" id="pricing-section" role="tabpanel"
                    aria-labelledby="pricing-tab">
                    <div class="card shadow-sm p-4 mt-3 fade-in">
                        <h6 class="fw-bold mb-2 text-uppercase text-secondary">
                            <i class="fa fa-map-marker-alt me-2"></i>Available in Cities
                        </h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php
                            if (!empty($provider->city)) {
                                $cities = explode(',', $provider->city);
                                foreach ($cities as $city) { ?>
                                    <span class="badge rounded-pill bg-info px-3 py-2 fade-in">
                                        <?= htmlspecialchars(trim($city)); ?>
                                    </span>
                                <?php }
                            } else { ?>
                                <span class="badge bg-light text-dark border px-3 py-2">City not available</span>
                            <?php } ?>
                        </div>

                        <div class="list-group mt-5">
                            <?php if (!empty($provider)): ?>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="priceOption"
                                        data-price="<?= $provider->day_price; ?>" data-label="Day" checked>
                                    <i class="fa fa-calendar-day me-2 text-primary"></i>
                                    ₹<?= number_format($provider->day_price, 2); ?> <small class="text-muted">/day</small>
                                </label>

                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="priceOption"
                                        data-price="<?= $provider->week_price; ?>" data-label="Week">
                                    <i class="fa fa-calendar-week me-2 text-primary"></i>
                                    ₹<?= number_format($provider->week_price, 2); ?> <small class="text-muted">/week</small>
                                </label>

                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="priceOption"
                                        data-price="<?= $provider->month_price; ?>" data-label="Month">
                                    <i class="fa fa-calendar-alt me-2 text-primary"></i>
                                    ₹<?= number_format($provider->month_price, 2); ?> <small
                                        class="text-muted">/month</small>
                                </label>

                                <?php
                                $yearPrice = is_numeric($provider->year_price) ? (float)$provider->year_price : 0;
                                ?>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="radio" name="priceOption"
                                        data-price="<?= $yearPrice; ?>" data-label="Year">
                                    <i class="fa fa-calendar me-2 text-primary"></i>
                                    ₹<?= $yearPrice > 0 ? number_format($yearPrice, 2) : 'N/A'; ?>
                                    <small class="text-muted">/year</small>
                                </label>
                            <?php endif; ?>
                        </div>

                        <form method="post" action="<?= site_url('cart/add_to_cart'); ?>" id="cartForm">
                            <input type="hidden" name="provider_id" id="provider_id"
                                value="<?= $provider->provider_id; ?>">
                            <input type="hidden" name="provider_name" value="<?= $provider->gym_name; ?>">
                            <input type="hidden" name="provider_image"
                                value="<?= base_url($provider->profile_image); ?>">
                            <input type="hidden" name="price" id="priceInput" value="100">
                            <input type="hidden" name="duration" id="durationInput" value="day">
                            <?php if (!empty($offers)): ?>
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3 text-secondary text-uppercase">
                                        <i class="fa fa-gift me-2"></i>Special Offers
                                    </h6>
                                    <div class="row g-3">
                                        <?php foreach ($offers as $offer): ?>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="card shadow-sm border-0 h-100">
                                                    <div class="card-body text-center">
                                                        <!-- Duration -->
                                                        <h5 class="card-title text-primary"><?= $offer->duration ?></h5>

                                                        <!-- Buy & Free Quantity -->
                                                        <p class="mb-1">
                                                            <i class="fa fa-shopping-cart text-info me-1"></i>
                                                            Buy: <strong><?= $offer->buy_quantity ?></strong>
                                                        </p>
                                                        <p class="mb-2">
                                                            <i class="fa fa-gift text-warning me-1"></i>
                                                            Free: <strong><?= $offer->free_quantity ?></strong>
                                                        </p>

                                                        <!-- Valid Till Date -->
                                                        <p class="mb-0">
                                                            <i class="fa fa-calendar-alt text-success me-1"></i>
                                                            Valid Till:
                                                            <strong><?= date('d M Y', strtotime($offer->valid_till)) ?></strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mt-4">No Offers Available Right Now</p>
                            <?php endif; ?>


                            <h6 id="selectedOption" class="fw-bold mb-2 text-uppercase text-secondary mt-4">
                                <i class="fa fa-shopping-cart me-2"></i>Book for Day
                            </h6>
                            <div class=" mb-3" style="width: 5%;
    display: inline;">
                                <button class="btn btn-outline-primary" type="button" id="decreaseQty">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" id="quantityInput" name="quantity" class="form-controll text-center"
                                    value="1" readonly style="display: inline;
        width: 16%;">
                                <button class="btn btn-outline-primary" type="button" id="increaseQty">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <h6 class="fw-bold mb-2 text-uppercase text-secondary mt-4">
                                <i class="fa fa-calendar-plus me-2"></i>Start From
                            </h6>
                            <input type="text" class="form-control" id="startDate" placeholder="dd-mm-yyyy"
                                name="start_date">


                            <small id="dateError" class="text-danger d-none"></small>

                            <button type="button" class="btn btn-primary w-100 py-3 mt-3 fw-bold mb-5"
                                onclick="validateAndBook(<?= isset($this->user['id']) ? $this->user['id'] : '0'; ?>)">
                                <i class="fa fa-rocket me-2"></i>Book Now
                            </button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                    <div id="service-list"></div>
                    <nav class="mt-3 mb-5">
                        <ul class="pagination justify-content-center" id="service-pagination"></ul>
                    </nav>
                </div>

                <!-- About -->
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div class="container py-4">


                        <!-- Service Type -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card shadow-sm border-0 fade-in">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">
                                            <i class="fa fa-server me-2 text-primary"></i>Service Types Available
                                        </h5>
                                        <div class="service-type-container">

                                            <?php if (!empty($provider->service_type)) : ?>

                                                <?php if ($provider->service_type == 'online' || $provider->service_type == 'both') : ?>
                                                    <div class="service-type-badge online">
                                                        <i class="fa fa-wifi"></i>
                                                        <h5>Online</h5>
                                                        <p>Live video classes & personalized training</p>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($provider->service_type == 'offline' || $provider->service_type == 'both') : ?>
                                                    <div class="service-type-badge offline">
                                                        <i class="fa fa-building"></i>
                                                        <h5>Offline</h5>
                                                        <p>Visit our facility for hands-on experience</p>
                                                    </div>
                                                <?php endif; ?>

                                            <?php else : ?>

                                                <p class="text-danger fw-bold text-align-center text-center w-100">
                                                    Services Type not Specified.
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Languages -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card shadow-sm border-0 fade-in">
                                    <div class="card-body">

                                        <!-- Languages -->
                                        <h5 class="fw-bold mb-3">
                                            <i class="fa fa-language me-2 text-primary"></i>
                                            Languages Spoken
                                        </h5>

                                        <div class="d-flex flex-wrap gap-3">

                                            <?php if (!empty($provider->language)) : ?>

                                                <?php
                                                $languages = explode(',', $provider->language);
                                                foreach ($languages as $lang) :
                                                ?>

                                                    <div class="language-chip">
                                                        <i class="fa fa-globe"></i>
                                                        <span><?= htmlspecialchars(trim($lang)) ?></span>
                                                    </div>

                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <span class="text-danger fw-bold w-100 text-center">
                                                    Language Not Specified.
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                        <!-- Experience -->
                                        <h5 class="fw-bold mt-4 mb-3">
                                            <i class="fa fa-briefcase me-2 text-primary"></i>
                                            Hand On Experience
                                        </h5>

                                        <div class="d-flex flex-wrap gap-3">

                                            <div class="language-chip">
                                                <i class="fa fa-clock"></i>
                                                <span>
                                                    <?= !empty($provider->exp) ? $provider->exp . '' : 'Experience not specified' ?>
                                                </span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Profile Description -->
                            <div class="col-lg-8 col-md-7 mb-4">
                                <div class="card shadow-sm border-0 h-100 fade-in">
                                    <div class="card-body">
                                        <h4 class="fw-bold mb-3">
                                            <i class="fa fa-user-circle me-2 text-primary"></i>About the Provider
                                        </h4>
                                        <p class="text-muted mb-0">
                                            <?= !empty($provider->description) ? $provider->description : 'No description available.'; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Contact Info -->
                            <div class="col-lg-4 col-md-5 mb-4">
                                <div class="card shadow-sm border-0 h-100 fade-in">
                                    <div class="card-header bg-primary text-white fw-bold">
                                        <i class="fa fa-address-card me-2"></i> Contact Information
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 d-flex align-items-center">
                                            <div class="contact-icon user">
                                                <i class="fa fa-user text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Owner:</strong> <span><?= $provider->name; ?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex align-items-center">
                                            <div class="contact-icon email">
                                                <i class="fa fa-envelope text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Email:</strong> <span><?= $provider->email; ?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex align-items-center">
                                            <div class="contact-icon phone">
                                                <i class="fa fa-phone text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Mobile:</strong> <span><?= $provider->mobile; ?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex align-items-start">
                                            <div class="contact-icon location">
                                                <i class="fa fa-map-marker-alt text-white"></i>
                                            </div>
                                            <div>
                                                <strong>Address:</strong>
                                                <div><?= $provider->address; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-0 map-container">
                                        <!-- Clickable Static Map -->
                                        <img
                                            src="https://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($provider->address); ?>&zoom=15&size=400x200&markers=color:red%7C<?= $provider->latitude; ?>,<?= $provider->longitude; ?>&key=AIzaSyAR5-9XtV0r0VyR7uu0ppEKhNHanKlGwWk"
                                            class="img-fluid w-100 rounded-bottom map-image"
                                            alt="Map of <?= $provider->address; ?>"
                                            data-gym-lat="<?= $provider->latitude; ?>"
                                            data-gym-lng="<?= $provider->longitude; ?>"
                                            style="cursor:pointer;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                    <div class="container py-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold">
                                <i class="fa fa-clock me-2 text-primary"></i>Business Hours
                            </h5>
                            <?php
                            // Find today's schedule
                            $today = strtolower(date('l')); // sunday, monday...
                            $todaySchedule = array_filter($schedule, function ($s) use ($today) {
                                return strtolower($s->day) === $today;
                            });
                            $todaySchedule = reset($todaySchedule);
                            ?>
                            <div class="badge bg-primary px-3 py-2">
                                Today:
                                <?php if ($todaySchedule && $todaySchedule->status === 'open'): ?>
                                    <span class="text-white">
                                        <?= date("g:i A", strtotime($todaySchedule->start_time)) ?> -
                                        <?= date("g:i A", strtotime($todaySchedule->end_time)) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-white">Holiday</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row g-3 bg-light rounded p-4">
                            <?php if (!empty($schedule)): ?>
                                <?php foreach ($schedule as $s): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="schedule-card border rounded p-3 bg-white shadow-sm h-100 fade-in">
                                            <h6 class="fw-bold mb-2">
                                                <i class="fa fa-calendar-day me-2 text-primary"></i><?= ucfirst($s->day); ?>
                                            </h6>
                                            <?php if ($s->status === 'open'): ?>
                                                <p class="mb-0 text-muted">
                                                    <i class="fa fa-clock me-1"></i>
                                                    <?= date("g:i A", strtotime($s->start_time)) ?> -
                                                    <?= date("g:i A", strtotime($s->end_time)) ?>
                                                </p>
                                            <?php else: ?>
                                                <p class="mb-0 text-danger">
                                                    <i class="fa fa-times-circle me-1"></i>Holiday
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="fa fa-calendar-times fa-3x mb-3"></i>
                                    <p>No schedule available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Review Tab -->
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="container">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <!-- Header with Add Review Button -->
                                <div class="d-flex justify-content-between align-items-center mb-4 header-section">
                                    <h5 class="fw-bold mb-0">
                                        <i class="fa fa-star me-2 text-warning"></i>Customer Reviews
                                    </h5>
                                    <?php if (isset($this->user['id']) && isset($provider->id)) : ?>
                                        <?php if ($can_add_review): ?>
                                            <button class="btn btn-primary"
                                                id="openReviewModal"
                                                data-user="<?= $this->user['id']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addReviewModal">
                                                <i class="fa fa-plus me-2"></i>Add Review
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Reviews Container with Scroll -->
                                <div class="reviews-scroll-container">
                                    <?php if (!empty($this->data['reviews'])) : ?>
                                        <?php foreach ($reviews as $review) : ?>
                                            <div class="review-card">
                                                <div class="review-header">
                                                    <div class="reviewer-name">
                                                        <i class="fa fa-user-circle"></i>
                                                        <?= htmlspecialchars($review->user_name ?? 'Anonymous'); ?>
                                                    </div>

                                                    <div class="review-stars">
                                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                            <?php if ($i <= $review->rating) : ?>
                                                                <i class="fa fa-star"></i>
                                                            <?php else : ?>
                                                                <i class="far fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>

                                                <p class="review-text">
                                                    <?= nl2br(htmlspecialchars($review->review_text)); ?>
                                                </p>

                                                <small class="review-date">
                                                    <i class="fa fa-clock me-1"></i>
                                                    <?= date('M d, Y', strtotime($review->created_at)); ?>
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p class="text-muted text-center">No reviews yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Tab -->
                <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                    <div class="container py-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fa fa-images me-2 text-primary"></i>Photo Gallery
                                </h5>
                                <div class="gallery-grid">

                                    <?php if (!empty($gallery_images)) : ?>

                                        <?php foreach ($gallery_images as $image) : ?>

                                            <div class="gallery-item fade-in">
                                                <img src="<?= base_url($image->image) ?>"
                                                    alt="Gallery Image"
                                                    class="img-fluid rounded">
                                            </div>

                                        <?php endforeach; ?>

                                    <?php else : ?>
                                        <p class="text-danger fw-bold text-align-center text-center w-100">
                                            No Gallery Image Uploaded yet.
                                        </p>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Certification Tab -->
                <div class="tab-pane fade" id="certification" role="tabpanel" aria-labelledby="certification-tab">
                    <div class="container py-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fa fa-certificate me-2 text-primary"></i>Certifications & Achievements
                                </h5>
                                <div class="row g-3">

                                    <?php if (!empty($certifications)) : ?>
                                        <?php foreach ($certifications as $cert) : ?>

                                            <div class="col-md-6">
                                                <div class="certification-card fade-in">
                                                    <h6 class="certification-title">
                                                        <?= htmlspecialchars($cert->title) ?>
                                                    </h6>
                                                    <p class="certification-issuer">
                                                        <i class="fa fa-map-marker-alt me-2"></i>
                                                        <?= htmlspecialchars($provider->address ?? 'Address Not Available') ?>
                                                    </p>

                                                    <?php if (!empty($cert->image_path)) : ?>

                                                        <p class="certification-year">
                                                            <a href="<?= base_url($cert->image_path) ?>" target="_blank" class="certificate-btn">
                                                                <i class="fa fa-file me-2 text-light"></i>
                                                                View Certificate
                                                            </a>
                                                        </p>

                                                    <?php endif; ?>

                                                    <span class="certification-year">
                                                        <?= date('Y', strtotime($cert->created_on)) ?>
                                                    </span>

                                                </div>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php else : ?>

                                        <div class="col-12 text-danger fw-bold text-align-center text-center">
                                            No Certifications Uploaded yet.
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Add Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addReviewModalLabel">
                    <i class="fa fa-star me-2"></i>Write a Review
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="review_user" value="<?= isset($this->user['id']) ? $this->user['id'] : '' ?>">
                <input type="hidden" id="review_provider" value="<?= isset($provider->provider_id) ? $provider->provider_id : '' ?>">

                <form id="reviewForm">
                    <!-- Star Rating -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                        <div class="star-rating-input">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" value="<?= $i ?>">
                                    <label class="form-check-label">
                                        <i class="fa fa-star"></i> <?= $i ?>
                                    </label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Your Review <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reviewText" rows="4"
                            placeholder="Share your experience..." required></textarea>
                    </div>

                    <button type="submit" id="submitReviewBtn" class="btn btn-primary w-100">
                        <i class="fa fa-paper-plane me-2"></i>Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>