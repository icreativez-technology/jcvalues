<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT Id_customer, Status FROM Basic_Customer WHERE Id_customer = '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);


		if($result_data['Status'] == "Active")
		{
			$sql = "UPDATE Basic_Customer SET Status = 'Suspended' WHERE Id_customer = '$id' ";
		}
		else
		{
			$sql = "UPDATE Basic_Customer SET Status = 'Active' WHERE Id_customer = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_customers-panel.php");

?>