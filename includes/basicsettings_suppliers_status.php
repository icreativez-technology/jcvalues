<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT Id_Supplier, Status FROM Basic_Supplier WHERE Id_Supplier = '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);


		if($result_data['Status'] == "Active")
		{
			$sql = "UPDATE Basic_Supplier SET Status = 'Suspended' WHERE Id_Supplier = '$id' ";
		}
		else
		{
			$sql = "UPDATE Basic_Supplier SET Status = 'Active' WHERE Id_Supplier = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_suppliers-panel.php");

?>