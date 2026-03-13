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

    .back-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 20px;
        background: #e9ecef;
        transition: all 0.2s;
        margin-bottom: 1.5rem;
    }

    .back-btn:hover {
        background: #dee2e6;
        color: #212529;
    }

    .back-btn svg {
        margin-right: 6px;
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
        overflow: hidden;
    }

    .folder-name {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .folder-arrow {
        color: #adb5bd;
    }
</style>

<div class="fittv-container container-fluid px-md-5 px-3">

    <div class="d-flex justify-content-between align-items-center mb-3 fittv-header">
        <h2 class="mb-0">FITTV <span class="text-danger">.</span></h2>
    </div>

    <a href="<?= base_url('fittv') ?>" class="back-btn">
        <svg focusable="false" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
        </svg>
        Back to Gender
    </a>

    <!-- Category Folders -->
    <h3 class="section-title">Select Category</h3>
    
    <?php if(!empty($categories)) { ?>
        <div class="folder-vertical-list">
            <?php foreach ($categories as $cat) { ?>
                <a href="<?= base_url('fittv/videos/' . $cat->id) ?>" class="folder-card <?= (isset($gender) && $gender == 'Boy') ? 'hover-boy' : 'hover-girl' ?>">
                    <div class="folder-icon">
                        <svg focusable="false" viewBox="0 0 24 24">
                            <path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"></path>
                        </svg>
                    </div>
                    <div class="folder-info">
                        <p class="folder-name"><?= htmlspecialchars($cat->name) ?></p>
                    </div>
                    <div class="folder-arrow">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                        </svg>
                    </div>
                </a>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="d-flex flex-column align-items-center justify-content-center mt-5 py-5 text-muted bg-white rounded-4 shadow-sm border border-light" style="max-width: 800px;">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" class="mb-3 opacity-50 text-secondary" stroke="currentColor" stroke-width="1.5">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
            <h5 class="fw-light opacity-75 mb-1">No Categories Found</h5>
            <p class="small opacity-50">This gender does not have any categories yet.</p>
        </div>
    <?php } ?>

</div>