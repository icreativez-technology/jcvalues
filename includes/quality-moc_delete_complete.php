<?php

session_start();
include('functions.php');


	$id = $_REQUEST['pg_id'];
	/**
	 * Proceso: Eliminar 1o archivo
	 * Acciones
	 * TeamMembers
	 * MoC
	 * 	
	*/

	/*eliminar archivo*/

	$sql_data = "SELECT File From Quality_MoC WHERE Id_quality_moc = '$id'";
	$connect_data = mysqli_query($con, $sql_data);
	$result_data = mysqli_fetch_assoc($connect_data);

	$oldfile = $result_data['File'];

	$url = "../quality/moc/".$oldfile;
	unlink($url);
	
	/*Fin eliminar archivo*/

	/*eliminar Rejected*/
	$consulta="DELETE FROM Quality_MoC_Rejected_Action WHERE Id_quality_moc = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	/*Fin eliminar Rejected*/


	/*eliminar actions*/
	$consulta="DELETE FROM Quality_MoC_Action WHERE Id_quality_moc = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	/*Fin eliminar actions*/

	/*eliminar Team Members*/
	$consulta="DELETE FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	/*Fin eliminar Team members*/

	/*eliminar MoC*/
	$consulta="DELETE FROM Quality_MoC WHERE Id_quality_moc = '$id'";
	$consultaBD = mysqli_query($con, $consulta);

	/*Fin eliminar MoC*/


	header("Location: ../quality-moc_view_list.php");

?>