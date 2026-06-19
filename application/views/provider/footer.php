</div>
<!-- END PAGE CONTENT -->

</div>
<!-- END MAIN CONTENT -->

</div>
<!-- END ADMIN WRAPPER -->

<!-- ===========================
	     SCRIPTS
	============================ -->
<!-- Core JS Dependencies -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Plugins JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="<?= base_url('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Global Site Variables -->
<script>
  const site_url = "<?= base_url(); ?>";
  const BASE_URL = "<?= base_url(); ?>";
  const GET_BOOKINGS_URL = "<?= base_url('provider/customers/get_bookings_ajax'); ?>";
</script>

<style>
  .swal2-popup {
    background: var(--bg-primary) !important;
    border: 1px solid var(--border-color) !important;
    border-radius: var(--r-xl) !important;
    box-shadow: 0 24px 64px var(--shadow-lg) !important;
    font-family: 'Poppins', sans-serif !important;
    padding: 2rem 1.75rem 1.75rem !important
  }

  .swal2-title {
    color: var(--text-primary) !important;
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    padding: 0 !important;
    margin-bottom: 6px !important
  }

  .swal2-html-container,
  .swal2-content {
    color: var(--text-secondary) !important;
    font-size: 0.845rem !important;
    line-height: 1.65 !important;
    margin: 0 !important;
    padding: 0 !important
  }

  .swal2-backdrop-show,
  .swal2-container.swal2-backdrop-show {
    background: rgba(0, 0, 0, 0.55) !important;
    backdrop-filter: blur(4px) !important
  }

  .swal2-icon {
    border-width: 2px !important;
    width: 60px !important;
    height: 60px !important;
    margin: 0 auto 1.25rem !important
  }

  .swal2-icon .swal2-icon-content {
    font-size: 2rem !important
  }

  .swal2-icon.swal2-success {
    border-color: rgba(16, 185, 129, 0.35) !important;
  }

  .swal2-icon.swal2-success .swal2-success-ring {
    border-color: rgba(16, 185, 129, 0.2) !important
  }

  .swal2-icon.swal2-success [class^='swal2-success-line'] {
    background-color: var(--success) !important
  }

  .swal2-icon.swal2-error {
    border-color: rgba(239, 68, 68, 0.35) !important;
  }

  .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {
    background-color: var(--danger) !important
  }

  .swal2-icon.swal2-warning {
    border-color: rgba(245, 158, 11, 0.35) !important;
  }

  .swal2-icon.swal2-info {
    border-color: rgba(59, 130, 246, 0.35) !important;
  }

  .swal2-icon.swal2-question {
    border-color: rgba(99, 102, 241, 0.35) !important;
  }

  .swal2-actions {
    margin-top: 1.5rem !important;
    gap: 10px !important
  }

  .swal2-confirm {
    background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
    border: none !important;
    border-radius: var(--r-md) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.835rem !important;
    font-weight: 500 !important;
    padding: 9px 22px !important;
    box-shadow: none !important;
    transition: opacity 0.15s ease, transform 0.12s ease !important
  }

  .swal2-confirm:hover {
    opacity: 0.88 !important;
    transform: translateY(-1px) !important
  }

  .swal2-confirm:active {
    transform: scale(0.98) !important
  }

  .swal2-confirm:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important
  }

  .swal2-deny {
    background: var(--danger) !important;
    border: none !important;
    border-radius: var(--r-md) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.835rem !important;
    font-weight: 500 !important;
    padding: 9px 22px !important;
    box-shadow: none !important
  }

  .swal2-deny:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important
  }

  .swal2-cancel {
    background: var(--bg-tertiary) !important;
    color: var(--text-secondary) !important;
    border: 1px solid var(--border-color) !important;
    border-radius: var(--r-md) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.835rem !important;
    font-weight: 500 !important;
    padding: 9px 22px !important;
    box-shadow: none !important
  }

  .swal2-cancel:hover {
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important
  }

  .swal2-cancel:focus {
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.08) !important
  }

  .swal2-input,
  .swal2-textarea,
  .swal2-select {
    background: var(--bg-secondary) !important;
    border: 1px solid var(--border-color) !important;
    border-radius: var(--r-md) !important;
    color: var(--text-primary) !important;
    font-family: 'Poppins', sans-serif !important;
    font-size: 0.835rem !important;
    box-shadow: none !important
  }

  .swal2-input:focus,
  .swal2-textarea:focus,
  .swal2-select:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12) !important
  }

  .swal2-close {
    color: var(--text-tertiary) !important;
    font-size: 1.4rem !important;
    width: 32px !important;
    height: 32px !important;
    border-radius: var(--r-sm) !important;
    transition: background 0.15s, color 0.15s !important
  }

  .swal2-close:hover {
    background: var(--bg-tertiary) !important;
    color: var(--text-primary) !important
  }

  .swal2-timer-progress-bar {
    background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
    height: 3px !important
  }

  .swal2-timer-progress-bar-container {
    border-radius: 0 0 var(--r-xl) var(--r-xl) !important;
    overflow: hidden !important
  }

  .swal2-loader {
    border-color: var(--primary) transparent var(--primary) transparent !important
  }

  .swal2-validation-message {
    background: rgba(239, 68, 68, 0.08) !important;
    color: var(--danger) !important;
    font-size: 0.8rem !important;
    border-radius: var(--r-sm) !important;
    border: 1px solid rgba(239, 68, 68, 0.18) !important;
    margin-top: 0.5rem !important
  }

  .swal2-validation-message::before {
    background: var(--danger) !important
  }

  .swal-btn-success {
    background: var(--success) !important
  }

  .swal-btn-success:focus {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important
  }

  .swal-btn-warning {
    background: var(--warning) !important
  }

  .swal-btn-warning:focus {
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.25) !important
  }

  .swal-btn-danger {
    background: var(--danger) !important
  }

  .swal-btn-danger:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important
  }
</style>

<!-- Custom App Logic JS -->
<script src="<?= base_url('assets/js/provider/custom.js') ?>?v=<?= time() ?>"></script>

<script>
  // ==========================================
  // THEME TOGGLE
  // ==========================================
  const html = document.documentElement;
  const themeBtn = document.getElementById('themeToggle');
  const themeIcon = document.getElementById('themeIcon');

  function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    localStorage.setItem('admin_theme', theme);
    if (themeIcon) {
      themeIcon.className = theme === 'dark' ? 'bx bx-sun' : 'bx bx-moon';
    }
  }

  // Sync icon on load (theme already applied via head script)
  (function() {
    var saved = localStorage.getItem('admin_theme') || 'dark';
    if (themeIcon) {
      themeIcon.className = saved === 'dark' ? 'bx bx-sun' : 'bx bx-moon';
    }
  })();

  if (themeBtn) {
    themeBtn.addEventListener('click', function() {
      applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });
  }

  // ==========================================
  // SIDEBAR COLLAPSE (desktop)
  // FIX: Apply state immediately on load,
  //      remove the pre-collapse html class after JS takes over
  // ==========================================
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const toggleIcon = document.getElementById('sidebarToggleIcon');

  var isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';

  function setSidebarState(collapsed, animate) {
    // When animate=false we skip adding the class that triggers CSS transition
    // (used on initial load so there's no sliding animation on refresh)
    if (!animate) {
      sidebar.style.transition = 'none';
      document.getElementById('mainContent').style.transition = 'none';
    }

    if (collapsed) {
      sidebar.classList.add('collapsed');
      if (toggleIcon) toggleIcon.className = 'bx bx-menu-alt-right';
    } else {
      sidebar.classList.remove('collapsed');
      if (toggleIcon) toggleIcon.className = 'bx bx-menu';
    }

    localStorage.setItem('sidebar_collapsed', collapsed);

    // Re-enable transitions after the immediate paint
    if (!animate) {
      requestAnimationFrame(function() {
        requestAnimationFrame(function() {
          sidebar.style.transition = '';
          document.getElementById('mainContent').style.transition = '';
        });
      });
    }
  }

  // Apply state on load — no animation so no flash
  setSidebarState(isCollapsed, false);

  // Remove the pre-collapse CSS class now that JS has taken over
  html.classList.remove('sidebar-pre-collapsed');

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function() {
      isCollapsed = !sidebar.classList.contains('collapsed');
      setSidebarState(isCollapsed, true); // animate on user click
    });
  }

  // ==========================================
  // MOBILE SIDEBAR
  // ==========================================
  const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  function checkMobile() {
    if (window.innerWidth <= 992) {
      if (mobileSidebarToggle) mobileSidebarToggle.style.display = 'flex';
    } else {
      if (mobileSidebarToggle) mobileSidebarToggle.style.display = 'none';
      sidebar.classList.remove('mobile-open');
      if (sidebarOverlay) sidebarOverlay.classList.remove('open');
    }
  }

  checkMobile();
  window.addEventListener('resize', checkMobile);

  if (mobileSidebarToggle) {
    mobileSidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('mobile-open');
      if (sidebarOverlay) sidebarOverlay.classList.toggle('open');
    });
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', function() {
      sidebar.classList.remove('mobile-open');
      sidebarOverlay.classList.remove('open');
    });
  }

  // ==========================================
  // SUBMENU ACCORDION
  // ==========================================
  document.querySelectorAll('.nav-item.has-submenu > .nav-link').forEach(function(link) {
    link.addEventListener('click', function() {
      var parent = this.closest('.nav-item');
      var wasOpen = parent.classList.contains('open');
      document.querySelectorAll('.nav-item.has-submenu.open').forEach(function(el) {
        el.classList.remove('open');
      });
      if (!wasOpen) parent.classList.add('open');
    });
  });

  // ==========================================
  // TOPBAR DROPDOWNS
  // ==========================================
  function closeAllDropdowns() {
    document.querySelectorAll('.topbar-dropdown.open').forEach(function(d) {
      d.classList.remove('open');
    });
    // Also remove open class from button
    document.querySelectorAll('.user-menu-btn.open').forEach(function(b) {
      b.classList.remove('open');
    });
  }

  var userMenuBtn = document.getElementById('userMenuBtn');
  var userDropdown = document.getElementById('userDropdown');

  if (userMenuBtn && userDropdown) {
    userMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      var wasOpen = userDropdown.classList.contains('open');
      closeAllDropdowns();
      if (!wasOpen) {
        userDropdown.classList.add('open');
        userMenuBtn.classList.add('open');
      }
    });
  }

  document.addEventListener('click', closeAllDropdowns);

  document.querySelectorAll('.topbar-dropdown').forEach(function(dd) {
    dd.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });

  // ==========================================
  // ENHANCED ALERT AUTO-DISMISS
  // Auto-dismiss with smooth fade + collapse
  // ==========================================
  function dismissAlert(alert) {
    alert.style.transition = 'opacity 0.4s ease, max-height 0.35s ease, margin 0.35s ease, padding 0.35s ease, border-width 0.35s ease';
    alert.style.opacity = '0';
    alert.style.maxHeight = alert.offsetHeight + 'px';

    requestAnimationFrame(function() {
      requestAnimationFrame(function() {
        alert.style.maxHeight = '0';
        alert.style.padding = '0';
        alert.style.marginBottom = '0';
        alert.style.borderWidth = '0';
        alert.style.overflow = 'hidden';
      });
    });

    setTimeout(function() {
      alert.remove();
    }, 450);
  }

  // Wire up manual close buttons
  document.querySelectorAll('.alert-close').forEach(function(btn) {
    btn.addEventListener('click', function() {
      dismissAlert(this.closest('.alert'));
    });
  });

  // Auto-dismiss after 3.5s
  document.querySelectorAll('.alert').forEach(function(alert) {
    setTimeout(function() {
      dismissAlert(alert);
    }, 3500);
  });

  // ==========================================
  // DASHBOARD CHART
  // ==========================================
  const chartElement = document.getElementById('bookingChart');
  if (chartElement) {
    const ctx = chartElement.getContext('2d');
    const bookingChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Bookings',
          data: <?= json_encode($bookings_by_month ?? array_fill(0, 12, 0)) ?>,
          backgroundColor: 'rgba(99, 102, 241, 0.65)',
          borderColor: 'rgba(99, 102, 241, 1)',
          borderWidth: 1.5,
          borderRadius: 6,
          hoverBackgroundColor: 'rgba(139, 92, 246, 0.85)',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `Bookings: ${context.parsed.y}`;
              }
            }
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5
            }
          }
        }
      }
    });
  }

  // Boxicons are CSS-based, no re-init needed
  window.reinitIcons = function() {};

  // ==========================================
  // HELPER: Show toast-style alert from JS
  // Usage: showAlert('success', 'Saved!', 'Record has been saved.');
  // ==========================================
  window.showAlert = function(type, title, message) {
    var icons = {
      success: 'bx bx-check-circle',
      danger: 'bx bx-x-circle',
      warning: 'bx bx-error',
      info: 'bx bx-info-circle',
      primary: 'bx bx-bell',
    };

    var el = document.createElement('div');
    el.className = 'alert alert-' + type;
    el.style.maxHeight = '200px';
    el.innerHTML = `
				<div class="alert-icon">
					<i class="${icons[type] || 'bx bx-info-circle'}"></i>
				</div>
				<div class="alert-body">
					<div class="alert-title">${title}</div>
					${message ? `<div class="alert-message">${message}</div>` : ''}
				</div>
				<button class="alert-close" onclick="this.closest('.alert') && dismissAlert(this.closest('.alert'))">
					<i class="bx bx-x"></i>
				</button>
				<div class="alert-progress"></div>
			`;

    // Insert at top of page-content
    var pc = document.querySelector('.page-content');
    if (pc) pc.insertBefore(el, pc.firstChild);

    // Wire dismiss
    el.querySelector('.alert-close').addEventListener('click', function() {
      dismissAlert(el);
    });

    setTimeout(function() {
      dismissAlert(el);
    }, 3500);
  };
</script>

</body>

</html>