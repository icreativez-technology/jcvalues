<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$mocId = $_POST["mocId"];
		$moc_id = $_POST["moc_id"];
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
		$existingFiles = $_POST["existingFiles"];
		$mocUpdateSql = "UPDATE quality_moc SET on_behalf_of = '$on_behalf_of', plant_id = '$plant_id', product_group_id = '$product_group_id', department_id = '$department_id', moc_type_id = '$moc_type_id', old_moc_ref_no = '$old_moc_ref_no', std_procedure_ref = '$std_procedure_ref', risk_assessment = '$risk_assessment', current_state = '$current_state', change_state = '$change_state', description_of_change = '$description_of_change' WHERE id = '$mocId'";
		$mocUpdateResult = mysqli_query($con, $mocUpdateSql);
		$deleteTeamMembersSql = "UPDATE quality_moc_team_members SET is_deleted = 1 WHERE quality_moc_id = '$mocId'";
		$deleteTeamMembersSqlResult = mysqli_query($con, $deleteTeamMembersSql);
		foreach ($team_members as $key => $memberId) {
			$isExists = "SELECT id FROM quality_moc_team_members WHERE quality_moc_id = '$mocId' AND member_id = '$memberId'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$addMemberSql = "INSERT INTO quality_moc_team_members (quality_moc_id, member_id) VALUES ('$mocId', '$memberId')";
				$addMemberSqlResult = mysqli_query($con, $addMemberSql);
			} else {
				$updateMemberSql = "UPDATE quality_moc_team_members SET is_deleted = 0 WHERE quality_moc_id = '$mocId' AND member_id = '$memberId'";
				$updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
			}
		}
		$deleteFileSql = "UPDATE quality_moc_files SET is_deleted = 1 WHERE quality_moc_id = '$mocId'";
		$deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
		foreach ($existingFiles as $key => $id) {
			$updateFileSql = "UPDATE quality_moc_files SET is_deleted = 0 WHERE quality_moc_id = '$mocId' AND id = '$id'";
			$updateFileResult = mysqli_query($con, $updateFileSql);
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
					$addFileSql = "INSERT INTO quality_moc_files (quality_moc_id, file_path, file_name) VALUES ('$mocId', '$filePath', '$fileName')";
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
