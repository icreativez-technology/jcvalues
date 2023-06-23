<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_finding_types, status FROM finding_types WHERE Id_finding_types = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['status'] == 1)
	{
		$sql = "UPDATE finding_types SET status = 0 WHERE Id_finding_types = '$id' ";
	}
	else

	{
		$sql = "UPDATE finding_types SET status = 1 WHERE Id_finding_types = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_audit-finding-type.php");

?>