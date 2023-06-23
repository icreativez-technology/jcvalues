<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$meeting_id = $_POST["meeting_id"];
		$notes_id = $_POST["notes_id"];
		$notes_description = $_POST["notes_description"];
		$notes_speaker = $_POST["notes_speaker"];
		if ($notes_id == "") {
			$addSql = "INSERT INTO meeting_notes (meeting_id, description, speaker) VALUES ('$meeting_id', '$notes_description', '$notes_speaker')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE meeting_notes SET description = '$notes_description', speaker = $notes_speaker WHERE id = '$notes_id'";
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
