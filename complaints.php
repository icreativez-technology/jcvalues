<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Customer Complaints";
$email = $_SESSION['usuario'];
$userSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchUser = mysqli_query($con, $userSql);
$userInfo = mysqli_fetch_assoc($fetchUser);
?>
<style>
    @media (max-width: 330px) {
        .table-text {
            font-size: 8px !important;
            font-weight: bold !important;	
            color: white !important;
        }
        .logo-button {
            display: none !important;
        }
    }
</style>

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
                            <?php if ($userInfo['Customer_Compliants_Representatives'] == 'Yes') { ?>
                            <a href="/customer_complaint_add.php">
                                <button type="button" class="btn btn-primary me-3 topbottons">
                                   <span class='table-text'> New Customer Complaint</span>
                                </button>
                            </a>
                            <?php } ?>
                            <a href="/customer_complaint_view_list.php">
                                <button type="button" class="btn btn-primary me-3 topbottons">
                                    <i class="bi bi-list-ul logo-button"></i>  <span class='table-text'>View List</span>
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
                                                <span class="card-label fw-bolder fs-3 mb-1">Nature of complaint</span>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="box-internal-column_fin">
                                                <div id="nature-of-complaint" class="donut-chart-j6"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
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
                url: 'includes/filter_complaints.php',
                data: data
            })
            .done(function(result) {
                dataArr = JSON.parse(result);
                let natureOfComplaintValue = new Array();
                console.log(dataArr.nature_of_complaint_result);
                Object.entries(dataArr.nature_of_complaint_result).forEach(([key, value]) => {
                    value?.length > 0 ? natureOfComplaintValue.push([key, value?.length]) : null;
                });
                if (!key) {
                    monthWiseChart.destroy();
                }
                drawMonthChart(dataArr.month_result);
                return google.charts.setOnLoadCallback(() => drawNatureOfComplaintChart(natureOfComplaintValue));
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
                    // backgroundColor: 'rgb(254, 215, 19)',
                    // borderColor: 'rgb(254, 215, 19)',
                     backgroundColor: '#008ffb',
                     borderColor: '#008ffb',
                    data: getCount(data.Open),
                },
                {
                    label: 'Closed',
                    // backgroundColor: 'rgb(0, 204, 207)',
                    // borderColor: 'rgb(0, 204, 207)',
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

    function drawNatureOfComplaintChart(valueArr) {
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
        var chart = new google.visualization.PieChart(document.getElementById('nature-of-complaint'));
        chart.draw(data, options);
    }

    $('body').on('click', '#update', function(e) {
        return getCharts(false);
    });
    </script>
</body>

</html>