<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE admin_audit_standard SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteMemberQuery = "UPDATE admin_audit_standard_auditors SET is_deleted = 1 WHERE admin_audit_standard_id = '$requestId'";
$connectData = mysqli_query($con, $deleteMemberQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../admin_audit_standard.php");