<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		
		$Id_employee = $_POST["employee"];
		$created = date("Y/m/d");
		$modified = date("Y/m/d");

		
		$sql_add = "INSERT INTO Customer_Inspection_Co_Ordinator(Id_employee, Created, Modified) VALUES ('$Id_employee','$created','$modified')";
		$result = mysqli_query($con, $sql_add);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_cm-coordinators.php");
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>