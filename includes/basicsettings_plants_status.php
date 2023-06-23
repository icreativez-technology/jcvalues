<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		$modified = date("Y/m/d");
		
		 $sql_data = "SELECT Id_plant, Title, Created, Modified, Status FROM Basic_Plant WHERE Id_plant LIKE '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);


		if($result_data['Status'] == "Active")
		{
			$sql = "UPDATE Basic_Plant SET Status = 'Suspended', Modified = '$modified' WHERE Id_plant = '$id' ";
		}
		else
		{
			$sql = "UPDATE Basic_Plant SET Status = 'Active', Modified = '$modified' WHERE Id_plant = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_plants-panel.php");

?>