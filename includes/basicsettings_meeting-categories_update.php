<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];

	//update 
	$isExists = "SELECT * FROM Meeting_Category WHERE Title = '$title' AND Id_meeting_category != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql = "UPDATE Meeting_Category SET Title = '$title' WHERE Id_meeting_category = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_meeting-categories.php");
	} else {
		header("Location: ../admin_meeting-categories-edit.php?pg_id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}