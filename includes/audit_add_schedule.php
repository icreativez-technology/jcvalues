<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		

		$id_plant = $_POST['plant'];
		$id_auditee = $_POST['auditee'];
		$id_product_group = $_POST['product_group'];
		$audit_schedule_date = $_POST['audit_schedule_date'];
		$id_type_audit = $_POST['type_audit'];
		$check_list = $_POST['assign'];
		$id_audit_standard = $_POST['audit_standard'];
		//$status = $_POST['status'];
		$id_auditor = $_POST['auditor'];
		$format_no = $_POST['format_no'];
		$external = $_POST['Id_name_of_external_company'];
		$revision_external = $_POST['Revision_check_list_format_no'];
		$id_audit_area = $_POST['audit_area'];
		$finding_format = $_POST['finding_format'];
		$id_department = $_POST['department'];
		$revision_department = $_POST['revision_finding_format_no'];

		
		$sql = "INSERT INTO Audit_Management VALUES ('', '$id_plant', '$id_product_group', '$id_type_audit', '$id_audit_standard', '$id_auditor', '$external', '$id_audit_area', '$id_department', '$id_auditee','$audit_schedule_date', '$check_list', 'Schedule', '$format_no','$revision_external', '$finding_format', '$revision_department', '','','')";

		$result = mysqli_query($con, $sql);

		$id_audit_management = mysqli_insert_id($con);

		//ID Audit
		$customid_audit_management = $id_audit_management;
			
		if($id_audit_management <= 999)
			{ 
				$customid_audit_management = "0".$customid_audit_management;
				if($id_audit_management <= 99)
				{
					$customid_audit_management = "0".$customid_audit_management;
					if($id_audit_management <= 9)
					{
						$customid_audit_management = "0".$customid_audit_management;
					}
				}
			}
		
		if($_POST['type_audit'] == 1){

			$custom_id = 'INT-AUD-'.$customid_audit_management;

		}elseif($_POST['type_audit'] == 2)
		{
			$custom_id = 'EXT-AUD-'.$customid_audit_management;
		}else{
			$custom_id = 'CUS-AUD-'.$customid_audit_management;
		}
		
			$sql_id = "UPDATE Audit_Management SET Custom_Id = '$custom_id' WHERE Id_audit_management = $id_audit_management";
			$result_id = mysqli_query($con, $sql_id);

		
		if($_POST["sl"]){
			for($i=0;$i<count($_POST["sl"]); $i++) {

				//Add File

				if ($_FILES["file_assign"]["size"][$i] > 1000000)
					{
							echo "el arcvhio es mayor de 10MB";
							header("Location: ../audit.php");
							
				}else{
						$sl = $_POST["sl"][$i];
						$clause = $_POST["clause"][$i];
						$point = $_POST["point"][$i];
						$clevel = $_POST["clevel"][$i];
						$evidance = $_POST["evidance"][$i];
						$ftype = $_POST["ftype"][$i];
						
						$name_image = $_FILES["file_assign"]["name"][$i];
						$path = "../assets/media/assignchecklist/";
						$target_file = $path . basename($_FILES["file_assign"]["name"][$i]);
						move_uploaded_file($_FILES["file_assign"]["tmp_name"][$i], $target_file);

						//Insertar datos 
						$sql_agenda_audit_management_check_list = "INSERT INTO Audit_Management_Check_List VALUES ('','$id_audit_management', '$sl', '$clause', '$point','$clevel','$evidance','$ftype', '$name_image')";
						$result_audit_management_check_list = mysqli_query($con, $sql_agenda_audit_management_check_list);
				
						if($clevel == 'No'){

							//create finding 
							$finding_created_date = date("y-m-d");

							$sql_audit_finding = "INSERT INTO Audit_Management_Findings VALUES ('','$id_audit_management', '$id_type_audit', '$id_auditor', '$id_audit_area','$id_auditee','$finding_created_date','$ftype', '$id_audit_standard', '$id_department', 'Schedule', '')";
							$result_finding = mysqli_query($con, $sql_audit_finding);

							//Update ID Findign
							$id_audit_management_findings = mysqli_insert_id($con);
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

								$custom_fin_id = 'FIN-AUD-'.$customid_audit_management_findings;
						
								$sql_id = "UPDATE Audit_Management_Findings SET Custom_Id = '$custom_fin_id' WHERE 	Id_Audit_Management_Findings = $id_audit_management_findings";

								$result_id = mysqli_query($con, $sql_id);
							

						}
						echo "<script type='text/javascript'>alert('Success!');</script>";
						header('refresh:1; url=../audit.php?');
				}
			}
		}else{

				echo "<script type='text/javascript'>alert('Success!');</script>";
				header('refresh:1; url=../audit.php');
		}
		
		//header("Location: ../audit.php");
					   	
	}	

?>