<?php
session_start();
include('functions.php');
$id = $_REQUEST["id"];
$today = date('Y-m-d');
$updateSql = "UPDATE report_bug SET status = 'Closed', closed_at = '$today' WHERE id = '$id'";
$result = mysqli_query($con, $updateSql);
echo $result;
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../report-bug.php");