$(document).ready(function () {
    if ($("#bookingTableBodyy").length > 0) {
        function loadBookings(page = 1, search = "") {
            $.ajax({
                url: site_url + "provider/customers/get_bookings_ajax",
                type: "GET",
                data: { page: page, search: search },
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        renderBookings(res.data, res.page, res.limit);
                        renderPagination(res.total, res.page, res.limit, search);
                    }
                }
            });
        }
       
function getStatusUI(status) {
    switch (status.toLowerCase()) {
        case "pending":
            return `<div class="d-flex align-items-center text-info">
                        <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                        <span>Pending</span>
                    </div>`;
        case "success":
            return `<div class="d-flex align-items-center text-success">
                        <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                        <span>Success</span>
                    </div>`;
        case "failed":
            return `<div class="d-flex align-items-center text-danger">
                        <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                        <span>Failed</span>
                    </div>`;
        default:
            return `<div class="d-flex align-items-center text-secondary">
                        <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                        <span>${status}</span>
                    </div>`;
    }
}

       function renderBookings(bookings, page, limit) {
    let html = '';
    const offset = (page - 1) * limit;

    if (bookings.length === 0) {
        html = '<tr><td colspan="8" class="text-center">No bookings found</td></tr>';
    } else {
        bookings.forEach((booking, index) => {
    // Parse start date
    let startDate = new Date(booking.start_date);
    let endDate = new Date(startDate);

    const paidQty = Number(booking.qty) || 1; // paid quantity
    const freeQty = Number(booking.free_qty) || 0; // free quantity
    const totalQty = paidQty + freeQty; // total for end date calculation

    // Add duration * total quantity
    switch ((booking.duration || '').toLowerCase()) {
        case 'day':
        case 'days':
            endDate.setDate(startDate.getDate() + totalQty);
            break;
        case 'week':
        case 'weeks':
            endDate.setDate(startDate.getDate() + (totalQty * 7));
            break;
        case 'month':
        case 'months':
            endDate.setMonth(startDate.getMonth() + totalQty);
            break;
        case 'year':
        case 'years':
            endDate.setFullYear(startDate.getFullYear() + totalQty);
            break;
        default:
            endDate = null;
            break;
    }

    // Format dates
    const options = { day: '2-digit', month: 'short', year: 'numeric' };
    const startDateStr = startDate.toLocaleDateString('en-GB', options);
    const endDateStr = endDate ? endDate.toLocaleDateString('en-GB', options) : '-';

    // Render row with separate Qty and Free Qty columns
    html += `
        <tr>
            <td>${offset + index + 1}</td>
            <td>${booking.name}</td>
            <td>${booking.mobile}</td>
            <td>₹${booking.price}</td>
            <td>${booking.duration}</td>
            <td>${paidQty}</td>
            <td>${freeQty}</td>
            <td>${getStatusUI(booking.status)}</td>
            <td>${startDateStr}</td>
            <td>${endDateStr}</td>
        </tr>`;
});

    }

    $('#bookingTableBody').html(html);
}



        function renderPagination(total, page, limit, search) {
            const totalPages = Math.ceil(total / limit);
            let pagHtml = '';

            if (totalPages <= 1) {
                $(".pagination").html('');
                return;
            }

            for (let i = 1; i <= totalPages; i++) {
                pagHtml += `<li class="page-item ${page == i ? "active" : ""}">
                                <a class="page-link" href="#" data-page="${i}" data-search="${search}">${i}</a>
                            </li>`;
            }
            $(".pagination").html(pagHtml);
        }

        // Initial load
        loadBookings();

        // Pagination click
        $(document).on("click", ".pagination .page-link", function (e) {
            e.preventDefault();
            let page = $(this).data("page");
            let search = $(".form-control").val() || "";
            loadBookings(page, search);
        });

        // Search input
        $(".form-control").on("input", function () {
            let search = $(this).val();
            loadBookings(1, search);
        });
    }
});

$("#service_form").on("submit", function (e) {
		e.preventDefault();

		const form = this;
		if (!form.checkValidity()) {
			form.classList.add("was-validated");
			return;
		}

		const formData = new FormData(this);

		$.ajax({
			url: site_url + "provider/service/save",
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			dataType: "json", // Make sure the server returns JSON
			success: function (response) {
				if (response.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: response.message || "Service saved successfully!",
						confirmButtonColor: "#3085d6",
						confirmButtonText: "OK",
					});

					form.reset();
                      const defaultImage = site_url + "assets/images/no-image.png";

					$("#image_previeww").attr("src", defaultImage);
					form.classList.remove("was-validated");
				} else {
					Swal.fire({
						icon: "warning",
						title: "Notice",
						text: response.message || "Category already exists.",
						confirmButtonColor: "#d33",
						confirmButtonText: "OK",
					});
				}
			},
			error: function (xhr) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: "Something went wrong while saving the category.",
				});
			},
		});
	});
    $(document).on("click", ".toggle-status-btn_service", function () {
	const button = $(this);
	const postId = button.data("id");
	const newStatus = button.data("status");

	$.ajax({
		url: site_url + "provider/service/toggle_status",
		type: "POST",
		data: { id: postId, status: newStatus },
		dataType: "json",
		success: function (res) {
			if (res.success) {
				Swal.fire({
					icon: "success",
					title: res.message,
					timer: 2000,
					showConfirmButton: false,
				});
				setTimeout(function () {
					location.reload();
				}, 2000);
			} else {
				Swal.fire("Error", res.message, "error");
			}
		},
		error: function () {
			Swal.fire("Error", "Something went wrong!", "error");
		},
	});
});
// customer pagiantion
$(document).ready(function () {
    // Run only if customer table exists
    if ($("#customerTableBodyy").length > 0) {
        function loadCustomers(page = 1, search = "") {
            $.ajax({
                url: site_url + "provider/customers/get_customers_ajax",
                type: "GET",
                data: { page: page, search: search },
                dataType: "json",
                success: function (res) {
                    let html = "";
                    $.each(res.customers, function (index, c) {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${c.name}</td>
                                <td>${c.mobile}</td>
                                <td>${c.email}</td>
                                
                            </tr>
                        `;
                    });
                    $("#customerTableBody").html(html);

                    // Pagination
                    let totalPages = Math.ceil(res.total / res.limit);
                    let pagHtml = "";
                    for (let i = 1; i <= totalPages; i++) {
                        pagHtml += `<li class="page-item ${res.page == i ? "active" : ""}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>`;
                    }
                    $(".pagination").html(pagHtml);
                },
            });
        }

        // Initial load
        loadCustomers();

        // Pagination click
        $(document).on("click", ".pagination .page-link", function (e) {
            e.preventDefault();
            let page = $(this).data("page");
            let search = $(".form-control").val();
            loadCustomers(page, search);
        });

        // Search input
        $(".form-control").on("input", function () {
            let search = $(this).val();
            loadCustomers(1, search);
        });
    }
});

$("#edit_service_form").on("submit", function (e) {
	e.preventDefault();
	// alert('hh');
	// return;
	var formData = new FormData(this);

	$.ajax({
		url: site_url + "provider/service/update",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response.status) {
				Swal.fire({
					icon: "success",
					title: "Updated",
					text: response.message,
					timer: 2000,
					showConfirmButton: false,
				}).then(() => {
					window.location.href = site_url + "service";
				});
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: response.message,
				});
			}
		},
		error: function () {
			Swal.fire("Error", "Something went wrong!", "error");
		},
	});
});
$(document).ready(function () {
	$("#ProfileForm").on("submit", function (e) {
		e.preventDefault();

		let form = this;
		let formData = new FormData(form);

		// Clear previous validation errors
		$(".is-invalid").removeClass("is-invalid");
		$(".invalid-feedback").remove();

		let isValid = true;

		$(form)
			.find("input, select, textarea")
			.each(function () {
				let $input = $(this);
				let value = $input.val();

				// Skip disabled or hidden fields
				if ($input.is(":disabled") || $input.is(":hidden")) return;

				// Handle multi-select
				if ($input.is("select[multiple]")) {
					if ($input.prop("required") && (!value || value.length === 0)) {
						$input.addClass("is-invalid");
						$input.after(
							'<div class="invalid-feedback">This field is required.</div>'
						);
						isValid = false;
					}
					return; // skip further checks for multi-select
				}

				// General required field validation
				if (
					$input.prop("required") &&
					(value === null || $.trim(value) === "")
				) {
					$input.addClass("is-invalid");
					$input.after(
						'<div class="invalid-feedback">This field is required.</div>'
					);
					isValid = false;
				}
			});

		if (!isValid) return;

		// Optional: disable submit button during save
		let $submitBtn = $(form).find('button[type="submit"]');
		$submitBtn.prop("disabled", true).text("Saving...");

		$.ajax({
			url: site_url + "provider/profile/save",
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				Swal.fire({
					icon: "success",
					title: "Profile Updated!",
					text: "Your information has been successfully saved.",
					confirmButtonColor: "#28a745",
				});
			},
			error: function (xhr) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Something went wrong. Please try again!",
					confirmButtonColor: "#dc3545",
				});
			},
			complete: function () {
				// Re-enable the submit button
				$submitBtn.prop("disabled", false).text("Save");
			},
		});
	});
});
$(document).ready(function () {
    // Use the correct ID that you render into
    if ($("#serviceTableBodyy").length > 0) {

        function loadServices(page = 1, search = "") {
            $.ajax({
                url: site_url + "provider/service/fetch_services",
                method: "POST",
                data: { page: page, search: search },
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        renderTable(res.data, res.page, res.limit); 
        renderPagination(res.total, res.page, res.limit, search);
                    } else {
                        renderTable([]);
                        renderPagination(0, 1, 5, search);
                    }
                }
            });
        }

      function renderTable(data, page, limit) {
    let html = "";
    if (!data || data.length === 0) {
        html = '<tr><td colspan="6" class="text-center">No records found</td></tr>';
    } else {
        const startIndex = (page - 1) * limit; 
        data.forEach((item, index) => {
            html += `<tr>
                <td>${startIndex + index + 1}</td> 
                <td><img src="${site_url + item.image}" width="50" /></td>
                <td>${item.name}</td>
                <td>
                  ${
                    item.isActive == 1
                      ? `<div class="d-flex align-items-center text-success">
                           <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                           <span>Published</span>
                         </div>`
                      : `<div class="d-flex align-items-center text-danger">
                           <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                           <span>Unpublished</span>
                         </div>`
                  }
                </td>
                <td>
                  <div class="d-flex order-actions align-items-center">
                    <a href="${site_url}edit_service/${item.id}" class="me-2" title="Edit">
                      <i class="bx bxs-edit"></i>
                    </a>
                    ${
                      item.isActive == 1
                        ? `<button class="btn btn-sm btn-danger toggle-status-btn_service" data-id="${item.id}" data-status="0">
                             <i class="bx bx-x-circle me-1"></i> Unpublish
                           </button>`
                        : `<button class="btn btn-sm btn-success toggle-status-btn_service" data-id="${item.id}" data-status="1">
                             <i class="bx bx-check-circle me-1"></i> Publish
                           </button>`
                    }
                  </div>
                </td>
            </tr>`;
        });
    }
    $("#serviceTableBody").html(html);
}


        function renderPagination(total, page, limit, search) {
            page  = parseInt(page || 1, 10);
            limit = parseInt(limit || 5, 10);
            const totalPages = Math.ceil((parseInt(total || 0, 10)) / limit);

            // If no pages, clear pagination
            if (!totalPages || totalPages <= 1) {
                $(".pagination").html("");
                return;
            }

            let pagHtml = "";

            // Prev
            pagHtml += `<li class="page-item ${page === 1 ? "disabled" : ""}">
                            <a class="page-link" href="#" data-page="${page - 1}">Prev</a>
                        </li>`;

            for (let i = 1; i <= totalPages; i++) {
                pagHtml += `<li class="page-item ${page === i ? "active" : ""}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }

            // Next
            pagHtml += `<li class="page-item ${page === totalPages ? "disabled" : ""}">
                            <a class="page-link" href="#" data-page="${page + 1}">Next</a>
                        </li>`;

            $(".pagination").html(pagHtml);
        }

        // Initial load
        loadServices();

        // Pagination click
        $(document).on("click", ".pagination .page-link", function (e) {
            e.preventDefault();
            const page = parseInt($(this).data("page"), 10) || 1;
            const search = $(".service-search").val() || "";
            loadServices(page, search);
        });

        // Optional: search input with class .service-search
        $(".service-search").on("input", function () {
            loadServices(1, $(this).val());
        });
    }
});


function renderPagination(total, currentPage, limit, search) {
	const totalPages = Math.ceil(total / limit);
	let start = Math.max(1, currentPage - 1);
	let end = Math.min(start + 2, totalPages);

	if (end - start < 2) start = Math.max(1, end - 2);

	let html = "";

	if (currentPage > 1) {
		html += `<li class="page-item"><a class="page-link" href="javascript:;" onclick="loadServices(${
			currentPage - 1
		}, '${search}')">Previous</a></li>`;
	}

	for (let i = start; i <= end; i++) {
		html += `<li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="javascript:;" onclick="loadServices(${i}, '${search}')">${i}</a>
                </li>`;
	}

	if (currentPage < totalPages) {
		html += `<li class="page-item"><a class="page-link" href="javascript:;" onclick="loadServices(${
			currentPage + 1
		}, '${search}')">Next</a></li>`;
	}

	$(".pagination").html(html);
}


document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("profileImageInput");
  if (!input) return; // Element not found, exit safely

  input.addEventListener("change", function (e) {
    const preview = document.getElementById("previewImage");
    const file = e.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        preview.src = event.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
      preview.style.display = "none";
    }
  });
});
$('#scheduleForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: site_url + "provider/wallet/save_schedule",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            const res = typeof response === "string" ? JSON.parse(response) : response;
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Schedule Updated',
                    text: 'Schedule updated successfully!',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error saving schedule.',
                    confirmButtonText: 'Try Again'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Something went wrong while saving schedule.',
                confirmButtonText: 'OK'
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("bankDetailsForm");
if (!form) return;
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Bootstrap validation
        if (!form.checkValidity()) {
            form.classList.add("was-validated");
            return;
        }

       
        // const providerId = document.getElementById("providerId").value.trim();
        // if (!providerId) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Missing Provider',
        //         text: 'Provider ID is missing. Please refresh the page and try again.'
        //     });
        //     return;
        // }

        // Extra validation: confirm account numbers
        const accountNumber = document.getElementById("accountNumber").value.trim();
        const confirmAccountNumber = document.getElementById("confirmAccountNumber").value.trim();

        if (accountNumber !== confirmAccountNumber) {
            Swal.fire({
                icon: 'error',
                title: 'Mismatch',
                text: 'Account numbers do not match!'
            });
            return;
        }

        // Collect form data
        const formData = new FormData();
        formData.append("provider_id", providerId);
        formData.append("accountHolderName", document.getElementById("accountHolderName").value.trim());
        formData.append("bankName", document.getElementById("bankName").value.trim());
        formData.append("accountNumber", accountNumber);
        formData.append("ifscCode", document.getElementById("ifscCode").value.trim().toUpperCase());
        formData.append("accountType", document.getElementById("accountType").value);
        formData.append("branchName", document.getElementById("branchName").value.trim());

        // Send via AJAX
        fetch(site_url + "provider/profile/saveBankDetails", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Saved",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                form.reset();
                form.classList.remove("was-validated");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Failed",
                text: "Something went wrong. Please try again."
            });
        });
    });
});

function shareProfile(profileUrl) {
    if (navigator.share) {
        navigator.share({
            title: 'My Profile',
            text: 'Check out my fitness profile!',
            url: profileUrl
        }).catch(err => console.error('Error sharing:', err));
    } else {
        // Fallback for browsers that don't support Web Share API
        navigator.clipboard.writeText(profileUrl).then(() => {
            alert("Profile link copied to clipboard:\n" + profileUrl);
        });
    }
}
document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("service_image");
  if (!input) return; 

  input.addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("image_previeww");
    if (!preview) return; 

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      preview.src = "noimage.png";
    }
  });
});
 $(document).ready(function () {
            // alert('h');
  $("#citySelect").select2({
    placeholder: "Select available cities",
    allowClear: true,
    tags: false,
    width: "100%",
    theme: "bootstrap-5",
  });
 document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('#expertiseTags');

    if (!input) {
        console.warn('Tagify: #expertiseTags not found');
        return;
    }

    new Tagify(input, {
        whitelist: [],
        dropdown: {
            enabled: 0,
        },
    });
});

  $('#js-example-basic-multiple').select2();({
     placeholder: "Select Prefer Languages",
    allowClear: true,
    tags: false,
    width: "100%",
    theme: "bootstrap-5",
  })
});
$(document).ready(function () {
  $("#offer_form").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: site_url + "provider/service/save_offer",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function () {
        Swal.fire({
          title: 'Saving...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
      },
      success: function (res) {
        Swal.close();
        if (res.status === "success") {
          Swal.fire({
            title: "Success",
            text: "Offers saved successfully!",
            icon: "success",
            timer: 1500,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire("Error", "Something went wrong!", "error");
        }
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.querySelector('input[type="file"]');

    if (!fileInput) return; // safety check

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        const preview = document.getElementById('certificatePreview');
        const img = document.getElementById('previewImage');
        const fileName = document.getElementById('previewFileName');

        if (!file) return;

        preview.classList.remove('d-none');
        fileName.textContent = file.name;

        if (file.type.startsWith('image/')) {
            img.src = URL.createObjectURL(file);
            img.classList.remove('d-none');
        } else {
            img.classList.add('d-none');
        }
    });
});

$("#certificationForm").on("submit", function (e) {
    e.preventDefault();

    let title = $("#title").val().trim();
    let file = $("#certificate")[0].files.length;

    // 🔒 Frontend Validation
    if (title === "") {
        Swal.fire("Validation Error", "Certificate title is required", "warning");
        return;
    }

    if (!file) {
        Swal.fire("Validation Error", "Please upload certificate file", "warning");
        return;
    }

    let formData = new FormData(this);

    $.ajax({
        url: site_url +"provider/profile/save_certificate",   // backend URL
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",

        beforeSend: function () {
            Swal.fire({
                title: "Uploading...",
                text: "Please wait",
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },

        success: function (res) {
            if (res.status) {
                Swal.fire("Success", res.message, "success").then(() => {
                    location.reload();
                });
            } else {
                Swal.fire("Error", res.message, "error");
            }
        },

        error: function () {
            Swal.fire("Error", "Something went wrong", "error");
        }
    });
});
$(document).on("click", ".delete-cert", function (e) {
    e.preventDefault();
    e.stopPropagation();

    let certId = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This certification will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: site_url + "provider/profile/delete_certificate",
                type: "POST",
                data: { id: certId },
                dataType: "json",

                success: function (res) {
                    if (res.status) {
                        Swal.fire("Deleted!", res.message, "success");
                        $(`[data-id="${certId}"]`).closest('.col-lg-3').fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                },

                error: function () {
                    Swal.fire("Error", "Something went wrong!", "error");
                }
            });

        }
    });
});
