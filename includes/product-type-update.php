<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title = $_POST["product_type"];
	$id = $_POST["id"];
	$modified = date("Y/m/d");
	$status = $_POST["status"];
	$isExists = "SELECT * FROM product_types WHERE product_type = '$title' AND id != '$id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		// Update product type
		$sql_update = "UPDATE product_types SET product_type ='$title', status = '$status', updated_at = '$modified' WHERE id = '$id'";
		$result = mysqli_query($con, $sql_update);

		//delete models
		$consulta = "DELETE FROM product_type_model WHERE product_type_id = $id";
		$consultaBD = mysqli_query($con, $consulta);

		//add product-model
		foreach ($_POST['models'] as $id_deparment) {
			$sql_add_deparment = "INSERT INTO product_type_model VALUES ('','$id', '$id_deparment')";
			$result = mysqli_query($con, $sql_add_deparment);
		}

		//delete components
		$consulta = "DELETE FROM product_type_component WHERE product_type_id = $id";
		$consultaBD = mysqli_query($con, $consulta);

		//add product-component
		foreach ($_POST['components'] as $id_components) {
			$mandatory=0;
			if (in_array($id_components, $_POST['components2'])){
				$mandatory=1;
			}
			$sql_add_components = "INSERT INTO product_type_component VALUES ('','$id', '$id_components', '$mandatory')";
			$result = mysqli_query($con, $sql_add_components);
		}

		//delete design_standards
		$consulta = "DELETE FROM product_type_design_std WHERE product_type_id = $id";
		$consultaBD = mysqli_query($con, $consulta);

		//add product-design
		foreach ($_POST['design_standards'] as $id_design_standards) {
			$sql_add_design_standards = "INSERT INTO product_type_design_std VALUES ('','$id', '$id_design_standards')";
			$result = mysqli_query($con, $sql_add_design_standards);
		}

		//delete testing_standards
		$consulta = "DELETE FROM product_type_testing_std WHERE product_type_id = $id";
		$consultaBD = mysqli_query($con, $consulta);

		//add product-testing
		foreach ($_POST['testing_standards'] as $id_testing_standards) {
			$sql_add_testing_standards = "INSERT INTO product_type_testing_std VALUES ('','$id', '$id_testing_standards')";
			$result = mysqli_query($con, $sql_add_testing_standards);
		}

		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../product-type.php");
	} else {
		header("Location: ../product-type-edit.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
