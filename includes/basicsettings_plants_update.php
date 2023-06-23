<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];
		$title = $_POST["title"];
		$modified = date("Y/m/d");
		$status = $_POST["status"];		
		
		$isExists = "SELECT * FROM Basic_Plant WHERE title = '$title' AND Id_Plant != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {
		
			//update 
		$sql = "UPDATE Basic_Plant SET Title = '$title', Modified = '$modified', Status = '$status' WHERE Id_plant = '$id' ";
		$result = mysqli_query($con, $sql);

		//delete deparments
		$consulta="DELETE FROM Basic_Plant_Deparment WHERE Id_plant = $id";
		$consultaBD = mysqli_query($con, $consulta);

		foreach($_POST['Deparment'] as $id_deparment)
		{ 
			//add deparments
			$sql_add_deparment = "INSERT INTO Basic_Plant_Deparment VALUES ('','$id', '$id_deparment')";
			$result = mysqli_query($con, $sql_add_deparment);		
		}
		
		//delete product group
		$consulta="DELETE FROM Basic_Plant_Product_Group WHERE Id_plant = $id";
		$consultaBD = mysqli_query($con, $consulta);

		foreach($_POST['product_group'] as $id_product_group)
		{ 
			//add deparments
			$sql_add_product_group = "INSERT INTO Basic_Plant_Product_Group VALUES ('','$id', '$id_product_group')";
			$result = mysqli_query($con, $sql_add_product_group);		
		}
		

		echo "<script type='text/javascript'>alert('Success!');</script>";
		unset($_SESSION['error']);
		header("Location: ../admin_plants-panel.php");
	}else {
		header("Location: ../admin_plants-edit.php?pg_id=$id&exist");
	}		
	}else{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>