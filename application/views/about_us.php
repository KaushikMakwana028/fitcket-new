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

  /* ── Scoped wrapper ── */
  .fitket-about {
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    overflow-x: hidden;
    line-height: 1.6;
  }

  .fitket-about *,
  .fitket-about *::before,
  .fitket-about *::after {
    box-sizing: border-box;
  }

  .fitket-about input,
  .fitket-about button,
  .fitket-about select,
  .fitket-about textarea {
    font-family: 'Poppins', sans-serif;
  }

  .fitket-about *:focus-visible {
    outline: 2px solid var(--accent-color);
    outline-offset: 2px;
  }

  /* ══════════════════════════════════════════
     HERO
  ══════════════════════════════════════════ */
  .fka-hero {
    position: relative;
    background: var(--secondary-color);
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    padding: 120px 0 80px;
  }

  /* Giant watermark text */
  .fka-hero__watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: clamp(100px, 22vw, 260px);
    font-weight: 900;
    letter-spacing: -0.04em;
    color: transparent;
    -webkit-text-stroke: 1px rgba(111, 66, 193, 0.18);
    white-space: nowrap;
    pointer-events: none;
    user-select: none;
    line-height: 1;
  }

  /* Diagonal accent line */
  .fka-hero::before {
    content: '';
    position: absolute;
    width: 2px;
    height: 140%;
    background: linear-gradient(180deg, transparent, rgba(111, 66, 193, 0.6), transparent);
    top: -20%;
    left: 60%;
    transform: rotate(20deg);
  }

  /* Purple glow blob */
  .fka-hero::after {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(111, 66, 193, 0.25) 0%, transparent 70%);
    top: -100px;
    right: -200px;
    pointer-events: none;
  }

  .fka-hero__inner {
    position: relative;
    z-index: 2;
  }

  .fka-hero__eyebrow {
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

  .fka-hero__eyebrow::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--primary-color);
    animation: fka-pulse 1.8s ease-in-out infinite;
  }

  @keyframes fka-pulse {

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

  .fka-hero__heading {
    font-size: clamp(2.8rem, 7vw, 5.5rem);
    font-weight: 900;
    line-height: 1.05;
    color: var(--white);
    letter-spacing: -0.03em;
    margin-bottom: 24px;
  }

  .fka-hero__heading em {
    font-style: normal;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .fka-hero__sub {
    font-size: clamp(1rem, 1.8vw, 1.2rem);
    color: rgba(255, 255, 255, 0.6);
    font-weight: 300;
    max-width: 500px;
    margin-bottom: 44px;
    line-height: 1.8;
  }

  .fka-hero__actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
  }

  .fka-btn-primary {
    background: var(--primary-color);
    color: var(--white);
    border: none;
    padding: 14px 32px;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .fka-btn-primary:hover {
    background: var(--accent-color);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 16px 32px rgba(111, 66, 193, 0.45);
    text-decoration: none;
  }

  .fka-btn-ghost {
    background: transparent;
    color: rgba(255, 255, 255, 0.75);
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    padding: 14px 32px;
    border-radius: var(--radius-pill);
    font-weight: 600;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: all 0.25s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .fka-btn-ghost:hover {
    border-color: rgba(255, 255, 255, 0.6);
    color: var(--white);
    background: rgba(255, 255, 255, 0.06);
    text-decoration: none;
  }

  /* Floating stat pills */
  .fka-hero__stats {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 56px;
    padding-top: 40px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
  }

  .fka-hero__stat {
    display: flex;
    flex-direction: column;
    padding-right: 32px;
  }

  .fka-hero__stat+.fka-hero__stat {
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    padding-left: 32px;
    padding-right: 32px;
  }

  .fka-hero__stat-num {
    font-size: 2rem;
    font-weight: 800;
    color: var(--white);
    line-height: 1;
    letter-spacing: -0.02em;
  }

  .fka-hero__stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.45);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-top: 4px;
  }

  /* Visual side */
  .fka-hero__visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .fka-hero__ring {
    width: clamp(280px, 40vw, 460px);
    height: clamp(280px, 40vw, 460px);
    border-radius: 50%;
    border: 1px solid rgba(111, 66, 193, 0.25);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .fka-hero__ring::before {
    content: '';
    position: absolute;
    inset: 20px;
    border-radius: 50%;
    border: 1px solid rgba(111, 66, 193, 0.15);
  }

  .fka-hero__ring::after {
    content: '';
    position: absolute;
    inset: 50px;
    border-radius: 50%;
    border: 1px solid rgba(111, 66, 193, 0.1);
  }

  .fka-hero__ring-icon {
    font-size: clamp(5rem, 12vw, 9rem);
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0.85;
    position: relative;
    z-index: 1;
  }

  /* Orbit dots */
  .fka-orbit-dot {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary-color);
  }

  .fka-orbit-dot:nth-child(1) {
    top: -5px;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0.9;
  }

  .fka-orbit-dot:nth-child(2) {
    bottom: 15%;
    right: -5px;
    opacity: 0.6;
  }

  .fka-orbit-dot:nth-child(3) {
    bottom: -5px;
    left: 30%;
    opacity: 0.4;
  }


  /* ══════════════════════════════════════════
     MISSION — angled ribbon
  ══════════════════════════════════════════ */
  .fka-mission {
    background: var(--bg-light);
    padding: 100px 0;
    position: relative;
  }

  .fka-mission::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: var(--secondary-color);
    clip-path: polygon(0 0, 100% 0, 100% 60%, 0 100%);
  }

  .fka-label {
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

  .fka-section-heading {
    font-size: clamp(1.8rem, 3.5vw, 3rem);
    font-weight: 800;
    color: var(--secondary-color);
    line-height: 1.15;
    letter-spacing: -0.025em;
  }

  .fka-section-heading em {
    font-style: normal;
    color: var(--primary-color);
  }

  .fka-mission__text {
    font-size: clamp(1rem, 1.6vw, 1.15rem);
    color: var(--text-muted);
    line-height: 1.9;
  }

  .fka-mission__highlight {
    background: var(--white);
    border-left: 4px solid var(--primary-color);
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
    padding: 24px 28px;
    margin-top: 28px;
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 1.05rem;
  }


  /* ══════════════════════════════════════════
     BENTO FEATURES
  ══════════════════════════════════════════ */
  .fka-features {
    padding: 100px 0;
    background: var(--white);
  }

  .fka-bento {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: auto;
    gap: 20px;
    margin-top: 60px;
  }

  .fka-bento__card {
    background: var(--bg-light);
    border-radius: var(--radius-xl);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease;
  }

  .fka-bento__card:hover {
    transform: translateY(-6px);
  }

  /* Card layout placements */
  .fka-bento__card--a {
    grid-column: span 5;
  }

  .fka-bento__card--b {
    grid-column: span 7;
    background: var(--secondary-color);
    color: var(--white);
  }

  .fka-bento__card--c {
    grid-column: span 4;
  }

  .fka-bento__card--d {
    grid-column: span 4;
  }

  .fka-bento__card--e {
    grid-column: span 4;
  }

  /* Card icon */
  .fka-bento__icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--white);
    margin-bottom: 20px;
  }

  .fka-bento__card--b .fka-bento__icon {
    background: rgba(111, 66, 193, 0.3);
  }

  .fka-bento__title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--secondary-color);
    margin-bottom: 10px;
  }

  .fka-bento__card--b .fka-bento__title {
    color: var(--white);
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
  }

  .fka-bento__desc {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
  }

  .fka-bento__card--b .fka-bento__desc {
    color: rgba(255, 255, 255, 0.6);
    font-size: 1rem;
    margin-top: 12px;
  }

  /* Big number on dark card */
  .fka-bento__bignum {
    font-size: 5rem;
    font-weight: 900;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    letter-spacing: -0.04em;
    margin-top: 16px;
  }

  /* Corner decoration */
  .fka-bento__card--b::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(111, 66, 193, 0.12);
    bottom: -60px;
    right: -40px;
  }


  /* ══════════════════════════════════════════
     SERVICES — tabbed cards with numbers
  ══════════════════════════════════════════ */
  .fka-services {
    padding: 100px 0;
    background: var(--secondary-color);
    position: relative;
    overflow: hidden;
  }

  .fka-services::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(111, 66, 193, 0.2) 0%, transparent 70%);
    bottom: -200px;
    left: -100px;
  }

  .fka-services .fka-label {
    color: #b19fe8;
    background: rgba(111, 66, 193, 0.2);
  }

  .fka-services .fka-section-heading {
    color: var(--white);
  }

  .fka-services__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 60px;
  }

  .fka-service-card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-xl);
    padding: 40px 32px;
    position: relative;
    overflow: hidden;
    transition: background 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
  }

  .fka-service-card:hover {
    background: rgba(111, 66, 193, 0.12);
    border-color: rgba(111, 66, 193, 0.35);
    transform: translateY(-6px);
  }

  .fka-service-card__num {
    font-size: 5rem;
    font-weight: 900;
    color: rgba(255, 255, 255, 0.04);
    position: absolute;
    top: 16px;
    right: 24px;
    line-height: 1;
    letter-spacing: -0.04em;
    pointer-events: none;
    user-select: none;
    transition: color 0.3s ease;
  }

  .fka-service-card:hover .fka-service-card__num {
    color: rgba(111, 66, 193, 0.15);
  }

  .fka-service-card__icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: rgba(111, 66, 193, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #b19fe8;
    margin-bottom: 24px;
    transition: background 0.3s;
  }

  .fka-service-card:hover .fka-service-card__icon {
    background: var(--primary-color);
    color: var(--white);
  }

  .fka-service-card__title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--white);
    margin-bottom: 12px;
  }

  .fka-service-card__desc {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.5);
    line-height: 1.8;
  }

  .fka-service-card:hover .fka-service-card__desc {
    color: rgba(255, 255, 255, 0.7);
  }

  /* ══════════════════════════════════════════
     STORY SECTION
  ══════════════════════════════════════════ */
  .fka-story {
    padding: 100px 0;
    background: var(--white);
  }

  .fka-story__timeline {
    position: relative;
    padding-left: 32px;
    margin-top: 48px;
  }

  .fka-story__timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 6px;
    bottom: 6px;
    width: 2px;
    background: linear-gradient(180deg, var(--primary-color), rgba(111, 66, 193, 0.1));
  }

  .fka-story__item {
    position: relative;
    margin-bottom: 40px;
    padding-left: 28px;
  }

  .fka-story__item::before {
    content: '';
    position: absolute;
    left: -25px;
    top: 7px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--primary-color);
    border: 2px solid var(--white);
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.2);
  }

  .fka-story__year {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--primary-color);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 6px;
  }

  .fka-story__item-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--secondary-color);
    margin-bottom: 6px;
  }

  .fka-story__item-text {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.7;
  }

  /* Right side — big visual card */
  .fka-story__visual-card {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
    border-radius: var(--radius-xl);
    padding: 60px 40px;
    color: var(--white);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .fka-story__visual-card::before {
    content: '';
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    bottom: -80px;
    right: -80px;
  }

  .fka-story__visual-card::after {
    content: '';
    position: absolute;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    top: -40px;
    left: -40px;
  }

  .fka-story__card-icon {
    font-size: 4rem;
    opacity: 0.4;
    margin-bottom: 32px;
    position: relative;
    z-index: 1;
  }

  .fka-story__card-heading {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.02em;
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
  }

  .fka-story__card-text {
    font-size: 0.95rem;
    opacity: 0.78;
    line-height: 1.8;
    position: relative;
    z-index: 1;
  }

  /* Achievements row */
  .fka-story__achievements {
    display: flex;
    gap: 0;
    margin-top: 36px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 32px;
    position: relative;
    z-index: 1;
  }

  .fka-story__achievement {
    flex: 1;
    text-align: center;
  }

  .fka-story__achievement+.fka-story__achievement {
    border-left: 1px solid rgba(255, 255, 255, 0.15);
  }

  .fka-story__achievement-num {
    display: block;
    font-size: 1.8rem;
    font-weight: 800;
    letter-spacing: -0.02em;
  }

  .fka-story__achievement-label {
    font-size: 0.7rem;
    opacity: 0.6;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 2px;
    display: block;
  }


  /* ══════════════════════════════════════════
     STATS BAND
  ══════════════════════════════════════════ */
  .fka-statsband {
    background: var(--bg-light);
    padding: 80px 0;
    position: relative;
  }

  .fka-statsband__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
  }

  .fka-statsband__item {
    text-align: center;
    padding: 32px 20px;
    position: relative;
  }

  .fka-statsband__item+.fka-statsband__item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: rgba(111, 66, 193, 0.15);
  }

  .fka-statsband__num {
    display: block;
    font-size: clamp(2.4rem, 5vw, 3.6rem);
    font-weight: 900;
    letter-spacing: -0.04em;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 8px;
  }

  .fka-statsband__label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-muted);
  }


  /* ══════════════════════════════════════════
     CTA SECTION
  ══════════════════════════════════════════ */
  .fka-cta {
    padding: 120px 0;
    background: var(--secondary-color);
    position: relative;
    overflow: hidden;
  }

  /* Diagonal lines background */
  .fka-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(-45deg,
        transparent,
        transparent 30px,
        rgba(111, 66, 193, 0.04) 30px,
        rgba(111, 66, 193, 0.04) 31px);
  }

  .fka-cta::after {
    content: '';
    position: absolute;
    width: 700px;
    height: 700px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(111, 66, 193, 0.22) 0%, transparent 65%);
    top: -200px;
    right: -200px;
  }

  .fka-cta__inner {
    position: relative;
    z-index: 2;
    text-align: center;
  }

  .fka-cta__heading {
    font-size: clamp(2.2rem, 5.5vw, 4rem);
    font-weight: 900;
    color: var(--white);
    line-height: 1.1;
    letter-spacing: -0.03em;
    margin-bottom: 20px;
  }

  .fka-cta__heading em {
    font-style: normal;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .fka-cta__sub {
    font-size: clamp(1rem, 1.6vw, 1.15rem);
    color: rgba(255, 255, 255, 0.55);
    font-weight: 300;
    max-width: 520px;
    margin: 0 auto 48px;
    line-height: 1.8;
  }

  .fka-cta__actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .fka-btn-secondary {
    background: transparent;
    color: var(--white);
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    padding: 14px 32px;
    border-radius: var(--radius-pill);
    font-weight: 600;
    font-size: 0.95rem;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    transition: all 0.25s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .fka-btn-secondary:hover {
    border-color: rgba(255, 255, 255, 0.55);
    color: var(--white);
    background: rgba(255, 255, 255, 0.07);
    text-decoration: none;
    transform: translateY(-2px);
  }


  /* ══════════════════════════════════════════
     MOBILE RESPONSIVE
  ══════════════════════════════════════════ */
  @media (max-width: 991px) {
    .fka-hero {
      min-height: auto;
      padding: 80px 0 60px;
    }

    .fka-hero__visual {
      margin-top: 48px;
    }

    .fka-bento {
      grid-template-columns: 1fr;
    }

    .fka-bento__card--a,
    .fka-bento__card--b,
    .fka-bento__card--c,
    .fka-bento__card--d,
    .fka-bento__card--e {
      grid-column: span 1;
    }

    .fka-services__grid {
      grid-template-columns: 1fr;
    }

    .fka-statsband__grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .fka-statsband__item:nth-child(3)::before {
      display: none;
    }

    .fka-story__visual-card {
      margin-top: 40px;
    }
  }

  @media (max-width: 576px) {
    .fka-hero__stats {
      flex-direction: column;
      gap: 20px;
    }

    .fka-hero__stat+.fka-hero__stat {
      border-left: none;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-left: 0;
      padding-top: 20px;
    }

    .fka-statsband__grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .fka-bento__card {
      padding: 28px 22px;
    }
  }
</style>

<div class="fitket-about">

  <!-- ── HERO ── -->
  <section class="fka-hero">
    <div class="fka-hero__watermark" aria-hidden="true">FITCKET</div>
    <div class="container fka-hero__inner">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <span class="fka-hero__eyebrow">Est. 2023 · Online Fitness Platform</span>
          <h1 class="fka-hero__heading">
            Fitness that fits<br>
            <em>your life.</em>
          </h1>
          <p class="fka-hero__sub">
            Professional trainers. Dance, yoga, Zumba &amp; personal sessions — all from the comfort of wherever you are.
          </p>
          <div class="fka-hero__actions">
            <a href="<?= base_url('providers'); ?>" class="fka-btn-primary">
              <i class="fas fa-play" aria-hidden="true"></i> Start Your Journey
            </a>
            <a href="<?= base_url('contact-us'); ?>" class="fka-btn-ghost">
              <i class="fas fa-phone" aria-hidden="true"></i> Talk to Us
            </a>
          </div>
          <div class="fka-hero__stats">
            <div class="fka-hero__stat">
              <span class="fka-hero__stat-num">500+</span>
              <span class="fka-hero__stat-label">Happy Members</span>
            </div>
            <div class="fka-hero__stat">
              <span class="fka-hero__stat-num">50+</span>
              <span class="fka-hero__stat-label">Expert Trainers</span>
            </div>
            <div class="fka-hero__stat">
              <span class="fka-hero__stat-num">15+</span>
              <span class="fka-hero__stat-label">Workout Types</span>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="fka-hero__visual">
            <div class="fka-hero__ring">
              <span class="fka-orbit-dot"></span>
              <span class="fka-orbit-dot"></span>
              <span class="fka-orbit-dot"></span>
              <i class="fas fa-dumbbell fka-hero__ring-icon" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ── MISSION ── -->
  <section class="fka-mission">
    <div class="container" style="padding-top: 20px;">
      <div class="row align-items-center g-5">
        <div class="col-lg-5">
          <span class="fka-label">Our Mission</span>
          <h2 class="fka-section-heading">Bringing <em>world-class</em> fitness to your screen</h2>
        </div>
        <div class="col-lg-7">
          <p class="fka-mission__text">
            At Fitcket, we believe great fitness guidance shouldn't require a commute, a packed gym floor,
            or a rigid schedule. Our platform bridges professional expertise with your busy life — connecting
            you with certified trainers whenever and wherever works for you.
          </p>
          <div class="fka-mission__highlight">
            &ldquo;Accessible, convenient, and genuinely enjoyable — fitness finally on your terms.&rdquo;
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ── BENTO FEATURES ── -->
  <section class="fka-features">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-6">
          <span class="fka-label">Why Choose Fitcket</span>
          <h2 class="fka-section-heading">Everything you need,<br><em>nothing you don't</em></h2>
        </div>
        <div class="col-lg-6">
          <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.8;">
            We built Fitcket around four core promises — ease of booking, quality of trainers, flexibility of location, and accessibility on every device.
          </p>
        </div>
      </div>

      <div class="fka-bento">

        <!-- Card A — Easy Booking -->
        <div class="fka-bento__card fka-bento__card--a">
          <div class="fka-bento__icon">
            <i class="fas fa-calendar-check" aria-hidden="true"></i>
          </div>
          <h3 class="fka-bento__title">Easy Booking</h3>
          <p class="fka-bento__desc">
            Pick your trainer, choose your time, confirm in seconds. Our booking flow is designed to get out of your way so you can focus on the workout.
          </p>
        </div>

        <!-- Card B — Dark feature card -->
        <div class="fka-bento__card fka-bento__card--b">
          <div class="fka-bento__icon">
            <i class="fas fa-users" aria-hidden="true"></i>
          </div>
          <h3 class="fka-bento__title">Certified Expert Trainers</h3>
          <p class="fka-bento__desc">Every trainer on Fitcket is vetted, certified, and passionate. Dance, Zumba, yoga, strength — specialists across every discipline.</p>
          <div class="fka-bento__bignum">50+</div>
        </div>

        <!-- Card C — Home -->
        <div class="fka-bento__card fka-bento__card--c">
          <div class="fka-bento__icon">
            <i class="fas fa-home" aria-hidden="true"></i>
          </div>
          <h3 class="fka-bento__title">Train From Home</h3>
          <p class="fka-bento__desc">No commute. No crowds. Your living room becomes your personal studio.</p>
        </div>

        <!-- Card D — Mobile -->
        <div class="fka-bento__card fka-bento__card--d">
          <div class="fka-bento__icon">
            <i class="fas fa-mobile-alt" aria-hidden="true"></i>
          </div>
          <h3 class="fka-bento__title">Any Device</h3>
          <p class="fka-bento__desc">Phone, tablet, laptop — Fitcket adapts perfectly to your screen.</p>
        </div>

        <!-- Card E — Support -->
        <div class="fka-bento__card fka-bento__card--e">
          <div class="fka-bento__icon">
            <i class="fas fa-headset" aria-hidden="true"></i>
          </div>
          <h3 class="fka-bento__title">24/7 Support</h3>
          <p class="fka-bento__desc">Questions or issues? Our support team is always on — day or night.</p>
        </div>

      </div>
    </div>
  </section>


  <!-- ── SERVICES ── -->
  <section class="fka-services">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-6">
          <span class="fka-label">What We Offer</span>
          <h2 class="fka-section-heading" style="color: var(--white);">Our <em style="color: #b19fe8;">Services</em></h2>
        </div>
        <div class="col-lg-6">
          <p style="color: rgba(255,255,255,0.45); font-size: 0.95rem; line-height: 1.8;">
            From high-energy Zumba to mindful meditation, our catalogue covers every dimension of fitness and wellness.
          </p>
        </div>
      </div>

      <div class="fka-services__grid">

        <div class="fka-service-card">
          <span class="fka-service-card__num" aria-hidden="true">01</span>
          <div class="fka-service-card__icon">
            <i class="fas fa-music" aria-hidden="true"></i>
          </div>
          <h3 class="fka-service-card__title">Dance &amp; Zumba</h3>
          <p class="fka-service-card__desc">
            High-energy dance workouts blending fitness with pure fun. Bollywood to Hip-hop, salsa to contemporary — your stage, your rules.
          </p>
        </div>

        <div class="fka-service-card">
          <span class="fka-service-card__num" aria-hidden="true">02</span>
          <div class="fka-service-card__icon">
            <i class="fas fa-leaf" aria-hidden="true"></i>
          </div>
          <h3 class="fka-service-card__title">Yoga &amp; Meditation</h3>
          <p class="fka-service-card__desc">
            Guided yoga and mindfulness sessions for every skill level. Flexibility, balance, inner calm — all in one practice.
          </p>
        </div>

        <div class="fka-service-card">
          <span class="fka-service-card__num" aria-hidden="true">03</span>
          <div class="fka-service-card__icon">
            <i class="fas fa-dumbbell" aria-hidden="true"></i>
          </div>
          <h3 class="fka-service-card__title">Personal Training</h3>
          <p class="fka-service-card__desc">
            One-on-one sessions laser-focused on your goals. Your certified trainer, your programme, your pace.
          </p>
        </div>

      </div>
    </div>
  </section>


  <!-- ── STATS BAND ── -->
  <section class="fka-statsband">
    <div class="container">
      <div class="fka-statsband__grid">
        <div class="fka-statsband__item">
          <span class="fka-statsband__num">500+</span>
          <span class="fka-statsband__label">Happy Members</span>
        </div>
        <div class="fka-statsband__item">
          <span class="fka-statsband__num">50+</span>
          <span class="fka-statsband__label">Expert Trainers</span>
        </div>
        <div class="fka-statsband__item">
          <span class="fka-statsband__num">15+</span>
          <span class="fka-statsband__label">Workout Types</span>
        </div>
        <div class="fka-statsband__item">
          <span class="fka-statsband__num">24/7</span>
          <span class="fka-statsband__label">Support Available</span>
        </div>
      </div>
    </div>
  </section>


  <!-- ── STORY ── -->
  <section class="fka-story">
    <div class="container">
      <div class="row g-5 align-items-start">
        <div class="col-lg-6">
          <span class="fka-label">Our Story</span>
          <h2 class="fka-section-heading" style="margin-bottom: 0;">How Fitcket came to <em>life</em></h2>
          <div class="fka-story__timeline">
            <div class="fka-story__item">
              <div class="fka-story__year">2023 — The Idea</div>
              <div class="fka-story__item-title">A simple frustration, a bold solution</div>
              <p class="fka-story__item-text">
                Fitcket was born from one simple observation: access to quality fitness coaching shouldn't depend on geography or a fixed schedule.
              </p>
            </div>
            <div class="fka-story__item">
              <div class="fka-story__year">2023 — The Build</div>
              <div class="fka-story__item-title">Platform goes live</div>
              <p class="fka-story__item-text">
                During the global shift toward remote lifestyles, we built a platform that could deliver authentic, personalised fitness experiences without location constraints.
              </p>
            </div>
            <div class="fka-story__item">
              <div class="fka-story__year">Today</div>
              <div class="fka-story__item-title">A growing global community</div>
              <p class="fka-story__item-text">
                We're proud to serve hundreds of fitness enthusiasts worldwide — connecting them with certified trainers and celebrating health, wellness, and the joy of movement.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="fka-story__visual-card">
            <div class="fka-story__card-icon">
              <i class="fas fa-heart" aria-hidden="true"></i>
            </div>
            <h3 class="fka-story__card-heading">Built with passion.<br>Powered by purpose.</h3>
            <p class="fka-story__card-text">
              Every feature, every trainer, every session reflects our core belief: fitness should enrich your life, not complicate it.
            </p>
            <div class="fka-story__achievements">
              <div class="fka-story__achievement">
                <span class="fka-story__achievement-num">500+</span>
                <span class="fka-story__achievement-label">Members</span>
              </div>
              <div class="fka-story__achievement">
                <span class="fka-story__achievement-num">50+</span>
                <span class="fka-story__achievement-label">Trainers</span>
              </div>
              <div class="fka-story__achievement">
                <span class="fka-story__achievement-num">100%</span>
                <span class="fka-story__achievement-label">Online</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ── CTA ── -->
  <section class="fka-cta">
    <div class="container fka-cta__inner">
      <span class="fka-label" style="color: #b19fe8; background: rgba(111,66,193,0.2);">Get Started Today</span>
      <h2 class="fka-cta__heading">
        Ready to transform<br>
        <em>your fitness?</em>
      </h2>
      <p class="fka-cta__sub">
        Join hundreds of members who've already discovered what professional guidance actually feels like. Book your first session — no equipment needed.
      </p>
      <div class="fka-cta__actions">
        <a href="<?= base_url('providers'); ?>" class="fka-btn-primary">
          <i class="fas fa-calendar" aria-hidden="true"></i> Book a Session
        </a>
        <a href="<?= base_url('contact-us'); ?>" class="fka-btn-secondary">
          <i class="fas fa-phone" aria-hidden="true"></i> Contact Us
        </a>
      </div>
    </div>
  </section>

</div>