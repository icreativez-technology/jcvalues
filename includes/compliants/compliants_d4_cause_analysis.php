<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// var_dump($_POST);
		$category = $_POST['category'];
		$cause = $_POST['cause'];
		$remarks = $_POST['remarks'];
		$significant = isset($_POST['significant'])? 1 : 0;

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];
		if($compliant_details_type == 'new') {
			$queryString = "INSERT INTO compliant_d4_cause_analysis(`category`, `cause`,`remarks`, `significant`,  `compliant_details_id`) VALUES 
				('$category', '$cause','$remarks', $significant,  '$compliant_details_id')";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=4');    
		} else {
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=4');    
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}

?>