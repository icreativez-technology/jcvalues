<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_ncr_correction, Status FROM NCR_Correction WHERE Id_ncr_correction = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE NCR_Correction SET Status = 'Suspended' WHERE Id_ncr_correction = '$id' ";
	}
	else

	{
		$sql = "UPDATE NCR_Correction SET Status = 'Active' WHERE Id_ncr_correction = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_ncr-correction.php");

?>