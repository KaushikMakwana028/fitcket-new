<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Package</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashbaord'); ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Package</li>
                    </ol>
                </nav>
            </div>

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
                    <!-- <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Order</a></div> -->
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>index#</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Inclusion</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
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
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
    $(document).ready(function () {
        const baseUrl = "<?= base_url() ?>"; 
        function fetchPackages(page = 1, search = '') {
            $.ajax({
                url: '<?= base_url('admin/review/fetch_packages') ?>',
                type: 'POST',
                dataType: 'json',
                data: { page: page, search: search },
                success: function (res) {
                    let html = '';
                    let i = (page - 1) * res.limit + 1;
                    res.data.forEach(function (pkg) {
                       html += `<tr>
    <td>${i++}</td>
    <td>${pkg.name}</td>
    <td>₹${pkg.price}</td>
    <td><div style="white-space: pre-line;">${pkg.inclusion}</div></td>
    <td>
        <div class="d-flex order-actions">
            <a href="${baseUrl}package_edit/${pkg.id}" class="edit-customer" data-id="${pkg.id}">
                <i class="bx bxs-edit"></i>
            </a>
            <a href="javascript:void(0);" class="ms-3 delete-package" data-id="${pkg.id}">
                <i class="bx bxs-trash"></i>
            </a>
        </div>
    </td>
</tr>`;

                    });
                    $('table tbody').html(html);

                    let totalPages = Math.ceil(res.total_rows / res.limit);
                    let pagination = '';
                    for (let j = 1; j <= totalPages; j++) {
                        pagination += `<li class="page-item ${j == page ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${j}">${j}</a>
                    </li>`;
                    }
                    $('.pagination').html(`
                    <li class="page-item"><a class="page-link prev" href="javascript:void(0);">Previous</a></li>
                    ${pagination}
                    <li class="page-item"><a class="page-link next" href="javascript:void(0);">Next</a></li>
                `).data('current', page);
                }
            });
        }

        fetchPackages();

        // Search
        $('.ps-5').on('keyup', function () {
            const search = $(this).val();
            fetchPackages(1, search);
        });

        // Pagination click
        $(document).on('click', '.pagination a.page-link', function () {
            const page = $(this).data('page');
            const search = $('.ps-5').val();
            if (page) fetchPackages(page, search);
        });

        $(document).on('click', '.pagination .prev', function () {
            const current = $('.pagination').data('current');
            if (current > 1) {
                const search = $('.ps-5').val();
                fetchPackages(current - 1, search);
            }
        });

        $(document).on('click', '.pagination .next', function () {
            const current = $('.pagination').data('current');
            const search = $('.ps-5').val();
            fetchPackages(current + 1, search);
        });
    });
</script>