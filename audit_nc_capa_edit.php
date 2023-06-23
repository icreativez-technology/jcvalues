<?php
session_start();
include('includes/functions.php');

$page = 'Edit';
$disabled = 0;
if (isset($_REQUEST['view'])) {
    $disabled = 1;
    $page = 'View';
}

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$sqlNcr = "SELECT * FROM audit_nc_capa_ncr_details WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecNcr = mysqli_query($con, $sqlNcr);
$ncrDetailsData = mysqli_fetch_assoc($connecNcr);

$sql = "SELECT * FROM audit_management_list WHERE id = '$ncrDetailsData[audit_id]' AND is_deleted = 0";
$connect = mysqli_query($con, $sql);
$audit = mysqli_fetch_assoc($connect);

$_SESSION['Page_Title'] = $page ." Audit NC & CAPA - " . $ncrDetailsData['unique_id'];

$ncrDisabled = ($connecNcr->num_rows == 0) ? true : false;

$sqlCorrection = "SELECT * FROM audit_nc_capa_correction WHERE audit_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectCorrection = mysqli_query($con, $sqlCorrection);
$correctionData = mysqli_fetch_assoc($connectCorrection);

$correctionDisabled = ($connectCorrection->num_rows == 0) ? true : false;

$sqlAnalysis = "SELECT * FROM audit_nc_capa_analysis_ca WHERE audit_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectAnalysis = mysqli_query($con, $sqlAnalysis);
$analysisData = mysqli_fetch_assoc($connectAnalysis);

$analysisDisabled = ($connectAnalysis->num_rows == 0) ? true : false;

$sqlVerification = "SELECT * FROM audit_nc_capa_verification WHERE audit_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectVerification = mysqli_query($con, $sqlVerification);
$verificationData = mysqli_fetch_assoc($connectVerification);

$departmentsqlData = "SELECT * FROM audit_nc_capa_verification_departments WHERE audit_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$departmentData = mysqli_query($con, $departmentsqlData);
$department_data =  array();
while ($row = mysqli_fetch_assoc($departmentData)) {
    array_push($department_data, $row['department_id']);
}

$sqlData = "SELECT member_id, First_Name, Last_Name FROM audit_nc_capa_responsible LEFT JOIN Basic_Employee ON audit_nc_capa_responsible.member_id = Basic_Employee.Id_employee WHERE audit_nc_capa_ncr_details_id = '$_REQUEST[id]' AND audit_nc_capa_responsible.is_deleted = 0";
$data = mysqli_query($con, $sqlData);
$responsible =  array();
while ($row = mysqli_fetch_assoc($data)) {
    array_push($responsible, $row['member_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
.tab-disabled,
.ver-disabled input {
    background-color: #e9ecef !important;
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
                            <p><a href="/">Home</a> » <a href="/audit_nc_capa.php">Audit NC & CAPA</a> » <a
                                    href="/audit_nc_capa_view_list.php">Audit NC & CAPA View List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link <?php echo (isset($_GET['ncr'])) ? "active" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active" : ''; ?>"
                                    id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button"
                                    role="tab" aria-controls="details" aria-selected="true">NCR Details</button>
                            </li>
                            <li class="nav-item  <?php echo $ncrDisabled ? "tab-disabled" : "" ?>" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['correction'])) ? "active" : "" ?>"
                                    id="correction-tab" data-bs-toggle="tab" data-bs-target="#correction" type="button"
                                    role="tab" aria-controls="mitigation" aria-selected="false"
                                    <?php echo $ncrDisabled ? "disabled" : "" ?>>Correction</button>
                            </li>
                            <li class="nav-item <?php echo $correctionDisabled ? "tab-disabled" : "" ?>"
                                role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['analysisCa'])) ? "active" : "" ?>"
                                    id="analysis_capa_tab" data-bs-toggle="tab" data-bs-target="#analysis_capa"
                                    type="button" role="tab" aria-controls="analysis_capa" aria-selected="false"
                                    <?php echo $correctionDisabled ? "disabled" : "" ?>>Analysis & CAPA</button>
                            </li>
                            <li class="nav-item <?php echo $analysisDisabled ? "tab-disabled" : "" ?>"
                                role="presentation">
                                <button class="nav-link  <?php echo (isset($_GET['verification'])) ? "active" : "" ?>"
                                    id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification"
                                    type="button" role="tab" aria-controls="verification" aria-selected="false"
                                    <?php echo $analysisDisabled ? "disabled" : "" ?>>Verification</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['ncr'])) ? "active show" : "" ?> <?php echo (sizeof($_GET) == 1 || isset($_GET['view'])) ? "active show" : ''; ?>"
                                id="details" role="tabpanel" aria-labelledby="details-tab">
                                <div class="card card-flush">
                                    <?php if ($audit['audit_type'] == "External") {?>
                                        <?php
                                            $sql = "SELECT * FROM audit_nc_capa_external WHERE audit_nc_capa_id = '$_REQUEST[id]' AND is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $externalData = mysqli_fetch_assoc($connect);
                                        ?>
                                        <form class="form" action="includes/audit_nc_capa_update.php" method="post"
                                            enctype="multipart/form-data">
                                            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $ncrDetailsData['id']; ?>"/>
                                            <input type="hidden" class="form-control" name="audit_id" id="audit_id" value="<?php echo $ncrDetailsData['audit_id']; ?>"/>
                                            <input type="hidden" class="form-control" name="unique_id" id="unique_id" value="<?php echo $ncrDetailsData['unique_id']; ?>"/>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="required">Audit ID</label>
                                                        <input type="text" class="form-control" value="<?php echo $audit['unique_id']; ?>" disabled/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Type</label>
                                                        <input type="text" class="form-control" id="audit_type" value="<?php echo $audit['audit_type']; ?>" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Area</label>
                                                        <input type="text" class="form-control" id="audit_area" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Standard</label>
                                                        <input type="text" class="form-control" id="audit_standard" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Auditor</label>
                                                        <input type="text" class="form-control" id="auditor" disabled/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Department</label>
                                                        <input type="text" class="form-control" id="department" disabled/>
                                                    </div>
                                                    <div class="col-md-9 mt-5">
                                                        <label class="required">Auditee</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                                                            data-hide-search="true" id="auditee" data-select2-id="select2-data-7-oqcd" 
                                                            tabindex="-1" aria-hidden="true" disabled multiple>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 mt-5">
                                                        <label class="required">NCR issue Date</label>
                                                        <input type="date" class="form-control" name="ncr_issue_date" value="<?php echo $externalData['ncr_issue_date']; ?>" required <?php echo ($disabled == 1) ? "disabled" : "" ?>/>
                                                    </div>
                                                    <div class="col-md-2 mt-5">
                                                        <label class="required">Finding Type</label>
                                                        <select class="form-control" name="finding_type" required <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <option value="">Please Select</option>
                                                            <option value="Minor" <?php echo $externalData['finding_type'] == "Minor" ? "selected" : ""; ?>>Minor</option>
                                                            <option value="Major" <?php echo $externalData['finding_type'] == "Major" ? "selected" : ""; ?>>Major</option>
                                                            <option value="Observation" <?php echo $externalData['finding_type'] == "Observation" ? "selected" : ""; ?>>Observation</option>
                                                        </select>
                                                    </div>
                                                    <?php if ($disabled == 0) { ?>
                                                        <div class="col-md-3 mt-5">
                                                            <label>File Upload</label>
                                                            <input type="file" class="form-control" name="file" accept=".pdf" />
                                                        </div>
                                                    <?php } ?>
                                                    <?php if($externalData['file_path']) {?>
                                                        <div class="col-md-3 mt-6">
                                                            <div class="custom-select mt-6">
                                                                <div class="tag-wrapper">
                                                                    <div class="tags">
                                                                        <a href="<?php echo $externalData['file_path']; ?>"
                                                                            target="_blank"><?php echo $externalData['file_name']; ?></a>
                                                                        <input type="hidden" class="form-control" name="ext_file_path"
                                                                            value="<?php echo $externalData['file_path']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <div class="col-md-2 mt-5">
                                                        <label class="required">Product / Process Impact</label>
                                                        <div class="row">
                                                            <div class="col-md-6 mt-5">
                                                                <input type="radio" value="Yes" name="product_process_impact"
                                                                    class="form-check-input" required <?php echo $externalData['product_process_impact'] == "Yes" ? "checked" : ""; ?> <?php echo ($disabled == 1) ? "disabled" : "" ?>/>
                                                                <label class="form-check-label">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 mt-5">
                                                                <input type="radio" value="No" name="product_process_impact"
                                                                    class="form-check-input" required <?php echo $externalData['product_process_impact'] == "No" ? "checked" : ""; ?> <?php echo ($disabled == 1) ? "disabled" : "" ?>/>
                                                                <label class="form-check-label">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Clause</label>
                                                        <input type="text" class="form-control" name="clause" required value="<?php echo $externalData['clause']; ?>" <?php echo ($disabled == 1) ? "disabled" : "" ?>/>
                                                    </div>
                                                    <div class="col-md-9 mt-5">
                                                        <label class="required">Audit Point</label>
                                                        <textarea type="text" class="form-control" name="audit_point" rows="1"
                                                            required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $externalData['audit_point']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-5">
                                                        <label class="required">Object Evidence Details</label>
                                                        <textarea type="text" class="form-control" name="objective_evidence_details"
                                                            rows="1" required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $externalData['objective_evidence_details']; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6 mt-5">
                                                        <label class="required">Non conformance Description</label>
                                                        <textarea type="text" class="form-control"
                                                            name="non_conformance_description" rows="1" required <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $externalData['non_conformance_description']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($disabled == 0) { ?>
                                            <div class="card-footer m-6">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-6">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            Update
                                                        </button>
                                                        <a type="button" href="/audit_nc_capa_view_list.php"
                                                            class="btn btn-sm btn-secondary ms-2">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    <?php } else { ?>
                                        <?php
                                            $sql = "SELECT * FROM internal_audits WHERE audit_id = '$audit[id]' AND is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $internalAudit = mysqli_fetch_assoc($connect);
                                            $auditAreaId = $internalAudit['audit_area_id'];
                                            $sql = "SELECT * FROM admin_audit_area LEFT JOIN admin_audit_standard ON admin_audit_standard.id = admin_audit_area.audit_standard_id WHERE admin_audit_area.id = '$auditAreaId' AND admin_audit_area.is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $auditData = mysqli_fetch_assoc($connect);
                                            $sql = "SELECT member_id, First_Name, Last_Name FROM admin_audit_area_assign_auditees LEFT JOIN Basic_Employee ON admin_audit_area_assign_auditees.member_id = Basic_Employee.Id_employee WHERE admin_audit_area_id = '$auditAreaId' AND admin_audit_area_assign_auditees.is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $auditees = array();
                                            while ($row = mysqli_fetch_assoc($connect)) {
                                                array_push($auditees, $row['member_id']);
                                            }
                                            $sql = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$auditData[audit_standard_id]' AND is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $auditors = array();
                                            while ($row = mysqli_fetch_assoc($connect)) {
                                                array_push($auditors, $row['member_id']);
                                            }
                                            $sql = "SELECT * FROM audit_management_execute_check_list LEFT JOIN admin_audit_area_assign_check_list ON audit_management_execute_check_list.audit_area_check_list_id = admin_audit_area_assign_check_list.id WHERE anc_id = '$_REQUEST[id]' AND audit_management_execute_check_list.is_deleted = 0";
                                            $connect = mysqli_query($con, $sql);
                                            $auditNcData = mysqli_fetch_assoc($connect);
                                        ?>
                                        <form class="form" method="post"
                                            enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="required">Audit ID</label>
                                                        <input type="text" class="form-control" value="<?php echo $audit['unique_id']; ?>" disabled/>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Type</label>
                                                        <input type="text" class="form-control" id="audit_type" value="<?php echo $audit['audit_type']; ?>" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Area</label>
                                                        <input type="text" class="form-control" value="<?php echo $auditData['audit_area']; ?>" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Audit Standard</label>
                                                        <input type="text" class="form-control" value="<?php echo $auditData['audit_standard']; ?>" disabled/>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Auditor</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                                                            data-hide-search="true" data-select2-id="select2-data-7-oqzx"
                                                            tabindex="-1" aria-hidden="true" multiple disabled>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option
                                                                <?php echo (in_array($result_data['Id_employee'], $auditors)) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Department</label>
                                                        <select class="form-control" disabled>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Department";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option
                                                                <?php echo ($auditData['department_id'] == $result_data['Id_department']) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['Department']; ?>
                                                            </option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 mt-5">
                                                        <label class="required">Auditee</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2"
                                                            data-hide-search="true" data-select2-id="select2-data-7-oqew"
                                                            tabindex="-1" aria-hidden="true" multiple disabled>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>"
                                                                <?php echo (in_array($result_data['Id_employee'], $auditees)) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-2 mt-5">
                                                        <label class="required">Finding Type</label>
                                                        <input type="text" class="form-control" value="<?php echo $auditNcData['finding_type']; ?>" disabled/>
                                                    </div>
                                                    <?php if($auditNcData['file_path']) {?>
                                                        <div class="col-md-3 mt-5">
                                                            <label class="required">Uploaded File</label>
                                                            <div class="custom-select mt-2">
                                                                <div class="tag-wrapper">
                                                                    <div class="tags">
                                                                        <a href="<?php echo $auditNcData['file_path']; ?>"
                                                                            target="_blank"><?php echo $auditNcData['file_name']; ?></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <div class="col-md-2 mt-5">
                                                        <label class="required">Product / Process Impact</label>
                                                        <div class="row">
                                                            <div class="col-md-6 mt-5">
                                                                <input type="radio" value="Yes" name="product_process_impact"
                                                                    class="form-check-input" required <?php echo $auditNcData['product_process_impact'] == "Yes" ? "checked" : ""; ?> disabled/>
                                                                <label class="form-check-label">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 mt-5">
                                                                <input type="radio" value="No" name="product_process_impact"
                                                                    class="form-check-input" <?php echo $auditNcData['product_process_impact'] == "No" ? "checked" : ""; ?> disabled/>
                                                                <label class="form-check-label">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Clause</label>
                                                        <input type="text" class="form-control" value="<?php echo $auditNcData['clause']; ?>" disabled/>
                                                    </div>
                                                    <div class="col-md-9 mt-5">
                                                        <label class="required">Audit Point</label>
                                                        <textarea type="text" class="form-control" rows="1" disabled><?php echo $auditNcData['audit_point']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-5">
                                                        <label class="required">Object Evidence Details</label>
                                                        <textarea type="text" class="form-control" rows="1" disabled><?php echo $auditNcData['objective_evidence']; ?></textarea>
                                                    </div>
                                                    <div class="col-md-6 mt-5">
                                                        <label class="required">Non conformance Description</label>
                                                        <textarea type="text" class="form-control" rows="1" disabled><?php echo $auditNcData['finding_details']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['correction'])) ? "active show" : "" ?>"
                                id="correction" role="tabpanel" aria-labelledby="mitigation-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/audit_nc_capa_correction.update.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row mt-4">
                                                <input type="hidden" class="form-control" name="audit_nc_capa_ncr_id"
                                                    value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id"
                                                    value="<?php echo $correctionData['id'] ?>">
                                                <div class="col-md-12">
                                                    <label class="required">Correction</label>
                                                    <textarea type="text" class="form-control" name="correction"
                                                        rows="1" value="<?php echo $correctionData['correction'] ?>"
                                                        required
                                                        <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $correctionData['correction'] ?></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer m-6">
                                            <?php if ($disabled == 0) { ?>
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-6">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/audit_nc_capa_view_list.php"
                                                        class="btn btn-sm btn-secondary ms-2">Close</a>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['analysisCa'])) ? "active show" : "" ?>"
                                id="analysis_capa" role="tabpanel" aria-labelledby="analysis_capa-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/audit_nc_capa_analysis_ca_update.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row">
                                                <input type="hidden" class="form-control" name="audit_nc_capa_ncr_id"
                                                    value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id"
                                                    value="<?php echo $analysisData['id'] ?>">
                                                <div class="row">
                                                    <div class="col-md-12 mt-5">
                                                        <label class="required">Root Cause Analysis</label>
                                                        <textarea type="text" class="form-control"
                                                            name="root_cause_analysis" rows="1"
                                                            value="<?php echo $analysisData['root_cause_analysis'] ?>"
                                                            required
                                                            <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $analysisData['root_cause_analysis'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-5">
                                                        <label class="required">Corrective Action (long term)</label>
                                                        <textarea type="text" class="form-control"
                                                            name="corrective_action" rows="1"
                                                            value="<?php echo $analysisData['corrective_action'] ?>"
                                                            required
                                                            <?php echo ($disabled == 1) ? "disabled" : "" ?>><?php echo $analysisData['corrective_action'] ?></textarea>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Recommended by</label>
                                                        <select class="form-control" name="recommended_by" required
                                                            <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>"
                                                                <?php echo ($analysisData['recommended_by'] == $result_data['Id_employee']) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Date</label>
                                                        <input type="date" class="form-control" name="date"
                                                            value="<?php echo ($disabled == 1) ? $analysisData['date'] : date('Y-m-d') ?>"
                                                            required <?php echo ($disabled == 1) ? "disabled" : "" ?>
                                                            <?php echo ($disabled == 1) ? "" : "readonly" ?> />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Department Affected</label>
                                                        <select class="form-control" name="department_affected" required
                                                            <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_department']; ?>"
                                                                <?php echo ($analysisData['department_affected'] == $result_data['Id_department']) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['Department']; ?>
                                                            </option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Term</label>
                                                        <input type="date" class="form-control" name="term"
                                                            value="<?php echo $analysisData['term'] ?>" required
                                                            <?php echo ($disabled == 1) ? "disabled" : "" ?> />
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">Risk Assessment</label>
                                                        <div class="row">
                                                            <div class="col-md-6 mt-4">
                                                                <input type="radio" value="Yes" name="risk_assessment"
                                                                    <?php echo ($analysisData['risk_assessment'] == 'Yes') ? 'checked' : ''; ?>
                                                                    class="form-check-input" required
                                                                    <?php echo ($disabled == 1) ? "disabled" : "" ?> />
                                                                <label class="form-check-label">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 mt-4">
                                                                <input type="radio" value="No" name="risk_assessment"
                                                                    class="form-check-input"
                                                                    <?php echo ($analysisData['risk_assessment'] == 'No') ? 'checked' : ''; ?>
                                                                    required
                                                                    <?php echo ($disabled == 1) ? "disabled" : "" ?> />
                                                                <label class="form-check-label">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <label class="required">MOC</label>
                                                        <div class="row">
                                                            <div class="col-md-6 mt-4">
                                                                <input type="radio" value="Yes" name="moc"
                                                                    class="form-check-input"
                                                                    <?php echo ($analysisData['moc'] == 'Yes') ? 'checked' : ''; ?>
                                                                    required
                                                                    <?php echo ($disabled == 1) ? "disabled" : "" ?> />
                                                                <label class="form-check-label">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6 mt-4">
                                                                <input type="radio" value="No" name="moc"
                                                                    class="form-check-input"
                                                                    <?php echo ($analysisData['moc'] == 'No') ? 'checked' : ''; ?>
                                                                    required
                                                                    <?php echo ($disabled == 1) ? "disabled" : "" ?> />
                                                                <label class="form-check-label">
                                                                    No
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mt-5">
                                                        <label class="required">Responsible</label>
                                                        <select
                                                            class="form-control form-select-solid select2-hidden-accessible"
                                                            data-control="select2" data-hide-search="true"
                                                            data-placeholder="Select responsible persons"
                                                            name="responsible[]" data-select2-id="select2-data-7-oqw7"
                                                            tabindex="-1" aria-hidden="true" required multiple>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                            ?>
                                                            <option value="<?php echo $result_data['Id_employee']; ?>"
                                                                <?php echo (in_array($result_data['Id_employee'], $responsible)) ? 'selected' : ''; ?>>
                                                                <?php echo $result_data['First_Name']; ?>
                                                                <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer m-6">
                                            <?php if ($disabled == 0) { ?>
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <a type="button" href="/audit_nc_capa_view_list.php"
                                                        class="btn btn-sm btn-secondary ms-2">Cancel</a>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade <?php echo (isset($_GET['verification'])) ? "active show" : "" ?>"
                                id="verification" role="tabpanel" aria-labelledby="verification-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/audit_nc_capa_verification_update.php"
                                        method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div class="row mt-2">
                                                <input type="hidden" class="form-control" name="audit_nc_capa_ncr_id"
                                                    value="<?php echo $ncrDetailsData['id'] ?>">
                                                <input type="hidden" class="form-control" name="id"
                                                    value="<?php echo $verificationData['id'] ?>">
                                                <div class="col-md-4">
                                                    <label class="required">Corrective Action (long term)</label>
                                                    <input type="text" class="form-control" name="corrective_action"
                                                        value="<?php echo $analysisData['corrective_action'] ?>"
                                                        disabled />
                                                </div>
                                                <div class=" col-md-4">
                                                    <label class="required">Closed By</label>
                                                    <select class="form-control" name="closed_by" required
                                                        <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        $sql_data = "SELECT * FROM Basic_Employee";
                                                        $connect_data = mysqli_query($con, $sql_data);
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            if ($result_data['Status'] == 'Active') {
                                                        ?>
                                                        <option value="<?php echo $result_data['Id_employee']; ?>"
                                                            <?php echo ($verificationData['closed_by'] == $result_data['Id_employee']) ? 'selected' : ''; ?>>
                                                            <?php echo $result_data['First_Name']; ?>
                                                            <?php echo $result_data['Last_Name']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="required">Date</label>
                                                    <input type="date" class="form-control" name="date"
                                                        value="<?php echo ($disabled == 1) ? $verificationData['date'] : date('Y-m-d') ?>"
                                                        required <?php echo ($disabled == 1) ? "disabled" : "" ?>
                                                        <?php echo ($disabled == 1) ? "" : "readonly" ?> />
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label class="required">Distribution</label>
                                                    <select
                                                        class="form-control form-select-solid select2-hidden-accessible"
                                                        data-control="select2" data-hide-search="true"
                                                        data-placeholder="Select Departments" name="departments[]"
                                                        data-select2-id="select2-data-7-oqww" tabindex="-1"
                                                        aria-hidden="true" required multiple
                                                        <?php echo ($disabled == 1) ? "disabled" : "" ?>>
                                                        <option value="">Please Select</option>
                                                        <?php
                                                        $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
                                                        $connect_data = mysqli_query($con, $sql_data);
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                        ?>
                                                        <option value="<?php echo $result_data['Id_department']; ?>"
                                                            <?php echo (in_array($result_data['Id_department'], $department_data)) ? 'selected' : ''; ?>>
                                                            <?php echo $result_data['Department']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer m-6">
                                            <?php if ($disabled == 0) { ?>
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                                    <a type="button" href="/audit_nc_capa_view_list.php"
                                                        class="btn btn-sm btn-secondary ms-2">Cancel</a>
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
    </div>
    <?php include('includes/footer.php'); ?>
    </div>
    </div>
    </div>
    <?php include('includes/scrolltop.php'); ?>
    <script>
    $('.remove-tag').on('click', function() {
        return $(this).closest('div.tags').remove();
    });
     $(document).ready(function() {
        let audit_type = document.getElementById("audit_type").value;
        if (audit_type == "External") {
            getData();
        };
    });
    function getData() {
        $("#audit_area").val("");
        $("#audit_standard").val("");
        $("#auditor").val("");
        $("#department").val("");
        $("#auditee option").remove();
        let audit_id = document.getElementById("audit_id").value;
        if (audit_id != "") {
            const data = {
                audit_id: audit_id
            }
            $.ajax({
                type: 'POST',
                url: 'includes/get_external_audit_management.php',
                data: data
            })
            .done(function(result) {
                var dataArr = JSON.parse(result);
                var auditData = dataArr.auditData;
                var auditeeData = dataArr.auditeeData;
                $("#audit_area").val(auditData.audit_area);
                $("#audit_standard").val(auditData.audit_standard);
                $("#auditor").val(auditData.auditor);
                $("#department").val(auditData.department);
                $.each(auditeeData, function(index, value) {
                    $("#auditee").append(`<option selected>${value.First_Name} ${value.Last_Name}</option>`);
                });
            });
        }
    }
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
</body>

</html>