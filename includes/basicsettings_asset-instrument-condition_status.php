<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_instrument_condition, Status FROM Asset_Instrument_Condition WHERE Id_instrument_condition = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Asset_Instrument_Condition SET Status = 'Suspended' WHERE Id_instrument_condition = '$id' ";
	}
	else

	{
		$sql = "UPDATE Asset_Instrument_Condition SET Status = 'Active' WHERE Id_instrument_condition = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_asset-instrument-condition.php");

?>