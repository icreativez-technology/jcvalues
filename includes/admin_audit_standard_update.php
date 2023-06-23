<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$audit_standard = $_POST["audit_standard"];
	$auditors = $_POST["auditors"];
	$isExists = "SELECT id FROM admin_audit_standard WHERE audit_standard = '$audit_standard' AND id != '$id' AND is_deleted = 0";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE admin_audit_standard SET audit_standard = '$audit_standard' WHERE id = '$id'";
		$result = mysqli_query($con, $updateSql);
		$deleteMembersSql = "UPDATE admin_audit_standard_auditors SET is_deleted = 1 WHERE admin_audit_standard_id = '$id'";
		$deleteMembersSqlResult = mysqli_query($con, $deleteMembersSql);
		foreach ($auditors as $key => $memberId) {
			$isExists = "SELECT id FROM admin_audit_standard_auditors WHERE admin_audit_standard_id = '$id' AND member_id = '$memberId'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$addMemberSql = "INSERT INTO admin_audit_standard_auditors (admin_audit_standard_id, member_id) VALUES ('$id', '$memberId')";
				$addMemberSqlResult = mysqli_query($con, $addMemberSql);
			} else {
				$updateMemberSql = "UPDATE admin_audit_standard_auditors SET is_deleted = 0 WHERE admin_audit_standard_id = '$id' AND member_id = '$memberId'";
				$updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../admin_audit_standard.php");
	} else {
		header("Location: ../admin_audit_standard_edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}