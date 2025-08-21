<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>




<div class="page-wrapper">

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

  <!-- Tabs -->
  <ul class="nav nav-tabs profile-tab" role="tablist" id="projectTabs">
    <!-- <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#all" role="tab" onclick="selectProject('ALL')">All
        Projects</a>
    </li> -->
    <?php foreach ($projects as $project): ?>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#project<?= $project->id ?>" role="tab"
          onclick="selectProject(<?= (int) $project->id ?>)">
          <?= htmlspecialchars($project->pro_name) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>

  <!-- Add Order -->
  <div class="mt-3 mb-3">
    <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#orderModal">
      <i class="fa fa-plus"></i> Add Order
    </button>
  </div>

  <!-- KPI Cards -->
  <div class="container-fluid">
    <div class="grid-container" style="margin-top: 20px;">

      <!-- EMPLOYEES -->
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

      <!-- ORDERS -->
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

      <!-- MISTAKES -->
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
    <div id="lineChart" style="height: 300px;"></div>
  </div>


  <!-- --------------------------------------------------------- -->
<!-- <div class="col-md-12">
    <div class="card p-3 text-center shadow-sm rounded">
        <h6 class="section-title">Mistakes Rate</h6>
        <div class="highlight" id="mistakesRate">0</div>
        <p class="text-muted small">Total mistakes of the employees</p>
        <div id="mistakeAreaChart" style="height: 300px;"></div>
    </div>
</div> -->
<div class="col-md-6">
  <div class="card p-3 text-center shadow-sm rounded">
    <h6 class="section-title">Mistakes Chart</h6>
    <div id="mistakeChart" style="height: 300px;"></div>
  </div>
</div>

<script>
let mistakeChart = null;

function loadMistakeChart(projectId = "ALL") {
    fetch(`<?= base_url('Order_report/mistake_chart_data') ?>?project_id=${projectId}`)
        .then(res => res.json())
        .then(data => {
            if (!data || !data.length) {
                document.querySelector("#mistakeChart").innerHTML = "<p class='text-muted'>No mistake data available</p>";
                return;
            }

            const dailyCounts = {};
            data.forEach(d => {
                const date = new Date(d.date);
                const key = date.getFullYear() + '-' +
                            (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                            date.getDate().toString().padStart(2, '0');
                dailyCounts[key] = (dailyCounts[key] || 0) + 1;
            });

            const seriesData = Object.keys(dailyCounts)
                .sort((a, b) => new Date(a) - new Date(b))
                .map(date => [new Date(date).getTime(), dailyCounts[date]]);

            const options = {
                chart: { type: 'area', height: 300, zoom: { enabled: true } },
                series: [{ name: 'Mistakes', data: seriesData }],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: { type: 'datetime', title: { text: 'Date' } },
                yaxis: { title: { text: 'Mistakes' }, min: 0 },
                tooltip: { x: { format: 'dd MMM yyyy' } },
                colors: ['#FF0000']
            };

            document.querySelector("#mistakeChart").innerHTML = "";
            new ApexCharts(document.querySelector("#mistakeChart"), options).render();
        })
        .catch(err => console.error("Error loading mistake chart:", err));
}

// 🔄 Hook into your existing project selection
function selectProject(projectId) {
    currentProjectId = projectId;
    updateSummary(projectId);
    loadOrders(projectId);
    fetchChartData(projectId);   // existing orders chart
    loadMistakeChart(projectId); // new mistakes chart
}

// First load
document.addEventListener("DOMContentLoaded", () => {
    loadMistakeChart("ALL");
});


</script>




<!-- --------------------------------------------------------------------- -->


  <!-- Orders table -->
  <div id="orderTable" class="mt-3"></div>
</div>

<!-- Add Order Modal -->
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

            <!-- Employee -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Name</label>
              <select id="employee_code" name="employee_code" class="w-100" required>
                <option></option> <!-- real empty option for placeholder -->
                <?php foreach ($employee as $e): ?>
                  <option value="<?= (int) $e->id ?>" data-code="<?= htmlspecialchars($e->em_code) ?>"
                    data-search="<?= htmlspecialchars($e->first_name . ' ' . $e->last_name . ' ' . $e->em_code) ?>">
                    <?= htmlspecialchars($e->first_name . ' ' . $e->last_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Employee Code -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Code</label>
              <input type="text" id="employee_code_display" class="form-control bg-light" placeholder="Select Employee"
                readonly>
            </div>

            <!-- Project -->
            <div class="col-md-6" id="projectSelectWrapper" style="display:none;">
              <label class="form-label fw-bold">Project</label>
              <select class="form-control" id="modal_project_select">
                <option value="">Select Project</option>
                <?php foreach ($projects as $p): ?>
                  <option value="<?= (int) $p->id ?>"><?= htmlspecialchars($p->pro_name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Employee Position -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Position</label>
              <input type="text" name="pc_position" id="pc_position" class="form-control" placeholder="AAA203C"
                required>
            </div>

            <!-- Order Date -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Order Date</label>
              <input type="date" name="order_date" id="order_date" class="form-control" required>
            </div>

            <!-- Shift -->
            <div class="col-md-6">
              <label class="form-label fw-bold">Shift</label>
              <select class="form-control" name="shift" id="shift" required>
                <option value="">Select Shift</option>
                <option value="Morning">Morning</option>
                <option value="Noon">Noon</option>
                <option value="Night">Night</option>
              </select>
            </div>

            <!-- Order Count -->
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
          chart: { height: 450, type: 'line' },
          stroke: { width: [0, 4], curve: 'smooth' },
          colors: ['#7267EF', '#c7d9ff'],
          stroke: {
            width: [0, 3],
            curve: 'smooth'
          },
          series: [
            { name: 'Total Orders', type: 'column', data: data.total_orders.map(d => d.y) },
            { name: 'Average Orders', type: 'line', data: data.avg_orders.map(d => d.y) }
          ],
          xaxis: { categories: data.total_orders.map(d => d.x) },
          yaxis: [
            { title: { text: 'Total Orders' } },
            // { opposite: true, title: { text: 'Average Orders' } }
          ],
          tooltip: { shared: true, intersect: false }
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

  // Project Selection
  function selectProject(projectId) {
    currentProjectId = projectId;
    updateSummary(projectId);
    loadOrders(projectId);
    fetchChartData(projectId);
  }

  // Summary Counts
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

  // Load Orders Table
  function loadOrders(projectId) {
    const params = new URLSearchParams({ project_id: projectId, shift: 'ALL' });
    fetch(`<?= base_url("Order_report/get_orders") ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        let html = `<table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Total Orders</th>
                        <th>Position</th>
                    </tr>
                </thead>
                <tbody>`;
        data.orders.forEach(o => {
          html += `<tr>
                    <td>${o.pro_name ?? ''}</td>
                    <td>${(o.first_name ?? '')} ${(o.last_name ?? '')} (${o.em_code ?? ''})</td>
                    <td>${o.order_date ?? ''}</td>
                    <td>${(o.shift ?? '').charAt(0).toUpperCase() + (o.shift ?? '').slice(1)}</td>
                    <td>${o.order_count ?? 0}</td>
                    <td>${o.pc_position ?? ''}</td>
                </tr>`;
        });
        html += '</tbody></table>';
        document.getElementById('orderTable').innerHTML = html;
      });
  }

  // Initial Load
  document.addEventListener('DOMContentLoaded', () => {
    selectProject('ALL');
  });
</script>


<!-- typing features -->
<script>
  function initEmployeeSelect() {
    var $el = $('#employee_code');

    // If already initialized, destroy first (prevents weird behavior)
    if ($el.hasClass('select2-hidden-accessible')) {
      $el.select2('destroy');
    }

    $el.select2({
      dropdownParent: $('#orderModal'),        // important in modals
      placeholder: 'Select Employee',
      allowClear: true,
      width: '100%',
      minimumResultsForSearch: 0,              // always show search

      // Match by name (text), data-code, or data-search
      matcher: function (params, data) {
        if (!params.term || !params.term.trim()) return data;
        if (typeof data.text === 'undefined') return null;

        var term = params.term.toLowerCase();
        var text = (data.text || '').toLowerCase();
        var code = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-code') || '').toLowerCase() : '';
        var extra = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-search') || '').toLowerCase() : '';

        return (text.indexOf(term) > -1 || code.indexOf(term) > -1 || extra.indexOf(term) > -1) ? data : null;
      },

      // Show code next to the name
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

    // Keep your code display field in sync
    $el.on('change', function () {
      var code = $(this).find(':selected').data('code') || '';
      $('#employee_code_display').val(code);
    });
  }

  // Initialize when modal is fully shown (element is in DOM)
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
          loadOrders(currentProjectId); // refresh table
          updateSummary(currentProjectId); // refresh counts
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
    let today = new Date().toISOString().split('T')[0]; // yyyy-mm-dd
    document.getElementById('order_date').value = today;
  });
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





<?php $this->load->view('backend/footer'); ?>