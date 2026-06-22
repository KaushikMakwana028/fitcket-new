<?php if (empty($provider)): ?>
    <div class="col-12">
        <div class="fkp-empty">
            <i class="fas fa-search" aria-hidden="true"></i>
            <h5>No providers found</h5>
            <p>Try adjusting your search or filter criteria</p>
            <button class="fkp-clear-btn clear-search" type="button">
                <i class="fas fa-undo me-1" aria-hidden="true"></i>Clear Search
            </button>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($provider as $row): ?>
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="fkp-card h-100">

                <!-- Header -->
                <div class="fkp-card-head">
                    <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>" class="fkp-avatar-link">
                        <span class="fkp-avatar-ring">
                            <img src="<?= base_url(!empty($row['profile_image']) ? $row['profile_image'] : 'assets/images/3d-cartoon-fitness-man.jpg') ?>"
                                alt="<?= htmlspecialchars($row['gym_name']) ?>" class="fkp-avatar-img">
                        </span>
                    </a>

                    <div class="fkp-head-info">
                        <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>" class="fkp-name">
                            <?= ucfirst($row['gym_name']) ?>
                        </a>
                        <div class="fkp-services">
                            <i class="fas fa-dumbbell" aria-hidden="true"></i>
                            <?= $row['service_count'] ?> Services
                        </div>
                    </div>
                </div>

                <!-- Price band -->
                <div class="fkp-price-band">
                    <div class="fkp-price">
                        <span class="fkp-price-currency">₹</span><?= number_format($row['month_price']) ?>
                        <span class="fkp-price-unit">/ month</span>
                    </div>
                </div>

                <!-- Rating & Distance -->
                <div class="fkp-stat-row">
                    <div class="fkp-rating">
                        <span class="fkp-stars">
                            <?php
                            $rating = round($row['avg_rating']);
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating
                                    ? '<i class="fas fa-star" aria-hidden="true"></i>'
                                    : '<i class="far fa-star" aria-hidden="true"></i>';
                            }
                            ?>
                        </span>
                        <span class="fkp-rating-text">
                            <?= $row['avg_rating'] ?: '0.0' ?> <span class="fkp-rating-count">(<?= $row['total_reviews'] ?>)</span>
                        </span>
                    </div>

                    <div class="fkp-distance">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <?= $row['distance']; ?>
                    </div>
                </div>

                <!-- Footer -->
                <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>" class="fkp-view-btn">
                    View Details
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>

            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

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
        --warning: #ffc107;
        --border-color: #ececec;
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 22px;
        --radius-pill: 50px;
    }

    /* ══════════════════════════════════════════
       PROVIDER CARD
    ══════════════════════════════════════════ */
    .fkp-card {
        font-family: 'Poppins', sans-serif;
        background: var(--white);
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .fkp-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .fkp-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(111, 66, 193, 0.13);
        border-color: rgba(111, 66, 193, 0.25);
    }

    .fkp-card:hover::before {
        transform: scaleX(1);
    }

    /* Header */
    .fkp-card-head {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .fkp-avatar-link {
        flex-shrink: 0;
        display: block;
    }

    .fkp-avatar-ring {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        padding: 3px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s;
    }

    .fkp-card:hover .fkp-avatar-ring {
        transform: scale(1.06) rotate(-3deg);
    }

    .fkp-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 13px;
        border: 2px solid var(--white);
        display: block;
    }

    .fkp-head-info {
        flex: 1;
        min-width: 0;
    }

    .fkp-name {
        display: block;
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--secondary-color);
        text-decoration: none;
        margin-bottom: 4px;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.2s;
    }

    .fkp-name:hover {
        color: var(--primary-color);
    }

    .fkp-services {
        font-size: 0.82rem;
        color: var(--text-muted);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .fkp-services i {
        color: var(--primary-color);
        font-size: 0.78rem;
    }

    /* Price band — signature element */
    .fkp-price-band {
        background: linear-gradient(135deg, rgba(111, 66, 193, 0.07), rgba(142, 68, 173, 0.07));
        border: 1.5px dashed rgba(111, 66, 193, 0.25);
        border-radius: var(--radius-md);
        padding: 14px 20px;
        text-align: left;
    }

    .fkp-price {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--primary-color);
        letter-spacing: -0.02em;
        line-height: 1;
    }

    .fkp-price-currency {
        font-size: 1.15rem;
        font-weight: 700;
        margin-right: 1px;
    }

    .fkp-price-unit {
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--text-muted);
        margin-left: 2px;
    }

    /* Stat row */
    .fkp-stat-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .fkp-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .fkp-stars {
        display: inline-flex;
        gap: 1px;
        flex-shrink: 0;
    }

    .fkp-stars i {
        font-size: 0.85rem;
        color: var(--warning);
    }

    .fkp-stars i.far {
        color: #d8d8d8;
    }

    .fkp-rating-text {
        font-size: 0.84rem;
        color: var(--text-dark);
        font-weight: 600;
        white-space: nowrap;
    }

    .fkp-rating-count {
        color: var(--text-muted);
        font-weight: 400;
    }

    .fkp-distance {
        font-size: 0.82rem;
        color: var(--primary-dark);
        font-weight: 600;
        background: rgba(111, 66, 193, 0.08);
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
        flex-shrink: 0;
    }

    .fkp-distance i {
        font-size: 0.75rem;
    }

    /* Footer button */
    .fkp-view-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        border-radius: var(--radius-pill);
        border: 1.5px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.25s;
        margin-top: auto;
    }

    .fkp-view-btn:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(111, 66, 193, 0.28);
    }

    .fkp-view-btn i {
        font-size: 0.82rem;
        transition: transform 0.25s;
    }

    .fkp-view-btn:hover i {
        transform: translateX(3px);
    }

    /* Empty state */
    .fkp-empty {
        font-family: 'Poppins', sans-serif;
        text-align: center;
        padding: 70px 24px;
        background: var(--white);
        border: 1.5px dashed var(--border-color);
        border-radius: var(--radius-lg);
    }

    .fkp-empty i {
        font-size: 2.4rem;
        color: rgba(111, 66, 193, 0.3);
        margin-bottom: 14px;
        display: block;
    }

    .fkp-empty h5 {
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 6px;
        font-size: 1.05rem;
    }

    .fkp-empty p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .fkp-clear-btn {
        background: none;
        border: 1.5px solid var(--primary-color);
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.88rem;
        padding: 11px 26px;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: all 0.25s;
    }

    .fkp-clear-btn:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* ══════════════════════════════════════════
       MOBILE RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 768px) {
        .fkp-card {
            padding: 18px;
            gap: 14px;
        }

        .fkp-avatar-ring {
            width: 56px;
            height: 56px;
            border-radius: 14px;
        }

        .fkp-name {
            font-size: 0.96rem;
        }

        .fkp-price {
            font-size: 1.5rem;
        }

        .fkp-price-band {
            padding: 12px 20px;
        }

        .fkp-stat-row {
            justify-content: space-between;
        }

        .fkp-view-btn {
            padding: 11px;
            font-size: 0.86rem;
        }

        .fkp-empty {
            padding: 50px 20px;
        }
    }

    @media (max-width: 480px) {
        .fkp-card-head {
            gap: 12px;
        }

        .fkp-avatar-ring {
            width: 50px;
            height: 50px;
        }

        .fkp-services {
            font-size: 0.78rem;
        }

        .fkp-stat-row {
            flex-direction: row;
            flex-wrap: wrap;
        }

        .fkp-rating-text {
            font-size: 0.8rem;
        }

        .fkp-distance {
            font-size: 0.78rem;
            padding: 5px 10px;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .fkp-card,
        .fkp-avatar-ring,
        .fkp-view-btn,
        .fkp-view-btn i,
        .fkp-clear-btn {
            transition: none !important;
        }

        .fkp-card:hover,
        .fkp-card:hover .fkp-avatar-ring,
        .fkp-view-btn:hover,
        .fkp-clear-btn:hover {
            transform: none !important;
        }
    }
</style>