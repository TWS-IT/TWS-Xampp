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
        <!-- New Modern Dashboard Cards -->
        <div class="grid-container" style="margin-top: 20px;">
            <!-- TOTAL EMPLOYEES -->
            <div class="card" style="--grad: #FFC107, #FF9800;">
                <div class="title">Total Employees</div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="content">
                    <h2>
                        <?php 
                            $this->db->where('status','ACTIVE');
                            $this->db->from("employee");
                            echo $this->db->count_all_results();
                        ?>
                    </h2>
                    <p>Currently Active Employees</p>
                    <!-- <select class="form-select form-select-sm mt-2" style="width: 120px;">
                        <option selected>All</option>
                        <option value="country1">Malaysia</option>
                        <option value="Country2">Sri Lanka</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Combodia">Cambodia</option>
                    </select> -->
                </div>
            </div>

            <!-- ORDERS -->
            <div class="card" style="--grad: #2196F3, #03A9F4;">
                <div class="title">Orders</div>
                <div class="icon"><i class="fa fa-list-alt"></i></div>
                <div class="content">
                    <h2>
                        <?php 
                            $this->db->where('leave_status','Approved');
                            $this->db->from("emp_leave");
                            echo $this->db->count_all_results();
                        ?>
                    </h2>
                    <p>Total Approved Orders</p>
                    <select class="form-select custom-select-sm mt-2 custom-dropdown" style="width: 120px;">
    <option selected>All</option>
    <option value="today">W</option>
    <option value="week">A</option>
    <option value="Month">W1W</option>
    <option value="Year">K</option>
</select>
                </div>
            </div>

            <!-- MISTAKES -->
            <div class="card" style="--grad: #F44336, #E91E63;">
                <div class="title">Mistakes</div>
                <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                <div class="content">
                    <h2>
    <?php 
        $this->db->from("ir");
        echo $this->db->count_all_results();
    ?>
</h2>


                    <p>Total Granted Mistakes</p>
                    <!-- Mistakes position filter dropdown -->
<select id="positionFilter" class="form-select custom-select-sm mt-2 custom-dropdown" style="width: 120px;">
    <option value="">All</option>
    <option value="W">W</option>
    <option value="Atas">Atas</option>
    <option value="K8 deposit">K8 deposit</option>
    <option value="K8 withdrawal">K8 withdrawal</option>
    <option value="TC">TC</option>
</select>

                </div>
            </div>
        </div>
        <!-- End Modern Cards -->

        <style>
        .grid-container {
            width: min(90%, 1200px);
            margin-inline: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
         @keyframes shake {
    0% { transform: translate(0px, 0px); }
    20% { transform: translate(-2px, 0px); }
    40% { transform: translate(2px, 0px); }
    60% { transform: translate(-2px, 0px); }
    80% { transform: translate(2px, 0px); }
    100% { transform: translate(0px, 0px); }
}

.card:hover {
    animation: shake 0.5s ease-in-out;
}
        .card {
            --grad: red, blue;
            padding: 2rem;
            background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
            border-radius: 1.5rem;
            display: grid;
            grid-template-areas:
                "title icon"
                "content content"
                "bar bar";
            grid-template-columns: 1fr auto;
            gap: 1rem;
            color: #444;
            box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);
        }
        .card .title {
            grid-area: title;
            font-size: 1.4rem;
            font-weight: 600;
            text-transform: uppercase;


        }
        .card .icon {
            grid-area: icon;
            font-size: 2.5rem;
            color: transparent;
            background: linear-gradient(to right, var(--grad));
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card .content {
            grid-area: content;
        }
        .card::after {
            content: "";
            grid-area: bar;
            height: 2px;
            background-image: linear-gradient(90deg, var(--grad));
        }
        .custom-dropdown {
    background: #f8f9fa;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 6px 10px;
    font-size: 14px;
    color: #333;
    appearance: none; /* Removes default arrow */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23666' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 10px 10px;
    transition: border-color 0.3s ease;
}

.custom-dropdown:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.2);
}

.custom-dropdown:hover {
    border-color: #007bff;
    cursor: pointer;
}

        </style>
    </div>

    <div class="container-fluid">
        <?php 
        $notice = $this->notice_model->GetNoticelimit(); 
        $running = $this->dashboard_model->GetRunningProject(); 
        $userid = $this->session->userdata('user_login_id');
        $todolist = $this->dashboard_model->GettodoInfo($userid);                 
        $leaveinfo = $this->dashboard_model->GetLeaveInfo();                 
        ?>

        <div class="row">
            <div class="col-md-8">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Running Project/s</h4>

            <div class="table-responsive" style="height:400px; overflow-y:auto; overflow-x:auto;">
                <table class="table table-bordered table-hover earning-box" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Employee Count</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($running AS $value): ?>
                        <tr style="vertical-align:top;">
                            <td><a href="<?php echo base_url(); ?>Projects/view?P=<?php echo base64_encode($value->id); ?>"><?php echo substr("$value->pro_name",0,25).'...'; ?></a></td>
                            <td><?php echo $value->employee_count; ?></td>
                            <td><?php echo $value->pro_description; ?></td>
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
                        <div class="to-do-widget m-t-20" style="height:330px;overflow-y:auto;">
                            <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                <?php foreach($todolist as $value): ?>
                                <li class="list-group-item d-flex align-items-start" data-role="task" style="text-align: left;">
                                    <?php if($value->value == '1'){ ?>
                                    <div class="checkbox checkbox-info w-100" style="display: flex; align-items: center; gap: 8px;">

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
                    
                    <div class="card-body">
                        <div class="table-responsive slimScrollDiv" style="height:400px;overflow-y:scroll">
                            <table class="table table-hover table-bordered earning-box">
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
        </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Leave List</h4>
                    
                    <div class="card-body">
                        <div class="table-responsive" style="height:400px;overflow-y:scroll">
                            <table class="table table-hover table-bordered earning-box">
                                <thead>
                                    <tr>
                                        <th>Leave Type</th>
                                        <th>Duration</th>
                                    </tr>                                            
                                </thead>
                                <tbody>
                                    <?php foreach($leaveinfo as $value): ?>
                                    <tr style="background-color:#e3f0f7">
                                        <td><?php echo $value->leave_type ?></td>
                                        <td><?php echo $value->leave_duration; ?></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div> 

        <script>
        $(document).ready(function(){
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
        });



        $(document).ready(function() {
    function loadMistakeCount(position = '') {
        $.ajax({
            url: "<?php echo base_url('Dashboard/mistake_count'); ?>",
            type: "POST",
            data: { position: position },
            success: function(response) {
                $('.card .title:contains("Mistakes")').siblings('.content').find('h2').text(response);
            },
            error: function(xhr) {
                console.log("Error:", xhr.responseText);
            }
        });
    }

    // Initial load
    loadMistakeCount();

    // Update count when position is changed
    $('#positionFilter').on('change', function() {
        const selectedPosition = $(this).val();
        loadMistakeCount(selectedPosition);
    });
});
        </script>

        
<?php $this->load->view('backend/footer'); ?>
