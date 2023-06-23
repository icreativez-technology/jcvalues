<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$audit_standard = $_POST["audit_standard"];
	$auditors = $_POST["auditors"];
	$isExists = "SELECT id FROM admin_audit_standard WHERE audit_standard = '$audit_standard' AND is_deleted = 0";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$email = $_SESSION['usuario'];
			$sql = "SELECT * From Basic_Employee Where Email = '$email'";
			$fetch = mysqli_query($con, $sql);
			$userInfo = mysqli_fetch_assoc($fetch);
			$userId = $userInfo['Id_employee'];
			$sqlAdd = "INSERT INTO admin_audit_standard (audit_standard, created_by) VALUES ('$audit_standard', '$userId')";
			$result = mysqli_query($con, $sqlAdd);
			$addedId = mysqli_insert_id($con);
			foreach ($auditors as $key => $memberId) {
				$addMemberSql = "INSERT INTO admin_audit_standard_auditors (admin_audit_standard_id, member_id) VALUES ('$addedId', '$memberId')";
				$addMemberSqlConnect = mysqli_query($con, $addMemberSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../admin_audit_standard.php");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../admin_audit_standard_add.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}