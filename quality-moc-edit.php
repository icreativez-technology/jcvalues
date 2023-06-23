<?php
session_start();
include('includes/functions.php');
$sqlData = "SELECT * FROM quality_moc WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$moc = mysqli_fetch_assoc($connectData);
$actionPlanSqlData = "SELECT * FROM quality_moc_action_plan WHERE is_deleted = 0 AND quality_moc_id = '$_REQUEST[id]'";
$actionPlanData = mysqli_query($con, $actionPlanSqlData);
$actionPlan =  array();
while ($row = mysqli_fetch_assoc($actionPlanData)) {
    array_push($actionPlan, $row);
}
$teamSqlData = "SELECT member_id, First_Name, Last_Name FROM quality_moc_team_members LEFT JOIN Basic_Employee ON quality_moc_team_members.member_id = Basic_Employee.Id_employee WHERE quality_moc_id = '$moc[id]' AND quality_moc_team_members.is_deleted = 0";
$teamData = mysqli_query($con, $teamSqlData);
$team =  array();
$teamMembers =  array();
while ($row = mysqli_fetch_assoc($teamData)) {
    array_push($team, $row['member_id']);
    array_push($teamMembers, $row);
}
$_SESSION['Page_Title'] = "Edit MoC - " . $moc['moc_id'];

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$disabled = $type == 'view' ? true : false;

?>
<script>
var productGroup = <?php echo $moc['product_group_id']; ?>;
var department = <?php echo $moc['department_id']; ?>;
</script>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!--begin::Body-->

<style>
.custom-tab .nav-link {
    border-radius: 3px;
    padding: 8px 20px;
    /* background-color: #e7d2d2; */
}

.custom-tab .nav-link.active {
    color: #fff !important;
    background-color: #009ef7;
}

.required::after {
    content: "*";
    color: #e1261c;
}

.custom-select {
    background-color: #f5f8fa;
    border: 1px solid #e4e6ef;
    border-radius: 6px;
    width: 100%;
    padding: 6px;
    min-height: 38px;
}

.custom-select .tag-wrapper {
    list-style: none;
    display: flex;
    justify-content: flex-start;
    align-content: flex-start;
    flex-wrap: wrap;
}

.tag-wrapper .tags {
    position: relative;
    padding: 0px 15px 0px 6px;
    margin: 4px;
    text-align: left;
    background-color: #e1e2e4;
    border-radius: 5px;
}

.tag-wrapper .tags span {
    position: absolute;
    right: 4px;
    cursor: pointer;
    color: #002429;
}

.tag-wrapper .tags span::after {
    content: "x";
    font-weight: 600;
}

.tag-wrapper .tags span:hover {
    color: #e1261c;
}

.tag-wrapper .tags a {
    color: #002429;
}

.tag-wrapper .tags a:hover {
    color: #e1261c;
}

.modal.left .modal-dialog,
.modal.right .modal-dialog {
    position: fixed;
    top: 0 !important;
    right: 0 !important;
    margin: auto;
    width: 320px;
    height: 100%;
    -webkit-transform: translate3d(0%, 0, 0);
    -ms-transform: translate3d(0%, 0, 0);
    -o-transform: translate3d(0%, 0, 0);
    transform: translate3d(0%, 0, 0);
}

.modal.left .modal-content,
.modal.right .modal-content {
    height: 100%;
    overflow-y: auto;
}

.modal.left .modal-body,
.modal.right .modal-body {
    padding: 15px 15px 80px;
}

/*Left*/
.modal.left.fade .modal-dialog {
    left: -320px;
    -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
    -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
    -o-transition: opacity 0.3s linear, left 0.3s ease-out;
    transition: opacity 0.3s linear, left 0.3s ease-out;
}

.modal.left.fade.in .modal-dialog {
    left: 0;
}

/*Right*/
.modal.right.fade .modal-dialog {
    right: -320px;
    -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
    -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
    -o-transition: opacity 0.3s linear, right 0.3s ease-out;
    transition: opacity 0.3s linear, right 0.3s ease-out;
}

.modal.right.fade.in .modal-dialog {
    right: 0;
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
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/quality-moc.php">Quality MoC</a> » <a
                                    href="/quality-moc_view_list.php">Quality MoC List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                    <!--end::body-->
                </div>
                <!--end::BREADCRUMBS-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "" : "active" ?>"
                                    id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button"
                                    role="tab" aria-controls="details" aria-selected="true">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "active" : "" ?>"
                                    id="action-plan-tab" data-bs-toggle="tab" data-bs-target="#action-plan"
                                    type="button" role="tab" aria-controls="action-plan" aria-selected="false">Action
                                    Plan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "" : "active show" ?>"
                                id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/quality-moc_update_form.php" method="post"
                                        enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">On Behalf Of</label>
                                                        <select class="form-control" name="on_behalf_of" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $moc['on_behalf_of'] == $result_data['Id_employee'] ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>"
                                                                <?= $selected; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Plant</label>
                                                        <select class="form-control" name="plant_id" id="plant"
                                                            onchange="AgregrarPlantRelacionados();" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="0">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $moc['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_plant']; ?>"
                                                                <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                            </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Product Group</label>
                                                        <select class="form-control" id="product_group"
                                                            name="product_group_id" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Department</label>
                                                        <select class="form-control" id="department"
                                                            name="department_id" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">MoC Type</label>
                                                        <select class="form-control" name="moc_type_id" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_MoC_Type";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $moc['moc_type_id'] == $result_data['Id_quality_moc_type'] ? 'selected' : '';
                                                            ?>
                                                            <option
                                                                value="<?php echo $result_data['Id_quality_moc_type']; ?>"
                                                                <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                            </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Old MoC Ref#</label>
                                                        <input class="form-control" name="old_moc_ref_no" required
                                                            value="<?php echo $moc['old_moc_ref_no']; ?>"
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Standard / Procedure Reference</label>
                                                        <input class="form-control" name="std_procedure_ref" required
                                                            value="<?php echo $moc['std_procedure_ref']; ?>"
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Risk Assessment</label>
                                                        <select class="form-control" name="risk_assessment" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <option value="Yes"
                                                                <?php echo ($moc['risk_assessment'] == "Yes") ? 'selected' : ''; ?>>
                                                                Yes</option>
                                                            <option value="No"
                                                                <?php echo ($moc['risk_assessment'] == "No") ? 'selected' : ''; ?>>
                                                                No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Current State</label>
                                                        <input class="form-control" name="current_state" required
                                                            value="<?php echo $moc['current_state']; ?>"
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Change State</label>
                                                        <input class="form-control" name="change_state" required
                                                            value="<?php echo $moc['change_state']; ?>"
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <div class="col-lg-6 mt-5">
                                                        <label class="required">Informed Team Members</label>
                                                        <select
                                                            class="form-control form-select-solid select2-hidden-accessible"
                                                            data-control="select2" data-hide-search="true"
                                                            data-placeholder="Select Team Members" name="team_members[]"
                                                            data-select2-id="select2-data-7-oqww" tabindex="-1"
                                                            aria-hidden="true" required multiple
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>"
                                                                <?php echo (in_array($result_data['Id_employee'], $team)) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 mt-5">
                                                        <label class="required">Description Of Change</label>
                                                        <textarea type="text" rows="3" class="form-control"
                                                            name="description_of_change" required
                                                            <?php echo $disabled ? "disabled" : ""  ?>><?php echo $moc['description_of_change']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-2">
                                                    <div class="col-lg-3 mt-5">
                                                        <label>File Upload</label>
                                                        <input type="file" class="form-control" name="files[]"
                                                            accept=".pdf" multiple
                                                            <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <?php
                                                    $sql_data = "SELECT * FROM quality_moc_files WHERE quality_moc_id = '$moc[id]' AND is_deleted = 0";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    if (mysqli_num_rows($connect_data)) {
                                                    ?>
                                                    <div class="col-lg-6 mt-6">
                                                        <div class="custom-select mt-6">
                                                            <div class="tag-wrapper">
                                                                <?php
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                    ?>
                                                                <div class="tags">
                                                                    <?php if ($type != 'view') {
                                                                            ?>
                                                                    <span class="remove-tag"></span>
                                                                    <?php
                                                                            }
                                                                            ?>
                                                                    <a href="<?php echo $result_data['file_path']; ?>"
                                                                        target="_blank"><?php echo $result_data['file_name']; ?></a>
                                                                    <input type="hidden" class="form-control"
                                                                        name="existingFiles[]"
                                                                        value="<?php echo $result_data['id']; ?>">
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
                                            </div>
                                            <!-- end::Form Content -->
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <?php
                                                        if ($type != 'view') {
                                                        ?>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Update</button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <a type="button" href="/quality-moc.php"
                                                            class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                        <input type="hidden" class="form-control" name="mocId"
                                            value="<?php echo $moc['id']; ?>">
                                        <input type="hidden" class="form-control" name="moc_id"
                                            value="<?php echo $moc['moc_id']; ?>">
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "active show" : "" ?>"
                                id="action-plan" role="tabpanel" aria-labelledby="action-plan-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/quality-moc-action-plan-update.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <?php
                                                if ($type != 'view') {
                                                ?>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-sm btn-primary mb-4 mt-2 me-2"
                                                        data-bs-toggle="modal" data-bs-target="#action-plan-popup">
                                                        Add
                                                    </button>
                                                </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="col-md-12 mt-5">
                                                    <table class="table table-row-dashed fs-4 gy-5">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                                <th class="min-w-250px ps-4">
                                                                    Action Point</th>
                                                                <th class="min-w-100px ">
                                                                    Who</th>
                                                                <th class="min-w-100px">
                                                                    When</th>
                                                                <th class="min-w-100px">
                                                                    Verified</th>
                                                                <th class="w-50px">
                                                                    Status</th>
                                                                <?php
                                                                if ($type != 'view') {
                                                                ?>
                                                                <th class="w-75px pe-4">
                                                                    Action</th>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <tbody class="text-gray-600 fw-bold" id="plan-table">
                                                            <?php if ($actionPlan && count($actionPlan) > 0) {
                                                                foreach ($actionPlan as $key => $item) { ?>
                                                            <tr>
                                                                <input type="hidden" class="form-control"
                                                                    name="action_plan_id"
                                                                    value="<?php echo $item['id']; ?>">
                                                                <td>
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <input type="hidden" class="form-control"
                                                                            name="action_point"
                                                                            value="<?php echo $item['action_point']; ?>">
                                                                        <?php echo $item['action_point']; ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <input type="hidden" class="form-control"
                                                                            name="who"
                                                                            value="<?php echo $item['who']; ?>">
                                                                        <?php
                                                                                $sql_data = "SELECT * FROM Basic_Employee";
                                                                                $connect_data = mysqli_query($con, $sql_data);
                                                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                                    if ($result_data['Status'] == 'Active') {
                                                                                        if ($item['who'] == $result_data['Id_employee']) {
                                                                                            echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <input type="hidden" class="form-control"
                                                                            name="when"
                                                                            value="<?php echo $item['date']; ?>">
                                                                        <?php echo date("d-m-y", strtotime($item['date'])); ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <input type="hidden" class="form-control"
                                                                            name="verified"
                                                                            value="<?php echo $item['verified']; ?>">
                                                                        <?php
                                                                                $sql_data = "SELECT * FROM Basic_Employee";
                                                                                $connect_data = mysqli_query($con, $sql_data);
                                                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                                    if ($result_data['Status'] == 'Active') {
                                                                                        if ($item['verified'] == $result_data['Id_employee']) {
                                                                                            echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <?php if ($item['status'] == '0') { ?>
                                                                        <div class="badge badge-light-danger"
                                                                            style="cursor:pointer"
                                                                            onclick="changeApproval(this)">Open</div>
                                                                        <input type="hidden"
                                                                            class="form-control plan-status"
                                                                            name="status" value="0">
                                                                        <?php } else { ?>
                                                                        <div class="badge badge-light-success"
                                                                            onclick="changeApproval(this)"
                                                                            style="cursor:pointer">Closed</div>
                                                                        <input type="hidden"
                                                                            class="form-control plan-status"
                                                                            name="status" value="1">
                                                                        <?php } ?>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                                        if ($type != 'view') {
                                                                        ?>
                                                                <td class="plan-actions">
                                                                    <div class="mt-2" style="font-size:14px">
                                                                        <span class="edit-actionPlan me-2"
                                                                            style="cursor: pointer"><i
                                                                                class="bi bi-pencil"></i></span>
                                                                        <span class="delete-actionPlan"
                                                                            style="cursor: pointer"> <i
                                                                                class="bi bi-trash"></i></span>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                                        }
                                                                        ?>
                                                            </tr>
                                                            <?php }
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="container-full customer-header" id="approval-header">
                                                Approval
                                            </div>
                                            <div class="row" id="approval">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-md-4 mt-5">
                                                            <label class="required"><b>Decision</b></label>
                                                            <div class="row">
                                                                <div class="col-md-6 mt-6">
                                                                    <input type="radio" class="decision" name="decision"
                                                                        value="1" required
                                                                        <?php echo $disabled ? "disabled" : ""  ?>
                                                                        <?php echo ($moc['decision'] == '1') ?  "checked" : "";  ?>>
                                                                    <label style="color:green">
                                                                        Approved
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6 mt-6">
                                                                    <input type="radio" class="decision" name="decision"
                                                                        value="2" required
                                                                        <?php echo $disabled ? "disabled" : ""  ?>
                                                                        <?php echo ($moc['decision'] == '2') ?  "checked" : "";  ?>>
                                                                    <label style="color:#e1261c">
                                                                        Rejected
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 mt-5">
                                                            <label class="required"><b>Decision Remarks</b></label>
                                                            <input type="text" class="form-control decision_remarks"
                                                                name="decision_remarks" required
                                                                <?php echo $disabled ? "disabled" : ""  ?>
                                                                value="<?php echo $moc['decision_remarks']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer mt-4">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <?php
                                                    if ($type != 'view') {
                                                    ?>
                                                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a type="button" href="/quality-moc.php"
                                                        class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="quality_moc_id"
                                            id="quality_moc_id" value="<?php echo $moc['id']; ?>">
                                    </form>


                                    <div class="modal right fade" id="action-plan-popup" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="action-plan-form" class="form" enctype="multipart/form-data">
                                                <div class="modal-content">
                                                    <div class="modal-header right-modal">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Action Plan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <input type="hidden" class="form-control"
                                                                    name="actionPlanId" id="actionPlanId" value="">
                                                                <label class="required">Action Point</label>
                                                                <textarea class="form-control" name="actionPoint"
                                                                    id="actionPoint" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">Who</label>
                                                                <select class="form-control" name="actionPlanWho"
                                                                    id="actionPlanWho" required>
                                                                    <option value="">Please Select</option>
                                                                    <?php
                                                                    $sql_data = "SELECT * FROM Basic_Employee";
                                                                    $connect_data = mysqli_query($con, $sql_data);
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                        if ($result_data['Status'] == 'Active') {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $result_data['Id_employee']; ?>">
                                                                        <?php echo $result_data['First_Name']; ?>
                                                                        <?php echo $result_data['Last_Name']; ?>
                                                                    </option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">When</label>
                                                                <input type="date" class="form-control"
                                                                    name="actionPlanWhen" id="actionPlanWhen" required>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">Verified</label>
                                                                <select class="form-control" name="actionPlanVerified"
                                                                    id="actionPlanVerified" required>
                                                                    <option value="">Please Select</option>
                                                                    <?php
                                                                    $sql_data = "SELECT * FROM Basic_Employee";
                                                                    $connect_data = mysqli_query($con, $sql_data);
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {

                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $result_data['Id_employee']; ?>">
                                                                        <?php echo $result_data['First_Name']; ?>
                                                                        <?php echo $result_data['Last_Name']; ?>
                                                                    </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">Status</label>
                                                                <select class="form-control" name="actionPlanStatus"
                                                                    id="actionPlanStatus" required>
                                                                    <option value="0"> Open </option>
                                                                    <option value="1"> Closed </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            id="actionPlan-submit">Save</button>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-dismiss="modal"
                                                            onclick="resetValues();">Close</button>
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
        </div>
        <!--end::Container-->
    </div>
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
    function AgregrarPlantRelacionados() {
        var result = document.getElementById("plant").value;
        /*Product Group*/
        $("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result + '&key=' + productGroup,
            function() {
                $('#product_group option').remove();
                $("#product_group").append($(this).html());
            });

        /*Department*/
        $("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result + '&key=' + department,
            function() {
                $('#department option').remove();
                $("#department").append($(this).html());
            });
    }

    function checkApproval() {
        var canShowApproval = false;
        $(".plan-status").each(function() {
            if (Number($(this).val())) {
                canShowApproval = true;
                return true;
            } else {
                canShowApproval = false;
                return false;
            }
        });
        if (canShowApproval) {
            $("#approval-header").removeClass("d-none");
            $("#approval-header").addClass("d-block");
            $("#approval").removeClass("d-none");
            $("#approval").addClass("d-block");
            $(".decision").prop('required', true);
            $(".decision_remarks").prop('required', true);
        } else {
            $("#approval-header").removeClass("d-block");
            $("#approval-header").addClass("d-none");
            $("#approval").removeClass("d-block");
            $("#approval").addClass("d-none");
            $(".decision").prop('required', false);
            $(".decision_remarks").prop('required', false);
        }
    }

    $(document).ready(function() {
        AgregrarPlantRelacionados();
        checkApproval();
    });

    function changeApproval(obj) {
        if ($(obj).text() == "Open") {
            $(obj).attr('class', 'badge badge-light-success');
            $(obj).text('Closed');
            $(obj).parent().find(".plan-status").val(1);
        } else {
            $(obj).attr('class', 'badge badge-light-danger');
            $(obj).text('Open');
            $(obj).parent().find(".plan-status").val(0);
        }
        checkApproval();
    }

    $('.remove-tag').on('click', function() {
        return $(this).closest('div.tags').remove();
    });

    $('body').delegate('.remove-plan', 'click', function() {
        $(this).closest('tr').remove();
        return checkApproval();
    });

    $('#action-plan-form').submit(function(e) {
        e.preventDefault();
        let quality_moc_id = $('#quality_moc_id').val();
        let actionPlanId = $('#actionPlanId').val();
        let actionPoint = $('#actionPoint').val();
        let actionPlanStatus = $('#actionPlanStatus').val();
        let actionPlanWho = $('#actionPlanWho').val();
        let actionPlanVerified = $('#actionPlanVerified').val();
        let actionPlanWhen = $('#actionPlanWhen').val();

        $.ajax({
            url: "includes/quality-moc-action-plan-table-add.php",
            type: "POST",
            dataType: "html",
            data: {
                quality_moc_id: quality_moc_id,
                actionPlanId: actionPlanId,
                actionPoint: actionPoint,
                actionPlanStatus: actionPlanStatus,
                actionPlanWho: actionPlanWho,
                actionPlanVerified: actionPlanVerified,
                actionPlanWhen: actionPlanWhen
            },
        }).done(function(resultado) {
            if (resultado) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                if (urlParams.has('updated')) {
                    return window.location.reload();
                }
                return window.location.href = url + "&updated";
            }
            return alert('Try Again');
        });
    });

    $('.delete-actionPlan').on('click', function() {
        let actionPlanId = $(this).closest('tr').find('input[name="action_plan_id"]').val();
        $.ajax({
            url: "includes/quality-moc-action-plan-table-delete.php",
            type: "POST",
            dataType: "html",
            data: {
                actionPlanId: actionPlanId,
            },
        }).done(function(resultado) {
            if (resultado) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                if (urlParams.has('updated')) {
                    return window.location.reload();
                }
                return window.location.href = url + "&updated";
            }
            return alert('Try Again');
        });
    });

    $('.edit-actionPlan').on('click', function() {
        let getData = getValue($(this).closest('tr'));
        let setData = setValue(getData);
        if (setData) {
            return $('#action-plan-popup').modal('show');
        }
    });

    function getValue(row) {
        let actionPlanId = $(row).find('input[name="action_plan_id"]').val();
        let actionPoint = $(row).find('input[name="action_point"]').val();
        let actionPlanStatus = $(row).find('input[name="status"]').val();
        let actionPlanWho = $(row).find('input[name="who"]').val();
        let actionPlanWhen = $(row).find('input[name="when"]').val();
        let actionPlanVerified = $(row).find('input[name="verified"]').val();
        return {
            actionPlanId,
            actionPoint,
            actionPlanStatus,
            actionPlanWho,
            actionPlanWhen,
            actionPlanVerified
        }
    }

    function setValue(dataArr) {
        if (Object.keys(dataArr)?.length > 0) {
            $('#actionPlanId').val(dataArr.actionPlanId);
            $('#actionPoint').val(dataArr.actionPoint);
            $('#actionPlanStatus').val(dataArr.actionPlanStatus);
            $('#actionPlanWho').val(dataArr.actionPlanWho);
            $('#actionPlanWhen').val(dataArr.actionPlanWhen);
            $('#actionPlanVerified').val(dataArr.actionPlanVerified);
            return true;
        }
        return false;
    }

    function resetValues() {
        return setValue({
            actionPlanId: "",
            actionPoint: "",
            actionPlanStatus: "",
            actionPlanWho: "",
            actionPlanWhen: "",
            actionPlanVerified: "",
        });
    }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>