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


			$sql = "UPDATE Quality_MoC SET Decision = '$Decision', Decision_Remarks = '$Decision_Remarks' WHERE Id_quality_moc = '$id' ";
			$result = mysqli_query($con, $sql);

			/*Block Action Rejected*/
			if($Decision == "Rejected")
			{
				/*Solamente se bloquea una vez, si el MoC ya ha sido rechazado antes, los action point no pueden ser rechazados de nuevo, solo aprovados.*/
				if($_POST['actual_decision'] != "Rejected")
				{
					$sql_datos_moc_actions = "SELECT * From Quality_MoC_Action WHERE Id_quality_moc = '$id'";
					$conect_datos_moc_actions = mysqli_query($con, $sql_datos_moc_actions);

					while ($result_datos_moc_actions = mysqli_fetch_assoc($conect_datos_moc_actions))
					{
						$sql_agenda = "INSERT INTO Quality_MoC_Rejected_Action VALUES ('', '$result_datos_moc_actions[Id_quality_moc_action]','$id')";
						$result_agenda = mysqli_query($con, $sql_agenda);
					}
				}
			}

			$location = "Location: ../quality-moc_actions.php?pg_id=".$id;
			header($location);
		
	}

?>