<!--start page wrapper-->
<div class="page-wrapper">
  <div class="page-content">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Add Gym Gallery Images</h5>
      </div>

      <div class="card-body">
        <form id="gymGalleryForm" enctype="multipart/form-data" novalidate>
          
          <!-- File Input -->
          <div class="mb-3">
            <label for="gallery_images" class="form-label">Select Images</label>
            <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" accept="image/*" multiple required>
            <div class="invalid-feedback">Please select at least one image.</div>
          </div>

          <!-- Preview Section -->
          <div class="mb-3" id="preview_section"></div>

          <!-- Submit -->
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Upload Images</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.getElementById('gallery_images').addEventListener('change', function(event) {
  let preview = document.getElementById('preview_section');
  preview.innerHTML = '';
  Array.from(event.target.files).forEach(file => {
    let reader = new FileReader();
    reader.onload = function(e) {
      let img = document.createElement('img');
      img.src = e.target.result;
      img.style = "width:90px; margin:5px; border:1px solid #ccc; padding:4px; border-radius:6px;";
      preview.appendChild(img);
    };
    reader.readAsDataURL(file);
  });
});
$(document).ready(function () {
  $('#gymGalleryForm').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    if (!form.checkValidity()) {
      e.stopPropagation();
      $(form).addClass('was-validated');
      return;
    }

    let formData = new FormData(form);

    Swal.fire({
      title: 'Uploading...',
      text: 'Please wait while we upload your images.',
      icon: 'info',
      showConfirmButton: false,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });

    $.ajax({
      url: '<?= base_url("provider/profile/upload_gallery_images"); ?>',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (response) {
        Swal.close();
        if (response.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response.message
          }).then(() => {
            $('#gymGalleryForm')[0].reset();
            $('#preview_section').html('');
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
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Something went wrong while uploading.'
        });
      }
    });
  });
});
</script>
