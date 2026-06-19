<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url(''); ?>" type="image/png">
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
            opacity: 1;
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

        .left-features {
            list-style: none;
            text-align: left;
            display: inline-block;
        }

        .left-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.80);
            padding: 5px 0;
        }

        .feat-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ffc107;
            flex-shrink: 0;
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
            margin-bottom: 28px;
        }

        .store-name-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff3ff;
            color: #3d52d5;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12.5px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 6px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #8590a0;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .input-prefix span {
            color: #bbb;
            font-size: 13px;
        }

        .form-control-custom {
            width: 100%;
            height: 46px;
            border: 1.5px solid #e4e8f0;
            border-radius: 10px;
            padding: 0 14px 0 90px;
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            color: #1a1a2e;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fafbff;
        }

        .form-control-custom:focus {
            border-color: #3d52d5;
            box-shadow: 0 0 0 3px rgba(61, 82, 213, 0.10);
            background: #fff;
        }

        .form-control-custom::placeholder {
            color: #c0c7d4;
        }

        .btn-send-otp {
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

        .btn-send-otp:hover {
            background: #283593;
            box-shadow: 0 6px 20px rgba(26, 35, 126, 0.28);
            transform: translateY(-1px);
        }

        .btn-send-otp:active {
            transform: translateY(0);
        }

        .signup-hint {
            text-align: center;
            font-size: 13px;
            color: #8590a0;
        }

        .signup-hint a {
            color: #3d52d5;
            font-weight: 500;
            text-decoration: none;
        }

        .signup-hint a:hover {
            text-decoration: underline;
        }

        /* ALERTS */
        .alert-custom {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 18px;
        }

        .alert-custom.success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-custom.danger {
            background: #fdecea;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .alert-custom .alert-icon {
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-custom .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: inherit;
            opacity: 0.6;
            flex-shrink: 0;
            padding: 0;
            line-height: 1;
        }

        /* RESPONSIVE */
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
                box-shadow: 0 12px 40px rgba(30, 40, 100, 0.14);
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- LEFT DECORATIVE PANEL -->
        <div class="login-left">
            <div class="left-content">
                <div class="brand-icon">🏪</div>
                <div class="left-title">Welcome Back</div>
                <p class="left-subtitle">Manage your store, track sales and serve customers better.</p>
                <ul class="left-features">
                    <li><span class="feat-dot"></span> Real-time sales dashboard</li>
                    <li><span class="feat-dot"></span> Inventory management</li>
                    <li><span class="feat-dot"></span> Customer & billing tools</li>
                    <li><span class="feat-dot"></span> Secure OTP login</li>
                </ul>
            </div>
        </div>

        <!-- RIGHT FORM PANEL -->
        <div class="login-right">

            <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="Logo" class="login-logo">

            <?php if (isset($user_data['store_name']) && $user_data['store_name']): ?>
                <div class="store-name-badge">
                    🏬 <?= htmlspecialchars($user_data['store_name']) ?>
                </div>
            <?php endif; ?>

            <div class="login-heading">Sign in to your account</div>
            <p class="login-sub">Enter your mobile number to receive an OTP</p>

            <!-- Success Alert -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert-custom success" id="alert-success">
                    <span class="alert-icon">✅</span>
                    <span><?= $this->session->flashdata('success'); ?></span>
                    <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
                </div>
            <?php endif; ?>

            <!-- Error Alert -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert-custom danger" id="alert-error">
                    <span class="alert-icon">⚠️</span>
                    <span><?= $this->session->flashdata('error'); ?></span>
                    <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('provider/login/send_otp') ?>" method="post">

                <label class="form-label" for="inputMobile">Mobile Number</label>
                <div class="input-group-custom">
                    <span class="input-prefix">
                        <i class="bx bx-mobile-alt"></i>
                        <span>+91 |</span>
                    </span>
                    <input
                        type="tel"
                        class="form-control-custom"
                        id="inputMobile"
                        name="mobile"
                        placeholder="98765 43210"
                        maxlength="10"
                        pattern="[6-9][0-9]{9}"
                        inputmode="numeric"
                        required>
                </div>

                <button type="submit" class="btn-send-otp">
                    <i class="bx bx-send"></i> Send OTP
                </button>

            </form>

            <p class="signup-hint">Don't have an account? <a href="<?= base_url('provider/sing_up'); ?>">Sign up here</a></p>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js'); ?>"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ['alert-success', 'alert-error'].forEach(function(id) {
                var el = document.getElementById(id);
                if (!el) return;
                setTimeout(function() {
                    el.style.transition = "opacity 0.5s ease";
                    el.style.opacity = 0;
                    setTimeout(function() {
                        el.remove();
                    }, 500);
                }, 3000);
            });

            // Allow only digits in mobile field
            var mobileInput = document.getElementById('inputMobile');
            if (mobileInput) {
                mobileInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 10);
                });
            }
        });
    </script>
</body>

</html>