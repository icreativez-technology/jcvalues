<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE material_specifications SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE material_specification_tensile_test SET is_deleted = 1 WHERE material_specification_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE material_specification_impact_test SET is_deleted = 1 WHERE material_specification_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE material_specification_hardness_test SET is_deleted = 1 WHERE material_specification_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
$deleteQuery = "UPDATE material_specification_chemicals SET is_deleted = 1 WHERE material_specification_id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../material-specification.php");