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
});
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
	if ($("#categoryTable").length > 0) {
		const per_group = 3;
		const per_page = 10;
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
            <td>${(currentPage - 1) * per_page + i + 1}</td>
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
                <a href="${site_url}edit_main/${row.id}" class="me-2">
                  <i class="bx bxs-edit"></i>
                </a>
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

			$("#categoryTableBody").html(
				rows ||
					`<tr><td colspan="5" class="text-center">No records found</td></tr>`,
			);
		}

		function renderPagination(curr, total) {
			if (total <= 1) {
				$("#categoryPagination").html("");
				return;
			}

			let html = "";
			const half = Math.floor(per_group / 2);
			let start = Math.max(1, curr - half);
			let end = Math.min(total, start + per_group - 1);

			if (end - start + 1 < per_group) {
				start = Math.max(1, end - per_group + 1);
			}

			// Previous
			if (curr > 1) {
				html += `
            <li class="page-item">
                <a class="page-link" href="javascript:;" data-page="${curr - 1}">Previous</a>
            </li>`;
			} else {
				html += `
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>`;
			}

			// Page numbers
			for (let p = start; p <= end; p++) {
				html += `
            <li class="page-item ${curr === p ? "active" : ""}">
                <a class="page-link" href="javascript:;" data-page="${p}">${p}</a>
            </li>`;
			}

			// Next
			if (curr < total) {
				html += `
            <li class="page-item">
                <a class="page-link" href="javascript:;" data-page="${curr + 1}">Next</a>
            </li>`;
			} else {
				html += `
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>`;
			}

			$("#categoryPagination").html(html);
		}

		// Pagination click
		$(document).on("click", "#categoryPagination .page-link", function () {
			const page = $(this).data("page");
			if (page) {
				loadPage(page);
			}
		});

		// Search input (global one in card header)
		$("#categorySearch").on("keyup", function () {
			searchText = $(this).val().trim();
			loadPage(1);
		});

		// Initialize table data
		loadPage();
	}
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
	// Only run this code if #SubcategoryTable exists
	if ($("#SubcategoryTable").length > 0) {
		const perPage = 3;
		let currentPage = 1;
		let searchText = "";

		function loadSubcategories(page = 1) {
			$.ajax({
				url: site_url + "admin/category/sub_ajax_list",
				type: "POST",
				dataType: "json",
				data: { page: page, search: searchText },
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
                                    <a href="${site_url}edit/${
																			row.id
																		}" class="me-2"><i class="bx bxs-edit"></i></a>
                                    <button class="btn btn-sm btn-${
																			row.isActive == 1 ? "danger" : "success"
																		} toggle-status-btn-2"
                                            data-id="${row.id}"
                                            data-status="${
																							row.isActive == 1 ? 0 : 1
																						}"
                                            title="${
																							row.isActive == 1
																								? "Unpublish"
																								: "Publish"
																						}">
                                        <i class="bx ${
																					row.isActive == 1
																						? "bx-x-circle"
																						: "bx-check-circle"
																				} me-1"></i>
                                        ${
																					row.isActive == 1
																						? "Unpublish"
																						: "Publish"
																				}
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

			html += `<li class="subcategory-page-item ${
				current === 1 ? "disabled" : ""
			}">
                        <a class="subcategory-page-link" href="javascript:;" data-page="${
													current - 1
												}">Previous</a>
                     </li>`;

			for (let i = start; i <= end; i++) {
				html += `<li class="subcategory-page-item ${
					i === current ? "active" : ""
				}">
                            <a class="subcategory-page-link" href="javascript:;" data-page="${i}">${i}</a>
                         </li>`;
			}

			html += `<li class="subcategory-page-item ${
				current === total ? "disabled" : ""
			}">
                        <a class="subcategory-page-link" href="javascript:;" data-page="${
													current + 1
												}">Next</a>
                     </li>`;

			$("#SubcategoryTable .subcategory-pagination").html(html);
		}

		// Pagination click (scoped to SubcategoryTable)
		$(document).on(
			"click",
			"#SubcategoryTable .subcategory-page-link",
			function () {
				const page = $(this).data("page");
				if (page) {
					currentPage = page;
					loadSubcategories(currentPage);
				}
			},
		);

		// Search input scoped to SubcategoryTable
		$("#SubcategoryTable .form-control[placeholder*='Search']").on(
			"keyup",
			function () {
				searchText = $(this).val();
				currentPage = 1;
				loadSubcategories(currentPage);
			},
		);

		// Toggle status scoped to this table
		$(document).on(
			"click",
			"#SubcategoryTable .toggle-status-btn-2",
			function () {
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
			},
		);

		// Initial load
		loadSubcategories(currentPage);
	}
});

$(document).ready(function () {
	// ✅ Check for the container, not the table
	if ($("#PartnerTableContainer").length > 0) {
		const limit = 10;
		let offset = 0;
		let totalRecords = 0;

		// Initial load
		loadPartners(offset);

		// ✅ FIXED: Search input selector
		$("#PartnerTableContainer .partner-search").on("keyup", function () {
			offset = 0;
			loadPartners(offset, $(this).val());
		});

		// Toggle status button
		$(document).on(
			"click",
			"#PartnerTableContainer .btn-toggle-status",
			function () {
				const partnerId = $(this).data("id");
				const currentStatus = $(this).data("status");
				const newStatus = currentStatus == 1 ? 0 : 1;
				const actionText = newStatus == 0 ? "deactivate" : "activate";

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
							dataType: "json",
							data: { partner_id: partnerId, status: newStatus },
							success: function (response) {
								if (response.status === "success") {
									Swal.fire({
										icon: "success",
										title: `Partner ${actionText}d successfully.`,
										timer: 1500,
										showConfirmButton: false,
									});
									loadPartners(
										offset,
										$("#PartnerTableContainer .partner-search").val(),
									);
								} else {
									Swal.fire("Failed!", response.message, "error");
								}
							},
							error: function () {
								Swal.fire("Error", "Something went wrong!", "error");
							},
						});
					}
				});
			},
		);

		// ✅ FIXED: Pagination page click
		$(document).on(
			"click",
			"#PartnerTableContainer .partner-page-link",
			function (e) {
				e.preventDefault();
				const pageOffset = $(this).data("offset");
				if (pageOffset !== undefined) {
					offset = pageOffset;
					loadPartners(
						offset,
						$("#PartnerTableContainer .partner-search").val(),
					);
				}
			},
		);

		// ✅ FIXED: Prev button
		$(document).on(
			"click",
			"#PartnerTableContainer .partner-prev",
			function (e) {
				e.preventDefault();
				if (offset > 0) {
					offset -= limit;
					loadPartners(
						offset,
						$("#PartnerTableContainer .partner-search").val(),
					);
				}
			},
		);

		// ✅ FIXED: Next button
		$(document).on(
			"click",
			"#PartnerTableContainer .partner-next",
			function (e) {
				e.preventDefault();
				if (offset + limit < totalRecords) {
					offset += limit;
					loadPartners(
						offset,
						$("#PartnerTableContainer .partner-search").val(),
					);
				}
			},
		);

		function loadPartners(offset, search = "") {
			$.ajax({
				url: site_url + "admin/partner/fetchPartners",
				type: "POST",
				data: { limit: limit, offset: offset, search: search },
				dataType: "json",
				success: function (response) {
					totalRecords = response.total;

					let html = "";
					if (response.partners && response.partners.length > 0) {
						$.each(response.partners, function (index, partner) {
							html += `
                                <tr>
                                    <td>${offset + index + 1}</td>
                                    <td><img src="${partner.profile_image}" alt="Image" width="50"></td>
                                    <td>${partner.partner_name}</td>
                                    <td>${partner.gym_name || ""}</td>
                                    <td>${partner.mobile}</td>
                                    <td>${partner.address || ""}</td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            ₹ ${parseFloat(partner.wallet_balance || 0).toLocaleString("en-IN", { minimumFractionDigits: 2 })}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions align-items-center">
                                            <a href="${site_url}loginAsPartner/${partner.id}" class="ms-2" title="Login">
                                                <i class="bx bx-log-in"></i>
                                            </a>
                                            <a href="javascript:void(0);" 
                                               class="btn-toggle-status ms-2" 
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
						html = `<tr><td colspan="8" class="text-center">No partners found</td></tr>`;
					}
					$("#partnerTableBody").html(html);

					// ✅ FIXED: Pagination generation
					const totalPages = Math.ceil(totalRecords / limit);
					const currentPage = Math.floor(offset / limit);

					let paginationHtml = "";

					// Previous button
					if (offset === 0) {
						paginationHtml += `
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>`;
					} else {
						paginationHtml += `
                            <li class="page-item">
                                <a class="page-link partner-prev" href="#">Previous</a>
                            </li>`;
					}

					// Page numbers (with ellipsis for many pages)
					for (let i = 0; i < totalPages; i++) {
						// Show first, last, and pages around current
						if (
							i === 0 ||
							i === totalPages - 1 ||
							(i >= currentPage - 2 && i <= currentPage + 2)
						) {
							paginationHtml += `
                                <li class="page-item ${currentPage === i ? "active" : ""}">
                                    <a class="page-link partner-page-link" href="#" data-offset="${i * limit}">${i + 1}</a>
                                </li>`;
						} else if (i === currentPage - 3 || i === currentPage + 3) {
							paginationHtml += `
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>`;
						}
					}

					// Next button
					if (offset + limit >= totalRecords) {
						paginationHtml += `
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>`;
					} else {
						paginationHtml += `
                            <li class="page-item">
                                <a class="page-link partner-next" href="#">Next</a>
                            </li>`;
					}

					// ✅ FIXED: Correct selector for pagination
					$("#PartnerTableContainer .pagination").html(paginationHtml);
				},
				error: function (xhr, status, error) {
					console.error("AJAX Error:", xhr.responseText);
					Swal.fire("Error", "Failed to load partners", "error");
				},
			});
		}
	}
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
					"error",
				);
			},
		});
	});
});
if ($("#sliderTable").length > 0) {
	// Only run if table exists
	let currentPage = 1;
	let searchKeyword = "";

	function fetchSliders(page = 1, keyword = "") {
		$.ajax({
			url: site_url + "admin/category/ajax_list_slider",
			type: "POST",
			data: { page: page, keyword: keyword },
			dataType: "json",
			success: function (res) {
				if (res.status) {
					$("#sliderTableBody").html(res.html);
					$(".pagination").html(res.pagination);
					currentPage = page;
				} else {
					$("#sliderTableBody").html(
						'<tr><td colspan="7" class="text-center">No records found</td></tr>',
					);
					$(".pagination").html("");
				}
			},
		});
	}

	// Pagination click
	$(document).on("click", "#sliderPagination .page-link", function () {
		let page = $(this).data("page");
		if (page) {
			fetchSliders(page, searchKeyword);
		}
	});

	// Search input
	$("#sliderSearch").on("keyup", function () {
		searchKeyword = $(this).val();
		fetchSliders(1, searchKeyword); // reset to first page on search
	});

	// Initial load
	fetchSliders();
}

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
							`<option value="${city.name}">${city.name}</option>`,
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
	// Only run this code if #CityTable exists
	if ($("#CityTable").length > 0) {
		let currentPage = 1;
		let searchKeyword = "";

		// Initial fetch
		fetchCityList();

		// Search input scoped to CityTable
		$("#CityTable input[type='text']").on("keyup", function () {
			searchKeyword = $(this).val();
			currentPage = 1;
			fetchCityList();
		});

		// Pagination click scoped to CityTable
		$(document).on("click", "#CityTable .city-page-link", function () {
			const page = $(this).data("page");
			if (page) {
				currentPage = page;
				fetchCityList();
			}
		});

		// Toggle publish/unpublish button scoped to CityTable
		$(document).on("click", "#CityTable .toggle-status-btn_city", function () {
			const id = $(this).data("id");
			const status = $(this).data("status");

			$.ajax({
				url: site_url + "admin/category/toggle_status_city",
				type: "POST",
				dataType: "json",
				data: { id, status },
				success: function (res) {
					if (res.success) {
						Swal.fire({
							icon: "success",
							title: res.message,
							timer: 2000,
							showConfirmButton: false,
						});
						setTimeout(() => fetchCityList(), 2000);
					} else {
						Swal.fire("Error", res.message, "error");
					}
				},
			});
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
                                </tr>`;
						});
					} else {
						rows = `<tr><td colspan="5" class="text-center">No data found</td></tr>`;
					}

					$("#cityTableBody").html(rows);
					renderPagination(res.total_pages, res.current_page);
				},
			});
		}

		function renderPagination(totalPages, current) {
			let html = "";
			if (totalPages > 1) {
				if (current > 1) {
					html += `<li class="page-item"><a class="city-page-link page-link" href="javascript:;" data-page="${
						current - 1
					}">Previous</a></li>`;
				}

				for (let i = 1; i <= totalPages; i++) {
					const active = i === current ? "active" : "";
					html += `<li class="page-item ${active}"><a class="city-page-link page-link" href="javascript:;" data-page="${i}">${i}</a></li>`;
				}

				if (current < totalPages) {
					html += `<li class="page-item"><a class="city-page-link page-link" href="javascript:;" data-page="${
						current + 1
					}">Next</a></li>`;
				}
			}
			$("#CityTable .pagination").html(html);
		}
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
					`<option value="${state.name}">${state.name}</option>`,
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

$(document).ready(function () {
	// Only run if #bookingTableBodyy exists on the page
	if ($("#bookingTableBodyyy").length) {
		function loadData(page = 1, search = "") {
			$.ajax({
				url: site_url + "admin/booking/fetch_partnerss",
				type: "POST",
				dataType: "json",
				data: { page, search },
				success: function (res) {
					let rows = "";
					if (res.rows && res.rows.length) {
						res.rows.forEach((r, i) => {
							rows += `
<tr>
  <td>${(res.page - 1) * res.limit + i + 1}</td>
  <td>${r.customer_name ?? ""}</td>
  <td>${r.mobile ?? ""}</td>
  <td>${r.provider_name ?? ""}</td>
  <td>${r.created_at ?? ""}</td>
  <td>₹${r.amount ?? "0"}</td>
  <td>${r.duration ?? ""}</td>
  <td>${r.qty ?? "0"}</td>
  <td>${r.free_qty ?? "0"}</td>
  <td>${formatEndDate(r.start_date, r.duration, r.total_qty)}</td>
  <td>${r.status ?? ""}</td>
</tr>`;
						});
					} else {
						rows = `<tr><td colspan="9" class="text-center">No data found</td></tr>`;
					}
					$("#bookingTableBodyy").html(rows);
					$("#pagination_booking").html(res.pagination);
				},
				error: function (xhr) {
					console.error("Error loading data", xhr.responseText);
				},
			});
		}
		function formatEndDate(startDate, duration, totalQty) {
			if (!startDate || !duration) return "-";
			const s = new Date(startDate);
			const e = new Date(s);
			const qty = Number(totalQty) || 0;

			switch (duration.toLowerCase()) {
				case "day":
				case "days":
					e.setDate(s.getDate() + qty);
					break;
				case "week":
				case "weeks":
					e.setDate(s.getDate() + qty * 7);
					break;
				case "month":
				case "months":
					e.setMonth(s.getMonth() + qty);
					break;
				case "year":
				case "years":
					e.setFullYear(s.getFullYear() + qty);
					break;
				default:
					return "-";
			}

			return e.toLocaleDateString("en-GB", {
				day: "2-digit",
				month: "short",
				year: "numeric",
			});
		}

		// initial load
		loadData(1, "");

		// pagination click handler
		$(document).on(
			"click",
			"#pagination_booking li.page-item:not(.disabled) .page-link",
			function (e) {
				e.preventDefault();
				e.stopPropagation();
				const page = Number($(this).data("page"));
				const search = $("#searchOrder").val();
				if (page) loadData(page, search);
			},
		);

		// search (debounced)
		let t;
		$("#searchOrder").on("keyup", function () {
			clearTimeout(t);
			const q = $(this).val();
			t = setTimeout(() => loadData(1, q), 300);
		});
	}
});

// $(document).ready(function () {
// 	loadServices();

// 	$(".radius-30").on("input", function () {
// 		const search = $(this).val();
// 		loadServices(1, search);
// 	});
// });

document.addEventListener("DOMContentLoaded", function () {
	const input = document.getElementById("service_image");
	if (!input) return; // Exit if element does not exist

	input.addEventListener("change", function (event) {
		const file = event.target.files[0];
		const preview = document.getElementById("image_preview");
		if (!preview) return; // Exit if preview element does not exist

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
});
$(document).ready(function () {
	$("#PayoutForm").on("submit", function (e) {
		e.preventDefault();

		const amount = parseFloat($("#payoutAmount").val());
		const providerId = $("#providerId").val().trim();
		const note = $("#transactionNote").val();

		/* ================= CLIENT VALIDATION ================= */
		if (!providerId) {
			Swal.fire({
				icon: "warning",
				title: "Missing Provider",
				text: "Provider ID is missing.",
			});
			return;
		}

		if (isNaN(amount) || amount <= 0) {
			Swal.fire({
				icon: "warning",
				title: "Invalid Amount",
				text: "Please enter a valid payout amount.",
			});
			return;
		}

		/* ================= AJAX ================= */
		$.ajax({
			url: site_url + "admin/pay_out/pay_out_process",
			type: "POST",
			dataType: "json", // 🔥 IMPORTANT (no manual JSON.parse)
			data: {
				provider_id: providerId,
				payout_amount: amount,
				transaction_note: note,
			},

			beforeSend: function () {
				$('button[type="submit"]').prop("disabled", true).text("Processing...");
			},

			success: function (res) {
				// ✅ Always handled properly
				if (res.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Payout Successful",
						text: res.message,
						confirmButtonText: "OK",
					}).then(() => {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Payout Failed",
						text: res.message || "Something went wrong.",
					});
				}
			},

			error: function (xhr) {
				console.error("XHR ERROR:", xhr.responseText);

				let message = "Server error. Please try again.";

				// ✅ Try to read backend JSON error
				try {
					const res = JSON.parse(xhr.responseText);
					if (res.message) message = res.message;
				} catch (e) {}

				Swal.fire({
					icon: "error",
					title: "Request Failed",
					text: message,
				});
			},

			complete: function () {
				$('button[type="submit"]')
					.prop("disabled", false)
					.text("Settle Payout");
			},
		});
	});
});

$(document).ready(function () {
	if ($("#paymentTableBodyy").length > 0) {
		// ✅ Check if table exists
		let limit = 5;
		let currentPage = 1;

		function loadPayouts(page = 1) {
			$.ajax({
				url: site_url + "admin/payment/payouts_list",
				type: "POST",
				data: { limit: limit, page: page },
				dataType: "json",
				success: function (res) {
					let tbody = "";
					if (res.data.length > 0) {
						$.each(res.data, function (i, row) {
							let statusHtml = "";

							if (row.status === "pending") {
								statusHtml = `<div class="d-flex align-items-center text-info">
                            <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                            <span>Pending</span>
                          </div>`;
							} else if (row.status === "success") {
								statusHtml = `<div class="d-flex align-items-center text-success">
                            <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                            <span>Success</span>
                          </div>`;
							} else if (row.status === "failed") {
								statusHtml = `<div class="d-flex align-items-center text-danger">
                            <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                            <span>Failed</span>
                          </div>`;
							} else {
								statusHtml = row.status; // fallback
							}

							tbody += `
            <tr>
                <td>${(page - 1) * limit + i + 1}</td>
                <td>${row.gym_name}</td>
                <td>${row.mobile}</td>
                <td>₹${row.amount}</td>
                <td>${row.request_date}</td>
                <td>${statusHtml}</td>
                 <td>
                                        <div class="d-flex order-actions align-items-center">
                                            
                                            <a href="${site_url}pay_out/${
																							row.provider_id
																						}" 
                                                class="ms-2 js-payout" 
                                                title="Payout">
                                                <i class="bx bx-transfer"></i>
                                              </a>

                                           
                                        </div>
                                    </td>
            </tr>
        `;
						});
					} else {
						tbody = `<tr><td colspan="6" class="text-center">No payouts found</td></tr>`;
					}

					$("#paymentTableBody").html(tbody);

					// Build pagination

					$(".pagination").html(res.pagination);
				},
			});
		}

		// Initial load
		loadPayouts(currentPage);

		// Handle pagination click
		$(document).on("click", ".pagination .page-link", function (e) {
			e.preventDefault();

			let page = $(this).data("page");
			if (page) {
				currentPage = page;
				loadPayouts(page);
			}
		});
	}
});

$(document).ready(function () {
	$("#PaymentForm").on("submit", function (e) {
		e.preventDefault(); // prevent default submit

		let form = $(this);
		let formData = form.serialize();

		$.ajax({
			url: site_url + "admin/payment/save",
			type: "POST",
			data: formData,
			dataType: "json",
			beforeSend: function () {
				Swal.fire({
					title: "Please wait...",
					text: "Updating payment settings",
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
					},
				});
			},
			success: function (response) {
				Swal.close();
				if (response.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Updated!",
						text: response.message || "Payment settings updated successfully.",
						timer: 2000,
						showConfirmButton: false,
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Error!",
						text: response.message || "Something went wrong. Please try again.",
					});
				}
			},
			error: function () {
				Swal.close();
				Swal.fire({
					icon: "error",
					title: "Server Error",
					text: "Unable to process your request at the moment.",
				});
			},
		});
	});
});

document.addEventListener("DOMContentLoaded", function () {
	if (!document.querySelector("#SettlementTable")) return;

	let currentPage = 1;
	let currentSearch = "";
	let currentFilter = "";

	function loadTransactions(page = 1) {
		currentPage = page;

		fetch(site_url + "admin/settlement/fetch_transactions", {
			method: "POST",
			headers: {
				"Content-Type": "application/x-www-form-urlencoded",
				"X-Requested-With": "XMLHttpRequest",
			},
			body:
				"page=" +
				page +
				"&search=" +
				encodeURIComponent(currentSearch) +
				"&filter=" +
				currentFilter,
		})
			.then((res) => res.json())
			.then((res) => {
				if (res.status !== "success") return;

				let tbody = document.querySelector("#SettlementTableBody");
				tbody.innerHTML = "";

				res.data.forEach((row, index) => {
					let tr = document.createElement("tr");

					tr.innerHTML = `
					<td>${(res.current_page - 1) * 10 + (index + 1)}</td>
					<td>${row.user_name || "-"}</td>
					<td>${row.recipient_name || "-"}</td>
					<td>${row.mobile || "-"}</td>
					<td>
						<div class="d-flex align-items-center 
							${
								row.status === "success"
									? "text-success"
									: row.status === "pending"
										? "text-warning"
										: "text-danger"
							}">
							<i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
							<span>${row.status ? row.status.charAt(0).toUpperCase() + row.status.slice(1) : "-"}</span>
						</div>
					</td>
					<td>
						<div class="d-flex align-items-center 
							${row.settled == 1 ? "text-success" : "text-danger"}">
							<i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
							<span>${row.settled == 1 ? "Success" : "Pending"}</span>
						</div>
					</td>
					<td>₹ ${row.amount}</td>
					<td>${row.formatted_date}</td>
					<td>
						<button type="button"
							onclick="window.location='${site_url}admin/settlement/transaction_details/${row.id}'"
							class="btn btn-warning btn-sm radius-30 px-3">
							<i class="bx bx-transfer"></i>
						</button>
					</td>
				`;

					tbody.appendChild(tr);
				});

				// ✅ Use controller pagination
				document.querySelector(".pagination").innerHTML = res.pagination;
			});
	}

	// ✅ Single global click handler (OUTSIDE function)
	document.addEventListener("click", function (e) {
		let link = e.target.closest(".pagination .page-link");
		if (!link) return;

		e.preventDefault();

		let page = link.dataset.page;
		if (page) {
			loadTransactions(parseInt(page));
		}
	});

	// Search
	document.querySelector("#searchInput").addEventListener("keyup", function () {
		currentSearch = this.value.trim();
		loadTransactions(1);
	});

	// Filter
	document.querySelectorAll(".filter-btn").forEach((btn) => {
		btn.addEventListener("click", function () {
			document
				.querySelectorAll(".filter-btn")
				.forEach((b) => b.classList.remove("active"));

			this.classList.add("active");

			currentFilter = this.getAttribute("data-filter");

			loadTransactions(1);
		});
	});

	// Initial Load
	loadTransactions(1);
});

$(document).ready(function () {
	$("#settlementForm").on("submit", function (e) {
		e.preventDefault(); // stop normal form submit

		let amountField = $("#amount");
		let amount = amountField.val().trim();

		// Clear previous error
		$(".amount-error").remove();

		if (amount === "") {
			amountField.after(
				'<div class="text-danger amount-error">Please enter the amount.</div>',
			);
			amountField.focus();
			return false;
		}

		$.ajax({
			url: site_url + "admin/settlement/settle_transaction", // ✅ fixed variable
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (res) {
				if (res.status === "success") {
					Swal.fire({
						icon: "success",
						title: "Payout Settled",
						text: "The transaction has been settled successfully!",
						timer: 2000,
						showConfirmButton: false,
					}).then(() => {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: "error",
						title: "Failed",
						text: res.message || "Something went wrong, please try again.",
					});
				}
			},
			error: function (xhr, status, error) {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: "Something went wrong: " + error,
				});
			},
		});
	});
});

$(document).ready(function () {
	// Check if the table exists
	if ($("#SettlementHistoryBody").length) {
		let currentPage = 1;
		let currentFilter = "";
		let currentSearch = "";

		// Format date (yyyy-mm-dd hh:mm:ss → dd-mm-yyyy hh:mm)
		function formatDate(dateString) {
			let date = new Date(dateString);
			if (isNaN(date)) return "-";
			let day = ("0" + date.getDate()).slice(-2);
			let month = ("0" + (date.getMonth() + 1)).slice(-2);
			let year = date.getFullYear();
			let hours = ("0" + date.getHours()).slice(-2);
			let minutes = ("0" + date.getMinutes()).slice(-2);
			return `${day}-${month}-${year} ${hours}:${minutes}`;
		}

		// Function to load transactions
		function loadTransactions(page = 1, search = "", filter = "") {
			$.ajax({
				url: site_url + "admin/settlement/fetch_transactions_history",
				type: "POST",
				data: {
					page: page,
					search: search,
					filter: filter,
				},
				dataType: "json",
				beforeSend: function () {
					$("#SettlementHistoryBody").html(
						`<tr><td colspan="7" class="text-center">Loading...</td></tr>`,
					);
				},
				success: function (res) {
					if (res.status !== "success") return;

					let rows = "";

					if (res.data.length > 0) {
						$.each(res.data, function (i, row) {
							let serial = (page - 1) * 10 + (i + 1);

							rows += `
                        <tr>
                            <td>${serial}</td>
                            <td>${row.recipient_name || "-"}</td>
                            <td>${row.phone_number || "-"}</td>
                            <td>
                                ${
																	row.settled == 1
																		? `<div class="d-flex align-items-center text-success">
                                            <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
                                            <span>Success</span>
                                       </div>`
																		: `<div class="d-flex align-items-center text-info">
                                            <i class="bx bx-radio-circle-marked bx-flashing align-middle font-18 me-1"></i>
                                            <span>Pending</span>
                                       </div>`
																}
                            </td>
                            <td>${row.settled_amount ? "₹ " + row.settled_amount : "-"}</td>
                            <td>${row.settled_at ? formatDate(row.settled_at) : "-"}</td>
                        </tr>`;
						});
					} else {
						rows = `<tr><td colspan="7" class="text-center">No records found</td></tr>`;
					}

					$("#SettlementHistoryBody").html(rows);

					$(".pagination").html(res.pagination);
				},
				error: function () {
					$("#SettlementHistoryBody").html(
						`<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>`,
					);
				},
			});
		}

		// Load first page
		loadTransactions();

		// Handle pagination click
		$(document).on("click", ".pagination a", function (e) {
			e.preventDefault();
			let page = $(this).data("page");
			if (page) {
				currentPage = page;
				loadTransactions(currentPage, currentSearch, currentFilter);
			}
		});

		// Handle search
		$("#searchInputhistory").on("keyup", function () {
			currentSearch = $(this).val();
			currentPage = 1;
			loadTransactions(currentPage, currentSearch, currentFilter);
		});

		// Handle filter
		$(".filter-transection").on("click", function () {
			$(".filter-transection").removeClass("active");
			$(this).addClass("active");
			currentFilter = $(this).data("filter");
			currentPage = 1;
			loadTransactions(currentPage, currentSearch, currentFilter);
		});
	}
});

$(document).ready(function () {
	let limit = 10;
	let offset = 0;
	let totalRecords = 0;

	function loadInquiries(search = "", newOffset = 0) {
		$.ajax({
			url: site_url + "admin/page/get_inquries",
			type: "POST",
			data: { search: search, limit: limit, offset: newOffset },
			dataType: "json",
			success: function (response) {
				let html = "";
				totalRecords = response.total;
				let data = response.data;
				if (data.length > 0) {
					$.each(data, function (index, row) {
						let userName = row.user_name ? row.user_name : "Guest User";

						html += `<tr>
            <td>${newOffset + index + 1}</td>
            <td>${userName}</td>
            <td>${row.gym_name ?? "-"}</td>
            <td>${row.mobile_number ?? "-"}</td>
            <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${row.description}">
                ${row.description ?? "-"}
            </td>
            <td>${row.created_at ?? "-"}</td>
        </tr>`;
					});
				} else {
					html = `<tr>
        <td colspan="6" class="text-center text-muted">
            No enquiries found
        </td>
    </tr>`;
				}
				$("#inqurieTableBody").html(html);
				renderPagination(newOffset);
			},
			error: function () {
				$("#inqurieTableBody").html(
					`<tr><td colspan="8" class="text-center text-danger">Error loading enquiries.</td></tr>`,
				);
			},
		});
	}

	function renderPagination(currentOffset) {
		let pages = Math.ceil(totalRecords / limit);
		let currentPage = currentOffset / limit + 1;
		let html = "";

		if (pages > 1) {
			html += `<li class="page-item ${currentPage == 1 ? "disabled" : ""}">
                <a class="page-link" href="#" data-offset="${currentOffset - limit}">Previous</a></li>`;

			for (let i = 1; i <= pages; i++) {
				html += `<li class="page-item ${i == currentPage ? "active" : ""}">
                    <a class="page-link" href="#" data-offset="${(i - 1) * limit}">${i}</a></li>`;
			}

			html += `<li class="page-item ${currentPage == pages ? "disabled" : ""}">
                <a class="page-link" href="#" data-offset="${currentOffset + limit}">Next</a></li>`;
		}

		$("#pagination").html(html);
	}

	$(document).on("click", "#pagination .page-link", function (e) {
		e.preventDefault();
		let newOffset = $(this).data("offset");
		if (newOffset >= 0 && newOffset < totalRecords) {
			offset = newOffset;
			loadInquiries($("#searchBox").val(), offset);
		}
	});

	$("#searchBox").on("keyup", function () {
		let search = $(this).val();
		offset = 0;
		loadInquiries(search, offset);
	});

	// Initial load
	loadInquiries();
});
$(document).ready(function () {
	$("#OfferForm").on("submit", function (e) {
		e.preventDefault();

		$.ajax({
			url: site_url + "admin/dashboard/save_offer",
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			beforeSend: function () {
				Swal.fire({
					title: "Saving...",
					allowOutsideClick: false,
					didOpen: () => Swal.showLoading(),
				});
			},
			success: function (res) {
				Swal.close();
				if (res.status === "success") {
					Swal.fire("Success", res.message, "success");
				} else {
					Swal.fire("Error", res.message, "error");
				}
			},
			error: function () {
				Swal.close();
				Swal.fire("Error", "Something went wrong. Please try again.", "error");
			},
		});
	});
});

$(document).ready(function () {
	if ($("#customerTableBody").length > 0) {
		let currentPage = 1;
		let currentSearch = "";

		function loadCustomers(page = 1, search = "") {
			$.get(
				site_url + "admin/customers/fetch_customers",
				{
					page: page,
					search: search,
				},
				function (res) {
					let rows = "";

					if (res.customers.length > 0) {
						$.each(res.customers, function (i, customer) {
							rows += `
                            <tr>
                                <td>${(res.page - 1) * res.limit + i + 1}</td>
                                <td>${customer.name}</td>
                                <td>${customer.email}</td>
                                <td>${customer.mobile}</td>
                                <td>
                                    ${
																			customer.isActive == 1
																				? '<span class="text-success">Active</span>'
																				: '<span class="text-danger">Inactive</span>'
																		}
                                </td>
                            </tr>
                        `;
						});
					} else {
						rows = `<tr>
                                <td colspan="5" class="text-center">
                                    No customers found
                                </td>
                            </tr>`;
					}

					$("#customerTableBody").html(rows);
					$(".pagination").html(res.pagination);
				},
				"json",
			);
		}

		// Pagination click
		$(document).on("click", ".pagination .page-link", function (e) {
			e.preventDefault();
			let page = $(this).data("page");
			if (page) {
				currentPage = page;
				loadCustomers(currentPage, currentSearch);
			}
		});

		// Search
		$("#customerSearch").on("keyup", function () {
			currentSearch = $(this).val();
			loadCustomers(1, currentSearch);
		});

		// Initial load
		loadCustomers();
	}
});
