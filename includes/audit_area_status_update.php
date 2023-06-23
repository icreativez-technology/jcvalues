<?php

session_start();
include('functions.php');

$id = $_REQUEST["pg_id"];
$sql_data = "SELECT * FROM admin_audit_area WHERE id LIKE '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

if ($result_data['status'] == "Active") {
    $sql = "UPDATE admin_audit_area SET status = 'Suspended' WHERE id = '$id' ";
} else {
    $sql = "UPDATE admin_audit_area SET status = 'Active'WHERE id = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_audit_area.php");