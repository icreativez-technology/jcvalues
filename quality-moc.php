<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Quality MOC";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 4 AND role_id = '$role'";
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
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div class="col-lg-6 col-sm-12">
                        <p><a href="/">Home</a> » <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="d-flex justify-content-end">
                            <?php if ($role == 1 || $canEdit == 1) { ?>
                            <a href="/quality-moc_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    New MoC
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/quality-moc_view_list.php">
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
                            <div class="container-full">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="filterlabel">Year:</label>
                                            <input type="number" class="date-own form-control" placeholder="Year"
                                                name="year" id="year" value="<?php echo date('Y'); ?>" required>
                                        </div>
                                        <div class="col-md-4 ms-2 mt-7">
                                            <Button class="btn btn-sm btn-primary mt-3" id="update">Apply
                                                Filter</Button>
                                            <Button type="button" class="btn btn-sm btn-secondary mt-3"
                                                onClick="window.location.href=window.location.href">Reset
                                                Filter</Button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-5 g-xl-8">
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Departments</span>
                                            </h3>
                                        </div>
                                        <div class="card-body  table-responsive matrixbox">
                                            <div id="box-internal-column_fin">
                                                <div id="first_chart_column" class="donut-chart-j6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">MoC Types</span>
                                            </h3>
                                        </div>
                                        <div class="card-body table-responsive matrixbox">
                                            <div id="second_chart_column" class="donut-chart-j6"></div>
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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
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
                url: 'includes/filter_quality_moc.php',
                data: data
            })
            .done(function(result) {
                dataArr = JSON.parse(result);
                let departmentValue = new Array();
                let mocValue = new Array();
                Object.entries(dataArr.department_result).forEach(([key, value]) => {
                    value?.length > 0 ? departmentValue.push([key, value?.length]) : null;
                });
                Object.entries(dataArr.moc_type_result).forEach(([key, value]) => {
                    value?.length > 0 ? mocValue.push([key, value?.length]) : null;
                });
                google.charts.setOnLoadCallback(() => drawDepartmentChart(departmentValue));
                return google.charts.setOnLoadCallback(() => drawMocChart(mocValue));
            });
    };

    function drawDepartmentChart(valueArr) {
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
        var chart = new google.visualization.PieChart(document.getElementById('first_chart_column'));
        chart.draw(data, options);
    }

    function drawMocChart(valueArr) {
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
        var chart = new google.visualization.PieChart(document.getElementById('second_chart_column'));
        chart.draw(data, options);
    }

    $('body').on('click', '#update', function(e) {
        return getCharts();
    });
    </script>
</body>

</html>