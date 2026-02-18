<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Customers</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>"><i class="bx bx-home-alt"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Add New Customer</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body p-4">
				<h5 class="card-title">Add New Customer</h5>
				<hr>
				<div class="form-body mt-4">
					<div class="row">
						<div class="col">
							<form id="customerForm" method="post">
								<div class="mb-3">
									<label for="customerName" class="form-label">Customer Name</label>
									<input type="text" name="name" class="form-control" id="customerName" placeholder="Enter customer name" required>
								</div>
                                
								<div class="mb-3">
									<label for="customerPhone" class="form-label">Customer Mobile</label>
									<input type="text" name="mobile" class="form-control" id="customerPhone" placeholder="Enter mobile number" required>
								</div>
								<div class="mb-3">
									<label for="customerLocation" class="form-label">Total spent</label>
									<input type="text" name="total"  class="form-control" id="totalspent" placeholder="Enter totoal spent" required>
								</div>
								
								<div class="mb-3">
									<button class="btn btn-primary w-100" id="submit_customer" type="submit">Save Customer</button>
								</div>
							</form>
						</div>
					</div><!--end row-->
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
