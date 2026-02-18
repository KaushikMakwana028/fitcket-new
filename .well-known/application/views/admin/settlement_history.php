<div class="page-wrapper">
    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/dashboard');?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Settlement Transactions</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">

                <!-- Search + Filter Row -->
                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <!-- Search Box -->
                    <div class="position-relative">
                        <input id="searchInputhistory" type="text" class="form-control ps-5 radius-30" placeholder="Search by User">
                        <span class="position-absolute top-50 product-show translate-middle-y">
                            <i class="bx bx-search"></i>
                        </span>
                    </div>

                    <!-- Settlement Filter -->
                    <div class="filter-bar ms-auto">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary filter-transection active" data-filter="">All</button>
                            <button class="btn btn-sm btn-outline-warning filter-transection" data-filter="pending">Pending</button>
                            <button class="btn btn-sm btn-outline-success filter-transection" data-filter="success">Success</button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table mb-0" id="SettlementHistory">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <!-- <th>User Name</th> -->
                                <th>Recipient Name</th>
                                <th>Mobile</th>
                                <th>Settlement Status</th>
                                <th>Settlement Amount</th>
                                <th>Settlement Date</th>
                            </tr>
                        </thead>
                        <tbody id="SettlementHistoryBody"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination round-pagination justify-content-center"></ul>
        </nav>

    </div>
</div>
