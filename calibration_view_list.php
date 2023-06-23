<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "Calibration List";

$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee LEFT JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$department = $roleInfo['Id_department'];
$eligible = ($role == 1 || $department == 5 || $department == 9) ? true : false;

$columns = array('id', 'instrument_id', 'instrument_name', 'storage_location', 'calibration_done_on', 'calibration_due_on', 'status', 'calibration_status');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';

$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);

$sorting_status = isset($_GET['sorting_status']) ? $_GET['sorting_status'] : false;

if ($sorting_status) {
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
} else {
    $asc_or_desc = $sort_order == 'ASC' ? 'asc' : 'desc';
}

$columnsQueryItem =    [
    'id' => 'id',
    'instrument_id' => 'instrument_id',
    'instrument_name' => 'instrument_name',
    'storage_location' => 'storage_location',
    'calibration_done_on' => 'calibration_done_on',
    'calibration_due_on' => 'calibration_due_on',
    'status' => 'status',
    'calibration_status' => 'calibration_status',
];

$activeSql = "SELECT COUNT(*) FROM calibrations WHERE status = 'Active' AND is_deleted ='0'";
$fetchActive = mysqli_query($con, $activeSql);
$activeInfo = mysqli_fetch_assoc($fetchActive);

$rejectedSql = "SELECT COUNT(*) FROM calibrations WHERE status = 'Rejected' AND is_deleted ='0'";
$fetchRejected = mysqli_query($con, $rejectedSql);
$rejectedInfo = mysqli_fetch_assoc($fetchRejected);

$dueSql = "SELECT COUNT(*) FROM calibrations WHERE status = 'Due' AND is_deleted ='0'";
$fetchDueIn = mysqli_query($con, $dueSql);
$dueInfo = mysqli_fetch_assoc($fetchDueIn);

$delaySql = "SELECT COUNT(*) FROM calibrations WHERE status = 'Delay' AND is_deleted ='0'";
$fetchDelay = mysqli_query($con, $delaySql);
$delayInfo = mysqli_fetch_assoc($fetchDelay);



/* for Filter */
$currentURI = $_SERVER['REQUEST_URI'];

  $page = 1;
    if (isset($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
    }

    $filterColumns = ['audit_type', 'audit_area', 'uniq_id', 'audit_std', 'audit_id', 'dept', 'create_dt'];

    $resetFilterStatus = true;
    $createDt=$startDt=$endDt=$auditId=$auditArea='';
    $auditType = isset($_GET['audit_type']) ? $_GET['audit_type'] : '';
    $auditStd = isset($_GET['audit_std']) ? $_GET['audit_std'] : '';
    // $auditId = isset($_GET['audit_id']) ? $_GET['audit_id'] : '';
    $uniqID = isset($_GET['uniq_id']) ? $_GET['uniq_id'] : '';
    $deptId = isset($_GET['dept']) ? $_GET['dept'] : '';

    // $createDt = isset($_GET['create_dt']) ? date('Y-m-d', strtotime($_GET['create_dt'])) : '';
    if(isset($_GET['create_dt'])){
    $dates = DateTime::createFromFormat('d-m-y', $_GET['create_dt']);
    $createDt = $dates->format('Y-m-d');
    }

    if(isset($_GET['audit_id'])){
    $sql = "SELECT * FROM audit_management_list WHERE unique_id = '$_GET[audit_id]'";
    $fetch = mysqli_query($con, $sql);
    $search1 = mysqli_fetch_assoc($fetch);
    $auditId=$search1['id'];
    }

    // $ids = array_filter(array_unique(array_map('intval', (array)$ids)));
    // if ($ids) {
    // $query = 'SELECT * FROM `galleries` WHERE `id` IN ('.implode(',', $ids).');';
    // }

    if(isset($_GET['audit_area'])){
    $sql = "SELECT * From external_and_customer_audits where audit_area LIKE '%$_GET[audit_area]%'";
    $fetch = mysqli_query($con, $sql);
    //$search2 = mysqli_fetch_assoc($fetch);
    while ($result_data = mysqli_fetch_assoc($fetch)) {
        echo $result_data;
    }
    //$auditArea=$search2['audit_id'];
    }



  if ($auditType || $uniqID || $auditStd || $auditArea || $deptId || $auditId || $createDt) {
        $resetFilterStatus = false;
    }


?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- < ?php include('includes/admin_check.php'); ?> -->
<style>
.table-responsive {
/*    overflow: inherit !important;*/
}

.table-responsive table td {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <div class="row mt-2">
                            <div class="col-lg-3 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-success shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-pencil text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <p class="m-0">Active</p>
                                                <p class="m-0 text-end"><?php echo $activeInfo['COUNT(*)'] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fa fa-info-circle text-secondary me-2"></i>
                                            <p class="m-0 text-secondary">&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-danger shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-envelope-open text-danger fs-4"></i>
                                            </div>
                                            <div>
                                                <p class="m-0">Rejected</p>
                                                <p class="m-0 text-end"><?php echo $rejectedInfo['COUNT(*)'] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fa fa-info-circle text-secondary me-2"></i>
                                            <p class="m-0 text-secondary">&nbsp;</p>
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
                                                <p class="m-0">Due</p>
                                                <p class="m-0 text-end"><?php echo $dueInfo['COUNT(*)'] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fa fa-info-circle text-secondary me-2"></i>
                                            <p class="m-0 text-secondary">&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mt-2">
                                <div class="card border-0 border-top border-3 border-warning shadow">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-hourglass-start text-warning fs-4"></i>
                                            </div>
                                            <div>
                                                <p class="m-0">Delay</p>
                                                <p class="m-0 text-end"><?php echo $delayInfo['COUNT(*)'] ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-2 d-flex align-items-center">
                                            <i class="fa fa-info-circle text-secondary me-2"></i>
                                            <p class="m-0 text-secondary">&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="row mt-2 mb-4 ms-2">
                                <div class="col-3">
                                    <!-- <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-1 position-absolute ms-3 mt-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-filemanager-table-filter="search"
                                            class="form-control form-control-solid w-250px ps-15"
                                            placeholder="Search By ID or Name" id="termino" name="termino" />
                                    </div> -->
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <div class="d-flex justify-content-end mr-2">
                                        <button id="resetFilter" onclick="resetFilter();" class="btn btn-sm btn-primary mt-4 me-2" <?php echo $resetFilterStatus ? 'disabled' : ''; ?>>
                                            Reset Filter
                                        </button>
                                        <button id="btnExport" onclick="fnExcelReport('Calibration.xlsx');"
                                            class="btn btn-sm btn-primary mt-4 me-2">
                                            Export
                                        </button>
                                        <?php if ($eligible) { ?>
                                        <a href="/calibration_add.php" class="btn btn-sm btn-primary mt-4 me-3">
                                            Create
                                        </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive custom-search-nz" id="result-busqueda">
                            </div>
                            <div class="card-body pt-0 table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5"
                                    id="kt_department_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 text-uppercase gs-0" data-height="30">
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/calibration_view_list.php?a=calibration&column=instrument_id&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Instrument Id<i
                                                        class="fas fa-sort<?php echo $column == 'instrument_id' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                               <span style='font-size: 11px;'> Instrument ID</span>
                                                <i class="fas fa-sm fa-filter btn" data-toggle="popover_uniq_id" id="uniq_id"></i>
                                            </th>
                                            <th class="min-w-150px">
                                                Created At
                                                  <i class="fas fa-filter fa-sm btn" data-toggle="popover_create_dt" id="create_dt"></i>
                                            </th>
                                            <th class="min-w-200px">
                                               <!--  <a
                                                    href="/calibration_view_list.php?a=calibration&column=instrument_name&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Instrument Name<i
                                                        class="fas fa-sort<?php echo $column == 'instrument_name' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Instrument Name
                                            </th>
                                            <th class="min-w-150px">
                                               <!--  <a
                                                    href="/calibration_view_list.php?a=calibration&column=storage_location&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Location<i
                                                        class="fas fa-sort<?php echo $column == 'storage_location' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Location
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/calibration_view_list.php?a=calibration&column=calibration_done_on&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Cal Done On<i
                                                        class="fas fa-sort<?php echo $column == 'calibration_done_on' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Cal Done On
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/calibration_view_list.php?a=calibration&column=calibration_due_on&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Cal Due On<i
                                                        class="fas fa-sort<?php echo $column == 'calibration_due_on' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Cal Due On
                                            </th>
                                            <th class="min-w-150px">
                                                <!-- <a
                                                    href="/calibration_view_list.php?a=calibration&column=calibration_status&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Movements<i
                                                        class="fas fa-sort<?php echo $column == 'calibration_status' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Movements
                                            </th>
                                            <th class="min-w-100px">
                                               <!--  <a
                                                    href="/calibration_view_list.php?a=calibration&column=status&order=<?php echo $asc_or_desc; ?>&sorting_status=true">
                                                    Status<i
                                                        class="fas fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i>
                                                </a> -->
                                                Status
                                            </th>

                                            <th class="min-w-100px text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <?php
                                        $sql_data = "SELECT * FROM calibrations WHERE is_deleted = 0 AND calibrations.instrument_id LIKE '%$uniqID%' AND calibrations.created_at LIKE '%$createDt%' order by " . $columnsQueryItem[$column] . " " . $sort_order;
                                        $connect_data = mysqli_query($con, $sql_data);
                                        $pagination_ok = 1;
                                        $num_rows = mysqli_num_rows($connect_data);
                                        $page_register_count = 0;
                                        $max_registers_page = (isset($_GET['limit'])) ? $_GET['limit'] : 50;
                                        if ($_REQUEST['page'] && $_REQUEST['page'] != 1) {
                                            $this_page = $_REQUEST['page'] - 1;
                                            $pass_registers = $max_registers_page * $this_page;
                                            $registers_off = 0;
                                        } else {
                                            $this_page = 0;
                                            $pass_registers = 0;
                                            $registers_off = 0;
                                        }
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {

                                            $calibInSql = "SELECT * FROM calibration_in LEFT JOIN calibration_history ON calibration_history.id = calibration_in.calibration_history_id WHERE calibration_history.calibration_id = '$result_data[id]' ORDER BY calibration_in.id DESC LIMIT 1";
                                            $calibInConnection = mysqli_query($con, $calibInSql);
                                            $calibInInfo = mysqli_fetch_assoc($calibInConnection);
                                            $calibDueOn = $result_data['calibration_due_on'];
                                            $calibDoneOn = $result_data['calibration_done_on'];
                                            $storageLocation = $result_data['storage_location'];
                                            $filePath = $result_data['file_path'];
                                            if ($calibInConnection->num_rows != 0) {
                                                $calibDueOn = $calibInInfo['calibration_due_on'];
                                                $calibDoneOn = $calibInInfo['calibration_done_on'];
                                                $filePath = $calibInInfo['file_path'];
                                                $storageLocation = $calibInInfo['storage_location'];
                                            }
                                            $validationDate = $result_data['asset_type'] == "Machine" ? date('Y-m-d', strtotime('-30 day', strtotime($calibDueOn))) : date('Y-m-d', strtotime('-10 days', strtotime($calibDueOn)));
                                            if ((date("Y-m-d", strtotime($validationDate)) < date("Y-m-d", strtotime("today"))) && $result_data['status'] != "Rejected") {
                                                $result_data['status'] == "Due";
                                                $updateQuery = "UPDATE calibrations SET status = 'Due' WHERE id = '$result_data[id]'";
                                                $connectData = mysqli_query($con, $updateQuery);
                                            }
                                            if ((date("Y-m-d", strtotime($calibDueOn)) < date("Y-m-d", strtotime("today"))) && $result_data['status'] != "Rejected") {
                                                $result_data['status'] == "Delay";
                                                $updateQuery = "UPDATE calibrations SET status = 'Delay' WHERE id = '$result_data[id]'";
                                                $connectData = mysqli_query($con, $updateQuery);
                                            }
                                            if ($pagination_ok == 1) {
                                                if ($registers_off != $pass_registers) {
                                                    $registers_off++;
                                                    continue;
                                                }
                                                if ($page_register_count != $max_registers_page) {
                                                    $page_register_count++;
                                                } else {
                                                    break;
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $result_data['instrument_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($result_data['created_at'])); ?>
                                            </td>
                                            <td>
                                                <?php echo $result_data['instrument_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo  $storageLocation; ?>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($calibDoneOn)); ?>
                                            </td>
                                            <td>
                                                <?php echo date("d-m-y", strtotime($calibDueOn)); ?>
                                            </td>

                                            <?php $class = (($result_data['calibration_status'] == "Issuance") ? "status-active" : "status-danger"); ?>
                                            <td>
                                                <?php echo '<div class="' . $class . '">' . $result_data["calibration_status"] . '</div>'; ?>
                                            </td>
                                            <?php
                                                switch ($result_data['status']) {
                                                    case 'Delay':
                                                        $cl = 'status-info';
                                                        break;
                                                    case 'Due':
                                                        $cl = 'status-warning';
                                                        break;
                                                    case 'Rejected':
                                                        $cl = 'status-danger';
                                                        break;
                                                    case 'Active':
                                                        $cl = 'status-active';
                                                        break;
                                                }
                                                ?>
                                            <td>
                                                <?php echo '<div class="' . $cl . '">' . $result_data["status"] . '</div>'; ?>
                                            </td>
                                            <td>
                                                <div
                                                    class="d-flex justify-content-end align-items-center px-3 column-gap">
                                                    <div class="ms-2">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-light btn-active-light-primary view-menu"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect x="10" y="10" width="4" height="4" rx="2"
                                                                        fill="currentColor"></rect>
                                                                    <rect x="17" y="10" width="4" height="4" rx="2"
                                                                        fill="currentColor"></rect>
                                                                    <rect x="3" y="10" width="4" height="4" rx="2"
                                                                        fill="currentColor"></rect>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4 view-menu-content"
                                                            data-kt-menu="true">
                                                            <div class="menu-item px-3">
                                                                <a href="/calibration_edit.php?id=<?php echo $result_data['id']; ?>&view"
                                                                    class="menu-link px-3">
                                                                    View
                                                                </a>
                                                            </div>
                                                            <?php if ($eligible) { ?>
                                                            <div class="menu-item px-3">
                                                                <a href="calibration_edit.php?id=<?php echo $result_data['id']; ?>"
                                                                    class="menu-link px-3 set-url">Edit</a>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="menu-item px-3">
                                                                <a href="<?php echo $filePath; ?>" target="_blank"
                                                                    class="menu-link px-3">
                                                                    PDF
                                                                </a>
                                                            </div>
                                                            </a>
                                                            <?php if ($role == 1) { ?>
                                                            <div class="menu-item px-3">
                                                                <a class="menu-link px-3 set-url"
                                                                    href="/includes/calibration_delete.php?id=<?php echo $result_data['id']; ?>">Delete</a>
                                                            </div>
                                                            <?php } ?>
                                                            <?php if ($result_data['status'] != 'Rejected') { ?>
                                                            <div class="menu-item px-3">
                                                                <a class="menu-link px-3"
                                                                    href="/includes/calibration_status_update.php?pg_id=<?php echo $result_data['id']; ?>">Reject</a>
                                                            </div>
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-between">
                                    <div class="ms-3 pageRange">
                                        <select id="pageRange" name="pageRange" class="form-select">
                                            <option value="10"
                                                <?php echo ($max_registers_page == 10) ? 'selected' : ''; ?>>10</option>
                                            <option value="25"
                                                <?php echo ($max_registers_page == 25) ? 'selected' : ''; ?>>25</option>
                                            <option value="50"
                                                <?php echo ($max_registers_page == 50) ? 'selected' : ''; ?>>50</option>
                                            <option value="100"
                                                <?php echo ($max_registers_page == 100) ? 'selected' : ''; ?>>100
                                            </option>
                                        </select>
                                    </div>
                                    <div class="me-6">
                                        <ul class="pagination pagination-circle pagination-outline">
                                            <?php
                                            if ($pagination_ok == 1) {
                                                $num_pages = $num_rows / $max_registers_page;
                                                $total_pages = ceil($num_pages);
                                                if (!$_REQUEST['page']) {
                                                    $_REQUEST['page'] = 1;
                                                }
                                                $current_page = $_REQUEST['page'];
                                            }
                                            ?>
                                            <input type="hidden" id="total_pages" value="<?php echo $total_pages ?>">
                                            <input type="hidden" id="current_page" value="<?php echo $current_page ?>">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
    </div>
     <?php foreach ($filterColumns as $value) { ?>
        <div id="<?php echo 'popover_' . $value . '_content_wrapper' ;?>"  style="display: none">
            <div class="form-group mb-2">
                <input type="text" class="form-control" placeholder="Search..." id="<?php echo $value . '_filter'; ?>" value="<?php echo isset($_GET[$value]) ? $_GET[$value] : ''; ?>">
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div class="ms-2" id="<?php echo $value . '_cancel'; ?>">
                   <i class="btn far fa-times-circle fa-2x text-danger"></i>
                </div>
                <div class="ms-2" id="<?php echo $value . '_confirm'; ?>">
                  <i class="btn far fa-check-circle fa-2x text-success"></i>
                </div>
            </div>
        </div>
    <?php }  ?>
    <?php include('includes/scrolltop.php'); ?>
    <script>
    var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
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
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="JS/buscar_calibration_view_list.js"></script>

     <script>

        /* Filter Start */
        let qrCodeId = null;
        let base_url = window.location.origin;
        let id = null;
        let fileName = "";
        const filterColumns = <?php echo json_encode($filterColumns); ?>;


         $(document).ready(function(){
            // console.log('welcome');

            for (let i = filterColumns.length - 1; i >= 0; i--) {

                let popoverVal = "popover_" + filterColumns[i];
                let contentWrapperVal = 'popover_' + filterColumns[i] + '_content_wrapper'
                let filterInput = filterColumns[i] + '_filter';

                $('[data-toggle="' + popoverVal + '"]').popover({
                    sanitize: false,
                    html: true,
                    trigger: 'click',
                    placement: 'bottom',
                    content: function () {
                        return $('#' + contentWrapperVal).html();
                    }
                });

                let filterInputVal = $('#' + filterInput).val();
                let urlFilterValues = (window.location.search).slice(1);

                $(document).on('change', '#' + filterInput, function() {
                    filterInputVal = $(this).val();
                });

                 $(document).on('click', '#' + filterColumns[i] + '_cancel', function() {
                    $('[data-toggle="popover_' + filterColumns[i] + '"]').popover("hide");
                 });

                $(document).on('click', '#' + filterColumns[i] + '_confirm', function() {
                    const urlParams = urlFilterValues.split('&');
                    const pathName = window.location.pathname;
                    let url = base_url + pathName + '?';
                    let status = true;

                    for (let j = 0; j < urlParams.length; j++) {
                        let item = urlParams[j]

                        if ((item.split('='))[0] == filterColumns[i] ) {
                            item = filterColumns[i] + '=' + filterInputVal;
                            status = false;
                        }

                        if (j > 0) {
                            url += '&' + item;
                        } else {
                            url += item;
                        }
                    }

                    if (status) {
                        url += '&' + filterColumns[i] + '=' + filterInputVal;
                    }

                    window.location.href = url;
                });
            }
        });

        function resetFilter() {
            window.location.href = base_url + '/calibration_view_list.php?a=11';
        }

</script>

    <script>
    const element = document.querySelector(".pagination");
    let totalPages = Number($("#total_pages").val());
    let page = Number($("#current_page").val());
    if (totalPages > 0) {
        element.innerHTML = createPagination(totalPages, page);
    }

    function createPagination(totalPages, page) {
        var pageLimit=document.getElementById("pageRange").value;
        var asc_or_desc = "<?php echo $asc_or_desc; ?>";
        var sorting_status = "<?php echo $sorting_status  ?>"
        if (sorting_status) {
            asc_or_desc = asc_or_desc == 'asc' ? "desc" : 'asc';
        } else {
            asc_or_desc = asc_or_desc == 'asc' ? "asc" : 'desc';
        }
        let liTag = '';
        let active;
        let beforePage = page - 2;
        let afterPage = page + 2;
        let prevLabel = "<";
        let nextLabel = ">";
        let firstPage = "<<";
        let lastPage = ">>";
        liTag +=
            `<li class="page-item m-1"><a href="/calibration_view_list.php?a=calibration&page=${1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${firstPage}</a></li>`;
        if (page > 1) {
            liTag +=
                `<li class="page-item m-1"><a href="/calibration_view_list.php?a=calibration&page=${page - 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${prevLabel}</a></li>`;
        }
        if (page == totalPages) {
            beforePage = beforePage - 2;
        } else if (page == totalPages - 1) {
            beforePage = beforePage - 1;
        }
        if (page == 1) {
            afterPage = afterPage + 2;
        } else if (page == 2) {
            afterPage = afterPage + 1;
        }
        beforePage = beforePage > 0 ? beforePage : 1;
        for (var plength = beforePage; plength <= afterPage; plength++) {
            if (plength > totalPages) {
                continue;
            }
            if (plength == 0) {
                plength = plength + 1;
            }
            if (page == plength) {
                active = "active";
            } else {
                active = "";
            }
            liTag +=
                `<li class="page-item m-1 ${active}"><a href="/calibration_view_list.php?a=calibration&page=${plength}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${plength}</a></li>`;
        }
        if (page < totalPages) {
            liTag +=
                `<li class="page-item m-1"><a href="/calibration_view_list.php?a=calibration&page=${page + 1}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${nextLabel}</a></li>`;
        }
        liTag +=
            `<li class="page-item m-1"><a href="/calibration_view_list.php?a=calibration&page=${totalPages}&limit=${pageLimit}&column=<?php echo $column; ?>&order=${asc_or_desc}" class="page-link">${lastPage}</a></li>`;
        element.innerHTML = liTag;
        return liTag;
    }

    function fnExcelReport(fileName) {
        let table = document.getElementsByTagName("table");
        return TableToExcel.convert(table[0], {
            name: fileName,
            sheet: {
                name: 'Sheet 1'
            }
        });
    }
    </script>
</body>

</html>