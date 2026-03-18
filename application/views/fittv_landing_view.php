<style>
    .fittv-page {
        min-height: 100vh;
        padding: 36px 0 52px;
        background:
            radial-gradient(circle at top left, rgba(168, 85, 247, 0.16), transparent 28%),
            radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
            linear-gradient(180deg, #f3f0ff 0%, #e8f0ff 100%);
    }

    .fittv-shell {
        max-width: 1040px;
        margin: 0 auto;
    }

    .fittv-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding: 16px 18px;
        border-radius: 18px;
        font-size: 0.95rem;
        font-weight: 600;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .fittv-alert svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .fittv-alert-success {
        color: #166534;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .fittv-alert-error {
        color: #b91c1c;
        background: #fef2f2;
        border: 1px solid #fecaca;
    }

    .fittv-card {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.88), rgba(245, 247, 255, 0.96));
        border: 1px solid rgba(196, 181, 253, 0.7);
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(99, 102, 241, 0.16);
        backdrop-filter: blur(8px);
    }

    .fittv-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.3fr) minmax(280px, 0.7fr);
        gap: 28px;
        padding: 42px;
        background: linear-gradient(135deg, #f6edff 0%, #efe9ff 42%, #e0ecff 100%);
        color: #1e293b;
        position: relative;
    }

    .fittv-hero::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -30px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(168, 85, 247, 0.18), transparent 68%);
        pointer-events: none;
    }

    .fittv-hero::after {
        content: '';
        position: absolute;
        bottom: -80px;
        left: 45%;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.20), transparent 70%);
        pointer-events: none;
    }

    .fittv-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.64);
        border: 1px solid rgba(124, 58, 237, 0.16);
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 18px;
        color: #7c3aed;
        position: relative;
        z-index: 1;
    }

    .fittv-badge-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #22c55e;
    }

    .fittv-hero h1 {
        margin: 0 0 14px;
        color: #0f172a;
        font-size: 2.55rem;
        font-weight: 800;
        line-height: 1.08;
        letter-spacing: -0.03em;
        background: none;
        border: none;
        text-transform: none;
        -webkit-text-fill-color: #0f172a;
        position: relative;
        z-index: 1;
    }

    .fittv-hero p {
        margin: 0;
        max-width: 620px;
        color: #4b5563;
        font-size: 1rem;
        line-height: 1.7;
        position: relative;
        z-index: 1;
    }

    .fittv-pill-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
        position: relative;
        z-index: 1;
    }

    .fittv-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.74), rgba(244, 240, 255, 0.82));
        border: 1px solid rgba(167, 139, 250, 0.18);
        font-size: 0.88rem;
        color: #334155;
        box-shadow: 0 10px 24px rgba(124, 58, 237, 0.10);
    }

    .fittv-pill svg {
        width: 18px;
        height: 18px;
        stroke: #7c3aed;
        flex-shrink: 0;
    }

    .fittv-price-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 18px;
        padding: 26px;
        border-radius: 24px;
        background: linear-gradient(180deg, rgba(126, 34, 206, 0.10), rgba(59, 130, 246, 0.08), rgba(255, 255, 255, 0.72));
        border: 1px solid rgba(147, 197, 253, 0.42);
        box-shadow: 0 18px 36px rgba(99, 102, 241, 0.14);
        position: relative;
        z-index: 1;
    }

    .fittv-price-label {
        color: #6d28d9;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .fittv-price-value {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-top: 8px;
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1;
        color: #0f172a;
    }

    .fittv-price-value span {
        font-size: 1rem;
        font-weight: 600;
        color: #64748b;
    }

    .fittv-price-note {
        margin: 0;
        color: #475569;
        font-size: 0.92rem;
        line-height: 1.7;
    }

    .fittv-content {
        padding: 34px 42px 40px;
    }

    .fittv-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .fittv-feature {
        padding: 22px;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffffff 0%, #f6f4ff 100%);
        border: 1px solid #ddd6fe;
        box-shadow: 0 12px 28px rgba(124, 58, 237, 0.08);
    }

    .fittv-feature-icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        border-radius: 14px;
        background: linear-gradient(135deg, #ddd6fe, #e0e7ff);
    }

    .fittv-feature:nth-child(2) .fittv-feature-icon {
        background: linear-gradient(135deg, #fde2ff, #ffe4f1);
    }

    .fittv-feature:nth-child(3) .fittv-feature-icon {
        background: linear-gradient(135deg, #dbeafe, #ecfeff);
    }

    .fittv-feature-icon svg {
        width: 22px;
        height: 22px;
    }

    .fittv-feature h3 {
        margin: 0 0 8px;
        color: #0f172a;
        font-size: 1.02rem;
        font-weight: 700;
        background: none;
        border: none;
        text-transform: none;
        -webkit-text-fill-color: #0f172a;
    }

    .fittv-feature p {
        margin: 0;
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.65;
    }

    .fittv-summary {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 22px;
        align-items: center;
        padding: 24px 26px;
        border-radius: 24px;
        background: linear-gradient(135deg, #ede9fe 0%, #fdf4ff 48%, #e0ecff 100%);
        border: 1px solid #c4b5fd;
        box-shadow: 0 14px 34px rgba(99, 102, 241, 0.10);
    }

    .fittv-summary h2 {
        margin: 0 0 8px;
        color: #0f172a;
        font-size: 1.12rem;
        font-weight: 700;
    }

    .fittv-summary p {
        margin: 0;
        color: #475569;
        font-size: 0.94rem;
        line-height: 1.7;
    }

    .fittv-actions {
        display: flex;
        justify-content: flex-end;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 28px;
    }

    .fittv-btn,
    .fittv-btn:focus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 188px;
        padding: 15px 24px;
        border: 0;
        border-radius: 16px;
        font-size: 0.96rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        cursor: pointer;
    }

    .fittv-btn:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .fittv-btn-light {
        color: #334155;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
    }

    .fittv-btn-light:hover {
        color: #0f172a;
        background: #f1f5f9;
    }

    .fittv-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #ef4444, #2563eb);
        box-shadow: 0 16px 30px rgba(37, 99, 235, 0.20);
    }

    .fittv-btn-primary:hover {
        color: #fff;
        box-shadow: 0 20px 36px rgba(37, 99, 235, 0.26);
    }

    .fittv-btn-success {
        color: #fff;
        background: linear-gradient(135deg, #059669, #10b981);
        box-shadow: 0 16px 30px rgba(5, 150, 105, 0.18);
    }

    .fittv-btn-success:hover {
        color: #fff;
    }

    .fittv-btn svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .fittv-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 0.84rem;
        font-weight: 600;
    }

    .fittv-meta span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .fittv-meta svg {
        width: 16px;
        height: 16px;
        stroke: #2563eb;
    }

    @media (max-width: 991px) {
        .fittv-hero {
            grid-template-columns: 1fr;
        }

        .fittv-grid {
            grid-template-columns: 1fr;
        }

        .fittv-summary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .fittv-page {
            padding: 22px 0 38px;
        }

        .fittv-hero,
        .fittv-content {
            padding: 24px;
        }

        .fittv-hero h1 {
            font-size: 1.9rem;
        }

        .fittv-price-value {
            font-size: 2.2rem;
        }

        .fittv-actions {
            justify-content: stretch;
        }

        .fittv-btn,
        .fittv-pay-form {
            width: 100%;
        }
    }
</style>

<div class="fittv-page">
    <div class="container">
        <div class="fittv-shell">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="fittv-alert fittv-alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="fittv-alert fittv-alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <span><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <div class="fittv-card">
                <div class="fittv-hero">
                    <div>
                        <div class="fittv-badge">
                            <span class="fittv-badge-dot"></span>
                            FITTV Premium Access
                        </div>
                        <h1><?= htmlspecialchars($settings['title'] ?? 'FITTV Premium Access') ?></h1>
                        <p><?= nl2br(htmlspecialchars($settings['description'] ?? 'Unlock full FITTV access to explore all workout categories and videos.')) ?></p>

                        <div class="fittv-pill-row">
                            <div class="fittv-pill">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                </svg>
                                Full workout library
                            </div>
                            <div class="fittv-pill">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                Verified secure payment
                            </div>
                            <div class="fittv-pill">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Instant access after success
                            </div>
                        </div>
                    </div>

                    <div class="fittv-price-card">
                        <div>
                            <div class="fittv-price-label">One-time plan</div>
                            <div class="fittv-price-value">
                                <?php if ((float) ($settings['price'] ?? 0) > 0): ?>
                                    &#8377;<?= number_format((float) $settings['price'], 0) ?>
                                    <span>one-time</span>
                                <?php else: ?>
                                    FREE
                                <?php endif; ?>
                            </div>
                        </div>

                        <p class="fittv-price-note">
                            <?= $has_access
                                ? 'Your account already has FITTV access. You can continue directly to the video library.'
                                : 'Complete the payment once and the FITTV library will be unlocked for your account.' ?>
                        </p>
                    </div>
                </div>

                <div class="fittv-content">
                    <div class="fittv-grid">
                        <div class="fittv-feature">
                            <div class="fittv-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <h3>Simple Categories</h3>
                            <p>Open a clean library of workout categories and browse videos quickly without extra steps.</p>
                        </div>

                        <div class="fittv-feature">
                            <div class="fittv-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 1v22"></path>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                            <h3>One-Time Payment</h3>
                            <p>Pay once for FITTV access and avoid repeated checkout each time you want to watch content.</p>
                        </div>

                        <div class="fittv-feature">
                            <div class="fittv-feature-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 12l2 2 4-4"></path>
                                    <path d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4z"></path>
                                </svg>
                            </div>
                            <h3>Reliable Checkout</h3>
                            <p>The payment handoff now includes a clearer fallback so users can still open checkout if the browser blocks auto-launch.</p>
                        </div>
                    </div>

                    <div class="fittv-summary">
                        <div>
                            <h2><?= $has_access ? 'Access ready' : 'Ready to unlock FITTV?' ?></h2>
                            <p>
                                <?= $has_access
                                    ? 'Your account has an active FITTV purchase, so you can go straight to the content.'
                                    : 'After a successful payment, access is granted immediately. If checkout cannot open automatically, the next page now gives a clear manual payment button.' ?>
                            </p>
                        </div>
                        <div>
                            <strong style="color:#0f172a; font-size:1.55rem;">
                                <?php if ((float) ($settings['price'] ?? 0) > 0): ?>
                                    &#8377;<?= number_format((float) $settings['price'], 0) ?>
                                <?php else: ?>
                                    FREE
                                <?php endif; ?>
                            </strong>
                        </div>
                    </div>

                    <div class="fittv-actions">
                        <a href="<?= base_url() ?>" class="fittv-btn fittv-btn-light">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Back to Home
                        </a>

                        <?php if ($has_access): ?>
                            <a href="<?= base_url('fittv/access') ?>" class="fittv-btn fittv-btn-success">
                                Access FITTV
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        <?php else: ?>
                            <form method="get" action="<?= base_url('fittv/pay') ?>" class="fittv-pay-form mb-0">
                                <button type="submit" class="fittv-btn fittv-btn-primary">
                                    Proceed to Payment
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="fittv-meta">
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            SSL encrypted
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                            Verified payment flow
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 4L12 14.01l-3-3"></path>
                                <path d="M5 12v7h14v-7"></path>
                            </svg>
                            Instant activation after success
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
