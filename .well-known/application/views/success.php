<!-- Your header/nav here -->



<main class="flex-grow flex flex-col items-center justify-center mb-5">

    <!-- Success animation -->

    <lottie-player src="<?= base_url('assets/js/Success.json'); ?>" background="transparent" speed="1"
        style="width: 220px; height: 220px;" autoplay loop>

    </lottie-player>





    <!-- Flash success message -->

    <?php if ($this->session->flashdata('success')): ?>

        <h2 class="text-2xl font-bold text-green-600">

            <?php echo $this->session->flashdata('success'); ?>

        </h2>

    <?php else: ?>

        <h2 class="text-2xl font-bold text-green-600">Payment Successful!</h2>

    <?php endif; ?>



    <div class="max-w-lg mx-auto p-4 sm:p-6 md:p-8 text-center">

        <!-- Message -->

        <p class="text-gray-700 mt-2 text-base sm:text-base md:text-lg lg:text-xl">

            Your booking has been confirmed. You can view it anytime in “My Bookings”.

        </p>



        <!-- Primary button -->

        <a href="<?php echo base_url('profile'); ?>"
            class="mt-6 px-6 py-3 bg-purple-600 text-white font-medium rounded-lg shadow-lg hover:bg-purple-700 transition text-sm sm:text-base md:text-base lg:text-lg inline-block">

            Go to My Bookings

        </a>
        <button id="downloadReceipt"
            class="mt-4 px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-lg hover:bg-green-700 transition text-sm sm:text-base md:text-lg">
            Download Receipt
        </button>



        <!-- Optional secondary link -->

        <a href="<?php echo base_url('services'); ?>"
            class="mt-3 block text-purple-500 hover:underline text-sm sm:text-base md:text-base lg:text-base">

            Continue Browsing

        </a>

    </div>

    <!-- Hidden Receipt Template -->
    <div id="receiptContent" class="hidden">
        <div
            style="max-width:700px;margin:auto;padding:20px;font-family:Arial, sans-serif;color:#333;background:#fff;border:1px solid #ddd;border-radius:10px;">
            <!-- Logo -->
            <div style="text-align:center;margin-bottom:20px;">
                <img src="<?= base_url('assets/images/logo_ficat.png'); ?>" alt="Company Logo"
                    style="max-height:100px;">
            </div>

            <!-- Title -->
            <h1 style="text-align:center;color:#1a73e8;margin-bottom:20px;">Booking Receipt</h1>

            <!-- Customer Info -->
            <div style="margin-bottom:20px;">
                <p><strong>Booking ID:</strong> <?= $order['txnid']; ?></p>
                <p><strong>Date:</strong> <?= date("d M Y", strtotime($order['created_at'])); ?></p>
                <p><strong>Customer:</strong> <?= $user['name']; ?> (<?= $user['email']; ?>)</p>
            </div>

            <!-- Items Table -->
            <!-- Items Table -->
           <!-- Items Table -->
<table style="width:100%;border-collapse:collapse;margin-bottom:20px;">
    <thead>
        <tr style="background:#1a73e8;color:#fff;">
            <th style="padding:10px;border:1px solid #ddd;">Gym Name</th>
            <th style="padding:10px;border:1px solid #ddd;">Price</th>
            <th style="padding:10px;border:1px solid #ddd;">Qty</th>
            <th style="padding:10px;border:1px solid #ddd;">Free Qty</th>
            <th style="padding:10px;border:1px solid #ddd;">Duration</th>
            <th style="padding:10px;border:1px solid #ddd;">Start Date</th>
            <th style="padding:10px;border:1px solid #ddd;">End Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <?php
            $start = new DateTime($item['start_date']);
            $end   = clone $start;

            // Total quantity includes free items for date calculation
            $total_qty = (int)$item['qty'] + (int)($item['free_qty'] ?? 0);

            // Calculate end date based on total quantity
            switch ($item['duration']) {
                case 'day':
                    $end->modify('+' . $total_qty . ' day');
                    break;
                case 'week':
                    $end->modify('+' . $total_qty . ' week');
                    break;
                case 'month':
                    $end->modify('+' . $total_qty . ' month');
                    break;
                case 'year':
                    $end->modify('+' . $total_qty . ' year');
                    break;
            }
            ?>
            <tr>
                <td style="padding:10px;border:1px solid #ddd;"><?= $item['name']; ?></td>
                <td style="padding:10px;border:1px solid #ddd;">₹<?= number_format($item['price'], 2); ?></td>
                <td style="padding:10px;border:1px solid #ddd;"><?= $item['qty']; ?></td>
                <td style="padding:10px;border:1px solid #ddd;"><?= $item['free_qty'] ?? 0; ?></td>
                <td style="padding:10px;border:1px solid #ddd;"><?= $item['duration']; ?></td>
                <td style="padding:10px;border:1px solid #ddd;"><?= date("d M Y", strtotime($item['start_date'])); ?></td>
                <td style="padding:10px;border:1px solid #ddd;"><?= $end->format("d M Y"); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



            <!-- Total -->
            <h2 style="text-align:right;color:#1a73e8;">Grand Total: ₹<?= number_format($order['total'], 2); ?></h2>

            <!-- Footer -->
            <p style="text-align:center;margin-top:30px;font-size:12px;color:#777;">
                Thank you for booking with us!<br>
                Visit <strong>fitcket.com</strong> for more services.
            </p>
        </div>
    </div>



</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.getElementById("downloadReceipt").addEventListener("click", function () {
    const receiptContent = document.getElementById("receiptContent").innerHTML;

    // Create an iframe
    const iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = '0';
    document.body.appendChild(iframe);

    const doc = iframe.contentWindow.document;
    doc.open();
    doc.write('<html><head><title>Booking Receipt</title>');
    doc.write('<style>body{font-family:Arial,sans-serif;color:#333;margin:20px;}');
    doc.write('table{border-collapse:collapse;width:100%;} th, td{padding:10px;border:1px solid #ddd;text-align:left;}');
    doc.write('th{background:#1a73e8;color:#fff;}</style></head><body>');
    doc.write(receiptContent);
    doc.write('</body></html>');
    doc.close();

    iframe.contentWindow.focus();
    iframe.contentWindow.print();

    // Remove iframe after print
    setTimeout(() => { document.body.removeChild(iframe); }, 1000);
});

</script>