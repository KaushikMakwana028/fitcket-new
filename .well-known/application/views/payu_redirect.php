<!-- application/views/payu_redirect.php -->
<div class="text-center my-5">
    <h4>Redirecting to secure payment gateway...</h4>
    <p>Please do not refresh or press back.</p>
</div>
<form action="<?= $action ?>" method="post" id="payuForm">
<input type="hidden" name="key" value="<?= $key ?>">
    <input type="hidden" name="hash" value="<?= $hash ?>">
    <input type="hidden" name="txnid" value="<?= $txnid ?>">
    <input type="hidden" name="amount" value="<?= $amount ?>">
    <input type="hidden" name="firstname" value="<?= htmlspecialchars($firstname) ?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
    <input type="hidden" name="productinfo" value="<?= $productinfo ?>">
    <input type="hidden" name="surl" value="<?= $surl ?>">
    <input type="hidden" name="furl" value="<?= $furl ?>">
    <input type="hidden" name="service_provider" value="payu_paisa">
</form>
<script>document.getElementById('payuForm').submit();</script>
