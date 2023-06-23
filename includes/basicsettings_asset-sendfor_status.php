<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_asset_send_for, Status FROM Asset_Send_For WHERE Id_asset_send_for = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Asset_Send_For SET Status = 'Suspended' WHERE Id_asset_send_for = '$id' ";
	}
	else

	{
		$sql = "UPDATE Asset_Send_For SET Status = 'Active' WHERE Id_asset_send_for = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_asset-sendfor.php");

?>