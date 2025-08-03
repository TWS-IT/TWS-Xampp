<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
                <i class="fa fa-users" aria-hidden="true"></i> Daily Mistake Record
            </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Daily Mistake Record</li>
            </ol>
        </div>
    </div>

    <div class="message"></div>

    <!-- Add Entry Modal -->
    <div class="modal fade" id="mistakeModal" tabindex="-1" role="dialog" aria-labelledby="mistakeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mistakeModalLabel">Add Daily Mistake Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              <form method="post" action="<?= isset($mistake) ? site_url('Daily_Mistake/update_mistake') : site_url('Daily_Mistake/save_mistake') ?>" id="mistakeForm">
    <div class="modal-body">
        <!-- Hidden ID field for edit -->
        <?php if (isset($mistake)): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($mistake->id) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label>Employee</label>
            <select name="emp_id" class="form-control" required>
                <option value="">Select Employee</option>
                <?php foreach ($employee as $emp): ?>
                    <option value="<?= htmlspecialchars($emp->em_code) ?>"
                        <?= (isset($mistake) && $mistake->emp_id == $emp->em_code) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp->first_name . ' ' . $emp->last_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <label for="mistake_type">Mistake Type</label>
        <select name="mistake_type" id="mistake_type" class="form-control" required>
            <option value="">Select Mistake Type</option>
            <?php 
                $types = [
                    "Wrong Key in of Amount",
                    "Wrong Key in of Bank Code",
                    "Wrong Key - No Reference",
                    "Wrong Key - Double Key In",
                    "Wrong Key - Wrong Account",
                    "Wrong Key - Reversal",
                    "Double Payout",
                    "Custom"
                ];
                foreach ($types as $type): 
            ?>
                <option value="<?= htmlspecialchars($type) ?>"
                    <?= (isset($mistake) && $mistake->mistake_type == $type) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="form-group">
            <br>
            <label>PC Number</label>
            <input type="text" name="pc_number" class="form-control" placeholder="Enter PC Number" required
                value="<?= isset($mistake) ? htmlspecialchars($mistake->pc_number) : '' ?>">
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required
                value="<?= isset($mistake) ? htmlspecialchars($mistake->date) : '' ?>">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><?= isset($mistake) ? 'Update Entry' : 'Save Entry' ?></button>
    </div>
</form>

            </div>
        </div>
    </div>

    <!-- Add Entry Button -->
    <div class="container-fluid">
        <div class="row m-b-10"> 
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mistakeModal">
                    <i class="fa fa-plus"></i> Add Entry
                </button>
            </div>
        </div>

        <!-- Mistake Records Table -->
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Daily Mistake Record</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
                                        <th>Mistake Type</th>
                                        <th>PC Position</th>
                                        <th>Date</th>
                                        <th>Updated At</th>
                                       <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php if (!empty($mistakes) && is_array($mistakes) || is_object($mistakes)): ?>
    <?php foreach ($mistakes as $mistake): ?>
        <tr>
            <td><?= htmlspecialchars($mistake->employee_name) ?></td>
            <td><?= htmlspecialchars($mistake->emp_id) ?></td>
            <td><?= htmlspecialchars($mistake->mistake_type) ?></td>
            <td><?= htmlspecialchars($mistake->pc_number) ?></td>
            <td><?= htmlspecialchars($mistake->date) ?></td>
            <td><?= htmlspecialchars($mistake->updated_at) ?></td>
            <td>
                <button class="btn btn-outline-success btn-sm me-1" onclick='editMistake(<?= json_encode($mistake) ?>)'> 
                    <i class="bi bi-pencil-square"></i> 
                </button>

                <a href="<?= base_url("Daily_Mistake/delete_mistake/{$mistake->id}") ?>" 
   onclick="return confirm('Are you sure you want to delete this Mistake?')" 
   class="btn btn-outline-danger btn-sm"> 
    <i class="bi bi-trash"></i> 
</a>

            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="7" class="text-center">No mistakes found.</td></tr>
<?php endif; ?>
</tbody>

                            </table>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function editMistake(mistake) {
    // Populate modal fields
    $('#mistakeForm').attr('action', '<?= site_url("Daily_Mistake/update_mistake") ?>');
    $('input[name="id"]').remove(); // Remove existing hidden id input if any
    $('#mistakeForm').prepend(`<input type="hidden" name="id" value="${mistake.id}">`);
    $('select[name="emp_id"]').val(mistake.emp_id);
    $('select[name="mistake_type"]').val(mistake.mistake_type);
    $('input[name="pc_number"]').val(mistake.pc_number);
    $('input[name="date"]').val(mistake.date);

    $('#mistakeModal').modal('show');
}

</script>

<?php $this->load->view('backend/footer'); ?>

<script>
    $('#employees123').DataTable({
        "aaSorting": [[1, 'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
