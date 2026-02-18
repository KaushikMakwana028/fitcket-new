<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Products</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>"><i class="bx bx-home-alt"></i></a></li>
						<li class="breadcrumb-item active" aria-current="page">Add new Product</li>
					</ol>
				</nav>
			</div>
		</div>
		<!--end breadcrumb-->
		<div class="card">
			<div class="card-body p-4">
				<h5 class="card-title">Add New Product</h5>
				<hr>
				<div class="form-body mt-4">
					<div class="row">
						<div class="col">
							<div class="">
								<form id="productForm" enctype="multipart/form-data" method="post">
									<div class="mb-3">
										<label for="inputProductTitle" class="form-label">Product
											Name</label>
										<input type="text" name="name" class="form-control" id="inputProductTitle" placeholder="Enter product title">
										<div class="invalid-feedback">Please enter product name.</div>
										<input type="hidden" class="form-control" name="store_id" value="1">

									</div>
									<div class="mb-3">
										<label for="inputProductPrice" class="form-label">Product
											Price  </label>
										<input type="number" name="price" class="form-control" id="inputProductPrice" placeholder="Enter product price">
									</div>
                                    <div class="mb-3">
										<label for="inputProductPrice" class="form-label">Product
											MRP  </label>
										<input type="number" name="mrp" class="form-control" id="inputProductPrice" placeholder="Enter product price">
									</div>
									<div class="mb-3">
										<label for="inputProductDescription" class="form-label">Description</label>
										<textarea class="form-control" name="prd_dsc" id="inputProductDescription" rows="3"></textarea>
									</div>
									<div class="mb-3">
										<label for="inputProductDescription" class="form-label">Product
											Images</label>
										<input id="image-uploadify" name="prd_img" type="file" accept="image/*">
										<div class="invalid-feedback">Please select product image.</div>
									</div>
									<div class="mb-3">
										<img id="image-preview" src="" alt="Image Preview" style="max-width: 200px; max-height: 200px; display: none;">
									</div>
									<div class="mb-3">
										<button class="btn btn-primary w-100" id="submit_product_form">Save</button>
									</div>
								</form>

							</div>
						</div>
						
					</div><!--end row-->
				</div>
			</div>
		</div>
	</div>
            </div>