<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];

	/*eliminar archivo*/

	$sql_data = "SELECT File_name From NCR WHERE Id_ncr = '$id'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	$oldfile = $result_data['File_name'];

	$url = "../NCR/".$oldfile;
	unlink($url);
	
	/*Fin eliminar archivo*/

	/*UPDATE IN DATABASE*/
	$sql_archivo = "UPDATE NCR SET File_name = 'No file' WHERE Id_ncr = '$id' ";
	$result_archivo = mysqli_query($con, $sql_archivo);

	$location = "Location: ../ncr_details.php?pg_id=".$id;

	header($location);

?>