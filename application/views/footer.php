<?php
$current_controller = $this->router->fetch_class();
$current_method = $this->router->fetch_method();
?>
<?php if ($current_controller === 'home' && $current_method === 'index'): ?>

    <style>
        .ft-footer {
            background: #1a1a1a;
            color: #cbd5e1;
            padding: 60px 0 0;
            margin-top: 40px;
            margin-bottom: 0 !important;
            position: relative;
            overflow: hidden;
        }

        .ft-footer::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(111, 66, 193, 0.12) 0%, transparent 70%);
            bottom: -250px;
            right: -150px;
            pointer-events: none;
        }

        .ft-footer .ft-brand h2 {
            font-size: 22px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            margin: 0 0 12px;
        }

        .ft-footer .ft-brand p {
            font-size: 14px;
            line-height: 1.7;
            color: #94a3b8;
            margin: 0 0 20px;
        }

        .ft-socials {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .ft-social-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #1e293b;
            border: 0.5px solid #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 15px;
            transition: background 0.2s, border-color 0.2s, color 0.2s;
            text-decoration: none;
        }

        .ft-social-icon:hover {
            background: #6f42c1;
            border-color: #6f42c1;
            color: #fff;
        }

        .ft-col h4 {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #1e293b;
            position: relative;
        }

        .ft-col h4::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 30px;
            height: 2px;
            background: #6f42c1;
            border-radius: 2px;
        }

        .ft-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .ft-links li {
            margin-bottom: 10px;
        }

        .ft-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s, padding-left 0.2s;
        }

        .ft-links a::before {
            content: '›';
            color: #6f42c1;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .ft-links a:hover {
            color: #f1f5f9;
            padding-left: 6px;
        }

        .ft-links a:hover::before {
            opacity: 1;
        }

        .ft-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
            font-size: 14px;
            color: #94a3b8;
        }

        .ft-contact-icon {
            width: 32px;
            height: 32px;
            min-width: 32px;
            border-radius: 8px;
            background: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #6f42c1;
        }

        .ft-contact-item span {
            line-height: 1.6;
            padding-top: 4px;
        }

        .ft-app-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #1e293b;
            border: 0.5px solid #334155;
            border-radius: 10px;
            padding: 10px 16px;
            text-decoration: none;
            transition: background 0.2s, border-color 0.2s;
            margin-bottom: 10px;
        }

        .ft-app-btn:hover {
            background: #6f42c1;
            border-color: #6f42c1;
        }

        .ft-app-btn:hover .ft-app-text-main,
        .ft-app-btn:hover .ft-app-text-sub {
            color: #fff;
        }

        .ft-app-btn img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .ft-app-text-sub {
            font-size: 11px;
            color: #64748b;
            display: block;
            line-height: 1;
            margin-bottom: 3px;
            transition: color 0.2s;
        }

        .ft-app-text-main {
            font-size: 14px;
            font-weight: 600;
            color: #e2e8f0;
            display: block;
            line-height: 1;
            transition: color 0.2s;
        }

        .ft-badge {
            display: inline-block;
            background: #6f42c1;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            margin-left: 6px;
            vertical-align: middle;
            text-transform: none;
            letter-spacing: 0;
        }

        .ft-bottom {
            border-top: 1px solid #1e293b;
            margin-top: 48px;
            padding: 20px 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ft-bottom p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
        }

        .ft-bottom-links {
            display: flex;
            gap: 20px;
        }

        .ft-bottom-links a {
            font-size: 13px;
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .ft-bottom-links a:hover {
            color: #6f42c1;
        }

        @media (max-width: 576px) {
            .ft-bottom {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .ft-bottom-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
            }
        }
    </style>

    <footer class="ft-footer">
        <div class="container">
            <div class="row g-4 g-lg-5">

                <!-- Brand & Social -->
                <div class="col-lg-3 col-md-6 ft-brand ft-col">
                    <h2>FITCKET</h2>
                    <p>Your one-stop destination to search &amp; book the best fitness trainers near you.</p>
                    <div class="ft-socials">
                        <a href="#" class="ft-social-icon" title="X / Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="ft-social-icon" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="ft-social-icon" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="ft-social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="ft-social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="ft-social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-3 col-md-6 ft-col">
                    <h4>Quick Links</h4>
                    <ul class="ft-links">
                        <li><a href="<?= base_url('about-us'); ?>">About Us</a></li>
                        <li><a href="<?= base_url('contact-us'); ?>">Contact Us</a></li>
                        <li><a href="<?= base_url('refund-policy'); ?>">Refund Policy</a></li>
                        <li><a href="<?= base_url('terms-condition'); ?>">Terms &amp; Conditions</a></li>
                        <li><a href="<?= base_url('privacy-policy'); ?>">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 ft-col">
                    <h4>Contact Info</h4>
                    <div class="ft-contact-item">
                        <div class="ft-contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <span>support@fitcket.com</span>
                    </div>
                    <div class="ft-contact-item">
                        <div class="ft-contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <span>+91 8208894229</span>
                    </div>
                    <div class="ft-contact-item">
                        <div class="ft-contact-icon"><i class="bi bi-clock-fill"></i></div>
                        <span>Mon–Sat, 09:00 – 18:00</span>
                    </div>
                    <div class="ft-contact-item">
                        <div class="ft-contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <span>617, Kud Savre Wadi, Savre Road, Vangani (West), Taluka: Ambernath, Thane, Maharashtra – 421503</span>
                    </div>
                </div>

                <!-- Download App -->
                <div class="col-lg-3 col-md-6 ft-col">
                    <h4>Download App <span class="ft-badge">Free</span></h4>
                    <p style="font-size: 13px; color: #64748b; margin: 0 0 16px;">Get the FITCKET app and book trainers on the go.</p>
                    <a href="#" class="ft-app-btn">
                        <img src="<?= base_url('assets/images/google-play_6124997.png'); ?>" alt="Google Play">
                        <div>
                            <span class="ft-app-text-sub">Get it on</span>
                            <span class="ft-app-text-main">Google Play</span>
                        </div>
                    </a>
                    <a href="#" class="ft-app-btn">
                        <img src="<?= base_url('assets/images/app-store_5977575.png'); ?>" alt="App Store">
                        <div>
                            <span class="ft-app-text-sub">Download on the</span>
                            <span class="ft-app-text-main">App Store</span>
                        </div>
                    </a>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="ft-bottom">
                <p>&copy; 2026 FITCKET. All rights reserved.</p>
                <div class="ft-bottom-links">
                    <a href="<?= base_url('privacy-policy'); ?>">Privacy</a>
                    <a href="<?= base_url('terms-condition'); ?>">Terms</a>
                    <a href="<?= base_url('refund-policy'); ?>">Refund Policy</a>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    function initSwiper(selector) {
        const root = document.querySelector(selector);
        if (!root || typeof Swiper === 'undefined') {
            return;
        }

        const totalSlides = root.querySelectorAll('.swiper-slide').length;
        if (!totalSlides) {
            return;
        }

        let config = {
            slidesPerView: 1,
            spaceBetween: 0,
            watchOverflow: true,
            observer: false,
            observeParents: false,
            observeSlideChildren: false,
            resizeObserver: false,
            preloadImages: false,
            lazy: true,
            loop: totalSlides > 1,
            autoplay: totalSlides > 1 ? {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            } : false,
            navigation: {
                nextEl: `${selector} .swiper-button-next`,
                prevEl: `${selector} .swiper-button-prev`
            },
            pagination: {
                el: `${selector} .swiper-pagination`,
                clickable: true,
                dynamicBullets: true,
                dynamicMainBullets: 3
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 12
                },
                576: {
                    slidesPerView: 1,
                    spaceBetween: 12
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 24
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        };

        new Swiper(root, config);
    }

    if (typeof Swiper !== 'undefined' && document.querySelector(".categorySwiper")) {
        new Swiper(".categorySwiper", {
            slidesPerView: 2,
            spaceBetween: 12,

            watchOverflow: true,
            observer: false,
            observeParents: false,
            observeSlideChildren: false,
            resizeObserver: false,
            preloadImages: false,
            lazy: true,

            navigation: {
                nextEl: ".categorySwiper .swiper-button-next",
                prevEl: ".categorySwiper .swiper-button-prev"
            },

            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                992: {
                    slidesPerView: 4
                },
                1200: {
                    slidesPerView: 5
                }
            }
        });
    }

    initSwiper(".nearestSwiper");
    initSwiper(".gymSwiper");
    initSwiper(".trainerSwiper");

    const site_url = "<?= base_url(); ?>";

    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumber = entry.target.querySelector('.stat-number');
                    if (statNumber && !statNumber.classList.contains('animated')) {
                        animateNumber(statNumber);
                        statNumber.classList.add('animated');
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-card').forEach(card => observer.observe(card));

        function animateNumber(element) {
            const finalNumber = element.textContent;
            if (!isNaN(parseInt(finalNumber))) {
                const target = parseInt(finalNumber);
                let current = 0;
                const increment = target / 30;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = finalNumber;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current) + '+';
                    }
                }, 50);
            }
        }

        document.querySelectorAll('.content-editable').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.cursor = 'pointer';
            });
        });
    });
</script>

<script src="<?= base_url('assets/js/user/custom.js') ?>?v=<?= time() ?>"></script>

</body>

</html>
