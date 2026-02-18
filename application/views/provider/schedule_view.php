<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('provider/dashboard');?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Schedule Info</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="schedule-table">
            <form id="scheduleForm">
                <table class="table table-borderless">
                  <tbody>
    <?php 
    $days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];

    foreach ($days as $day): 
        $dayRec = isset($schedules[$day]) ? $schedules[$day] : null;
        $status = $dayRec ? $dayRec->status : 'holiday';
        $start  = $dayRec && $dayRec->start_time ? $dayRec->start_time : '10:00';
        $end    = $dayRec && $dayRec->end_time ? $dayRec->end_time : '18:00';
    ?>
    <tr>
        <td><?= ucfirst($day) ?></td>
        <td>
            <select class="form-select w-auto" name="status[<?= $day ?>]">
                <option value="holiday" <?= $status=='holiday'?'selected':''; ?>>Holiday</option>
                <option value="open" <?= $status=='open'?'selected':''; ?>>Open</option>
            </select>
        </td>
        <td>
            <input type="time" class="form-control time-input" 
                   name="from[<?= $day ?>]" 
                   value="<?= $start ?>">
        </td>
        <td>
            <input type="time" class="form-control time-input" 
                   name="to[<?= $day ?>]" 
                   value="<?= $end ?>">
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

                </table>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
                        </div>