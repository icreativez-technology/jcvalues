<?php

session_start();
include('functions.php');

$moc_sql_data = "SELECT quality_moc.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Plant.Title as plant, Basic_Product_Group.Title as product_group, Basic_Department.Department, Quality_MoC_Type.Title as moc_type FROM quality_moc
LEFT JOIN Basic_Employee ON quality_moc.on_behalf_of = Basic_Employee.Id_employee
LEFT JOIN Basic_Plant ON quality_moc.plant_id = Basic_Plant.Id_plant
LEFT JOIN Basic_Product_Group ON quality_moc.product_group_id = Basic_Product_Group.Id_product_group
LEFT JOIN Basic_Department ON quality_moc.department_id = Basic_Department.Id_department
LEFT JOIN Quality_MoC_Type ON quality_moc.moc_type_id = Quality_MoC_Type.Id_quality_moc_type
WHERE quality_moc.is_deleted = 0 AND id = '$_REQUEST[id]'";
$moc_conect_data = mysqli_query($con, $moc_sql_data);
$moc = mysqli_fetch_assoc($moc_conect_data);

$teamSqlData = "SELECT member_id, First_Name, Last_Name FROM quality_moc_team_members LEFT JOIN Basic_Employee ON quality_moc_team_members.member_id = Basic_Employee.Id_employee WHERE quality_moc_id = '$_REQUEST[id]'  AND is_deleted = 0";
$teamData = mysqli_query($con, $teamSqlData);
$teamMembers =  array();
while ($row = mysqli_fetch_assoc($teamData)) {
    array_push($teamMembers, $row['member_id']);
}

$actionPlanSqlData = "SELECT * FROM quality_moc_action_plan WHERE quality_moc_id = '$_REQUEST[id]' AND is_deleted = 0";
$actionPlanData = mysqli_query($con, $actionPlanSqlData);
$actionPlan =  array();
while ($row = mysqli_fetch_assoc($actionPlanData)) {
    array_push($actionPlan, $row);
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MTC</title>
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
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="80">
            </div>
        </div>

        <!--First section-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Management Of Change Details - Unique Id : <?php echo $moc['moc_id']; ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($moc['created_at']) ? date("d/m/y", strtotime($moc['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">On Behalf of</td>
                            <td class="fw-bold">Plant</td>
                            <td class="fw-bold">Product Group</td>
                            <td class="fw-bold">Department</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($moc['First_Name']) ? $moc['First_Name'] . ' ' . $moc['Last_Name'] : "-" ?>
                            </td>
                            <td><?php echo isset($moc['plant']) ? $moc['plant'] : "-" ?></td>
                            <td><?php echo isset($moc['product_group']) ? $moc['product_group'] : "-" ?> </td>
                            <td><?php echo isset($moc['Department']) ? $moc['Department'] : "-" ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">MoC Type</td>
                            <td class="fw-bold">Old Moc Ref#</td>
                            <td class="fw-bold">Standard/Procedure Reference</td>
                            <td class="fw-bold">Risk Assessment</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($moc['moc_type']) ? $moc['moc_type'] : "-" ?>
                            </td>
                            <td><?php echo isset($moc['old_moc_ref_no']) ? $moc['old_moc_ref_no'] : "-" ?></td>
                            <td><?php echo isset($moc['risk_assessment']) ? $moc['risk_assessment'] : "-" ?></td>
                            <td><?php echo isset($moc['std_procedure_ref']) ? $moc['std_procedure_ref'] : "-" ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Current State</td>
                            <td class="fw-bold">Change State</td>
                            <td class="fw-bold ps-2" colspan=2>Change Description</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($moc['current_state']) ? $moc['current_state'] : "-" ?>
                            </td>
                            <td><?php echo isset($moc['change_state']) ? $moc['change_state'] : "-" ?></td>
                            <td class="text-start ps-2" colspan=2>
                                <?php echo isset($moc['description_of_change']) ? $moc['description_of_change'] : "-" ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Participans Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Team Members</p>
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
                                    $sql_data = "SELECT * FROM Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if (in_array($result_data['Id_employee'], $teamMembers)) {
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
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Third table -->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Action plan</p>
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
                            <td class="fw-bold ps-2">Action Point</td>
                            <td class="fw-bold">Who</td>
                            <td class="fw-bold">When</td>
                            <td class="fw-bold">Verified</td>
                            <td class="fw-bold">Status</td>
                        </tr>
                        <?php
                        foreach ($actionPlan as $key => $plan) {
                        ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($plan['action_point']) ? $plan['action_point']  : "-" ?></td>
                            <td>
                                <?php
                                    $sql_data = "SELECT * FROM Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    $who = "-";
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if ($plan['who'] == $result_data['Id_employee']) {
                                                $who =  $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                            }
                                        }
                                    }
                                    echo $who;
                                    ?>
                            </td>
                            <td> <?php echo isset($plan['date']) ? date("d-m-y", strtotime($plan['date'])) : '-'; ?>
                            </td>
                            <td>
                                <?php
                                    $sql_data = "SELECT * FROM Basic_Employee";
                                    $connect_data = mysqli_query($con, $sql_data);
                                    $verified = "-";
                                    while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                        if ($result_data['Status'] == 'Active') {
                                            if ($plan['verified'] == $result_data['Id_employee']) {
                                                $verified = $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                            }
                                        }
                                    }
                                    echo $verified;
                                    ?>
                            </td>
                            <td><?php echo (isset($plan['status']) && $plan['status'] == '0') ? 'Open' : "Closed" ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Second section-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Approval</p>
            </div>
            <div class="col-lg-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 50%">
                        <col span="1" style="width: 50%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Decision</td>
                            <td class="fw-bold">Remarks</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $decision = "-";
                                if (isset($moc['decision']) && $moc['decision'] == '1') {
                                    $decision = "Approved";
                                } else {
                                    $decision = "Rejected";
                                }
                                echo $decision;
                                ?>
                            </td>
                            <td><?php echo isset($moc['decision_remarks']) ? $moc['decision_remarks'] : "-" ?></td>
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