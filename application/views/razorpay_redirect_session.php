<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Payment...</title>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

   
</head>

<body>

<!-- <div class="payment-box">
    <h3>Redirecting to Payment</h3>
    <p>Please wait, do not refresh the page.</p>
    <div class="loader"></div>
</div> -->

<form name="razorpayForm" action="<?= base_url('session_booking/razorpay_callback') ?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    <input type="hidden" name="txnid" value="<?= htmlspecialchars($txnid) ?>">
</form>

<script>
    var options = {
        "key": "<?= $key ?>",
        "amount": "<?= $amount ?>",
        "currency": "INR",
        "name": "<?= addslashes($name) ?>",
        "description": "<?= addslashes($description) ?>",
        "image": "<?= $image ?>",
        "order_id": "<?= $order_id ?>",
        "handler": function (response){
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;
            document.razorpayForm.submit();
        },
        "prefill": {
            "name": "<?= addslashes($prefill['name']) ?>",
            "email": "<?= addslashes($prefill['email']) ?>",
            "contact": "<?= addslashes($prefill['contact']) ?>"
        },
        "theme": {
            "color": "#3399cc"
        },
        "modal": {
            "ondismiss": function () {
                window.location.href = "<?= base_url('session_booking') ?>";
            }
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
</script>

</body>
</html>
