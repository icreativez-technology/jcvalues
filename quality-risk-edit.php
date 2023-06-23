<?php
session_start();
include('includes/functions.php');
$sqlData = "SELECT * FROM quality_risk WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$risk = mysqli_fetch_assoc($connectData);
$revisedSqlData = "SELECT * FROM quality_risk_revised_assessment WHERE quality_risk_id = '$_REQUEST[id]'";
$revisedConnectData = mysqli_query($con, $revisedSqlData);
$revisedRisk = mysqli_fetch_assoc($revisedConnectData);
$mitigationPlanSqlData = "SELECT * FROM quality_risk_mitigation_plan WHERE is_deleted = 0 AND quality_risk_id = '$_REQUEST[id]'";
$mitigationPlanData = mysqli_query($con, $mitigationPlanSqlData);
$mitigationPlan =  array();
while ($row = mysqli_fetch_assoc($mitigationPlanData)) {
    array_push($mitigationPlan, $row);
}
$approvalData = "SELECT * FROM quality_risk_approval WHERE quality_risk_id = '$_REQUEST[id]'";
$approvalConnectData = mysqli_query($con, $approvalData);
$approval = mysqli_fetch_assoc($approvalConnectData);
$_SESSION['Page_Title'] = "Edit Risk - " . $risk['risk_id'];

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
$disabled = $type == 'view' ? true : false;

?>
<script>
    var productGroup = <?php echo $risk['product_group_id']; ?>;
    var department = <?php echo $risk['department_id']; ?>;
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

    .assesment-row {
        display: flex;
        justify-content: space-between;
        align-content: space-around;
        min-height: 110px;
        flex-wrap: inherit;
        border-right: 2px solid #ededed;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .radio-grid {
        width: 115px;
        padding-top: 10px;
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
        /* color: #e1261c; */
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
                <!-- Includes Top bar and Responsive Menu -->
                <!--begin::BREADCRUMBS-->
                <div class="row breadcrumbs">
                    <!--begin::body-->
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/quality-risk.php">Risk Assesment</a> » <a href="/quality-risk-view-list.php">Risk Assesment List</a> »
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
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "" : "active" ?>" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "active" : "" ?>" id="mitigation-tab" data-bs-toggle="tab" data-bs-target="#mitigation" type="button" role="tab" aria-controls="mitigation" aria-selected="false">Mitigation Plan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "" : "active show" ?>" id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/quality-risk_update_form.php" method="post" enctype="multipart/form-data">
                                        <!-- begin::Form Content -->
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">On Behalf Of</label>
                                                        <select class="form-control" name="on_behalf_of" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $risk['on_behalf_of'] == $result_data['Id_employee'] ? 'selected' : '';
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
                                                        <select class="form-control" name="plant_id" id="plant" onchange="AgregrarPlantRelacionados();" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="0">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT Id_plant, Title, Status FROM Basic_Plant";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $risk['plant_id'] == $result_data['Id_plant'] ? 'selected' : '';
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
                                                        <select class="form-control" id="product_group" name="product_group_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Department</label>
                                                        <select class="form-control" id="department" name="department_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Process</label>
                                                        <select class="form-control" name="process_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_Process";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $risk['process_id'] == $result_data['Id_quality_process'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_quality_process']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Risk Type</label>
                                                        <select class="form-control" name="risk_type_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_Risk_Type";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $risk['risk_type_id'] == $result_data['Id_quality_risk_type'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_quality_risk_type']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Source of Risk</label>
                                                        <select class="form-control" name="source_of_risk_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_Risk_Source";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $risk['source_of_risk_id'] == $result_data['Id_quality_risk_source'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_quality_risk_source']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Impact Area</label>
                                                        <select class="form-control" name="impact_area_id" required <?php echo $disabled ? "disabled" : ""  ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Quality_Impact_Area";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                $selected = $risk['impact_area_id'] == $result_data['Id_quality_impact_area'] ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $result_data['Id_quality_impact_area']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?>
                                                                </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 mt-5">
                                                        <label class="required">Description</label>
                                                        <textarea type="text" rows="3" class="form-control" name="description" required <?php echo $disabled ? "disabled" : ""  ?>><?php echo $risk['description']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label>File Upload</label>
                                                        <input type="file" class="form-control" name="files[]" accept=".pdf" multiple <?php echo $disabled ? "disabled" : ""  ?>>
                                                    </div>
                                                    <?php
                                                    $sql_data = "SELECT * FROM quality_risk_files WHERE quality_risk_id = '$risk[id]' AND is_deleted = 0";
                                                    $connect_data = mysqli_query($con, $sql_data);
                                                    if (mysqli_num_rows($connect_data)) {
                                                    ?>
                                                        <div class="col-md-6 mt-6">
                                                            <div class="custom-select mt-6">
                                                                <div class="tag-wrapper">
                                                                    <?php
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                    ?>
                                                                        <div class="tags">
                                                                            <span class="remove-tag"></span>
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
                                            </div>
                                            <div class=" card-body mt-2">
                                                <div id="custom-section-1">
                                                    <div class="container-full customer-header">
                                                        Assessment
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-4 mt-4">
                                                            <label class="required"><b>Severity</b></label>
                                                            <div class="row">
                                                                <div class="assesment-row">
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '1') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-1">
                                                                            No Effect
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '2') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-2">
                                                                            Very Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '3') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-3">
                                                                            Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '4') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-4">
                                                                            Moderate
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '5') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-5">
                                                                            High
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="severity" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['severity'] == '6') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-6">
                                                                            Very High
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mt-4">
                                                            <label class="required"><b>Occurance</b></label>
                                                            <div class="row">
                                                                <div class="assesment-row">
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '1') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-1">
                                                                            No Effect
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '2') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-2">
                                                                            Very Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '3') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-3">
                                                                            Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '4') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-4">
                                                                            Moderate
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '5') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-5">
                                                                            High
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="occurance" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['occurance'] == '6') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-6">
                                                                            Very High
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mt-4">
                                                            <label class="required"><b>Detection</b></label>
                                                            <div class="row">
                                                                <div class="assesment-row" style="border-right:none">
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '1') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-1">
                                                                            No Effect
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '2') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-2">
                                                                            Very Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '3') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-3">
                                                                            Minor
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '4') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-4">
                                                                            Moderate
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '5') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-5">
                                                                            High
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio-grid">
                                                                        <input type="radio" name="detection" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($risk['detection'] == '6') ?  "checked" : "";  ?>>
                                                                        <label class="btn btn-custom-level-6">
                                                                            Very High
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mt-4">
                                                        <label class="col-form-label col-md-3 mt-3"><b>Risk Priority
                                                                Number</b></label>
                                                        <div class="col-md-2">
                                                            <input type="number" class="form-control text-center" name="rpn_value" value="<?php echo $risk['rpn_value'];  ?>" id="rpn_value" required readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end::Form Content -->
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-4">
                                                        <?php if ($type != 'view') {
                                                        ?>
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                Update
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                        <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Content-->
                                        <input type="hidden" class="form-control" name="riskId" value="<?php echo $risk['id']; ?>">
                                        <input type="hidden" class="form-control" name="risk_id" value="<?php echo $risk['risk_id']; ?>">
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "active show" : "" ?>" id="mitigation" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/quality-risk-mitigation-update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mt-3">
                                                    <?php
                                                    if ($type != 'view') {
                                                    ?>
                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-sm btn-primary mb-4 me-2" data-bs-toggle="modal" data-bs-target="#mitigation_popup">
                                                                Add
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                    <table class="table table-row-dashed fs-4 gy-5">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <!--begin::Table row-->
                                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                                <th class="min-w-250px ps-4">
                                                                    Corrective Action</th>
                                                                <th class="min-w-100px ">
                                                                    Who</th>
                                                                <th class="w-120px">
                                                                    When</th>
                                                                <th class="w-100px">
                                                                    Status</th>
                                                                <?php
                                                                if ($type != 'view') {
                                                                ?>
                                                                    <th class="w-100px">
                                                                        Action</th>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <!--end::Table row-->
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <tbody class="fw-bold text-gray-600" id="mitigation-table">
                                                            <?php if ($mitigationPlan && count($mitigationPlan) > 0) {
                                                                foreach ($mitigationPlan as $key => $item) { ?>
                                                                    <tr style="font-size: 14px">
                                                                        <input type="hidden" class="form-control" name="mitigation_plan_id" value="<?php echo $item['id']; ?>">
                                                                        <td>
                                                                            <div class="mt-2">
                                                                                <input type="hidden" class="form-control" name="corrective_action" value="<?php echo $item['corrective_action']; ?>">
                                                                                <?php echo $item['corrective_action']; ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mt-2">
                                                                                <?php
                                                                                $sql_data = "SELECT * FROM Basic_Employee";
                                                                                $connect_data = mysqli_query($con, $sql_data);
                                                                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                                    if ($result_data['Status'] == 'Active') {
                                                                                        if ($item['who'] == $result_data['Id_employee']) {
                                                                                ?>

                                                                                            <input type="hidden" class="form-control" name="who" value="<?php echo $result_data['Id_employee']; ?>">
                                                                                <?php echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mt-2">
                                                                                <input type="hidden" class="form-control" name="when" value="<?php echo $item['date']; ?>">
                                                                                <?php echo $item['date']; ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="mt-2">
                                                                                <?php if ($item['status'] == '0') { ?>
                                                                                    <div class="badge badge-light-danger" onclick="changeApproval(this)" style="cursor: pointer">Open</div>
                                                                                    <input type="hidden" class="form-control plan-status" name="status" value="0">
                                                                                <?php } else { ?>
                                                                                    <div class="badge badge-light-success" onclick="changeApproval(this)" style="cursor: pointer">Closed</div>
                                                                                    <input type="hidden" class="form-control plan-status" name="status" value="1">
                                                                                <?php } ?>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                        if ($type != 'view') {
                                                                        ?>
                                                                            <td class="mitigation-actions" style="vertical-align:middle">
                                                                                <div class="mt-2">
                                                                                    <span class="edit-mitigation me-2" style="cursor: pointer"><i class="bi bi-pencil"></i></span>
                                                                                    <span class="delete-mitigation" style="cursor: pointer"> <i class="bi bi-trash"></i></span>
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
                                            <div class="container-full customer-header">
                                                Revised Assessment
                                            </div>
                                            <div class="row">
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <label class="required"><b>Severity</b></label>
                                                        <div class="row">
                                                            <div class="assesment-row">
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '1') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-1">
                                                                        No Effect
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '2') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-2">
                                                                        Very Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '3') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-3">
                                                                        Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '4') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-4">
                                                                        Moderate
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '5') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-5">
                                                                        High
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_severity" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_severity'] == '6') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-6">
                                                                        Very High
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="required"><b>Occurance</b></label>
                                                        <div class="row">
                                                            <div class="assesment-row">
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '1') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-1">
                                                                        No Effect
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '2') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-2">
                                                                        Very Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '3') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-3">
                                                                        Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '4') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-4">
                                                                        Moderate
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '5') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-5">
                                                                        High
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_occurance" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_occurance'] == '6') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-6">
                                                                        Very High
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="required"><b>Detection</b></label>
                                                        <div class="row">
                                                            <div class="assesment-row" style="border-right:none;">
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '1') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-1">
                                                                        No Effect
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '2') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-2">
                                                                        Very Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="3" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '3') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-3">
                                                                        Minor
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="4" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '4') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-4">
                                                                        Moderate
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="5" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '5') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-5">
                                                                        High
                                                                    </label>
                                                                </div>
                                                                <div class="radio-grid">
                                                                    <input type="radio" name="revised_detection" value="6" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($revisedRisk['revised_detection'] == '6') ?  "checked" : "";  ?>>
                                                                    <label class="btn btn-custom-level-6">
                                                                        Very High
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-4">
                                                    <label class="col-form-label col-md-3 mt-3"><b>Risk Priority
                                                            Number</b></label>
                                                    <div class="col-md-2">
                                                        <input type="number" class="form-control text-center" name="revised_rpn_value" value="<?php echo $revisedRisk['revised_rpn_value'];  ?>" id="revised_rpn_value" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container-full customer-header mt-3" id="approval-header">
                                                Approval
                                            </div>
                                            <div class="row" id="approval">
                                                <div class="row mt-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="required"><b>Decision</b></label>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6 mt-3">
                                                                    <input type="radio" class="decision" name="decision" value="1" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($approval['decision'] == '1') ?  "checked" : "";  ?>>
                                                                    <label style="color:green">
                                                                        Approved
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <input type="radio" class="decision" name="decision" value="2" required <?php echo $disabled ? "disabled" : ""  ?> <?php echo ($approval['decision'] == '2') ?  "checked" : "";  ?>>
                                                                    <label style="color:#e1261c">
                                                                        Rejected
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <label class="required"><b>Decision Remarks</b></label>
                                                            <input type="text" class="form-control decision_remarks" name="decision_remarks" required <?php echo $disabled ? "disabled" : ""  ?> value="<?php echo $approval['decision_remarks']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card-footer m-6">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <?php if ($type != 'view') {
                                                    ?>
                                                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a type="button" href="/quality-risk.php" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="quality_risk_id" id="quality_risk_id" value="<?php echo $risk['id']; ?>">
                                    </form>

                                    <!-- Mitigation Modal start -->
                                    <div class="modal right fade" id="mitigation_popup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="mitigation-form" class="form" enctype="multipart/form-data">
                                                <div class="modal-content">
                                                    <div class="modal-header right-modal">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Mitigation Plan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <input type="hidden" class="form-control" name="mitigationPlanId" id="mitigationPlanId" value="">
                                                                <label class="required">Corrective Action</label>
                                                                <textarea class="form-control" name="mitigationPlan" id="correctiveAction" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">Who</label>
                                                                <select class="form-control" name="mitigationWho" id="mitigationWho" required>
                                                                    <option value="">Please Select</option>
                                                                    <?php
                                                                    $sql_data = "SELECT * FROM Basic_Employee";
                                                                    $connect_data = mysqli_query($con, $sql_data);
                                                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {

                                                                    ?>
                                                                        <option value="<?php echo $result_data['Id_employee']; ?>">
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
                                                                <label class="required">When</label>
                                                                <input type="date" class="form-control" name="mitigationWhen" id="mitigationWhen" required>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mt-2">
                                                                <label class="required">Status</label>
                                                                <select class="form-control" name="mitigationStatus" id="mitigationStatus" required>
                                                                    <option value="0"> Open </option>
                                                                    <option value="1"> Closed </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-sm btn-success" id="mitigation-submit">Save</button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetValues();">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                    </div>

                                    <!-- Mitigation Modal End -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            $("input[name='severity']").click(function() {
                calculateRpn();
            });
            $("input[name='occurance']").click(function() {
                calculateRpn();
            });
            $("input[name='detection']").click(function() {
                calculateRpn();
            });
            $("input[name='revised_severity']").click(function() {
                calculateRevisedRpn();
            });
            $("input[name='revised_occurance']").click(function() {
                calculateRevisedRpn();
            });
            $("input[name='revised_detection']").click(function() {
                calculateRevisedRpn();
            });
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

        function calculateRpn() {
            var severity = $('input[name="severity"]:checked').val();
            var occurance = $('input[name="occurance"]:checked').val();
            var detection = $('input[name="detection"]:checked').val();
            if (severity != undefined && occurance != undefined && detection != undefined) {
                var rpn = Number(severity) * Number(occurance) * Number(detection);
                $("#rpn_value").val(rpn);
            }
        }

        function calculateRevisedRpn() {
            var revisedSeverity = $('input[name="revised_severity"]:checked').val();
            var revisedOccurance = $('input[name="revised_occurance"]:checked').val();
            var revisedDetection = $('input[name="revised_detection"]:checked').val();
            if (revisedSeverity != undefined && revisedOccurance != undefined && revisedDetection != undefined) {
                var rpn = Number(revisedSeverity) * Number(revisedOccurance) * Number(revisedDetection);
                $("#revised_rpn_value").val(rpn);
            }
        }

        $('.remove-tag').on('click', function() {
            return $(this).closest('div.tags').remove();
        });

        $('#mitigation-form').submit(function(e) {
            e.preventDefault();
            let quality_risk_id = $('#quality_risk_id').val();
            let mitigationPlanId = $('#mitigationPlanId').val();
            let correctiveAction = $('#correctiveAction').val();
            let mitigationStatus = $('#mitigationStatus').val();
            let mitigationWho = $('#mitigationWho').val();
            let mitigationWhen = $('#mitigationWhen').val();
            $.ajax({
                url: "includes/quality-risk-mitigation-table-add.php",
                type: "POST",
                dataType: "html",
                data: {
                    quality_risk_id: quality_risk_id,
                    mitigationPlanId: mitigationPlanId,
                    correctiveAction: correctiveAction,
                    mitigationStatus: mitigationStatus,
                    mitigationWho: mitigationWho,
                    mitigationWhen: mitigationWhen
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

        $('.delete-mitigation').on('click', function() {
            let mitigationPlanId = $(this).closest('tr').find('input[name="mitigation_plan_id"]').val();
            $.ajax({
                url: "includes/quality-risk-mitigation-table-delete.php",
                type: "POST",
                dataType: "html",
                data: {
                    mitigationPlanId: mitigationPlanId,
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

        $('.edit-mitigation').on('click', function() {
            let getData = getValue($(this).closest('tr'));
            let setData = setValue(getData);
            if (setData) {
                return $('#mitigation_popup').modal('show');
            }
        });

        function getValue(row) {
            let mitigationPlanId = $(row).find('input[name="mitigation_plan_id"]').val();
            let correctiveAction = $(row).find('input[name="corrective_action"]').val();
            let mitigationStatus = $(row).find('input[name="status"]').val();
            let mitigationWho = $(row).find('input[name="who"]').val();
            let mitigationWhen = $(row).find('input[name="when"]').val();
            return {
                mitigationPlanId,
                correctiveAction,
                mitigationStatus,
                mitigationWho,
                mitigationWhen
            }
        }

        function setValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#mitigationPlanId').val(dataArr.mitigationPlanId);
                $('#correctiveAction').val(dataArr.correctiveAction);
                $('#mitigationStatus').val(dataArr.mitigationStatus);
                $('#mitigationWho').val(dataArr.mitigationWho);
                $('#mitigationWhen').val(dataArr.mitigationWhen);
                return true;
            }
            return false;
        }

        function resetValues() {
            return setValue({
                mitigationPlanId: "",
                correctiveAction: "",
                mitigationStatus: "",
                mitigationWho: "",
                mitigationWhen: "",
            });
        }
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>