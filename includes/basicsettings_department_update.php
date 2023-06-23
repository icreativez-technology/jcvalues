<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{


		$id = $_POST["pg_id"];
		$department_name = $_POST["department_name"];
		$status = $_POST["status"];		
		
		$isExists = "SELECT * FROM Basic_Department WHERE Department = '$department_name' AND Id_department != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {

		//update 
		$sql = "UPDATE Basic_Department SET Department = '$department_name', Status = '$status' WHERE Id_department = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		unset($_SESSION['error']);
		header("Location: ../admin_department-panel.php");
	}else {
		header("Location: ../admin_department-edit.php?pg_id=$id&exist");
	}		
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>