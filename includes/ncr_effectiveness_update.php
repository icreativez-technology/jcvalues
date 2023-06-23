<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		$location = "Location: ../ncr_verification.php?pg_id=".$id;
		//header($location);


		if(mysqli_affected_rows($con) == 1)
			{

				if($_POST["Id_ncr_why_why"]){
						for($i=0;$i<count($_POST["Id_ncr_why_why"]); $i++) {
					   		
					   		$Id_ncr = $id;
					   		$Id_ncr_why_why = $_POST["Id_ncr_why_why"][$i];
					   		
						   		 $sql_data = "SELECT * FROM NCR_Why_Why WHERE Id_ncr_why_why = $Id_ncr_why_why";
								 $connect_data = mysqli_query($con, $sql_data);
								 $result_data = mysqli_fetch_assoc($connect_data);

							$Root_cause = $result_data["Root_cause"];
							$Corrective_action = $_POST["Corrective_action"][$i];
							$Who_emp = $_POST["Who_emp"][$i];
							$When_date = $_POST["When_date"][$i];
							$Verified = $_POST["Verified"][$i];



					   		//Insertar datos 
					   		$sql_analysis = "INSERT INTO NCR_Effectiveness_verification VALUES ('','$Id_ncr', '$Id_ncr_why_why', '$Root_cause', '$Corrective_action', '$Who_emp', '$When_date', '$Verified')";
					   		$result_analysis = mysqli_query($con, $sql_analysis);

							header($location);

					   	}
					   }else{

					   		header($location);
					   }

			}else{

				if($_POST["Id_ncr_why_why"]){
					for($i=0;$i<count($_POST["Id_ncr_why_why"]); $i++) {

							
					   		$Id_ncr = $id;
					   		$Id_ncr_why_why = $_POST["Id_ncr_why_why"][$i];
					   		
						   		 $sql_data = "SELECT * FROM NCR_Why_Why WHERE Id_ncr_why_why = $Id_ncr_why_why";
								 $connect_data = mysqli_query($con, $sql_data);
								 $result_data = mysqli_fetch_assoc($connect_data);

							$Root_cause = $result_data["Root_cause"];
							$Corrective_action = $_POST["Corrective_action"][$i];
							$Who_emp = $_POST["Who_emp"][$i];
							$When_date = $_POST["When_date"][$i];
							$Verified = $_POST["Verified"][$i];

							$sql_analysis = "INSERT INTO NCR_Effectiveness_verification VALUES ('','$Id_ncr', '$Id_ncr_why_why', '$Root_cause', '$Corrective_action', '$Who_emp', '$When_date', '$Verified')";
					   		$result_analysis = mysqli_query($con, $sql_analysis);
	 			   		

							header($location);
					   	}

				}

			}	
	
	}
	$location = "Location: ../ncr_verification.php?pg_id=".$id;
	header($location);

?>