<div class="page-wrapper">

	<div class="page-content">

		<!--breadcrumb-->

		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

			<!-- <div class="breadcrumb-title pe-3">Category</div> -->

			<div class="ps-3">

				<nav aria-label="breadcrumb">

					<ol class="breadcrumb mb-0 p-0">

						<li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard'); ?>"><i class="bx bx-home-alt"></i></a>

						</li>

						<li class="breadcrumb-item active" aria-current="page">Payments</li>

					</ol>

				</nav>

			</div>



		</div>

		<!--end breadcrumb-->



		<div class="card">

			<div class="card-body">

				<div class="d-lg-flex align-items-center mb-4 gap-3">

					<div class="position-relative">

						<input type="text" class="form-control ps-5 radius-30" id="paymentSearch" placeholder="Search service"> 
							<span class="position-absolute top-50 product-show translate-middle-y">
							<i class="bx bx-search"></i>
						</span>

					</div>

				</div>

				<div class="table-responsive">

					<table class="table mb-0" id="paymentTableBodyy">

						<thead class="table-light">

							<tr>

								<th>Index</th>
								<th>Partner Name</th>
								<th>Phone</th>
								<th>Amount</th>
								<th>Request Date</th>
								<th>Staus</th>
								<th>Action</th>
							</tr>

						</thead>

						<tbody id="paymentTableBody">



						</tbody>

					</table>

				</div>

			</div>

			<nav aria-label="Page navigation example">

				<ul id="paymentPagination" class="pagination round-pagination justify-content-center">

				</ul>

			</nav>

		</div>





	</div>

</div>

<style>
	.page-link {
		border-radius: 8px;
		margin: 0 4px;
		transition: 0.3s ease;
	}

	.page-item.active .page-link {
		background: linear-gradient(135deg, #4f46e5, #6366f1);
		border: none;
		color: #fff;
	}

	.page-item.disabled .page-link {
		opacity: 0.5;
		pointer-events: none;
	}
</style>
