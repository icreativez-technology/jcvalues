<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		

		//eliminar registro
		$consulta="DELETE FROM Customer_Nature_of_Complaints WHERE Id_customer_nature_of_complaints = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_cm-nature.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('Try again');</script>";
		}

?>