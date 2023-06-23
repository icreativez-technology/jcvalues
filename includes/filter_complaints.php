<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
		$dataArr = array();
		$startDate = $_POST['startDate'];
		$endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

		$natureOfComplaintSqlData = "SELECT * FROM Customer_Nature_of_Complaints";
		$natureOfComplaintConnectData = mysqli_query($con, $natureOfComplaintSqlData);
		$natureOfComplaintArr = array();
		while ($result_data = mysqli_fetch_assoc($natureOfComplaintConnectData)) {
			array_push($natureOfComplaintArr, $result_data);
		}
		$natureOfComplaintDataArr = array();
		foreach ($natureOfComplaintArr as $natureOfComplaint) {
			$natureOfComplaintSql = "SELECT * FROM customer_complaints WHERE nature_of_complaint_id = '$natureOfComplaint[Id_customer_nature_of_complaints]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$natureOfComplaintSqlConnect = mysqli_query($con, $natureOfComplaintSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($natureOfComplaintSqlConnect)) {
				array_push($newArr, $result_data);
			}
			$natureOfComplaintDataArr[$natureOfComplaint['Title']] = $newArr;
		}

		$monthDataArr = array();
		$monthDataArr['Closed'] = array();
		$monthDataArr['Open'] = array();

		$monthSql = "SELECT status, created_at FROM customer_complaints WHERE created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
		$monthSqlConnect = mysqli_query($con, $monthSql);
		while ($result_data = mysqli_fetch_assoc($monthSqlConnect)) {
			array_push($monthDataArr[$result_data['status']], $result_data);
		}

		$dataArr['nature_of_complaint_result'] = $natureOfComplaintDataArr;
		$dataArr['month_result'] = $monthDataArr;

		echo json_encode($dataArr);
	}
}