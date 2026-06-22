<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

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
        --shadow-hover: 0 16px 32px rgba(111, 66, 193, 0.12);
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fks-page {
        font-family: 'Poppins', sans-serif;
    }

    .fks-page *,
    .fks-page *::before,
    .fks-page *::after {
        box-sizing: border-box;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ══════════════════════════════════════════
       FILTER BAR
    ══════════════════════════════════════════ */
    .filter-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
        gap: 1rem;
        background: var(--white);
        padding: 1.1rem 1.25rem;
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
        padding: 0.7rem 1rem 0.7rem 2.75rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 0.92rem;
        font-family: 'Poppins', sans-serif;
        transition: var(--transition);
        color: var(--text-dark);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.12);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* ══════════════════════════════════════════
       PROVIDERS GRID — compact cards
    ══════════════════════════════════════════ */
    .providers-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
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
        position: relative;
    }

    .provider-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
        border-color: var(--primary-light);
    }

    .card-header {
        position: relative;
        height: 168px;
        overflow: hidden;
        flex-shrink: 0;
        background: var(--light-bg);
    }

    .card-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: var(--transition);
        display: block;
    }

    /* Logo-style / broken / non-photo images fall back to "contain"
       via this class added by JS so nothing crops oddly */
    .card-header img.fks-fit-contain {
        object-fit: contain;
        padding: 14px;
        background: var(--light-bg);
    }

    .provider-card:hover .card-header img {
        transform: scale(1.05);
    }

    .card-rating {
        position: absolute;
        top: 0.65rem;
        right: 0.65rem;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(6px);
        padding: 0.3rem 0.75rem;
        border-radius: 30px;
        font-weight: 700;
        color: var(--warning-color);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    .card-rating i {
        font-size: 0.75rem;
    }

    .card-body {
        padding: 1.1rem 1.2rem 0.9rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .card-title {
        font-size: 1.08rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-dark);
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-subtitle {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
        font-size: 0.86rem;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-subtitle i {
        font-size: 0.78rem;
        flex-shrink: 0;
    }

    /* City + distance combined into one compact line */
    .info-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-top: 0.25rem;
    }

    .badge-city,
    .badge-distance {
        font-weight: 600;
        padding: 0.28rem 0.75rem;
        border-radius: 20px;
        font-size: 0.76rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        max-width: 50%;
    }

    .badge-city {
        background: var(--light-bg);
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .badge-city i {
        color: var(--primary-color);
        font-size: 0.7rem;
    }

    .badge-distance {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .badge-distance i {
        font-size: 0.7rem;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.9rem 1.2rem;
        border-top: 1px solid var(--border-color);
        background: #fafafa;
    }

    .price {
        font-weight: 800;
        color: var(--text-dark);
        font-size: 1.25rem;
        display: flex;
        align-items: baseline;
        line-height: 1;
    }

    .price span {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-muted);
        margin-left: 3px;
    }

    .btn-book {
        background: var(--primary-color);
        color: #fff !important;
        border: none;
        padding: 0.55rem 1.4rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.22);
        display: inline-block;
        text-align: center;
    }

    .btn-book:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(111, 66, 193, 0.3);
    }

    /* ══════════════════════════════════════════
       PAGINATION
    ══════════════════════════════════════════ */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pagination-info {
        color: var(--text-muted);
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
    }

    .pagination {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 0.4rem;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
    }

    .page-item {
        margin: 0 0.2rem;
        list-style: none;
    }

    .page-link {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        font-weight: 600;
        font-size: 0.85rem;
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        color: var(--text-dark);
        background: var(--white);
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

    /* ══════════════════════════════════════════
       EMPTY STATE
    ══════════════════════════════════════════ */
    .fks-empty {
        text-align: center;
        padding: 50px 20px;
        font-family: 'Poppins', sans-serif;
        grid-column: 1 / -1;
    }

    .fks-empty h4 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 6px;
    }

    .fks-empty p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.9rem;
    }

    /* ══════════════════════════════════════════
       BREADCRUMB
    ══════════════════════════════════════════ */
    .breadcrumb-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 0.75rem 1rem;
        margin: 0.75rem;
        border: 1px solid var(--border-color);
        font-family: 'Poppins', sans-serif;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item {
        font-size: 0.88rem;
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
        .breadcrumb-container {
            margin: 1rem;
            padding: 1rem 1.25rem;
        }
    }

    @media (min-width: 768px) {
        .breadcrumb-container {
            margin: 1rem auto;
            max-width: 95%;
        }
    }

    @media (min-width: 992px) {
        .breadcrumb-container {
            max-width: 1170px;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 992px) {
        .providers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .filter-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }

        .pagination-container {
            flex-direction: column;
        }

        .providers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .card-header {
            height: 140px;
        }

        .card-body {
            padding: 0.9rem 1rem 0.75rem;
        }

        .card-title {
            font-size: 0.95rem;
        }

        .card-subtitle {
            font-size: 0.78rem;
        }

        .badge-city,
        .badge-distance {
            font-size: 0.68rem;
            padding: 0.22rem 0.55rem;
        }

        .card-footer {
            padding: 0.75rem 1rem;
            flex-wrap: wrap;
            gap: 6px;
        }

        .price {
            font-size: 1.05rem;
        }

        .btn-book {
            padding: 0.48rem 1.1rem;
            font-size: 0.82rem;
        }
    }

    @media (max-width: 480px) {
        .providers-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .card-header {
            height: 170px;
        }

        .card-rating {
            font-size: 0.74rem;
            padding: 0.26rem 0.65rem;
        }

        .card-body {
            padding: 1rem 1.1rem 0.85rem;
            gap: 0.45rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-subtitle {
            font-size: 0.82rem;
        }

        .info-line {
            gap: 8px;
        }

        .badge-city,
        .badge-distance {
            max-width: 50%;
            font-size: 0.72rem;
        }

        .card-footer {
            padding: 0.85rem 1.1rem;
        }

        .price {
            font-size: 1.1rem;
        }

        .price span {
            font-size: 0.72rem;
        }

        .btn-book {
            padding: 0.5rem 1.2rem;
            font-size: 0.84rem;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .provider-card,
        .card-header img,
        .btn-book,
        .page-link {
            transition: none !important;
        }

        .provider-card:hover,
        .btn-book:hover,
        .page-link:hover {
            transform: none !important;
        }
    }
</style>

<div class="fks-page">

    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>">
                        <i class="fas fa-home me-1" aria-hidden="true"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-users me-1" aria-hidden="true"></i>Services
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">

        <div class="filter-controls">
            <div class="search-box">
                <i class="fas fa-search" aria-hidden="true"></i>
                <input type="text" placeholder="Search providers..." id="search-input">
            </div>
        </div>

        <div class="providers-grid" id="providers-container"></div>

        <div class="pagination-container" style="margin-bottom: 5rem !important;">
            <div class="pagination-info" id="pagination-info">
                Showing 1-6 of 24 providers
            </div>
            <div class="page-controls">
                <div class="pagination" id="pagination"></div>
            </div>
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
                            <div class="fks-empty">
                                <h4>No Services Found</h4>
                                <p>Try a different search term</p>
                            </div>
                        `;
                    } else {
                        res.services.forEach(service => {
                            let ratingText = (service.avg_rating && parseFloat(service.avg_rating) > 0) ? parseFloat(service.avg_rating).toFixed(1) : 'New';
                            html += `
                            <div class="provider-card">

                                <!-- IMAGE -->
                                <div class="card-header">
                                    <img class="fks-card-img" src="${service.image ? '<?= base_url() ?>' + service.image : '<?= base_url("assets/images/default.jpg") ?>'}" alt="${service.name || ''}">

                                    <!-- RATING -->
                                    <div class="card-rating">
                                        <i class="fas fa-star" aria-hidden="true"></i> ${ratingText}
                                    </div>
                                </div>

                                <!-- BODY -->
                                <div class="card-body">
                                    <h5 class="card-title" title="${service.name || ''}">${service.name || ''}</h5>
                                    <p class="card-subtitle" title="${service.gym_name || ''}"><i class="fas fa-dumbbell" aria-hidden="true"></i> ${service.gym_name || ''}</p>

                                    <!-- CITY + DISTANCE in one line -->
                                    <div class="info-line">
                                        <span class="badge-city" title="${service.city || 'N/A'}">
                                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>${service.city || 'N/A'}
                                        </span>
                                        <span class="badge-distance" title="${service.distance || 'N/A'}">
                                            <i class="fas fa-route" aria-hidden="true"></i>${service.distance || 'N/A'}
                                        </span>
                                    </div>
                                </div>

                                <!-- FOOTER -->
                                <div class="card-footer">
                                    <div class="price">₹${service.month_price || '0'}<span>/mo</span></div>
                                    <a href="<?= base_url('provider_details/') ?>${service.provider_id}" class="btn-book">View</a>
                                </div>

                            </div>
                            `;
                        });
                    }

                    $('#providers-container').html(html);
                    renderPagination(res.total, res.limit, res.page, search);
                    fixCardImages();
                }
            });
        }

        // Make sure broken images fall back to a default photo, and that
        // small/low-res or logo-style images (which would look stretched/cropped
        // under object-fit:cover) switch to object-fit:contain instead.
        function fixCardImages() {
            $('.fks-card-img').each(function() {
                let $img = $(this);
                const defaultSrc = '<?= base_url("assets/images/default.jpg") ?>';

                $img.off('error').on('error', function() {
                    $(this).off('error').attr('src', defaultSrc);
                });

                $img.off('load').on('load', function() {
                    const naturalW = this.naturalWidth;
                    const naturalH = this.naturalHeight;
                    // Small/low-res images (icons, logos) tend to look bad when
                    // force-cropped to fill the header — show them whole instead.
                    if (naturalW && naturalH && (naturalW < 300 || naturalH < 200)) {
                        $(this).addClass('fks-fit-contain');
                    }
                });

                // If the image is already loaded (cached) by the time we bind, run the check now
                if (this.complete && this.naturalWidth) {
                    $img.trigger('load');
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

            paginationHtml += `
                <div class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" data-page="${currentPage - 1}">&laquo;</a>
                </div>
            `;

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

            paginationHtml += `
                <div class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" data-page="${currentPage + 1}">&raquo;</a>
                </div>
            `;

            $('#pagination').html(paginationHtml);

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