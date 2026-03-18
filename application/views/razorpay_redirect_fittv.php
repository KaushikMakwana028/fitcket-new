<style>
    .fittv-payment-launch {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
    }

    .fittv-payment-card {
        width: 100%;
        max-width: 520px;
        padding: 34px 28px;
        text-align: center;
        background: #fff;
        border: 1px solid #dbeafe;
        border-radius: 28px;
        box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08);
    }

    .fittv-payment-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #dbeafe, #fee2e2);
    }

    .fittv-payment-icon svg {
        width: 30px;
        height: 30px;
        stroke: #1d4ed8;
    }

    .fittv-payment-card h2 {
        margin: 0 0 10px;
        color: #0f172a;
        font-size: 1.6rem;
        font-weight: 800;
    }

    .fittv-payment-card p {
        margin: 0;
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .fittv-payment-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 24px;
    }

    .fittv-payment-btn,
    .fittv-payment-btn:focus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px 18px;
        border: 0;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .fittv-payment-btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #ef4444, #2563eb);
    }

    .fittv-payment-btn-secondary {
        color: #334155;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
    }

    .fittv-payment-help {
        margin-top: 12px;
        font-size: 0.84rem;
        color: #94a3b8;
    }
</style>

<div class="fittv-payment-launch">
    <div class="fittv-payment-card">
        <div class="fittv-payment-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
        </div>
        <h2>Opening secure payment</h2>
        <p>
            We are launching Razorpay for your FITTV access payment. If the checkout window does not open automatically,
            use the button below.
        </p>

        <div class="fittv-payment-actions">
            <button type="button" class="fittv-payment-btn fittv-payment-btn-primary" id="openFittvPayment">
                Open Secure Payment
            </button>
            <a href="<?= base_url('fittv') ?>" class="fittv-payment-btn fittv-payment-btn-secondary">Back to FITTV</a>
        </div>

        <div class="fittv-payment-help">Amount: &#8377;<?= number_format(((float) $amount) / 100, 2) ?></div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "<?= $key ?>",
        "amount": "<?= $amount ?>",
        "currency": "INR",
        "name": "<?= $name ?>",
        "description": "<?= $description ?>",
        "image": "<?= $image ?>",
        "order_id": "<?= $order_id ?>",
        "handler": function(response) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= base_url('fittv/razorpay_callback') ?>";
            form.innerHTML = `
                <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
                <input type="hidden" name="txnid" value="<?= $txnid ?>">
            `;
            document.body.appendChild(form);
            form.submit();
        },
        "modal": {
            "ondismiss": function() {
                window.location.href = "<?= base_url('fittv/payment_cancel/' . rawurlencode($txnid)) ?>";
            }
        },
        "prefill": <?= json_encode($prefill) ?>,
        "notes": <?= json_encode($notes) ?>,
        "theme": <?= json_encode($theme) ?>
    };

    var rzpFittv = new Razorpay(options);
    var openPayment = function() {
        rzpFittv.open();
    };

    document.getElementById('openFittvPayment').addEventListener('click', openPayment);
    window.addEventListener('load', function() {
        setTimeout(openPayment, 150);
    });
</script>
