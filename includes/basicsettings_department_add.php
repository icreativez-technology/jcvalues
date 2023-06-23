<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$department_name = $_POST["title"];
		$status = 'Active';		

		$isExists = "SELECT * FROM Basic_Department WHERE Department = '$department_name'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
			
		$sql_add = "INSERT INTO Basic_Department(Department, Status) VALUES ('$department_name', '$status')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		unset($_SESSION['error']);
		header("Location: ../admin_department-panel.php");
		}else {
			header("Location: ../admin_department-panel.php?exist");
		}		
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>