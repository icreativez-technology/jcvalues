<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$title = $_POST["title"];
	$isExists = "SELECT id FROM main_cause WHERE title = '$title' AND is_deleted = 0";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$email = $_SESSION['usuario'];
			$sql = "SELECT * From Basic_Employee Where Email = '$email'";
			$fetch = mysqli_query($con, $sql);
			$userInfo = mysqli_fetch_assoc($fetch);
			$userId = $userInfo['Id_employee'];
			$sqlAdd = "INSERT INTO main_cause (title, created_by) VALUES ('$title', '$userId')";
			$result = mysqli_query($con, $sqlAdd);
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../main-cause.php");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../main-cause.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
