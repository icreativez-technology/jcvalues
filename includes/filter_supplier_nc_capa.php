<?php
session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
        $dataArr = array();
        $startDate = $_POST['startDate'];
        $endDate = date('Y-m-d', strtotime('+1 day', strtotime($_POST['endDate'])));

        $classificationTypeArr = ["Major", "Minor"];
        $classificationArr = array();
        foreach ($classificationTypeArr as $classificationType) {
            $sqlData = "SELECT * FROM supplier_nc_capa_ncr_details 
            WHERE ncr_classification = '$classificationType' AND created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
            $connectData = mysqli_query($con, $sqlData);
            $newArr = array();
            while ($result_data = mysqli_fetch_assoc($connectData)) {
                array_push($newArr, $result_data);
            }
            $classificationArr[$classificationType] = $newArr;
        }

        $sqlData = "SELECT * FROM supplier_nc_capa_ncr_details
        LEFT JOIN Basic_Supplier ON Basic_Supplier.Id_Supplier = supplier_nc_capa_ncr_details.supplier_id 
        WHERE created_at BETWEEN '$startDate' AND '$endDate' AND is_deleted = 0";
        $connectData = mysqli_query($con, $sqlData);
        $supplierArr = array();
        while ($result_data = mysqli_fetch_assoc($connectData)) {
            array_push($supplierArr, $result_data['Supplier_Name']);
        }

        $dataArr['classification'] = $classificationArr;
        $dataArr['supplier'] = $supplierArr;
        echo json_encode($dataArr);
    }
}