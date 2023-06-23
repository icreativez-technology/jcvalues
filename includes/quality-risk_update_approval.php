<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		$Decision = $_POST["decision"];
		$Decision_Remarks = $_POST["remarks"];

		//$file = $_POST["file_archivo"];
		

		//var_dump($_POST);
		//die();


			$sql = "UPDATE quality_risk SET Decision = '$Decision', Decision_Remarks = '$Decision_Remarks' WHERE Id_quality_risk = '$id' ";
			$result = mysqli_query($con, $sql);

			


			$location = "Location: ../quality-risk_view.php?pg_id=".$id;
			header($location);
		
	}

?>