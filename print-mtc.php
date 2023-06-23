<?php
// session_start();
// test comment
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

$classSql = "SELECT * FROM classes WHERE is_deleted = 0 AND id = '$resultData[class_id]'";
$classConnect = mysqli_query($con, $classSql);
$classes = mysqli_fetch_assoc($classConnect);

$sizeSql = "SELECT * FROM sizes WHERE is_deleted = 0 AND id = '$resultData[size_id]'";
$sizeConnect = mysqli_query($con, $sizeSql);
$sizes = mysqli_fetch_assoc($sizeConnect);

$materialSpecificationSql = "SELECT * FROM material_specifications WHERE id = '$resultData[material_specification_id]' AND is_deleted = 0";
$materialSpecificationConnect = mysqli_query($con, $materialSpecificationSql);
$materialSpecification = mysqli_fetch_assoc($materialSpecificationConnect);

$chemicalInfoSql = "SELECT supplier_certificate_actual_chemicals.actual, material_specification_chemicals.min_value,material_specification_chemicals.max_value,chemicals.parameter 
FROM supplier_certificate_actual_chemicals 
LEFT JOIN material_specification_chemicals ON material_specification_chemicals.chemical_id = supplier_certificate_actual_chemicals.chemical_id
LEFT JOIN chemicals ON chemicals.id =  supplier_certificate_actual_chemicals.chemical_id
LEFT JOIN supplier_certificates ON supplier_certificates.id = supplier_certificate_actual_chemicals.supplier_certificate_id
WHERE material_specification_chemicals.material_specification_id = '$resultData[material_specification_id]' AND supplier_certificates.id = '$_REQUEST[id]' AND supplier_certificate_actual_chemicals.is_deleted = 0 AND material_specification_chemicals.is_deleted = 0 AND chemicals.is_deleted = 0";
$chemicalInfoConnect = mysqli_query($con, $chemicalInfoSql);

$chemicalData = [];

while ($chemicalInfoData = mysqli_fetch_assoc($chemicalInfoConnect)) {
    $row = array(
        "parameter"=>(isset($chemicalInfoData['parameter']) && $chemicalInfoData['parameter']) ? $chemicalInfoData['parameter'] : "-", 
        "min_value"=>(isset($chemicalInfoData['min_value']) && $chemicalInfoData['min_value']) ? $chemicalInfoData['min_value'] : "-", 
        "max_value"=>(isset($chemicalInfoData['max_value']) && $chemicalInfoData['max_value']) ? $chemicalInfoData['max_value'] : "-",
        "actual"=>(isset($chemicalInfoData['actual']) && $chemicalInfoData['actual']) ? $chemicalInfoData['actual'] : "-"
    );
    
    array_push($chemicalData, $chemicalInfoData);
}

// $heatSql = "SELECT * FROM heat_treatments WHERE material_specification_id = $resultData[material_specification_id]";
$heatSql = "SELECT * FROM supplier_certificate_heat_notes WHERE supplier_certificate_id = '$_REQUEST[id]'";
$heatSqlConnectData = mysqli_query($con, $heatSql);
$heat = mysqli_fetch_assoc($heatSqlConnectData);
if (!isset($heat['heat_notes'])) {
    $heat['heat_notes'] = "-";
    $heat['id'] = null;
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

$hardnessSql = "SELECT * FROM material_specification_hardness_test WHERE material_specification_id = '$resultData[material_specification_id]' AND is_deleted = 0";
$hardnessSqlConnectData = mysqli_query($con, $hardnessSql);
$hardness = mysqli_fetch_assoc($hardnessSqlConnectData);
$hardness['hardness_mu'] = isset($hardness['hardness_mu']) ? $hardness['hardness_mu'] : '-';
$hardness['hardness_test_limit_min'] = (isset($hardness['hardness_test_limit_min']) && $hardness['hardness_test_limit_min'] != "") ? $hardness['hardness_test_limit_min'] : '-';
$hardness['hardness_test_limit_max'] = isset($hardness['hardness_test_limit_max']) && $hardness['hardness_test_limit_max'] != "" ? $hardness['hardness_test_limit_max'] : '-';

$impactSql = "SELECT * FROM material_specification_impact_test WHERE material_specification_id = '$resultData[material_specification_id]' AND is_deleted = 0";
$impactSqlConnectData = mysqli_query($con, $impactSql);
$impact = mysqli_fetch_assoc($impactSqlConnectData);
$impact['impact_test_temperature'] = isset($impact['impact_test_temperature']) && $impact['impact_test_temperature'] != "" ? "@ " . $impact['impact_test_temperature'] : '';
$impact['impact_test_limit_min'] = isset($impact['impact_test_limit_min']) && $impact['impact_test_limit_min'] != "" ? $impact['impact_test_limit_min'] : '-';
$impact['impact_test_limit_max'] = isset($impact['impact_test_limit_max']) && $impact['impact_test_limit_max'] != "" ? $impact['impact_test_limit_max'] : '-';

$tensileSql = "SELECT * FROM supplier_certificate_tensile_test WHERE supplier_certificate_id = '$_REQUEST[id]'";
$tensilData = mysqli_query($con, $tensileSql);
$tensileResult =  mysqli_fetch_assoc($tensilData);
print_r($tensileResult);
die();
$hardnessSql = "SELECT * FROM supplier_certificate_hardness_test WHERE supplier_certificate_id =  '$_REQUEST[id]'";
$hardnessData = mysqli_query($con, $hardnessSql);
$hardnessResult =  mysqli_fetch_assoc($hardnessData);

$impactSql = "SELECT * FROM supplier_certificate_impact_test WHERE supplier_certificate_id =  '$_REQUEST[id]'";
$impactData = mysqli_query($con, $impactSql);
$impactResult =  mysqli_fetch_assoc($impactData);

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTC</title>
</head>

<style>
    :root {
        --pdf-height: 1080px;
    }

    #element-to-print {
        padding: 0 !important;
        font-family: Poppins, Helvetica, sans-serif;
        height: var(--pdf-height);
    }

    #element-to-print .bordered-table-body td {
        padding-bottom: 5px;
        padding-top: 5px;
        font-size: 9px;

    }

    #element-to-print .bordered-table-body {
        border: 1px solid rgba(0, 0, 0, 0.125) !important;
    }

    #element-to-print p {
        font-size: 10px;
    }

    #element-to-print p .text-uppercase {
        font-size: 9px;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        margin-top: 0;
    }

    #element-to-print .footer {
        position: absolute;
        bottom: 0;
        width: 98%;
    }

    #element-to-print .footer p {
        font-size: 10px !important;
    }
</style>

<body>
    <div id="element-to-print">
        <!-- fluid -->
        <!--Header-->
        <div class="card m-0">
            <div class="row p-1">
                <div class="col-md-2 py-1">
                    <div class="card py-1 h-100">
                        <div class="">
                            <?php if ($_REQUEST['mode'] == 1) { ?>
                                <img src="logo/admin-logo.png" class="mx-auto d-block py-1" width="38">
                            <?php } else { ?>
                                <img src="logo/ipc-logo.jpeg" class="mx-auto d-block py-1" width="45" height="40">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 py-1">
                    <div class="card py-1 h-100">
                        <h1 class="text-uppercase text-center m-0 pt-1">
                            Material Certificate
                        </h1>
                    </div>
                </div>
                <div class="col-md-2 py-1">
                    <div class="card py-1 h-100 pt-2">
                        <p class="text-center m-0">
                            PS0/F2
                        </p>
                        <p class="text-center m-0">
                            REV.1
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--content 1-->
        <div class="card mt-2 text-uppercase">
            <div class="row m-0">
                <div class="col-lg-4 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Supplier:</p>
                            <p class="mb-1"><?php echo $suppliers['Supplier_Name'] ?></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">ISO 9001: </p>
                            <p class="mb-1">Approved</p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">2014/68/EU: </p>
                            <p class="mb-1">Approved</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">P.0 NO:</p>
                            <p class="mb-1"><?php echo $resultData['po_number'] ?></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Date: </p>
                            <p class="mb-1"><?php echo  date('d-m-Y', strtotime($resultData['po_date'])) ?></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Revision: </p>
                            <p class="mb-1"><?php echo $resultData['po_revision'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Material Cert NO:</p>
                            <p class="mb-1"><?php echo $resultData['material_certificate_number'] ?></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Date: </p>
                            <p class="mb-1"> <?php echo date('d-m-Y', strtotime($resultData['mtc_date'])) ?></p>
                        </div>
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Revision: </p>
                            <p class="mb-1"><?php echo $resultData['mtc_revision'] ?></p>
                             <p class="mb-1">BS EN ISO - 10204 3.1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--content 2-->
        <div class="card mt-2 text-uppercase">
            <div class="row p-1">
                <div class="col-md-6">
                    <div class="card p-1 h-100">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 me-2 fw-bold">Item Code:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1"><?php echo $resultData['item_code'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 me-2 fw-bold">Drawing No:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1"><?php echo $resultData['drawing_number'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 me-2 fw-bold">Component:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1"><?php echo $components['component'] ?></p>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1 me-2 fw-bold">Size:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="mb-1"><?php echo $sizes['size'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-1 h-100">
                       
                        <div class="row">
                            <div class="col-md-5">
                                <p class="mb-1 me-2 fw-bold">Class:</p>
                            </div>
                            <div class="col-md-7">
                                <p class="mb-1"><?php echo $classes['class'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <p class="mb-1 me-2 fw-bold">Material:</p>
                            </div>
                            <div class="col-md-7">
                                <p class="mb-1"><?php echo $materialSpecification['material_specification'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <p class="mb-1 me-2 fw-bold">Edition:</p>
                            </div>
                            <div class="col-md-7">
                                <p class="mb-1"><?php echo $materialSpecification['nom_comp'] ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="d-flex">
                                    <p class="mb-1 me-2 fw-bold">Heat NO: </p>
                                    <p class="mb-1"><?php echo $resultData['heat_number'] ?></p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="d-flex">
                                    <p class="mb-1 me-2 fw-bold">QTY: </p>
                                    <p class="mb-1"><?php echo $resultData['qty'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--content 3-->
        <div class="card mt-2 text-uppercase">
            <div class="row m-0">
                <div class="col-12 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Heat Treatment:</p>
                            <p class="mb-1"><?php echo $heat['heat_notes'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-2 text-uppercase">
            <div class="row m-0">
                <div class="col-6 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Melting Process:</p>
                            <p class="mb-1">
                                <?php echo $resultData['melting_process'] ? $resultData['melting_process'] : "-"  ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-6 p-1">
                    <div class="card p-1 h-100">
                        <div class="d-flex">
                            <p class="mb-1 me-2 fw-bold">Other specs agreed:</p>
                            <p class="mb-1">
                                <?php echo $resultData['other_specs_agreed'] ? $resultData['other_specs_agreed'] : "-" ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-0 mt-2 text-uppercase">
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
                        <tr class="border-0">
                            <td rowspan="2" class="fw-bold text-center align-middle"></td>
                            <td class="fw-bold text-center border fw-bold" colspan="11">Chemical Analysis</td>
                        </tr>
                        <tr class="border-0">
                            <?php for ($i=0; $i < (count($chemicalData) > 11 ? ceil(count($chemicalData)/2) : count($chemicalData)); $i++) { ?>
                                <td class="text-center border"><?php echo $chemicalData[$i]['parameter']; ?></td>
                            <?php }  ?>
                        </tr>
                        <tr>
                            <td class="text-center border fw-bold">Min</td>
                            <?php for ($i=0; $i < (count($chemicalData) > 11 ? ceil(count($chemicalData)/2) : count($chemicalData)); $i++) { ?>
                                <td class="text-center border"><?php echo $chemicalData[$i]['min_value'] ? $chemicalData[$i]['min_value'] : "-"; ?></td>
                            <?php }  ?>
                        </tr>
                        <tr>
                            <td class="text-center border fw-bold">Max</td>
                            <?php for ($i=0; $i < (count($chemicalData) > 11 ? ceil(count($chemicalData)/2) : count($chemicalData)); $i++) { ?>
                                <td class="text-center border"><?php echo $chemicalData[$i]['max_value'] ? $chemicalData[$i]['max_value'] : "-"; ?></td>
                            <?php }  ?>
                        </tr>
                         <tr>
                            <td class="text-center border ps-1 fw-bold">Actual</td>
                            <?php for ($i=0; $i < (count($chemicalData) > 11 ? ceil(count($chemicalData)/2) : count($chemicalData)); $i++) { ?>
                                <td class="text-center border"><?php echo $chemicalData[$i]['actual'] ? $chemicalData[$i]['actual']: "-"; ?></td>
                            <?php }  ?>
                        </tr>

                        <?php if (count($chemicalData) > 11) {  ?>
                            <tr class="border-0">
                                <td></td>
                                <?php for ($i=ceil(count($chemicalData)/2); $i < (count($chemicalData) > 22 ? 22 : count($chemicalData)); $i++) { ?>
                                    <td class="text-center border"><?php echo $chemicalData[$i]['parameter']; ?></td>
                                <?php }  ?>
                            </tr>
                            <tr>
                            <td class="text-center border fw-bold">Min</td>
                                <?php for ($i=ceil(count($chemicalData)/2); $i < (count($chemicalData) > 22 ? 22 : count($chemicalData)); $i++) { ?>
                                    <td class="text-center border"><?php echo $chemicalData[$i]['min_value'] ? $chemicalData[$i]['min_value'] : "-"; ?></td>
                                <?php }  ?>
                            </tr>

                            <tr>
                                <td class="text-center border fw-bold">Max</td>
                                <?php for ($i=ceil(count($chemicalData)/2); $i < (count($chemicalData) > 22 ? 22 : count($chemicalData)); $i++) { ?>
                                    <td class="text-center border"><?php echo $chemicalData[$i]['max_value'] ? $chemicalData[$i]['max_value'] : "-"; ?></td>
                                <?php }  ?>
                            </tr>

                            <tr>
                                <td class="text-center border fw-bold ps-1">Actual</td>
                                <?php for ($i=ceil(count($chemicalData)/2); $i < (count($chemicalData) > 22 ? 22 : count($chemicalData)); $i++) { ?>
                                    <td class="text-center border"><?php echo $chemicalData[$i]['actual'] ? $chemicalData[$i]['actual'] : "-"; ?></td>
                                <?php }  ?>
                            </tr>
                        <?php  } ?>
                    </tbody>
                </table>
            </div>

        <!--content 3(table)-->
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
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
                            <td class="text-center border min-w-125px">IMPACT TEST <?php echo $impact['impact_test_temperature'] ?></td>
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
                            <td class="text-center border"><?php echo isset($tensile['tensile_strength_min']) ? $tensile['tensile_strength_min'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['yield_strength_min']) ? $tensile['yield_strength_min'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['elongation_min']) ? $tensile['elongation_min'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['reduction_area_min']) ? $tensile['reduction_area_min'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($hardness['hardness_test_limit_min']) ? $hardness['hardness_test_limit_min'] : "-" ?></td>
                            <td class="text-center border"><?php echo $impact['impact_test_limit_min'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-center border fw-bold ps-1">Max</td>
                            <td class="text-center border"><?php echo isset($tensile['tensile_strength_max']) ? $tensile['tensile_strength_max'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['yield_strength_max']) ? $tensile['yield_strength_max'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['elongation_max']) ? $tensile['elongation_max'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensile['reduction_area_max']) ? $tensile['reduction_area_max'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($hardness['hardness_test_limit_max']) ? $hardness['hardness_test_limit_max'] : "-" ?></td>
                            <td class="text-center border"><?php echo $impact['impact_test_limit_max'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-center border fw-bold ps-1">Actual</td>
                            <td class="text-center border"><?php echo isset($tensileResult['actual_tensile_strength']) ? $tensileResult['actual_tensile_strength'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensileResult['actual_yield_strength']) ? $tensileResult['actual_yield_strength'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensileResult['actual_elongation']) ? $tensileResult['actual_elongation'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($tensileResult['actual_reduction_area']) ? $tensileResult['actual_reduction_area'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($hardnessResult['result1']) ? $hardnessResult['result1'] : "-" ?> - <?php echo isset($hardnessResult['result2']) ? $hardnessResult['result2'] : "-" ?> - <?php echo isset($hardnessResult['result3']) ? $hardnessResult['result3'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($impactResult['result1']) ? $impactResult['result1'] : "-" ?> - <?php echo isset($impactResult['result2']) ? $impactResult['result2'] : "-" ?> - <?php echo isset($impactResult['result3']) ? $impactResult['result3'] : "-" ?></td>
                        </tr>
                        <tr>
                            <td class="text-center border fw-bold ps-1">Average</td>
                            <td class="text-center border">-</td>
                            <td class="text-center border">-</td>
                            <td class="text-center border">-</td>
                            <td class="text-center border">-</td>
                            <td class="text-center border"><?php echo isset($hardnessResult['average']) ? $hardnessResult['average'] : "-" ?></td>
                            <td class="text-center border"><?php echo isset($impactResult['average']) ? $impactResult['average'] : "-" ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="text-end mt-4">
                <div class="row p-1 ps-2">
                    <!--content4 -->
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
                            4. - In accordance with NACE MR0175/ISO15156 & NACE MR0103/ISO17945
                        </p>
                    </div>

                    <!--content 5-->
                    <div class="text-end mt-2 ">
                        <p class="mb-1">
                            (x)Visual Inspection:
                        </p>
                        <p class="mb-1">
                            Casting: MSS-SP55 and PS04/11 JC IT
                        </p>
                        <p class="mb-1">
                            Forging: Material Standard applicable and PS04/11 JC IT
                        </p>
                    </div>
                </div>
                <div class="row m-0 mt-2">
                    <div class="col-3 p-1">
                         <?php if ($_REQUEST['mode'] == 1) { ?>
                                <img src="./logo/jc-seal.jpg" class="mx-auto d-block py-1" width="160" style="margin-top: -90px;">
                                <p class="mb-1 h5 fw-bold text-center" style="margin-top: -10px;">JC FABRICA DE VALVULAS S.A.U</p>
                                 <p class="mb-1 text-muted text-center">Quality Control Department</p>
                            <?php } else { ?>
                                <img src="logo/icp-seal.jpg" class="mx-auto d-block py-1" width="175" style="margin-top: -90px;">
                                <p class="mb-1 h5 fw-bold text-center" style="margin-top: -20px;">ICP VALVES S.A.U</p>
                                 <p class="mb-1 text-muted text-center">Quality Control Department</p>
                            <?php } ?>
                    </div>
                    <div class="col-4 p-1">
                        <?php if ($_REQUEST['mode'] == 1) { ?>
                            <p class="mb-1 fw-bold">
                                JC Fabrica de Valvulas S.A.U.
                            </p>
                        <?php } else { ?>
                            <p class="mb-1 fw-bold">
                                ICP VALVES, S.A.U
                            </p>
                        <?php } ?>
                        <p class="mb-1 text-muted">
                            Av. Segle XXl, 75 - Pol. Ind. Can Calderon
                        </p>
                        <p class="mb-1 text-muted">
                            08830 Sant del Llobregal - Barcelona (Spain)
                        </p>
                    </div>
                    <div class="col-2 p-1">
                        <p class="mb-1 fw-bold">
                            &nbsp;
                        </p>
                        <div class="border-start border-2 border-danger ps-3">
                            <p class="mb-1 text-muted">
                                T. +34 936 548 686
                            </p>
                            <p class="mb-1 text-muted">
                                F. +34 936 548 687
                            </p>
                        </div>
                    </div>
                    <div class="col-3 p-1">
                        <p class="mb-1 fw-bold">
                            &nbsp;
                        </p>
                        <div class="border-start border-2 border-danger ps-1">
                            <?php if ($_REQUEST['mode'] == 1) { ?>
                                <p class="mb-1 text-muted">
                                    jc@jc-valves.com
                                </p>
                                <p class="mb-1 text-muted">
                                    www.jc-valves.com
                                </p>
                            <?php } else { ?>
                                <p class="mb-1 text-muted">
                                    sales@icp-valves.com
                                </p>
                                <p class="mb-1 text-muted">
                                    www.icp-valves.com/
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="JS/jquery-3.6.0.min.js"></script>

<script>
    //document management system
    const acc = document.getElementsByClassName("accordion");
    let i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            const panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }

    const addButton = document.getElementsByClassName('add-folder');
    for (i = 0; i < addButton.length; i++) {
        addButton[i].addEventListener('click', function(e) {
            e.stopPropagation();
        })
    }

    const addPermission = document.getElementsByClassName('add-permission');
    for (i = 0; i < addPermission.length; i++) {
        addPermission[i].addEventListener('click', function(e) {
            e.stopPropagation();
        })
    }
    // setTimeout(() => {
    //     var element = document.getElementById('element-to-print');
    //     var opt = {
    //         margin: 0.5,
    //         image: {
    //             type: 'jpeg',
    //             quality: 0.98
    //         },
    //         html2canvas: {
    //             scale: 7,
    //             letterRendering: false,
    //             dpi: 500,
    //             width: 750,
    //         },
    //         jsPDF: {
    //             unit: 'in',
    //             format: 'A4',
    //             orientation: 'portrait'
    //         },
    //     };

    //     var worker = html2pdf().set(opt).from(element).save('jcpdf');

    // }, 1000)
</script>

</html>