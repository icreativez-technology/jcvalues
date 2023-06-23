<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT Id_quality_impact_area, status FROM Quality_Impact_Area WHERE Id_quality_impact_area = '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);


		if($result_data['status'] == "Active")
		{
			$sql = "UPDATE Quality_Impact_Area SET status = 'Suspended' WHERE Id_quality_impact_area = '$id' ";
		}
		else
		{
			$sql = "UPDATE Quality_Impact_Area SET status = 'Active' WHERE Id_quality_impact_area = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_quality-impact.php");