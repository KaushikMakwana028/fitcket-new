<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <!-- <div class="breadcrumb-title pe-3">Enquire</div> -->
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page"> New City</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Add New City</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                         <form id="CityForm" method="post"  novalidate>

                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select id="state" name="state" class="form-control" required>
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select id="city" name="city" class="form-control" required>
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <!-- Submit Button -->
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Save</button>
                                </div>
                        </form>

                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>