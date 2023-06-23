<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		/*$sql = "UPDATE Quality_MoC SET Decision = '$Decision', Decision_Remarks = '$Decision_Remarks' WHERE Id_quality_moc = '$id' ";
		$result = mysqli_query($con, $sql);*/

		$location = "Location: ../ncr_analysis_ca.php?pg_id=".$id;
		//header($location);


		if(mysqli_affected_rows($con) == 1)
			{

				if($_POST["Category"]){
						for($i=0;$i<count($_POST["Category"]); $i++) {
					   		
					   		$Id_ncr = $id;
					   		$Category = $_POST["Category"][$i];
					   		$Cause = $_POST["Cause"][$i];
					   		$Significant = $_POST["Significant"][$i];					   		

					   		//Insertar datos 
					   		$sql_analysis = "INSERT INTO NCR_Analysis VALUES ('','$Id_ncr', '$Category', '$Cause', '$Significant')";
					   		$result_analysis = mysqli_query($con, $sql_analysis);

							header($location);

					   	}
					   }else{

					   		header($location);
					   }

			}else{

				if($_POST["Category"]){
					for($i=0;$i<count($_POST["Category"]); $i++) {

							
					   		$Id_ncr = $id;
					   		$Category = $_POST["Category"][$i];
					   		$Cause = $_POST["Cause"][$i];
					   		$Significant = $_POST["Significant"][$i];	

								$sql_analysis = "INSERT INTO NCR_Analysis VALUES ('','$Id_ncr', '$Category', '$Cause', '$Significant')";
					   			$result_analysis = mysqli_query($con, $sql_analysis);
	 			   		

							header($location);
					   	}

				}

			}	
	
	}
	$location = "Location: ../ncr_analysis_ca.php?pg_id=".$id;
	header($location);

?>