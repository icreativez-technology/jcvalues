<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	$modified = date("Y/m/d");
	//$status = $_POST["status"];	
	$isExists = "SELECT * FROM Asset_Usage_Condition WHERE Title = '$title' AND Id_asset_usage_condition != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE Asset_Usage_Condition SET Title = '$title', Modified = '$modified' WHERE Id_asset_usage_condition = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_asset-usage.php");
	} else {
		header("Location: ../admin_asset-usage-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}