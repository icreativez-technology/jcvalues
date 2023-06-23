<?php
session_start();
include('functions.php');

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$empId = $EmpInfo['Id_employee'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $audit_area = $_POST["audit_area"];
        $isExists = "SELECT * FROM admin_audit_area WHERE audit_area = '$audit_area'";
        $result = mysqli_query($con, $isExists);
        if ($result->num_rows == 0) {
            $audit_standard_id = $_POST["audit_standard_id"];
            $audit_check_list_format_no = $_POST["audit_check_list_format_no"];
            $revision_no = $_POST["revision_no"];
            $department_id = $_POST["department_id"];
            $created_by = $empId;

            $addSql = "INSERT INTO `admin_audit_area` (`audit_area`,`audit_standard_id`, `audit_check_list_format_no`, `revision_no`, `department_id`, `created_by`) VALUES ('$audit_area','$audit_standard_id', '$audit_check_list_format_no', '$revision_no', '$department_id', '$created_by')";
            $addResult = mysqli_query($con, $addSql);
            $addedId = mysqli_insert_id($con);

            $clause = $_POST["clause"];
            $audit_point = $_POST["audit_point"];
            foreach ($clause as $key => $val) {
                $addListSql = "INSERT INTO admin_audit_area_assign_check_list (admin_audit_area_id, clause, audit_point) VALUES ('$addedId', '$clause[$key]', '$audit_point[$key]')";
                $addListConnect = mysqli_query($con, $addListSql);
            }

            $auditee = $_POST["auditee"];
            foreach ($auditee as $key => $memberId) {
                $addMemberSql = "INSERT INTO admin_audit_area_assign_auditees (admin_audit_area_id, member_id) VALUES ('$addedId', '$memberId')";
                $addMemberSqlConnect = mysqli_query($con, $addMemberSql);
            }
            echo "<script type='text/javascript'>alert('Success!');</script>";
            header("Location: ../admin_audit_area.php");
        } else {
            header("Location: ../admin_audit_area_add.php?exist");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}