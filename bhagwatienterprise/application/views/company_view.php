<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Table</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Company</li>
                    </ol>
                </nav>
            </div>
        </div>

        <hr>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" id="search" class="form-control w-25" placeholder="Search company...">
                </div>

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="company"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
        </nav>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let currentPage = 1;
        let totalPages = 1;

        function loadCompanies(page = 1, search = '') {
            $.ajax({
                url: "<?= base_url('driver/fetch_companies'); ?>",
                type: "POST",
                data: { page, search },
                dataType: "json",
                success: function (res) {
                    let html = '';
                    if (res.companies.length > 0) {
                        $.each(res.companies, function (i, c) {
                            html += `
<tr>
  <td>${(page - 1) * 10 + i + 1}</td>
  <td>${c.company_name}</td>
  <td><span class="badge ${c.isActive == 1 ? 'bg-success' : 'bg-danger'}">
      ${c.isActive == 1 ? 'Active' : 'Inactive'}
  </span></td>
  <td>
    <div class="d-flex order-actions">
      <a href="<?= base_url('company/edit/'); ?>${c.id}"><i class="bx bxs-edit"></i></a>
      <a class="ms-2 pe-auto" data-id="${c.id}" style="cursor: pointer;"><i class="bx bxs-trash text-danger"></i></a>

      ${c.isActive == 1
                                    ? `<a href="javascript:;" class="ms-3" onclick="toggleCompanyStatus(${c.id}, 0)"><i class="bx bx-toggle-left"></i></a>`
                                    : `<a href="javascript:;" class="ms-3" onclick="toggleCompanyStatus(${c.id}, 1)"><i class="bx bx-toggle-right"></i></a>`}
    </div>
  </td>
</tr>`;
                        });
                    } else {
                        html = `<tr><td colspan="4" class="text-center text-danger">No companies found</td></tr>`;
                    }

                    $('#company').html(html);
                    totalPages = res.total_pages;
                    currentPage = res.current_page;
                    renderPagination();
                }
            });
        }

        function renderPagination() {
            let paginationHtml = '';
            let startPage = Math.max(1, currentPage - 1);
            let endPage = Math.min(totalPages, startPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#">${i}</a>
            </li>`;
            }

            if (endPage < totalPages) {
                paginationHtml += `<li class="page-item"><a class="page-link" href="#" id="nextBtn">Next</a></li>`;
            }

            $('#pagination').html(paginationHtml);
        }

        $(document).on('click', '.page-link', function (e) {
            e.preventDefault();
            let pageText = $(this).text();
            if (pageText === 'Next') {
                if (currentPage < totalPages) currentPage++;
            } else {
                currentPage = parseInt(pageText);
            }
            loadCompanies(currentPage, $('#search').val());
        });

        $('#search').on('keyup', function () {
            currentPage = 1;
            loadCompanies(1, $(this).val());
        });

        loadCompanies();
    });

    function toggleCompanyStatus(id, status) {
        let action = status == 1 ? 'Activate' : 'Deactivate';
        Swal.fire({
            title: `${action} Company?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: action,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('driver/toggle_status_company'); ?>",
                    type: "POST",
                    data: { id: id, isActive: status },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === 'success') {
                            Swal.fire('Success', res.message, 'success');
                            loadCompanies(currentPage, $('#search').val());
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    }
                });
            }
        });
    }
   $(document).on('click', '.bxs-trash', function () {
    var id = $(this).closest('a').data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("driver/delete_item"); ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Record deleted successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: response.message || 'Failed to delete record.'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }
    });
});


</script>