<?php

session_start();
include('functions.php');

$id = $_REQUEST["pg_id"];
//$modified = date("Y/m/d");

$sql_data = "SELECT Id_quality_risk_source, status FROM Quality_Risk_Source WHERE Id_quality_risk_source = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] == "Active") {
	$sql = "UPDATE Quality_Risk_Source SET status = 'Suspended' WHERE Id_quality_risk_source = '$id' ";
} else {
	$sql = "UPDATE Quality_Risk_Source SET status = 'Active' WHERE Id_quality_risk_source = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_quality-risk-source.php");