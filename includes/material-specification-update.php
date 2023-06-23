<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$material_specification_id = $_POST["material_specification_id"];
	$heat_treatment_id = $_POST["heat_treatment_id"];
	$heat_treatment = $_POST["heat_treatment"];
	$tensile_test_id = $_POST["tensile_test_id"];
	$hardness_test_id = $_POST["hardness_test_id"];
	$impact_test_id = $_POST["impact_test_id"];
	$material_specification = $_POST["material_specification"];
	$nom_comp = $_POST["nom_comp"];
	$nom_comp_old = $_POST["nom_comp_old"];
	$product_form = $_POST["product_form"];
	$uns = $_POST["uns"];
	$asme_ix_p_no = $_POST["asme_ix_p_no"];
	$asme_ix_group_no = $_POST["asme_ix_group_no"];
	$temperature_limit_min = $_POST["temperature_limit_min"];
	$temperature_limit_max = $_POST["temperature_limit_max"];
		if ($_SESSION['usuario']) {
			$email = $_SESSION['usuario'];
			$sql = "SELECT * From Basic_Employee Where Email = '$email'";
			$fetch = mysqli_query($con, $sql);
			$userInfo = mysqli_fetch_assoc($fetch);
			$userId = $userInfo['Id_employee'];

			if ($nom_comp_old != $nom_comp) {
				$specUpdate = "UPDATE material_specifications SET is_editable = 0 WHERE id = '$material_specification_id'";
				$specUpdateResult = mysqli_query($con, $specUpdate);
				$specAdd = "INSERT INTO material_specifications (material_specification, nom_comp, product_form, uns, asme_ix_p_no, asme_ix_group_no, temperature_limit_min, temperature_limit_max, created_by) VALUES ('$material_specification', '$nom_comp', '$product_form', '$uns', '$asme_ix_p_no', '$asme_ix_group_no', '$temperature_limit_min', '$temperature_limit_max', '$userId')";
				$specAddResult = mysqli_query($con, $specAdd);
				$material_specification_id = mysqli_insert_id($con);

				$tensile_strength_min = $_POST["tensile_strength_min"];
				$tensile_strength_max = $_POST["tensile_strength_max"];
				$yield_strength_min = $_POST["yield_strength_min"];
				$yield_strength_max = $_POST["yield_strength_max"];
				$elongation_min = $_POST["elongation_min"];
				$elongation_max = $_POST["elongation_max"];
				$reduction_area_min = $_POST["reduction_area_min"];
				$reduction_area_max = $_POST["reduction_area_max"];
				$tensileAdd = "INSERT INTO material_specification_tensile_test (material_specification_id, tensile_strength_min, tensile_strength_max, yield_strength_min, yield_strength_max, elongation_min, elongation_max, reduction_area_min, reduction_area_max, created_by) VALUES ('$material_specification_id', '$tensile_strength_min', '$tensile_strength_max', '$yield_strength_min', '$yield_strength_max', '$elongation_min', '$elongation_max', '$reduction_area_min', '$reduction_area_max', '$userId')";
				$tensileAddResult = mysqli_query($con, $tensileAdd);

				$hardness_mu = $_POST["hardness_mu"];
				$hardness_test_limit_min = $_POST["hardness_test_limit_min"];
				$hardness_test_limit_max = $_POST["hardness_test_limit_max"];
				$hardnessAdd = "INSERT INTO material_specification_hardness_test (material_specification_id, hardness_mu, hardness_test_limit_min, hardness_test_limit_max, created_by) VALUES ('$material_specification_id', '$hardness_mu', '$hardness_test_limit_min', '$hardness_test_limit_max', '$userId')";
				$hardnessAddResult = mysqli_query($con, $hardnessAdd);

				$impact_test_temperature = $_POST["impact_test_temperature"];
				$impact_test_limit_min = $_POST["impact_test_limit_min"];
				$impact_test_limit_max = $_POST["impact_test_limit_max"];
				$impact_test_status = isset($_POST["impact_test_status"]) ? 1 : 0;
				$impactAdd = "INSERT INTO material_specification_impact_test (material_specification_id, impact_test_temperature, impact_test_limit_min, impact_test_limit_max, status, created_by) VALUES ('$material_specification_id', '$impact_test_temperature', '$impact_test_limit_min', '$impact_test_limit_max', '$impact_test_status', '$userId')";
				$impactAddResult = mysqli_query($con, $impactAdd);

				$heatAdd = "INSERT INTO heat_treatments (material_specification_id, heat_treatment, created_by) VALUES ('$material_specification_id', '$heat_treatment', '$userId')";
				$heatAddResult = mysqli_query($con, $heatAdd);

				$chemicals = $_POST["chemical_id"];
				$checkedChemicals = $_POST["chemical_check_id"];
				$minArr = $_POST["minimum_value"];
				$maxArr = $_POST["maximum_value"];
				foreach ($chemicals as $key => $val) {
					$chemical_id = $chemicals[$key];
					$min_value = $minArr[$key];
					$max_value = $maxArr[$key];
					$status = ($checkedChemicals != null && in_array($chemicals[$key], $checkedChemicals)) ? 1 : 0;
					$linkChemical = "INSERT INTO material_specification_chemicals (material_specification_id, chemical_id, min_value, max_value, status, created_by) VALUES ('$material_specification_id', '$chemical_id', '$min_value', '$max_value', '$status', '$userId')";
					$linkChemicalResult = mysqli_query($con, $linkChemical);
				}

				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../material-specification.php");
			} else {
				$specUpdate = "UPDATE material_specifications SET material_specification = '$material_specification', nom_comp = '$nom_comp', product_form = '$product_form', uns = '$uns', asme_ix_p_no = '$asme_ix_p_no', asme_ix_group_no = '$asme_ix_group_no', temperature_limit_min = '$temperature_limit_min', temperature_limit_max = '$temperature_limit_max' WHERE id = '$material_specification_id'";
				$specUpdateResult = mysqli_query($con, $specUpdate);

				$tensile_strength_min = $_POST["tensile_strength_min"];
				$tensile_strength_max = $_POST["tensile_strength_max"];
				$yield_strength_min = $_POST["yield_strength_min"];
				$yield_strength_max = $_POST["yield_strength_max"];
				$elongation_min = $_POST["elongation_min"];
				$elongation_max = $_POST["elongation_max"];
				$reduction_area_min = $_POST["reduction_area_min"];
				$reduction_area_max = $_POST["reduction_area_max"];
				$tensileUpdate = "UPDATE material_specification_tensile_test SET tensile_strength_min = '$tensile_strength_min', tensile_strength_max = '$tensile_strength_max', yield_strength_min = '$yield_strength_min', yield_strength_max = '$yield_strength_max', elongation_min = '$elongation_min', elongation_max = '$elongation_max', reduction_area_min = '$reduction_area_min', reduction_area_max = '$reduction_area_max' WHERE id = '$tensile_test_id'";
				$tensileUpdateResult = mysqli_query($con, $tensileUpdate);

				$hardness_mu = $_POST["hardness_mu"];
				$hardness_test_limit_min = $_POST["hardness_test_limit_min"];
				$hardness_test_limit_max = $_POST["hardness_test_limit_max"];
				$hardnessUpdate = "UPDATE material_specification_hardness_test SET hardness_mu = '$hardness_mu', hardness_test_limit_min = '$hardness_test_limit_min', hardness_test_limit_max = '$hardness_test_limit_max' WHERE id = '$hardness_test_id'";
				$hardnessUpdateResult = mysqli_query($con, $hardnessUpdate);

				$impact_test_status = isset($_POST["impact_test_status"]) ? 1 : 0;
				$impact_test_temperature = $_POST["impact_test_temperature"];
				$impact_test_limit_min = $_POST["impact_test_limit_min"];
				$impact_test_limit_max = $_POST["impact_test_limit_max"];
				$impactUpdate = "UPDATE material_specification_impact_test SET impact_test_temperature = '$impact_test_temperature', impact_test_limit_min = '$impact_test_limit_min', impact_test_limit_max = '$impact_test_limit_max', status = '$impact_test_status' WHERE id = '$impact_test_id'";
				$impactUpdateResult = mysqli_query($con, $impactUpdate);

				$heatUpdate = "UPDATE heat_treatments SET heat_treatment = '$heat_treatment' WHERE id = '$heat_treatment_id'";
				$heatUpdateResult = mysqli_query($con, $heatUpdate);

				$id = $_POST["id"];
				$chemicals = $_POST["chemical_id"];
				$checkedChemicals = $_POST["chemical_check_id"];
				$minArr = $_POST["minimum_value"];
				$maxArr = $_POST["maximum_value"];
				foreach ($id as $key => $val) {
					$min_value = $minArr[$key];
					$max_value = $maxArr[$key];
					$status = ($checkedChemicals != null && in_array($chemicals[$key], $checkedChemicals)) ? 1 : 0;
					$chemicalUpdate = "UPDATE material_specification_chemicals SET min_value = '$min_value', max_value = '$max_value', status = '$status' WHERE id = '$id[$key]'";
					$chemicalUpdateResult = mysqli_query($con, $chemicalUpdate);
				}
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../material-specification.php");
			}
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}