<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$title = $_POST["title"];
	$isExists = "SELECT id FROM suggestion_nature_of_obs WHERE title = '$title' AND id != '$id' AND is_deleted = 0";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE suggestion_nature_of_obs SET title = '$title' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../suggestion-nature-of-obs.php");
	} else {
		header("Location: ../suggestion-nature-of-obs-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
