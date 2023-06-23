<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["title"];
	$isExists = "SELECT * FROM Meeting_Category WHERE title = '$title'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql_add = "INSERT INTO Meeting_Category(Title) VALUES ('$title')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_meeting-categories.php");
	} else {
		header("Location: ../admin_meeting-categories.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}