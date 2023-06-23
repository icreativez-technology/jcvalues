<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
			
			$id = $_POST["pg_id"];
			$return_id = $_POST["return_id"];


			$Id_ncr_why_why = $_POST["Id_ncr_why_why"];
   		
		   		 $sql_data = "SELECT * FROM NCR_Why_Why WHERE Id_ncr_why_why = $Id_ncr_why_why";
				 $connect_data = mysqli_query($con, $sql_data);
				 $result_data = mysqli_fetch_assoc($connect_data);

			$Root_cause = $result_data["Root_cause"];
			$Corrective_action = $_POST["Corrective_action"];
			$Who_emp = $_POST["Who_emp"];
			$When_date = $_POST["When_date"];
			$Verified = $_POST["Verified"];

		$sql = "UPDATE NCR_Effectiveness_verification SET Id_ncr_why_why = '$Id_ncr_why_why', Root_cause = '$Root_cause', Corrective_action = '$Corrective_action', Who_emp = '$Who_emp', When_date = '$When_date', Verified = '$Verified' WHERE Id_ncr_effectiveness = '$id' ";
		$result = mysqli_query($con, $sql);

		$location = "Location: ../ncr_verification.php?pg_id=".$return_id;
		header($location);

	}

?>