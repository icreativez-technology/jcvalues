<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['yearStartDate']) && isset($_POST['yearEndDate']) && isset($_POST['monthStartDate']) && isset($_POST['monthEndDate'])) {
        $dataArr = array();
        $yearStartDate = $_POST['yearStartDate'];
        $yearEndDate = $_POST['yearEndDate'];
        $monthStartDate = $_POST['monthStartDate'];
        $monthEndDate = $_POST['monthEndDate'];

        /* Start Moc type */
        $qualityMocTypeSqlData = "SELECT * FROM Quality_MoC_Type";
        $qualityMocTypeSqlConnectData = mysqli_query($con, $qualityMocTypeSqlData);
        $qualityMocTypeArr = array();
        while ($result_data = mysqli_fetch_assoc($qualityMocTypeSqlConnectData)) {
            array_push($qualityMocTypeArr, $result_data);
        }

        $qualityMocYearArr = array();
        $qualityMocMonthArr = array();
        foreach ($qualityMocTypeArr as $qualityMocType) {
            $mocSql = "SELECT * FROM quality_moc WHERE moc_type_id = '$qualityMocType[Id_quality_moc_type]' AND created_at BETWEEN '$yearStartDate' AND '$yearEndDate' AND is_deleted = 0";
            $mocSqlConnect = mysqli_query($con, $mocSql);

            $mocMonthSql = "SELECT * FROM quality_moc WHERE moc_type_id = '$qualityMocType[Id_quality_moc_type]' AND created_at BETWEEN '$monthStartDate' AND '$monthEndDate' AND is_deleted = 0";
            $mocMonthSqlConnect = mysqli_query($con, $mocMonthSql);

            $newArr = array();
            while ($result_data = mysqli_fetch_assoc($mocSqlConnect)) {
                array_push($newArr, $result_data);
            }
            $qualityMocYearArr[$qualityMocType['Title']] = $newArr;

            $monthArr = array();
            while ($result_data = mysqli_fetch_assoc($mocMonthSqlConnect)) {
                array_push($monthArr, $result_data);
            }
            $qualityMocMonthArr[$qualityMocType['Title']] = $monthArr;
        }
        /* End Moc type */

        /* Start Risk type */
        $qualityRiskSqlData = "SELECT * FROM Quality_Risk_Type";
        $qualityConectData = mysqli_query($con, $qualityRiskSqlData);
        $qualityArr = array();
        while ($result_data = mysqli_fetch_assoc($qualityConectData)) {
            array_push($qualityArr, $result_data);
        }


        $riskTypeYearDataArr = array();
        $riskTypeMonthDataArr = array();

        foreach ($qualityArr as $quality) {
            $riskSql = "SELECT * FROM quality_risk WHERE risk_type_id = '$quality[Id_quality_risk_type]' AND created_at BETWEEN '$yearStartDate' AND '$yearEndDate' AND is_deleted = 0";
            $connect_riskData = mysqli_query($con, $riskSql);

            $newArr = array();
            while ($result_data = mysqli_fetch_assoc($connect_riskData)) {
                array_push($newArr, $result_data);
            }
            $riskTypeYearDataArr[$quality['Title']] = $newArr;

            $riskMonthSql = "SELECT * FROM quality_risk WHERE risk_type_id = '$quality[Id_quality_risk_type]' AND created_at BETWEEN '$monthStartDate' AND '$monthEndDate' AND is_deleted = 0";
            $connect_riskMonthData = mysqli_query($con, $riskMonthSql);

            $monthArr = array();
            while ($result_data = mysqli_fetch_assoc($connect_riskMonthData)) {
                array_push($monthArr, $result_data);
            }
            $riskTypeMonthDataArr[$quality['Title']] = $monthArr;
        }
        /* End Risk type */



        $dataArr['moc_type_year_result'] = $qualityMocYearArr;
        $dataArr['moc_type_month_result'] = $qualityMocMonthArr;
        $dataArr['risk_type_year_result'] = $riskTypeYearDataArr;
        $dataArr['risk_type_month_result'] = $riskTypeMonthDataArr;
        echo json_encode($dataArr);
    }
}