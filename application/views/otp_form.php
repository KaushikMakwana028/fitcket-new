<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url('assets/images/dumbbell_8729453.png') ?>" type="image/png">

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Boxicons -->
    <link href="<?= base_url('assets/css/icons.css') ?>" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Verify OTP — FITCKET</title>

    <style>
        /* ---- Reset & Base ---- */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-1: #0f172a;
            --text-2: #64748b;
            --text-3: #94a3b8;
            --bg-page: #f1f5f9;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --r-md: 10px;
            --r-lg: 16px;
            --r-xl: 22px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-page);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ---- Background decoration ---- */
        .bg-blobs {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bg-blobs span {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.18;
        }

        .bg-blobs span:nth-child(1) {
            width: 500px;
            height: 500px;
            background: #6366f1;
            top: -120px;
            left: -120px;
        }

        .bg-blobs span:nth-child(2) {
            width: 400px;
            height: 400px;
            background: #8b5cf6;
            bottom: -100px;
            right: -80px;
        }

        .bg-blobs span:nth-child(3) {
            width: 300px;
            height: 300px;
            background: #3b82f6;
            top: 40%;
            left: 60%;
        }

        /* ---- Card ---- */
        .otp-card {
            position: relative;
            z-index: 1;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.09);
            padding: 2.75rem 2.25rem 2.25rem;
            width: 100%;
            max-width: 430px;
            text-align: center;
        }

        /* ---- Icon ring ---- */
        .icon-ring {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(139, 92, 246, 0.12));
            border: 1px solid rgba(99, 102, 241, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .icon-ring i {
            font-size: 32px;
            color: var(--primary);
        }

        /* ---- Headings ---- */
        .otp-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-1);
            margin-bottom: 6px;
        }

        .otp-sub {
            font-size: 0.83rem;
            color: var(--text-2);
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }

        .otp-sub .phone-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(99, 102, 241, 0.08);
            color: var(--primary);
            border: 1px solid rgba(99, 102, 241, 0.18);
            border-radius: 50px;
            padding: 2px 12px;
            font-size: 0.82rem;
            font-weight: 500;
        }

        /* ---- Progress dots ---- */
        .progress-dots {
            display: flex;
            gap: 7px;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .progress-dots span {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--border);
            transition: background 0.2s, transform 0.2s;
        }

        .progress-dots span.active {
            background: var(--primary);
            transform: scale(1.2);
        }

        /* ---- OTP Inputs ---- */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 1.75rem;
        }

        .otp-inputs input {
            width: 50px;
            height: 58px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0;
            font-family: 'Poppins', monospace;
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: var(--r-md);
            color: var(--text-1);
            outline: none;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
            -moz-appearance: textfield;
            caret-color: var(--primary);
        }

        .otp-inputs input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.13);
        }

        .otp-inputs input.filled {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.05);
            color: var(--primary);
        }

        .otp-inputs input.error {
            border-color: var(--danger) !important;
            background: rgba(239, 68, 68, 0.05) !important;
        }

        .otp-inputs input.shake {
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

            60% {
                transform: translateX(5px);
            }

            80% {
                transform: translateX(-3px);
            }
        }

        /* ---- Alert ---- */
        .otp-alert {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 12px 15px;
            border-radius: var(--r-md);
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            text-align: left;
            border-left: 3px solid;
            animation: fadeSlide 0.3s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .otp-alert i {
            font-size: 18px;
            flex-shrink: 0;
        }

        .otp-alert .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            opacity: 0.5;
            line-height: 1;
            padding: 0;
        }

        .otp-alert .close-btn:hover {
            opacity: 1;
        }

        .otp-alert .close-btn i {
            font-size: 15px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.07);
            border-color: var(--danger);
            color: #7f1d1d;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.07);
            border-color: var(--success);
            color: #065f46;
        }

        /* ---- Button ---- */
        .otp-btn {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            border-radius: var(--r-md);
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.12s;
        }

        .otp-btn:hover {
            opacity: 0.9;
        }

        .otp-btn:active {
            transform: scale(0.98);
        }

        .otp-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }

        .otp-btn i {
            font-size: 18px;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ---- Resend ---- */
        .resend-row {
            margin-top: 1.25rem;
            font-size: 0.8rem;
            color: var(--text-2);
        }

        .resend-row button {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .resend-row button:disabled {
            color: var(--text-3);
            cursor: default;
        }

        /* ---- Divider ---- */
        .otp-divider {
            height: 1px;
            background: var(--border);
            margin: 1.5rem 0 1.25rem;
        }

        .otp-footer {
            font-size: 0.75rem;
            color: var(--text-3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .otp-footer i {
            font-size: 14px;
        }

        /* ---- Responsive ---- */
        @media (max-width: 480px) {
            .otp-card {
                padding: 2rem 1.25rem 1.5rem;
            }

            .otp-inputs input {
                width: 42px;
                height: 50px;
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>

    <div class="bg-blobs">
        <span></span><span></span><span></span>
    </div>

    <div class="otp-card">

        <!-- Icon -->
        <div class="icon-ring">
            <i class="bx bx-mobile-alt"></i>
        </div>

        <!-- Heading -->
        <h1 class="otp-title">Verify your number</h1>
        <p class="otp-sub">
            We sent a 6-digit code to<br>
            <span class="phone-badge">
                <i class="bx bx-phone"></i>
                <?= $masked_mobile ?>
            </span>
        </p>

        <!-- Alert box -->
        <div id="alertBox" style="display:none;"></div>

        <!-- Progress dots -->
        <div class="progress-dots" id="dots">
            <span></span><span></span><span></span>
            <span></span><span></span><span></span>
        </div>

        <!-- OTP Inputs -->
        <div class="otp-inputs" id="otpInputs">
            <input type="text" inputmode="numeric" maxlength="1" autocomplete="one-time-code" aria-label="OTP digit 1">
            <input type="text" inputmode="numeric" maxlength="1" aria-label="OTP digit 2">
            <input type="text" inputmode="numeric" maxlength="1" aria-label="OTP digit 3">
            <input type="text" inputmode="numeric" maxlength="1" aria-label="OTP digit 4">
            <input type="text" inputmode="numeric" maxlength="1" aria-label="OTP digit 5">
            <input type="text" inputmode="numeric" maxlength="1" aria-label="OTP digit 6">
        </div>

        <!-- Validate Button -->
        <button class="otp-btn" id="validateBtn">
            <i class="bx bx-shield-quarter"></i>
            Verify code
        </button>

        <!-- Resend -->
        <div class="resend-row">
            Didn't receive it?&nbsp;
            <button id="resendBtn" disabled>Resend</button>
            <span id="timerLabel">in <strong id="countdown">30</strong>s</span>
        </div>

        <!-- Footer -->
        <div class="otp-divider"></div>
        <div class="otp-footer">
            <i class="bx bx-lock-alt"></i>
            Secured with end-to-end encryption
        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const inputs = document.querySelectorAll('#otpInputs input');
            const btn = document.getElementById('validateBtn');
            const alertBox = document.getElementById('alertBox');
            const dots = document.querySelectorAll('#dots span');
            const resendBtn = document.getElementById('resendBtn');
            const timerLabel = document.getElementById('timerLabel');
            const countdown = document.getElementById('countdown');

            /* ---- Helpers ---- */
            function updateDots() {
                inputs.forEach(function(inp, i) {
                    dots[i].classList.toggle('active', inp.value !== '');
                });
            }

            function showAlert(type, icon, msg) {
                alertBox.innerHTML =
                    '<div class="otp-alert alert-' + type + '">' +
                    '<i class="bx ' + icon + '"></i>' +
                    '<span>' + msg + '</span>' +
                    '<button class="close-btn" onclick="document.getElementById(\'alertBox\').style.display=\'none\'">' +
                    '<i class="bx bx-x"></i>' +
                    '</button>' +
                    '</div>';
                alertBox.style.display = 'block';
            }

            function clearAlert() {
                alertBox.style.display = 'none';
                alertBox.innerHTML = '';
            }

            function resetInputStyles() {
                inputs.forEach(function(inp) {
                    inp.classList.remove('error', 'filled');
                    inp.style.borderColor = '';
                    inp.style.color = '';
                });
            }

            /* ---- OTP Input Behaviour ---- */
            inputs.forEach(function(inp, i) {

                inp.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(-1);
                    this.classList.toggle('filled', this.value !== '');
                    updateDots();
                    clearAlert();
                    if (this.value && i < inputs.length - 1) inputs[i + 1].focus();
                });

                inp.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        this.value = '';
                        this.classList.remove('filled', 'error');
                        updateDots();
                        if (i > 0) inputs[i - 1].focus();
                    }
                    if (e.key === 'ArrowLeft' && i > 0) inputs[i - 1].focus();
                    if (e.key === 'ArrowRight' && i < inputs.length - 1) inputs[i + 1].focus();
                });

                inp.addEventListener('paste', function(e) {
                    e.preventDefault();
                    var text = (e.clipboardData || window.clipboardData)
                        .getData('text').replace(/\D/g, '');
                    if (!text) return;
                    text.split('').slice(0, 6).forEach(function(ch, j) {
                        if (inputs[j]) {
                            inputs[j].value = ch;
                            inputs[j].classList.add('filled');
                        }
                    });
                    updateDots();
                    inputs[Math.min(text.length, 5)].focus();
                });

                inp.addEventListener('focus', function() {
                    this.select();
                });
            });

            /* ---- Validate ---- */
            btn.addEventListener('click', function() {
                clearAlert();
                var otp = Array.from(inputs).map(function(i) {
                    return i.value;
                }).join('');

                if (otp.length < 6) {
                    inputs.forEach(function(inp) {
                        if (!inp.value) {
                            inp.classList.add('shake', 'error');
                        }
                    });
                    setTimeout(function() {
                        inputs.forEach(function(inp) {
                            inp.classList.remove('shake');
                        });
                    }, 400);
                    showAlert('error', 'bx-error-circle', 'Please enter all 6 digits.');
                    return;
                }

                btn.innerHTML = '<div class="spinner"></div>';
                btn.disabled = true;

                $.ajax({
                    url: "<?= base_url('login/verify_otp') ?>",
                    type: 'POST',
                    data: {
                        otp: otp
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.redirect_url) {
                            btn.innerHTML = '<i class="bx bx-check-circle"></i> Verified!';
                            inputs.forEach(function(inp) {
                                inp.style.borderColor = '#10b981';
                                inp.style.color = '#10b981';
                            });
                            showAlert('success', 'bx-check-shield', 'Verified! Redirecting you now…');
                            setTimeout(function() {
                                window.location.href = res.redirect_url;
                            }, 800);
                        }
                    },
                    error: function(xhr) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bx bx-shield-quarter"></i> Verify code';
                        inputs.forEach(function(inp) {
                            inp.value = '';
                            inp.classList.remove('filled');
                            inp.classList.add('error');
                        });
                        updateDots();
                        inputs[0].focus();
                        try {
                            var err = JSON.parse(xhr.responseText);
                            showAlert('error', 'bx-error-circle', err.error || 'Invalid OTP. Please try again.');
                        } catch (e) {
                            showAlert('error', 'bx-error-circle', 'Something went wrong. Please try again.');
                        }
                        setTimeout(function() {
                            resetInputStyles();
                        }, 1800);
                    }
                });
            });

            /* ---- Resend Timer ---- */
            var seconds = 30;
            var timer = null;

            function startTimer() {
                clearInterval(timer);
                seconds = 30;
                countdown.textContent = 30;
                timerLabel.style.display = '';
                resendBtn.disabled = true;

                timer = setInterval(function() {
                    seconds--;
                    countdown.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(timer);
                        timerLabel.style.display = 'none';
                        resendBtn.disabled = false;
                    }
                }, 1000);
            }

            startTimer();

            resendBtn.addEventListener('click', function() {
                clearAlert();
                inputs.forEach(function(inp) {
                    inp.value = '';
                    inp.classList.remove('filled', 'error');
                });
                updateDots();
                inputs[0].focus();
                resetInputStyles();
                startTimer();
                showAlert('success', 'bx-send', 'OTP resent to your number.');

                /* Optionally call a resend endpoint: */
                /* $.post("<?= base_url('login/resend_otp') ?>"); */
            });

            /* Focus first input on load */
            inputs[0].focus();
        });
    </script>

</body>

</html>