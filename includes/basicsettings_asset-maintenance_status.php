<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_asset_type_of_maintenance, Status FROM Asset_Type_of_Maintenance WHERE Id_asset_type_of_maintenance = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Asset_Type_of_Maintenance SET Status = 'Suspended' WHERE Id_asset_type_of_maintenance = '$id' ";
	}
	else

	{
		$sql = "UPDATE Asset_Type_of_Maintenance SET Status = 'Active' WHERE Id_asset_type_of_maintenance = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_asset-maintenance.php");

?>