<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = $_POST["coordinator"];
    $created = date("Y/m/d");
    $status = '1';
    $isExists = "SELECT * FROM audit_co_ordinator WHERE Id_Employee = '$employee_id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "INSERT INTO audit_co_ordinator (Id_Employee, status, created_at) VALUES ('$employee_id','$status','$created')";
        $result = mysqli_query($con, $sql_add);
        header("Location: ../admin_audit-coordinator.php");
    } else {
        header("Location: ../admin_audit-coordinator.php?exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}