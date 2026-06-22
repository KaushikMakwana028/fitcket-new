<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --primary-color: #6f42c1;
        --primary-dark: #5a32a3;
        --primary-light: #d8c9f0;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --warning-color: #e67e22;
        --success-color: #16a34a;
        --white: #ffffff;
        --light-bg: #f8f9fa;
        --text-dark: #1a1a1a;
        --text-muted: #6c757d;
        --border-color: #ececec;
        --border-radius: 16px;
        --shadow: 0 4px 20px rgba(111, 66, 193, 0.07);
        --shadow-hover: 0 12px 36px rgba(111, 66, 193, 0.13);
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        --gradient-primary: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
        --gradient-success: linear-gradient(135deg, #16a34a 0%, #2ecc71 100%);
    }

    .fkpd-page {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    .fkpd-page *,
    .fkpd-page *::before,
    .fkpd-page *::after {
        box-sizing: border-box;
    }

    .fkpd-page *:focus-visible {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* ══════════════════════════════════════════
       BREADCRUMB
    ══════════════════════════════════════════ */
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
        font-size: 0.88rem;
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
        color: var(--primary-dark);
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

    /* ══════════════════════════════════════════
       LEFT PROFILE CARD
    ══════════════════════════════════════════ */
    .provider-card {
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow);
        background: var(--white);
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
        z-index: 2;
    }

    @media (min-width: 992px) {
        .provider-card {
            position: sticky;
            top: 90px;
        }
    }

    .provider-img-container {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: var(--light-bg);
    }

    .provider-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .provider-card:hover .provider-img {
        transform: scale(1.04);
    }

    .provider-body {
        background: var(--white);
        padding: 1.5rem;
    }

    .provider-body h4 {
        font-weight: 800;
        letter-spacing: -0.01em;
        font-size: 1.3rem;
    }

    .provider-body .text-primary {
        color: var(--primary-color) !important;
    }

    .provider-body a.text-primary:hover {
        color: var(--primary-dark) !important;
        text-decoration: underline;
    }

    .provider-body .border-top {
        border-color: var(--border-color) !important;
    }

    .badge.bg-light {
        background: rgba(111, 66, 193, 0.07) !important;
        color: var(--primary-color) !important;
        border-color: rgba(111, 66, 193, 0.2) !important;
        font-weight: 600;
        transition: var(--transition);
    }

    .badge.bg-light:hover {
        background: var(--primary-color) !important;
        color: var(--white) !important;
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════════
       TABS
    ══════════════════════════════════════════ */
    .custom-tabs {
        background: rgba(111, 66, 193, 0.06);
        padding: 0.6rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
    }

    .custom-tabs .nav-link {
        background: var(--white);
        border-radius: 10px;
        color: var(--secondary-color);
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.7rem 1rem;
        transition: var(--transition);
        border: 1.5px solid transparent;
        margin: 0 0.2rem;
    }

    .custom-tabs .nav-link.active {
        color: var(--white) !important;
        background: var(--gradient-primary) !important;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(111, 66, 193, 0.25);
    }

    .custom-tabs .nav-link:hover:not(.active) {
        background: var(--white);
        color: var(--primary-color);
        border-color: rgba(111, 66, 193, 0.25);
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .custom-tabs {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            gap: 6px !important;
            padding: 0.5rem !important;
            scrollbar-width: none;
        }

        .custom-tabs::-webkit-scrollbar {
            display: none;
        }

        .custom-tabs .nav-item {
            flex: 0 0 auto !important;
            margin: 0 !important;
        }

        .custom-tabs .nav-link {
            white-space: nowrap !important;
            padding: 0.6rem 1rem !important;
            font-size: 0.84rem !important;
            margin: 0 !important;
        }
    }

    /* ══════════════════════════════════════════
       GENERIC CARD
    ══════════════════════════════════════════ */
    .card {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        background: var(--white);
    }

    .card.border-0 {
        border: 1px solid var(--border-color) !important;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
    }

    .card-header {
        background: var(--gradient-primary) !important;
        border-bottom: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        color: var(--white);
    }

    /* ══════════════════════════════════════════
       PRICING GRID
    ══════════════════════════════════════════ */
    .pricing-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-top: 1.4rem;
    }

    .pricing-option-card {
        position: relative;
        background: var(--white);
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 1.1rem 1rem;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 0;
        user-select: none;
    }

    .pricing-option-card:hover {
        border-color: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(111, 66, 193, 0.08);
    }

    .pricing-option-card.active {
        border-color: var(--primary-color);
        background-color: rgba(111, 66, 193, 0.04);
        box-shadow: 0 10px 22px rgba(111, 66, 193, 0.1);
    }

    .pricing-option-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .pricing-option-card .custom-radio-indicator {
        width: 19px;
        height: 19px;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        position: relative;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .pricing-option-card.active .custom-radio-indicator {
        border-color: var(--primary-color);
    }

    .pricing-option-card.active .custom-radio-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 9px;
        height: 9px;
        background-color: var(--primary-color);
        border-radius: 50%;
    }

    .pricing-option-card .pricing-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background-color: rgba(111, 66, 193, 0.08);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .pricing-option-card.active .pricing-card-icon {
        background-color: var(--primary-color);
        color: var(--white);
    }

    .pricing-option-card .pricing-card-details {
        flex-grow: 1;
        min-width: 0;
    }

    .pricing-option-card .pricing-card-label {
        font-size: 0.72rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .pricing-option-card .pricing-card-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-dark);
        white-space: nowrap;
    }

    .pricing-option-card .pricing-card-period {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-muted);
    }

    /* ══════════════════════════════════════════
       OFFER CARDS
    ══════════════════════════════════════════ */
    .offer-card {
        background: linear-gradient(135deg, #ffffff 0%, #fdfaff 100%);
        border: 1.5px dashed rgba(111, 66, 193, 0.35);
        border-radius: var(--border-radius);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        padding: 1.4rem 1rem !important;
    }

    .offer-card::before,
    .offer-card::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 14px;
        height: 28px;
        background-color: var(--white);
        transform: translateY(-50%);
        z-index: 2;
        border: 1.5px dashed rgba(111, 66, 193, 0.35);
    }

    .offer-card::before {
        left: -8px;
        border-radius: 0 14px 14px 0;
        border-left: 0;
    }

    .offer-card::after {
        right: -8px;
        border-radius: 14px 0 0 14px;
        border-right: 0;
    }

    .offer-card:hover {
        transform: translateY(-3px);
        border-color: var(--primary-color);
        box-shadow: 0 10px 26px rgba(111, 66, 193, 0.1);
    }

    .offer-duration-badge {
        background: rgba(111, 66, 193, 0.1);
        color: var(--primary-color);
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        font-size: 0.8rem;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .offer-deal {
        font-size: 1.18rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 6px;
    }

    .offer-deal span {
        color: var(--accent-color);
    }

    .offer-details {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0;
        font-weight: 500;
    }

    /* ══════════════════════════════════════════
       QUANTITY + DATE
    ══════════════════════════════════════════ */
    .qty-input-group {
        width: 140px;
        border: 2px solid #cbd5e1;
        border-radius: var(--border-radius);
        overflow: hidden;
        background-color: var(--white);
    }

    .qty-input-group .btn-qty-btn {
        border: none !important;
        background-color: transparent !important;
        color: var(--primary-color) !important;
        font-size: 0.92rem;
        padding: 0.5rem 0.85rem;
        transition: var(--transition);
        box-shadow: none !important;
    }

    .qty-input-group .btn-qty-btn:hover {
        background-color: #f1f5f9 !important;
    }

    .qty-input-group .qty-input-value {
        border: none !important;
        background-color: transparent !important;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-dark) !important;
        padding: 0;
        box-shadow: none !important;
    }

    .form-control,
    .input-group .form-control {
        border-radius: 10px;
        border: 2px solid var(--border-color);
        transition: var(--transition);
        background: var(--white);
        font-family: 'Poppins', sans-serif;
    }

    .form-control:focus,
    .input-group .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.12);
        background: var(--white);
    }

    /* ══════════════════════════════════════════
       BUTTONS
    ══════════════════════════════════════════ */
    .btn {
        border-radius: 10px;
        font-weight: 600;
        transition: var(--transition);
        font-family: 'Poppins', sans-serif;
    }

    .btn-primary {
        background: var(--gradient-primary);
        border: none;
        box-shadow: 0 6px 18px rgba(111, 66, 193, 0.22);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(111, 66, 193, 0.3);
        background: var(--gradient-primary);
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: var(--white);
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    /* ══════════════════════════════════════════
       SERVICE TYPE / LANGUAGE
    ══════════════════════════════════════════ */
    .language-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.85rem;
        background: var(--white);
        border: 1.5px solid var(--primary-light);
        border-radius: 50px;
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .language-chip i {
        font-size: 0.85rem;
    }

    .language-chip:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .service-type-container {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .service-type-badge {
        flex: 1;
        min-width: 200px;
        padding: 1.4rem;
        border-radius: var(--border-radius);
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .service-type-badge.online {
        background: var(--gradient-primary);
        color: var(--white);
    }

    .service-type-badge.offline {
        background: linear-gradient(135deg, #8e44ad 0%, #c2185b 100%);
        color: var(--white);
    }

    .service-type-badge:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
    }

    .service-type-badge i {
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .service-type-badge h5 {
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .service-type-badge p {
        margin: 0;
        font-size: 0.86rem;
        opacity: 0.9;
    }

    /* ══════════════════════════════════════════
       CONTACT INFO — REDESIGNED
    ══════════════════════════════════════════ */
    .contact-card-body {
        padding: 1.25rem !important;
    }

    .contact-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0.85rem 1rem;
        background: var(--light-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 10px;
        transition: var(--transition);
    }

    .contact-row:last-child {
        margin-bottom: 0;
    }

    .contact-row:hover {
        background: var(--white);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 66, 193, 0.08);
    }

    .contact-icon-wrap {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-icon-wrap.owner {
        background: rgba(111, 66, 193, 0.12);
        color: var(--primary-color);
    }

    .contact-icon-wrap.email {
        background: rgba(194, 24, 91, 0.1);
        color: #c2185b;
    }

    .contact-icon-wrap.phone {
        background: rgba(83, 74, 183, 0.1);
        color: #534ab7;
    }

    .contact-icon-wrap.addr {
        background: rgba(15, 110, 86, 0.1);
        color: #0f6e56;
    }

    .contact-icon-wrap i {
        font-size: 1rem;
    }

    .contact-text {
        min-width: 0;
        flex: 1;
    }

    .contact-label-new {
        font-size: 0.68rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 2px;
    }

    .contact-value-new {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-dark);
        word-break: break-word;
        line-height: 1.4;
    }

    .contact-value-new.email-val {
        font-size: 0.82rem;
        word-break: break-all;
    }

    .map-wrapper {
        overflow: hidden;
        border-top: 1px solid var(--border-color);
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    .map-wrapper img {
        width: 100%;
        height: 175px;
        object-fit: cover;
        display: block;
        cursor: pointer;
        transition: var(--transition);
    }

    .map-wrapper:hover img {
        transform: scale(1.03);
    }

    /* ══════════════════════════════════════════
       SCHEDULE
    ══════════════════════════════════════════ */
    .schedule-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border-color);
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
        box-shadow: var(--shadow-hover);
    }

    .schedule-card:hover::before {
        opacity: 1;
    }

    .badge.bg-primary {
        background: var(--gradient-primary) !important;
    }

    /* ══════════════════════════════════════════
       REVIEWS
    ══════════════════════════════════════════ */
    .review-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 15px;
        transition: var(--transition);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .review-card:hover {
        box-shadow: var(--shadow-hover);
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
        font-weight: 700;
        color: var(--text-dark);
        font-size: 0.98rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reviewer-name i {
        color: var(--primary-color);
        font-size: 1.15rem;
    }

    .review-stars {
        color: var(--warning-color);
        font-size: 0.95rem;
    }

    .review-stars i {
        margin: 0 1px;
    }

    .review-text {
        color: var(--text-muted);
        line-height: 1.65;
        margin: 0;
        word-wrap: break-word;
        font-size: 0.92rem;
    }

    .review-date {
        color: #999;
        font-size: 0.82rem;
        margin-top: 10px;
        display: block;
    }

    .star-rating-input {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .star-rating-input label {
        cursor: pointer;
        color: var(--warning-color);
        font-weight: 500;
    }

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
        background: var(--primary-light);
        border-radius: 10px;
    }

    .reviews-scroll-container::-webkit-scrollbar-thumb:hover {
        background: var(--primary-color);
    }

    /* ══════════════════════════════════════════
       GALLERY
    ══════════════════════════════════════════ */
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
        inset: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(26, 26, 26, 0.65) 100%);
        opacity: 0;
        transition: var(--transition);
        z-index: 1;
    }

    .gallery-item:hover::before {
        opacity: 1;
    }

    /* ══════════════════════════════════════════
       CERTIFICATIONS
    ══════════════════════════════════════════ */
    .certification-card {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 1.4rem;
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
        font-size: 2.8rem;
        color: var(--primary-light);
        opacity: 0.25;
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
        font-size: 0.88rem;
        margin-bottom: 0.5rem;
    }

    .certification-year {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: var(--gradient-primary);
        color: var(--white);
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 600;
    }

    /* ══════════════════════════════════════════
       SERVICE ITEM CARDS
    ══════════════════════════════════════════ */
    .service-item-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-item-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-light);
    }

    .service-item-img-wrapper {
        position: relative;
        height: 170px;
        overflow: hidden;
        background: var(--light-bg);
    }

    .service-item-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .service-item-card:hover .service-item-img-wrapper img {
        transform: scale(1.06);
    }

    .service-item-body {
        padding: 1.1rem 1.2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .service-item-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .service-item-desc {
        font-size: 0.84rem;
        color: var(--text-muted);
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .service-item-footer {
        padding: 0.9rem 1.2rem;
        background-color: #fafafa;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .service-item-price {
        font-size: 1.12rem;
        font-weight: 800;
        color: var(--primary-color);
    }

    .service-item-price small {
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .service-item-btn {
        background: var(--gradient-primary);
        color: var(--white) !important;
        border: none;
        border-radius: 8px;
        padding: 0.48rem 1.2rem;
        font-weight: 600;
        font-size: 0.84rem;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(111, 66, 193, 0.2);
    }

    .service-item-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(111, 66, 193, 0.28);
    }

    /* ══════════════════════════════════════════
       FITTV
    ══════════════════════════════════════════ */
    .fittv-slider {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding-bottom: 10px;
        scrollbar-width: none;
    }

    .fittv-slider::-webkit-scrollbar {
        display: none;
    }

    .fittv-card {
        min-width: 220px;
        cursor: pointer;
        transition: var(--transition);
    }

    .fittv-card:hover {
        transform: scale(1.06);
        z-index: 5;
    }

    .fittv-card video {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
    }

    .fittv-title {
        font-size: 14px;
        font-weight: 600;
        margin-top: 8px;
        color: var(--text-dark);
        text-align: center;
    }

    /* ══════════════════════════════════════════
       ANIMATIONS
    ══════════════════════════════════════════ */
    .fade-in {
        opacity: 0;
        transform: translateY(16px);
        animation: fkpdFadeIn 0.5s ease-out forwards;
    }

    @keyframes fkpdFadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .fade-in {
            opacity: 1;
            transform: none;
            animation: none;
        }

        * {
            transition: none !important;
            animation: none !important;
            transform: none !important;
        }
    }

    /* ══════════════════════════════════════════
       MOBILE RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 768px) {
        .provider-img-container {
            height: 190px;
        }

        .provider-body {
            padding: 1.25rem;
        }

        .provider-body h4 {
            font-size: 1.15rem;
        }

        .custom-tabs .nav-link {
            font-size: 0.84rem;
            padding: 0.6rem 0.9rem;
        }

        .pricing-card-grid {
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .pricing-option-card {
            padding: 0.9rem 0.75rem;
            gap: 9px;
        }

        .pricing-option-card .pricing-card-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .pricing-option-card .pricing-card-price {
            font-size: 0.96rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }

        .service-type-badge {
            min-width: 100%;
        }

        .header-section {
            flex-direction: column !important;
            gap: 10px;
            align-items: flex-start !important;
        }

        .header-section .btn {
            width: 100%;
        }

        .reviews-scroll-container {
            max-height: 500px !important;
        }

        .contact-row {
            padding: 0.85rem 1rem;
            gap: 12px;
        }

        .contact-icon-wrap {
            width: 34px;
            height: 34px;
        }
    }

    @media (max-width: 576px) {
        .pricing-card-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .reviewer-name {
            font-size: 0.92rem;
        }

        .review-stars {
            font-size: 0.86rem;
        }

        .review-text {
            font-size: 0.88rem;
        }

        .d-flex.flex-wrap.gap-4 {
            gap: 1rem !important;
        }

        .qty-input-group {
            width: 100%;
        }

        .date-selector-container {
            width: 100%;
        }

        .contact-value-new {
            font-size: 0.85rem;
        }

        .contact-value-new.email-val {
            font-size: 0.78rem;
        }

        .map-wrapper img {
            height: 150px;
        }
    }
</style>

<div class="fkpd-page">

    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>">
                        <i class="fas fa-home me-1" aria-hidden="true"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url('providers'); ?>">
                        <i class="fas fa-users me-1" aria-hidden="true"></i>Providers
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-user me-1" aria-hidden="true"></i>Provider Details
                </li>
            </ol>
        </nav>
    </div>

    <div class="container py-4">
        <div class="row g-3">

            <!-- ══════════════════════════════════════════
                 LEFT PROFILE CARD
            ══════════════════════════════════════════ -->
            <div class="col-lg-4 col-md-12">
                <div class="provider-card shadow-sm fade-in">
                    <input type="hidden" name="provider_id" value="<?= $provider->provider_id; ?>">

                    <div class="provider-img-container">
                        <img src="<?= base_url($provider->profile_image); ?>" class="provider-img mx-auto d-block"
                            alt="<?= htmlspecialchars($provider->gym_name); ?>">
                    </div>

                    <div class="provider-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0 text-dark"><?= $provider->gym_name; ?></h4>
                            <a href="#services" class="text-primary fw-bold small" onclick="openServicesTab()"><?= $provider->service_count; ?> Services</a>
                        </div>

                        <div class="text-muted mb-3">
                            <i class="fa fa-location-dot me-2 text-primary" aria-hidden="true"></i>
                            <?= $city; ?>, <?= $state; ?>
                        </div>

                        <p class="text-muted small mb-2"
                            style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 1.6;">
                            <?= $provider->description; ?>
                        </p>
                        <a href="#about" class="text-primary fw-bold small d-inline-block mb-3" onclick="openAboutTab()">Read More</a>

                        <?php
                        $tags = [];
                        if (isset($provider->expertise_tags) && !empty($provider->expertise_tags)) {
                            $tags = explode(',', $provider->expertise_tags);
                        }
                        ?>
                        <div class="mt-3 pt-3 border-top">
                            <h6 class="fw-bold mb-2 text-uppercase text-secondary" style="font-size: 0.8rem; letter-spacing: 0.5px;">Expertise</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($tags)): ?>
                                    <?php foreach ($tags as $tag): ?>
                                        <span class="badge rounded-pill bg-light text-primary border px-3 py-2 fade-in" style="font-size: 0.8rem;">
                                            <?= htmlspecialchars(trim($tag)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted small">No expertise added</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══════════════════════════════════════════
                 RIGHT SECTION
            ══════════════════════════════════════════ -->
            <div class="col-lg-8 col-md-12">

                <!-- TABS -->
                <ul class="nav nav-pills custom-tabs mb-3 justify-content-between d-flex gap-2" id="providerTabs" role="tablist">
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100 active" id="pricing-tab" data-bs-toggle="pill" data-bs-target="#pricing-section" type="button">
                            <i class="fa fa-tags me-2" aria-hidden="true"></i>Pricing
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="services-tab" data-bs-toggle="pill" data-bs-target="#services" type="button">
                            <i class="fa fa-dumbbell me-2" aria-hidden="true"></i>Services
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="about-tab" data-bs-toggle="pill" data-bs-target="#about" type="button">
                            <i class="fa fa-info-circle me-2" aria-hidden="true"></i>About
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="schedule-tab" data-bs-toggle="pill" data-bs-target="#schedule" type="button">
                            <i class="fa fa-clock me-2" aria-hidden="true"></i>Schedule
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="review-tab" data-bs-toggle="pill" data-bs-target="#review" type="button">
                            <i class="fa-solid fa-comments me-2" aria-hidden="true"></i>Review
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="gallery-tab" data-bs-toggle="pill" data-bs-target="#gallery" type="button">
                            <i class="fa-solid fa-images me-2" aria-hidden="true"></i>Gallery
                        </button>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <button class="nav-link w-100" id="certification-tab" data-bs-toggle="pill" data-bs-target="#certification" type="button">
                            <i class="fa-solid fa-certificate me-2" aria-hidden="true"></i>Certificates
                        </button>
                    </li>
                </ul>

                <!-- TAB CONTENT -->
                <div class="tab-content" id="tabContentArea">

                    <!-- ══════ PRICING TAB ══════ -->
                    <div class="tab-pane fade show active" id="pricing-section" role="tabpanel" aria-labelledby="pricing-tab">
                        <div class="card shadow-sm p-4 mt-3 fade-in">
                            <h6 class="fw-bold mb-2 text-uppercase text-secondary" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                <i class="fa fa-map-marker-alt me-2 text-primary" aria-hidden="true"></i>Available in Cities
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                if (!empty($provider->city)) {
                                    $cities = explode(',', $provider->city);
                                    foreach ($cities as $c) { ?>
                                        <span class="badge rounded-pill px-3 py-2 fade-in" style="font-size: 0.8rem; background: var(--gradient-primary); color:#fff;">
                                            <?= htmlspecialchars(trim($c)); ?>
                                        </span>
                                    <?php }
                                } else { ?>
                                    <span class="badge bg-light text-dark border px-3 py-2">City not available</span>
                                <?php } ?>
                            </div>

                            <div class="pricing-card-grid">
                                <?php if (!empty($provider)): ?>
                                    <label class="pricing-option-card active">
                                        <input type="radio" name="priceOption" data-price="<?= $provider->day_price; ?>" data-label="Day" checked>
                                        <div class="custom-radio-indicator"></div>
                                        <div class="pricing-card-icon"><i class="fa fa-calendar-day" aria-hidden="true"></i></div>
                                        <div class="pricing-card-details">
                                            <div class="pricing-card-label">Day Pass</div>
                                            <div class="pricing-card-price">₹<?= number_format($provider->day_price, 2); ?><span class="pricing-card-period">/day</span></div>
                                        </div>
                                    </label>
                                    <label class="pricing-option-card">
                                        <input type="radio" name="priceOption" data-price="<?= $provider->week_price; ?>" data-label="Week">
                                        <div class="custom-radio-indicator"></div>
                                        <div class="pricing-card-icon"><i class="fa fa-calendar-week" aria-hidden="true"></i></div>
                                        <div class="pricing-card-details">
                                            <div class="pricing-card-label">Weekly Pass</div>
                                            <div class="pricing-card-price">₹<?= number_format($provider->week_price, 2); ?><span class="pricing-card-period">/week</span></div>
                                        </div>
                                    </label>
                                    <label class="pricing-option-card">
                                        <input type="radio" name="priceOption" data-price="<?= $provider->month_price; ?>" data-label="Month">
                                        <div class="custom-radio-indicator"></div>
                                        <div class="pricing-card-icon"><i class="fa fa-calendar-alt" aria-hidden="true"></i></div>
                                        <div class="pricing-card-details">
                                            <div class="pricing-card-label">Monthly Pass</div>
                                            <div class="pricing-card-price">₹<?= number_format($provider->month_price, 2); ?><span class="pricing-card-period">/month</span></div>
                                        </div>
                                    </label>
                                    <?php $yearPrice = is_numeric($provider->year_price) ? (float)$provider->year_price : 0; ?>
                                    <label class="pricing-option-card">
                                        <input type="radio" name="priceOption" data-price="<?= $yearPrice; ?>" data-label="Year">
                                        <div class="custom-radio-indicator"></div>
                                        <div class="pricing-card-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
                                        <div class="pricing-card-details">
                                            <div class="pricing-card-label">Yearly Pass</div>
                                            <div class="pricing-card-price"><?= $yearPrice > 0 ? '₹' . number_format($yearPrice, 2) : 'N/A'; ?><span class="pricing-card-period">/year</span></div>
                                        </div>
                                    </label>
                                <?php endif; ?>
                            </div>

                            <form method="post" action="<?= site_url('cart/add_to_cart'); ?>" id="cartForm">
                                <input type="hidden" name="provider_id" id="provider_id" value="<?= $provider->provider_id; ?>">
                                <input type="hidden" name="provider_name" value="<?= $provider->gym_name; ?>">
                                <input type="hidden" name="provider_image" value="<?= base_url($provider->profile_image); ?>">
                                <input type="hidden" name="price" id="priceInput" value="<?= $provider->day_price; ?>">
                                <input type="hidden" name="duration" id="durationInput" value="day">

                                <?php if (!empty($offers)): ?>
                                    <div class="mt-5 pt-3 border-top">
                                        <h6 class="fw-bold mb-3 text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                            <i class="fa fa-gift me-2 text-primary" aria-hidden="true"></i>Special Offers
                                        </h6>
                                        <div class="row g-3">
                                            <?php foreach ($offers as $offer): ?>
                                                <div class="col-md-6 col-lg-3 col-sm-6">
                                                    <div class="offer-card text-center shadow-sm h-100">
                                                        <div class="offer-duration-badge"><?= htmlspecialchars($offer->duration) ?></div>
                                                        <div class="offer-deal">Buy <?= $offer->buy_quantity ?> Get <span><?= $offer->free_quantity ?> Free</span></div>
                                                        <p class="offer-details">
                                                            <i class="fa fa-calendar-alt text-success me-1" aria-hidden="true"></i>
                                                            Valid: <?= date('d M Y', strtotime($offer->valid_till)) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted small mt-4 pt-3 border-top">
                                        <i class="fa fa-info-circle me-1" aria-hidden="true"></i>No offers available right now.
                                    </p>
                                <?php endif; ?>

                                <div class="d-flex flex-wrap gap-4 align-items-center mt-5 mb-3">
                                    <div class="qty-selector-container">
                                        <span class="qty-label small fw-bold text-uppercase text-muted mb-2 d-block">
                                            <i class="fa fa-shopping-cart me-1" aria-hidden="true"></i>Quantity
                                        </span>
                                        <div class="input-group qty-input-group">
                                            <button class="btn btn-qty-btn" type="button" id="decreaseQty"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                            <input type="text" id="quantityInput" name="quantity" class="form-control qty-input-value text-center" value="1" readonly>
                                            <button class="btn btn-qty-btn" type="button" id="increaseQty"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="date-selector-container flex-grow-1" style="min-width: 200px;">
                                        <span class="date-label small fw-bold text-uppercase text-muted mb-2 d-block">
                                            <i class="fa fa-calendar-plus me-1" aria-hidden="true"></i>Start Date
                                        </span>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-muted border-end-0">
                                                <i class="fa fa-calendar-alt" aria-hidden="true"></i>
                                            </span>
                                            <input type="date" class="form-control border-start-0 ps-1" id="startDate" name="start_date" required>
                                        </div>
                                    </div>
                                </div>

                                <small id="dateError" class="text-danger d-none"></small>

                                <button type="button" class="btn btn-primary w-100 py-3 mt-4 fw-bold mb-3"
                                    style="border-radius: 12px; font-size: 1.05rem;"
                                    onclick="validateAndBook(<?= isset($this->user['id']) ? $this->user['id'] : '0'; ?>)">
                                    <i class="fa fa-rocket me-2" aria-hidden="true"></i>Book Now
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- ══════ SERVICES TAB ══════ -->
                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                        <div id="service-list"></div>
                        <nav class="mt-3 mb-5">
                            <ul class="pagination justify-content-center" id="service-pagination"></ul>
                        </nav>
                    </div>

                    <!-- ══════ FITTV TAB ══════ -->
                    <div class="tab-pane fade" id="fittv" role="tabpanel" aria-labelledby="fittv-tab">
                        <div class="container py-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">
                                        <i class="fa fa-play-circle me-2 text-primary" aria-hidden="true"></i>Workout Videos
                                    </h5>
                                    <?php if (!empty($fittv_categories)): ?>
                                        <?php foreach ($fittv_categories as $cat): ?>
                                            <h6 class="fw-bold mt-4 mb-3 text-primary"><?= $cat->name ?></h6>
                                            <div class="fittv-slider">
                                                <?php foreach ($cat->videos as $video): ?>
                                                    <div class="fittv-card">
                                                        <a href="<?= base_url('fittv/watch/' . $video->id) ?>">
                                                            <video muted loop onmouseover="this.play()" onmouseout="this.pause();this.currentTime=0">
                                                                <source src="<?= base_url('uploads/videos/' . $video->video) ?>">
                                                            </video>
                                                        </a>
                                                        <p class="fittv-title"><?= $video->title ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-danger text-center fw-bold">No Workout Videos Available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ══════ ABOUT TAB ══════ -->
                    <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <div class="container py-4">

                            <!-- Service Type -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card shadow-sm border-0 fade-in">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-3">
                                                <i class="fa fa-server me-2 text-primary" aria-hidden="true"></i>Service Types Available
                                            </h5>
                                            <div class="service-type-container">
                                                <div class="service-type-badge online">
                                                    <i class="fa fa-wifi" aria-hidden="true"></i>
                                                    <h5>Online</h5>
                                                    <p>Live video classes &amp; personalized training</p>
                                                </div>
                                                <div class="service-type-badge offline">
                                                    <i class="fa fa-building" aria-hidden="true"></i>
                                                    <h5>Offline</h5>
                                                    <p>Visit our facility for hands-on experience</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Languages + Experience -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card shadow-sm border-0 fade-in">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-3">
                                                <i class="fa fa-language me-2 text-primary" aria-hidden="true"></i>Languages Spoken
                                            </h5>
                                            <div class="d-flex flex-wrap gap-3 mb-4">
                                                <div class="language-chip"><i class="fa fa-globe" aria-hidden="true"></i><span>English</span></div>
                                                <div class="language-chip"><i class="fa fa-globe" aria-hidden="true"></i><span>Hindi</span></div>
                                                <div class="language-chip"><i class="fa fa-globe" aria-hidden="true"></i><span>Marathi</span></div>
                                            </div>
                                            <h5 class="fw-bold mb-3">
                                                <i class="fa fa-briefcase me-2 text-primary" aria-hidden="true"></i>Hands-On Experience
                                            </h5>
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="language-chip"><i class="fa fa-award" aria-hidden="true"></i><span>5+ Years</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <!-- About Description -->
                                <div class="col-lg-8 col-md-7 mb-4">
                                    <div class="card shadow-sm border-0 fade-in" style="border-radius: var(--border-radius); overflow: hidden;">
                                        <div class="card-header text-white fw-bold py-3">
                                            <i class="fa fa-user-circle me-2" aria-hidden="true"></i>About the Provider
                                        </div>
                                        <div class="card-body p-4">
                                            <p class="text-muted mb-0" style="line-height: 1.75;">
                                                <?= !empty($provider->description) ? $provider->description : 'No description available.'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- ══════ CONTACT INFO — FULLY REDESIGNED ══════ -->
                                <div class="col-lg-4 col-md-5 mb-4">
                                    <div class="card shadow-sm border-0 fade-in" style="border-radius: var(--border-radius); overflow: hidden;">

                                        <div class="card-header text-white fw-bold py-3">
                                            <i class="fa fa-address-book me-2" aria-hidden="true"></i>Contact Information
                                        </div>

                                        <div class="contact-card-body">

                                            <!-- Owner -->
                                            <div class="contact-row">
                                                <div class="contact-icon-wrap owner">
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <div class="contact-label-new">Owner</div>
                                                    <div class="contact-value-new"><?= htmlspecialchars($provider->name); ?></div>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="contact-row">
                                                <div class="contact-icon-wrap email">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <div class="contact-label-new">Email</div>
                                                    <div class="contact-value-new email-val"><?= htmlspecialchars($provider->email); ?></div>
                                                </div>
                                            </div>

                                            <!-- Mobile -->
                                            <div class="contact-row">
                                                <div class="contact-icon-wrap phone">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <div class="contact-label-new">Mobile</div>
                                                    <div class="contact-value-new"><?= htmlspecialchars($provider->mobile); ?></div>
                                                </div>
                                            </div>

                                            <!-- Address -->
                                            <div class="contact-row">
                                                <div class="contact-icon-wrap addr">
                                                    <i class="fa fa-map-marker-alt" aria-hidden="true"></i>
                                                </div>
                                                <div class="contact-text">
                                                    <div class="contact-label-new">Address</div>
                                                    <div class="contact-value-new"><?= htmlspecialchars($provider->address); ?></div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Map -->
                                        <div class="map-wrapper">
                                            <img
                                                src="https://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($provider->address); ?>&zoom=15&size=600x350&markers=color:purple%7C<?= $provider->latitude; ?>,<?= $provider->longitude; ?>&key=AIzaSyAR5-9XtV0r0VyR7uu0ppEKhNHanKlGwWk"
                                                alt="Map of <?= htmlspecialchars($provider->address); ?>"
                                                data-gym-lat="<?= $provider->latitude; ?>"
                                                data-gym-lng="<?= $provider->longitude; ?>">
                                        </div>

                                    </div>
                                </div>
                                <!-- ══════ END CONTACT INFO ══════ -->

                            </div>
                        </div>
                    </div>

                    <!-- ══════ SCHEDULE TAB ══════ -->
                    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                        <div class="container py-3">
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                                <h5 class="fw-bold mb-0">
                                    <i class="fa fa-clock me-2 text-primary" aria-hidden="true"></i>Business Hours
                                </h5>
                                <?php
                                $today = strtolower(date('l'));
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
                                                    <i class="fa fa-calendar-day me-2 text-primary" aria-hidden="true"></i><?= ucfirst($s->day); ?>
                                                </h6>
                                                <?php if ($s->status === 'open'): ?>
                                                    <p class="mb-0 text-muted">
                                                        <i class="fa fa-clock me-1" aria-hidden="true"></i>
                                                        <?= date("g:i A", strtotime($s->start_time)) ?> - <?= date("g:i A", strtotime($s->end_time)) ?>
                                                    </p>
                                                <?php else: ?>
                                                    <p class="mb-0 text-danger">
                                                        <i class="fa fa-times-circle me-1" aria-hidden="true"></i>Holiday
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-12 text-center text-muted py-5">
                                        <i class="fa fa-calendar-times fa-3x mb-3" aria-hidden="true"></i>
                                        <p>No schedule available</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- ══════ REVIEW TAB ══════ -->
                    <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                        <div class="container">
                            <div class="card shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4 header-section">
                                        <h5 class="fw-bold mb-0">
                                            <i class="fa fa-star me-2 text-warning" aria-hidden="true"></i>Customer Reviews
                                        </h5>
                                        <?php if (isset($this->user['id']) && isset($provider->id)) : ?>
                                            <?php if ($can_add_review): ?>
                                                <button class="btn btn-primary" id="openReviewModal"
                                                    data-user="<?= $this->user['id']; ?>"
                                                    data-bs-toggle="modal" data-bs-target="#addReviewModal">
                                                    <i class="fa fa-plus me-2" aria-hidden="true"></i>Add Review
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="reviews-scroll-container">
                                        <?php if (!empty($this->data['reviews'])) : ?>
                                            <?php foreach ($reviews as $review) : ?>
                                                <div class="review-card">
                                                    <div class="review-header">
                                                        <div class="reviewer-name">
                                                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                                                            <?= htmlspecialchars($review->user_name ?? 'Anonymous'); ?>
                                                        </div>
                                                        <div class="review-stars">
                                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                                <?php if ($i <= $review->rating) : ?>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                <?php else : ?>
                                                                    <i class="far fa-star" aria-hidden="true"></i>
                                                                <?php endif; ?>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <p class="review-text"><?= nl2br(htmlspecialchars($review->review_text)); ?></p>
                                                    <small class="review-date">
                                                        <i class="fa fa-clock me-1" aria-hidden="true"></i>
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

                    <!-- ══════ GALLERY TAB ══════ -->
                    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        <div class="container py-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">
                                        <i class="fa fa-images me-2 text-primary" aria-hidden="true"></i>Photo Gallery
                                    </h5>
                                    <div class="gallery-grid">
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500" alt="Gym Image 1"></div>
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=500" alt="Gym Image 2"></div>
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500" alt="Gym Image 3"></div>
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=500" alt="Gym Image 4"></div>
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1593476087123-36d1de271f08?w=500" alt="Gym Image 5"></div>
                                        <div class="gallery-item fade-in"><img src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=500" alt="Gym Image 6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ══════ CERTIFICATION TAB ══════ -->
                    <div class="tab-pane fade" id="certification" role="tabpanel" aria-labelledby="certification-tab">
                        <div class="container py-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-4">
                                        <i class="fa fa-certificate me-2 text-primary" aria-hidden="true"></i>Certifications &amp; Achievements
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="certification-card fade-in">
                                                <h6 class="certification-title">Certified Personal Trainer</h6>
                                                <p class="certification-issuer"><i class="fa fa-building me-2" aria-hidden="true"></i>American Council on Exercise (ACE)</p>
                                                <span class="certification-year">2019</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="certification-card fade-in">
                                                <h6 class="certification-title">Nutrition &amp; Wellness Consultant</h6>
                                                <p class="certification-issuer"><i class="fa fa-building me-2" aria-hidden="true"></i>International Sports Sciences Association</p>
                                                <span class="certification-year">2020</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="certification-card fade-in">
                                                <h6 class="certification-title">Advanced Strength Training</h6>
                                                <p class="certification-issuer"><i class="fa fa-building me-2" aria-hidden="true"></i>National Academy of Sports Medicine</p>
                                                <span class="certification-year">2021</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="certification-card fade-in">
                                                <h6 class="certification-title">Yoga Instructor Level 2</h6>
                                                <p class="certification-issuer"><i class="fa fa-building me-2" aria-hidden="true"></i>Yoga Alliance International</p>
                                                <span class="certification-year">2022</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /tab-content -->
            </div><!-- /col right -->
        </div><!-- /row -->
    </div><!-- /container -->

</div><!-- /fkpd-page -->


<!-- ══════════════════════════════════════════
     ADD REVIEW MODAL
══════════════════════════════════════════ -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background: var(--gradient-primary);">
                <h5 class="modal-title" id="addReviewModalLabel">
                    <i class="fa fa-star me-2" aria-hidden="true"></i>Write a Review
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="review_user" value="<?= isset($this->user['id']) ? $this->user['id'] : '' ?>">
                <input type="hidden" id="review_provider" value="<?= isset($provider->provider_id) ? $provider->provider_id : '' ?>">
                <form id="reviewForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                        <div class="star-rating-input">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" value="<?= $i ?>">
                                    <label class="form-check-label">
                                        <i class="fa fa-star" aria-hidden="true"></i> <?= $i ?>
                                    </label>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Your Review <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reviewText" rows="4" placeholder="Share your experience..." required></textarea>
                    </div>
                    <button type="submit" id="submitReviewBtn" class="btn btn-primary w-100">
                        <i class="fa fa-paper-plane me-2" aria-hidden="true"></i>Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        const providerId = "<?= $provider->provider_id; ?>";
        const baseUrl = "<?= base_url(); ?>";

        /* ── Services Loader ── */
        function loadServices(page = 1) {
            const container = $('#service-list');
            container.html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

            $.ajax({
                url: `${baseUrl}profile/get_services_ajax/${providerId}`,
                type: 'GET',
                data: {
                    page
                },
                dataType: 'json',
                success: function(res) {
                    let html = '';
                    if (!res.services || res.services.length === 0) {
                        html = `
                        <div class="text-center py-5 bg-white rounded shadow-sm">
                            <i class="fa fa-dumbbell fa-3x text-muted mb-3"></i>
                            <h5 class="fw-bold text-muted">No Services Found</h5>
                            <p class="text-muted mb-0">This provider hasn't listed any services yet.</p>
                        </div>
                    `;
                        $('#service-pagination').html('');
                    } else {
                        html = '<div class="row g-4">';
                        res.services.forEach(service => {
                            const imgUrl = service.image ?
                                `${baseUrl}${service.image}` :
                                `${baseUrl}assets/images/default.jpg`;
                            const desc = service.description || 'No description available.';
                            html += `
                            <div class="col-md-6 col-sm-12">
                                <div class="service-item-card">
                                    <div class="service-item-img-wrapper">
                                        <img src="${imgUrl}" alt="${service.name}"
                                             onerror="this.src='${baseUrl}assets/images/default.jpg'">
                                    </div>
                                    <div class="service-item-body">
                                        <h5 class="service-item-title">${service.name}</h5>
                                        <p class="service-item-desc">${desc}</p>
                                    </div>
                                    <div class="service-item-footer">
                                        <div class="service-item-price">
                                            ₹${parseFloat(service.month_price).toFixed(2)}<small>/month</small>
                                        </div>
                                        <a href="${baseUrl}services" class="service-item-btn">View All</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        });
                        html += '</div>';
                        renderServicePagination(res.totalPages, res.currentPage);
                    }
                    container.html(html);
                },
                error: function() {
                    container.html(`
                    <div class="text-center py-5 bg-white rounded shadow-sm text-danger">
                        <i class="fa fa-exclamation-triangle fa-3x mb-3"></i>
                        <h5 class="fw-bold">Unable to Load Services</h5>
                        <p class="mb-0">Please reload the page or try again later.</p>
                    </div>
                `);
                    $('#service-pagination').html('');
                }
            });
        }

        function renderServicePagination(totalPages, currentPage) {
            if (totalPages <= 1) {
                $('#service-pagination').html('');
                return;
            }
            let html = `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">&laquo;</a>
            </li>
        `;
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                     </li>`;
            }
            html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">&raquo;</a>
            </li>
        `;
            $('#service-pagination').html(html);
            $('#service-pagination .page-link').off('click').on('click', function(e) {
                e.preventDefault();
                const selectedPage = $(this).data('page');
                if (selectedPage && selectedPage !== currentPage) loadServices(selectedPage);
            });
        }

        /* ── Tab Hooks ── */
        $('#services-tab').on('shown.bs.tab', function() {
            loadServices(1);
        });
        if (window.location.hash === '#services') loadServices(1);

        /* ── Pricing Card Toggle ── */
        function updatePricingActiveCards() {
            $('.pricing-option-card').each(function() {
                const radio = $(this).find('input[type="radio"]');
                if (radio.is(':checked')) {
                    $(this).addClass('active');
                    $('#priceInput').val(radio.data('price'));
                    $('#durationInput').val(radio.data('label').toLowerCase());
                } else {
                    $(this).removeClass('active');
                }
            });
        }

        $('.pricing-option-card input[type="radio"]').on('change', updatePricingActiveCards);
        $('.pricing-option-card').on('click', function() {
            const radio = $(this).find('input[type="radio"]');
            if (!radio.is(':checked')) radio.prop('checked', true).trigger('change');
        });
        updatePricingActiveCards();

        /* ── Quantity Buttons ── */
        $('#increaseQty').on('click', function(e) {
            e.preventDefault();
            $('#quantityInput').val((parseInt($('#quantityInput').val()) || 1) + 1);
        });
        $('#decreaseQty').on('click', function(e) {
            e.preventDefault();
            const val = parseInt($('#quantityInput').val()) || 1;
            if (val > 1) $('#quantityInput').val(val - 1);
        });
    });

    /* ── Tab helpers for sidebar links ── */
    function openServicesTab() {
        document.getElementById('services-tab')?.click();
        window.scrollTo({
            top: document.getElementById('services').offsetTop - 100,
            behavior: 'smooth'
        });
    }

    function openAboutTab() {
        document.getElementById('about-tab')?.click();
        window.scrollTo({
            top: document.getElementById('about').offsetTop - 100,
            behavior: 'smooth'
        });
    }
</script>