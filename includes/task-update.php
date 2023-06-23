<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["title"])) {
		$task_id = $_POST["task_id"];
		$title = $_POST["title"];
		$project = $_POST["project"];
		$priority = $_POST["priority"];
		$due_date = $_POST["due_date"];
		$actual_date = $_POST["actual_date"];
		$assigned_to = $_POST["assigned_to"];
		$status = $_POST["status"];
		$description = $_POST["description"];
		$titleExistsSql = "SELECT id FROM tasks WHERE title = '$title' AND id != '$task_id'";
		$isTitleExists = mysqli_query($con, $titleExistsSql);
		if ($isTitleExists->num_rows == 0) {
			if ($_SESSION['usuario']) {
				$taskUpdateSql = "UPDATE tasks SET title = '$title', project = '$project', priority = '$priority', due_date = '$due_date', actual_date = '$actual_date', assigned_to = '$assigned_to', status = '$status', description = '$description' WHERE id = '$task_id'";
				$taskUpdateResult = mysqli_query($con, $taskUpdateSql);
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../task-management.php");
			} else {
				$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
				echo "<script type='text/javascript'>alert('$msg');</script>";
			}
		} else {
			header("Location: ../task-edit.php?id=$task_id&exist");
		}
	} else {
		$task_id = $_POST["task_id"];
		$actual_date = $_POST["actual_date"];
		$status = $_POST["status"];
		$taskUpdateSql = "UPDATE tasks SET actual_date = '$actual_date', status = '$status' WHERE id = '$task_id'";
		$taskUpdateResult = mysqli_query($con, $taskUpdateSql);
		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../task-management.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}