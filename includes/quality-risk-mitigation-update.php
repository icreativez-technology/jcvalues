<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$quality_risk_id = $_POST["quality_risk_id"];
		$revised_severity = $_POST["revised_severity"];
		$revised_occurance = $_POST["revised_occurance"];
		$revised_detection = $_POST["revised_detection"];
		$revised_rpn_value = $_POST["revised_rpn_value"];
		$isExists = "SELECT id FROM quality_risk_revised_assessment WHERE quality_risk_id = '$quality_risk_id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
			$revisedRiskAddSql = "INSERT INTO quality_risk_revised_assessment (quality_risk_id, revised_severity, revised_occurance, revised_detection, revised_rpn_value) VALUES ('$quality_risk_id', '$revised_severity', '$revised_occurance', '$revised_detection', '$revised_rpn_value')";
			$riskAddResult = mysqli_query($con, $revisedRiskAddSql);
		} else {
			$revisedRiskUpdateSql = "UPDATE quality_risk_revised_assessment SET revised_severity = '$revised_severity', revised_occurance = '$revised_occurance', revised_detection = '$revised_detection', revised_rpn_value = '$revised_rpn_value' WHERE quality_risk_id = '$quality_risk_id'";
			$revisedRiskUpdateResult = mysqli_query($con, $revisedRiskUpdateSql);
		}
		if (isset($_POST["decision"]) && isset($_POST["decision_remarks"])) {
			$decision = $_POST["decision"];
			$decision_remarks = $_POST["decision_remarks"];
			$isExists = "SELECT id FROM quality_risk_approval WHERE quality_risk_id = '$quality_risk_id'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$approvalAddSql = "INSERT INTO quality_risk_approval (quality_risk_id, decision, decision_remarks) VALUES ('$quality_risk_id', '$decision', '$decision_remarks')";
				$approvalResult = mysqli_query($con, $approvalAddSql);
			} else {
				$approvalUpdateSql = "UPDATE quality_risk_approval SET decision = '$decision', decision_remarks = '$decision_remarks' WHERE quality_risk_id = '$quality_risk_id'";
				$approvalUpdateResult = mysqli_query($con, $approvalUpdateSql);
			}
			$riskStatus = ($decision == 1) ? "Approved" : "Rejected";
			$updateRiskSql = "UPDATE quality_risk SET status = '$riskStatus' WHERE id = '$quality_risk_id'";
			$updateRiskSqlResult = mysqli_query($con, $updateRiskSql);
		}
		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../quality-risk-view-list.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
