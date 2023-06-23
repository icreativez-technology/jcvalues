<?php

session_start();
include('functions.php');

$Id_quality_risk = $_REQUEST['id'];

$sql_data_risk = "SELECT * From quality_risk WHERE id = '$Id_quality_risk' AND is_deleted = 0";
$conect_data_risk = mysqli_query($con, $sql_data_risk);
$result_data_risk = mysqli_fetch_assoc($conect_data_risk);

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../Imagenes/logo_PDF.png', 90, 4, 27);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título

        // Salto de línea
        $this->Ln(30);
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

    function MultiAlignCell($w, $h, $text, $ln = 0, $fill = false)
    {
        // Store reset values for (x,y) positions
        $x = $this->GetX() + $w;
        $y = $this->GetY();

        // Make a call to FPDF's MultiCell
        $this->MultiCell($w, $h, $text, $fill);

        // Reset the line position to the right, like in Cell
        if ($ln == 0) {
            $this->SetXY($x, $y);
        }
    }
}

$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(207, 27, 18);
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(0, 10, 'Quality Risk ' . $result_data_risk['id'], 0, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 10, 'On Behalf of', 0, 0, 1);
$pdf->Cell(50, 10, 'Plant', 0, 0, 1);
$pdf->Cell(50, 10, 'Product Group', 0, 0, 1);
$pdf->Cell(50, 10, 'Department', 0, 0, 1);
$pdf->SetDrawColor(207, 27, 18);
$pdf->SetLineWidth(1);
$pdf->SetLineWidth(15, 95, 205, 95);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

/*USER*/
$sql_data_user = "SELECT * FROM Basic_Employee";
$connect_data_user = mysqli_query($con, $sql_data_user);

while ($result_data_user = mysqli_fetch_assoc($connect_data_user)) {
    if ($result_data_user['Id_employee'] == $result_data_risk['on_behalf_of']) {
        $pdf->Cell(50, 10, $result_data_user['First_Name'] . ' ' . $result_data_user['Last_Name'], 0, 0, 1);
    }
}
// /*End User*/

/*PLANT*/
$sql_data_plant = "SELECT Id_plant, Title, Status FROM Basic_Plant";
$connect_data_plant = mysqli_query($con, $sql_data_plant);

while ($result_data_plant = mysqli_fetch_assoc($connect_data_plant)) {
    if ($result_data_plant['Id_plant'] == $result_data_risk['plant_id']) {
        $pdf->Cell(50, 10, $result_data_plant['Title'], 0, 0, 1);
    }
}
/*END PLANT*/

/*PG*/
$sql_data_pg = "SELECT * FROM Basic_Product_Group";
$connect_data_pg = mysqli_query($con, $sql_data_pg);


while ($result_data_pg = mysqli_fetch_assoc($connect_data_pg)) {
    if ($result_data_pg['Id_product_group'] == $result_data_risk['product_group_id']) {
        $pdf->Cell(50, 10, $result_data_pg['Title'], 0, 0, 1);
    }
}
/*END PG*/

/*Department*/
$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_dep = mysqli_fetch_assoc($connect_data)) {
    if ($result_data_dep['Id_department'] == $result_data_risk['department_id']) {
        $pdf->Cell(50, 10, $result_data_dep['Department'], 0, 0, 1);
    }
}
/*End Department*/

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(207, 27, 18);
$pdf->Cell(50, 10, 'Process', 0, 0, 1);
$pdf->Cell(50, 10, 'Risk Type', 0, 0, 1);
$pdf->Cell(50, 10, 'Source of Risk', 0, 0, 1);
$pdf->Cell(50, 10, 'Impact Area', 0, 0, 1);
$pdf->SetDrawColor(207, 27, 18);
$pdf->SetLineWidth(1);
$pdf->SetLineWidth(15, 95, 205, 95);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

/*process*/
$sql_data = "SELECT * FROM Quality_Process";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_impact = mysqli_fetch_assoc($connect_data)) {
    if ($result_data_impact['Id_quality_process'] == $result_data_risk['process_id']) {
        $pdf->Cell(50, 10, $result_data_impact['Title'], 0, 0, 1);
    }
}
/*End Process*/

/*Risk Type*/
$sql_data = "SELECT * FROM Quality_Risk_Type";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_impact = mysqli_fetch_assoc($connect_data)) {
    if ($result_data_impact['Id_quality_risk_type'] == $result_data_risk['risk_type_id']) {
        $pdf->Cell(50, 10, $result_data_impact['Title'], 0, 0, 1);
    }
}
/*End Risk Type*/

/*Risk Type*/
$sql_data = "SELECT * FROM Quality_Risk_Source";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_impact = mysqli_fetch_assoc($connect_data)) {
    if ($result_data_impact['Id_quality_risk_source'] == $result_data_risk['source_of_risk_id']) {
        $pdf->Cell(50, 10, $result_data_impact['Title'], 0, 0, 1);
    }
}
/*End Risk Type*/

/*Impact*/
$sql_data = "SELECT * FROM Quality_Impact_Area";
$connect_data = mysqli_query($con, $sql_data);


while ($result_data_impact = mysqli_fetch_assoc($connect_data)) {
    if ($result_data_impact['Id_quality_impact_area'] == $result_data_risk['impact_area_id']) {
        $pdf->Cell(50, 10, $result_data_impact['Title'], 0, 0, 1);
    }
}
/*End Impact*/

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(207, 27, 18);
$pdf->Cell(50, 10, 'Description', 0, 0, 1);
$pdf->SetDrawColor(207, 27, 18);
$pdf->SetLineWidth(1);
$pdf->SetLineWidth(15, 95, 205, 95);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);


/* Description */

$pdf->Cell(50, 10, $result_data_risk['description'], 0, 0, 1);

/*End Description */

/* Mitigation Plan */

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(207, 27, 18);
$pdf->Cell(50, 10, 'Mitigation Plan', 0, 0, 1);
$pdf->SetDrawColor(207, 27, 18);
$pdf->SetLineWidth(1);
$pdf->SetLineWidth(15, 95, 205, 95);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(112, 112, 112);

$pdf->Cell(100, 10, 'Corrective Action', 0, 0, 1);
$pdf->Cell(35, 10, 'Who', 0, 0, 1);
$pdf->Cell(35, 10, 'When', 0, 0, 1);
$pdf->Cell(35, 10, 'Status', 0, 0, 1);

$pdf->Ln(15);
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);


$sql_data = "SELECT * FROM quality_risk_mitigation_plan WHERE quality_risk_id = '$result_data_risk[id]'";
$connect_data = mysqli_query($con, $sql_data);

while ($result_data_mitigation = mysqli_fetch_assoc($connect_data)) {

    $pdf->MultiAlignCell(100, 4, utf8_encode($result_data_mitigation['corrective_action']), 0, false);

    $sql_user = "SELECT * FROM Basic_Employee WHERE Id_employee = '$result_data_mitigation[who]'";
    $connect_user = mysqli_query($con, $sql_user);
    $result_user = mysqli_fetch_assoc($connect_user);

    $pdf->Cell(35, 10, $result_user['First_Name'] . " " . $result_user['Last_Name'], 0, 0, 1);
    $pdf->Cell(35, 10, date("d-m-Y", strtotime($result_data_mitigation['date'])), 0, 0, 1);

    $status = $result_data_mitigation['status'] == 1 ? "Closed" : "Open";
    $pdf->Cell(35, 10, $status, 0, 0, 1);

    $pdf->Ln(16);
}

/* End Mitigation Plan */

/* Approval */

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(207, 27, 18);
$pdf->Cell(50, 10, 'Decision', 0, 0, 1);
$pdf->Cell(50, 10, 'Decision Remarks', 0, 0, 1);
$pdf->SetDrawColor(207, 27, 18);
$pdf->SetLineWidth(1);
$pdf->SetLineWidth(15, 95, 205, 95);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

$sql_data = "SELECT * FROM quality_risk_approval WHERE quality_risk_id = '$result_data_risk[id]'";
$connect_data = mysqli_query($con, $sql_data);

while ($result_data_approval = mysqli_fetch_assoc($connect_data)) {

    $decision = $result_data_approval['decision'] == 1 ? "Approved" : "Rejected";
    $pdf->Cell(50, 10, $decision, 0, 0, 1);
    $pdf->Cell(50, 10, $result_data_approval['decision_remarks'], 0, 0, 1);
}

/* End Approval */

$pdf->Output();
