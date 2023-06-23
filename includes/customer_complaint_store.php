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
		$prefix = "COMP-";
		$complaintIdSql = "SELECT complaint_id FROM customer_complaints order by id DESC LIMIT 1";
		$complaintIdConnect = mysqli_query($con, $complaintIdSql);
		$complaintIdInfo = mysqli_fetch_assoc($complaintIdConnect);
		$complaintId = (isset($complaintIdInfo['complaint_id'])) ? $complaintIdInfo['complaint_id'] : null;
		$length = 4;
		if (!$complaintId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($complaintId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$complaint_id = $prefix . $zeros . $last_number;
		$complaintAddSql = "INSERT INTO customer_complaints (complaint_id, customer_id, customer_order_ref, internal_order_ref, item_no, product_details, nature_of_complaint_id, complaint_date, phone, complaint_details, details_of_solution, created_by) VALUES ('$complaint_id', '$customer_id', '$customer_order_ref', '$internal_order_ref', '$item_no', '$product_details', '$nature_of_complaint_id', '$complaint_date', '$phone', '$complaint_details', '$details_of_solution', '$userId')";
		$complaintAddResult = mysqli_query($con, $complaintAddSql);
		$addedComplaintId = mysqli_insert_id($con);
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
					$addFileSql = "INSERT INTO customer_complaint_files (customer_complaint_id, file_path, file_name) VALUES ('$addedComplaintId', '$filePath', '$fileName')";
					$addFileConnect = mysqli_query($con, $addFileSql);
				}
			}
		}
		foreach ($team_members as $key => $memberId) {
			$addMemberSql = "INSERT INTO customer_complaint_d1_d2_team (customer_complaint_id, member_id) VALUES ('$addedComplaintId', '$memberId')";
			$addMemberSqlConnect = mysqli_query($con, $addMemberSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../customer_complaint_view_list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
