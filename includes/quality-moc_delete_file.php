<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];

	/*eliminar archivo*/

	$sql_data = "SELECT File From Quality_MoC WHERE Id_quality_moc = '$id'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	$oldfile = $result_data['File'];

	$url = "../quality/moc/".$oldfile;
	unlink($url);
	
	/*Fin eliminar archivo*/

	/*UPDATE IN DATABASE*/
	$sql_archivo = "UPDATE Quality_MoC SET File = 'No file' WHERE Id_quality_moc = '$id' ";
	$result_archivo = mysqli_query($con, $sql_archivo);

	$location = "Location: ../quality-moc_details.php?pg_id=".$id;

	header($location);

?>