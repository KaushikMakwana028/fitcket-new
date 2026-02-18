<main class="flex-grow flex flex-col items-center justify-center mb-5">

    <!-- Success Animation -->
    <lottie-player
        src="<?= base_url('assets/js/Success.json'); ?>"
        background="transparent"
        speed="1"
        style="width:220px;height:220px;"
        autoplay loop>
    </lottie-player>

    <h2 class="text-2xl font-bold text-green-600">
        Session Booked Successfully!
    </h2>

    <div class="max-w-lg mx-auto p-6 text-center">

        <p class="text-gray-700 mt-2 text-lg">
            Your session has been confirmed. You can join it at the scheduled time.
        </p>

        <!-- Primary -->
        <a href="<?= base_url('profile'); ?>"
           class="mt-6 px-6 py-3 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 inline-block">
            Go to My Sessions
        </a>

        <!-- Download Receipt -->
        <button id="downloadReceipt"
            class="mt-4 px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
            Download Receipt
        </button>

        <a href="<?= base_url('session_booking'); ?>"
           class="mt-3 block text-purple-500 hover:underline">
            Browse More Sessions
        </a>
    </div>

    <!-- RECEIPT -->
    <div id="receiptContent" class="hidden">
        <div style="max-width:700px;margin:auto;padding:20px;font-family:Arial;border:1px solid #ddd;border-radius:10px;">
            
            <div style="text-align:center;margin-bottom:20px;">
                <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" style="max-height:90px;">
            </div>

            <h1 style="text-align:center;color:#1a73e8;">Session Booking Receipt</h1>

            <p><strong>Booking ID:</strong> <?= $order['txnid']; ?></p>
            <p><strong>Date:</strong> <?= date('d M Y', strtotime($order['created_at'])); ?></p>
            <p><strong>User:</strong> <?= $user['name']; ?> (<?= $user['email']; ?>)</p>

            <table style="width:100%;border-collapse:collapse;margin-top:20px;">
                <thead>
                    <tr style="background:#1a73e8;color:#fff;">
                        <th style="padding:10px;border:1px solid #ddd;">Session</th>
                        <th style="padding:10px;border:1px solid #ddd;">Provider</th>
                        <th style="padding:10px;border:1px solid #ddd;">Date</th>
                        <th style="padding:10px;border:1px solid #ddd;">Time</th>
                        <th style="padding:10px;border:1px solid #ddd;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:10px;border:1px solid #ddd;">
                            <?= htmlspecialchars($session['title']); ?>
                        </td>
                        <td style="padding:10px;border:1px solid #ddd;">
                            <?= htmlspecialchars($session['gym_name']); ?>
                        </td>
                        <td style="padding:10px;border:1px solid #ddd;">
                            <?= date('d M Y', strtotime($session['session_date'])); ?>
                        </td>
                        <td style="padding:10px;border:1px solid #ddd;">
                            <?= date('h:i A', strtotime($session['start_time'])); ?>
                        </td>
                        <td style="padding:10px;border:1px solid #ddd;">
                            ₹<?= number_format($order['amount'], 2); ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 style="text-align:right;color:#1a73e8;margin-top:20px;">
                Total Paid: ₹<?= number_format($order['amount'], 2); ?>
            </h2>

            <p style="text-align:center;font-size:12px;color:#777;margin-top:30px;">
                Thank you for booking with <strong>fitcket.com</strong>
            </p>
        </div>
    </div>

</main>
<script>
document.getElementById("downloadReceipt").addEventListener("click", function () {
    const content = document.getElementById("receiptContent").innerHTML;

    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    document.body.appendChild(iframe);

    const doc = iframe.contentWindow.document;
    doc.open();
    doc.write('<html><head><title>Session Receipt</title></head><body>');
    doc.write(content);
    doc.write('</body></html>');
    doc.close();

    iframe.contentWindow.print();

    setTimeout(() => document.body.removeChild(iframe), 1000);
});
</script>
