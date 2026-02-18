<!--start overlay-->

		 <div class="overlay mobile-toggle-icon"></div>

		<!--end overlay-->

		<!--Start Back To Top Button-->

		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

		<!--End Back To Top Button-->

		<!-- <footer class="page-footer">

			<p class="mb-0">Copyright © 2025. All right reserved.</p>

		</footer> -->

	</div>

	<!--end wrapper-->

    <!-- Bootstrap JS -->

	

	 

	<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>



<!--plugins-->

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<!-- SweetAlert2 CDN -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js');?>"></script>

	<script src="<?= base_url('assets/plugins/apexcharts-bundle/js/apexcharts.min.js');?>"></script>

	<script src="<?= base_url('assets/js/index2.js');?>"></script>





<script>

  const site_url = "<?= base_url() ?>";

</script>

<script src="<?= base_url('assets/js/app.js') ?>"></script>



<script src="<?= base_url('assets/plugins/simplebar/js/simplebar.min.js') ?>"></script>

<script src="<?= base_url('assets/plugins/metismenu/js/metisMenu.min.js') ?>"></script>

<script src="<?= base_url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') ?>"></script>

<script>

  $('#menu').metisMenu(); 

</script>

<!--app JS-->

<script src="<?= base_url('assets/js/index.js') ?>"></script>

<script src="<?= base_url('assets/plugins/peity/jquery.peity.min.js') ?>"></script>



    <script>

       $(".data-attributes span").peity("donut")

	   

    </script>

	<script>

document.addEventListener("DOMContentLoaded", function () {

  var options = {

    chart: {

      type: 'bar',

      height: 250,

      toolbar: { show: false }

    },

    series: [

      {

        name: 'New Customer',

        data: [70, 90, 100, 80, 95, 85, 100, 110, 95]

      },

      {

        name: 'Repeat Customer',

        data: [50, 65, 75, 60, 80, 70, 85, 95, 88]

      },

      {

        name: 'High Value Customer',

        data: [30, 45, 50, 40, 55, 60, 65, 70, 60]

      }

    ],

    xaxis: {

      categories: ['jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','nov','dec']

    },

    colors: ['#0d6efd', '#198754', '#6c757d'],

    legend: {

      position: 'bottom'

    },

    plotOptions: {

      bar: {

        horizontal: false,

        columnWidth: '50%',

        endingShape: 'rounded'

      }

    },

    dataLabels: {

      enabled: false

    },

    grid: {

      strokeDashArray: 4

    }

  };



  var chart = new ApexCharts(document.querySelector("#charts4"), options);

  chart.render();

});

</script>



</body>



</html>