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

    <title>FITKET</title>
    <style>
        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .card h6 {
            color: red;
            font-size: 20px
        }

        .inputs input {
            width: 40px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: red
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid red
        }

        .validate {
            border-radius: 20px;
            height: 40px;
            background-color: red;
            border: 1px solid red;
            width: 140px
        }
    </style>
</head>

<body class="">


    <div class="container height-100 d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div id="errorAlert" style="display: none;">
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class="bx bxs-error"></i></div>
                        <div class="ms-3">
                            <div class="text-white" id="errorText"></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close"
                        onclick="document.getElementById('errorAlert').style.display='none';"
                        aria-label="Close"></button>
                </div>
            </div>

            <div class="card p-2 text-center">
                <h6>Please enter the one time password <br> to verify your account</h6>
                <div> <span>A code has been sent to</span> <small id="maskedNumber"><?= $masked_mobile ?></small>
                </div>
                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                    <input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
                    <input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
                </div>
                <div class="mt-4">
                    <button id="validateBtn" class="btn btn-danger px-4 validate">Validate</button>
                </div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > input');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('input', function () {
                        if (this.value.length > 1) {
                            this.value = this.value[0]; //    
                        }
                        if (this.value !== '' && i < inputs.length - 1) {
                            inputs[i + 1].focus(); //   
                        }
                    });

                    inputs[i].addEventListener('keydown', function (event) {
                        if (event.key === 'Backspace') {
                            this.value = '';
                            if (i > 0) {
                                inputs[i - 1].focus();
                            }
                        }
                    });
                }
            }

            OTPInput();

            const validateBtn = document.getElementById('validateBtn');
            validateBtn.addEventListener('click', function () {
                let otp = '';
                document.querySelectorAll('#otp > input').forEach(input => otp += input.value);

                $.ajax({
                    url: "<?= base_url('login/register_verify_otp') ?>",
                    type: "POST",
                    data: { otp: otp },
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.redirect_url) {
                            window.location.href = res.redirect_url;
                        }
                    },
                    error: function (xhr) {
                        try {
                            let errorResponse = JSON.parse(xhr.responseText);
                            document.getElementById('errorText').innerText = errorResponse.error;
                            document.getElementById('errorAlert').style.display = 'block';
                        } catch (e) {
                            alert("Unexpected error. Please try again.");
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>