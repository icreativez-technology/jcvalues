<?php
session_start();
include('functions.php');
$sqlData = "SELECT * FROM inspection_agency WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $sqlData);
$inspectionAgency = mysqli_fetch_assoc($connectData);
$deleteQuery = "UPDATE inspection_agency SET is_deleted = 1 WHERE id = '$_REQUEST[id]'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../inspection_edit.php?id=$inspectionAgency[inspection_id]&updated");