<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["title"];
	$created = date("Y/m/d");
	$modified = date("Y/m/d");
	// $status = $_POST["status"];		

	$isExists = "SELECT * FROM NCR_Disposition WHERE Title = '$title'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql_add = "INSERT INTO NCR_Disposition(Title, Created, Modified) VALUES ('$title', '$created', '$modified')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_ncr-disposition.php");
	} else {
		header("Location: ../admin_ncr-disposition.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}