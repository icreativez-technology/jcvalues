<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $auditStandard = $_POST["audit_standard"];
    $plant = $_POST["plant"];
    $productGroup = $_POST["product_group"];
    $department = $_POST["department"];
    $auditChecklistFormatNo = $_POST["audit_checklist_format_no"];
    $revisionNo = $_POST["revision_number"];
    $findingFormatNo = $_POST["finding_format_no"];
    $findingRevisionNo = $_POST["finding_revision_no"];
    $auditor = $_POST['auditor'];
    $status = '1';
    $auditee = $_POST['auditee'];
    $clauseArr = $_POST['clause'];
    $audit_pointArr = $_POST['audit_point'];

    $isExists = "SELECT * FROM audit_area WHERE Title = '$title'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "INSERT INTO `audit_area` (`Title`, `Id_audit_standard`, `Id_plant`, `Id_product_group`, `Id_department`, `audit_checklist_format_no`, `revision_number`, `finding_format_no`, `finding_revision_no`, `Id_auditor`, `status`) VALUES ('$title', '$auditStandard', '$plant', '$productGroup', '$department', '$auditChecklistFormatNo', '$revisionNo', '$findingFormatNo', '$findingRevisionNo', '$auditor', '$status')";
        $result = mysqli_query($con, $sql_add);
        $insertedId = mysqli_insert_id($con);

        foreach ($auditee as $key => $id) {
            $insertAuditeeSql = "INSERT INTO `basic_auditee` (`Id_audit_area`, `emp_id`) VALUES ('$insertedId', '$id')";
            $resultAuditee = mysqli_query($con, $insertAuditeeSql);
        }

        foreach ($clauseArr as $key => $val) {
            $addListSql = "INSERT INTO basic_audit_checklist (Id_audit_area, clause, audit_point) VALUES ('$insertedId', '$clauseArr[$key]', '$audit_pointArr[$key]')";
            $addListConnect = mysqli_query($con, $addListSql);
        }

        echo "<script type='text/javascript'>alert('Success!');</script>";

        header("Location: ../admin_audit-area.php");
    } else {
        header("Location: ../admin_audit-area-add.php?exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}