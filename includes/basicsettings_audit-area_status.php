<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_audit_area, Status FROM audit_area WHERE Id_audit_area = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == 1)
	{
		$sql = "UPDATE audit_area SET Status = 0 WHERE Id_audit_area = '$id' ";
	}
	else

	{
		$sql = "UPDATE audit_area SET Status = 1 WHERE Id_audit_area = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_audit-area.php");

?>