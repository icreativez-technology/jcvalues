<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];
	$return_id = $_REQUEST["return_id"];

	//eliminar registro
	$consulta="DELETE FROM NCR_MR_Approval WHERE Id_ncr_mr_approval = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	echo "<script type='text/javascript'>alert('Success!');</script>";
		
	$location = "Location: ../ncr_mr_approval.php?pg_id=".$return_id;
	header($location);

?>