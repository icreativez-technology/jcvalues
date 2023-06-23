<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST['id'];
        $audit_nc_capa_id = $_POST['audit_nc_capa_ncr_id'];
        $closed_by = $_POST['closed_by'];
        $date = $_POST['date'];
        $departments = $_POST['departments'];
        if ($id == "") {
            $addSql = "INSERT INTO audit_nc_capa_verification (audit_nc_capa_ncr_details_id, closed_by, date) VALUES ('$audit_nc_capa_id', '$closed_by','$date')";
            $addResult = mysqli_query($con, $addSql);

            $deleteDepartmentSql = "UPDATE audit_nc_capa_verification_departments SET is_deleted = 1 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id'";
            $deleteDepartmentSqlResult = mysqli_query($con, $deleteDepartmentSql);
            foreach ($departments as $key => $departmentId) {
                $isExists = "SELECT id FROM audit_nc_capa_verification_departments WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND department_id = '$departmentId'";
                $result = mysqli_query($con, $isExists);
                if ($result->num_rows == 0) {
                    $addDepartmentSql = "INSERT INTO audit_nc_capa_verification_departments (audit_nc_capa_ncr_details_id, department_id) VALUES ('$audit_nc_capa_id', '$departmentId')";
                    $addDepartmentSqlResult = mysqli_query($con, $addDepartmentSql);
                } else {
                    $updateDepartmentSql = "UPDATE audit_nc_capa_verification_departments SET is_deleted = 0 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND department_id = '$departmentId'";
                    $updateDepartmentSqlResult = mysqli_query($con, $updateMemberSql);
                }
            }
        } else {
            $updateSql = "UPDATE audit_nc_capa_verification SET closed_by = '$closed_by', date = '$date' WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
            $deleteDepartmentSql = "UPDATE audit_nc_capa_verification_departments SET is_deleted = 1 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id'";
            $deleteDepartmentSqlResult = mysqli_query($con, $deleteDepartmentSql);
            foreach ($departments as $key => $departmentId) {
                $isExists = "SELECT id FROM audit_nc_capa_verification_departments WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND department_id = '$departmentId'";
                $result = mysqli_query($con, $isExists);
                if ($result->num_rows == 0) {
                    $addDepartmentSql = "INSERT INTO audit_nc_capa_verification_departments (audit_nc_capa_ncr_details_id, department_id) VALUES ('$audit_nc_capa_id', '$departmentId')";
                    $addDepartmentSqlResult = mysqli_query($con, $addDepartmentSql);
                } else {
                    $updateDepartmentSql = "UPDATE audit_nc_capa_verification_departments SET is_deleted = 0 WHERE audit_nc_capa_ncr_details_id = '$audit_nc_capa_id' AND department_id = '$departmentId'";
                    $updateDepartmentSqlResult = mysqli_query($con, $updateDepartmentSql);
                }
            }
        }
        $updateSql = "UPDATE audit_nc_capa_ncr_details SET status = 'Closed' WHERE id = '$audit_nc_capa_id'";
        $updateResult = mysqli_query($con, $updateSql);
        // echo "<script type='text/javascript'>alert('Success!');</script>";
        // header("Location: ../audit_nc_capa_view_list.php");
        echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}
