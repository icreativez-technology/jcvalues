<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE audit_nc_capa_ncr_details SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE audit_nc_capa_external SET is_deleted = 1 WHERE audit_nc_capa_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../audit_nc_capa_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
