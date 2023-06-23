<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT Id_employee, Status FROM Basic_Employee WHERE Id_employee LIKE '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);


		if($result_data['Status'] == "Active")
		{
			$sql = "UPDATE Basic_Employee SET Status = 'Suspended' WHERE Id_employee = '$id' ";
		}
		else
		{
			$sql = "UPDATE Basic_Employee SET Status = 'Active' WHERE Id_employee = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_user-panel.php");

?>