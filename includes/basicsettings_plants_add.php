<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$title = $_POST["title"];
		$created = date("Y/m/d");
		$modified = date("Y/m/d");
		$status = $_POST["status"];		
		
		$isExists = "SELECT * FROM Basic_Plant WHERE title = '$title'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
	
			$sql_add = "INSERT INTO Basic_Plant VALUES ('','$title', '$created', '$modified', '$status')";
			$result = mysqli_query($con, $sql_add);
			$id = mysqli_insert_id($con);

			//add Deparment
			foreach($_POST['Deparment'] as $id_deparment)
			{
				$sql_add_deparment = "INSERT INTO Basic_Plant_Deparment VALUES ('','$id', '$id_deparment')";
				$result = mysqli_query($con, $sql_add_deparment);
			}

			//add Deparment
			foreach($_POST['product_group'] as $id_product_group)
			{
				$sql_add_product_group = "INSERT INTO Basic_Plant_Product_Group VALUES ('','$id', '$id_product_group')";
				$result = mysqli_query($con, $sql_add_product_group);
			}

			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../admin_plants-panel.php");
		}else{
			header("Location: ../admin_plants-add.php?exist");
		}		
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>