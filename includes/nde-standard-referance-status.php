<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$getSql = "SELECT * FROM nde_standard_referances WHERE id = '$id' ";
$connectData = mysqli_query($con, $getSql);
$resultData = mysqli_fetch_assoc($connectData);
$updateStatus = ($resultData['status'] == "1") ? 0 : 1;
$updateSql = "UPDATE nde_standard_referances SET status = '$updateStatus' WHERE id = '$id' ";
$result = mysqli_query($con, $updateSql);
echo $result;
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../nde-standard-referance.php");
