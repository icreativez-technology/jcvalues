<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["title"];
	$isExists = "SELECT * FROM NCR_Non_Conformance_Type WHERE Title = '$title'";
	$result = mysqli_query($con, $isExists);

	if ($result->num_rows == 0) {
		$sql_add = "INSERT INTO NCR_Non_Conformance_Type(Title) VALUES ('$title')";
		$result = mysqli_query($con, $sql_add);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../admin_ncr-type.php");
	} else {
		header("Location: ../admin_ncr-type.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}