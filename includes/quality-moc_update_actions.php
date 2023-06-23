<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		/*$sql = "UPDATE Quality_MoC SET Decision = '$Decision', Decision_Remarks = '$Decision_Remarks' WHERE Id_quality_moc = '$id' ";
		$result = mysqli_query($con, $sql);*/

		$location = "Location: ../quality-moc_actions.php?pg_id=".$id;
		//header($location);


		if(mysqli_affected_rows($con) == 1)
			{

				if($_POST["sno"]){


					   	

					   	for($i=0;$i<count($_POST["sno"]); $i++) {
					   		$sno = $_POST["sno"][$i];
					   		$actionpoint = $_POST["ActionPoint"][$i];
					   		$who = $_POST["who"][$i];
					   		$when = $_POST["When"][$i];
					   		$verified = $_POST["Verified"][$i];
					   		$status = $_POST["Status"][$i];
					   		

					   		//Insertar datos 
					   		$sql_agenda = "INSERT INTO Quality_MoC_Action VALUES ('','$id', '$sno', '$actionpoint', '$who','$when','$verified','$status')";
					   		$result_agenda = mysqli_query($con, $sql_agenda);

							header($location);

					   	}
					   }else{

					   		header($location);
					   }

			}else{

				if($_POST["sno"]){
					for($i=0;$i<count($_POST["sno"]); $i++) {

							print_r($_POST);
					   		$sno = $_POST["sno"][$i];
					   		$actionpoint = $_POST["ActionPoint"][$i];
					   		$who = $_POST["who"][$i];
					   		$when = $_POST["When"][$i];
					   		$verified = $_POST["Verified"][$i];
					   		$status = $_POST["Status"][$i];
					   		//$id_Quality_MoC_Action = $_POST["id_Quality_MoC_Action"][$i];

					   		
					   		//echo $id_Quality_MoC_Action;
							//if($id_Quality_MoC_Action == 0){
								//Insertar datos
								//echo $status;
								$sql_agenda = "INSERT INTO Quality_MoC_Action VALUES ('','$id', '$sno', '$actionpoint', '$who','$when','$verified','$status')";
					   			$result_agenda = mysqli_query($con, $sql_agenda);
							//}
							 
					   		

					   		

							header($location);
					   	}

				}

			}	
	
	}
	$location = "Location: ../quality-moc_actions.php?pg_id=".$id;
	header($location);

?>