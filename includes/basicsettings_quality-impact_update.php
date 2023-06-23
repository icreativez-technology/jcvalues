<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];
		$title = $_POST["title"];
		//$status = $_POST["status"];	
		
		//update 
		$isExists = "SELECT * FROM Quality_Impact_Area WHERE Title = '$title' AND Id_quality_impact_area != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
	
		$sql = "UPDATE Quality_Impact_Area SET Title = '$title' WHERE Id_quality_impact_area = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_quality-impact.php");
	}else{
		header("Location: ../admin_quality-impact-edit.php?pg_id=$id&exist");
	}
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}