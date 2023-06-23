<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$inspection_id = $_POST["inspection_id"];
		$id = $_POST["inspection_agency_id"];
		$on_behalf_of = $_POST["on_behalf_of_modal"];
		$inspection_agency = $_POST["inspection_agency_modal"];
		$inspector_name = $_POST["inspector_name_modal"];
		$email = $_POST["email_modal"];
		if ($id == "") {
			$addSql = "INSERT INTO inspection_agency (inspection_id, on_behalf_of, inspection_agency, inspector_name, email) VALUES ('$inspection_id', '$on_behalf_of', '$inspection_agency', '$inspector_name', '$email')";
			$addResult = mysqli_query($con, $addSql);
		} else {
			$updateSql = "UPDATE inspection_agency SET on_behalf_of = '$on_behalf_of', inspection_agency = '$inspection_agency', inspector_name = '$inspector_name', email = '$email' WHERE id = '$id'";
			$updateResult = mysqli_query($con, $updateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../inspection_edit.php?id=$inspection_id&updated");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}