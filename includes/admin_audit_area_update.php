<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $audit_area = $_POST["audit_area"];
        $admin_audit_area_id = $_POST["admin_audit_area_id"];
        $isExists = "SELECT * FROM admin_audit_area WHERE audit_area = '$audit_area' AND id != $admin_audit_area_id";
        $result = mysqli_query($con, $isExists);
        if ($result->num_rows == 0) {
            $audit_standard_id = $_POST["audit_standard_id"];
            $audit_check_list_format_no = $_POST["audit_check_list_format_no"];
            $revision_no = $_POST["revision_no"];
            $department_id = $_POST["department_id"];

            $updateSql = "UPDATE `admin_audit_area` SET `audit_area` = '$audit_area', `audit_standard_id` = '$audit_standard_id', `audit_check_list_format_no` = '$audit_check_list_format_no', `revision_no` = '$revision_no', `department_id` = '$department_id' WHERE (`id` = '$admin_audit_area_id')";
            $updateResult = mysqli_query($con, $updateSql);

            $deleteListSql = "UPDATE admin_audit_area_assign_check_list SET is_deleted = 1 WHERE admin_audit_area_id = '$admin_audit_area_id'";
            $deleteListSqlResult = mysqli_query($con, $deleteListSql);

            $clause = $_POST["clause"];
            $audit_point = $_POST["audit_point"];
            foreach ($clause as $key => $val) {
                $addListSql = "INSERT INTO admin_audit_area_assign_check_list (admin_audit_area_id, clause, audit_point) VALUES ('$admin_audit_area_id', '$clause[$key]', '$audit_point[$key]')";
                $addListConnect = mysqli_query($con, $addListSql);
            }

            $deleteAuditeeSql = "UPDATE admin_audit_area_assign_auditees SET is_deleted = 1 WHERE admin_audit_area_id = '$admin_audit_area_id'";
            $deleteAuditeeResult = mysqli_query($con, $deleteAuditeeSql);

            $auditee = $_POST["auditee"];
            foreach ($auditee as $key => $memberId) {
                $addMemberSql = "INSERT INTO admin_audit_area_assign_auditees (admin_audit_area_id, member_id) VALUES ('$admin_audit_area_id', '$memberId')";
                $addMemberSqlConnect = mysqli_query($con, $addMemberSql);
            }
            echo "<script type='text/javascript'>alert('Success!');</script>";
            header("Location: ../admin_audit_area.php");
        } else {
            header("Location: ../admin_audit_area_edit.php?exist");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}