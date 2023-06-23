<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$customer_complaint_id = $_POST["customer_complaint_id"];
		$complaint_id = $_POST["complaint_id"];
		$customer_id = $_POST["customer_id"];
		$customer_order_ref = $_POST["customer_order_ref"];
		$internal_order_ref = $_POST["internal_order_ref"];
		$item_no = $_POST["item_no"];
		$product_details = $_POST["product_details"];
		$nature_of_complaint_id = $_POST["nature_of_complaint_id"];
		$complaint_date = $_POST["complaint_date"];
		$phone = $_POST["phone"];
		$complaint_details = $_POST["complaint_details"];
		$details_of_solution = $_POST["details_of_solution"];
		$team_members = $_POST["team_members"];
		$existingFiles = $_POST["existingFiles"];
		
		$complaintUpdateSql = "UPDATE customer_complaints SET customer_id = '$customer_id', customer_order_ref = '$customer_order_ref', internal_order_ref = '$internal_order_ref', item_no = '$item_no', product_details = '$product_details', nature_of_complaint_id = '$nature_of_complaint_id', complaint_date = '$complaint_date', phone = '$phone', complaint_details = '$complaint_details', details_of_solution = '$details_of_solution' WHERE id = '$customer_complaint_id'";
		$complaintUpdateResult = mysqli_query($con, $complaintUpdateSql);

		$deleteFileSql = "UPDATE customer_complaint_files SET is_deleted = 1 WHERE customer_complaint_id = '$customer_complaint_id'";
		$deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
		foreach ($existingFiles as $key => $id) {
			$updateFileSql = "UPDATE customer_complaint_files SET is_deleted = 0 WHERE customer_complaint_id = '$customer_complaint_id' AND id = '$id'";
			$updateFileResult = mysqli_query($con, $updateFileSql);
		}
		if (!empty(array_filter($_FILES['files']['name']))) {
			$directory = "../complaints/" . $complaint_id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			foreach ($_FILES['files']['name'] as $key => $item) {
				if ($item) {
					$fileName = $_FILES["files"]["name"][$key];
					$targetFile = $directory . basename($fileName);
					$destinationFolder = $directory . "/" . $fileName;
					move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
					$filePath = "complaints/" . $complaint_id . "/" . $fileName;
					$addFileSql = "INSERT INTO customer_complaint_files (customer_complaint_id, file_path, file_name) VALUES ('$customer_complaint_id', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}

		$deleteTeamMembersSql = "UPDATE customer_complaint_d1_d2_team SET is_deleted = 1 WHERE customer_complaint_id = '$customer_complaint_id'";
		$deleteTeamMembersSqlResult = mysqli_query($con, $deleteTeamMembersSql);
		foreach ($team_members as $key => $memberId) {
			$isExists = "SELECT id FROM customer_complaint_d1_d2_team WHERE customer_complaint_id = '$customer_complaint_id' AND member_id = '$memberId'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$addMemberSql = "INSERT INTO customer_complaint_d1_d2_team (customer_complaint_id, member_id) VALUES ('$customer_complaint_id', '$memberId')";
				$addMemberSqlResult = mysqli_query($con, $addMemberSql);
			} else {
				$updateMemberSql = "UPDATE customer_complaint_d1_d2_team SET is_deleted = 0 WHERE customer_complaint_id = '$customer_complaint_id' AND member_id = '$memberId'";
				$updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../customer_complaint_edit.php?id=$customer_complaint_id");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
