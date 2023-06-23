<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];
		$return_id = $_POST["return_id"];


		$Id_ncr_analysis = $_POST["Id_ncr_analysis"];
					   		
			$sql_data = "SELECT * FROM NCR_Analysis WHERE Id_ncr_analysis = $Id_ncr_analysis";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);

		$Significant_cause = $result_data["Cause"];
		$First_why = $_POST["First_why"];
		$Second_why = $_POST["Second_why"];
		$Third_why = $_POST["Third_why"];
		$Fourth_why = $_POST["Fourth_why"];
		$Fifth_why = $_POST["Fifth_why"];
		$Root_cause = $_POST["Root_cause"];

		$sql = "UPDATE NCR_Why_Why SET Id_ncr_analysis = '$Id_ncr_analysis', Significant_cause = '$Significant_cause', First_why = '$First_why', Second_why = '$Second_why', Third_why = '$Third_why', Fourth_why = '$Fourth_why', Fifth_why = '$Fifth_why', Root_cause = '$Root_cause' WHERE Id_ncr_why_why = '$id' ";
		$result = mysqli_query($con, $sql);

		$location = "Location: ../ncr_analysis_ca.php?pg_id=".$return_id;
		header($location);

	}

?>