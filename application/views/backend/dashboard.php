<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
                <i class="fa fa-braille" style="color:#1976d2"></i>&nbsp Dashboard
            </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <!-- New Modern Dashboard Stats Start -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-users text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>
                        <?php 
                            $this->db->where('status','ACTIVE');
                            $this->db->from("employee");
                            echo $this->db->count_all_results();
                        ?>
                    </h4>
                    <p class="text-muted">TOTAL EMPLOYEES</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-globe text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>
                        <?php 
                            $this->db->where('leave_status','Approve');
                            $this->db->from("emp_leave");
                            echo $this->db->count_all_results();
                        ?>
                    </h4>
                    <p class="text-muted">TODAY ORDERS</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-upload text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>600</h4>
                    <p class="text-muted">GROWTH</p>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-random text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>Atas Project</h4>
                    <p class="text-muted">PROJECT NAME</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-exclamation-triangle text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>
                        <?php 
                            $this->db->where('status','Granted');
                            $this->db->from("loan");
                            echo $this->db->count_all_results();
                        ?>
                    </h4>
                    <p class="text-muted">MISTAKES</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center p-3 shadow-sm">
                    <i class="fa fa-shopping-cart text-primary mb-2" style="font-size: 24px;"></i>
                    <h4>89%</h4>
                    <p class="text-muted">ALL ORDER PERCENTAGE</p>
                </div>
            </div>
        </div>
        <!-- New Modern Dashboard Stats End -->
    </div>

    <div class="container-fluid">
        <?php 
        $notice = $this->notice_model->GetNoticelimit(); 
        $running = $this->dashboard_model->GetRunningProject(); 
        $userid = $this->session->userdata('user_login_id');
        $todolist = $this->dashboard_model->GettodoInfo($userid);                 
        $holiday = $this->dashboard_model->GetHolidayInfo();                 
        ?>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Running Project/s</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:600px;overflow-y:scroll">
                            <table class="table table-bordered table-hover earning-box">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Employee Count</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($running AS $value): ?>
                                    <tr style="vertical-align:top;">
                                        <td><a href="<?php echo base_url(); ?>Projects/view?P=<?php echo base64_encode($value->id); ?>"><?php echo substr("$value->pro_name",0,25).'...'; ?></a></td>
                                        <td><?php echo $value->employee_count; ?></td>
                                        <td><?php echo $value->pro_end_date; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>                                
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">To Do list</h4>
                        <h6 class="card-subtitle">List of your next task to complete</h6>
                        <div class="to-do-widget m-t-20" style="height:550px;overflow-y:auto;">
    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
        <?php foreach($todolist as $value): ?>
        <li class="list-group-item d-flex align-items-start" data-role="task" style="text-align: left;">
            <?php if($value->value == '1'){ ?>
            <div class="checkbox checkbox-info w-100">
                <input class="to-do" data-id="<?php echo $value->id?>" data-value="0" type="checkbox" id="<?php echo $value->id?>">
                <label for="<?php echo $value->id?>" class="mb-0 ms-2"><span><?php echo $value->to_dodata; ?></span></label>
            </div>
            <?php } else { ?>
            <div class="checkbox checkbox-info w-100">
                <input class="to-do" data-id="<?php echo $value->id?>" data-value="1" type="checkbox" id="<?php echo $value->id?>" checked>
                <label for="<?php echo $value->id?>" class="task-done mb-0 ms-2"><span><?php echo $value->to_dodata; ?></span></label>
            </div>
            <?php } ?>
        </li>
        <?php endforeach; ?>
    </ul>                                    
</div>

                        <div class="new-todo">
                            <form method="post" action="add_todo" enctype="multipart/form-data" id="add_todo">
                                <div class="input-group">
                                    <input type="text" name="todo_data" class="form-control" style="border: 1px solid #fff !IMPORTANT;" placeholder="Enter New Task...">
                                    <span class="input-group-btn">
                                        <input type="hidden" name="userid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
                                        <button type="submit" class="btn btn-success todo-submit"><i class="fa fa-plus"></i></button>
                                    </span> 
                                </div>
                            </form>
                        </div>                                
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notice Board</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive slimScrollDiv" style="height:600px;overflow-y:scroll">
                            <table class="table table-hover table-bordered earning-box ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>File</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($notice AS $value): ?>
                                    <tr class="scrollbar" style="vertical-align:top">
                                        <td><?php echo $value->title ?></td>
                                        <td><mark><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url ?>" target="_blank"><?php echo $value->file_url ?></a></mark></td>
                                        <td style="width:100px"><?php echo $value->date ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Holidays</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="height:600px;overflow-y:scroll">
                            <table class="table table-hover table-bordered earning-box">
                                <thead>
                                    <tr>
                                        <th>Holiday Name</th>
                                        <th>Date</th>
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php foreach($holiday as $value): ?>
                                    <tr style="background-color:#e3f0f7">
                                        <td><?php echo $value->holiday_name ?></td>
                                        <td><?php echo $value->from_date; ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <script>
        $(".to-do").on("click", function(){
            $.ajax({
                url: "Update_Todo",
                type:"POST",
                data: {
                    'toid': $(this).attr('data-id'),         
                    'tovalue': $(this).attr('data-value'),
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    console.error();
                }
            });
        });
        </script>
<?php $this->load->view('backend/footer'); ?>
