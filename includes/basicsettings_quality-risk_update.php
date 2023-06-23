<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	//$status = $_POST["status"];	

	//update 
	$isExists = "SELECT * FROM Quality_Risk_Type WHERE Title = '$title' AND Id_quality_risk_type != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql = "UPDATE Quality_Risk_Type SET Title = '$title' WHERE Id_quality_risk_type = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_quality-risk.php");
	} else {
		header("Location: ../admin_quality-risk-edit.php?pg_id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}