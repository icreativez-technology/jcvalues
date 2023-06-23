<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$workingPressure = $_POST["working_pressure"];
	$isExists = "SELECT id FROM working_pressures WHERE working_pressure = '$workingPressure' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE working_pressures SET working_pressure = '$workingPressure' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../working-pressure.php");
	} else {
		header("Location: ../working-pressure-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
