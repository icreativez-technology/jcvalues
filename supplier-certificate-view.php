<?php
session_start();
include('includes/functions.php');
$_SESSION['Page_Title'] = "View Supplier Certificate";
$getDataQuery = "SELECT supplier_certificates.id,supplier_certificates.po_number, supplier_certificates.material_certificate_number, supplier_certificates.po_date,
supplier_certificates.po_revision, supplier_certificates.mtc_revision, supplier_certificates.mtc_date,
supplier_certificates.item_code, supplier_certificates.drawing_number,supplier_certificates.certificate_type_id,material_specifications.nom_comp, supplier_certificates.material_specification_id,
supplier_certificates.heat_number, supplier_certificates.qty,supplier_certificates.material_certification_type, Basic_Supplier.Supplier_Name,material_specifications.material_specification, 
sizes.size, classes.class, components.component, certificate_types.certificate_type_name FROM supplier_certificates 
INNER JOIN Basic_Supplier ON supplier_certificates.supplier_id = Basic_Supplier.Id_Supplier 
INNER JOIN material_specifications ON supplier_certificates.material_specification_id = material_specifications.id
INNER JOIN sizes ON supplier_certificates.size_id = sizes.id
INNER JOIN classes ON supplier_certificates.class_id = classes.id
INNER JOIN components ON supplier_certificates.component_id = components.id
INNER JOIN certificate_types ON supplier_certificates.certificate_type_id = certificate_types.id
WHERE supplier_certificates.is_deleted = 0 AND material_specifications.is_deleted = 0 AND sizes.is_deleted = 0
AND classes.is_deleted = 0 AND components.is_deleted =0 AND certificate_types.is_deleted = 0 AND supplier_certificates.id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);

$file = null;
if ($resultData['certificate_type_id'] == 1) {
    $getFileQuery = "SELECT file_path FROM original_certificates WHERE is_deleted = 0 AND supplier_certificate_id ='$_REQUEST[id]'";
    $fileData = mysqli_query($con, $getFileQuery);
    $file = mysqli_fetch_assoc($fileData);
}

if (isset($resultData['material_specification_id'])) {
    $heatSql = "SELECT * FROM heat_treatments WHERE material_specification_id = $resultData[material_specification_id]";
    $heatSqlConnectData = mysqli_query($con, $heatSql);
    $heat = mysqli_fetch_assoc($heatSqlConnectData);
    if (!isset($heat['heat_treatment'])) {
        $heat['heat_treatment'] = "-";
    }
    $tensileSql = "SELECT * FROM material_specification_tensile_test WHERE material_specification_id = $resultData[material_specification_id] AND is_deleted = 0";
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

    $hardnessSql = "SELECT * FROM material_specification_hardness_test WHERE material_specification_id = $resultData[material_specification_id] AND is_deleted = 0";
    $hardnessSqlConnectData = mysqli_query($con, $hardnessSql);
    $hardness = mysqli_fetch_assoc($hardnessSqlConnectData);
    $hardness['hardness_mu'] = ($hardness['hardness_mu']) ? $hardness['hardness_mu'] : '-';
    $hardness['hardness_test_limit_min'] = ($hardness['hardness_test_limit_min']) ? $hardness['hardness_test_limit_min'] : '-';
    $hardness['hardness_test_limit_max'] = ($hardness['hardness_test_limit_max']) ? $hardness['hardness_test_limit_max'] : '-';

    $impactSql = "SELECT * FROM material_specification_impact_test WHERE material_specification_id = $resultData[material_specification_id] AND is_deleted = 0";
    $impactSqlConnectData = mysqli_query($con, $impactSql);
    $impact = mysqli_fetch_assoc($impactSqlConnectData);
    $impact['impact_test_temperature'] = ($impact['impact_test_temperature']) ? $impact['impact_test_temperature'] : '-';
    $impact['impact_test_limit_min'] = ($impact['impact_test_limit_min']) ? $impact['impact_test_limit_min'] : '-';
    $impact['impact_test_limit_max'] = ($impact['impact_test_limit_max']) ? $impact['impact_test_limit_max'] : '-';

    $chemicalInfoSql = "SELECT material_specification_chemicals.*, chemicals.parameter FROM material_specification_chemicals LEFT JOIN chemicals ON material_specification_chemicals.chemical_id=chemicals.id WHERE material_specification_id = $resultData[material_specification_id] AND material_specification_chemicals.status = 1 AND material_specification_chemicals.is_deleted = 0";
    $chemicalInfoSqlConnectData = mysqli_query($con, $chemicalInfoSql);
    $chemicalInfo = array();
    while ($row = mysqli_fetch_assoc($chemicalInfoSqlConnectData)) {
        array_push($chemicalInfo, $row);
    }
}

$ChemicalSql = "SELECT * FROM supplier_certificate_actual_chemicals WHERE supplier_certificate_id = $resultData[id]";
$chemicalData = mysqli_query($con, $ChemicalSql);
$chemicalResult = array();
while ($row = mysqli_fetch_assoc($chemicalData)) {
    array_push($chemicalResult, $row);
}

$SpecialTestSql = "SELECT * FROM supplier_certificate_special_tests WHERE supplier_certificate_id = $resultData[id]";
$specialData = mysqli_query($con, $SpecialTestSql);
$specialResult =  array();
while ($row = mysqli_fetch_assoc($specialData)) {
    array_push($specialResult, $row);
}

$heatSql = "SELECT * FROM supplier_certificate_heat_notes WHERE supplier_certificate_id = $resultData[id]";
$heatData = mysqli_query($con, $heatSql);
$heatResult =  mysqli_fetch_assoc($heatData);

$tensileSql = "SELECT * FROM supplier_certificate_tensile_test WHERE supplier_certificate_id = $resultData[id]";
$tensilData = mysqli_query($con, $tensileSql);
$tensileResult =  mysqli_fetch_assoc($tensilData);

$hardnessSql = "SELECT * FROM supplier_certificate_hardness_test WHERE supplier_certificate_id = $resultData[id]";
$hardnessData = mysqli_query($con, $hardnessSql);
$hardnessResult =  mysqli_fetch_assoc($hardnessData);

$impactSql = "SELECT * FROM supplier_certificate_impact_test WHERE supplier_certificate_id = $resultData[id]";
$impactData = mysqli_query($con, $impactSql);
$impactResult =  mysqli_fetch_assoc($impactData);

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<!-- Meta tags + CSS -->
<?php include('includes/admin_check.php'); ?>
<!--begin::Body-->

<style>
    .icon-view {
        background-color: #eff2f5;
        display: inline-block;
        position: absolute;
        right: 0px;
        top: 0px;
        padding: 9px;
        border-bottom-right-radius: 5px;
        border-top-right-radius: 5px;
        color: #009ef7;
    }

    .view-pdf {
        position: relative;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    .tab-parameter .nav-tabs {
        border-bottom: 2px solid #dee2e6;

    }

    .tab-parameter .nav-tabs li {
        list-style: none;
    }

    .tab-parameter .nav-tabs li a {
        color: #333;

        margin-bottom: -2px;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        border-bottom: 2px solid transparent;
        padding-left: 0px;
        padding-right: 0px;
        font-weight: 500;
        margin-right: 20px;
    }

    .tab-parameter .nav-tabs li a:hover {
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: none;
    }

    .tab-parameter .nav-tabs li a.active {
        background-color: transparent;
        color: #009ef7;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom: 2px solid #009ef7;
    }

    .table-chemical td {
        padding: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;

    }

    .table-chemical .actual_td {
        width: 15%;
    }

    .table-chemical th {
        text-align: center;
    }

    .table-chemical td:first-child {
        text-align: left;
        padding-left: 8px;
        width: 95px !important;
    }

    .table-chemical .form-control {
        margin: 0px !important;
        padding: 0.5rem 0.5rem !important;
    }

    table.table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-chemical .header-tr {
        background-color: #009ef7;
    }

    .table-chemical .header-tr td {
        /* text-align: center !important; */
        color: #fff;

    }

    .table-chemical thead tr {
        border: 1px solid #d1d2d4;
        vertical-align: middle;
    }

    .std-td {
        width: 15%;

    }

    .add-item i {
        font-size: 10px;
        background-color: #346cb0;
        padding: 5px;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
    }

    .remove-item i {
        font-size: 10px;
        background-color: #009ef7;
        padding: 5px;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        margin-left: 20px;
    }

    .custom-padding {
        padding: 20px !important;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <!-- Includes Top bar and Responsive Menu -->
                <!-- Breadcrumbs + Actions -->
                <div class="row breadcrumbs">
                    <div class="col-lg-6">
                        <p><a href="/">Home</a> » <a href="/supplier-mtc.php">Supplier MTC</a> »
                            <?php echo $_SESSION['Page_Title']; ?></p>
                        <!-- MIGAS DE PAN -->
                    </div>
                </div>
                <!-- End Breadcrumbs + Actions -->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-custom" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card mt-4 p-6">
                            <!--end::Add design standard form-->
                            <div class="row mb-4">
                                <!--begin::Card body-->
                                <div class="card-body pt-0 table-responsive">
                                    <!--begin::Table-->
                                    <form class="form" action="includes/basicsettings_product_type_add.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>PO Number*</label>
                                                    <input type="text" class="form-control" value="<?php echo $resultData['po_number'] ?>" name="po_number" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Supplier Name*</label>
                                                    <input type="text" class="form-control" value="<?php echo $resultData['Supplier_Name'] ?>" name="supplier_id" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>PO Date*</label>
                                                    <input type="date" class="form-control" value="<?php echo $resultData['po_date'] ?>" name="po_date" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>PO Revision*</label>
                                                    <input type="text" class="form-control" value="<?php echo $resultData['po_revision'] ?>" name="po_revision" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>MTC Number*</label>
                                                    <input type="text" class="form-control" name="material_certificate_number" value="<?php echo $resultData['material_certificate_number'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group ver-disabled">
                                                    <label>MTC Revision*</label>
                                                    <input type="text" class="form-control" name="mtc_revision" value="<?php echo $resultData['mtc_revision'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>MTC Date*</label>
                                                    <input type="date" class="form-control" name="mtc_date" value="<?php echo $resultData['mtc_date'] ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Item Code*</label>
                                                    <input type="text" class="form-control" name="item_code" value="<?php echo $resultData['item_code'] ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Size*</label>
                                                    <input type="text" class="form-control" name="size_id" value="<?php echo $resultData['size'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Class*</label>
                                                    <input type="text" class="form-control" name="class" value="<?php echo $resultData['class'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Material Specification*</label>
                                                    <input type="text" class="form-control" name="material_specification" value="<?php echo $resultData['material_specification'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Edition*</label>
                                                    <input type="text" class="form-control" name="edition" value="<?php echo $resultData['nom_comp'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Drawing Number*</label>
                                                    <input type="text" class="form-control" name="drawing_number" value="<?php echo $resultData['drawing_number'] ?>" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Component Name*</label>
                                                    <input type="text" class="form-control" name="component" value="<?php echo $resultData['component'] ?>" disabled>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Material Certification Type*</label>
                                                    <input type="text" class="form-control" name="material_certification_type" value="<?php echo $resultData['material_certification_type'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Heat Number*</label>
                                                    <input type="text" class="form-control" name="heat_number" value="<?php echo $resultData['heat_number'] ?> " disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Qty*</label>
                                                    <input type="text" class="form-control" name="qty" value="<?php echo $resultData['qty'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Certificate Type*</label>
                                                    <input type="text" class="form-control" name="certificate_type_id" value="<?php echo $resultData['certificate_type_name'] ?>" disabled>
                                                </div>
                                            </div>

                                        </div>

                                        <?php if ($file != null &&  $file['file_path'] && $resultData['certificate_type_id'] == 1) { ?>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group view-pdf">
                                                        <a class="icon-view" href="<?php echo $file['file_path'] ?>" target="_blank"><i class="fa fa-eye" style="color:#009ef7"></i></a>
                                                        <input type="text" class="form-control" value="<?php echo basename($file['file_path'], ".php") . PHP_EOL  ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($resultData['certificate_type_id'] == 2) {
                                        ?>
                                            <div class="row mt-4" id="transcripted-content">
                                                <div class="col-md-12">
                                                    <div class="mt-4 tab-parameter">
                                                        <ul class="nav nav-tabs" id="transcripted-tabs" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="chemical-tab" data-bs-toggle="tab" data-bs-target="#chemical" type="button" role="tab" aria-controls="home" aria-selected="true">Chemical</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="mechanical-tab" data-bs-toggle="tab" data-bs-target="#mechanical" type="button" role="tab" aria-controls="mechanical" aria-selected="false">Mechanical</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="heat-treatment-tab" data-bs-toggle="tab" data-bs-target="#heat-treatment" type="button" role="tab" aria-controls="heat-tratment" aria-selected="false">Heat
                                                                    Treatment</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="special-test-tab" data-bs-toggle="tab" data-bs-target="#special-test" type="button" role="tab" aria-controls="contact" aria-selected="false">Special
                                                                    Test</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content mt-4" id="material-specification-tabs">
                                                            <div class="tab-pane fade show active" id="chemical" role="tabpanel" aria-labelledby="chemical-tab">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <table class="table table-bordered table-chemical">
                                                                            <thead>
                                                                                <tr>
                                                                                <tr>
                                                                                    <th scope="col" rowspan="4">PARAMETER
                                                                                    </th>
                                                                                    <th scope="col" rowspan="2">ACTUAL
                                                                                    </th>
                                                                                    <th scope="colgroup" colspan="2">
                                                                                        STANDARD</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="col">MIN</th>
                                                                                    <th scope="col">MAX</th>
                                                                                </tr>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php if ($chemicalInfo != null) {
                                                                                    foreach ($chemicalInfo as $key => $chemical) {
                                                                                        foreach ($chemicalResult as $row => $item) {
                                                                                            $min = ($chemicalInfo[$key]['min_value'] != null) ? $chemicalInfo[$key]['min_value'] : '-';
                                                                                            $max = ($chemicalInfo[$key]['max_value'] != null) ? $chemicalInfo[$key]['max_value'] : '-';
                                                                                            if ($item['chemical_id'] == $chemicalInfo[$key]['chemical_id']) {
                                                                                ?>
                                                                                                <tr scope="row">
                                                                                                    <td scope="col">
                                                                                                        <?php echo $chemicalInfo[$key]['parameter'] ?>
                                                                                                    </td>
                                                                                                    <td class="actual_td" scope="col">
                                                                                                        <div>
                                                                                                            <input type="hidden" class="form-control" id="chemical_id_<?php echo $key ?>" name="chemical_id[]" value="<?php echo $chemicalInfo[$key]['id'] ?>" disabled>
                                                                                                            <input type="number" class="form-control" id="actual_chemical_<?php echo $key ?>" name="actual_chemical[]" value="<?php echo $item['actual'] ?>" disabled>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td class="std-td" scope="col">
                                                                                                        <?php echo $min ?></td>
                                                                                                    <td class="std-td" scope="col">
                                                                                                        <?php echo $max ?></td>
                                                                                                </tr>
                                                                                    <?php }
                                                                                        }
                                                                                    }
                                                                                } else { ?>
                                                                                    <tr scope="row">
                                                                                        <td scope="col">
                                                                                            <center>
                                                                                                <div class="text-danger">
                                                                                                    Material specification does
                                                                                                    not have chemical value
                                                                                                </div>
                                                                                            </center>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="mechanical" role="tabpanel" aria-labelledby="mechanical-tab">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <table class="table table-bordered table-chemical">
                                                                            <thead>
                                                                                <tr>
                                                                                <tr>
                                                                                    <th scope="col" rowspan="2" colspan="4">
                                                                                        PARAMETER</th>
                                                                                    <th scope="col" rowspan="2">ACTUAL</th>
                                                                                    <th scope="colgroup" colspan="2">
                                                                                        STANDARD</th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th scope="col">MIN</th>
                                                                                    <th scope="col">MAX</th>
                                                                                </tr>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr class="header-tr">
                                                                                    <td colspan="7">
                                                                                        <label>TENSILE TEST</label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="4">Tensile
                                                                                        Strength (UTS)(Mpa)</td>
                                                                                    <td class="actual_td" scope="col">
                                                                                        <div><input type="number" class="form-control" name="tensile_strength_actual" value="<?php echo $tensileResult['actual_tensile_strength'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $tensile['tensile_strength_min'] ?>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $tensile['tensile_strength_max'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="4">Yield
                                                                                        Strength (YS)(Mpa)</td>
                                                                                    <td class="actual_td" scope="col">
                                                                                        <div><input type="number" class="form-control" name="yield_strength_actual" value="<?php echo $tensileResult['actual_yield_strength'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $tensile['yield_strength_min'] ?>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php
                                                                                        echo $tensile['yield_strength_max'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="4">Elongation
                                                                                        (E)(%)</td>
                                                                                    <td class="actual_td" scope="col">
                                                                                        <div><input type="number" class="form-control" name="elongation_actual" value="<?php echo $tensileResult['actual_elongation'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $tensile['elongation_min'] ?>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $tensile['elongation_min'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="4">Reduction
                                                                                        Area (RA)(%)</td>
                                                                                    <td class="actual_td" scope="col">
                                                                                        <div><input type="number" class="form-control" name="reduction_area_actual" value="<?php echo $tensileResult['actual_reduction_area'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php
                                                                                        echo $tensile['reduction_area_min'] ?>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php
                                                                                        echo $tensile['reduction_area_max'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="header-tr">
                                                                                    <td colspan="7">
                                                                                        <label>HARDNESS TEST SETS</label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" style="width:30%" colspan="4">Hardness M.U.</td>
                                                                                    <td colspan="3" scope="col">
                                                                                        <?php
                                                                                        echo $hardness['hardness_mu'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td colspan="1" scope="col">Limit</td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" placeholder="1st test result" value="<?php echo $hardnessResult['result1'] ?>" disabled>
                                                                                    </td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" value="<?php echo $hardnessResult['result2'] ?>" placeholder="2nd test result" disabled>
                                                                                    </td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" value="<?php echo $hardnessResult['result3'] ?>" placeholder="3rd test result" disabled>
                                                                                    </td>
                                                                                    <td class="actual_td" scope="col">
                                                                                        <div>
                                                                                            <input type="number" class="form-control" name="hardness_test_limit_actual" value="<?php echo $hardnessResult['average'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $hardness['hardness_test_limit_min']
                                                                                        ?></td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php
                                                                                        echo $hardness['hardness_test_limit_max']
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="header-tr">
                                                                                    <td colspan="7">
                                                                                        <label>IMPACT TEST SETS</label>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="4">Temperature
                                                                                    </td>
                                                                                    <td colspan="3" scope="col">
                                                                                        <?php
                                                                                        echo $impact['impact_test_temperature'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr scope="row">
                                                                                    <td scope="col" colspan="1">Limit</td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" placeholder="1st test result" value="<?php echo $impactResult['result1'] ?>" disabled>
                                                                                    </td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" placeholder="2nd test result" value="<?php echo $impactResult['result2'] ?>" disabled>
                                                                                    </td>
                                                                                    <td scope="col" colspan="1"><input type="number" class="form-control" placeholder="3rd test result" value="<?php echo $impactResult['result3'] ?>" disabled>
                                                                                    </td>
                                                                                    <td class="actual_td" colspan="1" scope="col">
                                                                                        <div class="form-group">
                                                                                            <input type="number" class="form-control" value="<?php echo $impactResult['average'] ?>" disabled>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php
                                                                                        echo $impact['impact_test_limit_min'] ?>
                                                                                    </td>
                                                                                    <td class="std-td" scope="col">
                                                                                        <?php echo $impact['impact_test_limit_max'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="heat-treatment" role="tabpanel" aria-labelledby="heat-treatment-tab">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label>Heat Treatment</label>
                                                                            <input type="text" class="form-control" disabled value="<?php echo $heat['heat_treatment'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label>Notes*</label>
                                                                            <input type="text" class="form-control" name="heat_treatment_notes" value="<?php echo $heatResult['heat_notes'] ? $heatResult['heat_notes'] : "-"; ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane fade" id="special-test" role="tabpanel" aria-labelledby="special-test-tab">
                                                                <?php
                                                                if (count($specialResult) > 0) {
                                                                    foreach ($specialResult as $key => $item) {
                                                                ?>
                                                                        <div class="row special-test-elem special-test-newelem">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>Type of Test</label>
                                                                                    <input type="text" class="form-control" value="<?php echo $item['type_of_test'] ?>" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label>Result</label>
                                                                                    <input type="text" class="form-control" value="<?php echo $item['result'] ?>" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    <?php }
                                                                } else { ?>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <left>
                                                                                <div class="text-danger">
                                                                                    Material specification does
                                                                                    not have special test
                                                                                </div>
                                                                            </left>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="row mt-6">
                                            <div class="col-md-12">
                                                <div class="form-group form-group-button" style="float:right">
                                                    <a type="button" href="/supplier-mtc.php" class="btn btn-secondary ms-2">Close</a>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <!--start:: PAGINATION-->
                                <ul class="pagination pagination-circle pagination-outline">
                                </ul>
                                <!--end:: PAGINATION-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!-- Finalizar contenido -->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <?php include('includes/footer.php'); ?>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>

    <!--end::Root-->
    <!--end::Main-->
    <?php include('includes/scrolltop.php'); ?>
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Page Custom Javascript-->
    <script>

    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>