<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$customer_complaint_id = $_POST["customer_complaint_id"];
		$id = $_POST["id"];
		$category = $_POST["category"];
		$cause = $_POST["cause"];
		$significant = isset($_POST["significant"]) && $_POST["significant"] != "" ? 1 : 0;
		if ($id == "") {
			$addSql = "INSERT INTO customer_complaint_d4_cause_analysis (customer_complaint_id, category, cause, significant) VALUES ('$customer_complaint_id', '$category', '$cause', '$significant')";
			$addResult = mysqli_query($con, $addSql);
			$rowId = mysqli_insert_id($con);
			if ($significant == '1') {
				$whyAddSql = "INSERT INTO customer_complaint_d4_why_analysis (customer_complaint_id, customer_complaint_d4_cause_analysis_id) VALUES ('$customer_complaint_id', '$rowId')";
				$whyAddResult = mysqli_query($con, $whyAddSql);
			}
		} else {
			$updateSql = "UPDATE customer_complaint_d4_cause_analysis SET category = '$category', cause = '$cause', significant = '$significant' WHERE id = '$id'";
			$updateResult = mysqli_query($con, $updateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../customer_complaint_edit.php?id=$customer_complaint_id&d4");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}