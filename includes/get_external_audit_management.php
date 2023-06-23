<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['audit_id'])) {
		$dataArr = array();
		$audit_id = $_POST['audit_id'];

		$sqlExternal = "SELECT external_and_customer_audits.audit_area, external_and_customer_audits.audit_standard, external_and_customer_audits.auditor, Basic_Department.Department as department FROM external_and_customer_audits LEFT JOIN Basic_Department ON external_and_customer_audits.department_id = Basic_Department.Id_department WHERE audit_id = '$audit_id' AND is_deleted = 0";
		$connectExternal = mysqli_query($con, $sqlExternal);
		$auditData = mysqli_fetch_assoc($connectExternal);

		$auditeeSqlData = "SELECT member_id, First_Name, Last_Name FROM external_and_customer_audit_assign_auditees LEFT JOIN Basic_Employee ON external_and_customer_audit_assign_auditees.member_id = Basic_Employee.Id_employee WHERE audit_id = '$audit_id' AND is_deleted = 0";
		$auditeeConnectData = mysqli_query($con, $auditeeSqlData);
		$auditeeData =  array();
		while ($row = mysqli_fetch_assoc($auditeeConnectData)) {
			array_push($auditeeData, $row);
		}

		$dataArr['auditData'] = $auditData;
		$dataArr['auditeeData'] = $auditeeData;

		echo json_encode($dataArr);
	}
}