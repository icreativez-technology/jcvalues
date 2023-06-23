<?php
session_start();
include('includes/functions.php');
$email = $_SESSION['usuario'];
$roleSql = "SELECT * From Basic_Employee INNER JOIN Basic_Role_Employee ON Basic_Employee.Id_employee=Basic_Role_Employee.Id_employee Where Email = '$email'";
$fetchRole = mysqli_query($con, $roleSql);
$roleInfo = mysqli_fetch_assoc($fetchRole);
$role = $roleInfo['Id_basic_role'];
$empId = $roleInfo['Id_employee'];
$sqlData = "SELECT * FROM meeting WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$meeting = mysqli_fetch_assoc($connectData);
$sql = "SELECT * FROM Basic_Employee where Id_employee = '$meeting[coordinator]'";
$fetch = mysqli_query($con, $sql);
$coordinatorInfo = mysqli_fetch_assoc($fetch);
$disabled = $meeting['coordinator'] == $empId || $role == 1 ? false : true;
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

$decisionsReviewSqlData = "SELECT * FROM meeting_review_decision WHERE meeting_id = '$_REQUEST[id]'";
$decisionsReviewSqlConnectData = mysqli_query($con, $decisionsReviewSqlData);
$decisionsReview =  array();
while ($row = mysqli_fetch_assoc($decisionsReviewSqlConnectData)) {
    array_push($decisionsReview, $row);
}
$_SESSION['Page_Title'] = "Edit Meeting - " . $meeting['meeting_id'];

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<style>
    .custom-tab .nav-link {
        border-radius: 3px;
        padding: 8px 20px;
    }

    .custom-tab .nav-link.active {
        color: #fff !important;
        background-color: #009ef7;
    }

    .custom-tab .nav-link.active:hover {
        color: #fff !important;
    }

    .required::after {
        content: "*";
        color: #e1261c;
    }

    .custom-select {
        background-color: #f5f8fa;
        border: 1px solid #e4e6ef;
        border-radius: 6px;
        width: 100%;
        padding: 6px;
        min-height: 38px;
    }

    .custom-select .tag-wrapper {
        list-style: none;
        display: flex;
        justify-content: flex-start;
        align-content: flex-start;
        flex-wrap: wrap;
    }

    .tag-wrapper .tags {
        position: relative;
        padding: 0px 15px 0px 6px;
        margin: 4px;
        text-align: left;
        background-color: #e1e2e4;
        border-radius: 5px;
    }

    .tag-wrapper .tags span {
        position: absolute;
        right: 4px;
        cursor: pointer;
        color: #002429;
    }

    .tag-wrapper .tags span::after {
        content: "x";
        font-weight: 600;
    }

    .tag-wrapper .tags span:hover {
        color: #e1261c;
    }

    .tag-wrapper .tags a {
        color: #002429;
    }

    .tag-wrapper .tags a:hover {
        color: #e1261c;
    }

    .ver-disabled input {
        background-color: #e9ecef !important;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        top: 0 !important;
        right: 0 !important;
        margin: auto;
        width: 320px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 15px;
    }

    .modal.left.fade .modal-dialog {
        left: -320px;
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog {
        left: 0;
    }

    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    .popup-form {
        height: 100%;
    }

    .form-check-input {
        width: 1.35rem;
        height: 1.35rem;
    }
</style>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-disabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include('includes/aside-menu.php'); ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include('includes/header.php'); ?>
                <div class="row breadcrumbs">
                    <div>
                        <div>
                            <p><a href="/">Home</a> » <a href="/meeting.php">Meetings</a> » <a href="/meeting_view_list.php">Meeting List</a> »
                                <?php echo $_SESSION['Page_Title']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="container-custom" id="kt_content_container">
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "" : "active" ?>" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button" role="tab" aria-controls="schedule" aria-selected="true">Schedule</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo (isset($_GET['updated'])) ? "active" : "" ?>" id="mom-tab" data-bs-toggle="tab" data-bs-target="#mom" type="button" role="tab" aria-controls="mom" aria-selected="false">MOM</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "" : "active show" ?>" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
                                <div class="card card-flush">
                                    <form class="form" action="includes/meeting_update.php" method="post" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <div id="custom-section-1">
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Title</label>
                                                        <input class="form-control" name="title" required value="<?php echo $meeting['title']; ?>" <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Coordinator</label>
                                                        <input type="hidden" class="form-control" name="coordinator" value="<?php echo $coordinatorInfo['Id_employee']; ?>">
                                                        <input type="text" class="form-control" value="<?php echo $coordinatorInfo['First_Name'] . ' ' . $coordinatorInfo['Last_Name']; ?>" disabled>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Category</label>
                                                        <select class="form-control" name="category" required <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Meeting_Category";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $meeting['category'] == $result_data['Id_meeting_category'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_meeting_category']; ?>" <?= $selected; ?>>
                                                                        <?php echo $result_data['Title']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Venue</label>
                                                        <select class="form-control" name="venue" required <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Meeting_Venue";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active') {
                                                                    $selected = $meeting['venue'] == $result_data['Id_meeting_venue'] ? 'selected' : '';
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_meeting_venue']; ?>" <?= $selected; ?>>
                                                                        <?php echo $result_data['Title']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Date</label>
                                                        <input type="date" class="form-control" name="date" min="" id="date" required value="<?php echo $meeting['date']; ?>" <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">Start Time</label>
                                                        <input type="time" class="form-control set-time" name="start_time" id="start_time" required value="<?php echo $meeting['start_time']; ?>" <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5">
                                                        <label class="required">End Time</label>
                                                        <input type="time" class="form-control set-time" name="end_time" id="end_time" required value="<?php echo $meeting['end_time']; ?>" <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                    <div class="col-lg-3 mt-5 ver-disabled">
                                                        <label class="required">Duration</label>
                                                        <input type="time" class="form-control" name="duration" id="duration" required value="<?php echo $meeting['duration']; ?>" readonly <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-9 mt-5">
                                                        <label class="required">Participants</label>
                                                        <select class="form-control form-select-solid select2-hidden-accessible" data-control="select2" data-hide-search="true" data-placeholder="Select Participants" name="participants[]" data-select2-id="select2-data-7-oqww" tabindex="-1" aria-hidden="true" required multiple <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                            <?php
                                                            $sql_data = "SELECT * FROM Basic_Employee";
                                                            $connect_data = mysqli_query($con, $sql_data);
                                                            while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                                if ($result_data['Status'] == 'Active' && $result_data['Id_employee'] != $coordinatorInfo['Id_employee']) {
                                                            ?>
                                                                    <option value="<?php echo $result_data['Id_employee']; ?>" <?php echo (in_array($result_data['Id_employee'], $participants)) ? 'selected' : ''; ?>>
                                                                        <?php echo $result_data['First_Name']; ?>
                                                                        <?php echo $result_data['Last_Name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 mt-5 ver-disabled">
                                                        <label class="required">Status</label>
                                                        <input class="form-control" name="status" required value="<?php echo $meeting['status']; ?>" readonly <?php echo ($disabled) ? "disabled" : ""; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row" style="text-align:center; float:right;">
                                                <div class="mb-4">
                                                    <?php if (!$disabled) {
                                                        $label = "Cancel"; ?>
                                                        <button type="submit" class="btn btn-sm btn-success" id="tag-form-submit1">Update</button>
                                                    <?php } else {
                                                        $label = "Close";
                                                    } ?>
                                                    <a type="button" href="/meeting.php" class="btn btn-sm btn-secondary ms-2"><?php echo $label; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="meetingId" value="<?php echo $meeting['id']; ?>">
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade <?php echo (isset($_GET['updated'])) ? "active show" : "" ?>" id="mom" role="tabpanel" aria-labelledby="mom-tab">
                                <div class="row">
                                    <div class="<?php echo ($meeting['status'] == 'In Review') ? "col-md-7" : "col-md-12" ?>">
                                        <div class="card card-flush p-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mt-4">
                                                    <h5 class="fw-bold text-primary m-0">Meeting Agenda</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#agenda">Create</button>
                                                </div>
                                                <ul class="mt-4">
                                                    <?php if ($agenda && count($agenda) > 0) {
                                                        foreach ($agenda as $key => $item) { ?>
                                                            <li class="mt-2">
                                                                <input type="hidden" class="form-control" name="agenda_id" value="<?php echo $item['id']; ?>">
                                                                <input type="hidden" class="form-control" name="agenda_description" value="<?php echo $item['description']; ?>">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-link me-3 mb-1" data-bs-toggle="modal" onclick="agendaPopup(this);">
                                                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                        </button>
                                                                        <a href="/includes/meeting_agenda_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    <?php }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="fw-bold text-primary m-0">Discussion Notes</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#notes">Create</button>
                                                </div>
                                                <ul class="mt-4">
                                                    <?php if ($notes && count($notes) > 0) {
                                                        foreach ($notes as $key => $item) { ?>
                                                            <li class="mt-2">
                                                                <input type="hidden" class="form-control" name="notes_id" value="<?php echo $item['id']; ?>">
                                                                <input type="hidden" class="form-control" name="notes_description" value="<?php echo $item['description']; ?>">
                                                                <input type="hidden" class="form-control" name="notes_speaker" value="<?php echo $item['speaker']; ?>">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
                                                                        <?php
                                                                        $sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
                                                                        $fetch = mysqli_query($con, $sql);
                                                                        $who = mysqli_fetch_assoc($fetch);
                                                                        ?>
                                                                        <span class="text-muted fw-bold me-2"><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></span>
                                                                        <span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
                                                                        <span class="text-muted fw-bold"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-link me-3 mb-1" data-bs-toggle="modal" onclick="notesPopup(this);">
                                                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                        </button>
                                                                        <a href="/includes/meeting_notes_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    <?php }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="fw-bold text-primary m-0">Follow Up Actions</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#actions">Create</button>
                                                </div>
                                                <ul class="mt-4">
                                                    <?php if ($actions && count($actions) > 0) {
                                                        foreach ($actions as $key => $item) { ?>
                                                            <li class="mt-2">
                                                                <input type="hidden" class="form-control" name="actions_id" value="<?php echo $item['id']; ?>">
                                                                <input type="hidden" class="form-control" name="actions_description" value="<?php echo $item['description']; ?>">
                                                                <input type="hidden" class="form-control" name="actions_speaker" value="<?php echo $item['speaker']; ?>">
                                                                <input type="hidden" class="form-control" name="actions_target_date" value="<?php echo $item['target_date']; ?>">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
                                                                        <?php
                                                                        $sql = "SELECT * From Basic_Employee Where Id_employee = $item[speaker]";
                                                                        $fetch = mysqli_query($con, $sql);
                                                                        $who = mysqli_fetch_assoc($fetch);
                                                                        ?>
                                                                        <span class="text-muted fw-bold me-2"><?php echo $who['First_Name'] . ' ' . $who['Last_Name']; ?></span>
                                                                        <span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
                                                                        <span class="text-muted fw-bold me-4"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
                                                                        <span class="text-muted fw-bold"><i class="fa fa-calendar me-1" aria-hidden="true"></i><?php echo date("d-m-y", strtotime($item['target_date'])); ?></span>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-link me-3 mb-1" data-bs-toggle="modal" onclick="actionsPopup(this);">
                                                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                        </button>
                                                                        <a href="/includes/meeting_actions_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    <?php }
                                                    }
                                                    ?>
                                                </ul>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="fw-bold text-primary m-0">Key Decisions</h5>
                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#decisions">Create</button>
                                                </div>
                                                <ul class="mt-4">
                                                    <?php if ($decisions && count($decisions) > 0) {
                                                        foreach ($decisions as $key => $item) { ?>
                                                            <li class="mt-2">
                                                                <input type="hidden" class="form-control" name="decisions_id" value="<?php echo $item['id']; ?>">
                                                                <input type="hidden" class="form-control" name="decisions_description" value="<?php echo $item['description']; ?>">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <span class="text-dark d-block fw-bold fs-6"><?php echo $item['description']; ?></span>
                                                                        <span class="text-muted fw-bold me-2"><?php echo date("d-m-y", strtotime($item['updated_at'])); ?></span>
                                                                        <span class="text-muted fw-bold me-4"><?php echo date("h:i:s", strtotime($item['updated_at'])); ?></span>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-link me-3 mb-1" data-bs-toggle="modal" onclick="decisionsPopup(this);">
                                                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                                                        </button>
                                                                        <a href="/includes/meeting_decisions_delete.php?id=<?php echo $item['id']; ?>"><i class="bi bi-trash" aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    <?php }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-2">
                                                        <?php if ($meeting['status'] != "Published" && (!$disabled)) { ?>
                                                            <?php if ($meeting['status'] != "In Review") { ?>
                                                                <a type="button" href="/includes/meeting_status.php?id=<?php echo $meeting['id']; ?>&status=review" class="btn btn-sm btn-warning me-2">Submit For Review</a>
                                                            <?php } ?>
                                                            <a type="button" href="/includes/meeting_status.php?id=<?php echo $meeting['id']; ?>&status=publish" class="btn btn-sm btn-success me-2 <?php echo (count($decisionsReview) != count($participants)) && $meeting['status'] == 'In Review' ? 'disabled' : "" ?>">Publish</a>
                                                        <?php } ?>
                                                        <a type="button" href="/meeting_view_list.php" class="btn btn-sm btn-secondary">Close</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 <?php echo ($meeting['status'] == 'In Review') ? "" : "d-none" ?>">
                                        <div class="card card-flush p-3">
                                            <div class="card-body">
                                                <table class="table align-middle table-row-dashed fs-6 gy-5 gx-5" id="kt_suppliers_table">
                                                    <!--begin::Table head-->
                                                    <thead>
                                                        <!--begin::Table row-->
                                                        <tr class="text-start text-gray-400 text-uppercase gs-0">
                                                            <th class="min-w-100px">Participants</th>
                                                            <th class="min-w-180px">Decision</th>
                                                            <!--end::Table row-->
                                                    </thead>
                                                    <tbody class="fw-bold text-gray-600" id="decision-content">
                                                        <input type="hidden" name="decisionReviewArr" id="decisionReviewArr" value='<?php echo json_encode($decisionsReview) ?>'>
                                                        <?php
                                                        $sql_data = "SELECT * FROM Basic_Employee";
                                                        $connect_data = mysqli_query($con, $sql_data);
                                                        while ($result_data = mysqli_fetch_assoc($connect_data)) {
                                                            if ($result_data['Status'] == 'Active' && $result_data['Id_employee'] != $coordinatorInfo['Id_employee']) {
                                                                if (in_array($result_data['Id_employee'], $participants)) {
                                                                    $checkbox_show = intval($empId) ==  intval($result_data['Id_employee']) ? "" : "disabled";
                                                                    echo '<tr><td>' . $result_data['First_Name'] . ' ' . $result_data['Last_Name'] . '</td>
                                                                    <td><input type="checkbox" class="form-check-input decision-check" data-id="' . $result_data['Id_employee'] . '" value="Agree" ' . $checkbox_show . '/>
                                                                    <label class="form-check-label ms-2">Agree</label>
                                                                    <input type="checkbox" class="form-check-input decision-check ms-4 " data-id="' . $result_data['Id_employee'] . '" value="Disagree" ' . $checkbox_show . '/>
                                                                    <label class="form-check-label ms-2">Disagree</label>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row" style="text-align:center; float:right;">
                                                    <div class="mb-2">
                                                        <a type="button" class="btn btn-sm btn-success me-2" id="decision-submit">Submit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
    <?php include('includes/scrolltop.php'); ?>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="assets/plugins/custom/leaflet/leaflet.bundle.js"></script>
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="assets/js/widgets.bundle.js"></script>
    <script src="assets/js/custom/widgets.js"></script>
    <script src="assets/js/custom/apps/chat/chat.js"></script>
    <script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="assets/js/custom/utilities/modals/select-location.js"></script>
    <script src="assets/js/custom/utilities/modals/users-search.js"></script>
    <script>
        $(document).ready(function() {
            checkDecisionReview();
            var date = new Date();
            var min = date.getFullYear() +
                "-" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "-" +
                ("0" + date.getDate()).slice(-2);
            document.getElementById("date").min = min;
            document.getElementById("actions_target_date").min = min;
            document.getElementById("decisions_target_date").min = min;
        });

        function agendaPopup(obj) {
            let getData = getAgendaValue($(obj).closest('li'));
            let setData = setAgendaValue(getData);
            if (setData) {
                return $('#agenda').modal('show');
            }
        }

        function getAgendaValue(obj) {
            let agenda_id = $(obj).find('input[name="agenda_id"]').val();
            let agenda_description = $(obj).find('input[name="agenda_description"]').val();
            return {
                agenda_id,
                agenda_description,
            }
        }

        function setAgendaValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#agenda_id').val(dataArr.agenda_id);
                $('#agenda_description').val(dataArr.agenda_description);
                return true;
            }
            return false;
        }

        function resetAgendaValues() {
            return setAgendaValue({
                agenda_id: "",
                agenda_description: "",
            });
        }

        function notesPopup(obj) {
            let getData = getNotesValue($(obj).closest('li'));
            let setData = setNotesValue(getData);
            if (setData) {
                return $('#notes').modal('show');
            }
        }

        function getNotesValue(obj) {
            let notes_id = $(obj).find('input[name="notes_id"]').val();
            let notes_description = $(obj).find('input[name="notes_description"]').val();
            let notes_speaker = $(obj).find('input[name="notes_speaker"]').val();
            return {
                notes_id,
                notes_description,
                notes_speaker
            }
        }

        function setNotesValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#notes_id').val(dataArr.notes_id);
                $('#notes_description').val(dataArr.notes_description);
                $('#notes_speaker').val(dataArr.notes_speaker);
                return true;
            }
            return false;
        }

        function resetNotesValues() {
            return setNotesValue({
                notes_id: "",
                notes_description: "",
                notes_speaker: ""
            });
        }

        function actionsPopup(obj) {
            let getData = getActionsValue($(obj).closest('li'));
            let setData = setActionsValue(getData);
            if (setData) {
                return $('#actions').modal('show');
            }
        }

        function getActionsValue(obj) {
            let actions_id = $(obj).find('input[name="actions_id"]').val();
            let actions_description = $(obj).find('input[name="actions_description"]').val();
            let actions_speaker = $(obj).find('input[name="actions_speaker"]').val();
            let actions_target_date = $(obj).find('input[name="actions_target_date"]').val();
            return {
                actions_id,
                actions_description,
                actions_speaker,
                actions_target_date
            }
        }

        function setActionsValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#actions_id').val(dataArr.actions_id);
                $('#actions_description').val(dataArr.actions_description);
                $('#actions_speaker').val(dataArr.actions_speaker);
                $('#actions_target_date').val(dataArr.actions_target_date);
                return true;
            }
            return false;
        }

        function resetActionsValues() {
            return setActionsValue({
                actions_id: "",
                actions_description: "",
                actions_speaker: "",
                actions_target_date: ""

            });
        }

        function decisionsPopup(obj) {
            let getData = getDecisionsValue($(obj).closest('li'));
            let setData = setDecisionsValue(getData);
            if (setData) {
                return $('#decisions').modal('show');
            }
        }

        function getDecisionsValue(obj) {
            let decisions_id = $(obj).find('input[name="decisions_id"]').val();
            let decisions_description = $(obj).find('input[name="decisions_description"]').val();
            return {
                decisions_id,
                decisions_description,
            }
        }

        function setDecisionsValue(dataArr) {
            if (Object.keys(dataArr)?.length > 0) {
                $('#decisions_id').val(dataArr.decisions_id);
                $('#decisions_description').val(dataArr.decisions_description);
                return true;
            }
            return false;
        }

        function resetDecisionsValues() {
            return setDecisionsValue({
                decisions_id: "",
                decisions_description: "",
            });
        }

        function pad(n) {
            return (n < 10 && n > -1) ? ("0" + n) : n;
        };

        $(".set-time").on("change", function() {
            var valuestart = $("#start_time").val();
            var valuestop = $("#end_time").val();

            var timeStart = new Date("01/01/2022 " + valuestart + ":00");
            var timeEnd = new Date("01/01/2022 " + valuestop + ":00");

            var diff = timeEnd.getTime() - timeStart.getTime();

            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            let duration = pad(hh) + ":" + pad(mm) + ":" + pad(ss);
            if (duration.includes("-", 0)) {
                $("#duration").val("");
                return $("#end_time").val("");
            };
            return $('#duration').val(String(duration));
        });

        $('#decision-submit').on('click', function() {
            let contentElem = $('.decision-check:checked');
            let decisionArr = new Array();
            let meetingId = $('#meeting_id').val();
            $.each(contentElem, function(key, elem) {
                let dataObj = {
                    id: $(elem).data('id'),
                    decision: elem.value
                }
                decisionArr.push(dataObj);
            });

            if (decisionArr.length > 0) {
                $.ajax({
                    url: `includes/meeting-review-decision.php`,
                    type: "POST",
                    dataType: "html",
                    data: {
                        data: decisionArr,
                        meetingId: meetingId
                    },
                }).done(function(resultado) {
                    if (resultado) {
                        let origin_url = window.location.href;
                        window.location.href = `${origin_url}&updated`;
                    }
                });
            }
        });

        function checkDecisionReview() {
            let decisionReviewArr = JSON.parse($('#decisionReviewArr').val());
            let tableElem = $('#decision-content').find('tr');
            $.each(tableElem, function(key, tr) {
                let inputElem = $(tr).find('input');
                $.each(inputElem, function(input_key, input) {
                    decisionReviewArr.map(function(item) {
                        if ((Number(item.employee_id) == Number($(input).data('id')) &&
                                (item.decision.toString() == $(input).val().toString()))) {
                            input.checked = true;
                        }
                    })
                });
            });
        }

        $('.decision-check').on('click', function() {
            let elemArr = $(this).closest('td').find('input');
            let elemValue = $(this).val();
            $.each(elemArr, function(key, elem) {
                if ($(elem).val().toString() != elemValue.toString()) {
                    return elem.checked = false;
                }
            });
        });
    </script>
    <div class="modal right fade" id="agenda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="form popup-form" action="includes/meeting_agenda_update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Meeting Agenda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetAgendaValues();"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required">Description</label>
                                <textarea class="form-control" name="agenda_description" id="agenda_description" required value=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetAgendaValues();">Close</button>
                    </div>
                    <input type="hidden" class="form-control" name="meeting_id" id="meeting_id" value="<?php echo $meeting['id']; ?>">
                    <input type="hidden" class="form-control" name="agenda_id" id="agenda_id" value="">
                </div>
            </form>
        </div>
    </div>
    <div class="modal right fade" id="notes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="form popup-form" action="includes/meeting_notes_update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Discussion Notes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetNotesValues();"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required">Description</label>
                                <textarea class="form-control" name="notes_description" id="notes_description" required value=""></textarea>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="required">Speaker</label>
                                <select class="form-control" name="notes_speaker" id="notes_speaker" required>
                                    <option value="">Please Select</option>
                                    <option value="<?php echo $coordinatorInfo['Id_employee']; ?>">
                                        <?php echo $coordinatorInfo['First_Name']; ?>
                                        <?php echo $coordinatorInfo['Last_Name']; ?>
                                    </option>
                                    <?php foreach ($participantsData as $key => $participant) { ?>
                                        <option value="<?php echo $participant['participant_id']; ?>">
                                            <?php echo $participant['First_Name']; ?>
                                            <?php echo $participant['Last_Name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetNotesValues();">Close</button>
                    </div>
                    <input type="hidden" class="form-control" name="meeting_id" id="meeting_id" value="<?php echo $meeting['id']; ?>">
                    <input type="hidden" class="form-control" name="notes_id" id="notes_id" value="">
                </div>
            </form>
        </div>
    </div>
    <div class="modal right fade" id="actions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="form popup-form" action="includes/meeting_actions_update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Follow Up Actions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetActionsValues();"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required">Description</label>
                                <textarea class="form-control" name="actions_description" id="actions_description" required value=""></textarea>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="required">Assigned To</label>
                                <select class="form-control" name="actions_speaker" id="actions_speaker" required>
                                    <option value="">Please Select</option>
                                    <option value="<?php echo $coordinatorInfo['Id_employee']; ?>">
                                        <?php echo $coordinatorInfo['First_Name']; ?>
                                        <?php echo $coordinatorInfo['Last_Name']; ?>
                                    </option>
                                    <?php foreach ($participantsData as $key => $participant) { ?>
                                        <option value="<?php echo $participant['participant_id']; ?>">
                                            <?php echo $participant['First_Name']; ?>
                                            <?php echo $participant['Last_Name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <label class="required">Target Date</label>
                                <input type="date" class="form-control" name="actions_target_date" id="actions_target_date" required min="" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetActionsValues();">Close</button>
                    </div>
                    <input type="hidden" class="form-control" name="meeting_id" id="meeting_id" value="<?php echo $meeting['id']; ?>">
                    <input type="hidden" class="form-control" name="actions_id" id="actions_id" value="">
                </div>
            </form>
        </div>
    </div>
    <div class="modal right fade" id="decisions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="form popup-form" action="includes/meeting_decisions_update.php" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header right-modal">
                        <h5 class="modal-title" id="staticBackdropLabel">Key Decisions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetDecisionsValues();"></button>
                    </div>
                    <div class="modal-body" style="overflow-y: scroll">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="required">Description</label>
                                <textarea class="form-control" name="decisions_description" id="decisions_description" required value=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" onclick="resetDecisionsValues();">Close</button>
                    </div>
                    <input type="hidden" class="form-control" name="meeting_id" id="meeting_id" value="<?php echo $meeting['id']; ?>">
                    <input type="hidden" class="form-control" name="decisions_id" id="decisions_id" value="">
                </div>
            </form>
        </div>
    </div>
</body>

</html>

</html>