<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$testingStandard = $_POST["testing_standard"];
	$isExists = "SELECT id FROM testing_standards WHERE testing_standard = '$testingStandard' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE testing_standards SET testing_standard = '$testingStandard' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../testing-standard.php");
	} else {
		header("Location: ../testing-standard-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
