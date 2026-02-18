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

    "handler": function (response){

        // Post to callback controller

        var form = document.createElement('form');

        form.method = 'POST';

        form.action = "<?= base_url('cart/razorpay_callback') ?>";

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
        "ondismiss": function(){
            // 👇 User closed the Razorpay popup without completing payment
            window.location.href = "<?= base_url('cart/view') ?>";
        }
    },

    "prefill": <?= json_encode($prefill) ?>,

    "notes": <?= json_encode($notes) ?>,

    "theme": <?= json_encode($theme) ?>

};

var rzp1 = new Razorpay(options);

rzp1.open();

</script>

