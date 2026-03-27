<?php
$renderCricketTeamAvatar = function ($logoUrl, $teamName) {
    $fallback = html_escape(strtoupper(substr(trim((string) $teamName), 0, 1) ?: 'T'));

    if (!empty($logoUrl)) {
        return '<img src="' . html_escape($logoUrl) . '" alt="' . html_escape($teamName) . '" onerror="this.onerror=null; this.parentNode.innerHTML=\'<span>' . $fallback . '</span>\';">';
    }

    return '<span>' . $fallback . '</span>';
};
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #1a1a2e;
        --secondary: #16213e;
        --accent: #e94560;
        --accent-light: #ff6b81;
        --gold: #f1c40f;
        --green: #2ecc71;
        --dark: #0f0f23;
        --light: #f0f2f5;
        --card-bg: #ffffff;
        --text-primary: #1a1a2e;
        --text-secondary: #6c757d;
        --border-light: rgba(0, 0, 0, 0.06);
        --shadow-sm: 0 2px 12px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 12px 48px rgba(0, 0, 0, 0.12);
        --radius-sm: 10px;
        --radius-md: 16px;
        --radius-lg: 20px;
        --radius-xl: 24px;
        --header-height: 68px;
        --safe-bottom: env(safe-area-inset-bottom, 0px);
        --safe-left: env(safe-area-inset-left, 0px);
        --safe-right: env(safe-area-inset-right, 0px);
    }

    body.cricket-page {
        background: var(--light) !important;
        font-family: 'Poppins', sans-serif !important;
        color: var(--text-primary);
        overflow-x: hidden;
        padding-top: 0 !important;
        margin-top: 0 !important;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
    }

    /* ========== CONTAINER - responsive widths ========== */
    .ck-container {
        width: 100%;
        margin: 0 auto;
        padding-left: max(16px, var(--safe-left));
        padding-right: max(16px, var(--safe-right));
    }

    @media (min-width: 576px) {
        .ck-container {
            max-width: 540px;
        }
    }

    @media (min-width: 768px) {
        .ck-container {
            max-width: 720px;
            padding-left: 20px;
            padding-right: 20px;
        }
    }

    @media (min-width: 992px) {
        .ck-container {
            max-width: 960px;
            padding-left: 24px;
            padding-right: 24px;
        }
    }

    @media (min-width: 1200px) {
        .ck-container {
            max-width: 1140px;
        }
    }

    @media (min-width: 1400px) {
        .ck-container {
            max-width: 1280px;
        }
    }

    /* ========== ANIMATIONS ========== */
    @keyframes pulse-dot {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.4);
            opacity: 0.7;
        }
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }
    }

    @keyframes pulse-badge {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(233, 69, 96, 0.4);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(233, 69, 96, 0);
        }
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse-icon {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes pulse-play {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.15);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-in {
        animation: fadeInUp 0.5s ease forwards;
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

    .delay-5 {
        animation-delay: 0.45s;
    }

    /* ========== MAIN CONTENT ========== */
    .cricket-content {
        position: relative;
        z-index: 1;
        padding-bottom: calc(30px + var(--safe-bottom));
    }

    /* ========== FEATURED BANNER ========== */
    .banner-section {
        position: relative;
        overflow: hidden;
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
        background:
            radial-gradient(circle at top right, rgba(233, 69, 96, 0.16), transparent 20%),
            radial-gradient(circle at bottom left, rgba(46, 204, 113, 0.12), transparent 20%),
            linear-gradient(135deg, #0f1531 0%, #17244a 45%, #0e1837 100%);
        padding: 20px 0;
        box-shadow: var(--shadow-lg);
    }

    .banner-shell {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 20px 16px 18px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02)),
            rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
    }

    .banner-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .banner-shell-split {
        height: 100%;
    }

    .banner-shell::before,
    .banner-shell::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .banner-shell::before {
        width: 160px;
        height: 160px;
        top: -60px;
        right: -60px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent 65%);
    }

    .banner-shell::after {
        width: 120px;
        height: 120px;
        left: -40px;
        bottom: -50px;
        background: radial-gradient(circle, rgba(241, 196, 15, 0.12), transparent 65%);
    }

    .banner-topbar {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .banner-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .banner-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .banner-status.live {
        background: rgba(255, 95, 109, 0.18);
        color: #ffd7dd;
    }

    .banner-status.today {
        background: rgba(255, 176, 32, 0.16);
        color: #ffe6b0;
    }

    .banner-status.upcoming {
        background: rgba(22, 131, 255, 0.16);
        color: #d7ebff;
    }

    .banner-match {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .banner-team {
        text-align: center;
        flex: 1;
        min-width: 0;
    }

    .banner-logo {
        width: 72px;
        height: 72px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }

    .banner-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .banner-logo span {
        font-size: 1.6rem;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.6);
    }

    .banner-team-name {
        color: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        word-break: break-word;
        line-height: 1.2;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .banner-center {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .banner-vs {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        color: #fff;
        font-size: 0.85rem;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.26);
    }

    .banner-details {
        position: relative;
        z-index: 1;
        margin-top: 14px;
        text-align: center;
    }

    .banner-time {
        color: var(--gold);
        font-size: 1.1rem;
        font-weight: 800;
        word-break: break-word;
        line-height: 1.2;
    }

    .banner-subtime {
        margin-top: 4px;
        color: rgba(255, 255, 255, 0.62);
        font-size: 0.72rem;
        word-break: break-word;
        line-height: 1.35;
    }

    .banner-meta {
        position: relative;
        z-index: 1;
        margin-top: 16px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .banner-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.86);
        font-size: 0.72rem;
        border: 1px solid rgba(255, 255, 255, 0.06);
        white-space: nowrap;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .banner-chip i {
        flex-shrink: 0;
    }

    @media (min-width: 992px) {
        .banner-grid.two-matches {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .banner-grid.two-matches .banner-match {
            min-height: 180px;
        }
    }

    .empty-banner {
        min-height: 160px !important;
    }

    .empty-banner .empty-icon {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.15);
        margin-bottom: 12px;
    }

    .empty-banner .empty-title {
        font-size: 1.15rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fff;
    }

    .empty-banner .empty-desc {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 6px;
        max-width: 320px;
        line-height: 1.5;
    }

    /* ========== SECTION TITLES ========== */
    .section-title {
        font-weight: 700;
        font-size: 1rem;
        margin: 22px 0 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
        padding: 0 2px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, var(--accent), transparent);
        border-radius: 2px;
    }

    .section-title .title-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: #fff;
        flex-shrink: 0;
    }

    .title-icon.live {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }

    .title-icon.upcoming {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .title-icon.tournament {
        background: linear-gradient(135deg, #f39c12, #e67e22);
    }

    .title-icon.players {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
    }

    /* ========== LIVE MATCH CARD ========== */
    .live-card {
        background:
            radial-gradient(circle at top right, rgba(233, 69, 96, 0.16), transparent 24%),
            radial-gradient(circle at bottom left, rgba(241, 196, 15, 0.1), transparent 20%),
            linear-gradient(135deg, #181c37 0%, #20264b 52%, #172545 100%);
        border-radius: 22px;
        padding: 20px 16px 18px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(16, 22, 48, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .live-card .card-glow-1 {
        position: absolute;
        top: -60px;
        right: -40px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(233, 69, 96, 0.12), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .live-card .card-glow-2 {
        position: absolute;
        bottom: -50px;
        left: -30px;
        width: 110px;
        height: 110px;
        background: radial-gradient(circle, rgba(241, 196, 15, 0.08), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #ff4f76, #ff6c4a);
        color: #fff;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 16px;
        animation: pulse-badge 2s infinite;
    }

    .live-badge .blink-dot {
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        animation: blink 1s infinite;
        flex-shrink: 0;
    }

    .live-teams {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        position: relative;
        z-index: 1;
    }

    .live-team {
        text-align: center;
        flex: 1;
        min-width: 0;
        max-width: 140px;
    }

    .live-team .team-avatar {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }

    .live-team .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .live-team .team-avatar span {
        font-size: 1.4rem;
        font-weight: 800;
        color: rgba(255, 255, 255, 0.6);
    }

    .live-team .team-name {
        font-weight: 700;
        font-size: 0.82rem;
        line-height: 1.2;
        word-break: break-word;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .live-vs {
        font-weight: 800;
        font-size: 0.85rem;
        color: #fff;
        flex-shrink: 0;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.26);
    }

    .live-score {
        text-align: center;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        z-index: 1;
    }

    .live-score .score-text {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--gold);
        word-break: break-word;
    }

    .live-score .score-subtext {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.55);
        margin-top: 4px;
        word-break: break-word;
    }

    .live-info {
        position: relative;
        z-index: 1;
    }

    .live-info-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .live-info-chip i {
        color: var(--gold);
    }

    .live-empty {
        position: relative;
        z-index: 1;
    }

    .live-empty .empty-icon-live {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.2);
        margin-bottom: 12px;
    }

    /* ========== MATCH CARDS GRID ========== */
    .matches-grid {
        display: flex;
        flex-direction: column;
        gap: 14px;
        padding: 4px 0 10px;
    }

    .match-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 10px 30px rgba(21, 34, 68, 0.07);
        border: 1px solid #e5edf8;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .match-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .match-card .card-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #1da1ff, #22c55e);
    }

    .match-card .card-accent.completed {
        background: linear-gradient(90deg, #1abc9c, transparent);
    }

    .match-card .match-league {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .match-card .match-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }

    .match-card .match-logo {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        overflow: hidden;
        background: linear-gradient(180deg, #fbfdff 0%, #f2f6fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e4ebf7;
        flex-shrink: 0;
    }

    .match-card .match-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .match-card .match-logo span {
        font-size: 1rem;
        font-weight: 800;
        color: var(--primary);
    }

    .match-card .match-vs-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        color: #fff;
        font-weight: 800;
        font-size: 0.65rem;
        box-shadow: 0 6px 16px rgba(255, 95, 109, 0.18);
        flex-shrink: 0;
    }

    .match-card .match-vs-badge.completed-vs {
        background: #f1f9f6;
        color: #16a085;
        box-shadow: none;
    }

    .match-card .match-teams-label {
        font-weight: 700;
        font-size: 0.92rem;
        color: var(--text-primary);
        margin-bottom: 8px;
        line-height: 1.3;
        word-break: break-word;
    }

    .match-card .match-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-top: 8px;
    }

    .match-card .match-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        background: #f5f8fc;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #edf2fa;
        word-break: break-word;
    }

    .match-card .match-date i {
        color: #3498db;
        font-size: 0.68rem;
        flex-shrink: 0;
    }

    .match-result-box {
        font-size: 0.78rem;
        font-weight: 700;
        color: #d35400;
        background: #fdf2e9;
        padding: 6px 10px;
        border-radius: 8px;
        text-align: center;
        margin-top: 8px;
        word-break: break-word;
    }

    /* ========== TOURNAMENT CARDS ========== */
    .tournament-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .tournament-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        padding: 14px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .tournament-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .tournament-card .trophy-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .tournament-card .tournament-info {
        flex: 1;
        min-width: 0;
    }

    .tournament-card .tournament-name {
        font-weight: 600;
        font-size: 0.84rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tournament-card .tournament-date {
        font-size: 0.72rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .tournament-card .tournament-date i {
        font-size: 0.64rem;
    }

    .tournament-card .arrow-icon {
        color: var(--text-secondary);
        font-size: 0.85rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .tournament-card:hover .arrow-icon {
        color: var(--accent);
        transform: translateX(3px);
    }

    /* ========== PLAYERS ========== */
    .players-scroll {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 4px 4px 14px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .players-scroll::-webkit-scrollbar {
        height: 3px;
    }

    .players-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .players-scroll::-webkit-scrollbar-thumb {
        background: #9b59b6;
        border-radius: 10px;
    }

    .player-card {
        min-width: 80px;
        max-width: 100px;
        text-align: center;
        scroll-snap-align: start;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .player-card:hover {
        transform: translateY(-4px);
    }

    .player-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 6px;
        font-size: 1.2rem;
        color: #fff;
        box-shadow: 0 4px 12px rgba(155, 89, 182, 0.25);
        border: 2px solid #fff;
        position: relative;
    }

    .player-avatar .spin-border {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px dashed rgba(155, 89, 182, 0.25);
        animation: spin 12s linear infinite;
        pointer-events: none;
    }

    .player-name {
        font-weight: 600;
        font-size: 0.72rem;
        color: var(--text-primary);
        line-height: 1.2;
        word-break: break-word;
    }

    /* ========== HOST BUTTON ========== */
    .host-section {
        padding: 24px 0 10px;
        text-align: center;
    }

    .host-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
        -webkit-tap-highlight-color: transparent;
    }

    .host-btn .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: all 0.5s ease;
        pointer-events: none;
    }

    .host-btn:hover .btn-shine {
        left: 100%;
    }

    .host-btn:hover {
        transform: translateY(-2px);
    }

    .host-btn:active {
        transform: translateY(0);
    }

    .host-btn.btn-become {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: #fff;
        box-shadow: 0 4px 16px rgba(243, 156, 18, 0.35);
    }

    .host-btn.btn-pending {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: #fff;
        box-shadow: 0 4px 16px rgba(149, 165, 166, 0.35);
    }

    .host-btn.btn-accepted {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: #fff;
        box-shadow: 0 4px 16px rgba(46, 204, 113, 0.35);
    }

    .host-btn.btn-rejected {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: #fff;
        box-shadow: 0 4px 16px rgba(231, 76, 60, 0.35);
    }

    /* ========== POOL CTA ========== */
    .pool-cta-wrapper {
        text-align: center;
        margin-top: 14px;
        position: relative;
        z-index: 1;
    }

    .pool-cta-btn {
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-radius: 14px;
        padding: 0;
        text-decoration: none !important;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3), 0 0 0 1px rgba(46, 204, 113, 0.1);
        -webkit-tap-highlight-color: transparent;
        max-width: 100%;
    }

    .pool-cta-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 32px rgba(46, 204, 113, 0.45), 0 0 0 1px rgba(46, 204, 113, 0.2);
        text-decoration: none !important;
    }

    .pool-cta-btn:active {
        transform: translateY(-1px) scale(0.99);
    }

    .pool-btn-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 40%, #1abc9c 100%);
        z-index: 0;
        transition: all 0.4s ease;
    }

    .pool-cta-btn:hover .pool-btn-bg {
        background: linear-gradient(135deg, #27ae60 0%, #1abc9c 40%, #2ecc71 100%);
    }

    .pool-btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        z-index: 1;
        transition: left 0.6s ease;
        pointer-events: none;
    }

    .pool-cta-btn:hover .pool-btn-shine {
        left: 100%;
    }

    .pool-btn-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 20px;
        color: #fff;
    }

    .pool-btn-icon {
        font-size: 1.3rem;
        flex-shrink: 0;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        animation: pulse-play 2s ease-in-out infinite;
    }

    .pool-btn-text-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1;
    }

    .pool-btn-label {
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }

    .pool-btn-sub {
        font-size: 0.64rem;
        font-weight: 400;
        opacity: 0.75;
        margin-top: 2px;
    }

    .pool-btn-arrow {
        font-size: 0.8rem;
        flex-shrink: 0;
        opacity: 0.7;
        transition: all 0.3s ease;
        margin-left: 4px;
    }

    .pool-cta-btn:hover .pool-btn-arrow {
        opacity: 1;
        transform: translateX(4px);
    }

    /* ========== MODALS ========== */
    .cricket-modal .modal-dialog {
        margin: 12px auto;
        max-width: 420px;
        padding: 0 12px;
    }

    .cricket-modal .modal-content {
        border: none !important;
        border-radius: var(--radius-xl) !important;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2) !important;
        background: var(--card-bg) !important;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        padding: 20px;
        color: #fff;
        text-align: center;
        position: relative;
    }

    .modal-header-custom .modal-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 0.78rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-header-custom .modal-close:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .modal-header-custom h5 {
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .modal-header-custom .subtitle {
        font-size: 0.75rem;
        opacity: 0.65;
        margin-top: 4px;
    }

    .modal-body-custom {
        padding: 18px;
    }

    .user-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: #f8f9fa;
        border-radius: var(--radius-sm);
        margin-bottom: 8px;
    }

    .user-info-item .info-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: #fff;
        flex-shrink: 0;
    }

    .user-info-item .info-icon.name-icon {
        background: linear-gradient(135deg, #3498db, #2980b9);
    }

    .user-info-item .info-icon.email-icon {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }

    .user-info-item .info-icon.phone-icon {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
    }

    .user-info-item .info-label {
        font-size: 0.62rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .user-info-item .info-text {
        font-weight: 500;
        font-size: 0.82rem;
        line-height: 1.2;
        word-break: break-all;
    }

    .form-input-custom {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-top: 12px;
        outline: none;
        background: #fff;
        color: var(--text-primary);
        -webkit-appearance: none;
    }

    .form-input-custom:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(233, 69, 96, 0.1);
    }

    .form-input-custom::placeholder {
        color: #adb5bd;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent), var(--accent-light));
        color: #fff;
        font-weight: 600;
        font-size: 0.88rem;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        -webkit-tap-highlight-color: transparent;
        -webkit-appearance: none;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(233, 69, 96, 0.35);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .submit-btn.loading {
        pointer-events: none;
        opacity: 0.75;
    }

    .spinner-sm {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: none;
    }

    .submit-btn.loading .spinner-sm {
        display: block;
    }

    .submit-btn.loading .btn-text {
        display: none;
    }

    #msg {
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .msg-success {
        color: #155724;
        padding: 10px;
        background: #d4edda;
        border-radius: var(--radius-sm);
        margin-top: 10px;
    }

    .msg-error {
        color: #e74c3c;
        padding: 10px;
        background: #fdf0f0;
        border-radius: var(--radius-sm);
        margin-top: 10px;
    }

    /* STATUS MODALS */
    .status-modal-body {
        padding: 32px 18px;
        text-align: center;
    }

    .status-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 2rem;
    }

    .status-icon.pending {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #95a5a6;
        animation: pulse-icon 2s infinite;
    }

    .status-icon.accepted {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #27ae60;
    }

    .status-icon.rejected {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #e74c3c;
    }

    .status-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 6px;
        color: var(--text-primary);
    }

    .status-subtitle {
        font-size: 0.8rem;
        color: var(--text-secondary);
        line-height: 1.5;
        max-width: 260px;
        margin: 0 auto;
    }

    .modal-close-btn {
        padding: 10px 24px;
        border: none;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 16px;
        transition: all 0.3s ease;
        font-size: 0.82rem;
    }

    .modal-close-btn:hover {
        transform: translateY(-2px);
    }

    .modal-close-btn:active {
        transform: translateY(0);
    }

    .modal-close-btn.pending-btn {
        background: #e9ecef;
        color: #495057;
    }

    .modal-close-btn.accepted-btn {
        background: #d4edda;
        color: #155724;
    }

    .modal-close-btn.rejected-btn {
        background: #f8d7da;
        color: #721c24;
    }

    /* ============================================================
       DESKTOP-SPECIFIC LAYOUT
       ============================================================ */

    /* Desktop layout wrapper */
    .desktop-layout {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .desktop-main-col {
        width: 100%;
    }

    .desktop-side-col {
        width: 100%;
        display: none;
    }

    /* ========== TABLET (576px+) ========== */
    @media (min-width: 576px) {
        .banner-section {
            padding: 28px 0;
        }

        .banner-shell {
            padding: 24px 24px 22px;
            border-radius: 24px;
        }

        .banner-logo {
            width: 90px;
            height: 90px;
            border-radius: 24px;
        }

        .banner-team-name {
            font-size: 1.05rem;
        }

        .banner-vs {
            width: 54px;
            height: 54px;
            font-size: 0.95rem;
        }

        .banner-time {
            font-size: 1.35rem;
        }

        .banner-details {
            margin-top: 16px;
        }

        .banner-match {
            gap: 18px;
        }

        .live-card {
            padding: 24px 22px 20px;
            border-radius: 26px;
        }

        .live-teams {
            gap: 28px;
        }

        .live-team .team-avatar {
            width: 80px;
            height: 80px;
            border-radius: 22px;
        }

        .live-team .team-name {
            font-size: 0.95rem;
        }

        .live-team {
            max-width: 160px;
        }

        .live-vs {
            width: 48px;
            height: 48px;
            font-size: 0.95rem;
        }

        .live-score .score-text {
            font-size: 1.4rem;
        }

        .section-title {
            font-size: 1.1rem;
        }

        .matches-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .match-card {
            padding: 18px;
        }

        .tournament-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
    }

    /* ========== DESKTOP (992px+) ========== */
    @media (min-width: 992px) {
        .banner-section {
            padding: 34px 0 28px;
            border-radius: 0 0 32px 32px;
        }

        .banner-shell {
            padding: 32px 36px 28px;
            border-radius: 28px;
        }

        .banner-shell::before {
            width: 260px;
            height: 260px;
            top: -100px;
            right: -100px;
        }

        .banner-shell::after {
            width: 200px;
            height: 200px;
            left: -60px;
            bottom: -80px;
        }

        .banner-logo {
            width: 120px;
            height: 120px;
            border-radius: 28px;
        }

        .banner-logo span {
            font-size: 2.2rem;
        }

        .banner-team-name {
            font-size: 1.3rem;
        }

        .banner-vs {
            width: 66px;
            height: 66px;
            font-size: 1.1rem;
            box-shadow: 0 18px 28px rgba(255, 95, 109, 0.26);
        }

        .banner-time {
            font-size: 1.65rem;
        }

        .banner-subtime {
            font-size: 0.88rem;
        }

        .banner-details {
            margin-top: 20px;
        }

        .banner-match {
            gap: 32px;
        }

        .banner-kicker,
        .banner-status {
            font-size: 0.78rem;
            padding: 8px 16px;
        }

        .banner-chip {
            font-size: 0.8rem;
            padding: 9px 16px;
        }

        .empty-banner {
            min-height: 220px !important;
        }

        .empty-banner .empty-icon {
            font-size: 3.5rem;
        }

        .empty-banner .empty-title {
            font-size: 1.5rem;
            letter-spacing: 1.5px;
        }

        .empty-banner .empty-desc {
            font-size: 0.95rem;
            max-width: 420px;
        }

        .desktop-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
            align-items: start;
        }

        .section-title {
            font-size: 1.2rem;
            margin: 28px 0 16px;
        }

        .section-title .title-icon {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        /* Live card - full width spanning both columns */
        .live-card-wrapper {
            grid-column: 1 / -1;
        }

        .live-card {
            padding: 32px 36px 28px;
            border-radius: 28px;
            box-shadow: 0 20px 54px rgba(16, 22, 48, 0.24);
        }

        .live-card .card-glow-1 {
            width: 200px;
            height: 200px;
            top: -80px;
            right: -60px;
        }

        .live-card .card-glow-2 {
            width: 160px;
            height: 160px;
            bottom: -70px;
            left: -40px;
        }

        .live-badge {
            font-size: 0.75rem;
            padding: 7px 18px;
        }

        .live-teams {
            gap: 48px;
        }

        .live-team {
            max-width: 200px;
        }

        .live-team .team-avatar {
            width: 100px;
            height: 100px;
            border-radius: 26px;
        }

        .live-team .team-avatar span {
            font-size: 2rem;
        }

        .live-team .team-name {
            font-size: 1.1rem;
        }

        .live-vs {
            width: 56px;
            height: 56px;
            font-size: 1.05rem;
        }

        .live-score .score-text {
            font-size: 1.65rem;
        }

        .live-score .score-subtext {
            font-size: 0.85rem;
        }

        .live-score {
            margin-top: 22px;
            padding-top: 18px;
        }

        .pool-btn-content {
            padding: 14px 28px;
            gap: 14px;
        }

        .pool-btn-icon {
            font-size: 1.5rem;
        }

        .pool-btn-label {
            font-size: 0.95rem;
        }

        .pool-btn-sub {
            font-size: 0.72rem;
        }

        /* Matches grid */
        .matches-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .match-card {
            padding: 20px;
            border-radius: 22px;
        }

        .match-card .match-logo {
            width: 56px;
            height: 56px;
            border-radius: 16px;
        }

        .match-card .match-vs-badge {
            width: 34px;
            height: 34px;
            font-size: 0.7rem;
        }

        .match-card .match-teams-label {
            font-size: 1rem;
        }

        .match-card .match-date {
            font-size: 0.8rem;
        }

        /* Host */
        .host-section {
            padding: 32px 0 16px;
        }

        .host-btn {
            padding: 13px 36px;
            font-size: 0.9rem;
        }
    }

    /* ========== LARGE DESKTOP (1200px+) ========== */
    @media (min-width: 1200px) {
        .desktop-layout {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .banner-shell {
            padding: 36px 44px 32px;
        }

        .banner-logo {
            width: 130px;
            height: 130px;
        }

        .banner-team-name {
            font-size: 1.4rem;
        }

        .banner-vs {
            width: 72px;
            height: 72px;
            font-size: 1.2rem;
        }

        .banner-time {
            font-size: 1.8rem;
        }

        .banner-match {
            gap: 40px;
        }

        .live-card {
            padding: 36px 44px 32px;
        }

        .live-teams {
            gap: 56px;
        }

        .live-team .team-avatar {
            width: 110px;
            height: 110px;
        }

        .live-vs {
            width: 60px;
            height: 60px;
            font-size: 1.1rem;
        }

        .live-score .score-text {
            font-size: 1.8rem;
        }

        .matches-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }
    }

    /* ========== VERY SMALL PHONES (374px-) ========== */
    @media (max-width: 374px) {
        .ck-container {
            padding-left: 12px;
            padding-right: 12px;
        }

        .banner-shell {
            padding: 16px 12px 14px;
        }

        .banner-topbar {
            gap: 6px;
        }

        .banner-kicker,
        .banner-status {
            font-size: 0.62rem;
            padding: 5px 10px;
        }

        .banner-logo {
            width: 56px;
            height: 56px;
            border-radius: 14px;
        }

        .banner-logo span {
            font-size: 1.2rem;
        }

        .banner-team-name {
            font-size: 0.75rem;
        }

        .banner-vs {
            width: 38px;
            height: 38px;
            font-size: 0.72rem;
        }

        .banner-time {
            font-size: 0.92rem;
        }

        .banner-subtime {
            font-size: 0.65rem;
        }

        .banner-chip {
            font-size: 0.65rem;
            padding: 5px 10px;
        }

        .banner-match {
            gap: 8px;
        }

        .live-card {
            padding: 16px 12px 14px;
            border-radius: 18px;
        }

        .live-teams {
            gap: 10px;
        }

        .live-team .team-avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
        }

        .live-team .team-avatar span {
            font-size: 1rem;
        }

        .live-team .team-name {
            font-size: 0.72rem;
        }

        .live-vs {
            width: 36px;
            height: 36px;
            font-size: 0.72rem;
        }

        .live-score .score-text {
            font-size: 1rem;
        }

        .live-badge {
            font-size: 0.62rem;
            padding: 4px 10px;
        }

        .section-title {
            font-size: 0.9rem;
        }

        .section-title .title-icon {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }

        .match-card {
            padding: 12px;
        }

        .match-card .match-teams-label {
            font-size: 0.82rem;
        }

        .match-card .match-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
        }

        .match-card .match-vs-badge {
            width: 26px;
            height: 26px;
            font-size: 0.58rem;
        }

        .match-card .match-date {
            font-size: 0.7rem;
            padding: 6px 10px;
        }

        .player-avatar {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }

        .player-card {
            min-width: 72px;
            max-width: 85px;
        }

        .player-name {
            font-size: 0.65rem;
        }

        .host-btn {
            padding: 10px 20px;
            font-size: 0.78rem;
        }

        .pool-btn-content {
            padding: 9px 14px;
            gap: 8px;
        }

        .pool-btn-icon {
            font-size: 1.1rem;
        }

        .pool-btn-label {
            font-size: 0.78rem;
        }

        .pool-btn-sub {
            font-size: 0.58rem;
        }

        .pool-btn-arrow {
            display: none;
        }

        .tournament-card {
            padding: 12px;
        }

        .tournament-card .trophy-icon {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
            border-radius: 10px;
        }

        .tournament-card .tournament-name {
            font-size: 0.78rem;
        }

        .tournament-card .tournament-date {
            font-size: 0.68rem;
        }
    }

    /* ========== iOS SAFE AREAS ========== */
    @supports (padding: max(0px)) {
        .cricket-content {
            padding-bottom: max(30px, calc(var(--safe-bottom) + 16px));
        }
    }

    /* ========== REDUCE MOTION ========== */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- ========== MAIN CONTENT ========== -->
<div class="cricket-content">

    <!-- BANNER -->
    <div class="banner-section animate-in delay-1">
        <div class="ck-container">
            <?php $bannerCards = !empty($header_matches) ? $header_matches : (!empty($has_featured) ? [$featured_match] : []); ?>
            <div class="banner-grid <?= count($bannerCards) > 1 ? 'two-matches' : '' ?>">
                <?php if (!empty($bannerCards)): ?>
                    <?php foreach ($bannerCards as $index => $bannerCard): ?>
                        <div class="banner-shell <?= count($bannerCards) > 1 ? 'banner-shell-split' : '' ?>">
                            <div class="banner-topbar">
                                <div class="banner-kicker">
                                    <i class="fas fa-trophy"></i>
                                    <?= $index === 0 ? 'Featured Match' : 'Match ' . ($index + 1) ?>
                                </div>
                                <div class="banner-status <?= !empty($bannerCard) ? ($bannerCard['bucket'] ?? 'upcoming') : 'upcoming' ?>">
                                    <i class="fas fa-bolt"></i>
                                    <?= !empty($bannerCard) && ($bannerCard['bucket'] ?? '') === 'live' ? 'Live Now' : (!empty($bannerCard) && ($bannerCard['bucket'] ?? '') === 'today' ? 'Today Match' : 'Upcoming Match') ?>
                                </div>
                            </div>

                            <div class="banner-match">
                                <div class="banner-team">
                                    <div class="banner-logo"><?= $renderCricketTeamAvatar($bannerCard['team1_logo'] ?? '', $bannerCard['team1'] ?? '') ?></div>
                                    <div class="banner-team-name"><?= html_escape($bannerCard['team1'] ?? 'Team A') ?></div>
                                </div>
                                <div class="banner-center">
                                    <div class="banner-vs">VS</div>
                                </div>
                                <div class="banner-team">
                                    <div class="banner-logo"><?= $renderCricketTeamAvatar($bannerCard['team2_logo'] ?? '', $bannerCard['team2'] ?? '') ?></div>
                                    <div class="banner-team-name"><?= html_escape($bannerCard['team2'] ?? 'Team B') ?></div>
                                </div>
                            </div>

                            <div class="banner-details">
                                <div class="banner-time"><?= html_escape($bannerCard['score'] ?? 'TBD') ?></div>
                                <div class="banner-subtime"><?= html_escape($bannerCard['start_label'] ?? 'Schedule not set') ?></div>
                            </div>

                            <div class="banner-meta">
                                <?php if (!empty($bannerCard['competition_name'])): ?>
                                    <span class="banner-chip"><i class="fas fa-award"></i> <?= html_escape($bannerCard['competition_name']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($bannerCard['venue'])): ?>
                                    <span class="banner-chip"><i class="fas fa-map-marker-alt"></i> <?= html_escape($bannerCard['venue']) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($bannerCard['start_label'])): ?>
                                    <span class="banner-chip"><i class="fas fa-clock"></i> <?= html_escape($bannerCard['start_label']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="banner-shell">
                        <div class="banner-match empty-banner" style="display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;">
                            <div class="empty-icon"><i class="fas fa-cricket-bat-ball"></i></div>
                            <div class="empty-title">No Matches Right Now</div>
                            <div class="empty-desc">We are scheduling the next big fixtures. Check back soon!</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="ck-container">

        <!-- LIVE MATCH - Always full width -->
        <h4 class="section-title animate-in delay-2">
            <span class="title-icon live"><i class="fas fa-circle" style="font-size:0.55rem"></i></span>
            Live Match
        </h4>

        <div class="live-card animate-in delay-2">
            <div class="card-glow-1"></div>
            <div class="card-glow-2"></div>
            <div class="live-badge">
                <span class="blink-dot"></span>
                <?= ($live['status'] ?? '') === 'LIVE' ? 'LIVE NOW' : (($live['status'] ?? '') === 'TODAY' ? 'TODAY' : 'UPCOMING') ?>
            </div>

            <?php if (!empty($has_live) && $has_live): ?>
                <div class="live-teams">
                    <div class="live-team">
                        <div class="team-avatar"><?= $renderCricketTeamAvatar($live['team1_logo'] ?? '', $live['team1'] ?? '') ?></div>
                        <div class="team-name"><?= html_escape($live['team1']) ?></div>
                    </div>
                    <div class="live-vs">VS</div>
                    <div class="live-team">
                        <div class="team-avatar"><?= $renderCricketTeamAvatar($live['team2_logo'] ?? '', $live['team2'] ?? '') ?></div>
                        <div class="team-name"><?= html_escape($live['team2']) ?></div>
                    </div>
                </div>
                <div class="live-score">
                    <div class="score-text"><?= $live['score'] ?></div>
                    <div class="score-subtext"><?= html_escape($live['venue']) ?></div>
                </div>
                <?php if (!empty($live['competition_name'])): ?>
                    <div class="live-info" style="margin-top:12px;display:flex;justify-content:center;">
                        <span class="live-info-chip">
                            <i class="fas fa-trophy"></i> <?= html_escape($live['competition_name']) ?>
                        </span>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="live-empty" style="text-align:center;padding:28px 0;">
                    <div class="empty-icon-live"><i class="fas fa-satellite-dish"></i></div>
                    <h5 style="color:#fff;font-weight:700;margin-bottom:6px;font-size:1.1rem;">No Live Broadcast</h5>
                    <p style="color:rgba(255,255,255,0.6);font-size:0.78rem;margin:0 auto;max-width:260px;">Our live center is offline until the next match begins.</p>
                </div>
            <?php endif; ?>

            <div class="pool-cta-wrapper">
                <a href="<?= base_url('pool') ?>" class="pool-cta-btn">
                    <span class="pool-btn-bg"></span>
                    <span class="pool-btn-shine"></span>
                    <span class="pool-btn-content">
                        <i class="fas fa-play-circle pool-btn-icon"></i>
                        <span class="pool-btn-text-group">
                            <?php if (!empty($user) && isset($user['is_host']) && $user['is_host'] == 1): ?>
                                <span class="pool-btn-label">Play & Create Pool</span>
                                <span class="pool-btn-sub">Manage your matches</span>
                            <?php else: ?>
                                <span class="pool-btn-label">Play & Join Pool</span>
                                <span class="pool-btn-sub">Join matches & compete</span>
                            <?php endif; ?>
                        </span>
                        <i class="fas fa-arrow-right pool-btn-arrow"></i>
                    </span>
                </a>
            </div>
        </div>

        <!-- ========== DESKTOP TWO-COLUMN LAYOUT ========== -->
        <div class="desktop-layout">

            <!-- LEFT / MAIN COLUMN -->
            <div class="desktop-main-col">

                <!-- COMPLETED -->
                <h4 class="section-title animate-in delay-3">
                    <span class="title-icon upcoming" style="background:linear-gradient(135deg,#1abc9c,#16a085);"><i class="fas fa-check-circle"></i></span>
                    Completed Matches
                </h4>

                <div class="matches-grid animate-in delay-3">
                    <?php if (!empty($completed_matches)): ?>
                        <?php foreach ($completed_matches as $u): ?>
                            <div class="match-card" style="border:1px solid #e0f2e9;">
                                <div class="card-accent completed"></div>
                                <div class="match-league"><i class="fas fa-check" style="color:#2ecc71;"></i> <?= html_escape($u['competition_name'] ?: 'Completed Match') ?></div>
                                <div class="match-row">
                                    <div class="match-logo"><?= $renderCricketTeamAvatar($u['team1_logo'] ?? '', $u['team1'] ?? '') ?></div>
                                    <div class="match-vs-badge completed-vs">VS</div>
                                    <div class="match-logo"><?= $renderCricketTeamAvatar($u['team2_logo'] ?? '', $u['team2'] ?? '') ?></div>
                                </div>
                                <div class="match-teams-label"><?= html_escape($u['teams']) ?></div>
                                <?php if (!empty($u['match_result'])): ?>
                                    <div class="match-result-box"><?= html_escape($u['match_result']) ?></div>
                                <?php endif; ?>
                                <div class="match-meta">
                                    <div class="match-date"><i class="fas fa-calendar-day"></i> <?= html_escape($u['date_label']) ?></div>
                                    <?php if (!empty($u['venue'])): ?>
                                        <div class="match-date"><i class="fas fa-map-marker-alt"></i> <?= html_escape($u['venue']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="match-card">
                            <div class="card-accent"></div>
                            <div class="match-teams-label">No completed matches found.</div>
                            <div class="match-meta">
                                <div class="match-date"><i class="fas fa-info-circle"></i> Completed match results will appear here.</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- UPCOMING -->
                <h4 class="section-title animate-in delay-4">
                    <span class="title-icon upcoming"><i class="fas fa-calendar-alt"></i></span>
                    Upcoming Matches
                </h4>

                <div class="matches-grid animate-in delay-4">
                    <?php if (!empty($upcoming)): ?>
                        <?php foreach ($upcoming as $u): ?>
                            <div class="match-card">
                                <div class="card-accent"></div>
                                <div class="match-league"><i class="fas fa-calendar-alt"></i> <?= html_escape($u['competition_name'] ?: 'Upcoming Match') ?></div>
                                <div class="match-row">
                                    <div class="match-logo"><?= $renderCricketTeamAvatar($u['team1_logo'] ?? '', $u['team1'] ?? '') ?></div>
                                    <div class="match-vs-badge">VS</div>
                                    <div class="match-logo"><?= $renderCricketTeamAvatar($u['team2_logo'] ?? '', $u['team2'] ?? '') ?></div>
                                </div>
                                <div class="match-teams-label"><?= html_escape($u['teams']) ?></div>
                                <div class="match-meta">
                                    <div class="match-date"><i class="fas fa-calendar-day"></i> <?= html_escape($u['date_label']) ?></div>
                                    <div class="match-date"><i class="fas fa-clock"></i> <?= html_escape($u['time_label']) ?></div>
                                    <?php if (!empty($u['venue'])): ?>
                                        <div class="match-date"><i class="fas fa-map-marker-alt"></i> <?= html_escape($u['venue']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="match-card">
                            <div class="card-accent"></div>
                            <div class="match-teams-label">No upcoming matches available.</div>
                            <div class="match-meta">
                                <div class="match-date"><i class="fas fa-info-circle"></i> Scheduled matches will show here.</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT / SIDEBAR COLUMN -->
            <div class="desktop-side-col">

                <!-- TOURNAMENTS -->
                <h4 class="section-title animate-in delay-5">
                    <span class="title-icon tournament"><i class="fas fa-trophy"></i></span>
                    Tournaments
                </h4>

                <div class="tournament-grid animate-in delay-5">
                    <?php if (!empty($tournaments)): ?>
                        <?php foreach ($tournaments as $t): ?>
                            <div class="tournament-card">
                                <div class="trophy-icon">🏆</div>
                                <div class="tournament-info">
                                    <div class="tournament-name"><?= html_escape($t['name']) ?></div>
                                    <div class="tournament-date">
                                        <i class="far fa-calendar"></i>
                                        <?= html_escape($t['date']) ?>
                                    </div>
                                </div>
                                <div class="arrow-icon"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="tournament-card">
                            <div class="trophy-icon">🏆</div>
                            <div class="tournament-info">
                                <div class="tournament-name">No tournaments available</div>
                                <div class="tournament-date">Check back later</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- PLAYERS -->
                <h4 class="section-title animate-in delay-5">
                    <span class="title-icon players"><i class="fas fa-users"></i></span>
                    Featured Players
                </h4>

                <div class="players-scroll animate-in delay-5">
                    <?php if (!empty($players)): ?>
                        <?php foreach ($players as $p): ?>
                            <?php 
                                $pName = is_array($p) ? $p['name'] : $p;
                                $pImageRaw = is_array($p) && !empty($p['image']) ? trim($p['image']) : '';
                                
                                $pImage = '';
                                if ($pImageRaw !== '') {
                                    $pImage = (strpos($pImageRaw, 'http') === 0) ? $pImageRaw : base_url($pImageRaw);
                                }
                            ?>
                            <div class="player-card">
                                <div class="player-avatar">
                                    <?php if ($pImage): ?>
                                        <img src="<?= html_escape($pImage) ?>" alt="<?= html_escape($pName) ?>" style="width:100%; height:100%; border-radius:50%; object-fit:cover; position:relative; z-index:2;">
                                    <?php else: ?>
                                        <i class="fas fa-user"></i>
                                    <?php endif; ?>
                                    <div class="spin-border"></div>
                                </div>
                                <div class="player-name"><?= html_escape($pName) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="player-card">
                            <div class="player-avatar"><i class="fas fa-user-slash"></i></div>
                            <div class="player-name">No players</div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <!-- end desktop-layout -->

        <!-- HOST BUTTON (full width below) -->
        <div class="host-section animate-in delay-5">
            <?php if (!$request): ?>
                <button class="host-btn btn-become" data-bs-toggle="modal" data-bs-target="#hostModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-crown"></i> Become a Host
                </button>
            <?php elseif ($request['status'] == 'pending'): ?>
                <button class="host-btn btn-pending" data-bs-toggle="modal" data-bs-target="#pendingModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-hourglass-half"></i> Request Pending
                </button>
            <?php elseif ($request['status'] == 'accepted'): ?>
                <button class="host-btn btn-accepted" data-bs-toggle="modal" data-bs-target="#acceptedModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-check-circle"></i> You are a Host
                </button>
            <?php else: ?>
                <button class="host-btn btn-rejected" data-bs-toggle="modal" data-bs-target="#rejectedModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-times-circle"></i> Request Rejected
                </button>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ========== MODALS ========== -->
<div class="modal fade cricket-modal" id="hostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-custom">
                <button type="button" class="modal-close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                <h5><i class="fas fa-crown"></i> Become a Host</h5>
                <div class="subtitle">Fill in the details to apply</div>
            </div>
            <div class="modal-body-custom">
                <div class="user-info-item">
                    <div class="info-icon name-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="info-label">Full Name</div>
                        <div class="info-text"><?= html_escape($user['name'] ?? '') ?></div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon email-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-text"><?= html_escape($user['email'] ?? '') ?></div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon phone-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="info-label">Mobile</div>
                        <div class="info-text"><?= html_escape($user['mobile'] ?? '') ?></div>
                    </div>
                </div>
                <input type="text" id="insta" class="form-input-custom" placeholder="🔗 Instagram Profile URL" autocomplete="off" inputmode="url">
                <div id="msg"></div>
                <button class="submit-btn" id="submitHostBtn" onclick="submitHost()">
                    <span class="btn-text">Submit Application</span>
                    <span class="spinner-sm"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cricket-modal" id="pendingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon pending"><i class="fas fa-hourglass-half"></i></div>
                <div class="status-title">Under Review</div>
                <div class="status-subtitle">Your host application is being reviewed. We'll notify you once it's processed.</div>
                <button class="modal-close-btn pending-btn" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cricket-modal" id="acceptedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon accepted"><i class="fas fa-check"></i></div>
                <div class="status-title">Congratulations! 🎉</div>
                <div class="status-subtitle">You are now an official Cricket Host. Start organizing matches!</div>
                <button class="modal-close-btn accepted-btn" data-bs-dismiss="modal">Awesome!</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade cricket-modal" id="rejectedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon rejected"><i class="fas fa-times"></i></div>
                <div class="status-title">Request Declined</div>
                <div class="status-subtitle">Your host application was not approved. Contact support for details.</div>
                <button class="modal-close-btn rejected-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitHost() {
        const btn = document.getElementById('submitHostBtn');
        const insta = document.getElementById('insta').value.trim();
        const msg = document.getElementById('msg');

        if (!insta) {
            msg.innerHTML = '<div class="msg-error"><i class="fas fa-exclamation-circle"></i> Please enter your Instagram URL</div>';
            document.getElementById('insta').style.borderColor = '#e74c3c';
            document.getElementById('insta').focus();
            setTimeout(() => {
                document.getElementById('insta').style.borderColor = '#e9ecef';
            }, 2500);
            return;
        }

        btn.classList.add('loading');

        fetch("<?= base_url('cricket/becomeHost') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "instagram=" + encodeURIComponent(insta)
            })
            .then(res => res.json())
            .then(data => {
                btn.classList.remove('loading');
                msg.innerHTML = '<div class="msg-success"><i class="fas fa-check-circle"></i> Application submitted!</div>';
                setTimeout(() => location.reload(), 1500);
            })
            .catch(err => {
                btn.classList.remove('loading');
                msg.innerHTML = '<div class="msg-error"><i class="fas fa-exclamation-triangle"></i> Something went wrong. Try again.</div>';
            });
    }

    document.getElementById('hostModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('msg').innerHTML = '';
        document.getElementById('insta').value = '';
        document.getElementById('insta').style.borderColor = '#e9ecef';
        document.getElementById('submitHostBtn').classList.remove('loading');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.style.animationPlayState = 'running';
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.animate-in').forEach(el => observer.observe(el));
    });
</script>
