<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];
	$return_id = $_REQUEST["return_id"];

	//eliminar registro
	$consulta="DELETE FROM NCR_Why_Why WHERE Id_ncr_why_why = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	echo "<script type='text/javascript'>alert('Success!');</script>";
		
	$location = "Location: ../ncr_analysis_ca.php?pg_id=".$return_id;
	header($location);

?>