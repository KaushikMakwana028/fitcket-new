<div class="page-wrapper">
  <div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">User Profile</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item">
              <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              User Profile
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end breadcrumb-->

   <div class="">
  <div class="main-body">
    <div class="row">

      <!-- Left Profile Image -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
              <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
              
              <?php 
                $profile = isset($profile[0]) ? $profile[0] : null; 
                $profile_image = !empty($profile->profile_image) ? base_url($profile->profile_image) : base_url('assets/images/programmer.png');
              ?>

              <img
                src="<?= $profile_image; ?>"
                alt="Admin"
                class="rounded-circle p-1"
                width="110"
                id="avatar-img"
                style="cursor:pointer;"
              />
              <div class="mt-3">
                <h4 id="userName"><?= isset($profile->name) ? ucfirst($profile->name) : 'John Doe'; ?></h4>
                <p class="text-secondary mb-1 fw-bold" id="userRole">
                  <?= isset($profile->role) && $profile->role == 1 ? 'Admin' : 'Member'; ?>
                </p>
              </div>
            </div>
            <hr class="my-4" />
          </div>
        </div>
      </div>

      <!-- Right Form Section -->
      <div class="col-lg-8">
        <form id="updateForm">
          <div class="card">
            <div class="card-body">

              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Full Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input 
                    type="text" 
                    id="fullName" 
                    class="form-control" 
                    name="name"
                    value="<?= isset($profile->name) ? $profile->name : ''; ?>"
                    placeholder="Enter your name" 
                  />
                  <div class="error-msg text-danger"></div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input 
                    type="email" 
                    id="email" 
                    class="form-control" 
                    name="email"
                    value="<?= isset($profile->email) ? $profile->email : ''; ?>"
                    placeholder="Enter your email" 
                  />
                  <div class="error-msg text-danger"></div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input 
                    type="tel" 
                    id="mobile" 
                    class="form-control" 
                    name="mobile"
                    value="<?= isset($profile->mobile) ? $profile->mobile : ''; ?>"
                    placeholder="Enter your phone number" 
                  />
                  <div class="error-msg text-danger"></div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-3">
                  <h6 class="mb-0">Password</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input 
                    type="password" 
                    id="password" 
                    class="form-control" 
                    name="password"
                    placeholder="Enter your password" 
                  />
                  <div class="error-msg text-danger"></div>
                  <small>Leave blank to keep current password.</small>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 text-secondary">
                  <input type="button" class="btn btn-primary px-4 update_form" value="Update Profile" />
                </div>
              </div>

            </div>
          </div>
        </form>
      </div>
      <!-- End Right Form -->
    </div>
  </div>
</div>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
  
  // ✅ Click profile image → open file chooser
  $("#avatar-img").on("click", function() {
    $("#avatar-upload").click();
  });

  // ✅ Preview selected image instantly
  $("#avatar-upload").on("change", function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $("#avatar-img").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    }
  });

  // ✅ Update profile using AJAX
  $(".update_form").on("click", function(e) {
    e.preventDefault();

    const formData = new FormData($("#updateForm")[0]);
    const file = $("#avatar-upload")[0].files[0];
    if (file) {
      formData.append("profile_image", file);
    }

    $.ajax({
      url: "<?= base_url('profile/update_profile'); ?>", 
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      beforeSend: function() {
        $(".update_form").val("Updating...");
      },
      success: function(response) {
        $(".update_form").val("Update Profile");

        if (response.status === 200) {
          Swal.fire({
            icon: "success",
            title: "Profile Updated",
            text: response.message,
            timer: 1500,
            showConfirmButton: false
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message
          });
        }
      },
      error: function(xhr, status, error) {
        $(".update_form").val("Update Profile");
        Swal.fire({
          icon: "error",
          title: "Something went wrong!",
          text: "Please try again."
        });
      }
    });
  });

});
</script>

