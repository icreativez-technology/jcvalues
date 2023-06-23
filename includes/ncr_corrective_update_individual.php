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
			$Review = $_POST["Review"];
			$Status = $_POST["Status"];

		$sql = "UPDATE NCR_Corrective_Action_Plan SET Id_ncr_why_why = '$Id_ncr_why_why', Root_cause = '$Root_cause', Corrective_action = '$Corrective_action', Who_emp = '$Who_emp', When_date = '$When_date', Review = '$Review', Status = '$Status' WHERE Id_ncr_corrective = '$id' ";
		$result = mysqli_query($con, $sql);

		$location = "Location: ../ncr_analysis_ca.php?pg_id=".$return_id;
		header($location);

	}

?>