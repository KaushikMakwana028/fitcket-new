
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Package</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Package</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Package</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                           <form id="packageForm" method="post" action="">
    <div class="mb-3">
        <label for="cust_name" class="form-label">Package Name</label>
        <input type="text" name="name" class="form-control" id="cust_name"
               placeholder="Enter Package name" value="<?= htmlspecialchars($package->name); ?>" required>
    </div>

    <div class="mb-3">
        <label for="mob" class="form-label">Price (INR)</label>
        <input type="text" name="price" class="form-control" id="mob"
               placeholder="Enter Price (INR)" value="<?= htmlspecialchars($package->price); ?>" required>
    </div>

    <div class="mb-3">
        <label for="inclusions" class="form-label">Inclusions</label>
        <textarea name="inclusions" class="form-control" id="inclusions" rows="4"
                  required><?= htmlspecialchars($package->inclusion); ?></textarea>
    </div>

    <div class="mb-3">
        <button class="btn btn-success w-100" id="update_package" type="submit">
            Update Package
        </button>
    </div>
</form>

                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>