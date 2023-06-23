<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$fetch = mysqli_query($con, $sql);
		$userInfo = mysqli_fetch_assoc($fetch);
		$created_by = $userInfo['Id_employee'];
		$audit_type = $_POST["audit_type"];
		$start_date = $_POST["start_date"];
		$end_date = $_POST["end_date"];
		$prefix = "";
		if ($audit_type == 'Internal') {
			$prefix = "INT-AUD-";
		} else if ($audit_type == 'External') {
			$prefix = "EXT-AUD-";
		}
		$uniqueIdSql = "SELECT audit_management_list.unique_id FROM audit_management_list WHERE audit_type = '$audit_type' order by id DESC LIMIT 1";
		$uniqueIdConnect = mysqli_query($con, $uniqueIdSql);
		$uniqueIdInfo = mysqli_fetch_assoc($uniqueIdConnect);
		$uniqueId = (isset($uniqueIdInfo['unique_id'])) ? $uniqueIdInfo['unique_id'] : null;
		$length = 4;
		if (!$uniqueId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($uniqueId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$unique_id = $prefix . $zeros . $last_number;
		$addSql = "INSERT INTO audit_management_list (audit_type, unique_id, start_date, end_date, created_by) VALUES ('$audit_type', '$unique_id', '$start_date', '$end_date', '$created_by')";
		$addResult = mysqli_query($con, $addSql);
		$audit_id = mysqli_insert_id($con);
		if ($audit_type == 'Internal') {
			$audit_area_id = $_POST["audit_area_id"];
			$finding_format_no = $_POST["finding_format_no"];
			$revision_no = $_POST["revision_no"];
			$addSql = "INSERT INTO internal_audits (audit_id, audit_area_id, finding_format_no, revision_no) VALUES ('$audit_id', '$audit_area_id', '$finding_format_no', '$revision_no')";
			$addResult = mysqli_query($con, $addSql);
		} else if ($audit_type == 'External') {
			$audit_area = $_POST["audit_area"];
			$audit_standard = $_POST["audit_standard"];
			$auditor = $_POST["auditor"];
			$department_id = $_POST["department_id"];
			$name_of_external_company = $_POST["name_of_external_company"];
			$auditee = $_POST["auditee"];
			$addSql = "INSERT INTO external_and_customer_audits (audit_id, audit_area, audit_standard, auditor, department_id, name_of_external_company) VALUES ('$audit_id', '$audit_area', '$audit_standard', '$auditor', '$department_id', '$name_of_external_company')";
			$addResult = mysqli_query($con, $addSql);
			foreach ($auditee as $key => $memberId) {
				$addMemberSql = "INSERT INTO external_and_customer_audit_assign_auditees (audit_id, member_id) VALUES ('$audit_id', '$memberId')";
				$addMemberSqlConnect = mysqli_query($con, $addMemberSql);
			}
		}

		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../audit_management.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}