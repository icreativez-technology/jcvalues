<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$specialTestingStandard = $_POST["special_testing_standard"];
	$isExists = "SELECT id FROM special_testing_standards WHERE special_testing_standard = '$specialTestingStandard' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE special_testing_standards SET special_testing_standard = '$specialTestingStandard' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../special-testing-standard.php");
	} else {
		header("Location: ../special-testing-standard-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
