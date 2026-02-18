<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Review</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Review</li>
                    </ol>
                </nav>
            </div>
            <!-- <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                            href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                            link</a>
                    </div>
                </div>
            </div> -->
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span
                            class="position-absolute top-50 product-show translate-middle-y"><i
                                class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Index#</th>
                                <th>Name</th>
                                <th>Sentiment</th>
                                <th>Platform</th>
                                <th>Status</th>
                                <th>Review</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination round-pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="javascript:;">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="javascript:;javascript:;">1</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="javascript:;">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="javascript:;">3</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="javascript:;">Next</a>
                    </li>
                </ul>
            </nav>
        </div>


    </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
    let currentPage = 1;
    let searchTerm = '';

    function loadReviews(page = 1, search = '') {
        $.ajax({
            url: "<?= base_url('admin/review/ajax_reviews') ?>",
            method: "GET",
            data: { page, search },
            dataType: "json",
            success: function (res) {
                const tbody = $('tbody').empty();
                if (res.reviews.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No reviews found</td></tr>');
                } else {
                    $.each(res.reviews, function (index, review) {
                        tbody.append(`
                        <tr>
                            <td>${index + 1 + ((page - 1) * 5)}</td>
                            <td>${review.customer_name}</td>
                            <td>
  ${review.sentiment === 'negative'
                                ? `<div class="d-flex align-items-center text-danger">
         <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
         <span>${review.sentiment}</span>
       </div>`
                                : `<div class="d-flex align-items-center text-success">
         <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
         <span>${review.sentiment || '-'}</span>
       </div>`
                            }
</td>
                <td>${review.platform}</td>
                            <td>
  ${review.status === 'pending'
                                ? `<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
           <i class="bx bxs-circle me-1"></i>Pending
         </div>`
                                : `<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
           <i class="bx bxs-circle me-1"></i>Responded
         </div>`
                            }
</td>
                                                        <td>${review.review_text}</td>

                        </tr>
                    `);
                    });
                }

                // Pagination
                const totalPages = Math.ceil(res.total / 5);
                const pagination = $('.pagination').empty();
                pagination.append(`<li class="page-item"><a class="page-link" href="#" data-page="${page - 1}">Previous</a></li>`);

                for (let i = 1; i <= totalPages; i++) {
                    pagination.append(`
                    <li class="page-item ${i === page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
                }

                pagination.append(`<li class="page-item"><a class="page-link" href="#" data-page="${page + 1}">Next</a></li>`);
            }
        });
    }

    $(document).ready(function () {
        loadReviews();

        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            const newPage = parseInt($(this).data('page'));
            if (newPage > 0) {
                currentPage = newPage;
                loadReviews(currentPage, searchTerm);
            }
        });

        $('input[type="text"]').on('keyup', function () {
            searchTerm = $(this).val();
            currentPage = 1;
            loadReviews(currentPage, searchTerm);
        });
    });
</script>