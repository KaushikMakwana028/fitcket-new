<div class="container">

    

    <div class="register-box text-center">

        <?php if ($this->session->flashdata('error')): ?>

                                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">

                                        <div class="d-flex align-items-center">

                                            <div class="font-35 text-white"><i class="bx bxs-error"></i></div>

                                            <div class="ms-3">

                                                <!-- <h6 class="mb-0 text-white">Error Alert</h6> -->

                                                <div class="text-white">

                                                    <?= $this->session->flashdata('error'); ?>

                                                </div>

                                            </div>

                                        </div>

                                        <button type="button" class="btn-close" data-bs-dismiss="alert"

                                            aria-label="Close"></button>

                                    </div>

                                <?php endif; ?>

      <!-- Logo -->

      <div class="register-logo mb-3 d-flex justify-content-center">

        <img src="<?= base_url('assets/images/logo_ficat.png');?>" alt="Fitcket Logo">

      </div>



      <!-- Heading -->

      <h5 class="fw-bold">User Registration</h5>



      <!-- Form -->

     <form id="registrationForm" method="post" action="<?= base_url('login/register_user');?>" 
      novalidate class="needs-validation mt-4">

  <div class="row g-2 mb-3">
    <div class="col-md-6">
      <input type="text" 
             class="form-control <?= form_error('first_name') ? 'is-invalid' : '' ?>" 
             placeholder="First Name" 
             name="first_name" 
             value="<?= set_value('first_name', $old['first_name'] ?? '') ?>" 
             required>
      <div class="invalid-feedback"><?= form_error('first_name'); ?></div>
    </div>

    <div class="col-md-6">
      <input type="text" 
             class="form-control <?= form_error('last_name') ? 'is-invalid' : '' ?>" 
             placeholder="Last Name" 
             name="last_name" 
             value="<?= set_value('last_name', $old['last_name'] ?? '') ?>" 
             required>
      <div class="invalid-feedback"><?= form_error('last_name'); ?></div>
    </div>
  </div>

  <div class="mb-3">
    <input type="tel" 
           class="form-control <?= form_error('mobile') ? 'is-invalid' : '' ?>" 
           placeholder="Mobile" 
           name="mobile" 
           value="<?= set_value('mobile', $old['mobile'] ?? '') ?>" 
           required>
    <div class="invalid-feedback"><?= form_error('mobile'); ?></div>
  </div>

  <div class="mb-3">
    <input type="email" 
           class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
           placeholder="example@user.com" 
           name="email" 
           value="<?= set_value('email', $old['email'] ?? '') ?>" 
           required>
    <div class="invalid-feedback"><?= form_error('email'); ?></div>
  </div>

  <button type="submit" class="btn btn-primary">Sign up</button>
</form>

    



      <!-- Footer text -->

      <div class="bottom-text">
    Already have an account? 
    <a href="<?= base_url('login') ?>?redirect=<?= urlencode($this->input->get('redirect') ?? current_url()) ?>">
        Sign in here
    </a>
</div>

    </div>

  </div>