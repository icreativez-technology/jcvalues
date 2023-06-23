<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$riskId = $_POST["riskId"];
		$risk_id = $_POST["risk_id"];
		$on_behalf_of = $_POST["on_behalf_of"];
		$plant_id = $_POST["plant_id"];
		$product_group_id = $_POST["product_group_id"];
		$department_id = $_POST["department_id"];
		$process_id = $_POST["process_id"];
		$risk_type_id = $_POST["risk_type_id"];
		$source_of_risk_id = $_POST["source_of_risk_id"];
		$impact_area_id = $_POST["impact_area_id"];
		$description = $_POST["description"];
		$severity = $_POST["severity"];
		$occurance = $_POST["occurance"];
		$detection = $_POST["detection"];
		$rpn_value = $_POST["rpn_value"];
		$existingFiles = $_POST["existingFiles"];
		$riskUpdateSql = "UPDATE quality_risk SET on_behalf_of = '$on_behalf_of', plant_id = '$plant_id', product_group_id = '$product_group_id', department_id = '$department_id', process_id = '$process_id', risk_type_id = '$risk_type_id', source_of_risk_id = '$source_of_risk_id', impact_area_id = '$impact_area_id', description = '$description', severity = '$severity', occurance = '$occurance', detection = '$detection', rpn_value = '$rpn_value'  WHERE id = '$riskId'";
		$riskUpdateResult = mysqli_query($con, $riskUpdateSql);
		$deleteFileSql = "UPDATE quality_risk_files SET is_deleted = 1 WHERE quality_risk_id = '$riskId'";
		$deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
		foreach ($existingFiles as $key => $id) {
			$updateFileSql = "UPDATE quality_risk_files SET is_deleted = 0 WHERE quality_risk_id = '$riskId' AND id = '$id'";
			$updateFileResult = mysqli_query($con, $updateFileSql);
		}
		if (!empty(array_filter($_FILES['files']['name']))) {
			$directory = "../risks/" . $risk_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			foreach ($_FILES['files']['name'] as $key => $item) {
				if ($item) {
					$fileName = $_FILES["files"]["name"][$key];
					$targetFile = $directory . basename($fileName);
					$destinationFolder = $directory . "/" . $fileName;
					move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
					$filePath = "risks/" . $risk_id . "/" . $fileName;
					$addFileSql = "INSERT INTO quality_risk_files (quality_risk_id, file_path, file_name) VALUES ('$riskId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../quality-risk-view-list.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
