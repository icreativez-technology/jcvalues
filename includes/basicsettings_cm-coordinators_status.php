<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_customer_inspection_co_ordinator, Status FROM Customer_Inspection_Co_Ordinator WHERE Id_customer_inspection_co_ordinator = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Customer_Inspection_Co_Ordinator SET Status = 'Suspended' WHERE Id_customer_inspection_co_ordinator = '$id' ";
	}
	else

	{
		$sql = "UPDATE Customer_Inspection_Co_Ordinator SET Status = 'Active' WHERE Id_customer_inspection_co_ordinator = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_cm-coordinators.php");

?>