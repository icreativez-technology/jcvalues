<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		
		$id_audit_finding = $_POST['id_audit_finding'];
		$date_capa = $_POST['date_capa'];
		$description_capa = $_POST['description_capa'];
		$ftype_capa = $_POST['ftype_capa'];
		$issued_by_capa = $_POST['issued_by_capa'];
		$action_by_capa = $_POST['action_by_capa'];



		$sql_audit_finding_capa = "INSERT INTO Audit_Management_Findings_Capa VALUES ('','$id_audit_finding', '$description_capa', '$date_capa', '$ftype_capa','$issued_by_capa','$action_by_capa','Schedule')";

		$result_finding_capa = mysqli_query($con, $sql_audit_finding_capa);
		$Id_Audit_Management_Findings_Capa = mysqli_insert_id($con);
		
		if($_POST['detail_root']){

			for($i=0;$i<count($_POST["detail_root"]); $i++) {

				$detail_root = $_POST['detail_root'][$i];
				$auditee_root = $_POST['auditee_root'][$i];
				$date_root = $_POST['date_root'][$i];
				$sql_audit_finding_capa_root = "INSERT INTO Audit_Management_Findings_Capa_Root_Cause_Analysis VALUES ('','$Id_Audit_Management_Findings_Capa', '$detail_root', '$auditee_root', '$date_root')";
				$result_finding_capa_root = mysqli_query($con, $sql_audit_finding_capa_root);
			}
		}

		if($_POST['correction']){
			for($i=0;$i<count($_POST["correction"]); $i++) {
				$correction = $_POST['correction'][$i];
				$auditee_correction = $_POST['auditee_correction'][$i];
				$date_correction = $_POST['date_correction'][$i];
				$sql_audit_finding_capa_correction = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','$Id_Audit_Management_Findings_Capa', '$correction', '$auditee_correction','$date_correction')";
				$result_finding_capa_correction = mysqli_query($con, $sql_audit_finding_capa_correction);
			}
		}

		if($_POST['description_correctivepreventiveaction']){
			for($i=0;$i<count($_POST["description_correctivepreventiveaction"]); $i++) {
				$description_correctivepreventiveaction = $_POST['description_correctivepreventiveaction'][$i];
				$auditee_correctivepreventiveaction = $_POST['auditee_correctivepreventiveaction'][$i];
				$date_correctivepreventiveaction = $_POST['date_correctivepreventiveaction'][$i];
				$deparment_correctivepreventiveaction = $_POST['deparment_correctivepreventiveaction'][$i];
				$due_data_correctivepreventiveaction = $_POST['due_data_correctivepreventiveaction'][$i];
				$responsible_correctivepreventiveaction = $_POST['responsible_correctivepreventiveaction'][$i];
				$sql_audit_finding_capa_correctivepreventiveaction = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','0', '$correction', '$auditee_correction','$date_correction')";
				$result_finding_capa_correctivepreventiveaction = mysqli_query($con, $sql_audit_finding_capa_correctivepreventiveaction);
			}
		}

		if($_POST['moc_managementofchange']){
			for($i=0;$i<count($_POST["moc_managementofchange"]); $i++) {
				$moc_managementofchange = $_POST['moc_managementofchange'][$i];
				$description_managementofchange = $_POST['description_managementofchange'][$i];
				$sql_audit_finding_capa_managementofchange = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','$Id_Audit_Management_Findings_Capa', '$moc_managementofchange', '$description_managementofchange')";
				$result_finding_capa_managementofchange = mysqli_query($con, $sql_audit_finding_capa_managementofchange);
			}
		}

		if($_POST['description_FollowingUpQuality']){
			for($i=0;$i<count($_POST["description_FollowingUpQuality"]); $i++) {
				$description_FollowingUpQuality = $_POST['description_FollowingUpQuality'][$i];
				$auditee_FollowingUpQuality = $_POST['auditee_FollowingUpQuality'][$i];
				$date_FollowingUpQuality = $_POST['date_FollowingUpQuality'][$i];
				$sql_audit_finding_capa_FollowingUpQuality = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','$Id_Audit_Management_Findings_Capa', '$description_FollowingUpQuality', '$auditee_FollowingUpQuality', '$date_FollowingUpQuality')";
				$result_finding_capa_FollowingUpQuality = mysqli_query($con, $sql_audit_finding_capa_FollowingUpQuality);
			}
		}

		if($_POST['description_closingcorrectivepreventiveaction']){
			for($i=0;$i<count($_POST["description_FollowingUpQuality"]); $i++) {
				$description_closingcorrectivepreventiveaction = $_POST['description_closingcorrectivepreventiveaction'][$i];
				$auditee_closingcorrectivepreventiveaction = $_POST['auditee_closingcorrectivepreventiveaction'][$i];
				$date_closingcorrectivepreventiveaction = $_POST['date_closingcorrectivepreventiveaction'][$i];
				$sql_audit_finding_capa_closingcorrectivepreventiveaction = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','$Id_Audit_Management_Findings_Capa', '$description_closingcorrectivepreventiveaction', '$auditee_FollowingUpQuality', '$date_FollowingUpQuality')";
				$result_finding_capa_closingcorrectivepreventiveaction = mysqli_query($con, $sql_audit_finding_capa_closingcorrectivepreventiveaction);
			}
		}

		if($_POST['deparment_distribution']){
			for($i=0;$i<count($_POST["deparment_distribution"]); $i++) {
				$deparment_distribution = $_POST['deparment_distribution'][$i];
				
				$sql_audit_finding_capa_distribution = "INSERT INTO Audit_Management_Findings_Capa_Correction_Immediate VALUES ('','$Id_Audit_Management_Findings_Capa', '$deparment_distribution')";
				$result_finding_capa_distribution = mysqli_query($con, $sql_audit_finding_capa_distribution);
			}
			
		}

		if(mysqli_affected_rows($con) == 1)
		{
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header('refresh:1; url=../audit_finding_edit.php?audit_f_id='.$id_audit_finding);
		}
		/*
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

		
		//header("Location: ../audit.php");	
		
		*/
		
	}

?>