<?php

session_start();
include('functions.php');

$areaDetailsData = null;
$auditeeMembers =  array();
$auditors =  array();
$lists =  array();

$sqlAudit = "SELECT * FROM audit_management_list WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecAudit = mysqli_query($con, $sqlAudit);
$auditDetailsData = mysqli_fetch_assoc($connecAudit);

$sqlInternal = "SELECT * FROM internal_audits WHERE audit_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectInternal = mysqli_query($con, $sqlInternal);
$internalAuditData = mysqli_fetch_assoc($connectInternal);

$auditAreaId = isset($_REQUEST['area_id']) ? $_REQUEST['area_id'] : $internalAuditData['audit_area_id'];

if ($auditAreaId != null && $auditAreaId != "") {
    $sqlArea = "SELECT * FROM admin_audit_area LEFT JOIN admin_audit_standard ON admin_audit_standard.id = admin_audit_area.audit_standard_id WHERE admin_audit_area.id = '$auditAreaId' AND admin_audit_area.is_deleted = 0";
    $connectArea = mysqli_query($con, $sqlArea);
    $areaDetailsData = mysqli_fetch_assoc($connectArea);

    $existingAuditeeSqlData = "SELECT member_id, First_Name, Last_Name FROM admin_audit_area_assign_auditees LEFT JOIN Basic_Employee ON admin_audit_area_assign_auditees.member_id = Basic_Employee.Id_employee WHERE admin_audit_area_id = '$auditAreaId' AND admin_audit_area_assign_auditees.is_deleted = 0";
    $auditeeMembersConnect = mysqli_query($con, $existingAuditeeSqlData);
    while ($row = mysqli_fetch_assoc($auditeeMembersConnect)) {
        array_push($auditeeMembers, $row['member_id']);
    }

    $auditorsSqlData = "SELECT * FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$areaDetailsData[audit_standard_id]' AND is_deleted = 0";
    $auditorsSqlConnect = mysqli_query($con, $auditorsSqlData);
    while ($row = mysqli_fetch_assoc($auditorsSqlConnect)) {
        array_push($auditors, $row['member_id']);
    }

    $listSqlData = "SELECT * FROM admin_audit_area_assign_check_list WHERE is_deleted = 0 AND admin_audit_area_id = '$auditAreaId'";
    $listData = mysqli_query($con, $listSqlData);
    while ($row = mysqli_fetch_assoc($listData)) {
        array_push($lists, $row);
    }
}


$executionSql = "SELECT * FROM audit_management_execute_check_list WHERE is_deleted = 0 AND audit_id = '$_REQUEST[id]'";
$executionData = mysqli_query($con, $executionSql);
$executeArr = array();
while ($row = mysqli_fetch_assoc($executionData)) {
    array_push($executeArr, $row);
}

$header = "Audit Management - " . $auditDetailsData['unique_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meeting</title>
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
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold"><?php echo $header ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($auditDetailsData['created_at']) ? date("d/m/y", strtotime($auditDetailsData['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-lg-12 p-1">
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
                            <td class="fw-bold ps-2">Audit Type</td>
                            <td class="fw-bold ">Audit Area</td>
                            <td class="fw-bold ">Audit Checklist No</td>
                            <td class="fw-bold">Audit Checklist Revision</td>
                            <td class="fw-bold">Audit Standard</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                Internal
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM admin_audit_area WHERE status = 'Active' AND is_deleted = 0";
                                $connect_data = mysqli_query($con, $sql_data);
                                $audit_area = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($areaDetailsData != null && $auditAreaId == $result_data['id']) {
                                        $audit_area = $result_data['audit_area'];
                                    }
                                }
                                echo $audit_area;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($areaDetailsData['audit_check_list_format_no']) ?  $areaDetailsData['audit_check_list_format_no']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($areaDetailsData['revision_no']) ?  $areaDetailsData['revision_no']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($areaDetailsData['audit_standard']) ?  $areaDetailsData['audit_standard']  : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Department</td>
                            <td class="fw-bold ">Finding Format No</td>
                            <td class="fw-bold ">Finding Revision No</td>
                            <td class="fw-bold">Audit Schedule Start Date</td>
                            <td class="fw-bold ps-2">Audit Schedule End Date</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Department";
                                $connect_data = mysqli_query($con, $sql_data);
                                $department = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($areaDetailsData && $areaDetailsData['department_id'] == $result_data['Id_department']) {
                                            $department =  $result_data['Department'];
                                        }
                                    }
                                }
                                echo $department;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($internalAuditData['finding_format_no']) ?  $internalAuditData['finding_format_no']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($internalAuditData['revision_no']) ?  $internalAuditData['revision_no']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditDetailsData['start_date']) ?   date("d-m-y", strtotime($auditDetailsData['start_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($auditDetailsData['end_date']) ?  date("d-m-y", strtotime($auditDetailsData['end_date']))  : '-'; ?>
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
                                            if (in_array($result_data['Id_employee'], $auditeeMembers)) {
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


        <!--Discussion Notes Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Assign Checklist</p>
            </div>
            <div class="col-12 p-1">
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
                            <td class="fw-bold ps-2">Clause</td>
                            <td class="fw-bold ">Audit Point</td>
                            <td class="fw-bold ">Objective Evidence</td>
                            <td class="fw-bold ">IsNcR</td>
                            <td class="fw-bold ">Attachment</td>
                        </tr>
                        <?php if ($lists && count($lists) > 0) {
                            foreach ($lists as $key => $list) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($list['clause']) ?  $list['clause'] : '-'; ?></td>
                            <td class="">
                                <?php echo isset($list['audit_point']) ?  $list['audit_point'] : '-'; ?></td>
                            </td>
                            <?php
                                    $sqlExecutionList = "SELECT * FROM audit_management_execute_check_list WHERE audit_id = '$_REQUEST[id]' AND audit_area_check_list_id = '$list[id]' AND is_deleted = 0";
                                    $connectExe = mysqli_query($con, $sqlExecutionList);
                                    $executionData = mysqli_fetch_assoc($connectExe);
                                    ?>
                            <td class="">
                                <?php echo isset($executionData['objective_evidence']) ? $executionData['objective_evidence'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                        $isNcr = "-";
                                        if ($executionData) {
                                            $isNcr =  $executionData['is_ncr'] == '1' ? "Yes" : "No";
                                        }
                                        echo $isNcr;
                                        ?>
                            </td>
                            <td class="">
                                <?php
                                        $ncrPdf = "-";
                                        if ($executionData && $executionData['file_name'] != "") {
                                            $ncrPdf  =   $executionData['file_name'];
                                        }
                                        echo $ncrPdf;
                                        ?>
                            </td>
                        </tr>
                        <?php }
                        }
                        ?>
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