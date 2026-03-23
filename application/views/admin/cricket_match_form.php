<?php
$startValue = !empty($match['start_at']) ? date('Y-m-d\TH:i', strtotime($match['start_at'])) : '';
$actionUrl = (int) ($match['id'] ?? 0) > 0
    ? base_url('admin/cricket_matches/update/' . (int) $match['id'])
    : base_url('admin/cricket_matches/store');

$homeLogo = trim((string) ($match['home_logo'] ?? ''));
$awayLogo = trim((string) ($match['away_logo'] ?? ''));
$homeTeam = trim((string) ($match['team_home'] ?? 'Home'));
$awayTeam = trim((string) ($match['team_away'] ?? 'Away'));
$competitionName = trim((string) ($match['competition_name'] ?? 'Friendly Match'));
$venue = trim((string) ($match['venue'] ?? 'Venue not added'));
$statusValue = (string) ($match['admin_status'] ?? 'scheduled');
$statusLabels = [
    'scheduled' => 'Scheduled',
    'live' => 'Live',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled',
];
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=swap');

    .cricket-form-page {
        --bg: linear-gradient(180deg, #f5f8ff 0%, #eef3fb 100%);
        --card: #ffffff;
        --border: #dce4f2;
        --border-strong: #c9d6ee;
        --text: #182033;
        --muted: #6b7892;
        --navy: #12203d;
        --navy-2: #1a2a4f;
        --blue: #1683ff;
        --blue-soft: #e9f3ff;
        --green: #16c47f;
        --green-soft: #eafbf4;
        --red: #ff5f6d;
        --red-soft: #ffedf0;
        --shadow: 0 18px 45px rgba(16, 35, 74, 0.08);
        --shadow-soft: 0 10px 28px rgba(16, 35, 74, 0.06);
        font-family: 'Space Grotesk', sans-serif;
        color: var(--text);
    }

    .cricket-form-page *,
    .cricket-form-page *::before,
    .cricket-form-page *::after {
        box-sizing: border-box;
    }

    .cricket-form-page .page-title,
    .cricket-form-page .section-title,
    .cricket-form-page .preview-matchup,
    .cricket-form-page .btn,
    .cricket-form-page .meta-value {
        font-family: 'Barlow', sans-serif;
    }

    /* ── Dashboard Shell ── */
    .cricket-form-page .dashboard-shell {
        background: var(--bg);
        padding: 24px;
        border-radius: 28px;
    }

    /* ── Hero Panel ── */
    .cricket-form-page .hero-panel {
        background:
            radial-gradient(circle at top right, rgba(22, 131, 255, 0.16), transparent 28%),
            radial-gradient(circle at bottom left, rgba(22, 196, 127, 0.14), transparent 24%),
            linear-gradient(135deg, var(--navy) 0%, var(--navy-2) 100%);
        border-radius: 28px;
        padding: 28px 30px;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
    }

    .cricket-form-page .hero-panel::after {
        content: '';
        position: absolute;
        right: -40px;
        bottom: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
        pointer-events: none;
    }

    .cricket-form-page .hero-copy {
        position: relative;
        z-index: 1;
        max-width: 720px;
    }

    .cricket-form-page .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.88);
        font-size: 0.82rem;
        margin-bottom: 14px;
    }

    .cricket-form-page .page-title {
        font-size: 2.15rem;
        line-height: 1.1;
        font-weight: 800;
        margin: 0 0 10px;
    }

    .cricket-form-page .page-subtitle {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.98rem;
        max-width: 640px;
        line-height: 1.5;
    }

    .cricket-form-page .hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .cricket-form-page .hero-btn {
        border: 0;
        border-radius: 16px;
        padding: 14px 20px;
        font-size: 1rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .cricket-form-page .hero-btn:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .cricket-form-page .hero-btn.primary {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.16);
    }

    .cricket-form-page .hero-btn.secondary {
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.14);
    }

    /* ── Alerts ── */
    .cricket-form-page .alert {
        border: 0;
        border-radius: 18px;
        box-shadow: var(--shadow-soft);
        margin-top: 20px;
        padding: 16px 20px;
        font-size: 0.95rem;
    }

    /* ── Editor Grid ── */
    .cricket-form-page .editor-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.75fr);
        gap: 22px;
        margin-top: 22px;
        align-items: start;
    }

    .cricket-form-page .editor-card,
    .cricket-form-page .preview-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 26px;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    .cricket-form-page .editor-card {
        padding: 24px;
    }

    .cricket-form-page .section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--blue);
        background: var(--blue-soft);
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .cricket-form-page .section-title {
        font-size: 1.32rem;
        font-weight: 800;
        margin: 0 0 6px;
        color: var(--text);
    }

    .cricket-form-page .section-copy {
        color: var(--muted);
        margin: 0 0 18px;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .cricket-form-page .form-section {
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid #eaf0fa;
    }

    .cricket-form-page .form-section:first-of-type {
        margin-top: 0;
        padding-top: 0;
        border-top: 0;
    }

    .cricket-form-page .form-label {
        color: var(--text);
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 0.92rem;
    }

    .cricket-form-page .form-control,
    .cricket-form-page .form-select {
        border-radius: 16px;
        min-height: 52px;
        border: 1px solid var(--border-strong);
        background: #f9fbff;
        box-shadow: none;
        font-size: 0.95rem;
        width: 100%;
    }

    .cricket-form-page .form-control:focus,
    .cricket-form-page .form-select:focus {
        border-color: #76afff;
        box-shadow: 0 0 0 4px rgba(22, 131, 255, 0.12);
        background: #fff;
        outline: none;
    }

    /* ── Upload Cards ── */
    .cricket-form-page .upload-card {
        border: 1px dashed #c8d7ef;
        border-radius: 22px;
        padding: 18px;
        background: linear-gradient(180deg, #fbfdff 0%, #f4f8ff 100%);
        height: 100%;
    }

    .cricket-form-page .upload-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .cricket-form-page .upload-title {
        font-family: 'Barlow', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: var(--text);
    }

    .cricket-form-page .upload-hint {
        font-size: 0.82rem;
        color: var(--muted);
    }

    .cricket-form-page .upload-badge {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .cricket-form-page .upload-badge.home {
        background: linear-gradient(135deg, #1da1ff, #0066ff);
    }

    .cricket-form-page .upload-badge.away {
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
    }

    .cricket-form-page .file-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        width: 0;
        height: 0;
    }

    .cricket-form-page .file-picker {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 54px;
        padding: 8px;
        border-radius: 18px;
        border: 1px solid var(--border-strong);
        background: #fff;
        overflow: hidden;
    }

    .cricket-form-page .file-picker-btn {
        min-height: 38px;
        padding: 0 16px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
        font-size: 0.88rem;
        border: none;
        transition: opacity 0.2s ease;
    }

    .cricket-form-page .file-picker-btn:hover {
        opacity: 0.9;
    }

    .cricket-form-page .file-picker-btn.home {
        background: linear-gradient(135deg, #1da1ff, #0066ff);
    }

    .cricket-form-page .file-picker-btn.away {
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
    }

    .cricket-form-page .file-picker-name {
        min-width: 0;
        color: var(--muted);
        font-size: 0.88rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    .cricket-form-page .logo-preview {
        margin-top: 18px;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: #fff;
        border: 1px solid #e5ecf8;
        padding: 14px;
    }

    .cricket-form-page .logo-preview img {
        width: 100%;
        max-width: 120px;
        height: 90px;
        object-fit: contain;
    }

    .cricket-form-page .logo-empty {
        text-align: center;
        color: var(--muted);
        font-size: 0.85rem;
    }

    .cricket-form-page .logo-empty i {
        display: block;
        font-size: 1.4rem;
        margin-bottom: 8px;
        color: #a4b2cd;
    }

    /* ── Schedule / Status Grid ── */
    .cricket-form-page .status-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 16px;
    }

    /* ── Preview Card ── */
    .cricket-form-page .preview-card {
        position: sticky;
        top: 18px;
    }

    .cricket-form-page .preview-head {
        padding: 18px 20px;
        background: linear-gradient(135deg, #f7fbff, #edf5ff);
        border-bottom: 1px solid #e5edf8;
    }

    .cricket-form-page .preview-body {
        padding: 20px;
    }

    .cricket-form-page .match-preview {
        background:
            radial-gradient(circle at top right, rgba(22, 131, 255, 0.16), transparent 30%),
            radial-gradient(circle at bottom left, rgba(22, 196, 127, 0.14), transparent 26%),
            linear-gradient(135deg, #12203d 0%, #1a2a4f 100%);
        border-radius: 24px;
        padding: 22px 18px;
        color: #fff;
        box-shadow: var(--shadow-soft);
    }

    .cricket-form-page .preview-league {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 18px;
        word-break: break-word;
    }

    .cricket-form-page .preview-matchup {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .cricket-form-page .preview-team {
        text-align: center;
        min-width: 0;
    }

    .cricket-form-page .preview-logo {
        width: 74px;
        height: 74px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        overflow: hidden;
        flex-shrink: 0;
    }

    .cricket-form-page .preview-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .cricket-form-page .preview-logo i {
        font-size: 1.6rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .cricket-form-page .preview-team-name {
        font-family: 'Barlow', sans-serif;
        font-weight: 800;
        font-size: 1.15rem;
        word-break: break-word;
        line-height: 1.2;
    }

    .cricket-form-page .preview-vs {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.26);
        font-family: 'Barlow', sans-serif;
        font-weight: 800;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .cricket-form-page .preview-meta {
        display: grid;
        gap: 10px;
        margin-top: 14px;
    }

    .cricket-form-page .meta-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.08);
    }

    .cricket-form-page .meta-row i {
        width: 28px;
        height: 28px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.08);
        color: #fff;
        flex-shrink: 0;
        font-size: 0.95rem;
    }

    .cricket-form-page .meta-content {
        min-width: 0;
        flex: 1;
    }

    .cricket-form-page .meta-value {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.2;
        word-break: break-word;
    }

    .cricket-form-page .meta-label {
        font-size: 0.74rem;
        color: rgba(255, 255, 255, 0.62);
        margin-top: 2px;
    }

    .cricket-form-page .status-pill {
        width: fit-content;
        padding: 9px 14px;
        border-radius: 999px;
        font-size: 0.84rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 18px;
    }

    .cricket-form-page .status-pill.scheduled {
        background: var(--blue-soft);
        color: #1668d8;
    }

    .cricket-form-page .status-pill.live {
        background: var(--red-soft);
        color: #d43749;
    }

    .cricket-form-page .status-pill.completed {
        background: var(--green-soft);
        color: #13915f;
    }

    .cricket-form-page .status-pill.cancelled {
        background: #eef1f7;
        color: #6f7b91;
    }

    /* ── Tips Panel ── */
    .cricket-form-page .tips-panel {
        margin-top: 18px;
        padding: 18px;
        border-radius: 20px;
        background: #f7fbff;
        border: 1px solid #e6eefb;
    }

    .cricket-form-page .tips-title {
        font-family: 'Barlow', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 12px;
        color: var(--text);
    }

    .cricket-form-page .tips-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: var(--muted);
        font-size: 0.88rem;
        margin-top: 10px;
        line-height: 1.45;
    }

    .cricket-form-page .tips-item i {
        color: var(--green);
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ── Form Actions ── */
    .cricket-form-page .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 26px;
        padding-top: 22px;
        border-top: 1px solid #eaf0fa;
    }

    .cricket-form-page .action-btn {
        min-height: 52px;
        border-radius: 16px;
        padding: 0 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        white-space: nowrap;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cricket-form-page .action-btn:hover {
        transform: translateY(-1px);
    }

    .cricket-form-page .action-btn.save {
        background: linear-gradient(135deg, #1da1ff 0%, #0066ff 100%);
        color: #fff;
        border: 0;
        box-shadow: 0 14px 28px rgba(0, 102, 255, 0.18);
    }

    .cricket-form-page .action-btn.save:hover {
        color: #fff;
        box-shadow: 0 16px 32px rgba(0, 102, 255, 0.24);
    }

    .cricket-form-page .action-btn.cancel {
        background: #fff;
        color: var(--text);
        border: 1px solid var(--border-strong);
    }

    .cricket-form-page .action-btn.cancel:hover {
        background: #f8faff;
    }

    .cricket-form-page .action-btn.ghost {
        background: #f7f9fd;
        color: var(--muted);
        border: 1px solid #e5edf8;
    }

    .cricket-form-page .action-btn.ghost:hover {
        background: #eef3fb;
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — LARGE TABLET (max 1199px)
       ══════════════════════════════════════════ */
    @media (max-width: 1199px) {
        .cricket-form-page .editor-grid {
            grid-template-columns: 1fr;
        }

        .cricket-form-page .preview-card {
            position: static;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — TABLET (max 991px)
       ══════════════════════════════════════════ */
    @media (max-width: 991px) {
        .cricket-form-page .dashboard-shell {
            padding: 16px;
            border-radius: 20px;
        }

        .cricket-form-page .hero-panel {
            padding: 22px;
            border-radius: 22px;
            flex-direction: column;
            align-items: flex-start;
        }

        .cricket-form-page .page-title {
            font-size: 1.7rem;
        }

        .cricket-form-page .hero-actions {
            width: 100%;
        }

        .cricket-form-page .hero-btn {
            flex: 1;
            justify-content: center;
            padding: 12px 16px;
            font-size: 0.92rem;
        }

        .cricket-form-page .editor-card {
            padding: 20px;
        }

        .cricket-form-page .preview-head {
            padding: 16px 18px;
        }

        .cricket-form-page .preview-body {
            padding: 16px;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — MOBILE (max 767px)
       ══════════════════════════════════════════ */
    @media (max-width: 767px) {
        .cricket-form-page .dashboard-shell {
            padding: 12px;
            border-radius: 16px;
        }

        .cricket-form-page .hero-panel {
            padding: 18px;
            border-radius: 18px;
            gap: 14px;
        }

        .cricket-form-page .hero-tag {
            font-size: 0.75rem;
            padding: 6px 10px;
            margin-bottom: 10px;
        }

        .cricket-form-page .page-title {
            font-size: 1.4rem;
        }

        .cricket-form-page .page-subtitle {
            font-size: 0.88rem;
        }

        .cricket-form-page .hero-actions {
            flex-direction: column;
            gap: 8px;
        }

        .cricket-form-page .hero-btn {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.9rem;
            border-radius: 12px;
        }

        /* Editor Card */
        .cricket-form-page .editor-grid {
            gap: 16px;
            margin-top: 16px;
        }

        .cricket-form-page .editor-card {
            padding: 16px;
            border-radius: 20px;
        }

        .cricket-form-page .section-kicker {
            font-size: 0.74rem;
            padding: 5px 10px;
            margin-bottom: 10px;
        }

        .cricket-form-page .section-title {
            font-size: 1.12rem;
        }

        .cricket-form-page .section-copy {
            font-size: 0.88rem;
            margin-bottom: 14px;
        }

        .cricket-form-page .form-section {
            margin-top: 18px;
            padding-top: 18px;
        }

        .cricket-form-page .form-control,
        .cricket-form-page .form-select {
            min-height: 48px;
            border-radius: 14px;
            font-size: 0.9rem;
        }

        /* Status Grid — stack on mobile */
        .cricket-form-page .status-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        /* Upload Cards */
        .cricket-form-page .upload-card {
            padding: 14px;
            border-radius: 18px;
        }

        .cricket-form-page .upload-title {
            font-size: 0.92rem;
        }

        .cricket-form-page .upload-hint {
            font-size: 0.78rem;
        }

        .cricket-form-page .upload-badge {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            font-size: 1rem;
        }

        .cricket-form-page .file-picker {
            min-height: 48px;
            padding: 6px;
            border-radius: 14px;
        }

        .cricket-form-page .file-picker-btn {
            min-height: 34px;
            padding: 0 12px;
            font-size: 0.82rem;
            border-radius: 10px;
        }

        .cricket-form-page .file-picker-name {
            font-size: 0.82rem;
        }

        .cricket-form-page .logo-preview {
            min-height: 100px;
            margin-top: 14px;
            border-radius: 16px;
            padding: 12px;
        }

        .cricket-form-page .logo-preview img {
            max-width: 100px;
            height: 80px;
        }

        /* Preview Card */
        .cricket-form-page .preview-card {
            border-radius: 20px;
        }

        .cricket-form-page .preview-head {
            padding: 14px 16px;
        }

        .cricket-form-page .preview-body {
            padding: 14px;
        }

        .cricket-form-page .match-preview {
            border-radius: 20px;
            padding: 18px 14px;
        }

        .cricket-form-page .preview-league {
            font-size: 0.78rem;
            padding: 6px 12px;
            margin-bottom: 16px;
        }

        .cricket-form-page .preview-matchup {
            gap: 8px;
            margin-bottom: 16px;
        }

        .cricket-form-page .preview-logo {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            margin-bottom: 8px;
        }

        .cricket-form-page .preview-logo i {
            font-size: 1.3rem;
        }

        .cricket-form-page .preview-team-name {
            font-size: 0.95rem;
        }

        .cricket-form-page .preview-vs {
            width: 36px;
            height: 36px;
            font-size: 0.75rem;
        }

        .cricket-form-page .meta-row {
            padding: 8px 10px;
            border-radius: 14px;
            gap: 8px;
        }

        .cricket-form-page .meta-row i {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .cricket-form-page .meta-value {
            font-size: 0.88rem;
        }

        .cricket-form-page .meta-label {
            font-size: 0.7rem;
        }

        .cricket-form-page .status-pill {
            padding: 7px 12px;
            font-size: 0.8rem;
            margin-top: 14px;
        }

        /* Tips */
        .cricket-form-page .tips-panel {
            padding: 14px;
            border-radius: 16px;
            margin-top: 14px;
        }

        .cricket-form-page .tips-title {
            font-size: 0.92rem;
            margin-bottom: 10px;
        }

        .cricket-form-page .tips-item {
            font-size: 0.82rem;
            gap: 8px;
            margin-top: 8px;
        }

        /* Form Actions — stack on mobile */
        .cricket-form-page .form-actions {
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
            padding-top: 18px;
        }

        .cricket-form-page .action-btn {
            width: 100%;
            min-height: 48px;
            border-radius: 14px;
            padding: 0 18px;
            font-size: 0.92rem;
        }
    }

    /* ══════════════════════════════════════════
       RESPONSIVE — VERY SMALL (max 400px)
       ══════════════════════════════════════════ */
    @media (max-width: 400px) {
        .cricket-form-page .dashboard-shell {
            padding: 8px;
            border-radius: 12px;
        }

        .cricket-form-page .hero-panel {
            padding: 14px;
            border-radius: 14px;
        }

        .cricket-form-page .page-title {
            font-size: 1.2rem;
        }

        .cricket-form-page .page-subtitle {
            font-size: 0.82rem;
        }

        .cricket-form-page .editor-card {
            padding: 12px;
            border-radius: 16px;
        }

        .cricket-form-page .section-title {
            font-size: 1rem;
        }

        .cricket-form-page .match-preview {
            padding: 14px 12px;
            border-radius: 16px;
        }

        .cricket-form-page .preview-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
        }

        .cricket-form-page .preview-team-name {
            font-size: 0.85rem;
        }

        .cricket-form-page .preview-vs {
            width: 32px;
            height: 32px;
            font-size: 0.65rem;
        }

        .cricket-form-page .upload-head {
            margin-bottom: 10px;
        }

        .cricket-form-page .logo-preview {
            min-height: 80px;
        }

        .cricket-form-page .logo-preview img {
            max-width: 80px;
            height: 60px;
        }
    }
</style>

<div class="page-wrapper cricket-form-page">
    <div class="page-content">
        <div class="container-fluid">
            <div class="dashboard-shell">
                <!-- Hero Panel -->
                <div class="hero-panel">
                    <div class="hero-copy">
                        <div class="hero-tag">
                            <i class="bx bx-edit-alt"></i>
                            Cricket Match Editor
                        </div>
                        <h4 class="page-title" style="color: #fff;"><?= html_escape($page_title ?? 'Cricket Match') ?></h4>
                        <p class="page-subtitle">Build a clean cricket fixture with team identity, timing, and venue details that look sharp on the public match page.</p>
                    </div>
                    <div class="hero-actions">
                        <a href="<?= base_url('admin/cricket_matches') ?>" class="hero-btn secondary">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                        <button type="submit" form="cricketMatchForm" class="hero-btn primary">
                            <i class="bx bx-save"></i> Save Match
                        </button>
                    </div>
                </div>

                <!-- Flash Messages -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <!-- Editor Grid -->
                <div class="editor-grid">
                    <!-- Left: Form -->
                    <div class="editor-card">
                        <div class="section-kicker"><i class="bx bx-slider-alt"></i> Match Setup</div>
                        <h5 class="section-title">Fixture Details</h5>
                        <p class="section-copy">Fill the main match information below. Team names, logos, and schedule update the preview card.</p>

                        <form method="post" id="cricketMatchForm" action="<?= $actionUrl ?>" enctype="multipart/form-data">

                            <!-- Competition & Venue -->
                            <div class="form-section">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Competition Name</label>
                                        <input type="text" name="competition_name" class="form-control" value="<?= html_escape($match['competition_name'] ?? '') ?>" placeholder="IPL 2026">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Venue</label>
                                        <input type="text" name="venue" class="form-control" value="<?= html_escape($match['venue'] ?? '') ?>" placeholder="Narendra Modi Stadium">
                                    </div>
                                </div>
                            </div>

                            <!-- Teams -->
                            <div class="form-section">
                                <div class="section-kicker"><i class="bx bx-group"></i> Teams</div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label class="form-label">Home Team</label>
                                        <input type="text" name="team_home" id="inputTeamHome" class="form-control" value="<?= html_escape($match['team_home'] ?? '') ?>" placeholder="CSK" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label">Away Team</label>
                                        <input type="text" name="team_away" id="inputTeamAway" class="form-control" value="<?= html_escape($match['team_away'] ?? '') ?>" placeholder="RCB" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Logos -->
                            <div class="form-section">
                                <div class="section-kicker"><i class="bx bx-image-add"></i> Team Logos</div>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="upload-card">
                                            <div class="upload-head">
                                                <div>
                                                    <div class="upload-title">Home Logo</div>
                                                    <div class="upload-hint">PNG, JPG, WEBP, or GIF</div>
                                                </div>
                                                <span class="upload-badge home"><i class="bx bx-shield-quarter"></i></span>
                                            </div>
                                            <input type="file" name="home_logo" id="homeLogoInput" class="file-input" accept=".jpg,.jpeg,.png,.webp,.gif">
                                            <div class="file-picker">
                                                <label for="homeLogoInput" class="file-picker-btn home">Choose</label>
                                                <span class="file-picker-name" id="homeLogoFileName"><?= $homeLogo !== '' ? html_escape(basename($homeLogo)) : 'No file chosen' ?></span>
                                            </div>
                                            <div class="logo-preview" id="homeLogoPreview">
                                                <?php if ($homeLogo !== ''): ?>
                                                    <img src="<?= base_url($homeLogo) ?>" alt="Home Logo">
                                                <?php else: ?>
                                                    <div class="logo-empty"><i class="bx bx-image"></i>No logo uploaded</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="upload-card">
                                            <div class="upload-head">
                                                <div>
                                                    <div class="upload-title">Away Logo</div>
                                                    <div class="upload-hint">PNG, JPG, WEBP, or GIF</div>
                                                </div>
                                                <span class="upload-badge away"><i class="bx bx-flag"></i></span>
                                            </div>
                                            <input type="file" name="away_logo" id="awayLogoInput" class="file-input" accept=".jpg,.jpeg,.png,.webp,.gif">
                                            <div class="file-picker">
                                                <label for="awayLogoInput" class="file-picker-btn away">Choose</label>
                                                <span class="file-picker-name" id="awayLogoFileName"><?= $awayLogo !== '' ? html_escape(basename($awayLogo)) : 'No file chosen' ?></span>
                                            </div>
                                            <div class="logo-preview" id="awayLogoPreview">
                                                <?php if ($awayLogo !== ''): ?>
                                                    <img src="<?= base_url($awayLogo) ?>" alt="Away Logo">
                                                <?php else: ?>
                                                    <div class="logo-empty"><i class="bx bx-image"></i>No logo uploaded</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule & Status -->
                            <div class="form-section">
                                <div class="section-kicker"><i class="bx bx-time-five"></i> Schedule</div>
                                <div class="status-grid">
                                    <div>
                                        <label class="form-label">Start Date & Time</label>
                                        <input type="datetime-local" name="start_datetime" class="form-control d-none" value="<?= html_escape($startValue) ?>">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input type="date" name="start_date" id="inputStartDate" class="form-control" value="<?= $startValue ? date('Y-m-d', strtotime($match['start_at'])) : '' ?>" required>
                                            </div>
                                            <div class="col-6">
                                                <input type="time" name="start_time" id="inputStartTime" class="form-control" value="<?= $startValue ? date('H:i', strtotime($match['start_at'])) : '' ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label">Status</label>
                                        <select name="admin_status" id="inputStatus" class="form-select">
                                            <?php foreach ($statusLabels as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= $statusValue === $value ? 'selected' : '' ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="form-actions">
                                <button type="submit" class="action-btn save">
                                    <i class="bx bx-save"></i> Save Match
                                </button>
                                <a href="<?= base_url('admin/cricket_matches') ?>" class="action-btn cancel">
                                    <i class="bx bx-arrow-back"></i> Cancel
                                </a>
                                <a href="<?= base_url('admin/cricket_matches/create') ?>" class="action-btn ghost">
                                    <i class="bx bx-plus-circle"></i> New Match
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Right: Preview -->
                    <div class="preview-card">
                        <div class="preview-head">
                            <div class="section-kicker"><i class="bx bx-show"></i> Live Preview</div>
                            <h5 class="section-title">Public Match Card</h5>
                            <p class="section-copy mb-0">This reflects how the match will appear on your public page.</p>
                        </div>
                        <div class="preview-body">
                            <div class="match-preview">
                                <div class="preview-league" id="previewLeague">
                                    <i class="bx bx-trophy"></i>
                                    <span><?= html_escape($competitionName !== '' ? $competitionName : 'Friendly Match') ?></span>
                                </div>

                                <div class="preview-matchup">
                                    <div class="preview-team">
                                        <div class="preview-logo" id="homeLogoCardPreview">
                                            <?php if ($homeLogo !== ''): ?>
                                                <img src="<?= base_url($homeLogo) ?>" alt="<?= html_escape($homeTeam) ?>">
                                            <?php else: ?>
                                                <i class="bx bx-shield"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="preview-team-name" id="previewHomeName"><?= html_escape($homeTeam !== '' ? $homeTeam : 'HOME') ?></div>
                                    </div>
                                    <div class="preview-vs">VS</div>
                                    <div class="preview-team">
                                        <div class="preview-logo" id="awayLogoCardPreview">
                                            <?php if ($awayLogo !== ''): ?>
                                                <img src="<?= base_url($awayLogo) ?>" alt="<?= html_escape($awayTeam) ?>">
                                            <?php else: ?>
                                                <i class="bx bx-shield"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="preview-team-name" id="previewAwayName"><?= html_escape($awayTeam !== '' ? $awayTeam : 'AWAY') ?></div>
                                    </div>
                                </div>

                                <div class="preview-meta">
                                    <div class="meta-row">
                                        <i class="bx bx-calendar"></i>
                                        <div class="meta-content">
                                            <div class="meta-value" id="previewDate"><?= $startValue ? date('d M Y', strtotime($match['start_at'])) : 'Date not set' ?></div>
                                            <div class="meta-label">Match Date</div>
                                        </div>
                                    </div>
                                    <div class="meta-row">
                                        <i class="bx bx-time-five"></i>
                                        <div class="meta-content">
                                            <div class="meta-value" id="previewTime"><?= $startValue ? date('h:i A', strtotime($match['start_at'])) : 'Time not set' ?></div>
                                            <div class="meta-label">Start Time</div>
                                        </div>
                                    </div>
                                    <div class="meta-row">
                                        <i class="bx bx-map"></i>
                                        <div class="meta-content">
                                            <div class="meta-value" id="previewVenue"><?= html_escape($venue !== '' ? $venue : 'Venue not added') ?></div>
                                            <div class="meta-label">Venue</div>
                                        </div>
                                    </div>
                                </div>

                                <span class="status-pill <?= html_escape($statusValue) ?>" id="previewStatus">
                                    <i class="bx bx-radio-circle-marked"></i>
                                    <span><?= html_escape($statusLabels[$statusValue] ?? 'Scheduled') ?></span>
                                </span>
                            </div>

                            <div class="tips-panel">
                                <div class="tips-title">Quick Tips</div>
                                <div class="tips-item">
                                    <i class="bx bx-check-circle"></i>
                                    <span>Use short team codes like CSK and RCB so the public cards stay neat.</span>
                                </div>
                                <div class="tips-item">
                                    <i class="bx bx-check-circle"></i>
                                    <span>Transparent PNG logos usually look the cleanest on both admin and public pages.</span>
                                </div>
                                <div class="tips-item">
                                    <i class="bx bx-check-circle"></i>
                                    <span>Set the correct status before going live so the match appears in the right section.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        // ── Logo Preview Binding ──
        function bindLogoPreview(inputId, fileNameId, previewId, cardPreviewId, fallbackText) {
            var input = document.getElementById(inputId);
            var fileName = document.getElementById(fileNameId);
            var preview = document.getElementById(previewId);
            var cardPreview = document.getElementById(cardPreviewId);

            if (!input || !fileName || !preview || !cardPreview) return;

            var emptyPreviewHtml = '<div class="logo-empty"><i class="bx bx-image"></i>No logo uploaded</div>';
            var emptyCardHtml = '<i class="bx bx-shield"></i>';

            input.addEventListener('change', function() {
                var file = input.files && input.files[0] ? input.files[0] : null;

                if (!file) {
                    fileName.textContent = 'No file chosen';
                    if (!preview.querySelector('img')) {
                        preview.innerHTML = emptyPreviewHtml;
                    }
                    if (!cardPreview.querySelector('img')) {
                        cardPreview.innerHTML = emptyCardHtml;
                    }
                    return;
                }

                fileName.textContent = file.name;

                if (!file.type.match(/^image\//i)) {
                    preview.innerHTML = emptyPreviewHtml;
                    cardPreview.innerHTML = emptyCardHtml;
                    return;
                }

                var objectUrl = URL.createObjectURL(file);
                preview.innerHTML = '<img src="' + objectUrl + '" alt="' + fallbackText + ' logo">';
                cardPreview.innerHTML = '<img src="' + objectUrl + '" alt="' + fallbackText + ' logo">';
            });
        }

        bindLogoPreview('homeLogoInput', 'homeLogoFileName', 'homeLogoPreview', 'homeLogoCardPreview', 'Home team');
        bindLogoPreview('awayLogoInput', 'awayLogoFileName', 'awayLogoPreview', 'awayLogoCardPreview', 'Away team');

        // ── Live Preview Updates ──
        var inputTeamHome = document.getElementById('inputTeamHome');
        var inputTeamAway = document.getElementById('inputTeamAway');
        var inputStartDate = document.getElementById('inputStartDate');
        var inputStartTime = document.getElementById('inputStartTime');
        var inputStatus = document.getElementById('inputStatus');
        var inputCompetition = document.querySelector('[name="competition_name"]');
        var inputVenue = document.querySelector('[name="venue"]');

        var previewHomeName = document.getElementById('previewHomeName');
        var previewAwayName = document.getElementById('previewAwayName');
        var previewDate = document.getElementById('previewDate');
        var previewTime = document.getElementById('previewTime');
        var previewVenue = document.getElementById('previewVenue');
        var previewStatus = document.getElementById('previewStatus');
        var previewLeague = document.getElementById('previewLeague');

        var statusLabels = {
            'scheduled': 'Scheduled',
            'live': 'Live',
            'completed': 'Completed',
            'cancelled': 'Cancelled'
        };

        function safeText(val, fallback) {
            var trimmed = (val || '').trim();
            return trimmed !== '' ? trimmed : fallback;
        }

        function formatDate(dateStr) {
            if (!dateStr) return 'Date not set';
            var parts = dateStr.split('-');
            if (parts.length !== 3) return dateStr;
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var monthIndex = parseInt(parts[1], 10) - 1;
            return parts[2] + ' ' + (months[monthIndex] || parts[1]) + ' ' + parts[0];
        }

        function formatTime(timeStr) {
            if (!timeStr) return 'Time not set';
            var parts = timeStr.split(':');
            if (parts.length < 2) return timeStr;
            var h = parseInt(parts[0], 10);
            var m = parts[1];
            var ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12;
            if (h === 0) h = 12;
            return (h < 10 ? '0' : '') + h + ':' + m + ' ' + ampm;
        }

        if (inputTeamHome && previewHomeName) {
            inputTeamHome.addEventListener('input', function() {
                previewHomeName.textContent = safeText(inputTeamHome.value, 'HOME');
            });
        }

        if (inputTeamAway && previewAwayName) {
            inputTeamAway.addEventListener('input', function() {
                previewAwayName.textContent = safeText(inputTeamAway.value, 'AWAY');
            });
        }

        if (inputStartDate && previewDate) {
            inputStartDate.addEventListener('change', function() {
                previewDate.textContent = formatDate(inputStartDate.value);
            });
        }

        if (inputStartTime && previewTime) {
            inputStartTime.addEventListener('change', function() {
                previewTime.textContent = formatTime(inputStartTime.value);
            });
        }

        if (inputVenue && previewVenue) {
            inputVenue.addEventListener('input', function() {
                previewVenue.textContent = safeText(inputVenue.value, 'Venue not added');
            });
        }

        if (inputCompetition && previewLeague) {
            inputCompetition.addEventListener('input', function() {
                var spanEl = previewLeague.querySelector('span');
                if (spanEl) {
                    spanEl.textContent = safeText(inputCompetition.value, 'Friendly Match');
                }
            });
        }

        if (inputStatus && previewStatus) {
            inputStatus.addEventListener('change', function() {
                var val = inputStatus.value;
                previewStatus.className = 'status-pill ' + val;
                var spanEl = previewStatus.querySelector('span');
                if (spanEl) {
                    spanEl.textContent = statusLabels[val] || 'Scheduled';
                }
            });
        }
    })();
</script>