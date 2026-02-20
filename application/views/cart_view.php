<style>
    /* Use your root color variables */
    :root {
        --primary-color: #6f42c1;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --bg-light: #f8f9fa;
        --gradient-primary: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
        --shadow-light: 0 2px 15px rgba(111, 66, 193, 0.1);
        --shadow-medium: 0 4px 25px rgba(111, 66, 193, 0.15);

        /* Additional enhanced colors */
        --success-gradient: linear-gradient(135deg, #10ac84, #0fb272);
        --danger-gradient: linear-gradient(135deg, #ff4757, #ff3742);
        --info-gradient: linear-gradient(135deg, #667eea, #764ba2);
        --border-radius-sm: 8px;
        --border-radius-md: 12px;
        --border-radius-lg: 16px;
        --border-radius-xl: 20px;
        --border-radius-pill: 25px;
        --transition-base: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-fast: all 0.2s ease;
    }

    /* Enhanced smooth scrolling and base styles */
    /* html {
        scroll-behavior: smooth;
        font-size: 16px;
    }

    body {
        overflow-x: hidden;
    } */

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬Å“Ã‚Â± Enhanced Mobile First Styling (320px - 767px) */
    @media (max-width: 767.98px) {
        /* html {
            font-size: 14px;
        } */

        .container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .cart-item {
            padding: 1rem !important;
            font-size: 0.9rem;
            margin-bottom: 1rem !important;
            border-radius: var(--border-radius-md) !important;
            box-shadow: var(--shadow-light);
            border: 1px solid rgba(111, 66, 193, 0.1);
            background: #fff;
            transition: var(--transition-base);
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .cart-summary {
            font-size: 0.95rem;
            padding: 1.25rem;
            background: #fff;
            border-radius: var(--border-radius-lg);
            border: none;
            margin-top: 1.5rem;
            position: relative !important;
            top: auto !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .provider-image {
            width: 48px !important;
            height: 48px !important;
            border: 2px solid var(--primary-color);
            border-radius: 50%;
            object-fit: cover;
            transition: var(--transition-fast);
        }

        .provider-image:hover {
            transform: scale(1.05);
            border-color: var(--accent-color);
        }

        .item-name {
            font-size: 0.95rem !important;
            line-height: 1.4;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .price-info {
            font-size: 0.85rem;
        }

        .quantity-controls {
            width: 90px !important;
            min-width: 90px;
            border-radius: var(--border-radius-pill);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(111, 66, 193, 0.15);
        }

        .quantity-controls .btn {
            padding: 0.35rem 0.5rem;
            font-size: 0.8rem;
            min-width: 28px;
            min-height: 44px;
            /* Better touch target */
            border: none;
            background: var(--primary-color);
            color: white;
            transition: var(--transition-fast);
        }

        .quantity-controls .btn:hover {
            background: var(--accent-color);
            transform: scale(1.05);
        }

        .quantity-controls .btn:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
        }

        .quantity-controls .form-control {
            font-size: 0.85rem;
            padding: 0.35rem 0.1rem;
            border: none;
            background: rgba(111, 66, 193, 0.1);
            font-weight: 600;
            color: var(--primary-color);
        }

        .cart-item-mobile {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .mobile-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .mobile-section {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            flex: 1;
        }

        .remove-btn {
            padding: 0.375rem 0.625rem !important;
            font-size: 0.8rem !important;
            min-width: 44px;
            /* Better touch target */
            min-height: 44px;
            border-radius: var(--border-radius-xl);
            background: var(--danger-gradient);
            border: none;
            color: white;
            transition: var(--transition-base);
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
        }

        .remove-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
        }

        .remove-btn:focus {
            outline: 2px solid #ff4757;
            outline-offset: 2px;
        }

        .price-badge {
            font-size: 0.825rem !important;
            padding: 0.375rem 0.75rem !important;
            white-space: nowrap;
            border-radius: var(--border-radius-xl);
            background: var(--info-gradient);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            color: white;
            transition: var(--transition-fast);
        }

        .price-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .subtotal-row {
            text-align: right;
            font-weight: 600;
            font-size: 0.95rem;
            color: #10ac84;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 2px solid var(--bg-light);
            border-radius: var(--border-radius-sm);
        }

        .subtotal-row span {
            display: block;
        }

        /* Enhanced mobile cart header */
        .d-flex.align-items-center.mb-4 {
            margin-bottom: 1.25rem !important;
            padding: 0.75rem 1rem;
            background: var(--gradient-primary);
            border-radius: var(--border-radius-md);
            color: white;
            box-shadow: var(--shadow-medium);
        }

        .d-flex.align-items-center.mb-4 h3 {
            font-size: 1.35rem;
            margin: 0;
            font-weight: 600;
        }

        .d-flex.align-items-center.mb-4 i {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Enhanced mobile summary */
        .cart-summary .summary-header,
        .summary-header {
            background: var(--gradient-primary);
            color: #fff;
            margin: -1.25rem -1.25rem 1.25rem -1.25rem !important;
            padding: 1rem 1.25rem !important;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
            text-align: center;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .cart-summary .summary-header h5,
        .summary-header h5 {
            font-size: 1.1rem;
            margin: 0;
            font-weight: 600;
        }

        .pay-now-btn {
            padding: 0.75rem !important;
            font-size: 1.05rem !important;
            font-weight: 600;
            min-height: 50px;
            /* Better touch target */
            border-radius: var(--border-radius-pill);
            background: var(--success-gradient);
            border: none;
            color: white;
            transition: var(--transition-base);
            box-shadow: 0 4px 15px rgba(16, 172, 132, 0.3);
        }

        .pay-now-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 172, 132, 0.4);
        }

        .pay-now-btn:focus {
            outline: 2px solid #10ac84;
            outline-offset: 2px;
        }

        /* Duration section mobile optimization */
        .duration-section {
            padding: 0.75rem;
            margin: 0.5rem 0;
            background: linear-gradient(135deg, var(--bg-light), #e9ecef);
            border-radius: var(--border-radius-sm);
            border-left: 4px solid var(--primary-color);
            transition: var(--transition-fast);
        }

        .duration-section:hover {
            transform: translateX(2px);
            box-shadow: var(--shadow-light);
        }

        .duration-header {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .duration-item {
            font-size: 0.825rem !important;
            padding: 0.25rem 0;
            transition: color 0.2s ease;
        }

        .duration-item:hover {
            color: var(--primary-color);
        }

        /* Enhanced alert styling for mobile */
        .alert {
            margin-bottom: 1.25rem;
            font-size: 0.9rem;
            border-radius: var(--border-radius-md);
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: var(--success-gradient);
            color: white;
        }

        .alert-danger {
            background: var(--danger-gradient);
            color: white;
        }

        /* Enhanced empty cart styling */
        .empty-cart {
            padding: 2.5rem 1rem !important;
            background: linear-gradient(135deg, var(--bg-light), #e9ecef);
            border-radius: var(--border-radius-xl);
            text-align: center;
            box-shadow: var(--shadow-light);
        }

        .empty-cart i {
            font-size: 3.5rem !important;
            color: #dee2e6;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        .empty-cart h4 {
            font-size: 1.3rem;
            color: #495057;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬Å“Ã‚Â± Extra Small Mobile Devices (320px - 575px) */
    @media (max-width: 575.98px) {
        /* html {
            font-size: 13px;
        } */

        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }

        .cart-item {
            padding: 0.875rem !important;
            margin-bottom: 0.875rem !important;
        }

        .cart-summary {
            padding: 1rem;
            margin-top: 1rem;
        }

        .provider-image {
            width: 42px !important;
            height: 42px !important;
        }

        .item-name {
            font-size: 0.875rem !important;
        }

        .quantity-controls {
            width: 85px !important;
        }

        .mobile-section {
            gap: 0.5rem;
        }

        .price-badge {
            font-size: 0.75rem !important;
            padding: 0.3rem 0.6rem !important;
        }

        .summary-header h5 {
            font-size: 1rem;
        }

        .d-flex.align-items-center.mb-4 h3 {
            font-size: 1.2rem;
        }

        .pay-now-btn {
            font-size: 1rem !important;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬â„¢Ã‚Â» Tablet Landscape and Small Desktop (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        /* html {
            font-size: 15px;
        } */

        .cart-summary {
            padding: 1.75rem;
        }

        .provider-image {
            width: 56px;
            height: 56px;
        }

        .quantity-controls {
            width: 100px;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬â€œÃ‚Â¥ÃƒÂ¯Ã‚Â¸Ã‚Â Enhanced Desktop Styling (992px+) */
    @media (min-width: 992px) {
        /* html {
            font-size: 16px;
        } */

        .cart-summary {
            background: #fff;
            border: none;
            border-radius: var(--border-radius-xl);
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            position: relative !important;
            top: auto !important;
            backdrop-filter: blur(10px);
        }

        .cart-summary .summary-header {
            background: var(--gradient-primary);
            color: #fff;
            margin: -2rem -2rem 2rem -2rem;
            padding: 1.5rem 2rem;
            border-radius: var(--border-radius-xl) var(--border-radius-xl) 0 0;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .cart-summary .summary-header h5 {
            font-size: 1.2rem;
            font-weight: 600;
        }

        #cartTotal {
            font-size: 1.6rem;
            font-weight: 700;
            color: #10ac84;
        }

        .cart-item {
            transition: var(--transition-base);
            border-radius: var(--border-radius-lg);
            border: 1px solid rgba(111, 66, 193, 0.1);
            box-shadow: var(--shadow-light);
        }

        .cart-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .d-flex.align-items-center.mb-4 {
            background: var(--gradient-primary);
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius-lg);
            color: white;
            margin-bottom: 2rem !important;
            box-shadow: var(--shadow-medium);
        }

        .d-flex.align-items-center.mb-4 h3 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }

        .d-flex.align-items-center.mb-4 i {
            color: rgba(255, 255, 255, 0.9);
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬â€œÃ‚Â¥ÃƒÂ¯Ã‚Â¸Ã‚Â Large Desktop Enhancements (1200px+) */
    @media (min-width: 1200px) {
        .cart-summary {
            padding: 2.5rem;
        }

        .cart-summary .summary-header {
            margin: -2.5rem -2.5rem 2.5rem -2.5rem;
            padding: 2rem 2.5rem;
        }

        .cart-item {
            padding: 1.5rem !important;
        }

        #cartTotal {
            font-size: 1.8rem;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬â€œÃ‚Â¥ÃƒÂ¯Ã‚Â¸Ã‚Â Extra Large Desktop (1400px+) */
    @media (min-width: 1400px) {
        .container {
            max-width: 1320px;
        }

        .cart-summary {
            padding: 3rem;
        }

        .cart-summary .summary-header {
            margin: -3rem -3rem 3rem -3rem;
            padding: 2.5rem 3rem;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã…Â½Ã‚Â¨ Enhanced Shared Styles */
    .cart-item {
        border: 1px solid rgba(111, 66, 193, 0.1);
        border-radius: var(--border-radius-lg);
        transition: var(--transition-base);
        background: #fff;
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-light);
    }

    .cart-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .provider-image {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border: 3px solid rgba(111, 66, 193, 0.2);
        border-radius: 50%;
        transition: var(--transition-base);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .provider-image:hover {
        transform: scale(1.05);
        border-color: var(--primary-color);
    }

    .item-name {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .price-badge {
        background: var(--info-gradient);
        color: white;
        padding: 0.375rem 1rem;
        border-radius: var(--border-radius-pill);
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        transition: var(--transition-fast);
    }

    .price-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .quantity-controls {
        width: 110px;
        border-radius: var(--border-radius-pill);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(111, 66, 193, 0.15);
    }

    .quantity-controls .btn {
        border: none;
        background: var(--primary-color);
        color: white;
        transition: var(--transition-fast);
    }

    .quantity-controls .btn:hover {
        background: var(--accent-color);
        transform: scale(1.05);
    }

    .quantity-controls .btn:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
    }

    .quantity-controls .form-control {
        border: none;
        background: rgba(111, 66, 193, 0.1);
        font-weight: 600;
        color: var(--primary-color);
    }

    .quantity-controls .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(111, 66, 193, 0.2);
        background: rgba(111, 66, 193, 0.15);
    }

    .remove-btn {
        background: var(--danger-gradient);
        border: none;
        border-radius: var(--border-radius-pill);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition-base);
        box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
    }

    .remove-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4);
        background: linear-gradient(135deg, #ff3742, #ff2636);
    }

    .remove-btn:focus {
        outline: 2px solid #ff4757;
        outline-offset: 2px;
    }

    .duration-section {
        background: linear-gradient(135deg, var(--bg-light), #e9ecef);
        padding: 1rem;
        border-radius: var(--border-radius-md);
        margin: 0.75rem 0;
        border-left: 4px solid var(--primary-color);
        transition: var(--transition-fast);
    }

    .duration-section:hover {
        transform: translateX(2px);
        box-shadow: var(--shadow-light);
    }

    .duration-header {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .duration-item {
        padding: 0.25rem 0;
        transition: color 0.2s ease;
    }

    .duration-item:hover {
        color: var(--primary-color);
    }

    .pay-now-btn {
        background: var(--success-gradient);
        border: none;
        padding: 0.875rem;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: var(--border-radius-pill);
        transition: var(--transition-base);
        box-shadow: 0 4px 15px rgba(16, 172, 132, 0.3);
        color: white;
    }

    .pay-now-btn:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(16, 172, 132, 0.4);
        background: linear-gradient(135deg, #0fb272, #0e9f63);
    }

    .pay-now-btn:focus {
        outline: 2px solid #10ac84;
        outline-offset: 2px;
    }

    .pay-now-btn:disabled {
        background: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
        transform: none;
        box-shadow: none;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
        background: linear-gradient(135deg, var(--bg-light), #e9ecef);
        border-radius: var(--border-radius-xl);
        box-shadow: var(--shadow-light);
    }

    .empty-cart i {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
        color: #dee2e6;
        animation: pulse 2s infinite;
    }

    .empty-cart h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    /* ÃƒÂ°Ã…Â¸Ã…Â½Ã‚Â­ Enhanced Animations */
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }

        50% {
            transform: scale(1.05);
            opacity: 1;
        }

        100% {
            transform: scale(1);
            opacity: 0.8;
        }
    }

    .alert {
        border-radius: var(--border-radius-md);
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
    }

    .alert-success {
        background: var(--success-gradient);
        color: white;
    }

    .alert-danger {
        background: var(--danger-gradient);
        color: white;
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬ÂÃ¢â‚¬Å¾ Loading states and interactions */
    .btn:active {
        transform: scale(0.98);
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬Å“Ã‚Â± Enhanced touch targets for better accessibility */
    @media (max-width: 767.98px) {

        .btn,
        .form-control,
        .clickable {
            min-height: 44px;
            min-width: 44px;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬â„¢Ã‚Â« Enhanced focus states for accessibility */
    .btn:focus,
    .form-control:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
    }

    /* ÃƒÂ°Ã…Â¸Ã…â€™Ã…Â¸ High contrast mode support */
    @media (prefers-contrast: high) {
        .cart-item {
            border: 2px solid var(--primary-color);
        }

        .price-badge,
        .remove-btn,
        .pay-now-btn {
            border: 2px solid currentColor;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã…Â½Ã‚Â¯ Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬Å“Ã‚Â Better spacing utilities */
    .gap-xs {
        gap: 0.25rem;
    }

    .gap-sm {
        gap: 0.5rem;
    }

    .gap-md {
        gap: 1rem;
    }

    .gap-lg {
        gap: 1.5rem;
    }

    /* ÃƒÂ°Ã…Â¸Ã…Â½Ã‚Â¨ Enhanced visual hierarchy */
    .text-gradient {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ÃƒÂ°Ã…Â¸Ã¢â‚¬Å“Ã‚Â± Improved landscape mobile support */
    @media (max-height: 500px) and (orientation: landscape) {
        .cart-summary {
            margin-top: 1rem;
        }

        .empty-cart {
            padding: 2rem 1rem !important;
        }

        .empty-cart i {
            font-size: 2.5rem !important;
        }
    }
</style>



<div class="container py-5">

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-cart3 me-2 fs-3 text-primary"></i>
        <h3 class="mb-0">Your Cart Items</h3>
    </div>

    <div class="row">
        <!-- Cart Items List -->
        <div class="col-12 col-lg-8">
            <?php if (!empty($cart_items)) { ?>
                <!-- <?php
                        $subtotal = 0;
                        $duration_items = [];
                        foreach ($cart_items as $index => $item) {
                            $item_total = $item['price'] * $item['qty'];
                            $subtotal += $item_total;

                            $d = $item['duration'];
                            if (!isset($duration_items[$d]))
                                $duration_items[$d] = [];

                            $duration_items[$d][] = [
                                'id' => $item['id'],
                                'name' => $item['name'],
                                'qty' => $item['qty'],
                                'price' => $item['price'],
                                'item_total' => $item_total
                            ];
                        }
                        $total = $subtotal;
                        ?> -->

                <?php foreach ($cart_items as $index => $item) { ?>
                    <div class="card mb-3 cart-item p-3 cart-item-row" data-id="<?= $item['id']; ?>">
                        <!-- Desktop View -->
                        <div class="row g-0 align-items-center d-none d-md-flex">
                            <!-- Provider -->
                            <div class="col-md-2 text-center">
                                <small class="text-muted d-block mb-2">Provider</small>
                                <img
                                    src="<?= !empty($item['provider_image'])
                                                ? base_url($item['provider_image'])
                                                : base_url('assets/no-image.png'); ?>"
                                    alt="Provider"
                                    class="provider-image rounded-circle">
                            </div>

                            <!-- Name & Start Date -->
                            <div class="col-md-4">
                                <div class="item-name"><?= $item['provider_name']; ?></div>
                                <div class="text-muted">
                                    <small><i class="bi bi-calendar-event me-1"></i>Start Date:</small>
                                    <span class="fw-semibold"><?= $item['start_date']; ?></span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-md-2 text-center">
                                <small class="text-muted d-block mb-2">Price / Duration</small>
                                <div class="price-badge">
                                    <span class="itemPrice">&#8377;<?= number_format((float)($item['price'] ?? 0), 2); ?></span>
                                    <small>/<?= $item['duration']; ?></small>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-2 text-center">
                                <small class="text-muted d-block mb-2">Quantity</small>
                                <div class="input-group quantity-controls mx-auto" style="width:44%;">
                                    <button type="button" class="btn btn-outline-primary btn-sm decreaseQty" data-id="<?= $item['id']; ?>">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="text" class="form-control text-center qtyInput" value="<?= $item['qty']; ?>"
                                        readonly style="margin-top:10px;margin-bottom:10px">
                                    <button type="button" class="btn btn-outline-primary btn-sm increaseQty" data-id="<?= $item['id']; ?>">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Subtotal & Remove -->
                            <div class="col-md-2 text-center">
                                <div class="fw-bold fs-5 text-success mb-2">
                                    <span class="itemSubtotal">&#8377;<?= number_format((float)($item['item_total'] ?? 0), 2); ?></span>
                                </div>
                                <button type="button" class="btn remove-btn btn-sm remove-cart-item" data-id="<?= $item['id']; ?>">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="d-block d-md-none">
                            <div class="cart-item-mobile">
                                <!-- Header Row -->
                                <div class="mobile-row">
                                    <div class="mobile-section">
                                        <img
                                            src="<?= !empty($item['provider_image'])
                                                        ? base_url($item['provider_image'])
                                                        : base_url('assets/no-image.png'); ?>"
                                            alt="Provider"
                                            class="provider-image rounded-circle">
                                        <div class="item-name"><?= $item['provider_name']; ?></div>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i><?= $item['start_date']; ?>
                                        </small>
                                    </div>
                                    <button type="button" class="btn remove-btn btn-sm remove-cart-item" data-id="<?= $item['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Price and Quantity Row -->
                                <div class="mobile-row">
                                    <div class="price-badge">
                                        <span class="itemPrice">&#8377;<?= number_format((float)($item['price'] ?? 0), 2); ?></span>
                                        <small>/<?= $item['duration']; ?></small>
                                    </div>
                                    <div class="input-group quantity-controls" style="width: 54%!important;margin-top: 20px;">
                                        <button type="button" class="btn btn-outline-primary btn-sm decreaseQty" data-id="<?= $item['id']; ?>">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="text" class="form-control text-center qtyInput me-2 ms-2" value="<?= $item['qty']; ?>"
                                            readonly>
                                        <button type="button" class="btn btn-outline-primary btn-sm increaseQty" data-id="<?= $item['id']; ?>">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Total Row -->
                                <div class="subtotal-row">
                                    <span>Subtotal: <span class="itemSubtotal">&#8377;<?= number_format((float)($item['item_total'] ?? 0), 2); ?></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <div class="empty-cart">
                    <i class="bi bi-cart-x text-danger"></i>
                    <h4 class="fw-bold">Your cart is empty</h4>
                    <p class="mb-0">Add some items to get started!</p>
                </div>
            <?php } ?>
        </div>

        <!-- Cart Summary -->
        <div class="col-12 col-lg-4 mt-4 mt-lg-0">
            <div class="cart-summary mb-5">
                <div class="summary-header">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Order Summary</h5>
                </div>

                <!-- Subtotal -->
                <div class="d-flex justify-content-between mb-3">
                    <span><i class="bi bi-calculator me-2"></i>Subtotal</span>
                    <span class="fw-bold" id="cartSubtotal">&#8377;<?= number_format((float)($subtotal ?? 0), 2); ?></span>
                </div>

                <!-- Duration Breakdown -->
                <?php if (!empty($duration_items)) { ?>
                    <div class="mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-clock me-2"></i>Duration Breakdown</h6>
                        <?php foreach ($duration_items as $dur => $items): ?>
                            <div class="duration-section">
                                <div class="duration-header"><?= ucfirst($dur) ?></div>
                                <?php foreach ($items as $item): ?>
                                    <div class="d-flex justify-content-between small duration-item" data-id="<?= $item['id']; ?>">
                                        <span>
                                            <?= $item['provider_name'] ?? '' ?> x<span class="durationQty"><?= $item['qty'] ?></span>
                                            <?php if (!empty($item['platform_discount']) && $item['platform_discount'] > 0): ?>
                                                <span class="badge bg-success ms-2">
                                                    Save &#8377;<?= number_format($item['platform_discount'], 2); ?>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                        <span class="durationSubtotal">&#8377;<?= number_format((float)($item['item_total'] ?? 0), 2); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>

                <!-- Platform Offer Discount -->
                <?php if (!empty($discount_amount) && $discount_amount > 0): ?>
                    <div class="alert alert-success py-1 px-2 mb-3 text-center">
                        <i class="bi bi-gift me-1"></i> Congratulations! You save &#8377;<?= number_format($discount_amount, 2); ?> (<?= $offer_percent ?>% platform offer)
                    </div>
                <?php endif; ?>

                <hr>

                <!-- Total -->
                <div class="d-flex justify-content-between mb-4">
                    <strong class="fs-5"><i class="bi bi-currency-rupee me-2"></i>Total</strong>
                    <strong class="fs-4 text-success" id="cartTotal">&#8377;<?= number_format((float)($total_after_discount ?? $total ?? 0), 2); ?></strong>
                </div>

                <!-- Pay Now Button -->
                <button class="btn pay-now-btn w-100" <?= ($subtotal ?? 0) == 0 ? 'disabled' : 'type="button"'; ?>
                    onclick="window.location.href='<?= site_url('cart/pay'); ?>'">
                    <i class="bi bi-credit-card me-2"></i>Pay Now
                </button>

                <?php if (($subtotal ?? 0) == 0): ?>
                    <small class="text-muted d-block text-center mt-2">
                        <i class="bi bi-info-circle me-1"></i>Add items to proceed with payment
                    </small>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.increaseQty, .decreaseQty', function(e) {
        e.preventDefault();

        var $btn = $(this);
        if ($btn.prop('disabled')) {
            return;
        }

        var id = $btn.data('id');
        var action = $btn.hasClass('increaseQty') ? 'increase' : 'decrease';
        var row = $('.cart-item-row[data-id="' + id + '"]');
        var rowButtons = row.find('.increaseQty, .decreaseQty');

        rowButtons.prop('disabled', true);

        $.ajax({
            url: "<?= site_url('cart/update_quantity'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                action: action
            }
        }).done(function(response) {
            if (!response || response.status !== 'success') {
                return;
            }

            var qtyInput = row.find('.qtyInput');
            var currentQty = parseInt(qtyInput.first().val(), 10) || 1;
            var nextQty = response.qty ? parseInt(response.qty, 10) : (action === 'increase' ? currentQty + 1 : Math.max(1, currentQty - 1));

            qtyInput.val(nextQty);

            var rowSubtotal;
            if (typeof response.item_subtotal !== 'undefined') {
                rowSubtotal = parseFloat(response.item_subtotal) || 0;
            } else {
                var price = parseFloat(row.find('.itemPrice').first().text().replace(/[^0-9.]/g, '')) || 0;
                rowSubtotal = price * nextQty;
            }

            row.find('.itemSubtotal').text('\u20B9' + rowSubtotal.toFixed(2));

            var durationRow = $('.duration-item[data-id="' + id + '"]');
            durationRow.find('.durationQty').text(nextQty);
            durationRow.find('.durationSubtotal').text('\u20B9' + rowSubtotal.toFixed(2));

            recalculateCart();
            updateCartCount();
        }).always(function() {
            rowButtons.prop('disabled', false);
        });
    });
</script>

<script>
    $(document).on('click', '.remove-cart-item', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var row = $('.cart-item-row[data-id="' + id + '"]');

        $.post("<?= site_url('cart/remove'); ?>", {
            id: id
        }, function(response) {
            if (response.status === 'success') {
                row.fadeOut(300, function() {
                    $(this).remove();
                    $('.duration-item[data-id="' + id + '"]').remove();
                    recalculateCart();
                    updateCartCount();
                });
            }
        }, 'json');
    });
</script>

<script>
    function recalculateCart() {
        var subtotal = 0;

        $('.cart-item-row').each(function() {
            var value = $(this).find('.itemSubtotal').first().text().replace(/[^0-9.]/g, '');
            subtotal += parseFloat(value) || 0;
        });

        $("#cartSubtotal").text("\u20B9" + subtotal.toFixed(2));
        $("#cartTotal").text("\u20B9" + subtotal.toFixed(2));
        $('.pay-now-btn').prop('disabled', subtotal <= 0);
    }
</script>

<script>
    function updateCartCount() {
        $.getJSON("<?= site_url('cart/get_cart_count'); ?>", function(data) {
            $('.cart-count').text(data.count || 0);
        });
    }
</script>
