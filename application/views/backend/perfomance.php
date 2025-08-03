<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="mdi mdi-speedometer"></i> Employee Performance</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Employee Perfomance</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table id="employees123" class="display nowrap table table-hover table-striped table-bordered"
                    cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Project</th>
                            <th>Total Orders</th>
                            <th>Mistakes</th>
                            <th>Efficiency</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($performance_data)) {
                            foreach ($performance_data as $row): ?>
                                <tr>
                                    <td><?= $row['em_code'] ?></td>
                                    <td><?= $row['full_name'] ?></td>
                                    <td><?= $row['project'] ?></td>
                                    <td><?= $row['total_orders'] ?></td>
                                    <td><?= $row['mistakes'] ?></td>
                                    <td><?= $row['efficiency'] ?>%</td>
                                </tr>
                            <?php endforeach;
                        } else {
                            echo '<tr><td colspan="6">No data available.</td></tr>';
                        } ?>
                    </tbody>
                </table>


            </div>

        </div>
    </div>


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