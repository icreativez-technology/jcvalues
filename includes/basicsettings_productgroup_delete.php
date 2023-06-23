<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		
		
		//update 
		/*$sql = "UPDATE Basic_Product_Group SET Title = '$title', Created = '$created', Modified = '$modified', Status = '$status' WHERE Id_product_group = '$id' ";
		$result = mysqli_query($con, $sql);*/

		//eliminar registro
		$consulta="DELETE FROM Basic_Product_Group WHERE Id_product_group LIKE '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_productgroup-panel.php");
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>