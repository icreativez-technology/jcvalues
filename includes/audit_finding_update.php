<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$id_audit_finding = $_POST['id_audit_finding'];
		$id_auditee = $_POST['auditee'];
		$finding_schedule_date = $_POST['finding_schedule_date'];
		$id_type_audit = $_POST['type_audit'];
		$id_audit_standard = $_POST['audit_standard'];
		$id_auditor = $_POST['auditor'];
		$id_audit_area = $_POST['audit_area'];
		$id_department = $_POST['department'];
		$ftype = $_POST['ftype'];

		
			$sql_update = "UPDATE Audit_Management_Findings SET Id_type_of_audit = '$id_type_audit', Id_audit_auditor = '$id_auditor', Id_audit_area = '$id_audit_area',  Id_audit_auditee = '$id_auditee', Finding_created_date = '$finding_schedule_date', Id_finding_types = '$ftype', Id_audit_standard = '$id_audit_standard', Id_department = '$id_department' WHERE Id_Audit_Management_Findings = '$id_audit_finding'";
			
			$result = mysqli_query($con, $sql_update);
		

		
		if(mysqli_affected_rows($con) == 1){ 
			

						//header("Location: ../audit_edit_schedule.php?audit_id=".$id_audit);
						echo "<script type='text/javascript'>alert('Update!');</script>";
						header('refresh:1; url=../audit_finding_edit.php?audit_f_id='.$id_audit_finding);
		}
		
		
		
		
	}

?>