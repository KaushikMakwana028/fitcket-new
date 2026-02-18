<?php foreach ($provider as $row): ?>
<div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card provider-card shadow-sm h-100">

        <!-- Header -->
        <div class="provider-header d-flex align-items-center">
            <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>">
                <img src="<?= base_url($row['profile_image']) ?>" 
                     alt="<?= $row['gym_name'] ?>" 
                     class="provider-image">
            </a>

            <div class="ms-3 flex-grow-1">
                <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>" class="provider-name">
                    <?= ucfirst($row['gym_name']) ?>
                </a>

                <div class="text-muted small">
                    <i class="fas fa-dumbbell me-1"></i>
                    <?= $row['service_count'] ?> Services
                </div>
            </div>
        </div>

        <hr>

        <!-- Price -->
        <div class="provider-price text-center mb-2">
            ₹<?= number_format($row['month_price']) ?>
            <span>/ month</span>
        </div>

        <!-- Rating & Distance -->
        <div class="provider-meta d-flex justify-content-between align-items-center">

            <!-- Rating -->
            <div class="rating">
                <?php
                    $rating = round($row['avg_rating']);
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating
                            ? '<i class="fas fa-star text-warning"></i>'
                            : '<i class="far fa-star text-muted"></i>';
                    }
                ?>
                <span class="small text-muted ms-1">
                    <?= $row['avg_rating'] ?: '0.0' ?> (<?= $row['total_reviews'] ?>)
                </span>
            </div>

            <!-- Distance -->
            <div class="distance text-muted small">
                <i class="fas fa-map-marker-alt me-1"></i>
                <?= $row['distance']; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-3">
            <a href="<?= site_url('provider_details/' . $row['provider_id']) ?>" 
               class="btn btn-outline-primary w-100 view-more-btn">
                View Details
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>

    </div>
</div>
<?php endforeach; ?>
<style>
    .provider-card {
    border-radius: 14px;
    padding: 16px;
    transition: all 0.3s ease;
    background: #fff;
}

.provider-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.provider-image {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #eee;
}

.provider-name {
    font-size: 17px;
    font-weight: 600;
    color: #333;
    text-decoration: none;
}

.provider-name:hover {
    color: #6c63ff;
}

.provider-price {
    font-size: 22px;
    font-weight: 700;
    color: #6c63ff;
}

.provider-price span {
    font-size: 14px;
    font-weight: 500;
    color: #777;
}

.rating i {
    font-size: 14px;
}

.view-more-btn {
    border-radius: 10px;
    font-weight: 500;
}

</style>