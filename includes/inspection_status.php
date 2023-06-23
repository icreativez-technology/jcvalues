<?php
session_start();
include('functions.php');
$id = $_REQUEST['id'];
switch ($_REQUEST['status']) {
    case 'complete':
        $status = 'Completed';
        break;
    case 'cancel':
        $status = 'Cancelled';
        break;
}
$updateQuery = "UPDATE inspection SET status = '$status' WHERE id = '$id'";
$connectData = mysqli_query($con, $updateQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../inspection_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";