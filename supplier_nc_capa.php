<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Supplier Non-Conformance";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$permissionSql = "SELECT * From permissions Where module_id = 13 AND role_id = '$role'";
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
@media(max-width: 768px){
    .text-buttons {
        font-size: 9px;
      
    }
}
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
                            <a href="/supplier_nc_capa_add.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                   <span class='text-buttons'> New Supplier Non-Conformance</span>
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/supplier_nc_capa_view_list.php">
                                <button type="button" class="btn btn-light-primary me-3 topbottons">
                                    <i class="bi bi-list-ul"></i>   <span class='text-buttons'>View List</span>
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
                            <div class="row g-5 g-xl-8 p-6">
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Supplier</span>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="supplier" style="height: 350px; min-height: 365px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="card card-xl-stretch mb-xl-8">
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">Classification</span>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="box-internal-column_fin">
                                                <div id="classification" class="donut-chart-j6"></div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js">
        </script>
        <script type="text/javascript">
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
                    url: 'includes/filter_supplier_nc_capa.php',
                    data: data
                })
                .done(function(result) {
                    let supplierArr = JSON.parse(result)?.supplier;
                    let classificationArr = JSON.parse(result)?.classification;
                    getSupplierWiseData(supplierArr);
                    getSupplierWiseChart();
                    chart.updateSeries([{
                        name: "Count",
                        data: categoryVal
                    }]);
                    let classificationValue = new Array();
                    Object.entries(classificationArr).forEach(([key, value]) => {
                        value?.length > 0 ? classificationValue.push([key, value?.length]) : null;
                    });
                    return google.charts.setOnLoadCallback(() => drawClassificationChart(classificationValue));
                });
        };

        $('body').on('click', '#update', function(e) {
            return getCharts(false);
        });

        function drawClassificationChart(valueArr) {
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
            var chart = new google.visualization.PieChart(document.getElementById('classification'));
            chart.draw(data, options);
        }

        function getSupplierWiseChart() {
            var options = getSupplierWiseOptions();
            chart = new ApexCharts(document.querySelector("#supplier"), options);
            chart.render();
        }

        function getSupplierWiseData(dataArr) {
            const findingObj = {};
            dataArr.forEach(element => {
                findingObj[element] = (findingObj[element] || 0) + 1;
            });
            categoryArr = Object.keys(findingObj).length > 0 ? Object.keys(findingObj) : categoryArr;
            categoryVal = Object.values(findingObj);
        }

        function getSupplierWiseOptions() {
            var options = {
                series: [{
                    data: []
                }],
                chart: {
                    type: 'bar',
                    height: 350,
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