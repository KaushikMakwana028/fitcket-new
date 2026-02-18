 <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --input-focus: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* .page-wrapper {
            padding: 20px;
        }

        .breadcrumb-card {
            background: var(--primary-gradient);
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }

        .breadcrumb {
            margin: 0;
            background: none;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
            font-weight: 500;
        } */

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
        }

        .card-header-custom {
            background: var(--primary-gradient);
            padding: 25px 30px;
            border: none;
        }

        .card-title-custom {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-section {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label-custom {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control-custom {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control-custom:focus {
            border-color: #667eea;
            box-shadow: var(--input-focus);
            background: white;
        }

        .form-control-custom[readonly] {
            background: #f3f4f6;
            border-color: #d1d5db;
            color: #6b7280;
        }

        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .wallet-balance-highlight {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .balance-amount {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .info-card {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .invalid-feedback {
            display: block;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 15px;
            }
            
            .card-header-custom,
            .form-section {
                padding: 20px;
            }
            
            .card-title-custom {
                font-size: 1.3rem;
            }
            
            .breadcrumb-card {
                padding: 12px 15px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .form-section {
                padding: 15px;
            }
            
            .btn-primary-custom {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }
    </style>
    <!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="breadcrumb-card d-none d-sm-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/dashboard'); ?>">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Payout Form</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->

        <div class="main-card card">
            <!-- Card Header -->
            <div class="card-header-custom">
                <h5 class="card-title-custom">
                    <i class="fas fa-money-check-alt"></i>
                    Settle Payout
                </h5>
            </div>

            <!-- Card Body -->
            <div class="form-section">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <form id="PayoutForm" method="post" novalidate>
                            
                            <!-- Provider Information Section -->
                            <div class="info-card">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-building me-2"></i>Provider Information
                                </h6>
                                
                                <!-- Provider Name -->
                                <div class="form-group">
                                    <label for="providerName" class="form-label-custom">
                                        <i class="fas fa-user"></i>
                                        Provider Name
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="text" class="form-control form-control-custom" id="providerName"
                                            value="<?= !empty($provider->gym_name) ? $provider->gym_name : 'No data given'; ?>"
                                            readonly>
                                        <i class="fas fa-lock input-icon"></i>
                                    </div>
                                    <input type="hidden" name="provider_id" id="providerId"
                                        value="<?= !empty($provider->id) ? $provider->id : ''; ?>">
                                </div>
                            </div>

                            <!-- Bank Details Section -->
                            <div class="info-card">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-university me-2"></i>Bank Details
                                </h6>
                                
                                <!-- Bank Name -->
                                <div class="form-group">
                                    <label for="bankName" class="form-label-custom">
                                        <i class="fas fa-landmark"></i>
                                        Bank Name
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="text" class="form-control form-control-custom" id="bankName"
                                            value="<?= !empty($bank_details->bank_name) ? $bank_details->bank_name : 'No data given'; ?>"
                                            readonly>
                                        <i class="fas fa-lock input-icon"></i>
                                    </div>
                                </div>

                                <!-- Account Number -->
                                <div class="form-group">
                                    <label for="accountNumber" class="form-label-custom">
                                        <i class="fas fa-credit-card"></i>
                                        Account Number
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="text" class="form-control form-control-custom" id="accountNumber"
                                            value="<?= !empty($bank_details->account_number) ? $bank_details->account_number : 'No data given'; ?>"
                                            readonly>
                                        <i class="fas fa-lock input-icon"></i>
                                    </div>
                                </div>

                                <!-- IFSC Code -->
                                <div class="form-group">
                                    <label for="ifscCode" class="form-label-custom">
                                        <i class="fas fa-code"></i>
                                        IFSC Code
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="text" class="form-control form-control-custom" id="ifscCode"
                                            value="<?= !empty($bank_details->ifsc_code) ? $bank_details->ifsc_code : 'No data given'; ?>"
                                            readonly>
                                        <i class="fas fa-lock input-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Payout Section -->
                            <div class="info-card">
                                <h6 class="text-success mb-3">
                                    <i class="fas fa-wallet me-2"></i>Payout Details
                                </h6>
                                
                                <!-- Wallet Balance -->
                                <div class="wallet-balance-highlight text-center mb-4">
                                    <div class="small text-white-50 mb-1">Available Balance</div>
                                    <div class="balance-amount">
                                        ₹<?= !empty($wallet_belence->balance) ? number_format($wallet_belence->balance, 2) : '0.00'; ?>
                                    </div>
                                </div>

                                <input type="hidden" id="walletBalance" 
                                    value="<?= !empty($wallet_belence->balance) ? $wallet_belence->balance : 'No data given'; ?>">

                                <!-- Payout Amount -->
                                <div class="form-group">
                                    <label for="payoutAmount" class="form-label-custom">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Payout Amount
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="number" name="payout_amount" class="form-control form-control-custom" id="payoutAmount"
                                            placeholder="Enter amount to payout" required min="1" value="<?= !empty($amount->amount) ? $amount->amount : 'No data given'; ?>">
                                        <i class="fas fa-rupee-sign input-icon"></i>
                                    </div>
                                    <div class="invalid-feedback">Please enter a valid payout amount.</div>
                                </div>

                                <!-- Transaction Note -->
                                <div class="form-group">
                                    <label for="transactionNote" class="form-label-custom">
                                        <i class="fas fa-sticky-note"></i>
                                        Transaction Note <span class="text-muted">(optional)</span>
                                    </label>
                                    <textarea name="transaction_note" class="form-control form-control-custom" id="transactionNote"
                                        placeholder="Enter remarks if any" rows="3"></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Settle Payout
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>