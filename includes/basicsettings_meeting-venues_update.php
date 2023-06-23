<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];
		$title = $_POST["title"];
		$modified = date("Y/m/d");
		$status = $_POST["status"];	
		
		//update 
		$isExists = "SELECT * FROM Meeting_Venue WHERE Title = '$title' AND Id_meeting_venue != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
	
		$sql = "UPDATE Meeting_Venue SET Title = '$title', Modified = '$modified', Status = '$status' WHERE Id_meeting_venue = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_meeting-venues.php");
		}else{
			header("Location: ../admin_meeting-venues-edit.php?pg_id=$id&exist");
		}
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>