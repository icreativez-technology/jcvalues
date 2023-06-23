<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST['id'];
        $calibration_id = $_POST['calibration_id'];
        $issue_date = $_POST["issue_date"];
        $department_id = $_POST["department_id"];
        $collected_by = $_POST["collected_by"];
        $type = "Issuance";
        if ($id == "") {
            $addSql = "INSERT INTO calibration_history (calibration_id, type) VALUES ('$calibration_id', '$type')";
            $addResult = mysqli_query($con, $addSql);
            $historyId = mysqli_insert_id($con);
            $updateSql = "UPDATE calibrations SET calibration_status = '$type' WHERE id = '$calibration_id'";
            $updateSqlResult = mysqli_query($con, $updateSql);
            if ($historyId != null) {
                $issuanceSql = "INSERT INTO calibration_issuance (calibration_history_id, issue_date, department_id,collected_by) VALUES ('$historyId', '$issue_date', '$department_id','$collected_by')";
                $issuanceResult = mysqli_query($con, $issuanceSql);
            }
        } else {
            $updateSql = "UPDATE calibration_issuance SET issue_date = '$issue_date', department_id = '$department_id', collected_by = '$collected_by' WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../calibration_edit.php?id=$calibration_id&history");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}
