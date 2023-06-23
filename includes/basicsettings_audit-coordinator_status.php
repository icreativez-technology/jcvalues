<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_audit_co_ordinator, status FROM audit_co_ordinator WHERE Id_audit_co_ordinator = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['status'] == 1)
	{
		$sql = "UPDATE audit_co_ordinator SET status = 0 WHERE Id_audit_co_ordinator = '$id' ";
	}
	else

	{
		$sql = "UPDATE audit_co_ordinator SET status = 1 WHERE Id_audit_co_ordinator = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_audit-coordinator.php");

?>