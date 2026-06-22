<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

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
        --success-color: #10ac84;
        --danger-color: #ff4757;
        --border-color: #ececec;
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-xl: 32px;
        --radius-pill: 50px;
    }

    .fitket-cart {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
        background: var(--bg-light);
        padding: 50px 0 80px;
    }

    .fitket-cart *,
    .fitket-cart *::before,
    .fitket-cart *::after {
        box-sizing: border-box;
    }

    .fitket-cart button,
    .fitket-cart input {
        font-family: 'Poppins', sans-serif;
    }

    .fitket-cart *:focus-visible {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    .fitket-cart .container {
        max-width: 1200px;
    }

    /* ══════════════════════════════════════════
     PAGE HEADER
  ══════════════════════════════════════════ */
    .fkc-page-header {
        position: relative;
        background: var(--secondary-color);
        border-radius: var(--radius-xl);
        padding: 38px 40px;
        margin-bottom: 36px;
        color: var(--white);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .fkc-page-header::after {
        content: '';
        position: absolute;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.32) 0%, transparent 70%);
        top: -160px;
        right: -100px;
        pointer-events: none;
    }

    .fkc-page-header .fkh-label-row {
        position: relative;
        z-index: 2;
    }

    .fkc-page-header .fkh-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #b19fe8;
        background: rgba(111, 66, 193, 0.2);
        border: 1px solid rgba(111, 66, 193, 0.4);
        padding: 5px 16px;
        border-radius: var(--radius-pill);
        margin-bottom: 14px;
    }

    .fkc-page-header h1 {
        font-size: clamp(1.5rem, 3vw, 2.1rem);
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .fkc-page-header h1 em {
        font-style: normal;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .fkc-item-count-pill {
        position: relative;
        z-index: 2;
        background: rgba(111, 66, 193, 0.18);
        border: 1px solid rgba(111, 66, 193, 0.4);
        color: var(--white);
        padding: 10px 22px;
        border-radius: var(--radius-pill);
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .fkc-item-count-pill strong {
        color: #ffc107;
    }

    /* ══════════════════════════════════════════
     ALERTS
  ══════════════════════════════════════════ */
    .fitket-cart .alert {
        border-radius: var(--radius-md);
        border: none;
        font-weight: 500;
        padding: 14px 20px;
    }

    .fitket-cart .alert-success {
        background: linear-gradient(135deg, var(--success-color), #0fb272);
        color: var(--white);
    }

    .fitket-cart .alert-danger {
        background: linear-gradient(135deg, var(--danger-color), #ff3742);
        color: var(--white);
    }

    .fitket-cart .alert .btn-close {
        filter: invert(1);
    }

    /* ══════════════════════════════════════════
     CART ITEM CARD
  ══════════════════════════════════════════ */
    .cart-card {
        background: var(--white);
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 22px;
        margin-bottom: 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .cart-card::before {
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

    .cart-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(111, 66, 193, 0.13);
        border-color: rgba(111, 66, 193, 0.25);
    }

    .cart-card:hover::before {
        transform: scaleX(1);
    }

    .prov-img {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid rgba(111, 66, 193, 0.15);
        flex-shrink: 0;
        padding: 2px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    }

    .price-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: rgba(111, 66, 193, 0.1);
        color: var(--primary-dark);
        padding: 6px 16px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
    }

    .price-badge small {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.75rem;
    }

    /* ── Qty Controls ── */
    .qty-wrap {
        display: inline-flex;
        align-items: center;
        border-radius: var(--radius-pill);
        overflow: hidden;
        background: var(--bg-light);
        border: 1.5px solid var(--border-color);
        width: 112px;
    }

    .qty-btn {
        width: 34px;
        height: 36px;
        border: none;
        background: transparent;
        color: var(--primary-color);
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--primary-color);
        color: var(--white);
    }

    .qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-display {
        flex: 1;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--secondary-color);
        background: transparent;
        border: none;
        height: 36px;
        line-height: 36px;
        pointer-events: none;
        user-select: none;
    }

    /* ── Remove btn ── */
    .remove-btn {
        background: var(--white);
        border: 1.5px solid rgba(255, 71, 87, 0.3);
        border-radius: var(--radius-pill);
        color: var(--danger-color);
        padding: 8px 18px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .remove-btn:hover {
        background: var(--danger-color);
        border-color: var(--danger-color);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(255, 71, 87, 0.28);
    }

    /* ── Item subtotal ── */
    .item-subtotal-val {
        font-weight: 800;
        font-size: 1.1rem;
        color: var(--success-color);
        white-space: nowrap;
    }

    .col-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #b3a8c9;
        display: block;
        margin-bottom: 8px;
    }

    /* ── Desktop layout ── */
    .cart-desktop {
        display: grid;
        grid-template-columns: 70px 1fr 150px 120px 130px 120px;
        align-items: center;
        gap: 1rem;
    }

    .cart-desktop .text-center {
        text-align: center;
    }

    .item-name-d {
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 5px;
        font-size: 0.98rem;
    }

    .start-date-d {
        font-size: 0.8rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ── Mobile layout ── */
    .cart-mobile {
        display: none;
    }

    @media (max-width: 767px) {
        .cart-desktop {
            display: none;
        }

        .cart-mobile {
            display: block;
        }

        .cart-card {
            padding: 16px;
            border-radius: var(--radius-md);
        }

        .cart-mobile .mob-row1 {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1.5px dashed var(--border-color);
        }

        .cart-mobile .mob-info {
            flex: 1;
            min-width: 0;
        }

        .cart-mobile .mob-info .item-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--secondary-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-mobile .mob-info .start-date {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-top: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cart-mobile .mob-row2 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .cart-mobile .mob-subtotal {
            width: 100%;
            text-align: right;
            font-size: 0.92rem;
            color: var(--success-color);
            font-weight: 800;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1.5px dashed var(--border-color);
        }

        .prov-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
        }

        .qty-wrap {
            width: 100px;
        }

        .qty-btn {
            width: 30px;
            height: 34px;
        }

        .qty-display {
            height: 34px;
            line-height: 34px;
        }

        .remove-btn {
            padding: 8px 10px;
            font-size: 0;
            gap: 0;
        }

        .remove-btn i {
            font-size: 0.95rem;
        }
    }

    /* ── Empty Cart ── */
    .empty-cart {
        text-align: center;
        padding: 70px 30px;
        background: var(--white);
        border: 1.5px dashed rgba(111, 66, 193, 0.25);
        border-radius: var(--radius-xl);
    }

    .empty-cart .empty-icon-wrap {
        width: 90px;
        height: 90px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: rgba(111, 66, 193, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-cart i {
        font-size: 2.6rem;
        color: var(--primary-color);
    }

    .empty-cart h4 {
        font-size: 1.3rem;
        color: var(--secondary-color);
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-cart p {
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .empty-cart .browse-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: var(--white);
        border: none;
        padding: 12px 32px;
        border-radius: var(--radius-pill);
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.25s;
    }

    .empty-cart .browse-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(111, 66, 193, 0.3);
        color: var(--white);
    }

    /* ══════════════════════════════════════════
     SUMMARY CARD
  ══════════════════════════════════════════ */
    .summary-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1.5px solid var(--border-color);
        position: sticky;
        top: 1rem;
    }

    .summary-header {
        background: var(--secondary-color);
        position: relative;
        overflow: hidden;
        color: var(--white);
        padding: 22px 26px;
    }

    .summary-header::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.35) 0%, transparent 70%);
        top: -90px;
        right: -60px;
        pointer-events: none;
    }

    .summary-header h5 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-body {
        padding: 24px 26px 26px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 0.92rem;
        color: var(--text-muted);
    }

    .summary-row .fw-bold {
        color: var(--secondary-color);
        font-weight: 700;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1rem;
        font-weight: 700;
        margin-top: 8px;
        color: var(--secondary-color);
    }

    #cartTotal {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--success-color);
    }

    .duration-breakdown-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--primary-color);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .duration-block {
        background: var(--bg-light);
        border-left: 3px solid var(--primary-color);
        border-radius: var(--radius-sm);
        padding: 12px 14px;
        margin-bottom: 10px;
    }

    .duration-block .dur-title {
        font-weight: 700;
        color: var(--primary-dark);
        font-size: 0.8rem;
        text-transform: capitalize;
        margin-bottom: 6px;
    }

    .dur-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--text-muted);
        padding: 3px 0;
    }

    .discount-alert {
        background: linear-gradient(135deg, var(--success-color), #0fb272);
        color: var(--white);
        border-radius: var(--radius-md);
        padding: 12px 16px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    hr.fkc-divider {
        border: none;
        border-top: 1.5px dashed var(--border-color);
        margin: 14px 0;
    }

    .pay-btn {
        width: 100%;
        background: var(--warning);
        border: none;
        border-radius: var(--radius-pill);
        color: #1a1a1a;
        padding: 15px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s;
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        letter-spacing: 0.01em;
    }

    .pay-btn:hover:not(:disabled) {
        background: var(--warning-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(255, 193, 7, 0.35);
    }

    .pay-btn:disabled {
        background: #e2e2e2;
        color: #999;
        cursor: not-allowed;
        box-shadow: none;
    }

    .secure-note {
        text-align: center;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    @media (max-width: 991px) {
        .summary-card {
            position: static;
            margin-top: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .fkc-page-header {
            padding: 26px 22px;
            border-radius: var(--radius-lg);
        }

        .fitket-cart {
            padding: 26px 0 60px;
        }
    }
</style>

<div class="fitket-cart">
    <div class="container">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= $this->session->flashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ═══ PAGE HEADER ═══ -->
        <div class="fkc-page-header">
            <div class="fkh-label-row">
                <span class="fkh-eyebrow"><i class="bi bi-cart3"></i> Your Selections</span>
                <h1>Review Your <em>Cart</em></h1>
            </div>
            <div class="fkc-item-count-pill">
                <strong><?= !empty($cart_items) ? count($cart_items) : 0; ?></strong> item<?= (!empty($cart_items) && count($cart_items) == 1) ? '' : 's'; ?> in cart
            </div>
        </div>

        <div class="row">
            <!-- ── Cart Items ── -->
            <div class="col-12 col-lg-8" id="cartItemsCol">

                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <?php
                        $item_price = (float)($item['price'] ?? 0);
                        $item_qty   = (int)($item['qty'] ?? 1);
                        $item_total = $item_price * $item_qty;
                        ?>
                        <!-- data-price stores the unit price for JS — single source of truth -->
                        <div class="cart-card cart-item-row"
                            data-id="<?= (int)$item['id']; ?>"
                            data-price="<?= $item_price; ?>">

                            <!-- ═══ DESKTOP ═══ -->
                            <div class="cart-desktop d-none d-md-grid">
                                <!-- Image -->
                                <div>
                                    <img src="<?= !empty($item['provider_image']) ? base_url($item['provider_image']) : base_url('assets/images/3d-cartoon-fitness-man.jpg'); ?>"
                                        class="prov-img" alt="Provider">
                                </div>
                                <!-- Name + date -->
                                <div>
                                    <div class="item-name-d"><?= htmlspecialchars($item['provider_name']); ?></div>
                                    <div class="start-date-d">
                                        <i class="bi bi-calendar-event"></i><?= $item['start_date']; ?>
                                    </div>
                                </div>
                                <!-- Price badge -->
                                <div class="text-center">
                                    <span class="col-label">Price / Duration</span>
                                    <div class="price-badge">
                                        &#8377;<?= number_format($item_price, 2); ?><small>/<?= $item['duration']; ?></small>
                                    </div>
                                </div>
                                <!-- Qty -->
                                <div class="text-center">
                                    <span class="col-label">Quantity</span>
                                    <div class="qty-wrap">
                                        <button class="qty-btn decreaseQty" data-id="<?= (int)$item['id']; ?>">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <div class="qty-display"><?= $item_qty; ?></div>
                                        <button class="qty-btn increaseQty" data-id="<?= (int)$item['id']; ?>">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Subtotal -->
                                <div class="text-center">
                                    <span class="col-label">Subtotal</span>
                                    <div class="item-subtotal-val">
                                        &#8377;<span class="itemSubtotalNum"><?= number_format($item_total, 2); ?></span>
                                    </div>
                                </div>
                                <!-- Remove -->
                                <div class="text-center">
                                    <button class="remove-btn remove-cart-item" data-id="<?= (int)$item['id']; ?>">
                                        <i class="bi bi-trash"></i>Remove
                                    </button>
                                </div>
                            </div>

                            <!-- ═══ MOBILE ═══ -->
                            <div class="cart-mobile d-md-none">
                                <div class="mob-row1">
                                    <img src="<?= !empty($item['provider_image']) ? base_url($item['provider_image']) : base_url('assets/images/3d-cartoon-fitness-man.jpg'); ?>"
                                        class="prov-img" alt="Provider">
                                    <div class="mob-info">
                                        <div class="item-name"><?= htmlspecialchars($item['provider_name']); ?></div>
                                        <div class="start-date"><i class="bi bi-calendar-event"></i><?= $item['start_date']; ?></div>
                                    </div>
                                    <button class="remove-btn remove-cart-item" data-id="<?= (int)$item['id']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="mob-row2">
                                    <div class="price-badge">
                                        &#8377;<?= number_format($item_price, 2); ?><small>/<?= $item['duration']; ?></small>
                                    </div>
                                    <div class="qty-wrap">
                                        <button class="qty-btn decreaseQty" data-id="<?= (int)$item['id']; ?>">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <div class="qty-display"><?= $item_qty; ?></div>
                                        <button class="qty-btn increaseQty" data-id="<?= (int)$item['id']; ?>">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mob-subtotal">
                                    Total: &#8377;<span class="itemSubtotalNum"><?= number_format($item_total, 2); ?></span>
                                </div>
                            </div>

                        </div><!-- /.cart-card -->
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="empty-cart">
                        <div class="empty-icon-wrap">
                            <i class="bi bi-cart-x"></i>
                        </div>
                        <h4>Your cart is empty</h4>
                        <p>Looks like you haven't added any services yet. Let's find something for you!</p>
                        <a href="<?= base_url('services'); ?>" class="browse-btn">
                            <i class="bi bi-search me-2"></i>Browse Services
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ── Order Summary ── -->
            <div class="col-12 col-lg-4">
                <div class="summary-card">
                    <div class="summary-header">
                        <h5><i class="bi bi-receipt"></i>Order Summary</h5>
                    </div>
                    <div class="summary-body">

                        <div class="summary-row">
                            <span><i class="bi bi-calculator me-2"></i>Subtotal</span>
                            <span class="fw-bold" id="cartSubtotal">
                                &#8377;<?= number_format((float)($subtotal ?? 0), 2); ?>
                            </span>
                        </div>

                        <!-- Duration Breakdown -->
                        <?php if (!empty($duration_items)): ?>
                            <hr class="fkc-divider">
                            <div class="duration-breakdown-title">
                                <i class="bi bi-clock-history"></i>Duration Breakdown
                            </div>
                            <?php foreach ($duration_items as $dur => $ditems): ?>
                                <div class="duration-block">
                                    <div class="dur-title"><?= ucfirst($dur); ?></div>
                                    <?php foreach ($ditems as $di): ?>
                                        <div class="dur-row duration-item" data-id="<?= (int)$di['id']; ?>">
                                            <span>
                                                <?= htmlspecialchars($di['provider_name'] ?? ''); ?>
                                                &times;<span class="durationQty"><?= (int)$di['qty']; ?></span>
                                            </span>
                                            <span class="durationSubtotal">
                                                &#8377;<?= number_format((float)($di['item_total'] ?? 0), 2); ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Discount -->
                        <div id="platformDiscountRow"
                            class="discount-alert <?= (!empty($discount_amount) && $discount_amount > 0) ? '' : 'd-none'; ?>">
                            <i class="bi bi-gift"></i>
                            You save <span id="platformDiscountAmount">&#8377;<?= number_format((float)($discount_amount ?? 0), 2); ?></span>
                            (<?= (float)($offer_percent ?? 0); ?>% platform offer)
                        </div>

                        <hr class="fkc-divider">

                        <div class="summary-total">
                            <strong><i class="bi bi-currency-rupee me-1"></i>Total</strong>
                            <strong id="cartTotal">
                                &#8377;<?= number_format((float)($total_after_discount ?? $subtotal ?? 0), 2); ?>
                            </strong>
                        </div>

                        <button class="pay-btn"
                            id="payNowBtn"
                            <?= (($subtotal ?? 0) == 0) ? 'disabled' : ''; ?>
                            onclick="window.location.href='<?= site_url('cart/pay'); ?>'">
                            <i class="bi bi-credit-card"></i>Pay Now
                        </button>

                        <?php if (($subtotal ?? 0) == 0): ?>
                            <small class="text-muted d-block text-center mt-2">
                                <i class="bi bi-info-circle me-1"></i>Add items to proceed
                            </small>
                        <?php else: ?>
                            <div class="secure-note">
                                <i class="bi bi-shield-lock"></i>100% Secure Checkout
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';

        /* ── Wait for jQuery ── */
        function initCart() {
            if (typeof $ === 'undefined') {
                setTimeout(initCart, 50);
                return;
            }

            const OFFER_PCT = parseFloat('<?= (float)($offer_percent ?? 0); ?>') || 0;
            const MIN_FOR_OFFER = parseFloat('<?= (float)($min_amount_for_offer ?? 0); ?>') || 0;
            const PAY_URL = '<?= site_url('cart/pay'); ?>';
            const UPDATE_URL = '<?= site_url('cart/update_quantity'); ?>';
            const REMOVE_URL = '<?= site_url('cart/remove'); ?>';

            /* ONE pending flag per cart-item id — blocks ALL duplicate AJAX */
            const pending = {};

            /* ── Helpers ── */

            /**
             * Get unit price from the card's data-price attribute.
             * This is the ONLY source of price — no DOM text parsing.
             */
            function getPrice(id) {
                return parseFloat($('.cart-item-row[data-id="' + id + '"]').first().data('price')) || 0;
            }

            /**
             * Read qty from the FIRST qty-display in the card.
             * Both desktop + mobile share the same card, so .first() is safe.
             */
            function getQty(id) {
                return parseInt($('.cart-item-row[data-id="' + id + '"]').first().find('.qty-display').first().text(), 10) || 1;
            }

            /** Push qty + subtotal into DOM for both desktop and mobile at once */
            function setQty(id, qty) {
                var price = getPrice(id);
                var subtotal = (price * qty).toFixed(2);

                /* Update both desktop + mobile qty displays inside the card */
                $('.cart-item-row[data-id="' + id + '"]').find('.qty-display').text(qty);
                /* Update both desktop + mobile subtotal spans inside the card */
                $('.cart-item-row[data-id="' + id + '"]').find('.itemSubtotalNum').text(subtotal);

                /* Update summary duration breakdown */
                var $dur = $('.duration-item[data-id="' + id + '"]');
                $dur.find('.durationQty').text(qty);
                $dur.find('.durationSubtotal').text('\u20B9' + subtotal);
            }

            /** Recalculate order summary totals */
            function recalc() {
                var subtotal = 0;

                /* Read from data-price + qty-display — no text parsing of currency strings */
                $('.cart-item-row').each(function() {
                    var price = parseFloat($(this).data('price')) || 0;
                    var qty = parseInt($(this).find('.qty-display').first().text(), 10) || 0;
                    subtotal += price * qty;
                });

                var discount = 0;
                if (OFFER_PCT > 0 && (MIN_FOR_OFFER === 0 || subtotal >= MIN_FOR_OFFER)) {
                    discount = (subtotal * OFFER_PCT) / 100;
                }
                var total = Math.max(0, subtotal - discount);

                $('#cartSubtotal').text('\u20B9' + subtotal.toFixed(2));
                $('#cartTotal').text('\u20B9' + total.toFixed(2));
                $('#platformDiscountAmount').text('\u20B9' + discount.toFixed(2));
                $('#platformDiscountRow').toggleClass('d-none', discount <= 0);

                /* Pay button state */
                var $btn = $('#payNowBtn');
                if (total <= 0) {
                    $btn.prop('disabled', true).attr('onclick', '');
                } else {
                    $btn.prop('disabled', false).attr('onclick', "window.location.href='" + PAY_URL + "'");
                }

                /* Cart icon count */
                var totalQty = 0;
                $('.cart-item-row').each(function() {
                    totalQty += parseInt($(this).find('.qty-display').first().text(), 10) || 0;
                });
                $('.cart-count').text(totalQty);
            }

            /* ── Quantity buttons ── */
            $(document).on('click', '.increaseQty, .decreaseQty', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation(); /* stops the sibling button (mobile/desktop twin) */

                var $btn = $(this);
                var id = String($btn.data('id'));

                /* Hard block if request already in flight */
                if (pending[id]) return;

                var action = $btn.hasClass('increaseQty') ? 'increase' : 'decrease';

                /* Lock every +/- button for this item (covers desktop AND mobile) */
                pending[id] = true;
                $('.cart-item-row[data-id="' + id + '"]').find('.qty-btn').prop('disabled', true);

                $.ajax({
                        url: UPDATE_URL,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            action: action
                        },
                        timeout: 8000
                    })
                    .done(function(res) {
                        if (res && res.status === 'success') {
                            setQty(id, parseInt(res.qty, 10));
                            recalc();
                        }
                        /* On failure we do nothing — server qty is unchanged, DOM stays correct */
                    })
                    .always(function() {
                        delete pending[id];
                        $('.cart-item-row[data-id="' + id + '"]').find('.qty-btn').prop('disabled', false);
                    });
            });

            /* ── Remove item ── */
            $(document).on('click', '.remove-cart-item', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var $btn = $(this);
                var id = String($btn.data('id'));

                if ($btn.data('removing')) return;
                $btn.data('removing', true);

                var $card = $('.cart-item-row[data-id="' + id + '"]');

                $.ajax({
                        url: REMOVE_URL,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        timeout: 8000
                    })
                    .done(function(res) {
                        if (res && res.status === 'success') {
                            $card.fadeOut(250, function() {
                                $(this).remove();

                                /* Clean up duration breakdown row */
                                var $durItem = $('.duration-item[data-id="' + id + '"]');
                                var $durSection = $durItem.closest('.duration-block');
                                $durItem.remove();
                                if ($durSection.find('.duration-item').length === 0) {
                                    $durSection.remove();
                                }

                                recalc();

                                if ($('.cart-item-row').length === 0) {
                                    $('#cartItemsCol').html(
                                        '<div class="empty-cart">' +
                                        '<div class="empty-icon-wrap"><i class="bi bi-cart-x"></i></div>' +
                                        '<h4>Your cart is empty</h4>' +
                                        '<p>Looks like you haven\'t added any services yet. Let\'s find something for you!</p>' +
                                        '<a href="<?= base_url('services'); ?>" class="browse-btn"><i class="bi bi-search me-2"></i>Browse Services</a>' +
                                        '</div>'
                                    );
                                }
                            });
                        } else {
                            $btn.data('removing', false);
                        }
                    })
                    .fail(function() {
                        $btn.data('removing', false);
                    });
            });

        } // end initCart

        initCart();
    })();
</script>