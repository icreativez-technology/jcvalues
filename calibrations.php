<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Calibrations";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end">
                            <a href="/calibration_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Calibration
                                </button>
                            </a>
                            <a href="/calibration_view_list.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    <i class="bi bi-list-ul"></i> View List
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
                    <div class="container-custom" id="kt_content_container">
                        <div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">
                            <!--filters-->
                            <div class="container-full">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="filterlabel">From:</label>
                                            <input type="date" class="form-control" placeholder="From" name="fromDate" id="fromDate" value="<?php echo date('Y-01-01'); ?>" required="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="filterlabel">To:</label>
                                            <input type="date" class="form-control" placeholder="From" name="todate" id="toDate" value="<?php echo date('Y-m-d'); ?>" required="">
                                        </div>
                                        <div class="col-md-3 ms-2 mt-6">
                                            <button class="btn btn-sm btn-primary mt-4" id="update">Apply
                                                Filter</button>
                                            <button type="button" class="btn btn-sm btn-secondary mt-4" onClick="window.location.href=window.location.href">Reset
                                                Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 g-xl-8">
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Month Wise</span>
                                            </h3>
                                        </div>
                                        <div class="card-body mt-6">
                                            <div id="box-internal-column_fin">
                                                <canvas id="month-wise"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Product Group Wise</span>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="box-internal-column_fin">
                                                <div id="product-group" class="donut-chart-j6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 g-xl-8" style=" font-size: 11px; padding: 10px; color: #3366cc; ">
                                * The statistics shown above are related to current year only
                            </div>
                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/scrolltop.php'); ?>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            google.charts.load('current', {
                packages: ['corechart']
            });
            getCharts(true);
        });

        let dataArr = new Array();

        function getCharts(key) {
            const start = $('#fromDate').val();
            const end = $('#toDate').val();
            const data = {
                startDate: start,
                endDate: end
            }
            $.ajax({
                    type: 'POST',
                    url: 'includes/filter_calibration.php',
                    data: data
                })
                .done(function(result) {
                    dataArr = JSON.parse(result);
                    let focusAreaValue = new Array();
                    Object.entries(dataArr.focus_area_result).forEach(([key, value]) => {
                        value?.length > 0 ? focusAreaValue.push([key, value?.length]) : null;
                    });
                    if (key) {
                        drawMonthChart(dataArr.month_result);
                    }
                    return google.charts.setOnLoadCallback(() => drawFocusAreaChart(focusAreaValue));
                });
        };

        function drawMonthChart(data) {
            const monthWiseLabels = [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ];

            const monthWiseData = {
                labels: monthWiseLabels,
                datasets: [{
                        label: 'Active',
                        backgroundColor: 'rgb(254, 215, 19)',
                        borderColor: 'rgb(254, 215, 19)',
                        data: getCount(data.Active),
                    },
                    {
                        label: 'Rejected',
                        backgroundColor: 'rgb(0, 204, 207)',
                        borderColor: 'rgb(0, 204, 207)',
                        data: getCount(data.Rejected),
                    }
                ]
            };
            const monthWiseChart = new Chart(
                document.getElementById('month-wise'), {
                    type: 'bar',
                    data: monthWiseData,
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                }
            );
        }

        const getCount = (data) => {
            const a = [];
            for (let i = 0; i < 12; i++) {
                let count = 0;
                for (let m = 0; m < data.length; m++) {
                    if (i == new Date(data[m].created_at).getMonth()) {
                        count++;
                    }
                }
                a[i] = count;
            }
            return a;
        }

        function drawFocusAreaChart(valueArr) {
            var data = google.visualization.arrayToDataTable([
                ['Element', 'Count'],
            ]);
            if (valueArr) {
                var data = google.visualization.arrayToDataTable([
                    ['Element', 'Count'],
                    ...valueArr
                ]);
            }
            var options = {
                pieSliceText: 'label',
            };
            var chart = new google.visualization.PieChart(document.getElementById('product-group'));
            chart.draw(data, options);
        }

        $('body').on('click', '#update', function(e) {
            return getCharts(false);
        });
    </script>
</body>

</html>