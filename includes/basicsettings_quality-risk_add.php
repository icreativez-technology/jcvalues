<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["title"];

	$isExists = "SELECT * FROM Quality_Risk_Type WHERE Title = '$title'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql_add = "INSERT INTO Quality_Risk_Type(Title) VALUES ('$title')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_quality-risk.php");
	} else {
		header("Location: ../admin_quality-risk.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}