<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$meeting_id = $_POST["meeting_id"];
		$agenda_id = $_POST["agenda_id"];
		$agenda_description = $_POST["agenda_description"];
		if ($agenda_id == "") {
			$addSql = "INSERT INTO meeting_agenda (meeting_id, description) VALUES ('$meeting_id', '$agenda_description')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE meeting_agenda SET description = '$agenda_description' WHERE id = '$agenda_id'";
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
