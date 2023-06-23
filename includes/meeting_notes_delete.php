<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$sqlData = "SELECT * FROM meeting_notes WHERE id = '$requestId'";
$connectData = mysqli_query($con, $sqlData);
$meeting = mysqli_fetch_assoc($connectData);
$meeting_id = $meeting['id'];
$deleteQuery = "UPDATE meeting_notes SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../meeting_edit.php?id=$meeting_id&updated");
