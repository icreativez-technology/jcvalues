<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$meetingId = $_POST["meetingId"];
		$title = $_POST["title"];
		$coordinator = $_POST["coordinator"];
		$category = $_POST["category"];
		$venue = $_POST["venue"];
		$date = $_POST["date"];
		$start_time = $_POST["start_time"];
		$end_time = $_POST["end_time"];
		$duration = $_POST["duration"];
		$status = $_POST["status"];
		$participants = $_POST["participants"];
		$meetingUpdateSql = "UPDATE meeting SET title = '$title', coordinator = '$coordinator', category = '$category', venue = '$venue', date = '$date', start_time = '$start_time', end_time = '$end_time', duration = '$duration', status = '$status' WHERE id = '$meetingId'";
		$meetingUpdateResult = mysqli_query($con, $meetingUpdateSql);
		$deleteParticipantsSql = "UPDATE meeting_participant SET is_deleted = 1 WHERE meeting_id = '$meetingId'";
		$deleteParticipantsSqlResult = mysqli_query($con, $deleteParticipantsSql);
		foreach ($participants as $key => $participantId) {
			$isExists = "SELECT id FROM meeting_participant WHERE meeting_id = '$meetingId' AND participant_id = '$participantId'";
			$result = mysqli_query($con, $isExists);
			if ($result->num_rows == 0) {
				$addParticipantSql = "INSERT INTO meeting_participant (meeting_id, participant_id) VALUES ('$meetingId', '$participantId')";
				$addParticipantSqlResult = mysqli_query($con, $addParticipantSql);
			} else {
				$updateParticipantSql = "UPDATE meeting_participant SET is_deleted = 0 WHERE meeting_id = '$meetingId' AND participant_id = '$participantId'";
				$updateParticipantSqlResult = mysqli_query($con, $updateParticipantSql);
			}
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../meeting_edit.php?id=$meetingId");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
