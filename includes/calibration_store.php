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
		$isExistsSql = "SELECT * FROM calibrations WHERE instrument_id = '$instrument_id' AND is_deleted = 0";
		$isExists = mysqli_query($con, $isExistsSql);
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
			$directory = "../calibrations/" . $instrument_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			$fileName = $_FILES["file"]["name"];
			$targetFile = $directory . basename($fileName);
			$destinationFolder = $directory . "/" . $fileName;
			move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
			$filePath = "calibrations/" . $instrument_id . "/" . $fileName;
			$addSql = "INSERT INTO calibrations (instrument_id, serial_no, instrument_name, make, model_no, date_of_purchase, supplier_name, specification, least_count, calibration_done_on, calibration_frequency, calibration_due_on, storage_location, usage_condition, created_by, calibration_status, file_path, file_name, asset_type) VALUES ('$instrument_id', '$serial_no', '$instrument_name', '$make', '$model_no', '$date_of_purchase', '$supplier_name', '$specification', '$least_count', '$calibration_done_on', '$calibration_frequency', '$calibration_due_on', '$storage_location', '$usage_condition', '$userId', 'In Store', '$filePath', '$fileName', '$asset_type')";
			$addResult = mysqli_query($con, $addSql);
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../calibration_view_list.php");
		} else {
			header("Location: ../calibration_add.php?exist");
		}
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
