<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["pg_id"];
	$email = $_POST["email"];
	$department_head = $_POST["department_head"];
	$plant = $_POST["plant"];
	$department = $_POST["department"];
	$isExists = "SELECT Id_employee FROM Basic_Employee WHERE Email = '$email' AND Id_employee != '$id'";
	$result = mysqli_query($con, $isExists);

	$deptHeadExist = 0;
	if ($department_head == 'Yes') {
		$deptHeadSql = "SELECT * From Basic_Employee Where Id_plant = '$plant' AND id_department = '$department' AND Department_Head = 'Yes'";
		$deptHead = mysqli_query($con, $deptHeadSql);
		$deptHeadExist = $deptHead->num_rows;
	}

	if ($result->num_rows == 0) {
		if ($deptHeadExist == 0) {
			/*Comprobar EMAIL*/
			$sql_data = "SELECT Id_employee, Email From Basic_Employee WHERE Id_employee = '$id'";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);

			/*We check if the email has changed*/
			if ($result_data['Email'] != $_POST["email"]) {
				$email_new_user = $_POST["email"];
				$sql_new_user = "SELECT Email, Password, Id_employee From Basic_Employee Where Email LIKE '$email_new_user'";
				$result_new_user = mysqli_query($con, $sql_new_user);
				$datos_new_user = mysqli_num_rows($result_new_user);
				if ($datos_new_user != 0) {
					/*Email is in use, so we keep the old one in order to not fail the entire modification*/
					$_POST["email"] = $result_data['Email'];
				}
			}



			$first_name = $_POST["first_name"];
			$last_name = $_POST["last_name"];
			$email = $_POST["email"];
			$rol = $_POST["rol"];
			$plant_head = $_POST["plant_head"];
			$management_representatives = $_POST["management_representatives"];
			$Customer_Compliants_Representatives = $_POST["Customer_Compliants_Representatives"];
			$status = $_POST["status"];
			$is_blocked = isset($_POST["is_blocked"]) ? 0 : 1;
			$modified = date("Y/m/d");

			$sql = "UPDATE Basic_Employee SET First_Name = '$first_name', Last_Name = '$last_name', Email = '$email', Id_plant = '$plant', Id_department = '$department', Admin_User = '$rol', Plant_Head = '$plant_head', Department_Head = '$department_head', Management_Representative = '$management_representatives', Customer_Compliants_Representatives = '$Customer_Compliants_Representatives', Status = '$status', is_blocked = '$is_blocked', Modified = '$modified' WHERE Id_employee = '$id' ";
			$result = mysqli_query($con, $sql);


			if ($_POST['password']) {
				$password = $_POST["password"];
				/*UPDATE PASS IF THEY ENTERED A NEW ONE*/
				$sql = "UPDATE Basic_Employee SET Password = '$password' WHERE Id_employee = '$id' ";
				$result = mysqli_query($con, $sql);
			}

			if ($_FILES) {
				/*UPLOAD AVATAR IMAGE*/
				if ($_FILES["file_avatar"]["size"] > 1000000 or $_FILES["file_avatar"]["size"] <= 0) {
					/*Size too big or inexistent, do nothing*/
				} else {
					$path = "../assets/media/avatars/";
					$time = md5(time());
					$file_avatar = $first_name . $time . ".jpg";
					$completefilenameandpath = $path . $file_avatar;
					move_uploaded_file($_FILES["file_avatar"]["tmp_name"], $completefilenameandpath);

					/*Delete old file*/

					$sql_data = "SELECT Avatar_img From Basic_Employee WHERE Id_employee = '$id'";
					$connect_data = mysqli_query($con, $sql_data);
					$result_data = mysqli_fetch_assoc($connect_data);

					$oldavatar = $result_data['Avatar_img'];

					/*Only delete file if its not the default avatar*/
					if ($oldavatar != "blank.png") {
						$url = "../assets/media/avatars/" . $oldavatar;
						unlink($url);
					}


					/*End delete old file*/

					/*UPDATE IN DATABASE*/
					$sql = "UPDATE Basic_Employee SET Avatar_img = '$file_avatar' WHERE Id_employee = '$id' ";
					$result = mysqli_query($con, $sql);
				}

				/*END UPLOAD*/
			}

			/*Role Table*/
			if ($rol == "Administrator") {
				/*Is an admin*/
				$basic_role = 2;
			} else if ($rol == "Super Administrator") {
				/*Is an admin*/
				$basic_role = 1;
			} else {
				/*Is an Employee*/
				$basic_role = 3;
			}

			$sql = "UPDATE Basic_Role_Employee SET Id_basic_role = '$basic_role' WHERE Id_employee = '$id' ";
			$result = mysqli_query($con, $sql);

			/* FIN ROLE TABLE */

			echo "<script type='text/javascript'>alert('Success!');</script>";

			header("Location: ../admin_user-panel.php");
		} else {
			header("Location: ../admin_user-edit.php?pg_id=$id&deptHeadExist");
		}
	} else {
		header("Location: ../admin_user-edit.php?pg_id=$id&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
