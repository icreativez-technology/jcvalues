<?php

session_start();
include('functions.php');


$id = $_REQUEST["pg_id"];
$sql_data = "SELECT * FROM calibrations WHERE id LIKE '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] != "Rejected") {
    $sql = "UPDATE calibrations SET status = 'Rejected' WHERE id = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../calibration_view_list.php?a=calibration");
