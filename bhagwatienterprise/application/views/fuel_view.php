<div class="page-wrapper">
  <div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Table</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">All Fuel</li>
          </ol>
        </nav>
      </div>
    </div>

    <hr>

    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <input type="text" id="search-fuel" class="form-control w-25" placeholder="Search fuel...">
        </div>

        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Driver Name</th>
                <th>Vechical Name</th>
                <th>Vehicle Number</th>
                <th>Fuel Type</th>
                <th>Kilometer</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Notes</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody id="fuel"></tbody>
          </table>
        </div>

        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
        </nav>

      </div>
    </div>

  </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const USER_ID = "<?= $user_id ?>";

  function loadFuel(page = 1, search = '') {
    $.ajax({
      url: "<?= base_url('profile/get_fuel_list'); ?>",
      type: "GET",
      data: { page: page, search: search,user_id: USER_ID },
      dataType: "json",
      success: function (res) {
        if (res.status && res.data.length > 0) {
          let rows = '';
          $.each(res.data, function (i, item) {
            rows += `
              <tr>
                <td>${i + 1}</td>
                <td>${item.name || '-'}</td>

                <td>${item.vehical_name || '-'}</td>
                <td>${item.vehical_number || '-'}</td>
                <td>${item.fuel_type}</td>
                <td>${item.km || '-'}</td>
                <td>${item.quantity}</td>
                <td>${item.amount}</td>
                <td>${item.notes || '-'}</td>
                <td>
                  <a class="delete-fuel text-danger" data-id="${item.id}" style="cursor: pointer;">
                    <i class='bx bx-trash' style="font-size: 25px;"></i>
                  </a>
                </td>
              </tr>`;
          });
          $("#fuel").html(rows);
          renderPagination(res.pagination);
        } else {
          $("#fuel").html(`<tr><td colspan="9" class="text-center text-danger">No records found.</td></tr>`);
          $("#pagination").html('');
        }
      }
    });
  }

  function renderPagination(pagination) {
    if (!pagination) return;
    const totalPages = pagination.total_pages;
    const currentPage = pagination.current_page;
    let html = '';

    if (currentPage > 1) {
      html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">Prev</a></li>`;
    }

    for (let i = 1; i <= totalPages; i++) {
      html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                 <a class="page-link" href="#" data-page="${i}">${i}</a>
               </li>`;
    }

    if (currentPage < totalPages) {
      html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">Next</a></li>`;
    }

    $("#pagination").html(html);
  }

  $("#search-fuel").on("keyup", function () {
    const search = $(this).val().trim();
    loadFuel(1, search);
  });

  $(document).on("click", ".page-link", function (e) {
    e.preventDefault();
    const page = $(this).data("page");
    const search = $("#search-fuel").val().trim();
    loadFuel(page, search);
  });

  loadFuel();
});
$(document).on('click', '.delete-fuel', function () {
  const id = $(this).data('id');
  Swal.fire({
    title: 'Are you sure?',
    text: 'This record will be deleted permanently.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "<?= base_url('profile/delete_fuel'); ?>",
        type: "POST",
        data: { id },
        success: function (res) {
          Swal.fire('Deleted!', 'Fuel entry removed.', 'success');
          loadFuel();
          location.reload();
        }
      });
    }
  });
});

</script>
