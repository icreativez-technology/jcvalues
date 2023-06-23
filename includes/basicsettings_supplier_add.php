<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Supplier_Id = $_POST["Supplier_Id"];
	$isExists = "SELECT * FROM Basic_Supplier WHERE Supplier_Id = '$Supplier_Id'";
	$result = mysqli_query($con, $isExists);
	if ($result->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$Supplier_Name = $_POST["Supplier_Name"];
			$Address = $_POST["Address"];
			$Country_of_Origin = $_POST["Country_of_Origin"];
			$Primary_Contact_Person = $_POST["Primary_Contact_Person"];
			$Email_Primary = $_POST["Email_Primary"];
			$Secondary_Contact_Person = $_POST["Secondary_Contact_Person"];
			$Email_Secondary = $_POST["Email_Secondary"];
			$Parent_Company = $_POST["Parent_Company"];
			$Classification_Type = $_POST["Classification_Type"];
			$Scope_of_Supply = $_POST["Scope_of_Supply"];
			$Product_Category = $_POST["Product_Category"];
			$Type_of_Approval = $_POST["Type_of_Approval"];
			$Expiry_Date_of_Approval = $_POST["Expiry_Date_of_Approval"];
			$Initial_Evaluation_Date = $_POST["Initial_Evaluation_Date"];
			$Status = $_POST["Status"];
			$Remarks_Observations = $_POST["Remarks_Observations"];
			$Created = date("Y/m/d");
			$Modified = date("Y/m/d");
			$directory = "../suppliers/" . $Supplier_Id;
			if (!file_exists($directory)) {
				mkdir($directory, 0777, true);
			}
			$fileName = $_FILES["file"]["name"];
			$targetFile = $directory . basename($fileName);
			$destinationFolder = $directory . "/" . $fileName;
			move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
			$filePath = "suppliers/" . $Supplier_Id . "/" . $fileName;

			$addSql = "INSERT INTO Basic_Supplier (Supplier_Id, Supplier_Name, Address, Country_of_Origin, Primary_Contact_Person, Email_Primary, Secondary_Contact_Person, Email_Secondary, Parent_Company, Classification_Type, Scope_of_Supply, Product_Category, Type_of_Approval, Expiry_Date_of_Approval, Initial_Evaluation_Date, Status, Remarks_Observations, Created, Modified, file_name, file_path) VALUES ('$Supplier_Id', '$Supplier_Name', '$Address', '$Country_of_Origin', '$Primary_Contact_Person', '$Email_Primary', '$Secondary_Contact_Person', '$Email_Secondary', '$Parent_Company', '$Classification_Type', '$Scope_of_Supply', '$Product_Category', '$Type_of_Approval', '$Expiry_Date_of_Approval', '$Initial_Evaluation_Date', '$Status', '$Remarks_Observations', '$Created', '$Modified', '$fileName', '$filePath')";
			$addResult = mysqli_query($con, $addSql);

			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../admin_suppliers-panel.php");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../admin_suppliers-add.php?exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}