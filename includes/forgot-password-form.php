<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$error = "";
	if (!$email) {
		return header("Location: ../forgot-password.php?emailerr");
	} else {
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$result = mysqli_query($con, $sql);
		if ($result->num_rows == 0) {
			return header("Location: ../forgot-password.php?usererr");
		} else {
			$userInfo = mysqli_fetch_assoc($result);
			$userId = $userInfo['Id_employee'];
			$reset_token = bin2hex(random_bytes(25));
			$updateSql = "UPDATE Basic_Employee SET reset_token = '$reset_token' WHERE Id_employee = '$userId' ";
			$result = mysqli_query($con, $updateSql);
			$output = '<p>Dear user,</p>';
			$output .= '<p>Please click on the following link to reset your password.</p>';
			$output .= '<p>-------------------------------------------------------------</p>';
			$output .= '<p><a href="http://'.$_SERVER["HTTP_HOST"].'/reset-password.php?token=' . $reset_token . '&email=' . $email . '" target="_blank">Password reset link</a></p>';
			$output .= '<p>-------------------------------------------------------------</p>';
			$output .= '<p>Please be sure to copy the entire link into your browser.</p>';
			$output .= '<p>If you did not request this reset password link, no action is needed, your password will not be reset. However, you may want to log into your account and change your security password as someone may have guessed it.</p>';
			$output .= '<p>Thanks,</p>';
			$output .= '<p>JC Valves Team</p>';
			$message = $output;
			$subject = "Password Recovery";

			$sendMail = mail($email, $subject, $message);

			if ($sendMail == true) {
				return header("Location: ../sign-in.php");
			} else {
				return header("Location: ../forgot-password.php?mailerr");
			}
		}
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
