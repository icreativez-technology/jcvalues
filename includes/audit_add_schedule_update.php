<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$id_audit = $_POST['id_audit'];
		$id_plant = $_POST['plant'];
		$id_auditee = $_POST['auditee'];
		$id_product_group = $_POST['product_group'];
		$audit_schedule_date = $_POST['audit_schedule_date'];
		$id_type_audit = $_POST['type_audit'];
		$check_list = $_POST['assign'];
		$id_audit_standard = $_POST['audit_standard'];
		$status = $_POST['status'];
		$id_auditor = $_POST['auditor'];
		$format_no = $_POST['format_no'];
		$external = $_POST['Id_name_of_external_company'];
		$revision_check_list_format_no = $_POST['Revision_check_list_format_no'];
		$id_audit_area = $_POST['audit_area'];
		$finding_format = $_POST['finding_format'];
		$id_department = $_POST['department'];
		$revision_finding_format_no = $_POST['revision_finding_format_no'];

		
			$sql_update = "UPDATE Audit_Management SET Id_basic_plant = '$id_plant', Id_basic_product_group = '$id_product_group', Id_type_of_audit = '$id_type_audit', Id_employee_auditor = '$id_auditor', Id_audit_name_of_external_company = '$external', Id_audit_area = '$id_audit_area', Id_basic_department = '$id_department', Id_employee_auditee = '$id_auditee', Audit_check_list_format_no = '$format_no', Revision_check_list_format_no = '$revision_check_list_format_no', finding_format_no ='$finding_format', Revision_finding_format_no = '$revision_finding_format_no' WHERE Id_audit_management = '$id_audit'";
			
			$result = mysqli_query($con, $sql_update);
		

		
		if($_POST["sl"]){ 
					   	
			for($i=0;$i<count($_POST["sl"]); $i++) {

				$sl = $_POST["sl"][$i];
				$clause = $_POST["clause"][$i];
				$point = $_POST["point"][$i];
				$clevel = $_POST["clevel"][$i];
				$evidance = $_POST["evidance"][$i];
				$ftype = $_POST["ftype"][$i];

				if($clevel == 'No'){

					//create finding 
					$finding_created_date = date("y-m-d");

					$sql_audit_finding = "INSERT INTO Audit_Management_Findings VALUES ('','$id_audit', '$id_type_audit', '$id_auditor', '$id_audit_area','$id_auditee','$finding_created_date','$ftype', '$id_audit_standard', '$id_department', 'Open')";
					$result_finding = mysqli_query($con, $sql_audit_finding);

					//Insertar datos 
					$sql_agenda_audit_management_check_list = "INSERT INTO Audit_Management_Check_List VALUES ('','$id_audit', '$sl', '$clause', '$point','$clevel','$evidance','$ftype', '')";
					$result_audit_management_check_list = mysqli_query($con, $sql_agenda_audit_management_check_list);


				}else{
						
					//Insertar datos 
					if ($_FILES["file_assign"]["size"][$i] > 1000000)
					{
							echo "el arcvhio es mayor de 10MB";
							
					}else{ 
						
						$name_image = $_FILES["file_assign"]["name"][$i];
						
						$path = "../assets/media/assignchecklist/";
						$target_file = $path . basename($_FILES["file_assign"]["name"][$i]);
						move_uploaded_file($_FILES["file_assign"]["tmp_name"][$i], $target_file);
						//Insertar datos 
						
						$sql_agenda_audit_management_check_list = "INSERT INTO Audit_Management_Check_List VALUES ('','$id_audit', '$sl', '$clause', '$point','$clevel','$evidance','$ftype', '$name_image')";
						$result_audit_management_check_list = mysqli_query($con, $sql_agenda_audit_management_check_list);

						//header("Location: ../audit_edit_schedule.php?audit_id=".$id_audit);
						echo "<script type='text/javascript'>alert('Success!');</script>";
						header('refresh:1; url=../audit_edit_schedule.php?audit_id='.$id_audit);

					}

					

				}

			}
		}else{

				echo "<script type='text/javascript'>alert('Success!');</script>";
				header('refresh:1; url=../audit_edit_schedule.php?audit_id='.$id_audit);
		}
		
		
		
		
	}

?>