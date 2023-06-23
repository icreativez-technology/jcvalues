<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	$isExists = "SELECT * FROM NCR_Non_Conformance_Type WHERE Title = '$title' AND Id_ncr_non_conformance_type != '$id'";
	$result = mysqli_query($con, $isExists);

	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE NCR_Non_Conformance_Type SET Title = '$title' WHERE Id_ncr_non_conformance_type = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_ncr-type.php");
	} else {
		header("Location: ../admin_ncr-type-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}