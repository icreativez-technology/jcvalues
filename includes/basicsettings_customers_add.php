<?php

session_start();
include('functions.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Customer_Id = $_POST["Customer_Id"];
	$Customer_Name = $_POST["Customer_Name"];
	$Address = $_POST["Address"];
	$Country_of_Origin = $_POST["Country_of_Origin"];
	$Email = $_POST["Email"];
	$Parent_Company = $_POST["Parent_Company"];
	$Primary_Contact_Person = $_POST["Primary_Contact_Person"];
	$Secondary_Contact_Person = $_POST["Secondary_Contact_Person"];
	$Status = $_POST["Status"];



	$sql_add = "INSERT INTO Basic_Customer (`Id_customer`,`Customer_Id`,`Customer_Name`,`Address`,`Country_of_Origin`,`Email`,`Parent_Company`,`Primary_Contact_Person`,`Secondary_Contact_Person`,`Status`)VALUES ('','$Customer_Id','$Customer_Name','$Address','$Country_of_Origin','$Email','$Parent_Company','$Primary_Contact_Person','$Secondary_Contact_Person', '$Status')";
	$result = mysqli_query($con, $sql_add);

	echo "<script type='text/javascript'>alert('Success!');</script>";

	header("Location: ../admin_customers-panel.php");
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}