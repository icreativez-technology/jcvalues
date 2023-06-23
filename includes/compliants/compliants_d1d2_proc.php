<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// var_dump($_POST);
		$actioncategory = $_POST['actioncategory'];
		$detailsofsolution = $_POST['detailsofsolution'];
		$plant = $_POST['plant'];
		$assigntodepartment = $_POST['assigntodepartment'];
		$assigntoowner = $_POST['assigntoowner'];
		$teammembers = $_POST['teammembers'];
		$productgroup = $_POST['productgroup'];

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];
		if($compliant_details_type == 'new') {
			$queryString = "INSERT INTO compliant_d1d2(`actioncategory`, `detailsofsolution`,`plant`, `productgroup`, `assigntodepartment`, `assigntoowner`, `teammembers`,  `compliant_details_id`) VALUES 
				('$actioncategory', '$detailsofsolution','$plant', '$productgroup', '$assigntodepartment', '$assigntoowner', '$teammembers', '$compliant_details_id')";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=3');    
		} else {
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=1');    
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}

?>