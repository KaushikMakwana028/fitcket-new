<div class="pagination-container mt-2">
    <div class="pagination-info">
        Showing <?= (($current_page - 1) * $per_page + 1) ?>-
        <?= min($current_page * $per_page, $total_transactions) ?>
        of <?= $total_transactions ?> transactions
    </div>

    <div class="pagination-controls mt-3">
        <!-- Prev Button -->
        <button class="page-btn" id="prev-page" <?= ($current_page <= 1 ? 'disabled' : '') ?>>
            <i class="fas fa-chevron-left"></i>
        </button>

        <?php
        $total_pages = ceil($total_transactions / $per_page);

        if ($total_pages > 1) {
            // Always show page 1
            if ($current_page == 1) {
                echo '<button class="page-btn active" data-page="1">1</button>';
            } else {
                echo '<button class="page-btn" data-page="1">1</button>';
            }

            // Show ellipsis if current page > 3
            if ($current_page > 3) {
                echo '<span class="dots">...</span>';
            }

            // Middle pages (only 1 before & 1 after current)
            $start = max(2, $current_page - 1);
            $end   = min($total_pages - 1, $current_page + 1);

            for ($i = $start; $i <= $end; $i++) {
                if ($i == $current_page) {
                    echo '<button class="page-btn active" data-page="' . $i . '">' . $i . '</button>';
                } else {
                    echo '<button class="page-btn" data-page="' . $i . '">' . $i . '</button>';
                }
            }

            // Show ellipsis if current page is far from last
            if ($current_page < $total_pages - 2) {
                echo '<span class="dots">...</span>';
            }

            // Always show last page if >1
            if ($total_pages > 1) {
                if ($current_page == $total_pages) {
                    echo '<button class="page-btn active" data-page="' . $total_pages . '">' . $total_pages . '</button>';
                } else {
                    echo '<button class="page-btn" data-page="' . $total_pages . '">' . $total_pages . '</button>';
                }
            }
        }
        ?>

        <!-- Next Button -->
        <button class="page-btn" id="next-page" <?= ($current_page >= $total_pages ? 'disabled' : '') ?>>
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>
