<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/png">

	<!-- Google Fonts: Poppins -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">

	<!-- Local Boxicons CSS -->
	<link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">

	<!-- Select2 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

	<!-- Tagify CSS -->
	<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

	<!-- Lucide Icons -->
	<script src="https://unpkg.com/lucide@latest"></script>

	<!-- Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<title><?= isset($page_title) ? $page_title : 'Provider Panel' ?></title>

	<!-- ⚡ CRITICAL: Apply theme + sidebar state BEFORE render to prevent flash -->
	<script>
		(function() {
			var t = localStorage.getItem('admin_theme') || 'dark';
			var c = localStorage.getItem('sidebar_collapsed') === 'true';
			document.documentElement.setAttribute('data-theme', t);
			// Inject sidebar state class on html so CSS can use it before JS runs
			if (c) document.documentElement.classList.add('sidebar-pre-collapsed');
		})();
	</script>

	<style>
		/* ==========================================
           CSS VARIABLES & THEME
        ========================================== */
		:root {
			--primary: #6366F1;
			--primary-dark: #4f46e5;
			--primary-light: #818cf8;
			--secondary: #8B5CF6;
			--success: #10B981;
			--warning: #F59E0B;
			--danger: #EF4444;
			--info: #3B82F6;

			--bg-primary: #ffffff;
			--bg-secondary: #f8fafc;
			--bg-tertiary: #f1f5f9;
			--text-primary: #0f172a;
			--text-secondary: #64748b;
			--text-tertiary: #94a3b8;
			--border-color: #e2e8f0;
			--shadow: rgba(0, 0, 0, 0.08);
			--shadow-lg: rgba(0, 0, 0, 0.15);
			--sidebar-bg: #ffffff;

			--sidebar-width: 260px;
			--sidebar-collapsed-width: 72px;
			--topbar-height: 64px;

			--sp-xs: 0.5rem;
			--sp-sm: 0.75rem;
			--sp-md: 1rem;
			--sp-lg: 1.5rem;
			--sp-xl: 2rem;

			--r-sm: 8px;
			--r-md: 12px;
			--r-lg: 16px;
			--r-xl: 20px;

			--transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			--transition-fast: all 0.15s ease;
		}

		[data-theme="dark"] {
			--bg-primary: #0f172a;
			--bg-secondary: #1e293b;
			--bg-tertiary: #334155;
			--text-primary: #f1f5f9;
			--text-secondary: #cbd5e1;
			--text-tertiary: #94a3b8;
			--border-color: rgba(255, 255, 255, 0.08);
			--shadow: rgba(0, 0, 0, 0.3);
			--shadow-lg: rgba(0, 0, 0, 0.5);
			--sidebar-bg: #1e293b;
		}

		/* ==========================================
           RESET & BASE
        ========================================== */
		*,
		*::before,
		*::after {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		html {
			scroll-behavior: smooth;
		}

		body {
			font-family: 'Poppins', sans-serif;
			background: var(--bg-secondary);
			color: var(--text-primary);
			font-size: 14px;
			line-height: 1.6;
			overflow-x: hidden;
			transition: background 0.3s ease, color 0.3s ease;
		}

		a {
			text-decoration: none;
			color: inherit;
		}

		button {
			font-family: inherit;
			cursor: pointer;
		}

		img {
			display: block;
		}

		::-webkit-scrollbar {
			width: 5px;
			height: 5px;
		}

		::-webkit-scrollbar-track {
			background: var(--bg-secondary);
		}

		::-webkit-scrollbar-thumb {
			background: var(--border-color);
			border-radius: 4px;
		}

		::-webkit-scrollbar-thumb:hover {
			background: var(--text-tertiary);
		}

		/* ==========================================
           LAYOUT
        ========================================== */
		.admin-wrapper {
			display: flex;
			min-height: 100vh;
		}

		/* ==========================================
           SIDEBAR
        ========================================== */
		.sidebar {
			position: fixed;
			left: 0;
			top: 0;
			height: 100vh;
			width: var(--sidebar-width);
			background: var(--sidebar-bg);
			border-right: 1px solid var(--border-color);
			display: flex;
			flex-direction: column;
			transition: var(--transition);
			z-index: 1000;
			overflow: hidden;
		}

		.sidebar.collapsed {
			width: var(--sidebar-collapsed-width);
		}

		/* Pre-collapse: applied via JS before render to avoid flash */
		html.sidebar-pre-collapsed .sidebar {
			width: var(--sidebar-collapsed-width);
		}

		html.sidebar-pre-collapsed .main-content {
			margin-left: var(--sidebar-collapsed-width);
		}

		/* Sidebar Header */
		.sidebar-header {
			padding: 12px var(--sp-md);
			display: flex;
			align-items: center;
			justify-content: space-between;
			border-bottom: 1px solid var(--border-color);
			height: var(--topbar-height);
			flex-shrink: 0;
			gap: 8px;
		}

		.logo {
			display: flex;
			align-items: center;
			overflow: hidden;
			min-width: 0;
			flex: 1;
		}

		.logo-img-full {
			height: 38px;
			width: auto;
			max-width: 160px;
			object-fit: contain;
			transition: var(--transition);
		}

		.logo-img-icon {
			width: 36px;
			height: 36px;
			border-radius: var(--r-md);
			object-fit: contain;
			display: none;
			flex-shrink: 0;
		}

		.logo-icon-fallback {
			width: 36px;
			height: 36px;
			background: linear-gradient(135deg, var(--primary), var(--secondary));
			border-radius: var(--r-md);
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			flex-shrink: 0;
		}

		.logo-icon-fallback svg {
			width: 20px;
			height: 20px;
		}

		.sidebar.collapsed .logo-img-full,
		html.sidebar-pre-collapsed .logo-img-full {
			display: none;
		}

		.sidebar.collapsed .logo-img-icon,
		html.sidebar-pre-collapsed .logo-img-icon {
			display: block;
		}

		.sidebar.collapsed .logo-icon-fallback,
		html.sidebar-pre-collapsed .logo-icon-fallback {
			display: flex;
		}

		.sidebar-toggle-btn {
			background: transparent;
			border: none;
			color: var(--text-secondary);
			padding: 6px;
			border-radius: var(--r-sm);
			display: flex;
			align-items: center;
			justify-content: center;
			transition: var(--transition-fast);
			flex-shrink: 0;
		}

		.sidebar-toggle-btn:hover {
			background: var(--bg-tertiary);
			color: var(--text-primary);
		}

		.sidebar-toggle-btn svg {
			width: 18px;
			height: 18px;
		}

		/* Sidebar Nav */
		.sidebar-nav {
			flex: 1;
			padding: var(--sp-sm);
			overflow-y: auto;
			overflow-x: hidden;
		}

		.nav-section-label {
			font-size: 0.62rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.09em;
			color: var(--text-tertiary);
			padding: var(--sp-md) var(--sp-sm) 4px;
			white-space: nowrap;
			overflow: hidden;
			transition: var(--transition);
		}

		.sidebar.collapsed .nav-section-label,
		html.sidebar-pre-collapsed .sidebar .nav-section-label {
			opacity: 0;
			height: 0;
			padding: 0;
		}

		.nav-item {
			margin-bottom: 2px;
		}

		.nav-link {
			display: flex;
			align-items: center;
			gap: 10px;
			padding: 10px var(--sp-sm);
			border-radius: var(--r-md);
			color: var(--text-secondary);
			cursor: pointer;
			transition: var(--transition-fast);
			font-weight: 500;
			font-size: 0.85rem;
			white-space: nowrap;
			overflow: hidden;
			position: relative;
			text-decoration: none;
		}

		.nav-link:hover {
			background: var(--bg-tertiary);
			color: var(--text-primary);
		}

		.nav-item.active>.nav-link {
			background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.15));
			color: var(--primary-light);
		}

		.nav-link>svg:first-child {
			width: 20px;
			height: 20px;
			flex-shrink: 0;
		}

		.nav-link-text {
			flex: 1;
			transition: var(--transition);
		}

		.sidebar.collapsed .nav-link-text,
		.sidebar.collapsed .submenu-chevron,
		html.sidebar-pre-collapsed .sidebar .nav-link-text,
		html.sidebar-pre-collapsed .sidebar .submenu-chevron {
			display: none;
		}

		.sidebar.collapsed .nav-link,
		html.sidebar-pre-collapsed .sidebar .nav-link {
			justify-content: center;
			padding: 10px;
		}

		.submenu-chevron {
			width: 15px;
			height: 15px;
			margin-left: auto;
			transition: transform 0.3s ease;
			flex-shrink: 0;
			color: var(--text-tertiary);
		}

		.nav-item.open>.nav-link .submenu-chevron {
			transform: rotate(180deg);
		}

		/* Submenu */
		.submenu {
			max-height: 0;
			overflow: hidden;
			transition: max-height 0.35s ease;
			padding-left: 30px;
		}

		.nav-item.open>.submenu {
			max-height: 400px;
		}

		.sidebar.collapsed .submenu {
			display: none;
		}

		.submenu-link {
			display: flex;
			align-items: center;
			gap: 8px;
			padding: 8px var(--sp-sm);
			border-radius: var(--r-md);
			color: var(--text-secondary);
			font-size: 0.815rem;
			font-weight: 400;
			transition: var(--transition-fast);
			margin-top: 2px;
			white-space: nowrap;
			text-decoration: none;
		}

		.submenu-link svg {
			width: 15px;
			height: 15px;
			flex-shrink: 0;
		}

		.submenu-link:hover {
			background: var(--bg-tertiary);
			color: var(--text-primary);
		}

		.submenu-link.active {
			background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(139, 92, 246, 0.12));
			color: var(--primary-light);
			font-weight: 500;
		}

		/* Collapsed tooltip */
		.sidebar.collapsed .nav-link[data-tooltip]:hover::after {
			content: attr(data-tooltip);
			position: absolute;
			left: calc(var(--sidebar-collapsed-width) + 4px);
			top: 50%;
			transform: translateY(-50%);
			background: var(--bg-tertiary);
			color: var(--text-primary);
			padding: 4px 10px;
			border-radius: var(--r-sm);
			font-size: 0.75rem;
			white-space: nowrap;
			z-index: 9999;
			box-shadow: 0 4px 12px var(--shadow-lg);
			border: 1px solid var(--border-color);
			pointer-events: none;
		}

		/* ==========================================
           MAIN CONTENT
        ========================================== */
		.main-content {
			margin-left: var(--sidebar-width);
			flex: 1;
			min-height: 100vh;
			transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			display: flex;
			flex-direction: column;
			background: var(--bg-secondary);
			/* FIX: Prevent content from overflowing topbar */
			min-width: 0;
		}

		.sidebar.collapsed~.main-content {
			margin-left: var(--sidebar-collapsed-width);
		}

		/* ==========================================
           TOPBAR — FIXED
        ========================================== */
		.topbar {
			position: sticky;
			top: 0;
			z-index: 999;
			height: var(--topbar-height);
			background: var(--bg-primary);
			border-bottom: 1px solid var(--border-color);
			padding: 0 var(--sp-xl);
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: var(--sp-md);
			box-shadow: 0 1px 3px var(--shadow);
			/* FIX: Ensure topbar never shrinks or overflows */
			min-width: 0;
			width: 100%;
		}

		.topbar-left {
			display: flex;
			align-items: center;
			gap: var(--sp-sm);
			/* FIX: Don't let left side grow and push right side off screen */
			flex: 1;
			min-width: 0;
		}

		.mobile-sidebar-toggle {
			display: none;
			background: transparent;
			border: none;
			color: var(--text-primary);
			padding: 6px;
			border-radius: var(--r-sm);
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
		}

		.mobile-sidebar-toggle svg {
			width: 22px;
			height: 22px;
		}

		/* Impersonation bar */
		.impersonation-bar {
			display: flex;
			align-items: center;
			gap: var(--sp-sm);
			background: rgba(245, 158, 11, 0.1);
			border: 1px solid rgba(245, 158, 11, 0.3);
			border-radius: var(--r-sm);
			padding: 5px 12px;
			font-size: 0.775rem;
			color: var(--warning);
			/* FIX: don't let it overflow */
			overflow: hidden;
			min-width: 0;
		}

		.impersonation-bar svg {
			width: 15px;
			height: 15px;
			flex-shrink: 0;
		}

		.impersonation-bar a {
			background: var(--warning);
			color: #fff;
			padding: 3px 10px;
			border-radius: 50px;
			font-size: 0.72rem;
			font-weight: 600;
			display: inline-flex;
			align-items: center;
			gap: 4px;
			white-space: nowrap;
			flex-shrink: 0;
		}

		/* Topbar Right — FIX: never shrink, always visible */
		.topbar-right {
			display: flex;
			align-items: center;
			gap: 6px;
			flex-shrink: 0;
			/* ← KEY FIX: don't let right side compress */
		}

		.icon-btn {
			width: 38px;
			height: 38px;
			background: transparent;
			border: none;
			border-radius: var(--r-md);
			color: var(--text-secondary);
			display: flex;
			align-items: center;
			justify-content: center;
			transition: var(--transition-fast);
			position: relative;
			flex-shrink: 0;
		}

		.icon-btn svg {
			width: 20px;
			height: 20px;
		}

		.icon-btn:hover {
			background: var(--bg-secondary);
			color: var(--text-primary);
		}

		/* User Menu Button — FIX: keep it stable */
		.user-menu-wrapper {
			position: relative;
			flex-shrink: 0;
		}

		.user-menu-btn {
			display: flex;
			align-items: center;
			gap: var(--sp-sm);
			background: transparent;
			border: 1px solid var(--border-color);
			border-radius: 50px;
			padding: 5px 14px 5px 5px;
			cursor: pointer;
			transition: var(--transition-fast);
			color: var(--text-primary);
			white-space: nowrap;
		}

		.user-menu-btn:hover {
			background: var(--bg-secondary);
			border-color: var(--primary-light);
		}

		.user-avatar {
			width: 32px;
			height: 32px;
			border-radius: 50%;
			object-fit: cover;
			flex-shrink: 0;
			border: 2px solid var(--border-color);
		}

		/* Fallback avatar if image fails */
		.user-avatar-fallback {
			width: 32px;
			height: 32px;
			border-radius: 50%;
			background: linear-gradient(135deg, var(--primary), var(--secondary));
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 0.75rem;
			font-weight: 700;
			flex-shrink: 0;
		}

		.user-menu-btn .user-name {
			font-size: 0.825rem;
			font-weight: 500;
			max-width: 130px;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.user-menu-btn .chevron-icon {
			width: 15px;
			height: 15px;
			color: var(--text-tertiary);
			flex-shrink: 0;
			transition: transform 0.2s ease;
		}

		.user-menu-btn.open .chevron-icon {
			transform: rotate(180deg);
		}

		/* Dropdown */
		.topbar-dropdown {
			position: absolute;
			top: calc(100% + 10px);
			right: 0;
			min-width: 210px;
			background: var(--bg-primary);
			border: 1px solid var(--border-color);
			border-radius: var(--r-lg);
			box-shadow: 0 12px 40px var(--shadow-lg);
			padding: var(--sp-xs);
			opacity: 0;
			visibility: hidden;
			transform: translateY(-8px);
			transition: var(--transition-fast);
			z-index: 9999;
		}

		.topbar-dropdown.open {
			opacity: 1;
			visibility: visible;
			transform: translateY(0);
		}

		.dropdown-header {
			padding: var(--sp-sm) var(--sp-md);
			border-bottom: 1px solid var(--border-color);
			margin-bottom: 4px;
		}

		.dropdown-header p:first-child {
			font-size: 0.85rem;
			font-weight: 600;
			color: var(--text-primary);
		}

		.dropdown-header p:last-child {
			font-size: 0.72rem;
			color: var(--text-tertiary);
			margin-top: 1px;
		}

		.dropdown-divider {
			border: none;
			border-top: 1px solid var(--border-color);
			margin: 4px 0;
		}

		.dropdown-item {
			display: flex;
			align-items: center;
			gap: var(--sp-sm);
			padding: 9px var(--sp-md);
			border-radius: var(--r-sm);
			font-size: 0.825rem;
			color: var(--text-secondary);
			cursor: pointer;
			transition: var(--transition-fast);
			text-decoration: none;
		}

		.dropdown-item svg {
			width: 15px;
			height: 15px;
			flex-shrink: 0;
		}

		.dropdown-item:hover {
			background: var(--bg-secondary);
			color: var(--text-primary);
		}

		.dropdown-item.danger:hover {
			background: rgba(239, 68, 68, 0.08);
			color: var(--danger);
		}

		/* ==========================================
           PAGE CONTENT
        ========================================== */
		.page-content {
			padding: var(--sp-xl);
			flex: 1;
		}

		/* Fix double spacing on all pages */
		.page-wrapper {
			margin: 0 !important;
			padding: 0 !important;
			width: 100% !important;
		}

		.page-content .page-content {
			padding: 0 !important;
		}

		.page-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: var(--sp-xl);
			flex-wrap: wrap;
			gap: var(--sp-md);
		}

		.page-title {
			font-size: 1.25rem;
			font-weight: 700;
			color: var(--text-primary);
		}

		.page-subtitle {
			font-size: 0.78rem;
			color: var(--text-tertiary);
			margin-top: 2px;
		}

		.breadcrumb {
			display: flex;
			align-items: center;
			gap: 5px;
			font-size: 0.75rem;
			color: var(--text-tertiary);
			margin-top: 3px;
		}

		.breadcrumb a {
			color: var(--primary);
		}

		.breadcrumb svg {
			width: 12px;
			height: 12px;
		}

		/* ==========================================
           CARDS
        ========================================== */
		.card {
			background: var(--bg-primary);
			border: 1px solid var(--border-color);
			border-radius: var(--r-lg);
			box-shadow: 0 1px 4px var(--shadow);
		}

		.card-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: var(--sp-lg);
			border-bottom: 1px solid var(--border-color);
		}

		.card-title {
			font-size: 0.95rem;
			font-weight: 600;
			color: var(--text-primary);
		}

		.card-body {
			padding: var(--sp-lg);
		}

		/* ==========================================
           STAT CARDS
        ========================================== */
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: var(--sp-lg);
			margin-bottom: var(--sp-xl);
		}

		.stat-card {
			background: var(--bg-primary);
			border: 1px solid var(--border-color);
			border-radius: var(--r-lg);
			padding: var(--sp-lg);
			display: flex;
			align-items: center;
			gap: var(--sp-md);
			box-shadow: 0 1px 4px var(--shadow);
			transition: transform 0.2s ease, box-shadow 0.2s ease;
			overflow: hidden;
		}

		.stat-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px var(--shadow-lg);
		}

		.stat-icon {
			width: 52px;
			height: 52px;
			border-radius: var(--r-md);
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
		}

		.stat-icon svg {
			width: 26px;
			height: 26px;
			color: #fff;
		}

		.stat-info {
			flex: 1;
			min-width: 0;
		}

		.stat-value {
			font-size: 1.8rem;
			font-weight: 700;
			color: var(--text-primary);
			line-height: 1.1;
			white-space: nowrap;
		}

		.stat-label {
			font-size: 0.775rem;
			color: var(--text-secondary);
			margin-top: 3px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.stat-change {
			font-size: 0.72rem;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 3px;
			margin-top: 4px;
		}

		.stat-change.up {
			color: var(--success);
		}

		.stat-change.down {
			color: var(--danger);
		}

		.stat-change svg {
			width: 13px;
			height: 13px;
		}

		/* ==========================================
           BUTTONS
        ========================================== */
		.btn {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			padding: 8px 18px;
			border-radius: var(--r-md);
			font-family: 'Poppins', sans-serif;
			font-size: 0.825rem;
			font-weight: 500;
			border: none;
			cursor: pointer;
			transition: var(--transition-fast);
			text-decoration: none;
		}

		.btn svg {
			width: 16px;
			height: 16px;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--primary), var(--secondary));
			color: #fff;
		}

		.btn-primary:hover {
			opacity: 0.88;
			transform: translateY(-1px);
		}

		.btn-secondary {
			background: var(--bg-tertiary);
			color: var(--text-secondary);
			border: 1px solid var(--border-color);
		}

		.btn-secondary:hover {
			background: var(--bg-secondary);
			color: var(--text-primary);
		}

		.btn-success {
			background: var(--success);
			color: #fff;
		}

		.btn-danger {
			background: var(--danger);
			color: #fff;
		}

		.btn-warning {
			background: var(--warning);
			color: #fff;
		}

		.btn-info {
			background: var(--info);
			color: #fff;
		}

		.btn-sm {
			padding: 5px 12px;
			font-size: 0.775rem;
		}

		.btn-lg {
			padding: 11px 24px;
			font-size: 0.95rem;
		}

		/* ==========================================
           TABLES
        ========================================== */
		.table-wrapper {
			overflow-x: auto;
			border-radius: var(--r-lg);
			background: var(--bg-primary);
		}

		.data-table {
			width: 100%;
			border-collapse: collapse;
			background-color: var(--bg-primary) !important;
			color: var(--text-primary) !important;
			--bs-table-bg: var(--bg-primary) !important;
			--bs-table-color: var(--text-primary) !important;
			--bs-table-border-color: var(--border-color) !important;
			--bs-table-striped-bg: var(--bg-secondary) !important;
			--bs-table-hover-bg: var(--bg-secondary) !important;
			border-color: var(--border-color) !important;
		}

		.data-table th {
			padding: 14px var(--sp-md);
			text-align: left;
			font-size: 0.75rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.05em;
			color: var(--text-tertiary) !important;
			background: var(--bg-secondary) !important;
			background-color: var(--bg-secondary) !important;
			border-bottom: 1px solid var(--border-color) !important;
			white-space: nowrap;
		}

		.data-table td {
			padding: 14px var(--sp-md);
			font-size: 0.825rem;
			color: var(--text-secondary) !important;
			border-bottom: 1px solid var(--border-color) !important;
			vertical-align: middle;
			background-color: var(--bg-primary) !important;
			transition: var(--transition-fast);
		}

		.data-table tr:last-child td {
			border-bottom: none !important;
		}

		.data-table tbody tr:hover td {
			background: var(--bg-secondary) !important;
			background-color: var(--bg-secondary) !important;
			color: var(--text-primary) !important;
		}

		/* ==========================================
           BADGES
        ========================================== */
		.badge {
			display: inline-flex;
			align-items: center;
			padding: 3px 10px;
			border-radius: 50px;
			font-size: 0.7rem;
			font-weight: 600;
		}

		.badge-primary {
			background: rgba(99, 102, 241, 0.15);
			color: var(--primary-light);
		}

		.badge-success {
			background: rgba(16, 185, 129, 0.15);
			color: var(--success);
		}

		.badge-warning {
			background: rgba(245, 158, 11, 0.15);
			color: var(--warning);
		}

		.badge-danger {
			background: rgba(239, 68, 68, 0.15);
			color: var(--danger);
		}

		.badge-info {
			background: rgba(59, 130, 246, 0.15);
			color: var(--info);
		}

		.badge-secondary {
			background: var(--bg-tertiary);
			color: var(--text-secondary);
		}

		/* ==========================================
           FORMS
        ========================================== */
		.form-group {
			margin-bottom: var(--sp-md);
		}

		.form-label {
			display: block;
			font-size: 0.8rem;
			font-weight: 500;
			color: var(--text-secondary);
			margin-bottom: 6px;
		}

		.form-control,
		.form-select {
			width: 100%;
			padding: 9px var(--sp-md);
			background: var(--bg-secondary);
			border: 1px solid var(--border-color);
			border-radius: var(--r-md);
			color: var(--text-primary);
			font-family: 'Poppins', sans-serif;
			font-size: 0.825rem;
			transition: var(--transition-fast);
		}

		.form-control:focus,
		.form-select:focus {
			outline: none;
			border-color: var(--primary);
			box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
		}

		.form-control::placeholder {
			color: var(--text-tertiary);
		}

		select.form-control {
			cursor: pointer;
		}

		textarea.form-control {
			resize: vertical;
			min-height: 90px;
		}

		/* ==========================================
           MODAL
        ========================================== */
		.modal-overlay {
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, 0.55);
			backdrop-filter: blur(4px);
			z-index: 2000;
			opacity: 0;
			visibility: hidden;
			transition: var(--transition-fast);
		}

		.modal-overlay.open {
			opacity: 1;
			visibility: visible;
		}

		.modal-box {
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -48%);
			background: var(--bg-primary);
			border: 1px solid var(--border-color);
			border-radius: var(--r-xl);
			box-shadow: 0 20px 60px var(--shadow-lg);
			width: 90%;
			max-width: 520px;
			max-height: 90vh;
			overflow-y: auto;
			z-index: 2001;
			opacity: 0;
			visibility: hidden;
			transition: var(--transition-fast);
		}

		.modal-box.open {
			opacity: 1;
			visibility: visible;
			transform: translate(-50%, -50%);
		}

		.modal-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: var(--sp-lg);
			border-bottom: 1px solid var(--border-color);
		}

		.modal-title {
			font-size: 1rem;
			font-weight: 600;
			color: var(--text-primary);
		}

		.modal-close-btn {
			background: var(--bg-secondary);
			border: none;
			width: 30px;
			height: 30px;
			border-radius: var(--r-sm);
			display: flex;
			align-items: center;
			justify-content: center;
			color: var(--text-tertiary);
			transition: var(--transition-fast);
		}

		.modal-close-btn:hover {
			background: var(--bg-tertiary);
			color: var(--text-primary);
		}

		.modal-close-btn svg {
			width: 15px;
			height: 15px;
		}

		.modal-body {
			padding: var(--sp-lg);
		}

		.modal-footer {
			display: flex;
			align-items: center;
			justify-content: flex-end;
			gap: var(--sp-sm);
			padding: var(--sp-md) var(--sp-lg);
			border-top: 1px solid var(--border-color);
		}

		/* ==========================================
           ENHANCED ALERTS — NEW & AWESOME
        ========================================== */
		.alert {
			display: flex;
			align-items: flex-start;
			gap: 14px;
			padding: 14px 18px;
			border-radius: var(--r-lg);
			font-size: 0.835rem;
			margin-bottom: var(--sp-md);
			position: relative;
			border: 1px solid transparent;
			overflow: hidden;
			animation: alertSlideIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
		}

		@keyframes alertSlideIn {
			from {
				opacity: 0;
				transform: translateY(-10px) scale(0.97);
			}

			to {
				opacity: 1;
				transform: translateY(0) scale(1);
			}
		}

		/* Glowing left bar via pseudo */
		.alert::before {
			content: '';
			position: absolute;
			left: 0;
			top: 0;
			bottom: 0;
			width: 4px;
			border-radius: 0 2px 2px 0;
		}

		/* Icon circle */
		.alert-icon {
			width: 34px;
			height: 34px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
		}

		.alert-icon i,
		.alert-icon svg {
			font-size: 17px;
			width: 17px;
			height: 17px;
		}

		.alert-body {
			flex: 1;
			min-width: 0;
		}

		.alert-title {
			font-size: 0.855rem;
			font-weight: 600;
			margin-bottom: 2px;
			line-height: 1.3;
		}

		.alert-message {
			font-size: 0.8rem;
			line-height: 1.5;
			opacity: 0.88;
		}

		/* Close button */
		.alert-close {
			background: transparent;
			border: none;
			padding: 2px;
			border-radius: 6px;
			cursor: pointer;
			flex-shrink: 0;
			opacity: 0.55;
			transition: opacity 0.15s ease;
			line-height: 1;
			align-self: flex-start;
		}

		.alert-close:hover {
			opacity: 1;
		}

		.alert-close i {
			font-size: 14px;
		}

		/* Progress bar at bottom */
		.alert-progress {
			position: absolute;
			bottom: 0;
			left: 0;
			height: 3px;
			border-radius: 0 0 var(--r-lg) var(--r-lg);
			animation: alertProgress 3.5s linear forwards;
			transform-origin: left;
		}

		@keyframes alertProgress {
			from {
				width: 100%;
			}

			to {
				width: 0%;
			}
		}

		/* — SUCCESS — */
		.alert-success {
			background: rgba(16, 185, 129, 0.07);
			border-color: rgba(16, 185, 129, 0.18);
			color: #065f46;
		}

		[data-theme="dark"] .alert-success {
			color: #6ee7b7;
		}

		.alert-success::before {
			background: var(--success);
		}

		.alert-success .alert-icon {
			background: rgba(16, 185, 129, 0.15);
			color: var(--success);
		}

		.alert-success .alert-progress {
			background: var(--success);
		}

		/* — DANGER — */
		.alert-danger {
			background: rgba(239, 68, 68, 0.07);
			border-color: rgba(239, 68, 68, 0.18);
			color: #7f1d1d;
		}

		[data-theme="dark"] .alert-danger {
			color: #fca5a5;
		}

		.alert-danger::before {
			background: var(--danger);
		}

		.alert-danger .alert-icon {
			background: rgba(239, 68, 68, 0.15);
			color: var(--danger);
		}

		.alert-danger .alert-progress {
			background: var(--danger);
		}

		/* — WARNING — */
		.alert-warning {
			background: rgba(245, 158, 11, 0.07);
			border-color: rgba(245, 158, 11, 0.18);
			color: #78350f;
		}

		[data-theme="dark"] .alert-warning {
			color: #fcd34d;
		}

		.alert-warning::before {
			background: var(--warning);
		}

		.alert-warning .alert-icon {
			background: rgba(245, 158, 11, 0.15);
			color: var(--warning);
		}

		.alert-warning .alert-progress {
			background: var(--warning);
		}

		/* — INFO — */
		.alert-info {
			background: rgba(59, 130, 246, 0.07);
			border-color: rgba(59, 130, 246, 0.18);
			color: #1e3a5f;
		}

		[data-theme="dark"] .alert-info {
			color: #93c5fd;
		}

		.alert-info::before {
			background: var(--info);
		}

		.alert-info .alert-icon {
			background: rgba(59, 130, 246, 0.15);
			color: var(--info);
		}

		.alert-info .alert-progress {
			background: var(--info);
		}

		/* — PRIMARY — */
		.alert-primary {
			background: rgba(99, 102, 241, 0.07);
			border-color: rgba(99, 102, 241, 0.18);
			color: #312e81;
		}

		[data-theme="dark"] .alert-primary {
			color: #a5b4fc;
		}

		.alert-primary::before {
			background: var(--primary);
		}

		.alert-primary .alert-icon {
			background: rgba(99, 102, 241, 0.15);
			color: var(--primary);
		}

		.alert-primary .alert-progress {
			background: var(--primary);
		}

		/* Legacy alert compatibility (border-warning.alert etc.) */
		.border-warning.alert {
			background: rgba(245, 158, 11, 0.07) !important;
			border-color: rgba(245, 158, 11, 0.18) !important;
			border-left: 4px solid var(--warning) !important;
			color: var(--warning) !important;
		}

		.border-primary.alert {
			background: rgba(99, 102, 241, 0.07) !important;
			border-color: rgba(99, 102, 241, 0.18) !important;
			border-left: 4px solid var(--primary) !important;
			color: var(--primary) !important;
		}

		.border-success.alert {
			background: rgba(16, 185, 129, 0.07) !important;
			border-color: rgba(16, 185, 129, 0.18) !important;
			border-left: 4px solid var(--success) !important;
			color: var(--success) !important;
		}

		.border-danger.alert {
			background: rgba(239, 68, 68, 0.07) !important;
			border-color: rgba(239, 68, 68, 0.18) !important;
			border-left: 4px solid var(--danger) !important;
			color: var(--danger) !important;
		}

		.border-info.alert {
			background: rgba(59, 130, 246, 0.07) !important;
			border-color: rgba(59, 130, 246, 0.18) !important;
			border-left: 4px solid var(--info) !important;
			color: var(--info) !important;
		}

		/* ==========================================
           SIDEBAR MOBILE OVERLAY
        ========================================== */
		.sidebar-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, 0.5);
			z-index: 999;
			opacity: 0;
			visibility: hidden;
			transition: var(--transition-fast);
		}

		.sidebar-overlay.open {
			opacity: 1;
			visibility: visible;
		}

		/* ==========================================
   SWEETALERT2 — THEME OVERRIDE
========================================== */

		/* Popup container */
		.swal2-popup {
			background: var(--bg-primary) !important;
			border: 1px solid var(--border-color) !important;
			border-radius: var(--r-xl) !important;
			box-shadow: 0 24px 64px var(--shadow-lg) !important;
			font-family: 'Poppins', sans-serif !important;
			padding: 2rem 1.75rem 1.75rem !important;
		}

		/* Title */
		.swal2-title {
			color: var(--text-primary) !important;
			font-size: 1.1rem !important;
			font-weight: 600 !important;
			padding: 0 !important;
			margin-bottom: 6px !important;
		}

		/* Body text */
		.swal2-html-container,
		.swal2-content {
			color: var(--text-secondary) !important;
			font-size: 0.845rem !important;
			line-height: 1.65 !important;
			margin: 0 !important;
			padding: 0 !important;
		}

		/* Backdrop */
		.swal2-backdrop-show,
		.swal2-container.swal2-backdrop-show {
			background: rgba(0, 0, 0, 0.55) !important;
			backdrop-filter: blur(4px) !important;
		}

		/* ---- Icon overrides ---- */
		.swal2-icon {
			border-width: 2px !important;
			width: 60px !important;
			height: 60px !important;
			margin: 0 auto 1.25rem !important;
		}

		.swal2-icon .swal2-icon-content {
			font-size: 2rem !important;
		}

		/* Success icon */
		.swal2-icon.swal2-success {
			border-color: rgba(16, 185, 129, 0.35) !important;
			color: var(--success) !important;
		}

		.swal2-icon.swal2-success .swal2-success-ring {
			border-color: rgba(16, 185, 129, 0.2) !important;
		}

		.swal2-icon.swal2-success [class^='swal2-success-line'] {
			background-color: var(--success) !important;
		}

		/* Error icon */
		.swal2-icon.swal2-error {
			border-color: rgba(239, 68, 68, 0.35) !important;
			color: var(--danger) !important;
		}

		.swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
			background-color: var(--danger) !important;
		}

		/* Warning icon */
		.swal2-icon.swal2-warning {
			border-color: rgba(245, 158, 11, 0.35) !important;
			color: var(--warning) !important;
		}

		/* Info icon */
		.swal2-icon.swal2-info {
			border-color: rgba(59, 130, 246, 0.35) !important;
			color: var(--info) !important;
		}

		/* Question icon */
		.swal2-icon.swal2-question {
			border-color: rgba(99, 102, 241, 0.35) !important;
			color: var(--primary) !important;
		}

		/* ---- Buttons ---- */
		.swal2-actions {
			margin-top: 1.5rem !important;
			gap: 10px !important;
		}

		/* Confirm button — matches your .btn-primary */
		.swal2-confirm {
			background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
			border: none !important;
			border-radius: var(--r-md) !important;
			font-family: 'Poppins', sans-serif !important;
			font-size: 0.835rem !important;
			font-weight: 500 !important;
			padding: 9px 22px !important;
			box-shadow: none !important;
			transition: opacity 0.15s ease, transform 0.12s ease !important;
		}

		.swal2-confirm:hover {
			opacity: 0.88 !important;
			transform: translateY(-1px) !important;
		}

		.swal2-confirm:active {
			transform: scale(0.98) !important;
		}

		.swal2-confirm:focus {
			box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
		}

		/* Deny button */
		.swal2-deny {
			background: var(--danger) !important;
			border: none !important;
			border-radius: var(--r-md) !important;
			font-family: 'Poppins', sans-serif !important;
			font-size: 0.835rem !important;
			font-weight: 500 !important;
			padding: 9px 22px !important;
			box-shadow: none !important;
		}

		.swal2-deny:focus {
			box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
		}

		/* Cancel button — matches your .btn-secondary */
		.swal2-cancel {
			background: var(--bg-tertiary) !important;
			color: var(--text-secondary) !important;
			border: 1px solid var(--border-color) !important;
			border-radius: var(--r-md) !important;
			font-family: 'Poppins', sans-serif !important;
			font-size: 0.835rem !important;
			font-weight: 500 !important;
			padding: 9px 22px !important;
			box-shadow: none !important;
		}

		.swal2-cancel:hover {
			background: var(--bg-secondary) !important;
			color: var(--text-primary) !important;
		}

		.swal2-cancel:focus {
			box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.08) !important;
		}

		/* ---- Input (when using input: 'text' etc.) ---- */
		.swal2-input,
		.swal2-textarea,
		.swal2-select {
			background: var(--bg-secondary) !important;
			border: 1px solid var(--border-color) !important;
			border-radius: var(--r-md) !important;
			color: var(--text-primary) !important;
			font-family: 'Poppins', sans-serif !important;
			font-size: 0.835rem !important;
			box-shadow: none !important;
		}

		.swal2-input:focus,
		.swal2-textarea:focus,
		.swal2-select:focus {
			border-color: var(--primary) !important;
			box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12) !important;
		}

		/* ---- Close button (top right X) ---- */
		.swal2-close {
			color: var(--text-tertiary) !important;
			font-size: 1.4rem !important;
			width: 32px !important;
			height: 32px !important;
			border-radius: var(--r-sm) !important;
			transition: background 0.15s, color 0.15s !important;
		}

		.swal2-close:hover {
			background: var(--bg-tertiary) !important;
			color: var(--text-primary) !important;
		}

		/* ---- Progress bar (timer) ---- */
		.swal2-timer-progress-bar {
			background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
			height: 3px !important;
		}

		.swal2-timer-progress-bar-container {
			border-radius: 0 0 var(--r-xl) var(--r-xl) !important;
			overflow: hidden !important;
		}

		/* ---- Loader spinner ---- */
		.swal2-loader {
			border-color: var(--primary) transparent var(--primary) transparent !important;
		}

		/* ---- Validation message ---- */
		.swal2-validation-message {
			background: rgba(239, 68, 68, 0.08) !important;
			color: var(--danger) !important;
			font-size: 0.8rem !important;
			border-radius: var(--r-sm) !important;
			border: 1px solid rgba(239, 68, 68, 0.18) !important;
			margin-top: 0.5rem !important;
		}

		.swal2-validation-message::before {
			background: var(--danger) !important;
		}

		/* ---- Confirm color variants via customClass ---- */
		/* Usage: customClass: { confirmButton: 'swal-btn-success' } */
		.swal-btn-success {
			background: var(--success) !important;
		}

		.swal-btn-success:focus {
			box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important;
		}

		.swal-btn-warning {
			background: var(--warning) !important;
		}

		.swal-btn-warning:focus {
			box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25) !important;
		}

		.swal-btn-danger {
			background: var(--danger) !important;
		}

		.swal-btn-danger:focus {
			box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
		}

		#bookingChart {
			height: 300px !important;
			max-height: 300px;
		}

		/* ==========================================
           RESPONSIVE
        ========================================== */
		@media (max-width: 992px) {
			.sidebar {
				transform: translateX(-100%);
				width: var(--sidebar-width) !important;
			}

			.sidebar.mobile-open {
				transform: translateX(0);
			}

			.main-content,
			.sidebar.collapsed~.main-content {
				margin-left: 0 !important;
			}

			html.sidebar-pre-collapsed .main-content {
				margin-left: 0 !important;
			}

			.mobile-sidebar-toggle {
				display: flex !important;
			}

			.sidebar-overlay {
				display: block;
			}
		}

		@media (max-width: 768px) {
			.topbar {
				padding: 0 var(--sp-md);
			}

			.page-content {
				padding: var(--sp-md);
			}

			.user-name {
				display: none !important;
			}

			.stats-grid {
				grid-template-columns: 1fr 1fr;
			}
		}

		@media (max-width: 480px) {
			.stats-grid {
				grid-template-columns: 1fr;
			}
		}

		/* ==========================================
           UTILITIES
        ========================================== */
		.text-primary-clr {
			color: var(--primary);
		}

		.text-success {
			color: var(--success);
		}

		.text-danger {
			color: var(--danger);
		}

		.text-warning {
			color: var(--warning);
		}

		.text-muted {
			color: var(--text-tertiary);
		}

		.bg-gradient-primary {
			background: linear-gradient(135deg, var(--primary), var(--secondary));
		}

		.bg-gradient-success {
			background: linear-gradient(135deg, #10B981, #059669);
		}

		.bg-gradient-warning {
			background: linear-gradient(135deg, #F59E0B, #D97706);
		}

		.bg-gradient-danger {
			background: linear-gradient(135deg, #EF4444, #DC2626);
		}

		.bg-gradient-info {
			background: linear-gradient(135deg, #3B82F6, #2563EB);
		}

		.d-flex {
			display: flex;
		}

		.align-center {
			align-items: center;
		}

		.justify-between {
			justify-content: space-between;
		}

		.gap-sm {
			gap: var(--sp-sm);
		}

		.gap-md {
			gap: var(--sp-md);
		}

		.mt-md {
			margin-top: var(--sp-md);
		}

		.mb-md {
			margin-bottom: var(--sp-md);
		}

		.w-100 {
			width: 100%;
		}

		/* Bootstrap-style utilities */
		.d-flex {
			display: flex !important;
		}

		.flex-column {
			flex-direction: column !important;
		}

		.justify-content-between {
			justify-content: space-between !important;
		}

		.justify-content-center {
			justify-content: center !important;
		}

		.align-items-center {
			align-items: center !important;
		}

		.gap-3 {
			gap: 1rem !important;
		}

		.ms-auto {
			margin-left: auto !important;
		}

		.me-auto {
			margin-right: auto !important;
		}

		.mt-2 {
			margin-top: 0.5rem !important;
		}

		.mt-3 {
			margin-top: 1rem !important;
		}

		.mb-0 {
			margin-bottom: 0 !important;
		}

		.mb-1 {
			margin-bottom: 0.25rem !important;
		}

		.mb-2 {
			margin-bottom: 0.5rem !important;
		}

		.mb-3 {
			margin-bottom: 1rem !important;
		}

		.mb-4 {
			margin-bottom: 1.5rem !important;
		}

		.pb-2 {
			padding-bottom: 0.5rem !important;
		}

		.py-2 {
			padding-top: 0.5rem !important;
			padding-bottom: 0.5rem !important;
		}

		.px-4 {
			padding-left: 1.5rem !important;
			padding-right: 1.5rem !important;
		}

		.fw-semibold {
			font-weight: 600 !important;
		}

		.h-100 {
			height: 100% !important;
		}

		.position-relative {
			position: relative !important;
		}

		.position-absolute {
			position: absolute !important;
		}

		.top-50 {
			top: 50% !important;
		}

		.translate-middle-y {
			transform: translateY(-50%) !important;
		}

		.img-fluid {
			max-width: 100%;
			height: auto;
		}

		.rounded {
			border-radius: var(--r-sm) !important;
		}

		.rounded-circle {
			border-radius: 50% !important;
		}

		.text-center {
			text-align: center !important;
		}

		.text-white {
			color: #fff !important;
		}

		.text-dark {
			color: #000 !important;
		}

		.text-muted {
			color: var(--text-tertiary) !important;
		}

		.d-grid {
			display: grid !important;
		}

		.text-primary {
			color: var(--primary) !important;
		}

		.text-secondary {
			color: var(--text-secondary) !important;
		}

		.text-success {
			color: var(--success) !important;
		}

		.text-danger {
			color: var(--danger) !important;
		}

		.text-warning {
			color: var(--warning) !important;
		}

		.text-info {
			color: var(--info) !important;
		}

		/* Table compatibility */
		.table-responsive {
			overflow-x: auto;
			border-radius: var(--r-lg);
			background: var(--bg-primary);
		}

		.table {
			width: 100%;
			border-collapse: collapse;
			background-color: var(--bg-primary) !important;
			color: var(--text-primary) !important;
			--bs-table-bg: var(--bg-primary) !important;
			--bs-table-color: var(--text-primary) !important;
			--bs-table-border-color: var(--border-color) !important;
			--bs-table-striped-bg: var(--bg-secondary) !important;
			--bs-table-hover-bg: var(--bg-secondary) !important;
			border-color: var(--border-color) !important;
		}

		.table th {
			padding: 14px var(--sp-md);
			text-align: left;
			font-size: 0.75rem;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.05em;
			color: var(--text-tertiary) !important;
			background: var(--bg-secondary) !important;
			background-color: var(--bg-secondary) !important;
			border-bottom: 1px solid var(--border-color) !important;
			white-space: nowrap;
		}

		.table td {
			padding: 14px var(--sp-md);
			font-size: 0.825rem;
			color: var(--text-secondary) !important;
			border-bottom: 1px solid var(--border-color) !important;
			vertical-align: middle;
			background-color: var(--bg-primary) !important;
			transition: var(--transition-fast);
		}

		.table tr:last-child td {
			border-bottom: none !important;
		}

		.table tbody tr:hover td {
			background: var(--bg-secondary) !important;
			background-color: var(--bg-secondary) !important;
			color: var(--text-primary) !important;
		}

		.table-light,
		.table-light th {
			--bs-table-bg: var(--bg-secondary) !important;
			--bs-table-color: var(--text-tertiary) !important;
			background-color: var(--bg-secondary) !important;
			color: var(--text-tertiary) !important;
		}

		/* Pagination */
		.pagination {
			display: flex;
			padding-left: 0;
			list-style: none;
			gap: 6px;
			margin-top: var(--sp-lg);
			margin-bottom: var(--sp-md);
			justify-content: center;
		}

		.page-item {
			display: inline;
		}

		.page-link {
			display: flex;
			align-items: center;
			justify-content: center;
			min-width: 36px;
			height: 36px;
			padding: 0 12px;
			border-radius: var(--r-sm);
			background: var(--bg-secondary);
			border: 1px solid var(--border-color);
			color: var(--text-secondary);
			font-size: 0.825rem;
			font-weight: 500;
			text-decoration: none;
			transition: var(--transition-fast);
		}

		.page-link:hover {
			background: var(--bg-tertiary);
			color: var(--text-primary);
			border-color: var(--text-tertiary);
		}

		.page-item.active .page-link {
			background: linear-gradient(135deg, var(--primary), var(--secondary));
			color: #fff;
			border-color: transparent;
		}

		.page-item.disabled .page-link {
			opacity: 0.4;
			pointer-events: none;
		}

		/* Card modifiers */
		.radius-10 {
			border-radius: 10px !important;
		}

		.border-start {
			border-left-style: solid !important;
		}

		.border-0 {
			border-top-width: 0 !important;
			border-right-width: 0 !important;
			border-bottom-width: 0 !important;
		}

		.border-4 {
			border-left-width: 4px !important;
		}

		.border-5 {
			border-left-width: 5px !important;
		}

		.border-primary {
			border-color: var(--primary) !important;
		}

		.border-success {
			border-color: var(--success) !important;
		}

		.border-warning {
			border-color: var(--warning) !important;
		}

		.border-danger {
			border-color: var(--danger) !important;
		}

		.widgets-icons-2 {
			width: 48px;
			height: 48px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 22px;
			flex-shrink: 0;
			box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
		}

		.bg-gradient-cosmic {
			background: linear-gradient(135deg, #8e2de2, #4a00e0) !important;
		}

		.bg-gradient-burning {
			background: linear-gradient(135deg, #ff416c, #ff4b2b) !important;
		}

		.bg-gradient-ohhappiness {
			background: linear-gradient(135deg, #00b09b, #96c93d) !important;
		}

		.bg-gradient-bloody {
			background: linear-gradient(135deg, #f857a6, #ff5858) !important;
		}

		.text-warning {
			color: var(--warning) !important;
		}

		.text-success {
			color: var(--success) !important;
		}

		.text-danger {
			color: var(--danger) !important;
		}

		.text-primary {
			color: var(--primary) !important;
		}

		.text-info {
			color: var(--info) !important;
		}

		.font-35 {
			font-size: 28px !important;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.ms-3 {
			margin-left: 1rem !important;
		}

		/* ==========================================
           SWEETALERT2 SUCCESS ICON FIX
        ========================================== */
		.swal2-icon.swal2-success .swal2-success-line-tip,
		.swal2-icon.swal2-success .swal2-success-line-long {
			font-size: 16px !important;
		}

		.swal2-icon.swal2-success [class^=swal2-success-line] {
			box-sizing: content-box !important;
		}

		.swal2-icon.swal2-success::before,
		.swal2-icon.swal2-success::after,
		.swal2-success-fix {
			box-sizing: content-box !important;
		}
	</style>
</head>

<body>

	<div class="sidebar-overlay" id="sidebarOverlay"></div>

	<div class="admin-wrapper">

		<!-- ===========================
             SIDEBAR
        ============================ -->
		<aside class="sidebar" id="sidebar">

			<div class="sidebar-header">
				<div class="logo">
					<!-- Full logo (expanded state) -->
					<img
						src="<?= base_url('assets/images/logo_ficat.png') ?>"
						alt="Logo"
						class="logo-img-full"
						onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
					<!-- Fallback icon -->
					<div class="logo-icon-fallback" style="display:none;">
						<i class="bx bx-bolt"></i>
					</div>
				</div>
				<button class="sidebar-toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
					<i class="bx bx-menu" id="sidebarToggleIcon"></i>
				</button>
			</div>

			<nav class="sidebar-nav">

				<div class="nav-section-label">Main</div>

				<div class="nav-item <?= (uri_string() == 'provider/dashboard') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('provider/dashboard') ?>" data-tooltip="Dashboard">
						<i class="bx bx-grid-alt"></i>
						<span class="nav-link-text">Dashboard</span>
					</a>
				</div>

				<div class="nav-item <?= (uri_string() == 'provider/wallet') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('provider/wallet') ?>" data-tooltip="Wallet">
						<i class="bx bx-wallet"></i>
						<span class="nav-link-text">Wallet</span>
					</a>
				</div>

				<div class="nav-section-label">Management</div>

				<div class="nav-item has-submenu <?= in_array(uri_string(), ['service', 'add_service']) ? 'open active' : '' ?>">
					<div class="nav-link" data-tooltip="Service">
						<i class="bx bx-cog"></i>
						<span class="nav-link-text">Service</span>
						<i class="bx bx-chevron-down submenu-chevron"></i>
					</div>
					<div class="submenu">
						<a class="submenu-link <?= (uri_string() == 'service') ? 'active' : '' ?>" href="<?= base_url('service') ?>">
							<i class="bx bx-list-ul"></i> All Services
						</a>
						<a class="submenu-link <?= (uri_string() == 'add_service') ? 'active' : '' ?>" href="<?= base_url('add_service') ?>">
							<i class="bx bx-plus-circle"></i> Add Service
						</a>
					</div>
				</div>

				<div class="nav-item has-submenu <?= in_array(uri_string(), ['image', 'add_image']) ? 'open active' : '' ?>">
					<div class="nav-link" data-tooltip="Gallery">
						<i class="bx bx-image"></i>
						<span class="nav-link-text">Gym Gallery</span>
						<i class="bx bx-chevron-down submenu-chevron"></i>
					</div>
					<div class="submenu">
						<a class="submenu-link <?= (uri_string() == 'image') ? 'active' : '' ?>" href="<?= base_url('image') ?>">
							<i class="bx bx-images"></i> All Images
						</a>
						<a class="submenu-link <?= (uri_string() == 'add_image') ? 'active' : '' ?>" href="<?= base_url('add_image') ?>">
							<i class="bx bx-image-add"></i> Add Image
						</a>
					</div>
				</div>

				<div class="nav-item <?= (uri_string() == 'customer') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('customer') ?>" data-tooltip="Customers">
						<i class="bx bx-user"></i>
						<span class="nav-link-text">Customers</span>
					</a>
				</div>

				<div class="nav-item has-submenu <?= in_array(uri_string(), ['booking']) ? 'open active' : '' ?>">
					<div class="nav-link" data-tooltip="Bookings">
						<i class="bx bx-calendar-check"></i>
						<span class="nav-link-text">Bookings</span>
						<i class="bx bx-chevron-down submenu-chevron"></i>
					</div>
					<div class="submenu">
						<a class="submenu-link <?= (uri_string() == 'booking') ? 'active' : '' ?>" href="<?= base_url('booking') ?>">
							<i class="bx bx-calendar"></i> All Bookings
						</a>
					</div>
				</div>

				<div class="nav-section-label">Other</div>

				<div class="nav-item <?= (uri_string() == 'provider/live_session') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('provider/live_session') ?>" data-tooltip="Live Session">
						<i class="bx bx-video"></i>
						<span class="nav-link-text">Live Session</span>
					</a>
				</div>

				<div class="nav-item <?= (uri_string() == 'scheduled') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('scheduled') ?>" data-tooltip="Schedule">
						<i class="bx bx-time-five"></i>
						<span class="nav-link-text">Schedule</span>
					</a>
				</div>

				<div class="nav-item <?= (uri_string() == 'offers') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('offers') ?>" data-tooltip="Offers">
						<i class="bx bx-tag"></i>
						<span class="nav-link-text">Offers</span>
					</a>
				</div>

				<div class="nav-item <?= (uri_string() == 'certification') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('certification') ?>" data-tooltip="Certificate">
						<i class="bx bx-award"></i>
						<span class="nav-link-text">Certificate</span>
					</a>
				</div>

				<div class="nav-item <?= (uri_string() == 'bank_details') ? 'active' : '' ?>">
					<a class="nav-link" href="<?= base_url('bank_details') ?>" data-tooltip="Bank Details">
						<i class="bx bx-bank"></i>
						<span class="nav-link-text">Bank Details</span>
					</a>
				</div>

			</nav>

		</aside>
		<!-- END SIDEBAR -->

		<!-- ===========================
             MAIN CONTENT
        ============================ -->
		<div class="main-content" id="mainContent">

			<!-- TOPBAR -->
			<header class="topbar">
				<div class="topbar-left">
					<!-- Mobile hamburger -->
					<button class="mobile-sidebar-toggle icon-btn" id="mobileSidebarToggle">
						<i class="bx bx-menu"></i>
					</button>

					<?php if ($this->session->userdata('admin_as_partner')): ?>
						<div class="impersonation-bar">
							<i class="bx bx-error-circle"></i>
							<a href="<?= base_url('admin/partner/backToAdmin') ?>">
								<i class="bx bx-arrow-back"></i> Back to Admin
							</a>
							<span>Viewing as partner</span>
						</div>
					<?php endif; ?>
				</div>

				<div class="topbar-right">

					<!-- Theme Toggle -->
					<button class="icon-btn" id="themeToggle" title="Toggle Theme">
						<i class="bx bx-sun" id="themeIcon"></i>
					</button>

					<!-- User Menu -->
					<div class="user-menu-wrapper">
						<button class="user-menu-btn" id="userMenuBtn">
							<!-- Avatar with fallback -->
							<img
								src="<?= $this->provider_image ?>"
								alt="User"
								class="user-avatar"
								onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
							<div class="user-avatar-fallback" style="display:none;">
								<?= strtoupper(substr($this->provider['gym_name'] ?? 'U', 0, 1)) ?>
							</div>
							<span class="user-name"><?= $this->provider['gym_name'] ?? 'User' ?></span>
							<i class="bx bx-chevron-down chevron-icon"></i>
						</button>

						<div class="topbar-dropdown" id="userDropdown">
							<div class="dropdown-header">
								<p><?= $this->provider['gym_name'] ?? 'Gym Name' ?></p>
								<p><?= $this->provider['name'] ?? 'Owner' ?></p>
							</div>
							<a class="dropdown-item" href="<?= base_url('provider/profile') ?>">
								<i class="bx bx-user"></i> Profile
							</a>
							<a class="dropdown-item" href="<?= base_url('provider/wallet') ?>">
								<i class="bx bx-wallet"></i> Wallet
							</a>
							<hr class="dropdown-divider">
							<a class="dropdown-item danger" href="<?= base_url('provider/logout') ?>">
								<i class="bx bx-log-out"></i> Logout
							</a>
						</div>
					</div>

				</div>
			</header>
			<!-- END TOPBAR -->

			<!-- PAGE CONTENT -->
			<div class="page-content">