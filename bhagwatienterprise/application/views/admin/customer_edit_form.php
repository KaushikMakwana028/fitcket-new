<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Customers</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Customer</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form id="customerForm" method="post"
                                action="<?= base_url('admin/customers/update/' . $customer->id) ?>">
                                <input type="hidden" name="id" value="<?= $customer->id ?>">

                                <div class="mb-3">
                                    <label for="customerName" class="form-label">Customer Name</label>
                                    <input type="text" name="name" class="form-control" id="customerName"
                                        value="<?= htmlspecialchars($customer->full_name) ?>"
                                        placeholder="Enter customer name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="customerPhone" class="form-label">Customer Mobile</label>
                                    <input type="text" name="mobile" class="form-control" id="customerPhone"
                                        value="<?= htmlspecialchars($customer->mobile_number) ?>"
                                        placeholder="Enter mobile number" required>
                                </div>



                                <div class="mb-3">
                                    <label for="customerLocation" class="form-label">Location</label>
                                    <input type="text" name="location" class="form-control" id="customerLocation"
                                        value="<?= htmlspecialchars($customer->location) ?>"
                                        placeholder="Enter location">
                                </div>

                                <div class="mb-3">
                                    <label for="customerTag" class="form-label">Tag</label>
                                    <input type="text" name="tag" class="form-control" id="customerTag"
                                        value="<?= htmlspecialchars($customer->tag) ?>"
                                        placeholder="Enter tag (e.g., high-value)">
                                </div>

                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" id="submit_customer" type="submit">Update
                                        Customer</button>
                                </div>
                            </form>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>