<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$getSql = "SELECT * FROM customer_complaint_d4_cause_analysis WHERE id = '$requestId' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$customer_complaint_id = $resultData['customer_complaint_id'];
$deleteQuery = "UPDATE customer_complaint_d4_cause_analysis SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);

$deleteWhy = "UPDATE customer_complaint_d4_why_analysis SET is_deleted = 1 WHERE customer_complaint_d4_cause_analysis_id = '$requestId'";
$whyData = mysqli_query($con, $deleteWhy);

$sql = "SELECT * From customer_complaint_d4_why_analysis Where customer_complaint_d4_cause_analysis_id = '$requestId'";
$fetchWhy = mysqli_query($con, $sql);
$whyInfo = mysqli_fetch_assoc($fetchWhy);
$whyId = $whyInfo['id'];

$deleteAction = "UPDATE customer_complaint_d4_corrective_action_plan SET is_deleted = 1 WHERE customer_complaint_d4_why_analysis_id = '$whyId'";
$actionData = mysqli_query($con, $deleteAction);


echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../customer_complaint_edit.php?id=$customer_complaint_id&d4");