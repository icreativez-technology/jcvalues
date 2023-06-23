<?php

session_start();
include('functions.php');


$id = $_REQUEST["pg_id"];
$sql_data = "SELECT * FROM Quality_MoC_Type WHERE Id_quality_moc_type = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] == "Active") {
	$sql = "UPDATE Quality_MoC_Type SET status = 'Suspended' WHERE Id_quality_moc_type = '$id' ";
} else {
	$sql = "UPDATE Quality_MoC_Type SET status = 'Active' WHERE Id_quality_moc_type = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_quality-moc.php");