<?php
session_start();
include 'includes/functions.php';
$disabled = false;
if (isset($_REQUEST['view'])) {
    $disabled = true;
}

$sql = "SELECT * FROM customer_complaints WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sql);
$complaintData = mysqli_fetch_assoc($connectData);

$emailSql = "SELECT Email FROM Basic_Customer WHERE Id_customer = '$complaintData[customer_id]'";
$emailConnect = mysqli_query($con, $emailSql);
$emailInfo = mysqli_fetch_assoc($emailConnect);
$email = $emailInfo['Email'];

$team_membersqlData = "SELECT member_id, First_Name, Last_Name FROM customer_complaint_d1_d2_team LEFT JOIN Basic_Employee ON customer_complaint_d1_d2_team.member_id = Basic_Employee.Id_employee WHERE customer_complaint_id = '$complaintData[id]' AND customer_complaint_d1_d2_team.is_deleted = 0";
$team_membersData = mysqli_query($con, $team_membersqlData);
$team_members =  array();
while ($row = mysqli_fetch_assoc($team_membersData)) {
    array_push($team_members, $row['member_id']);
}
$preliminarySql = "SELECT * FROM preliminary_analysis_d3 WHERE is_deleted = 0 AND customer_complaint_id = '$_REQUEST[id]'";
$preliminaryData = mysqli_query($con, $preliminarySql);
$preliminary = mysqli_fetch_assoc($preliminaryData);

$corrections =  array();
if ($preliminary != null) {
    $correctionSqlData = "SELECT * FROM customer_complaint_correction_d3 WHERE preliminary_analysis_d3_id = '$preliminary[id]'";
    $correctionData = mysqli_query($con, $correctionSqlData);
    while ($row = mysqli_fetch_assoc($correctionData)) {
        array_push($corrections, $row);
    }
}
$d4Disabled = ($preliminary != null && count($corrections) > 0) ? false : true;

$cASql = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$cAConnectData = mysqli_query($con, $cASql);
$cAnalysisData =  array();
while ($row = mysqli_fetch_assoc($cAConnectData)) {
    array_push($cAnalysisData, $row);
}

$_SESSION['Page_Title'] = ($disabled) ? "View Customer Complaint - " . $complaintData['complaint_id'] : "Edit Customer Complaint - " . $complaintData['complaint_id'];

$correctiveActionSqlData = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$correctiveActionSqlConnectData = mysqli_query($con, $correctiveActionSqlData);
$correctiveAction =  array();
while ($row = mysqli_fetch_assoc($correctiveActionSqlConnectData)) {
    array_push($correctiveAction, $row);
}
$d6d7Disabled = true;
if ($correctiveAction && count($correctiveAction) > 0) {
    $sql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0 AND status = 'Completed'";
    $connectData = mysqli_query($con, $sql);
    $d6d7Disabled = count($correctiveAction) != $connectData->num_rows ? true : false;
}
$d8Disabled = true;
if ($correctiveAction && count($correctiveAction) > 0) {
    $sql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0 AND verified = '1'";
    $connectData = mysqli_query($con, $sql);
    $d8Disabled = count($correctiveAction) != $connectData->num_rows ? true : false;
}
$whySqlData = "SELECT * FROM customer_complaint_d4_why_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$whySqlConnectData = mysqli_query($con, $whySqlData);
$whyData =  array();
while ($row = mysqli_fetch_assoc($whySqlConnectData)) {
    array_push($whyData, $row);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php'; ?>
<style>
    .list-add {
        background-color: transparent;
        padding: 2px 5px;
        border-radius: 50%;
        font-size: 12px;
        color: #fff !important;
        cursor: pointer;
    }

    .list-add i {
        color: #fff;
    }

    .tab-disabled,
    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    #correction-form,
    #ca-form,
    #why-form,
    #c-action-form {
        height: 100%;
    }

    #ca-form {
        height: 100%;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include 'includes/aside-menu.php'; ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'includes/header.php'; ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/complaints.php">Complaints</a> » <a href="/customer_complaint_view_list.php">Customer Complaint List</a> »
                                <?php echo $_SESSION['Page_Title']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['d3']) || isset($_GET['d4']) || isset($_GET['d6']) || isset($_GET['d8'])) ? "" : "active" ?>" id="complaint_details_tab" data-bs-toggle="tab" data-bs-target="#complaint_details" type="button" role="tab" aria-controls="complaint_details" aria-selected="true">Complaint Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['d3'])) ? "active" : "" ?>" id="d3-tab" data-bs-toggle="tab" data-bs-target="#d3" type="button" role="tab" aria-controls="mitigation" aria-selected="false">D3</button>
                            </li>
                            <li class="nav-item <?php echo $d4Disabled ? "tab-disabled" : "" ?>" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['d4'])) ? "active" : "" ?>" id="d4-tab" data-bs-toggle="tab" data-bs-target="#d4" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $d4Disabled ? "disabled" : "" ?>>D4</button>
                            </li>
                            <li class="nav-item <?php echo $d6d7Disabled ? "tab-disabled" : "" ?>" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['d6'])) ? "active" : "" ?>" id="d6-d7-tab" data-bs-toggle="tab" data-bs-target="#d6-d7" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $d6d7Disabled ? "disabled" : "" ?>>D6-D7</button>
                            </li>
                            <li class="nav-item <?php echo $d8Disabled ? "tab-disabled" : "" ?>" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['d8'])) ? "active" : "" ?>" id="d8-tab" data-bs-toggle="tab" data-bs-target="#d8" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $d8Disabled ? "disabled" : "" ?>>D8</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['d3']) || isset($_GET['d4']) || isset($_GET['d6']) || isset($_GET['d8'])) ? "" : "active show" ?>" id="complaint_details" role="tabpanel" aria-labelledby="complaint_details_tab">
                                <div class="card card-flush">
                                    <form class="form" action="/includes/customer_complaint_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Customer Name</label>
                                                        <select class="form-control" name="customer_id" id="customer_name" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Customer";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_customer']; ?>" <?php echo ($complaintData['customer_id'] == $result_data['Id_customer']) ? "selected" : ""; ?>>
                                                                        <?php echo $result_data['Customer_Name']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2 mt-5">
                                                        <label class="required">Order Ref Number</label>
                                                        <input type="text" name="customer_order_ref" value="<?php echo $complaintData['customer_order_ref'] ?>" class="form-control" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-2 mt-5">
                                                        <label class="required">Internal Order Ref</label>
                                                        <input type="text" name="internal_order_ref" value="<?php echo $complaintData['internal_order_ref'] ?>" class="form-control" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-2 mt-5">
                                                        <label class="required">Item No</label>
                                                        <input type="text" name="item_no" value="<?php echo $complaintData['item_no'] ?>" class="form-control" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Product Details</label>
                                                        <input type="text" name="product_details" value="<?php echo $complaintData['product_details'] ?>" class="form-control" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Nature of Complaint</label>
                                                        <select class="form-control" name="nature_of_complaint_id" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                            <option value="">Please select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Customer_Nature_of_Complaints";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_customer_nature_of_complaints']; ?>" <?php echo ($complaintData['nature_of_complaint_id'] == $result_data['Id_customer_nature_of_complaints']) ? "selected" : ""; ?>>
                                                                    <?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Complaint Recieved On</label>
                                                        <input type="date" id="date" class="form-control" name="complaint_date" value="<?php echo $complaintData['complaint_date'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5 ver-disabled">
                                                        <label class="required">Email</label>
                                                        <input class="form-control" id="email" value="<?php echo $email ?>" readonly <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label>Phone</label>
                                                        <input name="phone" value="<?php echo $complaintData['phone'] ?>" class="form-control" <?php echo ($disabled) ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 mt-5">
                                                        <label class="required">Complaint Details</label>
                                                        <textarea type="text" rows="2" class="form-control" name="complaint_details" value="<?php echo $complaintData['complaint_details'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?>><?php echo $complaintData['complaint_details'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <?php if (!$disabled) { ?>
                                                        <div class="col-lg-3 mt-5">
                                                            <label>File Upload</label>
                                                            <div class="d-flex align-items-center">
                                                                <input type="file" class="form-control" name="files[]" accept=".pdf" multiple>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php
                                                    $sql_data = "SELECT * FROM customer_complaint_files WHERE customer_complaint_id = '$complaintData[id]' AND is_deleted = 0";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    if (mysqli_num_rows($connect_data)) {
                                                    ?>
                                                        <div class="col-lg-9 mt-5">
                                                            <label>Uploaded Files</label>
                                                            <div class="custom-select mt-2">
                                                                <div class="tag-wrapper">
                                                                    <?php
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                    ?>
                                                                        <div class="tags">
                                                                            <?php if (!$disabled) { ?>
                                                                                <span class="remove-tag"></span>
                                                                            <?php } ?>
                                                                            <a href="<?php echo $result_data['file_path']; ?>" target="_blank"><?php echo $result_data['file_name']; ?></a>
                                                                            <input type="hidden" class="form-control" name="existingFiles[]" value="<?php echo $result_data['id']; ?>">
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                    D1-D2
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mt-5">
                                                        <label class="required">Details of Solution</label>
                                                        <input type="text" class="form-control" name="details_of_solution" value="<?php echo $complaintData['details_of_solution'] ?>" required <?php echo ($disabled) ? "disabled" : "" ?> />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mt-5">
                                                        <label class="required">Team members</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Participants" name="team_members[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple <?php echo ($disabled) ? "disabled" : "" ?>>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee WHERE Status='Active';";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $team_members)) ? 'selected' : ''; ?>>
                                                                    <?php echo $result_data['First_Name']; ?>
                                                                    <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <?php if ($disabled) { ?>
                                                            <a type="button" href="javascript:history.back(-1)" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                        <?php } else { ?>
                                                            <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                            <a type="button" href="javascript:history.back(-1)" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="customer_complaint_id" value="<?php echo $complaintData['id'] ?>" />
                                        <input type="hidden" class="form-control" name="complaint_id" value="<?php echo $complaintData['complaint_id'] ?>" />
                                    </form>
                                </div>
                            </div>

                            <!--D3-->
                            <div class="tab-pane fade <?php echo (isset($_GET['d3'])) ? "active show" : "" ?>" id="d3" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/customer_complaint_d3_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="container-full customer-header d-flex justify-content-between">
                                                Preliminary Analysis
                                            </div>
                                            <input type="hidden" name="complaint_id" value="<?php echo $_REQUEST['id'] ?>">
                                            <input type="hidden" name="preliminary_analysis_id" value="<?php echo ($preliminary != null) ? $preliminary['id'] : '' ?>">
                                            <div class="form-group row">
                                                <div class="col-lg-12 mt-5">
                                                    <label class="required">Indicative Cause of Non Conformance</label>
                                                    <textarea class="form-control" type="text" name="indicative_cause_of_non_conformance" rows="3" value="<?php echo ($preliminary != null) ? $preliminary['indicative_cause_of_non_conformance'] : '' ?>" required <?php echo ($disabled) ? "disabled" : "" ?>><?php echo ($preliminary != null) ? $preliminary['indicative_cause_of_non_conformance'] : '' ?></textarea>
                                                </div>
                                            </div>
                                            <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                Correction
                                                <?php if (!$disabled) { ?>
                                                    <a class="list-add" id="list-add" data-bs-toggle="modal" data-bs-target="#addNewCorrection"><i class="fa fa-plus"></i></a>
                                                <?php } ?>
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-135px">Correction</th>
                                                        <th class="min-w-150px">Who</th>
                                                        <th class="min-w-100px">when</th>
                                                        <th class="min-w-100px">How</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <?php if (!$disabled) { ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600" id="list-table">
                                                    <input type="hidden" name="dataArr" id="dataArr" value='<?php echo json_encode($corrections) ?>'>
                                                    <?php if ($corrections && count($corrections) > 0) {
                                                        foreach ($corrections as $key => $correction) { ?>
                                                            <tr id="<?php echo $key ?>">
                                                                <td>

                                                                    <input class="form-control" type="hidden" name="correction_d3[]" value="<?php echo $correction['correction']; ?>" required>
                                                                    <?php echo $correction['correction']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $sql_data = "SELECT * FROM Basic_Employee WHERE status = 'Active'";
                                                                    $connect_data = mysqli_query($con, $sql_data);
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                        if ($result_data['Status'] == 'Active' && $correction['who'] == $result_data['Id_employee']) {
                                                                            echo $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <input class="form-control" type="hidden" name="who_d3[]" value="<?php echo $correction['who']; ?>" required>
                                                                </td>
                                                                <td>
                                                                    <?php echo $correction['when_date']; ?>
                                                                    <input class="form-control" type="hidden" name="when_d3[]" value="<?php echo $correction['when_date']; ?>" required>
                                                                </td>
                                                                <td>
                                                                    <?php echo $correction['how']; ?>
                                                                    <input class="form-control" type="hidden" name="how_d3[]" value="<?php echo $correction['how']; ?>" required>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $statusClass = ($correction['status'] == 'Open') ? 'badge badge-light-danger' : 'badge badge-light-success';
                                                                    echo '<span class="' . $statusClass . '">' . $correction['status'] . '</span>';
                                                                    ?>
                                                                    <input class="form-control" type="hidden" name="status_d3[]" value="<?php echo $correction['status']; ?>" required>
                                                                </td>
                                                                <?php if (!$disabled) { ?>
                                                                    <td class="list-row" style="vertical-align:middle">
                                                                        <a class="list-edit cursor-pointer me-2" data-id="<?php echo $correction['id'] ?>"><i class="bi bi-pencil"></i></a>
                                                                        <a class="list-remove cursor-pointer" data-id="<?php echo $correction['id'] ?></td>"><i class="bi bi-trash"></i></a>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <?php if (!$disabled) { ?>
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Save
                                                        </button>
                                                        <a type="button" href="/customer_complaint_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    <?php } else { ?>
                                                        <a type="button" href="/customer_complaint_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--D4-->
                            <div class="tab-pane fade <?php echo (isset($_GET['d4'])) ? "active show" : "" ?>" id="d4" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="container-full customer-header d-flex justify-content-between">
                                                Cause Analysis Table (4M Analysis)
                                                <?php if (!$disabled) { ?>
                                                    <a class="list-add" id="list-add-ca" data-bs-toggle="modal" data-bs-target="#caModal"><i class="fa fa-plus"></i></a>
                                                <?php } ?>
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-135px">Category</th>
                                                        <th class="min-w-150px">Cause</th>
                                                        <th class="min-w-100px">Significant</th>
                                                        <?php if (!$disabled) { ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <?php if ($cAnalysisData && count($cAnalysisData) > 0) {
                                                        foreach ($cAnalysisData as $key => $item) { ?>
                                                            <tr>
                                                                <input type="hidden" class="form-control" name="canalysis_id" value="<?php echo $item['id']; ?>">
                                                                <input type="hidden" class="form-control" name="canalysis_category" value="<?php echo $item['category']; ?>">
                                                                <input type="hidden" class="form-control" name="canalysis_cause" value="<?php echo $item['cause']; ?>">
                                                                <input type="hidden" class="form-control" name="canalysis_significant" value="<?php echo $item['significant']; ?>">
                                                                <td>
                                                                    <?php echo $item['category']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item['cause']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $ans = $item['significant'] == 1 ?
                                                                        "<div class='badge badge-light-success'>Yes</div>"
                                                                        : "<div class='badge badge-light-danger'>No</div>";
                                                                    echo $ans;
                                                                    ?>
                                                                </td>
                                                                <?php if (!$disabled) { ?>
                                                                    <td>
                                                                        <button type="button" class="btn btn-link me-3" data-bs-toggle="modal" onclick="openCAPopup(this);">
                                                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                        </button>
                                                                        <a href="/includes/customer_complaint_d4_cause_analysis_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                    <?php }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                5 Why Analysis
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-135px">Significant Cause</th>
                                                        <th class="min-w-100px">1st Why</th>
                                                        <th class="min-w-100px">2nd Why</th>
                                                        <th class="min-w-100px">3rd Why</th>
                                                        <th class="min-w-100px">4th Why</th>
                                                        <th class="min-w-100px">5th Why</th>
                                                        <th class="min-w-100px">Root Cause</th>
                                                        <?php if (!$disabled) { ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">

                                                    <?php
                                                    if ($whyData && count($whyData) > 0) {
                                                        foreach ($whyData as $key => $item) {
                                                            $SqlData = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND id = '$item[customer_complaint_d4_cause_analysis_id]' AND significant = '1' AND is_deleted = 0";
                                                            $result = mysqli_query($con, $SqlData);
                                                            if ($result->num_rows != 0) {
                                                    ?>
                                                                <tr>
                                                                    <input type="hidden" class="form-control" name="why_id" value="<?php echo $item['id']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_root_cause" value="<?php echo $item['root_cause']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_1" value="<?php echo $item['why_1']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_2" value="<?php echo $item['why_2']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_3" value="<?php echo $item['why_3']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_4" value="<?php echo $item['why_4']; ?>">
                                                                    <input type="hidden" class="form-control" name="why_5" value="<?php echo $item['why_5']; ?>">
                                                                    <td>
                                                                        <?php
                                                                        $sql_data = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]'";
                                                                        $connect_data = mysqli_query($con, $sql_data);
                                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                            if ($result_data['id'] == $item['customer_complaint_d4_cause_analysis_id']) {
                                                                                echo $result_data['cause'];
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['why_1']; ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php echo $item['why_2']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['why_3']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['why_4']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['why_5']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['root_cause']; ?>
                                                                    </td>
                                                                    <?php if (!$disabled) { ?>
                                                                        <td>
                                                                            <button type="button" class="btn btn-link me-3" onclick="openWhyEditPopup(this);">
                                                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                    <?php }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <div class="container-full customer-header d-flex justify-content-between mt-4">
                                                Corrective Action Plan
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-135px">Root Cause</th>
                                                        <th class="min-w-150px">Corrective Action</th>
                                                        <th class="min-w-100px">Who</th>
                                                        <th class="min-w-100px">When</th>
                                                        <th class="min-w-100px">How</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <?php if (!$disabled) { ?>
                                                            <th class="min-w-100px">Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <?php if ($correctiveAction && count($correctiveAction) > 0) {
                                                        foreach ($correctiveAction as $key => $item) {
                                                            $SqlData = "SELECT * FROM customer_complaint_d4_why_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND id = '$item[customer_complaint_d4_why_analysis_id]' AND is_deleted = 0";
                                                            $result = mysqli_query($con, $SqlData);
                                                            if ($result->num_rows != 0) {
                                                    ?>
                                                                <tr>
                                                                    <input type="hidden" class="form-control" name="cAction_id" value="<?php echo $item['id']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_corrective_action" value="<?php echo $item['corrective_action']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_who" value="<?php echo $item['who']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_date" value="<?php echo $item['when_date']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_status" value="<?php echo $item['status']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_how" value="<?php echo $item['how']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_moc" value="<?php echo $item['moc']; ?>">
                                                                    <input type="hidden" class="form-control" name="cAction_risk_assessment" value="<?php echo $item['risk_assessment']; ?>">
                                                                    <td>
                                                                        <?php
                                                                        $sql = "SELECT * From customer_complaint_d4_why_analysis Where id = '$item[customer_complaint_d4_why_analysis_id]'";
                                                                        $fetchRootCause = mysqli_query($con, $sql);
                                                                        $causeInfo = mysqli_fetch_assoc($fetchRootCause);
                                                                        switch ($causeInfo['root_cause']) {
                                                                            case "1st Why":
                                                                                echo $causeInfo['why_1'];
                                                                                break;
                                                                            case "2nd Why":
                                                                                echo $causeInfo['why_2'];
                                                                                break;
                                                                            case "3rd Why":
                                                                                echo $causeInfo['why_3'];
                                                                                break;
                                                                            case "4th Why":
                                                                                echo $causeInfo['why_4'];
                                                                                break;
                                                                            case "5th Why":
                                                                                echo $causeInfo['why_5'];
                                                                                break;
                                                                            default:
                                                                                echo "";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['corrective_action']; ?>
                                                                    </td>
                                                                    <?php if (isset($item['who'])) {
                                                                        $sql = "SELECT * FROM Basic_Employee Where Id_employee = $item[who]";
                                                                        $fetch = mysqli_query($con, $sql);
                                                                        $who = mysqli_fetch_assoc($fetch);
                                                                    ?>
                                                                        <td>
                                                                            <?php echo $who['First_Name'] . ' ' . $who['Last_Name'] ?>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            <?php echo ' '; ?>
                                                                        </td>
                                                                    <?php } ?>
                                                                    <td>
                                                                        <?php echo ($who['First_Name'] != null) ? date("d-m-y", strtotime($item['when_date'])) : "" ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $item['how']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        if ($item['status'] == 'Open') {
                                                                            echo  '<div class="badge badge-light-danger">
                                                                ' . $item['status'] . '
                                                            </div>';
                                                                        } else if ($item['status'] == 'Completed') {
                                                                            echo  '<div class="badge badge-light-success">
                                                                ' . $item['status'] . '
                                                            </div>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <?php if (!$disabled) { ?>
                                                                        <td>
                                                                            <button type="button" class="btn btn-link me-3" onclick="openCActionEditPopup(this);">
                                                                                <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    <?php } ?>
                                                                </tr>
                                                    <?php }
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!--D6-D7-->
                            <div class="tab-pane fade <?php echo (isset($_GET['d6'])) ? "active show" : "" ?>" id="d6-d7" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/customer_complaint_d6_d7_verification_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="container-full customer-header d-flex justify-content-between">
                                                Verification
                                            </div>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5 mt-4" id="kt_department_table">
                                                <thead>
                                                    <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                        <th class="min-w-135px">Root Cause</th>
                                                        <th class="min-w-150px">Corrective Action</th>
                                                        <th class="min-w-100px">Who</th>
                                                        <th class="min-w-100px">when</th>
                                                        <th class="min-w-100px">Verified</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-bold text-gray-600">
                                                    <?php if ($correctiveAction && count($correctiveAction) > 0) {
                                                        foreach ($correctiveAction as $key => $item) { ?>
                                                            <tr>
                                                                <input type="hidden" name='ids[]' value="<?php echo $item['id']; ?>">
                                                                <td>
                                                                    <?php
                                                                    $sql = "SELECT * From customer_complaint_d4_why_analysis Where id = '$item[customer_complaint_d4_why_analysis_id]'";
                                                                    $fetchRootCause = mysqli_query($con, $sql);
                                                                    $causeInfo = mysqli_fetch_assoc($fetchRootCause);
                                                                    switch ($causeInfo['root_cause']) {
                                                                        case "1st Why":
                                                                            echo $causeInfo['why_1'];
                                                                            break;
                                                                        case "2nd Why":
                                                                            echo $causeInfo['why_2'];
                                                                            break;
                                                                        case "3rd Why":
                                                                            echo $causeInfo['why_3'];
                                                                            break;
                                                                        case "4th Why":
                                                                            echo $causeInfo['why_4'];
                                                                            break;
                                                                        case "5th Why":
                                                                            echo $causeInfo['why_5'];
                                                                            break;
                                                                        default:
                                                                            echo "";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $item['corrective_action']; ?>
                                                                </td>
                                                                <?php if (isset($item['who'])) {
                                                                    $sql = "SELECT * FROM Basic_Employee Where Id_employee = $item[who]";
                                                                    $fetch = mysqli_query($con, $sql);
                                                                    $who = mysqli_fetch_assoc($fetch);
                                                                ?>
                                                                    <td>
                                                                        <?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td>
                                                                        <?php echo ''; ?>
                                                                    </td>
                                                                <?php } ?>
                                                                <td>
                                                                    <?php echo date("d-m-y", strtotime($item['when_date'])) ?>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="verifiedIds[]" value="<?php echo $item['id']; ?>" <?php echo $item['verified'] == 1 ? "checked" : ""; ?> <?php echo ($disabled) ? "disabled" : "" ?>>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <?php if (!$disabled) { ?>
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Save
                                                        </button>
                                                        <a type="button" href="/customer_complaint_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    <?php } else { ?>
                                                        <a type="button" href="/customer_complaint_view_list.php" class="btn btn-sm btn-secondary ms-2">Close</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="customer_complaint_id" value="<?php echo $complaintData['id'] ?>" />
                                    </form>
                                </div>
                            </div>

                            <!--D8-->
                            <div class="tab-pane fade <?php echo (isset($_GET['d8'])) ? "active show" : "" ?>" id="d8" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <div class="card-body text-center mb-6">
                                        <img src="https://img.icons8.com/bubbles/200/000000/trophy.png">
                                        <h3 class="font-weight-bold text-danger">CONGRATULATIONS!</h3>
                                        <p>
                                            Appreciate everyone worked in this project and supported customer in
                                            their hard time.
                                        </p>
                                        <p class="fst-italic">
                                            Keep it up, build better process & great brand.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->

        <!--Add New correction Modal-->
        <div class="modal right fade" id="addNewCorrection" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form class="form" id="correction-form" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title right-modal text-white">Correction</h5>
                            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" onclick="resetModalVal();" aria-label="Close"></button>
                        </div>

                        <div class="modal-body" style="overflow-y: scroll">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Correction</label>
                                    <textarea class="form-control" type="text" name='correctionModal_d3' id="correctionModal_d3" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">Who</label>
                                    <select class="form-control" name="whoModal_d3" id="whoModal_d3" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        $sql_data = "SELECT * FROM Basic_Employee WHERE Status = 'Active'";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        ?>
                                            <option value="<?php echo $result_data['Id_employee']; ?>">
                                                <?php echo $result_data['First_Name'] . ' ' . $result_data['Last_Name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">When</label>
                                    <input type="date" class="form-control" name="whenModal_d3" id="whenModal_d3" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">How</label>
                                    <textarea class="form-control" type="text" name='howModal_d3' id='howModal_d3' required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">Status</label>
                                    <select class="form-control" name="statusModal_d3" id="statusModal_d3" required>
                                        <option value="">Please Select</option>
                                        <option value="Open">Open</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success" id="correction-submit">Add</button>
                            <button type="button" class="btn btn-sm btn-danger" id="correction-cancel" data-bs-dismiss="modal" onclick="resetModalVal();">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Add New Cause Analysis Modal-->
        <div class="modal right fade" id="caModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form class="form" id="ca-form" action="/includes/customer_complaint_d4_cause_analysis_update.php" method="post">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title right-modal text-white">Cause Analysis</h5>
                            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: scroll">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Category</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">Please Select</option>
                                        <option value="Material">Material</option>
                                        <option value="Method">Method</option>
                                        <option value="Machine">Machine</option>
                                        <option value="Man">Man</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">Cause</label>
                                    <textarea name='cause' id="cause" class="form-control" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="significant" name='significant'>
                                        <label class="form-check-label" for="significant">
                                            Significant
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetCAValues();">Close</button>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="customer_complaint_id" value="<?php echo $complaintData['id'] ?>" />
                    <input type="hidden" class="form-control" name="id" id="canalysis_form_id" value="">
                </form>
            </div>
        </div>
        <!--Add New 5 Why Analysis Modal-->
        <div class="modal right fade" id="whyModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form class="form" id="why-form" action="/includes/customer_complaint_why_analysis_update.php" method="post">
                    <input type="hidden" class="form-control" name="why_complaint_id" id="why_complaint_id" value="<?php echo $_REQUEST['id']; ?>">
                    <input type="hidden" class="form-control" name="why_id" id="why_id" value="">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title right-modal text-white">5 Why Analysis</h5>
                            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" onclick="resetWhyValues();" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: scroll">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="">1st Why</label>
                                    <textarea name='why_1' class="form-control" rows="2" id="why_1" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="1st Why" name='why_root_cause' required>
                                        <label class="form-check-label">
                                            Is Root Cause?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="">2nd Why</label>
                                    <textarea name='why_2' class="form-control" rows="2" id="why_2" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="2nd Why" name='why_root_cause' required>
                                        <label class="form-check-label">
                                            Is Root Cause?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="">3rd Why</label>
                                    <textarea name='why_3' class="form-control" rows="2" id="why_3" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="3rd Why" name='why_root_cause' required>
                                        <label class="form-check-label">
                                            Is Root Cause?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="">4th Why</label>
                                    <textarea name='why_4' class="form-control" rows="2" id="why_4" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="4th Why" name='why_root_cause' required>
                                        <label class="form-check-label">
                                            Is Root Cause?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="">5th Why</label>
                                    <textarea name='why_5' class="form-control" rows="2" id="why_5" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="5th Why" name='why_root_cause' required>
                                        <label class="form-check-label">
                                            Is Root Cause?
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetWhyValues();">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Add New Corrective Action Plan Modal-->
        <div class="modal right fade" id="cActionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form class="form" id="c-action-form" action="/includes/customer_complaint_corrective_action_update.php" method="post">
                    <input type="hidden" class="form-control" name="cAction_complaint_id" id="cAction_complaint_id" value="<?php echo $_REQUEST['id']; ?>">
                    <input type="hidden" class="form-control" name="cAction_id" id="cAction_id" value="">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title right-modal text-white">Corrective Action Plan</h5>
                            <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" onclick="resetCActionValues();" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="overflow-y: scroll">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="required">Corrective Action</label>
                                    <textarea name='cAction_correction_action' class="form-control" id="cAction_correction_action" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">Who</label>
                                    <select class="form-control" id="cAction_who" name="cAction_who" required>
                                        <option value="">Please Select</option>
                                        <?php
                                        $results = mysqli_query($con, "SELECT * FROM Basic_Employee WHERE status = 'Active'");
                                        while ($row = mysqli_fetch_assoc($results)) {
                                            if ($row['Status'] == 'Active') {
                                                echo "<option value='" . $row['Id_employee'] . "'>" . $row['First_Name'] . ' ' . $row['Last_Name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">When</label>
                                    <input type="date" class="form-control" id="cAction_when" name="cAction_when" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">How</label>
                                    <textarea id="cAction_how" name="cAction_how" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name='cAction_moc' id="cAction_moc">
                                        <label class="form-check-label" for="moc">
                                            MoC
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name='cAction_risk_assessment' id="cAction_riskAssessment">
                                        <label class="form-check-label" for="riskAssessment">
                                            Risk Assessment
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <label class="required">Status</label>
                                    <select class="form-control" id="cAction_status" name="cAction_status" required>
                                        <option value="">Please Select</option>
                                        <option value='Open'>Open</option>
                                        <option value='Completed'>Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetCActionValues();">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <?php include 'includes/scrolltop.php'; ?>
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
        $("input").intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        });
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
    <script>
        $('.remove-tag').on('click', function() {
            return $(this).closest('div.tags').remove();
        });

        $(document).on("change", "#customer_name", function() {
            $.ajax({
                url: "includes/get_email_by_customer_name.php",
                type: "POST",
                dataType: "html",
                data: {
                    id: $('#customer_name').val()
                },
            }).done(function(res) {
                $('#email').val(res);
            });
        });
        $(document).ready(function() {
            var date = new Date();
            var min = date.getFullYear() +
                "-" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "-" +
                ("0" + date.getDate()).slice(-2);
            // document.getElementById("date").min = min;
            document.getElementById("whenModal_d3").min = min;
            document.getElementById("cAction_when").min = min;
        });

        let rowId = ($('#dataArr').val() == 'null' || $('#dataArr').val() == '') ? '0' : JSON.parse($('#dataArr').val())
            .length;
        let editRowId = "";

        $('body').delegate('.list-remove', 'click', function() {
            return $(this).closest('tr').remove();
        });

        $('#correction-form').submit(function(e) {
            e.preventDefault()
            let correctionModal = $("#correctionModal_d3").val();
            let whoModal = $("#whoModal_d3").val();
            let whoModalContent = $("#whoModal_d3 option:selected").text();
            let whenModal = $("#whenModal_d3").val();
            let howModal = $("#howModal_d3").val();
            let statusModal = $("#statusModal_d3").val();
            return appendTask(correctionModal, whoModal, whoModalContent, whenModal, howModal, statusModal);
        });


        function appendTask(correctionModal, whoModal, whoModalContent, whenModal, howModal, statusModal) {
            let statusClass = (statusModal == 'Open') ? 'badge badge-light-danger' : 'badge badge-light-success';
            if (editRowId != "") {
                let content = `
        <td><input class="form-control" type="hidden" name="correction_d3[]" value="${correctionModal}" required>${correctionModal}</td>
        <td><input class="form-control" type="hidden" name="who_d3[]" value="${whoModal}" required>${whoModalContent}</td>
        <td><input class="form-control" type="hidden" name="when_d3[]" value="${whenModal}" required> ${whenModal}</td>
        <td><input class="form-control" type="hidden" name="how_d3[]" value="${howModal}" required>${howModal}</td>
        <td><input class="form-control" type="hidden" name="status_d3[]" value="${statusModal}" required><span class="${statusClass}">${statusModal}</span></td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>`
                $('#' + editRowId).empty();
                $('#' + editRowId).append(content);
            } else {
                rowId++;
                let content = `<tr id="${rowId}">
            <td><input class="form-control" type="hidden" name="correction_d3[]" value="${correctionModal}" required>${correctionModal}</td>
        <td><input class="form-control" type="hidden" name="who_d3[]" value="${whoModal}" required>${whoModalContent}</td>
        <td><input class="form-control" type="hidden" name="when_d3[]" value="${whenModal}" required> ${whenModal}</td>
        <td><input class="form-control" type="hidden" name="how_d3[]" value="${howModal}" required>${howModal}</td>
        <td><input class="form-control" type="hidden" name="status_d3[]" value="${statusModal}" required><span class="${statusClass}">${statusModal}</span></td>
        <td class="list-row" style="vertical-align:middle">
        <a class="list-edit cursor-pointer me-2"> <i class="bi bi-pencil"></i></a>
        <a class="list-remove cursor-pointer"> <i class="bi bi-trash"></i></a>
        </td>
        </tr>`
                $('#list-table').append(content);
            }
            return $('#correction-cancel').trigger("click");
        }

        function resetModalVal() {
            editRowId = "";
            $("#correctionModal_d3").val("");
            $("#whoModal_d3").val("");
            $("#whenModal_d3").val("");
            $("#statusModal_d3").val("");
            return $("#howModal_d3").val("");
        }

        $('body').delegate('.list-edit', 'click', function() {
            editRowId = $(this).closest('tr')[0].id;
            let getData = getValue($(this).closest('tr')[0]);
            let setData = setValue(getData);
            if (setData) {
                return $('#list-add')[0].click();
            }
        });


        function getValue(row) {
            let correction = $(row).find('input[name="correction_d3[]"]').val();
            let who = $(row).find('input[name="who_d3[]"]').val();
            let when = $(row).find('input[name="when_d3[]"]').val();
            let how = $(row).find('input[name="how_d3[]"]').val();
            let status = $(row).find('input[name="status_d3[]"]').val()
            return {
                correction,
                who,
                when,
                how,
                status
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#correctionModal_d3').val(dataArr.correction);
                $('#whoModal_d3').val(dataArr.who);
                $('#whenModal_d3').val(dataArr.when);
                $('#howModal_d3').val(dataArr.how);
                $('#statusModal_d3').val(dataArr.status);
                return true;
            }
            return false;
        }

        function openCAPopup(obj) {
            let getData = getCAValue($(obj).closest('tr'));
            let setData = setCAValue(getData);
            if (setData) {
                return $('#caModal').modal('show');
            }
        }

        function getCAValue(row) {
            let id = $(row).find('input[name="canalysis_id"]').val();
            let category = $(row).find('input[name="canalysis_category"]').val();
            let cause = $(row).find('input[name="canalysis_cause"]').val();
            let significant = $(row).find('input[name="canalysis_significant"]').val();
            return {
                id,
                category,
                cause,
                significant
            }
        }

        function setCAValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#canalysis_form_id').val(dataArr.id);
                $('#category').val(dataArr.category);
                $('#cause').val(dataArr.cause);
                let significantCheck = dataArr.significant == 1 ? true : false;
                $('#significant').prop('checked', significantCheck);
            }
        }

        function openCActionEditPopup(obj) {
            let getData = getCActionValue($(obj).closest('tr'));
            let setData = setCActionValue(getData);
            if (setData) {
                return $('#cActionModal').modal('show');
            }
        }

        function getCActionValue(row) {
            let id = $(row).find('input[name="cAction_id"]').val();
            let corrective_action = $(row).find('input[name="cAction_corrective_action"]').val();
            let who = $(row).find('input[name="cAction_who"]').val();
            let date = $(row).find('input[name="cAction_date"]').val();
            let how = $(row).find('input[name="cAction_how"]').val();
            let status = $(row).find('input[name="cAction_status"]').val();
            let moc = $(row).find('input[name="cAction_moc"]').val();
            let risk_assessment = $(row).find('input[name="cAction_risk_assessment"]').val();
            return {
                id,
                corrective_action,
                who,
                date,
                how,
                status,
                moc,
                risk_assessment
            }
        }

        function setCActionValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#cAction_id').val(dataArr.id);
                $('#cAction_correction_action').val(dataArr.corrective_action);
                $('#cAction_who').val(dataArr.who);
                $('#cAction_when').val(dataArr.date);
                $('#cAction_how').val(dataArr.how);
                $('#cAction_status').val(dataArr.status);
                let mocCheck = dataArr.moc == 1 ? true : false;
                $('#cAction_moc').prop('checked', mocCheck);
                let riskCheck = dataArr.risk_assessment == 1 ? true : false;
                $('#cAction_riskAssessment').prop('checked', riskCheck);
                return true;
            }
            return false;
        }

        function resetCAValues() {
            return setValue({
                id: "",
                category: "",
                cause: "",
                significant: "",
            });
        }

        function resetCActionValues() {
            return setCActionValue({
                id: "",
                corrective_action: "",
                who: "",
                date: "",
                how: "",
                status: "",
                moc: "",
                risk_assessment: "",
            });
        }

        function openWhyEditPopup(obj) {
            let getData = getWhyValue($(obj).closest('tr'));
            let setData = setWhyValue(getData);
            if (setData) {
                return $('#whyModal').modal('show');
            }
        }

        function getWhyValue(row) {
            let id = $(row).find('input[name="why_id"]').val();
            let why1 = $(row).find('input[name="why_1"]').val();
            let why2 = $(row).find('input[name="why_2"]').val();
            let why3 = $(row).find('input[name="why_3"]').val();
            let why4 = $(row).find('input[name="why_4"]').val();
            let why5 = $(row).find('input[name="why_5"]').val();
            let root_cause = $(row).find('input[name="why_root_cause"]').val();
            return {
                id,
                why1,
                why2,
                why3,
                why4,
                why5,
                root_cause,
            }
        }

        function setWhyValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#why_id').val(dataArr.id);
                $('input[name="why_root_cause"]').each((key, elem) => {
                    if (elem.value == dataArr.root_cause) {
                        $(elem).attr('checked', 'checked');
                    }
                });
                $('#why_1').val(dataArr.why1);
                $('#why_2').val(dataArr.why2);
                $('#why_3').val(dataArr.why3);
                $('#why_4').val(dataArr.why4);
                $('#why_5').val(dataArr.why5);
                return true;
            }
            return false;
        }

        function resetWhyValues() {
            $('input[name="why_root_cause"]').each((key, elem) => {
                $(elem).attr('checked', false);
            });
            return setWhyValue({
                id: "",
                why1: "",
                why2: "",
                why3: "",
                why4: "",
                why5: "",
                root_cause: "",
            });
        }
    </script>
</body>
<!--end::Body-->

</html>