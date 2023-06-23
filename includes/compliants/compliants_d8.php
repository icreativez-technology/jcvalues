<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];

		if($compliant_details_type == 'new') {
			$queryString = "UPDATE compliant_details SET created = 'created' WHERE id = (select compliant_details_id from compliant_details_temp);";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_view_list.php');    
		} else {
			header('refresh:1; url=/compliant_view_list.php');    
		}
	} else {
		header('refresh:1; url=/compliant_view_list.php');    
	}

?>