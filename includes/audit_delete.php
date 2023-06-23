<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["audit_id"];		

		//Delete Audit
		$consulta="DELETE FROM Audit_Management WHERE Id_audit_management = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		//Delete check list
		$consulta="DELETE FROM Audit_Management_Check_List WHERE Id_audit_management = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		//Delete finding
		$consulta="DELETE FROM Audit_Management_Findings WHERE 	Id_Audit_Management = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
					
	    header('refresh:1; url=../audit.php');

		}
		

?>