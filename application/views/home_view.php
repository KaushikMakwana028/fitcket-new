<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    /* ══════════════════════════════════════════
       CSS VARIABLES
    ══════════════════════════════════════════ */
    :root {
        --primary-color: #6f42c1;
        --primary-dark: #5a32a3;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --text-muted: #6c757d;
        --bg-light: #f8f9fa;
        --white: #ffffff;
        --warning: #ffc107;
        --warning-dark: #e0a800;
        --border-color: #ececec;
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-xl: 32px;
        --radius-pill: 50px;
    }

    /* ══════════════════════════════════════════
       BASE
    ══════════════════════════════════════════ */
    .fitket-home {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        overflow-x: hidden;
        line-height: 1.6;
    }

    .fitket-home .services-section,
    .fitket-home .fkh-banner-wrap {
        content-visibility: auto;
        contain-intrinsic-size: 620px;
        contain: layout paint style;
    }

    .fitket-home *,
    .fitket-home *::before,
    .fitket-home *::after {
        box-sizing: border-box;
    }

    .fitket-home input,
    .fitket-home button,
    .fitket-home select,
    .fitket-home textarea {
        font-family: 'Poppins', sans-serif;
    }

    .fitket-home *:focus-visible {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* ══════════════════════════════════════════
       HERO CAROUSEL
    ══════════════════════════════════════════ */
    .fitket-home .hero-wrapper {
        position: relative;
        margin-bottom: 70px;
    }

    .fitket-home .carousel-item {
        height: 600px;
        background: #1a1a1a;
        position: relative;
        overflow: hidden;
    }

    .fitket-home .hero-slide-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 0;
    }

    /* Dark gradient overlay */
    .fitket-home .carousel-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse at 80% 20%, rgba(111, 66, 193, 0.35) 0%, transparent 55%),
            linear-gradient(160deg, rgba(26, 26, 26, 0.3) 0%, rgba(26, 26, 26, 0.75) 55%, rgba(26, 26, 26, 0.92) 100%);
        z-index: 1;
    }

    /*
     * KEY FIX: Override Bootstrap's .carousel-caption which sets
     * bottom/left/right/padding-bottom and kills our layout.
     * We make it cover the full slide, then use .caption-inner for layout.
     */
    .fitket-home .carousel-caption {
        position: absolute !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        padding: 0 !important;
        text-align: left !important;
        z-index: 2;
    }

    /* Inner flex container: content centered, CTA pinned to bottom */
    .fitket-home .caption-inner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        height: 100%;
        padding: 60px clamp(28px, 6vw, 80px) 80px;
        max-width: 720px;
    }

    /* Eyebrow pill badge */
    .fitket-home .caption-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(111, 66, 193, 0.22);
        border: 1px solid rgba(111, 66, 193, 0.45);
        color: #c9b0f0;
        padding: 6px 18px;
        border-radius: var(--radius-pill);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .fitket-home .carousel-caption h1 {
        font-size: clamp(2rem, 4.5vw, 3.6rem);
        font-weight: 900;
        margin-bottom: 14px;
        color: var(--white);
        line-height: 1.1;
        letter-spacing: -0.03em;
    }

    .fitket-home .carousel-caption h1 span {
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .fitket-home .carousel-caption p {
        font-size: clamp(0.95rem, 1.6vw, 1.1rem);
        font-weight: 300;
        margin-bottom: 0;
        color: rgba(255, 255, 255, 0.65);
        line-height: 1.75;
        max-width: 480px;
    }

    /* CTA pinned to bottom via margin-top: auto */
    .fitket-home .cta-group {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: auto;
        padding-top: 28px;
    }

    .fitket-home .btn-warning {
        background: var(--warning);
        border: none;
        color: #1a1a1a;
        font-weight: 700;
        padding: 14px 36px;
        border-radius: var(--radius-pill);
        font-size: 0.98rem;
        transition: all 0.25s;
    }

    .fitket-home .btn-warning:hover {
        background: var(--warning-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(255, 193, 7, 0.38);
        color: #1a1a1a;
    }

    .fitket-home .btn-outline-light {
        border: 1.5px solid rgba(255, 255, 255, 0.35);
        color: var(--white);
        padding: 14px 36px;
        border-radius: var(--radius-pill);
        font-weight: 600;
        font-size: 0.98rem;
        background: transparent;
        transition: all 0.25s;
    }

    .fitket-home .btn-outline-light:hover {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-3px);
    }

    /* Carousel controls */
    .fitket-home #heroCarousel .carousel-control-prev,
    .fitket-home #heroCarousel .carousel-control-next {
        width: 48px;
        height: 48px;
        top: 50%;
        bottom: auto;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        opacity: 0.9;
        transition: background-color 0.25s, border-color 0.25s, opacity 0.25s;
        z-index: 10;
    }

    .fitket-home #heroCarousel .carousel-control-prev {
        left: 20px;
    }

    .fitket-home #heroCarousel .carousel-control-next {
        right: 20px;
    }

    .fitket-home #heroCarousel .carousel-control-prev:hover,
    .fitket-home #heroCarousel .carousel-control-next:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        opacity: 1;
    }

    /* Indicator dots */
    .fitket-home #heroCarousel .carousel-indicators {
        bottom: 24px;
        justify-content: flex-start;
        padding-left: clamp(28px, 6vw, 80px);
        gap: 6px;
        margin: 0;
    }

    .fitket-home #heroCarousel .carousel-indicators [data-bs-target] {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        border: none;
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .fitket-home #heroCarousel .carousel-indicators .active {
        width: 24px;
        border-radius: var(--radius-pill);
        background: var(--primary-color);
    }

    /* ══════════════════════════════════════════
       FLOATING SEARCH BAR
    ══════════════════════════════════════════ */
    .fitket-home .search-bar-container {
        position: absolute;
        bottom: -38px;
        left: 50%;
        transform: translateX(-50%);
        width: 86%;
        max-width: 900px;
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 20px 24px;
        box-shadow: 0 20px 50px rgba(111, 66, 193, 0.18);
        z-index: 100;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .fitket-home .search-input-group {
        flex: 1;
        min-width: 200px;
    }

    .fitket-home .search-input-group .input-group-text {
        background: var(--bg-light);
        border: 1.5px solid var(--border-color);
        border-right: none;
        color: var(--primary-color);
        border-radius: var(--radius-md) 0 0 var(--radius-md);
        padding: 0 14px;
    }

    .fitket-home .search-input-group .form-control {
        border: 1.5px solid var(--border-color);
        border-left: none;
        padding: 13px 16px;
        border-radius: 0 var(--radius-md) var(--radius-md) 0;
        font-size: 0.92rem;
        color: var(--text-dark);
        background: var(--bg-light);
        transition: border-color 0.25s, box-shadow 0.25s;
    }

    .fitket-home .search-input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
        background: var(--white);
        outline: none;
    }

    .fitket-home .search-divider {
        width: 1px;
        height: 36px;
        background: var(--border-color);
        flex-shrink: 0;
    }

    .fitket-home .search-btn {
        background: var(--primary-color);
        border: none;
        border-radius: var(--radius-md);
        padding: 13px 36px;
        color: var(--white);
        font-weight: 700;
        font-size: 0.95rem;
        transition: background-color 0.25s, color 0.25s, transform 0.25s, box-shadow 0.25s;
        white-space: nowrap;
        cursor: pointer;
        letter-spacing: 0.02em;
    }

    .fitket-home .search-btn:hover {
        background: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(111, 66, 193, 0.32);
    }

    /* ══════════════════════════════════════════
       SECTION HEADINGS
    ══════════════════════════════════════════ */
    .fitket-home .fkh-section-label {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.1);
        padding: 5px 14px;
        border-radius: var(--radius-pill);
        margin-bottom: 12px;
    }

    .fitket-home .fkh-section-title {
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 800;
        color: var(--secondary-color);
        letter-spacing: -0.025em;
        margin-bottom: 6px;
        line-height: 1.2;
    }

    .fitket-home .fkh-section-title em {
        font-style: normal;
        color: var(--primary-color);
    }

    .fitket-home .fkh-section-sub {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-weight: 400;
        margin-bottom: 0;
    }

    .fitket-home .fkh-section-label--dark {
        color: #b19fe8;
        background: rgba(111, 66, 193, 0.2);
    }

    .fitket-home .fkh-section-title--dark {
        color: var(--white);
    }

    .fitket-home .fkh-section-sub--dark {
        color: rgba(255, 255, 255, 0.45);
    }

    /* ══════════════════════════════════════════
       CATEGORY SECTION
    ══════════════════════════════════════════ */
    .fitket-home .services-section {
        padding: 90px 0 60px;
        background: var(--white);
    }

    .fitket-home .fkh-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 44px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .fitket-home .fkh-view-all {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        padding: 9px 20px;
        border: 1.5px solid rgba(111, 66, 193, 0.25);
        border-radius: var(--radius-pill);
        transition: all 0.25s;
        white-space: nowrap;
    }

    .fitket-home .fkh-view-all:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    /* Category grid */
    .fitket-home .category-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 18px;
    }

    .fitket-home .category-link {
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }

    .fitket-home .service-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 14px;
        border-radius: var(--radius-lg);
        background: var(--white);
        border: 1.5px solid var(--border-color);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        cursor: pointer;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .fitket-home .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .fitket-home .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(111, 66, 193, 0.13);
        border-color: rgba(111, 66, 193, 0.25);
    }

    .fitket-home .service-card:hover::before {
        transform: scaleX(1);
    }

    .fitket-home .service-icon {
        flex-shrink: 0;
        width: 62px;
        height: 62px;
        border-radius: 16px;
        padding: 3px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s;
    }

    .fitket-home .service-card:hover .service-icon {
        transform: scale(1.08) rotate(-4deg);
    }

    .fitket-home .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 13px;
        object-fit: cover;
        border: 2px solid var(--white);
    }

    .fitket-home .service-icon .avatar-img {
        border-radius: 13px;
    }

    .fitket-home .service-title {
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 3px;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
    }

    .fitket-home .service-subtitle {
        color: var(--primary-color);
        font-size: 0.82rem;
        font-weight: 600;
    }

    /* ══════════════════════════════════════════
       PROVIDER / EXPERT CARDS
    ══════════════════════════════════════════ */
    .fitket-home .experts-section {
        padding: 70px 0;
    }

    .fitket-home .expert-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1.5px solid var(--border-color);
        transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        width: 100%;
    }

    .fitket-home .expert-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.35s ease;
    }

    .fitket-home .expert-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 22px 48px rgba(111, 66, 193, 0.14);
        border-color: rgba(111, 66, 193, 0.22);
    }

    .fitket-home .expert-card:hover::before {
        transform: scaleX(1);
    }

    .fitket-home .expert-left {
        display: flex;
        align-items: center;
        padding: 30px 28px 24px;
        gap: 16px;
        flex-grow: 1;
    }

    .fitket-home .expert-logo {
        width: 66px;
        height: 66px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        padding: 3px;
        transition: transform 0.3s;
    }

    .fitket-home .expert-logo .avatar-img {
        border-radius: 50%;
    }

    .fitket-home .expert-card:hover .expert-logo {
        transform: scale(1.06);
    }

    .fitket-home .expert-title {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1rem;
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .fitket-home .expert-services {
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 500;
    }

    .fitket-home .expert-footer {
        padding: 18px 22px;
        background: var(--bg-light);
        border-top: 1.5px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
    }

    .fitket-home .distance-pill {
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 0.83rem;
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(111, 66, 193, 0.09);
        padding: 8px 16px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
    }

    .fitket-home .view-more-btn {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: var(--radius-pill);
        background: rgba(111, 66, 193, 0.06);
        border: 1px solid rgba(111, 66, 193, 0.15);
        transition: all 0.25s;
    }

    .fitket-home .view-more-btn:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateX(3px);
    }

    .fitket-home .view-more-text {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.83rem;
    }

    .fitket-home .view-more-btn:hover .view-more-text,
    .fitket-home .view-more-btn:hover .fkh-arrow-icon {
        color: var(--white) !important;
    }

    /* ══════════════════════════════════════════
       SWIPER
    ══════════════════════════════════════════ */
    .fitket-home .swiper {
        position: relative;
        padding: 8px 4px 30px;
        min-height: 120px;
    }

    .fitket-home .swiper-slide {
        height: auto;
        display: flex;
    }

    .fitket-home .swiper-pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 6px;
        position: relative;
        margin-top: 18px;
        bottom: auto !important;
    }

    .fitket-home .swiper-pagination-bullet {
        width: 7px;
        height: 7px;
        background: var(--border-color);
        opacity: 1;
        margin: 0 !important;
        border-radius: 50%;
        transition: all 0.25s;
    }

    .fitket-home .swiper-pagination-bullet-active {
        width: 20px;
        border-radius: var(--radius-pill);
        background: var(--primary-color);
    }

    .fitket-home .swiper-button-prev,
    .fitket-home .swiper-button-next {
        width: 30px;
        height: 30px;
        background: rgba(111, 66, 193, 0.55);
        border-radius: 50%;
        top: 24px;
        margin-top: 0;
        color: var(--white);
        transition: all 0.25s;
        z-index: 5;
    }

    .fitket-home .swiper-button-prev:after,
    .fitket-home .swiper-button-next:after {
        font-size: 12px;
        font-weight: 900;
    }

    .fitket-home .swiper-button-prev:hover,
    .fitket-home .swiper-button-next:hover {
        background: var(--primary-color);
        transform: scale(1.1);
    }

    .fitket-home .swiper-button-prev {
        left: 6px;
    }

    .fitket-home .swiper-button-next {
        right: 6px;
    }

    .fitket-home .swiper-button-disabled {
        opacity: 0.35;
    }

    /* ══════════════════════════════════════════
       PROMO BANNERS
    ══════════════════════════════════════════ */
    .fitket-home .fkh-banner-wrap {
        padding: 60px 0 70px;
    }

    .fitket-home .edemand-banner {
        position: relative;
        background: var(--secondary-color);
        border-radius: var(--radius-xl);
        padding: 0;
        color: var(--white);
        display: flex;
        align-items: stretch;
        overflow: hidden;
        min-height: 260px;
    }

    .fitket-home .edemand-banner::before {
        content: '';
        position: absolute;
        width: 3px;
        height: 160%;
        background: linear-gradient(180deg, transparent, rgba(111, 66, 193, 0.7), transparent);
        top: -30%;
        left: 52%;
        transform: rotate(14deg);
        pointer-events: none;
    }

    .fitket-home .edemand-banner::after {
        content: '';
        position: absolute;
        width: 420px;
        height: 420px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.28) 0%, transparent 70%);
        top: -120px;
        right: -80px;
        pointer-events: none;
    }

    .fitket-home .banner-watermark {
        position: absolute;
        bottom: -10px;
        left: -10px;
        font-size: 120px;
        font-weight: 900;
        letter-spacing: -0.06em;
        color: transparent;
        -webkit-text-stroke: 1px rgba(111, 66, 193, 0.12);
        pointer-events: none;
        user-select: none;
        line-height: 1;
    }

    .fitket-home .banner-text {
        flex: 1;
        padding: 52px 48px;
        position: relative;
        z-index: 2;
    }

    .fitket-home .banner-eyebrow {
        display: inline-block;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #b19fe8;
        background: rgba(111, 66, 193, 0.2);
        border: 1px solid rgba(111, 66, 193, 0.35);
        padding: 5px 14px;
        border-radius: var(--radius-pill);
        margin-bottom: 18px;
    }

    .fitket-home .banner-text h2 {
        font-weight: 800;
        margin-bottom: 14px;
        font-size: clamp(1.4rem, 3.2vw, 2.2rem);
        color: var(--white);
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .fitket-home .banner-text h2 em {
        font-style: normal;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .fitket-home .banner-text p {
        font-size: clamp(0.88rem, 1.5vw, 1rem);
        margin-bottom: 32px;
        line-height: 1.75;
        color: rgba(255, 255, 255, 0.55);
        font-weight: 300;
        max-width: 480px;
    }

    .fitket-home .buy-btn {
        background: var(--warning);
        color: #1a1a1a;
        border: none;
        padding: 14px 36px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        transition: all 0.25s;
        font-size: 0.95rem;
        display: inline-block;
        text-decoration: none;
        letter-spacing: 0.02em;
    }

    .fitket-home .buy-btn:hover {
        background: var(--warning-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(255, 193, 7, 0.3);
        color: #1a1a1a;
    }

    .fitket-home .banner-illustration {
        position: relative;
        z-index: 2;
        flex-shrink: 0;
        width: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 30px 40px 0;
    }

    .fitket-home .banner-illustration svg {
        width: 180px;
        height: 180px;
        opacity: 0.18;
    }

    /* Accent banner variant */
    .fitket-home .edemand-banner--accent {
        background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 50%, var(--accent-color) 100%);
    }

    .fitket-home .edemand-banner--accent::before {
        background: linear-gradient(180deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    }

    .fitket-home .edemand-banner--accent::after {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
    }

    .fitket-home .edemand-banner--accent .banner-eyebrow {
        color: rgba(255, 255, 255, 0.8);
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .fitket-home .edemand-banner--accent .banner-text p {
        color: rgba(255, 255, 255, 0.7);
    }

    .fitket-home .edemand-banner--accent .banner-watermark {
        -webkit-text-stroke: 1px rgba(255, 255, 255, 0.1);
    }

    /* ══════════════════════════════════════════
       DARK BG SECTION
    ══════════════════════════════════════════ */
    .fitket-home .fkh-bg-dark {
        background: var(--secondary-color);
        position: relative;
        overflow: hidden;
    }

    .fitket-home .fkh-bg-dark::after {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.14) 0%, transparent 70%);
        bottom: -200px;
        left: -100px;
        pointer-events: none;
    }

    .fitket-home .fkh-bg-dark .fkh-section-label {
        color: #b19fe8;
        background: rgba(111, 66, 193, 0.2);
    }

    .fitket-home .fkh-bg-dark .fkh-section-title {
        color: var(--white);
    }

    .fitket-home .fkh-bg-dark .fkh-section-sub {
        color: rgba(255, 255, 255, 0.4);
    }

    .fitket-home .fkh-bg-dark .expert-card {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.08);
    }

    .fitket-home .fkh-bg-dark .expert-card:hover {
        background: rgba(111, 66, 193, 0.1);
        border-color: rgba(111, 66, 193, 0.3);
    }

    .fitket-home .fkh-bg-dark .expert-title {
        color: var(--white);
    }

    .fitket-home .fkh-bg-dark .expert-services {
        color: rgba(255, 255, 255, 0.45);
    }

    .fitket-home .fkh-bg-dark .expert-footer {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.07);
    }

    .fitket-home .fkh-bg-dark .distance-pill {
        background: rgba(111, 66, 193, 0.2);
        color: #b19fe8;
    }

    .fitket-home .fkh-bg-dark .view-more-btn {
        background: rgba(111, 66, 193, 0.15);
        border-color: rgba(111, 66, 193, 0.25);
    }

    .fitket-home .fkh-bg-dark .view-more-text {
        color: #b19fe8;
    }

    .fitket-home .fkh-bg-dark .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.2);
    }

    .fitket-home .fkh-bg-dark .swiper-pagination-bullet-active {
        background: var(--primary-color);
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — hide swiper arrows on desktop
    ══════════════════════════════════════════ */
    @media (min-width: 992px) {

        .fitket-home .swiper-button-prev,
        .fitket-home .swiper-button-next {
            display: none;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — ≤ 991px  (tablets)
    ══════════════════════════════════════════ */
    @media (max-width: 991px) {

        /* — Hero — */
        .fitket-home .hero-wrapper {
            margin-bottom: 0;
        }

        .fitket-home .carousel-item {
            height: 480px;
        }

        .fitket-home .caption-inner {
            padding: 44px 24px 60px;
            max-width: 100%;
            /* Keep justify-content:center so title stays mid-slide */
        }

        .fitket-home .caption-eyebrow {
            display: none;
        }

        .fitket-home .carousel-caption h1 {
            font-size: clamp(1.55rem, 5.5vw, 2.4rem);
            line-height: 1.15;
        }

        .fitket-home .carousel-caption p {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .fitket-home .cta-group {
            margin-top: 20px;
            padding-top: 0;
            width: 100%;
        }

        .fitket-home .cta-group .btn {
            padding: 12px 28px;
            font-size: 0.9rem;
        }

        /* — Carousel controls — */
        .fitket-home #heroCarousel .carousel-control-prev,
        .fitket-home #heroCarousel .carousel-control-next {
            width: 32px;
            height: 32px;
        }

        .fitket-home #heroCarousel .carousel-control-prev {
            left: 10px;
        }

        .fitket-home #heroCarousel .carousel-control-next {
            right: 10px;
        }

        .fitket-home #heroCarousel .carousel-control-prev-icon,
        .fitket-home #heroCarousel .carousel-control-next-icon {
            width: 12px;
            height: 12px;
        }

        /* — Search bar — */
        .fitket-home .search-bar-container {
            position: static;
            transform: none;
            width: 94%;
            margin: 20px auto 0;
            padding: 16px 18px;
            border-radius: var(--radius-lg);
            gap: 10px;
        }

        .fitket-home .search-divider {
            display: none;
        }

        .fitket-home .search-input-group {
            flex: 1 1 160px;
            min-width: 0;
        }

        .fitket-home .search-btn {
            flex: 0 0 auto;
            padding: 12px 24px;
        }

        /* — Category grid — */
        .fitket-home .category-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        /* — Banners — */
        .fitket-home .banner-illustration {
            width: 160px;
        }

        .fitket-home .banner-illustration svg {
            width: 130px;
            height: 130px;
        }

        .fitket-home .banner-text {
            padding: 40px 36px;
        }

        /* — Swiper arrows — */
        .fitket-home .swiper-button-prev,
        .fitket-home .swiper-button-next {
            display: flex;
            width: 24px;
            height: 24px;
            top: 50%;
            transform: translateY(-50%);
        }

        .fitket-home .swiper-button-prev:after,
        .fitket-home .swiper-button-next:after {
            font-size: 9px;
        }

        .fitket-home .swiper-button-prev {
            left: 2px;
        }

        .fitket-home .swiper-button-next {
            right: 2px;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — ≤ 768px  (phones)
    ══════════════════════════════════════════ */
    @media (max-width: 768px) {

        /* — Hero — */
        .fitket-home .carousel-item {
            height: 420px;
        }

        .fitket-home .caption-inner {
            padding: 40px 20px 56px;
        }

        .fitket-home .carousel-caption h1 {
            font-size: clamp(1.4rem, 5vw, 2rem);
        }

        .fitket-home .carousel-caption p {
            font-size: 0.87rem;
        }

        .fitket-home #heroCarousel .carousel-indicators {
            padding-left: 20px;
            bottom: 18px;
        }

        /* — Search bar — */
        .fitket-home .search-bar-container {
            flex-direction: column;
            gap: 10px;
            padding: 14px 16px;
            width: 92%;
        }

        .fitket-home .search-input-group {
            width: 100%;
            flex: unset;
        }

        .fitket-home .search-btn {
            width: 100%;
            padding: 13px;
            border-radius: var(--radius-md);
        }

        /* — Category grid — */
        .fitket-home .category-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        /* — Sections — */
        .fitket-home .services-section {
            padding: 42px 0 40px;
        }

        .fitket-home .experts-section {
            padding: 60px 0;
        }

        .fitket-home .fkh-section-header {
            justify-content: center;
            text-align: center;
        }

        /* — Expert cards — */
        .fitket-home .expert-left {
            padding: 18px 18px 14px;
            gap: 12px;
        }

        .fitket-home .expert-logo {
            width: 54px;
            height: 54px;
        }

        .fitket-home .expert-title {
            font-size: 0.95rem;
        }

        .fitket-home .expert-footer {
            padding: 12px 16px;
            flex-wrap: wrap;
            gap: 8px;
        }

        /* — Banners — */
        .fitket-home .edemand-banner {
            flex-direction: column;
            min-height: auto;
        }

        .fitket-home .banner-text {
            padding: 36px 28px 30px;
        }

        .fitket-home .banner-illustration {
            display: none;
        }

        .fitket-home .buy-btn {
            width: 100%;
            text-align: center;
            padding: 13px 28px;
        }

        .fitket-home .fkh-banner-wrap {
            padding-bottom: 50px;
        }

        /* — Landscape — */
        @media (orientation: landscape) {
            .fitket-home .carousel-item {
                height: 260px;
            }

            .fitket-home .caption-inner {
                padding: 24px 20px 40px;
            }

            .fitket-home .carousel-caption p {
                display: none;
            }

            .fitket-home #heroCarousel .carousel-indicators {
                bottom: 10px;
            }
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — ≤ 576px  (small phones)
    ══════════════════════════════════════════ */
    @media (max-width: 576px) {

        /* — Hero — */
        .fitket-home .carousel-item {
            height: 360px;
        }

        .fitket-home .caption-inner {
            padding: 36px 16px 52px;
        }

        .fitket-home .carousel-caption h1 {
            font-size: clamp(1.3rem, 6vw, 1.85rem);
        }

        .fitket-home .carousel-caption p {
            font-size: 0.82rem;
        }

        .fitket-home .cta-group .btn {
            padding: 11px 22px;
            font-size: 0.84rem;
        }

        /* — Category grid — */
        .fitket-home .category-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .fitket-home .category-grid .service-card {
            padding: 18px 10px;
            border-radius: 16px;
        }

        .fitket-home .category-grid .service-icon {
            width: 52px;
            height: 52px;
            border-radius: 13px;
        }

        .fitket-home .category-grid .service-title {
            font-size: 0.8rem;
        }

        .fitket-home .category-grid .service-subtitle {
            font-size: 0.72rem;
        }

        /* — Banners — */
        .fitket-home .banner-text {
            padding: 28px 22px;
        }

        .fitket-home .banner-text h2 {
            font-size: 1.3rem;
        }

        .fitket-home .fkh-view-all {
            display: none;
        }

        /* — Expert cards — */
        .fitket-home .expert-card {
            min-width: 100%;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — ≤ 480px  (tiny phones)
    ══════════════════════════════════════════ */
    @media (max-width: 480px) {
        .fitket-home .carousel-item {
            height: 320px;
        }

        .fitket-home .caption-inner {
            padding: 30px 14px 46px;
        }

        .fitket-home .carousel-caption h1 {
            font-size: clamp(1.15rem, 5.5vw, 1.55rem);
        }

        .fitket-home #heroCarousel .carousel-indicators {
            bottom: 14px;
        }
    }
</style>

<div class="fitket-home">

    <!-- ═══ HERO CAROUSEL ═══ -->
    <div class="hero-wrapper">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <?php $i = 0;
                foreach ($sliders as $s): ?>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $i ?>"
                        <?= $i === 0 ? 'class="active" aria-current="true"' : '' ?>
                        aria-label="Slide <?= $i + 1 ?>"></button>
                <?php $i++;
                endforeach; ?>
            </div>

            <div class="carousel-inner">
                <?php $first = true;
                foreach ($sliders as $slide): ?>
                    <div class="carousel-item <?= $first ? 'active' : '' ?>">
                        <img src="<?= base_url('uploads/slider/' . $slide->slider_image) ?>"
                            alt="<?= htmlspecialchars($slide->slider_title) ?>"
                            class="hero-slide-img"
                            loading="<?= $first ? 'eager' : 'lazy' ?>"
                            decoding="async"
                            <?= $first ? 'fetchpriority="high"' : '' ?>>
                        <div class="carousel-caption">
                            <div class="caption-inner">
                                <span class="caption-eyebrow">
                                    <i class="fas fa-dumbbell" aria-hidden="true"></i>
                                    Premium Fitness Platform
                                </span>
                                <h1><?= htmlspecialchars($slide->slider_title) ?></h1>
                                <p><?= htmlspecialchars($slide->sub_title) ?></p>
                                <div class="cta-group">
                                    <a href="<?= base_url('providers') ?>" class="btn btn-warning">
                                        <i class="fas fa-calendar-check me-2" aria-hidden="true"></i>Book Now
                                    </a>
                                    <a href="<?= base_url('services') ?>" class="btn btn-outline-light">
                                        Explore Services
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php $first = false;
                endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Floating Search Bar -->
        <div class="search-bar-container">
            <div class="search-input-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
                    <input type="text" id="locationInput" class="form-control" placeholder="Your location"
                        aria-label="Your location"
                        data-lat="<?= $this->session->userdata('user_lat') ?>"
                        data-lng="<?= $this->session->userdata('user_lng') ?>"
                        data-cities="<?= htmlspecialchars(implode(',', $all_db_cities ?? [])) ?>"
                        value="<?= !empty($user_location) ? htmlspecialchars($user_location) : '' ?>">
                </div>
            </div>
            <div class="search-divider"></div>
            <div class="search-input-group">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" id="homepageSearchInput" class="form-control" placeholder="Search service or trainer…" aria-label="Search Service">
                </div>
            </div>
            <button class="search-btn" id="homepageSearchBtn" type="button">
                <i class="fas fa-search me-2" aria-hidden="true"></i>Search
            </button>
        </div>
    </div>


    <!-- ═══ CATEGORIES ═══ -->
    <section class="services-section">
        <div class="container">
            <div class="fkh-section-header">
                <div>
                    <span class="fkh-section-label">Explore</span>
                    <h2 class="fkh-section-title">Choose Your <em>Category</em></h2>
                    <p class="fkh-section-sub">Discover tailored services built for your fitness goals</p>
                </div>
                <a href="<?= base_url('services') ?>" class="fkh-view-all">
                    View All <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="category-grid">
                <?php foreach ($category as $cat): ?>
                    <a href="<?= base_url('providers?category=' . $cat->id) ?>" class="category-link">
                        <div class="service-card">
                            <div class="service-icon">
                                <img src="<?= base_url($cat->image) ?>" alt="<?= htmlspecialchars($cat->name) ?>" class="avatar-img" loading="lazy" decoding="async">
                            </div>
                            <div>
                                <div class="service-title"><?= strtoupper($cat->name) ?></div>
                                <div class="service-subtitle"><?= $cat->provider_count ?> Providers</div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <?php if (!empty($nearest_providers)): ?>
    <!-- ═══ NEAREST PROVIDERS (dark bg) ═══ -->
    <section class="experts-section fkh-bg-dark">
        <div class="container" style="position:relative; z-index:2;">
            <div class="fkh-section-header">
                <div>
                    <span class="fkh-section-label fkh-section-label--dark">Near You</span>
                    <h2 class="fkh-section-title fkh-section-title--dark">Nearest <em style="color:#b19fe8">Providers</em></h2>
                    <p class="fkh-section-sub fkh-section-sub--dark">Fitness professionals closest to your location</p>
                </div>
                <a href="<?= base_url('providers') ?>" class="fkh-view-all" style="border-color:rgba(255,255,255,0.15); color:rgba(255,255,255,0.7);">
                    View All <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="swiper nearestSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($nearest_providers as $np): ?>
                        <div class="swiper-slide">
                            <div class="expert-card">
                                <div class="expert-left">
                                    <div class="expert-logo">
                                        <img src="<?= base_url(!empty($np->profile_image) ? $np->profile_image : 'assets/images/3d-cartoon-fitness-man.jpg') ?>"
                                            alt="<?= htmlspecialchars($np->gym_name ?: $np->name) ?>" class="avatar-img" loading="lazy" decoding="async">
                                    </div>
                                    <div>
                                        <div class="expert-title"><?= $np->gym_name ?: $np->name ?></div>
                                        <div class="expert-services"><?= $np->total_services ?> Services</div>
                                    </div>
                                </div>
                                <div class="expert-footer">
                                    <?php 
                                    $is_loc_enabled = ($lat != 0 && $lng != 0);
                                    $dist_label = !is_null($np->distance) ? round($np->distance, 1) . ' Km' : ($is_loc_enabled ? 'N/A' : 'Enable Location');
                                    $is_trigger = ($dist_label === 'Enable Location');
                                    ?>
                                    <span class="distance-pill <?= $is_trigger ? 'fkp-enable-loc-trigger' : '' ?>" style="<?= $is_trigger ? 'cursor: pointer; color: #b19fe8;' : '' ?>">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                        <?= $dist_label ?>
                                    </span>
                                    <a href="<?= site_url('provider_details/' . $np->provider_id) ?>" class="view-more-btn">
                                        <span class="view-more-text">View</span>
                                        <i class="fas fa-chevron-right fkh-arrow-icon" style="font-size:0.75rem; color:var(--primary-color);" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <!-- ═══ BANNER 1 — Become a Provider ═══ -->
    <section class="fkh-banner-wrap">
        <div class="container">
            <div class="edemand-banner">
                <span class="banner-watermark" aria-hidden="true">JOIN</span>
                <div class="banner-text">
                    <span class="banner-eyebrow">For Professionals</span>
                    <h2>Want to Become a<br><em>Service Provider?</em></h2>
                    <p>Join our platform and grow your business by reaching thousands of customers. Start offering your services online with ease and flexibility.</p>
                    <a class="buy-btn" href="<?= base_url('provider/sing_up') ?>">
                        <i class="fas fa-user-plus me-2" aria-hidden="true"></i>Become a Provider
                    </a>
                </div>
                <div class="banner-illustration" aria-hidden="true">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="white">
                        <circle cx="100" cy="100" r="90" fill="none" stroke="white" stroke-width="5" />
                        <circle cx="100" cy="72" r="28" />
                        <path d="M40 160 Q100 110 160 160" stroke="white" stroke-width="6" fill="none" />
                        <path d="M55 155 Q100 120 145 155" />
                        <circle cx="152" cy="52" r="14" />
                        <line x1="152" y1="38" x2="152" y2="22" stroke="white" stroke-width="5" stroke-linecap="round" />
                        <line x1="152" y1="66" x2="152" y2="82" stroke="white" stroke-width="5" stroke-linecap="round" />
                        <line x1="138" y1="52" x2="122" y2="52" stroke="white" stroke-width="5" stroke-linecap="round" />
                        <line x1="166" y1="52" x2="182" y2="52" stroke="white" stroke-width="5" stroke-linecap="round" />
                    </svg>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══ POPULAR GYM ═══ -->
    <section class="experts-section" style="background: var(--bg-light);">
        <div class="container">
            <div class="fkh-section-header">
                <div>
                    <span class="fkh-section-label">Top Picks</span>
                    <h2 class="fkh-section-title">Popular <em>Gyms</em></h2>
                    <p class="fkh-section-sub">Trusted facilities ready to help you reach your goals</p>
                </div>
                <a href="<?= base_url('providers?type=gym') ?>" class="fkh-view-all">
                    View All <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="swiper gymSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($gym_providers as $provider): ?>
                        <div class="swiper-slide">
                            <div class="expert-card">
                                <div class="expert-left">
                                    <div class="expert-logo">
                                        <img src="<?= !empty($provider->profile_image) ? base_url($provider->profile_image) : base_url('assets/images/3d-cartoon-fitness-man.jpg') ?>"
                                            alt="<?= htmlspecialchars($provider->gym_name) ?>" class="avatar-img" loading="lazy" decoding="async">
                                    </div>
                                    <div>
                                        <div class="expert-title"><?= $provider->gym_name ?></div>
                                        <div class="expert-services"><?= $provider->total_services ?? '0' ?> Services</div>
                                    </div>
                                </div>
                                <div class="expert-footer">
                                    <?php 
                                    $is_loc_enabled = ($lat != 0 && $lng != 0);
                                    $dist_label = !is_null($provider->distance) ? round($provider->distance, 1) . ' Km' : ($is_loc_enabled ? 'N/A' : 'Enable Location');
                                    $is_trigger = ($dist_label === 'Enable Location');
                                    ?>
                                    <span class="distance-pill <?= $is_trigger ? 'fkp-enable-loc-trigger' : '' ?>" style="<?= $is_trigger ? 'cursor: pointer; color: var(--primary-color);' : '' ?>">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                        <?= $dist_label ?>
                                    </span>
                                    <a href="<?= site_url('provider_details/' . $provider->provider_id) ?>" class="view-more-btn">
                                        <span class="view-more-text">View</span>
                                        <i class="fas fa-chevron-right fkh-arrow-icon" style="font-size:0.75rem; color:var(--primary-color);" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>


    <!-- ═══ BANNER 2 — Special Offer (accent variant) ═══ -->
    <section class="fkh-banner-wrap">
        <div class="container">
            <div class="edemand-banner edemand-banner--accent">
                <span class="banner-watermark" aria-hidden="true">OFFER</span>
                <div class="banner-text">
                    <span class="banner-eyebrow">Limited Time</span>
                    <h2>FitPro Gym –<br><em style="-webkit-text-fill-color:var(--warning); background:none;">Special Offer!</em></h2>
                    <p>Get 20% off on your first membership. Join today with professional trainers and modern facilities designed for results.</p>
                    <a class="buy-btn" href="<?= base_url('services') ?>">
                        <i class="fas fa-bolt me-2" aria-hidden="true"></i>Book Now
                    </a>
                </div>
                <div class="banner-illustration" aria-hidden="true">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="white">
                        <rect x="20" y="88" width="160" height="24" rx="12" />
                        <rect x="10" y="68" width="36" height="64" rx="10" />
                        <rect x="154" y="68" width="36" height="64" rx="10" />
                        <rect x="2" y="80" width="22" height="40" rx="8" />
                        <rect x="176" y="80" width="22" height="40" rx="8" />
                        <circle cx="155" cy="48" r="26" fill="none" stroke="white" stroke-width="5" />
                        <text x="155" y="58" text-anchor="middle" font-size="26" font-weight="900" fill="white">%</text>
                    </svg>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══ POPULAR TRAINERS (dark bg) ═══ -->
    <section class="experts-section fkh-bg-dark" style="padding-bottom: 80px;">
        <div class="container" style="position:relative; z-index:2;">
            <div class="fkh-section-header">
                <div>
                    <span class="fkh-section-label fkh-section-label--dark">Certified</span>
                    <h2 class="fkh-section-title fkh-section-title--dark">Popular <em style="color:#b19fe8">Trainers</em></h2>
                    <p class="fkh-section-sub fkh-section-sub--dark">Professionals ready to assist you anytime, anywhere</p>
                </div>
                <a href="<?= base_url('providers?type=trainer&popular=1') ?>" class="fkh-view-all" style="border-color:rgba(255,255,255,0.15); color:rgba(255,255,255,0.7);">
                    View All <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
            <div class="swiper trainerSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($trainer_providers as $provider): ?>
                        <div class="swiper-slide">
                            <div class="expert-card">
                                <div class="expert-left">
                                    <div class="expert-logo">
                                        <img src="<?= !empty($provider->profile_image) ? base_url($provider->profile_image) : base_url('assets/images/3d-cartoon-fitness-man.jpg') ?>"
                                            alt="<?= htmlspecialchars($provider->name) ?>" class="avatar-img" loading="lazy" decoding="async">
                                    </div>
                                    <div>
                                        <div class="expert-title"><?= $provider->gym_name ?></div>
                                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                            <span class="expert-services"><?= $provider->total_services ?? '0' ?> Services</span>
                                            <?php if ($provider->avg_rating > 3.5): ?>
                                                <span class="expert-rating" style="display: inline-flex; align-items: center; gap: 3px; color: #ffb800; font-size: 0.8rem;">
                                                    <i class="fas fa-star" aria-hidden="true"></i>
                                                    <span style="font-weight: 600; color: #fff;"><?= number_format($provider->avg_rating, 1) ?></span>
                                                    <span style="color: rgba(255,255,255,0.5); font-size: 0.75rem;">(<?= $provider->total_reviews ?>)</span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="expert-footer">
                                    <?php 
                                    $is_loc_enabled = ($lat != 0 && $lng != 0);
                                    $dist_label = !is_null($provider->distance) ? round($provider->distance, 1) . ' Km' : ($is_loc_enabled ? 'N/A' : 'Enable Location');
                                    $is_trigger = ($dist_label === 'Enable Location');
                                    ?>
                                    <span class="distance-pill <?= $is_trigger ? 'fkp-enable-loc-trigger' : '' ?>" style="<?= $is_trigger ? 'cursor: pointer; color: #b19fe8;' : '' ?>">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                        <?= $dist_label ?>
                                    </span>
                                    <a href="<?= site_url('provider_details/' . $provider->provider_id) ?>" class="view-more-btn">
                                        <span class="view-more-text">View</span>
                                        <i class="fas fa-chevron-right fkh-arrow-icon" style="font-size:0.75rem; color:var(--primary-color);" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                 </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("homepageSearchInput");
    const searchBtn = document.getElementById("homepageSearchBtn");

    if (searchBtn && searchInput) {
        searchBtn.addEventListener("click", function() {
            const keyword = searchInput.value.trim();
            if (keyword) {
                window.location.href = "<?= base_url('providers') ?>?search=" + encodeURIComponent(keyword);
            }
        });

        searchInput.addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                const keyword = searchInput.value.trim();
                if (keyword) {
                    window.location.href = "<?= base_url('providers') ?>?search=" + encodeURIComponent(keyword);
                }
            }
        });
    }
});
</script>
