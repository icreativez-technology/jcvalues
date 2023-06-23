<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$title_document = $_POST["title_document"];
	$formatno = $_POST["formatno"];
	$revno = $_POST["revno"];
	$prep = $_POST["prep"];
	$rev = $_POST["rev"];
	$approv = $_POST["approv"];
	$date_prep = $_POST["date_prep"];
	$date_rev = $_POST["date_rev"];
	$date_approv = $_POST["date_approv"];
	$category = $_POST["category"];
	$remarks = $_POST["remarks"];
	$langauage = $_POST['language'];
	$isExists = "SELECT Id_document FROM Document WHERE Format_No = '$formatno' AND language = '$_POST[language]'";
	$result = mysqli_query($con, $isExists);
	$lang_ext = $_POST['language'] ? 'SP' : 'EN';
	if ($result->num_rows == 0) {


		$target_dir = "../document-manager/" . $category . "/";
		$target_file = $target_dir . basename($_FILES["file_docu"]["name"]);
		$randomName =  $_POST["formatno"] . '_' . $lang_ext;
		$fileName  = $randomName . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$destinationFolder = $target_dir . $fileName;

		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		if (!is_dir("../document-manager/" . $category)) {
			header("Location: ../documentation_add_file.php?notFolder");
			$uploadOk = 0;
		}

		if ($prep == $rev && $rev == $approv && $approv == $prep) {
			header("Location: ../documentation_add_file.php?notUnique");
			$uploadOk = 0;
		}

		// Comprobar si el archivo ya existe
		if (file_exists($fileName)) {
			header("Location: ../documentation_add_file.php?fileExist");
			$uploadOk = 0;
		}


		// Comprobar tamaña del PDF
		if ($_FILES["file_docu"]["size"] > 10000000) {
			header("Location: ../documentation_add_file.php?sizeLarge");
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "<script type='text/javascript'>alert('The document could not be uploaded.'); setTimeout( function() { window.location.href = '/documentation_add_file.php'; }, 3000 );</script>";
			// Cargar archivo
		} else {
			if (move_uploaded_file($_FILES["file_docu"]["tmp_name"], $destinationFolder)) {


				$sql = "INSERT INTO Document VALUES ('', '$title_document', '$formatno', '$revno', '$prep', '$rev', '$approv', '$date_prep', '$date_rev', '$date_approv', '$fileName', '$remarks', '$category','$langauage')";
				$result = mysqli_query($con, $sql);
				$Id_document = mysqli_insert_id($con);

				if ($result) {

					$sql_historial = "INSERT INTO Document_historial VALUES ('','$Id_document', '$title_document', '$formatno', '$revno', '$prep', '$rev', '$approv', '$date_prep', '$date_rev', '$date_approv', '$fileName', '$remarks', '$category','$langauage')";
					$result_historial = mysqli_query($con, $sql_historial);

					header("Location: ../documentation.php");
				}
			}
		}
	} else {
		header("Location: ../documentation_add_file.php?exist");
	}
}