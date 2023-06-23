<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$title = $_POST["title"];
		$created = date("Y/m/d");
		$modified = date("Y/m/d");
		$status = "Active";
		
	$isExists = "SELECT * FROM Basic_Product_Group WHERE title = '$title'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		$sql_add = "INSERT INTO Basic_Product_Group (Title, Created, Modified, Status)VALUES ('$title', '$created', '$modified', '$status')";
		$result = mysqli_query($con, $sql_add);
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../admin_productgroup-panel.php");
		}
		else {
			header("Location: ../admin_productgroup-panel.php?exist");
		}		  
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>