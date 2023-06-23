<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$title = $_POST["title"];
		$isExists = "SELECT * FROM Quality_MoC_Type WHERE Title = '$title'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
	
		$sql_add1 = "INSERT INTO Quality_MoC_Type(Title) VALUES ('$title')";
		$result1 = mysqli_query($con, $sql_add1);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_quality-moc.php");
	}else{
		header("Location: ../admin_quality-moc.php?exist");
	}
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}