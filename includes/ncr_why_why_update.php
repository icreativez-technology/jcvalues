<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		$location = "Location: ../ncr_analysis_ca.php?pg_id=".$id;
		//header($location);


		if(mysqli_affected_rows($con) == 1)
			{

				if($_POST["Id_ncr_analysis"]){
						for($i=0;$i<count($_POST["Id_ncr_analysis"]); $i++) {
					   		
					   		$Id_ncr = $id;
					   		$Id_ncr_analysis = $_POST["Id_ncr_analysis"][$i];
					   		
						   		 $sql_data = "SELECT * FROM NCR_Analysis WHERE Id_ncr_analysis = $Id_ncr_analysis";
								 $connect_data = mysqli_query($con, $sql_data);
								 $result_data = mysqli_fetch_assoc($connect_data);

							$Significant_cause = $result_data["Cause"];
							$First_why = $_POST["First_why"][$i];
							$Second_why = $_POST["Second_why"][$i];
							$Third_why = $_POST["Third_why"][$i];
							$Fourth_why = $_POST["Fourth_why"][$i];
							$Fifth_why = $_POST["Fifth_why"][$i];
							$Root_cause = $_POST["Root_cause"][$i];




					   		//Insertar datos 
					   		$sql_analysis = "INSERT INTO NCR_Why_Why VALUES ('','$Id_ncr', '$Id_ncr_analysis', '$Significant_cause', '$First_why', '$Second_why', '$Third_why', '$Fourth_why', '$Fifth_why', '$Root_cause')";
					   		$result_analysis = mysqli_query($con, $sql_analysis);

							header($location);

					   	}
					   }else{

					   		header($location);
					   }

			}else{

				if($_POST["Id_ncr_analysis"]){
					for($i=0;$i<count($_POST["Id_ncr_analysis"]); $i++) {

							
					   		$Id_ncr = $id;
					   		$Id_ncr_analysis = $_POST["Id_ncr_analysis"][$i];
					   		
						   		 $sql_data = "SELECT * FROM NCR_Analysis WHERE Id_ncr_analysis = $Id_ncr_analysis";
								 $connect_data = mysqli_query($con, $sql_data);
								 $result_data = mysqli_fetch_assoc($connect_data);

							$Significant_cause = $result_data["Cause"];
							$First_why = $_POST["First_why"][$i];
							$Second_why = $_POST["Second_why"][$i];
							$Third_why = $_POST["Third_why"][$i];
							$Fourth_why = $_POST["Fourth_why"][$i];
							$Fifth_why = $_POST["Fifth_why"][$i];
							$Root_cause = $_POST["Root_cause"][$i];	

								$sql_analysis = "INSERT INTO NCR_Why_Why VALUES ('','$Id_ncr', '$Id_ncr_analysis', '$Significant_cause', '$First_why', '$Second_why', '$Third_why', '$Fourth_why', '$Fifth_why', '$Root_cause')";
					   		$result_analysis = mysqli_query($con, $sql_analysis);
	 			   		

							header($location);
					   	}

				}

			}	
	
	}
	$location = "Location: ../ncr_analysis_ca.php?pg_id=".$id;
	header($location);

?>