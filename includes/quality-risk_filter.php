<?php 
session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
{

	$_SESSION["risk_data"] = "SELECT * FROM Quality_Risk WHERE ";
	$flag = 0;

	if($_POST['on_behalf'] != "blank_option")
	{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Id_employee = ".$_POST['on_behalf'];
		$flag = 1;
	}
	
	if($_POST['Id_plant'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]." AND ";	
		}
		
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Id_plant = ".$_POST['Id_plant'];
		$flag = 1;
	}

	if($_POST['Id_department'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]." AND ";	
		}
		
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Id_department = ".$_POST['Id_department'];
		$flag = 1;
	}

	if($_POST['impact'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]." AND ";	
		}
		
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Impact = '".$_POST['impact']."'";
		$flag = 1;
	}

	if($_POST['assessment'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]." AND ";	
		}
		
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Assessment = '".$_POST['assessment']."'";
		$flag = 1;
	}


	if($_POST['approval'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["risk_data"] = $_SESSION["risk_data"]." AND ";	
		}
		
		$_SESSION["risk_data"] = $_SESSION["risk_data"]."Decision = '".$_POST['approval']."'";
		$flag = 1;
	}

	/*Si no se ha activado ningun filtro*/
	if($flag == 0)
	{
		$_SESSION["risk_data"] = "SELECT * FROM Quality_Risk";
	}

}

	header("Location: ../quality-risk_view_list.php");
?>
