<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){

	// var_dump($_POST);
		$root_cause = $_POST['root_cause'];
		$correction_action = $_POST['correction_action'];
		$who = $_POST['who'];
		$when = $_POST['when'];
		$how = $_POST['how'];
		$moc = isset($_POST['moc'])? 1 : 0;
		$risk_assessment = isset($_POST['risk_ass$risk_assessment'])? 1 : 0;
		$status=$_POST['status'];
		$verified=$_POST['verified'];
		$remarks=$_POST['remarks'];
		$updated_at=date('Y-m-d');

		$query = "Select * from compliant_details_temp";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$compliant_details_id = $row['compliant_details_id'];
		$compliant_details_type = $row['type'];
		if($compliant_details_type == 'new') {
			$queryString = "INSERT INTO compliant_d6d7(`root_cause`, `correction_action`,`who`,`when`,`how`, `moc`, `risk_assessment`,`status` ,`verified` ,`remarks` , `compliant_details_id`, 'updated_at') VALUES 
				('$root_cause', '$correction_action','$who','$when','$how', $moc, $risk_assessment, '$status','$verified','$remarks' ,'$compliant_details_id', '$updated_at')";
			mysqli_query($con, $queryString);
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=6');    
		} else {
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=6');    
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}

?>