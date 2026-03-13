<style>
  /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 10px;
        } */

  .main-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 0 auto;
  }

  .profile-grid {
    display: grid;
    grid-template-columns: 400px 1fr;
    min-height: calc(100vh - 30px);
  }

  .profile-section {
    background: var(--gradient-primary);
    color: #fff;
    padding: 30px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
  }

  .profile-avatar {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 30px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
  }

  .profile-avatar:hover {
    transform: scale(1.05);
  }

  .profile-name {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 12px;
  }

  .profile-email {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-bottom: 20px;
  }

  .profile-badge {
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 16px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
    border-radius: 20px;
    margin-bottom: 20px;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .stat-item {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 16px;
    text-align: center;
    transition: transform 0.3s ease;
  }

  .stat-item:hover {
    transform: translateY(-2px);
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
  }

  .stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
  }

  .actions-section {
    padding: 1rem;
    background: white;
    overflow-y: auto;
  }

  .section-header h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 8px;
  }

  .section-header p {
    color: #6b7280;
  }

  .action-category {
    background: #f9fafb;
    border-radius: 16px;
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
    margin-bottom: 20px;
  }

  .category-title {
    font-size: 1.25rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
  }

  .category-icon {
    width: 38px;
    height: 38px;
    background: var(--gradient-primary);
    color: #fff;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
  }

  .action-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
  }

  .action-button {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: .5rem;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    color: #374151;
    transition: transform 0.3s ease;
  }

  .action-button:hover {
    transform: translateY(-2px);
    border-color: #4f46e5;
    color: #4f46e5;
  }

  .action-icon {
    width: 48px;
    height: 48px;
    background: #f3f4f6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .logout-section {
    /* margin-top: 40px; */
    text-align: center;
  }

  .logout-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    border-radius: 12px;
    padding: 0.5rem 1rem;
    color: white;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 12px;
  }

  @media (max-width: 992px) {
    .profile-grid {
      grid-template-columns: 1fr;
    }

    .profile-avatar {
      width: 120px;
      height: 120px;
    }

    .action-links {
      grid-template-columns: 1fr;
    }
  }
</style>
<div class="container mt-5 mb-5">
  <div class="profile-grid">
    <div class="profile-section">
      <img src="<?= !empty($user->profile_image) ? base_url($user->profile_image) : base_url('assets/images/9334234.jpg') ?>"
        alt="Profile Picture"
        class="profile-avatar">

      <h1 class="profile-name"><?= isset($user->name) ? $user->name : 'No Name' ?></h1>
      <p class="profile-email"><?= isset($user->email) ? $user->email : 'No Email' ?></p>

      <!-- <div class="profile-badge">Premium Member</div> -->

      <div class="stats-grid">
        <!-- <div class="stat-item">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Active Bookings</div>
                    </div> -->
        <div class="stat-item">
          <div class="stat-number">
            <?= isset($bank_account_count) ? $bank_account_count : 0 ?>
          </div>
          <div class="stat-label">Bank Accounts</div>
        </div>

        <div class="stat-item">
          <div class="stat-number">
            <?= isset($booking_count) ? $booking_count : 0 ?>
          </div>
          <div class="stat-label">Total Bookings</div>
        </div>

        <!-- <div class="stat-item">
                        <div class="stat-number">2.5k</div>
                        <div class="stat-label">Points Earned</div>
                    </div> -->
      </div>
    </div>

    <div class="actions-section">
      <div class="section-header">
        <h2>Account Management</h2>
        <p>Manage your profile, bookings, and account settings</p>
      </div>

      <div class="action-category">
        <div class="category-title">
          <div class="category-icon"><i class="bi bi-person-gear"></i></div>
          Profile Settings
        </div>
        <div class="action-links">
          <a href="<?= base_url('edit_user/' . $user->id); ?>" class="action-button">
            <div class="action-icon"><i class="bi bi-pencil-square"></i></div>
            <div>Edit Profile</div>
          </a>

        </div>
      </div>

      <div class="action-category">
        <div class="category-title">
          <div class="category-icon"><i class="bi bi-bank"></i></div>
          Banking & Payments
        </div>
        <div class="action-links">
          <a href="<?= base_url('manage_bank_account/' . $user->id); ?>" class="action-button">
            <div class="action-icon"><i class="bi bi-credit-card"></i></div>
            <div>Manage Bank Accounts</div>
          </a>
        </div>
      </div>

      <div class="action-category">
        <div class="category-title">
          <div class="category-icon"><i class="bi bi-calendar-check"></i></div>
          Bookings & Reservations
        </div>
        <div class="action-links">
          <a href="<?= base_url('bookings/' . $user->id); ?>" class="action-button">
            <div class="action-icon"><i class="bi bi-list-ul"></i></div>
            <div>View My Bookings</div>
          </a>
        </div>
      </div>

      <div class="action-category">
        <div class="category-title">
          <div class="category-icon">
            <i class="bi bi-camera-video-fill"></i>
          </div>
          My Live Sessions
        </div>

        <div class="action-links">
          <a href="<?= base_url('session_booking/my_sessions'); ?>" class="action-button">
            <div class="action-icon">
              <i class="bi bi-play-circle"></i>
            </div>
            <div>View Booked Sessions</div>
          </a>
        </div>
      </div>

      <div class="action-category">
        <div class="category-title">
          <div class="category-icon" style="background: linear-gradient(135deg, #e50914, #b81d24);">
            <i class="bi bi-collection-play-fill"></i>
          </div>
          FITTV EXCLUSIVE
        </div>

        <div class="action-links">
          <a href="<?= base_url('fittv'); ?>" class="action-button">
            <div class="action-icon" style="background: #fee2e2; color: #ef4444;">
              <i class="bi bi-play-btn-fill"></i>
            </div>
            <div>Watch Premium Workouts</div>
          </a>
        </div>
      </div>

      <div class="logout-section mb-5">
        <a class="logout-btn" style="text-decoration: none;" href="<?= base_url('logout'); ?>">
          <i class="bi bi-box-arrow-right"></i> Sign Out Securely
        </a>

      </div>
    </div>
  </div>
</div>
<script>
  function handleAction(actionName) {
    const button = event.target.closest('.action-button, .logout-btn');
    if (button) {
      button.style.transform = 'scale(0.95)';
      setTimeout(() => {
        button.style.transform = '';
        alert(`Action triggered: ${actionName}`);
      }, 150);
    } else {
      alert(`Action triggered: ${actionName}`);
    }
  }
</script>