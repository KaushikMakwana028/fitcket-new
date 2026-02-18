<div class="page-wrapper">
  <div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Table</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">All Trip</li>
          </ol>
        </nav>
      </div>
    </div>

    <hr>

    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <input type="text" id="search-trip" class="form-control w-25" placeholder="Search trip...">
           <select id="trip-filter" class="form-select w-25">
      <option value="">All Trips</option>
      <option value="fixcab">Fix Cab</option>
      <option value="oncall">On Call</option>
  </select>
        </div>

        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Driver Name</th>
                <th>Vehicle</th>
                <th>Trip Date</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Staus</th>
                <th>Trip Type</th>
                <th>Details</th>
                <th>Remove</th>

              </tr>
            </thead>
            <tbody id="trip"></tbody>
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
let currentPage = 1;

function loadTrips(page = 1, search = '') {
    $.ajax({
        url: '<?= base_url("driver/fetch_trips") ?>',
        type: 'GET',
        data: { page: page, search: search },
        dataType: 'json',
        success: function(res) {
            if (res.status && Array.isArray(res.data) && res.data.length > 0) {
                let tbody = '';
                res.data.forEach((trip, index) => {
                    let statusHtml = trip.status === 'completed' 
                        ? `<div class="d-flex align-items-center text-success">
                               <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                               <span>Completed</span>
                           </div>`
                        : `<div class="d-flex align-items-center text-danger">
                               <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                               <span>Running</span>
                           </div>`;

                    tbody += `<tr>
                        <td>${(page - 1) * 10 + index + 1}</td>
                        <td>${trip.driver_name || '-'}</td>
                        <td>${trip.vehical_name || '-'}</td>
                        <td>${trip.trip_date || '-'}</td>
                        <td>${trip.from_location || '-'}</td>
                        <td>${trip.to_location || '-'}</td>
                        <td>${statusHtml}</td>
                        <td>${trip.trip_type|| '-'}</td>

                        <td>

                            <a href="<?= base_url('trip_details/') ?>${trip.id}" 
                               class="btn btn-primary btn-sm radius-30 px-4">View Details</a>

                        </td>
                         <td>
        <a class="ms-2 delete-trip text-danger" data-id="${trip.id}" style="cursor: pointer;">
            <i class='bx bx-trash' style="    font-size: 25px;
"></i> 
        </a>
    </td>
                    </tr>`;
                });

                $('#trip').html(tbody);
                renderPagination(res.total_pages || 1, res.current_page || 1);
            } else {
                $('#trip').html('<tr><td colspan="8" class="text-center text-muted py-4">🚘 No bookings found </td></tr>');
                $('#pagination').html('');
            }
        },
        error: function() {
            $('#trip').html('<tr><td colspan="8" class="text-center text-danger py-4">Error loading data. Please try again later.</td></tr>');
            $('#pagination').html('');
        }
    });
}

// Render pagination buttons
function renderPagination(totalPages, current) {
    let html = '';
    let start = Math.max(1, current - 1);
    let end = Math.min(totalPages, start + 2);

    if (current > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTrips(${current - 1})">Prev</a></li>`;
    }

    for (let i = start; i <= end; i++) {
        html += `<li class="page-item ${i === current ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadTrips(${i})">${i}</a>
                 </li>`;
    }

    if (end < totalPages) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadTrips(${current + 1})">Next</a></li>`;
    }

    $('#pagination').html(html);
}

// Search input
$('#search-trip').on('input', function() {
    currentPage = 1;
    let searchTerm = $(this).val().trim();
    loadTrips(1, searchTerm);
});

// Initial load
$(document).ready(function() {
    loadTrips();
});
$(document).on('click', '.delete-trip', function () {
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this Trip?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("driver/delete_trip"); ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Trip deleted successfully.'
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

</script>

