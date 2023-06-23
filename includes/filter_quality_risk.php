<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
		$dataArr = array();
		$startDate = $_POST['startDate'];
		$endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

		$processSqlData = "SELECT * FROM Quality_Process";
		$processConectData = mysqli_query($con, $processSqlData);
		$processArr = array();
		while ($result_data = mysqli_fetch_assoc($processConectData)) {
			array_push($processArr, $result_data);
		}

		$qualityRiskSqlData = "SELECT * FROM Quality_Risk_Type";
		$qualityConectData = mysqli_query($con, $qualityRiskSqlData);
		$qualityArr = array();
		while ($result_data = mysqli_fetch_assoc($qualityConectData)) {
			array_push($qualityArr, $result_data);
		}

		$proccessDataArr = array();
		foreach ($processArr as $process) {
			$riskSql = "SELECT * FROM quality_risk WHERE process_id = '$process[Id_quality_process]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$connect_riskData = mysqli_query($con, $riskSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($connect_riskData)) {
				array_push($newArr, $result_data);
			}
			$proccessDataArr[$process['Title']] = $newArr;
		}

		$riskTypeDataArr = array();
		foreach ($qualityArr as $quality) {
			$riskSql = "SELECT * FROM quality_risk WHERE risk_type_id = '$quality[Id_quality_risk_type]' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
			$connect_riskData = mysqli_query($con, $riskSql);
			$newArr = array();
			while ($result_data = mysqli_fetch_assoc($connect_riskData)) {
				array_push($newArr, $result_data);
			}
			$riskTypeDataArr[$quality['Title']] = $newArr;
		}

		$dataArr['process_type'] = $processArr;
		$dataArr['risk_type'] = $qualityArr;
		$dataArr['process_result'] = $proccessDataArr;
		$dataArr['risk_type_result'] = $riskTypeDataArr;
		echo json_encode($dataArr);
	}
}