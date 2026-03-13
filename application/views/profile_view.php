<style>
        :root {
            --primary-color: #6c5ce7;
            --primary-dark: #5a4fcf;
            --primary-light: #a29bfe;
            --secondary-color: #2d3436;
            --accent-color: #fd79a8;
            --warning-color: #fdcb6e;
            --success-color: #00b894;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #2d3436;
            --text-muted: #636e72;
            --border-color: #e9ecef;
            --border-radius: 12px;
            --shadow: 0 4px 20px rgba(108, 92, 231, 0.08);
            --shadow-hover: 0 8px 30px rgba(108, 92, 231, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding-bottom: 2rem;
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

        /* Header Section */
        .header-section {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
        }

        .header-section h4 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .header-section .text-muted {
            color: var(--text-muted) !important;
            font-size: 0.95rem;
        }

        /* Search and Filter Section */
        .search-filter-section {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 1.25rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            margin: 0.75rem;
        }

        .input-group {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(108, 92, 231, 0.1);
        }

        .input-group-text {
            background: var(--white);
            border: 2px solid var(--border-color);
            border-right: none;
            color: var(--text-muted);
            padding: 0.75rem 1rem;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-left: none;
            border-right: none;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .btn-search {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--white);
            border: none;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            transition: var(--transition);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            white-space: nowrap;
        }

        .btn-search:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            color: var(--white);
        }

        .form-select {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: var(--transition);
            background: var(--white);
            width: 100%;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .filter-label {
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
/* Mobile fix for search bar */
@media (max-width: 576px) {
  .search-box {
    display: flex;
    flex-direction: column !important;
    align-items: stretch;
    gap: 0.5rem;
    box-shadow: none; /* remove weird box overflow */
  }

  /* Hide search icon span only on mobile */
  .search-box .input-group-text {
    display: none !important;
  }

  .search-box .form-control {
    border: 2px solid var(--border-color);
    border-radius: 14px!important;
    width: 100%;
    padding: 0.6rem 1rem;
    font-size: 0.9rem;
  }

  .search-box .btn-search {
    border-radius: var(--border-radius);
    width: 100%;
    padding: 0.6rem;
    font-size: 0.95rem;
    font-weight: 600;
  }

  /* Accordion filter spacing */
  .accordion-button {
    padding: 0.6rem 1rem;
    font-size: 0.9rem;
  }

  .accordion-body {
    padding: 0.75rem;
  }
}
/* end */

        /* Provider Cards */
        .provider-card {
            background: var(--white);
            border: none;
            border-radius: var(--border-radius);
            padding: 1.25rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .provider-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            transform: scaleY(0);
            transition: var(--transition);
        }

        .provider-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .provider-card:hover::before {
            transform: scaleY(1);
        }

        .provider-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid var(--border-color);
            transition: var(--transition);
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .provider-card:hover .provider-image {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .provider-name {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            line-height: 1.3;
            margin-bottom: 0.25rem;
            display: block;
            transition: var(--transition);
        }

        .provider-name:hover {
            color: var(--primary-color);
        }

        .service-link {
            color: var(--primary-color) !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .service-link:hover {
            color: var(--primary-dark) !important;
            text-decoration: underline;
        }

        .provider-divider {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-light), transparent);
            margin: 1rem 0;
            opacity: 0.3;
        }

        .provider-stats {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .stat-item i {
            font-size: 0.9rem;
        }

        .stat-item .fa-star {
            color: var(--warning-color);
        }

        .stat-item .fa-map-marker-alt {
            color: var(--primary-color);
        }

        .view-more-btn {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: var(--transition);
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            background: var(--light-bg);
        }

        .view-more-btn:hover {
            background: var(--primary-color);
            transform: translateX(4px);
        }

        .view-more-btn i {
            color: var(--warning-color);
            transition: var(--transition);
        }

        .view-more-btn:hover i {
            color: var(--white);
        }

        .view-more-text {
            color: var(--primary-color) !important;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .view-more-btn:hover .view-more-text {
            color: var(--white) !important;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 0.5rem;
            border: 1px solid var(--border-color);
        }

        .page-link {
            border-radius: 8px;
            margin: 0 0.25rem;
            border: 1px solid var(--border-color);
            color: var(--primary-color);
            font-weight: 600;
            min-width: 42px;
            text-align: center;
        }

        .page-link:hover {
            background-color: var(--primary-light);
            color: var(--white);
            border-color: var(--primary-light);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Responsive Design */
        @media (min-width: 576px) {
            .breadcrumb-container {
                margin: 1rem;
                padding: 1rem 1.25rem;
            }
            
            .header-section {
                margin: 1rem;
                padding: 1.75rem;
            }
            
            .search-filter-section {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .provider-card {
                padding: 1.5rem;
            }
        }

        @media (min-width: 768px) {
            .breadcrumb-container {
                margin: 1rem auto;
                max-width: 95%;
            }
            
            .header-section {
                margin: 1rem auto;
                max-width: 95%;
            }
            
            .search-filter-section {
                margin: 1rem auto;
                max-width: 95%;
            }
            
            .container-custom {
                max-width: 95%;
                margin: 0 auto;
            }
            
            .filter-section {
                display: flex;
                align-items: center;
            }
            
            .filter-label {
                margin-bottom: 0;
                margin-right: 0.75rem;
                white-space: nowrap;
            }
            
            .provider-image {
                width: 70px;
                height: 70px;
            }
        }

        @media (min-width: 992px) {
            .breadcrumb-container {
                max-width: 1200px;
            }
            
            .header-section {
                max-width: 1200px;
            }
            
            .search-filter-section {
                max-width: 1200px;
            }
            
            .container-custom {
                max-width: 1200px;
            }
            
            .header-section h4 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 767px) {
            .input-group {
                flex-direction: column;
                box-shadow: none;
            }
            
            .input-group-text {
                border-radius: 8px 8px 0 0;
                border: 2px solid var(--border-color);
                border-bottom: none;
                justify-content: center;
            }
            
            .form-control {
                border-radius: 0;
                border: 2px solid var(--border-color);
                border-top: none;
                border-bottom: none;
            }
            
            .btn-search {
                border-radius: 0 0 8px 8px;
                width: 100%;
            }
            
            .provider-stats {
                flex-wrap: wrap;
                gap: 0.75rem;
            }
            
            .view-more-btn {
                margin-left: auto;
            }
        }

        @media (max-width: 575px) {
            .provider-card {
                margin: 0.5rem 0;
            }
            
            .provider-image {
                width: 55px;
                height: 55px;
                margin-right: 0.75rem;
            }
            
            .provider-name {
                font-size: 1rem;
            }
            
            .stat-item {
                flex: 1;
                min-width: 45%;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .provider-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .provider-card:nth-child(2n) {
            animation-delay: 0.1s;
        }

        .provider-card:nth-child(3n) {
            animation-delay: 0.2s;
        }

        /* Loading State */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: var(--border-radius);
            min-height: 180px;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }
        
        /* Container adjustments */
        .container-custom {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        /* Improved focus states for accessibility */
        .provider-name:focus,
        .service-link:focus,
        .view-more-btn:focus {
            outline: 2px solid var(--primary-light);
            outline-offset: 2px;
        }
        /* Filter Group Styles */
.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group .filter-label {
    color: var(--text-dark);
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
}

.filter-group .filter-label i {
    color: var(--primary-color);
    font-size: 0.8rem;
}

.filter-group .form-select {
    padding: 0.6rem 0.85rem;
    font-size: 0.9rem;
    border-radius: 8px;
}

.filter-actions .btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
}

.filter-actions .btn-outline-secondary {
    border-color: var(--border-color);
    color: var(--text-muted);
}

.filter-actions .btn-outline-secondary:hover {
    background: var(--light-bg);
    border-color: var(--text-muted);
    color: var(--text-dark);
}

.filter-actions .btn-search {
    border-radius: 8px;
}

/* Scrollable filter on mobile */
@media (max-width: 576px) {
    #collapseFilter .accordion-body {
        max-height: 350px;
        overflow-y: auto;
    }
    
    .filter-group {
        margin-bottom: 0.75rem !important;
    }
    
    .filter-group .filter-label {
        font-size: 0.8rem;
    }
    
    .filter-group .form-select {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }
}
/* Filter Accordion Overlay Fix */
.col-12.col-md-4 {
    position: relative;
}

#filterAccordion {
    position: relative;
}

#filterAccordion .accordion-item {
    position: relative;
}

#collapseFilter {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1000;
    background: var(--white);
    border-radius: 0 0 var(--border-radius) var(--border-radius);
    box-shadow: var(--shadow-hover);
    border: 1px solid var(--border-color);
    border-top: none;
}

#collapseFilter .accordion-body {
    max-height: 400px;
    overflow-y: auto;
    padding: 1rem;
}

/* Custom Scrollbar for Filter */
#collapseFilter .accordion-body::-webkit-scrollbar {
    width: 6px;
}

#collapseFilter .accordion-body::-webkit-scrollbar-track {
    background: var(--light-bg);
    border-radius: 3px;
}

#collapseFilter .accordion-body::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 3px;
}

#collapseFilter .accordion-body::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
}

/* Mobile adjustments */
@media (max-width: 767px) {
    #collapseFilter {
        position: fixed;
        top: auto;
        bottom: 0;
        left: 0;
        right: 0;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        max-height: 70vh;
        border: 1px solid var(--border-color);
    }
    
    #collapseFilter .accordion-body {
        max-height: calc(70vh - 20px);
    }
    
    /* Backdrop when filter is open on mobile */
    #collapseFilter.show::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
}

    </style>
<div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-users me-1"></i>Providers
                </li>
            </ol>
        </nav>
    </div>

    <!-- Header -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="mb-1">
                    <i class="fas fa-dumbbell me-2 text-primary"></i>All Providers
                </h4>
                <!-- <p class="text-muted mb-0">
                    <i class="fas fa-chart-bar me-1"></i>9 of 10 Providers
                </p> -->
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    
<!-- Search and Filter -->
<div class="search-filter-section">
  <div class="row g-3">
    <!-- Search -->
   <!-- Search -->
<div class="col-12 col-md-8">
    <div class="search-box input-group">
        <span class="input-group-text">
            <i class="fas fa-search"></i>
        </span>
        <input type="text"
            id="providerSearch"
            name="search"
            class="form-control"
            placeholder="Search by provider or business name..."
            value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>">
        <button class="btn btn-outline-secondary clear-search" type="button" title="Clear search">
            <i class="fas fa-times"></i>
        </button>
        <button class="btn btn-search" type="button">
            <i class="fas fa-search me-1"></i>Search
        </button>
    </div>
</div>

    <!-- Filter -->
   <!-- Filter -->
<div class="col-12 col-md-4">
  <div class="accordion" id="filterAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFilter">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
          <i class="fas fa-filter me-2"></i>Filter
        </button>
      </h2>
      <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#filterAccordion">
        <div class="accordion-body">
          
          <!-- Sort By -->
        
 <!-- <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-dollar-sign me-1"></i>Service Type
            </label>
            <select class="form-select" id="servcie_filter">
              <option value="" selected disabled>Select...</option>
              <option value="online">Online</option>
              <option value="offline">Offline</option>
            </select>
          </div> -->
          <!-- Price -->
          <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-dollar-sign me-1"></i>Price
            </label>
            <select class="form-select" id="price_filter">
              <option value="" selected disabled>Select...</option>
              <option value="low_to_high">Low to High</option>
              <option value="high_to_low">High to Low</option>
            </select>
          </div>

          <!-- Rating -->
          <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-star me-1"></i>Rating
            </label>
            <select class="form-select" id="rating_filter">
              <option value="" selected disabled>Select...</option>
              <option value="top_rated">Top Rated First</option>
              <option value="4_plus">4+ Stars</option>
              <option value="3_plus">3+ Stars</option>
              <option value="2_plus">2+ Stars</option>
            </select>
          </div>

          <!-- Experience -->
          <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-briefcase me-1"></i>Experience
            </label>
            <select class="form-select" id="experience_filter">
              <option value="" selected disabled>Select...</option>
              <option value="0_2">0-2 Years</option>
              <option value="3_5">3-5 Years</option>
              <option value="5_10">5-10 Years</option>
              <option value="10_plus">10+ Years</option>
            </select>
          </div>

          <!-- Category -->
          <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-th-large me-1"></i>Category
            </label>
            <select class="form-select" id="category_filter">
              <option value="" selected disabled>Select...</option>
              <option value="yoga">Yoga</option>
              <option value="weight_lifting">Weight Lifting</option>
              <option value="cardio">Cardio</option>
              <option value="crossfit">CrossFit</option>
              <option value="pilates">Pilates</option>
              <option value="zumba">Zumba</option>
              <option value="martial_arts">Martial Arts</option>
              <option value="swimming">Swimming</option>
              <option value="personal_training">Personal Training</option>
            </select>
          </div>

          <!-- Language -->
          <div class="filter-group mb-3">
            <label class="filter-label">
              <i class="fas fa-language me-1"></i>Language
            </label>
            <select class="form-select" id="language_filter">
              <option value="" selected disabled>Select...</option>
              <option value="english">English</option>
              <option value="hindi">Hindi</option>
              <option value="spanish">Spanish</option>
              <option value="french">French</option>
              <option value="german">German</option>
              <option value="arabic">Arabic</option>
              <option value="chinese">Chinese</option>
              <option value="japanese">Japanese</option>
            </select>
          </div>

          <!-- Action Buttons -->
          <div class="filter-actions d-flex gap-2 mt-3 pt-3 border-top">
            <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1">
              <i class="fas fa-undo me-1"></i>Reset
            </button>
            <button type="button" class="btn btn-search btn-sm flex-grow-1">
              <i class="fas fa-check me-1"></i>Apply
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
  </div>
</div>


    <div class="container-custom ">
    <div id="providerList" class="row g-3">
        <?php $this->load->view('provider_list', ['provider' => $provider]); ?>
    </div>

    <!-- Pagination -->
    <div class="pagination-container mb-5">
        <nav aria-label="Providers pagination">
            <div id="paginationLinks">
                <?= $pagination ?>
            </div>
        </nav>
    </div>
</div>
<script src="<?= base_url('assets/js/lib/jquery-3.7.1.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
    
    var searchTimer;
    
    // ✅ Search on button click
    $('.btn-search').on('click', function(e) {
        e.preventDefault();
        performSearch();
    });
    
    // ✅ Search on Enter key
    $('#providerSearch').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            performSearch();
        }
    });
    
    // ✅ Optional: Live search with debounce (search as you type)
    $('#providerSearch').on('keyup', function(e) {
        // Ignore Enter key (already handled above)
        if (e.which === 13) return;
        
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            performSearch();
        }, 500); // Wait 500ms after user stops typing
    });
    
    // ✅ Main search function
    function performSearch() {
        var searchTerm = $('#providerSearch').val().trim();
        
        // Get all current filter values
        var filters = {
            search: searchTerm,
            price: $('#price_filter').val() || '',
            rating: $('#rating_filter').val() || '',
            exp: $('#experience_filter').val() || '',
            category: $('#category_filter').val() || '',
            language: $('#language_filter').val() || ''
        };
        
        // Remove empty values
        Object.keys(filters).forEach(function(key) {
            if (!filters[key]) delete filters[key];
        });
        
        // Show loading state
        $('#providerList').html('<div class="col-12 text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i><p class="mt-2">Searching...</p></div>');
        
        $.ajax({
            url: '<?= base_url("profile/index/0") ?>',
            type: 'GET',
            data: filters,
            dataType: 'json',
            success: function(response) {
                $('#providerList').html(response.html);
                $('#paginationLinks').html(response.pagination);
                
                // Update URL without page reload (optional)
                var queryString = $.param(filters);
                var newUrl = window.location.pathname + (queryString ? '?' + queryString : '');
                window.history.pushState({}, '', newUrl);
            },
            error: function(xhr, status, error) {
                console.error('Search error:', error);
                $('#providerList').html('<div class="col-12 text-center py-5 text-danger"><i class="fas fa-exclamation-circle fa-2x"></i><p class="mt-2">Error searching providers. Please try again.</p></div>');
            }
        });
    }
    
    // ✅ Clear search
    $(document).on('click', '.clear-search', function() {
        $('#providerSearch').val('');
        performSearch();
    });
});
</script>