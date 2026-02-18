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
  }

  .hero-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 80px 0;
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

  .feature-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    border: none;
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .feature-icon {
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
  }

  .stats-section {
    background: var(--bg-light);
    padding: 80px 0;
  }

  .stat-card {
    text-align: center;
    padding: 2rem 1rem;
  }

  .stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    display: block;
  }

  .stat-label {
    color: var(--text-dark);
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.9rem;
  }

  .team-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
  }

  .team-card:hover {
    transform: translateY(-5px);
  }

  .team-image {
    height: 250px;
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 4rem;
  }

  .cta-section {
    background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
    color: white;
    padding: 80px 0;
  }

  .btn-primary-custom {
    background: var(--primary-color);
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary-custom:hover {
    background: var(--accent-color);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .content-editable {
    min-height: 100px;
    padding: 20px;
    border: 2px dashed transparent;
    transition: border-color 0.3s ease;
  }

  .content-editable:hover {
    border-color: var(--primary-color);
    background: rgba(111, 66, 193, 0.05);
  }

  @media (max-width: 768px) {
    .hero-section {
      padding: 60px 0;
    }

    .section-title::after {
      left: 0;
      transform: none;
    }

    .stat-number {
      font-size: 2.5rem;
    }
  }
</style>
<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="content-editable">
          <h1 class="display-4 fw-bold mb-4">About Fitcket</h1>
          <p class="lead mb-4">Your premier destination for online fitness services, connecting you with professional
            trainers for dance, Zumba, yoga, and personalized gym sessions from the comfort of your home.</p>
          <button class="btn btn-primary-custom btn-lg">
            <i class="fas fa-play me-2"></i>Start Your Journey
          </button>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="text-center">
          <i class="fas fa-dumbbell" style="font-size: 8rem; opacity: 0.3; color: rgba(255,255,255,0.3);"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission Section -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="section-title text-center">Our Mission</h2>
        <div class="content-editable">
          <p class="lead text-center">At Fitcket, we believe fitness should be accessible, convenient, and enjoyable for
            everyone. Our platform bridges the gap between professional fitness expertise and your busy lifestyle,
            bringing world-class trainers directly to your screen.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center">Why Choose Fitcket</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto">
            <i class="fas fa-calendar-check"></i>
          </div>
          <div class="content-editable">
            <h4>Easy Booking</h4>
            <p>Book your favorite classes with just a few clicks. Choose your time, trainer, and fitness style.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto">
            <i class="fas fa-users"></i>
          </div>
          <div class="content-editable">
            <h4>Expert Trainers</h4>
            <p>Certified professionals specializing in dance, Zumba, yoga, and personalized fitness training.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto">
            <i class="fas fa-home"></i>
          </div>
          <div class="content-editable">
            <h4>Train From Home</h4>
            <p>No commute, no crowds. Enjoy professional fitness guidance from your living room.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center">
          <div class="feature-icon mx-auto">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <div class="content-editable">
            <h4>Mobile Friendly</h4>
            <p>Access your workouts on any device. Train anywhere, anytime with our responsive platform.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
  <div class="container">
    <div class="row">
      <div class="col-6 col-md-3">
        <div class="stat-card content-editable">
          <span class="stat-number">500+</span>
          <span class="stat-label">Happy Members</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card content-editable">
          <span class="stat-number">50+</span>
          <span class="stat-label">Expert Trainers</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card content-editable">
          <span class="stat-number">15+</span>
          <span class="stat-label">Workout Types</span>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card content-editable">
          <span class="stat-number">24/7</span>
          <span class="stat-label">Support</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Services Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center">Our Services</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-music"></i>
          </div>
          <div class="content-editable">
            <h4>Dance & Zumba</h4>
            <p>High-energy dance workouts that combine fitness with fun. From Bollywood to Hip-hop, salsa to
              contemporary.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-leaf"></i>
          </div>
          <div class="content-editable">
            <h4>Yoga & Meditation</h4>
            <p>Find your inner peace with guided yoga sessions and meditation practices for all skill levels.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="fas fa-dumbbell"></i>
          </div>
          <div class="content-editable">
            <h4>Personal Training</h4>
            <p>One-on-one sessions tailored to your fitness goals with certified personal trainers.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Company Story Section -->
<section class="py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="content-editable">
          <h2 class="section-title">Our Story</h2>
          <p class="lead">Founded in 2023, Fitcket emerged from a simple idea: making professional fitness training
            accessible to everyone, everywhere.</p>
          <p>During the global shift towards remote work and digital lifestyles, we recognized the need for a platform
            that could deliver authentic, personalized fitness experiences without the constraints of physical location
            or rigid schedules.</p>
          <p>Today, we're proud to serve hundreds of fitness enthusiasts across the globe, connecting them with
            certified trainers and creating a community that celebrates health, wellness, and the joy of movement.</p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="text-center">
          <i class="fas fa-heart" style="font-size: 8rem; color: var(--primary-color); opacity: 0.7;"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8">
        <div class="content-editable">
          <h2 class="display-5 fw-bold mb-4">Ready to Start Your Fitness Journey?</h2>
          <p class="lead mb-4">Join thousands of satisfied members who have transformed their lives with Fitcket. Book
            your first session today and discover the difference professional guidance makes.</p>
          <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="<?= base_url('providers');?>" class="btn btn-light btn-lg px-4">
              <i class="fas fa-calendar me-2"></i>Book Now
            </a>
            <a href="<?= base_url('contact-us');?>" class="btn btn-outline-light btn-lg px-4">
              <i class="fas fa-phone me-2"></i>Contact Us
            </a>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>