<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
		$dataArr = array();
		$startDate = $_POST['startDate'];
		$endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

		$focusAreaSqlData = "SELECT * FROM kaizen_focus_area";
		$focusAreaConnectData = mysqli_query($con, $focusAreaSqlData);
		$focusAreaArr = array();
		while ($result_data = mysqli_fetch_assoc($focusAreaConnectData)) {
			array_push($focusAreaArr, $result_data);
		}
		$focusAreaDataArr = array();
		foreach ($focusAreaArr as $focusArea) {
			$focusAreaSql = "SELECT * FROM kaizen WHERE focus_area_id = '$focusArea[id]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$focusAreaSqlConnect = mysqli_query($con, $focusAreaSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($focusAreaSqlConnect)) {
				array_push($newArr, $result_data);
			}
			$focusAreaDataArr[$focusArea['title']] = $newArr;
		}

		$monthDataArr = array();
		$monthDataArr['Rejected'] = array();
		$monthDataArr['Active'] = array();

		$monthSql = "SELECT status, created_at FROM calibrations WHERE is_deleted = 0";
		$monthSqlConnect = mysqli_query($con, $monthSql);
		while ($result_data = mysqli_fetch_assoc($monthSqlConnect)) {
			array_push($monthDataArr[$result_data['status']], $result_data);
		}

		$dataArr['focus_area_result'] = $focusAreaDataArr;
		$dataArr['month_result'] = $monthDataArr;

		echo json_encode($dataArr);
	}
}