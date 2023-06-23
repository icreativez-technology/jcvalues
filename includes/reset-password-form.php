<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	$reset_token = isset($_POST["reset_token"]) ? $_POST["reset_token"] : "";
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!$email) {
		return header("Location: ../reset-password.php?invalid");
	} else {
		$sql = "SELECT * From Basic_Employee Where Email = '$email' AND reset_token = '$reset_token'";
		$result = mysqli_query($con, $sql);
		if ($result->num_rows == 0) {
			return header("Location: ../reset-password.php?invalid");
		} else {
			if ($password != $confirm_password) {
				return header("Location: ../reset-password.php?token=" . $reset_token . "&email=" . $email . "&passworderr");
			} else {
				$userInfo = mysqli_fetch_assoc($result);
				$userId = $userInfo['Id_employee'];
				$updateSql = "UPDATE Basic_Employee SET password = '$password' WHERE Id_employee = '$userId' ";
				$result = mysqli_query($con, $updateSql);
				return header("Location: ../sign-in.php");
			}
		}
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
