<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
		$dataArr = array();
		$startDate = $_POST['startDate'];
		$endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

		$processSqlData = "SELECT * FROM area_process";
		$processConnectData = mysqli_query($con, $processSqlData);
		$processArr = array();
		while ($result_data = mysqli_fetch_assoc($processConnectData)) {
			array_push($processArr, $result_data);
		}
		$processDataArr = array();
		foreach ($processArr as $process) {
			$processSql = "SELECT * FROM q_alert WHERE area_process_id = '$process[id]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$processSqlConnect = mysqli_query($con, $processSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($processSqlConnect)) {
				array_push($newArr, $result_data);
			}
			$processDataArr[$process['title']] = $newArr;
		}

		$monthDataArr = array();
		$monthDataArr['Closed'] = array();
		$monthDataArr['Open'] = array();

		$monthSql = "SELECT status, created_at FROM q_alert WHERE created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
		$monthSqlConnect = mysqli_query($con, $monthSql);
		while ($result_data = mysqli_fetch_assoc($monthSqlConnect)) {
			array_push($monthDataArr[$result_data['status']], $result_data);
		}

		$dataArr['process_result'] = $processDataArr;
		$dataArr['month_result'] = $monthDataArr;

		echo json_encode($dataArr);
	}
}