<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// var_dump($_POST);
		$correction = $_POST['correction'];
		$who = $_POST['who'];
		$when = $_POST['when'];
		$how = $_POST['how'];
		$status = $_POST['status'];
		$remarks = $_POST['remarks'];

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];
		if($compliant_details_type == 'new') {
			$queryString = "INSERT INTO compliant_d3(`correction`, `who`,`when`, `how`, `status`, `remarks`,  `compliant_details_id`) VALUES 
				('$correction', '$who','$when', '$how', '$status', '$remarks', '$compliant_details_id')";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=3');    
		} else {
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=3');    
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}

?>