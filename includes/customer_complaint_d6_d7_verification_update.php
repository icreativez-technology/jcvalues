<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$customer_complaint_id = $_POST["customer_complaint_id"];
		$ids = $_POST["ids"];
		$verifiedIds = $_POST["verifiedIds"];
		foreach ($ids as $key => $id) {
			$updateSql = "UPDATE customer_complaint_d4_corrective_action_plan SET verified = 0 WHERE id = '$id'";
			$updateResult = mysqli_query($con, $updateSql);
		}
		foreach ($verifiedIds as $key => $id) {
			$updateSql = "UPDATE customer_complaint_d4_corrective_action_plan SET verified = 1 WHERE id = '$id'";
			$updateResult = mysqli_query($con, $updateSql);
		}
		$sql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE customer_complaint_id = '$customer_complaint_id' AND is_deleted = 0 AND verified = '0'";
		$connectData = mysqli_query($con, $sql);
		if ($connectData->num_rows > 0) {
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../customer_complaint_edit.php?id=$customer_complaint_id&d6");
		} else {
			$updateSql = "UPDATE customer_complaints SET status = 'Closed' WHERE id = '$customer_complaint_id'";
			$updateResult = mysqli_query($con, $updateSql);
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../customer_complaint_edit.php?id=$customer_complaint_id&d8");
		}
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}