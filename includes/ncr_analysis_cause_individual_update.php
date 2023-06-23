<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];
		$return_id = $_POST["return_id"];

		$Category = $_POST["Category"];
		$Cause = $_POST["Cause"];
		$Significant = $_POST["Significant"];

		$sql = "UPDATE NCR_Analysis SET Category = '$Category', Cause = '$Cause', Significant = '$Significant' WHERE Id_ncr_analysis = '$id' ";
		$result = mysqli_query($con, $sql);

		$location = "Location: ../ncr_analysis_ca.php?pg_id=".$return_id;
		header($location);

	}

?>