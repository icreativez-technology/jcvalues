<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE serial_heat_details SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteTeamQuery = "UPDATE serial_heat_type_material SET is_deleted = 1 WHERE serial_heat_details_id = '$requestId'";
$connectData = mysqli_query($con, $deleteTeamQuery);
$deleteQuery = "UPDATE serial_heat_marking SET is_deleted = 1 WHERE serial_heat_details_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
