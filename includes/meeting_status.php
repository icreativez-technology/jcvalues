<?php
session_start();
include('functions.php');
$id = $_REQUEST['id'];
switch ($_REQUEST['status']) {
	case 'review':
		$status = 'In Review';
		break;
	case 'cancel':
		$status = 'Cancelled';
		break;
	case 'publish':
		$status = 'Published';
		break;
}
$updateQuery = "UPDATE meeting SET status = '$status' WHERE id = '$id'";
$connectData = mysqli_query($con, $updateQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../meeting_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
