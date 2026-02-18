<!--start page wrapper -->
<div class="page-wrapper p-4">
  <div class="page-content">
    <div class="card shadow-sm">
      <div class="card-header bg-white border-bottom">
        <h5 class="mb-0 fw-semibold">Add / Update Offer</h5>
      </div>

      <div class="card-body">
        <form id="offer_form" method="post" novalidate>

          <!-- Heading Row -->
          <div class="row text-center fw-semibold border-bottom pb-2 mb-3">
            <div class="col-md-2">Duration</div>
            <div class="col-md-2">Buy Quantity</div>
            <div class="col-md-2">Free Quantity</div>
            <div class="col-md-3">Valid Till</div>
            <div class="col-md-2">Status</div>
          </div>

          <?php 
            $durations = ['Day', 'Week', 'Month', 'Year'];
            $today = date('Y-m-d');

            // Convert offers array into an associative array by duration
            $offer_map = [];
            if (!empty($offer)) {
              foreach ($offer as $o) {
                $offer_map[$o->duration] = $o;
              }
            }

            foreach ($durations as $duration): 
              $current = isset($offer_map[$duration]) ? $offer_map[$duration] : null;
          ?>
          <div class="row g-3 align-items-center mb-3 text-center">
            <div class="col-md-2 text-md-start">
              <label class="fw-medium"><?= $duration ?></label>
              <input type="hidden" name="duration[]" value="<?= $duration ?>">
              <input type="hidden" name="id[]" value="<?= $current ? $current->id : '' ?>">
            </div>

            <div class="col-md-2">
              <input type="number" min-="1" class="form-control text-center" name="buy_quantity[]" 
                value="<?= $current ? $current->buy_quantity : 0 ?>">
            </div>

            <div class="col-md-2">
              <input type="number" min="1" class="form-control text-center" name="free_quantity[]" 
                value="<?= $current ? $current->free_quantity : 0 ?>">
            </div>

            <div class="col-md-3">
              <input type="date" class="form-control" name="valid_till[]" 
                value="<?= $current ? $current->valid_till : $today ?>">
            </div>

            <div class="col-md-2">
              <select class="form-select text-center" name="isActive[]">
                <option value="1" <?= ($current && $current->isActive == 1) ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= (!$current || $current->isActive == 0) ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
          </div>
          <?php endforeach; ?>

          <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary px-4">Save Offers</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<!--end page wrapper -->
            </div>