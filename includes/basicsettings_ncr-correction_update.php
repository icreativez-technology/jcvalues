<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	$modified = date("Y/m/d");
	//$status = $_POST["status"];	
	$isExists = "SELECT * FROM NCR_Correction WHERE Title = '$title' AND Id_ncr_correction != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE NCR_Correction SET Title = '$title', Modified = '$modified' WHERE Id_ncr_correction = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_ncr-correction.php");
	} else {
		header("Location: ../admin_ncr-correction-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}