<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = $_POST["pg_id"];
	$Supplier_Id = $_POST["Supplier_Id"];
	$isExists = "SELECT * FROM Basic_Supplier WHERE Supplier_Id = '$Supplier_Id' AND Id_Supplier != '$id'";
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
			$Modified = date("Y/m/d");
			$sql = "UPDATE Basic_Supplier SET Supplier_Id = '$Supplier_Id', Supplier_Name = '$Supplier_Name', Address = '$Address', Country_of_Origin = '$Country_of_Origin', Email_Primary = '$Email_Primary', Email_Secondary = '$Email_Secondary', Parent_Company = '$Parent_Company', Primary_Contact_Person = '$Primary_Contact_Person', Secondary_Contact_Person = '$Secondary_Contact_Person', Classification_Type = '$Classification_Type', Product_Category = '$Product_Category', Scope_of_Supply = '$Scope_of_Supply', Type_of_Approval = '$Type_of_Approval', Expiry_Date_of_Approval = '$Expiry_Date_of_Approval', Initial_Evaluation_Date = '$Initial_Evaluation_Date', Modified = '$Modified', Status = '$Status', Remarks_Observations = '$Remarks_Observations' WHERE Id_Supplier = '$id'";
			$result = mysqli_query($con, $sql);
			if ($_FILES['file']['name']) {
				$directory = "../suppliers/" . $Supplier_Id;
				if (!file_exists($directory)) {
					mkdir($directory, 0777, true);
				}
				$fileName = $_FILES["file"]["name"];
				$targetFile = $directory . basename($fileName);
				$destinationFolder = $directory . "/" . $fileName;
				move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
				$filePath = "suppliers/" . $Supplier_Id . "/" . $fileName;
				$updateSql = "UPDATE Basic_Supplier SET file_path = '$filePath', file_name = '$fileName' WHERE Id_Supplier = '$id'";
				$updateResult = mysqli_query($con, $updateSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../admin_suppliers-panel.php");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../admin_suppliers-edit.php?pg_id=" . $id . "&exist");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}