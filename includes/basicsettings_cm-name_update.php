<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$customer = $_POST["customer"];
	$modified = date("Y/m/d");
	//$status = $_POST["status"];	
	$isExists = "SELECT * FROM Customer_Name WHERE Customer = '$customer' AND Id_customer_name != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE Customer_Name SET Customer = '$customer', Modified = '$modified' WHERE Id_customer_name = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_cm-name.php");
	} else {
		header("Location: ../admin_cm-name-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}