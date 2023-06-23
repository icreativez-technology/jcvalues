<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["id"];
	$designStandard = $_POST["design_standard"];
	// $productTypeId = $_POST["product_type_id"];
	$isExists = "SELECT id FROM design_standards WHERE design_standard = '$designStandard' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$updateSql = "UPDATE design_standards SET design_standard = '$designStandard' WHERE id = '$id' ";
		$result = mysqli_query($con, $updateSql);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../design-standard.php");
	} else {
		header("Location: ../design-standard-edit.php?id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
