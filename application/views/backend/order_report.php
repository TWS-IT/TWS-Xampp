<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Optional for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>







<div class="page-wrapper">

  <div class="profile-tab sticky-top" role="tablist" style="z-index: 1020;">
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h5 class="text-themecolor"><i class="mdi mdi-chart-line"></i> Order Report</h5>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Order Report</li>
        </ol>
      </div>
    </div>


    <ul class="nav nav-tabs profile-tab" role="tablist" id="projectTabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#all" role="tab" onclick="selectProject('ALL')">All
          Projects</a>
      </li>
      <?php foreach ($projects as $project): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#project<?= $project->id ?>" role="tab"
            onclick="selectProject(<?= (int) $project->id ?>)">
            <?= htmlspecialchars($project->pro_name) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="mt-3 mb-3">
      <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#orderModal">
        <i class="fa fa-plus"></i> Add Order
      </button>
    </div>
  </div>

  <style>
    #projectTabs {
      position: sticky;
      top: 0;
      z-index: 1050;
      background: linear-gradient(135deg, #eef5f9, #eef5f9);
      padding: 0.75rem 1rem;

      display: flex;
      justify-content: center;
      gap: 0.5rem;

      border-bottom: 1px solid #e5e7eb;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      backdrop-filter: blur(8px);
    }

    /* Each tab */
    #projectTabs .nav-link {
      color: #374151;
      font-weight: 500;
      padding: 0.5rem 1.25rem;
      border-radius: 999px;
      transition: all 0.25s ease;
      background: transparent;
      border: none;
    }

    /* Hover effect */
    #projectTabs .nav-link:hover {
      background: rgba(37, 99, 235, 0.08);
      color: #2563eb;
    }

    /* Active tab */
    #projectTabs .nav-link.active {
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      color: #eef5f9;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(37, 99, 235, 0.4);
    }

    /* Responsive: smooth horizontal scroll */
    @media (max-width: 768px) {
      #projectTabs {
        overflow-x: auto;
        white-space: nowrap;
        justify-content: flex-start;
        /* on small screens, align left */
        scrollbar-width: none;
      }

      #projectTabs::-webkit-scrollbar {
        display: none;
      }
    }

    /* Page Wrapper (main content area) */
    .page-wrapper {
      min-height: 100vh;
      /* full height */
      padding: 20px 30px;
      /* spacing inside */
      background: linear-gradient(135deg, #eef5f9, #eef5f9);
      /* subtle gradient bg */
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* Card container */
    .card {
      border: none;
      border-radius: 16px;
      background: #eef5f9;
      # box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      /* soft shadow */
      overflow: hidden;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Card hover effect */
    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    /* Card header or title */
    .card .card-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #374151;
      margin-bottom: 1rem;
    }

    /* Card body (main content inside cards) */
    .card-body {
      padding: 1.5rem;
      font-size: 0.95rem;
      color: #4b5563;
      line-height: 1.6;
    }

    /* Utility for centered content inside cards */
    .card-body.text-center {
      text-align: center;
      justify-content: center;
      align-items: center;
    }

    /* Responsive padding for smaller screens */
    @media (max-width: 768px) {
      .page-wrapper {
        padding: 15px;
      }

      .card-body {
        padding: 1rem;
      }
    }
  </style>




  <div class="container-fluid">
    <div class="grid-container" style="margin-top: 20px;">


      <div class="card" style="--grad: #FFC107, #FF9800;">
        <center>
          <div class="title">
            <i class="fas fa-users" style="color: #FF9800;"></i>
            <span id="employeesTitle">All Projects Employees</span>
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="employeesCount">0</h2>
          </center>
        </div>
      </div>


      <div class="card" style="--grad: #2196F3, #03A9F4;">
        <center>
          <div class="title">
            <i class="fa fa-list-alt" style="color: #03A9F4;"></i> Total Orders
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="ordersTotal">0</h2>
          </center>
        </div>
      </div>


      <div class="card" style="--grad: #F44336, #E91E63;">
        <center>
          <div class="title">
            <i class="fa fa-exclamation-triangle" style="color: #E91E63;"></i> Mistakes
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="mistakesCount">0</h2>
          </center>
        </div>
      </div>

    </div>
  </div>


  <div class="row">


    <div class="col-md-6">
      <div class="card p-3 text-center">
        <h6 class="section-title" id="reportLabel">Total Orders</h6>
        <span id="totalOrderCount"><?= isset($sum_order_count) ? $sum_order_count : 0 ?></span>
        <div id="lineChart" style="height: 300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3 text-center">
        <h6 class="section-title">Mistakes Rate</h6>
        <div class="highlight" id="mistakesRate">0%</div>
        <div id="mistakeChart" style="height: 300px;"></div>
      </div>
    </div>

  </div>


  <!-- Orders table -->
  <div class="col-md-12">
    <div class="card p-3 text-center">
      <div id="orderTable" class="mt-3"></div>
    </div>
  </div>
</div>

<style>
  #orderTable table {
    border-collapse: collapse;
    width: 100%;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  }

  #orderTable table thead th {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: white;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 10;
    padding: 12px;
    text-align: left;
  }

  #orderTable table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
  }

  #orderTable table tbody tr:hover {
    background-color: #f0f4ff;
    cursor: pointer;
  }

  .dt-button {
    border-radius: 6px;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #4f46e5;
    color: white !important;
    font-weight: 500;
  }

  .custom-dt-btn {
    background: linear-gradient(135deg, #4f46e5, #3b82f6) !important;
    color: #fff !important;
    font-weight: 600;
    border: none !important;
    border-radius: 3px !important;
    padding: 6px 14px !important;
    margin-right: 5px !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
  }

  .custom-dt-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #4f46e5) !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
  }
</style>



<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="orderModalLabel"><i class="fa fa-braille"></i> Add Order</h4>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form method="post" action="<?= base_url('Order_report/save_order') ?>" id="orderForm">
        <input type="hidden" name="project_id" id="modal_project_id">

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Name</label>
              <select id="employee_code" name="employee_code" class="w-100" required>
                <option></option>
                <?php foreach ($employee as $e): ?>
                  <option value="<?= (int) $e->id ?>" data-code="<?= htmlspecialchars($e->em_code) ?>"
                    data-search="<?= htmlspecialchars($e->first_name . ' ' . $e->last_name . ' ' . $e->em_code) ?>">
                    <?= htmlspecialchars($e->first_name . ' ' . $e->last_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Code</label>
              <input type="text" id="employee_code_display" class="form-control bg-light" placeholder="Select Employee"
                readonly>
            </div>

            <div class="col-md-6" id="projectSelectWrapper" style="display:none;">
              <label class="form-label fw-bold">Project</label>
              <select class="form-control" id="modal_project_select">
                <option value="">Select Project</option>
                <?php foreach ($projects as $p): ?>
                  <option value="<?= (int) $p->id ?>"><?= htmlspecialchars($p->pro_name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Position</label>
              <input type="text" name="pc_position" id="pc_position" class="form-control" placeholder="AAA203C"
                required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Order Date</label>
              <input type="date" name="order_date" id="order_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Shift</label>
              <select class="form-control" name="shift" id="shift" required>
                <option value="">Select Shift</option>
                <option value="Morning">Morning</option>
                <option value="Noon">Noon</option>
                <option value="Night">Night</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Order Count</label>
              <input type="number" name="order_count" id="order_count" class="form-control" min="0"
                placeholder="Order Count" required>
            </div>

          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<style>
  .grid-container {
    width: min(90%, 1200px);
    margin-inline: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }

  .card {
    --grad: red, blue;
    padding: 1rem;
    background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
    border-radius: 1rem;
    display: grid;
    grid-template-areas:
      "title icon"
      "content content"
      "bar bar";
    grid-template-columns: 1fr auto;
    gap: 0.5rem;
    color: #444;
    box-shadow: inset -2px 2px #fff, -20px 20px 40px rgba(0, 0, 0, .25);
    font-size: 0.9rem;
  }

  .card .title {
    grid-area: title;
    font-size: 1.4rem;
    font-weight: 600;
    text-transform: uppercase;
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
</style>


<script>
  let chart = null;
  let currentProjectId = 'ALL';

  function fetchChartData(projectId = 'ALL') {
    currentProjectId = projectId;

    let startDate = document.getElementById('date_from')?.value || '';
    let endDate = document.getElementById('date_to')?.value || '';
    let shiftid = document.getElementById('shiftid')?.value || 'ALL';

    let params = new URLSearchParams({
      project_id: projectId,
      date_from: startDate,
      date_to: endDate,
      shiftid: shiftid
    });

    fetch(`<?= base_url('order_report/get_all_orders_barline_chart') ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data || !data.total_orders) return;

        data.total_orders.sort((a, b) => new Date(a.x) - new Date(b.x));
        data.avg_orders.sort((a, b) => new Date(a.x) - new Date(b.x));

        const options = {
          chart: {
            height: 370,
            type: 'line',
            zoom: { enabled: true, type: 'x', autoScaleYaxis: true },
            toolbar: { show: true, tools: { pan: true, reset: true } }
          },
          stroke: { width: [0, 3], curve: 'smooth' },
          colors: ['#7267EF', '#c7d9ff'],
          series: [
            { name: 'Total Orders', type: 'column', data: data.total_orders.map(d => [new Date(d.x).getTime(), d.y]) },
            { name: 'Average Orders', type: 'line', data: data.avg_orders.map(d => [new Date(d.x).getTime(), d.y]) }
          ],
          xaxis: { type: 'datetime' },
          tooltip: { shared: true, intersect: false, x: { format: 'yyyy-MM-dd HH:mm' } }
        };


        if (chart) {
          chart.updateOptions(options);
        } else {
          chart = new ApexCharts(document.querySelector("#lineChart"), options);
          chart.render();
        }

        document.getElementById('totalOrderCount').textContent =
          data.total_orders.reduce((sum, d) => sum + d.y, 0);
      })
      .catch(err => console.error("Error fetching chart data:", err));
  }

  function selectProject(projectId) {
    currentProjectId = projectId;
    updateSummary(projectId);
    loadOrders(projectId);
    fetchChartData(projectId);
    fetchMistakeChart(projectId);
  }

  function updateSummary(projectId) {
    fetch(`<?= base_url("Order_report/get_summary_counts") ?>?project_id=${projectId}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('employeesTitle').textContent =
          (projectId === 'ALL') ? 'All Projects Employees' : `${data.label} Employees`;
        document.getElementById('employeesCount').textContent = data.employees_count ?? 0;
        document.getElementById('ordersTotal').textContent = data.orders_total ?? 0;
        document.getElementById('mistakesCount').textContent = data.mistakes_count ?? 0;
      });
  }

  function loadOrders(projectId) {
    const params = new URLSearchParams({ project_id: projectId, shift: 'ALL' });

    fetch(`<?= base_url("Order_report/get_orders") ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        let html = `<table id="ordersTable" class="display nowrap table table-bordered table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <th>Project</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Total Orders</th>
                        <th>Position</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>`;

        data.orders.forEach(o => {
          html += `<tr>
                  <td>${o.pro_name ?? ''}</td>
                  <td>${o.first_name ?? ''} ${o.last_name ?? ''} (${o.em_code ?? ''})</td>
                  <td>${o.order_date ?? ''}</td>
                  <td>${(o.shift ?? '').charAt(0).toUpperCase() + (o.shift ?? '').slice(1)}</td>
                  <td>${o.order_count ?? 0}</td>
                  <td>${o.pc_position ?? ''}</td>
                  <td>
                        <button class="btn btn-sm btn-success me-1" onclick="editOrder(${o.order_id})">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteOrder(${o.order_id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                 </tr>`;
        });

        html += `</tbody></table>`;
        document.getElementById('orderTable').innerHTML = html;

        $('#ordersTable').DataTable({
          dom: 'Bfrtip',
          buttons: [
            { extend: 'copy', text: 'Copy', className: 'custom-dt-btn' },
            { extend: 'csv', text: 'CSV', className: 'custom-dt-btn' },
            { extend: 'excel', text: 'Excel', className: 'custom-dt-btn' },
            { extend: 'pdf', text: 'PDF', className: 'custom-dt-btn' },
            { extend: 'print', text: 'Print', className: 'custom-dt-btn' }
          ],
          responsive: true,
          pageLength: 10,
          scrollX: true,
          fixedHeader: true,
          destroy: true
        });


      })
      .catch(err => console.error("Error loading orders:", err));
  }


  document.addEventListener('DOMContentLoaded', () => {
    selectProject('ALL');
  });
</script>

<script>
  $(document).ready(function () {
    function initOrderTable() {
      $('#orderTable table').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'print'],
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']],
        destroy: true
      });
    }

    initOrderTable();
  });
</script>

<script>
  function initEmployeeSelect() {
    var $el = $('#employee_code');

    if ($el.hasClass('select2-hidden-accessible')) {
      $el.select2('destroy');
    }

    $el.select2({
      dropdownParent: $('#orderModal'),
      placeholder: 'Select Employee',
      allowClear: true,
      width: '100%',
      minimumResultsForSearch: 0,

      matcher: function (params, data) {
        if (!params.term || !params.term.trim()) return data;
        if (typeof data.text === 'undefined') return null;

        var term = params.term.toLowerCase();
        var text = (data.text || '').toLowerCase();
        var code = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-code') || '').toLowerCase() : '';
        var extra = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-search') || '').toLowerCase() : '';

        return (text.indexOf(term) > -1 || code.indexOf(term) > -1 || extra.indexOf(term) > -1) ? data : null;
      },

      templateResult: function (data) {
        if (!data.id) return data.text;
        var code = data.element ? data.element.getAttribute('data-code') : '';
        var $row = $('<span></span>').text(data.text);
        if (code) $row.append($('<small class="ml-1"></small>').text(' (' + code + ')'));
        return $row;
      },
      templateSelection: function (data) {
        if (!data.id) return data.text;
        var code = data.element ? data.element.getAttribute('data-code') : '';
        return code ? data.text + ' (' + code + ')' : data.text;
      }
    });

    $el.on('change', function () {
      var code = $(this).find(':selected').data('code') || '';
      $('#employee_code_display').val(code);
    });
  }

  $('#orderModal').on('shown.bs.modal', initEmployeeSelect);

</script>

<!-- save -->
<script>
  function saveOrderAJAX(form) {
    const formData = new FormData(form);

    fetch(form.action, {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("Order saved successfully!");
          $('#orderModal').modal('hide');
          loadOrders(currentProjectId);
          updateSummary(currentProjectId);
        } else {
          alert(data.message || "Failed to save order.");
        }
      })
      .catch(err => {
        console.error("Save failed:", err);
        alert("An error occurred while saving the order.");
      });
  }

</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    let today = new Date().toISOString().split('T')[0];
    document.getElementById('order_date').value = today;
  });
</script>

<!-- Mistake chart -->
<script>
  let mistakeChart = null;

  function fetchMistakeChart(projectId = 'ALL') {
    let startDate = document.getElementById('date_from')?.value || '';
    let endDate = document.getElementById('date_to')?.value || '';

    let params = new URLSearchParams({
      project_id: projectId,
      date_from: startDate,
      date_to: endDate
    });

    fetch(`<?= base_url('Order_report/get_mistakes_chart') ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data) return;

        // Sort by date
        data.sort((a, b) => new Date(a.x) - new Date(b.x));

        // ✅ Calculate totals
        let totalMistakes = data.reduce((sum, d) => sum + (d.y || 0), 0);
        let totalOrders = parseInt(document.getElementById('totalOrderCount')?.textContent || 0);
        let percentage = (totalOrders > 0) ? ((totalMistakes / totalOrders) * 100).toFixed(2) : 0;

        // ✅ Update percentage in UI
        document.getElementById('mistakesRate').textContent = percentage + "%";

        // Chart config
        const options = {
          chart: {
            height: 310,
            type: 'area',
            toolbar: { show: true, tools: { zoom: true, pan: true, reset: true } },
            zoom: { enabled: true, type: 'x', autoScaleYaxis: true }
          },
          dataLabels: { enabled: false },
          stroke: { curve: 'smooth' },
          series: [{
            name: 'Mistakes',
            data: data.map(d => [new Date(d.x).getTime(), d.y])
          }],
          xaxis: { type: 'datetime', title: { text: 'Date & Time' } },
          yaxis: { title: { text: 'Mistake Count' } },
          colors: ['#FF4560'],
          tooltip: { x: { format: 'yyyy-MM-dd HH:mm' }, shared: true }
        };

        if (mistakeChart) {
          mistakeChart.updateOptions(options);
        } else {
          mistakeChart = new ApexCharts(document.querySelector("#mistakeChart"), options);
          mistakeChart.render();
        }
      })
      .catch(err => console.error("Error fetching mistake chart data:", err));
  }

</script>

<script>
  function editOrder(id) {
    // Fetch existing data first
    fetch(`<?= base_url('Order_report/get_orders') ?>?id=${id}`)
      .then(res => res.json())
      .then(order => {
        // Fill modal form with order details
        document.getElementById('orderId').value = order.id;
        document.getElementById('project_id').value = order.project_id;
        document.getElementById('employee_code').value = order.employee_code;
        document.getElementById('pc_position').value = order.pc_position;
        document.getElementById('order_date').value = order.order_date;
        document.getElementById('shift').value = order.shift;
        document.getElementById('order_count').value = order.order_count;

        // Show modal
        $('#orderModal').modal('show');
      });
  }

  function saveUpdatedOrder() {
    let formData = new FormData(document.getElementById("orderForm"));

    fetch("<?= base_url('Order_report/update_order') ?>", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.status === "success") {
          location.reload();
        }
      });
  }

  function deleteOrder(id) {
    if (!confirm("Are you sure you want to delete this order?")) return;

    fetch(`<?= base_url('Order_report/delete_order') ?>/${id}`, {
      method: "POST"
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.status === "success") {
          location.reload();
        }
      });
  }

</script>

<style>
  .select2-container--default .select2-selection--single {
    height: 34px;
    border: 1px solid #aaa;
    border-radius: 6px;
    background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    font-size: 13px;
    padding-left: 6px;
    display: flex;
    align-items: center;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 3px;
    right: 8px;
    border-radius: 0 6px 6px 0;
  }

  .select2-container--default .select2-selection--single:hover {
    background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
    transform: translateY(-1px);
  }

  .select2-container--default.select2-container--open .select2-selection--single {
    border-color: #007bff;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
  }

  .select2-dropdown {
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-size: 13px;
  }

  .select2-results__option {
    padding: 5px 10px;
    font-size: 13px;
  }

  .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: #fff !important;
  }

  .form-control,
  .select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #aaa;
    border-radius: 6px;
    background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    font-size: 14px;
    padding: 6px 10px;
    transition: all 0.2s ease;
  }

  .form-control:hover,
  .select2-container--default .select2-selection--single:hover {
    background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
    transform: translateY(-1px);
  }

  .form-control:focus,
  .select2-container--default.select2-container--open .select2-selection--single {
    border-color: #007bff;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
    outline: none;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 6px;
    border-radius: 6px;
  }

  .select2-dropdown {
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-size: 14px;
  }

  .select2-results__option {
    padding: 6px 10px;
  }

  .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: #fff !important;
  }
</style>




<style>
  .grid-container {
    width: min(90%, 1200px);
    margin-inline: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }

  .card {
    --grad: red, blue;
    padding: 1rem;

    background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
    border-radius: 1rem;

    display: grid;
    grid-template-areas:
      "title icon"
      "content content"
      "bar bar";
    grid-template-columns: 1fr auto;
    gap: 0.5rem;

    color: #444;
    box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);
    font-size: 0.9rem;

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
    appearance: none;

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
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
  }

  .custom-dropdown:hover {
    border-color: #007bff;
    cursor: pointer;
  }
</style>

<style>

</style>




<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
    color: #ef6789ff;
    background-color: transparent;

    padding: 8px 12px;
    border-radius: 8px;

    display: inline-block;

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

<style>
  table.dataTable {
    border-collapse: collapse !important;
  }

  table.dataTable th,
  table.dataTable td {
    border: 1px solid #ccc !important;
    padding: 8px;
  }

  .highlight {
    font-size: 1.5rem;
    font-weight: bold;
  }

  .section-title {
    font-size: 1rem;
    font-weight: 500;
  }

  .chart-box {
    margin-top: 10px;
  }
</style>

<style>
  .btn-sm {
    padding: 4px 10px;
    font-size: 0.85rem;
    border-radius: 6px;
  }

  .btn-success {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff;
    border: none;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #3b82f6, #4f46e5);
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    border: none;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #ef4444);
  }
</style>

<?php $this->load->view('backend/footer'); ?>