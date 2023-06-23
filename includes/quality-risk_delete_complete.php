<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];
	/**
	 * Proceso: Eliminar 1o archivo
	 * TeamMembers
	 * Risk
	 * 	
	*/

	/*eliminar archivo*/

	$sql_data = "SELECT File From quality_risk WHERE Id_quality_risk = '$id'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	$oldfile = $result_data['File'];

	$url = "../quality/risk/".$oldfile;
	unlink($url);
	/*Fin eliminar archivo*/


	/*eliminar Team members*/
	$consulta="DELETE FROM Quality_Risk_TeamMembers WHERE Id_quality_risk = '$id'";
	$consultaBD = mysqli_query($con, $consulta);
	/*Fin eliminar Team members*/

	/*eliminar MoC*/
	$consulta="DELETE FROM quality_risk WHERE Id_quality_risk = '$id'";
	$consultaBD = mysqli_query($con, $consulta);
	/*Fin eliminar MoC*/


	header("Location: ../quality-risk_view_list.php");

?>