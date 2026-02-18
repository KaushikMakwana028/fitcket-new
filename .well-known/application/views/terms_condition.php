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
        margin: 0;
        padding: 0;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 80px 15px 60px;
        text-align: center;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .hero-section p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }

    .terms-section {
        padding: 60px 20px;
        max-width: 900px;
        margin: auto;
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .terms-section h2 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .terms-section h3 {
        color: var(--secondary-color);
        font-weight: 600;
        margin-top: 2rem;
        font-size: 1.3rem;
    }

    .terms-section p,
    .terms-section li {
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .terms-section ul {
        padding-left: 1.2rem;
        margin-bottom: 1rem;
    }

    .last-updated {
        text-align: center;
        font-size: 0.9rem;
        color: gray;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2rem;
        }
        .terms-section {
            padding: 40px 15px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <h1><?= ucfirst($page_data->title); ?></h1>
    <p>Welcome to Fitcket – your trusted platform for booking gyms and hiring trainers online. Please read carefully.</p>
</section>

<!-- Terms Content -->
<section class="terms-section">
    <?= htmlspecialchars_decode($page_data->content); ?>
    <div class="last-updated">
        Last updated: <?= date("F d, Y", strtotime($page_data->updated_at)); ?>
    </div>
</section>
