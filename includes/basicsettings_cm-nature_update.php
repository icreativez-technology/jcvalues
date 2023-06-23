<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	$modified = date("Y/m/d");
	//$status = $_POST["status"];	

	$isExists = "SELECT * FROM Customer_Nature_of_Complaints WHERE Title = '$title' AND Id_customer_nature_of_complaints != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE Customer_Nature_of_Complaints SET Title = '$title', Modified = '$modified' WHERE Id_customer_nature_of_complaints = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_cm-nature.php");
	} else {
		header("Location: ../admin_cm-nature-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}