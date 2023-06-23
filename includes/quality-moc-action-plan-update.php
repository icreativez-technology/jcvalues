<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$quality_moc_id = $_POST["quality_moc_id"];
		if (isset($_POST["decision"]) && isset($_POST["decision_remarks"])) {
			$decision = $_POST["decision"];
			$mocStatus = "Open";
			if ($decision == 1) {
				$mocStatus = "Approved";
			} else if ($decision == 2) {
				$mocStatus = "Rejected";
			}
			$decision_remarks = $_POST["decision_remarks"];
			$approvalUpdateSql = "UPDATE quality_moc SET status = '$mocStatus', decision = '$decision', decision_remarks = '$decision_remarks' WHERE id = '$quality_moc_id'";
			$approvalUpdateResult = mysqli_query($con, $approvalUpdateSql);
		}
		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../quality-moc_view_list.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}