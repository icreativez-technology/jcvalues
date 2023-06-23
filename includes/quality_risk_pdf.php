<?php

session_start();
include('functions.php');

$sql_data = "SELECT quality_risk.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Department.Department, Quality_Process.Title as process, Quality_Risk_Type.Title as Risk_Type, Quality_Risk_Source.Title as Risk_Source, Quality_Impact_Area.Title as Impact_Area, Basic_Plant.Title as plant FROM quality_risk 
		LEFT JOIN Basic_Employee ON quality_risk.created_by = Basic_Employee.Id_employee
		LEFT JOIN Basic_Department ON quality_risk.department_id = Basic_Department.Id_department
		LEFT JOIN Quality_Process ON quality_risk.process_id = Quality_Process.Id_quality_process
		LEFT JOIN Quality_Risk_Type ON quality_risk.risk_type_id = Quality_Risk_Type.Id_quality_risk_type
		LEFT JOIN Quality_Risk_Source ON quality_risk.source_of_risk_id = Quality_Risk_Source.Id_quality_risk_source
		LEFT JOIN Quality_Impact_Area ON quality_risk.impact_area_id = Quality_Impact_Area.Id_quality_impact_area
		
		LEFT JOIN Basic_Plant ON quality_risk.plant_id = Basic_Plant.Id_plant 
		LEFT JOIN Basic_Product_Group ON quality_risk.product_group_id = Basic_Product_Group.Id_product_group
		WHERE quality_risk.is_deleted = 0 AND Basic_Plant.Status = 'Active' AND id = '$_REQUEST[id]' ";

$conect_data = mysqli_query($con, $sql_data);
$quality_risk = mysqli_fetch_assoc($conect_data);

$assessment = [
    '1' => 'No Effect',
    '2' => 'Very Minor',
    '3' => 'Minor',
    '4' => 'Moderate',
    '5' => 'High',
    '6' => 'Very High',
];

$mitigationPlanSqlData = "SELECT * FROM quality_risk_mitigation_plan WHERE is_deleted = 0 AND quality_risk_id = '$_REQUEST[id]'";
$mitigationPlanData = mysqli_query($con, $mitigationPlanSqlData);
$mitigationPlan =  array();

while ($row = mysqli_fetch_assoc($mitigationPlanData)) {
    array_push($mitigationPlan, $row);
}

$revisedSqlData = "SELECT * FROM quality_risk_revised_assessment WHERE quality_risk_id = '$_REQUEST[id]'";
$revisedConnectData = mysqli_query($con, $revisedSqlData);
$revisedRisk = mysqli_fetch_assoc($revisedConnectData);

$approvalData = "SELECT * FROM quality_risk_approval WHERE quality_risk_id = '$_REQUEST[id]'";
$approvalConnectData = mysqli_query($con, $approvalData);
$approval = mysqli_fetch_assoc($approvalConnectData);

$productGroupSqlData = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = '$quality_risk[product_group_id]'";
$connectProductGroup = mysqli_query($con, $productGroupSqlData);
$productGroup = mysqli_fetch_assoc($connectProductGroup);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Risk Assignment</title>
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
        <!--Logo-->
        <div class="d-flex justify-content-start">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>


        <!--Details-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Risk Assessment Details - Unique Id: <?php echo $quality_risk['risk_id']; ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($quality_risk['created_at']) ? date("d/m/y", strtotime($quality_risk['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-12 p-1 mt-2">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 30%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">On Behalf of</td>
                            <td class="fw-bold">Plant</td>
                            <td class="fw-bold ">Product Group</td>
                            <td class="fw-bold">Department</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $sql_data = "SELECT * FROM Basic_Employee";
                                $connect_data = mysqli_query($con, $sql_data);
                                $onBehalfOf = "-";
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($quality_risk['on_behalf_of'] == $result_data['Id_employee']) {
                                            $onBehalfOf =  $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                        }
                                    }
                                }
                                echo $onBehalfOf;
                                ?>
                            </td>
                            <td class=""><?php echo isset($quality_risk['plant']) ? $quality_risk['plant'] : "-" ?></td>
                            <td class="">
                                <?php echo isset($productGroup['Title']) ? $productGroup['Title'] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($quality_risk['Department']) ? $quality_risk['Department'] : "-" ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Area/Process</td>
                            <td class="fw-bold">Risk Type</td>
                            <td class="fw-bold ">Source of Risk</td>
                            <td class="fw-bold">Impact Area</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($quality_risk['process']) ? $quality_risk['process'] : "-" ?></td>
                            <td class="">
                                <?php echo isset($quality_risk['Risk_Type']) ? $quality_risk['Risk_Type'] : "-" ?></td>
                            <td class="">
                                <?php echo isset($quality_risk['Risk_Source']) ? $quality_risk['Risk_Source'] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($quality_risk['Impact_Area']) ? $quality_risk['Impact_Area'] : "-" ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Date</td>
                            <td class="fw-bold" colspan="3">Description of Observation</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($quality_risk['created_at']) ? date("d-m-y", strtotime($quality_risk['created_at'])) : '-'; ?>
                            </td>
                            <td class="" colspan="3">
                                <?php echo isset($quality_risk['description']) ? $quality_risk['description'] : "-" ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Assessment-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Assessment</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Serverity</td>
                            <td class="fw-bold">Occurance</td>
                            <td class="fw-bold">Detection</td>
                            <td class="fw-bold">RPN</td>
                            <!-- <td class="fw-bold">Risk Level</td> -->
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($quality_risk['severity']) ? $assessment[$quality_risk['severity']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($quality_risk['occurance']) ? $assessment[$quality_risk['occurance']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($quality_risk['detection']) ? $assessment[$quality_risk['detection']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($quality_risk['rpn_value']) ? $quality_risk['rpn_value'] : "-" ?></td>
                            <!-- <td class="">Low risk</td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Mitigation Plan-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Mitigation Plan</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 10%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Corrective Action</td>
                            <td class="fw-bold">Who</td>
                            <td class="fw-bold">When</td>
                            <td class="fw-bold ">Status</td>
                        </tr>
                        <?php if ($mitigationPlan && count($mitigationPlan) > 0) {
                            foreach ($mitigationPlan as $key => $item) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($item['corrective_action']) ? $item['corrective_action'] : "-" ?></td>
                            <td>
                                <?php
                                        $sql_data = "SELECT * FROM Basic_Employee";
                                        $connect_data = mysqli_query($con, $sql_data);
                                        $who = "-";
                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                            if ($result_data['Status'] == 'Active') {
                                                if ($item['who'] == $result_data['Id_employee']) {
                                                    $who =  $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                                }
                                            }
                                        }
                                        echo $who;
                                        ?>
                            </td>
                            <td>
                                <?php echo isset($item['date']) ? date("d-m-y", strtotime($item['date'])) : '-'; ?>
                            </td>
                            <td>
                                <?php
                                        $status = "-";
                                        if (isset($item['status']) && $item['status'] == '0') {
                                            $status = "Open";
                                        } else {
                                            $status = "Closed";
                                        }
                                        echo $status;
                                        ?>
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

        <!--Revised Assessment-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Revised Assessment</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 30%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 20%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Severity</td>
                            <td class="fw-bold">Occurance</td>
                            <td class="fw-bold">Detection</td>
                            <td class="fw-bold">RPN</td>
                            <!-- <td class="fw-bold ">Risk Level</td> -->
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($revisedRisk['revised_severity']) ? $assessment[$revisedRisk['revised_severity']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($revisedRisk['revised_occurance']) ? $assessment[$revisedRisk['revised_occurance']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($revisedRisk['revised_detection']) ? $assessment[$revisedRisk['revised_detection']] : "-" ?>
                            </td>
                            <td class="">
                                <?php echo isset($revisedRisk['revised_rpn_value']) ? $revisedRisk['revised_rpn_value'] : "-"; ?>
                            </td>
                            <!-- <td class="">Low risk</td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Approval-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Approval</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 50%">
                        <col span="1" style="width: 50%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Approval</td>
                            <td class="fw-bold">Remarks</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php
                                $decision = "-";
                                if (isset($approval['decision']) && $approval['decision'] == '1') {
                                    $decision = 'Approved';
                                } else if (isset($approval['decision']) && $approval['decision'] == '2') {
                                    $decision = 'Rejecetd';
                                }
                                echo $decision;
                                ?>
                            <td class="">
                                <?php echo isset($approval['decision']) ? $approval['decision_remarks'] : "-"; ?></td>
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
<script type="text/javascript" src="./js/accordion-action.js"></script>

</html>