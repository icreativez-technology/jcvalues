<?php

session_start();
include('functions.php');

$sqlData = "SELECT * FROM q_alert WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$qAlert = mysqli_fetch_assoc($connectData);
$headReviewSqlData = "SELECT * FROM q_alert_head_review WHERE q_alert_id = '$_REQUEST[id]'";
$headReviewSqlConnectData = mysqli_query($con, $headReviewSqlData);
$headReview = mysqli_fetch_assoc($headReviewSqlConnectData);
$hodDisabled = $headReviewSqlConnectData->num_rows == 0 ? true : false;
$headReview['action_category_id'] = (isset($headReview['action_category_id'])) ? $headReview['action_category_id'] : $qAlert['action_category_id'];
$headReview['detail_of_solution'] = (isset($headReview['detail_of_solution'])) ? $headReview['detail_of_solution'] : $qAlert['detail_of_solution'];
$headReview['owner'] = (isset($headReview['owner'])) ? $headReview['owner'] : 0;

$hodReviewSqlData = "SELECT * FROM q_alert_hod_review WHERE q_alert_id = '$_REQUEST[id]'";
$hodReviewSqlConnectData = mysqli_query($con, $hodReviewSqlData);
$hodReview = mysqli_fetch_assoc($hodReviewSqlConnectData);
$correctiveActionDisabled = $hodReviewSqlConnectData->num_rows == 0 ? true : false;
$hodReview['action_category_id'] = (isset($hodReview['action_category_id'])) ? $hodReview['action_category_id'] : $headReview['action_category_id'];
$hodReview['detail_of_solution'] = (isset($hodReview['detail_of_solution'])) ? $hodReview['detail_of_solution'] : $headReview['detail_of_solution'];
$hodReview['owner'] = (isset($hodReview['owner'])) ? $hodReview['owner'] : 0;

$correctiveActionSqlData = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$_REQUEST[id]' AND is_deleted = 0";
$correctiveActionSqlConnectData = mysqli_query($con, $correctiveActionSqlData);
$correctiveAction =  array();
while ($row = mysqli_fetch_assoc($correctiveActionSqlConnectData)) {
    array_push($correctiveAction, $row);
}
$verificationDisabled = true;
if ($correctiveAction && count($correctiveAction) > 0) {
    $sql = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$_REQUEST[id]' AND is_deleted = 0 AND status = '100%'";
    $connectData = mysqli_query($con, $sql);
    $verificationDisabled = count($correctiveAction) != $connectData->num_rows ? true : false;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Q-Alert</title>
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
                <p class="m-0 fw-bold ">Q-Alert Details - Unique Id : <?php echo $qAlert['q_alert_id']; ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($qAlert['created_at']) ? date("d/m/y", strtotime($qAlert['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 30%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">On Behalf of</td>
                            <td class="fw-bold">Plant</td>
                            <td class="fw-bold">Product Group</td>
                            <td class="fw-bold">Department</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM Basic_Employee WHERE Id_employee = $qAlert[on_behalf_of] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);

                            $firstName = isset($result_data['First_Name']) ? $result_data['First_Name'] : '';
                            $lastName = isset($result_data['Last_Name']) ? $result_data['Last_Name'] : '';
                            $employeeName =  $firstName . ' ' . $lastName;
                            ?>
                            <td class="text-start ps-2"><?php echo $employeeName; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Plant WHERE Id_plant = $qAlert[plant_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['Title']) ? $result_data['Title'] : '-'; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = $qAlert[product_group_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['Title']) ? $result_data['Title'] : '-'; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Department WHERE Id_department = $qAlert[department_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="">
                                <?php echo isset($result_data['Department']) ? $result_data['Department'] : '-'; ?></td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Area/Process</td>
                            <td class="fw-bold">Nature of Observation</td>
                            <td class="fw-bold">Date</td>
                            <td class="fw-bold">Shift</td>
                        </tr>
                        <tr>

                            <?php
                            $sql_data = "SELECT * FROM area_process WHERE id = $qAlert[area_process_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="text-start ps-2">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-'; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM q_alert_nature_of_obs WHERE id = $qAlert[nature_of_obs_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['title']) ? $result_data['title'] : '-'; ?></td>
                            <td class="">
                                <?php echo isset($qAlert['date']) ? date("d-m-y", strtotime($qAlert['date'])) : '-'; ?>
                            </td>
                            <td class=""><?php echo isset($qAlert['shift']) ? $qAlert['shift'] : '-'; ?></td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Action Category</td>
                            <td class="fw-bold" colspan="2">Details of Solution</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM action_category WHERE id = $qAlert[action_category_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-'; ?></td>

                            <td class="" colspan="2">
                                <?php echo isset($qAlert['detail_of_solution']) ? $qAlert['detail_of_solution'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Observation Details</td>
                            <td class="fw-bold" colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php echo isset($qAlert['obs_details']) ? $qAlert['obs_details'] : '-'; ?></td>
                            <td class="" colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Q-Head Review-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Q-Head Review</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Action Category</td>
                            <td class="fw-bold">Details of Solution</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM action_category WHERE id = $headReview[action_category_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="text-start ps-2">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-'; ?></td>
                            <td>
                                <?php echo isset($headReview['detail_of_solution']) ? $headReview['detail_of_solution'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Department</td>
                            <td class="fw-bold">Owner</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM Basic_Department WHERE Id_department = $headReview[department_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="text-start ps-2">
                                <?php echo isset($result_data['Department']) ? $result_data['Department'] : ''; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Employee WHERE Id_employee = $headReview[owner] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);

                            $firstName = isset($result_data['First_Name']) ? $result_data['First_Name'] : '';
                            $lastName = isset($result_data['Last_Name']) ? $result_data['Last_Name'] : '';
                            $employeeName =  $firstName . ' ' . $lastName;
                            ?>
                            <td><?php echo $employeeName; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--HOD Review-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">HOD Review</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Action Category</td>
                            <td class="fw-bold">Details of Solution</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM action_category WHERE id = $hodReview[action_category_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="ps-2">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-'; ?></td>
                            <td class="">
                                <?php echo isset($hodReview['detail_of_solution']) ? $hodReview['detail_of_solution'] : '-'; ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Department</td>
                            <td class="fw-bold">Owner</td>
                        </tr>
                        <tr>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Department WHERE Id_department = $hodReview[department_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="ps-2">
                                <?php echo isset($result_data['Department']) ? $result_data['Department'] : ''; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Employee WHERE Id_employee = $hodReview[owner] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);

                            $firstName = isset($result_data['First_Name']) ? $result_data['First_Name'] : '';
                            $lastName = isset($result_data['Last_Name']) ? $result_data['Last_Name'] : '';
                            $employeeName =  $firstName . ' ' . $lastName;
                            ?>
                            <td><?php echo $employeeName ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Corrective Action-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Corrective Action</p>
            </div>
            <table class="table table-bordered">
                <colgroup>
                    <col span="1" style="width: 20%">
                    <col span="1" style="width: 20%">
                </colgroup>
                <tbody class="text-center bordered-table-body">
                    <tr>
                        <td class="fw-bold ps-2">Root Cause</td>
                        <td class="fw-bold">Corrective Action</td>
                        <td class="fw-bold">Who</td>
                        <td class="fw-bold">When</td>
                        <td class="fw-bold">Status</td>
                    </tr>
                    <?php if ($correctiveAction && count($correctiveAction) > 0) {
                        foreach ($correctiveAction as $key => $item) { ?>
                    <tr>
                        <td class="text-start ps-2"><?php echo $item['root_cause']; ?></td>
                        <td class=""><?php echo $item['corrective_action']; ?></td>
                        <?php
                                $sql_data = "SELECT * FROM Basic_Employee WHERE Id_employee = $item[who]";
                                $connect_data = mysqli_query($con, $sql_data);
                                $who = mysqli_fetch_assoc($connect_data);
                                ?>
                        <td class=""><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></td>
                        <td class=""><?php echo date("d-m-y", strtotime($item['date'])) ?></td>
                        <td class=""><?php echo $item['status']; ?></td>
                    </tr>
                    <?php }
                    }
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--Verification-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Verification</p>
            </div>
            <table class="table table-bordered mt-1">
                <colgroup>
                    <col span="1" style="width: 20%">
                    <col span="1" style="width: 20%">
                </colgroup>
                <tbody class="text-center bordered-table-body">
                    <tr>
                        <td class="fw-bold ps-2">Root Cause</td>
                        <td class="fw-bold">Corrective Action</td>
                        <td class="fw-bold">Who</td>
                        <td class="fw-bold">When</td>
                        <td class="fw-bold">Status</td>
                    </tr>

                    <?php if ($correctiveAction && count($correctiveAction) > 0) {
                        foreach ($correctiveAction as $key => $item) { ?>
                    <tr>
                        <td class="text-start ps-2">
                            <?php echo $item['root_cause']; ?>
                        </td>
                        <td>
                            <?php echo $item['corrective_action']; ?>
                        </td>
                        <?php if (isset($item['who'])) {
                                    $sql = "SELECT * From Basic_Employee Where Id_employee = $item[who]";
                                    $fetch = mysqli_query($con, $sql);
                                    $who = mysqli_fetch_assoc($fetch);
                                ?>
                        <td>
                            <?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?>
                        </td>
                        <?php } else { ?>
                        <td>
                            <?php echo ' '; ?>
                        </td>
                        <?php } ?>
                        <td>
                            <?php echo date("d-m-y", strtotime($item['date'])) ?>
                        </td>
                        <td>
                            <?php echo $item['status']; ?>
                        </td>

                    </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
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