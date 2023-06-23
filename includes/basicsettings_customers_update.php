<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$id = $_POST["pg_id"];
	$Customer_Id = $_POST["Customer_Id"];
	$Customer_Name = $_POST["Customer_Name"];
	$Address = $_POST["Address"];
	$Country_of_Origin = $_POST["Country_of_Origin"];
	$Email = $_POST["Email"];
	$Parent_Company = $_POST["Parent_Company"];
	$Primary_Contact_Person = $_POST["Primary_Contact_Person"];
	$Secondary_Contact_Person = $_POST["Secondary_Contact_Person"];
	$Status = $_POST["Status"];

	//update 
	$sql = "UPDATE Basic_Customer SET Customer_Id = '$Customer_Id',Customer_Name = '$Customer_Name', Address = '$Address', Country_of_Origin = '$Country_of_Origin', Email = '$Email', Parent_Company = '$Parent_Company', Primary_Contact_Person = '$Primary_Contact_Person', Secondary_Contact_Person = '$Secondary_Contact_Person', Status = '$Status' WHERE Id_customer = '$id' ";
	$result = mysqli_query($con, $sql);

	echo "<script type='text/javascript'>alert('Success!');</script>";

	header("Location: ../admin_customers-panel.php");
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}