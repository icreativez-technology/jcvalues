<?php

	session_start();
	include('functions.php');

	$id = $_REQUEST["pg_id"];
	//$modified = date("Y/m/d");
	
	$sql_data = "SELECT Id_customer_diposition, Status FROM Customer_Disposition WHERE Id_customer_diposition = '$_REQUEST[pg_id]'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	if($result_data['Status'] == "Active")
	{
		$sql = "UPDATE Customer_Disposition SET Status = 'Suspended' WHERE Id_customer_diposition = '$id' ";
	}
	else

	{
		$sql = "UPDATE Customer_Disposition SET Status = 'Active' WHERE Id_customer_diposition = '$id' ";
	}
	
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";
	
	header("Location: ../admin_cm-disposition.php");

?>