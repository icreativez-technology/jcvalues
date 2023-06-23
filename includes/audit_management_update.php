<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$audit_id = $_POST["id"];
		$audit_type = $_POST["audit_type"];
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$updateSql = "UPDATE audit_management_list SET start_date = '$start_date', end_date = '$end_date' WHERE id = '$audit_id'";
		$updateResult = mysqli_query($con, $updateSql);
		if ($audit_type == 'Internal') {
			$audit_area_id = $_POST["audit_area_id"];
			$finding_format_no = $_POST["finding_format_no"];
			$revision_no = $_POST["revision_no"];
			$updateSql = "UPDATE internal_audits SET audit_area_id = '$audit_area_id', finding_format_no = '$finding_format_no', revision_no = '$revision_no' WHERE audit_id = '$audit_id'";
			$updateResult = mysqli_query($con, $updateSql);
		} else if ($audit_type == 'External') {
			$audit_area = $_POST["audit_area"];
			$audit_standard = $_POST["audit_standard"];
			$auditor = $_POST["auditor"];
			$department_id = $_POST["department_id"];
			$name_of_external_company = $_POST["name_of_external_company"];
			$auditee = $_POST["auditee"];
			$updateSql = "UPDATE external_and_customer_audits SET audit_area = '$audit_area', audit_standard = '$audit_standard', auditor = '$auditor', department_id = '$department_id', name_of_external_company = '$name_of_external_company' WHERE audit_id = '$audit_id'";
			$updateResult = mysqli_query($con, $updateSql);
			$deleteMembersSql = "UPDATE external_and_customer_audit_assign_auditees SET is_deleted = 1 WHERE audit_id = '$audit_id'";
			$deleteMembersSqlResult = mysqli_query($con, $deleteMembersSql);
			foreach ($auditee as $key => $memberId) {
				$isExists = "SELECT id FROM external_and_customer_audit_assign_auditees WHERE audit_id = '$audit_id' AND member_id = '$memberId'";
				$result = mysqli_query($con, $isExists);
				if ($result->num_rows == 0) {
					$addMemberSql = "INSERT INTO external_and_customer_audit_assign_auditees (audit_id, member_id) VALUES ('$audit_id', '$memberId')";
					$addMemberSqlResult = mysqli_query($con, $addMemberSql);
				} else {
					$updateMemberSql = "UPDATE external_and_customer_audit_assign_auditees SET is_deleted = 0 WHERE audit_id = '$audit_id' AND member_id = '$memberId'";
					$updateMemberSqlResult = mysqli_query($con, $updateMemberSql);
				}
			}
		}
		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../audit_management.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
