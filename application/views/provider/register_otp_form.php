<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url('assets/images/dumbbell_8729453.png') ?>" type="image/png">
    <link href="<?= base_url('assets/plugins/simplebar/css/simplebar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/metismenu/css/metisMenu.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/pace.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/pace.min.js') ?>"></script>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/bootstrap-extended.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/sass/app.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/sass/dark-theme.css') ?>">
    <link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">

    <title>Register OTP</title>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 96vw;
            min-height: 540px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(30, 40, 100, 0.14), 0 4px 16px rgba(30, 40, 100, 0.08);
        }

        /* LEFT PANEL */
        .login-left {
            flex: 1;
            background: #1a237e;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 36px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='220' height='220' viewBox='0 0 220 220'%3E%3Ccircle cx='110' cy='110' r='100' fill='none' stroke='rgba(255,193,7,0.12)' stroke-width='1.5'/%3E%3Ccircle cx='110' cy='110' r='78' fill='none' stroke='rgba(255,193,7,0.10)' stroke-width='1'/%3E%3Ccircle cx='110' cy='110' r='56' fill='none' stroke='rgba(255,193,7,0.08)' stroke-width='1'/%3E%3Cpolygon points='110,10 200,155 20,155' fill='none' stroke='rgba(255,193,7,0.09)' stroke-width='1'/%3E%3Cpolygon points='110,210 20,65 200,65' fill='none' stroke='rgba(255,193,7,0.09)' stroke-width='1'/%3E%3Ccircle cx='110' cy='110' r='6' fill='rgba(255,193,7,0.25)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 220px 220px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 193, 7, 0.07);
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
        }

        .brand-icon {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: rgba(255, 193, 7, 0.15);
            border: 1.5px solid rgba(255, 193, 7, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 34px;
        }

        .left-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .left-subtitle {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.65);
            line-height: 1.6;
            max-width: 200px;
            margin: 0 auto 28px;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-top: 8px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }

        .step.done .step-circle {
            background: rgba(255, 193, 7, 0.25);
            border: 1.5px solid rgba(255, 193, 7, 0.6);
            color: #ffc107;
        }

        .step.active .step-circle {
            background: #ffc107;
            color: #1a237e;
        }

        .step-label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
            white-space: nowrap;
        }

        .step.done .step-label,
        .step.active .step-label {
            color: rgba(255, 255, 255, 0.85);
        }

        .step-line {
            width: 36px;
            height: 1.5px;
            background: rgba(255, 193, 7, 0.3);
            margin-bottom: 20px;
        }

        /* RIGHT PANEL */
        .login-right {
            flex: 1.1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
        }

        .login-logo {
            display: block;
            max-height: 44px;
            max-width: 140px;
            object-fit: contain;
            margin-bottom: 28px;
        }

        .otp-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #eff3ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 18px;
        }

        .login-heading {
            font-size: 22px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .login-sub {
            font-size: 13.5px;
            color: #8590a0;
            margin-bottom: 8px;
        }

        .mobile-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff3ff;
            color: #3d52d5;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 28px;
        }

        /* OTP INPUTS */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
            margin-bottom: 24px;
        }

        .otp-box {
            width: 48px;
            height: 54px;
            border: 1.5px solid #e4e8f0;
            border-radius: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            color: #1a237e;
            background: #fafbff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            caret-color: #3d52d5;
        }

        .otp-box:focus {
            border-color: #3d52d5;
            box-shadow: 0 0 0 3px rgba(61, 82, 213, 0.10);
            background: #fff;
        }

        .otp-box.filled {
            border-color: #3d52d5;
            background: #f0f3ff;
        }

        .otp-box.error {
            border-color: #e53935;
            background: #fff8f8;
            box-shadow: 0 0 0 3px rgba(229, 57, 53, 0.10);
            animation: shake 0.35s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-5px);
            }

            40% {
                transform: translateX(5px);
            }

            60% {
                transform: translateX(-4px);
            }

            80% {
                transform: translateX(4px);
            }
        }

        .btn-validate {
            width: 100%;
            height: 48px;
            background: #1a237e;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            letter-spacing: 0.2px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .btn-validate:hover {
            background: #283593;
            box-shadow: 0 6px 20px rgba(26, 35, 126, 0.28);
            transform: translateY(-1px);
        }

        .btn-validate:active {
            transform: translateY(0);
        }

        .btn-validate:disabled {
            background: #9fa8da;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255, 255, 255, 0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .resend-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: #8590a0;
            margin-bottom: 20px;
        }

        .resend-btn {
            background: none;
            border: none;
            font-size: 13px;
            font-weight: 500;
            color: #3d52d5;
            cursor: pointer;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        .resend-btn:disabled {
            color: #b0bec5;
            cursor: not-allowed;
        }

        .back-link {
            text-align: center;
            font-size: 13px;
            color: #8590a0;
        }

        .back-link a {
            color: #3d52d5;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .error-msg {
            display: none;
            align-items: center;
            gap: 8px;
            background: #fdecea;
            color: #c62828;
            border: 1px solid #ffcdd2;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13.5px;
            margin-bottom: 18px;
        }

        .error-msg.show {
            display: flex;
        }

        @media (max-width: 640px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 36px 24px;
                border-radius: 16px;
            }

            .login-wrapper {
                border-radius: 16px;
            }

            .otp-box {
                width: 42px;
                height: 48px;
                font-size: 18px;
            }
        }

        @media (max-width: 400px) {
            .otp-inputs {
                gap: 6px;
            }

            .otp-box {
                width: 38px;
                height: 46px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- LEFT PANEL -->
        <div class="login-left">
            <div class="left-content">
                <div class="brand-icon">🔐</div>
                <div class="left-title">Verify Your Identity</div>
                <p class="left-subtitle">A one-time password has been sent to your registered mobile number.</p>

                <div class="step-indicator">
                    <div class="step done">
                        <div class="step-circle">✓</div>
                        <div class="step-label">Mobile</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step active">
                        <div class="step-circle">2</div>
                        <div class="step-label">Verify OTP</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step">
                        <div class="step-circle" style="border:1.5px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.4)">3</div>
                        <div class="step-label">Dashboard</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="login-right">

            <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="Logo" class="login-logo">

            <div class="otp-icon-wrap">🔑</div>

            <div class="login-heading">Enter verification code</div>
            <p class="login-sub">6-digit OTP sent to</p>
            <div class="mobile-badge">
                📱 <span id="maskedNumber"><?= htmlspecialchars($masked_mobile) ?></span>
            </div>

            <!-- Error -->
            <div class="error-msg" id="errorAlert">
                <span>⚠️</span>
                <span id="errorText"></span>
            </div>

            <!-- OTP Inputs -->
            <div class="otp-inputs" id="otp">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="first" autocomplete="one-time-code">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="second">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="third">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="fourth">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="fifth">
                <input class="otp-box" type="text" inputmode="numeric" maxlength="1" id="sixth">
            </div>

            <!-- Resend row (UI only — wire the AJAX call to your own resend endpoint if you have one) -->
            <div class="resend-row">
                <span>Didn't receive the code?</span>
                <button class="resend-btn" id="resendBtn" disabled>Resend in <span id="timerCount">30</span>s</button>
            </div>

            <button class="btn-validate" id="validateBtn">
                <div class="spinner" id="btnSpinner"></div>
                <span id="btnText"><i class="bx bx-check-shield"></i> Validate</span>
            </button>

            <div class="back-link">
                <a href="<?= base_url('provider/login') ?>">← Back to login</a>
            </div>

        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const inputs = document.querySelectorAll('.otp-box');
            const validateBtn = document.getElementById('validateBtn');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnText = document.getElementById('btnText');
            const errorAlert = document.getElementById('errorAlert');
            const errorText = document.getElementById('errorText');
            const resendBtn = document.getElementById('resendBtn');
            const timerCount = document.getElementById('timerCount');

            // OTP input navigation
            inputs.forEach(function(input, i) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1);
                    this.classList.toggle('filled', this.value !== '');
                    if (this.value && i < inputs.length - 1) {
                        inputs[i + 1].focus();
                    }
                    checkAllFilled();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        this.value = '';
                        this.classList.remove('filled');
                        if (i > 0) inputs[i - 1].focus();
                        checkAllFilled();
                    }
                    if (e.key === 'ArrowLeft' && i > 0) inputs[i - 1].focus();
                    if (e.key === 'ArrowRight' && i < inputs.length - 1) inputs[i + 1].focus();
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                    paste.split('').slice(0, inputs.length).forEach(function(ch, idx) {
                        if (inputs[idx]) {
                            inputs[idx].value = ch;
                            inputs[idx].classList.add('filled');
                        }
                    });
                    const nextEmpty = [...inputs].findIndex(el => !el.value);
                    (nextEmpty >= 0 ? inputs[nextEmpty] : inputs[inputs.length - 1]).focus();
                    checkAllFilled();
                });
            });

            function checkAllFilled() {
                const allFilled = [...inputs].every(el => el.value !== '');
                validateBtn.disabled = !allFilled;
            }

            checkAllFilled();
            inputs[0].focus();

            function showError(msg) {
                errorText.textContent = msg;
                errorAlert.classList.add('show');
                inputs.forEach(el => el.classList.add('error'));
                setTimeout(() => inputs.forEach(el => el.classList.remove('error')), 400);
            }

            function hideError() {
                errorAlert.classList.remove('show');
            }

            function setLoading(loading) {
                if (loading) {
                    btnSpinner.style.display = 'block';
                    btnText.style.display = 'none';
                    validateBtn.disabled = true;
                } else {
                    btnSpinner.style.display = 'none';
                    btnText.style.display = 'flex';
                    validateBtn.disabled = false;
                }
            }

            validateBtn.addEventListener('click', function() {
                hideError();
                let otp = '';
                inputs.forEach(el => otp += el.value);

                if (otp.length < 6) {
                    showError('Please enter all 6 digits.');
                    return;
                }

                setLoading(true);

                $.ajax({
                    url: "<?= base_url('provider/login/register_verify_otp') ?>",
                    type: "POST",
                    data: {
                        otp: otp
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.redirect_url) {
                            window.location.href = res.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        setLoading(false);
                        try {
                            let err = JSON.parse(xhr.responseText);
                            showError(err.error || 'Invalid OTP. Please try again.');
                        } catch (e) {
                            showError('Unexpected error. Please try again.');
                        }
                        inputs.forEach(el => {
                            el.value = '';
                            el.classList.remove('filled');
                        });
                        inputs[0].focus();
                        checkAllFilled();
                    }
                });
            });

            // Resend countdown timer (UI only — hook this up to your resend
            // endpoint via $.ajax if/when you add one on the backend)
            let seconds = 30;
            const timer = setInterval(function() {
                seconds--;
                timerCount.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(timer);
                    resendBtn.disabled = false;
                    resendBtn.textContent = 'Resend OTP';
                }
            }, 1000);

            resendBtn.addEventListener('click', function() {
                if (this.disabled) return;
                this.disabled = true;
                seconds = 30;
                this.innerHTML = 'Resend in <span id="timerCount">30</span>s';
                const newTimer = setInterval(function() {
                    seconds--;
                    const el = document.getElementById('timerCount');
                    if (el) el.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(newTimer);
                        resendBtn.disabled = false;
                        resendBtn.textContent = 'Resend OTP';
                    }
                }, 1000);

                // TODO: point this at your actual resend-OTP controller method
                // $.ajax({
                //     url: "<?= base_url('provider/login/register_resend_otp') ?>",
                //     type: "POST",
                //     success: function () { hideError(); },
                //     error: function () { showError('Failed to resend OTP. Please try again.'); }
                // });
            });
        });
    </script>
</body>

</html>