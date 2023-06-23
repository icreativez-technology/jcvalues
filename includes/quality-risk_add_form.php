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
		$process_id = $_POST["process_id"];
		$risk_type_id = $_POST["risk_type_id"];
		$source_of_risk_id = $_POST["source_of_risk_id"];
		$impact_area_id = $_POST["impact_area_id"];
		$description = $_POST["description"];
		$severity = $_POST["severity"];
		$occurance = $_POST["occurance"];
		$detection = $_POST["detection"];
		$rpn_value = $_POST["rpn_value"];
		$prefix = "RISK-ID-";
		$riskIdSql = "SELECT quality_risk.risk_id FROM quality_risk order by id DESC LIMIT 1";
		$riskIdConnect = mysqli_query($con, $riskIdSql);
		$riskIdInfo = mysqli_fetch_assoc($riskIdConnect);
		$riskId = (isset($riskIdInfo['risk_id'])) ? $riskIdInfo['risk_id'] : null;
		$length = 4;
		if (!$riskId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($riskId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$risk_id = $prefix . $zeros . $last_number;
		$riskAddSql = "INSERT INTO quality_risk (risk_id, on_behalf_of, plant_id, product_group_id, department_id, process_id, risk_type_id, source_of_risk_id, impact_area_id, description, severity, occurance, detection, rpn_value, created_by) VALUES ('$risk_id', '$on_behalf_of', '$plant_id', '$product_group_id', '$department_id', '$process_id', '$risk_type_id', '$source_of_risk_id', '$impact_area_id', '$description', '$severity', '$occurance', '$detection', '$rpn_value', '$userId')";
		$riskAddResult = mysqli_query($con, $riskAddSql);
		$addedRiskId = mysqli_insert_id($con);
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
					$addFileSql = "INSERT INTO quality_risk_files (quality_risk_id, file_path, file_name) VALUES ('$addedRiskId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../quality-risk-view-list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
