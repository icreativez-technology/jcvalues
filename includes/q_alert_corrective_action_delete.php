<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$getSql = "SELECT * FROM q_alert_corrective_action WHERE id = '$requestId' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$q_alert_id = $resultData['q_alert_id'];
$deleteQuery = "UPDATE q_alert_corrective_action SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../q_alert_edit.php?id=$q_alert_id&action");
