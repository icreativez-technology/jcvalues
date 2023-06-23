<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$getSql = "SELECT * FROM suggestion_nature_of_obs WHERE id = '$id' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$updateStatus = ($resultData['status'] == "1") ? 0 : 1;
$updateSql = "UPDATE suggestion_nature_of_obs SET status = '$updateStatus' WHERE id = '$id' ";
$result = mysqli_query($con, $updateSql);
echo $result;
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../suggestion-nature-of-obs.php");
