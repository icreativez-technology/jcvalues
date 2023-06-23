<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Q-Alert";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 9 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canDelete = $permissionInfo['can_delete'];
$canEdit = $permissionInfo['can_edit'];
$canView = $permissionInfo['can_view'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
    rel="stylesheet" />
<style>
.ui-datepicker-calendar {
    display: none;
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6 col-sm-12">
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                        <!-- MIGAS DE PAN -->
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="d-flex justify-content-end">
                            <?php if ($role == 1 || $canEdit == 1) { ?>
                            <a href="/q_alert_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Q-Alert
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/q_alert_view_list.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    <i class="bi bi-list-ul"></i> View List
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="padding: 0;">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!-- AQUI AÑADIR EL CONTENIDO  -->

                        <!--begin::Container-->
                        <div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">

                            <!--filters-->
                            <div class="container-full">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="filterlabel">Year:</label>
                                            <input type="number" class="date-own form-control" placeholder="Year"
                                                name="year" id="year" value="<?php echo date('Y'); ?>" required>
                                        </div>
                                        <div class="col-md-4 ms-2 mt-6">
                                            <button class="btn btn-sm btn-primary mt-4" id="update">Apply
                                                Filter</button>
                                            <button type="button" class="btn btn-sm btn-secondary mt-4"
                                                onClick="window.location.href=window.location.href">Reset
                                                Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--board-->
                            <!-- <div class="row mt-2">
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-primary shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-pencil text-primary fs-4" aria-hidden="true"></i>
                        </div>
                        <div>
                          <p class="m-0">Create</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">Created in this period</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-warning shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-envelope-open text-warning fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Open</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">Yet to start, In progress</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-info shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-check-circle text-info fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Completed</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">Action taken, verified</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 mt-2">
                  <div class="card border-0 border-top border-3 border-danger shadow">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fa fa-hourglass-start text-danger fs-4"></i>
                        </div>
                        <div>
                          <p class="m-0">Delay</p>
                          <p class="m-0 text-end">0</p>
                        </div>
                      </div>
                      <div class="mt-2 d-flex align-items-center">
                        <i class="fa fa-info-circle text-secondary me-2"></i>
                        <p class="m-0 text-secondary">Missed due date</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->

                            <!--chart-->
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
                                                <span class="card-label fw-bolder fs-3 mb-1">Process Type</span>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="box-internal-column_fin">
                                                <div id="process-type" class="donut-chart-j6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 g-xl-8" style=" font-size: 11px; padding: 10px; color: #3366cc; ">
                                * The statistics shown above are related to current year only
                            </div>
                            <!-- Finalizar contenido -->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Content-->

                    <?php include('includes/footer.php'); ?>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Root-->

        <!--end::Main-->


        <?php include('includes/scrolltop.php'); ?>
        <script>
        var hostUrl = "assets/";
        </script>
        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!--end::Global Javascript Bundle-->
        <!--begin::Page Vendors Javascript(used by this page)-->
        <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
        <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <!--end::Page Vendors Javascript-->
        <!--begin::Page Custom Javascript(used by this page)-->
        <script src="assets/js/widgets.bundle.js"></script>
        <script src="assets/js/custom/widgets.js"></script>
        <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
        <script src="assets/js/custom/utilities/modals/select-location.js"></script>
        <script src="assets/js/custom/utilities/modals/users-search.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js">
        </script>
        <script type="text/javascript">
        $('.date-own').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });
        $(document).ready(function() {
            google.charts.load('current', {
                packages: ['corechart']
            });
            getCharts(true);
        });

        let dataArr = new Array();
        var monthWiseChart = null;

        function getCharts(key) {
            const year = $('#year').val();
            const start = year + "-01-01";
            const end = (Number(year) + 1) + "-01-01";
            const data = {
                startDate: start,
                endDate: end
            }
            $.ajax({
                    type: 'POST',
                    url: 'includes/filter_q_alert.php',
                    data: data
                })
                .done(function(result) {
                    dataArr = JSON.parse(result);
                    let processValue = new Array();
                    Object.entries(dataArr.process_result).forEach(([key, value]) => {
                        value?.length > 0 ? processValue.push([key, value?.length]) : null;
                    });
                    if (!key) {
                        monthWiseChart.destroy();
                    }
                    drawMonthChart(dataArr.month_result);
                    return google.charts.setOnLoadCallback(() => drawProcessChart(processValue));
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
                        label: 'Open',
                        backgroundColor: '#008ffb',
                        borderColor: '#008ffb',
                        // backgroundColor: 'rgb(254, 215, 19)',
                        // borderColor: 'rgb(254, 215, 19)',
                        data: getCount(data.Open),
                    },
                    {
                        label: 'Closed',
                        backgroundColor: '#00e396',
                        borderColor: '#00e396',
                        data: getCount(data.Closed),
                    }
                ]
            };

            monthWiseChart = new Chart(
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

        function drawProcessChart(valueArr) {
            console.log(valueArr);
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
            var chart = new google.visualization.PieChart(document.getElementById('process-type'));
            chart.draw(data, options);
        }

        $('body').on('click', '#update', function(e) {
            return getCharts(false);
        });
        </script>
</body>

</html>