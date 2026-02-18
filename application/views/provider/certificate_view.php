<style>
    
.image-card:hover .delete-icon {
    opacity: 1 !important;
}

.image-card {
    cursor: pointer;
}

.delete-icon {
    z-index: 5;
}

</style>
<div class="page-wrapper">
    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">
                <i class="bi bi-patch-check-fill me-2"></i>CERTIFICATIONS
            </div>

            <!-- Add Certification Button -->
            <div class="ms-auto">
                <button class="btn btn-primary d-flex align-items-center"
                        data-bs-toggle="modal"
                        data-bs-target="#addCertificationModal">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add Certification
                </button>
            </div>
        </div>

        <hr>

        <!-- Image Gallery -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Card Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-secondary mb-0">
                        <i class="bi bi-image-fill me-2"></i>Recent Certification
                    </h5>

                   
                </div>

               <div class="row g-4">

<?php if (isset($certifications) && !empty($certifications)) : ?>

    <?php foreach ($certifications as $row) : ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0 position-relative image-card">

                <a href="<?= base_url($row->image_path); ?>" target="_blank" class="text-decoration-none">
                    <div class="position-relative overflow-hidden rounded-top">
                        <img src="<?= base_url($row->image_path); ?>"
                             class="card-img-top"
                             style="height:200px; object-fit:cover; transition: transform 0.3s ease;"
                             onmouseover="this.style.transform='scale(1.05)'"
                             onmouseout="this.style.transform='scale(1)'">

                       
                    </div>
                </a>
                        <!-- Delete Icon -->

 <div class="position-absolute top-0 end-0 m-2 delete-icon"
                             style="opacity: 0; transition: opacity 0.3s ease;">
                            <button type="button"
        class="btn btn-danger btn-sm rounded-circle shadow delete-cert"
        data-id="<?= $row->id ?>"
        style="width: 36px; height: 36px; padding: 0;">
    <i class="bx bxs-trash" style="     margin-right: 0px;"></i>
</button>

                        </div>
                <div class="card-body p-3 text-center bg-light">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar-check text-muted me-2"></i>
                        <small class="text-muted fw-semibold">
                            <?= date('d M Y', strtotime($row->created_on)); ?>
                        </small>
                    </div>

                    <div class="mt-1 fw-semibold text-dark">
                        <?= htmlspecialchars($row->title); ?>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>

<?php else : ?>

    <!-- Empty State -->
    <div class="col-12">
        <div class="text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted mb-2">No certifications found</h5>
            <p class="text-muted">Upload certifications to showcase your achievements</p>
        </div>
    </div>

<?php endif; ?>

</div>

            </div>
        </div>

    </div>
</div>
<!-- Add Certification Modal -->
<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addCertificationModalLabel">
                    <i class="bi bi-patch-check-fill me-2 text-primary"></i>
                    Add Certification
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
               <form id="certificationForm" enctype="multipart/form-data">
    <!-- <input type="hidden" name="provider_id" value="1"> -->

    <div class="mb-3">
        <label class="form-label fw-semibold">Certificate Title</label>
        <input type="text" class="form-control" name="title" id="title" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Upload Certificate</label>
        <input type="file" class="form-control" name="certificate" id="certificate"
               accept=".jpg,.jpeg,.png,.pdf" required>
    </div>



            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button type="submit" form="certificationForm" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i>Submit
                </button>
            </div>
</form>
        </div>
    </div>
</div>
