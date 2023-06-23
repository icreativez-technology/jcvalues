<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$fetch = mysqli_query($con, $sql);
		$userInfo = mysqli_fetch_assoc($fetch);
		$userId = $userInfo['Id_employee'];
		$po_number = $_POST["po_number"];
		$supplier_id = $_POST["supplier_id"];
		$po_date = $_POST["po_date"];
		$po_revision = $_POST["po_revision"];
		$material_certificate_number = $_POST["material_certificate_number"];
		$mtc_date = $_POST["mtc_date"];
		$mtc_revision = (int)$_POST["mtc_revision"] + 1;
		$item_code = $_POST["item_code"];
		$size_id = $_POST["size_id"];
		$material_specification_id = $_POST["material_specification_id"];
		$drawing_number = $_POST["drawing_number"];
		$class_id = $_POST["class_id"];
		$component_id = $_POST["component_id"];
		$material_certification_type = $_POST["material_certification_type"];
		$certificate_type_id = $_POST["certificate_type_id"];
		$heat_number = $_POST["heat_number"];
		$qty = $_POST["qty"];
		$certificate_id = $_POST["certificate_id"];
		$makeViewSql = "UPDATE supplier_certificates SET is_editable = 0 WHERE certificate_id = '$certificate_id' ";
		$makeViewSqlResult = mysqli_query($con, $makeViewSql);
		$certificateAdd = "INSERT INTO supplier_certificates (certificate_id, po_number, supplier_id, po_date, po_revision, material_certificate_number, mtc_date, mtc_revision, item_code, size_id, material_specification_id, drawing_number, class_id, component_id, material_certification_type, certificate_type_id, heat_number, qty, created_by) VALUES ('$certificate_id', '$po_number', '$supplier_id', '$po_date', '$po_revision', '$material_certificate_number', '$mtc_date', '$mtc_revision', '$item_code', '$size_id', '$material_specification_id', '$drawing_number', '$class_id', '$component_id', '$material_certification_type', '$certificate_type_id', '$heat_number', '$qty', '$userId')";
		$certificateAddResult = mysqli_query($con, $certificateAdd);
		$supplier_certificate_id = mysqli_insert_id($con);
		if ($certificate_type_id == 1) {
			if ($_FILES["file"]["name"]) {
				$directory = '../certificates';
				if (!is_dir($directory)) {
					mkdir($directory);
					chmod($directory, 0777);
				}
				$targetFile = $directory . basename($_FILES["file"]["name"]);
				$fileName = $material_certificate_number . '-' . $mtc_revision . '.' . strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
				$destinationFolder = $directory . "/" . $fileName;
				move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
				$filePath = "certificates/" . $fileName;
				$originalCertificateAdd = "INSERT INTO original_certificates (supplier_certificate_id, file_path) VALUES ('$supplier_certificate_id', '$filePath')";
				$originalCertificateAddResult = mysqli_query($con, $originalCertificateAdd);
			} else {
				$filePath = "certificates/" . $_POST["file_name"];
				$originalCertificateAdd = "INSERT INTO original_certificates (supplier_certificate_id, file_path) VALUES ('$supplier_certificate_id', '$filePath')";
				$originalCertificateAddResult = mysqli_query($con, $originalCertificateAdd);
			}
		} else {
			$melting_process = $_POST["melting_process"];
			$other_specs_agreed = $_POST["other_specs_agreed"];
			$sql = "UPDATE supplier_certificates SET melting_process = '$melting_process', other_specs_agreed = '$other_specs_agreed' WHERE id = '$supplier_certificate_id' ";
			$sqlResult = mysqli_query($con, $sql);
			$chemicals = $_POST["chemical_id"];
			$actualChemicals = $_POST["actual_chemical"];
			foreach ($chemicals as $key => $val) {
				if ($val != "") {
					$addChemicalSql = "INSERT INTO supplier_certificate_actual_chemicals (supplier_certificate_id, chemical_id, actual) VALUES ('$supplier_certificate_id', '$val', '$actualChemicals[$key]')";
					$addChemicalSqlConnect = mysqli_query($con, $addChemicalSql);
				}
			}
			$type_of_testArr = $_POST["type_of_test"];
			$resultArr = $_POST["result"];
			foreach ($type_of_testArr as $key => $val) {
				if ($val != "" || $resultArr[$key] != "") {
					$addSpecialTestSql = "INSERT INTO supplier_certificate_special_tests (supplier_certificate_id, type_of_test, result) VALUES ('$supplier_certificate_id', '$val', '$resultArr[$key]')";
					$addSpecialTestConnect = mysqli_query($con, $addSpecialTestSql);
				}
			}
			$heat_treatment_id = $_POST["heat_treatment_id"];
			$heat_notes = $_POST["heat_notes"];
			if ($heat_treatment_id != null && $heat_notes != "") {
				$addHeatSql = "INSERT INTO supplier_certificate_heat_notes (supplier_certificate_id, heat_treatment_id, heat_notes) VALUES ('$supplier_certificate_id', '$heat_treatment_id', '$heat_notes')";
				$addHeatSqlConnect = mysqli_query($con, $addHeatSql);
			}

			$actual_tensile_strength = $_POST["actual_tensile_strength"];
			$actual_yield_strength = $_POST["actual_yield_strength"];
			$actual_elongation = $_POST["actual_elongation"];
			$actual_reduction_area = $_POST["actual_reduction_area"];
			$addTensileSql = "INSERT INTO supplier_certificate_tensile_test (supplier_certificate_id, actual_tensile_strength, actual_yield_strength, actual_elongation, actual_reduction_area) VALUES ('$supplier_certificate_id', '$actual_tensile_strength', '$actual_yield_strength', '$actual_elongation', '$actual_reduction_area')";
			$addTensileSqlConnect = mysqli_query($con, $addTensileSql);

			$hardness_result_1 = $_POST["hardness_result_1"];
			$hardness_result_2 = $_POST["hardness_result_2"];
			$hardness_result_3 = $_POST["hardness_result_3"];
			$actual_hardness_test_limit = $_POST["actual_hardness_test_limit"];
			$addHardnessSql = "INSERT INTO supplier_certificate_hardness_test (supplier_certificate_id, result1, result2, result3, average) VALUES ('$supplier_certificate_id', '$hardness_result_1', '$hardness_result_2', '$hardness_result_3', '$actual_hardness_test_limit')";
			$addHardnessSqlConnect = mysqli_query($con, $addHardnessSql);

			if ($_POST["impact_status"]) {
				$impact_result_1 = $_POST["impact_result_1"];
				$impact_result_2 = $_POST["impact_result_2"];
				$impact_result_3 = $_POST["impact_result_3"];
				$actual_impact_test_limit = $_POST["actual_impact_test_limit"];
				$addImpactSql = "INSERT INTO supplier_certificate_impact_test (supplier_certificate_id, result1, result2, result3, average) VALUES ('$supplier_certificate_id', '$impact_result_1', '$impact_result_2', '$impact_result_3', '$actual_impact_test_limit')";
				$addImpactSqlConnect = mysqli_query($con, $addImpactSql);
			}
		}

		// echo "<script type='text/javascript'>alert('Success!');</script>";
		// header("Location: ../supplier-mtc.php");
		echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
