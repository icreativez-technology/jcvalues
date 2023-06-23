<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["title"];
	$created = date("Y/m/d");
	$modified = date("Y/m/d");
	$status = $_POST["status"];

	$email = $_SESSION['usuario'];
	$sql = "SELECT * From Basic_Employee Where Email = '$email'";
	$fetch = mysqli_query($con, $sql);
	$userInfo = mysqli_fetch_assoc($fetch);
	$userId = $userInfo['Id_employee'];


	$isExists = "SELECT * FROM product_types WHERE product_type = '$title'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {

		$sql_add = "INSERT INTO product_types (product_type, created_by) VALUES ('$title', '$userId')";
		$result = mysqli_query($con, $sql_add);
		$id = mysqli_insert_id($con);

		//add product-model
		foreach ($_POST['models'] as $id_deparment) {
			$sql_add_deparment = "INSERT INTO product_type_model VALUES ('','$id', '$id_deparment')";
			$result = mysqli_query($con, $sql_add_deparment);
		}

		//previous
		/*foreach ($_POST['components'] as $id_components) {
			$sql_add_components = "INSERT INTO product_type_component VALUES ('','$id', '$id_components')";
			$result = mysqli_query($con, $sql_add_components);
		}*/

		//add product-component with mandatory field
		foreach ($_POST['components'] as $id_components) {
			$mandatory=0;
			if (in_array($id_components, $_POST['components2'])){
				$mandatory=1;
			}
			$sql_add_components = "INSERT INTO product_type_component VALUES ('','$id', '$id_components', '$mandatory')";
			$result = mysqli_query($con, $sql_add_components);
		}

		//add product-design
		foreach ($_POST['design_standards'] as $id_design_standards) {
			$sql_add_design_standards = "INSERT INTO product_type_design_std VALUES ('','$id', '$id_design_standards')";
			$result = mysqli_query($con, $sql_add_design_standards);
		}

		//add product-testing
		foreach ($_POST['testing_standards'] as $id_testing_standards) {
			$sql_add_testing_standards = "INSERT INTO product_type_testing_std VALUES ('','$id', '$id_testing_standards')";
			$result = mysqli_query($con, $sql_add_testing_standards);
		}

		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../product-type.php");
	} else {
		header("Location: ../admin_product_type-add.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
