<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    var options = {
        "key": "<?= $key ?>", // Razorpay key id
        "amount": "<?= $amount ?>", // Amount in paise
        "currency": "INR",
        "name": "<?= $name ?>",
        "description": "<?= $description ?>",
        "image": "<?= $image ?>",
        "order_id": "<?= $order_id ?>", // Razorpay Order ID
        "handler": function (response){
            // Create form to send back response
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?= base_url('rent_payment/razorpay_callback') ?>";

            form.innerHTML = `
                <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
                <input type="hidden" name="txnid" value="<?= $txnid ?>">
            `;

            document.body.appendChild(form);
            form.submit();
        },
        "prefill": <?= json_encode($prefill) ?>,
        "notes": <?= json_encode($notes) ?>,
        "theme": <?= json_encode($theme) ?>
    };

    var rzp1 = new Razorpay(options);

    window.onload = function(){
        rzp1.open();
    };
</script>
