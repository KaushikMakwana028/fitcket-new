<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <!-- <div class="breadcrumb-title pe-3">eCommerce</div> -->
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Filtter</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                        <!-- <a class="dropdown-item" href="javascript:;">Action</a> -->
                        <a class="dropdown-item" href="javascript:;">New</a>
                        <a class="dropdown-item" href="javascript:;">Repeat</a>
                        <!-- <div class="dropdown-divider"></div>	 -->
                        <a class="dropdown-item" href="javascript:;">High value</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" id="searchCustomer" placeholder="Search Customers"> <span
                            class="position-absolute top-50 product-show translate-middle-y"><i
                                class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Customer Mobile</th>
                                <th>Customer Location</th>
                                <th>Customer Tag</th>
                                <!-- <th>View Details</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                          
                           
                        </tbody>
                    </table>


                </div>
            </div>
           <nav aria-label="Page navigation example">
							<ul class="pagination round-pagination d-flex justify-content-center" id="paginationLinks">
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
$(document).ready(function () {
    fetchCustomers();

    $('#searchCustomer').on('keyup', function () {
        fetchCustomers(1, $(this).val());
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1]; // ← FIXED LINE
        let search = $('#searchCustomer').val();
        fetchCustomers(page, search);
    });

    function fetchCustomers(page = 1, search = '') {
        $.ajax({
            url: "<?= base_url('admin/customers/ajax_customers') ?>",
            method: "GET",
            data: {
                page: page,
                search: search
            },
            dataType: "json",
            success: function (res) {
                $('#customerTableBody').html(res.table_data);
                $('#paginationLinks').html(res.pagination);
            }
        });
    }
});

</script>
