<?php
session_start();
include('functions.php');
$requestId = $_REQUEST['id'];
$deleteQuery = "UPDATE send_for SET is_deleted = 1 WHERE id = '$requestId'";
$connectData = mysqli_query($con, $deleteQuery);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../send-for.php");
