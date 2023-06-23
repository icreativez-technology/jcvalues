<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$meeting_id = $_POST["meeting_id"];
		$decisions_id = $_POST["decisions_id"];
		$decisions_description = $_POST["decisions_description"];
		if ($decisions_id == "") {
			$addSql = "INSERT INTO meeting_decisions (meeting_id, description) VALUES ('$meeting_id', '$decisions_description')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE meeting_decisions SET description = '$decisions_description' WHERE id = '$decisions_id'";
			$updateResult = mysqli_query($con, $updateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../meeting_edit.php?id=$meeting_id&updated");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}