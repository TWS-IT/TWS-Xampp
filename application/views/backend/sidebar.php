        <aside class="left-sidebar">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                        <?php 
                        $id = $this->session->userdata('user_login_id');
                        $basicinfo = $this->employee_model->GetBasic($id); 
                        ?>                
                <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img text-center">
                        <?php
                        $image_name = $basicinfo->em_image ?? '';
                        $image_path = 'assets/images/users/' . $image_name;
                        $full_path = FCPATH . $image_path;
                        if (!empty($image_name) && file_exists($full_path)) {
                            // Image exists — show it
                            echo '<img src="' . base_url($image_path) . '" alt="user" />';
                        } else {
                            // Image missing — show Font Awesome user icon
                            echo '<i class="fa fa-user-circle" style="font-size: 60px; color: #ccc;"></i>';
                        }
                        ?>
            </div>

                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5><?php echo $basicinfo->first_name.' '.$basicinfo->last_name; ?></h5>
                        <a href="<?php echo base_url(); ?>settings/Settings" class="dropdown-toggle u-dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                        <a href="<?php echo base_url(); ?>login/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a href="<?php echo base_url(); ?>" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>
                        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!--<li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>-->
                                <li><a href="<?php echo base_url(); ?>leave/EmApplication"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li>
                            </ul>
                        </li> 
                        <!-- Side bar project add feature -->
                       <li> 
  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
    <i class="mdi mdi-briefcase-check"></i>
    <span class="hide-menu">Projects</span>
  </a>
  <ul aria-expanded="false" class="collapse">
    <li><a href="<?php echo base_url(); ?>Projects/All_Projects">All Projects</a></li>
    <li><a href="<?php echo base_url(); ?>Projects/All_Tasks">Task List</a></li>

    <?php
    $CI =& get_instance();
    $CI->load->model('project_model');
    $projects = $CI->project_model->GetProjectsValue();
    foreach ($projects as $project) {
        echo '<li><a href="' . base_url('Projects/view?P=' . base64_encode($project->id)) . '">' . htmlspecialchars($project->pro_name) . '</a></li>';
    }
    ?>
  </ul>
</li>

                                                                       
                        <?php } else { ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Disciplinary">Disciplinary </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>employee/Inactive_Employee">Inactive User </a></li> -->
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-clipboard-text"></i><span class="hide-menu">Attendance </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>attendance/Attendance">Attendance List </a></li>
                                <li><a href="<?php echo base_url(); ?>attendance/Save_Attendance">Add Attendance </a></li>
                                <li><a href="<?php echo base_url(); ?>attendance/Attendance_Report">Attendance Report </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report">Report</a></li> 
                            </ul>
                        </li>
                       <!-- <li>
  <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
    <i class="mdi mdi-earth"></i>
    <span class="hide-menu">Holiday</span>
  </a>
  <ul aria-expanded="false" class="collapse">
 <li><a href="<?php echo base_url(); ?>leave/Holidays">Holidays List</a></li> -->
    <!-- <li><a href="<?php echo base_url(); ?>leave/leavetypes">Leave List</a></li>
    <li><a href="<?php echo base_url(); ?>leave/Application">Application List</a></li>
    <li><a href="<?php echo base_url(); ?>leave/Earnedleave">Earn Balance</a></li> -->
    
  <!-- </ul> -->
</li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-briefcase-check"></i><span class="hide-menu">Project </span></a>
                            <ul aria-expanded="false" class="collapse">
                                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">W </span></a>
                                        <ul aria-expanded="false" class="collapse">
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Order Report</a></li>
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Sortage</a></li>
                                        </ul>
                                    </li>
                                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">A </span></a>
                                        <ul aria-expanded="false" class="collapse">
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Order Report</a></li>
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Sortage</a></li>
                                        </ul>
                                    </li>
                                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">W1W </span></a>
                                        <ul aria-expanded="false" class="collapse">
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Order Report</a></li>
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Sortage</a></li>
                                        </ul>
                                    </li>
                                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">K </span></a>
                                        <ul aria-expanded="false" class="collapse">
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Order Report</a></li>
                                            <li><a href="<?php echo base_url(); ?>Projects/All_Tasks"> Sortage</a></li>
                                        </ul>
                                    </li>
                            </ul>
                        </li>
                        <!-- <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                               <li><a href="<?php #echo base_url(); ?>Payroll/Salary_Type"> Payroll Type </a></li>-->
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Payroll List </a></li> -->
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Generate_salary"> Generate Payslip</a></li> -->
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Payslip_Report"> Payslip Report</a></li> -->
                            <!-- </ul> -->
                        <!-- </li>  -->
                      <li> 
    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
        <i class="mdi mdi-alert-circle"></i>
        <span class="hide-menu">Mistakes</span>
    </a>
    <ul aria-expanded="false" class="collapse">
        <li><a href="<?php echo base_url(); ?>Loan/View"> IR </a></li>
        <li><a href="<?php echo base_url(); ?>Loan/installment"> Warning Latter</a></li>
    </ul>
</li>
                        <!-- <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-grid"></i><span class="hide-menu">Assets </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>Logistice/Assets_Category"> Assets Category </a></li>
                                <li><a href="<?php echo base_url(); ?>Logistice/All_Assets"> Asset List </a></li>
                               <li><a href="<?php #echo base_url(); ?>Logistice/View"> Logistic Support List </a></li>-->
                                <!-- <li><a href="<?php echo base_url(); ?>Logistice/logistic_support"> Logistic Support </a></li> -->
                            <!-- </ul> -->
                        <!-- </li> --> 
                        
                        <li> <a href="<?php echo base_url()?>notice/All_notice" ><i class="mdi mdi-clipboard"></i><span class="hide-menu">Notice <span class="hide-menu"></a></li>
                        <li> <a href="<?php echo base_url(); ?>settings/Settings" ><i class="mdi mdi-settings"></i><span class="hide-menu">Settings <span class="hide-menu"></a></li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>