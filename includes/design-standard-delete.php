<?php
session_start();
include('functions.php');
$currentDate = date("Y-m-d H:i:s");
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE design_standards SET deleted_at = '$currentDate' WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../design-standard.php");
