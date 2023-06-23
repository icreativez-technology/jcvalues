<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	//$status = $_POST["status"];	

	$isExists = "SELECT * FROM NCR_Process_Type WHERE Title = '$title' AND Id_ncr_process_type != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE NCR_Process_Type SET Title = '$title' WHERE Id_ncr_process_type = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_ncr-process.php");
	} else {
		header("Location: ../admin_ncr-process-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}