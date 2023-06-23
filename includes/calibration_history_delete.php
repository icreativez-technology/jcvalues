<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$type = $_REQUEST['type'];
$sqlData = "SELECT * FROM calibration_history WHERE id = '$_REQUEST[id]' AND is_deleted = 0";
$connectData = mysqli_query($con, $sqlData);
$history = mysqli_fetch_assoc($connectData);
$calibration_id = $history['calibration_id'];
$deleteQuery = "UPDATE calibration_history SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
if ($type == "Calibration In") {
    $deleteQuery = "UPDATE calibration_in SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
    $deleteQuery = "UPDATE calibration_in_files SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
} else if ($type == "Calibration Out") {
    $deleteQuery = "UPDATE calibration_out SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
    $deleteQuery = "UPDATE calibration_out_files SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
} else if ($type == "Issuance") {
    $deleteQuery = "UPDATE calibration_issuance SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
} else if ($type == "Receipt") {
    $deleteQuery = "UPDATE calibration_receipt SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
    $deleteQuery = "UPDATE calibration_receipt_files SET is_deleted = 1 WHERE calibration_history_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
}
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../calibration_edit.php?id=$calibration_id&history");