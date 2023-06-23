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
		$project = $_POST["project"];
		$priority = $_POST["priority"];
		$due_date = $_POST["due_date"];
		$actual_date = $_POST["actual_date"];
		$assigned_to = $_POST["assigned_to"];
		$status = $_POST["status"];
		$description = $_POST["description"];
		$created_by = $userId;
		$titleExistsSql = "SELECT id FROM tasks WHERE title = '$title'";
		$isTitleExists = mysqli_query($con, $titleExistsSql);
		if ($isTitleExists->num_rows == 0) {
			if ($_SESSION['usuario']) {
				$prefix = "T-";
				$taskIdSql = "SELECT tasks.task_id FROM tasks order by id DESC LIMIT 1";
				$taskIdConnect = mysqli_query($con, $taskIdSql);
				$taskIdInfo = mysqli_fetch_assoc($taskIdConnect);
				$taskId = (isset($taskIdInfo['task_id'])) ? $taskIdInfo['task_id'] : null;
				$length = 6;
				if (!$taskId) {
					$og_length = $length - 1;
					$last_number = '1';
				} else {
					$code = substr($taskId, strlen($prefix));
					$increment_last_number = ((int)$code) + 1;
					$last_number_length = strlen($increment_last_number);
					$og_length = $length - $last_number_length;
					$last_number = $increment_last_number;
				}
				$zeros = "";
				for ($i = 0; $i < $og_length; $i++) {
					$zeros .= "0";
				}
				$task_id = $prefix . $zeros . $last_number;
				$taskAdd = "INSERT INTO tasks (task_id, title, status, priority, project, due_date, actual_date, assigned_to, description, created_by) VALUES ('$task_id', '$title', '$status', '$priority', '$project', '$due_date', '$actual_date', '$assigned_to', '$description','$created_by')";
				$taskAddResult = mysqli_query($con, $taskAdd);
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../task-management.php");
			} else {
				$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		} else {
			header("Location: ../task-add.php?exist");
		}
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
