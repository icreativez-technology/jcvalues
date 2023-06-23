<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// var_dump($_POST);
		$cause = $_POST['cause'];
		$firstwhy = $_POST['firstwhy'];
		$secondwhy = $_POST['secondwhy'];
		$thirdwhy = $_POST['thirdwhy'];
		$forthwhy = $_POST['forthwhy'];
		$fifthwhy = $_POST['fifthwhy'];
		$first_isrootcause = isset($_POST['first_isrootcause'])? 1 : 0;
		$second_isrootcause = isset($_POST['second_isrootcause'])? 1 : 0;
		$third_isrootcause = isset($_POST['third_isrootcause'])? 1 : 0;
		$forth_isrootcause = isset($_POST['forth_isrootcause'])? 1 : 0;
		$fifth_isrootcause = isset($_POST['fifth_isrootcause'])? 1 : 0;

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];
		if($compliant_details_type == 'new') {
			$queryString = "INSERT INTO compliant_d4_why_analysis(`cause`,`firstwhy`, `first_isrootcause`,`secondwhy`, `second_isrootcause`,`thirdwhy`, `third_isrootcause`,`forthwhy`, `forth_isrootcause`,`fifthwhy`, `fifth_isrootcause`,  `compliant_details_id`) VALUES 
				('$cause','$firstwhy', $first_isrootcause,'$secondwhy', $second_isrootcause,'$thirdwhy', $third_isrootcause,'$forthwhy', $forth_isrootcause,'$fifthwhy', $fifth_isrootcause,  '$compliant_details_id')";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=4');    
		} else {
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=4');    
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}

?>