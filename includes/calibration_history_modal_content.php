<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'];
    $id = $_POST['id'];
    $calibration_id = $_POST['calibration_id'];
    $plant_id = $_POST['plant_id'];

    if ($type == 'Issuance') {
        $sqlData = "SELECT * FROM calibration_issuance WHERE calibration_history_id = '$id' AND is_deleted = 0";
        $connectData = mysqli_query($con, $sqlData);
        $calibrationData = mysqli_fetch_assoc($connectData);

        $sql = "SELECT * FROM Basic_Employee WHERE Id_plant = '$plant_id' AND Id_department = '$calibrationData[department_id]' AND Department_Head = 'Yes' LIMIT 1";
        $result = mysqli_query($con, $sql);
        $resultinfo = mysqli_fetch_assoc($result);
        $departmentHead = null;
        if ($resultinfo != null) {
            $departmentHead = $resultinfo['First_Name'] . " " . $resultinfo['Last_Name'];
        }

        echo '<form class="form" id="issuance-form" action="/includes/calibration_issuance_update.php" method="post">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title right-modal text-white">Issuance</h5>
                <button type="button" class="btn btn-close btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <input type="hidden" name="id" value="' . $calibrationData['id'] . '"/>
                <input type="hidden" name="calibration_id" id="calibration_id" value="' . $calibration_id . '"/>
            <input type="hidden" name="plantId" id="plantId" value="' . $plant_id . '" />
            <div class="row">
            <div class="col-md-12 mt-4">
                <label class="required">Issue Date</label>
                <input type="date" class="form-control" name="issue_date" value="' . $calibrationData['issue_date'] . '" required />
            </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4">
        <label class="required">Department</label>
        <select class="form-control" name="department_id" id="department" required>
            <option value="">Please Select</option>';
        $sql_data = "SELECT * FROM Basic_Plant_Deparment INNER JOIN Basic_Department ON Basic_Plant_Deparment.Id_department = Basic_Department.Id_department WHERE Id_plant = '$plant_id'";
        $connect_data = mysqli_query($con, $sql_data);
        while ($result_data = mysqli_fetch_assoc($connect_data)) {
            $selected = ($calibrationData['department_id'] == $result_data['Id_department']) ? "selected" : "";
            echo '<option value="' . $result_data['Id_department'] . '"' . $selected . '>' . $result_data['Department'] . '</option>';
        }
        echo '</select>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4 ver-disabled">
                <label class="required">Owner</label>
                <input type="text" class="form-control" id="owner" name="owner"  value="' . $departmentHead . '" readonly required />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4">
                <label class="required">Collected by</label>
                <input type="text" name="collected_by" class="form-control" value="' . $calibrationData['collected_by'] . '"required>
            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-success">Save</button>
            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </form>';
    }
}
