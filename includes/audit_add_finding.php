<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		//print_r($_POST);

		$id_auditee = $_POST['auditee'];
		$finding_created_date = $_POST['finding_create_date'];
		$id_type_audit = $_POST['type_audit'];
		$id_audit_standard = $_POST['audit_standard'];
		$status = $_POST['status'];
		$id_auditor = $_POST['auditor'];
		$id_audit_area = $_POST['audit_area'];
		$finding_format = $_POST['finding_format'];
		$id_department = $_POST['department'];
		$id_ftype = $_POST['ftype'];


		$sql_audit_finding = "INSERT INTO Audit_Management_Findings VALUES ('','0', '$id_type_audit', '$id_auditor', '$id_audit_area','$id_auditee','$finding_created_date','$id_ftype', '$id_audit_standard', '$id_department', 'Schedule','')";


		$result_finding = mysqli_query($con, $sql_audit_finding);
		

		$id_audit_management_findings = mysqli_insert_id($con);

		//ID Audit
		$customid_audit_management_findings = $id_audit_management_findings;
			
		if($id_audit_management_findings <= 999)
			{ 
				$customid_audit_management_findings = "0".$customid_audit_management_findings;
				if($id_audit_management_findings <= 99)
				{
					$customid_audit_management_findings = "0".$customid_audit_management_findings;
					if($id_audit_management_findings <= 9)
					{
						$customid_audit_management_findings = "0".$customid_audit_management_findings;
					}
				}
			}

			$custom_id = 'FIN-AUD-'.$customid_audit_management_findings;
	
			$sql_id = "UPDATE Audit_Management_Findings SET Custom_Id = '$custom_id' WHERE 	Id_Audit_Management_Findings = $id_audit_management_findings";

			$result_id = mysqli_query($con, $sql_id);

		if(mysqli_affected_rows($con) == 1)
		{
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header('refresh:1; url=../audit.php');
	}
		//header("Location: ../audit.php");	
		
		
		
	}

?>