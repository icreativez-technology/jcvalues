<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		

		//eliminar registro
		$consulta="DELETE FROM Asset_Machine_Location WHERE Id_asset_machine_location = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_asset-machine-location.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('Try again');</script>";
		}

?>