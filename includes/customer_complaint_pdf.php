<?php

session_start();
include('functions.php');
$sql = "SELECT * FROM customer_complaints WHERE is_deleted = 0 AND id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sql);
$complaintData = mysqli_fetch_assoc($connectData);

$emailSql = "SELECT Email FROM Basic_Customer WHERE Id_customer = '$complaintData[customer_id]'";
$emailConnect = mysqli_query($con, $emailSql);
$emailInfo = mysqli_fetch_assoc($emailConnect);
$email = $emailInfo['Email'];

$team_membersqlData = "SELECT member_id, First_Name, Last_Name FROM customer_complaint_d1_d2_team LEFT JOIN Basic_Employee ON customer_complaint_d1_d2_team.member_id = Basic_Employee.Id_employee WHERE customer_complaint_id = '$complaintData[id]' AND customer_complaint_d1_d2_team.is_deleted = 0";
$team_membersData = mysqli_query($con, $team_membersqlData);
$team_members =  array();
while ($row = mysqli_fetch_assoc($team_membersData)) {
    array_push($team_members, $row['member_id']);
}
$preliminarySql = "SELECT * FROM preliminary_analysis_d3 WHERE is_deleted = 0 AND customer_complaint_id = '$_REQUEST[id]'";
$preliminaryData = mysqli_query($con, $preliminarySql);
$preliminary = mysqli_fetch_assoc($preliminaryData);

$corrections =  array();
if ($preliminary != null) {
    $correctionSqlData = "SELECT * FROM customer_complaint_correction_d3 WHERE preliminary_analysis_d3_id = '$preliminary[id]'";
    $correctionData = mysqli_query($con, $correctionSqlData);
    while ($row = mysqli_fetch_assoc($correctionData)) {
        array_push($corrections, $row);
    }
}

$cASql = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$cAConnectData = mysqli_query($con, $cASql);
$cAnalysisData =  array();
while ($row = mysqli_fetch_assoc($cAConnectData)) {
    array_push($cAnalysisData, $row);
}


$correctiveActionSqlData = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$correctiveActionSqlConnectData = mysqli_query($con, $correctiveActionSqlData);
$correctiveAction =  array();
while ($row = mysqli_fetch_assoc($correctiveActionSqlConnectData)) {
    array_push($correctiveAction, $row);
}
if ($correctiveAction && count($correctiveAction) > 0) {
    $sql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0 AND status = 'Completed'";
    $connectData = mysqli_query($con, $sql);
}
if ($correctiveAction && count($correctiveAction) > 0) {
    $sql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0 AND verified = '1'";
    $connectData = mysqli_query($con, $sql);
}
$whySqlData = "SELECT * FROM customer_complaint_d4_why_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND is_deleted = 0";
$whySqlConnectData = mysqli_query($con, $whySqlData);
$whyData =  array();
while ($row = mysqli_fetch_assoc($whySqlConnectData)) {
    array_push($whyData, $row);
}
$header = "Customer Complaint - " . $complaintData["complaint_id"];
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
#element-to-print,
#element-to-print-1 {
    padding: 0 !important;
    font-family: Poppins, Helvetica, sans-serif;
    height: 1080px;
}

#element-to-print *,
#element-to-print-1 * {
    font-family: Poppins, Helvetica, sans-serif !important;
}

#element-to-print .bordered-table-body td,
#element-to-print-1 .bordered-table-body td {
    padding-bottom: 3px;
    padding-top: 3px;
    font-size: 10px;
    color: black !important;
    font-weight: 200;
}

#element-to-print .bordered-table-body tr,
#element-to-print-1 .bordered-table-body tr {
    border: 1px solid rgba(0, 0, 0, 0.125) !important;
    border-bottom: none !important;
}

#element-to-print .bordered-table-body tr:last-child,
#element-to-print-1 .bordered-table-body tr:last-child {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
}

#element-to-print p,
#element-to-print-1 p {
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
tr th,
#element-to-print-1 .table-bordered tr td,
tr th {
    border: none;
    text-align: left;
    font-size: 10px;
}

#element-to-print .m-0,
#element-to-print-1 .m-0 {
    margin: 0;
}

#element-to-print .fw-bold,
#element-to-print-1 .fw-bold {
    font-size: 11px;
    font-weight: 700;
    color: black !important;
}

#element-to-print .footer,
#element-to-print-1 .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}

#element-to-print .footer p,
#element-to-print-1 .footer p {
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
                        <?php echo isset($complaintData['created_at']) ? date("d/m/y", strtotime($complaintData['created_at'])) : '-'; ?></span>
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
                            <td class="fw-bold ps-2">Customer Name</td>
                            <td class="fw-bold ">Order Ref Number</td>
                            <td class="fw-bold ">Internal Order Ref</td>
                            <td class="fw-bold">Item No</td>
                            <td class="fw-bold">Product Details</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Customer";
                                $connect_data = mysqli_query($con, $sql_data);
                                $customerName = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($complaintData['customer_id'] == $result_data['Id_customer']) {
                                            $customerName = $result_data['Customer_Name'];
                                        }
                                    }
                                }
                                echo $customerName;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['customer_order_ref']) ? $complaintData['customer_order_ref']  : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['internal_order_ref']) ?  $complaintData['internal_order_ref']   : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['item_no']) ?   $complaintData['item_no'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['product_details']) ?   $complaintData['product_details'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Nature of Complaint</td>
                            <td class="fw-bold ">Complaint Received On</td>
                            <td class="fw-bold ">Email</td>
                            <td class="fw-bold">Phone</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2">
                                <?php
                                $sql_data = "SELECT * FROM Customer_Nature_of_Complaints";
                                $connect_data = mysqli_query($con, $sql_data);
                                $noc = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($complaintData['nature_of_complaint_id'] == $result_data['Id_customer_nature_of_complaints']) {
                                        $noc = $result_data['Title'];
                                    }
                                }
                                echo $noc;
                                ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['complaint_date']) ? date("d-m-y", strtotime($complaintData['complaint_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($email) ? $email : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($complaintData['phone']) ?  $complaintData['phone'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="5">Complaint Details</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($complaintData['complaint_details']) ? $complaintData['complaint_details'] : '-'; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!--Evidence Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Files</p>
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
                                    $sql_data = "SELECT * FROM customer_complaint_files WHERE customer_complaint_id = '$complaintData[id]' AND is_deleted = 0";
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
        <!-- D1-D2 Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D1-D2</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Details of Solution</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($complaintData['details_of_solution']) ? $complaintData['details_of_solution'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Team Members</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <ul class="mt-4">
                                    <?php
                                    $sql_data = "SELECT * FROM Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if (in_array($result_data['Id_employee'], $team_members)) {
                                                echo ' <li class="mt-2">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<span>' . $result_data['First_Name'] . " " . $result_data['Last_Name'] . '</span>
												</div>
											</div>
										</li>';
                                            }
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

        <!--D3 Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D3 (Preliminary Analysis)</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 100%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Indicative Cause of Non Conformance</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($preliminary['indicative_cause_of_non_conformance']) ? $preliminary['indicative_cause_of_non_conformance']  : '-'; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D3 (Correction)</p>
            </div>
            <div class="col-12 p-1">
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
                            <td class="fw-bold ps-2">Correction</td>
                            <td class="fw-bold ">Who</td>
                            <td class="fw-bold ">When</td>
                            <td class="fw-bold ">How</td>
                            <td class="fw-bold ">Status</td>
                        </tr>
                        <?php if ($corrections && count($corrections) > 0) {
                            foreach ($corrections as $key => $correction) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($correction['correction']) ? $correction['correction'] : '-'; ?></td>

                            <td class="">
                                <?php
                                        $sql_data = "SELECT * FROM Basic_Employee WHERE status = 'Active'";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        $who = "-";
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active' && $correction['who'] == $result_data['Id_employee']) {
                                                $who = $result_data['First_Name'] . ' ' . $result_data['Last_Name'];
                                            }
                                        }
                                        echo $who;
                                        ?>
                            </td>
                            <td class="">
                                <?php echo isset($correction['when_date']) ? date("d-m-y", strtotime($correction['when_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($correction['how']) ? $correction['how'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($correction['status']) ? $correction['status'] : '-'; ?>
                            </td>
                        </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- D4 Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D4 (Cause Analysis Table (4M Analysis))</p>
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
                            <td class="fw-bold ps-2">Category</td>
                            <td class="fw-bold ">Cause</td>
                            <td class="fw-bold ">Significant</td>
                        </tr>
                        <?php if ($cAnalysisData && count($cAnalysisData) > 0) {
                            foreach ($cAnalysisData as $key => $item) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($item['category']) ? $item['category'] : '-'; ?>
                            </td>

                            <td class="">
                                <?php echo isset($item['cause']) ? $item['cause'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['significant']) ? $item['significant'] : '-'; ?>
                            </td>
                        </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D4 (5 Why Analysis)</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Significant Cause</td>
                            <td class="fw-bold ">1st Why</td>
                            <td class="fw-bold ">2nd Why</td>
                            <td class="fw-bold ">3rd Why</td>
                            <td class="fw-bold ">4th Why</td>
                            <td class="fw-bold ">5th Why</td>
                            <td class="fw-bold ">Root Cause</td>
                        </tr>
                        <?php if ($whyData && count($whyData) > 0) {
                            foreach ($whyData as $key => $item) {
                                $SqlData = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND id = '$item[customer_complaint_d4_cause_analysis_id]' AND significant = '1' AND is_deleted = 0";
                                $result = mysqli_query($con, $SqlData);
                                if ($result->num_rows != 0) {
                        ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                            $sql_data = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE customer_complaint_id = '$_REQUEST[id]'";
                                            $connect_data = mysqli_query($con, $sql_data);
                                            $cause = "-";
                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                if ($result_data['id'] == $item['customer_complaint_d4_cause_analysis_id']) {
                                                    $cause =  $result_data['cause'];
                                                }
                                            }
                                            echo $cause;
                                            ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['why_1']) ? $item['why_1'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['why_2']) ? $item['why_2'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['why_3']) ? $item['why_3'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['why_4']) ? $item['why_4'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['why_5']) ?  $item['why_5'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['root_cause']) ? $item['root_cause'] : '-'; ?>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D4 (Corrective Action Plan)</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Root Cause</td>
                            <td class="fw-bold ">Corrective Action</td>
                            <td class="fw-bold ">Who</td>
                            <td class="fw-bold ">When</td>
                            <td class="fw-bold ">How</td>
                            <td class="fw-bold ">Status</td>
                        </tr>
                        <?php if ($correctiveAction && count($correctiveAction) > 0) {
                            foreach ($correctiveAction as $key => $item) {
                                $SqlData = "SELECT * FROM customer_complaint_d4_why_analysis WHERE customer_complaint_id = '$_REQUEST[id]' AND id = '$item[customer_complaint_d4_why_analysis_id]' AND is_deleted = 0";
                                $result = mysqli_query($con, $SqlData);
                                if ($result->num_rows != 0) {
                        ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                            $sql = "SELECT * From customer_complaint_d4_why_analysis Where id = '$item[customer_complaint_d4_why_analysis_id]'";
                                            $fetchRootCause = mysqli_query($con, $sql);
                                            $causeInfo = mysqli_fetch_assoc($fetchRootCause);
                                            switch ($causeInfo['root_cause']) {
                                                case "1st Why":
                                                    echo $causeInfo['why_1'];
                                                    break;
                                                case "2nd Why":
                                                    echo $causeInfo['why_2'];
                                                    break;
                                                case "3rd Why":
                                                    echo $causeInfo['why_3'];
                                                    break;
                                                case "4th Why":
                                                    echo $causeInfo['why_4'];
                                                    break;
                                                case "5th Why":
                                                    echo $causeInfo['why_5'];
                                                    break;
                                                default:
                                                    echo "";
                                            }
                                            ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['corrective_action']) ? $item['corrective_action'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                            $who = "-";
                                            if (isset($item['who'])) {
                                                $sql = "SELECT * FROM Basic_Employee Where Id_employee = $item[who]";
                                                $fetch = mysqli_query($con, $sql);
                                                $data = mysqli_fetch_assoc($fetch);
                                                $who = $data['First_Name'] . ' ' . $data['Last_Name'];
                                            }
                                            echo $who;
                                            ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['when_date']) ? date("d-m-y", strtotime($item['when_date'])) : "" ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['how']) ? $item['how'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['status']) ?  $item['status'] : '-'; ?>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">D6-D7 (Verification)</p>
            </div>
            <div class="col-12 p-1">
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
                            <td class="fw-bold ps-2">Root Cause</td>
                            <td class="fw-bold ">Corrective Action</td>
                            <td class="fw-bold ">Who</td>
                            <td class="fw-bold ">When</td>
                            <td class="fw-bold ">Verified</td>
                        </tr>
                        <?php if ($correctiveAction && count($correctiveAction) > 0) {
                            foreach ($correctiveAction as $key => $item) {
                        ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                        $sql = "SELECT * From customer_complaint_d4_why_analysis Where id = '$item[customer_complaint_d4_why_analysis_id]'";
                                        $fetchRootCause = mysqli_query($con, $sql);
                                        $causeInfo = mysqli_fetch_assoc($fetchRootCause);
                                        switch ($causeInfo['root_cause']) {
                                            case "1st Why":
                                                echo $causeInfo['why_1'];
                                                break;
                                            case "2nd Why":
                                                echo $causeInfo['why_2'];
                                                break;
                                            case "3rd Why":
                                                echo $causeInfo['why_3'];
                                                break;
                                            case "4th Why":
                                                echo $causeInfo['why_4'];
                                                break;
                                            case "5th Why":
                                                echo $causeInfo['why_5'];
                                                break;
                                            default:
                                                echo "-";
                                        }
                                        ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['corrective_action']) ? $item['corrective_action'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                        $who = "-";
                                        if (isset($item['who'])) {
                                            $sql = "SELECT * FROM Basic_Employee Where Id_employee = $item[who]";
                                            $fetch = mysqli_query($con, $sql);
                                            $data = mysqli_fetch_assoc($fetch);
                                            $who = $data['First_Name'] . ' ' . $data['Last_Name'];
                                        }
                                        echo $who;
                                        ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['when_date']) ? date("d-m-y", strtotime($item['when_date'])) : "" ?>
                            </td>
                            <td class="">
                                <?php echo (isset($item['verified']) && $item['verified'] == 1) ? "Yes" : 'NO'; ?>
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
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