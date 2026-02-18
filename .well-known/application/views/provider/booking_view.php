<div class="page-wrapper">

    <div class="page-content">

        <!--breadcrumb-->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <!-- <div class="breadcrumb-title pe-3">Category</div> -->

            <div class="ps-3">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0">

                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard'); ?>"><i

                                    class="bx bx-home-alt"></i></a>

                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Bookings</li>

                    </ol>

                </nav>

            </div>



        </div>

        <!--end breadcrumb-->



        <div class="card">

            <div class="card-body">

                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="position-relative">

                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search service"> <span

                            class="position-absolute top-50 product-show translate-middle-y"><i

                                class="bx bx-search"></i></span>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead class="table-light" id="bookingTableBodyy">

                            <tr>
    <th>#</th>
    <th>Name</th>
    <th>Mobile</th>
    <th>Price</th>
    <th>Duration</th>
    <th>Qty</th>
    <th>Free Qty</th>
    <th>Status</th>
    <th>Start Date</th>
    <th>End Date</th>
</tr>

                        </thead>

                        <tbody id="bookingTableBody">



                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        <nav aria-label="Page navigation example">

            <ul class="pagination round-pagination justify-content-center" id="paginationContainer">

                <!-- Pagination items will be injected dynamically -->

            </ul>

        </nav>



    </div>

</div>

<!-- </div> -->