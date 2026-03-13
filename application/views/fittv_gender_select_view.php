<style>
    body {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }
    
    .fittv-container {
        background-color: #f8f9fa;
        color: #212529;
        padding-top: 2rem;
        padding-bottom: 3rem;
        min-height: 100vh;
    }
    
    .fittv-header h2 {
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 2.2rem;
        color: #212529;
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #495057;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .folder-vertical-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        max-width: 800px;
    }

    .folder-card {
        background: #fff;
        border: 1px solid #dadce0;
        border-radius: 12px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #3c4043;
        transition: background 0.2s, box-shadow 0.2s, border-color 0.2s, transform 0.2s;
        cursor: pointer;
    }

    .folder-card:hover {
        background: #f8f9fa;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        text-decoration: none;
        color: #202124;
        transform: translateY(-2px);
    }
    
    .folder-card.hover-boy:hover { border-color: #007bff; }
    .folder-card.hover-girl:hover { border-color: #dc3545; }

    .folder-icon {
        flex-shrink: 0;
        margin-right: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f1f3f5;
    }

    .folder-icon svg {
        width: 24px;
        height: 24px;
    }
    
    .folder-card.hover-boy .folder-icon svg { fill: #007bff; }
    .folder-card.hover-girl .folder-icon svg { fill: #dc3545; }

    .folder-info {
        flex-grow: 1;
    }

    .folder-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
    }
    
    .folder-desc {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 4px 0 0 0;
    }
    
    .folder-arrow {
        color: #adb5bd;
    }
</style>

<div class="fittv-container container-fluid px-md-5 px-3">

    <div class="fittv-header">
        <h2 class="mb-0">FITTV <span class="text-danger">.</span></h2>
    </div>

    <!-- Gender Selection -->
    <h3 class="section-title">Select Gender</h3>
    
    <div class="folder-vertical-list">
        
        <a href="<?= base_url('fittv/Boy') ?>" class="folder-card hover-boy">
            <div class="folder-icon">
                <svg focusable="false" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            </div>
            <div class="folder-info">
                <p class="folder-name">Boy</p>
                <p class="folder-desc">View fitness content and workouts for boys</p>
            </div>
            <div class="folder-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                </svg>
            </div>
        </a>
        
        <a href="<?= base_url('fittv/Girl') ?>" class="folder-card hover-girl">
            <div class="folder-icon">
                <svg focusable="false" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            </div>
            <div class="folder-info">
                <p class="folder-name">Girl</p>
                <p class="folder-desc">View fitness content and workouts for girls</p>
            </div>
            <div class="folder-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                </svg>
            </div>
        </a>

    </div>

</div>
