<div class="page-wrapper">
    <div class="page-content">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <h4>My Reviews</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($reviews)): ?>
                                <?php $i = 1;
                                foreach ($reviews as $row): ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row->user_name ?? '-'; ?></td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                <?= $row->rating; ?> ★
                                            </span>
                                        </td>
                                        <td><?= $row->review_text; ?></td>
                                        <td><?= date('d M Y', strtotime($row->created_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Reviews Found</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>