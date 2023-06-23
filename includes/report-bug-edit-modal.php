<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $sql = "SELECT * From report_bug WHERE id = '$id'";
    $fetch = mysqli_query($con, $sql);
    $resultData = mysqli_fetch_assoc($fetch);

    $employeeSql = "SELECT * From Basic_Employee Where Id_employee = '$resultData[created_by]'";
    $fetch = mysqli_query($con, $employeeSql);
    $userInfo = mysqli_fetch_assoc($fetch);
    $firstName = $userInfo['First_Name'];
    $lastName = $userInfo['Last_Name'];

    switch ($resultData['issue_type']) {
        case '1':
            $issueOption = '<option value="">Please Select</option>
            <option value="1" selected>UI</option>
          <option value="2">Functionality</option>
        <option value="3">Hotfix</option>';
            break;
        case '2':
            $issueOption = '<option value="">Please Select</option>
            <option value="1">UI</option>
          <option value="2" selected>Functionality</option>
        <option value="3">Hotfix</option>';
            break;
        case '3':
            $issueOption = '<option value="">Please Select</option>
            <option value="1" selected>UI</option>
        <option value="2">Functionality</option>
      <option value="3" selected>Hotfix</option>';
            break;
        default:
            $issueOption = '<option value="">Please Select</option>
            <option value="1">UI</option>
        <option value="2">Functionality</option>
      <option value="3" selected>Hotfix</option>';
            break;
    };

    switch ($resultData['priority']) {
        case '1':
            $priorityOption = '<option value="">Please Select</option>
            <option value="1" selected >High</option>
        <option value="2">Medium</option>
        <option value="3">Low</option>';
            break;
        case '2':
            $priorityOption = '<option value="">Please Select</option>
            <option value="1">High</option>
        <option value="2" selected>Medium</option>
        <option value="3">Low</option>';
            break;
        case '3':
            $priorityOption = '<option value="">Please Select</option>
            <option value="1">High</option>
        <option value="2">Medium</option>
        <option value="3" selected>Low</option>';
            break;
        default:
            $priorityOption = '
            <option value="">Please Select</option>
            <option value="1">High</option>
        <option value="2">Medium</option>
        <option value="3">Low</option>';
            break;
    };

    switch ($resultData['status']) {
        case '1':
            $statusOption = '<option value="1" selected>Open</option>
        <option value="0">Closed</option>';
            break;
        case '0':
            $statusOption = '<option value="1">Open</option>
        <option value="0" selected>Closed</option>';
            break;
        default:
            $statusOption = '<option value="">Please Select</option>
            <option value="1">Open</option>
        <option value="0">Closed</option>';
            break;
    };

    $fileSql = "SELECT file_path FROM report_bug_screenshots WHERE report_bug_id = '$id' AND is_deleted = 0";
    $fileConnectData = mysqli_query($con, $fileSql);
    $fileInfo = array();
    while ($row = mysqli_fetch_assoc($fileConnectData)) {
        array_push($fileInfo, $row);
    }
    echo '<input type="hidden" name="id" value="' . $id . '" readonly>
    <div class="row mt-2">
            <div class="col-md-12">
                <label>Reported By</label>
                <input type="text" class="form-control" value="' . $firstName . " " . $lastName . '" name="created_by"
                    disabled required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label>Issue Number</label>
                <input type="text" class="form-control" value="' . $resultData['issue_number'] . '" name="issue-number"
                    disabled required>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="required">Issue Description</label>
                <textarea type="text" class="form-control" name="issue_description"
                    value="' . $resultData['issue_description'] . '" rows="4" required>' . $resultData['issue_description'] . '</textarea>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="required">Type</label>
                <select class="form-control" name="issue-type" required>';
    echo $issueOption;
    echo '</select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="required">Priority</label>
                <select class="form-control" name="priority" required>';
    echo $priorityOption;
    echo '</div>
</div>
<div class="row mt-2">
<div class="col-md-12">
    <input type="hidden" id="deleted-file" name="deleted-file" value="">
    <div class="form-group view-pdf mt-2" id="screenshots">
        <label>Screen Shots</label>
        <input type="file" name="files[]" accept="image/*" id="original-file" style="display:none ;"onchange="uploadFile(this)"multiple>
        <a class="icon-delete" id="icon-delete"><i class="bi bi-trash" style="color:#009ef7"></i></a>
        <label class="icon-upload" for="original-file"><i class="fa fa-upload" style="color:#009ef7"></i></label>
        <a class="icon-view" id="icon-view" href="" target="_blank"><i class="fa fa-eye" style="color:#009ef7"></i></a>
        <select class="form-control" id="file-view" required>
            <option class="placeholder">Please select </option>';
    foreach ($fileInfo as $row => $item) {
        echo '<option value="' . $item['file_path'] . '">';
        echo basename($item['file_path'], ".png, .jpeg, .jpg") . PHP_EOL;

        echo '</option>';
    }
    echo '</select>
</div>
</div>
</div>';
} else {
    echo "<script type='text/javascript'>
    alert('Try again');
    </script>";
}
