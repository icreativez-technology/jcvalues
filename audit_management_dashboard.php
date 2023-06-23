<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Audit Management Dashboard";
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

.content-center {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}

.text-caps {
    font-size: 60px;
    margin-right: 15px;
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
                        <p><a href="/">Home</a> »  <br>
                        <?php echo $_SESSION['Page_Title']; ?></p>
                        <!-- MIGAS DE PAN -->
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="d-flex justify-content-end">
                            <a href="/audit_management_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Audit
                                </button>
                            </a>
                            <a href="/audit_management.php?a=2">
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
                                        <input type="hidden" name="internal-count" id="internal-count"
                                            value='<?php echo json_encode($internalCountInfo) ?>' />
                                        <input type="hidden" name="external-count" id="external-count"
                                            value='<?php echo json_encode($externalCountInfo) ?>' />
                                        <div class="col-md-3">
                                            <label class="filterlabel">Year:</label>
                                            <input type="number" class="date-own form-control" placeholder="Year"
                                                name="year" id="year" value="<?php echo date('Y'); ?>" required>
                                        </div>
                                        <div class="col-md-4 ms-2 mt-6">
                                            <button class="btn btn-sm btn-primary mt-4" id="update">Apply Filter</button>
                                            <button type="button" class="btn btn-sm btn-secondary mt-4" onClick="window.location.href=window.location.href">Reset Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--chart-->
                            <div class="row g-5 g-xl-8 p-6">
                                <div class="col-lg-7">
                                    <!--begin::Charts Widget 5-->
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bold fs-3 mb-1">Month Wise</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <div id="month-wise"
                                                class="apexcharts-canvas apexcharts64l2r5im apexcharts-theme-light"
                                                style="height: 350px; min-height: 365px;">

                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Charts Widget 5-->
                                </div>
                                <div class="col-lg-5">
                                    <!--begin::Mixed Widget 2-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 bg-info py-5"
                                            style="height: 150px; min-height: 150px; align-items:baseline">
                                            <h3 class="card-title fw-bold text-white">Audit Statistics</h3>
                                            <!--begin::Toolbar-->
                                            <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                                <a class="btn btn-sm btn-active btn-info active px-4 me-1"
                                                    id="internalCountBtn">Internal</a>
                                                <a class="btn btn-sm btn-active btn-info px-4 me-1"
                                                    id="externalCountBtn">External</a>
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body p-0">
                                            <!--begin::Chart-->
                                            <!--begin::Stats-->
                                            <div class="card-p mt-n20 position-relative">
                                                <!--begin::Row-->
                                                <div class="row g-0">
                                                    <!--begin::Col-->
                                                    <div
                                                        class="col bg-light-warning rounded-2 me-7 mb-7 content-center">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                                        <span class="text-caps text-warning" id="delayCount">0</span>
                                                        <div>
                                                            <span
                                                                class="svg-icon svg-icon-2x svg-icon-warning d-block mb-3"><i
                                                                    class="fas fa-user-clock fs-1"
                                                                    style="color: #fbad4f !important;"
                                                                    aria-hidden="true"></i></span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#"
                                                                class="text-warning fw-semibold fs-6">Delayed</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div
                                                        class="col bg-light-primary px-6 py-8 rounded-2 mb-7 content-center">
                                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                                        <span class="text-caps text-primary"
                                                            id="scheduledCount">0</span>
                                                        <div>
                                                            <span
                                                                class="svg-icon svg-icon-2x svg-icon-warning d-block mb-3"><i
                                                                    class="fas fa-stopwatch"
                                                                    style="color: #0ca7e1 !important; font-size: 28px;"></i></span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#"
                                                                class="text-primary fw-semibold fs-6">Scheduled</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                                <!--begin::Row-->
                                                <div class="row g-0">
                                                    <!--begin::Col-->
                                                    <div
                                                        class="col bg-light-danger px-6 py-8 rounded-2 me-7 content-center">
                                                        <span class="text-caps text-danger" id="cancelledCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                        <div>
                                                            <span class="symbol-label bg-light-danger d-block mb-3">
                                                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                                <span class="svg-icon svg-icon-2x svg-icon-danger"><i
                                                                        class="fas fa-hourglass-start fs-1"
                                                                        style="color: #ff6b6b !important"
                                                                        aria-hidden="true"></i></span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#"
                                                                class="text-danger fw-semibold fs-6 mt-2">Cancelled</a>
                                                        </div>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div
                                                        class="col bg-light-success px-6 py-8 rounded-2 content-center">
                                                        <span class="text-caps text-success" id="auditedCount">0</span>
                                                        <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                                        <div>
                                                            <span
                                                                class="svg-icon svg-icon-2x svg-icon-success d-block mb-3"><i
                                                                    class="fas fa-clock fs-1 text-success"></i></span>
                                                            <!--end::Svg Icon-->
                                                            <a href="#"
                                                                class="text-success fw-semibold fs-6 mt-2">Audited</a>
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
                                                <div id="dept-internal" class="donut-chart-j6"></div>
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
        const monthArr = ['Jan', 'Feb', 'Mar', 'Apr',
            'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ]
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
                    url: 'includes/filter_audit_management.php',
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
                    setCount(internalCountObj);
                    let internalMonthWise = getMonthCount(JSON.parse(result)?.monthwiseInternal);
                    let externalMonthWise = getMonthCount(JSON.parse(result)?.monthwiseExternal);
                    let monthWiseData = [{
                        name: "Internal",
                        data: internalMonthWise
                    }, {
                        name: "External",
                        data: externalMonthWise
                    }]
                    getMonthWiseChart(monthWiseData);
                    chart.updateSeries(monthWiseData);

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
                pieSliceText: 'value-and-percentage'
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

        $('#internalCountBtn').on('click', function() {
            return setCount(internalCountObj);
        })

        $('#externalCountBtn').on('click', function() {
            return setCount(externalCountObj);
        })

        function getMonthCount(dataArr) {
            let data = new Array();
            monthArr.map((ele, index) => {
                let countArr = new Array();
                countArr = dataArr.filter((item) => Number(item.months) == (Number(index) + 1))
                data.push(countArr?.length > 0 ? countArr?.length.toString() : "0");
            })
            return data;
        }

        function setCount(dataObj) {
            let reset = resetCount();
            if (reset) {
                $("#scheduledCount").append(dataObj?.sheduled > 0 ? dataObj.sheduled : 0);
                $("#cancelledCount").append(dataObj?.cancelled > 0 ? dataObj.cancelled : 0);
                $("#auditedCount").append(dataObj?.audited > 0 ? dataObj.audited : 0);
                $("#delayCount").append(dataObj?.delay > 0 ? dataObj.delay : 0);
            }
        }

        function resetCount() {
            $("#scheduledCount").empty();
            $("#cancelledCount").empty();
            $("#auditedCount").empty();
            $("#delayCount").empty();
            return true;
        }

        $('body').on('click', '#update', function(e) {
            return getCharts();
        });

        function getMonthWiseChart(monthWiseData) {
            var options = {
                series: monthWiseData ? monthWiseData : [],
                chart: {
                    type: 'bar',
                    stacked: true,
                    height: 350,

                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },

                responsive: [{
                    breakpoint: 600,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        },
                          plotOptions: {
                                bar: {
                                    horizontal: true,
                                    borderRadius: 5,
                                    columnWidth: '50%',
                                    dataLabels: {
                                        enabled: false,
                                        total: {
                                            enabled: false,
                                            style: {
                                                fontSize: '8px',
                                                fontWeight: 200,
                                            }
                                        }
                                    }
                                },
                            }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 10,
                        columnWidth: '20%',
                        dataLabels: {
                            enabled: false,
                            total: {
                                enabled: false,
                                style: {
                                    fontSize: '10px',
                                    fontWeight: 600,
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    type: 'month',
                    categories: monthArr,
                },
                legend: {
                    position: 'top',
                    colors: ['#008ffb', '#00e396']
                    // offsetY: 40
                },
                fill: {
                    opacity: 1,
                    colors: ['#008ffb', '#00e396']
                },

            };

            chart = new ApexCharts(document.querySelector("#month-wise"), options);
            chart.render();

        }
        </script>
</body>

</html>