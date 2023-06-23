<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $email = $_SESSION['usuario'];
        $sql = "SELECT * From Basic_Employee Where Email = '$email'";
        $fetch = mysqli_query($con, $sql);
        $userInfo = mysqli_fetch_assoc($fetch);
        $userId = $userInfo['Id_employee'];
        $instrument_id = $_POST["instrument_id"];
        $isExistsSql = "SELECT * FROM calibrations WHERE instrument_id = '$instrument_id' AND is_deleted = 0 AND id != '$_POST[calibration_id]'";
        $isExists = mysqli_query($con, $isExistsSql);
        $calibration_id = $_POST["calibration_id"];
        if ($isExists->num_rows == 0) {
            $serial_no = $_POST["serial_no"];
            $instrument_name = $_POST["instrument_name"];
            $make = $_POST["make"];
            $model_no = $_POST["model_no"];
            $date_of_purchase = $_POST["date_of_purchase"];
            $supplier_name = $_POST["supplier_name"];
            $specification = $_POST["specification"];
            $least_count = $_POST["least_count"];
            $calibration_done_on = $_POST["calibration_done_on"];
            $calibration_frequency = $_POST["calibration_frequency"];
            $calibration_due_on = $_POST["calibration_due_on"];
            $storage_location = $_POST["storage_location"];
            $usage_condition = $_POST["usage_condition"];
            $asset_type = $_POST["asset_type"];
            $updateSql = "UPDATE `calibrations` SET `asset_type` = '$asset_type', `instrument_id` = '$instrument_id', `serial_no` = '$serial_no', `instrument_name` = '$instrument_name', `make` = '$make', `model_no` = '$model_no', `date_of_purchase` = '$date_of_purchase', `supplier_name` = '$supplier_name', `specification` = '$specification', `least_count` = '$least_count', `calibration_done_on` = '$calibration_done_on', `calibration_frequency` = '$calibration_frequency', `calibration_due_on` = '$calibration_due_on', `storage_location` = '$storage_location', `usage_condition` = '$usage_condition', `status` = 'Active' WHERE (`id` = '$calibration_id')";
            $updateResult = mysqli_query($con, $updateSql);
            if ($_FILES['file']['name']) {
                $directory = "../calibrations/" . $instrument_id;
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $fileName = $_FILES["file"]["name"];
                $targetFile = $directory . basename($fileName);
                $destinationFolder = $directory . "/" . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
                $filePath = "calibrations/" . $instrument_id . "/" . $fileName;
                $updateSql = "UPDATE `calibrations` SET `file_path` = '$filePath', `file_name` = '$fileName' WHERE (`id` = '$calibration_id')";
                $updateResult = mysqli_query($con, $updateSql);
            }
            echo "<script type='text/javascript'>alert('Success!');</script>";
            header("Location: ../calibration_edit.php?id=$calibration_id");
        } else {
            header("Location: ../calibration_edit.php?id=$calibration_id&exist");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}
