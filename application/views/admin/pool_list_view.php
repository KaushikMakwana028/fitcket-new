<div class="page-wrapper p-4">
    <div class="page-content">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">All Pools</h5>
                    <small class="text-muted">Select a pool to manage up to <?= (int) $max_questions ?> questions.</small>
                </div>
                <span class="badge bg-primary"><?= count($pools ?? []) ?> Pools</span>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pool Name</th>
                                <th>Host</th>
                                <th>Entry Price</th>
                                <th>User Limit</th>
                                <th>Questions</th>
                                <th width="260">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pools)) : ?>
                                <?php foreach ($pools as $index => $pool) : ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= html_escape($pool['pool_name']) ?></td>
                                        <td><?= html_escape($pool['host_name']) ?></td>
                                        <td>Rs. <?= number_format((float) $pool['price'], 2) ?></td>
                                        <td><?= (int) $pool['user_limit'] ?></td>
                                        <td>
                                            <span class="badge <?= ((int) $pool['question_count'] >= (int) $max_questions) ? 'bg-success' : 'bg-warning text-dark' ?>">
                                                <?= (int) $pool['question_count'] ?>/<?= (int) $max_questions ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/pool/' . (int) $pool['id']) ?>" class="btn btn-primary btn-sm">
                                                <i class="bx bx-edit"></i> Manage Questions
                                            </a>
                                            <a href="<?= base_url('admin/pool/' . (int) $pool['id'] . '/leaderboard') ?>" class="btn btn-dark btn-sm ms-1">
                                                <i class="bx bx-bar-chart-alt-2"></i> Leaderboard
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" class="text-center text-danger">No pools found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
