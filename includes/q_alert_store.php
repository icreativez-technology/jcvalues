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
		$prefix = "QAL-";
		$qAlertIdSql = "SELECT q_alert.q_alert_id FROM q_alert order by id DESC LIMIT 1";
		$qAlertIdConnect = mysqli_query($con, $qAlertIdSql);
		$qAlertIdInfo = mysqli_fetch_assoc($qAlertIdConnect);
		$qAlertId = (isset($qAlertIdInfo['q_alert_id'])) ? $qAlertIdInfo['q_alert_id'] : null;
		$length = 6;
		if (!$qAlertId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($qAlertId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$q_alert_id = $prefix . $zeros . $last_number;
		$qAlertAddSql = "INSERT INTO q_alert (q_alert_id, on_behalf_of, plant_id, product_group_id, department_id, area_process_id, nature_of_obs_id, date, shift, obs_details, action_category_id, detail_of_solution, created_by) VALUES ('$q_alert_id', '$on_behalf_of', '$plant_id', '$product_group_id', '$department_id', '$area_process_id', '$nature_of_obs_id', '$date', '$shift', '$obs_details', '$action_category_id', '$detail_of_solution', '$userId')";
		$qAlertAddResult = mysqli_query($con, $qAlertAddSql);
		$addedQAlertId = mysqli_insert_id($con);
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
					$addFileSql = "INSERT INTO q_alert_files (q_alert_id, file_path, file_name) VALUES ('$addedQAlertId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../q_alert_view_list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
