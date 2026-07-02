<!doctype html>

<html lang="en" data-bs-theme="light">



<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--favicon-->

    <link rel="icon" href="<?= base_url('assets/images/dumbbell_8729453.png') ?>" type="image/png">

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

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link href="<?= base_url('assets/sass/app.css') ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/sass/dark-theme.css') ?>">

    <link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">



    <title>Fitcket - Partner Registration</title>

    <style>
        :root {
            --fk-purple: #6b21e8;
            --fk-purple-dark: #4c14b0;
            --fk-teal: #17c3b2;
            --fk-bg-1: #f2eefc;
            --fk-bg-2: #e8f9f7;
        }

        [data-bs-theme="dark"] {
            --fk-bg-1: #14101f;
            --fk-bg-2: #101a19;
        }

        body {
            font-family: 'Roboto', sans-serif;
        }

        .section-authentication-signin {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--fk-bg-1) 0%, var(--fk-bg-2) 100%);
            position: relative;
            overflow: hidden;
        }

        .section-authentication-signin::before,
        .section-authentication-signin::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(0px);
            opacity: 0.35;
            z-index: 0;
        }

        .section-authentication-signin::before {
            width: 420px;
            height: 420px;
            background: var(--fk-purple);
            top: -150px;
            left: -150px;
        }

        .section-authentication-signin::after {
            width: 380px;
            height: 380px;
            background: var(--fk-teal);
            bottom: -140px;
            right: -140px;
        }

        .signup-card {
            position: relative;
            z-index: 1;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(76, 20, 176, 0.15);
            overflow: hidden;
            animation: fk-fade-up 0.5s ease both;
        }

        @keyframes fk-fade-up {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .signup-card .card-body {
            padding: 0.5rem;
        }

        .signup-logo img {
            max-width: 170px;
        }

        .signup-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--fk-purple-dark);
            letter-spacing: 0.3px;
        }

        .signup-subtitle {
            font-size: 0.85rem;
            color: #8a8a9a;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #4a4a58;
            margin-bottom: 0.35rem;
        }

        .input-icon-group {
            position: relative;
        }

        .input-icon-group .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: var(--fk-purple);
            font-size: 1.1rem;
            pointer-events: none;
        }

        .input-icon-group .form-control {
            padding-left: 42px;
        }

        .form-control {
            border-radius: 10px;
            border: 1.5px solid #e5e1f5;
            padding: 0.65rem 0.9rem;
            font-size: 0.92rem;
            background-color: #fbfaff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #1c1730;
            border-color: #332a52;
            color: #eee;
        }

        .form-control:focus {
            border-color: var(--fk-purple);
            box-shadow: 0 0 0 0.2rem rgba(107, 33, 232, 0.15);
            background-color: #fff;
        }

        .btn-signup {
            background: linear-gradient(135deg, var(--fk-purple) 0%, var(--fk-purple-dark) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.98rem;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 20px rgba(107, 33, 232, 0.3);
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
        }

        .btn-signup:hover,
        .btn-signup:focus {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(107, 33, 232, 0.38);
            opacity: 0.97;
        }

        .btn-signup:active {
            transform: translateY(0);
        }

        .signin-link a {
            color: var(--fk-purple);
            font-weight: 600;
            text-decoration: none;
        }

        .signin-link a:hover {
            text-decoration: underline;
        }

        .alert-danger.custom-alert {
            border-radius: 12px;
            box-shadow: 0 8px 18px rgba(220, 53, 69, 0.25);
        }

        small.text-danger {
            display: inline-block;
            margin-top: 0.25rem;
            font-size: 0.78rem;
        }

        @media (max-width: 575.98px) {
            .signup-card {
                border-radius: 16px;
                margin: 0 0.5rem;
            }
        }
    </style>

</head>



<body class="">



    <!--wrapper-->

    <div class="wrapper">



        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">

            <div class="container-fluid">

                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">

                    <div class="col mx-auto">



                        <div class="card signup-card mb-0">

                            <div class="card-body">

                                <?php if ($this->session->flashdata('error')): ?>

                                    <div class="alert alert-danger custom-alert border-0 bg-danger alert-dismissible fade show py-2">

                                        <div class="d-flex align-items-center">

                                            <div class="font-35 text-white"><i class="bx bxs-error"></i></div>

                                            <div class="ms-3">

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

                                    <div class="mb-3 text-center signup-logo">

                                        <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="Fitcket" />

                                    </div>

                                    <div class="text-center mb-4">

                                        <p class="mb-1 signup-title">Partner Registration</p>
                                        <p class="signup-subtitle mb-0">Join Fitcket and grow your fitness business</p>

                                    </div>

                                    <div class="form-body">

                                        <form class="row g-3" method="post"
                                            action="<?= base_url('send_register_otp'); ?>">

                                            <div class="col-6">
                                                <label for="inputFirstName" class="form-label">First Name</label>
                                                <div class="input-icon-group">
                                                    <i class="bx bx-user input-icon"></i>
                                                    <input type="text" class="form-control" id="inputFirstName"
                                                        placeholder="John" name="firstname"
                                                        value="<?= set_value('firstname'); ?>">
                                                </div>
                                                <?= form_error('firstname', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-6">
                                                <label for="inputLastName" class="form-label">Last Name</label>
                                                <div class="input-icon-group">
                                                    <i class="bx bx-user input-icon"></i>
                                                    <input type="text" class="form-control" id="inputLastName"
                                                        placeholder="Doe" name="lastname"
                                                        value="<?= set_value('lastname'); ?>">
                                                </div>
                                                <?= form_error('lastname', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputMobile" class="form-label">Mobile</label>
                                                <div class="input-icon-group">
                                                    <i class="bx bx-phone input-icon"></i>
                                                    <input type="tel" class="form-control" id="inputMobile"
                                                        placeholder="9876543210" name="mobile"
                                                        value="<?= set_value('mobile'); ?>">
                                                </div>
                                                <?= form_error('mobile', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputEmail" class="form-label">Email</label>
                                                <div class="input-icon-group">
                                                    <i class="bx bx-envelope input-icon"></i>
                                                    <input type="email" class="form-control" id="inputEmail"
                                                        placeholder="example@user.com" name="email"
                                                        value="<?= set_value('email'); ?>">
                                                </div>
                                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <label for="inputBusinessName" class="form-label">Business Name</label>
                                                <div class="input-icon-group">
                                                    <i class="bx bx-store input-icon"></i>
                                                    <input type="text" class="form-control" id="inputBusinessName"
                                                        placeholder="Your Business Name" name="business_name"
                                                        value="<?= set_value('business_name'); ?>">
                                                </div>
                                                <?= form_error('business_name', '<small class="text-danger">', '</small>'); ?>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-signup text-white">Sign up</button>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="text-center signin-link">
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
        $(document).ready(function() {

            $("#show_hide_password a").on('click', function(event) {

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

        document.addEventListener("DOMContentLoaded", function() {

            var alerts = document.querySelectorAll('.alert-success, .alert-danger');

            alerts.forEach(function(alert) {

                setTimeout(function() {

                    alert.style.transition = "opacity 0.5s ease";

                    alert.style.opacity = 0;

                    setTimeout(function() {

                        alert.remove();

                    }, 500);

                }, 3000);

            });

        });
    </script>

    <!--app JS-->

    <script src="<?= base_url('assets/js/app.js'); ?>"></script>

</body>



</html>