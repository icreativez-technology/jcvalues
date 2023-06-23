<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["audit_f_id"];		

		//Delete findings
		$consulta="DELETE FROM Audit_Management_Findings WHERE Id_Audit_Management_Findings = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		//Delete findings capa
		$consulta="DELETE FROM Audit_Management_Findings_Capa WHERE Id_Audit_Management_Findings = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		//Delete finding
		$consulta_capa ="SELECT * FROM Audit_Management_Findings_Capa WHERE Id_Audit_Management_Findings = '$id'";
		$consulta_capa_result = mysqli_query($con, $consulta_capa);
		$result_capa = mysqli_fetch_assoc($consulta_capa_result);
		$id_finding_capa = $result_capa['Id_Audit_Management_Findings_capaa'];

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Closing_Corrective_Preventive WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Correction_Immediate WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Corrective_Preventive_Action WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Distribution WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Following_Up_Quality WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Management_Of_Change WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		$consulta="DELETE FROM Audit_Management_Findings_Capa_Root_Cause_Analysis WHERE Id_Audit_Management_Findings_Capa = '$id_finding_capa'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
					
	    header('refresh:1; url=../audit.php');

		}
		

?>