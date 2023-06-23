<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $employee_id = $_POST["coordinator"];
    $updated = date("Y/m/d");
    $status = $_POST["status"];
    $isExists = "SELECT * FROM audit_co_ordinator WHERE Id_Employee = '$employee_id' AND Id_audit_co_ordinator != '$id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "UPDATE audit_co_ordinator SET Id_Employee = '$employee_id', status = '$status', updated_at = '$updated' WHERE  Id_audit_co_ordinator = '$id'";
        $result = mysqli_query($con, $sql_add);
        header("Location: ../admin_audit-coordinator.php");
    } else {
        header("Location: ../admin_audit-coordinator-edit.php?id=" . $id . "&exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}