<?php
session_start();
include('includes/functions.php');
$getDataQuery = "SELECT * FROM supplier_certificates WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);

$supplierSql = "SELECT Supplier_Name FROM Basic_Supplier WHERE Id_Supplier = '$resultData[supplier_id]'";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_assoc($supplierConnect);

$componentSql = "SELECT * FROM components WHERE is_deleted = 0 AND id = '$resultData[component_id]'";
$componentConnect = mysqli_query($con, $componentSql);
$components = mysqli_fetch_assoc($componentConnect);

$materialSpecificationSql = "SELECT material_specification FROM material_specifications WHERE id = '$resultData[material_specification_id]' AND is_deleted = 0";
$materialSpecificationConnect = mysqli_query($con, $materialSpecificationSql);
$materialSpecification = mysqli_fetch_assoc($materialSpecificationConnect);

$chemicalInfoSql = "SELECT material_specification_chemicals.*, chemicals.parameter FROM material_specification_chemicals LEFT JOIN chemicals ON material_specification_chemicals.chemical_id=chemicals.id WHERE material_specification_id = '$resultData[material_specification_id]' AND material_specification_chemicals.status = 1 AND material_specification_chemicals.is_deleted = 0";
$chemicalInfoSqlConnectData = mysqli_query($con, $chemicalInfoSql);
$chemicalInfo = array();
while ($row = mysqli_fetch_assoc($chemicalInfoSqlConnectData)) {
    array_push($chemicalInfo, $row);
}

$ChemicalSql = "SELECT * FROM supplier_certificate_actual_chemicals WHERE supplier_certificate_id = '$_REQUEST[id]'";
$chemicalData = mysqli_query($con, $ChemicalSql);
$chemicalResult = array();
while ($row = mysqli_fetch_assoc($chemicalData)) {
    array_push($chemicalResult, $row);
}


$chemicalArr = array();
if ($chemicalInfo != null && count($chemicalInfo) > 0) {
    foreach ($chemicalInfo as $key => $chemical) {
        if ($chemical['chemical_id'] == '1') {
            $chemicalArr['cMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['cMaxValue'] = $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '2') {
            $chemicalArr['mnMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['mnMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '4') {
            $chemicalArr['sMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['sMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '3') {
            $chemicalArr['siMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['siMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '5') {
            $chemicalArr['pMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['pMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '6') {
            $chemicalArr['crMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['crMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '7') {
            $chemicalArr['moMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['moMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '8') {
            $chemicalArr['niMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['niMAXValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
        if ($chemical['chemical_id'] == '8') {
            $chemicalArr['cuMinValue'] = $chemical['min_value'] ? $chemical['min_value'] : "-";
            $chemicalArr['cuMaxValue'] =  $chemical['max_value'] ? $chemical['max_value'] : "-";
        }
    }
}

$chemicalResultArr = array();
if ($chemicalResult != null && count($chemicalResult) > 0) {
    foreach ($chemicalResult as $key => $chemical) {
        if ($chemical['chemical_id'] == '1') {
            $chemicalResultArr['cActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '2') {
            $chemicalResultArr['mnActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '4') {
            $chemicalResultArr['sActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '3') {
            $chemicalResultArr['siActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '5') {
            $chemicalResultArr['pActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '6') {
            $chemicalResultArr['cActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '7') {
            $chemicalResultArr['moActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '8') {
            $chemicalResultArr['nActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
        if ($chemical['chemical_id'] == '8') {
            $chemicalResultArr['cuActual'] = $chemical['actual'] ? $chemical['actual'] : "-";
        }
    }
}


$tensileSql = "SELECT * FROM material_specification_tensile_test WHERE material_specification_id = '$resultData[material_specification_id]' AND is_deleted = 0";
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

$hardnessSql = "SELECT * FROM material_specification_hardness_test WHERE material_specification_id = '$_REQUEST[id]' AND is_deleted = 0";
$hardnessSqlConnectData = mysqli_query($con, $hardnessSql);
$hardness = mysqli_fetch_assoc($hardnessSqlConnectData);
$hardness['hardness_mu'] = isset($hardness['hardness_mu']) ? $hardness['hardness_mu'] : '-';
$hardness['hardness_test_limit_min'] = (isset($hardness['hardness_test_limit_min'])) ? $hardness['hardness_test_limit_min'] : '-';
$hardness['hardness_test_limit_max'] = isset($hardness['hardness_test_limit_max']) ? $hardness['hardness_test_limit_max'] : '-';

$impactSql = "SELECT * FROM material_specification_impact_test WHERE material_specification_id = '$_REQUEST[id]' AND is_deleted = 0";
$impactSqlConnectData = mysqli_query($con, $impactSql);
$impact = mysqli_fetch_assoc($impactSqlConnectData);
$impact['impact_test_temperature'] = isset($impact['impact_test_temperature']) ? $impact['impact_test_temperature'] : '-';
$impact['impact_test_limit_min'] = isset($impact['impact_test_limit_min']) ? $impact['impact_test_limit_min'] : '-';
$impact['impact_test_limit_max'] = isset($impact['impact_test_limit_max']) ? $impact['impact_test_limit_max'] : '-';

$tensileSql = "SELECT * FROM supplier_certificate_tensile_test WHERE supplier_certificate_id = '$_REQUEST[id]'";
$tensilData = mysqli_query($con, $tensileSql);
$tensileResult =  mysqli_fetch_assoc($tensilData);

$hardnessSql = "SELECT * FROM supplier_certificate_hardness_test WHERE supplier_certificate_id =  '$_REQUEST[id]'";
$hardnessData = mysqli_query($con, $hardnessSql);
$hardnessResult =  mysqli_fetch_assoc($hardnessData);

$impactSql = "SELECT * FROM supplier_certificate_impact_test WHERE supplier_certificate_id =  '$_REQUEST[id]'";
$impactData = mysqli_query($con, $impactSql);
$impactResult =  mysqli_fetch_assoc($impactData);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
    body {
        margin: 0 auto;
        width: 75%;
        font-family: Poppins, Helvetica, sans-serif;
    }
    </style>
</head>

<body>
    <div id="element-to-print" class="main-container">
        <div class="title">
            <div class="title_logo">
                <img id="logo_patch"
                    src='data:image/png;base64,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'>
            </div>
            <div>
                Material Certificate
            </div>
            <div>
                <span>PS07/F2</span>
                <span>rev.1</span>
            </div>
        </div>
        <div class="title1">
            <div>
                <span>SUPPLIER: <?php echo $suppliers['Supplier_Name'] ?></span>
                <span>ISO 9001: approved</span>
                <span>CE 2014/68/EU: approved</span>
            </div>
            <div>
                <span>JCFV CERTIFICATE</span>
                <span>P.O. Nº : <?php echo $resultData['po_number'] ?></span>
                <span>DATE: <?php echo $resultData['po_date'] ?></span>
            </div>
            <div>
                <span><?php echo $resultData['material_certification_type'] ?></span>
                <span>MAT. CERT. Nº: <?php echo $resultData['material_certificate_number'] ?></span>
                <span>DATE : <?php echo $resultData['mtc_date'] ?></span>
            </div>
        </div>
        <div class="title2">
            <div>
                <span>COMPONENT</span>
                <span>DWG/PATERN Nº: <?php echo $resultData['drawing_number'] ?></span>
                <span>NAME: BODY CONNECTOR &nbsp; &nbsp; &nbsp; <?php echo $components['component'] ?></span>
            </div>
            <div>
                <span>SPECIFICATION / MATERIAL</span>
                <span> <?php echo $materialSpecification['material_specification'] ?></span>
                <span>Grade : 1.4408</span>
            </div>
        </div>
        <div class="title3">
            <div>
                <span><b>HEAT TREATMENT: </b></span>
                <span>SOLUTION ANNEALING 1080 ℃×2-2.5H+</span>
                <span>WATER QUENCHING.</span>
            </div>
            <div>
                <span><b>MELTING PROCESS :</b></span>
                <span>INDUCTION</span>
            </div>
            <div>
                <span><b>HEAT NUMBER : <?php echo $resultData['heat_number'] ?></b></span>
                <span><b>QTY : </b> <?php echo $resultData['qty'] ?></span>

            </div>
        </div>


        <table class="title4">
            <tr style="border-bottom: 1px solid black;">
                <th style="border-right: 1px solid black;" colspan="11">CHEMICAL COMPOSITION %</th>
            </tr>
            <tr>
                <th> </th>
                <th>C</th>
                <th>Mn</th>
                <th>S</th>
                <th>P</th>
                <th>Si</th>
                <th>Cr</th>
                <th>Ni</th>
                <th>Mo</th>
                <th style="border-right: 1px solid black;">Cu</th>
            </tr>

            <tr>
                <th> Min</th>
                <th><?php echo isset($chemicalArr['cMinValue']) ? $chemicalArr['cMinValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['mnMinValue']) ? $chemicalArr['mnMinValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['sMinValue']) ? $chemicalArr['sMinValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['pMinValue']) ? $chemicalArr['pMinValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['siMinValue']) ? $chemicalArr['siMinValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['crMinValue']) ? $chemicalArr['crMinValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['niMinValue']) ? $chemicalArr['niMinValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['moMinValue']) ? $chemicalArr['moMinValue'] : "-"  ?></th>
                <th style="border-right: 1px solid black;">
                    <?php echo isset($chemicalArr['cuMinValue']) ? $chemicalArr['cuMinValue'] : "-" ?></th>
            </tr>
            <tr>
                <th> Max</th>
                <th><?php echo isset($chemicalArr['cMaxValue']) ? $chemicalArr['cMaxValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['mnMaxValue']) ? $chemicalArr['mnMaxValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['sMaxValue']) ? $chemicalArr['sMaxValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['pMaxValue']) ? $chemicalArr['pMaxValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['siMaxValue']) ? $chemicalArr['siMaxValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['crMaxValue']) ? $chemicalArr['crMaxValue'] : "-" ?></th>
                <th><?php echo isset($chemicalArr['niMaxValue']) ? $chemicalArr['niMaxValue'] : "-"  ?></th>
                <th><?php echo isset($chemicalArr['moMaxValue']) ? $chemicalArr['moMaxValue'] : "-"  ?></th>
                <th style="border-right: 1px solid black;">
                    <?php echo isset($chemicalArr['cuMaxValue']) ? $chemicalArr['cuMaxValue'] : "-" ?></th>
            </tr>
            <tr style="border-top:1px solid black ;">
                <th></th>
                <th><?php echo isset($chemicalResultArr['cActual']) ? $chemicalResultArr['cActual'] : "-" ?></th>
                <th><?php echo isset($chemicalResultArr['mnActual']) ? $chemicalResultArr['mnActual'] : "-"  ?></th>
                <th><?php echo isset($chemicalResultArr['sActual']) ? $chemicalResultArr['sActual'] : "-" ?></th>
                <th><?php echo isset($chemicalResultArr['pActual']) ? $chemicalResultArr['pActual'] : "-"  ?></th>
                <th><?php echo isset($chemicalResultArr['siActual']) ? $chemicalResultArr['siActual'] : "-"  ?></th>
                <th><?php echo isset($chemicalResultArr['crActual']) ? $chemicalResultArr['crActual'] : "-" ?></th>
                <th><?php echo isset($chemicalResultArr['niActual']) ? $chemicalResultArr['niActual'] : "-"  ?></th>
                <th><?php echo isset($chemicalResultArr['moActual']) ? $chemicalResultArr['moActual'] : "-"  ?></th>
                <th style="border-right: 1px solid black;">
                    <?php echo isset($chemicalResultArr['cuActual']) ? $chemicalResultArr['cuActual'] : "-" ?></th>
            </tr>

        </table>

        <table class="title4" style="margin-top:30px">
            <tr style="border-bottom: 1px solid black;">
                <th style="border-right: 1px solid black;" colspan="7">PHYSICAL PROPERTIES</th>
            </tr>
            <tr>
                <th></th>
                <th> Yield St.1.0%</th>
                <th> Tensile St.</th>
                <th> Elongation</th>
                <th> Reduc.Area</th>
                <th> Hardness</th>
                <th> Impact Test ISO V</th>
                <th> T</th>
            </tr>
            <tr>
                <th>Min</th>
                <th> <?php echo isset($tensile['yield_strength_min']) ? $tensile['yield_strength_min'] : "-" ?></th>
                <th> <?php echo isset($tensile['tensile_strength_min']) ? $tensile['tensile_strength_min'] : "-" ?></th>
                <th> <?php echo isset($tensile['elongation_min']) ? $tensile['elongation_min'] : "-" ?></th>
                <th> <?php echo isset($tensile['reduction_area_min']) ? $tensile['reduction_area_min'] : "-" ?></th>
                <th> <?php echo isset($hardness['hardness_test_limit_min']) ? $hardness['hardness_test_limit_min'] : "-" ?>
                </th>
                <th><?php echo isset($impact['impact_test_limit_min']) ? $impact['impact_test_limit_min'] : "-" ?></th>
                <th>-</th>
            </tr>
            <tr>
                <th>Max</th>
                <th> <?php echo isset($tensile['yield_strength_max']) ? $tensile['yield_strength_max'] : "-" ?></th>
                <th> <?php echo isset($tensile['tensile_strength_max']) ? $tensile['tensile_strength_max'] : "-" ?></th>
                <th> <?php echo isset($tensile['elongation_max']) ? $tensile['elongation_max'] : "-" ?></th>
                <th> <?php echo isset($tensile['reduction_area_max']) ? $tensile['reduction_area_max'] : "-" ?></th>
                <th> <?php echo isset($hardness['hardness_test_limit_max']) ? $hardness['hardness_test_limit_max'] : "-" ?>
                </th>
                <th><?php echo isset($impact['impact_test_limit_max']) ? $impact['impact_test_limit_max'] : "-" ?></th>
                <th>-</th>
            </tr>
            <tr>
                <th></th>
                <th> MPa</th>
                <th> MPa</th>
                <th> %</th>
                <th> %</th>
                <th> HB</th>
                <th> J</th>
                <th> ºC</th>
            </tr>
            <tr style="border-top:1px solid black ;">
                <th></th>
                <th><?php echo isset($tensileResult['actual_yield_strength']) ? $tensileResult['actual_yield_strength'] : "-" ?>
                </th>
                <th> <?php echo isset($tensileResult['actual_tensile_strength']) ? $tensileResult['actual_tensile_strength'] : "-" ?>
                </th>
                <th><?php echo isset($tensileResult['actual_elongation']) ? $tensileResult['actual_elongation'] : "-" ?>
                </th>
                <th><?php echo isset($tensileResult['actual_reduction_area']) ? $tensileResult['actual_reduction_area'] : "-" ?>
                </th>
                <th><?php echo isset($hardnessResult['average']) ? $hardnessResult['average'] : "-" ?></th>
                <th><?php echo isset($impactResult['average']) ? $impactResult['average'] : "-" ?></th>
                <th> -</th>
            </tr>

        </table>

        <div class="title5">
            <span style="font-weight: bold ;">Remarks</span>
            <div style="height: unset">1.- Visual insdivection: accedivted according divS04-I1 JC IT. Other information:
                no major redivairs
                carried out.</div>
            <div style="height: unset">2.- We certify that the above material has been manufactured and divrocessed
                according to requirement
                of the above div.O.</div>
            <div style="height: unset">3.- The results above indicated are exact transcridivtion from the
                corresdivonding certificates , which
                are filed in our factory,issued by our homologated sudivdivliers.</div>
            <div style="height: unset">4.- In accordance with NACE MR0175/ISO15156 & NACE MR0103/ISO17945</div>
        </div>
        <div class="title6">
            <p> (x)Visual Inspection:</p>
            <p> Casting: MSS-SP55 and PS04-I1 JC IT</p>
            <p> Forging: Material Standard applicable and PS04-I1 JC IT</p>
        </div>
        <div class="title7">
            <p><b>JC FABRICA DE VALVULAS, S.A</b></p>
            <p>Quality Control Dep.</p>
        </div>
        <div class="title8">
            <div class="title8_dep">

            </div>
            <div class="title8_dep">
                <p>
                    <b>J.C Fabrica de valvulas S.A.U</b>
                </p>
                <p>
                    Av. Segle XXL. 75 -pol. Ind Can Calderon
                </p>
                <p>
                    08830 Sant Boi del Liobregat - Barcelona (Spain)

                </p>
            </div>
            <div class="title8_dep second">
                <p style="color:white ;">dfggds</p>
                <p>
                    T +34 936 548 686
                </p>
                <p>
                    F +34 936 548 687
                </p>
            </div>
            <div class="title8_dep third">
                <p style="color:white ;">fdsf</p>
                <p class="eee">
                    jc@jc-valves.com
                </p>
                <p>
                    www.jc-valves.com
                </p>
            </div>
        </div>
    </div>


    <script>
    //    setTimeout(()=>{
    //     var element = document.getElementById('element-to-print');
    //     var worker = html2pdf().from(element).save('jcpdf');
    //    console.log(worker)
    //    },2000)
    //  var ab = 
    </script>
</body>

</html>