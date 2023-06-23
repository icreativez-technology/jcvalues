<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$email_new_user = $_POST["email"];
	$plant = $_POST["plant"];
	$department = $_POST["department"];
	$department_head = $_POST["department_head"];

	$sql_new_user = "SELECT Email, Password, Id_employee From Basic_Employee Where Email LIKE '$email_new_user'";
	$result_new_user = mysqli_query($con, $sql_new_user);
	$datos_new_user = mysqli_num_rows($result_new_user);

	$deptHeadExist = 0;
	if ($department_head == 'Yes') {
		$deptHeadSql = "SELECT * From Basic_Employee Where Id_plant = '$plant' AND id_department = '$department' AND Department_Head = 'Yes'";
		$deptHead = mysqli_query($con, $deptHeadSql);
		$deptHeadExist = $deptHead->num_rows;
	}
	if ($datos_new_user == 0) {
		if ($deptHeadExist == 0) {

			$first_name = $_POST["first_name"];
			$last_name = $_POST["last_name"];
			$email = $_POST["email"];
			$rol = $_POST["rol"];
			$plant_head = $_POST["plant_head"];
			$management_representatives = $_POST["management_representatives"];
			$Customer_Compliants_Representatives = $_POST["Customer_Compliants_Representatives"];
			$status = $_POST["status"];

			if ($_FILES) {
				/*UPLOAD AVATAR IMAGE*/
				if ($_FILES["file_avatar"]["size"] > 1000000 or $_FILES["file_avatar"]["size"] <= 0) {
					/*Size too big or inexistent, default avatar is set*/
					$file_avatar = 'blank.png';
				} else {
					$path = "../assets/media/avatars/";
					$time = md5(time());
					$file_avatar = $first_name . $time . ".jpg";
					$completefilenameandpath = $path . $file_avatar;
					move_uploaded_file($_FILES["file_avatar"]["tmp_name"], $completefilenameandpath);
				}

				/*END UPLOAD*/
			} else {
				/*Default avatar is set*/
				$file_avatar = 'blank.png';
			}
			//$file_avatar = 'blank.png';

			//Generar password
			$bytes = openssl_random_pseudo_bytes(4);
			$pass = bin2hex($bytes);
			//$pass = '12345';
			/*title*/
			$title = 'title';
			/*Dates*/
			$created = date("Y/m/d");
			$modified = date("Y/m/d");

			//$custom_id temporal;
			$custom_id = 'CID';

			$sql = "INSERT INTO Basic_Employee (
				First_Name, 
				Last_Name, 
				Email, 
				Id_plant, 
				Id_department, 
				Admin_User, 
				Plant_Head, 
				Department_Head, 
				Management_Representative, 
				Customer_Compliants_Representatives, 
				Password, 
				Title, 
				Created, 
				Modified,
				Status,
				Avatar_img, 
				Custom_ID 
			) VALUES (
				'$first_name', 
				'$last_name', 
				'$email', 
				'$plant', 
				'$department', 
				'$rol', 
				'$plant_head', 
				'$department_head', 
				'$management_representatives', 
				'$Customer_Compliants_Representatives', 
				'$pass', 
				'$title', 
				'$created', 
				'$modified', 
				'$status', 
				'$file_avatar', 
				'$custom_id'
			)";
			// print_r($sql);
			$result = mysqli_query($con, $sql);

			//GENERAR CUSTOM ID:
			$sql_data = "SELECT Id_employee FROM Basic_Employee WHERE Email LIKE '$email'";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);

			$customid_postfix = $result_data['Id_employee'];

			if ($result_data['Id_employee'] <= 999) {
				$customid_postfix = "0" . $customid_postfix;
				if ($result_data['Id_employee'] <= 99) {
					$customid_postfix = "0" . $customid_postfix;
					if ($result_data['Id_employee'] <= 9) {
						$customid_postfix = "0" . $customid_postfix;
					}
				}
			}

			$custom_id = 'DQMS-' . $customid_postfix;

			$sql_id = "UPDATE Basic_Employee SET Custom_ID = '$custom_id' WHERE Email = '$email' ";


			$result_id = mysqli_query($con, $sql_id);

			/*FIN CUSTOM ID*/

			/*Role Table*/

			if ($rol == "Administrator") {
				/*Is an admin*/
				$basic_role = 2;
			} else if ($rol == "Super Administrator") {
				/*Is an Employee*/
				$basic_role = 1;
			} else {
				/*Is an Employee*/
				$basic_role = 3;
			}

			$sql_data = "SELECT Id_employee FROM Basic_Employee WHERE Email LIKE '$email'";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);

			$usuario = $result_data['Id_employee'];

			$sql = "INSERT INTO Basic_Role_Employee VALUES ('$basic_role','$usuario')";
			$result = mysqli_query($con, $sql);

			/* FIN ROLE TABLE */

			//Enviar mail al usuario

			$para      = $_POST["email"];
			$titulo    = 'New user for DQMS system';
			$mensaje   = 'Hello, you have been asigned as an Employee for <a href="https://jc-valves.dqms.pro/"">jc-valves.dqms.pro</a>. Find below the user data:<br />';
			$mensaje   = $mensaje . "<br />- User: " . $_POST["email"];
			$mensaje   = $mensaje . "<br />- Password: " . $pass;
			$mensaje   = $mensaje . "<br /><br />You can change the default password once you have logged in, at your account settings.";
			$cabeceras = 'Content-Type: text/html; From: D-QMS@jc-valves.com';

			mail($para, $titulo, $mensaje, $cabeceras);

			echo "<script type='text/javascript'>alert('Success!');</script>";

			header("Location: ../admin_user-panel.php");
		} else {
			header("Location: ../admin_user-add.php?deptHeadExist");
		}
	} else {
		header("Location: ../admin_user-add.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}