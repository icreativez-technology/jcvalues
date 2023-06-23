<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$customer = $_POST["customer"];
	$created = date("Y/m/d");
	$modified = date("Y/m/d");
	//$status = $_POST["status"];		

	$isExists = "SELECT * FROM Customer_Name WHERE Customer = '$customer'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$sql_add = "INSERT INTO Customer_Name(Customer, Created, Modified) VALUES ('$customer', '$created', '$modified')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_cm-name.php");
	} else {
		header("Location: ../admin_cm-name.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}