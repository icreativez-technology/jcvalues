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
		$moc_type_id = $_POST["moc_type_id"];
		$old_moc_ref_no = $_POST["old_moc_ref_no"];
		$std_procedure_ref = $_POST["std_procedure_ref"];
		$risk_assessment = $_POST["risk_assessment"];
		$current_state = $_POST["current_state"];
		$change_state = $_POST["change_state"];
		$description_of_change = $_POST["description_of_change"];
		$team_members = $_POST["team_members"];
		$prefix = "MOC-ID-";
		$mocIdSql = "SELECT quality_moc.moc_id FROM quality_moc order by id DESC LIMIT 1";
		$mocIdConnect = mysqli_query($con, $mocIdSql);
		$mocIdInfo = mysqli_fetch_assoc($mocIdConnect);
		$mocId = (isset($mocIdInfo['moc_id'])) ? $mocIdInfo['moc_id'] : null;
		$length = 4;
		if (!$mocId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($mocId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$moc_id = $prefix . $zeros . $last_number;
		$mocAddSql = "INSERT INTO quality_moc (moc_id, on_behalf_of, plant_id, product_group_id, department_id, moc_type_id, old_moc_ref_no, std_procedure_ref, risk_assessment, current_state, change_state, description_of_change, created_by) VALUES ('$moc_id', '$on_behalf_of', '$plant_id', '$product_group_id', '$department_id', '$moc_type_id', '$old_moc_ref_no', '$std_procedure_ref', '$risk_assessment', '$current_state', '$change_state', '$description_of_change', '$userId')";
		$mocAddResult = mysqli_query($con, $mocAddSql);
		$addedMocId = mysqli_insert_id($con);
		foreach ($team_members as $key => $memberId) {
			$addMemberSql = "INSERT INTO quality_moc_team_members (quality_moc_id, member_id) VALUES ('$addedMocId', '$memberId')";
			$addMemberSqlConnect = mysqli_query($con, $addMemberSql);
		}
		if (!empty(array_filter($_FILES['files']['name']))) {
			$directory = "../mocs/" . $moc_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			foreach ($_FILES['files']['name'] as $key => $item) {
				if ($item) {
					$fileName = $_FILES["files"]["name"][$key];
					$targetFile = $directory . basename($fileName);
					$destinationFolder = $directory . "/" . $fileName;
					move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
					$filePath = "mocs/" . $moc_id . "/" . $fileName;
					$addFileSql = "INSERT INTO quality_moc_files (quality_moc_id, file_path, file_name) VALUES ('$addedMocId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../quality-moc_view_list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
