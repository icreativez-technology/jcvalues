<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
		$dataArr = array();
		$startDate = $_POST['startDate'];
		$endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

		$departmentSqlData = "SELECT * FROM Basic_Department";
		$departmentConnectData = mysqli_query($con, $departmentSqlData);
		$departmentArr = array();
		while ($result_data = mysqli_fetch_assoc($departmentConnectData)) {
			array_push($departmentArr, $result_data);
		}
		$departmentDataArr = array();
		foreach ($departmentArr as $department) {
			$mocSql = "SELECT * FROM quality_moc WHERE department_id = '$department[Id_department]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$mocSqlConnect = mysqli_query($con, $mocSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($mocSqlConnect)) {
				array_push($newArr, $result_data);
			}
			$departmentDataArr[$department['Department']] = $newArr;
		}

		$qualityMocTypeSqlData = "SELECT * FROM Quality_MoC_Type";
		$qualityMocTypeSqlConnectData = mysqli_query($con, $qualityMocTypeSqlData);
		$qualityMocTypeArr = array();
		while ($result_data = mysqli_fetch_assoc($qualityMocTypeSqlConnectData)) {
			array_push($qualityMocTypeArr, $result_data);
		}
		$qualityMocArr = array();
		foreach ($qualityMocTypeArr as $qualityMocType) {
			$mocSql = "SELECT * FROM quality_moc WHERE moc_type_id = '$qualityMocType[Id_quality_moc_type]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$mocSqlConnect = mysqli_query($con, $mocSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($mocSqlConnect)) {
				array_push($newArr, $result_data);
			}
			$qualityMocArr[$qualityMocType['Title']] = $newArr;
		}

		$dataArr['department_result'] = $departmentDataArr;
		$dataArr['moc_type_result'] = $qualityMocArr;
		echo json_encode($dataArr);
	}
}