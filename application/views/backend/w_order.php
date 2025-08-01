<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h5 class="text-themecolor"><i class="fa fa-archive" aria-hidden="true"></i> W Order Report</h>
                </div>
                
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">W Order</li>
                    </ol>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                        
                        <?php } else { ?>
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Order </a></button>
                        <?php } ?>
                    </div>
                </div>

                
                 
                       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel1">
          <i class="fa fa-braille"></i> Add Order
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

 
      <form method="post" action="<?= base_url('W_Order/Save_W') ?>" id="btnSubmit" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
 
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Employee Position</label>
                <input type="text" name="pc_position" class="form-control" id="emp-positionid" maxlength="20" placeholder="AAA203C" required>
              </div>
              <div class="form-group">
                <label class="control-label">Employee Name</label>
                 <select id="employee-select" name="employee_id" style="width: 100%;" required>

    <?php if (!empty($attval->em_code)) { ?>
        <option value="<?= $attval->em_code ?>"><?= htmlspecialchars($attval->first_name . ' ' . $attval->last_name) ?></option>           
    <?php } else { ?>
        <option value="">Select Here</option>
        <?php foreach ($employee as $value): ?>
            <option value="<?= $value->em_code ?>"><?= htmlspecialchars($value->first_name . ' ' . $value->last_name) ?></option>
        <?php endforeach; ?>
    <?php } ?>
</select>

              </div>
             <div class="form-group">
  <label class="control-label">Order Date</label>
  <input type="date" name="order_date" class="form-control datepicker" id="order-dateid" required>
</div>

<div class="form-group">
  <label class="control-label">Shift</label>
  <select class="form-control custom-select" name="shift" required>
  <option value="">Select Shift</option>
  <option value="Morning">Morning</option>
  <option value="Noon">Noon</option>
  <option value="Night">Night</option>
</select>
</div>

<div class="form-group">
  <label class="control-label">Order Count</label>
  <input type="text" name="order_count" class="form-control" id="ordercount" placeholder="Enter the Order Count" required>
</div>

          </div>
            </div>
             
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

                         <div class="container-fluid">
        <!-- New Modern Dashboard Cards -->
        <div class="grid-container" style="margin-top: 20px;">
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
         /* @keyframes shake {
    0% { transform: translate(0px, 0px); }
    20% { transform: translate(-2px, 0px); }
    40% { transform: translate(2px, 0px); }
    60% { transform: translate(-2px, 0px); }
    80% { transform: translate(2px, 0px); }
    100% { transform: translate(0px, 0px); }
}

.card:hover {
    animation: shake 0.5s ease-in-out;
} */
        .card {
    --grad: red, blue;
    padding: 1rem; /* reduced from 2rem */
    background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
    border-radius: 1rem; /* reduced from 1.5rem */
    display: grid;
    grid-template-areas:
        "title icon"
        "content content"
        "bar bar";
    grid-template-columns: 1fr auto;
    gap: 0.5rem; /* reduced from 1rem */
    color: #444;
    box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);
    font-size: 0.9rem; /* optional: reduces text size slightly */
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
  

        <script>
        


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







        
<?php
// Dashboard Page - Full HTML converted to PHP wrapper
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- ApexCharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f5fc;
      color: #333;
    }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
    }

    .card h6 {
      font-size: 14px;
      font-weight: 600;
      color: #555;
    }
.highlight {
  font-size: 24px;
  font-weight: 600;
  color: #7267EF;
  background-color: transparent; /* ← Add your desired background color here */
  padding: 8px 12px;
  border-radius: 8px; /* Optional: for rounded corners */
  display: inline-block; /* Ensures padding works neatly */
}


    .chart-box {
      height: 160px;
    }

    .section-title {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 10px;
    }

    .profile {
      text-align: right;
    }

    .profile span {
      display: block;
      font-size: 14px;
      color: #888;
    }
  </style>
</head>

<body>
  <!-- <div class="container-fluid p-4"> -->

    <!-- Row 1: Stats -->
    <!-- <div class="row">
      <div class="col-md-3">
        <div class="card">
        <div class="card-body">
          <h6>Total Employees</h6>
          <div class="card">150</div>
        </div>
      </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <h6>Today Orders</h6>
          <div>1250</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <h6>Project Name</h6>
          <div class="highlight">Atas Project</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <h6>Mistakes</h6>
          <div class="highlight">3550</div>
        </div>
      </div>
    </div>

   
    <div class="row">
      <div class="col-md-3">
        <div class="card p-3">
          <h6>Growth</h6>
          <div class="highlight">600</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <h6>All Order Percentage</h6>
          <div class="highlight">89%</div>
        </div>
      </div>
    </div>

    < Row 3: Charts -->
    <div class="row">
      <div class="col-md-6">
        <div class="card p-3">
          <h6 class="section-title">Mistakes Rate</h6>
          <div class="highlight">53.94%</div>
          <div class="chart-box" id="areaChart"></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3">
          <h6 class="section-title">Complete Orders</h6>
          <div class="highlight">5432</div>
          <div class="chart-box" id="barChart"></div>
        </div>
      </div>
    </div>

    <!-- Row 4: Line Chart -->
    <div class="row">
      <div class="col-md-6">
        <div class="card p-3">
          <h6 class="section-title">Project wise monthly Order report</h6>
          <div class="highlight mb-2">105 Total Orders | 120 Total Mistakes</div>
          <div id="lineChart" style="height: 300px;"></div>
        </div>
      </div>
   

    <!-- Row 5: Pie Chart -->
   
      <div class="col-md-6">
        <div class="card p-3">
          <h6 class="section-title">Customer Satisfaction</h6>
          <div id="pieChart" style="height: 400px;"></div>
        </div>
      </div>
    </div>

    <!-- Row 6: Employee List -->
    <div class="row">
      <div class="col-12">
        <div class="card p-3">
          <h6 class="section-title">Employee List</h6>
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Status</th>
                  <th>Total Orders</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>John Doe</td>
                  <td><span class="badge bg-success">Active</span></td>
                  <td>125 Orders</td>
                  <td>
                    <button class="btn btn-outline-success btn-sm me-1"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>Jane Smith</td>
                  <td><span class="badge bg-danger">Resigned</span></td>
                  <td>98 Orders</td>
                  <td>
                    <button class="btn btn-outline-success btn-sm me-1"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>Ahmed Khan</td>
                  <td><span class="badge bg-warning text-dark">Suspended</span></td>
                  <td>40 Orders</td>
                  <td>
                    <button class="btn btn-outline-success btn-sm me-1"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
                <tr>
                  <td>Maria Garcia</td>
                  <td><span class="badge bg-success">Active</span></td>
                  <td>190 Orders</td>
                  <td>
                    <button class="btn btn-outline-success btn-sm me-1"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Script -->
  <script>
    new ApexCharts(document.querySelector("#areaChart"), {
      chart: { type: 'area', height: 160, sparkline: { enabled: true } },
      stroke: { curve: 'smooth', width: 2 },
      colors: ['#7267EF'],
      series: [{ data: [0, 20, 10, 45, 30, 55, 20, 30, 0] }],
      tooltip: { enabled: false },
    }).render();

    new ApexCharts(document.querySelector("#barChart"), {
      chart: { type: 'bar', height: 160, sparkline: { enabled: true } },
      plotOptions: { bar: { columnWidth: '70%' } },
      colors: ['#7267EF'],
      series: [{ data: [25, 66, 41, 89, 63, 25, 44, 12, 36] }],
      tooltip: { enabled: false },
    }).render();

    new ApexCharts(document.querySelector("#lineChart"), {
      chart: { height: 300, type: 'line', background: 'transparent' },
      stroke: { width: [0, 3], curve: 'smooth' },
      colors: ['#7267EF', '#c7d9ff'],
      series: [
        { name: 'Total Sales', type: 'column', data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 40] },
        { name: 'Average', type: 'line', data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39, 51] }
      ],
      labels: ['Jan 01', 'Feb 01', 'Mar 01', 'Apr 01', 'May 01', 'Jun 01', 'Jul 01', 'Aug 01', 'Sep 01', 'Oct 01', 'Nov 01', 'Dec 01'],
      tooltip: { shared: true, intersect: false },
    }).render();

    new ApexCharts(document.querySelector("#pieChart"), {
      chart: { type: 'pie', height: 260 },
      labels: ['TWS', 'K8 Withdrawal', 'K8 Deposit', 'Atas', 'W1W Deposit', 'W1W Withdrawal'],
      series: [20, 15, 18, 12, 22, 13],
      colors: ['#7267EF', '#8e86f8', '#a69ffc', '#bfb8ff', '#d8d2ff', '#edeaff'],
      dataLabels: {
        style: { fontSize: '14px' },
        formatter: function (val) {
          return val.toFixed(1) + "%";
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        fontSize: '13px'
      }
    }).render();

    document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("toggleButton");
  const textContainer = document.getElementById("textContainer");

  if (toggleButton && textContainer) {
    toggleButton.addEventListener("click", function () {
      textContainer.style.display = "block";
    });
  }
});

    
  </script>

  <script>
$(document).ready(function() {
  $('#employee-select').select2({
    placeholder: 'Search employee name',
    minimumInputLength: 1, 
    ajax: {
      url: '<?php echo base_url("W_Order/search"); ?>', 
      dataType: 'json',
      delay: 250,
      search: yes,
      data: function (params) {
        return {
          q: params.term 
        };
      },
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
});

</script>


</body>
</html>





                        <!-- /.modal -->    
<?php $this->load->view('backend/footer'); ?>