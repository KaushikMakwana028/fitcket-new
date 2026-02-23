<style>
  /* Minimal extra CSS */
  .widgets-icons {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 24px;
    background: #fff;
  }

  .card p {
    margin-bottom: 0;
    font-size: 14px;
  }

  .notifications-card {
    border-radius: 14px;
  }

  .notification-list {
    height: 420px;
    overflow-y: scroll;
    padding-right: 4px;
  }

  .notification-item {
    border: 1px solid #eceff4;
    border-radius: 12px;
    margin-bottom: 12px;
    padding: 12px 14px;
    transition: background-color 0.2s ease, border-color 0.2s ease;
  }

  .notification-item:last-child {
    margin-bottom: 0;
  }

  .notification-empty {
    height: 100%;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7a8694;
    text-align: center;
    border: 1px dashed #d6dee8;
    border-radius: 12px;
    padding: 16px;
  }

  .notification-item.unread {
    background: #f8faff;
    border-color: #d7e7ff;
  }

  .notification-title {
    font-size: 14px;
    font-weight: 600;
    color: #212529;
    margin-bottom: 4px;
  }

  .notification-message {
    font-size: 13px;
    color: #5b6572;
    margin-bottom: 8px;
    line-height: 1.4;
  }

  .notification-time {
    font-size: 12px;
    color: #8c96a3;
  }

  .notification-actions .btn {
    min-width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  @media (max-width: 576px) {
    .notification-item {
      padding: 10px 12px;
    }
  }
</style>

<div class="page-wrapper">
  <div class="page-content">
    <!-- Top Cards -->
    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xl-4">
      <!-- Total Customers -->
      <div class="col">
        <div class="card bg-success text-white h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p>Total Customers</p>
              <h4><?= $total_customers ?></h4>
            </div>
            <div class="widgets-icons text-success"><i class="bx bxs-user-account"></i></div>
          </div>
        </div>
      </div>

      <!-- Total Services -->
      <div class="col">
        <div class="card bg-info text-dark h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p>Total Services</p>
              <h4><?= $total_service ?></h4>
            </div>
            <div class="widgets-icons text-dark"><i class="bx bxs-id-card"></i></div>
          </div>
        </div>
      </div>

      <!-- Total Booking -->
      <div class="col">
        <div class="card bg-danger text-white h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p>Total Booking</p>
              <h4><?= $total_bookings ?></h4>
            </div>
            <div class="widgets-icons text-danger"><i class="bx bxs-calendar-check"></i></div>
          </div>
        </div>
      </div>

      <!-- Total Payment -->
      <div class="col">
        <div class="card bg-warning text-white h-100">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <p>Wallet Balance</p>
              <h4>₹<?= number_format($wallet_balance, 2) ?></h4>
            </div>
            <div class="widgets-icons text-warning"><i class="bx bxs-credit-card"></i></div>
          </div>
        </div>
      </div>
    </div>

    <!-- QR Code + Service Data -->
    <div class="row g-3 mt-2">
      <!-- QR Code -->
      <div class="col-xl-6">
        <div class="card h-100 text-center">
          <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <h5>QR Code Of Your Profile</h5>

            <?php if (!empty($qr_code_url)): ?>
              <img src="<?= $qr_code_url ?>" class="img-fluid" style="max-width:250px;" alt="Profile QR Code">
            <?php else: ?>
              <p class="text-muted">QR Code not available.</p>
            <?php endif; ?>

            <?php
            $profile_url = base_url('provider_details/' . ($this->provider['id'] ?? $this->provider['user_id']));
            ?>

            <button type="button" class="btn btn-primary mt-3 px-4" onclick="shareProfile('<?= $profile_url ?>')">
              <i class="bx bx-share me-2"></i>Share Profile
            </button>
          </div>
        </div>
      </div>

      <!-- Service Data -->
      <div class="col-xl-6">
        <div class="card h-100">
          <div class="card-body">
            <h6>Total Bookings Data</h6>
            <div class="d-flex align-items-center gap-3 mb-4">
              <div class="widgets-icons bg-light-primary text-primary rounded-circle">
                <i class="bx bx-credit-card-alt"></i>
              </div>
              <div>
                <h3>₹<?= number_format($wallet_balance ?? 0, 2) ?></h3>
                <p>Total Payment</p>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-success"><i class="bx bx-credit-card"></i></div>
                  <h5>₹<?= number_format(($pending_payout ?? 0), 2) ?></h5>
                  <p>Pending Payout</p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="border rounded-3 p-3 text-center h-100">
                  <div class="fs-3 text-primary"><i class="bx bx-check-circle"></i></div>
                  <h5>₹<?= number_format(($fulfilled_payout ?? 0), 2) ?></h5>
                  <p>Fulfill Payout</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bookings Overview Chart -->
    <div class="row g-3 mt-2">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h6 class="mb-3">Bookings Overview (Jan - Dec)</h6>
            <canvas id="bookingChart" height="120"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Notifications -->
    <div class="row g-3 mt-3">
      <div class="col-12">
        <div class="card notifications-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="mb-0">Recent Notifications</h6>
              <?php if ($unread_count > 0): ?>
                <span class="badge bg-danger" id="unread-badge"><?= $unread_count ?> New</span>
              <?php endif; ?>
            </div>

            <ul class="list-unstyled notification-list mb-0" id="notification-list">
              <?php if (!empty($notifications)): ?>
                <?php foreach ($notifications as $note): ?>
                  <li class="notification-item <?= (int)$note->is_read === 0 ? 'unread' : '' ?>" id="notification-<?= $note->id ?>">
                    <div class="d-flex justify-content-between gap-3">
                      <div class="flex-grow-1">
                        <div class="notification-title"><?= html_escape($note->title) ?></div>
                        <div class="notification-message"><?= html_escape($note->message) ?></div>
                        <div class="notification-time">
                          <i class="bx bx-time-five me-1"></i><?= date('d M Y h:i A', strtotime($note->created_at)) ?>
                        </div>
                      </div>
                      <div class="notification-actions">
                        <button type="button" class="btn btn-sm btn-outline-danger delete-notification" data-id="<?= $note->id ?>" title="Delete notification">
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li class="notification-empty" id="empty-notification">
                  <div>
                    <i class="bx bx-bell-off fs-1 d-block mb-2"></i>
                    No notifications found.
                  </div>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
  function getSwal() {
    return (typeof Swal !== 'undefined') ? Swal : null;
  }

  function updateUnreadBadgeAfterDelete(wasUnread) {
    if (!wasUnread) return;

    var $badge = $('#unread-badge');
    if (!$badge.length) return;

    var currentText = ($badge.text() || '').trim();
    var current = parseInt(currentText, 10) || 0;
    var next = Math.max(0, current - 1);

    if (next > 0) {
      $badge.text(next + ' New');
    } else {
      $badge.remove();
    }
  }

  $(document).on('click', '.delete-notification', function() {
    var id = $(this).data('id');
    var $row = $('#notification-' + id);
    var swal = getSwal();
    var wasUnread = $row.hasClass('unread');

    if (!id) {
      if (swal) {
        swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Notification ID is missing.'
        });
      }
      return;
    }

    var runDelete = function() {
      $.ajax({
        url: "<?= site_url('provider/dashboard/delete_notification'); ?>",
        type: "POST",
        data: {
          id: id
        },
        dataType: "json",
        success: function(response) {

          if (response.status === 'success') {
            $row.fadeOut(250, function() {
              $(this).remove();
              updateUnreadBadgeAfterDelete(wasUnread);
              if ($('#notification-list .notification-item').length === 0) {
                if (!$('#empty-notification').length) {
                  $('#notification-list').append(
                    '<li class="notification-empty" id="empty-notification"><div><i class="bx bx-bell-off fs-1 d-block mb-2"></i>No notifications found.</div></li>'
                  );
                }
              }
            });
            if (swal) {
              swal.fire({
                icon: 'success',
                title: 'Deleted',
                text: 'Notification deleted successfully.',
                timer: 1200,
                showConfirmButton: false
              });
            }
          } else {
            if (swal) {
              swal.fire({
                icon: 'error',
                title: 'Delete Failed',
                text: (response.message || 'Unknown error')
              });
            }
          }

        },
        error: function(xhr) {
          if (swal) {
            swal.fire({
              icon: 'error',
              title: 'Server Error',
              text: "Server error: " + xhr.status + " " + xhr.statusText
            });
          }
        }
      });
    };

    if (swal) {
      swal.fire({
        title: 'Delete Notification?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it'
      }).then(function(result) {
        if (result.isConfirmed) {
          runDelete();
        }
      });
    } else if (confirm("Delete this notification?")) {
      runDelete();
    }
  });
</script>
