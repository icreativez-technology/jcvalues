<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$audit_type = $_REQUEST['type'];
$deleteQuery = "UPDATE audit_management_list SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
if ($audit_type == 'Internal') {
    $deleteQuery = "UPDATE internal_audits SET is_deleted = 1 WHERE audit_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
} else if ($audit_type == 'External') {
    $deleteQuery = "UPDATE external_and_customer_audits SET is_deleted = 1 WHERE audit_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
    $deleteQuery = "UPDATE external_and_customer_audit_assign_auditees SET is_deleted = 1 WHERE audit_id = '$requestId'";
    $connectData = mysqli_query($con, $deleteQuery);
}
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../audit_management.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
