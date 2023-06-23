<?php

session_start();
include('functions.php');

$sqlData = "SELECT * FROM meeting WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$meeting = mysqli_fetch_assoc($connectData);

$sql = "SELECT * FROM Meeting_Co_Ordinator LEFT JOIN Basic_Employee ON Meeting_Co_Ordinator.Id_employee = Basic_Employee.Id_employee Where Meeting_Co_Ordinator.Id_meeting_co_ordinator = '$meeting[coordinator]'";
$fetch = mysqli_query($con, $sql);
$coordinatorInfo = mysqli_fetch_assoc($fetch);

$participantSqlData = "SELECT participant_id, First_Name, Last_Name FROM meeting_participant LEFT JOIN Basic_Employee ON meeting_participant.participant_id = Basic_Employee.Id_employee WHERE meeting_id = '$meeting[id]' AND meeting_participant.is_deleted = 0";
$participantData = mysqli_query($con, $participantSqlData);
$participants =  array();
$participantsData =  array();
while ($row = mysqli_fetch_assoc($participantData)) {
    array_push($participants, $row['participant_id']);
    array_push($participantsData, $row);
}

$agendaSqlData = "SELECT * FROM meeting_agenda WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$agendaSqlConnectData = mysqli_query($con, $agendaSqlData);
$agenda =  array();
while ($row = mysqli_fetch_assoc($agendaSqlConnectData)) {
    array_push($agenda, $row);
}
$notesSqlData = "SELECT * FROM meeting_notes WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$notesSqlConnectData = mysqli_query($con, $notesSqlData);
$notes =  array();
while ($row = mysqli_fetch_assoc($notesSqlConnectData)) {
    array_push($notes, $row);
}
$actionsSqlData = "SELECT * FROM meeting_actions WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$actionsSqlConnectData = mysqli_query($con, $actionsSqlData);
$actions =  array();
while ($row = mysqli_fetch_assoc($actionsSqlConnectData)) {
    array_push($actions, $row);
}
$decisionsSqlData = "SELECT * FROM meeting_decisions WHERE meeting_id = '$_REQUEST[id]' AND is_deleted = 0";
$decisionsSqlConnectData = mysqli_query($con, $decisionsSqlData);
$decisions =  array();
while ($row = mysqli_fetch_assoc($decisionsSqlConnectData)) {
    array_push($decisions, $row);
}
$header = "Meeting - Unique Id : " . $meeting['meeting_id'];
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
                        <?php echo isset($meeting['created_at']) ? date("d/m/y", strtotime($meeting['created_at'])) : '-'; ?></span>
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
                            <td class="fw-bold ps-2">Title</td>
                            <td class="fw-bold ">Coordinator</td>
                            <td class="fw-bold ">Category</td>
                            <td class="fw-bold">Venue</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($meeting['title']) ? $meeting['title'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT Meeting_Co_Ordinator.*, Basic_Employee.First_Name, Basic_Employee.Last_Name, Basic_Employee.Status FROM Meeting_Co_Ordinator LEFT JOIN Basic_Employee ON Meeting_Co_Ordinator.Id_employee = Basic_Employee.Id_employee";
                                $connect_data = mysqli_query($con, $sql_data);
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($meeting['coordinator'] == $result_data['Id_meeting_co_ordinator']) {
                                            echo $result_data['First_Name'] . " " . $result_data['Last_Name'];
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM Meeting_Category";
                                $connect_data = mysqli_query($con, $sql_data);
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($meeting['category'] == $result_data['Id_meeting_category']) {
                                            echo $result_data['Title'];
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td class="">
                                <?php
                                $sql_data = "SELECT * FROM Meeting_Venue";
                                $connect_data = mysqli_query($con, $sql_data);
                                while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                    if ($result_data['Status'] == 'Active') {
                                        if ($meeting['venue'] == $result_data['Id_meeting_venue']) {
                                            echo $result_data['Title'];
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Date</td>
                            <td class="fw-bold ">Start Time</td>
                            <td class="fw-bold ">End Time</td>
                            <td class="fw-bold">Duration</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($meeting['date']) ?  $meeting['date'] : '-'; ?></td>
                            <td class=""><?php echo isset($meeting['start_time']) ? $meeting['start_time'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($meeting['end_time']) ? $meeting['end_time'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($meeting['duration']) ?  $meeting['duration'] : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold ps-2">Status</td>
                        </tr>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($meeting['status']) ? $meeting['status'] : '-'; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--Participans Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Participants</p>
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
                                            if (in_array($result_data['Id_employee'], $participants)) {
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

        <!--Meeting Agenda Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Meeting Agenda</p>
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
                                    <?php if ($agenda && count($agenda) > 0) {
                                        foreach ($agenda as $key => $item) { ?>
                                    <li class="mt-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class=""><?php echo $item['description']; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php }
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
                <p class="m-0 fw-bold ">Discussion Notes</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 60%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 15%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Description</td>
                            <td class="fw-bold ">Speaker</td>
                            <td class="fw-bold ">Created Date</td>
                        </tr>
                        <?php if ($notes && count($notes) > 0) {
                            foreach ($notes as $key => $item) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($item['description']) ?  $item['description'] : '-'; ?></td>
                            <?php
                                    $sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
                                    $fetch = mysqli_query($con, $sql);
                                    $who = mysqli_fetch_assoc($fetch);
                                    ?>
                            <td class="">
                                <?php echo isset($who['First_Name']) ? $who['First_Name'] . ' ' . $who['Last_Name'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['updated_at']) ? date("d-m-y", strtotime($item['updated_at'])) : '-'; ?>
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
                <p class="m-0 fw-bold ">Follow Up Actions</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 45%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 15%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Description</td>
                            <td class="fw-bold ">Assigned To</td>
                            <td class="fw-bold ">Target Date</td>
                            <td class="fw-bold ">Created Date</td>
                        </tr>
                        <?php if ($actions && count($actions) > 0) {
                            foreach ($actions as $key => $item) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($item['description']) ?  $item['description'] : '-'; ?></td>
                            <?php
                                    $sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
                                    $fetch = mysqli_query($con, $sql);
                                    $who = mysqli_fetch_assoc($fetch);
                                    ?>
                            <td class="">
                                <?php echo isset($who['First_Name']) ? $who['First_Name'] . ' ' . $who['Last_Name'] : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['target_date']) ? date("d-m-y", strtotime($item['target_date'])) : '-'; ?>
                            </td>
                            <td class="">
                                <?php echo isset($item['updated_at']) ?  date("d-m-y", strtotime($item['updated_at'])) : '-'; ?>
                            </td>
                        </tr>
                        <?php }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!--Key Decisions Table-->
        <div class="row m-0">
            <div class="col-12 bg-title">
                <p class="m-0 fw-bold ">Key Decisions</p>
            </div>
            <div class="col-12 p-1">
                <table class="table table-bordered">
                    <colgroup>
                        <col span="1" style="width: 85%">
                        <col span="1" style="width: 15%">
                    </colgroup>
                    <tbody class="text-center bordered-table-body">
                        <tr>
                            <td class="fw-bold ps-2">Description</td>
                            <td class="fw-bold ">Created Date</td>
                        </tr>
                        <?php if ($decisions && count($decisions) > 0) {
                            foreach ($decisions as $key => $item) { ?>
                        <tr>
                            <td class="text-start ps-2">
                                <?php echo isset($item['description']) ?  $item['description'] : '-'; ?></td>
                            <td class="">
                                <?php echo isset($item['updated_at']) ? date("d-m-y", strtotime($item['updated_at'])) : '-'; ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="JS/jquery-3.6.0.min.js"></script>

</html>