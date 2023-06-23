<?php

session_start();
include('functions.php');
print_r($_POST);

if($_SERVER["REQUEST_METHOD"] == "POST")
	{	

		$email_new_user = $_POST["email"];

		$sql_new_user = "SELECT Email, Password, Id_employee From Basic_Employee Where Email LIKE '$email_new_user'";
		$result_new_user = mysqli_query($con, $sql_new_user);
		$datos_new_user = mysqli_num_rows($result_new_user);

		if($datos_new_user == 0)
		{

			$firts_name = $_POST["First_Name"];
			$last_name = $_POST["Last_Name"];
			$email = $_POST["email"];
			//Generar password
			$bytes = openssl_random_pseudo_bytes(4);
			$pass = bin2hex($bytes);

			$sql = "INSERT INTO Basic_Employee (First_Name, Last_Name, Email, Admin_User, Password ) VALUES ('$firts_name', '$last_name', '$email', 'Employee', '$pass')";

			$result = mysqli_query($con, $sql);

			$datos = mysqli_num_rows($result);
			$id_usario = $usario['Id_employee'];
			
			

		}

		
	}

?>