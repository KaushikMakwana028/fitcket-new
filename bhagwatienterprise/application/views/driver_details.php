<div class="page-wrapper">
  <div class="page-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Table</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Trips</li>
          </ol>
        </nav>
      </div>
    </div>

    <hr>

    <div class="card">
      <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <input type="text" id="search-trip" class="form-control w-25" placeholder="Search trip...">
        </div>

        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Mobile</th>
                <th>Trip Date</th>
                <th>From Location</th>
                <th>To Location</th>
                 <th>Staus</th>
                 <th>Details</th>
                
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
<!-- </div> -->
<!-- </div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadTrips(page = 1, search = '') {
    const user_id = <?= $id ?>;

    $.ajax({
        url: '<?= base_url("driver/fetch_trips_ajax") ?>',
        method: 'GET',
        data: { page: page, search: search, user_id },
        dataType: 'json',
        success: function(res) {
            let tbody = '';

            if (res.trips && res.trips.length > 0) {
                res.trips.forEach((trip, index) => {
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
                        <td>${(page-1)*10 + index + 1}</td>
                        <td>${trip.customer_name || ''}</td>
                        <td>${trip.customer_mobile || ''}</td>
                        <td>${trip.trip_date || ''}</td>
                        <td>${trip.from_location || ''}</td>
                        <td>${trip.to_location || ''}</td>
                         <td>${statusHtml}</td>

                        <td>
                            <a href="<?= base_url('driver_trip_details/') ?>${trip.id}" 
                               class="btn btn-primary btn-sm radius-30 px-4">View Details</a>
                        </td>
                    </tr>`;
                });
            } else {
                tbody = `
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bx bx-info-circle fs-4 me-2"></i> 
                            No trip found for this driver
                        </td>
                    </tr>`;
            }

            $('#trip').html(tbody);

            // Pagination buttons (3 visible + next)
            let pagination = '';
            if (res.total_pages > 1) {
                let start = Math.max(1, res.current_page - 1);
                let end = Math.min(start + 2, res.total_pages);

                for (let i = start; i <= end; i++) {
                    pagination += `<li class="page-item ${i == res.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }

                if (end < res.total_pages) {
                    pagination += `<li class="page-item">
                        <a class="page-link" href="#" data-page="${res.current_page + 1}">Next</a>
                    </li>`;
                }
            }

            $('#pagination').html(pagination);
        },
        error: function() {
            $('#trip').html(`
                <tr>
                    <td colspan="8" class="text-center text-danger py-4">
                        Error loading trips. Please try again.
                    </td>
                </tr>`);
        }
    });
}

// Initial load
loadTrips();

// Pagination click
$(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    let page = $(this).data('page');
    let search = $('#search-trip').val().trim();
    loadTrips(page, search);
});

// Search input
$('#search-trip').on('keyup', function() {
    let search = $(this).val().trim();
    loadTrips(1, search);
});
</script>


