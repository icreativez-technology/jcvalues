<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		

		//eliminar registro
		$consulta="DELETE FROM NCR_Process_Type WHERE Id_ncr_process_type = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_ncr-process.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('Try again');</script>";
		}

?>