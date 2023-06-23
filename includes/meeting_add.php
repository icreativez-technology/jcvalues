<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$fetch = mysqli_query($con, $sql);
		$userInfo = mysqli_fetch_assoc($fetch);
		$userId = $userInfo['Id_employee'];
		$title = $_POST["title"];
		$coordinator = $_POST["coordinator"];
		$category = $_POST["category"];
		$venue = $_POST["venue"];
		$date = $_POST["date"];
		$start_time = $_POST["start_time"];
		$end_time = $_POST["end_time"];
		$duration = $_POST["duration"];
		$participants = $_POST["participants"];
		$prefix = "MOM-ID-";
		$meetingIdSql = "SELECT meeting_id FROM meeting order by id DESC LIMIT 1";
		$meetingIdConnect = mysqli_query($con, $meetingIdSql);
		$meetingIdInfo = mysqli_fetch_assoc($meetingIdConnect);
		$meetingId = (isset($meetingIdInfo['meeting_id'])) ? $meetingIdInfo['meeting_id'] : null;
		$length = 4;
		if (!$meetingId) {
			$og_length = $length - 1;
			$last_number = '1';
		} else {
			$code = substr($meetingId, strlen($prefix));
			$increment_last_number = ((int)$code) + 1;
			$last_number_length = strlen($increment_last_number);
			$og_length = $length - $last_number_length;
			$last_number = $increment_last_number;
		}
		$zeros = "";
		for ($i = 0; $i < $og_length; $i++) {
			$zeros .= "0";
		}
		$meeting_id = $prefix . $zeros . $last_number;
		$meetingAddSql = "INSERT INTO meeting (title, meeting_id, coordinator, category, venue, date, start_time, end_time, duration, created_by) VALUES ('$title', '$meeting_id', '$coordinator', '$category', '$venue', '$date', '$start_time', '$end_time', '$duration', '$userId')";
		$meetingAddResult = mysqli_query($con, $meetingAddSql);
		$addedMeetingId = mysqli_insert_id($con);
		foreach ($participants as $key => $participantId) {
			$addParticipantSql = "INSERT INTO meeting_participant (meeting_id, participant_id) VALUES ('$addedMeetingId', '$participantId')";
			$addParticipantSqlConnect = mysqli_query($con, $addParticipantSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../meeting_view_list.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
