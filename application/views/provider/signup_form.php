<!doctype html>

<html lang="en" data-bs-theme="light">



<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--favicon-->

    <link rel="icon" href="<?= base_url('assets/images/favicon-32x32.png') ?>" type="image/png">

    <!--plugins-->

    <link href="<?= base_url('assets/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet">

    <!-- loader-->

    <link href="<?= base_url('assets/css/pace.min.css') ?>" rel="stylesheet">

    <script src="<?= base_url('assets/js/pace.min.js') ?>"></script>

    <!-- Bootstrap CSS -->

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <link href="<?= base_url('assets/sass/app.css') ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/sass/dark-theme.css') ?>">

    <link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">



    <title>Syndron - Bootstrap 5 Admin Dashboard Template</title>

</head>



<body class="">



    <!--wrapper-->

    <div class="wrapper">



        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">

            <div class="container-fluid">

                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">

                    <div class="col mx-auto">



                        <div class="card mb-0">

                            <div class="card-body">

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

                                <div class="p-4">

                                    <div class="mb-3 text-center">

                                        <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" width="" alt="" />

                                    </div>

                                    <div class="text-center mb-4">

                                        <!-- <h5 class="">Syndron Admin</h5> -->

                                        <p class="mb-0 fw-bold">Partner Registration</p>

                                    </div>

                                    <div class="form-body">

                                        <form class="row g-3" method="post"
                                            action="<?= base_url('send_register_otp'); ?>">

                                            <div class="col-6">
                                                <label for="inputFirstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="inputFirstName"
                                                    placeholder="John" name="firstname"
                                                    value="<?= set_value('firstname'); ?>">
                                                <?= form_error('firstname', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-6">
                                                <label for="inputLastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="inputLastName"
                                                    placeholder="Doe" name="lastname"
                                                    value="<?= set_value('lastname'); ?>">
                                                <?= form_error('lastname', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputMobile" class="form-label">Mobile</label>
                                                <input type="tel" class="form-control" id="inputMobile"
                                                    placeholder="9876543210" name="mobile"
                                                    value="<?= set_value('mobile'); ?>">
                                                <?= form_error('mobile', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="example@user.com" name="email"
                                                    value="<?= set_value('email'); ?>">
                                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputBusinessName" class="form-label">Business Name</label>
                                                <input type="text" class="form-control" id="inputBusinessName"
                                                    placeholder="Your Business Name" name="business_name"
                                                    value="<?= set_value('business_name'); ?>">
                                                <?= form_error('business_name', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Sign up</button>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="text-center">
                                                    <p class="mb-0">Already have an account?
                                                        <a href="<?= base_url('provider'); ?>">Sign in here</a>
                                                    </p>
                                                </div>
                                            </div>

                                        </form>

                                    </div>







                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!--end row-->

            </div>

        </div>

    </div>

    <!--end wrapper-->

    <!-- Bootstrap JS -->

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <!--plugins-->

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>

    <!--Password show & hide js -->

    <script>

        $(document).ready(function () {

            $("#show_hide_password a").on('click', function (event) {

                event.preventDefault();

                if ($('#show_hide_password input').attr("type") == "text") {

                    $('#show_hide_password input').attr('type', 'password');

                    $('#show_hide_password i').addClass("bx-hide");

                    $('#show_hide_password i').removeClass("bx-show");

                } else if ($('#show_hide_password input').attr("type") == "password") {

                    $('#show_hide_password input').attr('type', 'text');

                    $('#show_hide_password i').removeClass("bx-hide");

                    $('#show_hide_password i').addClass("bx-show");

                }

            });

        });

        document.addEventListener("DOMContentLoaded", function () {

            // Find all alerts (success, danger, warning etc.)

            var alerts = document.querySelectorAll('.alert-success, .alert-danger');



            alerts.forEach(function (alert) {

                // After 3 seconds

                setTimeout(function () {

                    // Smooth fade out

                    alert.style.transition = "opacity 0.5s ease";

                    alert.style.opacity = 0;



                    // After fade out, remove from DOM

                    setTimeout(function () {

                        alert.remove();

                    }, 500);

                }, 3000); // 3 seconds wait before starting fade

            });

        });

    </script>

    <!--app JS-->

    <script src="<?= base_url('assets/js/app.js'); ?>"></script>

</body>



</html>