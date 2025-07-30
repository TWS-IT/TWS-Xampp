<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-file-text"></i> Incident Report</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Incident Report</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info">
                    <i class="fa fa-plus"></i>
                    <a data-toggle="modal" data-target="#irModal" class="text-white"> New IR</a>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> IR List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="irTable" class="display nowrap table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Employee ID</th>
                                        <th>Department</th>
                                        <th>Details of Incident</th>
                                        <th>Date of Incident</th>
                                        <th>Description of Incident</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($irview as $value): ?>
                                        <tr>
                                            <td><?php echo $value->first_name . ' ' . $value->last_name; ?></td>
                                            <td><?php echo $value->em_code; ?></td>
                                            <td><?php echo $value->position; ?></td>
                                            <td><?php echo $value->ir_details; ?></td>
                                            <td><?php echo $value->ir_date; ?></td>
                                            <td><?php echo $value->prevent; ?></td>
                                            <td class="jsgrid-align-center">
                                                <a href="#" title="Edit" class="btn btn-sm btn-primary waves-effect waves-light irmodalclass" data-id="<?php echo $value->id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="irModal" tabindex="-1" role="dialog" aria-labelledby="irModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Incident Report</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('IR/Add_IR'); ?>" id="irForm">


                    <div class="modal-body">
                        <div class="form-group row">
    <label class="col-md-3 control-label">Full Name</label>
    <select class="form-control custom-select col-md-8" name="emid" required>
        <option value="">Select Here</option>
        <?php foreach($employee as $value): ?>
            <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name . ' ' . $value->last_name; ?></option>
        <?php endforeach; ?>
    </select>
</div>
                        
                        <div class="form-group row">
    <label class="col-md-3 control-label">Department</label>
    <select class="form-control custom-select col-md-8" name="position" required>
        <option value="">Select Department</option>
        <option value="W">W</option>
        <option value="Atas">Atas</option>
        <option value="K8 deposit">K8 deposit</option>
        <option value="K8 withdrawal">K8 withdrawal</option>
        <option value="TC">TC</option>
    </select>
</div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Date of Incident</label>
                            <input type="date" name="ir_date" class="form-control col-md-8" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Details of Incident</label>
                            <input type="text" name="ir_details" class="form-control col-md-8" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Prevent Mistake</label>
                            <textarea name="prevent" class="form-control col-md-8"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" id="submitIR" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>






<script>
    $(document).ready(function () {
        $(".irmodalclass").click(function (e) {
            e.preventDefault();
            var iid = $(this).attr('data-id');
            $('#irForm').trigger("reset");
            $('#irModal').modal('show');
            $.ajax({
                url: 'IRByID?id=' + iid,
                method: 'GET',
                dataType: 'json',
            }).done(function (response) {
                $('#irForm').find('[name="emid"]').val(response.irvalue.emp_id).end();
                $('#irForm').find('[name="id"]').val(response.irvalue.id).end();
                $('#irForm').find('[name="position"]').val(response.irvalue.position).end();
                $('#irForm').find('[name="ir_date"]').val(response.irvalue.ir_date).end();
                $('#irForm').find('[name="ir_details"]').val(response.irvalue.ir_details).end();
                $('#irForm').find('[name="prevent"]').val(response.irvalue.prevent).end();
            });
        });

        $('#irTable').DataTable({
            "aaSorting": [[6, 'desc']],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
    });



$('#submitIR').click(function () {
    var formData = $('#irForm').serialize();

    $.ajax({
        url: "<?php echo base_url('IR/Add_IR'); ?>",
        type: "POST",
        data: formData,
        success: function (response) {
            $('#irModal').modal('hide');
            location.reload(); // reload to update table
        },
        error: function () {
            alert("Failed to save data.");
        }
    });
});



$('#irModal').on('hidden.bs.modal', function () {
    $('#irForm')[0].reset();
    $('#irForm').find('[name="id"]').val(''); // Clear hidden ID
});




</script>

<?php $this->load->view('backend/footer'); ?>




