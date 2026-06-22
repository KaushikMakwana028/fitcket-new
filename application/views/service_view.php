<style>
    :root {
        --primary-color: #6f42c1;
        --primary-dark: #5a2ca6;
        --primary-light: #d1c4e9;
        --secondary-color: #1e293b;
        --accent-color: #8e44ad;
        --warning-color: #e67e22;
        --success-color: #2ecc71;
        --white: #ffffff;
        --light-bg: #f8f9fa;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --border-radius: 16px;
        --shadow: 0 10px 30px rgba(111, 66, 193, 0.06);
        --shadow-hover: 0 20px 40px rgba(111, 66, 193, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* body {
        background-color: var(--light-bg);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        padding: 2rem;
        margin: 0;
    } */

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header Styles */
    .demo-content {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .demo-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .demo-content i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .demo-content h4 {
        font-size: 1.8rem;
        margin: 0.5rem 0;
        color: var(--secondary-color);
    }

    .demo-content p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .provider-count {
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }

    /* Filter Controls */
    .filter-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
    }

    .search-box {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .view-options {
        display: flex;
        gap: 0.5rem;
    }

    .view-btn {
        background: var(--light-bg);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 0.5rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .view-btn:hover {
        background: var(--primary-light);
        color: var(--white);
    }

    .view-btn.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    /* Providers Grid */
    .providers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .provider-card {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
    }

    .provider-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-light);
    }

    .card-header {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .card-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .provider-card:hover .card-header img {
        transform: scale(1.06);
    }

    .card-rating {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-weight: 700;
        color: #e67e22;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.85rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 1.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .card-title {
        font-size: 1.35rem;
        font-weight: 750;
        margin: 0;
        color: var(--text-dark);
        line-height: 1.3;
    }

    .card-subtitle {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.25rem;
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-item i {
        color: var(--primary-color);
        width: 16px;
        text-align: center;
    }

    .badge-city {
        background: var(--light-bg);
        color: var(--text-dark);
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        border: 1px solid #e2e8f0;
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
    }

    .badge-distance {
        background: #fff3cd;
        color: #856404;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        border: 1px solid #ffeeba;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.75rem 1.75rem;
        border-top: 1px solid var(--border-color);
        background: #fafafa;
    }

    .price {
        font-weight: 800;
        color: var(--text-dark);
        font-size: 1.4rem;
        display: flex;
        align-items: baseline;
    }

    .price span {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-muted);
        margin-left: 4px;
    }

    .btn-book {
        background: var(--primary-color);
        color: #fff !important;
        border: none;
        padding: 0.65rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(111, 66, 193, 0.2);
        display: inline-block;
        text-align: center;
    }

    .btn-book:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111, 66, 193, 0.3);
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .pagination {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
    }

    .page-item {
        margin: 0 0.25rem;
    }

    .page-link {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        /* color: var(--primary-color); */
        font-weight: 600;
        min-width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
    }

    .page-link:hover {
        background-color: var(--primary-light);
        color: var(--white);
        border-color: var(--primary-light);
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .page-item.disabled .page-link {
        color: var(--text-muted);
        pointer-events: none;
        opacity: 0.6;
    }

    .page-controls {
        display: flex;
        gap: 1rem;
    }

    .btn-control {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-control:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-control:disabled {
        background: var(--border-color);
        color: var(--text-muted);
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .providers-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
    }

    @media (max-width: 768px) {
        /* body {
            padding: 1rem;
        } */

        .filter-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }

        .view-options {
            align-self: center;
        }

        .pagination-container {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .pagination {
            padding: 0.25rem;
        }

        .page-link {
            min-width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .page-item {
            margin: 0 0.1rem;
        }

        .btn-control {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .providers-grid {
            grid-template-columns: 1fr;
        }

        .demo-content {
            padding: 1.5rem;
        }

        .demo-content h4 {
            font-size: 1.5rem;
        }
    }

    /* Breadcrumb Styles */
    .breadcrumb-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 0.75rem 1rem;
        margin: 0.75rem;
        border: 1px solid var(--border-color);
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
    }

    .breadcrumb-item a:hover {
        background: var(--primary-light);
        color: var(--white);
    }

    .breadcrumb-item.active {
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
    }

    @media (min-width: 576px) {
        .bredcum {}

        .breadcrumb-container {
            margin: 1rem;
            padding: 1rem 1.25rem;
        }

    }

    @media (min-width: 768px) {
        .bredcum {}

        .breadcrumb-container {
            margin: 1rem auto;
            max-width: 95%;
        }
    }

    @media (min-width: 992px) {
        .bredcum {}

        .breadcrumb-container {
            max-width: 1170px;
        }
    }
</style>
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>">
                    <i class="fas fa-home me-1"></i>Home
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-users me-1"></i>Services
            </li>
        </ol>
    </nav>
</div>

<div class="container">
    <!-- <div class="demo-content">
        <i class="fas fa-dumbbell"></i>
        <h4>Fitness Providers Directory</h4>
        <p>Browse through our curated list of fitness service providers</p>
        <div class="provider-count" id="provider-count">24 Providers Available</div>
    </div> -->

    <div class="filter-controls">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search providers..." id="search-input">
        </div>
        <!-- <div class="view-options">
            <button class="view-btn active" title="Grid View">
                <i class="fas fa-th"></i>
            </button>
            <button class="view-btn" title="List View">
                <i class="fas fa-list"></i>
            </button>
        </div> -->
    </div>

    <div class="providers-grid" id="providers-container">
        <!-- Example Static Provider Card -->
        <!-- <div id="services-container" class="services-grid">

       </div> -->


    </div>

    <div class="pagination-container" style="margin-bottom: 5rem !important;">
        <div class="pagination-info" id="pagination-info">
            Showing 1-6 of 24 providers
        </div>
        <div class="page-controls">
            <div class="pagination" id="pagination"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {

        function loadServices(page = 1, search = '') {
            $.ajax({
                url: "<?= base_url('services/fetch_services') ?>",
                type: "GET",
                data: {
                    page: page,
                    search: search
                },
                dataType: "json",
                success: function(res) {
                    let html = '';

                    if (res.services.length === 0) {
                        html = `
                            <div style="text-align:center; padding:20px;">
                                <h4>No Services Found 😢</h4>
                                <p>Try different search</p>
                            </div>
                        `;
                    } else {
                        res.services.forEach(service => {
                            let ratingText = (service.avg_rating && parseFloat(service.avg_rating) > 0) ? parseFloat(service.avg_rating).toFixed(1) : 'New';
                            html += `
                            <div class="provider-card">
                                
                                <!-- IMAGE -->
                                <div class="card-header">
                                    <img src="${service.image ? '<?= base_url() ?>' + service.image : '<?= base_url("assets/images/default.jpg") ?>'}" onerror="this.onerror=null;this.src='<?= base_url("assets/images/default.jpg") ?>';" alt="">
                                    
                                    <!-- RATING -->
                                    <div class="card-rating">
                                        <i class="fas fa-star"></i> ${ratingText}
                                    </div>
                                </div>

                                <!-- BODY -->
                                <div class="card-body">
                                    <h5 class="card-title">${service.name || ''}</h5>
                                    <p class="card-subtitle"><i class="fas fa-dumbbell"></i> ${service.gym_name || ''}</p>

                                    <!-- CITY -->
                                    <div class="info-row">
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>Available in:</span>
                                        </div>
                                        <span class="badge-city" title="${service.city || 'N/A'}">${service.city || 'N/A'}</span>
                                    </div>

                                    <!-- DISTANCE -->
                                    <div class="info-row">
                                        <div class="info-item">
                                            <i class="fas fa-route"></i>
                                            <span>Distance:</span>
                                        </div>
                                        <span class="badge-distance">${service.distance || 'N/A'}</span>
                                    </div>
                                </div>

                                <!-- FOOTER -->
                                <div class="card-footer">
                                    <div class="price">₹${service.month_price || '0'}<span>/ month</span></div>
                                    <a href="<?= base_url('provider_details/') ?>${service.provider_id}" class="btn-book" style="color: #fff !important;">View</a>
                                </div>

                            </div>
                            `;
                        });
                    }

                    $('#providers-container').html(html);
                    renderPagination(res.total, res.limit, res.page, search);
                }
            });
        }

        function renderPagination(total, limit, currentPage, search) {
            let totalPages = Math.ceil(total / limit);
            if (totalPages <= 1) {
                $('#pagination').html('');
                $('#pagination-info').html(`Showing all ${total} services`);
                return;
            }

            let start = (currentPage - 1) * limit + 1;
            let end = Math.min(currentPage * limit, total);
            $('#pagination-info').html(`Showing ${start}-${end} of ${total} services`);

            let paginationHtml = '';
            
            // Previous
            paginationHtml += `
                <div class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" data-page="${currentPage - 1}">&laquo;</a>
                </div>
            `;

            // Numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    paginationHtml += `
                        <div class="page-item ${currentPage === i ? 'active' : ''}">
                            <a class="page-link" data-page="${i}">${i}</a>
                        </div>
                    `;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    paginationHtml += `
                        <div class="page-item disabled">
                            <span class="page-link">...</span>
                        </div>
                    `;
                }
            }

            // Next
            paginationHtml += `
                <div class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" data-page="${currentPage + 1}">&raquo;</a>
                </div>
            `;

            $('#pagination').html(paginationHtml);

            // Add click listener
            $('#pagination .page-link').off('click').on('click', function(e) {
                e.preventDefault();
                let selectedPage = $(this).data('page');
                if (selectedPage && selectedPage !== currentPage) {
                    loadServices(selectedPage, search);
                }
            });
        }

        // Initial load
        loadServices();

        // Search input
        $('#search-input').on('input', function() {
            let search = $(this).val();
            loadServices(1, search);
        });

    });
</script>