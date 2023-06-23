<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$title = $_POST["title"];
	$modified = date("Y/m/d");
	//$status = $_POST["status"];	
	$isExists = "SELECT * FROM Asset_Type_of_Maintenance WHERE Title = '$title' AND Id_asset_type_of_maintenance != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		//update 
		$sql = "UPDATE Asset_Type_of_Maintenance SET Title = '$title', Modified = '$modified' WHERE Id_asset_type_of_maintenance = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";

		header("Location: ../admin_asset-maintenance.php");
	} else {
		header("Location: ../admin_asset-maintenance-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}