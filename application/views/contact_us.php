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
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-xl: 32px;
        --radius-pill: 50px;
    }

    .fkc-contact {
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
        overflow-x: hidden;
        line-height: 1.6;
    }

    .fkc-contact *,
    .fkc-contact *::before,
    .fkc-contact *::after {
        box-sizing: border-box;
    }

    .fkc-contact input,
    .fkc-contact button,
    .fkc-contact select,
    .fkc-contact textarea {
        font-family: 'Poppins', sans-serif;
    }

    .fkc-contact *:focus-visible {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* ── Reusable atoms ── */
    .fkc-label {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--primary-color);
        background: rgba(111, 66, 193, 0.1);
        padding: 5px 14px;
        border-radius: var(--radius-pill);
        margin-bottom: 16px;
    }

    .fkc-heading {
        font-size: clamp(1.8rem, 3.5vw, 3rem);
        font-weight: 800;
        color: var(--secondary-color);
        line-height: 1.15;
        letter-spacing: -0.025em;
    }

    .fkc-heading em {
        font-style: normal;
        color: var(--primary-color);
    }


    /* ══════════════════════════════════════════
     HERO
  ══════════════════════════════════════════ */
    .fkc-hero {
        position: relative;
        background: var(--secondary-color);
        padding: 110px 0 90px;
        overflow: hidden;
    }

    .fkc-hero__watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: clamp(80px, 18vw, 220px);
        font-weight: 900;
        letter-spacing: -0.04em;
        color: transparent;
        -webkit-text-stroke: 1px rgba(111, 66, 193, 0.15);
        white-space: nowrap;
        pointer-events: none;
        user-select: none;
        line-height: 1;
    }

    .fkc-hero::before {
        content: '';
        position: absolute;
        width: 2px;
        height: 140%;
        background: linear-gradient(180deg, transparent, rgba(111, 66, 193, 0.5), transparent);
        top: -20%;
        left: 62%;
        transform: rotate(18deg);
    }

    .fkc-hero::after {
        content: '';
        position: absolute;
        width: 550px;
        height: 550px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.22) 0%, transparent 70%);
        top: -120px;
        right: -180px;
        pointer-events: none;
    }

    .fkc-hero__inner {
        position: relative;
        z-index: 2;
    }

    .fkc-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(111, 66, 193, 0.2);
        border: 1px solid rgba(111, 66, 193, 0.4);
        color: #b19fe8;
        padding: 6px 18px;
        border-radius: var(--radius-pill);
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 28px;
    }

    .fkc-hero__eyebrow::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--primary-color);
        animation: fkc-pulse 1.8s ease-in-out infinite;
    }

    @keyframes fkc-pulse {

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

    .fkc-hero__heading {
        font-size: clamp(2.6rem, 6.5vw, 5rem);
        font-weight: 900;
        line-height: 1.05;
        color: var(--white);
        letter-spacing: -0.03em;
        margin-bottom: 20px;
    }

    .fkc-hero__heading em {
        font-style: normal;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .fkc-hero__sub {
        font-size: clamp(0.95rem, 1.6vw, 1.1rem);
        color: rgba(255, 255, 255, 0.55);
        font-weight: 300;
        max-width: 460px;
        line-height: 1.85;
    }

    /* Right visual */
    .fkc-hero__visual {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .fkc-hero__ring {
        width: clamp(240px, 34vw, 400px);
        height: clamp(240px, 34vw, 400px);
        border-radius: 50%;
        border: 1px solid rgba(111, 66, 193, 0.22);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fkc-hero__ring::before {
        content: '';
        position: absolute;
        inset: 22px;
        border-radius: 50%;
        border: 1px solid rgba(111, 66, 193, 0.14);
    }

    .fkc-hero__ring-icon {
        font-size: clamp(4.5rem, 10vw, 8rem);
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0.8;
    }

    .fkc-orbit-dot {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--primary-color);
    }

    .fkc-orbit-dot:nth-child(1) {
        top: -5px;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0.9;
    }

    .fkc-orbit-dot:nth-child(2) {
        bottom: 14%;
        right: -5px;
        opacity: 0.55;
    }

    .fkc-orbit-dot:nth-child(3) {
        bottom: -5px;
        left: 28%;
        opacity: 0.35;
    }


    /* ══════════════════════════════════════════
     INFO CARDS STRIP
  ══════════════════════════════════════════ */
    .fkc-infostrip {
        background: var(--bg-light);
        padding: 80px 0;
        position: relative;
    }

    .fkc-infostrip::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        background: var(--secondary-color);
        clip-path: polygon(0 0, 100% 0, 100% 55%, 0 100%);
    }

    .fkc-infostrip__grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    .fkc-info-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        padding: 36px 28px;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(111, 66, 193, 0.07);
    }

    .fkc-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .fkc-info-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 48px rgba(111, 66, 193, 0.13);
    }

    .fkc-info-card__icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--white);
        margin: 0 auto 20px;
        transition: transform 0.3s;
    }

    .fkc-info-card:hover .fkc-info-card__icon {
        transform: scale(1.1) rotate(-4deg);
    }

    .fkc-info-card__title {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--secondary-color);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 10px;
    }

    .fkc-info-card__main {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .fkc-info-card__sub {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.6;
    }


    /* ══════════════════════════════════════════
     FORM + MAP
  ══════════════════════════════════════════ */
    .fkc-main {
        padding: 100px 0;
        background: var(--white);
    }

    /* Form card */
    .fkc-form-card {
        background: var(--bg-light);
        border-radius: var(--radius-xl);
        padding: 52px 48px;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .fkc-form-card::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(111, 66, 193, 0.05);
        bottom: -100px;
        right: -100px;
        pointer-events: none;
    }

    .fkc-form-card .fkc-heading {
        margin-bottom: 32px;
    }

    /* Inputs */
    .fkc-field {
        margin-bottom: 20px;
    }

    .fkc-field label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--secondary-color);
        margin-bottom: 8px;
    }

    .fkc-field input,
    .fkc-field select,
    .fkc-field textarea {
        width: 100%;
        background: var(--white);
        border: 1.5px solid rgba(111, 66, 193, 0.12);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        font-size: 0.95rem;
        color: var(--text-dark);
        transition: border-color 0.25s, box-shadow 0.25s;
        appearance: none;
        -webkit-appearance: none;
    }

    .fkc-field input:focus,
    .fkc-field select:focus,
    .fkc-field textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
    }

    .fkc-field select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236f42c1' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
        cursor: pointer;
    }

    .fkc-field textarea {
        min-height: 130px;
        resize: vertical;
        line-height: 1.7;
    }

    .fkc-field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Checkbox */
    .fkc-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 24px;
        cursor: pointer;
    }

    .fkc-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        margin-top: 2px;
        accent-color: var(--primary-color);
        cursor: pointer;
    }

    .fkc-checkbox span {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* Submit */
    .fkc-btn-submit {
        width: 100%;
        background: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 16px 32px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        letter-spacing: 0.02em;
    }

    .fkc-btn-submit:hover {
        background: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 16px 32px rgba(111, 66, 193, 0.4);
    }

    /* Map side */
    .fkc-map-side {
        display: flex;
        flex-direction: column;
        gap: 24px;
        height: 100%;
    }

    .fkc-map-wrap {
        border-radius: var(--radius-xl);
        overflow: hidden;
        flex: 1;
        min-height: 320px;
        position: relative;
    }

    .fkc-map-wrap iframe {
        width: 100%;
        height: 100%;
        min-height: 320px;
        border: 0;
        display: block;
    }

    /* Contact detail rows */
    .fkc-contact-rows {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .fkc-contact-row {
        background: var(--bg-light);
        border-radius: var(--radius-lg);
        padding: 18px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.25s, box-shadow 0.25s;
        border: 1px solid rgba(111, 66, 193, 0.07);
    }

    .fkc-contact-row:hover {
        transform: translateX(6px);
        box-shadow: 0 8px 24px rgba(111, 66, 193, 0.1);
    }

    .fkc-contact-row__icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .fkc-contact-row__label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--text-muted);
        display: block;
        margin-bottom: 2px;
    }

    .fkc-contact-row__val {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--secondary-color);
        line-height: 1.5;
    }


    /* ══════════════════════════════════════════
     FAQ SECTION
  ══════════════════════════════════════════ */
    .fkc-faq {
        padding: 100px 0;
        background: var(--secondary-color);
        position: relative;
        overflow: hidden;
    }

    .fkc-faq::after {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(111, 66, 193, 0.18) 0%, transparent 70%);
        bottom: -250px;
        right: -150px;
        pointer-events: none;
    }

    .fkc-faq .fkc-label {
        color: #b19fe8;
        background: rgba(111, 66, 193, 0.2);
    }

    .fkc-faq .fkc-heading {
        color: var(--white);
    }

    .fkc-faq__list {
        position: relative;
        z-index: 2;
        margin-top: 52px;
    }

    .fkc-faq__item {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-lg);
        margin-bottom: 14px;
        overflow: hidden;
        transition: border-color 0.25s;
    }

    .fkc-faq__item.is-open {
        border-color: rgba(111, 66, 193, 0.4);
        background: rgba(111, 66, 193, 0.08);
    }

    .fkc-faq__trigger {
        width: 100%;
        background: none;
        border: none;
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        cursor: pointer;
        text-align: left;
        color: var(--white);
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
        transition: color 0.25s;
    }

    .fkc-faq__trigger:hover {
        color: #b19fe8;
    }

    .fkc-faq__arrow {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(111, 66, 193, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.25s, transform 0.3s;
        font-size: 0.75rem;
        color: #b19fe8;
    }

    .fkc-faq__item.is-open .fkc-faq__arrow {
        background: var(--primary-color);
        color: var(--white);
        transform: rotate(180deg);
    }

    .fkc-faq__body {
        display: none;
        padding: 0 28px 24px;
        color: rgba(255, 255, 255, 0.55);
        font-size: 0.93rem;
        line-height: 1.8;
    }

    .fkc-faq__item.is-open .fkc-faq__body {
        display: block;
    }


    /* ══════════════════════════════════════════
     RESPONSIVE
  ══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .fkc-hero {
            padding: 80px 0 64px;
        }

        .fkc-hero__visual {
            margin-top: 48px;
        }

        .fkc-infostrip__grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .fkc-form-card {
            padding: 36px 28px;
        }

        .fkc-map-side {
            margin-top: 40px;
        }
    }

    @media (max-width: 576px) {
        .fkc-infostrip__grid {
            grid-template-columns: 1fr 1fr;
        }

        .fkc-field-row {
            grid-template-columns: 1fr;
        }

        .fkc-form-card {
            padding: 28px 20px;
        }

        .fkc-faq__trigger {
            padding: 20px 20px;
            font-size: 0.93rem;
        }

        .fkc-faq__body {
            padding: 0 20px 20px;
        }
    }
</style>

<div class="fkc-contact">

    <!-- ── HERO ── -->
    <section class="fkc-hero">
        <div class="fkc-hero__watermark" aria-hidden="true">CONTACT</div>
        <div class="container fkc-hero__inner">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="fkc-hero__eyebrow">We're here to help</span>
                    <h1 class="fkc-hero__heading">
                        Let's <em>talk</em><br>fitness.
                    </h1>
                    <p class="fkc-hero__sub">
                        Questions about booking, trainers, or your fitness journey? Drop us a message — we respond within 24 hours.
                    </p>
                </div>
                <div class="col-lg-5">
                    <div class="fkc-hero__visual">
                        <div class="fkc-hero__ring">
                            <span class="fkc-orbit-dot"></span>
                            <span class="fkc-orbit-dot"></span>
                            <span class="fkc-orbit-dot"></span>
                            <i class="fas fa-comments fkc-hero__ring-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ── INFO CARDS ── -->
    <section class="fkc-infostrip">
        <div class="container">
            <div class="fkc-infostrip__grid">

                <div class="fkc-info-card">
                    <div class="fkc-info-card__icon">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                    </div>
                    <div class="fkc-info-card__title">Call Us</div>
                    <div class="fkc-info-card__main">+91 8208894229</div>
                    <div class="fkc-info-card__sub">Mon – Sat: 8 AM – 8 PM</div>
                </div>

                <div class="fkc-info-card">
                    <div class="fkc-info-card__icon">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </div>
                    <div class="fkc-info-card__title">Email Us</div>
                    <div class="fkc-info-card__main">info@fitcket.com</div>
                    <div class="fkc-info-card__sub">Reply within 24 hours</div>
                </div>

                <div class="fkc-info-card">
                    <div class="fkc-info-card__icon">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                    </div>
                    <div class="fkc-info-card__title">Visit Us</div>
                    <div class="fkc-info-card__main">617, Kud Savre Wadi</div>
                    <div class="fkc-info-card__sub">Vangani (West), Ambernath,<br>Thane, Maharashtra – 421503</div>
                </div>

                <div class="fkc-info-card">
                    <div class="fkc-info-card__icon">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                    </div>
                    <div class="fkc-info-card__title">Support Hours</div>
                    <div class="fkc-info-card__main">24 / 7 Online</div>
                    <div class="fkc-info-card__sub">Always here to help you</div>
                </div>

            </div>
        </div>
    </section>


    <!-- ── FORM + MAP ── -->
    <section class="fkc-main">
        <div class="container">
            <div class="row g-5">

                <!-- Contact Form -->
                <div class="col-lg-6">
                    <div class="fkc-form-card">
                        <span class="fkc-label">Send a Message</span>
                        <h2 class="fkc-heading">We'd love to<br><em>hear from you</em></h2>

                        <form id="fkcContactForm" novalidate style="margin-top: 36px; position: relative; z-index: 1;">

                            <div class="fkc-field-row">
                                <div class="fkc-field">
                                    <label for="fkc_firstName">First Name <span style="color:var(--primary-color)">*</span></label>
                                    <input type="text" id="fkc_firstName" name="firstname" placeholder="e.g. Rahul" required>
                                </div>
                                <div class="fkc-field">
                                    <label for="fkc_lastName">Last Name <span style="color:var(--primary-color)">*</span></label>
                                    <input type="text" id="fkc_lastName" name="lastname" placeholder="e.g. Sharma" required>
                                </div>
                            </div>

                            <div class="fkc-field-row">
                                <div class="fkc-field">
                                    <label for="fkc_email">Email <span style="color:var(--primary-color)">*</span></label>
                                    <input type="email" id="fkc_email" name="email" placeholder="you@example.com" required>
                                </div>
                                <div class="fkc-field">
                                    <label for="fkc_phone">Phone</label>
                                    <input type="tel" id="fkc_phone" name="mobile" placeholder="+91 00000 00000">
                                </div>
                            </div>

                            <div class="fkc-field">
                                <label for="fkc_subject">Subject <span style="color:var(--primary-color)">*</span></label>
                                <select id="fkc_subject" name="sub" required>
                                    <option value="">Choose a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="booking">Booking Support</option>
                                    <option value="technical">Technical Issue</option>
                                    <option value="trainer">Become a Trainer</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="fkc-field">
                                <label for="fkc_message">Message <span style="color:var(--primary-color)">*</span></label>
                                <textarea id="fkc_message" name="msg" placeholder="Tell us how we can help…" required></textarea>
                            </div>

                            <label class="fkc-checkbox">
                                <input type="checkbox" name="newsletter" id="fkc_newsletter">
                                <span>Subscribe to our newsletter for fitness tips and updates</span>
                            </label>

                            <button type="submit" class="fkc-btn-submit">
                                <i class="fas fa-paper-plane" aria-hidden="true"></i>
                                Send Message
                            </button>

                        </form>
                    </div>
                </div>

                <!-- Map + Contact Detail Rows -->
                <div class="col-lg-6">
                    <div class="fkc-map-side">

                        <div style="margin-bottom: 4px;">
                            <span class="fkc-label">Find Us</span>
                            <h2 class="fkc-heading" style="margin-bottom: 0;">We're in<br><em>Maharashtra</em></h2>
                        </div>

                        <div class="fkc-map-wrap">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60286.16906468812!2d73.12418299752905!3d19.20019984936247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7938359bbd3a5%3A0x185ca7bca88f0c9!2sAmbernath%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1758290122506!5m2!1sen!2sin"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <div class="fkc-contact-rows">
                            <div class="fkc-contact-row">
                                <div class="fkc-contact-row__icon">
                                    <i class="fas fa-phone" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <span class="fkc-contact-row__label">Phone</span>
                                    <div class="fkc-contact-row__val">+91 8208894229</div>
                                </div>
                            </div>
                            <div class="fkc-contact-row">
                                <div class="fkc-contact-row__icon">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <span class="fkc-contact-row__label">Email</span>
                                    <div class="fkc-contact-row__val">info@fitcket.com</div>
                                </div>
                            </div>
                            <div class="fkc-contact-row">
                                <div class="fkc-contact-row__icon">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <span class="fkc-contact-row__label">Address</span>
                                    <div class="fkc-contact-row__val">617, Kud Savre Wadi, Savre Road, Vangani (West), Ambernath, Thane – 421503</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ── FAQ ── -->
    <section class="fkc-faq">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-7">
                    <span class="fkc-label">FAQ</span>
                    <h2 class="fkc-heading">Common <em style="color: #b19fe8;">questions</em></h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="fkc-faq__list">

                        <div class="fkc-faq__item is-open">
                            <button class="fkc-faq__trigger" type="button" onclick="fkcToggleFaq(this)">
                                How do I book a fitness session?
                                <span class="fkc-faq__arrow"><i class="fas fa-chevron-down" aria-hidden="true"></i></span>
                            </button>
                            <div class="fkc-faq__body">
                                Browse our available trainers, select your preferred time slot, and complete the booking online. You'll receive a confirmation email with all your session details.
                            </div>
                        </div>

                        <div class="fkc-faq__item">
                            <button class="fkc-faq__trigger" type="button" onclick="fkcToggleFaq(this)">
                                What equipment do I need for online sessions?
                                <span class="fkc-faq__arrow"><i class="fas fa-chevron-down" aria-hidden="true"></i></span>
                            </button>
                            <div class="fkc-faq__body">
                                Most sessions require minimal equipment. Your trainer will share a recommended list before your session starts. Typically, just a yoga mat and water bottle are enough to get going.
                            </div>
                        </div>

                        <div class="fkc-faq__item">
                            <button class="fkc-faq__trigger" type="button" onclick="fkcToggleFaq(this)">
                                Can I cancel or reschedule my session?
                                <span class="fkc-faq__arrow"><i class="fas fa-chevron-down" aria-hidden="true"></i></span>
                            </button>
                            <div class="fkc-faq__body">
                                Yes — you can cancel or reschedule up to 24 hours before your session via your dashboard or by contacting our support team directly.
                            </div>
                        </div>

                        <div class="fkc-faq__item">
                            <button class="fkc-faq__trigger" type="button" onclick="fkcToggleFaq(this)">
                                How do I become a trainer on Fitcket?
                                <span class="fkc-faq__arrow"><i class="fas fa-chevron-down" aria-hidden="true"></i></span>
                            </button>
                            <div class="fkc-faq__body">
                                Use the contact form above and select "Become a Trainer" as your subject. Our team will review your application and get back to you within 48 hours with next steps.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>
    function fkcToggleFaq(btn) {
        var item = btn.closest('.fkc-faq__item');
        var isOpen = item.classList.contains('is-open');
        document.querySelectorAll('.fkc-faq__item.is-open').forEach(function(el) {
            el.classList.remove('is-open');
        });
        if (!isOpen) item.classList.add('is-open');
    }
</script>