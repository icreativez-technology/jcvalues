<?php 

require_once "functions.php";

$item = $_POST['pg_id'];


//if($consultaBD){

	$sql_datos_document = "SELECT Title_of_the_document, Format_No, Rev_No,	Prepared_by, Reviewd_by, Approved_by, Date_of_preparation, Date_of_revision, Date_of_approval, File, Remarks, Category From Document WHERE File LIKE '$item'";

	$conect_datos_document = mysqli_query($con, $sql_datos_document);

	$result_datos_document = mysqli_fetch_assoc($conect_datos_document);

	$url = "../document-manager/".$result_datos_document['Category'].'/'.$item;
	echo $url;
	unlink($url);

	//eliminar registro
	$consulta="DELETE FROM Document WHERE File LIKE '%".$item."%'";
	$consultaBD = mysqli_query($con, $consulta);

	//eliminar historial
	$consulta="DELETE FROM Document_historial WHERE File LIKE '%".$item."%'";
	$consultaBD = mysqli_query($con, $consulta);	

	
	echo "<script type='text/javascript'>alert('Success!');</script>";
	header("Location: ../documentation.php");

//} 