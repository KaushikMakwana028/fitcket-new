<style>

    :root {

        --primary-color: #6f42c1;

        --secondary-color: #1a1a1a;

        --accent-color: #8e44ad;

        --text-dark: #2d3436;

        --bg-light: #f8f9fa;

    }



    body {

        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        line-height: 1.6;

        color: var(--text-dark);

        background: var(--bg-light);

    }



    .hero-section {

        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));

        color: white;

        padding: 80px 0 60px;

    }



    .section-title {

        color: var(--secondary-color);

        font-weight: 700;

        margin-bottom: 3rem;

        position: relative;

    }



    .section-title::after {

        content: '';

        width: 80px;

        height: 4px;

        background: var(--primary-color);

        position: absolute;

        bottom: -10px;

        left: 50%;

        transform: translateX(-50%);

    }



    .contact-card {

        background: white;

        border-radius: 15px;

        padding: 2.5rem;

        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

        transition: transform 0.3s ease, box-shadow 0.3s ease;

        height: 100%;

        border: none;

        position: relative;

        overflow: hidden;

    }



    .contact-card::before {

        content: '';

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

        height: 4px;

        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));

    }



    .contact-card:hover {

        transform: translateY(-5px);

        box-shadow: 0 25px 50px rgba(111, 66, 193, 0.15);

    }



    .contact-icon {

        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));

        color: white;

        width: 70px;

        height: 70px;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 1.5rem;

        margin-bottom: 1.5rem;

        margin: 0 auto 1.5rem;

    }



    .form-control {

        border: 2px solid #e9ecef;

        border-radius: 10px;

        padding: 12px 15px;

        font-size: 1rem;

        transition: all 0.3s ease;

    }



    .form-control:focus {

        border-color: var(--primary-color);

        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.15);

    }



    .form-label {

        font-weight: 600;

        color: var(--secondary-color);

        margin-bottom: 8px;

    }



    .btn-primary-custom {

        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));

        border: none;

        padding: 15px 40px;

        border-radius: 50px;

        font-weight: 600;

        font-size: 1.1rem;

        transition: all 0.3s ease;

        color: white;

        text-transform: uppercase;

        letter-spacing: 1px;

    }



    .btn-primary-custom:hover {

        transform: translateY(-3px);

        box-shadow: 0 15px 30px rgba(111, 66, 193, 0.4);

        background: linear-gradient(45deg, var(--accent-color), var(--primary-color));

    }



    .contact-info-item {

        padding: 1.5rem;

        background: white;

        border-radius: 10px;

        margin-bottom: 1rem;

        display: flex;

        align-items: center;

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);

        transition: all 0.3s ease;

    }



    .contact-info-item:hover {

        transform: translateX(5px);

        box-shadow: 0 8px 25px rgba(111, 66, 193, 0.15);

    }



    .contact-info-icon {

        background: linear-gradient(45deg, var(--primary-color), var(--accent-color));

        color: white;

        width: 50px;

        height: 50px;

        border-radius: 10px;

        display: flex;

        align-items: center;

        justify-content: center;

        margin-right: 1rem;

        flex-shrink: 0;

    }



    .map-container {

        position: relative;

        height: 400px;

        border-radius: 15px;

        overflow: hidden;

        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);

    }



    .map-placeholder {

        width: 100%;

        height: 100%;

        background: linear-gradient(45deg, #e9ecef, #dee2e6);

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 1.2rem;

        color: var(--text-dark);

        position: relative;

    }



    .map-placeholder::after {

        content: '';

        position: absolute;

        top: 0;

        left: 0;

        width: 100%;

        height: 100%;

        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="3" fill="%236f42c1"/></svg>') center/20px no-repeat;

    }



    .office-hours {

        background: white;

        border-radius: 15px;

        padding: 2rem;

        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);

    }



    .hours-item {

        display: flex;

        justify-content: space-between;

        padding: 10px 0;

        border-bottom: 1px solid #f1f3f4;

    }



    .hours-item:last-child {

        border-bottom: none;

    }



    .hours-day {

        font-weight: 600;

        color: var(--secondary-color);

    }



    .hours-time {

        color: var(--primary-color);

        font-weight: 500;

    }



    .contact-hero-icon {

        font-size: 6rem;

        opacity: 0.3;

        color: rgba(255, 255, 255, 0.3);

    }



    @media (max-width: 768px) {

        .hero-section {

            padding: 60px 0 40px;

        }



        .contact-card {

            padding: 2rem;

            margin-bottom: 2rem;

        }



        .section-title::after {

            left: 0;

            transform: none;

        }



        .map-container {

            height: 300px;

        }



        .contact-info-item {

            flex-direction: column;

            text-align: center;

        }



        .contact-info-icon {

            margin-right: 0;

            margin-bottom: 1rem;

        }

    }



    .form-floating {

        position: relative;

    }



    .form-floating>.form-control {

        height: calc(3.5rem + 2px);

        padding: 1rem 0.75rem;

    }



    .form-floating>textarea.form-control {

        height: auto;

        min-height: 120px;

    }



    .form-floating>label {

        position: absolute;

        top: 0;

        left: 0;

        height: 100%;

        padding: 1rem 0.75rem;

        pointer-events: none;

        border: 1px solid transparent;

        transform-origin: 0 0;

        transition: opacity 0.1s ease-in-out, transform 0.1s ease-in-out;

    }

</style>

<!-- Hero Section -->

<section class="hero-section">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>

                <p class="lead mb-4">Ready to start your fitness journey? Have questions about our services? We're here

                    to help! Reach out to us through any of the methods below.</p>

            </div>

            <div class="col-lg-6">

                <div class="text-center">

                    <i class="fas fa-comments contact-hero-icon"></i>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- Contact Information Cards -->

<section class="py-5">

    <div class="container">

        <div class="row g-4 mb-5">

            <div class="col-md-6 col-lg-3">

                <div class="contact-card text-center">

                    <div class="contact-icon">

                        <i class="fas fa-phone"></i>

                    </div>

                    <h4 class="mb-3">Call Us</h4>

                    <p class="mb-2"><strong>+91 8208894229</strong></p>

                    <p class="text-muted small">Mon - Sat: 8AM - 8PM</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="contact-card text-center">

                    <div class="contact-icon">

                        <i class="fas fa-envelope"></i>

                    </div>

                    <h4 class="mb-3">Email Us</h4>

                    <p class="mb-2"><strong>info@fitcket.com</strong></p>

                    <p class="text-muted small">We'll respond within 24 hours</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="contact-card text-center">

                    <div class="contact-icon">

                        <i class="fas fa-map-marker-alt"></i>

                    </div>

                    <h4 class="mb-3">Visit Us</h4>

                    <p class="mb-2"><strong>617, Kud Savre Wadi, </strong></p>

                    <p class="text-muted small">Savre Road, Vangani (West),
Taluka: Ambernath, District: Thane,
Maharashtra – 421503</p>

                </div>

            </div>

            <div class="col-md-6 col-lg-3">

                <div class="contact-card text-center">

                    <div class="contact-icon">

                        <i class="fas fa-clock"></i>

                    </div>

                    <h4 class="mb-3">Support Hours</h4>

                    <p class="mb-2"><strong>24/7 Online</strong></p>

                    <p class="text-muted small">Always here to help</p>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- Main Contact Section -->

<section class="py-5">

    <div class="container">

       <div class="row g-5">

    <!-- Contact Form -->

    <div class="col-lg-6">

        <div class="contact-card p-4 shadow-sm rounded bg-white h-100">

            <h2 class="section-title mb-4">Send us a Message</h2>

            <form id="contactForm" novalidate>

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="form-floating">

                            <input type="text" class="form-control" id="firstName" name="firstname" placeholder="First Name" required>

                            <label for="firstName">First Name *</label>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-floating">

                            <input type="text" class="form-control" id="lastName" name="lastname" placeholder="Last Name" required>

                            <label for="lastName">Last Name *</label>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-floating">

                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>

                            <label for="email">Email Address *</label>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-floating">

                            <input type="tel" class="form-control" id="phone" name="mobile" placeholder="Phone Number" required>

                            <label for="phone">Phone Number</label>

                        </div>

                    </div>

                    <div class="col-12">

                        <div class="form-floating">

                            <select class="form-control" id="subject" name="sub" required>

                                <option value="">Choose a subject</option>

                                <option value="general">General Inquiry</option>

                                <option value="booking">Booking Support</option>

                                <option value="technical">Technical Issue</option>

                                <option value="trainer">Become a Trainer</option>

                                <option value="partnership">Partnership</option>
                                <option value="partnership">Other</option>


                            </select>

                            <label for="subject">Subject *</label>

                        </div>

                    </div>

                    <div class="col-12">

                        <div class="form-floating">

                            <textarea class="form-control" id="message" name="msg" placeholder="Your Message" style="min-height: 120px;" required></textarea>

                            <label for="message">Your Message *</label>

                        </div>

                    </div>

                    <div class="col-12">

                        <div class="form-check mb-3">

                            <input class="form-check-input" type="checkbox" name="" id="newsletter">

                            <label class="form-check-label" for="newsletter">

                                Subscribe to our newsletter for fitness tips and updates

                            </label>

                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100">

                            <i class="fas fa-paper-plane me-2"></i>Send Message

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>



    <!-- Map Section -->

    <div class="col-lg-6">

        <div class="shadow-sm rounded overflow-hidden h-100">

            <h2 class="section-title text-center mb-4">Find Us</h2>

            <div class="map-container" style="width:100%;height:400px;">

                <iframe

                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60286.16906468812!2d73.12418299752905!3d19.20019984936247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7938359bbd3a5%3A0x185ca7bca88f0c9!2sAmbernath%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1758290122506!5m2!1sen!2sin"

                    style="border:0;width:100%;height:100%;" allowfullscreen="" loading="lazy"

                    referrerpolicy="no-referrer-when-downgrade">

                </iframe>

            </div>

        </div>

    </div>

</div>



<style>

@media (max-width: 991px) {

    .contact-card { margin-bottom: 2rem; }

    .map-container { height: 300px; }

}

</style>



    </div>

</section>







<!-- FAQ Section -->

<section class="py-5 bg-white">

    <div class="container">

        <h2 class="section-title text-center">Frequently Asked Questions</h2>

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item border-0 mb-3"

                        style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">

                        <h2 class="accordion-header">

                            <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                data-bs-target="#faq1">

                                How do I book a fitness session?

                            </button>

                        </h2>

                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">

                            <div class="accordion-body">

                                Simply browse our available trainers, select your preferred time slot, and complete the

                                booking process online. You'll receive confirmation via email with session details.

                            </div>

                        </div>

                    </div>

                    <div class="accordion-item border-0 mb-3"

                        style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">

                        <h2 class="accordion-header">

                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                                data-bs-target="#faq2">

                                What equipment do I need for online sessions?

                            </button>

                        </h2>

                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                            <div class="accordion-body">

                                Most sessions require minimal equipment. Your trainer will provide a list of recommended

                                items before your session. Basic items include a yoga mat and water bottle.

                            </div>

                        </div>

                    </div>

                    <div class="accordion-item border-0 mb-3"

                        style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08);">

                        <h2 class="accordion-header">

                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"

                                data-bs-target="#faq3">

                                Can I cancel or reschedule my session?

                            </button>

                        </h2>

                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">

                            <div class="accordion-body">

                                Yes, you can cancel or reschedule up to 24 hours before your session through your

                                dashboard or by contacting support.

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>