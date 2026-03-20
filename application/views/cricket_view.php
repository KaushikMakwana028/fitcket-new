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

    /* ========== RESET & VARIABLES ========== */
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
    }

    body.cricket-page {
        background: var(--light) !important;
        font-family: 'Poppins', sans-serif !important;
        color: var(--text-primary);
        overflow-x: hidden;
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* ========== CRICKET HEADER - ISOLATED ========== */
    .cricket-header-wrapper {
        position: sticky;
        top: 0;
        z-index: 1050;
        width: 100%;
        isolation: isolate;
    }

    .cricket-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--primary) 100%);
        padding: 0;
        height: var(--header-height);
        display: flex;
        align-items: center;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.25);
        position: relative;
        z-index: 1050;
    }

    .cricket-header .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .cricket-header .header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cricket-header h2 {
        color: #fff;
        font-weight: 800;
        font-size: 1.5rem;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        padding: 0;
        line-height: 1;
    }

    .cricket-header h2 .dot {
        width: 10px;
        height: 10px;
        background: var(--accent);
        border-radius: 50%;
        display: inline-block;
        animation: pulse-dot 1.5s infinite;
        flex-shrink: 0;
    }

    .cricket-header h2 .icon-cricket {
        font-size: 1.6rem;
        line-height: 1;
    }

    .header-live-indicator {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(233, 69, 96, 0.2);
        border: 1px solid rgba(233, 69, 96, 0.3);
        padding: 5px 14px;
        border-radius: 20px;
        color: var(--accent-light);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .header-live-indicator .live-dot {
        width: 6px;
        height: 6px;
        background: var(--accent);
        border-radius: 50%;
        animation: blink 1s infinite;
    }

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

    /* ========== MAIN CONTENT WRAPPER ========== */
    .cricket-content {
        position: relative;
        z-index: 1;
        padding-bottom: 30px;
    }

    /* ========== FEATURED BANNER ========== */
    .banner-section {
        position: relative;
        margin-top: 0;
        overflow: hidden;
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
        background:
            radial-gradient(circle at top right, rgba(233, 69, 96, 0.16), transparent 20%),
            radial-gradient(circle at bottom left, rgba(46, 204, 113, 0.12), transparent 20%),
            linear-gradient(135deg, #0f1531 0%, #17244a 45%, #0e1837 100%);
        padding: 34px 0 28px;
        box-shadow: var(--shadow-lg);
    }

    .banner-shell {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        padding: 28px 28px 24px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02)),
            rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(14px);
    }

    .banner-shell::before,
    .banner-shell::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .banner-shell::before {
        width: 220px;
        height: 220px;
        top: -80px;
        right: -90px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent 65%);
    }

    .banner-shell::after {
        width: 170px;
        height: 170px;
        left: -50px;
        bottom: -70px;
        background: radial-gradient(circle, rgba(241, 196, 15, 0.12), transparent 65%);
    }

    .banner-topbar {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .banner-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .banner-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
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
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 18px;
    }

    .banner-team {
        text-align: center;
    }

    .banner-logo {
        width: 110px;
        height: 110px;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }

    .banner-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .banner-team-name {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .banner-center {
        text-align: center;
    }

    .banner-vs {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 800;
        box-shadow: 0 18px 28px rgba(255, 95, 109, 0.26);
    }

    .banner-time {
        margin-top: 16px;
        color: var(--gold);
        font-size: 1.55rem;
        font-weight: 800;
    }

    .banner-subtime {
        margin-top: 6px;
        color: rgba(255, 255, 255, 0.62);
        font-size: 0.84rem;
    }

    .banner-meta {
        position: relative;
        z-index: 1;
        margin-top: 24px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .banner-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.86);
        font-size: 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    /* ========== SECTION TITLES ========== */
    .section-title {
        font-weight: 700;
        font-size: 1.15rem;
        margin: 24px 0 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-primary);
        padding: 0 4px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: linear-gradient(90deg, var(--accent), transparent);
        border-radius: 2px;
    }

    .section-title .title-icon {
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
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
        border-radius: 28px;
        padding: 28px 28px 24px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 54px rgba(16, 22, 48, 0.24);
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    .live-card .card-glow-1 {
        position: absolute;
        top: -60px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(233, 69, 96, 0.12), transparent);
        border-radius: 50%;
        pointer-events: none;
    }

    .live-card .card-glow-2 {
        position: absolute;
        bottom: -50px;
        left: -30px;
        width: 130px;
        height: 130px;
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
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 22px;
        animation: pulse-badge 2s infinite;
    }

    .live-badge .blink-dot {
        width: 7px;
        height: 7px;
        background: #fff;
        border-radius: 50%;
        animation: blink 1s infinite;
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

    .live-teams {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 32px;
        position: relative;
        z-index: 1;
    }

    .live-team {
        text-align: center;
        flex: 1;
        max-width: 180px;
    }

    .live-team .team-avatar {
        width: 92px;
        height: 92px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.4rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
        backdrop-filter: blur(12px);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.06);
    }

    .live-team .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .live-team .team-name {
        font-weight: 700;
        font-size: 1.05rem;
        line-height: 1.2;
        word-break: break-word;
        letter-spacing: 0.02em;
    }

    .live-vs {
        font-weight: 800;
        font-size: 1.05rem;
        color: #fff;
        flex-shrink: 0;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 14px 24px rgba(255, 95, 109, 0.26);
    }

    .live-score {
        text-align: center;
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        z-index: 1;
    }

    .live-score .score-text {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--gold);
        letter-spacing: 0.01em;
    }

    .live-score .score-status {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.58);
        margin-top: 6px;
    }

    .live-meta {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
        position: relative;
        z-index: 1;
    }

    .live-meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.84);
        font-size: 0.78rem;
        border: 1px solid rgba(255, 255, 255, 0.06);
    }

    /* ========== UPCOMING CARDS ========== */
    .upcoming-scroll {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 18px;
        padding: 6px 0 14px;
    }

    .upcoming-scroll::-webkit-scrollbar {
        height: 3px;
    }

    .upcoming-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .upcoming-scroll::-webkit-scrollbar-thumb {
        background: var(--accent);
        border-radius: 10px;
    }

    .upcoming-card {
        min-width: 0;
        max-width: none;
        background: var(--card-bg);
        border-radius: 24px;
        padding: 18px;
        box-shadow: 0 14px 36px rgba(21, 34, 68, 0.08);
        border: 1px solid #e5edf8;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .upcoming-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .upcoming-card .card-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1da1ff, #22c55e);
    }

    .upcoming-card .match-teams {
        font-weight: 700;
        font-size: 1.02rem;
        color: var(--text-primary);
        margin-bottom: 12px;
        line-height: 1.3;
    }

    .upcoming-card .match-league {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.74rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 14px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .upcoming-card .match-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 10px;
        margin-bottom: 14px;
    }

    .upcoming-card .match-logo {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        overflow: hidden;
        background: linear-gradient(180deg, #fbfdff 0%, #f2f6fd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e4ebf7;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary);
        flex-shrink: 0;
    }

    .upcoming-card .match-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .upcoming-card .match-vs-badge {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff5f6d, #ff8a65);
        color: #fff;
        font-weight: 800;
        font-size: 0.72rem;
        box-shadow: 0 10px 20px rgba(255, 95, 109, 0.18);
    }

    .upcoming-card .match-meta {
        display: grid;
        grid-template-columns: 1fr;
        gap: 9px;
        margin-top: 10px;
    }

    .upcoming-card .match-date {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.8rem;
        color: var(--text-secondary);
        background: #f5f8fc;
        padding: 9px 12px;
        border-radius: 12px;
        border: 1px solid #edf2fa;
    }

    .upcoming-card .match-date i {
        color: #3498db;
        font-size: 0.7rem;
    }

    /* ========== TOURNAMENT CARDS ========== */
    .tournament-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .tournament-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .tournament-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .tournament-card .trophy-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .tournament-card .tournament-info {
        flex: 1;
        min-width: 0;
    }

    .tournament-card .tournament-name {
        font-weight: 600;
        font-size: 0.88rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tournament-card .tournament-date {
        font-size: 0.76rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .tournament-card .tournament-date i {
        font-size: 0.68rem;
    }

    .tournament-card .arrow-icon {
        color: var(--text-secondary);
        font-size: 0.9rem;
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
        gap: 14px;
        overflow-x: auto;
        padding: 4px 4px 14px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
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
        min-width: 100px;
        max-width: 120px;
        text-align: center;
        scroll-snap-align: start;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .player-card:hover {
        transform: translateY(-4px);
    }

    .player-avatar {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 1.5rem;
        color: #fff;
        box-shadow: 0 4px 16px rgba(155, 89, 182, 0.25);
        border: 3px solid #fff;
        position: relative;
    }

    .player-avatar .spin-border {
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        border: 2px dashed rgba(155, 89, 182, 0.25);
        animation: spin 12s linear infinite;
        pointer-events: none;
    }

    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    .player-name {
        font-weight: 600;
        font-size: 0.78rem;
        color: var(--text-primary);
        line-height: 1.2;
        word-break: break-word;
    }

    /* ========== HOST BUTTON ========== */
    .host-section {
        padding: 28px 0 10px;
        text-align: center;
    }

    .host-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 32px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
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

    .host-btn.btn-become {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: #fff;
        box-shadow: 0 4px 16px rgba(243, 156, 18, 0.35);
    }

    .host-btn.btn-become:hover {
        box-shadow: 0 6px 24px rgba(243, 156, 18, 0.45);
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

    /* ========== MODALS - ISOLATED ========== */
    .cricket-modal .modal-dialog {
        margin: 16px auto;
        max-width: 420px;
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
        padding: 22px 24px;
        color: #fff;
        text-align: center;
        position: relative;
    }

    .modal-header-custom .modal-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        font-size: 0.85rem;
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
        font-size: 1.2rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .modal-header-custom .subtitle {
        font-size: 0.8rem;
        opacity: 0.65;
        margin-top: 4px;
    }

    .modal-body-custom {
        padding: 20px;
    }

    .user-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8f9fa;
        border-radius: var(--radius-sm);
        margin-bottom: 8px;
    }

    .user-info-item .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
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
        font-size: 0.65rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1;
    }

    .user-info-item .info-text {
        font-weight: 500;
        font-size: 0.85rem;
        line-height: 1.2;
        word-break: break-all;
    }

    .form-input-custom {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        margin-top: 12px;
        outline: none;
        background: #fff;
        color: var(--text-primary);
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
        font-size: 0.92rem;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
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
        font-size: 0.82rem;
        border-radius: var(--radius-sm);
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

    /* ========== STATUS MODALS ========== */
    .status-modal-body {
        padding: 36px 20px;
        text-align: center;
    }

    .status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 2.2rem;
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

    @keyframes pulse-icon {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .status-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 6px;
        color: var(--text-primary);
    }

    .status-subtitle {
        font-size: 0.82rem;
        color: var(--text-secondary);
        line-height: 1.5;
        max-width: 280px;
        margin: 0 auto;
    }

    .modal-close-btn {
        padding: 10px 28px;
        border: none;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        margin-top: 18px;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }

    .modal-close-btn:hover {
        transform: translateY(-2px);
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

    /* ========== ANIMATIONS ========== */
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

    /* ========== POOL CTA BUTTON - PREMIUM ========== */
    .pool-cta-btn {
        display: inline-flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        padding: 0;
        text-decoration: none !important;
        margin-top: 6px;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        box-shadow: 0 4px 20px rgba(46, 204, 113, 0.3),
            0 0 0 1px rgba(46, 204, 113, 0.1);
    }

    .pool-cta-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 32px rgba(46, 204, 113, 0.45),
            0 0 0 1px rgba(46, 204, 113, 0.2);
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
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
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
        gap: 12px;
        padding: 12px 22px;
        color: #fff;
    }

    .pool-btn-icon {
        font-size: 1.4rem;
        flex-shrink: 0;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.15));
        animation: pulse-play 2s ease-in-out infinite;
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

    .pool-btn-text-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        line-height: 1;
    }

    .pool-btn-label {
        font-weight: 700;
        font-size: 0.92rem;
        letter-spacing: 0.3px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .pool-btn-sub {
        font-size: 0.68rem;
        font-weight: 400;
        opacity: 0.75;
        margin-top: 3px;
        letter-spacing: 0.2px;
    }

    .pool-btn-arrow {
        font-size: 0.85rem;
        flex-shrink: 0;
        opacity: 0.7;
        transition: all 0.3s ease;
        margin-left: 4px;
    }

    .pool-cta-btn:hover .pool-btn-arrow {
        opacity: 1;
        transform: translateX(4px);
    }

    /* ========== RESPONSIVE ========== */
    @media (min-width: 768px) {
        .banner-section .carousel-item img {
            height: clamp(360px, 38vw, 500px);
        }

        .tournament-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .live-teams {
            gap: 30px;
        }

        .live-team {
            max-width: 160px;
        }

        .live-team .team-avatar {
            width: 104px;
            height: 104px;
            font-size: 1.6rem;
        }

        .live-team .team-name {
            font-size: 1.12rem;
        }
    }

    @media (max-width: 576px) {
        :root {
            --header-height: 56px;
        }

        .banner-section .carousel-item img {
            height: 240px;
            object-position: center 18%;
        }

        .cricket-header h2 {
            font-size: 1.2rem;
            letter-spacing: 1px;
        }

        .cricket-header h2 .icon-cricket {
            font-size: 1.3rem;
        }

        .header-live-indicator {
            font-size: 0.65rem;
            padding: 4px 10px;
        }

        .banner-section .carousel-item img {
            height: 180px;
        }

        .section-title {
            font-size: 1rem;
            margin: 20px 0 12px;
        }

        .section-title .title-icon {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .live-card {
            padding: 18px 16px;
            border-radius: 22px;
        }

        .live-team .team-avatar {
            width: 72px;
            height: 72px;
            font-size: 1.2rem;
        }

        .live-team .team-name {
            font-size: 0.88rem;
        }

        .live-vs {
            width: 40px;
            height: 40px;
            font-size: 0.82rem;
        }

        .live-score .score-text {
            font-size: 1.2rem;
        }

        .upcoming-card {
            padding: 14px;
        }

        .upcoming-card .match-teams {
            font-size: 0.92rem;
        }

        .upcoming-card .match-logo {
            width: 52px;
            height: 52px;
        }

        .upcoming-scroll {
            grid-template-columns: 1fr;
        }

        .tournament-card {
            padding: 14px;
        }

        .tournament-card .trophy-icon {
            width: 38px;
            height: 38px;
            font-size: 0.95rem;
            border-radius: 10px;
        }

        .player-avatar {
            width: 58px;
            height: 58px;
            font-size: 1.3rem;
        }

        .player-card {
            min-width: 85px;
        }

        .player-name {
            font-size: 0.72rem;
        }

        .host-btn {
            padding: 10px 24px;
            font-size: 0.82rem;
        }

        .cricket-modal .modal-dialog {
            margin: 10px;
        }

        .modal-header-custom {
            padding: 18px 20px;
        }

        .modal-header-custom h5 {
            font-size: 1.05rem;
        }

        .modal-body-custom {
            padding: 16px;
        }

        .status-modal-body {
            padding: 28px 16px;
        }

        .status-icon {
            width: 68px;
            height: 68px;
            font-size: 1.8rem;
        }

        .status-title {
            font-size: 1.05rem;
        }

        .pool-btn-content {
            padding: 10px 18px;
            gap: 10px;
        }

        .pool-btn-icon {
            font-size: 1.2rem;
        }

        .pool-btn-label {
            font-size: 0.84rem;
        }

        .pool-btn-sub {
            font-size: 0.62rem;
        }
    }

    @media (max-width: 380px) {
        .live-teams {
            gap: 12px;
        }

        .live-team .team-avatar {
            width: 58px;
            height: 58px;
            font-size: 1rem;
        }

        .live-team .team-name {
            font-size: 0.72rem;
        }

        .upcoming-card {
            min-width: 190px;
        }

        .pool-btn-content {
            padding: 9px 14px;
            gap: 8px;
        }

        .pool-btn-label {
            font-size: 0.78rem;
        }

        .pool-btn-arrow {
            display: none;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- ========== STICKY HEADER - ISOLATED ========== -->
<!-- <div class="cricket-header-wrapper">
    <div class="cricket-header">
        <div class="container">
            <div class="header-left">
                <h2>
                    <span class="icon-cricket">🏏</span>
                    CRICKET
                    <span class="dot"></span>
                </h2>
            </div>
            <div class="header-live-indicator">
                <span class="live-dot"></span>  
                LIVE
            </div>
        </div>
    </div>
</div> -->

<!-- ========== MAIN CONTENT ========== -->
<div class="cricket-content">

    <!-- BANNER -->
    <div class="banner-section animate-in delay-1">
        <div class="container">
            <div class="banner-shell">
                <div class="banner-topbar">
                    <div class="banner-kicker">
                        <i class="fas fa-trophy"></i>
                        Featured Match
                    </div>
                    <div class="banner-status <?= !empty($live_match) ? 'live' : (!empty($featured_match) && ($featured_match['bucket'] ?? '') === 'today' ? 'today' : 'upcoming') ?>">
                        <i class="fas fa-bolt"></i>
                        <?= !empty($live_match) ? 'Live Now' : (!empty($featured_match) && ($featured_match['bucket'] ?? '') === 'today' ? 'Today Match' : 'Upcoming Match') ?>
                    </div>
                </div>

                <div class="banner-match">
                    <div class="banner-team">
                        <div class="banner-logo"><?= $renderCricketTeamAvatar($live['team1_logo'] ?? '', $live['team1'] ?? '') ?></div>
                        <div class="banner-team-name"><?= html_escape($live['team1']) ?></div>
                    </div>

                    <div class="banner-center">
                        <div class="banner-vs">VS</div>
                        <div class="banner-time"><?= html_escape($live['score'] ?? 'Schedule not set') ?></div>
                        <div class="banner-subtime"><?= html_escape($live['start_label'] ?? 'Schedule not set') ?></div>
                    </div>

                    <div class="banner-team">
                        <div class="banner-logo"><?= $renderCricketTeamAvatar($live['team2_logo'] ?? '', $live['team2'] ?? '') ?></div>
                        <div class="banner-team-name"><?= html_escape($live['team2']) ?></div>
                    </div>
                </div>

                <div class="banner-meta">
                    <?php if (!empty($live['competition_name'])): ?>
                        <span class="banner-chip"><i class="fas fa-award"></i> <?= html_escape($live['competition_name']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($live['venue'])): ?>
                        <span class="banner-chip"><i class="fas fa-map-marker-alt"></i> <?= html_escape($live['venue']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($live['start_label'])): ?>
                        <span class="banner-chip"><i class="fas fa-clock"></i> <?= html_escape($live['start_label']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <!-- LIVE MATCH -->
        <h4 class="section-title animate-in delay-2">
            <span class="title-icon live"><i class="fas fa-circle" style="font-size:0.6rem"></i></span>
            Live Match
        </h4>

        <div class="live-card animate-in delay-2">
            <div class="card-glow-1"></div>
            <div class="card-glow-2"></div>
            <div class="live-badge">
                <span class="blink-dot"></span>
                <?= ($live['status'] ?? '') === 'LIVE' ? 'LIVE NOW' : (($live['status'] ?? '') === 'TODAY' ? 'TODAY MATCH' : 'UPCOMING MATCH') ?>
            </div>
            <div class="live-teams">
                <div class="live-team">
                    <div class="team-avatar">🏏</div>
                    <div class="team-name"><?= html_escape($live['team1']) ?></div>
                </div>
                <div class="live-vs">VS</div>
                <div class="live-team">
                    <div class="team-avatar">🏏</div>
                    <div class="team-name"><?= html_escape($live['team2']) ?></div>
                </div>
            </div>
            <div class="live-score">
                <div class="score-text"><?= $live['score'] ?></div>
                <div class="score-status"><?= !empty($live_match) ? 'Match in progress' : html_escape($live['start_label'] ?? 'Schedule not set') ?></div>
            </div>
            <?php if (!empty($live['competition_name']) || !empty($live['venue']) || !empty($live['start_label'])): ?>
                <div class="live-meta">
                    <?php if (!empty($live['competition_name'])): ?>
                        <span class="live-meta-chip"><i class="fas fa-trophy"></i> <?= html_escape($live['competition_name']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($live['venue'])): ?>
                        <span class="live-meta-chip"><i class="fas fa-map-marker-alt"></i> <?= html_escape($live['venue']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($live['start_label'])): ?>
                        <span class="live-meta-chip"><i class="fas fa-clock"></i> <?= html_escape($live['start_label']) ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="text-center mt-3" style="position: relative; z-index: 1;">
                <a href="<?= base_url('pool') ?>" class="pool-cta-btn">
                    <span class="pool-btn-bg"></span>
                    <span class="pool-btn-shine"></span>
                    <span class="pool-btn-content">

                        <i class="fas fa-play-circle pool-btn-icon"></i>

                        <span class="pool-btn-text-group">
                            <?php if ($user['is_host'] == 1): ?>
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

        <!-- TODAY -->
        <h4 class="section-title animate-in delay-3">
            <span class="title-icon upcoming"><i class="fas fa-bolt"></i></span>
            Today Matches
        </h4>

        <div class="upcoming-scroll animate-in delay-3">
            <?php if (!empty($today_matches)): ?>
                <?php foreach ($today_matches as $u): ?>
                    <div class="upcoming-card">
                        <div class="card-accent"></div>
                        <div class="match-league"><i class="fas fa-circle text-warning"></i> <?= html_escape($u['competition_name'] ?: 'Today Match') ?></div>
                        <div class="match-row">
                            <div class="match-logo"><?= $renderCricketTeamAvatar($u['team1_logo'] ?? '', $u['team1'] ?? '') ?></div>
                            <div class="match-vs-badge">VS</div>
                            <div class="match-logo"><?= $renderCricketTeamAvatar($u['team2_logo'] ?? '', $u['team2'] ?? '') ?></div>
                        </div>
                        <div class="match-teams"><?= html_escape($u['teams']) ?></div>
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
                <div class="upcoming-card">
                    <div class="card-accent"></div>
                    <div class="match-teams">No today matches available.</div>
                    <div class="match-date"><i class="fas fa-info-circle"></i> Matches scheduled for today will appear here.</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- UPCOMING -->
        <h4 class="section-title animate-in delay-4">
            <span class="title-icon upcoming"><i class="fas fa-calendar-alt"></i></span>
            Upcoming Matches
        </h4>

        <div class="upcoming-scroll animate-in delay-4">
            <?php if (!empty($upcoming)): ?>
                <?php foreach ($upcoming as $u): ?>
                    <div class="upcoming-card">
                        <div class="card-accent"></div>
                        <div class="match-league"><i class="fas fa-calendar-alt"></i> <?= html_escape($u['competition_name'] ?: 'Upcoming Match') ?></div>
                        <div class="match-row">
                            <div class="match-logo"><?= $renderCricketTeamAvatar($u['team1_logo'] ?? '', $u['team1'] ?? '') ?></div>
                            <div class="match-vs-badge">VS</div>
                            <div class="match-logo"><?= $renderCricketTeamAvatar($u['team2_logo'] ?? '', $u['team2'] ?? '') ?></div>
                        </div>
                        <div class="match-teams"><?= html_escape($u['teams']) ?></div>
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
                <div class="upcoming-card">
                    <div class="card-accent"></div>
                    <div class="match-teams">No upcoming matches available.</div>
                    <div class="match-date"><i class="fas fa-info-circle"></i> Add more scheduled matches from admin to show them here.</div>
                </div>
            <?php endif; ?>
        </div>

        <!-- TOURNAMENTS -->
        <h4 class="section-title animate-in delay-5">
            <span class="title-icon tournament"><i class="fas fa-trophy"></i></span>
            Tournaments
        </h4>

        <div class="tournament-grid animate-in delay-5">
            <?php foreach ($tournaments as $t): ?>
                <div class="tournament-card">
                    <div class="trophy-icon">🏆</div>
                    <div class="tournament-info">
                        <div class="tournament-name"><?= $t['name'] ?></div>
                        <div class="tournament-date">
                            <i class="far fa-calendar"></i>
                            <?= $t['date'] ?>
                        </div>
                    </div>
                    <div class="arrow-icon">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- PLAYERS -->
        <h4 class="section-title animate-in delay-5">
            <span class="title-icon players"><i class="fas fa-users"></i></span>
            Featured Players
        </h4>

        <div class="players-scroll animate-in delay-5">
            <?php foreach ($players as $p): ?>
                <div class="player-card">
                    <div class="player-avatar">
                        <i class="fas fa-user"></i>
                        <div class="spin-border"></div>
                    </div>
                    <div class="player-name"><?= $p ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- HOST BUTTON -->
        <div class="host-section animate-in delay-5">
            <?php if (!$request): ?>
                <button class="host-btn btn-become" data-bs-toggle="modal" data-bs-target="#hostModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-crown"></i>
                    Become a Host
                </button>
            <?php elseif ($request['status'] == 'pending'): ?>
                <button class="host-btn btn-pending" data-bs-toggle="modal" data-bs-target="#pendingModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-hourglass-half"></i>
                    Request Pending
                </button>
            <?php elseif ($request['status'] == 'accepted'): ?>
                <button class="host-btn btn-accepted" data-bs-toggle="modal" data-bs-target="#acceptedModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-check-circle"></i>
                    You are a Host
                </button>
            <?php else: ?>
                <button class="host-btn btn-rejected" data-bs-toggle="modal" data-bs-target="#rejectedModal">
                    <span class="btn-shine"></span>
                    <i class="fas fa-times-circle"></i>
                    Request Rejected
                </button>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- ========== MODALS ========== -->

<!-- HOST FORM MODAL -->
<div class="modal fade cricket-modal" id="hostModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-custom">
                <button type="button" class="modal-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <h5><i class="fas fa-crown"></i> Become a Host</h5>
                <div class="subtitle">Fill in the details to apply</div>
            </div>
            <div class="modal-body-custom">
                <div class="user-info-item">
                    <div class="info-icon name-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="info-label">Full Name</div>
                        <div class="info-text"><?= $user['name'] ?></div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon email-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-text"><?= $user['email'] ?></div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon phone-icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="info-label">Mobile</div>
                        <div class="info-text"><?= $user['mobile'] ?></div>
                    </div>
                </div>

                <input type="text" id="insta" class="form-input-custom" placeholder="🔗 Instagram Profile URL">
                <div id="msg"></div>

                <button class="submit-btn" id="submitHostBtn" onclick="submitHost()">
                    <span class="btn-text">Submit Application</span>
                    <span class="spinner-sm"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PENDING MODAL -->
<div class="modal fade cricket-modal" id="pendingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon pending">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="status-title">Under Review</div>
                <div class="status-subtitle">Your host application is being reviewed. We'll notify you once it's processed.</div>
                <button class="modal-close-btn pending-btn" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>

<!-- ACCEPTED MODAL -->
<div class="modal fade cricket-modal" id="acceptedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon accepted">
                    <i class="fas fa-check"></i>
                </div>
                <div class="status-title">Congratulations! 🎉</div>
                <div class="status-subtitle">You are now an official Cricket Host. Start organizing matches and tournaments!</div>
                <button class="modal-close-btn accepted-btn" data-bs-dismiss="modal">Awesome!</button>
            </div>
        </div>
    </div>
</div>

<!-- REJECTED MODAL -->
<div class="modal fade cricket-modal" id="rejectedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="status-modal-body">
                <div class="status-icon rejected">
                    <i class="fas fa-times"></i>
                </div>
                <div class="status-title">Request Declined</div>
                <div class="status-subtitle">Unfortunately, your host application was not approved. Please contact support for more information.</div>
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
                msg.innerHTML = '<div class="msg-success"><i class="fas fa-check-circle"></i> Application submitted successfully!</div>';
                setTimeout(() => location.reload(), 1500);
            })
            .catch(err => {
                btn.classList.remove('loading');
                msg.innerHTML = '<div class="msg-error"><i class="fas fa-exclamation-triangle"></i> Something went wrong. Please try again.</div>';
            });
    }

    // Reset modal form on close
    document.getElementById('hostModal')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('msg').innerHTML = '';
        document.getElementById('insta').value = '';
        document.getElementById('insta').style.borderColor = '#e9ecef';
        document.getElementById('submitHostBtn').classList.remove('loading');
    });

    // Intersection Observer
    document.addEventListener('DOMContentLoaded', function() {
        const liveTeamAvatars = document.querySelectorAll('.live-teams .live-team .team-avatar');
        const liveTeamAvatarHtml = [
            <?= json_encode($renderCricketTeamAvatar($live['team1_logo'] ?? '', $live['team1'] ?? '')) ?>,
            <?= json_encode($renderCricketTeamAvatar($live['team2_logo'] ?? '', $live['team2'] ?? '')) ?>
        ];

        liveTeamAvatars.forEach((avatar, index) => {
            if (liveTeamAvatarHtml[index]) {
                avatar.innerHTML = liveTeamAvatarHtml[index];
            }
        });

        const bannerSection = document.querySelector('.banner-section');
        const carouselElement = document.getElementById('cricketCarousel');

        if (carouselElement && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
            const carousel = bootstrap.Carousel.getOrCreateInstance(carouselElement, {
                interval: 4000,
                ride: 'carousel',
                pause: false,
                wrap: true,
                touch: true
            });

            let touchStartX = 0;
            let touchStartY = 0;
            let touchEndX = 0;
            let touchEndY = 0;
            let isHorizontalSwipe = false;

            const resetAutoplay = () => {
                carousel.cycle();
            };

            carouselElement.addEventListener('slid.bs.carousel', resetAutoplay);
            carouselElement.addEventListener('mouseenter', function() {
                carousel.pause();
            });
            carouselElement.addEventListener('mouseleave', resetAutoplay);

            carouselElement.addEventListener('touchstart', function(event) {
                const touch = event.changedTouches[0];
                touchStartX = touch.clientX;
                touchStartY = touch.clientY;
                touchEndX = touch.clientX;
                touchEndY = touch.clientY;
                isHorizontalSwipe = false;
                if (bannerSection) {
                    bannerSection.classList.add('is-touching');
                }
            }, {
                passive: true
            });

            carouselElement.addEventListener('touchmove', function(event) {
                const touch = event.changedTouches[0];
                touchEndX = touch.clientX;
                touchEndY = touch.clientY;
                isHorizontalSwipe = Math.abs(touchEndX - touchStartX) > Math.abs(touchEndY - touchStartY);
            }, {
                passive: true
            });

            carouselElement.addEventListener('touchend', function() {
                const deltaX = touchEndX - touchStartX;
                const deltaY = touchEndY - touchStartY;

                if (bannerSection) {
                    bannerSection.classList.remove('is-touching');
                }

                if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > Math.abs(deltaY) && isHorizontalSwipe) {
                    if (deltaX < 0) {
                        carousel.next();
                    } else {
                        carousel.prev();
                    }
                }

                resetAutoplay();
            }, {
                passive: true
            });
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.animate-in').forEach(el => observer.observe(el));
    });
</script>