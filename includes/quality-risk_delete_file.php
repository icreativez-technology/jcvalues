<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];

	/*eliminar archivo*/

	$sql_data = "SELECT File From quality_risk WHERE Id_quality_risk = '$id'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	$oldfile = $result_data['File'];

	$url = "../quality/risk/".$oldfile;
	unlink($url);
	
	/*Fin eliminar archivo*/

	/*UPDATE IN DATABASE*/
	$sql_archivo = "UPDATE quality_risk SET File = 'No file' WHERE Id_quality_risk = '$id' ";
	$result_archivo = mysqli_query($con, $sql_archivo);

	$location = "Location: ../quality-risk_details.php?pg_id=".$id;

	header($location);

?>