<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Risk Assesment";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 5 AND role_id = '$role'";
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
                            <a href="/quality-risk_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New Risk
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/quality-risk-view-list.php">
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

                        <!--begin::FILTROS-->
                        <div class="content d-flex flex-column flex-column-fluid filtros-audit" style="padding: 0;">
                            <!--begin::Container-->
                            <div class="container-full">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="filterlabel">Year:</label>
                                            <input type="number" class="date-own form-control" placeholder="Year"
                                                name="year" id="year" value="<?php echo date('Y'); ?>" required>
                                        </div>
                                        <div class="col-md-4 ms-2 mt-6">
                                            <Button class="btn btn-sm btn-primary mt-4" id="update">Apply
                                                Filter</Button>
                                            <Button type="button" class="btn btn-sm btn-secondary mt-4"
                                                onClick="window.location.href=window.location.href">Reset
                                                Filter</Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::FILTROS-->
                            <!-- begin:: CHARTS -->
                            <!--begin::Row-->
                            <div class="row g-5 g-xl-8">
                                <div class="col-xl-6">
                                    <!--begin::Charts Widget 3-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Process Wise</span>
                                            </h3>

                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body table-responsive matrixbox">
                                            <!--begin::Chart-->
                                            <div id="box-internal-column_fin">
                                                <div id="first_chart_column" class="donut-chart-j6" style="height: 350px; min-height: 365px; "></div>
                                            </div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Charts Widget 3-->
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Charts Widget 3-->
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Risk Type</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body table-responsive matrixbox">
                                            <!--begin::Chart-->
                                            <div id="second_chart_column" class="donut-chart-j6"></div>
                                            <!--end::Chart-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Charts Widget 3-->
                                </div>
                            </div>
                            <div class="row g-5 g-xl-8" style=" font-size: 11px; padding: 10px; color: #3366cc; ">
                                * The statistics shown above are related to current year only
                            </div>
                            <!--end::Row-->
                            <!-- end:: CHARTS -->

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
        <script src="https://www.gstatic.com/charts/loader.js"></script>
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
        <script src="assets/js/custom/apps/chat/chat.js"></script>
        <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
        <script src="assets/js/custom/utilities/modals/select-location.js"></script>
        <script src="assets/js/custom/utilities/modals/users-search.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js">
        </script>

        <!--end::Page Custom Javascript-->
        <script>
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

        let dataArr = new Array();

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
                    url: 'includes/filter_quality_risk.php',
                    data: data
                })
                .done(function(result) {
                    dataArr = JSON.parse(result);

                    let processValue = new Array();
                    let riskValue = new Array();

                    Object.entries(dataArr.process_result).forEach(([key, value]) => {
                        value?.length > 0 ? processValue.push([key, value?.length]) : null;
                    });

                    Object.entries(dataArr.risk_type_result).forEach(([key, value]) => {
                        value?.length > 0 ? riskValue.push([key, value?.length]) : null;
                    });

                    google.charts.setOnLoadCallback(() => drawProccessChart(processValue));
                    return google.charts.setOnLoadCallback(() => drawRiskChart(riskValue));
                });
        };

        function drawProccessChart(valueArr) {

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
            // Instantiate and draw the chart.
            var chart = new google.visualization.PieChart(document.getElementById('first_chart_column'));
            chart.draw(data, options);
        }

        function drawRiskChart(valueArr) {
            // Define the chart to be drawn.
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
            // Instantiate and draw the chart.
            var chart = new google.visualization.PieChart(document.getElementById('second_chart_column'));
            chart.draw(data, options);
        }

        $('body').on('click', '#update', function(e) {
            return getCharts();
        });
        </script>
        <!--end::Javascript-->
</body>
<!--end::Body-->

</html>