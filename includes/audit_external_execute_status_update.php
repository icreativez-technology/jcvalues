<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$sql = "UPDATE audit_management_list SET status = 'Audited' WHERE id = '$id'";
$connect_data = mysqli_query($con, $sql);
$executionSql = "SELECT * FROM audit_management_execute_check_list WHERE is_deleted = 0 AND is_ncr = 1 AND audit_id = '$id'";
$executionData = mysqli_query($con, $executionSql);
$executeArr = array();
while ($row = mysqli_fetch_assoc($executionData)) {
    array_push($executeArr, $row);
}
foreach ($executeArr as $execute) {
    $prefix = "ANC-";
    $uniqueIdSql = "SELECT unique_id FROM audit_nc_capa_ncr_details order by id DESC LIMIT 1";
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
    $addSql = "INSERT INTO audit_nc_capa_ncr_details (unique_id, audit_id) VALUES ('$unique_id', '$id')";
    $addResult = mysqli_query($con, $addSql);
    $anc_id = mysqli_insert_id($con);
    $sql = "UPDATE audit_management_execute_check_list SET anc_id = '$anc_id' WHERE id = '$execute[id]'";
    $connect_data = mysqli_query($con, $sql);
}
header("Location: ../audit_management.php");