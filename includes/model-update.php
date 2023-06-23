<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$model = $_POST["model"];
	$isExists = "SELECT id FROM models WHERE model = '$model' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE models SET model = '$model' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../model.php");
	} else {
		header("Location: ../model-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
