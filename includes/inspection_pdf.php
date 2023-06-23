<?php

session_start();
include('functions.php');

$sqlData = "SELECT * FROM inspection WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$inspection = mysqli_fetch_assoc($connectData);

$sqlData = "SELECT * FROM inspection_product_details WHERE is_deleted = 0 AND inspection_id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$productDetails =  array();
while ($row = mysqli_fetch_assoc($connectData)) {
    array_push($productDetails, $row);
}

$sqlData = "SELECT * FROM inspection_agency WHERE is_deleted = 0 AND inspection_id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$agencies =  array();
while ($row = mysqli_fetch_assoc($connectData)) {
    array_push($agencies, $row);
}

$locationSql = "SELECT * FROM tbl_Countries";
$locationConnect = mysqli_query($con, $locationSql);
$locations = mysqli_fetch_all($locationConnect, MYSQLI_ASSOC);

$header = "Inspection - Unique Id : " . $inspection['unique_id'];
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
                        <?php echo isset($inspection['created_at']) ? date("d/m/y", strtotime($inspection['created_at'])) : '-'; ?></span>
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
                            <td class="fw-bold ps-2">From</td>
                            <td class="fw-bold ">To</td>
                            <td class="fw-bold ">Customer</td>
                            <td class="fw-bold">Customer PO</td>
                            <td class="fw-bold">Order Ref</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($inspection['from_date']) ? date("d-m-y", strtotime($inspection['from_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['to_date']) ? date("d-m-y", strtotime($inspection['to_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Customer";
                                $connect_data = mysqli_query($con, $sql_data);
                                $customer = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($inspection['customer'] == $result_data['Id_customer']) {
                                            $customer =  $result_data['Customer_Name'];
                                        }
                                    }
                                }
                                echo $customer;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['customer_po']) ? $inspection['customer_po'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['order_ref']) ?  $inspection['order_ref'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Notification No</td>
                            <td class="fw-bold " colspan="2">Manufacturer</td>
                            <td class="fw-bold ">Stage of Inspection</td>
                            <td class="fw-bold">Location</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($inspection['notification_no']) ? $inspection['notification_no'] : '-'; ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($inspection['manufacturer']) ? $inspection['manufacturer'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['stage_of_inspection']) ? $inspection['stage_of_inspection'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $locationVal = "-";
                                foreach ($locations as $location) {
                                    if ($inspection['location'] == $location['CountryID']) {
                                        $locationVal =  $location['CountryName'];
                                    }
                                }
                                echo $locationVal;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Project Name (Optional)</td>
                            <td class="fw-bold " colspan="3">Equipment Description</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($inspection['project_name']) ? $inspection['project_name'] : '-'; ?>
                            </td>
                            <td class="" colspan="3">
                                <?php echo isset($inspection['equipment_description']) ? $inspection['equipment_description'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">ITP Number</td>
                            <td class="fw-bold " colspan="2">Revision</td>
                            <td class="fw-bold ">ITP Activity</td>

                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($inspection['itp_number']) ? $inspection['itp_number'] : '-'; ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($inspection['revision']) ? $inspection['revision'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['itp_activity']) ? $inspection['itp_activity'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold  ps-2" colspan="2">Contact Person</td>
                            <td class="fw-bold " colspan="2">Email</td>
                            <td class="fw-bold ">Place of Inspection</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($inspection['contact_person']) ? $inspection['contact_person'] : '-'; ?>
                            </td>
                            <td class="" colspan="2">
                                <?php echo isset($inspection['email']) ? $inspection['email'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($inspection['location_of_inspection']) ? $inspection['location_of_inspection'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Discussion Notes Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Product Details</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 5%">
                        <col span="1" style="width: 12%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 5%">
                        <col span="1" style="width: 5%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 5%">
                        <col span="1" style="width: 8%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Item No</td>
                            <td class="fw-bold ">Tag No</td>
                            <td class="fw-bold ">HR No</td>
                            <td class="fw-bold ">Type</td>
                            <td class="fw-bold ">Size</td>
                            <td class="fw-bold ">Bore</td>
                            <td class="fw-bold ">Class</td>
                            <td class="fw-bold ">Material</td>
                            <td class="fw-bold ">QTY</td>
                            <td class="fw-bold ">Actual QTY</td>
                        </tr>
                        <?php if ($productDetails && count($productDetails) > 0) {
                            foreach ($productDetails as $key => $item) { ?>
                                <tr>
                                    <td class="text-start ps-2">
                                        <?php echo isset($item['item_no']) ?  $item['item_no'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['tag_no']) ?  $item['tag_no'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['hr_no']) ?  $item['hr_no'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['type']) ?  $item['type'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['size']) ?  $item['size'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['bore']) ?  $item['bore'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['class']) ?  $item['class'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['material']) ?  $item['material'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['qty']) ?  $item['qty'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['actual_qty']) ?  $item['actual_qty'] : '-'; ?>
                                    </td>
                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Inspection Agency / Inspector Details Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Inspection Agency / Inspector Details</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">On Behalf Of</td>
                            <td class="fw-bold ">Inspection Agency</td>
                            <td class="fw-bold ">Inspector Name</td>
                            <td class="fw-bold ">Email</td>
                        </tr>
                        <?php if ($agencies && count($agencies) > 0) {
                            foreach ($agencies as $key => $item) { ?>
                                <tr>
                                    <td class="text-start ps-2">
                                        <?php echo isset($item['on_behalf_of']) ?  $item['on_behalf_of'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['inspection_agency']) ?  $item['inspection_agency'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['inspector_name']) ?  $item['inspector_name'] : '-'; ?>
                                    </td>
                                    <td class="">
                                        <?php echo isset($item['email']) ?  $item['email'] : '-'; ?>
                                    </td>
                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-5">
                <p>Format No : </p>
                <p>Electronically generated document, signature not required.</p>
                <p>Page 1 of 1</p>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ac14141ba7.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="JS/jquery-3.6.0.min.js"></script>

</html>