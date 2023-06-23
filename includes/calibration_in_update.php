<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$calibration_id = $_POST["calibration_id"];
		$calibration_history_id = $_POST["calibration_history_id"];
		$id = $_POST["calibration_in_id"];
		$received_on = $_POST["received_on"];
		$received_from = $_POST["received_from"];
		$instrument_condition = $_POST["instrument_condition"];
		$calibration_result = $_POST["calibration_result"];
		$calibration_done_on = $_POST["calibration_done_on"];
		$calibration_due_on = $_POST["calibration_due_on"];
		$doc_ref = $_POST["doc_ref"];
		$storage_location = $_POST["storage_location"];
		if ($id == "") {
			$addHistorySql = "INSERT INTO calibration_history (calibration_id, type) VALUES ('$calibration_id', 'Calibration In')";
			$addHistoryResult = mysqli_query($con, $addHistorySql);
			$calibration_history_id = mysqli_insert_id($con);
			$updateSql = "UPDATE calibrations SET calibration_status = 'In Store' WHERE id = '$calibration_id'";
			$updateSqlResult = mysqli_query($con, $updateSql);
			$directory = "../calibration_in/" . $calibration_history_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			$fileName = $_FILES["file"]["name"];
			$targetFile = $directory . basename($fileName);
			$destinationFolder = $directory . "/" . $fileName;
			move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
			$filePath = "calibration_in/" . $calibration_history_id . "/" . $fileName;
			$addSql = "INSERT INTO calibration_in (calibration_history_id, received_on, received_from, instrument_condition, calibration_result, calibration_done_on, calibration_due_on, doc_ref, storage_location, file_path, file_name) VALUES ('$calibration_history_id', '$received_on', '$received_from', '$instrument_condition', '$calibration_result', '$calibration_done_on', '$calibration_due_on', '$doc_ref', '$storage_location', '$filePath', '$fileName')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE calibration_in SET received_on = '$received_on', received_from = '$received_from', instrument_condition = '$instrument_condition', calibration_result = '$calibration_result', calibration_done_on = '$calibration_done_on', calibration_due_on = '$calibration_due_on', doc_ref = '$doc_ref', storage_location = '$storage_location' WHERE id = '$id'";
			$updateResult = mysqli_query($con, $updateSql);
			if ($_FILES['file']['name']) {
				$directory = "../calibration_in/" . $calibration_history_id;
				if (!file_exists($directory)) {
					mkdir($directory, 0777, true);
				}
				$fileName = $_FILES["file"]["name"];
				$targetFile = $directory . basename($fileName);
				$destinationFolder = $directory . "/" . $fileName;
				move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
				$filePath = "calibration_in/" . $calibration_history_id . "/" . $fileName;
				$updateSql = "UPDATE `calibration_in` SET `file_path` = '$filePath', `file_name` = '$fileName' WHERE (`id` = '$id')";
				$updateResult = mysqli_query($con, $updateSql);
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