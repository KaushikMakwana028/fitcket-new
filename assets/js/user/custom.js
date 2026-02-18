document.addEventListener("DOMContentLoaded", function () {
  const locationInput = document.getElementById("locationInput");

  if (locationInput) {
    if (!locationInput.value) {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          successCallback,
          errorCallback
        );
      } else {
        locationInput.placeholder = "Location not supported";
      }
    }
  }

  function successCallback(position) {
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    fetch(
      `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`
    )
      .then((response) => response.json())
      .then((data) => {
        const city =
          data.address.city ||
          data.address.town ||
          data.address.village ||
          data.address.county ||
          data.address.state_district ||
          data.address.suburb ||
          data.address.hamlet ||
          "";
        const state = data.address.state || "";
        const country = data.address.country || "";
        const location = `${city}, ${state}, ${country}`;
        locationInput.value = location;

        fetch(site_url + "home/save_location", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body:
            "lat=" +
            encodeURIComponent(lat) +
            "&lng=" +
            encodeURIComponent(lon) +
            "&address=" +
            encodeURIComponent(location),
        }).then(() => {
          location.reload();
        });
      })
      .catch(() => {
        locationInput.placeholder = "Unable to fetch location";
      });
  }

  function errorCallback() {
    locationInput.placeholder = "Permission denied or unavailable";
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Keep the selected tab active after reload
  var activeTab = window.location.hash;
  if (activeTab) {
    var tabElement = document.querySelector(
      'button[data-bs-target="' + activeTab + '"]'
    );
    if (tabElement) {
      new bootstrap.Tab(tabElement).show();
    }
  }

  // Update hash when tab is clicked
  var tabButtons = document.querySelectorAll(
    '#providerTabs button[data-bs-toggle="pill"]'
  );
  tabButtons.forEach(function (btn) {
    btn.addEventListener("shown.bs.tab", function () {
      window.location.hash = btn.getAttribute("data-bs-target");
    });
  });
});
function openAboutTab() {
  var aboutTab = document.getElementById("about-tab");
  if (aboutTab) {
    aboutTab.click();
    window.scrollTo({
      top: document.getElementById("about").offsetTop - 100,
      behavior: "smooth",
    });
  }
}
document.querySelectorAll('input[name="priceOption"]').forEach((radio) => {
  radio.addEventListener("change", function () {
    const label = this.getAttribute("data-label");
    document.getElementById("selectedOption").textContent = `Book for ${label}`;
  });
});
function checkLogin(userId) {
  if (parseInt(userId) === 0) {
    window.location.assign(site_url + "login");
  } else {
    window.location.assign(site_url + "cart");
  }
}
function validateAndBook(userId) {
  const startDateInput = document.getElementById("startDate");
  const dateError = document.getElementById("dateError");
  const selectedDate = new Date(startDateInput.value);
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  // Validate date field
  if (!startDateInput.value) {
    dateError.textContent = "Please select a start date.";
    dateError.classList.remove("d-none");
    return;
  }
  if (selectedDate < today) {
    dateError.textContent = "Start date cannot be earlier than today.";
    dateError.classList.remove("d-none");
    return;
  }
  dateError.classList.add("d-none");

  // If user not logged in, redirect to login
  if (parseInt(userId) === 0) {
    const currentUrl = encodeURIComponent(window.location.href);
  window.location.assign(site_url + "sign_in?redirect=" + currentUrl);
  } else {
    // Logged in: submit the form
    document.getElementById("cartForm").submit();
  }
}
document.querySelectorAll("input[name='priceOption']").forEach((radio) => {
  radio.addEventListener("change", function () {
    document.getElementById("priceInput").value = this.dataset.price;
    document.getElementById("durationInput").value =
      this.dataset.label.toLowerCase();
    document.getElementById("selectedOption").textContent =
      "Book for " + this.dataset.label;
  });
});

// document.addEventListener("DOMContentLoaded", function () {
//   const form = document.getElementById("registrationForm");

//   form.addEventListener("submit", function (e) {
//     e.preventDefault();
//     form.classList.add("was-validated");

//     if (!form.checkValidity()) {
//       return;
//     }

//     const formData = new FormData(form);

//     fetch(site_url + 'login/register_user', {
//       method: 'POST',
//       body: formData,
//     })
//     .then(res => res.json())
//     .then(response => {
//       if (response.status === 'success') {
//         Swal.fire({
//           icon: 'success',
//           title: 'Registered!',
//           text: 'You have successfully registered.',
//           confirmButtonColor: '#3085d6'
//         }).then(() => {
//           window.location.href = site_url + 'provider/dashboard'; // Redirect if needed
//         });
//       } else {
//         Swal.fire({
//           icon: 'error',
//           title: 'Error',
//           text: response.message || 'Registration failed!',
//         });
//       }
//     })
//     .catch(error => {
//       Swal.fire({
//         icon: 'error',
//         title: 'Oops...',
//         text: 'Something went wrong!',
//       });
//       console.error(error);
//     });
//   });
// });
function updateCartCount() {
  $.ajax({
    url: site_url + "cart/get_cart_count",
    method: "GET",
    dataType: "json",
    success: function (res) {
      $(".cartCount").text(res.count).show();
    },
  });
}

$(document).ready(function () {
  $(".cartCount").hide();
  updateCartCount();
});

// $(document).on("click", ".remove-cart-item", function (e) {
//     e.preventDefault();
//     let itemId = $(this).data("id");
//     let $btn = $(this); // cache button

//     $.ajax({
//         url: site_url + "cart/remove",
//         method: "POST",
//         data: { id: itemId },
//         dataType: "json",
//         success: function (res) {
//             if (res.status === "success") {
//                 // Update cart badge
//                 $(".cart-badge").text(res.count ?? 0);

//                 // Remove the card row
//                 $btn.closest(".cart-item-row").fadeOut(300, function () {
//                     $(this).remove();

//                     // Recalculate totals dynamically
//                     $("#cartSubtotal").text("₹" + (res.subtotal ?? 0));
//                     $("#cartTotal").text("₹" + (res.total ?? 0));

//                     // If no cart-item-row left, show empty cart
//                     if ($(".cart-item-row").length === 0) {
//                         $(".col-12.col-lg-8").html(`
//                             <div class="empty-cart text-center py-5">
//                                 <i class="bi bi-cart-x fs-1 mb-3"></i>
//                                 <h4>Your cart is empty</h4>
//                                 <p class="mb-0">Add some items to get started!</p>
//                             </div>
//                         `);

//                         // Disable Pay Now button
//                         $(".pay-now-btn").prop("disabled", true);
//                         $("#cartSubtotal, #cartTotal").text("₹0");
//                     }
//                 });
//             }
//         },
//         error: function(err) {
//             console.error("Failed to remove item:", err);
//         }
//     });
// });


$(document).on("click", ".pagination a", function (e) {
  e.preventDefault();
  var url = $(this).attr("href");

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (res) {
      $("#providerList").html(res.html);
      $("#paginationLinks").html(res.pagination);
      $("html, body").animate({ scrollTop: 0 }, "slow");
    },
  });
});
function fetchProviders(url = null) {
    let data = {
        price: $("#price_filter").val() || '',
        rating: $("#rating_filter").val() || '',
        exp: $("#experience_filter").val() || '',
        category: $("#category_filter").val() || '',
        language: $("#language_filter").val() || '',
        service: $("#servcie_filter").val() || ''  // Note: typo in your HTML id
    };

    // Remove empty values
    Object.keys(data).forEach(key => {
        if (data[key] === '' || data[key] === null) {
            delete data[key];
        }
    });

    $.ajax({
        url: url ?? site_url + "profile/index",
        type: "GET",
        data: data,
        dataType: "json",
        success: function (res) {
            $("#providerList").html(res.html);
            $("#paginationLinks").html(res.pagination);
            $("html, body").animate({ scrollTop: 0 }, "slow");
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
}

/* Apply button */
$(".btn-search").on("click", function () {
    fetchProviders();
    $("#collapseFilter").collapse("hide");
});

/* Pagination click */
$(document).on("click", ".pagination a", function (e) {
    e.preventDefault();
    fetchProviders($(this).attr("href"));
});

/* Reset - Fixed to properly reset select elements */
$(".btn-outline-secondary").on("click", function () {
    $("#filterAccordion select").each(function() {
        $(this).prop('selectedIndex', 0);  // Reset to first option
    });
    fetchProviders();
});

let currentPage = 1;
const limit = 9; // must match backend limit

function fetchServices(page = 1) {
  $.ajax({
    url: site_url + "services/fetch_services",
    type: "GET",
    data: { page },
    dataType: "json",
    success: function (response) {
      // 🔑 Always track the current page explicitly
      currentPage = page;

      renderServices(response.services);
      renderPagination(page, response.total, response.limit);

      $("#provider-count").text(
        response.provider_count + " Providers Available"
      );
    },
    error: function () {
      $("#providers-container").html(
        "<p class='text-danger'>Failed to load services. Try again.</p>"
      );
    },
  });
}

function renderServices(services) {
  let html = "";

  if (!services || services.length === 0) {
    html = `<p class="text-muted">No providers found.</p>`;
  } else {
    services.forEach((service) => {
      html += `
        <div class="provider-card">
            <div class="card-header">
                <img src="${service.image}" alt="${service.name}">
                <div class="card-rating">
                    <i class="fas fa-star"></i> 4.5
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">${service.name}</h3>
                <p class="card-subtitle">${service.gym_name}</p>
                <div class="card-features">
                  <div class="city-section">
                      <i class="fas fa-map-marker-alt"></i>
                      <span class="label">Available in:</span>
                      <span class="cities">
                          ${service.city
                            .split(",")
                            .map(
                              (city) =>
                                `<span class="city-tag">${city.trim()}</span>`
                            )
                            .join("")}
                      </span>
                  </div>
                  <div class="distance-section">
                      <i class="fas fa-route"></i>
                      <span class="label">Distance:</span>
                      <span class="distance">${service.distance}</span>
                  </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="price">₹${service.month_price} / month</div>
                <button class="btn-book" onclick="redirectToProvider(${
                  service.provider_id
                })">Book Now</button>
            </div>
        </div>`;
    });
  }

  $("#providers-container").html(html);
}

function redirectToProvider(providerId) {
  window.location.href = site_url + "provider_details/" + providerId;
}

function renderPagination(page, total, limit) {
  let totalPages = Math.ceil(total / limit);
  let html = "";

  // Prev button
  if (page > 1) {
    html += `
      <li class="page-item">
        <a class="page-link" href="#" data-page="${page - 1}">&laquo;</a>
      </li>`;
  }

  // Show max 3 pages
  let startPage = Math.max(1, page - 1);
  let endPage = startPage + 2;

  if (endPage > totalPages) {
    endPage = totalPages;
    startPage = Math.max(1, endPage - 2);
  }

  for (let i = startPage; i <= endPage; i++) {
    html += `
      <li class="page-item ${i === page ? "active" : ""}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>`;
  }

  // Next button
  if (page < totalPages) {
    html += `
      <li class="page-item">
        <a class="page-link" href="#" data-page="${page + 1}">&raquo;</a>
      </li>`;
  }

  $("#pagination").html(html);

  // Info text
  let start = (page - 1) * limit + 1;
  let end = Math.min(page * limit, total);
  $("#pagination-info").text(`Showing ${start}-${end} of ${total} providers`);
}

// Handle click events
$(document).on("click", "#pagination .page-link", function (e) {
  e.preventDefault();
  let page = parseInt($(this).data("page"));
  if (page && page !== currentPage) {
    fetchServices(page);
  }
});

// First load
fetchServices();

// Function to recalc totals and duration dynamically
function recalcCart() {
    let subtotal = 0;
    let durationData = {};

    $(".cart-item-row").each(function () {
        let row = $(this);
        let qty = parseInt(row.find(".qtyInput").val()) || 0;
        let price = parseFloat(row.find(".itemPrice").first().text().replace("₹", "")) || 0;
        let itemTotal = qty * price;

        // Update subtotal for this row
        row.find(".itemSubtotal").text("₹" + itemTotal.toFixed(2));

        subtotal += itemTotal;

        // Update duration breakdown
        let duration = row.find(".itemPrice").siblings("small").text().replace("/", "").trim();
        let name = row.find(".item-name").text().trim();

        if (!durationData[duration]) durationData[duration] = [];
        durationData[duration].push({ name: name, qty: qty, subtotal: itemTotal });
    });

    // Update summary
    $("#cartSubtotal, #cartTotal").text("₹" + subtotal.toFixed(2));

    // Update duration breakdown section
    let durSection = $(".cart-summary .duration-section");
    if (durSection.length) {
        durSection.empty();
        $.each(durationData, function (dur, items) {
            durSection.append(`<div class="duration-header">${dur}</div>`);
            items.forEach(function (item) {
                durSection.append(`
                    <div class="d-flex justify-content-between small duration-item">
                        <span>${item.name} x<span class="durationQty">${item.qty}</span></span>
                        <span class="durationSubtotal">₹${item.subtotal.toFixed(2)}</span>
                    </div>
                `);
            });
        });
    }
}

// Remove cart item
$(document).on("click", ".remove-cart-item", function (e) {
    e.preventDefault();
    let itemId = $(this).data("id");
    let $btn = $(this);

    $.post(site_url + "cart/remove", { id: itemId }, function (res) {
        if (res.status === "success") {
            $(".cart-badge").text(res.count ?? 0);

            $btn.closest(".cart-item-row").fadeOut(300, function () {
                $(this).remove();

                if ($(".cart-item-row").length === 0) {
                    $(".col-12.col-lg-8").html(`
                        <div class="empty-cart text-center py-5">
                            <i class="bi bi-cart-x fs-1 mb-3"></i>
                            <h4>Your cart is empty</h4>
                            <p class="mb-0">Add some items to get started!</p>
                        </div>
                    `);
                    $(".pay-now-btn").prop("disabled", true);
                }

                recalcCart(); // Recalculate totals & duration after removal
            });
        }
    }, "json");
});

// Increase/Decrease quantity
$(document).on("click", ".increaseQty, .decreaseQty", function () {
    let itemId = $(this).data("id");
    let action = $(this).hasClass("increaseQty") ? "increase" : "decrease";
    let row = $(this).closest(".cart-item");
    let input = row.find(".qtyInput");

    $.post(site_url + "/cart/update_quantity", { id: itemId, action: action }, function (res) {
        if (res.status === "success") {
            let updatedItem = res.cart.find(i => i.id == itemId);
            if (updatedItem) {
                $(".cart-item[data-id='" + itemId + "'] .qtyInput").val(updatedItem.qty);
            } else {
                // Item removed
                row.remove();
            }
            recalcCart(); // Recalculate everything dynamically
        }
    }, "json");
});


$(document).ready(function(){

    $('#user_profile_form').on('submit', function(e){
        e.preventDefault(); // prevent default submission

        // Clear previous error messages
        $('.error-msg').remove();

        // Get form values
        var name = $('#full-name').val().trim();
        var email = $('#email').val().trim();
        var mobile = $('#phone').val().trim();

        var hasError = false;

        // Validation
        if(name === ''){
            $('#full-name').after('<small class="error-msg text-danger">Full Name is required.</small>');
            hasError = true;
        }

        if(email === ''){
            $('#email').after('<small class="error-msg text-danger">Email Address is required.</small>');
            hasError = true;
        } else {
            // Simple email format check
            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if(!emailPattern.test(email)){
                $('#email').after('<small class="error-msg text-danger">Enter a valid email.</small>');
                hasError = true;
            }
        }

        if(mobile === ''){
            $('#phone').after('<small class="error-msg text-danger">Phone Number is required.</small>');
            hasError = true;
        }

        if(hasError) return; 

        
        var formData = new FormData(this);

        $.ajax({
            url: site_url+ "profile/edit_user_profile",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('.submit-btn').prop('disabled', true).html('Saving...');
            },
            success: function(response){
                $('.submit-btn').prop('disabled', false).html('<i class="bi bi-save"></i> Save Changes');

                if(response.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Profile updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Update profile image if server returns new image
                    if(response.profile_image){
                        $('.profile-avatar').attr('src', response.profile_image);
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Something went wrong!'
                    });
                }
            },
            error: function(xhr, status, error){
                $('.submit-btn').prop('disabled', false).html('<i class="bi bi-save"></i> Save Changes');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error
                });
            }
        });

    });

});
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile-picture');
    const profileImg = document.querySelector('.profile-avatar');

    // Only add event listener if both elements exist
    if (fileInput && profileImg) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImg.src = e.target.result;
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    }
});

$(document).ready(function () {
  let form = $("#bankDetailsForm");

  // Save / Update
  form.on("submit", function (e) {
    e.preventDefault();

    if (form[0].checkValidity() === false) {
      e.stopPropagation();
      form.addClass("was-validated");
      return false;
    }

    $.ajax({
      url: site_url + "profile/saveBankDetails",
      type: "POST",
      data: form.serialize(),
      dataType: "json",
      success: function (res) {
        Swal.fire({
          icon: res.status,
          title: res.status === "success" ? "Success" : "Error",
          text: res.message,
        }).then(() => location.reload());
      },
    });
  });

  // Edit button → Fill form
  $(document).on("click", ".edit-account", function () {
    let account = $(this).data("account");
    $("#id").val(account.id);
    $("#accountHolderName").val(account.account_holder_name);
    $("#bankName").val(account.bank_name);
    $("#accountNumber").val(account.account_number);
    $("#ifscCode").val(account.ifsc_code);
    $("#accountType").val(account.account_type);
    $("#branchName").val(account.branch_name);
    $("html, body").animate({ scrollTop: form.offset().top - 100 }, 500);
  });

  // Delete
  $(document).on("click", ".delete-account", function () {
    let id = $(this).data("id");
    Swal.fire({
      title: "Are you sure?",
      text: "This will remove the bank account.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: site_url + "profile/deleteBank/" + id,
          type: "POST",
          dataType: "json",
          success: function (res) {
            Swal.fire("Deleted!", res.message, "success").then(() => location.reload());
          },
        });
      }
    });
  });

  // Reset form
  $("#resetForm").on("click", function () {
    form.removeClass("was-validated")[0].reset();
    $("#id").val("");
  });
});
const startDate = document.getElementById("startDate");

if (startDate) {
  startDate.addEventListener("focus", function() {
    this.type = "date";
    if (typeof this.showPicker === "function") {
      this.showPicker(); // force open datepicker if supported
    }
  });
}


// startDate.addEventListener("blur", function() {
//   if (!this.value) {
//     this.type = "text"; // revert back if empty
//   }
// });
let currentFilter = "";

$(document).on("click", ".filter-btn", function(e) {
    e.preventDefault();
    currentFilter = $(this).data("filter");

    $.ajax({
        url: site_url + "rent_payment/index",
        type: "GET",
        data: { filter: currentFilter, page: 1 },
        success: function(response) {
            $("#transactions-container").html(response);
            $(".filter-btn").removeClass("btn-primary").addClass("btn-outline-primary");
            $(".filter-btn[data-filter='" + currentFilter + "']").removeClass("btn-outline-primary").addClass("btn-primary");
        }
    });
});

$(document).on("click", ".pagination-controls .page-btn", function(e) {
    e.preventDefault();

    let page = $(this).data("page");
    if (!page) {
        if ($(this).attr("id") === "prev-page") {
            page = $(".pagination-controls .page-btn.active").data("page") - 1;
        } else if ($(this).attr("id") === "next-page") {
            page = $(".pagination-controls .page-btn.active").data("page") + 1;
        }
    }

    if (page) {
        $.ajax({
            url: site_url + "rent_payment/index",
            type: "GET",
            data: { page: page, filter: currentFilter },
            success: function(response) {
                $("#transactions-container").html(response);
            }
        });
    }
});
document.addEventListener("DOMContentLoaded", function () {
    // ✅ Remove recipient
    document.querySelectorAll(".remove-btn-reception").forEach(btn => {
    btn.addEventListener("click", function () {
        let recipientId = this.getAttribute("data-id");
        let recipientItem = this.closest(".recipient-item");

        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to remove this recipient?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, remove it"
        }).then((result) => {
            if (!result.isConfirmed) return;

            fetch(site_url + "rent_payment/remove_recipient", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + recipientId
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    recipientItem.remove();

                    Swal.fire({
                        title: "Deleted!",
                        text: "Recipient has been removed successfully.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire("Error!", "Error removing recipient.", "error");
                }
            })
            .catch(() => {
                Swal.fire("Error!", "Request failed. Try again.", "error");
            });
        });
    });
});


    // ✅ Repay autofill
    document.querySelectorAll(".repay-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            let item = this.closest(".recipient-item");

            // Fill form fields
            document.getElementById("name").value = item.querySelector(".recipient-name").textContent.trim();
            document.getElementById("account_number").value = item.getAttribute("data-account");
            document.getElementById("confirm_account_number").value = item.getAttribute("data-account");
            document.getElementById("ifsc_code").value = item.getAttribute("data-ifsc");
            document.getElementById("bank_name").value = item.getAttribute("data-bank");

            // Focus on amount field
            let amountField = document.getElementById("transfer_amount");
            if (amountField) {
                amountField.focus();
            }

            // Smooth scroll to form
            document.getElementById("bank-payment-form").scrollIntoView({ behavior: "smooth" });
        });
    });
});

$(document).ready(function () {
  $("#contactForm").on("submit", function (e) {
    e.preventDefault();

    // Bootstrap validation
    if (!this.checkValidity()) {
      e.stopPropagation();
      $(this).addClass("was-validated");
      return;
    }

    const formData = {
      first_name: $("#firstName").val(),
      last_name: $("#lastName").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      subject: $("#subject").val(),
      message: $("#message").val(),
      newsletter: $("#newsletter").is(":checked") ? 1 : 0,
    };

    $.ajax({
      url: site_url +"page/submit_query",
      type: "POST",
      data: formData,
      dataType: "json",
      beforeSend: function () {
        Swal.fire({
          title: "Sending...",
          text: "Please wait while we process your request.",
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading(),
        });
      },
      success: function (res) {
        Swal.close();
        if (res.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Message Sent!",
            text: "We’ll get back to you within 24 hours.",
            showConfirmButton: false,
            timer: 2500
          });
          $("#contactForm")[0].reset();
          $("#contactForm").removeClass("was-validated");
        } else {
          Swal.fire("Error", res.message || "Something went wrong!", "error");
        }
      },
      error: function (xhr) {
        Swal.close();
        Swal.fire("Error", "Server error. Please try again later.", "error");
      },
    });
  });
});
$(document).on("click", "#openReviewModal", function () {

    let user_id     = $("#review_user").val();
    let provider_id = $("#review_provider").val();

    $.ajax({
        url: site_url + "page/get_review",
        type: "POST",
        dataType: "json",
        data: {
            user_id: user_id,
            provider_id: provider_id
        },
        success: function (res) {

            // reset form first
            $("#reviewForm")[0].reset();

            if (res.exists) {
                // PREFILL DATA
                $("input[name='rating'][value='" + res.data.rating + "']").prop("checked", true);
                $("#reviewText").val(res.data.review_text);

                $("#submitReviewBtn")
                    .text("Update Review")
                    .removeClass("btn-primary")
                    .addClass("btn-warning");
            } else {
                $("#submitReviewBtn")
                    .text("Submit Review")
                    .removeClass("btn-warning")
                    .addClass("btn-primary");
            }

            $("#addReviewModal").modal("show");
        }
    });
});

$(document).on("click", "#submitReviewBtn", function (e) {
    e.preventDefault();

    let rating      = $("input[name='rating']:checked").val();
    let review_text = $("#reviewText").val();

    if (!rating || !review_text) {
        Swal.fire("Error", "Please fill all required fields", "warning");
        return;
    }

    $.ajax({
        url: site_url + "page/save_review",
        type: "POST",
        dataType: "json",
        data: {
            user_id: $("#review_user").val(),
            provider_id: $("#review_provider").val(),
            rating: rating,
            review_text: review_text
        },
        success: function (res) {
            Swal.fire("Success", res.message, "success");
            $("#addReviewModal").modal("hide");
        }
    });
});



