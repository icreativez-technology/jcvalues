<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE calibrations SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../calibration_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";