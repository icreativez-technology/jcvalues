<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE kaizen SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteTeamQuery = "UPDATE kaizen_team_members SET is_deleted = 1 WHERE kaizen_id = '$requestId'";
$connectData = mysqli_query($con, $deleteTeamQuery);
$deleteQuery = "UPDATE kaizen_self_evaluation SET is_deleted = 1 WHERE kaizen_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE kaizen_hod_evaluation SET is_deleted = 1 WHERE kaizen_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE kaizen_committee_evaluation SET is_deleted = 1 WHERE kaizen_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
// echo "<script type='text/javascript'>alert('Success!');</script>";
// header("Location: ../kaizen_view_list.php");
echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
