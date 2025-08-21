<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- CSS & JS includes (some repeated jquery includes can be optimized) -->
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



<?php $this->load->view('backend/footer'); ?>