<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];
		$return_id = $_POST["return_id"];

		$Sno = $_POST["Sno"];
		$Action_point = $_POST["Action_point"];
		$Id_employee = $_POST["Id_employee"];
		$Date_date = $_POST["Date_date"];
		$Verified = $_POST["Verified"];
		$Status = $_POST["Status"];

		$sql = "UPDATE Quality_MoC_Action SET Sno = '$Sno', Action_point = '$Action_point', Id_employee = '$Id_employee', Date_date = '$Date_date', Verified = '$Verified', Status = '$Status' WHERE Id_quality_moc_action = '$id' ";
		$result = mysqli_query($con, $sql);

		$location = "Location: ../quality-moc_actions.php?pg_id=".$return_id;
		header($location);

	}

?>