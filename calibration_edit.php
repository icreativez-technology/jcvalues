<?php
session_start();
include('includes/functions.php');
$disabled = false;
if (isset($_REQUEST['view'])) {
    $disabled = true;
}
$sqlData = "SELECT * FROM calibrations WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connectData = mysqli_query($con, $sqlData);
$calibrationData = mysqli_fetch_assoc($connectData);
$historySql = "SELECT * FROM calibration_history WHERE calibration_id = '$_REQUEST[id]' AND is_deleted = 0";
$historyConnectData = mysqli_query($con, $historySql);
$historyData =  array();
while ($row = mysqli_fetch_assoc($historyConnectData)) {
    array_push($historyData, $row);
}
$enabledTab = "Issuance";
if (count($historyData) > 0) {
    switch ($calibrationData['calibration_status']) {
        case 'Issuance':
            $enabledTab = 'Receipt';
            break;
        case 'Receipt':
            $enabledTab = 'Calibration Out';
            break;
        case 'Calibration Out':
            $enabledTab = 'Calibration In';
            break;
        case 'Calibration In':
            $enabledTab = 'Issuance';
            break;
    }
}

$issuanceSql = "SELECT calibration_issuance.* , calibration_history.type as type FROM calibration_issuance INNER JOIN calibration_history ON calibration_history.id = calibration_issuance.calibration_history_id WHERE calibration_id = '$_REQUEST[id]' AND type = 'Issuance'";
$issuanceConnectData = mysqli_query($con, $issuanceSql);
$issuanceData =  array();
while ($row = mysqli_fetch_assoc($issuanceConnectData)) {
    array_push($issuanceData, $row);
}

$receiptSql = "SELECT calibration_receipt.* , calibration_history.type as type FROM calibration_receipt INNER JOIN calibration_history ON calibration_history.id = calibration_receipt.calibration_history_id WHERE calibration_id = '$_REQUEST[id]' AND type = 'Receipt'";
$receiptConnectData = mysqli_query($con, $receiptSql);
$receiptData =  array();
while ($row = mysqli_fetch_assoc($receiptConnectData)) {
    array_push($receiptData, $row);
}

$calibOutSql = "SELECT calibration_out.* , calibration_history.type as type FROM calibration_out INNER JOIN calibration_history ON calibration_history.id = calibration_out.calibration_history_id WHERE calibration_id = '$_REQUEST[id]' AND type = 'Calibration Out'";
$calibOutConnectData = mysqli_query($con, $calibOutSql);
$calibOutData =  array();
while ($row = mysqli_fetch_assoc($calibOutConnectData)) {
    array_push($calibOutData, $row);
}

$calibInSql = "SELECT calibration_in.* , calibration_history.type as type FROM calibration_in INNER JOIN calibration_history ON calibration_history.id = calibration_in.calibration_history_id WHERE calibration_id = '$_REQUEST[id]' AND type = 'Calibration In'";
$calibInConnectData = mysqli_query($con, $calibInSql);
$calibInData =  array();
while ($row = mysqli_fetch_assoc($calibInConnectData)) {
    array_push($calibInData, $row);
}
$_SESSION['Page_Title'] = ($disabled == 0) ? "Edit Calibration - " . $calibrationData['instrument_id'] : "View Calibration - " . $calibrationData['instrument_id'];
?>
<script>
    var calibration_id = <?php echo $calibrationData['id']; ?>;
</script>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    .form-height {
        height: 100%;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/calibration_view_list.php">Calibration List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['history'])) ? "" : "active" ?>" id="master-tab" data-bs-toggle="tab" data-bs-target="#master" type="button" role="tab" aria-controls="details" aria-selected="true">Master</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['history'])) ? "active" : "" ?>" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="mitigation" aria-selected="false">History</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['history'])) ? "" : "active show" ?>" id="master" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/calibration_update.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" id="calibration_id" name="calibration_id" value="<?php echo $calibrationData['id'] ?>" />
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Instrument Id</label>
                                                        <input type="text" class="form-control" name="instrument_id" value=<?php echo $calibrationData['instrument_id'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                        <?php if (isset($_GET['exist'])) { ?>
                                                            <small class="text-danger">The instrument id has already been
                                                                taken</small>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Serial Number</label>
                                                        <input type="text" class="form-control" name="serial_no" value=<?php echo $calibrationData['serial_no'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Instrument Name</label>
                                                        <input class="form-control capitalCase" type="text" name="instrument_name" value=<?php echo $calibrationData['instrument_name'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Make</label>
                                                        <input type="text" class="form-control capitalCase" name="make" value=<?php echo $calibrationData['make'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Model No</label>
                                                        <input type="text" class="form-control" name="model_no" value=<?php echo $calibrationData['model_no'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Date of Purchase</label>
                                                        <input type="date" class="form-control" name="date_of_purchase" value=<?php echo $calibrationData['date_of_purchase'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Supplier Name</label>
                                                        <input type="text" class="form-control capitalCase" name="supplier_name" value=<?php echo $calibrationData['supplier_name'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Specification <small>Range</small>
                                                        </label>
                                                        <input type="text" class="form-control" name="specification" value=<?php echo $calibrationData['specification'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Least Count</label>
                                                        <input type="text" class="form-control" name="least_count" value=<?php echo $calibrationData['least_count'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Calibration Done On</label>
                                                        <input type="date" class="form-control" value=<?php echo $calibrationData['calibration_done_on'] ?> name="calibration_done_on" id="calibration_done_on" required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Calibration Frequency<small>(in
                                                                Day's)</small> </label>
                                                        <input type="number" class="form-control" name="calibration_frequency" id="calibration_frequency" value=<?php echo $calibrationData['calibration_frequency'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5 ver-disabled">
                                                        <label class="required">Calibration Due On</label>
                                                        <input type="date" class="form-control" name="calibration_due_on" id="calibration_due_on" value=<?php echo $calibrationData['calibration_due_on'] ?> required readonly <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Storage Location</label>
                                                        <input type="text" class="form-control capitalCase" name="storage_location" value=<?php echo $calibrationData['storage_location'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Usage Condition</label>
                                                        <input type="text" class="form-control capitalCase" name="usage_condition" value=<?php echo $calibrationData['usage_condition'] ?> required <?php echo $disabled ? 'disabled' : '' ?> />
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Asset Type</label>
                                                        <select class="form-control" name="asset_type" <?php echo $disabled ? 'disabled' : '' ?> required>
                                                            <option value="">Please Select</option>
                                                            <option value="Machine" <?php echo ($calibrationData['asset_type'] == "Machine") ? 'selected' : ''; ?>>
                                                                Machine</option>
                                                            <option value="Instrument" <?php echo ($calibrationData['asset_type'] == "Instrument") ? 'selected' : ''; ?>>
                                                                Instrument</option>
                                                        </select>
                                                    </div>
                                                    <?php if (!$disabled) { ?>
                                                        <div class="col-lg-3 mt-5">
                                                            <label class="required">File Upload</label>
                                                            <div class="align-items-center">
                                                                <input type="file" class="form-control" name="file" accept=".pdf">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Uploaded File</label>
                                                        <div class="custom-select mt-3">
                                                            <div class="tag-wrapper">
                                                                <div class="tags">
                                                                    <a href="<?php echo $calibrationData['file_path']; ?>" target="_blank"><?php echo $calibrationData['file_name']; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer mt-6">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <?php if (!$disabled) {
                                                            $label = "Cancel" ?>
                                                            <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">
                                                                Update
                                                            </button>
                                                        <?php } else {
                                                            $label = "Close" ?>
                                                        <?php } ?>
                                                        <a type="button" href="/calibration_view_list.php" class="btn btn-sm btn-secondary ms-2"><?php echo $label; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['history'])) ? "active show" : "" ?>" id="history" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-end mt-4">
                                                <ul class="nav nav-tabs" id="history-tabs" role="tablist" style="border-bottom:none">
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" id="issuance-tab" data-bs-toggle="tab" data-bs-target="#issuance" role="tab" aria-controls="issuance" aria-selected="true">
                                                            Issuance
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" id="receipt-tab" data-bs-toggle="tab" data-bs-target="#receipt" role="tab" aria-controls="receipt" aria-selected="true">
                                                            Receipt
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" id="calibration-out-tab" data-bs-toggle="tab" data-bs-target="#calibration-out" role="tab" aria-controls="calibration-out" aria-selected="true">
                                                            Calibration Out
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" class="btn btn btn-secondary btn-sm ms-2" id="calibration-in-tab" data-bs-toggle="tab" data-bs-target="#calibration-in" role="tab" aria-controls="calibration-in" aria-selected="true">
                                                            Calibration In
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="issuance" role="tabpanel" aria-labelledby="issuance-tab">
                                                    <?php if (!$disabled) { ?>
                                                        <div class="row mt-2 mb-6 ms-2">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#issuanceModal" <?php echo $enabledTab != "Issuance" ? "disabled" : "" ?>>
                                                                        Create
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4">
                                                        <thead>
                                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                                <th class="min-w-135px">Issue Date</th>
                                                                <th class="min-w-150px">Department</th>
                                                                <th class="min-w-100px">Collected By</th>
                                                                <?php if (!$disabled) { ?>
                                                                    <th class="min-w-100px">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fw-bold text-gray-600">
                                                            <?php if ($issuanceData && count($issuanceData) > 0) {
                                                                foreach ($issuanceData as $key => $item) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['issue_date'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            $sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
                                                                            $connect_data = mysqli_query($con, $sql_data);
                                                                            while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
                                                                                if ($result_data_dep['Status'] == 'Active') {
                                                                                    if ($result_data_dep['Id_department'] == $item['department_id']) {
                                                                                        echo $result_data_dep['Department'];
                                                                                    }
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['collected_by']; ?>
                                                                        </td>
                                                                        <?php if (!$disabled) { ?>
                                                                            <td>
                                                                                <button type="button" class="btn btn-link me-3" data-type="<?php echo $item['type'] ?>" data-id="<?php echo $item['id'] ?>" data-history="<?php echo $item['calibration_history_id'] ?>" onclick="openEditPopup(this);">
                                                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="receipt" role="tabpanel" aria-labelledby="receipt-tab">
                                                    <?php if (!$disabled) { ?>
                                                        <div class="row mt-2 mb-6 ms-2">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#receiptModal" <?php echo $enabledTab != "Receipt" ? "disabled" : "" ?>>
                                                                        Create
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4">
                                                        <thead>
                                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                                <th class="min-w-135px">Receipt Date</th>
                                                                <th class="min-w-150px">Received From</th>
                                                                <th class="min-w-100px">Received For</th>
                                                                <th class="min-w-100px">Instrument Condition</th>
                                                                <th class="min-w-100px">Storage Location</th>
                                                                <th class="min-w-100px">Remarks</th>
                                                                <?php if (!$disabled) { ?>
                                                                    <th class="min-w-100px">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fw-bold text-gray-600">
                                                            <?php if ($receiptData && count($receiptData) > 0) {
                                                                foreach ($receiptData as $key => $item) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['receipted_date'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['received_from'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['received_for']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['instrument_condition']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['storage_location']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['remarks']; ?>
                                                                        </td>
                                                                        <?php if (!$disabled) { ?>
                                                                            <td>
                                                                                <button type="button" class="btn btn-link me-3" data-type="<?php echo $item['type'] ?>" data-id="<?php echo $item['id'] ?>" data-history="<?php echo $item['calibration_history_id'] ?>" onclick="openEditPopup(this);">
                                                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="calibration-out" role="tabpanel" aria-labelledby="receipt-tab">
                                                    <?php if (!$disabled) { ?>
                                                        <div class="row mt-2 mb-6 ms-2">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#calibrationOutModal" <?php echo $enabledTab != "Calibration Out" ? "disabled" : "" ?>>
                                                                        Create
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4">
                                                        <thead>
                                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                                <th class="min-w-135px">Send On</th>
                                                                <th class="min-w-150px">Send To</th>
                                                                <th class="min-w-100px">Document Reference</th>
                                                                <th class="min-w-100px">Send For</th>
                                                                <th class="min-w-100px">Instrument Condition</th>
                                                                <th class="min-w-100px">Collected By</th>
                                                                <?php if (!$disabled) { ?>
                                                                    <th class="min-w-100px">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fw-bold text-gray-600">
                                                            <?php if ($calibOutData && count($calibOutData) > 0) {
                                                                foreach ($calibOutData as $key => $item) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['send_on'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['send_to'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['doc_ref']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['send_for']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['instrument_condition']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['collected_by']; ?>
                                                                        </td>
                                                                        <?php if (!$disabled) { ?>
                                                                            <td>
                                                                                <button type="button" class="btn btn-link me-3" data-type="<?php echo $item['type'] ?>" data-id="<?php echo $item['id'] ?>" data-history="<?php echo $item['calibration_history_id'] ?>" onclick="openEditPopup(this);">
                                                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="tab-pane fade" id="calibration-in" role="tabpanel" aria-labelledby="receipt-tab">
                                                    <?php if (!$disabled) { ?>
                                                        <div class="row mt-2 mb-6 ms-2">
                                                            <div class="col-lg-12">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#calibrationInModal" <?php echo $enabledTab != "Calibration In" ? "disabled" : "" ?>>
                                                                        Create
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4">
                                                        <thead>
                                                            <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                                <th class="min-w-135px">Received On</th>
                                                                <th class="min-w-150px">Received From</th>
                                                                <th class="min-w-100px">Instrument Condition</th>
                                                                <th class="min-w-100px">Calibration Result</th>
                                                                <th class="min-w-100px">Calibration Done On</th>
                                                                <th class="min-w-100px">Calibration Due On</th>
                                                                <th class="min-w-100px">Storage Location</th>
                                                                <?php if (!$disabled) { ?>
                                                                    <th class="min-w-100px">Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fw-bold text-gray-600">
                                                            <?php if ($calibInData && count($calibInData) > 0) {
                                                                foreach ($calibInData as $key => $item) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['received_on'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['received_from'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['instrument_condition']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['calibration_result']; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['calibration_done_on'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo date("d-m-y", strtotime($item['calibration_due_on'])); ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $item['storage_location']; ?>
                                                                        </td>
                                                                        <?php if (!$disabled) { ?>
                                                                            <td>
                                                                                <button type="button" class="btn btn-link me-3" data-type="<?php echo $item['type'] ?>" data-id="<?php echo $item['id'] ?>" data-history="<?php echo $item['calibration_history_id'] ?>" onclick="openEditPopup(this);">
                                                                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                                </button>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
    <?php include('includes/scrolltop.php'); ?>
    <?php include('calibration_edit_modal.php'); ?>
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
    <script>
        $('.remove-tag').on('click', function() {
            return $(this).closest('div.tags').remove();
        });

        function getFormattedDate(date = new Date()) {
            return (
                date.getFullYear() +
                "-" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "-" +
                ("0" + date.getDate()).slice(-2)
            );
        }

        function getRequiredDate() {
            let done = $("#calibration_done_on").val();
            let frequency = Number($("#calibration_frequency").val());
            if (done != "" && frequency != "") {
                date = new Date(done);
                const daysAfter = new Date(date.getTime());
                daysAfter.setDate(date.getDate() + frequency);
                $("#calibration_due_on").val(getFormattedDate(daysAfter));
            }
        }

        $(document).ready(function() {
            $("#calibration_frequency").on('input', function() {
                getRequiredDate();
            });
            $("#calibration_done_on").on('input', function() {
                getRequiredDate();
            });
        });

        function openEditPopup(obj) {
            let calibration_history_id = $(obj).data('history');
            let type = $(obj).data('type');
            if (type == "Calibration Out") {
                $("<form>").load('/calibration_out_model.php?calibration_history_id=' + calibration_history_id +
                    '&calibration_id=' + calibration_id,
                    function() {
                        $('#calibrationOutEditModal form').remove();
                        $("#calibrationOutEditModal").append($(this).html());
                        return $('#calibrationOutEditModal').modal('show');
                    });
            }
            if (type == "Calibration In") {
                $("<form>").load('/calibration_in_model.php?calibration_history_id=' + calibration_history_id +
                    '&calibration_id=' + calibration_id,
                    function() {
                        $('#calibrationInEditModal form').remove();
                        $("#calibrationInEditModal").append($(this).html());
                        return $('#calibrationInEditModal').modal('show');
                    });
            }
            if (type == 'Issuance') {
                let calibration_id = $('#calibration_id').val();
                let plant_id = $('#plantId').val();
                $.ajax({
                    url: "includes/calibration_history_modal_content.php",
                    type: "POST",
                    dataType: "html",
                    data: {
                        type: type,
                        id: calibration_history_id,
                        plant_id: plant_id,
                        calibration_id: calibration_id
                    },
                }).done(function(res) {
                    $('#calibration_history_content').append(res);
                    $('#editCalibrationHistory').modal('show');
                });
            }
            if (type == "Receipt") {
                $("<form>").load('/calibration_receipt_model.php?calibration_history_id=' + calibration_history_id +
                    '&calibration_id=' + calibration_id,
                    function() {
                        $('#calibrationReceiptEditModal form').remove();
                        $("#calibrationReceiptEditModal").append($(this).html());
                        return $('#calibrationReceiptEditModal').modal('show');
                    });
            }
        }

        $('.capitalCase').on('keyup', function() {
            console.log("hdj")
            return $(this).val($(this).val().toUpperCase());
        });
    </script>

    <!-- Calibration Out Modal -->
    <div class="modal right fade card-body" id="calibrationOutModal" tabindex="-1" aria-hidden="true">
        <form class="form form-height" action="includes/calibration_out_update.php" method="post" enctype="multipart/form-data">
            <div class="modal-dialog">
                <input type="hidden" name="calibration_id" value="<?php echo $calibrationData['id'] ?>" />
                <input type="hidden" name="calibration_history_id" value="" />
                <input type="hidden" name="calibration_out_id" value="" />
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title right-modal text-white">Calibration Out</h5>
                        <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required">Send on</label>
                                <input type="date" class="form-control" name="send_on" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required">Send to (Supplier)</label>
                                <input type="text" class="form-control" name="send_to" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label>Doc ref<small>(Delivery note)</small></label>
                                <input type="text" name="doc_ref" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label class="required">Send For</label>
                                <input type="text" name="send_for" class="form-control" required>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="required">Instrument condition</label>
                                <input type="text" name="instrument_condition" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Collected by</label>
                                <input type="text" name="collected_by" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label>Attachments <small>Instrument Photo</small></label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Calibration In Modal -->
    <div class="modal right fade card-body" id="calibrationInModal" tabindex="-1" aria-hidden="true">
        <form class="form form-height" action="includes/calibration_in_update.php" method="post" enctype="multipart/form-data">
            <div class="modal-dialog">
                <input type="hidden" name="calibration_id" value="<?php echo $calibrationData['id'] ?>" />
                <input type="hidden" name="calibration_history_id" value="" />
                <input type="hidden" name="calibration_in_id" value="" />
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title right-modal text-white">Calibration In</h5>
                        <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required">Received on</label>
                                <input type="date" class="form-control" name="received_on" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required">Received from</label>
                                <input type="text" class="form-control" name="received_from" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label class="required">Instrument condition</label>
                                <input type="text" class="form-control" name="instrument_condition" required />
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="required">Calibration result</label>
                                <input type="text" class="form-control" name="calibration_result" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label class="required">Calibration done on</label>
                                <input type="date" class="form-control" name="calibration_done_on" required />
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="required">Calibration due on</label>
                                <input type="date" class="form-control" name="calibration_due_on" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label>Doc ref <small>(Inv, Delivery note)</small></label>
                                <input type="text" name="doc_ref" class="form-control">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="required">Storage location</label>
                                <input type="text" name="storage_location" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Attachments <small>Instrument Photo</small></label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="file" accept=".pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Receipt Modal -->
    <div class="modal right fade card-body" id="receiptModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="form" id="receipt-form" action="/includes/calibration_receipt_update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title right-modal text-white">Receipt</h5>
                        <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="calibration_id" value="<?php echo $calibrationData['id'] ?>" />
                        <input type="hidden" name="calibration_history_id" value="" />
                        <input type="hidden" name="calibration_receipt_id" value="" />
                        <div class="row">
                            <div class="col-md-6">
                                <label class="required">Receipted Date</label>
                                <input type="date" class="form-control" name="receipted_date" value="" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required">Received from</label>
                                <input class="form-control" type="text" name="received_from" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-4">
                                <label class="required">Received For</label>
                                <input class="form-control" type="text" name="received_for" required />
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="required">Instrument condition</label>
                                <input class="form-control" type="text" name="instrument_condition" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Storage location</label>
                                <input type="text" name="storage_location" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label class="required">Remarks</label>
                                <input type="text" name="remarks" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <label>Attachments <small>Instrument Photo</small></label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Calibration Out Edit Modal -->
    <div class="modal right fade card-body" id="calibrationOutEditModal" tabindex="-1" aria-hidden="true"></div>
    <!-- Calibration In Edit Modal -->
    <div class="modal right fade card-body" id="calibrationInEditModal" tabindex="-1" aria-hidden="true"></div>
    <!-- Calibration Receipt Edit Modal -->
    <div class="modal right fade card-body" id="calibrationReceiptEditModal" tabindex="-1" aria-hidden="true"></div>
</body>

</html>