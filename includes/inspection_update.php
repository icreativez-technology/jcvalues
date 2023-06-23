<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$id = $_POST["id"];
		$unique_id = $_POST["unique_id"];
		$order_ref = $_POST["order_ref"];
		$isExistSql = "SELECT id FROM inspection WHERE order_ref = '$order_ref' AND is_deleted = 0 AND id != '$id'";
		$isExist = mysqli_query($con, $isExistSql);
		if ($isExist->num_rows == 0) {
			if (isset($_POST["item_no"])) {
				$from_date = $_POST["from_date"];
				$to_date = $_POST["to_date"];
				$customer = $_POST["customer"];
				$customer_po = $_POST["customer_po"];
				$notification_no = $_POST["notification_no"];
				$manufacturer = $_POST["manufacturer"];
				$stage_of_inspection = $_POST["stage_of_inspection"];
				$location = $_POST["location"];
				$project_name = $_POST["project_name"];
				$equipment_description = $_POST["equipment_description"];
				$itp_number = $_POST["itp_number"];
				$revision = $_POST["revision"];
				$itp_activity = $_POST["itp_activity"];
				$contact_person = $_POST["contact_person"];
				$email = $_POST["email"];
				$location_of_inspection = $_POST["location_of_inspection"];
				$updateSql = "UPDATE inspection SET order_ref = '$order_ref', from_date = '$from_date', to_date = '$to_date', customer = '$customer', customer_po = '$customer_po', notification_no = '$notification_no', manufacturer = '$manufacturer', stage_of_inspection = '$stage_of_inspection', location = '$location', project_name = '$project_name', equipment_description = '$equipment_description', itp_number = '$itp_number', revision = '$revision', itp_activity = '$itp_activity', contact_person = '$contact_person', email = '$email', location_of_inspection = '$location_of_inspection', status = 'Scheduled' WHERE id = '$id'";
				$updateResult = mysqli_query($con, $updateSql);
				if ($_FILES['file']['name']) {
					if (isset($_POST['ext_file_path'])) {
						unlink("../" . $_POST['ext_file_path']);
					}
					$directory = "../inspection/" . $unique_id;
					if (!file_exists($directory)) {
						mkdir($directory, 0777, true);
					}
					$file_name = $_FILES["file"]["name"];
					$targetFile = $directory . basename($file_name);
					$destinationFolder = $directory . "/" . $file_name;
					move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
					$file_path = "inspection/" . $unique_id . "/" . $file_name;
					$updateSql = "UPDATE `inspection` SET `file_path` = '$file_path', `file_name` = '$file_name' WHERE (`id` = '$id')";
					$updateResult = mysqli_query($con, $updateSql);
				}
				$item_noArr = $_POST["item_no"];
				$tag_noArr = $_POST["tag_no"];
				$hr_noArr = $_POST["hr_no"];
				$typeArr = $_POST["type"];
				$sizeArr = $_POST["size"];
				$boreArr = $_POST["bore"];
				$classArr = $_POST["class"];
				$materialArr = $_POST["material"];
				$qtyArr = $_POST["qty"];
				$deleteListSql = "DELETE FROM inspection_product_details WHERE inspection_id = '$id'";
				$deleteListSqlResult = mysqli_query($con, $deleteListSql);
				foreach ($item_noArr as $key => $val) {
					$addListSql = "INSERT INTO inspection_product_details (inspection_id, item_no, tag_no, hr_no, type, size, bore, class, material, qty) 
				VALUES ('$id', '$item_noArr[$key]', '$tag_noArr[$key]', '$hr_noArr[$key]', '$typeArr[$key]', '$sizeArr[$key]', '$boreArr[$key]', '$classArr[$key]', '$materialArr[$key]', '$qtyArr[$key]')";
					$addListConnect = mysqli_query($con, $addListSql);
				}
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../inspection_edit.php?id=$id");
			} else {
				header("Location: ../inspection_edit.php?id=$id&product");
			}
		} else {
			header("Location: ../inspection_edit.php?id=$id&exist");
		}
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}