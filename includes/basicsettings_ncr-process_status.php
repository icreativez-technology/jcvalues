<?php

session_start();
include('functions.php');


$id = $_REQUEST["pg_id"];
//$modified = date("Y/m/d");

$sql_data = "SELECT Id_ncr_process_type, status FROM NCR_Process_Type WHERE Id_ncr_process_type = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] == "Active") {
	$sql = "UPDATE NCR_Process_Type SET status = 'Suspended' WHERE Id_ncr_process_type = '$id' ";
} else {
	$sql = "UPDATE NCR_Process_Type SET status = 'Active' WHERE Id_ncr_process_type = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_ncr-process.php");