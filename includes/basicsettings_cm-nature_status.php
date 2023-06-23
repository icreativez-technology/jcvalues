<?php

session_start();
include('functions.php');

$id = $_REQUEST["pg_id"];
//$modified = date("Y/m/d");

$sql_data = "SELECT Id_customer_nature_of_complaints, status FROM Customer_Nature_of_Complaints WHERE Id_customer_nature_of_complaints = '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);

if ($result_data['status'] == "Active") {
	$sql = "UPDATE Customer_Nature_of_Complaints SET status = 'Suspended' WHERE Id_customer_nature_of_complaints = '$id' ";
} else {
	$sql = "UPDATE Customer_Nature_of_Complaints SET status = 'Active' WHERE Id_customer_nature_of_complaints = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../admin_cm-nature.php");