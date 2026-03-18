<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    :root {
        --primary: #4e54c8;
        --primary-light: #8f94fb;
        --primary-ultra: #f0f1ff;
        --accent: #e94560;
        --accent-light: #ff6b81;
        --success: #00b894;
        --success-light: #e6f9f4;
        --warning: #f39c12;
        --warning-light: #fef9e7;
        --dark: #1a1a2e;
        --text-primary: #1a1a2e;
        --text-secondary: #6c757d;
        --text-muted: #adb5bd;
        --bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: #e8ecf1;
        --input-bg: #f8f9fc;
        --input-focus-bg: #ffffff;
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.04);
        --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.1);
        --shadow-glow: 0 4px 20px rgba(78, 84, 200, 0.15);
        --radius-sm: 10px;
        --radius-md: 14px;
        --radius-lg: 18px;
        --radius-xl: 24px;
    }

    .create-pool-page {
        font-family: 'Poppins', sans-serif;
        background: var(--bg);
        min-height: 100vh;
        padding: 20px 0 60px;
        color: var(--text-primary);
        position: relative;
    }

    .create-pool-page *,
    .create-pool-page *::before,
    .create-pool-page *::after {
        box-sizing: border-box;
    }

    /* ========== BG DECORATION ========== */
    .page-bg-deco {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 320px;
        background: linear-gradient(135deg, var(--dark) 0%, #16213e 60%, #0a3d62 100%);
        z-index: 0;
        pointer-events: none;
    }

    .page-bg-deco::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -60px;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(78, 84, 200, 0.15), transparent);
        border-radius: 50%;
    }

    .page-bg-deco::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: -30px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(233, 69, 96, 0.1), transparent);
        border-radius: 50%;
    }

    .create-pool-page .container {
        position: relative;
        z-index: 1;
    }

    /* ========== BACK BUTTON ========== */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        margin-bottom: 20px;
        padding: 8px 16px;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .back-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        transform: translateX(-3px);
    }

    .back-link i {
        font-size: 0.72rem;
        transition: transform 0.3s ease;
    }

    .back-link:hover i {
        transform: translateX(-2px);
    }

    /* ========== PAGE TITLE (Mobile-friendly) ========== */
    .page-title-bar {
        margin-bottom: 22px;
        color: #fff;
    }

    .page-title-bar h2 {
        font-weight: 800;
        font-size: 1.6rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        line-height: 1.2;
    }

    .page-title-bar h2 .title-emoji {
        font-size: 1.8rem;
    }

    .page-title-bar .page-desc {
        font-size: 0.82rem;
        opacity: 0.55;
        margin-top: 4px;
        padding-left: 2px;
    }

    /* ========== PAGE LAYOUT ========== */
    .create-pool-wrapper {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 24px;
        align-items: start;
    }

    /* ========== FORM CARD ========== */
    .form-card {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        padding: 24px 28px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -30px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 20%;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.06), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .form-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .form-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .form-header h3 {
        font-weight: 700;
        font-size: 1.15rem;
        margin: 0;
        line-height: 1.2;
    }

    .form-header .form-subtitle {
        font-size: 0.76rem;
        opacity: 0.7;
        margin-top: 2px;
    }

    .form-body {
        padding: 28px;
    }

    /* ========== STEP INDICATOR ========== */
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 32px;
        padding: 16px 20px;
        background: #f8f9fe;
        border-radius: 14px;
        border: 1px solid #eef0f8;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
        border: 2px solid var(--border);
        background: #fff;
        color: var(--text-muted);
    }

    .step-circle.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 3px 12px rgba(78, 84, 200, 0.25);
        transform: scale(1.08);
    }

    .step-circle.done {
        background: var(--success);
        color: #fff;
        border-color: var(--success);
        box-shadow: 0 2px 8px rgba(0, 184, 148, 0.2);
    }

    .step-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-muted);
        transition: color 0.3s ease;
        white-space: nowrap;
    }

    .step-label.active {
        color: var(--primary);
    }

    .step-label.done {
        color: var(--success);
    }

    .step-line {
        flex: 1;
        height: 2px;
        background: var(--border);
        margin: 0 10px;
        min-width: 24px;
        position: relative;
        overflow: hidden;
        border-radius: 1px;
    }

    .step-line .step-line-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background: var(--success);
        transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 1px;
    }

    .step-line.done .step-line-fill {
        width: 100%;
    }

    /* ========== FORM SECTION DIVIDERS ========== */
    .form-section {
        margin-bottom: 26px;
    }

    .form-section-title {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f0f2f8;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-section-title .section-num {
        width: 20px;
        height: 20px;
        border-radius: 5px;
        background: var(--primary-ultra);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.62rem;
        font-weight: 800;
    }

    /* ========== FORM GROUPS ========== */
    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.84rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .form-label .label-icon {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.68rem;
        color: #fff;
        flex-shrink: 0;
    }

    .label-icon.name {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
    }

    .label-icon.limit {
        background: linear-gradient(135deg, #f39c12, #e67e22);
    }

    .label-icon.price {
        background: linear-gradient(135deg, var(--success), #27ae60);
    }

    .label-icon.desc {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
    }

    .form-label .required {
        color: var(--accent);
        font-size: 0.65rem;
        font-weight: 400;
    }

    .form-hint {
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 400;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.88rem;
        color: var(--text-primary);
        background: var(--input-bg);
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-input:hover {
        border-color: #d0d5dd;
        background: #f4f5fa;
    }

    .form-input:focus {
        border-color: var(--primary);
        background: var(--input-focus-bg);
        box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.08);
    }

    .form-input::placeholder {
        color: #c5c9d6;
        font-weight: 400;
    }

    .form-input.error {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(233, 69, 96, 0.08);
        background: #fffbfb;
    }

    .form-input.valid {
        border-color: var(--success);
        box-shadow: 0 0 0 4px rgba(0, 184, 148, 0.06);
        background: #f9fefc;
    }

    /* Input with icon prefix */
    .input-wrapper {
        position: relative;
    }

    .input-prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-secondary);
        pointer-events: none;
        z-index: 1;
    }

    .input-wrapper .form-input.has-prefix {
        padding-left: 34px;
    }

    .input-suffix {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.72rem;
        color: var(--text-muted);
        pointer-events: none;
        font-weight: 500;
    }

    /* Validation message */
    .validation-msg {
        font-size: 0.72rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
        opacity: 0;
        transform: translateY(-4px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding-left: 2px;
    }

    .validation-msg.show {
        opacity: 1;
        transform: translateY(0);
    }

    .validation-msg.error {
        color: var(--accent);
    }

    .validation-msg.success {
        color: var(--success);
    }

    /* Textarea */
    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.88rem;
        color: var(--text-primary);
        background: var(--input-bg);
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        resize: vertical;
        min-height: 80px;
        max-height: 160px;
    }

    .form-textarea:hover {
        border-color: #d0d5dd;
    }

    .form-textarea:focus {
        border-color: var(--primary);
        background: var(--input-focus-bg);
        box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.08);
    }

    .form-textarea::placeholder {
        color: #c5c9d6;
    }

    .char-count {
        text-align: right;
        font-size: 0.66rem;
        color: var(--text-muted);
        margin-top: 4px;
        font-weight: 500;
    }

    /* Quick Buttons (shared) */
    .quick-btns {
        display: flex;
        gap: 6px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .quick-btn {
        padding: 5px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        user-select: none;
    }

    .quick-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-ultra);
        transform: translateY(-1px);
    }

    .quick-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 2px 8px rgba(78, 84, 200, 0.25);
    }

    .quick-btn.orange:hover {
        border-color: #f39c12;
        color: #e67e22;
        background: var(--warning-light);
    }

    .quick-btn.orange.active {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: #fff;
        border-color: #f39c12;
        box-shadow: 0 2px 8px rgba(243, 156, 18, 0.25);
    }

    /* ========== FORM DIVIDER ========== */
    .form-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border), transparent);
        margin: 8px 0 24px;
    }

    /* ========== SUBMIT SECTION ========== */
    .submit-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .submit-btn {
        flex: 1;
        padding: 14px 24px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.3px;
    }

    .submit-btn .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.6s ease;
    }

    .submit-btn:hover .btn-shine {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(78, 84, 200, 0.35);
    }

    .submit-btn:active {
        transform: translateY(0);
        box-shadow: 0 4px 16px rgba(78, 84, 200, 0.25);
    }

    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .submit-btn.loading {
        pointer-events: none;
    }

    .submit-btn .spinner {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: none;
    }

    .submit-btn.loading .spinner {
        display: block;
    }

    .submit-btn.loading .btn-label {
        display: none;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    .reset-btn {
        padding: 14px 18px;
        border: 2px solid var(--border);
        border-radius: 14px;
        background: #fff;
        color: var(--text-secondary);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .reset-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: #fef5f5;
        transform: translateY(-1px);
    }

    /* ========== SIDEBAR PREVIEW ========== */
    .preview-card {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: sticky;
        top: 24px;
    }

    .preview-header {
        padding: 14px 20px;
        background: linear-gradient(135deg, #f8f9fe, #f0f1ff);
        border-bottom: 1px solid #eef0f8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-header .preview-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--success);
        animation: pulse-dot 2s infinite;
        box-shadow: 0 0 0 3px rgba(0, 184, 148, 0.15);
    }

    @keyframes pulse-dot {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.6;
            transform: scale(0.85);
        }
    }

    .preview-header span {
        font-weight: 700;
        font-size: 0.76rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .preview-body {
        padding: 20px;
    }

    /* Mini Pool Card Preview */
    .mini-pool-card {
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1.5px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
    }

    .mini-pool-card:hover {
        box-shadow: var(--shadow-glow);
        border-color: rgba(78, 84, 200, 0.15);
    }

    .mini-card-accent {
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light), var(--accent-light));
        background-size: 200% 100%;
        animation: shimmer-accent 3s ease infinite;
    }

    @keyframes shimmer-accent {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .mini-card-body {
        padding: 16px;
    }

    .mini-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .mini-pool-name {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--text-primary);
        word-break: break-word;
        line-height: 1.3;
        min-height: 20px;
        flex: 1;
    }

    .mini-pool-name.placeholder {
        color: var(--text-muted);
        font-style: italic;
        font-weight: 400;
        font-size: 0.85rem;
    }

    .mini-price-tag {
        padding: 4px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--success), #27ae60);
        color: #fff;
        font-weight: 700;
        font-size: 0.75rem;
        white-space: nowrap;
        flex-shrink: 0;
        transition: all 0.3s ease;
        letter-spacing: 0.3px;
    }

    .mini-price-tag.free {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .mini-host-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 14px;
        padding: 8px 10px;
        background: #f8f9fc;
        border-radius: 8px;
    }

    .mini-host-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.58rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .mini-host-name {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .mini-host-badge {
        font-size: 0.58rem;
        background: var(--primary-ultra);
        color: var(--primary);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        margin-left: auto;
    }

    .mini-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 14px;
    }

    .mini-stat {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
        border: 1px solid #f0f2f8;
        transition: all 0.3s ease;
    }

    .mini-stat:hover {
        background: var(--primary-ultra);
        border-color: rgba(78, 84, 200, 0.1);
    }

    .mini-stat .ms-val {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--text-primary);
        line-height: 1;
    }

    .mini-stat .ms-lbl {
        font-size: 0.6rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
        font-weight: 600;
    }

    .mini-progress {
        margin-bottom: 14px;
    }

    .mini-progress-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }

    .mini-progress-info span {
        font-size: 0.62rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .mini-progress-bar {
        width: 100%;
        height: 5px;
        border-radius: 3px;
        background: #eef0f5;
        overflow: hidden;
    }

    .mini-progress-fill {
        height: 100%;
        width: 0%;
        border-radius: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mini-join-btn {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 0.78rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: default;
        opacity: 0.85;
        letter-spacing: 0.3px;
    }

    /* Preview Tips */
    .preview-tips {
        margin-top: 22px;
    }

    .preview-tips .tip-title {
        font-weight: 700;
        font-size: 0.76rem;
        color: var(--text-secondary);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .preview-tips .tip-title i {
        color: #f39c12;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f5f6fa;
    }

    .tip-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .tip-icon {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.58rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .tip-icon.info {
        background: var(--primary-ultra);
        color: var(--primary);
    }

    .tip-icon.warn {
        background: var(--warning-light);
        color: var(--warning);
    }

    .tip-icon.good {
        background: var(--success-light);
        color: var(--success);
    }

    .tip-text {
        font-size: 0.72rem;
        color: var(--text-secondary);
        line-height: 1.45;
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
    }

    .delay-1 {
        animation-delay: 0.05s;
    }

    .delay-2 {
        animation-delay: 0.15s;
    }

    .delay-3 {
        animation-delay: 0.25s;
    }

    .delay-4 {
        animation-delay: 0.35s;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 992px) {
        .create-pool-wrapper {
            grid-template-columns: 1fr;
        }

        .preview-card {
            position: static;
            order: -1;
        }

        .preview-tips {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .create-pool-page {
            padding: 16px 0 40px;
        }

        .page-bg-deco {
            height: 260px;
        }

        .page-title-bar h2 {
            font-size: 1.3rem;
        }

        .page-title-bar h2 .title-emoji {
            font-size: 1.5rem;
        }

        .form-header {
            padding: 20px;
        }

        .form-header h3 {
            font-size: 1.05rem;
        }

        .form-body {
            padding: 22px 18px;
        }

        .step-indicator {
            margin-bottom: 24px;
            padding: 12px 14px;
        }

        .step-label {
            display: none;
        }

        .submit-section {
            flex-direction: column;
        }

        .submit-btn,
        .reset-btn {
            width: 100%;
            justify-content: center;
        }

        .form-header-icon {
            width: 40px;
            height: 40px;
            font-size: 1.15rem;
            border-radius: 11px;
        }

        .form-header-content {
            gap: 12px;
        }

        .back-link {
            margin-bottom: 14px;
            font-size: 0.78rem;
            padding: 6px 12px;
        }
    }

    @media (max-width: 380px) {
        .form-body {
            padding: 18px 14px;
        }

        .step-indicator {
            padding: 10px 12px;
        }

        .quick-btn {
            padding: 4px 10px;
            font-size: 0.68rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- BG DECORATION -->
<div class="page-bg-deco"></div>

<div class="create-pool-page">
    <div class="container">

        <!-- BACK LINK -->
        <a href="<?= base_url('pool') ?>" class="back-link animate-in delay-1">
            <i class="fas fa-arrow-left"></i>
            Back to Pools
        </a>

        <!-- PAGE TITLE -->
        <div class="page-title-bar animate-in delay-1 text-dark">
            <h2>
                <span class="title-emoji">🏏</span>
                Create New Pool
            </h2>
            <div class="page-desc">Set up your cricket pool and invite players</div>
        </div>

        <div class="create-pool-wrapper">

            <!-- ========== FORM CARD ========== -->
            <div class="form-card animate-in delay-2">

                <div class="form-header">
                    <div class="form-header-content">
                        <div class="form-header-icon">⚡</div>
                        <div>
                            <h3>Pool Details</h3>
                            <div class="form-subtitle">Fill in the required information below</div>
                        </div>
                    </div>
                </div>

                <div class="form-body">

                    <!-- STEP INDICATOR -->
                    <div class="step-indicator">
                        <div class="step-item">
                            <div class="step-circle active" id="step1Circle">1</div>
                            <span class="step-label active" id="step1Label">Name</span>
                        </div>
                        <div class="step-line" id="line1">
                            <div class="step-line-fill"></div>
                        </div>
                        <div class="step-item">
                            <div class="step-circle" id="step2Circle">2</div>
                            <span class="step-label" id="step2Label">Capacity</span>
                        </div>
                        <div class="step-line" id="line2">
                            <div class="step-line-fill"></div>
                        </div>
                        <div class="step-item">
                            <div class="step-circle" id="step3Circle">3</div>
                            <span class="step-label" id="step3Label">Pricing</span>
                        </div>
                    </div>

                    <form method="post" action="<?= base_url('pool/store') ?>" id="poolForm" novalidate>

                        <!-- SECTION 1: BASIC INFO -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-num">1</span>
                                Basic Information
                            </div>

                            <!-- POOL NAME -->
                            <div class="form-group">
                                <div class="form-label-row">
                                    <label class="form-label">
                                        <span class="label-icon name"><i class="fas fa-tag"></i></span>
                                        Pool Name <span class="required">*</span>
                                    </label>
                                    <span class="form-hint" id="nameHint">0/50</span>
                                </div>
                                <input type="text"
                                    name="pool_name"
                                    class="form-input"
                                    id="poolName"
                                    placeholder="e.g. IPL Champions League"
                                    maxlength="50"
                                    required
                                    autocomplete="off"
                                    oninput="updatePreview(); validateField('name')">
                                <div class="validation-msg" id="nameValidation">
                                    <i class="fas fa-info-circle"></i>
                                    <span></span>
                                </div>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="form-group">
                                <div class="form-label-row">
                                    <label class="form-label">
                                        <span class="label-icon desc"><i class="fas fa-align-left"></i></span>
                                        Description
                                    </label>
                                    <span class="form-hint">Optional</span>
                                </div>
                                <textarea name="description"
                                    class="form-textarea"
                                    id="poolDesc"
                                    placeholder="Describe your pool rules, prizes, or any details..."
                                    maxlength="200"
                                    oninput="updateCharCount()"></textarea>
                                <div class="char-count"><span id="charCount">0</span>/200</div>
                            </div>
                        </div>

                        <!-- SECTION 2: SETTINGS -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-num">2</span>
                                Pool Settings
                            </div>

                            <!-- USER LIMIT -->
                            <div class="form-group">
                                <div class="form-label-row">
                                    <label class="form-label">
                                        <span class="label-icon limit"><i class="fas fa-users"></i></span>
                                        Player Limit <span class="required">*</span>
                                    </label>
                                    <span class="form-hint">2 – 1000</span>
                                </div>
                                <div class="input-wrapper">
                                    <input type="number"
                                        name="user_limit"
                                        class="form-input"
                                        id="userLimit"
                                        placeholder="e.g. 50"
                                        min="2"
                                        max="1000"
                                        required
                                        oninput="updatePreview(); validateField('limit')">
                                    <span class="input-suffix">players</span>
                                </div>
                                <div class="quick-btns">
                                    <button type="button" class="quick-btn orange" onclick="setLimit(10)">10</button>
                                    <button type="button" class="quick-btn orange" onclick="setLimit(20)">20</button>
                                    <button type="button" class="quick-btn orange" onclick="setLimit(50)">50</button>
                                    <button type="button" class="quick-btn orange" onclick="setLimit(100)">100</button>
                                    <button type="button" class="quick-btn orange" onclick="setLimit(200)">200</button>
                                </div>
                                <div class="validation-msg" id="limitValidation">
                                    <i class="fas fa-info-circle"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: PRICING -->
                        <div class="form-section">
                            <div class="form-section-title">
                                <span class="section-num">3</span>
                                Entry Pricing
                            </div>

                            <!-- PRICE -->
                            <div class="form-group">
                                <div class="form-label-row">
                                    <label class="form-label">
                                        <span class="label-icon price"><i class="fas fa-rupee-sign"></i></span>
                                        Entry Price <span class="required">*</span>
                                    </label>
                                    <span class="form-hint">Per player</span>
                                </div>
                                <div class="input-wrapper">
                                    <span class="input-prefix">₹</span>
                                    <input type="number"
                                        name="price"
                                        class="form-input has-prefix"
                                        id="poolPrice"
                                        placeholder="0"
                                        min="0"
                                        max="100000"
                                        required
                                        oninput="updatePreview(); validateField('price')">
                                </div>
                                <div class="quick-btns">
                                    <button type="button" class="quick-btn" onclick="setPrice(0)">Free</button>
                                    <button type="button" class="quick-btn" onclick="setPrice(50)">₹50</button>
                                    <button type="button" class="quick-btn" onclick="setPrice(100)">₹100</button>
                                    <button type="button" class="quick-btn" onclick="setPrice(200)">₹200</button>
                                    <button type="button" class="quick-btn" onclick="setPrice(500)">₹500</button>
                                </div>
                                <div class="validation-msg" id="priceValidation">
                                    <i class="fas fa-info-circle"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <!-- SUBMIT -->
                        <div class="submit-section">
                            <button type="submit" class="submit-btn" id="submitBtn">
                                <span class="btn-shine"></span>
                                <span class="btn-label"><i class="fas fa-plus-circle"></i> Create Pool</span>
                                <span class="spinner"></span>
                            </button>
                            <button type="reset" class="reset-btn" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- ========== SIDEBAR PREVIEW ========== -->
            <div class="animate-in delay-3">
                <div class="preview-card">
                    <div class="preview-header">
                        <div class="preview-dot"></div>
                        <span>Live Preview</span>
                    </div>
                    <div class="preview-body">

                        <div class="mini-pool-card">
                            <div class="mini-card-accent" id="previewAccent"></div>
                            <div class="mini-card-body">
                                <div class="mini-card-top">
                                    <div class="mini-pool-name placeholder" id="previewName">Pool Name</div>
                                    <div class="mini-price-tag" id="previewPrice">₹0</div>
                                </div>
                                <div class="mini-host-row">
                                    <div class="mini-host-avatar">
                                        <?= strtoupper(substr($user['name'] ?? 'H', 0, 1)) ?>
                                    </div>
                                    <span class="mini-host-name"><?= $user['name'] ?? 'You' ?></span>
                                    <span class="mini-host-badge">HOST</span>
                                </div>
                                <div class="mini-stats">
                                    <div class="mini-stat">
                                        <div class="ms-val" id="previewLimit">—</div>
                                        <div class="ms-lbl">Limit</div>
                                    </div>
                                    <div class="mini-stat">
                                        <div class="ms-val">0</div>
                                        <div class="ms-lbl">Joined</div>
                                    </div>
                                </div>
                                <div class="mini-progress">
                                    <div class="mini-progress-info">
                                        <span>0 joined</span>
                                        <span id="previewLimitLabel">— slots</span>
                                    </div>
                                    <div class="mini-progress-bar">
                                        <div class="mini-progress-fill"></div>
                                    </div>
                                </div>
                                <div class="mini-join-btn">
                                    <i class="fas fa-sign-in-alt"></i> Join Pool
                                </div>
                            </div>
                        </div>

                        <!-- TIPS -->
                        <div class="preview-tips">
                            <div class="tip-title">
                                <i class="fas fa-lightbulb"></i> Quick Tips
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon info"><i class="fas fa-info"></i></div>
                                <span class="tip-text">Choose a clear, descriptive name so players can easily find your pool</span>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon warn"><i class="fas fa-exclamation"></i></div>
                                <span class="tip-text">Player limit cannot be changed once someone joins the pool</span>
                            </div>
                            <div class="tip-item">
                                <div class="tip-icon good"><i class="fas fa-check"></i></div>
                                <span class="tip-text">Set entry price to ₹0 to create a free pool for practice games</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    // ========== LIVE PREVIEW ==========
    function updatePreview() {
        const name = document.getElementById('poolName').value.trim();
        const limit = document.getElementById('userLimit').value;
        const price = document.getElementById('poolPrice').value;

        // Name
        const previewName = document.getElementById('previewName');
        if (name) {
            previewName.textContent = name;
            previewName.classList.remove('placeholder');
        } else {
            previewName.textContent = 'Pool Name';
            previewName.classList.add('placeholder');
        }

        // Limit
        const limitVal = parseInt(limit) || 0;
        document.getElementById('previewLimit').textContent = limitVal || '—';
        document.getElementById('previewLimitLabel').textContent = limitVal ? limitVal + ' slots' : '— slots';

        // Price
        const previewPrice = document.getElementById('previewPrice');
        const priceVal = parseFloat(price) || 0;
        if (priceVal === 0) {
            previewPrice.textContent = 'FREE';
            previewPrice.classList.add('free');
        } else {
            previewPrice.textContent = '₹' + priceVal.toLocaleString('en-IN');
            previewPrice.classList.remove('free');
        }

        // Name hint
        document.getElementById('nameHint').textContent = (name.length || 0) + '/50';

        // Update steps
        updateSteps();
    }

    // ========== STEP INDICATOR ==========
    function updateSteps() {
        const name = document.getElementById('poolName').value.trim();
        const limit = document.getElementById('userLimit').value;
        const price = document.getElementById('poolPrice').value;

        const s1 = document.getElementById('step1Circle');
        const s2 = document.getElementById('step2Circle');
        const s3 = document.getElementById('step3Circle');
        const l1 = document.getElementById('step1Label');
        const l2 = document.getElementById('step2Label');
        const l3 = document.getElementById('step3Label');
        const line1 = document.getElementById('line1');
        const line2 = document.getElementById('line2');

        // Step 1: Name
        if (name.length >= 3) {
            s1.className = 'step-circle done';
            s1.innerHTML = '<i class="fas fa-check" style="font-size:0.65rem"></i>';
            l1.className = 'step-label done';
            line1.classList.add('done');
            s2.className = 'step-circle active';
            l2.className = 'step-label active';
        } else {
            s1.className = 'step-circle active';
            s1.textContent = '1';
            l1.className = 'step-label active';
            line1.classList.remove('done');
            s2.className = 'step-circle';
            l2.className = 'step-label';
        }

        // Step 2: Limit
        if (name.length >= 3 && limit >= 2) {
            s2.className = 'step-circle done';
            s2.innerHTML = '<i class="fas fa-check" style="font-size:0.65rem"></i>';
            l2.className = 'step-label done';
            line2.classList.add('done');
            s3.className = 'step-circle active';
            l3.className = 'step-label active';
        } else if (name.length >= 3) {
            s2.className = 'step-circle active';
            s2.textContent = '2';
            l2.className = 'step-label active';
            line2.classList.remove('done');
            s3.className = 'step-circle';
            l3.className = 'step-label';
        } else {
            s2.className = 'step-circle';
            s2.textContent = '2';
            l2.className = 'step-label';
            line2.classList.remove('done');
            s3.className = 'step-circle';
            l3.className = 'step-label';
        }

        // Step 3: Price
        if (name.length >= 3 && limit >= 2 && price !== '') {
            s3.className = 'step-circle done';
            s3.innerHTML = '<i class="fas fa-check" style="font-size:0.65rem"></i>';
            l3.className = 'step-label done';
        } else if (name.length >= 3 && limit >= 2) {
            s3.className = 'step-circle active';
            s3.textContent = '3';
            l3.className = 'step-label active';
        } else {
            s3.className = 'step-circle';
            s3.textContent = '3';
            l3.className = 'step-label';
        }
    }

    // ========== VALIDATION ==========
    function validateField(field) {
        if (field === 'name') {
            const val = document.getElementById('poolName').value.trim();
            const input = document.getElementById('poolName');
            const msg = document.getElementById('nameValidation');
            const msgText = msg.querySelector('span');
            const msgIcon = msg.querySelector('i');

            if (val.length === 0) {
                input.classList.remove('valid', 'error');
                msg.classList.remove('show');
            } else if (val.length < 3) {
                input.classList.add('error');
                input.classList.remove('valid');
                msg.className = 'validation-msg show error';
                msgIcon.className = 'fas fa-exclamation-circle';
                msgText.textContent = 'Name must be at least 3 characters';
            } else {
                input.classList.add('valid');
                input.classList.remove('error');
                msg.className = 'validation-msg show success';
                msgIcon.className = 'fas fa-check-circle';
                msgText.textContent = 'Looks good!';
            }
        }

        if (field === 'limit') {
            const val = parseInt(document.getElementById('userLimit').value);
            const input = document.getElementById('userLimit');
            const msg = document.getElementById('limitValidation');
            const msgText = msg.querySelector('span');
            const msgIcon = msg.querySelector('i');

            if (!val && val !== 0) {
                input.classList.remove('valid', 'error');
                msg.classList.remove('show');
            } else if (val < 2) {
                input.classList.add('error');
                input.classList.remove('valid');
                msg.className = 'validation-msg show error';
                msgIcon.className = 'fas fa-exclamation-circle';
                msgText.textContent = 'Minimum 2 players required';
            } else if (val > 1000) {
                input.classList.add('error');
                input.classList.remove('valid');
                msg.className = 'validation-msg show error';
                msgIcon.className = 'fas fa-exclamation-circle';
                msgText.textContent = 'Maximum 1000 players allowed';
            } else {
                input.classList.add('valid');
                input.classList.remove('error');
                msg.className = 'validation-msg show success';
                msgIcon.className = 'fas fa-check-circle';
                msgText.textContent = val + ' players capacity';
            }
        }

        if (field === 'price') {
            const val = parseFloat(document.getElementById('poolPrice').value);
            const input = document.getElementById('poolPrice');
            const msg = document.getElementById('priceValidation');
            const msgText = msg.querySelector('span');
            const msgIcon = msg.querySelector('i');

            if (isNaN(val)) {
                input.classList.remove('valid', 'error');
                msg.classList.remove('show');
            } else if (val < 0) {
                input.classList.add('error');
                input.classList.remove('valid');
                msg.className = 'validation-msg show error';
                msgIcon.className = 'fas fa-exclamation-circle';
                msgText.textContent = 'Price cannot be negative';
            } else {
                input.classList.add('valid');
                input.classList.remove('error');
                msg.className = 'validation-msg show success';
                msgIcon.className = 'fas fa-check-circle';
                msgText.textContent = val === 0 ? 'Free pool — great for casual play!' : '₹' + val.toLocaleString('en-IN') + ' per player';
            }
        }
    }

    // ========== QUICK SET HELPERS ==========
    function setPrice(val) {
        const input = document.getElementById('poolPrice');
        input.value = val;
        updatePreview();
        validateField('price');
        document.querySelectorAll('.form-section:last-of-type .quick-btn').forEach(b => b.classList.remove('active'));
        event.target.classList.add('active');
    }

    function setLimit(val) {
        const input = document.getElementById('userLimit');
        input.value = val;
        updatePreview();
        validateField('limit');
        document.querySelectorAll('.quick-btn.orange').forEach(b => b.classList.remove('active'));
        event.target.classList.add('active');
    }

    // ========== CHAR COUNT ==========
    function updateCharCount() {
        const val = document.getElementById('poolDesc').value;
        document.getElementById('charCount').textContent = val.length;
    }

    // ========== FORM SUBMIT ==========
    document.getElementById('poolForm')?.addEventListener('submit', function(e) {
        const name = document.getElementById('poolName').value.trim();
        const limit = parseInt(document.getElementById('userLimit').value);
        const price = document.getElementById('poolPrice').value;
        let hasError = false;

        if (name.length < 3) {
            validateField('name');
            hasError = true;
        }
        if (!limit || limit < 2 || limit > 1000) {
            validateField('limit');
            hasError = true;
        }
        if (price === '' || parseFloat(price) < 0) {
            validateField('price');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            const firstError = document.querySelector('.form-input.error');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
            }
            return;
        }

        document.getElementById('submitBtn').classList.add('loading');
    });

    // ========== RESET FORM ==========
    function resetForm() {
        setTimeout(() => {
            document.querySelectorAll('.form-input, .form-textarea').forEach(i => {
                i.classList.remove('valid', 'error');
            });
            document.querySelectorAll('.validation-msg').forEach(m => {
                m.className = 'validation-msg';
            });
            document.querySelectorAll('.quick-btn').forEach(b => {
                b.classList.remove('active');
            });
            document.getElementById('charCount').textContent = '0';
            document.getElementById('nameHint').textContent = '0/50';
            updatePreview();
        }, 50);
    }
</script>