$(function () {
	"use strict";

	new PerfectScrollbar(".app-container"),
		new PerfectScrollbar(".header-message-list"),
		new PerfectScrollbar(".header-notifications-list"),
		$(".mobile-toggle-icon").on("click", function () {
			$(".wrapper").toggleClass("toggled");
		}),
		/* dark mode button */

		$(".dark-mode").click(function () {
			$("html").attr("data-bs-theme", function (i, v) {
				return v === "dark" ? "light" : "dark";
			});
		});

	$(".dark-mode").on("click", function () {
		if ($(".dark-mode-icon i").attr("class") == "bx bx-sun") {
			$(".dark-mode-icon i").attr("class", "bx bx-moon");
		} else {
			$(".dark-mode-icon i").attr("class", "bx bx-sun");
		}
	}),
		$(".mobile-toggle-menu").click(function () {
			$(".wrapper").hasClass("toggled")
				? ($(".wrapper").removeClass("toggled"),
				  $(".sidebar-wrapper").unbind("hover"))
				: ($(".wrapper").addClass("toggled"),
				  $(".sidebar-wrapper").hover(
						function () {
							$(".wrapper").addClass("sidebar-hovered");
						},
						function () {
							$(".wrapper").removeClass("sidebar-hovered");
						}
				  ));
		}),
		// back to top button
		$(document).ready(function () {
			$(window).on("scroll", function () {
				$(this).scrollTop() > 300
					? $(".back-to-top").fadeIn()
					: $(".back-to-top").fadeOut();
			}),
				$(".back-to-top").on("click", function () {
					return (
						$("html, body").animate(
							{
								scrollTop: 0,
							},
							600
						),
						!1
					);
				});
		}),
		// menu
		$(function () {
			$("#menu").metisMenu();
		}),
		// active
		$(function () {
			for (
				var e = window.location,
					o = $(".metismenu li a")
						.filter(function () {
							return this.href == e;
						})
						.addClass("")
						.parent()
						.addClass("mm-active");
				o.is("li");

			)
				o = o.parent("").addClass("mm-show").parent("").addClass("mm-active");
		}),
		// chat process
		$(".chat-toggle-btn").on("click", function () {
			$(".chat-wrapper").toggleClass("chat-toggled");
		}),
		$(".chat-toggle-btn-mobile").on("click", function () {
			$(".chat-wrapper").removeClass("chat-toggled");
		}),
		// email
		$(".email-toggle-btn").on("click", function () {
			$(".email-wrapper").toggleClass("email-toggled");
		}),
		$(".email-toggle-btn-mobile").on("click", function () {
			$(".email-wrapper").removeClass("email-toggled");
		}),
		$(".compose-mail-btn").on("click", function () {
			$(".compose-mail-popup").show();
		}),
		$(".compose-mail-close").on("click", function () {
			$(".compose-mail-popup").hide();
		}),
		/* switcher */

		$("#LightTheme").on("click", function () {
			$("html").attr("data-bs-theme", "light");
		}),
		$("#DarkTheme").on("click", function () {
			$("html").attr("data-bs-theme", "dark");
		}),
		$("#SemiDarkTheme").on("click", function () {
			$("html").attr("data-bs-theme", "semi-dark");
		}),
		$("#BoderedTheme").on("click", function () {
			$("html").attr("data-bs-theme", "bodered-theme");
		});

	$(".switcher-btn").on("click", function () {
		$(".switcher-wrapper").toggleClass("switcher-toggled");
	}),
		$(".close-switcher").on("click", function () {
			$(".switcher-wrapper").removeClass("switcher-toggled");
		});
});

$("#submit_product_form").click(function (e) {
	e.preventDefault();

	var isValid = true;

	// Validate all inputs (text, number) and textarea
	$(
		"#productForm input[type='text'], #productForm input[type='number'], #productForm textarea"
	).each(function () {
		var input = $(this);
		if (!input.val().trim()) {
			input.addClass("is-invalid");
			isValid = false;
		} else {
			input.removeClass("is-invalid").addClass("is-valid");
		}
	});

	// Validate image input
	var imageInput = $("#image-uploadify");
	var file = imageInput.get(0).files[0];

	if (!file) {
		imageInput.addClass("is-invalid");
		isValid = false;
	} else {
		// Validate file type
		var allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
		if ($.inArray(file.type, allowedTypes) === -1) {
			imageInput.addClass("is-invalid");
			Swal.fire(
				"Invalid file type",
				"Only JPG, JPEG, and PNG files are allowed.",
				"error"
			);
			isValid = false;
		}
		// Validate file size (2MB = 2 * 1024 * 1024)
		else if (file.size > 2 * 1024 * 1024) {
			imageInput.addClass("is-invalid");
			Swal.fire("File too large", "Image size must be less than 2MB.", "error");
			isValid = false;
		} else {
			imageInput.removeClass("is-invalid").addClass("is-valid");
		}
	}

	if (!isValid) {
		return; // Stop form submission
	}

	var form = $("#productForm")[0];
	var formData = new FormData(form);

	$.ajax({
		url: site_url + "admin/products/new_product",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				Swal.fire({
					title: "Success!",
					text: "Product added successfully",
					icon: "success",
					timer: 3000,
				});
				$("#productForm")[0].reset();
				$("#productForm input, #productForm textarea").removeClass(
					"is-valid is-invalid"
				);
			} else {
				Swal.fire({
					title: "Error!",
					text: response.message || "An error occurred.",
					icon: "error",
				});
			}
		},
	});
});
$("#submit_customer").click(function (e) {
	e.preventDefault();
	// alert('h');
	// return;

	var form = $("#customerForm")[0];
	var formData = new FormData(form);

	$.ajax({
		url: site_url + "admin/customers/add",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				Swal.fire({
					title: "Success!",
					text: "customer added successfully",
					icon: "success",
					timer: 3000,
				});
				$("#customerForm")[0].reset();
				location.reload();
			} else {
				Swal.fire({
					title: "Error!",
					text: response.message || "An error occurred.",
					icon: "error",
				});
			}
		},
	});
});
$("#submit_package").click(function (e) {
	e.preventDefault();
	// alert('h');
	// return;

	var form = $("#packageForm")[0];
	var formData = new FormData(form);

	$.ajax({
		url: site_url + "admin/review/add",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				Swal.fire({
					title: "Success!",
					text: "Package added successfully",
					icon: "success",
					timer: 3000,
				});
				$("#packageForm")[0].reset();
				location.reload();
			} else {
				Swal.fire({
					title: "Error!",
					text: response.message || "An error occurred.",
					icon: "error",
				});
			}
		},
	});
});
$("#submit_event").click(function (e) {
	e.preventDefault();
	// alert('h');
	// return;

	var form = $("#eventForm")[0];
	var formData = new FormData(form);

	$.ajax({
		url: site_url + "admin/review/save_event",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (response) {
			if (response.status == "success") {
				Swal.fire({
					title: "Success!",
					text: "Event added successfully",
					icon: "success",
					timer: 3000,
				});
				$("#eventForm")[0].reset();
				location.reload();
			} else {
				Swal.fire({
					title: "Error!",
					text: response.message || "An error occurred.",
					icon: "error",
				});
			}
		},
	});
});

$(document).ready(function () {
	// Handle delete button click
	$(document).on("click", ".delete-product", function () {
		let productId = $(this).data("id");
		let row = $(this).closest("tr");

		// Show SweetAlert confirmation
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!",
		}).then((result) => {
			if (result.isConfirmed) {
				// Make AJAX request to delete product
				$.ajax({
					url: site_url + "admin/products/delete_product",
					type: "POST",
					data: { product_id: productId },
					dataType: "json",
					success: function (response) {
						if (response.success) {
							// Show success message
							Swal.fire(
								"Deleted!",
								"Product has been deleted successfully.",
								"success"
							);
							// Remove the row from the table
							row.remove();
							location.reload();
						} else {
							// Show error message
							Swal.fire(
								"Error!",
								response.message || "Failed to delete product.",
								"error"
							);
						}
					},
					error: function (xhr, status, error) {
						console.error("Error:", error);
						Swal.fire(
							"Error!",
							"An error occurred while deleting the product.",
							"error"
						);
					},
				});
			}
		});
	});
});
// $('#cust_id').on('select2:select', function (e) {
//     console.log('Selected customer ID:', $(this).val());
// });
$(document).ready(function () {
	// console.log(typeof $.fn.select2);
	$("#cust_id").select2({
		placeholder: "Select Customer",
		allowClear: true,
		ajax: {
			url: site_url + "admin/customers/fetch_customers_for_select",
			dataType: "json",
			delay: 250,
			data: function (params) {
				return {
					search: params.term || "",
				};
			},
			processResults: function (data) {
				return {
					results: data.map(function (customer) {
						return {
							id: customer.id,
							text: customer.full_name + " (" + customer.mobile_number + ")",
							full_name: customer.full_name,
							mobile_number: customer.mobile_number,
							location: customer.location,
						};
					}),
				};
			},
			cache: false,
		},
		minimumInputLength: 1,
	});
});

$("#cust_id").on("select2:select", function (e) {
	var data = e.params.data;
	$("#cust_name").val(data.full_name);
	$("#mob").val(data.mobile_number);
	$("#location").val(data.location);
	$('input[name="customer_id"]').val(data.id);
});
$(document).on("click", ".delete-customer", function () {
	const customerId = $(this).data("id");

	Swal.fire({
		title: "Are you sure?",
		text: "You want to delete this customer.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "admin/customers/delete/" + customerId,
				type: "POST",
				success: function (res) {
					Swal.fire({
						icon: "success",
						title: "Deleted!",
						text: "Customer has been deleted.",
						timer: 1500,
						showConfirmButton: false,
					});

					// Optionally reload or remove row
					setTimeout(() => location.reload(), 1500);
				},
				error: function () {
					Swal.fire("Error!", "Could not delete customer.", "error");
				},
			});
		}
	});
});
$(document).on("click", ".delete-booking", function () {
	const customerId = $(this).data("id");

	Swal.fire({
		title: "Are you sure?",
		text: "You want to delete this customer.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "admin/customers/delete_booking/" + customerId,
				type: "POST",
				success: function (res) {
					Swal.fire({
						icon: "success",
						title: "Deleted!",
						text: "Booking has been deleted.",
						timer: 1500,
						showConfirmButton: false,
					});

					// Optionally reload or remove row
					setTimeout(() => location.reload(), 1500);
				},
				error: function () {
					Swal.fire("Error!", "Could not delete Booking.", "error");
				},
			});
		}
	});
});
$(document).on("click", ".delete-package", function () {
	const customerId = $(this).data("id");

	Swal.fire({
		title: "Are you sure?",
		text: "You want to delete this package.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "admin/review/delete_package/" + customerId,
				type: "POST",
				success: function (res) {
					Swal.fire({
						icon: "success",
						title: "Deleted!",
						text: "Package has been deleted.",
						timer: 1500,
						showConfirmButton: false,
					});

					// Optionally reload or remove row
					setTimeout(() => location.reload(), 1500);
				},
				error: function () {
					Swal.fire("Error!", "Could not delete Booking.", "error");
				},
			});
		}
	});
});
$(document).on("click", ".delete-event", function () {
	const customerId = $(this).data("id");

	Swal.fire({
		title: "Are you sure?",
		text: "You want to delete this event.",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, delete it!",
		cancelButtonText: "Cancel",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: site_url + "admin/review/delete_event/" + customerId,
				type: "POST",
				success: function (res) {
					Swal.fire({
						icon: "success",
						title: "Deleted!",
						text: "Event has been deleted.",
						timer: 1500,
						showConfirmButton: false,
					});

					// Optionally reload or remove row
					setTimeout(() => location.reload(), 1500);
				},
				error: function () {
					Swal.fire("Error!", "Could not delete Booking.", "error");
				},
			});
		}
	});
});
function loadPackages(page = 1, search = "") {
	$.ajax({
		url: site_url + "admin/review/fetch_event_packages",
		type: "POST",
		data: { page: page, search: search },
		dataType: "json",
		success: function (res) {
			let html = "";
			let i = (page - 1) * res.limit + 1;
			$.each(res.data, function (index, row) {
				let statusBadge = "";
				if (row.payment_status === "paid") {
					statusBadge = `<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
						<i class="bx bxs-circle me-1"></i>${row.payment_status}
					</div>`;
				} else if (row.payment_status === "partial") {
					statusBadge = `<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
						<i class="bx bxs-circle me-1"></i>${row.payment_status}
					</div>`;
				} else {
					statusBadge = `<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
						<i class="bx bxs-circle me-1"></i>${row.payment_status}
					</div>`;
				}
				let followUpUI = "";
				if (row.payment_status !== "paid") {
					followUpUI = `<div class="d-flex align-items-center text-danger ms-3 followup-indicator" title="Follow Up">
        <i class="bx bx-radio-circle-marked bx-burst bx-rotate-90 align-middle font-18 me-1"></i>
        <span>Follw-up</span>
    </div>`;
				}
				html += `<tr>
                    <td>${i++}</td>
                    <td>${row.name}</td>
    				<td>${statusBadge}</td>
                    <td>${row.booking_date}</td>
                    <td>${row.package_name}</td>
					<td>
					<a href="${site_url}event/details/${
										row.id
									}" class="btn btn-primary btn-sm radius-30 px-4">
						View Details
					</a>
					</td>                  
					  <td>
                        <div class="d-flex order-actions">
                           <a href="${site_url}event_edit/${row.id}" class="edit-customer" data-id="${row.id}">
    <i class="bx bxs-edit"></i>
</a>

                            <a href="javascript:void(0);" class="ms-3 delete-event" data-id="${
															row.id
														}">
                                <i class="bx bxs-trash"></i>
                            </a>
							${followUpUI}

                        </div>
                    </td>
                </tr>`;
			});

			$("tbody").html(html);

			// Pagination (simple)
			let pageCount = Math.ceil(res.total / res.limit);
			let paginationHtml = "";
			for (let p = 1; p <= pageCount; p++) {
				paginationHtml += `<li class="page-item ${p == page ? "active" : ""}">
                    <a class="page-link" href="javascript:void(0);" onclick="loadPackages(${p}, '${search}')">${p}</a>
                </li>`;
			}
			$(".pagination").html(
				`<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="loadPackages(${Math.max(
					1,
					page - 1
				)}, '${search}')">Previous</a></li>` +
					paginationHtml +
					`<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="loadPackages(${Math.min(
						page + 1,
						pageCount
					)}, '${search}')">Next</a></li>`
			);
		},
	});
}

// Initial load
loadPackages();

// Search input handler
$('input[type="text"]').on("keyup", function () {
	let searchVal = $(this).val();
	loadPackages(1, searchVal);
});
