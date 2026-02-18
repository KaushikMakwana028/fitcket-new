<div class="container">
  <div class="login-box">

    <div class="register-logo mb-3 d-flex justify-content-center">
      <img src="<?= base_url('assets/images/logo_ficat.png');?>" alt="Logo" />
    </div>

    <p class="text-muted mb-3 fw-bold">Please log in to your account</p>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <!-- End Flash Messages -->

    <form action="<?= base_url('login/send_otp') ?>" method="post">
      <div class="mb-3 text-start">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="text" class="form-control" id="mobile" name="mobile"
               placeholder="Enter your mobile" value="<?= set_value('mobile'); ?>">
        <!-- Show validation error for mobile -->
        <?= form_error('mobile', '<small class="text-danger">', '</small>'); ?>
      </div>

      <button type="submit" class="btn btn-primary w-100">Send OTP</button>
    </form>

    <div class="signup-link mt-3 text-center">
      Don't have an account yet? 
      <a href="<?= base_url('sign_in') ?>?redirect=<?= urlencode($this->input->get('redirect') ?? current_url()) ?>">
        Sign up here
      </a>
    </div>

  </div>
</div>
