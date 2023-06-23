<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit NC & CAPA Dashboard";
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 3 AND role_id = '$role'";
$fetchPermission = mysqli_query($con, $permissionSql);
$permissionInfo = mysqli_fetch_assoc($fetchPermission);
$canEdit = $permissionInfo['can_edit'];
?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
<style>
    .ui-datepicker-calendar {
        display: none;
    }

    .content-center {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .text-caps {
        font-size: 48px;
        margin-right: 15px;
    }
</style>
<!--begin::Body-->

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
                                <a href="/audit_nc_capa_add.php">
                                    <button type="button" class="btn btn-primary me-3 topbottons" >
                                        New Audit NC
                                    </button>
                                </a>
                            <?php } ?>
                            <a href="/audit_nc_capa_view_list.php">
                                <button type="button" class="btn btn-primary me-3 topbottons" >
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
                                            <input type="number" class="date-own form-control" placeholder="Year" name="year" id="year" value="<?php echo date('Y'); ?>" required>
                                        </div>
                                        <div class="col-md-4 ms-2 mt-6">
                                            <button class="btn btn-sm btn-primary mt-4" id="update">Apply
                                                Filter</button>
                                            <button type="button" class="btn btn-sm btn-secondary mt-4" onClick="window.location.href=window.location.href">Reset
                                                Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--chart-->
                            <div class="row g-5 g-xl-8 p-6">
                                <div class="col-xl-6">
                                    <!--begin::Charts Widget 5-->
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">Findings By Type</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body table-responsive matrixbox">
                                            <div id="month-wise" style="height: 350px; min-height: 365px;">

                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Charts Widget 5-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Mixed Widget 2-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 bg-info py-5" style="height: 150px; min-height: 150px;">
                                            <h3 class="card-title fw-bold text-white">Audit NCR Statistics</h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body p-0 ">
                                            <!--begin::Chart-->
                                            <!-- <div class="mixed-widget-2-chart card-rounded-bottom bg-danger"
                                                data-kt-color="danger" style="height: 200px; min-height: 200px;">

                                            </div> -->
                                            <!--end::Chart-->
                                            <!--begin::Stats-->
                                            <div class="card-p mt-n20 position-relative">


                                                <!--begin::Row-->
                                                <div class="row g-0">
                                                    <!--begin::Col-->
                                                    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7 content-center">
                                                        <span class="text-caps text-danger" id="internalOpenCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                        <div>
                                                            <span class="symbol-label bg-light-danger d-block mb-3">
                                                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                                <span class="svg-icon svg-icon-2x svg-icon-danger"><i class="fas fa-hourglass-start fs-1" style="color: #ff6b6b !important" aria-hidden="true"></i></span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#" class="text-danger fw-semibold fs-6 mt-2">Internal
                                                                Open</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col bg-light-success px-6 py-8 rounded-2 content-center">
                                                        <span class="text-caps text-success" id="internalClosedCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                                        <div>
                                                            <span class="svg-icon svg-icon-2x svg-icon-success d-block mb-3"><i class="fas fa-clock fs-1 text-success"></i></span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#" class="text-success fw-semibold fs-6 mt-2">Internal
                                                                Closed</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                                <!--begin::Row-->
                                                <div class="row g-0 mt-4">
                                                    <!--begin::Col-->
                                                    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7 content-center">
                                                        <span class="text-caps text-danger" id="externalOpenCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                        <div>
                                                            <span class="symbol-label bg-light-danger d-block mb-3">
                                                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                                <span class="svg-icon svg-icon-2x svg-icon-danger"><i class="fas fa-hourglass-start fs-1" style="color: #ff6b6b !important" aria-hidden="true"></i></span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#" class="text-danger fw-semibold fs-6 mt-2">External
                                                                Open</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col bg-light-success px-6 py-8 rounded-2 content-center">
                                                        <span class="text-caps text-success" id="externalClosedCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                                        <div>
                                                            <span class="svg-icon svg-icon-2x svg-icon-success d-block mb-3"><i class="fas fa-clock fs-1 text-success"></i></span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#" class="text-success fw-semibold fs-6 mt-2">External
                                                                Closed</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Mixed Widget 2-->
                                </div>
                            </div>

                            <div class="row g-5 g-xl-8 p-3">
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">Department Wise
                                                    (Internal)</span>
                                            </h3>
                                        </div>
                                        <div class="card-body table-responsive matrixbox">
                                            <div id="box-internal-column_fin">
                                                <div id="dept-internal" class="donut-chart-j6" style="height: 350px; min-height: 365px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">Department Wise
                                                    (External)</span>
                                            </h3>
                                        </div>
                                        <div class="card-body table-responsive matrixbox">
                                            <div id="box-internal-column_fin">
                                                <div id="dept-external" class="donut-chart-j6"></div>
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
            let internalCountObj = new Object();
            let externalCountObj = new Object();
            let categoryArr = new Array();
            let categoryVal = new Array();
            let chart = null;

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
                getCharts();
            });

            function getCharts() {
                const year = $('#year').val();
                const start = year + "-01-01";
                const end = (Number(year) + 1) + "-01-01";
                const data = {
                    startDate: start,
                    endDate: end
                }
                $.ajax({
                        type: 'POST',
                        url: 'includes/filter_audit_nc_capa.php',
                        data: data
                    })
                    .done(function(result) {
                        let internalData = JSON.parse(result)?.internal;
                        const internalObj = {};
                        internalData.forEach(element => {
                            internalObj[element] = (internalObj[element] || 0) + 1;
                        });
                        let internalArr = Object.entries(internalObj);

                        let externalData = JSON.parse(result)?.external;
                        const externalObj = {};
                        externalData.forEach(element => {
                            externalObj[element] = (externalObj[element] || 0) + 1;
                        });
                        let externalArr = Object.entries(externalObj);
                        internalCountObj = JSON.parse(result)?.internalCount;
                        externalCountObj = JSON.parse(result)?.externalCount;
                        setCount();


                        let monthWiseInternalArr = JSON.parse(result)?.monthWiseInternal;
                        let monthWiseExternalArr = JSON.parse(result)?.monthWiseExternal;
                        getMonthWiseData([...monthWiseInternalArr, ...monthWiseExternalArr]);
                        getMonthWiseChart();
                        chart.updateSeries([{
                            name: "Count",
                            data: categoryVal
                        }])
                        google.charts.setOnLoadCallback(() => drawExternalChart(externalArr));
                        return google.charts.setOnLoadCallback(() => drawInternalChart(internalArr));
                    });
            };

            function drawExternalChart(valueArr) {
                var data = google.visualization.arrayToDataTable([
                    ['Element', 'Count'],
                ]);
                var data = google.visualization.arrayToDataTable([
                    ['Element', 'Count'],
                    ...valueArr
                ]);
                var options = {
                    title: '',
                    pieSliceText: 'value-and-percentage',
                    width:'auto',
                    height:'auto',
                    width_units: '%'
                };
                var chart = new google.visualization.PieChart(document.getElementById('dept-external'));
                chart.draw(data, options);
            }

            function drawInternalChart(valueArr) {
                var data = google.visualization.arrayToDataTable([
                    ['Element', 'Count'],
                ]);
                var data = google.visualization.arrayToDataTable([
                    ['Element', 'Count'],
                    ...valueArr
                ]);
                var options = {
                    title: '',
                    pieSliceText: 'value-and-percentage'
                };
                var chart = new google.visualization.PieChart(document.getElementById('dept-internal'));
                chart.draw(data, options);
            }

            function setCount() {
                let reset = resetCount();
                if (reset) {
                    $("#internalOpenCount").append(internalCountObj?.active > 0 ? internalCountObj.active : 0);
                    $("#internalClosedCount").append(internalCountObj?.closed > 0 ? internalCountObj.closed : 0);
                    $("#externalOpenCount").append(externalCountObj?.active > 0 ? externalCountObj.active : 0);
                    $("#externalClosedCount").append(externalCountObj?.closed > 0 ? externalCountObj.closed : 0);
                }
            }

            function resetCount() {
                $("#internalOpenCount").empty();
                $("#internalClosedCount").empty();
                $("#externalOpenCount").empty();
                $("#externalClosedCount").empty();
                return true;
            }

            $('body').on('click', '#update', function(e) {
                return getCharts(false);
            });

            function getMonthWiseChart() {
                var options = getMonthWiseOptions();
                chart = new ApexCharts(document.querySelector("#month-wise"), options);
                chart.render();
            }

            function getMonthWiseData(dataArr) {
                const findingObj = {};
                dataArr.forEach(element => {
                    if (element) {
                        findingObj[element] = (findingObj[element] || 0) + 1;
                    }
                });
                categoryArr = Object.keys(findingObj).length > 0 ? Object.keys(findingObj) : categoryArr;
                categoryVal = Object.values(findingObj);
            }

            function getMonthWiseOptions() {
                var options = {
                    series: [{
                        data: []
                    }],
                    chart: {
                        type: 'bar',
                        height: 320,
                        toolbar: {
                            show: false
                        },
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: true,
                            columnHeight: '20%',
                            barHeight: '10%',
                            distributed: true,
                        },
                        colors: [
                            "#33b2df",
                            "#2b908f",
                            "#f9a3a4",
                            "#90ee7e",
                            "#f48024",
                            "#69d2e7",
                            '#7239ea',
                            '#26a0fc',
                        ],
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: categoryArr,
                        tickAmount: 1,
                        decimalsInFloat: 0,
                        labels: {
                            formatter: (value) => {
                                return value
                            },
                        }
                    },
                };
                return options;
            }
        </script>
</body>

</html>