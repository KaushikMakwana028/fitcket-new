<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">eCommerce</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Bookings</li>
					</ol>
				</nav>
			</div>

		</div>


		<div class="card">
			<div class="card-body">
				<div class="d-lg-flex align-items-center mb-4 gap-3">
					<div class="position-relative">
						<input type="text" class="form-control ps-5 radius-30" id="searchCustomer"
							placeholder="Search Order"> <span
							class="position-absolute top-50 product-show translate-middle-y"><i
								class="bx bx-search"></i></span>
					</div>
					<!-- <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i
								class="bx bxs-plus-square"></i>Add New Order</a></div> -->
				</div>
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="table-light">
							<tr>
								<th>Order#</th>
								<th>Customer Name</th>
								<th>Booking Source</th>
								<th>Status</th>
								<th>Date</th>
								<th>View Details</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody id="bookingTableBody">

						</tbody>
					</table>
				</div>
			</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination round-pagination d-flex justify-content-center" id="paginationLinks">

				</ul>
			</nav>
		</div>


	</div>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
	$(document).ready(function () {
    fetchBookings();

    $('#searchCustomer').on('keyup', function () {
        fetchBookings(1, $(this).val());
    });

    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#searchCustomer').val();
        fetchBookings(page, search);
    });

    function fetchBookings(page = 1, search = '') {
        $.ajax({
            url: "<?= base_url('admin/customers/ajax_bookings') ?>",
            method: "GET",
            data: {
                page: page,
                search: search
            },
            dataType: "json",
            success: function (res) {
                $('#bookingTableBody').html(res.table_data);
                $('#paginationLinks').html(res.pagination);
            }
        });
    }
});

</script>