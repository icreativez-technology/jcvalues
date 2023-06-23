<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$getSql = "SELECT * FROM vt_light_incidence WHERE id = '$id' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$updateStatus = ($resultData['status'] == "1") ? 0 : 1;
$updateSql = "UPDATE vt_light_incidence SET status = '$updateStatus' WHERE id = '$id' ";
$result = mysqli_query($con, $updateSql);
echo $result;
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../vt-light-incidence.php");
