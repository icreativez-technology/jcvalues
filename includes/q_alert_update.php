<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$qAlertId = $_POST["qAlertId"];
		$q_alert_id = $_POST["q_alert_id"];
		$on_behalf_of = $_POST["on_behalf_of"];
		$plant_id = $_POST["plant_id"];
		$product_group_id = $_POST["product_group_id"];
		$department_id = $_POST["department_id"];
		$area_process_id = $_POST["area_process_id"];
		$nature_of_obs_id = $_POST["nature_of_obs_id"];
		$date = $_POST["date"];
		$shift = $_POST["shift"];
		$obs_details = $_POST["obs_details"];
		$action_category_id = $_POST["action_category_id"];
		$detail_of_solution = $_POST["detail_of_solution"];
		$existingFiles = $_POST["existingFiles"];
		$qAlertUpdateSql = "UPDATE q_alert SET on_behalf_of = '$on_behalf_of', plant_id = '$plant_id', product_group_id = '$product_group_id', department_id = '$department_id', area_process_id = '$area_process_id', nature_of_obs_id = '$nature_of_obs_id', date = '$date', shift = '$shift', obs_details = '$obs_details', action_category_id = '$action_category_id', detail_of_solution = '$detail_of_solution' WHERE id = '$qAlertId'";
		$qAlertUpdateResult = mysqli_query($con, $qAlertUpdateSql);
		$deleteFileSql = "UPDATE q_alert_files SET is_deleted = 1 WHERE q_alert_id = '$qAlertId'";
		$deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
		foreach ($existingFiles as $key => $id) {
			$updateFileSql = "UPDATE q_alert_files SET is_deleted = 0 WHERE q_alert_id = '$qAlertId' AND id = '$id'";
			$updateFileResult = mysqli_query($con, $updateFileSql);
		}
		if (!empty(array_filter($_FILES['files']['name']))) {
			$directory = "../q-alerts/" . $q_alert_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			foreach ($_FILES['files']['name'] as $key => $item) {
				if ($item) {
					$fileName = $_FILES["files"]["name"][$key];
					$targetFile = $directory . basename($fileName);
					$destinationFolder = $directory . "/" . $fileName;
					move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
					$filePath = "q-alerts/" . $q_alert_id . "/" . $fileName;
					$addFileSql = "INSERT INTO q_alert_files (q_alert_id, file_path, file_name) VALUES ('$qAlertId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../q_alert_edit.php?id=$qAlertId");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
