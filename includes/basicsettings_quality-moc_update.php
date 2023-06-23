<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];


	/*$sql_add = "INSERT INTO Basic_Product_Group VALUES ('','$title', '$created', '$modified', '$status')";
		$result = mysqli_query($con, $sql_add);*/

	//update 
	$isExists = "SELECT * FROM Quality_MoC_Type WHERE Title = '$title' AND Id_quality_moc_type != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$sql = "UPDATE Quality_MoC_Type SET Title = '$title' WHERE Id_quality_moc_type = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_quality-moc.php");
	} else {
		header("Location: ../admin_quality-moc-edit.php?pg_id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}