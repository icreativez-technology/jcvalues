<?php
session_start();
include('functions.php');
$id = $_REQUEST["id"];
$getSql = "SELECT * FROM admin_audit_standard WHERE id = '$id' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$updateStatus = ($resultData['status'] == "Active") ? "Suspended" : "Active";
$updateSql = "UPDATE admin_audit_standard SET status = '$updateStatus' WHERE id = '$id' ";
$result = mysqli_query($con, $updateSql);
echo $result;
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../admin_audit_standard.php");