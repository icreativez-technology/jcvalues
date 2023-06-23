<?php

session_start();
include('functions.php');

$getDataQuery = "SELECT * FROM objective WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $getDataQuery);
$resultData = mysqli_fetch_assoc($connectData);

$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[approved_by]";
$fetch = mysqli_query($con, $sql);
$approvedInfo = mysqli_fetch_assoc($fetch);

$sql = "SELECT * From Basic_Employee Where Id_employee = $resultData[created_by]";
$fetch = mysqli_query($con, $sql);
$createdInfo = mysqli_fetch_assoc($fetch);

$listSqlData = "SELECT * FROM objective_list WHERE is_deleted = 0 AND objective_id = '$_REQUEST[id]'";
$listData = mysqli_query($con, $listSqlData);
$lists =  array();
while ($row = mysqli_fetch_assoc($listData)) {
    array_push($lists, $row);
}
$header = "Objective - " . $resultData['year'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Objective</title>
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

#element-to-print .mr {
    margin-right: 10px;
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
                <p class="m-0 fw-bold "><?php echo $header ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($resultData['created_at']) ? date("d/m/y", strtotime($resultData['created_at'])) : '-'; ?></span>
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
                            <td class="fw-bold ps-2">Year</td>
                            <td class="fw-bold ">Revision</td>
                            <td class="fw-bold ">Created By</td>
                            <td class="fw-bold">Date of Register</td>
                            <td class="fw-bold">Approved By</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($resultData['year']) ? $resultData['year'] : '-'; ?></td>
                            <td class=""><?php echo isset($resultData['revision']) ? $resultData['revision'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($createdInfo['First_Name']) ? $createdInfo['First_Name'] . ' ' . $createdInfo['Last_Name'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($resultData['published_at']) ? date("d-m-y", strtotime($resultData['published_at'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($approvedInfo['First_Name']) ? $approvedInfo['First_Name'] . ' ' . $approvedInfo['Last_Name'] : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Strength Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Strategy Details</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="2" style="width: 40%">
                        <col span="2" style="width: 20%">
                        <col span="2" style="width: 20%">
                        <col span="2" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Objective</td>
                            <td class="fw-bold">Responsible</td>
                            <td class="fw-bold">Comply Level</td>
                        </tr>

                        <?php if ($lists && count($lists) > 0) {
                            foreach ($lists as $key => $list) { ?>
                        <tr>
                            <td class="text-start ps-2"><?php echo $list['objective']; ?></td>
                            <td class="">
                                <?php
                                        $sql_data = "SELECT * FROM Basic_Employee";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active') {
                                                if ($result_data['Id_employee'] ==  $list['responsible']) {
                                                    echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                                }
                                            }
                                        }
                                        ?>
                            </td>
                            <td class=""><?php echo  $list['comply_level'] ?></td>
                        </tr>
                        <?php }
                        }
                        ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-5">
                <p>Format No : SP_F2 Rev.1</p>
                <p>Electronically generated document, signature not required.</p>
                <p class="mr">Page 1 of 1</p>
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