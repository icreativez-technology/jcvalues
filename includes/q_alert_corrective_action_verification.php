<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$getSql = "SELECT * FROM q_alert_corrective_action WHERE id = '$id' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$q_alert_id = $resultData['q_alert_id'];
$updateStatus = ($resultData['verification'] == "1") ? 0 : 1;
$updateSql = "UPDATE q_alert_corrective_action SET verification = '$updateStatus' WHERE id = '$id' ";
$result = mysqli_query($con, $updateSql);
if ($updateStatus == 1) {
    $getAllSql = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$q_alert_id' AND is_deleted = 0";
    $connectAllData = mysqli_query($con, $getAllSql);
    $getApprovedSql = "SELECT * FROM q_alert_corrective_action WHERE q_alert_id = '$q_alert_id' AND is_deleted = 0 AND verification = 1";
    $connectApprovedData = mysqli_query($con, $getApprovedSql);
    if ($connectAllData->num_rows == $connectApprovedData->num_rows) {
        $closeQAlertSql = "UPDATE q_alert SET status = 'Closed' WHERE id = '$q_alert_id'";
        $closeQAlert = mysqli_query($con, $closeQAlertSql);
        // echo "<script type='text/javascript'>alert('Success!');</script>";
        // return header("Location: ../q_alert_view_list.php");
        echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
        return;
    }
} else {
    $openQAlertSql = "UPDATE q_alert SET status = 'Open' WHERE id = '$q_alert_id'";
    $openQAlert = mysqli_query($con, $openQAlertSql);
}
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../q_alert_edit.php?id=$q_alert_id&verification");
