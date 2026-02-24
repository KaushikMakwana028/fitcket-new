<style>
  .page-content {
    padding: 25px;
    background: #f4f6f9;
  }

  .card {
    border: none;
    border-radius: 18px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    transition: all 0.25s ease;
  }

  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 26px rgba(0, 0, 0, 0.08);
  }

  .dashboard-card {
    padding: 22px;
    border-radius: 18px;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .dashboard-card p {
    font-size: 13px;
    opacity: 0.92;
    margin-bottom: 6px;
  }

  .dashboard-card h4,
  .dashboard-card h3 {
    font-weight: 700;
    margin-bottom: 0;
  }

  .widgets-icons {
    width: 55px;
    height: 55px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    background: rgba(255, 255, 255, 0.2);
  }

  .bg-gradient-success {
    background: linear-gradient(135deg, #00c853, #009624);
  }

  .bg-gradient-info {
    background: linear-gradient(135deg, #00bcd4, #00838f);
  }

  .bg-gradient-danger {
    background: linear-gradient(135deg, #ff5252, #c62828);
  }

  .bg-gradient-warning {
    background: linear-gradient(135deg, #ffb300, #ff6f00);
  }

  .bg-gradient-primary {
    background: linear-gradient(135deg, #2979ff, #1565c0);
  }

  .rating-stars {
    display: inline-flex;
    align-items: center;
    gap: 1px;
    white-space: nowrap;
    line-height: 1;
  }

  .qr-card img {
    border-radius: 14px;
    padding: 10px;
    background: #f9fbff;
    border: 1px solid #edf1f7;
  }

  .payment-box {
    border-radius: 16px;
    padding: 20px;
    background: #f9fbff;
    border: 1px solid #edf1f7;
    transition: 0.2s ease;
  }

  .payment-box:hover {
    background: #eef3ff;
  }

  .dashboard-section-title {
    font-weight: 700;
    color: #1f2d3d;
  }

  .notifications-card .card-body {
    padding: 22px;
  }

  .notification-list {
    max-height: 420px;
    overflow-y: auto;
    padding-right: 4px;
  }

  .notification-item {
    border-radius: 14px;
    padding: 14px;
    border: 1px solid #edf0f5;
    margin-bottom: 12px;
    transition: 0.2s ease;
    background: #fff;
  }

  .notification-item:hover {
    background: #f9fbff;
  }

  .notification-item.unread {
    background: #eef5ff;
    border-left: 4px solid #2979ff;
  }

  .notification-title {
    font-weight: 600;
    margin-bottom: 4px;
    color: #1f2937;
  }

  .notification-message {
    font-size: 13px;
    color: #64748b;
  }

  .notification-time {
    font-size: 12px;
    color: #94a3b8;
  }

  .notification-empty {
    padding: 30px;
    text-align: center;
    color: #8c96a3;
    border: 1px dashed #d6dee8;
    border-radius: 14px;
  }

  .notification-delete-btn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
  }

  [data-bs-theme="dark"] .page-content {
    background: #111827;
  }

  [data-bs-theme="dark"] .card {
    background: #0f172a;
    border: 1px solid #263244;
    box-shadow: none;
  }

  [data-bs-theme="dark"] .dashboard-section-title,
  [data-bs-theme="dark"] h5,
  [data-bs-theme="dark"] h6,
  [data-bs-theme="dark"] h4,
  [data-bs-theme="dark"] h3 {
    color: #e2e8f0;
  }

  [data-bs-theme="dark"] .text-muted {
    color: #9fb0c7 !important;
  }

  [data-bs-theme="dark"] .qr-card img,
  [data-bs-theme="dark"] .payment-box {
    background: #111827;
    border-color: #334155;
  }

  [data-bs-theme="dark"] .notification-item {
    background: #0b1220;
    border-color: #334155;
  }

  [data-bs-theme="dark"] .notification-item.unread {
    background: #1e293b;
    border-left-color: #3b82f6;
  }

  [data-bs-theme="dark"] .notification-item:hover {
    background: #182235;
  }

  [data-bs-theme="dark"] .notification-title {
    color: #e2e8f0;
  }

  [data-bs-theme="dark"] .notification-message {
    color: #94a3b8;
  }

  [data-bs-theme="dark"] .notification-time,
  [data-bs-theme="dark"] .notification-empty {
    color: #9fb0c7;
  }
</style>

<div class="page-wrapper">
  <div class="page-content">
    <div class="row g-4 mb-4">
      <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="dashboard-card bg-gradient-success h-100">
          <div>
            <p>Total Customers</p>
            <h4><?= (int) ($total_customers ?? 0) ?></h4>
          </div>
          <div class="widgets-icons">
            <i class="bx bxs-user-account"></i>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="dashboard-card bg-gradient-info h-100">
          <div>
            <p>Total Services</p>
            <h4><?= (int) ($total_service ?? 0) ?></h4>
          </div>
          <div class="widgets-icons">
            <i class="bx bxs-id-card"></i>
          </div>
        </div>
      </div>

      <div class="col-xl-2 col-lg-4 col-md-6">
        <div class="dashboard-card bg-gradient-danger h-100">
          <div>
            <p>Total Booking</p>
            <h4><?= (int) ($total_bookings ?? 0) ?></h4>
          </div>
          <div class="widgets-icons">
            <i class="bx bxs-calendar-check"></i>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="dashboard-card bg-gradient-warning h-100">
          <div>
            <p>Wallet Balance</p>
            <h4>&#8377;<?= number_format((float) ($wallet_balance ?? 0), 2) ?></h4>
          </div>
          <div class="widgets-icons">
            <i class="bx bxs-credit-card"></i>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="dashboard-card bg-gradient-primary h-100">
          <div>
            <p>Total Reviews</p>
            <h3><?= (int) ($total_reviews ?? 0) ?></h3>
            <div class="d-flex align-items-center gap-2 mt-1">
              <span><?= number_format((float) ($average_rating ?? 0), 1) ?></span>
              <span class="rating-stars">
                <?php
                $avgRating = (float) ($average_rating ?? 0);
                $fullStars = (int) floor($avgRating);
                $fraction = $avgRating - $fullStars;
                $halfStars = 0;
                if ($fraction >= 0.75) {
                  $fullStars++;
                } elseif ($fraction >= 0.25) {
                  $halfStars = 1;
                }
                $emptyStars = max(0, 5 - $fullStars - $halfStars);
                for ($i = 0; $i < $fullStars; $i++): ?>
                  <i class="bx bxs-star text-warning"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < $halfStars; $i++): ?>
                  <i class="bx bxs-star-half text-warning"></i>
                <?php endfor; ?>
                <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                  <i class="bx bx-star text-white-50"></i>
                <?php endfor; ?>
              </span>
            </div>
          </div>
          <div class="widgets-icons">
            <i class="bx bxs-star"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-xl-6">
        <div class="card qr-card h-100 text-center">
          <div class="card-body py-4">
            <h5 class="mb-3 dashboard-section-title">QR Code Of Your Profile</h5>

            <?php if (!empty($qr_code_url)): ?>
              <img src="<?= $qr_code_url ?>" class="img-fluid" style="max-width:250px;" alt="Profile QR">
            <?php else: ?>
              <div class="py-4">
                <i class="bx bx-qr fs-1 text-muted mb-2"></i>
                <p class="text-muted">QR Code not available.</p>
              </div>
            <?php endif; ?>

            <?php $profile_url = base_url('provider_details/' . ($this->provider['id'] ?? $this->provider['user_id'])); ?>

            <button class="btn btn-primary mt-4" onclick="shareProfile('<?= $profile_url ?>')">
              <i class="bx bx-share me-2"></i>Share Profile
            </button>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="card h-100">
          <div class="card-body">
            <h6 class="mb-4 dashboard-section-title">Total Bookings Data</h6>

            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-gradient-primary">
                <i class="bx bx-credit-card-alt text-white"></i>
              </div>
              <div>
                <h3 class="mb-0">&#8377;<?= number_format((float) ($wallet_balance ?? 0), 2) ?></h3>
                <p class="text-muted mb-0">Total Payment</p>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="payment-box text-center h-100">
                  <div class="fs-3 text-success mb-2">
                    <i class="bx bx-credit-card"></i>
                  </div>
                  <h5>&#8377;<?= number_format((float) ($pending_payout ?? 0), 2) ?></h5>
                  <p class="text-muted small mb-0">Pending Payout</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="payment-box text-center h-100">
                  <div class="fs-3 text-primary mb-2">
                    <i class="bx bx-check-circle"></i>
                  </div>
                  <h5>&#8377;<?= number_format((float) ($fulfilled_payout ?? 0), 2) ?></h5>
                  <p class="text-muted small mb-0">Fulfill Payout</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h6 class="mb-3 dashboard-section-title">Bookings Overview (Jan - Dec)</h6>
            <canvas id="bookingChart" height="120"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12">
        <div class="card notifications-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="mb-0 dashboard-section-title">Recent Notifications</h6>
              <?php if (!empty($unread_count) && $unread_count > 0): ?>
                <span class="badge bg-danger" id="unread-badge"><?= (int) $unread_count ?> New</span>
              <?php endif; ?>
            </div>

            <div class="notification-list" id="notification-list">
              <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $note): ?>
                  <div class="notification-item <?= (isset($note->is_read) && (int) $note->is_read === 0) ? 'unread' : '' ?>" id="notification-<?= (int) $note->id ?>">
                    <div class="d-flex justify-content-between gap-2">
                      <div>
                        <div class="notification-title"><?= htmlspecialchars($note->title ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="notification-message"><?= htmlspecialchars($note->message ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="notification-time">
                          <i class="bx bx-time-five me-1"></i>
                          <?= date('d M Y h:i A', strtotime($note->created_at ?? 'now')) ?>
                        </div>
                      </div>
                      <button class="btn btn-sm btn-outline-danger delete-notification notification-delete-btn" data-id="<?= (int) $note->id ?>" title="Delete notification">
                        <i class="bx bx-trash"></i>
                      </button>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="notification-empty">
                  <i class="bx bx-bell-off fs-1 d-block mb-2"></i>
                  No notifications found.
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function shareProfile(url) {
    if (navigator.share) {
      navigator.share({
        title: "My FITCKET Profile",
        text: "Check my profile on FITCKET",
        url: url
      }).catch(function() {});
      return;
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(function() {
        Swal.fire({
          icon: "success",
          title: "Copied",
          text: "Profile link copied to clipboard",
          timer: 1400,
          showConfirmButton: false
        });
      });
      return;
    }

    window.prompt("Copy this profile link:", url);
  }

  function formatNotificationDate(dateString) {
    var date = new Date(dateString);
    if (isNaN(date.getTime())) return "";
    var day = String(date.getDate()).padStart(2, "0");
    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var month = monthNames[date.getMonth()];
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = String(date.getMinutes()).padStart(2, "0");
    var suffix = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12;
    return day + " " + month + " " + year + " " + String(hours).padStart(2, "0") + ":" + minutes + " " + suffix;
  }

  function escapeHtml(text) {
    if (text === null || text === undefined) return "";
    return String(text)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  function renderNotifications(notifications, unreadCount) {
    var list = document.getElementById("notification-list");
    var badge = document.getElementById("unread-badge");
    if (!list) return;

    if (!Array.isArray(notifications) || notifications.length === 0) {
      list.innerHTML = '<div class="notification-empty"><i class="bx bx-bell-off fs-1 d-block mb-2"></i>No notifications found.</div>';
    } else {
      var html = "";
      notifications.forEach(function(note) {
        var unreadClass = parseInt(note.is_read, 10) === 0 ? "unread" : "";
        html += `
          <div class="notification-item ${unreadClass}" id="notification-${note.id}">
            <div class="d-flex justify-content-between gap-2">
              <div>
                <div class="notification-title">${escapeHtml(note.title || "")}</div>
                <div class="notification-message">${escapeHtml(note.message || "")}</div>
                <div class="notification-time">
                  <i class="bx bx-time-five me-1"></i>
                  ${escapeHtml(formatNotificationDate(note.created_at || ""))}
                </div>
              </div>
              <button class="btn btn-sm btn-outline-danger delete-notification notification-delete-btn" data-id="${note.id}" title="Delete notification">
                <i class="bx bx-trash"></i>
              </button>
            </div>
          </div>
        `;
      });
      list.innerHTML = html;
    }

    if (unreadCount > 0) {
      if (!badge) {
        var titleRow = document.querySelector(".notifications-card .d-flex.justify-content-between.align-items-center.mb-3");
        if (titleRow) {
          titleRow.insertAdjacentHTML("beforeend", '<span class="badge bg-danger" id="unread-badge"></span>');
          badge = document.getElementById("unread-badge");
        }
      }
      if (badge) badge.textContent = unreadCount + " New";
    } else if (badge) {
      badge.remove();
    }
  }

  function fetchLatestNotifications() {
    return fetch("<?= base_url('provider/dashboard/get_notifications') ?>", {
      method: "GET",
      headers: { "X-Requested-With": "XMLHttpRequest" }
    })
      .then(function(res) {
        return res.json();
      })
      .then(function(res) {
        if (!res || res.status !== "success") return;
        renderNotifications(res.notifications || [], parseInt(res.unread_count, 10) || 0);
      });
  }

  document.addEventListener("click", function(e) {
    var btn = e.target.closest(".delete-notification");
    if (!btn) return;
    e.preventDefault();

    var id = parseInt(btn.getAttribute("data-id"), 10);
    if (!id) return;

    Swal.fire({
      title: "Delete notification?",
      text: "This action cannot be undone.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#64748b",
      confirmButtonText: "Yes, delete"
    }).then(function(result) {
      if (!result.isConfirmed) return;

      btn.disabled = true;
      btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';

      var body = new URLSearchParams();
      body.append("id", id);

      fetch("<?= base_url('provider/delete_notification') ?>", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: body.toString()
      })
        .then(function(res) {
          return res.json();
        })
        .then(function(res) {
          if (!res || res.status !== "success") {
            Swal.fire("Error", (res && res.message) ? res.message : "Delete failed", "error");
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-trash"></i>';
            return;
          }
          fetchLatestNotifications();
        })
        .catch(function() {
          Swal.fire("Error", "Unable to delete notification", "error");
          btn.disabled = false;
          btn.innerHTML = '<i class="bx bx-trash"></i>';
        });
    });
  });
</script>
