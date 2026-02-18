<style>
    :root {
        --primary-color: #6f42c1;
        --secondary-color: #1a1a1a;
        --accent-color: #8e44ad;
        --text-dark: #2d3436;
        --bg-light: #f8f9fa;
    }

    /* body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            padding: 15px;
        } */

    .main-container {
        background: white;
        border-radius: 12px;
        padding: 30px 20px;
        max-width: 900px;
        margin: auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 30px;
    }

    /* Filter Section */
    .filter-section {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        border: none;
        box-shadow: 0 8px 25px rgba(111, 66, 193, 0.15);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filter-header h5 {
        margin: 0;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .filter-header i {
        color: white;
        font-size: 1.2rem;
    }

    .filter-controls {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 20px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .filter-select {
        padding: 10px 14px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--text-dark);
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .filter-select:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.8);
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
    }

    .clear-filters-btn {
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        gap: 6px;
        height: fit-content;
    }

    .clear-filters-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-1px);
    }

    .bookings-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .booking-item {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .booking-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1 1 auto;
        min-width: 300px;
    }

    .booking-icon {
        width: 50px;
        height: 50px;
        background: var(--bg-light);
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        color: var(--primary-color);
    }

    .booking-details {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .booking-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--text-dark);
    }

    .booking-subtitle {
        font-size: 0.95rem;
        color: var(--secondary-color);
    }

    .booking-status {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 12px;
        min-width: 110px;
        text-align: center;
    }

    .booking-status.confirmed {
        background: rgba(34, 197, 94, 0.1);
        color: #15803d;
    }

    .booking-status.pending {
        background: rgba(234, 179, 8, 0.1);
        color: #a16207;
    }

    .booking-status.cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: #b91c1c;
    }

    .booking-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .view-btn,
    .cancel-btn {
        background: none;
        border: 2px solid #e5e7eb;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-btn {
        color: var(--primary-color);
    }

    .view-btn:hover {
        background: var(--primary-color);
        color: white;
    }

    .cancel-btn {
        color: var(--accent-color);
    }

    .cancel-btn:hover {
        background: var(--accent-color);
        color: white;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px 0;
        gap: 15px;
    }

    .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pagination-item {
        display: flex;
    }

    .pagination-link {
        padding: 8px 12px;
        border: 2px solid #e5e7eb;
        background: white;
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        min-width: 40px;
        text-align: center;
    }

    .pagination-link:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        background: var(--bg-light);
    }

    .pagination-link.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-link.disabled:hover {
        border-color: #e5e7eb;
        color: var(--text-dark);
        background: white;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: var(--text-dark);
        margin: 0 15px;
    }

    .back-btn {
        display: inline-block;
        background: none;
        border: 2px solid #e5e7eb;
        padding: 10px 20px;
        border-radius: 8px;
        color: var(--text-dark);
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        margin-bottom: 40px;
    }

    .back-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    @media (max-width: 1024px) {
        .filter-controls {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .clear-filters-btn {
            grid-column: span 2;
            justify-self: center;
            width: fit-content;
        }
    }

    @media (max-width: 768px) {
        .filter-controls {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .filter-group {
            width: 100%;
        }

        .filter-select {
            min-width: auto;
            width: 100%;
        }

        .clear-filters-btn {
            align-self: center;
            width: auto;
        }

        .booking-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .booking-status {
            align-self: flex-start;
        }

        .booking-actions {
            justify-content: flex-start;
        }

        .pagination-container {
            flex-direction: column;
            gap: 10px;
        }

        .pagination-info {
            margin: 0;
        }
          .booking-actions {
            justify-content: flex-start;
            width: 100%;
            gap: 10px;
        }

        .view-btn,
        .cancel-btn,
        .download-btn {
            flex: 1;
            justify-content: center;
            min-width: 0;
            padding: 10px 8px;
        }

    }
     .booking-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .view-btn,
    .cancel-btn,
    .download-btn {
        background: none;
        border: 2px solid #e5e7eb;
        padding: 8px 14px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.875rem;
        text-decoration: none;
    }

    .view-btn {
        color: var(--primary-color);
    }

    .view-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .cancel-btn {
        color: var(--accent-color);
    }

    .cancel-btn:hover {
        background: var(--accent-color);
        color: white;
        border-color: var(--accent-color);
    }

    .download-btn {
        color: #6f42c1;
        border-color: #6f42c1;
    }

    .download-btn:hover {
        background: #6f42c1;
        color: white;
        border-color: black;
        transform: translateY(-1px);
    }
 @media (max-width: 480px) {
    .kk{

    }
        .booking-actions {
            flex-direction: column;
        }

        .view-btn,
        .cancel-btn,
        .download-btn {
            width: 100%;
            flex: none;
        }
    }
</style>
<div class="container mt-5 mb-5">
    <div class="section-header">
        <h2>Bookings & Reservations</h2>
        <p>View and manage your current and past reservations</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <i class="bi bi-funnel"></i>
            <h5>Filter Bookings</h5>
        </div>
        <div class="filter-controls">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="success">Confirmed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Date Range</label>
                <select class="filter-select" id="dateFilter">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Sort By</label>
                <select class="filter-select" id="sortFilter">
                    <option value="date_desc">Newest First</option>
                    <option value="date_asc">Oldest First</option>
                    <option value="amount_desc">Highest Amount</option>
                    <option value="amount_asc">Lowest Amount</option>
                </select>
            </div>
            <button class="clear-filters-btn" onclick="clearFilters()">
                <i class="bi bi-x-circle"></i> Clear Filters
            </button>
        </div>
    </div>

    <div id="bookingResults">
       <div class="bookings-list">
    <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $b): ?>
            <?php
            $statusClass = strtolower($b['status']);
            if ($statusClass == 'success')
                $statusClass = 'confirmed';
            ?>
            <div class="booking-item"
                data-gym="<?= $b['gym_name']; ?>"
                data-booking="<?= date('jS F', strtotime($b['created_at'])); ?>"
                data-validity="<?= ucfirst($b['duration']) . ' ' . $b['qty'] . ' - ' . date('jS F', strtotime($b['start_date'])); ?>"
                data-expiry="<?= date('jS F', strtotime($b['end_date'])); ?>"
                data-amount-text="₹<?= number_format($b['total'], 2); ?>"
                data-status-text="<?= ucfirst($b['status']); ?>"
            >
                <div class="booking-info">
                    <div class="booking-icon"><i class="bi bi-building"></i></div>
                    <div class="booking-details">
                        <div class="booking-title"><?= $b['gym_name']; ?></div>
                        <div class="booking-subtitle">
                            <i class="bi bi-calendar-check"></i>
                            <strong>Booking Date:</strong> <?= date('jS F', strtotime($b['created_at'])); ?><br>

                            <i class="bi bi-ticket-perforated"></i>
                            <strong>Pass Validity:</strong> <?= ucfirst($b['duration']); ?> <?= $b['qty']; ?> -
                            <?= date('jS F', strtotime($b['start_date'])); ?><br>

                            <i class="bi bi-hourglass-split"></i>
                            <strong>Expiry:</strong> <?= date('jS F', strtotime($b['end_date'])); ?> (11:59 PM)
                        </div>

                        <div class="booking-subtitle">
                            Amount: ₹<?= number_format($b['total'], 2); ?>
                        </div>
                    </div>
                </div>
                <div class="booking-status <?= $statusClass; ?>">
                    <?= ucfirst($b['status']); ?>
                </div>
                <div class="booking-actions">
                    <button class="download-btn print-invoice">
                        <i class="bi bi-download"></i> Invoice
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No bookings found.</p>
    <?php endif; ?>
</div>


        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination-container">
                <ul class="pagination">
                    <li class="pagination-item">
                        <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . max(1, $current_page - 1)); ?>"
                            class="pagination-link <?= ($current_page == 1) ? 'disabled' : ''; ?>">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    <?php
                    $start = max(1, $current_page - 1);
                    $end = min($total_pages, $start + 2);
                    for ($i = $start; $i <= $end; $i++):
                        ?>
                        <li class="pagination-item">
                            <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . $i); ?>"
                                class="pagination-link <?= ($i == $current_page) ? 'active' : ''; ?>">
                                <?= $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="pagination-item">
                        <a href="<?= base_url('profile/bookings/' . $user->id . '?page=' . min($total_pages, $current_page + 1)); ?>"
                            class="pagination-link <?= ($current_page == $total_pages) ? 'disabled' : ''; ?>">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>

                <div class="pagination-info">
                    Showing <?= ($current_page - 1) * $limit + 1; ?>-
                    <?= min($current_page * $limit, $total_rows); ?>
                    of <?= $total_rows; ?> results
                </div>
            </div>
        <?php endif; ?>
    </div>

    <a href="<?= base_url('profile'); ?>" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back to Dashboard
    </a>
</div>
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
    function applyFilters() {
        let status = document.getElementById("statusFilter").value;
        let dateRange = document.getElementById("dateFilter").value;
        let sortBy = document.getElementById("sortFilter").value;

        let items = document.querySelectorAll(".booking-item");

        items.forEach(item => {
            let itemStatus = item.dataset.status;
            let itemDate = new Date(item.dataset.start);
            let show = true;

            // Status filter
            if (status && itemStatus !== status) {
                show = false;
            }

            // Date range filter
            if (dateRange) {
                let today = new Date();
                let startOfWeek = new Date(today);
                startOfWeek.setDate(today.getDate() - today.getDay());
                let endOfWeek = new Date(startOfWeek);
                endOfWeek.setDate(startOfWeek.getDate() + 6);

                let startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                let endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

                let startOfLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                let endOfLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);

                switch (dateRange) {
                    case "today":
                        if (itemDate.toDateString() !== today.toDateString()) show = false;
                        break;
                    case "this_week":
                        if (itemDate < startOfWeek || itemDate > endOfWeek) show = false;
                        break;
                    case "this_month":
                        if (itemDate < startOfMonth || itemDate > endOfMonth) show = false;
                        break;
                    case "last_month":
                        if (itemDate < startOfLastMonth || itemDate > endOfLastMonth) show = false;
                        break;
                }
            }

            item.style.display = show ? "" : "none";
        });

        // Sorting
        let container = document.getElementById("bookingList");
        let visibleItems = Array.from(items).filter(item => item.style.display !== "none");

        let sorted = visibleItems.sort((a, b) => {
            let aDate = new Date(a.dataset.start);
            let bDate = new Date(b.dataset.start);
            let aAmt = parseFloat(a.dataset.amount);
            let bAmt = parseFloat(b.dataset.amount);

            if (sortBy === "date_desc") return bDate - aDate;
            if (sortBy === "date_asc") return aDate - bDate;
            if (sortBy === "amount_desc") return bAmt - aAmt;
            if (sortBy === "amount_asc") return aAmt - bAmt;
            return 0;
        });

        // Re-append in sorted order
        sorted.forEach(item => container.appendChild(item));
    }

    function clearFilters() {
        document.getElementById("statusFilter").value = "";
        document.getElementById("dateFilter").value = "";
        document.getElementById("sortFilter").value = "date_desc";
        applyFilters();
    }

    // Event listeners
    document.querySelectorAll("#statusFilter, #dateFilter, #sortFilter")
        .forEach(el => el.addEventListener("change", applyFilters));


    $(document).on("click", ".pagination-link", function (e) {
        e.preventDefault();
        if ($(this).hasClass("disabled") || $(this).hasClass("active")) return;

        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            success: function (response) {
                $("#bookingResults").html($(response).find("#bookingResults").html());
                $('html, body').animate({ scrollTop: $("#bookingResults").offset().top - 100 }, 300);
            }
        });
    });
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.print-invoice').forEach(btn => {
        btn.addEventListener('click', function () {
            let booking = this.closest('.booking-item');

            let logoUrl = "<?= base_url('assets/images/logo_ficat.png'); ?>"; 
            let gym = booking.dataset.gym;
            let bookingDate = booking.dataset.booking;
            let validity = booking.dataset.validity;
            let expiry = booking.dataset.expiry;
            let amount = booking.dataset.amountText;
            let status = booking.dataset.statusText;

            let printContent = `
                <div style="font-family: Arial; padding:30px; max-width:750px; margin:0 auto; border:1px solid #ddd; border-radius:10px;">
                    <div style="text-align:center; margin-bottom:20px;">
                        <img src="${logoUrl}" alt="Company Logo" style="max-height:80px; margin-bottom:10px;">
                        <h2 style="margin:5px 0; font-size:24px; font-weight:bold; color:#007bff;">
                            Booking Receipt
                        </h2>
                    </div>

                   

                    <table cellspacing="0" cellpadding="10" 
                           style="width:100%; border:1px solid #ddd; border-collapse:collapse; text-align:center; font-size:14px; margin-top:15px;">
                        <thead>
                            <tr style="background:#f9f9f9; font-weight:bold; border-bottom:1px solid #ddd;">
                                <th style="border:1px solid #ddd;">Gym Name</th>
                                <th style="border:1px solid #ddd;">Validity</th>
                                <th style="border:1px solid #ddd;">Expiry</th>
                                <th style="border:1px solid #ddd;">Amount</th>
                                <th style="border:1px solid #ddd;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border:1px solid #ddd;">${gym}</td>
                                <td style="border:1px solid #ddd;">${validity}</td>
                                <td style="border:1px solid #ddd;">${expiry}</td>
                                <td style="border:1px solid #ddd;">${amount}</td>
                                <td style="border:1px solid #ddd;">${status}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3 style="text-align:right; margin-top:20px; font-weight:bold; color:#007bff; border-top:2px solid #ddd; padding-top:10px;">
                        Grand Total: ${amount}
                    </h3>

                    <p style="font-size:12px; margin-top:25px; text-align:center; color:#555;">
                        Thank you for booking with us!<br>
                        Visit <a href="https://fitcket.com" target="_blank" style="color:#007bff; text-decoration:none;">fitcket.com</a> for more services.
                    </p>
                </div>
            `;

            let win = window.open('', '_blank', 'width=800,height=600');
            win.document.write(`<html><head><title>Booking Receipt</title></head><body>${printContent}</body></html>`);
            win.document.close();
            win.print();
        });
    });
});


</script>