<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_ncr_disposition, Status FROM NCR_Disposition WHERE Id_ncr_disposition = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE NCR_Disposition SET Status = 'Suspended' WHERE Id_ncr_disposition = '$id' ";
	}
	else

	{
		$sql = "UPDATE NCR_Disposition SET Status = 'Active' WHERE Id_ncr_disposition = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_ncr-disposition.php");

?>