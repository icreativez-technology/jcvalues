<?php
session_start();
include('includes/functions.php');
$disabled = 0;
if (isset($_REQUEST['view'])) {
    $disabled = 1;
}

$sqlData = "SELECT * FROM kaizen WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$kaizen = mysqli_fetch_assoc($connectData);

$team_membersqlData = "SELECT member_id, First_Name, Last_Name FROM kaizen_team_members LEFT JOIN Basic_Employee ON kaizen_team_members.member_id = Basic_Employee.Id_employee WHERE kaizen_id = '$kaizen[id]' AND kaizen_team_members.is_deleted = 0";
$team_membersData = mysqli_query($con, $team_membersqlData);
$team_members =  array();
while ($row = mysqli_fetch_assoc($team_membersData)) {
    array_push($team_members, $row['member_id']);
}

$selfEvaluationSqlData = "SELECT * FROM kaizen_self_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$selfEvaluationqlConnectData = mysqli_query($con, $selfEvaluationSqlData);
$selfEvaluation = mysqli_fetch_assoc($selfEvaluationqlConnectData);
$hodDisabled = $selfEvaluationqlConnectData->num_rows == 0 ? true : false;
$hodEvaluationSqlData = "SELECT * FROM kaizen_hod_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$hodEvaluationqlConnectData = mysqli_query($con, $hodEvaluationSqlData);
$hodEvaluation = mysqli_fetch_assoc($hodEvaluationqlConnectData);
$comDisabled = $hodEvaluationqlConnectData->num_rows == 0 ? true : false;
$comEvaluationSqlData = "SELECT * FROM kaizen_committee_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$comEvaluationqlConnectData = mysqli_query($con, $comEvaluationSqlData);
$comEvaluation = mysqli_fetch_assoc($comEvaluationqlConnectData);

$_SESSION['Page_Title'] = ($disabled == 0) ? "Edit Kaizen Detail - " . $kaizen['kaizen_id'] : "View Kaizen Detail - " . $kaizen['kaizen_id'];
?>
<style>
    .div-disabled,
    .input-disabled input {
        background-color: #e9ecef !important;
    }
</style>
<script>
    var productGroup = <?php echo $kaizen['product_group_id']; ?>;
    var department = <?php echo $kaizen['department_id']; ?>;
</script>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/kaizen.php">Kaizen</a> » <a href="/kaizen_view_list.php">Kaizen List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Kaizen Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="self-tab" data-bs-toggle="tab" data-bs-target="#self" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Self
                                    Evaluation</button>
                            </li>
                            <li class="nav-item <?php echo $hodDisabled ? "div-disabled" : "" ?>" role="presentation">
                                <button class="nav-link" id="hod-tab" data-bs-toggle="tab" data-bs-target="#hod" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $hodDisabled ? "disabled" : "" ?>>HOD
                                    Evaluation</button>
                            </li>
                            <li class="nav-item <?php echo $comDisabled ? "div-disabled" : "" ?>" role="presentation">
                                <button class="nav-link" id="committee-tab" data-bs-toggle="tab" data-bs-target="#committee" type="button" role="tab" aria-controls="mitigation" aria-selected="false" <?php echo $comDisabled ? "disabled" : "" ?>>Committee
                                    Evaluation</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <!--Kaizen Details-->
                            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/kaizen_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Team Leader</label>
                                                        <select class="form-control" name="team_leader_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $kaizen['team_leader_id'] == $result_data['Id_employee'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_employee']; ?>" <?= $selected; ?>>
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
                                                        <select class="form-control" id="plant" name="plant_id" onchange="AgregrarPlantRelacionados();" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $kaizen['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_plant']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Product Group</label>
                                                        <select class="form-control" id="product_group" name="product_group_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Product_Group";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $kaizen['product_group_id'] == $result_data['Id_product_group'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_product_group']; ?>" <?php $selected; ?>><?php echo $result_data['Title']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Department</label>
                                                        <select class="form-control" id="department" name="department_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>

                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Department";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $kaizen['department_id'] == $result_data['Id_department'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_department']; ?>" <?php $selected; ?>><?php echo $result_data['Department']; ?>
                                                                    </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Category</label>
                                                        <select class="form-control" name="category_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM kaizen_category WHERE is_deleted = 0";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $kaizen['category_id'] == $result_data['id'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Focus Area</label>
                                                        <select class="form-control" name="focus_area_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM kaizen_focus_area WHERE is_deleted = 0";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $kaizen['focus_area_id'] == $result_data['id'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Process</label>
                                                        <select class="form-control" name="process_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM kaizen_process WHERE is_deleted = 0";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $kaizen['process_id'] == $result_data['id'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Kaizen Type</label>
                                                        <select class="form-control" name="kaizen_type_id" <?php echo ($disabled == 1) ? "disabled" : "" ?> required>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM kaizen_type WHERE is_deleted = 0";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $kaizen['kaizen_type_id'] == $result_data['id'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['id']; ?>" <?= $selected; ?>><?php echo $result_data['title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 mt-5">
                                                        <label class="required">Team Members</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Team Members" name="team_members[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $team_members)) ? 'selected' : ''; ?>>
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
                                                        <label class="required">Theme of kaizen</label>
                                                        <textarea class="form-control" name="theme_of_kaizen" required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['theme_of_kaizen']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-6 mt-5">
                                                        <label class="required">Before Improvement</label>
                                                        <textarea class="form-control" name="before_improvement" required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['before_improvement']; ?></textarea>
                                                    </div>
                                                    <div class="col-lg-6 mt-5">
                                                        <label class="required">After Improvement</label>
                                                        <textarea class="form-control" name="after_improvement" required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['after_improvement']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="container-full customer-header mt-2">
                                                    Benefits
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4 mt-5">
                                                        <label>
                                                            Expenditure
                                                            <small>(if any) </small>:
                                                            <small class="text-primary"> Please share details of
                                                                expenditure incurred to implement Kaizan</small>
                                                        </label>
                                                        <textarea class="form-control" name="expenditure" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['expenditure']; ?></textarea>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="">
                                                            Direct Savings
                                                            <small>(if any) </small>:
                                                            <small class="text-primary"> Please elaborate direct savings
                                                                against estimates due to implementation of
                                                                Kaizan</small>
                                                        </label>
                                                        <textarea class="form-control" name="direct_savings" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['direct_savings']; ?></textarea>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label>
                                                            Indirect Savings
                                                            <small>(if any) </small>:
                                                            <small class="text-primary"> Please elaborate indirect
                                                                savings e.g. man hours, service level improvement
                                                                energy, NVA revival etc.</small>
                                                        </label>
                                                        <textarea class="form-control" name="indirect_savings" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $kaizen['indirect_savings']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">
                                                            Total Expenditure
                                                            <small>(E)</small>
                                                            <small class="text-primary ms-2">Enter number only</small>
                                                        </label>
                                                        <input type="number" name="total_expenditure" id="total_expenditure" class="form-control" required value="<?php echo $kaizen['total_expenditure']; ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">
                                                            Total Direct Savings
                                                            <small>(D)</small>
                                                            <small class="text-primary ms-2">Enter number only</small>
                                                        </label>
                                                        <input type="number" name="total_direct_savings" id="total_direct_savings" class="form-control" required value="<?php echo $kaizen['total_direct_savings']; ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    </div>
                                                    <div class="col-lg-4 mt-5">
                                                        <label class="required">
                                                            Total Indirect Savings
                                                            <small>(I)</small>
                                                            <small class="text-primary ms-2">Enter number only</small>
                                                        </label>
                                                        <input type="number" name="total_indirect_savings" id="total_indirect_savings" class="form-control" required value="<?php echo $kaizen['total_indirect_savings']; ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-4 mt-5 input-disabled">
                                                        <label class="required">
                                                            Final Monetary Gain
                                                            <small>((D+I)-E)</small>
                                                        </label>
                                                        <input type="number" name="final_monetary_gain" id="final_monetary_gain" class="form-control" required readonly value="<?php echo $kaizen['final_monetary_gain']; ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($disabled == 0) { ?>
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Update</button>
                                                        <a type="button" href="/kaizen.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <input type="hidden" name="kaizenId" value="<?php echo $_REQUEST['id'] ?>">
                                    </form>
                                </div>
                            </div>

                            <!--Self Evaluation-->
                            <div class="tab-pane fade" id="self" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/kaizen-self-evaluation-update.php" method="post" enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-12 mt-5 kaizen-table">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="fw-bold">
                                                                <th class="min-w-100px p2-4">Criterion</th>
                                                                <th class="" colspan="4">point</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="">
                                                            <tr class="">
                                                                <td class="">
                                                                    Individual or Team
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="self-id" value="<?php echo $selfEvaluation['id'] ?>">
                                                                    <input type="hidden" name="self-kaizen-id" value="<?php echo $_REQUEST['id'] ?>">
                                                                    <div>
                                                                        <p>1 person</p>
                                                                        <div class="form-check mt-2">
                                                                            <input class="form-check-input self" type="radio" name="self-individual" value="10" <?php echo ($selfEvaluation['criteria1'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                            <label class="form-check-label">
                                                                                10
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <p>2 person</p>
                                                                        <div class="form-check mt-2">
                                                                            <input class="form-check-input self" type="radio" name="self-individual" value="15" <?php echo ($selfEvaluation['criteria1'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                            <label class="form-check-label">
                                                                                15
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <p>2 person</p>
                                                                        <div class="form-check form-check-sm mt-2">
                                                                            <input class="form-check-input self" type="radio" name="self-individual" value="20" <?php echo ($selfEvaluation['criteria1'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                            <label class="form-check-label">
                                                                                20
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr class="">
                                                                <td class="">
                                                                    One time or sustainable
                                                                </td>
                                                                <td>

                                                                    <p>One Time</p>
                                                                    <div class="form-check mt-2">
                                                                        <input class="form-check-input self" type="radio" name="self-time" value="10" <?php echo ($selfEvaluation['criteria2'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                        <label class="form-check-label">
                                                                            10
                                                                        </label>
                                                                    </div>
                                                </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Sustainable for 1 year</p>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input self" type="radio" name="self-time" value="20" <?php echo ($selfEvaluation['criteria2'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                20
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Perpetual</p>
                                                        <div class="form-check form-check-sm mt-2">
                                                            <input class="form-check-input self" type="radio" name="self-time" value="30" <?php echo ($selfEvaluation['criteria2'] == '30') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                30
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                </tr>
                                                <tr class="">
                                                    <td class="">
                                                        Proactive/Reactive
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Flower Stage</p>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-proactive" value="10" <?php echo ($selfEvaluation['criteria3'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    10
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Bud Stage</p>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-proactive" value="15" <?php echo ($selfEvaluation['criteria3'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    15
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Sprout Stage</p>
                                                            <div class="form-check form-check-sm mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-proactive" value="20" <?php echo ($selfEvaluation['criteria3'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    20
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Seed Stage</p>
                                                            <div class="form-check form-check-sm mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-proactive" value="25" <?php echo ($selfEvaluation['criteria3'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    25
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="">
                                                    <td class="">
                                                        Creativity
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Low</p>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-creativity" value="10" <?php echo ($selfEvaluation['criteria4'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    10
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Medium</p>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-creativity" value="15" <?php echo ($selfEvaluation['criteria4'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    15
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>High</p>
                                                            <div class="form-check form-check-sm mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-creativity" value="20" <?php echo ($selfEvaluation['criteria4'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    20
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Unique</p>
                                                            <div class="form-check form-check-sm mt-2">
                                                                <input class="form-check-input self" type="radio" name="self-creativity" value="25" <?php echo ($selfEvaluation['criteria4'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    25
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <input type="hidden" name="self-score" id="self-score" value="<?php echo $selfEvaluation['score'] ?>" required>
                                                <h6 class="fw-bold">Self Evaluation Score: <span class="badge bg-info fs-3 ms-2 self-score"><?php echo $selfEvaluation['score'] ?></span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 mt-5">
                                                <label class="">Remarks</label>
                                                <textarea rows="2" class="form-control" name="self-remarks" value="<?php echo $selfEvaluation['remarks'] ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $selfEvaluation['remarks'] ?> </textarea>
                                            </div>
                                        </div>
                                </div>
                                <?php if ($disabled == 0) { ?>
                                    <div class="card-footer">
                                        <div class="row" style="text-align:center; float:right;">
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Save
                                                </button>
                                                <a type="button" href="/kaizen_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </form>
                            </div>
                        </div>

                        <!--HOD Evaluation-->
                        <div class="tab-pane fade" id="hod" role="tabpanel" aria-labelledby="details-tab">
                            <div class="card card-flush">
                                <form class="form" action="includes/kaizen-hod-evaluation-update.php" method="post" enctype="multipart/form-data">
                                    <!-- begin::Form Content -->
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-12 mt-5 kaizen-table">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="fw-bold">
                                                            <th class="min-w-100px p2-4">Criterion</th>
                                                            <th class="" colspan="4">points</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="">
                                                        <tr class="">
                                                            <td class="">
                                                                Individual or Team
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="hod-id" value="<?php echo $hodEvaluation['id'] ?>">
                                                                <input type="hidden" name="hod-kaizen-id" value="<?php echo $_REQUEST['id'] ?>">
                                                                <div>
                                                                    <p>1 person</p>
                                                                    <div class="form-check mt-2">
                                                                        <input class="form-check-input hod" type="radio" name="hod-individual" value="10" <?php echo ($hodEvaluation['criteria1'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                        <label class="form-check-label">
                                                                            10
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <p>2 person</p>
                                                                    <div class="form-check mt-2">
                                                                        <input class="form-check-input hod" type="radio" name="hod-individual" value="15" <?php echo ($hodEvaluation['criteria1'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                        <label class="form-check-label">
                                                                            15
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <p>2 person</p>
                                                                    <div class="form-check form-check-sm mt-2">
                                                                        <input class="form-check-input hod" type="radio" name="hod-individual" value="20" <?php echo ($hodEvaluation['criteria1'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                        <label class="form-check-label">
                                                                            20
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="">
                                                            <td class="">
                                                                One time or sustainable
                                                            </td>
                                                            <td>

                                                                <p>One Time</p>
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input hod" type="radio" name="hod-time" value="10" <?php echo ($hodEvaluation['criteria2'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                    <label class="form-check-label">
                                                                        10
                                                                    </label>
                                                                </div>
                                            </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Sustainable for 1 year</p>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input hod" type="radio" name="hod-time" value="20" <?php echo ($hodEvaluation['criteria2'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            20
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Perpetual</p>
                                                    <div class="form-check form-check-sm mt-2">
                                                        <input class="form-check-input hod" type="radio" name="hod-time" value="30" <?php echo ($hodEvaluation['criteria2'] == '30') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            30
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>
                                            <tr class="">
                                                <td class="">
                                                    Proactive/Reactive
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Flower Stage</p>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-proactive" value="10" <?php echo ($hodEvaluation['criteria3'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                10
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Bud Stage</p>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-proactive" value="15" <?php echo ($hodEvaluation['criteria3'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                15
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Sprout Stage</p>
                                                        <div class="form-check form-check-sm mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-proactive" value="20" <?php echo ($hodEvaluation['criteria3'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                20
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Seed Stage</p>
                                                        <div class="form-check form-check-sm mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-proactive" value="25" <?php echo ($hodEvaluation['criteria3'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                25
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td class="">
                                                    Creativity
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Low</p>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-creativity" value="10" <?php echo ($hodEvaluation['criteria4'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                10
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Medium</p>
                                                        <div class="form-check mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-creativity" value="15" <?php echo ($hodEvaluation['criteria4'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                15
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>High</p>
                                                        <div class="form-check form-check-sm mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-creativity" value="20" <?php echo ($hodEvaluation['criteria4'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                20
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <p>Unique</p>
                                                        <div class="form-check form-check-sm mt-2">
                                                            <input class="form-check-input hod" type="radio" name="hod-creativity" value="25" <?php echo ($hodEvaluation['criteria4'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <label class="form-check-label">
                                                                25
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 mt-5">
                                            <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4 mt-5">
                                            <h6 class="fw-bold">Self Evaluation Score: <span class="badge bg-info fs-3 ms-2 self-score"><?php echo  $selfEvaluation['score'] ?></span>
                                            </h6>
                                        </div>
                                        <div class="col-lg-4 mt-5">
                                            <input type="hidden" name="hod-score" id="hod-score" value="<?php echo $hodEvaluation['score'] ?>" required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                            <h6 class="fw-bold">HOD Evaluation Score: <span class="badge bg-info fs-3 ms-2 hod-score"><?php echo $hodEvaluation['score'] ?></span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 mt-5">
                                            <label class="">Remarks</label>
                                            <textarea rows="2" class="form-control" name="hod-remarks" value="<?php echo $hodEvaluation['remarks'] ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $hodEvaluation['remarks'] ?></textarea>
                                        </div>
                                    </div>
                            </div>
                            <?php if ($disabled == 0) { ?>
                                <div class="card-footer">
                                    <div class="row" style="text-align:center; float:right;">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Save
                                            </button>
                                            <a type="button" href="/kaizen_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </form>
                        </div>
                    </div>

                    <!--Committee Evaluation-->
                    <div class="tab-pane fade" id="committee" role="tabpanel" aria-labelledby="details-tab">
                        <div class="card card-flush">
                            <form class="form" action="includes/kaizen-com-evaluation-update.php" method="post" enctype="multipart/form-data">
                                <!-- begin::Form Content -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-12 mt-5 kaizen-table">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="fw-bold">
                                                        <th class="min-w-100px p2-4">Criterion</th>
                                                        <th class="" colspan="4">points</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <tr class="">
                                                        <td class="">
                                                            Individual or Team
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="com-id" value="<?php echo $comEvaluation['id'] ?>">
                                                            <input type="hidden" name="com-kaizen-id" value="<?php echo $_REQUEST['id'] ?>">
                                                            <div>
                                                                <p>1 person</p>
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input com" type="radio" name="com-individual" value="10" <?php echo ($comEvaluation['criteria1'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                    <label class="form-check-label">
                                                                        10
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p>2 person</p>
                                                                <div class="form-check mt-2">
                                                                    <input class="form-check-input com" type="radio" name="com-individual" value="15" <?php echo ($comEvaluation['criteria1'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                    <label class="form-check-label">
                                                                        15
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <p>2 person</p>
                                                                <div class="form-check form-check-sm mt-2">
                                                                    <input class="form-check-input com" type="radio" name="com-individual" value="20" <?php echo ($comEvaluation['criteria1'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                    <label class="form-check-label">
                                                                        20
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="">
                                                        <td class="">
                                                            One time or sustainable
                                                        </td>
                                                        <td>

                                                            <p>One Time</p>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input com" type="radio" name="com-time" value="10" <?php echo ($comEvaluation['criteria2'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                                <label class="form-check-label">
                                                                    10
                                                                </label>
                                                            </div>
                                        </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p>Sustainable for 1 year</p>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input com" type="radio" name="com-time" value="20" <?php echo ($comEvaluation['criteria2'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    <label class="form-check-label">
                                                        20
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <p>Perpetual</p>
                                                <div class="form-check form-check-sm mt-2">
                                                    <input class="form-check-input com" type="radio" name="com-time" value="30" <?php echo ($comEvaluation['criteria2'] == '30') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                    <label class="form-check-label">
                                                        30
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                        <tr class="">
                                            <td class="">
                                                Proactive/Reactive
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Flower Stage</p>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-proactive" value="10" <?php echo ($comEvaluation['criteria3'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            10
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Bud Stage</p>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-proactive" value="15" <?php echo ($comEvaluation['criteria3'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            15
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Sprout Stage</p>
                                                    <div class="form-check form-check-sm mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-proactive" value="20" <?php echo ($comEvaluation['criteria3'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            20
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Seed Stage</p>
                                                    <div class="form-check form-check-sm mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-proactive" value="25" <?php echo ($comEvaluation['criteria3'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            25
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td class="">
                                                Creativity
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Low</p>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-creativity" value="10" <?php echo ($comEvaluation['criteria4'] == '10') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            10
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Medium</p>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-creativity" value="15" <?php echo ($comEvaluation['criteria4'] == '15') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            15
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>High</p>
                                                    <div class="form-check form-check-sm mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-creativity" value="20" <?php echo ($comEvaluation['criteria4'] == '20') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            20
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p>Unique</p>
                                                    <div class="form-check form-check-sm mt-2">
                                                        <input class="form-check-input com" type="radio" name="com-creativity" value="25" <?php echo ($comEvaluation['criteria4'] == '25') ? "checked" : ""; ?> required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <label class="form-check-label">
                                                            25
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-lg-12 mt-2">
                                        <h6 class="fw-bold">Focus Area Multiplier: <span class="badge bg-info fs-3 ms-2">1.5</span></h6>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-lg-4 mt-2">
                                        <h6 class="fw-bold">Self Evaluation Score: <span class="badge bg-info fs-3 ms-2 self-score"><?php echo $selfEvaluation['score'] ?></span>
                                        </h6>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <h6 class="fw-bold">HOD Evaluation Score: <span class="badge bg-info fs-3 ms-2 hod-score"><?php echo $hodEvaluation['score'] ?></span>
                                        </h6>
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                        <input type="hidden" name="com-score" id="com-score" value="<?php echo $comEvaluation['score'] ?>" required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                        <h6 class="fw-bold">Evaluation committee Score: <span class="badge bg-info fs-3 ms-2 com-score"><?php echo $comEvaluation['score'] ?></span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="form-group row mt-2">
                                    <div class="col-lg-12 mt-2">
                                        <label class="">Remarks</label>
                                        <textarea rows="2" class="form-control" name="com-remarks" value="<?php echo $comEvaluation['remarks'] ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $comEvaluation['remarks'] ?></textarea>
                                    </div>
                                </div>
                        </div>
                        <?php if ($disabled == 0) { ?>
                            <div class="card-footer">
                                <div class="row" style="text-align:center; float:right;">
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Save
                                        </button>
                                        <a type="button" href="/kaizen_view_list.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </form>
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
        $(".self").on('click', function() {
            var team = $('input[name="self-individual"]:checked').val();
            var time = $('input[name="self-time"]:checked').val();
            var proactive = $('input[name="self-proactive"]:checked').val();
            var creativity = $('input[name="self-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#self-score").val(Math.ceil(score));
                return $(".self-score").html(Math.ceil(score));
            }
        });

        $(".hod").on('click', function() {
            var team = $('input[name="hod-individual"]:checked').val();
            var time = $('input[name="hod-time"]:checked').val();
            var proactive = $('input[name="hod-proactive"]:checked').val();
            var creativity = $('input[name="hod-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#hod-score").val(Math.ceil(score));
                return $(".hod-score").html(Math.ceil(score));
            }
        });

        $(".com").on('click', function() {
            var team = $('input[name="com-individual"]:checked').val();
            var time = $('input[name="com-time"]:checked').val();
            var proactive = $('input[name="com-proactive"]:checked').val();
            var creativity = $('input[name="com-creativity"]:checked').val();
            if (team != undefined && time != undefined && proactive != undefined && creativity != undefined) {
                var score = (Number(team) + Number(time) + Number(proactive) + Number(creativity)) * 1.5;
                $("#com-score").val(Math.ceil(score));
                return $(".com-score").html(Math.ceil(score));
            }
        });

        $(document).ready(function() {
            AgregrarPlantRelacionados();
            $("#total_expenditure").on('input', function() {
                caluculateGain();
            });
            $("#total_direct_savings").on('input', function() {
                caluculateGain();
            });
            $("#total_indirect_savings").on('input', function() {
                caluculateGain();
            });
        });

        function AgregrarPlantRelacionados() {
            var result = document.getElementById("plant").value;
            $("<option>").load('includes/inputs-dinamicos-pg-plant.php?pg_id=' + result + '&key=' + productGroup,
                function() {
                    $('#product_group option').remove();
                    $("#product_group").append($(this).html());
                });

            $("<option>").load('includes/inputs-dinamicos-department-plant.php?pg_id=' + result + '&key=' + department,
                function() {
                    $('#department option').remove();
                    $("#department").append($(this).html());
                });
        }

        function caluculateGain() {
            var total_expenditure = $("#total_expenditure").val();
            var total_direct_savings = $("#total_direct_savings").val();
            var total_indirect_savings = $("#total_indirect_savings").val();
            if (total_expenditure != undefined && total_direct_savings != undefined && total_indirect_savings != undefined) {
                var final_monetary_gain = (Number(total_direct_savings) + Number(total_indirect_savings)) - Number(total_expenditure);
                $("#final_monetary_gain").val(Math.ceil(final_monetary_gain));
            }
        }
    </script>
</body>
<!--end::Body-->

</html>