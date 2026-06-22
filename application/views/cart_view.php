<style>
    :root {
        --primary-color: #6f42c1;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --bg-light: #f8f9fa;
        --gradient-primary: linear-gradient(135deg, #6f42c1 0%, #8e44ad 100%);
        --success-gradient: linear-gradient(135deg, #10ac84, #0fb272);
        --danger-gradient: linear-gradient(135deg, #ff4757, #ff3742);
        --info-gradient: linear-gradient(135deg, #667eea, #764ba2);
        --shadow-light: 0 2px 15px rgba(111, 66, 193, 0.1);
        --shadow-medium: 0 4px 25px rgba(111, 66, 193, 0.15);
        --br-sm: 8px;
        --br-md: 12px;
        --br-lg: 16px;
        --br-xl: 20px;
        --br-pill: 25px;
        --transition: all 0.25s ease;
    }

    /* ── Base ── */
    .cart-page-wrap {
        padding: 2rem 0 4rem;
    }

    .cart-header-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--gradient-primary);
        padding: 1rem 1.5rem;
        border-radius: var(--br-lg);
        color: #fff;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-medium);
    }

    .cart-header-bar h3 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
    }

    /* ── Cart Card ── */
    .cart-card {
        background: #fff;
        border: 1px solid rgba(111, 66, 193, 0.12);
        border-radius: var(--br-lg);
        box-shadow: var(--shadow-light);
        padding: 1.25rem;
        margin-bottom: 1rem;
        transition: var(--transition);
        /* CRITICAL: store price as data attr to avoid parsing issues */
    }

    .cart-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    /* ── Provider image ── */
    .prov-img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(111, 66, 193, 0.2);
        flex-shrink: 0;
    }

    /* ── Price badge ── */
    .price-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: var(--info-gradient);
        color: #fff;
        padding: 0.3rem 0.85rem;
        border-radius: var(--br-pill);
        font-weight: 700;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    /* ── Qty Controls ── */
    .qty-wrap {
        display: inline-flex;
        align-items: center;
        border-radius: var(--br-pill);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(111, 66, 193, 0.2);
        width: 110px;
    }

    .qty-btn {
        width: 34px;
        height: 36px;
        border: none;
        background: var(--primary-color);
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.15s;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qty-btn:hover {
        background: var(--accent-color);
    }

    .qty-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .qty-display {
        flex: 1;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.08);
        border: none;
        height: 36px;
        line-height: 36px;
        pointer-events: none;
        user-select: none;
    }

    /* ── Remove btn ── */
    .remove-btn {
        background: var(--danger-gradient);
        border: none;
        border-radius: var(--br-pill);
        color: #fff;
        padding: 0.45rem 1rem;
        font-size: 0.825rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
        white-space: nowrap;
    }

    .remove-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(255, 71, 87, 0.4);
    }

    /* ── Item subtotal ── */
    .item-subtotal-val {
        font-weight: 700;
        font-size: 1.05rem;
        color: #10ac84;
        white-space: nowrap;
    }

    /* ── Desktop layout ── */
    .cart-desktop {
        display: grid;
        grid-template-columns: 60px 1fr 130px 110px 120px 110px;
        align-items: center;
        gap: 1rem;
    }

    .cart-desktop .col-label {
        font-size: 0.75rem;
        color: #999;
        display: block;
        margin-bottom: 0.35rem;
    }

    .cart-desktop .text-center {
        text-align: center;
    }

    /* ── Mobile layout (hidden on md+) ── */
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

        .cart-mobile .mob-row1 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .cart-mobile .mob-info {
            flex: 1;
            min-width: 0;
        }

        .cart-mobile .mob-info .item-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-mobile .mob-info .start-date {
            font-size: 0.78rem;
            color: #999;
            margin-top: 2px;
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
            font-size: 0.9rem;
            color: #10ac84;
            font-weight: 700;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid #f0f0f0;
        }

        .prov-img {
            width: 46px;
            height: 46px;
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
            padding: 0.4rem 0.7rem;
            font-size: 0.78rem;
        }
    }

    /* ── Empty Cart ── */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, var(--bg-light), #e9ecef);
        border-radius: var(--br-xl);
        box-shadow: var(--shadow-light);
    }

    .empty-cart i {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-cart h4 {
        font-size: 1.4rem;
        color: #495057;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* ── Summary card ── */
    .summary-card {
        background: #fff;
        border-radius: var(--br-xl);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: sticky;
        top: 1rem;
    }

    .summary-header {
        background: var(--gradient-primary);
        color: #fff;
        padding: 1.25rem 1.75rem;
    }

    .summary-header h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .summary-body {
        padding: 1.5rem 1.75rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.05rem;
        font-weight: 700;
        margin-top: 0.5rem;
    }

    #cartTotal {
        font-size: 1.6rem;
        font-weight: 800;
        color: #10ac84;
    }

    .duration-block {
        background: linear-gradient(135deg, var(--bg-light), #eef0f3);
        border-left: 4px solid var(--primary-color);
        border-radius: var(--br-sm);
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
    }

    .duration-block .dur-title {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 0.85rem;
        text-transform: capitalize;
        margin-bottom: 0.4rem;
    }

    .dur-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.82rem;
        color: #555;
        padding: 0.15rem 0;
    }

    .discount-alert {
        background: var(--success-gradient);
        color: #fff;
        border-radius: var(--br-md);
        padding: 0.6rem 1rem;
        text-align: center;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .pay-btn {
        width: 100%;
        background: var(--success-gradient);
        border: none;
        border-radius: var(--br-pill);
        color: #fff;
        padding: 0.875rem;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(16, 172, 132, 0.3);
        margin-top: 1rem;
    }

    .pay-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 172, 132, 0.4);
    }

    .pay-btn:disabled {
        background: #adb5bd;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Alerts */
    .alert {
        border-radius: var(--br-md);
        border: none;
    }

    .alert-success {
        background: var(--success-gradient);
        color: #fff;
    }

    .alert-danger {
        background: var(--danger-gradient);
        color: #fff;
    }

    .alert .btn-close {
        filter: invert(1);
    }

    @media (max-width: 991px) {
        .summary-card {
            position: static;
            margin-top: 1.5rem;
        }
    }
</style>

<div class="container cart-page-wrap">

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="cart-header-bar">
        <i class="bi bi-cart3 fs-4"></i>
        <h3>Your Cart Items</h3>
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
                                <div style="font-weight:700;color:var(--text-dark);margin-bottom:0.25rem;">
                                    <?= htmlspecialchars($item['provider_name']); ?>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i><?= $item['start_date']; ?>
                                </small>
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
                                    <i class="bi bi-trash me-1"></i>Remove
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
                                    <div class="start-date"><i class="bi bi-calendar-event me-1"></i><?= $item['start_date']; ?></div>
                                </div>
                                <button class="remove-btn remove-cart-item" data-id="<?= (int)$item['id']; ?>" style="padding:0.4rem 0.7rem;">
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
                                <div class="mob-subtotal">
                                    Total: &#8377;<span class="itemSubtotalNum"><?= number_format($item_total, 2); ?></span>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.cart-card -->
                <?php endforeach; ?>

            <?php else: ?>
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <h4>Your cart is empty</h4>
                    <p class="text-muted mb-0">Add some items to get started!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- ── Order Summary ── -->
        <div class="col-12 col-lg-4">
            <div class="summary-card">
                <div class="summary-header">
                    <h5><i class="bi bi-receipt me-2"></i>Order Summary</h5>
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
                        <div style="margin-bottom:1rem;">
                            <div style="font-size:0.8rem;color:#888;margin-bottom:0.5rem;">
                                <i class="bi bi-clock me-1"></i>Duration Breakdown
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
                        </div>
                    <?php endif; ?>

                    <!-- Discount -->
                    <div id="platformDiscountRow"
                        class="discount-alert <?= (!empty($discount_amount) && $discount_amount > 0) ? '' : 'd-none'; ?>">
                        <i class="bi bi-gift me-1"></i>
                        You save <span id="platformDiscountAmount">&#8377;<?= number_format((float)($discount_amount ?? 0), 2); ?></span>
                        (<?= (float)($offer_percent ?? 0); ?>% platform offer)
                    </div>

                    <hr style="margin:0.75rem 0;">

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
                        <i class="bi bi-credit-card me-2"></i>Pay Now
                    </button>

                    <?php if (($subtotal ?? 0) == 0): ?>
                        <small class="text-muted d-block text-center mt-2">
                            <i class="bi bi-info-circle me-1"></i>Add items to proceed
                        </small>
                    <?php endif; ?>

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
                    var id = $(this).data('id');
                    var price = parseFloat($(this).data('price')) || 0;
                    var qty = parseInt($(this).find('.qty-display').first().text(), 10) || 0;
                    subtotal += price * qty;
                });

                /* Avoid double-counting by only reading first occurrence (desktop wins) */
                /* The above is already safe because .each iterates cards (not inner elements) */

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
                                        '<i class="bi bi-cart-x"></i>' +
                                        '<h4>Your cart is empty</h4>' +
                                        '<p class="text-muted mb-0">Add some items to get started!</p>' +
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