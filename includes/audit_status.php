<?php

session_start();
include('functions.php');


		$Id_audit_management = $_REQUEST["ad_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT * FROM Audit_Management WHERE Id_audit_management = $_REQUEST[ad_id]";

		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);
		 
		 echo $sql_data;
		if($result_data['status'] == "Schedule")
		{
			
			$sql = "UPDATE Audit_Management SET status = 'Completed' WHERE Id_audit_management = $_REQUEST[ad_id] ";
		}else{
			$sql = "UPDATE Audit_Management SET status = 'Schedule' WHERE Id_audit_management = $_REQUEST[ad_id] ";
		}
		
		$result = mysqli_query($con, $sql);

		
		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header('Location: ../audit_edit_schedule.php?audit_id='.$Id_audit_management);

?>