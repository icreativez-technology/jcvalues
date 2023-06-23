<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$email = $_POST["email"];
	$password = $_POST["password"];
	$sql = "SELECT * From Basic_Employee Where Email LIKE '$email' AND Password LIKE '$password'";
	$result = mysqli_query($con, $sql);
	$datos = mysqli_num_rows($result);
	if ($datos == 1) {
		$userInfo = mysqli_fetch_assoc($result);
		if ($userInfo['is_blocked'] == 1) {
			$_SESSION['LAST_ATTEMPT'] = time();
			return header("Location: ../sign-in.php");
		}
		$_SESSION['usuario'] = $email;
		if (!empty($_POST["remember"])) {
			setcookie("usermail", $_POST["email"], time() + (10 * 365 * 24 * 60 * 60));
			setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
		} else {
			if (isset($_COOKIE["usermail"])) {
				setcookie("usermail", "");
				if (isset($_COOKIE["userpassword"])) {
					setcookie("userpassword", "");
				}
			}
		}
		unset($_SESSION['LOGIN_ATTEMPT']);
		unset($_SESSION['LAST_ATTEMPT']);

		if(isset($_SESSION['page'])){
			header("Location: ".$_SESSION['page']);
		}
		else{
			header("Location: ../index.php");
		}
	} else {
		if (isset($_SESSION['LOGIN_ATTEMPT'])) {
			$_SESSION['LOGIN_ATTEMPT'] = $_SESSION['LOGIN_ATTEMPT'] + 1;
			if ($_SESSION['LOGIN_ATTEMPT'] > 2) {
				unset($_SESSION['LOGIN_ATTEMPT']);
				$_SESSION['LAST_ATTEMPT'] = time();
				$sql = "SELECT * From Basic_Employee Where Email LIKE '$email'";
				$result = mysqli_query($con, $sql);
				$datos = mysqli_num_rows($result);
				if ($datos == 1) {
					$updateSql = "UPDATE Basic_Employee SET is_blocked = 1 WHERE Email LIKE '$email'";
					$updateSqlResult = mysqli_query($con, $updateSql);
				}
			}
		} else {
			$_SESSION['LOGIN_ATTEMPT'] = 1;
		}
		header("Location: ../sign-in.php");
	}
}
