<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id_audit_finding_capa = $_POST['id_audit_finding_capa'];
		$date_capa = $_POST['date_capa'];
		$description_capa = $_POST['description_capa'];
		$ftype_capa = $_POST['ftype_capa'];
		$issued_by_capa = $_POST['issued_by_capa'];
		$action_by_capa = $_POST['action_by_capa'];

		
			$sql_update = "UPDATE Audit_Management_Findings_Capa SET Description = '$description_capa', Date_capa = '$date_capa', Id_finding_types = '$ftype_capa', Issued_by_Auditor = '$issued_by_capa', Action_by_Auditee = '$action_by_capa' WHERE Id_Audit_Management_Findings_Capaa = '$id_audit_finding_capa'";
			
			$result = mysqli_query($con, $sql_update);
		

		
		if(mysqli_affected_rows($con) == 1){ 

				echo "<script type='text/javascript'>alert('Update!');</script>";
				header('refresh:1; url=../audit_finding_capa_view_list_update.php?findings_capa='.$id_audit_finding_capa);
		}
		
		
		
		
	}

?>