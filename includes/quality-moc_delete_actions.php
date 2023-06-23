<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];
	$return_id = $_REQUEST["return_id"];

	//eliminar registro
	$consulta="DELETE FROM Quality_MoC_Action WHERE Id_quality_moc_action = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	echo "<script type='text/javascript'>alert('Success!');</script>";
		
	$location = "Location: ../quality-moc_actions.php?pg_id=".$return_id;
	header($location);

?>