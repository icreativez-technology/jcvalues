<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE meeting SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteParticipantQuery = "UPDATE meeting_participant SET is_deleted = 1 WHERE meeting_id = '$requestId'";
$connectData = mysqli_query($con, $deleteParticipantQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../meeting_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
