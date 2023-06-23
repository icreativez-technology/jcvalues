<?php

session_start();
include('functions.php');

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

$sqlExternal = "SELECT external_and_customer_audits.audit_area, external_and_customer_audits.audit_standard, external_and_customer_audits.auditor, Basic_Department.Department as department FROM external_and_customer_audits LEFT JOIN Basic_Department ON external_and_customer_audits.department_id = Basic_Department.Id_department WHERE audit_id = '$ncrDetailsData[audit_id]' AND is_deleted = 0";
$connectExternal = mysqli_query($con, $sqlExternal);
$auditData = mysqli_fetch_assoc($connectExternal);

$auditeeSqlData = "SELECT member_id, First_Name, Last_Name FROM external_and_customer_audit_assign_auditees LEFT JOIN Basic_Employee ON external_and_customer_audit_assign_auditees.member_id = Basic_Employee.Id_employee WHERE audit_id = '$ncrDetailsData[audit_id]' AND is_deleted = 0";
$auditeeConnectData = mysqli_query($con, $auditeeSqlData);
$auditeeData =  array();
while ($row = mysqli_fetch_assoc($auditeeConnectData)) {
    array_push($auditeeData, $row['member_id']);
}


$header = "Audit NC & CAPA - " . $ncrDetailsData['unique_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audit NC & CAPA</title>
    <script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
</head>

<style>
#element-to-print {
    padding: 0 !important;
    font-family: Poppins, Helvetica, sans-serif;
    height: 1080px;
}

#element-to-print * {
    font-family: Poppins, Helvetica, sans-serif !important;
}

#element-to-print .bordered-table-body td {
    padding-bottom: 3px;
    padding-top: 3px;
    font-size: 10px;
    color: black !important;
    font-weight: 200;
}

#element-to-print .bordered-table-body tr {
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
    border-bottom: none !important;
}

#element-to-print .bordered-table-body tr:last-child {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
}

#element-to-print p {
    font-size: 10px;
    font-weight: 300;
    color: black !important;
    margin-bottom: 3px;
}

#element-to-print .bg-title {
    background-color: #F1F9FF;
    font-weight: 700;
    color: black !important;
    font-size: 11px;
    padding-bottom: 3px;
}

#element-to-print .table-bordered tr td,
tr th {
    border: none;
    text-align: left;
    font-size: 10px;
}

#element-to-print .m-0 {
    margin: 0;
}

#element-to-print .fw-bold {
    font-size: 11px;
    font-weight: 700;
    color: black !important;
}

#element-to-print .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}

#element-to-print .footer p {
    font-size: 10px !important;
}
</style>

<body>
    <div id="element-to-print">
        <div class="d-flex justify-content-start">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>

        <!--Details-->
        <?php if ($audit['audit_type'] == "External") { ?>
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold"><?php echo $header ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($ncrDetailsData['created_at']) ? date("d/m/y", strtotime($ncrDetailsData['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-lg-12 p-1">

                <?php
                    $sql = "SELECT * FROM audit_nc_capa_external WHERE audit_nc_capa_id = '$_REQUEST[id]' AND is_deleted = 0";
                    $connect = mysqli_query($con, $sql);
                    $externalData = mysqli_fetch_assoc($connect);
                    ?>
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Audit ID</td>
                            <td class="fw-bold ">Audit Type</td>
                            <td class="fw-bold ">Audit Area</td>
                            <td class="fw-bold">Audit Standard</td>
                            <td class="fw-bold">Auditor</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($audit['unique_id']) ? $audit['unique_id'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($audit['audit_type']) ? $audit['audit_type'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditData['audit_area']) ? $auditData['audit_area'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditData['audit_standard']) ? $auditData['audit_standard'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditData['auditor']) ? $auditData['auditor'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Department</td>
                            <td class="fw-bold ">NCR Issue Date</td>
                            <td class="fw-bold ">Finding Type</td>
                            <td class="fw-bold">Product/Process Impact</td>
                            <td class="fw-bold">Clause</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($auditData['department']) ? $auditData['department'] : '-'; ?></td>
                            <td class="">
                                <?php echo isset($externalData['ncr_issue_date']) ? date("d-m-y", strtotime($externalData['ncr_issue_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($externalData['finding_type']) ? $externalData['finding_type'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($externalData['product_process_impact']) ?  $externalData['product_process_impact'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($externalData['clause']) ?  $externalData['clause'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Attachement</td>
                            <td class="fw-bold ps-2">Audit Point</td>
                            <td class="fw-bold">Object Evidence Details</td>
                            <td class="fw-bold" colspan="2">Non conformance Description</td>

                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($externalData['file_name']) ? $externalData['file_name'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($externalData['audit_point']) ? $externalData['audit_point'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($externalData['objective_evidence_details']) ? $externalData['objective_evidence_details'] : '-'; ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($externalData['non_conformance_description']) ? $externalData['non_conformance_description'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Auditee Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Auditee</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                        $sql_data = "SELECT * FROM Basic_Employee";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active') {
                                                if (in_array($result_data['Id_employee'], $auditeeData)) {
                                                    echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['First_Name'] . " " . $result_data['Last_Name'] . '</span>
												</div>
											</div>
										</li>';
                                                }
                                            }
                                        }
                                        ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php } else { ?>
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold"><?php echo $header ?></p>
            </div>
            <div class="col-lg-12 p-1">

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
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Audit ID</td>
                            <td class="fw-bold ">Audit Type</td>
                            <td class="fw-bold ">Audit Area</td>
                            <td class="fw-bold">Audit Standard</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($audit['unique_id']) ? $audit['unique_id'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($audit['audit_type']) ? $audit['audit_type'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditData['audit_area']) ? $auditData['audit_area'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditData['audit_standard']) ? $auditData['audit_standard'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Department</td>
                            <td class="fw-bold ">Finding Type</td>
                            <td class="fw-bold">Product/Process Impact</td>
                            <td class="fw-bold">Clause</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                    $sql_data = "SELECT * FROM Basic_Department";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    $department = "_";
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if ($auditData['department_id'] == $result_data['Id_department']) {
                                                $department =  $result_data['Department'];
                                            }
                                        }
                                    }
                                    echo $department;
                                    ?></td>
                            <td class="">
                                <?php echo isset($auditNcData['finding_type']) ? $auditNcData['finding_type'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditNcData['product_process_impact']) ?  $auditNcData['product_process_impact'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditNcData['clause']) ?  $auditNcData['clause'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Attachement</td>
                            <td class="fw-bold ps-2">Audit Point</td>
                            <td class="fw-bold">Object Evidence Details</td>
                            <td class="fw-bold">Non conformance Description</td>

                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($auditNcData['file_name']) ? $auditNcData['file_name'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditNcData['audit_point']) ? $auditNcData['audit_point'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditNcData['objective_evidence_details']) ? $auditNcData['objective_evidence_details'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditNcData['non_conformance_description']) ? $auditNcData['non_conformance_description'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Auditor Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Auditor</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                        $sql_data = "SELECT * FROM Basic_Employee";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active') {
                                                if (in_array($result_data['Id_employee'], $auditors)) {
                                                    echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['First_Name'] . " " . $result_data['Last_Name'] . '</span>
												</div>
											</div>
										</li>';
                                                }
                                            }
                                        }
                                        ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Auditee Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Auditee</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                        $sql_data = "SELECT * FROM Basic_Employee";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active') {
                                                if (in_array($result_data['Id_employee'], $auditees)) {
                                                    echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['First_Name'] . " " . $result_data['Last_Name'] . '</span>
												</div>
											</div>
										</li>';
                                                }
                                            }
                                        }
                                        ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>

        <!--Corrections Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Correction</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Correction</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($correctionData['correction']) ?  $correctionData['correction'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Analysis & CAPA</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Root Cause Analysis</td>
                            <td class="fw-bold ">Corrective Action(long term)</td>
                            <td class="fw-bold ">Recommended By</td>
                            <td class="fw-bold ">Date</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($analysisData['root_cause_analysis']) ?  $analysisData['root_cause_analysis'] : '-'; ?>
                            </td>

                            <td class="">
                                <?php echo isset($analysisData['corrective_action']) ? $analysisData['corrective_action'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Employee";
                                $connect_data = mysqli_query($con, $sql_data);
                                $recommended_by = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($analysisData['recommended_by'] == $result_data['Id_employee']) {
                                            $recommended_by =  $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                                        }
                                    }
                                }
                                echo $recommended_by;
                                ?>
                            </td>
                            <td>
                                <?php echo isset($analysisData['date']) ? date("d-m-y", strtotime($analysisData['date'])) : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Department Affected</td>
                            <td class="fw-bold ">Term</td>
                            <td class="fw-bold ">Risk Assesment</td>
                            <td class="fw-bold ">MoC</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
                                $connect_data = mysqli_query($con, $sql_data);
                                $dept = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($analysisData['department_affected'] == $result_data['Id_department']) {
                                        $dept  =  $result_data['Department'];
                                    }
                                }
                                echo $dept;
                                ?>
                            </td>

                            <td class="">
                                <?php echo isset($analysisData['term']) ? $analysisData['term'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($analysisData['risk_assessment']) ? $analysisData['risk_assessment'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($analysisData['moc']) ? $analysisData['moc']  : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--responsible Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Responsible</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                    $sql_data = "SELECT * FROM Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if (in_array($result_data['Id_employee'], $responsible)) {
                                                echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['First_Name'] . " " . $result_data['Last_Name'] . '</span>
												</div>
											</div>
										</li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Verification</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 33.3%">
                        <col span="1" style="width: 33.3%">
                        <col span="1" style="width: 33.3%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Corrective Action(long term)</td>
                            <td class="fw-bold ">Closed By</td>
                            <td class="fw-bold ">Date</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($analysisData['corrective_action']) ? $analysisData['corrective_action'] : '-'; ?>
                            </td>

                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Employee";
                                $connect_data = mysqli_query($con, $sql_data);
                                $closed_by = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($verificationData['closed_by'] == $result_data['Id_employee']) {
                                            $closed_by =  $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                                        }
                                    }
                                }
                                echo $closed_by;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($verificationData['date']) ? date("d-m-y", strtotime($verificationData['date'])) : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!--Distribution Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Distribution</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                    $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if (in_array($result_data['Id_department'], $department_data)) {
                                            echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['Department'] . '</span>
												</div>
											</div>
										</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-5">
                <p></p>
                <p>Page 1 of 1</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="JS/jquery-3.6.0.min.js"></script>

</html>