$(document).ready(function () {
	const defaultImage = site_url + "assets/images/no-image.png";

	// Show preview on image upload
	$("#categoryImage").on("change", function (event) {
		const file = event.target.files[0];
		const preview = document.getElementById("previewImage");

		if (file) {
			const reader = new FileReader();
			reader.onload = function (e) {
				preview.src = e.target.result;
			};
			reader.readAsDataURL(file);
		} else {
			preview.src = defaultImage;
		}
	});
	let pageIndex = 1;
let searchQuery = '';

function fetchBookings(page = 1, search = '') {
    $.ajax({
        url: GET_BOOKINGS_URL,
        type: 'GET',
        data: {
            page: page,
            search: search
        },
        success: function (response) {
            const data = typeof response === 'string' ? JSON.parse(response) : response;
            console.log('Fetched data:', data);
            renderBookings(data.bookings, data.page, data.limit);
            renderPagination(data.page, data.total, data.limit);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            $('#bookingTableBody').html('<tr><td colspan="6" class="text-center">Error loading bookings</td></tr>');
        }
    });
}

function renderBookings(bookings, page, limit) {
    let html = '';
    const offset = (page - 1) * limit;

    if (bookings.length === 0) {
        html = '<tr><td colspan="6" class="text-center">No bookings found</td></tr>';
    } else {
        bookings.forEach((booking, index) => {
            html += `
                <tr>
                    <td>${offset + index + 1}</td>
                    <td>${booking.name}</td>
                    <td>${booking.mobile}</td>
                    <td>${booking.created_at}</td>
                    <td>₹${booking.total}</td>
                    <td>
                        <a href="${BASE_URL}provider/booking/${booking.id}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>`;
        });
    }
    $('#bookingTableBody').html(html);
}

function renderPagination(current, total, limit) {
    let totalPages = Math.ceil(total / limit);
    let pagination = '';

    if (totalPages <= 1) {
        $('#paginationContainer').html('');
        return;
    }

    if (current > 1) {
        pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${current - 1}">Previous</a></li>`;
    }

    let startPage, endPage;
    if (totalPages <= 3) {
        startPage = 1;
        endPage = totalPages;
    } else if (current <= 2) {
        startPage = 1;
        endPage = 3;
    } else if (current >= totalPages - 1) {
        startPage = totalPages - 2;
        endPage = totalPages;
    } else {
        startPage = current - 1;
        endPage = current + 1;
    }

    for (let i = startPage; i <= endPage; i++) {
        pagination += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
    }

    if (current < totalPages) {
        pagination += `<li class="page-item"><a class="page-link" href="#" data-page="${current + 1}">Next</a></li>`;
    }

    $('#paginationContainer').html(pagination);
}

$(document).ready(function () {
    fetchBookings(pageIndex);

    $(document).on('click', '#paginationContainer .page-link', function (e) {
        e.preventDefault();
        const page = parseInt($(this).attr('data-page'), 10);
        if (!isNaN(page)) {
            pageIndex = page;
            fetchBookings(pageIndex, searchQuery);
        }
    });

    $('input[type="text"]').on('input', function () {
        searchQuery = $(this).val();
        pageIndex = 1;
        fetchBookings(pageIndex, searchQuery);
    });
});


	// Bootstrap validation + AJAX Submit with SweetAlert
	$("#CategoryForm").on("submit", function (e) {
		e.preventDefault();

		const form = this;
		if (!form.checkValidity()) {
			form.classList.add("was-validated");
			return;
		}

		const formData = new FormData(this);

		$.ajax({
			url: site_url + "admin/category/save",
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
						text: response.message || "Category saved successfully!",
						confirmButtonColor: "#3085d6",
						confirmButtonText: "OK",
					});

					form.reset();
					$("#previewImage").attr("src", defaultImage);
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
					$("#image_preview").attr("src", defaultImage);
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
});
$(document).ready(function () {
	$("#SubcategoryForm").on("submit", function (e) {
		e.preventDefault();

		const form = this;
		if (!form.checkValidity()) {
			form.classList.add("was-validated");
			return;
		}

		const subcategoryTitle = $("#subcategoryTitle").val();
		const mainCategoryId = $("#mainCategory").val();

		$.ajax({
			url: site_url + "admin/category/save_sub_category",
			type: "POST",
			dataType: "json",
			data: {
				subcategory_title: subcategoryTitle,
				main_category_id: mainCategoryId,
			},
			success: function (response) {
				if (response.success === "exist") {
					Swal.fire({
						icon: "warning",
						title: "Duplicate Entry",
						text: "This subcategory already exists under the selected category.",
					});
				} else if (response.success === true) {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: "Subcategory saved successfully!",
					});

					form.reset();
					form.classList.remove("was-validated");
				} else {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "Failed to save subcategory.",
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: "error",
					title: "Server Error",
					text: "Something went wrong while saving the subcategory.",
				});
			},
		});
	});
});

$(document).ready(function () {
	const per_group = 3;
	let searchText = "";
	let currentPage = 1;

	function loadPage(page = 1) {
		$.ajax({
			url: site_url + "admin/category/ajax_list",
			type: "POST",
			dataType: "json",
			data: { page, search: searchText },
			success: function (res) {
				currentPage = res.current_page;
				renderTable(res.data);
				renderPagination(res.current_page, res.total_pages);
			},
		});
	}

	function renderTable(data) {
		let rows = "";
		data.forEach((row, i) => {
			rows += `
      <tr>
        <td>${(currentPage - 1) * 10 + i + 1}</td>
        <td><img src="${site_url + row.image}" style="max-width:50px"/></td>
        <td>${row.name}</td>
        <td>
      ${
				row.isActive == 1
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
           		<a href="${site_url}edit_main/${
				row.id
			}" class="me-2"><i class="bx bxs-edit"></i></a>

            ${
							row.isActive == 1
								? `<button class="btn btn-sm btn-danger toggle-status-btn" data-id="${row.id}" data-status="0">
                     <i class="bx bx-x-circle me-1"></i> Unpublish
                   </button>`
								: `<button class="btn btn-sm btn-success toggle-status-btn" data-id="${row.id}" data-status="1">
                     <i class="bx bx-check-circle me-1"></i> Publish
                   </button>`
						}
          </div>
        </td>
      </tr>`;
		});

		// Define table IDs you want to update
		const tableIds = ["#categoryTableBody"];

		tableIds.forEach((id) => {
			$(id).html(
				rows ||
					`<tr><td colspan="5" class="text-center">No records found</td></tr>`
			);
		});
	}

	function renderPagination(curr, total) {
		let html = "";
		const half = Math.floor(per_group / 2);
		let start = Math.max(1, curr - half);
		let end = Math.min(total, start + per_group - 1);
		if (end - start + 1 < per_group) {
			start = Math.max(1, end - per_group + 1);
		}

		html += `<li class="page-item ${curr === 1 ? "disabled" : ""}">
               <a class="page-link" href="javascript:;" data-page="${
									curr - 1
								}">Previous</a></li>`;

		for (let p = start; p <= end; p++) {
			html += `<li class="page-item ${curr === p ? "active" : ""}">
                 <a class="page-link" href="javascript:;" data-page="${p}">${p}</a></li>`;
		}

		html += `<li class="page-item ${curr === total ? "disabled" : ""}">
               <a class="page-link" href="javascript:;" data-page="${
									curr + 1
								}">Next</a></li>`;

		$(".pagination").html(html);
	}

	// Pagination click
	$(document).on("click", ".pagination .page-link", function () {
		const page = $(this).data("page");
		if (page >= 1) loadPage(page);
	});

	// Search input
	$('.form-control[placeholder*="Search"]').on("keyup", function (e) {
		searchText = $(this).val();
		loadPage(1);
	});

	// Initialize
	loadPage();
});

$(document).on("click", ".toggle-status-btn", function () {
	const button = $(this);
	const postId = button.data("id");
	const newStatus = button.data("status");

	$.ajax({
		url: site_url + "admin/category/toggle_status",
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
							<td>
						<a href="<?= base_url('customers/view/' . $item->id); ?>" class="btn btn-primary btn-sm radius-30 px-4">
							View Details
						</a>
						</td>
						

                        </tr>
                    `;
				});
				$("#customerTableBody").html(html);

				// Pagination
				let totalPages = Math.ceil(res.total / res.limit);
				let pagHtml = "";
				for (let i = 1; i <= totalPages; i++) {
					pagHtml += `<li class="page-item ${
						res.page == i ? "active" : ""
					}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
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
});

// city & state toggel
$(document).on("click", ".toggle-status-btn_city", function () {
	const button = $(this);
	const postId = button.data("id");
	const newStatus = button.data("status");

	$.ajax({
		url: site_url + "admin/category/toggle_status_city",
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
// subcategory
$(document).ready(function () {
	const perPage = 3;
	let currentPage = 1;
	let searchText = "";

	function loadSubcategories(page = 1) {
		$.ajax({
			url: site_url + "admin/category/sub_ajax_list",
			type: "POST",
			dataType: "json",
			data: {
				page: page,
				search: searchText,
			},
			success: function (res) {
				renderTable(res.data, res.start_index);
				renderPagination(res.current_page, res.total_pages);
			},
		});
	}

	function renderTable(data, startIndex) {
		let rows = "";

		if (data.length === 0) {
			rows = `<tr><td colspan="5" class="text-center">No records found</td></tr>`;
		} else {
			data.forEach((row, i) => {
				rows += `
				<tr>
					<td>${startIndex + i}</td>
					<td>${row.category_name}</td>
					<td>${row.subcategory_name}</td>
					<td>
					
      ${
				row.isActive == 1
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
		<!-- Edit Button with Icon -->
		<a href="${site_url}edit/${row.id}" class="me-2"><i class="bx bxs-edit"></i></a>

		<!-- Publish / Unpublish Button with Icon -->
		<button class="btn btn-sm btn-${
			row.isActive == 1 ? "danger" : "success"
		} toggle-status-btn"
			data-id="${row.id}" data-status="${row.isActive == 1 ? 0 : 1}" title="${
					row.isActive == 1 ? "Unpublish" : "Publish"
				}">
			<i class="bx ${row.isActive == 1 ? "bx-x-circle" : "bx-check-circle"} me-1"></i>
			${row.isActive == 1 ? "Unpublish" : "Publish"}
		</button>
	</div>
</td>	
				</tr>`;
			});
		}

		$("#SubcategoryTableBody").html(rows);
	}

	function renderPagination(current, total) {
		let html = "";
		const maxPagesToShow = 3;
		let start = Math.max(1, current - 1);
		let end = Math.min(total, start + maxPagesToShow - 1);

		if (end - start + 1 < maxPagesToShow) {
			start = Math.max(1, end - maxPagesToShow + 1);
		}

		html += `<li class="page-item ${current === 1 ? "disabled" : ""}">
			<a class="page-link" href="javascript:;" data-page="${current - 1}">Previous</a>
		</li>`;

		for (let i = start; i <= end; i++) {
			html += `<li class="page-item ${i === current ? "active" : ""}">
				<a class="page-link" href="javascript:;" data-page="${i}">${i}</a>
			</li>`;
		}

		html += `<li class="page-item ${current === total ? "disabled" : ""}">
			<a class="page-link" href="javascript:;" data-page="${current + 1}">Next</a>
		</li>`;

		$(".pagination").html(html);
	}

	$(document).on("click", ".pagination .page-link", function () {
		const page = $(this).data("page");
		if (page) {
			currentPage = page;
			loadSubcategories(currentPage);
		}
	});

	$(".form-control[placeholder*='Search']").on("keyup", function () {
		searchText = $(this).val();
		currentPage = 1;
		loadSubcategories(currentPage);
	});

	$(document).on("click", ".toggle-status-btn-2", function () {
		const id = $(this).data("id");
		const status = $(this).data("status");

		$.ajax({
			url: site_url + "admin/category/toggle_status_sub_2",
			type: "POST",
			data: { id, status },
			dataType: "json",
			success: function (res) {
				if (res.success) {
					Swal.fire({
						icon: "success",
						title: res.message,
						timer: 2000,
						showConfirmButton: false,
					});
					setTimeout(() => loadSubcategories(currentPage), 2000);
				} else {
					Swal.fire("Error", res.message, "error");
				}
			},
		});
	});

	// Initial load
	loadSubcategories(currentPage);
});
$(document).ready(function () {
	let limit = 10; // rows per page
	let offset = 0;

	function loadPartners(offset, search = "") {
		$.ajax({
			url: site_url + "admin/partner/fetchPartners",
			type: "POST",
			data: { limit: limit, offset: offset, search: search },
			dataType: "json",
			success: function (response) {
				let html = "";
				if (response.partners.length > 0) {
					$.each(response.partners, function (index, partner) {
						html += `<tr>
                            <td>${offset + index + 1}</td>
                            <td><img src="${
															partner.profile_image
														}" alt="Image" width="50"></td>
                            <td>${partner.partner_name}</td>
                            <td>${partner.gym_name}</td>
                            <td>${partner.mobile}</td>
                            <td>${partner.address}</td>
							<td>
							<div class="d-flex order-actions align-items-center">
								<a href="${site_url}loginAsPartner/${partner.id}" 
           class="ms-2" title="Login">
            <i class="bx bx-log-in"></i>
        </a>
								<a href="javascript:void(0);" class="btn-toggle-status ms-2" 
								data-id="${partner.id}" 
								data-status="${partner.user_isActive}"
								title="${partner.user_isActive == 1 ? "Deactivate" : "Activate"}">
								<i class="bx ${partner.user_isActive == 1 ? "bx-user-x" : "bx-user-check"}"></i>
								</a>
							</div>
								
							</td>
                        </tr>`;
					});
				} else {
					html = `<tr><td colspan="6" class="text-center">No partners found</td></tr>`;
				}
				$("#partnerTableBody").html(html);

				// Pagination
				let totalPages = Math.ceil(response.total / limit);
				let paginationHtml = "";
				for (let i = 0; i < totalPages; i++) {
					paginationHtml += `<li class="page-item ${
						offset / limit == i ? "active" : ""
					}">
                        <a class="page-link" href="#" data-offset="${
													i * limit
												}">${i + 1}</a></li>`;
				}
				$(".pagination").html(`
                    <li class="page-item"><a class="page-link prev" href="#">Previous</a></li>
                    ${paginationHtml}
                    <li class="page-item"><a class="page-link next" href="#">Next</a></li>
                `);
			},
		});
	}

	// Initial load
	loadPartners(offset);

	// Search
	$(".radius-30").keyup(function () {
		let search = $(this).val();
		offset = 0;
		loadPartners(offset, search);
	});

	$(document).on("click", ".btn-toggle-status", function () {
		let partnerId = $(this).data("id");
		let currentStatus = $(this).data("status");
		let newStatus = currentStatus == 1 ? 0 : 1;

		let actionText = newStatus == 0 ? "deactivate" : "activate";

		Swal.fire({
			title: `Are you sure you want to ${actionText} this partner?`,
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: `Yes, ${actionText}!`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: site_url + "admin/partner/togglePartnerStatus",
					type: "POST",
					data: { partner_id: partnerId, status: newStatus },
					dataType: "json",
					success: function (response) {
						if (response.status === "success") {
							Swal.fire({
								icon: "success",
								title: `Partner ${actionText}d successfully.`,
								timer: 1500,
								showConfirmButton: false,
							});
							loadPartners(offset, $(".radius-30").val());
						} else {
							Swal.fire({
								icon: "error",
								title: "Failed!",
								text: response.message,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: "error",
							title: "Error",
							text: "Something went wrong!",
						});
					},
				});
			}
		});
	});

	// Pagination click
	$(document).on("click", ".pagination .page-link", function (e) {
		e.preventDefault();
		let page = $(this).data("offset");
		if (page !== undefined) {
			offset = page;
			loadPartners(offset, $(".radius-30").val());
		}
	});

	// Prev/Next
	$(document).on("click", ".pagination .prev", function () {
		if (offset >= limit) {
			offset -= limit;
			loadPartners(offset, $(".radius-30").val());
		}
	});
	$(document).on("click", ".pagination .next", function () {
		offset += limit;
		loadPartners(offset, $(".radius-30").val());
	});
});
$("#EditSubcategoryForm").on("submit", function (e) {
	e.preventDefault(); // Prevent form from submitting normally

	let form = $(this)[0];
	let formData = new FormData(form);

	$.ajax({
		url: site_url + "admin/category/edit_subcategory",
		type: "POST",
		data: formData,
		processData: false,
		contentType: false,
		dataType: "json",
		beforeSend: function () {
			// Optional: Show loading spinner
		},
		success: function (response) {
			if (response.status) {
				Swal.fire({
					icon: "success",
					title: "Updated",
					text: response.message,
					timer: 2000,
					showConfirmButton: false,
				}).then(() => {
					window.location.href = site_url + "sub_category";
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
			Swal.fire({
				icon: "error",
				title: "AJAX Error",
				text: "Something went wrong with the request.",
			});
		},
	});
});
$("#editCategoryForm").on("submit", function (e) {
	e.preventDefault();
	// alert('hh');
	// return;
	var formData = new FormData(this);

	$.ajax({
		url: site_url + "admin/category/update_main_cat",
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
					window.location.href = site_url + "category";
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
	$("#SliderForm").on("submit", function (e) {
		e.preventDefault();
		// alert('h');
		// return;
		// Clear validation styles
		$("#SliderForm").find(".is-invalid").removeClass("is-invalid");

		let isValid = true;

		// Validate title
		if ($("#sliderTitle").val().trim() === "") {
			$("#sliderTitle").addClass("is-invalid");
			isValid = false;
		}

		// Validate image (only if creating new; skip if editing and image already exists)
		const imageFile = $("#slider_image")[0].files[0];
		if (!imageFile) {
			// $('#slider_image').addClass('is-invalid');
			isValid = false;
		}

		// Validate display order
		if ($("#displayOrder").val() === "") {
			$("#displayOrder").addClass("is-invalid");
			isValid = false;
		}

		if (!isValid) return;

		// Prepare FormData
		var formData = new FormData(this);

		$.ajax({
			url: site_url + "admin/category/create",
			type: "POST",
			data: formData,
			dataType: "json",
			contentType: false,
			processData: false,
			beforeSend: function () {
				$(".btn-success").prop("disabled", true).text("Submitting...");
			},
			success: function (response) {
				$(".btn-success").prop("disabled", false).text("Submit");

				if (response.status) {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: response.message,
						timer: 2000,
						showConfirmButton: false,
					}).then(() => {
						window.location.href = site_url + "slider";
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
				$(".btn-success").prop("disabled", false).text("Submit");
				Swal.fire(
					"Error",
					"Something went wrong while submitting the form.",
					"error"
				);
			},
		});
	});
});
let currentPage = 1;
let searchKeyword = "";

function fetchSliders(page = 1, keyword = "") {
	$.ajax({
		url: site_url + "admin/category/ajax_list_slider",
		type: "POST",
		data: {
			page: page,
			keyword: keyword,
		},
		dataType: "json",
		success: function (res) {
			if (res.status) {
				$("#sliderTableBody").html(res.html);
				$(".pagination").html(res.pagination);
				currentPage = page;
			} else {
				$("#sliderTableBody").html(
					'<tr><td colspan="7" class="text-center">No records found</td></tr>'
				);
				$(".pagination").html("");
			}
		},
	});
}

// Pagination click
$(document).on("click", ".page-link", function () {
	let page = $(this).data("page");
	if (page) {
		fetchSliders(page, searchKeyword);
	}
});

// Search input
$('input[type="text"]').on("keyup", function () {
	searchKeyword = $(this).val();
	fetchSliders(1, searchKeyword); // reset to first page on search
});

// Initial load
fetchSliders();

$(document).on("click", ".toggle-status-btn_slider", function () {
	const button = $(this);
	const postId = button.data("id");
	const newStatus = button.data("status");

	$.ajax({
		url: site_url + "admin/category/toggle_status_slider",
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
const geonamesUsername = "rvmawar"; // Replace with your actual GeoNames username

const stateCodeMap = {}; // We'll store state name => adminCode1 mapping

$(document).ready(function () {
	// Load all Indian states with their codes
	$.ajax({
		url: "https://secure.geonames.org/childrenJSON",
		method: "GET",
		data: {
			geonameId: 1269750, // India
			username: geonamesUsername,
		},
		success: function (response) {
			response.geonames.forEach(function (state) {
				const name = state.name;
				const code = state.adminCode1;

				stateCodeMap[name] = code;

				$("#state").append(`<option value="${name}">${name}</option>`);
			});
		},
		error: function () {
			// alert("Error fetching states.");
		},
	});

	// On state change, fetch cities strictly by adminCode1
	$("#state").on("change", function () {
		// alert('h');
		const selectedState = $(this).val();
		const adminCode1 = stateCodeMap[selectedState];

		if (adminCode1) {
			$.ajax({
				url: "https://secure.geonames.org/searchJSON",
				method: "GET",
				data: {
					country: "IN",
					adminCode1: adminCode1,
					featureClass: "P",
					maxRows: 1000,
					username: geonamesUsername,
				},
				success: function (response) {
					$("#city").empty().append('<option value="">Select City</option>');
					response.geonames.forEach(function (city) {
						$("#city").append(
							`<option value="${city.name}">${city.name}</option>`
						);
					});
				},
				error: function () {
					alert("Error fetching cities.");
				},
			});
		} else {
			$("#city").empty().append('<option value="">Select City</option>');
		}
	});
});

$("#CityForm").on("submit", function (e) {
	e.preventDefault();

	const state = $("#state").val();
	const city = $("#city").val();

	if (state === "" || city === "") {
		Swal.fire("Required", "Please select both state and city", "warning");
		return;
	}

	$.ajax({
		url: site_url + "admin/category/save_city", // define `base_url` globally in your layout
		method: "POST",
		data: { state: state, city: city },
		success: function (response) {
			Swal.fire("Success", "City saved successfully", "success");
			$("#CityForm")[0].reset();
			$("#city").empty().append('<option value="">Select City</option>');
		},
		error: function () {
			Swal.fire("Error", "Something went wrong while saving.", "error");
		},
	});
});
$(document).ready(function () {
	let currentPage = 1;
	let searchKeyword = "";

	// Initial fetch
	fetchCityList();

	// Search handler
	$('input[type="text"]').on("keyup", function () {
		searchKeyword = $(this).val();
		currentPage = 1;
		fetchCityList();
	});

	// Pagination click
	$(document).on("click", ".page-link", function () {
		const page = $(this).data("page");
		if (page) {
			currentPage = page;
			fetchCityList();
		}
	});

	function fetchCityList() {
		$.ajax({
			url: site_url + "admin/category/ajax_list_city",
			method: "POST",
			dataType: "json",
			data: {
				search: searchKeyword,
				page: currentPage,
			},
			success: function (res) {
				let rows = "";
				let i = res.start + 1;

				if (res.data.length > 0) {
					res.data.forEach(function (row) {
						let status =
							row.isActive == 1
								? '<span class="badge bg-success">Publish</span>'
								: '<span class="badge bg-danger">Unpublish</span>';

						rows += `
							<tr>
								<td>${i++}</td>
								<td>${row.state}</td>
								<td>${row.city}</td>
								<td>
								${
									row.isActive == 1
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
									<a href="${site_url}edit_city/${
							row.id
						}" class="me-2"><i class="bx bxs-edit"></i></a>

									${
										row.isActive == 1
											? `<button class="btn btn-sm btn-danger toggle-status-btn_city" data-id="${row.id}" data-status="0">
														<i class="bx bx-x-circle me-1"></i> Unpublish
													</button>`
											: `<button class="btn btn-sm btn-success toggle-status-btn_city" data-id="${row.id}" data-status="1">
														<i class="bx bx-check-circle me-1"></i> Publish
													</button>`
									}
								</div>
							</td>
							</tr>
						`;
					});
				} else {
					rows = `<tr><td colspan="5" class="text-center">No data found</td></tr>`;
				}

				$("#cityTableBody").html(rows);
				renderPagination(res.total_pages, res.current_page);
			},
			// error: function () {
			// 	alert("Failed to fetch data.");
			// },
		});
	}

	function renderPagination(totalPages, currentPage) {
		let pag = "";
		if (totalPages > 1) {
			if (currentPage > 1) {
				pag += `<li class="page-item"><a class="page-link" href="javascript:;" data-page="${
					currentPage - 1
				}">Previous</a></li>`;
			}

			for (let i = 1; i <= totalPages; i++) {
				let active = i == currentPage ? "active" : "";
				pag += `<li class="page-item ${active}"><a class="page-link" href="javascript:;" data-page="${i}">${i}</a></li>`;
			}

			if (currentPage < totalPages) {
				pag += `<li class="page-item"><a class="page-link" href="javascript:;" data-page="${
					currentPage + 1
				}">Next</a></li>`;
			}
		}
		$(".pagination").html(pag);
	}
});
$(document).ready(function () {
	const geoUsername = "rvmawar"; // Replace with your GeoNames username

	// Fetch states on page load
	$.ajax({
		url:
			"http://api.geonames.org/childrenJSON?geonameId=1269750&username=" +
			geoUsername,
		method: "GET",
		success: function (response) {
			$("#edit_state").append('<option value="">Select State</option>');
			response.geonames.forEach(function (state) {
				$("#edit_state").append(
					`<option value="${state.name}">${state.name}</option>`
				);
			});
		},
	});

	// When state changes, fetch cities
	$("#edit_state").on("change", function () {
		const stateName = $(this).val();
		if (!stateName) return;

		$("#edit_city").empty().append('<option value="">Loading...</option>');

		$.ajax({
			url:
				"http://api.geonames.org/searchJSON?formatted=true&q=" +
				stateName +
				"&adminCode1=&maxRows=1000&country=IN&featureClass=P&username=" +
				geoUsername,
			method: "GET",
			success: function (response) {
				$("#edit_city").empty().append('<option value="">Select City</option>');
				const cities = [...new Set(response.geonames.map((city) => city.name))];
				cities.forEach(function (city) {
					$("#edit_city").append(`<option value="${city}">${city}</option>`);
				});
			},
		});
	});

	// Check if state is selected when city dropdown is clicked
	$("#edit_city").on("focus", function () {
		if ($("#edit_state").val() === "") {
			Swal.fire("Please select a state first");
			$(this).blur();
		}
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
	$("#EditCityForm").on("submit", function (e) {
		e.preventDefault();

		let city_id = $('input[name="city_id"]').val().trim();
		let state = $("#state").val().trim();
		let city = $("#city").val().trim();

		if (state === "" || city === "") {
			Swal.fire("Error", "Both state and city are required.", "error");
			return;
		}

		$.ajax({
			url: site_url + "admin/category/update_city",
			type: "POST",
			data: {
				city_id: city_id,
				state: state,
				city: city,
			},
			dataType: "json",
			success: function (res) {
				if (res.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Updated",
						text: "City and State updated successfully.",
						showConfirmButton: false,
						timer: 1500,
					}).then(() => {
						window.location.href = site_url + "city";
					});
				} else {
					Swal.fire("Failed", res.message || "Something went wrong!", "error");
				}
			},
			error: function () {
				Swal.fire("Error", "AJAX call failed!", "error");
			},
		});
	});
});
function loadServices(page = 1, search = "") {
	$.ajax({
		url: site_url + "provider/service/fetch_services",
		method: "POST",
		data: { page, search },
		dataType: "json",
		success: function (res) {
			if (res.status === "success") {
				renderTable(res.data);
				renderPagination(res.total, res.page, res.limit, search);
			}
		},
	});
}

function renderTable(data) {
	let html = "";
	if (data.length === 0) {
		html = '<tr><td colspan="6">No records found</td></tr>';
	} else {
		data.forEach((item, index) => {
			html += `<tr>
                <td>${index + 1}</td>
                <td><img src="${site_url + item.image}" width="50"/></td>
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
                    <a href="${site_url}edit_service/${
				item.id
			}" class="me-2" title="Edit">
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

$(document).ready(function () {
	loadServices();

	$(".radius-30").on("input", function () {
		const search = $(this).val();
		loadServices(1, search);
	});
});
$(document).ready(function () {
	$("#categorySelect").on("change", function () {
		let categoryId = $(this).val();

		if (categoryId) {
			$.ajax({
				url: site_url + "provider/profile/get_subcategories",
				type: "POST",
				data: { category_id: categoryId },
				dataType: "json",
				success: function (data) {
					if (data.length > 0) {
						let options = '<option value="">-- Select Subcategory --</option>';
						$.each(data, function (i, subcat) {
							options += `<option value="${subcat.id}">${subcat.title}</option>`;
						});
						$("#subcategorySelect").html(options);
						$("#subcategoryWrapper").show();
					} else {
						$("#subcategoryWrapper").hide();
						$("#subcategorySelect").html("");
					}
				},
			});
		} else {
			$("#subcategoryWrapper").hide();
			$("#subcategorySelect").html("");
		}
	});
});

$(document).ready(function () {
	$("#citySelect").select2({
		placeholder: "Select available cities",
		allowClear: true,
		tags: false,
		width: "100%",
		theme: "bootstrap-5",
	});
	var input = document.querySelector("#expertiseTags");
	new Tagify(input, {
		whitelist: [], // Optional: Add predefined suggestions
		dropdown: {
			enabled: 0, // Set 1 to show suggestions on focus
		},
	});
});
document
	.getElementById("profileImageInput")
	.addEventListener("change", function (e) {
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

document
	.getElementById("service_image")
	.addEventListener("change", function (event) {
		const file = event.target.files[0];
		const preview = document.getElementById("image_preview");

		if (file) {
			const reader = new FileReader();
			reader.onload = function (e) {
				preview.src = e.target.result;
			};
			reader.readAsDataURL(file);
		} else {
			// Revert to default image if no file selected
			preview.src = "noimage.png";
		}
	});


