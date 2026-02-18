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

        <!-- <p class="text-gray-700 mt-2 text-base sm:text-base md:text-lg lg:text-xl">

            Your booking has been confirmed. You can view it anytime in “My Bookings”.

        </p> -->



        <!-- Primary button -->

        <a href="<?php echo base_url('rent_payment'); ?>"
            class="mt-6 px-6 py-3 bg-purple-600 text-white font-medium rounded-lg shadow-lg hover:bg-purple-700 transition text-sm sm:text-base md:text-base lg:text-lg inline-block">

            Go to My Bookings

        </a>
        <!-- <button id="downloadReceipt"
            class="mt-4 px-6 py-3 bg-green-600 text-white font-medium rounded-lg shadow-lg hover:bg-green-700 transition text-sm sm:text-base md:text-lg">
            Download Receipt
        </button> -->



        <!-- Optional secondary link -->

        <a href="<?php echo base_url('services'); ?>"
            class="mt-3 block text-purple-500 hover:underline text-sm sm:text-base md:text-base lg:text-base">

            Continue Browsing

        </a>

    </div>

   



</main>
