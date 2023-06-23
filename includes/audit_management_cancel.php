<?php
session_start();
include('functions.php');
$updateSql = "UPDATE audit_management_list SET status = 'Cancelled' WHERE id = '$_REQUEST[id]'";
$result = mysqli_query($con, $updateSql);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../audit_management.php");