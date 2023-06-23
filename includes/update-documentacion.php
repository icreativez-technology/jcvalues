<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$Id_document = $_POST["Id_document"];
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
	$file_old = $_POST['file_old'];
	$language = $_POST['language'];
	$lang_ext = $_POST['language'] ? 'SP' : 'EN';

	if ($_FILES["file_docu"]["name"] != null) {
		//Add Documentatio
		$target_dir = "../document-manager/" . $category . "/";
		$target_file = $target_dir . basename($_FILES["file_docu"]["name"]);
		$randomName = $formatno . '_' . $lang_ext;
		$fileName  = $randomName . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$destinationFolder = $target_dir . $fileName;
		$delete_file = "../document-manager/" . $category . '/' . $file_old;

		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		if (file_exists($delete_file)) {
			unlink($delete_file);
		}

		if (!is_dir("../document-manager/" . $category)) {
			header("Location: ../documentation_edit_file.php?name=" . $file_old . "&notFolder=1");
			$uploadOk = 0;
		}

		if ($prep == $rev && $rev == $approv && $approv == $prep) {
			header("Location: ../documentation_edit_file.php?name=" . $file_old . "&notUnique=1");
			$uploadOk = 0;
		}

		// Comprobar si el archivo ya existe
		if (file_exists($fileName)) {
			header("Location: ../documentation_edit_file.php?name=" . $file_old . "&fileExist=1");
			$uploadOk = 0;
		}

		// Comprobar tamaña del PDF
		if ($_FILES["file_docu"]["size"] > 10000000) {
			header("Location: ../documentation_edit_file.php?name=" . $file_old . "&sizeLarge=1");
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$sql_datos_document = "SELECT * From Document WHERE Id_document = '$Id_document'";
			$conect_datos_document = mysqli_query($con, $sql_datos_document);
			$result_datos_document = mysqli_fetch_assoc($conect_datos_document);
			echo "<script type='text/javascript'>alert('The document could not be uploaded');</script>";
			header('refresh:1; url=../documentation_edit_file.php?' . $result_datos_document['File']);
			// Cargar archivo
		} else {
			if (move_uploaded_file($_FILES["file_docu"]["tmp_name"], $destinationFolder)) {
				//update 
				$updatedRev_no = intval($revno) + 1;
				$sql = "UPDATE Document SET Rev_No = '$updatedRev_no', Prepared_by = '$prep', Reviewd_by = '$rev', Approved_by = '$approv', Date_of_preparation = '$date_prep', Date_of_revision = '$date_rev', 	Date_of_approval = '$date_approv', Remarks = '$remarks', File = '$fileName', language = '$language' WHERE Id_document = $Id_document";
				$result = mysqli_query($con, $sql);
				if (mysqli_affected_rows($con) == 1) {
					$sql_historial = "INSERT INTO Document_historial VALUES ('','$Id_document', '$title_document', '$formatno', '$revno', '$prep', '$rev', '$approv', '$date_prep', '$date_rev', '$date_approv', '$fileName', '$remarks', '$category', '$langauge')";
					$result_historial = mysqli_query($con, $sql_historial);
					header("Location: ../documentation.php");
				}
			}
		}
	}
}