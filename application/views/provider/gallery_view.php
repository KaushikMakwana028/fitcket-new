<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

					<!-- <div class="breadcrumb-title pe-3">Category</div> -->

					<div class="ps-3">

						<nav aria-label="breadcrumb">

							<ol class="breadcrumb mb-0 p-0">

								<li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard');?>"><i class="bx bx-home-alt"></i></a>

								</li>

								<li class="breadcrumb-item active" aria-current="page">Gallery</li>

							</ol>

						</nav>

					</div>

					

				</div>

				<!--end breadcrumb-->

<div class="card">
  <div class="card-body">
    <div class="d-lg-flex align-items-center mb-4 gap-3">
      <div class="position-relative">
        <input type="text" id="searchInput" class="form-control ps-5 radius-30" placeholder="Search image...">
        <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Image</th>
            <!-- <th>Title</th> -->
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="galleryTableBody">
          <!-- Images loaded by AJAX -->
        </tbody>
      </table>
    </div>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center" id="paginationLinks"></ul>
    </nav>
  </div>
</div>
<!-- </div> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
  loadGallery(1);

  // Load data with pagination
  function loadGallery(page, search = '') {
    $.ajax({
      url: "<?= base_url('provider/profile/fetch_gallery') ?>",
      method: "POST",
      data: { page: page, search: search },
      dataType: "json",
      success: function (response) {
        let html = '';
        if (response.data.length > 0) {
          $.each(response.data, function (index, item) {
            html += `
              <tr>
                <td>${index + 1}</td>
                <td><img src="<?= base_url() ?>${item.image}" width="60" height="60" class="rounded"></td>
                <td>${item.status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>'}</td>
                <td>
                  <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">
                    <i class="bx bx-trash"></i>
                  </button>
                </td>
              </tr>
            `;
          });
        } else {
          html = `<tr><td colspan="5" class="text-center">No images found</td></tr>`;
        }
        $("#galleryTableBody").html(html);

        // Pagination
        let totalPages = Math.ceil(response.total / response.limit);
        let pagination = '';
        for (let i = 1; i <= totalPages; i++) {
          pagination += `<li class="page-item ${i === response.page ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        $("#paginationLinks").html(pagination);
      }
    });
  }

  // Pagination click
  $(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    let page = $(this).data('page');
    let search = $("#searchInput").val();
    loadGallery(page, search);
  });

  // Search
  $("#searchInput").on('keyup', function () {
    let search = $(this).val();
    loadGallery(1, search);
  });

  // Delete
  $(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');
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
          url: "<?= base_url('provider/gallery/delete_image') ?>",
          method: "POST",
          data: { id: id },
          success: function (response) {
            let res = JSON.parse(response);
            if (res.status) {
              Swal.fire('Deleted!', 'Image has been deleted.', 'success');
              loadGallery(1);
            }
          }
        });
      }
    });
  });
});

</script>
