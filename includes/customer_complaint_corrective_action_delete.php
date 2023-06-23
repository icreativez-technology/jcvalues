<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$getSql = "SELECT * FROM customer_complaint_d4_corrective_action_plan WHERE id = '$requestId' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$complaint_id = $resultData['customer_complaint_id'];
$deleteQuery = "UPDATE customer_complaint_d4_corrective_action_plan SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../customer_complaint_edit.php?id=$complaint_id&d4");