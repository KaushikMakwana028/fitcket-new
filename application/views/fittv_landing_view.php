<style>
    .fittv-access-page {
        min-height: 100vh;
        padding: 32px 0 48px;
        background:
            radial-gradient(circle at top left, rgba(226, 74, 107, 0.14), transparent 28%),
            radial-gradient(circle at top right, rgba(79, 70, 229, 0.14), transparent 24%),
            linear-gradient(180deg, #f8f9fc 0%, #eef2ff 100%);
    }

    .fittv-access-card {
        max-width: 980px;
        margin: 0 auto;
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 20px 50px rgba(31, 41, 55, 0.12);
        overflow: hidden;
        border: 1px solid rgba(99, 102, 241, 0.08);
    }

    .fittv-access-page .fittv-hero {
        padding: 52px 48px 48px;
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #4c1d95 75%, #be185d 120%);
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .fittv-access-page .fittv-hero::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.2), transparent 70%);
        pointer-events: none;
    }

    .fittv-access-page .fittv-hero::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: 30%;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.15), transparent 70%);
        pointer-events: none;
    }

    .fittv-access-page .fittv-hero-content {
        position: relative;
        z-index: 2;
    }

    .fittv-access-page .fittv-hero-grid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
    }

    .fittv-access-page .fittv-hero-text {
        flex: 1;
    }

    .fittv-access-page .fittv-hero-visual {
        flex-shrink: 0;
    }

    .fittv-access-page .fittv-hero-icon-wrap {
        width: 110px;
        height: 110px;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fittvFloat 4s ease-in-out infinite;
    }

    @keyframes fittvFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-8px);
        }
    }

    .fittv-access-page .fittv-hero-icon-wrap svg {
        width: 52px;
        height: 52px;
        opacity: 0.9;
    }

    .fittv-access-page .fittv-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 20px;
        color: rgba(255, 255, 255, 0.95);
    }

    .fittv-access-page .fittv-kicker-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #34d399;
        animation: fittvPulse 2s ease-in-out infinite;
    }

    @keyframes fittvPulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.4);
        }
    }

    .fittv-access-page .fittv-hero h1 {
        font-size: 2.6rem;
        font-weight: 900;
        margin: 0 0 16px 0;
        padding: 0;
        line-height: 1.08;
        letter-spacing: -0.03em;
        color: #fff;
        background: none;
        -webkit-text-fill-color: #fff;
        border: none;
        text-transform: none;
    }

    .fittv-access-page .fittv-hero p {
        max-width: 520px;
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.72);
        margin: 0;
        line-height: 1.65;
    }

    .fittv-access-page .fittv-stats-row {
        display: flex;
        gap: 24px;
        margin-top: 26px;
    }

    .fittv-access-page .fittv-stat {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .fittv-access-page .fittv-stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fittv-access-page .fittv-stat-icon svg {
        width: 18px;
        height: 18px;
        stroke: rgba(255, 255, 255, 0.7);
    }

    .fittv-access-page .fittv-stat-text {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.65);
        line-height: 1.3;
    }

    .fittv-access-page .fittv-stat-text strong {
        display: block;
        color: #fff;
        font-size: 0.92rem;
        font-weight: 700;
    }

    .fittv-access-page .fittv-access-body {
        padding: 40px 48px 48px;
    }

    .fittv-access-page .fittv-section-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #6366f1;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .fittv-access-page .fittv-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.2), transparent);
    }

    .fittv-access-page .fittv-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 36px;
    }

    .fittv-access-page .fittv-feature {
        background: #fafbff;
        border: 1px solid rgba(99, 102, 241, 0.08);
        border-radius: 20px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .fittv-access-page .fittv-feature::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #ec4899);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .fittv-access-page .fittv-feature:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(99, 102, 241, 0.1);
    }

    .fittv-access-page .fittv-feature:hover::before {
        opacity: 1;
    }

    .fittv-access-page .fittv-feature-icon {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .fittv-access-page .fittv-feature:nth-child(1) .fittv-feature-icon {
        background: linear-gradient(135deg, #ede9fe, #e0e7ff);
    }

    .fittv-access-page .fittv-feature:nth-child(2) .fittv-feature-icon {
        background: linear-gradient(135deg, #fce7f3, #fce4ec);
    }

    .fittv-access-page .fittv-feature:nth-child(3) .fittv-feature-icon {
        background: linear-gradient(135deg, #d1fae5, #e0f2fe);
    }

    .fittv-access-page .fittv-feature-icon svg {
        width: 22px;
        height: 22px;
    }

    .fittv-access-page .fittv-feature h3 {
        font-size: 1rem;
        font-weight: 800;
        margin: 0 0 8px 0;
        padding: 0;
        color: #111827;
        border: none;
        background: none;
        -webkit-text-fill-color: #111827;
        text-transform: none;
        letter-spacing: normal;
        line-height: 1.3;
    }

    .fittv-access-page .fittv-feature p {
        margin: 0;
        color: #6b7280;
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .fittv-access-page .fittv-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 28px 32px;
        border-radius: 24px;
        background: linear-gradient(135deg, #f5f3ff 0%, #fdf2f8 50%, #fff7ed 100%);
        border: 1px solid rgba(99, 102, 241, 0.1);
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .fittv-access-page .fittv-summary::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.08), transparent 70%);
        pointer-events: none;
    }

    .fittv-access-page .fittv-price-wrap {
        position: relative;
        z-index: 1;
    }

    .fittv-access-page .fittv-price-wrap small {
        display: block;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .fittv-access-page .fittv-price {
        font-size: 2.4rem;
        font-weight: 900;
        color: #111827;
        line-height: 1;
        letter-spacing: -0.03em;
        display: flex;
        align-items: baseline;
        gap: 6px;
    }

    .fittv-access-page .fittv-price-currency {
        font-size: 1.4rem;
        font-weight: 700;
        color: #6366f1;
    }

    .fittv-access-page .fittv-price-period {
        font-size: 0.85rem;
        font-weight: 500;
        color: #9ca3af;
        margin-left: 4px;
    }

    .fittv-access-page .fittv-price-note {
        color: #6b7280;
        font-size: 0.9rem;
        max-width: 400px;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }

    .fittv-access-page .fittv-guarantee {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        font-size: 0.8rem;
        color: #059669;
        font-weight: 600;
    }

    .fittv-access-page .fittv-guarantee svg {
        width: 16px;
        height: 16px;
    }

    .fittv-access-page .fittv-actions {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        flex-wrap: wrap;
    }

    .fittv-access-page .fittv-btn {
        border: none;
        border-radius: 16px;
        padding: 16px 28px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        line-height: 1.2;
    }

    .fittv-access-page .fittv-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .fittv-access-page .fittv-btn-cancel {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .fittv-access-page .fittv-btn-cancel:hover {
        background: #e5e7eb;
        color: #374151;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .fittv-access-page .fittv-btn-pay {
        background: linear-gradient(135deg, #6366f1, #a855f7, #ec4899);
        color: #fff;
        box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        min-width: 200px;
    }

    .fittv-access-page .fittv-btn-pay:hover {
        box-shadow: 0 12px 36px rgba(99, 102, 241, 0.4);
        color: #fff;
    }

    .fittv-access-page .fittv-btn-access {
        background: linear-gradient(135deg, #059669, #10b981, #34d399);
        color: #fff;
        box-shadow: 0 8px 24px rgba(5, 150, 105, 0.25);
        min-width: 200px;
    }

    .fittv-access-page .fittv-btn-access:hover {
        box-shadow: 0 12px 36px rgba(5, 150, 105, 0.35);
        color: #fff;
    }

    .fittv-access-page .fittv-btn-icon {
        display: flex;
        align-items: center;
    }

    .fittv-access-page .fittv-btn-icon svg {
        width: 18px;
        height: 18px;
    }

    .fittv-access-page .fittv-trust-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 28px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #f3f4f6;
    }

    .fittv-access-page .fittv-trust-badge {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: #9ca3af;
        font-weight: 500;
    }

    .fittv-access-page .fittv-trust-badge svg {
        width: 16px;
        height: 16px;
        stroke: #d1d5db;
    }

    .fittv-access-page .fittv-alert {
        max-width: 980px;
        margin: 0 auto 20px;
        padding: 16px 24px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: fittvSlideDown 0.4s ease;
    }

    .fittv-access-page .fittv-alert-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #065f46;
    }

    .fittv-access-page .fittv-alert-error {
        background: linear-gradient(135deg, #fef2f2, #fecaca);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #991b1b;
    }

    .fittv-access-page .fittv-alert-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .fittv-access-page .fittv-alert-success .fittv-alert-icon {
        background: rgba(16, 185, 129, 0.15);
    }

    .fittv-access-page .fittv-alert-error .fittv-alert-icon {
        background: rgba(239, 68, 68, 0.15);
    }

    @keyframes fittvSlideDown {
        from {
            opacity: 0;
            transform: translateY(-12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .fittv-access-page {
            padding: 20px 0 40px;
        }

        .fittv-access-page .fittv-access-card {
            margin: 0 8px;
            border-radius: 24px;
        }

        .fittv-access-page .fittv-hero {
            padding: 32px 24px;
        }

        .fittv-access-page .fittv-hero-grid {
            flex-direction: column-reverse;
            gap: 20px;
        }

        .fittv-access-page .fittv-hero-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 20px;
        }

        .fittv-access-page .fittv-hero-icon-wrap svg {
            width: 38px;
            height: 38px;
        }

        .fittv-access-page .fittv-hero h1 {
            font-size: 1.85rem;
        }

        .fittv-access-page .fittv-stats-row {
            flex-wrap: wrap;
            gap: 16px;
        }

        .fittv-access-page .fittv-access-body {
            padding: 28px 24px 32px;
        }

        .fittv-access-page .fittv-feature-grid {
            grid-template-columns: 1fr;
        }

        .fittv-access-page .fittv-summary {
            flex-direction: column;
            align-items: flex-start;
            padding: 24px;
        }

        .fittv-access-page .fittv-actions {
            justify-content: stretch;
        }

        .fittv-access-page .fittv-btn {
            width: 100%;
        }

        .fittv-access-page .fittv-trust-row {
            flex-wrap: wrap;
            gap: 16px;
        }
    }
</style>

<div class="fittv-access-page">
    <div class="container">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="fittv-alert fittv-alert-success">
                <span class="fittv-alert-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="fittv-alert fittv-alert-error">
                <span class="fittv-alert-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </span>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="fittv-access-card">
            <!-- Hero -->
            <div class="fittv-hero">
                <div class="fittv-hero-content">
                    <div class="fittv-hero-grid">
                        <div class="fittv-hero-text">
                            <div class="fittv-kicker">
                                <span class="fittv-kicker-dot"></span>
                                FITTV Premium
                            </div>
                            <h1><?= htmlspecialchars($settings['title'] ?? 'FITTV Premium Access') ?></h1>
                            <p><?= nl2br(htmlspecialchars($settings['description'] ?? 'Unlock full FITTV access to explore all workout categories and videos.')) ?></p>

                            <div class="fittv-stats-row">
                                <div class="fittv-stat">
                                    <div class="fittv-stat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                        </svg>
                                    </div>
                                    <div class="fittv-stat-text">
                                        <strong>HD Videos</strong>
                                        Full library access
                                    </div>
                                </div>
                                <div class="fittv-stat">
                                    <div class="fittv-stat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg>
                                    </div>
                                    <div class="fittv-stat-text">
                                        <strong>Secure</strong>
                                        Verified payment
                                    </div>
                                </div>
                                <div class="fittv-stat">
                                    <div class="fittv-stat-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                    <div class="fittv-stat-text">
                                        <strong>Instant</strong>
                                        Immediate access
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="fittv-hero-visual">
                            <div class="fittv-hero-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="5 3 19 12 5 21 5 3" fill="rgba(255,255,255,0.15)"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="fittv-access-body">
                <div class="fittv-section-label">What you get</div>

                <div class="fittv-feature-grid">
                    <div class="fittv-feature">
                        <div class="fittv-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                        </div>
                        <h3>Structured Library</h3>
                        <p>Browse fitness content by gender and category, then open the videos that match your goals.</p>
                    </div>
                    <div class="fittv-feature">
                        <div class="fittv-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <polyline points="9 12 11 14 15 10" stroke="#ec4899"></polyline>
                            </svg>
                        </div>
                        <h3>One Payment Access</h3>
                        <p>Pay once and unlock FITTV access. After success, the videos are available to your account.</p>
                    </div>
                    <div class="fittv-feature">
                        <div class="fittv-feature-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                        </div>
                        <h3>Easy Checkout</h3>
                        <p>Payment uses the same Razorpay flow already used in the project, so access is granted after verified success only.</p>
                    </div>
                </div>

                <div class="fittv-section-label">Pricing</div>

                <div class="fittv-summary">
                    <div class="fittv-price-wrap">
                        <small>Course Price</small>
                        <div class="fittv-price">
                            <?php if ((float)($settings['price'] ?? 0) > 0): ?>
                                <span class="fittv-price-currency">₹</span><?= number_format((float)$settings['price'], 0) ?>
                                <span class="fittv-price-period">one-time</span>
                            <?php else: ?>
                                FREE
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <div class="fittv-price-note">
                            <?= $has_access
                                ? 'Your account already has FITTV access. You can continue directly to the content.'
                                : 'Access is enabled only after successful payment verification. If you cancel, no payment record is stored.' ?>
                        </div>
                        <div class="fittv-guarantee">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            Secure payment &bull; Instant activation
                        </div>
                    </div>
                </div>

                <div class="fittv-actions">
                    <a href="<?= base_url() ?>" class="fittv-btn fittv-btn-cancel">
                        <span class="fittv-btn-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </span>
                        Cancel
                    </a>

                    <?php if ($has_access): ?>
                        <a href="<?= base_url('fittv/access') ?>" class="fittv-btn fittv-btn-access">
                            Access FITTV
                            <span class="fittv-btn-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </span>
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('fittv/pay') ?>" class="fittv-btn fittv-btn-pay">
                            Proceed to Payment
                            <span class="fittv-btn-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="fittv-trust-row">
                    <div class="fittv-trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        SSL Encrypted
                    </div>
                    <div class="fittv-trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        Secure Payments
                    </div>
                    <div class="fittv-trust-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Verified Access
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>