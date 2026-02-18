<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard'); ?>">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit City</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit City</h5>
                <hr>
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col">
                            <form id="EditCityForm" method="post">
                                <input type="hidden" id="city_id" name="city_id" value="<?= $city->id; ?>">

                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select id="edit_state" name="state" class="form-control" required>
                                        <option value="<?= $city->state ?>" selected><?= $city->state ?></option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select id="edit_city" name="city" class="form-control" required>
                                        <option value="<?= $city->city ?>" selected><?= $city->city ?></option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                </div>
                            </form>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
</div>
