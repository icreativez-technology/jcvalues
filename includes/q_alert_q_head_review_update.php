<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$qAlertId = $_POST["qAlertId"];
		$action_category_id = $_POST["action_category_id"];
		$detail_of_solution = $_POST["detail_of_solution"];
		$department_id = $_POST["department_id"];
		$owner = $_POST["owner"];
		$isExists = "SELECT id FROM q_alert_head_review WHERE q_alert_id = '$qAlertId'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
			$qHeadReviewAddSql = "INSERT INTO q_alert_head_review (q_alert_id, action_category_id, detail_of_solution, department_id, owner) VALUES ('$qAlertId', '$action_category_id', '$detail_of_solution', '$department_id', '$owner')";
			$qHeadReviewAddResult = mysqli_query($con, $qHeadReviewAddSql);
		} else {
			$qHeadReviewUpdateSql = "UPDATE q_alert_head_review SET action_category_id = '$action_category_id', detail_of_solution = '$detail_of_solution', department_id = '$department_id', owner = '$owner' WHERE q_alert_id = '$qAlertId'";
			$qHeadReviewUpdateResult = mysqli_query($con, $qHeadReviewUpdateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../q_alert_edit.php?id=$qAlertId&head");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
