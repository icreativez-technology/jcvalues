<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Dashboard";

$email_user = $_SESSION['usuario'];
//User ID
$sql_datos_user = "SELECT * From Basic_Employee WHERE Email LIKE '$email_user'";
$conect_datos_user = mysqli_query($con, $sql_datos_user);
$result_datos_user = mysqli_fetch_assoc($conect_datos_user);
$id_user = $result_datos_user['Id_employee'];


//User Coordinator
// $sql_datos_coor = "SELECT * From Meeting_Co_Ordinator WHERE Id_employee = '$id_user'";
// $conect_datos_coor = mysqli_query($con, $sql_datos_coor);
// $result_datos_coor = mysqli_fetch_assoc($conect_datos_coor);
// $id_coor = $result_datos_coor['Id_meeting_co_ordinator'];

$sql = "SELECT Id_basic_role, Basic_Employee.Id_employee From Basic_Employee INNER JOIN Basic_Role ON Basic_Employee.Admin_User=Basic_Role.Title Where Email = '$email_user'";
$fetch = mysqli_query($con, $sql);
$roleInfo = mysqli_fetch_assoc($fetch);
$role = $roleInfo['Id_basic_role'];
$empId = $roleInfo['Id_employee'];

?>

<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->

<!--begin::Body-->
<style>
    .status-green {
        color: #2d9f50 !important;
        font-weight: 500;
    }

    .status-red {
        color: #f81c1c !important;
        font-weight: 500;
    }

    .status-yellow {
        color: #f08709 !important;
        font-weight: 500;
    }

    .status-orange {
        color: #fc7150 !important;
        font-weight: 500;
    }

    .status-blue {
        color: #004cf9 !important;
        font-weight: 500;
    }

    .bg-light-info {
        background-color: #c4e5f7 !important;
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
                <!--begin::Search form-->
                <div class="card rounded-0 bgi-no-repeat bgi-position-x-end bgi-size-cover banner-inicio">
                    <!--begin::body-->
                    <!-- <div class="card-body container-fluid pt-10 pb-8"> -->
                    <!--begin::Title-->
                    <!-- <div class="d-flex align-items-center"> -->
                    <!-- <h1 class="fw-bold me-3 text-white">Welcome to Digital Quality Management Suite</h1> -->
                    <!-- <span class="fw-bold text-white opacity-50">< ?php echo $dt['First_Name']; ?></span> -->
                    <!-- </div> -->
                    <!--end::Title-->
                    <!--begin::Wrapper-->
                    <!--end::Wrapper-->
                    <!-- </div> -->
                    <!--end::body-->

                </div>
                <!--end::Search form-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Row-->
                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 1-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <!--begin::Title-->
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">MoC Type</span>
                                        </h3>

                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="moc-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="moc-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div style="height: 350px; min-height: 365px;">
                                            <div id="moc-chart" class="donut-chart-j6"></div>
                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 1-->
                            </div>
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 2-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Risk Type</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="risk-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="risk-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="risk-chart" style="height: 350px; min-height: 365px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 2-->
                            </div>
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 3-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Nature of observation</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="nature-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="nature-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_1_chart" style="height: 350px; min-height: 365px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 3-->
                            </div>
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 4-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">NCR Month wise</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="ncr-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="ncr-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_2_chart" style="height: 350px; min-height: 365px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 4-->
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 5-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Calibration Month wise</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="calibration-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="calibration-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_3_chart" style="height: 350px; min-height: 365px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 5-->
                            </div>
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 5-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Customer complaint</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="customer-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="customer-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_4_chart" style="height: 350px; min-height: 365px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 5-->
                            </div>
                        </div>
                        <!--end::Row-->
                        <!--begin::Row-->
                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 7-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Internal Audit</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="internal-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="internal-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_5_chart" style="height: 350px; min-height: 350px;">

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 7-->
                            </div>
                            <div class="col-xl-6">
                                <!--begin::Charts Widget 8-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold fs-3 mb-1">Supplier NCR</span>
                                        </h3>
                                        <!--begin::Toolbar-->
                                        <div class="card-toolbar" data-kt-buttons="true" data-kt-initialized="1">
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary active px-4 me-1" id="supplier-year">This year</a>
                                            <a class="btn btn-sm btn-color-muted btn-active btn-active-primary px-4 me-1" id="supplier-month">Last 3 months</a>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body table-responsive matrixbox">
                                        <!--begin::Chart-->
                                        <div id="kt_charts_widget_6_chart" >

                                        </div>
                                        <!--end::Chart-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Charts Widget 8-->
                            </div>
                        </div>
                        <!--end::Row-->

                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-4">
                                <!--begin::List Widget 1-->
                                <!--begin::List Widget 1-->
                                <div class="card card-xl-stretch mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark">Meeting</span>
                                        </h3>
                                    </div>


                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-5 table-responsive matrixbox" style="padding: 0px 20px;">
                                        <!--begin::Item-->
                                        <?php
                                        $sql_data_meeting = "SELECT * FROM meeting LEFT JOIN meeting_participant ON meeting.id = meeting_participant.Id_meeting 
                                        WHERE meeting.coordinator = '$empId ' OR meeting_participant.Id_meeting_participant = '$empId ' Group by meeting.id  order by meeting.id DESC";
                                        $connect_data_meeting = mysqli_query($con, $sql_data_meeting);
                                        while ($result_data_meeting = mysqli_fetch_assoc($connect_data_meeting)) {
                                            switch ($result_data_meeting['status']) {
                                                case 'Scheduled':
                                                    $bgColor = 'bg-light-info';
                                                    $testColor = 'status-green';
                                                    $badgeColor = 'badge-light-info';
                                                    $icon = '<span class="svg-icon svg-icon-2x svg-icon-warning"><i class="fas fa-stopwatch" style="color: #0ca7e1 !important; font-size: 28px;"></i></span>';

                                                    break;
                                                case 'In Review':
                                                    $bgColor = 'bg-light-primary';
                                                    $testColor = 'status-green';
                                                    $badgeColor = 'badge-light-primary';
                                                    $icon = '<span class="svg-icon svg-icon-2x svg-icon-warning"><i class="fas fa-history" style="color: #0ca7e1 !important; font-size: 28px;"></i></span>';
                                                    break;
                                                case 'Overdue':
                                                    $bgColor = 'bg-light-warning';
                                                    $testColor = 'status-green';
                                                    $badgeColor = 'badge-light-warning';
                                                    $icon = '<span class="svg-icon svg-icon-2x svg-icon-warning"><i class="fas fa-user-clock fs-1" style="color: #fbad4f !important;"></i></span>';
                                                    break;
                                                case 'Cancelled':
                                                    $bgColor = 'bg-light-danger';
                                                    $testColor = 'status-green';
                                                    $badgeColor = 'badge-light-danger';
                                                    $icon = '<span class="svg-icon svg-icon-2x svg-icon-danger"><i class="fas fa-hourglass-start fs-1" style="color: #ff6b6b !important"></i></span>';
                                                    break;
                                                case 'Published':
                                                    $bgColor = 'bg-light-success';
                                                    $testColor = 'status-green';
                                                    $badgeColor = 'badge-light-success';
                                                    $icon = '<span class="svg-icon svg-icon-2x svg-icon-success"><i class="fas fa-clock fs-1 status-green"></i></span>';
                                                    break;
                                            }

                                        ?>
                                            <div class="d-flex align-items-center justify-content-between mb-7">
                                                <!--begin::Symbol-->
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-50px me-5">
                                                        <span class="symbol-label <?php echo $bgColor ?>">
                                                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                                            <?php echo $icon ?>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </div>
                                                    <!--end::Symbol-->
                                                    <!--begin::Text-->
                                                    <div class="d-flex flex-column">
                                                        <a href="#" class="text-dark text-hover-primary fs-6 fw-bold"><?php echo $result_data_meeting['title']; ?></a>
                                                        <!-- <span
                                                        class="text-muted fw-bold">M-002</span> -->
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <span class="badge fs-8 fw-bold <?php echo $badgeColor ?>"><?php echo $result_data_meeting['status']; ?></span>
                                                    <span class="text-muted fw-semibold d-block fs-8 mt-2">
                                                        <?php echo date("dS, M-y", strtotime($result_data_meeting['date'])); ?>
                                                    </span>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::List Widget 1-->
                                <!--end::List Widget 1-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::List Widget 2-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <div class="card-title fw-bold text-dark p-3">
                                            <h3 class="card-title align-items-start flex-column">
                                                Task
                                            </h3>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-2" style="padding: 0px 29px">

                                        <?php
                                        $sql_data = null;
                                        if ($role == '1') {
                                            $sql_data = "SELECT * FROM tasks WHERE is_deleted = 0 order by id DESC";
                                        } else {
                                            $sql_data = "SELECT tasks.* FROM tasks LEFT JOIN sub_tasks ON 
                                            sub_tasks.task_id = tasks.id WHERE tasks.is_deleted = 0  AND tasks.assigned_to = '$empId'
                                            OR tasks.created_by = '$empId'OR sub_tasks.responsible = '$empId' GROUP BY sub_tasks.task_id";
                                        }
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            switch ($result_data['status']) {
                                                case 'Not Started':
                                                    $bgcolor = 'bg-warning';
                                                    $badgeColor = 'badge-light-warning';
                                                    $textColor = 'status-yellow';
                                                    break;
                                                case 'In Progress':
                                                    $bgcolor = 'bg-info';
                                                    $badgeColor = 'badge-light-info';
                                                    $textColor = 'status-blue';
                                                    break;
                                                case 'In Review':
                                                    $bgcolor = 'bg-warning';
                                                    $badgeColor = 'badge-light-warning';
                                                    $textColor = 'status-yellow';
                                                    break;
                                                case 'Completed':
                                                    $bgcolor = 'bg-success';
                                                    $badgeColor = 'badge-light-success';
                                                    $textColor = 'status-green';
                                                    break;
                                                case 'Cancelled':
                                                    $bgcolor = 'bg-danger';
                                                    $badgeColor = 'badge-light-danger';
                                                    $textColor = 'status-red';
                                                    break;
                                            }
                                        ?>
                                            <div class="d-flex align-items-center mb-8">
                                                <!--begin::Bullet-->
                                                <span class="bullet bullet-vertical h-40px <?php echo $bgcolor ?>"></span>
                                                <div class="flex-grow-1 ms-5">
                                                    <a class="text-gray-800 text-hover-primary fw-bold fs-6"><?php echo $result_data['title']; ?></a>
                                                    <span class="text-muted fw-semibold d-block fs-8 mt-2 <?php echo $textColor ?>">
                                                        <?php echo $result_data['task_id']; ?>
                                                    </span>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge fs-8 fw-bold <?php echo $badgeColor ?>"><?php echo $result_data['status']; ?></span>
                                                    <span class="text-muted fw-semibold d-block fs-8 mt-2">
                                                        <?php echo date("dS, M-y", strtotime($result_data['updated_at'])); ?>
                                                    </span>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::List Widget 2-->
                            </div>
                            <div class="col-xl-4">
                                <!--begin::List Widget 3-->
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <!--begin::Header-->
                                    <div class="card-header border-0 pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark">Calibration</span>
                                        </h3>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-0 mt-3" style="padding: 0px 20px">
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center bg-light-warning rounded p-5 mb-7">
                                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                            <span class="svg-icon svg-icon-warning svg-icon-1 me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Title-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Group
                                                    lunch </a>
                                                <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Lable-->
                                            <span class="fw-bold text-warning py-1">+28%</span>
                                            <!--end::Lable-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                            <span class="svg-icon svg-icon-success svg-icon-1 me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Title-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Navigation
                                                </a>
                                                <span class="text-muted fw-semibold d-block">Due in 2 Days</span>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Lable-->
                                            <span class="fw-bold text-success py-1">+50%</span>
                                            <!--end::Lable-->
                                        </div>
                                        <!--end::Item-->
                                        <!--begin::Item-->
                                        <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-7">
                                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                            <span class="svg-icon svg-icon-danger svg-icon-1 me-5">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor"></path>
                                                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--begin::Title-->
                                            <div class="flex-grow-1 me-2">
                                                <a href="#" class="fw-bold text-gray-800 text-hover-primary fs-6">Rebrand
                                                </a>
                                                <span class="text-muted fw-semibold d-block">Due in 5 Days</span>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Lable-->
                                            <span class="fw-bold text-danger py-1">-27%</span>
                                            <!--end::Lable-->
                                        </div>
                                        <!--end::Item-->

                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end:List Widget 3-->
                            </div>
                        </div>
                    </div>
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

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
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
    
    <!--end::Page Custom Javascript-->
    <script>
    
        $(document).ready(function() {
            google.charts.load('current', {
                packages: ['corechart']
            });
            let dates = getThisyearDate();
            console.log(dates);
            getCharts(dates);
        });

        let dataArr = new Array();
        let mocYearValue = new Array();
        let mocMonthValue = new Array();
        let riskYearValue = new Array();
        let riskMonthValue = new Array();

        function getCharts(dates) {
            $.ajax({
                    type: 'POST',
                    url: 'includes/dashboard-charts.php',
                    data: dates
                })
                .done(function(result) {
                    dataArr = JSON.parse(result);

                    //MOC
                    Object.entries(dataArr.moc_type_year_result).forEach(([key, value]) => {
                        value?.length > 0 ? mocYearValue.push([key, value?.length]) : null;
                    });

                    Object.entries(dataArr.moc_type_month_result).forEach(([key, value]) => {
                        value?.length > 0 ? mocMonthValue.push([key, value?.length]) : null;
                    });

                    //Risk
                    Object.entries(dataArr.risk_type_year_result).forEach(([key, value]) => {
                        value?.length > 0 ? riskYearValue.push([key, value?.length]) : null;
                    });

                    Object.entries(dataArr.risk_type_month_result).forEach(([key, value]) => {
                        value?.length > 0 ? riskMonthValue.push([key, value?.length]) : null;
                    });

                    google.charts.setOnLoadCallback(() => drawMocChart(mocYearValue));
                    return google.charts.setOnLoadCallback(() => drawRiskChart(riskYearValue));
                });
        };

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
            var chart = new google.visualization.PieChart(document.getElementById('moc-chart'));
            console.log(chart);
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
            var chart = new google.visualization.PieChart(document.getElementById('risk-chart'));
            chart.draw(data, options);
        }

        function getThisyearDate() {
            let currentDate = new Date();
            let yearStartDate = `${currentDate.getFullYear()}-01-01`;
            let yearEndDate = ("0" + currentDate.getFullYear()).slice(-2) + "-" + ("0" + (currentDate.getMonth() + 1))
                .slice(-
                    2) + "-" + currentDate.getDate();
            let monthStartDate = ("0" + currentDate.getFullYear()).slice(-2) + "-" + ("0" + (currentDate.getMonth() - 2))
                .slice(-2) + "-" + currentDate.getDate();
            let lastDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0);
            let monthEndDate = ("0" + lastDate.getFullYear()).slice(-2) + "-" + ("0" + (lastDate.getMonth() + 1)).slice(-
                2) + "-" + lastDate.getDate();
            return {
                yearStartDate,
                yearEndDate,
                monthStartDate,
                monthEndDate
            }
        }

        $('#moc-year').on('click', function() {
            return google.charts.setOnLoadCallback(() => drawMocChart(mocYearValue));
        })

        $('#moc-month').on('click', function() {
            return google.charts.setOnLoadCallback(() => drawMocChart(mocMonthValue));
        })

        $('#risk-year').on('click', function() {
            return google.charts.setOnLoadCallback(() => drawRiskChart(riskYearValue));
        })

        $('#risk-month').on('click', function() {
            return google.charts.setOnLoadCallback(() => drawRiskChart(riskMonthValue));
        })
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>