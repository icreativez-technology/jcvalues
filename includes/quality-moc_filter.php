<?php 
session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
{

	$_SESSION["moc_data"] = "SELECT * FROM Quality_MoC WHERE ";
	$flag = 0;

	if($_POST['on_behalf'] != "blank_option")
	{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Id_employee = ".$_POST['on_behalf'];
		$flag = 1;
	}
	
	if($_POST['Id_plant'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]." AND ";	
		}
		
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Id_plant = ".$_POST['Id_plant'];
		$flag = 1;
	}

	if($_POST['Id_product_group'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]." AND ";	
		}
		
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Id_product_group = ".$_POST['Id_product_group'];
		$flag = 1;
	}

	if($_POST['Id_department'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]." AND ";	
		}
		
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Id_department = ".$_POST['Id_department'];
		$flag = 1;
	}

	if($_POST['moc_type'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]." AND ";	
		}
		
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Id_quality_moc_type = ".$_POST['moc_type'];
		$flag = 1;
	}

	if($_POST['approval'] != "blank_option")
	{
		if($flag == 1)
		{
		$_SESSION["moc_data"] = $_SESSION["moc_data"]." AND ";	
		}
		
		$_SESSION["moc_data"] = $_SESSION["moc_data"]."Decision = '".$_POST['approval']."'";
		$flag = 1;
	}

	/*Si no se ha activado ningun filtro*/
	if($flag == 0)
	{
		$_SESSION["moc_data"] = "SELECT * FROM Quality_MoC";
	}

}

	header("Location: ../quality-moc_view_list.php");
?>
