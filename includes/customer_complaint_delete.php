<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE customer_complaints SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteTeamQuery = "UPDATE customer_complaint_d1_d2_team SET is_deleted = 1 WHERE customer_complaint_id = '$requestId'";
$connectData = mysqli_query($con, $deleteTeamQuery);
$deleteQuery = "UPDATE customer_complaint_files SET is_deleted = 1 WHERE customer_complaint_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../customer_complaint_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
