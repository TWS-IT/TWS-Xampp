<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-exclamation-triangle"></i> Warning Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Warnings</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <a href="<?php echo base_url('Warning/create'); ?>" class="btn btn-info text-white">
                    <i class="fa fa-plus"></i> New Warning
                </a>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Warning List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="warningTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Reason</th>
                                        <th>Sub Reason</th>
                                        <th>Explanation</th>
                                        <th>Supervisor Comments</th>
                                        <th>Skip Supervisor Approval</th>
                                        <th>Divisional Head Approval</th>
                                        <th>Acknowledgement</th>
                                        <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($warnings as $value): ?>
                                        <tr>
                                            <td><?php echo $value->employee_id; ?></td>
                                            <td><?php echo $value->employee_name; ?></td>
                                            <td><?php echo $value->designation; ?></td>
                                            <td><?php echo $value->reason_for_warning; ?></td>
                                            <td><?php echo $value->sub_reasons; ?></td>
                                            <td><?php echo $value->brief_explanation; ?></td>
                                            <td><?php echo $value->supervisors_comments; ?></td>
                                            <td><?php echo $value->skp_requested_approval; ?></td>
                                            <td><?php echo $value->dh_requested_approval; ?></td>
                                            <td><?php echo $value->acknowledgement; ?></td>
                                            <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                                <td class="jsgrid-align-center">
                                                    <a href="<?php echo base_url('Warning/edit/' . $value->id); ?>"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger deletebtn"
                                                        data-id="<?php echo $value->id; ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            <?php endif; ?>
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
</div>

<script>
    $(document).ready(function () {
        $('#warningTable').DataTable({
            "aaSorting": [],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Handle Delete
        $(document).on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this warning?")) {
                $.ajax({
                    url: "<?php echo base_url('Warning/delete_warning'); ?>",
                    type: "POST",
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert("Failed to delete.");
                    }
                });
            }
        });
    });
</script>

<?php $this->load->view('backend/footer'); ?>