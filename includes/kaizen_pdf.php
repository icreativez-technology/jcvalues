<?php

session_start();
include('functions.php');

$sqlData = "SELECT * FROM kaizen WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$kaizen = mysqli_fetch_assoc($connectData);

$sqlData = "SELECT * FROM Basic_Employee WHERE Id_plant = '$kaizen[plant_id]' AND Id_department = '$kaizen[department_id]' AND Department_Head = 'Yes' LIMIT 1";
$connectData = mysqli_query($con, $sqlData);
$hod = mysqli_fetch_assoc($connectData);

$team_membersqlData = "SELECT member_id, First_Name, Last_Name FROM kaizen_team_members LEFT JOIN Basic_Employee ON kaizen_team_members.member_id = Basic_Employee.Id_employee WHERE kaizen_id = '$kaizen[id]' AND kaizen_team_members.is_deleted = 0";
$team_membersData = mysqli_query($con, $team_membersqlData);
$team_members =  array();
while ($row = mysqli_fetch_assoc($team_membersData)) {
    array_push($team_members, $row['First_Name'] . ' ' . $row['Last_Name']);
}

$selfEvaluationSqlData = "SELECT * FROM kaizen_self_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$selfEvaluationqlConnectData = mysqli_query($con, $selfEvaluationSqlData);
$selfEvaluation = mysqli_fetch_assoc($selfEvaluationqlConnectData);
$hodDisabled = $selfEvaluationqlConnectData->num_rows == 0 ? true : false;
$hodEvaluationSqlData = "SELECT * FROM kaizen_hod_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$hodEvaluationqlConnectData = mysqli_query($con, $hodEvaluationSqlData);
$hodEvaluation = mysqli_fetch_assoc($hodEvaluationqlConnectData);
$comDisabled = $hodEvaluationqlConnectData->num_rows == 0 ? true : false;
$comEvaluationSqlData = "SELECT * FROM kaizen_committee_evaluation WHERE kaizen_id = '$_REQUEST[id]'";
$comEvaluationqlConnectData = mysqli_query($con, $comEvaluationSqlData);
$comEvaluation = mysqli_fetch_assoc($comEvaluationqlConnectData);

$sqlData = "SELECT * FROM Basic_Employee WHERE Id_employee = '$comEvaluation[created_by]'";
$connectData = mysqli_query($con, $sqlData);
$committeeHead = mysqli_fetch_assoc($connectData);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaizen Report</title>
</head>

<style>
#element-to-print {
    padding: 0 !important;
    font-family: Poppins, Helvetica, sans-serif;
    height: 1080px;
    position: relative;
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

#element-to-print .form-check-input {
    width: 10px;
    height: 10px;
    top: 5px;
}
</style>

<body>

    <!-- first page -->
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
                <p class="m-0 fw-bold ">Kaizen Details - Unique Id : <?php echo $kaizen['kaizen_id']; ?>
                    <span class="text-end" style="float: right;"> Created Date:
                        <?php echo isset($kaizen['created_at']) ? date("d/m/y", strtotime($kaizen['created_at'])) : '-'; ?></span>
                </p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Team Leader</td>
                            <td class="fw-bold">Plant</td>
                            <td class="fw-bold">Product Group</td>
                            <td class="fw-bold">Department</td>
                        </tr>
                        <tr>
                            <?php
                            $sql_data = "SELECT * FROM Basic_Employee WHERE Id_employee = $kaizen[team_leader_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);

                            $firstName = isset($result_data['First_Name']) ? $result_data['First_Name'] : '';
                            $lastName = isset($result_data['Last_Name']) ? $result_data['Last_Name'] : '';
                            $employeeName =  $firstName . ' ' . $lastName;
                            ?>
                            <td class="ps-2"><?php echo $employeeName ?></td>
                            <?php
                            $sql_data = "SELECT * FROM Basic_Plant WHERE Id_plant = $kaizen[plant_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['Title']) ? $result_data['Title'] : '-'; ?></td>


                            <?php
                            $sql_data = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = $kaizen[product_group_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['Title']) ? $result_data['Title'] : '-'; ?></td>

                            <?php
                            $sql_data = "SELECT * FROM Basic_Department WHERE Id_department = $kaizen[department_id] AND Status = 'Active'";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="">
                                <?php echo isset($result_data['Department']) ? $result_data['Department'] : '-'; ?></td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Category</td>
                            <td class="fw-bold">Focus Area</td>
                            <td class="fw-bold ">Process</td>
                            <td class="fw-bold">Kaizen Type</td>
                        </tr>
                        <tr>

                            <?php
                            $sql_data = "SELECT * FROM kaizen_category WHERE id = $kaizen[category_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="text-start ps-2">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-' ?></td>

                            <?php
                            $sql_data = "SELECT * FROM kaizen_focus_area WHERE id = $kaizen[focus_area_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class="">
                                <?php echo isset($result_data['title']) ? $result_data['title'] : '-' ?>
                            </td>

                            <?php
                            $sql_data = "SELECT * FROM kaizen_process WHERE id = $kaizen[process_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['title']) ? $result_data['title'] : '-' ?></td>

                            <?php
                            $sql_data = "SELECT * FROM kaizen_type WHERE id = $kaizen[kaizen_type_id] AND is_deleted = 0";
                            $connect_data = mysqli_query($con, $sql_data);
                            $result_data = mysqli_fetch_assoc($connect_data);
                            ?>
                            <td class=""><?php echo isset($result_data['title']) ? $result_data['title'] : '-' ?></td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2">Implemented On</td>
                            <td class="fw-bold" colspan="3">Team Members</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2"><?php echo date("d-m-y", strtotime($kaizen['created_at'])) ?>
                            </td>
                            <td class="" colspan="3">
                                <?php
                                foreach ($team_members as $member) {
                                    echo $member . ', ';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Theme of Kaizen</td>
                            <td class="fw-bold" colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2"><?php echo $kaizen['theme_of_kaizen']; ?></td>
                            <td class="" colspan="2"></td>
                        </tr>

                        <tr>
                            <td class="fw-bold ps-2" colspan="2">Before Improvement</td>
                            <td class="fw-bold" colspan="2">After Improvement</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2" colspan="2"><?php echo $kaizen['before_improvement']; ?></td>
                            <td class="" colspan="2"><?php echo $kaizen['after_improvement']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Benefits-->
        <div class="row m-0 mt-2">
            <div class="col-12 bg-title mt-2">
                <p class="m-0 fw-bold ">Benefits</p>
            </div>
            <table class="table table-bordered mt-2">
                <tbody class="text-center bordered-table-body">
                    <tr>
                        <td class="fw-bold ps-2">Expenditure<small>(if any)</small></td>
                        <td class="fw-bold">Direct Saving<small>(if any)</small></td>
                        <td class="fw-bold">Indirect Saving<small>(if any)</small></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-2"><?php echo $kaizen['expenditure']; ?></td>
                        <td class=""><?php echo $kaizen['direct_savings']; ?></td>
                        <td class=""><?php echo $kaizen['indirect_savings']; ?></td>
                    </tr>

                    <tr>
                        <td class="fw-bold ps-2">Total Expenditure (E)</td>
                        <td class="fw-bold">Total Direct Saving(D)</td>
                        <td class="fw-bold">Total Indirect Saving(I)</td>
                    </tr>
                    <tr>
                        <td class="text-start ps-2"><?php echo $kaizen['total_expenditure']; ?></td>
                        <td class=""><?php echo $kaizen['total_direct_savings']; ?></td>
                        <td class=""><?php echo $kaizen['total_indirect_savings']; ?></td>
                    </tr>

                    <tr>
                        <td class="fw-bold ps-2">Final Monetary Gain((D+I)-E)</td>
                        <td class="fw-bold"></td>
                        <td class="fw-bold"></td>
                    </tr>
                    <tr>
                        <td class="text-start ps-2"><?php echo $kaizen['final_monetary_gain']; ?></td>
                        <td class=""></td>
                        <td class=""></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--Self Evaluation-->
        <div class="row m-0 mt-2">
            <div class="col-12 bg-title mt-2">
                <p class="m-0 fw-bold ">Self Evaluation</p>
            </div>
            <table class="table table-bordered mt-2">
                <tbody class="text-center bordered-table-body">
                    <tr class="">
                        <td class="fw-bold  ps-2">Criterion</td>
                        <td class="fw-bold " colspan="4">Points</td>
                    </tr>
                    <tr class="">
                        <td class="ps-2">Individual or Team</td>
                        <td class="">
                            <p class="m-0">1 Person</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria1'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">2 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria1'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">3 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria1'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">One time or sustainable</td>
                        <td class="">
                            <p class="m-0">One Time</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria2'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sustainable for 1 year</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria2'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Perpetual</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria2'] == '30') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    30
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Proactive/Reactive</td>
                        <td class="">
                            <p class="m-0">Flower Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria3'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Bud Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria3'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sprout Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria3'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Seed Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria3'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Creativity</td>
                        <td class="">
                            <p class="m-0">Low</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria4'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Medium</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria4'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">High</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria4'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Unique</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($selfEvaluation['criteria4'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Focus Area Multiplier: 1.5</td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Self Evaluation Score:
                            <?php echo $selfEvaluation['score'] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Remarks: <?php echo $selfEvaluation['remarks'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-4 mx-4">
                <p class="m-0">Format No: Revision No:</p>
                <p class="m-0">Electronically generated document, signature not required. Page 1 of 2</p>
            </div>
        </div>
    </div>

    <!-- second page -->
    <div id="element-to-print">

        <!--Logo-->
        <div class="d-flex justify-content-start" style="margin-top: 50px">
            <div>
                <img src="./Imagenes/logo_PDF.png" class="mx-auto d-block py-1" width="60">
            </div>
        </div>

        <!--HOD Evaluation-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">HOD Evaluation -
                    <?php echo isset($hod) ? $hod['First_Name'] . ' ' . $hod['Last_Name'] : ''; ?></p>
            </div>
            <table class="table table-bordered mt-2">
                <tbody class="text-center bordered-table-body">
                    <tr class=" ">
                        <td class="fw-bold ps-2">Criterion</td>
                        <td class="fw-bold " colspan="4">Points</td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Individual or Team</td>
                        <td class="">
                            <p class="m-0">1 Person</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria1'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">2 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria1'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">3 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria1'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">One time or sustainable</td>
                        <td class="">
                            <p class="m-0">One Time</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria2'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sustainable for 1 year</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria2'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Perpetual</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria2'] == '30') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    30
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Proactive/Reactive</td>
                        <td class="">
                            <p class="m-0">Flower Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria3'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Bud Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria3'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sprout Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria3'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Seed Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria3'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Creativity</td>
                        <td class="">
                            <p class="m-0">Low</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio">
                                <label class="form-check-label" for=""
                                    <?php echo ($hodEvaluation['criteria4'] == '10') ? "checked" : ""; ?>>
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Medium</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria4'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">High</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria4'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Unique</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($hodEvaluation['criteria4'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Focus Area Multiplier: 1.5</td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Self Evaluation Score:
                            <?php echo  $selfEvaluation['score'] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">HOD Evaluation Score:
                            <?php echo  $hodEvaluation['score'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Remarks: <?php echo $hodEvaluation['remarks'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--Committee Evaluation-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Committee Evaluation -
                    <?php echo isset($committeeHead) ? $committeeHead['First_Name'] . ' ' . $committeeHead['Last_Name'] : ''; ?>
                </p>
            </div>
            <table class="table table-bordered mt-2">
                <tbody class="text-center bordered-table-body">
                    <tr class=" ">
                        <td class="fw-bold ps-2">Criterion</td>
                        <td class="fw-bold " colspan="4">Points</td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Individual or Team</td>
                        <td class="">
                            <p class="m-0">1 Person</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria1'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">2 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria1'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">3 Persons</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria1'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">One time or sustainable</td>
                        <td class="">
                            <p class="m-0">One Time</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria2'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sustainable for 1 year</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria2'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Perpetual</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria2'] == '30') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    30
                                </label>
                            </div>
                        </td>
                        <td class=""></td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Proactive/Reactive</td>
                        <td class="">
                            <p class="m-0">Flower Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria3'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Bud Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria3'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Sprout Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria3'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Seed Stage</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria3'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="text-start ps-2">Creativity</td>
                        <td class="">
                            <p class="m-0">Low</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria4'] == '10') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    10
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Medium</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria4'] == '15') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    15
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">High</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria4'] == '20') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    20
                                </label>
                            </div>
                        </td>
                        <td class="">
                            <p class="m-0">Unique</p>
                            <div class="form-check">
                                <input class="form-check-input mt-1" type="radio"
                                    <?php echo ($comEvaluation['criteria4'] == '25') ? "checked" : ""; ?>>
                                <label class="form-check-label" for="">
                                    25
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Focus Area Multiplier: 1.5</td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2">Self Evaluation Score: <?php echo $selfEvaluation['score'] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2">HOD Evaluation Score: <?php echo $hodEvaluation['score'] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2">Evaluation committee Score:
                            <?php echo $comEvaluation['score'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold ps-2" colspan="5">Remarks: <?php echo $comEvaluation['remarks'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!--footer-->
        <div class="footer">
            <div class="d-flex justify-content-between border-top mt-4 mx-4">
                <p class="m-0">Format No: Revision No:</p>
                <p class="m-0">Electronically generated document, signature not required. Page 2 of 2</p>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="./js/accordion-action.js"></script>

</html>