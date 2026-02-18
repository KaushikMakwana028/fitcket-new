<div class="page-wrapper">
  <div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Table</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">All Drivers</li>
          </ol>
        </nav>
      </div>
    </div>

    <hr>

    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <input type="text" id="search" class="form-control w-25" placeholder="Search driver...">
        </div>

        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Name</th>
               
                <th>Mobile</th>
                <th>Vehicle</th>
                <th>Vehicle Number</th>
                <th>Company</th>
                <th>Staus</th>

                <th>Action</th>
                <th>Details</th>
              </tr>
            </thead>
            <tbody id="driver"></tbody>
          </table>
        </div>

        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
        </nav>

      </div>
    </div>

  </div>
</div>
<!-- </div> -->
<!-- </div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Make global
let currentPage = 1;
let totalPages = 1;

$(document).ready(function () {
  loadDrivers();

  // Search
  $('#search').on('keyup', function () {
    currentPage = 1;
    loadDrivers(1, $(this).val());
  });

  // Pagination click
  $(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    let pageText = $(this).text();
    if (pageText === 'Next') {
      if (currentPage < totalPages) currentPage++;
    } else {
      currentPage = parseInt(pageText);
    }
    loadDrivers(currentPage, $('#search').val());
  });
});

function loadDrivers(page = 1, search = '') {
  $.ajax({
    url: "<?= base_url('driver/fetch_drivers'); ?>",
    type: "POST",
    data: { page, search },
    dataType: "json",
    success: function (res) {
      let html = '';
      if (res.drivers.length > 0) {
        $.each(res.drivers, function(i, d) {
          html += `
<tr>
  <td>${(page - 1) * 10 + i + 1}</td>
  <td>${d.name}</td>
  <td>${d.mobile}</td>
  <td>${d.vehical_name}</td>
  <td>${d.vehical_number}</td>
  <td>${d.company_name ?? '-'}</td>
  <td>
    <span class="badge ${d.isActive == 1 ? 'bg-success' : 'bg-danger'}">
      ${d.isActive == 1 ? 'Active' : 'Inactive'}
    </span>
  </td>
  <td>
    <div class="d-flex order-actions">
      <a href="<?= base_url('driver/edit/'); ?>${d.id}"><i class="bx bxs-edit"></i></a>
      <a class="ms-2 delete-user" data-id="${d.id}" style="cursor: pointer;">
  <i class="bx bxs-trash text-danger"></i>
</a>
 <a class="ms-2 download-pdf" data-id="${d.id}" style="cursor: pointer;">
  <i class="bx bxs-file-pdf text-danger"></i>
</a>
<a href="<?= base_url('fuel/') ?>${d.id}" class="ms-2" style="cursor: pointer;">
    <i class="bx bx-gas-pump text-danger"></i>
</a>





      ${d.isActive == 1 
        ? `<a href="javascript:;" class="ms-3" onclick="toggleDriverStatus(${d.id}, 0)"><i class="bx bx-toggle-left"></i></a>` 
        : `<a href="javascript:;" class="ms-3" onclick="toggleDriverStatus(${d.id}, 1)"><i class="bx bx-toggle-right"></i></a>`}
    </div>
  </td>
  <td>
    <a href="<?= base_url('driver/view/'); ?>${d.id}" class="btn btn-primary btn-sm radius-30 px-4">View Details</a>

    
  </td>
</tr>`;
        });
      } else {
        html = `<tr><td colspan="9" class="text-center text-danger">No drivers found</td></tr>`;
      }

      $('#driver').html(html);
      totalPages = res.total_pages;
      currentPage = res.current_page;
      renderPagination();
    }
  });
}

// Pagination render
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

// Toggle active/inactive status
function toggleDriverStatus(id, status) {
  let action = status == 1 ? 'Activate' : 'Deactivate';
  Swal.fire({
    title: `${action} Driver?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: action,
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if(result.isConfirmed) {
      $.ajax({
        url: "<?= base_url('driver/toggle_status'); ?>",
        type: "POST",
        data: { id: id, isActive: status },
        dataType: "json",
        success: function(res) {
          if(res.status === "success") {
            Swal.fire('Success', res.message, 'success');
            loadDrivers(currentPage, $('#search').val()); // reload table
          } else {
            Swal.fire('Error', res.message, 'error');
          }
        }
      });
    }
  });
}

$(document).on('click', '.delete-user', function () {
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this user?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("driver/delete_user"); ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'User deleted successfully.'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: response.message
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong while deleting.'
                    });
                }
            });
        }
    });
});

$(document).on('click', '.download-pdf', function () {
    const tripId = $(this).data('id');

    Swal.fire({
        title: 'Generating PDF...',
        text: 'Please wait while your trip report is being created.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    
    const pdfUrl = "<?= base_url('driver/generate_pdf'); ?>?id=" + tripId;
    window.open(pdfUrl, '_blank');

    Swal.close();
    Swal.fire({
        icon: 'success',
        title: 'Download Started',
        text: 'Your trip report is being downloaded.',
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
