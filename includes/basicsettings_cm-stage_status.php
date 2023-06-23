<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_customer_stage_of_inspection, Status FROM Customer_Stage_of_Inspection WHERE Id_customer_stage_of_inspection = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Customer_Stage_of_Inspection SET Status = 'Suspended' WHERE Id_customer_stage_of_inspection = '$id' ";
	}
	else

	{
		$sql = "UPDATE Customer_Stage_of_Inspection SET Status = 'Active' WHERE Id_customer_stage_of_inspection = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_cm-stage.php");

?>