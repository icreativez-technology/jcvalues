<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		

		//eliminar registro
		$consulta="DELETE FROM Quality_Risk_Source WHERE Id_quality_risk_source = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_quality-risk-source.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('Try again');</script>";
		}

?>