<?php

session_start();
include('functions.php');


$id = $_REQUEST["pg_id"];
//$modified = date("Y/m/d");

$sql_data = "SELECT Id_meeting_category, status FROM Meeting_Category WHERE Id_meeting_category = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] == "Active") {
	$sql = "UPDATE Meeting_Category SET Status = 'Suspended' WHERE Id_meeting_category = '$id' ";
} else {
	$sql = "UPDATE Meeting_Category SET Status = 'Active' WHERE Id_meeting_category = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_meeting-categories.php");