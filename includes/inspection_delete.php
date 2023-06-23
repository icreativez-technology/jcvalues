<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE inspection SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE inspection_product_details SET is_deleted = 1 WHERE inspection_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../inspection_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";