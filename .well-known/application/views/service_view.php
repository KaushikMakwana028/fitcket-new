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
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .provider-card {
        background: var(--white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
        border: 1px solid var(--border-color);
    }
    
    .provider-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }
    
    .card-header {
        position: relative;
        height: 160px;
        overflow: hidden;
    }
    
    .card-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }
    
    .provider-card:hover .card-header img {
        transform: scale(1.05);
    }
    /* City section */
.city-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.city-section i {
    color: var(--primary-color);
    font-size: 1rem;
}

.city-section .label {
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 0.85rem;
}

.cities {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
}

.city-tag {
    background: var(--light-bg);
    color: var(--secondary-color);
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    transition: var(--transition);
}

.city-tag:hover {
    background: var(--primary-color);
    color: var(--white);
}

/* Distance section */
.distance-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.distance-section i {
    color: var(--primary-color);
    font-size: 1rem;
}

.distance-section .label {
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 0.85rem;
}

.distance {
    background: var(--warning-light, #fff3cd);
    color: var(--warning-color, #856404);
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
}
    
    .card-rating {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        color: var(--warning-color);
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        margin: 0 0 0.5rem 0;
        color: var(--secondary-color);
    }
    
    .card-subtitle {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0 0 1rem 0;
        font-size: 0.9rem;
    }
    
    .card-features {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .feature-tag {
        background: var(--light-bg);
        color: var(--text-muted);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
    }
    
    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1.5rem 1.5rem;
    }
    
    .price {
        font-weight: 700;
        color: var(--secondary-color);
        font-size: 1.1rem;
    }
    .page-link{
        background: var(--gradient-primary);
    color: #fff;
    }
    
    .btn-book {
        background: var(--gradient-primary);
    color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .btn-book:hover {
        background: var(--primary-dark);
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
    .bredcum{

    }
            .breadcrumb-container {
                margin: 1rem;
                padding: 1rem 1.25rem;
            }
            
        }
         @media (min-width: 768px) {
            .bredcum{
        
    }
            .breadcrumb-container {
                margin: 1rem auto;
                max-width: 95%;
            }
        }
        @media (min-width: 992px) {
             .bredcum{
        
             }
            .breadcrumb-container {
                 max-width: 1170px;
            }
        }
</style>
<div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?=base_url();?>">
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

