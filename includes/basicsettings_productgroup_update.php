<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$id = $_POST["pg_id"];
		$title = $_POST["title"];
		$modified = date("Y/m/d");
		$status = $_POST["status"];		
		
		
		/*$sql_add = "INSERT INTO Basic_Product_Group VALUES ('','$title', '$created', '$modified', '$status')";
		$result = mysqli_query($con, $sql_add);*/

		//update 
		$isExists = "SELECT * FROM Basic_Product_Group WHERE title = '$title' AND Id_product_group != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
	
		$sql = "UPDATE Basic_Product_Group SET Title = '$title', Modified = '$modified', Status = '$status' WHERE Id_product_group = '$id' ";
		$result = mysqli_query($con, $sql);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../admin_productgroup-panel.php");
	}else {
		header("Location: ../admin_productgroup-edit.php?pg_id=$id&exist");
	}		
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>