<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<<<<<<< HEAD
<!-- CSS & JS Dependencies -->
=======
<!-- CSS & JS includes (some repeated jquery includes can be optimized) -->
>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<<<<<<< HEAD

<div class="page-wrapper modern-dashboard">
    <div class="container-fluid">

        <!-- PROFILE SECTION -->

        <div class="profile-card">
            <div class="profile-image">
                <img src="<?= htmlspecialchars($profile_img ?? base_url('assets/images/users/user.png')) ?>"
                    alt="<?= htmlspecialchars(($first_name ?? 'N/A') . ' ' . ($last_name ?? '')) ?>"
                    onerror="this.src='<?= base_url('assets/images/users/user.png'); ?>'">
            </div>
            <div class="profile-details">
                <h2 class="profile-name"><?= htmlspecialchars(($first_name ?? 'N/A') . ' ' . ($last_name ?? '')) ?></h2>
                <p class="profile-project">Project: <?= htmlspecialchars($pro_name ?? 'N/A') ?></p>
                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-number"><?= $total_orders ?? 0 ?></span>
                        <small class="stat-label">Total Orders</small>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?= $total_mistakes ?? 0 ?></span>
                        <small class="stat-label">Total Mistakes</small>
                    </div>

                    <div class="stat">
                        <span class="stat-number"><?= $total_ir ?? 0 ?></span>
                        <small class="stat-label">Total IR</small>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?= $efficiency ?? 0 ?>%</span>
                        <small class="stat-label">Efficiency</small>
                    </div>


                </div>
            </div>
        </div>

        <br>

        <!-- CHART SECTION -->
        <div class="chart-section card">
            <div class="chart-header">
                <div class="chart-buttons">
                    <button id="one_month" class="btn">1M</button>
                    <button id="six_months" class="btn">6M</button>
                    <button id="one_year" class="btn">1Y</button>
                    <button id="ytd" class="btn">YTD</button>
                    <button id="all" class="btn active">All</button>
                </div>
            </div>
            <div id="chart-timeline" style="height: 350px;"></div>
        </div>

        <!-- SHIFT ORDER TABLE -->
        <div class="table-section card">
            <div class="table-header">
                <div class="shift-filters">
                    <button class="shift-filter active" data-shift="">All</button>
                    <button class="shift-filter" data-shift="morning">Morning</button>
                    <button class="shift-filter" data-shift="noon">Noon</button>
                    <button class="shift-filter" data-shift="night">Night</button>
                </div>
                <div class="shift-total">
                    Shift Total Orders: <span id="shift-total-orders">0</span>
                </div>
            </div>
            <div class="table-responsive">
                <table id="shift-order-table" class="table table-striped table-hover modern-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>PC Position</th>
                            <th>Order Count</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<style>
    /* ===== GENERAL STYLES ===== */
    body {
        font-family: 'Poppins', sans-serif;
        background: #f6f8fa;
        margin: 0;
        color: #333;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        padding: 20px;
    }

    /* ===== PROFILE CARD ===== */
    .profile-section {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 20px;
        border-radius: 15px;
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        /* soft light gradient */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        color: #333;
        transition: transform 0.2s ease;
    }

    .profile-card:hover {
        transform: translateY(-3px);
    }

    .profile-image img {
        border-radius: 50%;
        width: 130px;
        height: 130px;
        object-fit: cover;
        border: 3px solid #80deea;
    }

    /* ===== PROFILE DETAILS ===== */
    .profile-details h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .profile-project {
        color: #666;
        margin-bottom: 12px;
    }

    .profile-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-weight: 700;
        font-size: 18px;
        color: #00796b;
        /* soft teal */
    }

    .stat-label {
        font-size: 12px;
        color: #555;
    }

    /* ===== BUTTONS ===== */
    .btn {
        background: #e0f7fa;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s, transform 0.2s;
    }

    .btn.active {
        background: #26a69a;
        color: #fff;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* ===== TABLE ===== */
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    table.modern-table th,
    table.modern-table td {
        text-align: center;
        padding: 12px;
    }

    table.modern-table th {
        background: #f0f7f7;
    }

    table.modern-table tbody tr:hover {
        background: #d0f0f0;
    }

    /* ===== SHIFT FILTERS ===== */
    .shift-filters {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin: 20px 0;
    }

    .shift-filter {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s, opacity 0.2s, background 0.2s;
    }

    .shift-filter[data-shift="morning"] {
        background-color: #80deea;
        color: #004d40;
    }

    .shift-filter[data-shift="noon"] {
        background-color: #ffe082;
        color: #bf360c;
    }

    .shift-filter[data-shift="night"] {
        background-color: #b0bec5;
        color: #263238;
    }

    .shift-filter.active {
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .shift-filter:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
</style>

<script>
    // -----------------------
    // ApexCharts Timeline
    // -----------------------
    const chartOptions = {
        series: [{ name: "Orders", data: [] }],
        chart: { height: 350, type: 'area', zoom: { enabled: true, autoScaleYaxis: true } },
        xaxis: { type: 'datetime', labels: { datetimeUTC: false } },
        annotations: {
            yaxis: [
                { y: 25, borderColor: '#ff4d4f', label: { text: 'Low performance', style: { color: '#fff', background: '#ff4d4f' } } },
                { y: 200, borderColor: '#52c41a', label: { text: 'High performance', style: { color: '#fff', background: '#52c41a' } } }
            ]
        },
        tooltip: { x: { format: 'dd MMM yyyy' }, shared: true, intersect: false }
    };

    const chart = new ApexCharts(document.querySelector("#chart-timeline"), chartOptions);
    chart.render();

    const setZoomRange = (start, end, btn) => {
        document.querySelectorAll('.chart-section .btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        chart.zoomX(start, end);
    };

    const ranges = {
        one_month: () => { const end = Date.now(); const start = new Date(); start.setMonth(start.getMonth() - 1); return [start.getTime(), end]; },
        six_months: () => { const end = Date.now(); const start = new Date(); start.setMonth(start.getMonth() - 6); return [start.getTime(), end]; },
        one_year: () => { const end = Date.now(); const start = new Date(); start.setFullYear(start.getFullYear() - 1); return [start.getTime(), end]; },
        ytd: () => { const today = new Date(); const start = new Date(today.getFullYear(), 0, 1); return [start.getTime(), today.getTime()]; },
        all: () => { const data = chart.w.globals.initialSeries[0].data; return data.length ? [data[0].x, data[data.length - 1].x] : [0, 0]; }
    };

    Object.keys(ranges).forEach(id => {
        document.querySelector(`#${id}`).addEventListener('click', e => setZoomRange(...ranges[id](), e.target));
    });

    fetch("<?= base_url('Emp_Perfomance/json_chart_data/' . $em_code) ?>")
        .then(res => res.json())
        .then(data => {
            if (!data.length) return;
            const maxOrder = Math.max(...data.map(d => d.y));
            const paddedMax = Math.ceil((maxOrder + 20) / 25) * 25;
            chart.updateOptions({ yaxis: { min: 0, max: paddedMax, tickAmount: paddedMax / 25, labels: { formatter: val => Math.round(val) }, title: { text: 'Order Count' } } });
            data.forEach(item => { const d = new Date(item.x); d.setHours(d.getHours() + 5.5); item.x = d.getTime(); });
            chart.updateSeries([{ name: "Orders", data }]);
        });

    // -----------------------
    // SHIFT ORDER TABLE
    // -----------------------
    const em_code = "<?= $em_code ?>";
    const loadShiftOrders = (shift = '') => {
        fetch(`<?= base_url('Emp_Perfomance/get_shift_order_data/') ?>${em_code}/${shift}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#shift-order-table tbody');
                tbody.innerHTML = '';
                let total = 0;
                if (!data.length) {
                    tbody.innerHTML = '<tr><td colspan="4">No data</td></tr>';
                    document.getElementById('shift-total-orders').textContent = '0';
                    return;
                }
                data.forEach(d => {
                    total += parseInt(d.order_count);
                    tbody.innerHTML += `<tr>
                        <td>${d.order_date}</td>
                        <td>${d.shift}</td>
                        <td>${d.pc_position}</td>
                        <td>${d.order_count}</td>
                    </tr>`;
                });
                document.getElementById('shift-total-orders').textContent = total;
            });
    };

    document.querySelectorAll('.shift-filter').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.shift-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadShiftOrders(this.dataset.shift);
        });
    });

    loadShiftOrders(); // initial load
</script>

=======
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1/dist/chartjs-plugin-zoom.min.js"></script>


<div class="page-wrapper">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <?php
                                // $profile_img = !empty($em_image) ? $em_image : base_url('assets/images/users/user.png');
                                $first_name = $first_name ?? 'N/A';
                                $last_name = $last_name ?? '';
                                $project = $project ?? 'N/A';
                                $total_orders = $total_orders ?? 0;
                                $mistakes = $mistakes ?? 0;
                                $efficiency = $efficiency ?? 0;
                                ?>
                                <img src="<?= htmlspecialchars($profile_img) ?>"
                                    alt="<?= htmlspecialchars($first_name . ' ' . $last_name) ?>" width="250"
                                    height="250"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/images/users/'); ?>';">

                                <h4 class="card-title mt-3"><?= htmlspecialchars($first_name . ' ' . $last_name) ?></h4>
                                <p>Project: <?= htmlspecialchars($project) ?></p>
                                <p>Total Orders: <?= $total_orders ?></p>
                                <p>Mistakes: <?= $mistakes ?></p>
                                <p>Efficiency: <?= $efficiency ?>%</p>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="chart-container">
                                    <div class="text-center mb-3">
                                        <button id="one_month" class="btn btn-sm btn-primary">1M</button>
                                        <button id="six_months" class="btn btn-sm btn-secondary">6M</button>
                                        <button id="one_year" class="btn btn-sm btn-success">1Y</button>
                                        <button id="ytd" class="btn btn-sm btn-warning">YTD</button>
                                        <button id="all" class="btn btn-sm btn-dark">All</button>
                                    </div>

                                    <div id="chart-timeline" style="height: 350px;"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">


                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="col text-end">
                                    <button class="btn btn-sm btn-outline-primary shift-filter active"
                                        data-shift="">All</button>
                                    <button class="btn btn-sm btn-outline-info shift-filter"
                                        data-shift="morning">Morning</button>
                                    <button class="btn btn-sm btn-outline-warning shift-filter"
                                        data-shift="noon">Noon</button>
                                    <button class="btn btn-sm btn-outline-dark shift-filter"
                                        data-shift="night">Night</button>
                                </div>


                                <div class="text-end mb-2">
                                    <span class="fw-bold">Shift Total Orders:</span>
                                    <span id="shift-total-orders" class="text-blue">0</span>
                                </div>
                            </div>

                            <div class="table-wrapper">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                        <table class="table table-bordered text-center" id="shift-order-table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Shift</th>
                                                    <th>PC Position</th>
                                                    <th>Order Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Order data rows will be appended here by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>


<script>
    var options = {
        series: [{
            name: "Orders",
            data: []
        }],
        chart: {
            height: 350,
            type: 'area',
            zoom: {
                enabled: true,
                autoScaleYaxis: true
            }
        },
        xaxis: {
            type: 'datetime', 
            labels: {
                datetimeUTC: false,  
                datetimeFormatter: {
                    year: 'yyyy',
                    month: 'MMM \'yy',
                    day: 'dd MMM',
                    title: "Date"
                }
            }

        },
        annotations: {
              yaxis: [
        {
            y: 25,  
            borderColor: '#ff0000',
            label: {
                borderColor: '#999',
                style: {
                    color: '#fff',
                    background: '#ff0000'
                },
                text: 'Low performance'
            }
        },
        {
            y: 200, 
            borderColor: '#00ff00',
            label: {
                borderColor: '#999',
                style: {
                    color: '#fff',
                    background: '#00ff00'
                },
                text: 'High performance'
            }
        }
    ]

        },
        

        tooltip: {
            x: {
                format: 'dd MMM yyyy'
            },
            shared: true,
            intersect: false
        }

    };





    var chart = new ApexCharts(document.querySelector("#chart-timeline"), options);
    chart.render();
    var resetCssClasses = function (activeEl) {
        var els = document.querySelectorAll('button')
        Array.prototype.forEach.call(els, function (el) {
            el.classList.remove('active')
        })

        activeEl.target.classList.add('active')
    }
    function resetCssClasses(activeEl) {
        document.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
        activeEl.target.classList.add('active');
    }

    // Zoom handlers
    document.querySelector('#one_month').addEventListener('click', function (e) {
        resetCssClasses(e);
        const end = new Date().getTime();
        const start = new Date();
        start.setMonth(start.getMonth() - 1);
        chart.zoomX(start.getTime(), end);
    });

    document.querySelector('#six_months').addEventListener('click', function (e) {
        resetCssClasses(e);
        const end = new Date().getTime();
        const start = new Date();
        start.setMonth(start.getMonth() - 6);
        chart.zoomX(start.getTime(), end);
    });

    document.querySelector('#one_year').addEventListener('click', function (e) {
        resetCssClasses(e);
        const end = new Date().getTime();
        const start = new Date();
        start.setFullYear(start.getFullYear() - 1);
        chart.zoomX(start.getTime(), end);
    });

    document.querySelector('#ytd').addEventListener('click', function (e) {
        resetCssClasses(e);

        const today = new Date();
        const startOfYear = new Date(today.getFullYear(), 0, 1); 

        chart.zoomX(
            startOfYear.getTime(),
            today.getTime()
        );
    });


    document.querySelector('#all').addEventListener('click', function (e) {
        resetCssClasses(e);

        
        const seriesData = chart.w.globals.initialSeries[0].data;

        if (seriesData.length > 0) {
            const start = seriesData[0].x;
            const end = seriesData[seriesData.length - 1].x;

            chart.zoomX(start, end);
        }
    });

fetch("<?= base_url('Emp_Perfomance/json_chart_data/' . $em_code) ?>")
    .then(res => res.json())
    .then(data => {

        const maxOrder = Math.max(...data.map(item => item.y));
        const paddedMax = Math.ceil((maxOrder + 20) / 25) * 25;

        chart.updateOptions({
            yaxis: {
                min: 0,
                max: paddedMax,
                tickAmount: paddedMax / 25, 
                labels: {
                    formatter: function (val) {
                        return Math.round(val);
                    }
                },
                forceNiceScale: false,
                decimalsInFloat: 0,
                title: {
                    text: 'Order Count'
                }
            }
        });

        
        data.forEach(item => {
            const localDate = new Date(item.x);  
            
            localDate.setHours(localDate.getHours() + 5.5); 
            item.x = localDate.getTime();  
        });

        chart.updateSeries([{ name: "Orders", data }]);
    });

</script>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;

    }

    .table-wrapper {
        overflow-x: auto;
        border: 2px transparent;
    }

    table {
        border-collapse: collapse;
        min-width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        text-align: center;
        padding: 4px;
        min-width: 80px;
    }

    th.shift {
        background: black;
        color: yellow;
        font-weight: bold;
    }

    th.name-header {
        background: orange;
        color: black;
    }

    td.name-cell {
        font-weight: bold;
        background: white;
    }

    th.date {
        background: limegreen;
        color: black;
        font-weight: bold;
    }

    .order-count {
        font-weight: bold;
        font-size: 14px;
    }

    .pc-position {
        font-size: 12px;
        color: blue;
    }

    .striped {
        background: repeating-linear-gradient(45deg,
                #ffcccc,
                #ffcccc 5px,
                #fff 5px,
                #fff 10px);
    }

    .shift-filter {
        cursor: pointer;
        margin: 0 5px;
        padding: 5px 10px;
        font-size: 14px;
    }

    .shift-filter.active {
        border: 2px solid #333;
    }
</style>


<!-- <script>
    document.querySelectorAll('.shift-filter').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.shift-filter').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        let selectedShift = this.dataset.shift;

        document.querySelectorAll('.order-cell').forEach(cell => {
            if (cell.dataset.shift === selectedShift) {
                cell.parentElement.style.display = '';
            } else {
                cell.parentElement.style.display = 'none';
            }
        });
    });
});

</script> -->

<script>
    const em_code = "<?= $em_code ?>";

    function loadShiftOrders(shift = '') {
        fetch(`<?= base_url('Emp_Perfomance/get_shift_order_data/') ?>${em_code}/${shift}`)
            .then(res => res.json())
            .then(data => {
                const tableBody = document.querySelector('#shift-order-table tbody');
                tableBody.innerHTML = '';

                let totalOrders = 0;

                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="4">No data found for selected shift.</td></tr>';
                    document.getElementById('shift-total-orders').textContent = '0';
                    return;
                }

                data.forEach(item => {
                    totalOrders += parseInt(item.order_count);
                    const row = `
                        <tr>
                            <td>${item.order_date}</td>
                            <td>${item.shift}</td>
                            <td>${item.pc_position}</td>
                            <td>${item.order_count}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });

                document.getElementById('shift-total-orders').textContent = totalOrders;
            });
    }

    document.querySelectorAll('.shift-filter').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.shift-filter').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const selectedShift = this.getAttribute('data-shift');
            loadShiftOrders(selectedShift);
        });
    });


    loadShiftOrders();
</script>



>>>>>>> d2b80f29b3e75409dba6e05677707d905edac65f
<?php $this->load->view('backend/footer'); ?>