<?php

session_start();
include('functions.php');
$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$plantId = $EmpInfo['Id_plant'];

$tokenSql = "SELECT * From supplier_nc_capa_token Where supplier_nc_capa_ncr_details_id = '$_REQUEST[id]'";
$fetchToken = mysqli_query($con, $tokenSql);
$tokenDisabled = ($fetchToken->num_rows == 0) ? true : false;

$supplierSql = "SELECT * FROM Basic_Supplier";
$supplierConnect = mysqli_query($con, $supplierSql);
$suppliers = mysqli_fetch_all($supplierConnect, MYSQLI_ASSOC);

$sqlNcr = "SELECT * FROM supplier_nc_capa_ncr_details WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connecNcr = mysqli_query($con, $sqlNcr);
$ncrDetailsData = mysqli_fetch_assoc($connecNcr);

$listSqlData = "SELECT * FROM supplier_nc_capa_analysis_ncr_modal WHERE is_deleted = 0 AND supplier_nc_capa_ncr_details_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}

$sqlCorrection = "SELECT * FROM supplier_nc_capa_correction WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectCorrection = mysqli_query($con, $sqlCorrection);
$correctionData = mysqli_fetch_assoc($connectCorrection);

$correctionDisabled = ($connectCorrection->num_rows == 0) ? true : false;

$sqlAnalysis = "SELECT * FROM supplier_nc_capa_analysis_ca WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectAnalysis = mysqli_query($con, $sqlAnalysis);
$analysisData = mysqli_fetch_assoc($connectAnalysis);

$analysisDisabled = ($connectAnalysis->num_rows == 0) ? true : false;

$sqlVerification = "SELECT * FROM supplier_nc_capa_verification WHERE supplier_nc_capa_ncr_details_id = '$_REQUEST[id]' AND is_deleted = 0";
$connectVerification = mysqli_query($con, $sqlVerification);
$verificationData = mysqli_fetch_assoc($connectVerification);

$header = "Supplier NC & CAPA - " . $ncrDetailsData['supplier_nc_capa_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meeting</title>
    <script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
</head>

<style>
#element-to-print {
    padding: 0 !important;
    font-family: Poppins, Helvetica, sans-serif;
    height: 1080px;
}

#element-to-print * {
    font-family: Poppins, Helvetica, sans-serif !important;
}

#element-to-print .bordered-table-body td {
    padding-bottom: 3px;
    padding-top: 3px;
    font-size: 10px;
    color: black !important;
    font-weight: 200;
}

#element-to-print .bordered-table-body tr {
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
    border-bottom: none !important;
}

#element-to-print .bordered-table-body tr:last-child {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
}

#element-to-print p {
    font-size: 10px;
    font-weight: 300;
    color: black !important;
    margin-bottom: 3px;
}

#element-to-print .bg-title {
    background-color: #F1F9FF;
    font-weight: 700;
    color: black !important;
    font-size: 11px;
    padding-bottom: 3px;
}

#element-to-print .table-bordered tr td,
tr th {
    border: none;
    text-align: left;
    font-size: 10px;
}

#element-to-print .m-0 {
    margin: 0;
}

#element-to-print .fw-bold {
    font-size: 11px;
    font-weight: 700;
    color: black !important;
}

#element-to-print .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}

#element-to-print .footer p {
    font-size: 10px !important;
}
</style>

<body>
    <div id="element-to-print">
        <div class="d-flex justify-content-start">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>

        <!--Details-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold"><?php echo $header ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($ncrDetailsData['created_at']) ? date("d/m/y", strtotime($ncrDetailsData['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Supplier Name</td>
                            <td class="fw-bold ">Date</td>
                            <td class="fw-bold ">Delivery Note</td>
                            <td class="fw-bold">PO Number</td>
                            <td class="fw-bold">Line Item</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $name = "-";
                                foreach ($suppliers as $supplier) {
                                    if ($ncrDetailsData['supplier_id'] == $supplier['Id_Supplier']) {
                                        $name  =  $supplier['Supplier_Name'];
                                    }
                                }
                                echo $name;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['date']) ? date("d-m-y", strtotime($ncrDetailsData['date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['delivery_note']) ? $ncrDetailsData['delivery_note']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['po_number']) ? $ncrDetailsData['po_number']   : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['line_item']) ?  $ncrDetailsData['line_item']  : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Part Number</td>
                            <td class="fw-bold " colspan="2">Part Description</td>
                            <td class="fw-bold ">Serial No/HEat No</td>
                            <td class="fw-bold">Material</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plantId'";
                                $connect_data = mysqli_query($con, $sql_data);
                                $dept = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($ncrDetailsData['part_number'] == $result_data['Id_department']) {
                                        $dept = $result_data['Department'];
                                    }
                                }
                                echo $dept;
                                ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($ncrDetailsData['part_description']) ? $ncrDetailsData['part_description']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['serial_no']) ? $ncrDetailsData['serial_no']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $material = "-";
                                if ($ncrDetailsData['material'] == 'Minor') {
                                    $material = "Minor";
                                } else if ($ncrDetailsData['material'] == 'Major') {
                                    $material = "Major";
                                } else if ($ncrDetailsData['material'] == 'Observation') {
                                    $material = "Observation";
                                }
                                echo  $material;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Lot Quantity</td>
                            <td class="fw-bold ">Inspected Quantity</td>
                            <td class="fw-bold ">Accepted Quantity</td>
                            <td class="fw-bold">QTY NC's</td>
                            <td class="fw-bold">Stock Affected</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($ncrDetailsData['lot_quantity']) ? $ncrDetailsData['lot_quantity']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['inspected_quantity']) ?  $ncrDetailsData['inspected_quantity']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['accepted_quantity']) ? $ncrDetailsData['accepted_quantity']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['qty_nc']) ? $ncrDetailsData['qty_nc']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($ncrDetailsData['stock_affected']) ? $ncrDetailsData['stock_affected']  : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">NCR Classification</td>
                            <td class="fw-bold " colspan="2">Classification Details</td>
                            <td class="fw-bold ">Action with NC Material</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php
                                $classification = "-";
                                if ($ncrDetailsData['ncr_classification'] == 'Minor') {
                                    $classification = "Minor";
                                } else if ($ncrDetailsData['ncr_classification'] == 'Major') {
                                    $classification = "Major";
                                }
                                echo  $classification;
                                ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($ncrDetailsData['classification_details']) ? $ncrDetailsData['classification_details']   : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $ncMaterial = "-";
                                if ($ncrDetailsData['action_with_nc_material'] == 'Accept') {
                                    $ncMaterial = "Accept";
                                } else if ($ncrDetailsData['action_with_nc_material'] == 'Reject') {
                                    $ncMaterial = "Reject";
                                } else if ($ncrDetailsData['action_with_nc_material'] == 'Repair') {
                                    $ncMaterial = "Repair";
                                } else if ($ncrDetailsData['action_with_nc_material'] == 'Concession') {
                                    $ncMaterial = "Concession";
                                }
                                echo  $ncMaterial;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="5">Non conformance Description</td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="5">
                                <?php echo isset($ncrDetailsData['Non conformance Description']) ? $ncrDetailsData['Non conformance Description']   : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Evidence Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Evidence</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                    $sql_data = "SELECT * FROM supplier_nc_capa_ncr_details_files WHERE supplier_nc_capa_ncr_details_id = '$ncrDetailsData[id]' AND is_deleted = 0";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    if (mysqli_num_rows($connect_data)) {
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) { ?>
                                    <li class="mt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class=""><?php echo $result_data['file_name']; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Discussion Notes Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">NCR Details</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 40%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 30%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Description Action Adopted By JC</td>
                            <td class="fw-bold ">Responsible</td>
                            <td class="fw-bold ">Target Date</td>
                        </tr>
                        <?php if ($lists && count($lists) > 0) {
                            foreach ($lists as $key => $list) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($list['description_of_action']) ?   $list['description_of_action'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($list['responsible']) ?   $list['responsible'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($list['target_date']) ? date("d-m-y", strtotime($list['target_date'])) : '-'; ?>
                            </td>
                        </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Follow Up Actions Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Correction</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Correction</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($correctionData['correction']) ?  $correctionData['correction'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Analysis & CAPA Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Analysis & CAPA</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 50%">
                        <col span="1" style="width: 50%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Root Cause Analysis</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($analysisData['root_cause_analysis']) ?  $analysisData['root_cause_analysis'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Corrective Action</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($analysisData['corrective_action']) ?  $analysisData['corrective_action'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Preventive Action</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($analysisData['preventive_action']) ?  $analysisData['preventive_action'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Responsible</td>
                            <td class="fw-bold">Date of implentation</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($analysisData['responsible']) ?  $analysisData['responsible'] : '-'; ?>
                            </td>
                            <td>
                                <?php echo isset($analysisData['date_of_implementation']) ?  $analysisData['date_of_implementation'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Verification Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Verification</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 50%">
                        <col span="1" style="width: 50%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Corrective Action</td>
                            <td class="fw-bold ">Preventive Action</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($analysisData['corrective_action']) ?  $analysisData['corrective_action'] : '-'; ?>

                            </td>
                            <td>
                                <?php echo isset($analysisData['preventive_action']) ?  $analysisData['preventive_action'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Verified and Closed By</td>
                            <td class="fw-bold">Date</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Employee";
                                $connect_data = mysqli_query($con, $sql_data);
                                $verified_by = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($verificationData['closed_by'] == $result_data['Id_employee']) {
                                            $verified_by = $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                        }
                                    }
                                }
                                echo $verified_by;
                                ?>
                            </td>
                            <td>
                                <?php echo isset($verificationData['date']) ? date("d-m-y", strtotime($verificationData['date'])) : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-5">
                <p></p>
                <p>Page 1 of 1</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="JS/jquery-3.6.0.min.js"></script>

</html>