<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$meeting_id = $_POST["meeting_id"];
		$actions_id = $_POST["actions_id"];
		$actions_description = $_POST["actions_description"];
		$actions_speaker = $_POST["actions_speaker"];
		$target_date = $_POST["actions_target_date"];
		if ($actions_id == "") {
			$addSql = "INSERT INTO meeting_actions (meeting_id, description, speaker, target_date) VALUES ('$meeting_id', '$actions_description', '$actions_speaker', '$target_date')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE meeting_actions SET description = '$actions_description', speaker = '$actions_speaker', target_date = '$target_date' WHERE id = '$actions_id'";
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
