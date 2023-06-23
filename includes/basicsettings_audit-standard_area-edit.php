<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
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
    $status = $_POST['status'];
    $auditee = $_POST['auditee'];
    $clauseArr = $_POST['clause'];
    $audit_pointArr = $_POST['audit_point'];
    $audit_checklist_idArr = $_POST['audit_checklist_id'];
    $updated = date("Y/m/d");

    var_dump($audit_checklist_idArr);
    var_dump($audit_pointArr);
    var_dump($clauseArr);

    $isExists = "SELECT * FROM audit_area WHERE Title = '$title' AND Id_audit_area != '$id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "UPDATE `audit_area` SET `Title` = '$title', `Id_audit_standard` = '$auditStandard', `Id_plant` = '$plant', `Id_product_group` = '$productGroup', `Id_department` = '$department', `audit_checklist_format_no` = '$auditChecklistFormatNo', `revision_number` = '$revisionNo', `finding_format_no` = '$findingFormatNo', `finding_revision_no` = '$findingRevisionNo', `Id_auditor` = '$auditor', `status` = '$status' , `updated_at` = '$updated' WHERE (`Id_audit_area` = '$id')";
        $result = mysqli_query($con, $sql_add);

        $deleteAuditeeSql = "DELETE FROM basic_auditee WHERE Id_audit_area = '$id'";
        $deleteAuditeeResult = mysqli_query($con, $deleteAuditeeSql);
        foreach ($auditee as $key => $row_id) {
            $insertAuditeeSql = "INSERT INTO `basic_auditee` (`Id_audit_area`, `emp_id`) VALUES ('$id', '$row_id')";
            $resultAuditee = mysqli_query($con, $insertAuditeeSql);
        }

        $deleteChecklistSql = "UPDATE basic_audit_checklist SET is_deleted = 1 WHERE Id_audit_area = '$id'";
        $deleteChecklistSqlResult = mysqli_query($con, $deleteChecklistSql);
        foreach ($audit_checklist_idArr as $key => $item) {
            $checklist_id = $audit_checklist_idArr[$key];
            $clause = $clauseArr[$key];
            $audit_point = $audit_pointArr[$key];

            if ($audit_checklist_idArr[$key] != "") {
                $checklistUpdateSql = "UPDATE basic_audit_checklist SET clause = '$clause', audit_point = '$audit_point', updated_at = '$updated', is_deleted = 0 WHERE Id_audit_checklist = '$checklist_id'";
                $checkListUpdateResult = mysqli_query($con, $checklistUpdateSql);
            } else {
                $addListSql = "INSERT INTO basic_audit_checklist (Id_audit_area, clause, audit_point) VALUES ('$id', '$clause', '$audit_point')";
                $addListConnect = mysqli_query($con, $addListSql);
            }
        }

        echo "<script type='text/javascript'>alert('Success!');</script>";

        header("Location: ../admin_audit-area.php");
    } else {
        header("Location: ../admin_audit-area-add.php?exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}