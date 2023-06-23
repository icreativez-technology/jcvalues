<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $calibration_id = $_POST["calibration_id"];
        $calibration_history_id = $_POST["calibration_history_id"];
        $id = $_POST["calibration_receipt_id"];
        $receipted_date = $_POST["receipted_date"];
        $received_from = $_POST["received_from"];
        $received_for = $_POST["received_for"];
        $storage_location = $_POST["storage_location"];
        $instrument_condition = $_POST["instrument_condition"];
        $remarks = $_POST["remarks"];
        if ($id == "") {
            $addHistorySql = "INSERT INTO calibration_history (calibration_id, type) VALUES ('$calibration_id', 'Receipt')";
            $addHistoryResult = mysqli_query($con, $addHistorySql);
            $calibration_history_id = mysqli_insert_id($con);
            $updateSql = "UPDATE calibrations SET calibration_status = 'Receipt' WHERE id = '$calibration_id'";
            $updateSqlResult = mysqli_query($con, $updateSql);
            $addSql = "INSERT INTO calibration_receipt (calibration_history_id, receipted_date, received_from, received_for, storage_location, instrument_condition, remarks) VALUES ('$calibration_history_id', '$receipted_date', '$received_from', '$received_for', '$storage_location', '$instrument_condition', '$remarks')";
            $addResult = mysqli_query($con, $addSql);
            if (!empty(array_filter($_FILES['files']['name']))) {
                $directory = "../calibration_receipt/" . $calibration_history_id;
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                foreach ($_FILES['files']['name'] as $key => $item) {
                    if ($item) {
                        $fileName = $_FILES["files"]["name"][$key];
                        $targetFile = $directory . basename($fileName);
                        $destinationFolder = $directory . "/" . $fileName;
                        move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
                        $filePath = "calibration_receipt/" . $calibration_history_id . "/" . $fileName;
                        $addFileSql = "INSERT INTO calibration_receipt_files (calibration_history_id, file_path, file_name) VALUES ('$calibration_history_id', '$filePath', '$fileName')";
                        $addFileConnect = mysqli_query($con, $addFileSql);
                    }
                }
            }
        } else {
            $existingFiles = $_POST["existingFiles"];
            $updateSql = "UPDATE calibration_receipt SET receipted_date = '$receipted_date', received_from = '$received_from', received_for = '$received_for', storage_location = '$storage_location', instrument_condition = '$instrument_condition', remarks = '$remarks' WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
            $deleteFileSql = "UPDATE calibration_receipt_files SET is_deleted = 1 WHERE calibration_history_id = '$calibration_history_id'";
            $deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
            foreach ($existingFiles as $key => $id) {
                $updateFileSql = "UPDATE calibration_receipt_files SET is_deleted = 0 WHERE calibration_history_id = '$calibration_history_id' AND id = '$id'";
                $updateFileResult = mysqli_query($con, $updateFileSql);
            }
            if (!empty(array_filter($_FILES['files']['name']))) {
                $directory = "../calibration_receipt/" . $calibration_history_id;
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                foreach ($_FILES['files']['name'] as $key => $item) {
                    if ($item) {
                        $fileName = $_FILES["files"]["name"][$key];
                        $targetFile = $directory . basename($fileName);
                        $destinationFolder = $directory . "/" . $fileName;
                        move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
                        $filePath = "calibration_receipt/" . $calibration_history_id . "/" . $fileName;
                        $addFileSql = "INSERT INTO calibration_receipt_files (calibration_history_id, file_path, file_name) VALUES ('$calibration_history_id', '$filePath', '$fileName')";
                        $addFileConnect = mysqli_query($con, $addFileSql);
                    }
                }
            }
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