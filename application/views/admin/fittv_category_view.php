<div class="page-wrapper p-4">
    <div class="page-content">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FITTV Categories</h5>
                <a href="<?= base_url('admin/add_fittv_category') ?>" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add Category</a>
            </div>

            <div class="card-body">

                <!-- SEARCH + FILTER -->
                <form method="get" class="row mb-3" id="filterForm">

                    <div class="col-md-4 mb-3 mb-md-0">
                        <input type="text" name="search" id="searchCategory" class="form-control"
                            placeholder="Search category..."
                            value="<?= $this->input->get('search') ?>">
                    </div>

                    <div class="col-md-3 mb-3 mb-md-0">
                        <select name="gender" id="genderSelect" class="form-control">

                            <option value="">All Gender</option>

                            <option value="Boy"
                                <?= $this->input->get('gender') == 'Boy' ? 'selected' : '' ?>>
                                Boy
                            </option>

                            <option value="Girl"
                                <?= $this->input->get('gender') == 'Girl' ? 'selected' : '' ?>>
                                Girl
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary">
                            <i class="bx bx-search"></i> Search
                        </button>

                        <a href="<?= base_url('admin/fittv_category') ?>" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </form>


                <!-- TABLE -->

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Gender</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>

                        </thead>

                        <tbody id="tableBody">

                            <?php if (!empty($categories)) { ?>

                                <?php
                                $index = $this->uri->segment(3) ? $this->uri->segment(3) + 1 : 1;

                                foreach ($categories as $c) {
                                ?>
                                    <tr>

                                        <td><?= $index++ ?></td>

                                        <td>
                                            <span class="badge <?= $c->gender == 'Boy' ? 'bg-primary' : 'bg-danger' ?>">
                                                <?= $c->gender ?>
                                            </span>
                                        </td>

                                        <td><?= $c->name ?></td>

                                        <td>
                                            <?php if ($c->isActive) { ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php } ?>
                                        </td>

                                        <td>
                                            <a href="<?= base_url('admin/edit_fittv_category/' . $c->id) ?>" class="btn btn-warning btn-sm">
                                                <i class="bx bx-edit"></i>
                                            </a>

                                            <button type="button"
                                                onclick="confirmDelete('<?= base_url('admin/delete_fittv_category/' . $c->id) ?>')"
                                                class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="5" class="text-center text-danger">
                                        No Categories Found
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </div>

                <!-- PAGINATION -->

                <div class="d-flex justify-content-center" id="paginationWrapper">

                    <?= $pagination ?? '' ?>

                </div>


            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchResults() {
            var formData = $('#filterForm').serialize();
            var currentUrl = window.location.href.split('?')[0];
            var url = currentUrl + '?' + formData;

            $('#tableBody').css('opacity', '0.5');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    var newTbody = $(response).find('#tableBody').html();
                    var newPagination = $(response).find('#paginationWrapper').html();

                    if (newTbody === undefined) {
                        window.location = url;
                        return;
                    }

                    $('#tableBody').html(newTbody).css('opacity', '1');
                    $('#paginationWrapper').html(newPagination);

                    window.history.pushState({
                        "html": response,
                        "pageTitle": document.title
                    }, "", url);
                },
                error: function() {
                    $('#tableBody').css('opacity', '1');
                }
            });
        }

        window.confirmDelete = function(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "All videos in this category will also be affected. You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete category!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        };

        var timeout = null;
        $('#searchCategory').on('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                fetchResults();
            }, 500);
        });

        $('#genderSelect').on('change', function() {
            fetchResults();
        });

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchResults();
        });
    });
</script>

<style>
    .page-item.disabled .page-link {
        pointer-events: none;
        opacity: 0.6;
    }

    .page-item.active .page-link, .page-item.active > a, .pagination .active > a:focus, .pagination .active > a:hover, .pagination .active > span, .pagination .active > span:focus, .pagination .active > span:hover {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        color: #fff;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
    }
</style>