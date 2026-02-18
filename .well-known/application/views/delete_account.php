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

    .policy-section {
        padding: 60px 20px;
        max-width: 900px;
        margin: auto;
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .policy-section h2 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }

    .policy-section h3 {
        color: var(--secondary-color);
        font-weight: 600;
        margin-top: 2rem;
        font-size: 1.3rem;
    }

    .policy-section p,
    .policy-section li {
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .policy-section ul {
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
        .policy-section {
            padding: 40px 15px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <h1>Delete Your Account</h1>
    <p>We’re sorry to see you go. Follow the instructions below to permanently delete your Fitcket account.</p>
</section>

<!-- Delete Account Instructions -->
<section class="policy-section">
    <h2>How to Delete Your Fitcket Account</h2>
    <p>At Fitcket, your data privacy and control are very important to us. Currently, account deletion is available only through our mobile application for your security.</p>

    <h3>Follow these simple steps to delete your account:</h3>
    <ul>
        <li>1️⃣ Open the <strong>Fitcket App</strong> on your mobile device.</li>
        <li>2️⃣ Tap on the <strong>Profile</strong> tab from the bottom menu.</li>
        <li>3️⃣ Scroll down to the bottom of your profile page.</li>
        <li>4️⃣ You’ll find a <strong>“Delete Account”</strong> button at the end of the page.</li>
        <li>5️⃣ Tap the button and confirm your decision to permanently delete your account.</li>
    </ul>

    <h3>Important Notes:</h3>
    <ul>
        <li>⚠️ Once your account is deleted, all your data, bookings, and membership history will be permanently removed.</li>
        <li>🔒 We do not retain any of your personal information after deletion.</li>
        <li>📱 You must be logged into the Fitcket app to delete your account — it cannot be done via our website or email.</li>
    </ul>

    <p>If you face any difficulty deleting your account, you can contact our support team at 
    <a href="mailto:support@fitcket.com">support@fitcket.com</a> for further assistance.</p>

    
</section>
