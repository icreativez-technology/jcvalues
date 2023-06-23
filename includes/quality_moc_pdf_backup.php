<?php

session_start();
include('functions.php');


$Id_quality_moc = $_REQUEST['id_met'];

$sql_datos_moc = "SELECT * From Quality_MoC WHERE Id_quality_moc = $Id_quality_moc";
$conect_datos_moc = mysqli_query($con, $sql_datos_moc);
$result_datos_moc = mysqli_fetch_assoc($conect_datos_moc);

//Participant
$sql_datos_moc_participant = "SELECT * From Quality_MoC_Action as mp CROSS JOIN Basic_Employee as be WHERE mp.Id_employee = be.Id_employee AND mp.Id_quality_moc = $Id_quality_moc";
$conect_datos_moc_participant = mysqli_query($con, $sql_datos_moc_participant);

//Agenda
$sql_datos_moc_actionplan = "SELECT * From Quality_MoC_Action WHERE Id_quality_moc = $Id_quality_moc";
$conect_datos_moc_actionplan = mysqli_query($con, $sql_datos_moc_actionplan);

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
		$title = "MoC " . $result_datos_moc['Id_quality_moc'];
		// Logo
		$this->Image('../Imagenes/jclogorecorte.png', 80, 8, 43);
		// Arial bold 15
		$this->SetFont('Arial', 'B', 15);
		// Movernos a la derecha
		$this->Cell(80);
		// Título

		// Salto de línea
		$this->Ln(40);
	}
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		// Número de página
		$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}
}
//$pdf->Cell(40,10,'Meeting Title:'.$result_datos_moc['Title'],0,1);
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Quality MoC ' . $result_datos_moc['Id_quality_moc'], 0, 1);

/*USER*/
$sql_data_user = "SELECT * FROM Basic_Employee";
$connect_data_user = mysqli_query($con, $sql_data_user);


while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {
	if ($result_data_user['Id_employee'] == $result_datos_moc['Id_employee']) {
		$pdf->Cell(0, 5, 'On behalf of: ' . $result_data_user['First_Name'] . ' ' . $result_data_user['Last_Name'] . ' ( ' . $result_data_user['Email'] . ' )', 0, 1);
	}
}
/*End User*/

/*PLANT*/
$sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
$connect_data_plant = mysqli_query($con, $sql_data_plant);


while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
	if ($result_data_plant['Id_plant'] == $result_datos_moc['Id_plant']) {
		$pdf->Cell(0, 5, 'Plant: ' . $result_data_plant['Title'], 0, 1);
	}
}
/*END PLANT*/

/*PG*/
$sql_data_pg = "SELECT * FROM Basic_Product_Group";
$connect_data_pg = mysqli_query($con, $sql_data_pg);


while ($result_data_pg = mysqli_fetch_assoc($connect_data_pg)) {
	if ($result_data_pg['Id_product_group'] == $result_datos_moc['Id_product_group']) {
		$pdf->Cell(0, 5, 'Product Group: ' . $result_data_pg['Title'], 0, 1);
	}
}
/*END PG*/

/*Department*/
$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
	if ($result_data_dep['Id_department'] == $result_datos_moc['Id_department']) {
		$pdf->Cell(0, 5, 'Department: ' . $result_data_dep['Department'], 0, 1);
	}
}
/*End Department*/

/*MoC Type*/
$sql_data = "SELECT * FROM Quality_MoC_Type";
$connect_data = mysqli_query($con, $sql_data);

while ($result_data_moc = mysqli_fetch_assoc($connect_data)) {
	if ($result_data_moc['Id_quality_moc_type'] == $result_datos_moc['Id_quality_moc_type']) {
		$pdf->Cell(0, 5, 'MoC Type: ' . $result_data_moc['Title'], 0, 1);
	}
}
/*End MoC Type*/

$pdf->Cell(0, 5, 'Old MoC Ref#: ' . $result_datos_moc['Old_MoC_Ref'], 0, 1);
$pdf->Cell(0, 5, 'Date: ' . date("d-m-y", strtotime($result_datos_moc['Date_date'])), 0, 1);
$pdf->Cell(0, 5, 'Standard / Procedure Reference: ' . $result_datos_moc['Stan_Proc_Ref'], 0, 1);
$pdf->Cell(0, 5, 'Current State: ' . $result_datos_moc['Current_State'], 0, 1);
$pdf->Cell(0, 5, 'Change State: ' . $result_datos_moc['Change_State'], 0, 1);

if ($result_datos_moc['Risk_Assessment'] == 'No') {
	$pdf->Cell(0, 5, 'Risk Assessment: No', 0, 1);
} else {
	$pdf->Cell(0, 5, 'Risk Assessment: Yes', 0, 1);
}

$pdf->Cell(0, 15, '- Team members -', 0, 1);

while ($result_datos_moc_participant = mysqli_fetch_assoc($conect_datos_moc_participant)) {
	$pdf->Cell(0, 5, '' . $result_datos_moc_participant['First_Name'] . ' ' . $result_datos_moc_participant['Last_Name'] . ' ( ' . $result_datos_moc_participant['Email'] . ' )', 0, 1);
}

$pdf->Cell(0, 15, '- Action Plan -', 0, 1);

while ($result_datos_moc_actions = mysqli_fetch_assoc($conect_datos_moc_actionplan)) {

	$pdf->Cell(0, 5, 'SNo: ' . $result_datos_moc_actions['Sno'], 0, 1);
	$pdf->Cell(0, 5, 'Action Point: ' . $result_datos_moc_actions['Action_point'], 0, 1);

	$sql_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_datos_moc_actions[Id_employee]'";
	$connect_user = mysqli_query($con, $sql_user);
	$result_user = mysqli_fetch_assoc($connect_user);

	$pdf->Cell(0, 5, 'Who: ' . $result_user['First_Name'] . ' ' . $result_user['Last_Name'] . ' ( ' . $result_user['Email'] . ' )', 0, 1);
	$pdf->Cell(0, 5, 'Date: ' . date("d-m-y", strtotime($result_datos_moc_actions['Date_date'])), 0, 1);
	$pdf->Cell(0, 5, 'Verified: ' . $result_datos_moc_actions['Verified'], 0, 1);
	$pdf->Cell(0, 5, 'Status: ' . $result_datos_moc_actions['Status'] . '%', 0, 1);

	$pdf->Cell(0, 5, '----', 0, 1);
}

$pdf->Cell(0, 10, 'Decision remarks: ' . $result_datos_moc['Decision_Remarks'], 0, 1);

$pdf->Output();
