<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$q_alert_id = $_POST["q_alert_id"];
		$id = $_POST["id"];
		$root_cause = $_POST["root_cause"];
		$corrective_action = $_POST["corrective_action"];
		$who = $_POST["who"];
		$date = $_POST["date"];
		$how = $_POST["how"];
		$moc = isset($_POST["moc"]) && $_POST["moc"] != "" ? 1 : 0;
		$risk_assessment = isset($_POST["risk_assessment"]) && $_POST["risk_assessment"] != "" ? 1 : 0;
		$status = $_POST["status"];
		if ($id == "") {
			$correctiveActionAddSql = "INSERT INTO q_alert_corrective_action (q_alert_id, root_cause, corrective_action, who, date, how, moc, risk_assessment, status) VALUES ('$q_alert_id', '$root_cause', '$corrective_action', '$who', '$date', '$how', '$moc', '$risk_assessment', '$status')";
			$correctiveActionAddResult = mysqli_query($con, $correctiveActionAddSql);
		} else {
			$correctiveActionUpdateSql = "UPDATE q_alert_corrective_action SET root_cause = '$root_cause', corrective_action = '$corrective_action', who = '$who', date = '$date', how = '$how', moc = '$moc', risk_assessment = '$risk_assessment', status = '$status' WHERE id = '$id'";
			$correctiveActionUpdateResult = mysqli_query($con, $correctiveActionUpdateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../q_alert_edit.php?id=$q_alert_id&action");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
