<?php
$current_controller = $this->router->fetch_class();
$current_method = $this->router->fetch_method();
?>
<?php if ($current_controller === 'home' && $current_method === 'index'): ?>
    <footer class="bg-dark text-white  pb-4 mb-5">

        <div class="container">

            <div class="row">

                <!-- Logo and Description -->

                <div class="col-lg-3 col-md-6 mb-4 mt-2">

                    <h5 class="fw-bold">FITCKET</h5>

                    <p>your onestop destintion to serch & book trainer.</p>

                    <div class="d-flex gap-4">

                        <a href="#" class="text-white"><i class="bi bi-x"></i></a>

                        <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>

                        <a href="#" class="text-white"><i class="bi bi-whatsapp"></i></a>

                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>

                        <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>

                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>

                    </div>

                </div>



                <!-- Quick Links -->

                <div class="col-lg-3 col-md-6 mb-4 mt-2">

                    <h5 class="fw-bold">Quick Links</h5>

                    <ul class="list-unstyled">

                        <li><a href="<?= base_url('about-us'); ?>" class="text-white text-decoration-none">About Us</a></li>

                        <li><a href="<?= base_url('contact-us'); ?>" class="text-white text-decoration-none">Contact Us</a>
                        </li>

                        <li><a href="<?= base_url('refund-policy'); ?>"
                                class="text-white text-decoration-none">Refund-Policy</a></li>

                        <li><a href="<?= base_url('terms-condition'); ?>" class="text-white text-decoration-none">Terms &
                                Conditions</a></li>

                        <li><a href="<?= base_url('privacy-policy'); ?>" class="text-white text-decoration-none">Privacy
                                Policy</a></li>

                    </ul>

                </div>



                <!-- Contact Info -->

                <div class="col-lg-3 col-md-6 mb-4 mt-2">

                    <h5 class="fw-bold">Contact Info</h5>

                    <ul class="list-unstyled">

                        <li><i class="bi bi-envelope me-2"></i> support@fitcket.com</li>

                        <li><i class="bi bi-telephone me-2"></i> 8208894229</li>

                        <li><i class="bi bi-clock me-2"></i> 09:00 to 18:00</li>

                        <li><i class="bi bi-geo-alt me-2"></i> 617, Kud Savre Wadi, Savre Road, Vangani (West),
                            Taluka: Ambernath, District: Thane,
                            Maharashtra – 421503</li>

                    </ul>

                </div>



                <!-- Download Apps -->

                <div class="col-lg-3 col-md-6 mb-4 mt-2">

                    <h5 class="fw-bold">Download Customer Apps</h5>

                    <p>Let's Download FITCKET Mobile App Free</p>

                    <div class="d-flex gap-2">

                        <a href="#" class="btn btn-dark d-flex align-items-center px-3 py-2">

                            <img src="<?= base_url('assets/images/google-play_6124997.png'); ?>" alt="Google Play"
                                style="width: 20px; height: 20px;" class="me-2">

                            Google Play

                        </a>

                        <a href="#" class="btn btn-dark d-flex align-items-center px-3 py-2">

                            <img src="<?= base_url('assets/images/app-store_5977575.png'); ?>" alt="App Store"
                                style="width: 20px; height: 20px;" class="me-2">

                            App Store

                        </a>

                    </div>

                </div>



            </div>



            <!-- Copyright -->

            <div class="text-center mt-4 border-top mb-3">

                &copy; 2025 FITCKET. All rights reserved.

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
        const totalSlides = document.querySelectorAll(`${selector} .swiper-slide`).length;

        new Swiper(selector, {
            slidesPerView: 2, // default for smallest screens
            spaceBetween: 20,
            loop: totalSlides > 1, // loop only if more than 1 card
            autoplay: totalSlides > 1 ? {
                delay: 2500,
                disableOnInteraction: false,
            } : false,
            pagination: {
                el: `${selector} .swiper-pagination`,
                clickable: true,
            },
            grid: totalSlides > 2 ? { rows: 2, fill: "row" } : {}, // only use 2 rows if enough cards
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    grid: totalSlides > 3 ? { rows: 2 } : {},
                },
                1200: {
                    slidesPerView: 4,
                    grid: totalSlides > 4 ? { rows: 2 } : {},
                }
            }
        });
    }

    // Initialize for all sliders
    initSwiper(".categorySwiper");
    initSwiper(".nearestSwiper");
    initSwiper(".gymSwiper");
    initSwiper(".trainerSwiper");


    const site_url = "<?= base_url(); ?>";

    document.addEventListener('DOMContentLoaded', function () {

        // Animate stats when they come into view

        const observerOptions = {

            threshold: 0.5,

            rootMargin: '0px 0px -100px 0px'

        };



        const observer = new IntersectionObserver(function (entries) {

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



        document.querySelectorAll('.stat-card').forEach(card => {

            observer.observe(card);

        });



        function animateNumber(element) {

            const finalNumber = element.textContent;

            const isNumber = !isNaN(parseInt(finalNumber));



            if (isNumber) {

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



        // Add hover effects for content-editable areas (for development)

        document.querySelectorAll('.content-editable').forEach(element => {

            element.addEventListener('mouseenter', function () {

                this.style.cursor = 'pointer';

            });

        });

    });



</script>



<script src="<?= base_url('assets/js/user/custom.js') ?>?v=<?= time() ?>"></script>



</body>

</html>