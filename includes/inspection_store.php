<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$order_ref = $_POST["order_ref"];
		$isExistSql = "SELECT id FROM inspection WHERE order_ref = '$order_ref' AND is_deleted = 0";
		$isExist = mysqli_query($con, $isExistSql);
		if ($isExist->num_rows == 0) {
			if (isset($_POST["item_no"])) {
				$email = $_SESSION['usuario'];
				$sql = "SELECT * From Basic_Employee Where Email = '$email'";
				$fetch = mysqli_query($con, $sql);
				$userInfo = mysqli_fetch_assoc($fetch);
				$created_by = $userInfo['Id_employee'];
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
				$prefix = "CINS-";
				$uniqueIdSql = "SELECT unique_id FROM inspection order by id DESC LIMIT 1";
				$uniqueIdConnect = mysqli_query($con, $uniqueIdSql);
				$uniqueIdInfo = mysqli_fetch_assoc($uniqueIdConnect);
				$uniqueId = (isset($uniqueIdInfo['unique_id'])) ? $uniqueIdInfo['unique_id'] : null;
				$length = 4;
				if (!$uniqueId) {
					$og_length = $length - 1;
					$last_number = '1';
				} else {
					$code = substr($uniqueId, strlen($prefix));
					$increment_last_number = ((int)$code) + 1;
					$last_number_length = strlen($increment_last_number);
					$og_length = $length - $last_number_length;
					$last_number = $increment_last_number;
				}
				$zeros = "";
				for ($i = 0; $i < $og_length; $i++) {
					$zeros .= "0";
				}
				$unique_id = $prefix . $zeros . $last_number;
				$directory = "../inspection/" . $unique_id;
				if (!file_exists($directory)) {
					mkdir($directory, 0777, true);
				}
				$file_name = $_FILES["file"]["name"];
				$targetFile = $directory . basename($file_name);
				$destinationFolder = $directory . "/" . $file_name;
				move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
				$file_path = "inspection/" . $unique_id . "/" . $file_name;
				$addSql = "INSERT INTO inspection (unique_id, from_date, to_date, customer, customer_po, order_ref, notification_no, manufacturer, stage_of_inspection, location, project_name, equipment_description, itp_number, revision, itp_activity, contact_person, email, location_of_inspection, created_by, file_name, file_path) VALUES ('$unique_id', '$from_date', '$to_date', '$customer', '$customer_po', '$order_ref', '$notification_no', '$manufacturer', '$stage_of_inspection', '$location', '$project_name', '$equipment_description', '$itp_number', '$revision', '$itp_activity', '$contact_person', '$email', '$location_of_inspection', '$created_by', '$file_name', '$file_path')";
				$addSqlResult = mysqli_query($con, $addSql);
				$inspection_id = mysqli_insert_id($con);
				$item_noArr = $_POST["item_no"];
				$tag_noArr = $_POST["tag_no"];
				$hr_noArr = $_POST["hr_no"];
				$typeArr = $_POST["type"];
				$sizeArr = $_POST["size"];
				$boreArr = $_POST["bore"];
				$classArr = $_POST["class"];
				$materialArr = $_POST["material"];
				$qtyArr = $_POST["qty"];
				foreach ($item_noArr as $key => $val) {
					$addListSql = "INSERT INTO inspection_product_details (inspection_id, item_no, tag_no, hr_no, type, size, bore, class, material, qty) 
				VALUES ('$inspection_id', '$item_noArr[$key]', '$tag_noArr[$key]', '$hr_noArr[$key]', '$typeArr[$key]', '$sizeArr[$key]', '$boreArr[$key]', '$classArr[$key]', '$materialArr[$key]', '$qtyArr[$key]')";
					$addListConnect = mysqli_query($con, $addListSql);
				}
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../inspection_view_list.php");
			} else {
				header("Location: ../inspection_add.php?product");
			}
		} else {
			header("Location: ../inspection_add.php?exist");
		}
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
