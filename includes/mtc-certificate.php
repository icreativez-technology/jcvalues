<?php
    
require_once __DIR__ . '/../vendor/autoload.php';

include('functions.php');

function mtcCertificates($mtc_number,$con){

$mtcCertificatesSql = "SELECT supplier_certificates.id as SpId, supplier_certificates.*, Basic_Supplier.*, components.*, classes.*, sizes.*
FROM `supplier_certificates`
LEFT JOIN `Basic_Supplier` ON Basic_Supplier.Id_Supplier = supplier_certificates.supplier_id
LEFT JOIN `components` ON components.id = supplier_certificates.component_id
LEFT JOIN `classes` ON classes.id = supplier_certificates.class_id
LEFT JOIN `sizes` ON sizes.id = supplier_certificates.size_id
WHERE supplier_certificates.material_certificate_number = '$mtc_number'";

$mtcCertificatesData = mysqli_query($con, $mtcCertificatesSql);

if($mtcCertificatesData->num_rows > 0){

$mtcCertificatesData = mysqli_fetch_assoc($mtcCertificatesData);

   $id =  $mtcCertificatesData['SpId'];

   $material_specification_id =  $mtcCertificatesData['material_specification_id'];
   $_REQUEST['mode'] = 1;

   $materialSpecificationSql = "SELECT * FROM material_specifications WHERE id = $material_specification_id AND is_deleted = 0";
   $materialSpecificationConnect = mysqli_query($con, $materialSpecificationSql);
   $materialSpecification = mysqli_fetch_assoc($materialSpecificationConnect);


   $chemicalInfoSql = "SELECT supplier_certificate_actual_chemicals.actual, material_specification_chemicals.min_value,material_specification_chemicals.max_value,chemicals.parameter 
    FROM supplier_certificate_actual_chemicals 
    LEFT JOIN material_specification_chemicals ON material_specification_chemicals.chemical_id = supplier_certificate_actual_chemicals.chemical_id
    LEFT JOIN chemicals ON chemicals.id =  supplier_certificate_actual_chemicals.chemical_id
    LEFT JOIN supplier_certificates ON supplier_certificates.id = supplier_certificate_actual_chemicals.supplier_certificate_id
    WHERE material_specification_chemicals.material_specification_id = $material_specification_id AND supplier_certificates.material_certificate_number = '$mtc_number' AND supplier_certificate_actual_chemicals.is_deleted = 0 AND material_specification_chemicals.is_deleted = 0 AND chemicals.is_deleted = 0
    GROUP BY supplier_certificate_actual_chemicals.chemical_id ";
    $chemicalInfoConnect = mysqli_query($con, $chemicalInfoSql);
  
    $chemicalData = [];
    
    while($chemicalInfoData = mysqli_fetch_assoc($chemicalInfoConnect)) {
        $row = array(
            "parameter"=>(isset($chemicalInfoData['parameter']) && $chemicalInfoData['parameter']) ? $chemicalInfoData['parameter'] : "-", 
            "min_value"=>(isset($chemicalInfoData['min_value']) && $chemicalInfoData['min_value']) ? $chemicalInfoData['min_value'] : "-", 
            "max_value"=>(isset($chemicalInfoData['max_value']) && $chemicalInfoData['max_value']) ? $chemicalInfoData['max_value'] : "-",
            "actual"=>(isset($chemicalInfoData['actual']) && $chemicalInfoData['actual']) ? $chemicalInfoData['actual'] : "-"
        );
        
        array_push($chemicalData, $chemicalInfoData);
    }

$parameter = "";
$min_value = "";
$max_value = "";
$actual    = "";


foreach($chemicalData as $chemical){   
    $parameter .= '<td class="text-center border">'. ($chemical['parameter']) ?? "-"  .'</td>';
    $min_value .= '<td>'. ($chemical['min_value']) ?? "-"  .'</td>';
    $max_value .= '<td>'. ($chemical['max_value']) ?? "-"  .'</td>';
    $actual    .= '<td>'. ($chemical['actual']) ?? "-"  .'</td>';
} 



$heatSql = "SELECT * FROM supplier_certificate_heat_notes WHERE supplier_certificate_id = $id";
$heatSqlConnectData = mysqli_query($con, $heatSql);
$heat = mysqli_fetch_assoc($heatSqlConnectData);
if(!isset($heat['heat_notes'])) {
    $heat['heat_notes'] = "-";
    $heat['id'] = null;
}

$tensileSql = "SELECT * FROM material_specification_tensile_test WHERE material_specification_id = $material_specification_id AND is_deleted = 0";
$tensileSqlConnectData = mysqli_query($con, $tensileSql);
$tensile = mysqli_fetch_assoc($tensileSqlConnectData);

$tensile['tensile_strength_min'] = ($tensile['tensile_strength_min']) ? $tensile['tensile_strength_min'] : '-';
$tensile['tensile_strength_max'] = ($tensile['tensile_strength_max']) ? $tensile['tensile_strength_max'] : '-';
$tensile['yield_strength_min'] = ($tensile['yield_strength_min']) ? $tensile['yield_strength_min'] : '-';
$tensile['yield_strength_max'] = ($tensile['yield_strength_max']) ? $tensile['yield_strength_max'] : '-';
$tensile['elongation_min'] = ($tensile['elongation_min']) ? $tensile['elongation_min'] : '-';
$tensile['elongation_max'] = ($tensile['elongation_max']) ? $tensile['elongation_max'] : '-';
$tensile['reduction_area_min'] = ($tensile['reduction_area_min']) ? $tensile['reduction_area_min'] : '-';
$tensile['reduction_area_max'] = ($tensile['reduction_area_max']) ? $tensile['reduction_area_max'] : '-';

$hardnessSql = "SELECT * FROM material_specification_hardness_test WHERE material_specification_id = $material_specification_id AND is_deleted = 0";
$hardnessSqlConnectData = mysqli_query($con, $hardnessSql);
$hardness = mysqli_fetch_assoc($hardnessSqlConnectData);

// print_r($hardness);
// die();

$hardness['hardness_mu'] = isset($hardness['hardness_mu']) ? $hardness['hardness_mu'] : '-';
$hardness['hardness_test_limit_min'] = ($hardness['hardness_test_limit_min']) ? $hardness['hardness_test_limit_min'] : '-';
$hardness['hardness_test_limit_max'] = isset($hardness['hardness_test_limit_max']) && $hardness['hardness_test_limit_max'] != "" ? $hardness['hardness_test_limit_max'] : '-';

$impactSql = "SELECT * FROM material_specification_impact_test WHERE material_specification_id = $material_specification_id AND is_deleted = 0";
$impactSqlConnectData = mysqli_query($con, $impactSql);
$impact = mysqli_fetch_assoc($impactSqlConnectData);
$impact['impact_test_temperature'] = isset($impact['impact_test_temperature']) && $impact['impact_test_temperature'] != "" ? "@" . $impact['impact_test_temperature'] : '';
$impact['impact_test_limit_min'] = isset($impact['impact_test_limit_min']) && $impact['impact_test_limit_min'] != "" ? $impact['impact_test_limit_min'] : '-';
$impact['impact_test_limit_max'] = isset($impact['impact_test_limit_max']) && $impact['impact_test_limit_max'] != "" ? $impact['impact_test_limit_max'] : '-';

$tensileSql = "SELECT * FROM supplier_certificate_tensile_test WHERE supplier_certificate_id = $id";
$tensilData = mysqli_query($con, $tensileSql);
$tensileResult =  mysqli_fetch_assoc($tensilData);


$tensileResult['actual_tensile_strength'] =  ($tensileResult['actual_tensile_strength']) ?? "-";
$tensileResult['actual_yield_strength'] =  ($tensileResult['actual_yield_strength']) ?? "-";
$tensileResult['actual_elongation'] =  ($tensileResult['actual_elongation']) ?? "-";
$tensileResult['actual_reduction_area'] =  ($tensileResult['actual_reduction_area']) ?? "-";

$hardnessSql = "SELECT * FROM supplier_certificate_hardness_test WHERE supplier_certificate_id =  $id";
$hardnessData = mysqli_query($con, $hardnessSql);
$hardnessResult =  mysqli_fetch_assoc($hardnessData);

$impactSql = "SELECT * FROM supplier_certificate_impact_test WHERE supplier_certificate_id =  $id";
$impactData = mysqli_query($con, $impactSql);
$impactResult =  mysqli_fetch_assoc($impactData);

$hardnessResult['result1'] =  ($hardnessResult['result1']) ?? "-";
$hardnessResult['result2'] =  ($hardnessResult['result2']) ?? "-";
$hardnessResult['result3'] =  ($hardnessResult['result3']) ?? "-";

$impactResult['result1'] =  ($impactResult['result1']) ?? "-";
$impactResult['result2'] =  ($impactResult['result2']) ?? "-";
$impactResult['result3'] =  ($impactResult['result3']) ?? "-";

$hardnessResult['average '] =  ($hardnessResult['average']) ?? "-";
$impactResult['average '] =  ($impactResult['average']) ?? "-";


// print_r($mtcCertificatesData);
// die();


$content = '

<style>
table, td, th {
  border: 1px solid lightgray;
}
th, td {
    padding: 5px 5px 5px 5px;
   
}

table {
  border-collapse: collapse;
  
}
.table1{
    margin-top: 20px;

}
.table2{
    margin-top: 10px;

}


</style>

<div style="font-family: sans-serif; font-size: 8px;">
		<table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 8px;">
			<tr>
				<td width="10%" align="center" style="border: 1px solid lightgray;">
					<img src="../Imagenes/logo_PDF.png" width="50px" />
				</td>
				<td width="80%" align="center" style="border: 1px solid lightgray; font-weight: bold; font-size: 25px">
                   Material Certificate
				</td>
				<td width="10%" style="border: 1px solid lightgray; text-align: center;">
					<p>
						PS07/F1
					</p>
					<p>
						F rev. Active
					</p>
				</td>
			</tr>
		</table>
		<div style="text-align: right; margin-top: 3px; color: #adb5bd">
			Sheet {PAGENO}/{nbpg}
		</div>
	</div>
<div class="card  text-uppercase">
    <div class="row m-0">
        <div class="col-lg-4 p-1">
            <div class="card p-1 h-100">

            <table width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size:12px;">
                    <tr>
                        <td width="33%"  style="border: 1px solid lightgray;">
                            <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Supplier:    '.$mtcCertificatesData['Supplier_Name'].' </p>
                            <p class="mb-1 me-2 fw-bold">ISO 9001:     Approved</p>
                            <p class="mb-1 me-2 fw-bold">2014/68/EU:   Approved</p>
                            </div>
                        </td>
                        <td width="33%"  style="border: 1px solid lightgray;">
                            <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">P.0 NO:  '.$mtcCertificatesData['po_number'].' </p>
                            <p class="mb-1 me-2 fw-bold">Date:  '.$mtcCertificatesData['po_date'].' </p>
                            <p class="mb-1 me-2 fw-bold">Revision:  '.$mtcCertificatesData['po_revision'].' </p>
                            </div>
                        </td>
                        <td width="33%"  style="border: 1px solid lightgray;">
                            <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Material Cert NO:  '.$mtcCertificatesData['material_certificate_number'].' </p>
                            <p class="mb-1 me-2 fw-bold">Date:  '.$mtcCertificatesData['mtc_date'].'</p>
                            <p class="mb-1 me-2 fw-bold">Revision:  '.$mtcCertificatesData['mtc_revision'].'</p>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        <div class="col-lg-4 p-1">
        <div class="card p-1 h-100">

            <table class="table2" width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size: 12px;">
                <tr>
                    <td width="50%"  style="border: 1px solid lightgray;">
                        <div class="d-flex">
                        <p class="mb-1 me-2 fw-bold">Item Code:  '.$mtcCertificatesData['item_code'].'</p>
                        <p class="mb-1 me-2 fw-bold">Drawing No: '.$mtcCertificatesData['drawing_number'].'</p>
                        <p class="mb-1 me-2 fw-bold">Component:  '.$mtcCertificatesData['component'].'</p>
                        <p class="mb-1 me-2 fw-bold">Size:  '.$mtcCertificatesData['size'].' </p>
                        </div>
                    </td>
                    <td width="50%"  style="border: 1px solid lightgray;">
                        <div class="d-flex">
                        <p class="mb-1 me-2 fw-bold">Class:  '.$mtcCertificatesData['class'].'</p>
                        <p class="mb-1 me-2 fw-bold">Material:  '.$materialSpecification['material_specification'].' </p>
                        <p class="mb-1 me-2 fw-bold">Edition:   '. $materialSpecification['nom_comp'].'</p>
                        <p class="mb-1 me-2 fw-bold">Heat NO:  '.$mtcCertificatesData['heat_number'].'</p>
                        <p class="mb-1 me-2 fw-bold">Qty:  '.$mtcCertificatesData['qty'].'</p>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
      </div>
    </div>
</div>

<table class="table2" width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size:12px;">
<tr>
    <td style="border: 1px solid lightgray;">
    <div class="card mt-2 text-uppercase">
    <div class="row m-0">
        <div class="col-12 p-1">
            <div class="card p-1 h-100">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Heat Treatment:</p>
                    <p class="mb-1"> '.$heat['heat_notes'].'</p>
                </div>
            </div>
        </div>
    </div>
</div>
    </td>
</tr>
</table>

<table class="table2" width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size:12px;">
<tr>
    <td width="50%" style="border: 1px solid lightgray;">
    <div class="card mt-2 text-uppercase">
    <div class="row m-0">
        <div class="col-12 p-1">
            <div class="card p-1 h-100">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Melting Process:</p>
                    <p class="mb-1"> '.$mtcCertificatesData['melting_process'].'</p>
                </div>
            </div>
        </div>
    </div>
</div>
    </td>

    <td width="50%" style="border: 1px solid lightgray;">
    <div class="card mt-2 text-uppercase">
    <div class="row m-0">
        <div class="col-12 p-1">
            <div class="card p-1 h-100">
                <div class="d-flex">
                    <p class="mb-1 me-2 fw-bold">Other Specs Agreed:</p>
                    <p class="mb-1"> '.$mtcCertificatesData['other_specs_agreed'].'</p>
                </div>
            </div>
        </div>
    </div>
</div>
    </td>
</tr>
</table>

<div class="row m-0 mb-10 text-uppercase">
<div class="col-lg-12 p-1">
<table class="table1" width="100%"   style="border-left: 1px solid lightgray; vertical-align: middle; font-size:12px;">
    <tr class="border-0">
        <td rowspan="2" class="fw-bold text-center align-middle"></td>
        <td class="fw-bold text-center border fw-bold" colspan="11">Chemical Analysis</td>
    </tr>
    <tr class="border">'. $parameter .'</tr>
    <tr class="border"><td>Min</td>'. $min_value .'</tr>
    <tr class="border"><td>Max</td>'. $max_value .'</tr>
    <tr class="border"><td>Actual</td>'. $actual .'</tr>
    </tr>
</table>
</div>

    <div class="col-lg-12 p-1">
        <table class="table1" width="100%" border="1"  style="border: 1px solid lightgray; vertical-align: middle; font-size:12px;">
                <tr class="border-0">
                    <td rowspan="3" class="fw-bold text-center align-middle"></td>
                    <td class="fw-bold text-center border fw-bold" colspan="6">Mechanical Properties</td>
                </tr>
                <tr class="border-0">
                    <td class="text-center border">Tensile (UTS)</td>
                    <td class="text-center border">Yield (YS)</td>
                    <td class="text-center border">Elongation (E)</td>
                    <td class="text-center border max-w-50px">Reduction area (Ra)</td>
                    <td class="text-center border min-w-125px">Hardness Test</td>
                    <td class="text-center border min-w-125px">IMPACT TEST</td>
                </tr>
                <tr class="border-0">
                    <td class="text-center border">[Mpa]</td>
                    <td class="text-center border">[Mpa]</td>
                    <td class="text-center border">%</td>
                    <td class="text-center border max-w-50px">%</td>
                    <td class="text-center border min-w-125px">HB</td>
                    <td class="text-center border min-w-125px">JOULES</td>
                </tr>

                <tr>
                    <td class="text-center border fw-bold ps-1">Min</td>
                    <td class="text-center border">'.$tensile['tensile_strength_min'].'</td>
                    <td class="text-center border">'.$tensile['yield_strength_min'].'</td>
                    <td class="text-center border">'.$tensile['elongation_min'].'</td>
                    <td class="text-center border">'.$tensile['reduction_area_min'].'</td>
                    <td class="text-center border">'.$hardness['hardness_test_limit_min'].'</td>
                    <td class="text-center border">'.$impact['impact_test_limit_min'].'</td>
                </tr>
                <tr>
                    <td class="text-center border fw-bold ps-1">Max</td>
                    <td class="text-center border">'.$tensile['tensile_strength_max'].'</td>
                    <td class="text-center border">'.$tensile['yield_strength_max'].'</td>
                    <td class="text-center border">'.$tensile['elongation_max'].'</td>
                    <td class="text-center border">'.$tensile['reduction_area_max'].'</td>
                    <td class="text-center border">'.$hardness['hardness_test_limit_max'].'</td>
                    <td class="text-center border">'.$impact['impact_test_limit_max'].'</td>
                </tr>
                <tr>
                    <td class="text-center border fw-bold ps-1">Actual</td>
                    <td class="text-center border">'.$tensileResult['actual_tensile_strength'].'</td>
                    <td class="text-center border">'.$tensileResult['actual_yield_strength'].'</td>
                    <td class="text-center border">'.$tensileResult['actual_elongation'].'</td>
                    <td class="text-center border">'.$tensileResult['actual_reduction_area'].'</td>
                    <td class="text-center border">'.$hardnessResult['result1'] .'-'. $hardnessResult['result2'] .'-'. $hardnessResult['result3'].'</td>
                    <td class="text-center border">'.$impactResult['result1'] .'-'. $impactResult['result2'] .'-'. $impactResult['result3'].'</td>
                </tr>
                <tr>
                    <td class="text-center border fw-bold ps-1">Average</td>
                    <td class="text-center border">-</td>
                    <td class="text-center border">-</td>
                    <td class="text-center border">-</td>
                    <td class="text-center border">'.$hardnessResult['average'].'</td>
                    <td class="text-center " style="border-left: none;">'.$impactResult['average'].'</td>
                    <td class="text-center  border " ></td>
                </tr>
        </table>
    </div>
</div>
<div class="footer">
<div class="text-end">
<table class="table1" width="100%" style="border: 1px solid lightgray; vertical-align: middle; font-size:12px;">
<tr>
    <td  style="border: 1px solid lightgray;">
    <div class="card m-1 p-2" style="text-align:left">

    <h5 class="m-0">REMARKS</h5>
    <p class="m-0">
        1. - Visual inspection: accepted according PS04/11 JC IT. Other information: no major
        repairs carried
        out.
    </p>
    <p class="m-0">
        2. - We certify that the above material has been manufactured and processed according to
        requirement of
        the above P.O.
    </p>
    <p class="m-0">
        3. - The results above indicated are exact transcription from the correspoding certificates,
        which are
        filed in our factory, issued by our homologated suppliers
    </p>
    <p class="m-0">
        4. - In accordance with NACE MR0175/ISO16166 & NACE MR0103/ISO17945
    </p>
</div>
</td>

</tr>
</table>


<table class="table1" width="100%" style=" font-family: Poppins !important; border: none; vertical-align: middle; font-size:12px;">
<tr>
<td width="50%"  style="border:none;">
<img src="./img/jc-seal.png" width="100px">
<p class="mb-1 h5 fw-bold text-center" style="margin-top: -10px;">JC FABRICA DE VALVULAS S.A.U</p>
<p class="mb-1 text-muted text-center">Quality Control Department</p>
</td>
    <td width="50%"  style="border:none;">
    <div class="text-end mt-2 ">
    <p>
        (x)Visual Inspection:
    </p>
    <p>
        Casting: MSS-SP55 and PS04/11 JC IT
    </p>
    <p>
        Forging: Material Standard applicable and PS04/11 JC IT
    </p>
</div>
    </td>
</tr>
</table>

<div style="font-family: sans-serif; font-size: 12px;">
<table width="100%" style="vertical-align: bottom; font-size: 8px; border: none;">
	<tr>
		<td width="36%"  style="color: #adb5bd; border: none;">
            <div style="border: none;">JC Fabrica de Valvulas S.A.U.</div>
            <div style="border: none;">Quality Control Department</div>
			<div style="border: none;">Av. Segle XXl, 75 - Pol. Ind. Can Calderon</div>
			<div style="border: none;">08830 Sant del Llobregal - Barcelona (Spain)</div>
		</td>
		<td width="15%" style="border-left: 1px solid #d63384; padding-left: 5px; color: #adb5bd; border-right: none; border-top: none; border-bottom: none;">
			<div style="border: none;">jc@jc-valves.com</div>
			<div style="border: none;">www.jc-valves.com</div>
            <div style="border: none;">sales@icp-valves.com</div>
            <div style="border: none;">www.icp-valves.com</div>
		</td>
        <td width="19%" style="border-left: 1px solid #d63384; padding-left: 5px; color: #adb5bd; border-right: none; border-top: none; border-bottom: none;">
        <div style="border: none;">T. +34 936 548 686</div>
        <div style="border: none;">F. +34 936 548 687</div>
        </td>
	</tr>
</table>
</div>
</div>
</div>';

 return $content;
    }else{
        return null;
    }
}


