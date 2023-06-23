<?php

session_start();
include('../functions.php');
if($_SERVER["REQUEST_METHOD"] == "POST"){
		$on_behalf_of = $_POST['on_behalf_of'];
		$customer_id = $_POST['customer_id'];
		$orderrefnumber = $_POST['orderrefnumber'];
		$productdetails = $_POST['productdetails'];
		$id_customer_nature_of_compliants = $_POST['id_customer_nature_of_compliants'];
		$date = $_POST['date'];
		$email = $_POST['email'];//

		$phone = $_POST['phone'];
		$compliantdetails = $_POST['compliantdetails'];
		$created_at = date('Y-m-d');
		$updated_at = date('Y-m-d');

		$queryString = "INSERT INTO `compliant_details`(`on_behalf_of`, `customer_id`, `orderrefnumber`, `productdetails`, `id_customer_nature_of_compliants`, `date`, `email`, `phone`, `compliantdetails`, 'created_at', 'updated_at') VALUES 
			('$on_behalf_of', '$customer_id', '$orderrefnumber', '$productdetails', '$id_customer_nature_of_compliants', '$date', '$email', '$phone', '$compliantdetails','$created_at','$updated_at')";
		$newRow = mysqli_query($con, $queryString);
		$query = "Select max(id) as id from compliant_details";
		$results = mysqli_query($con, $query);
		$row = mysqli_fetch_assoc($results);
		$query = "UPDATE compliant_details_temp SET compliant_details_id = '".$row['id']."',type = 'new';	";
		$flag = mysqli_query($con, $query);
		if($flag == true){
			header('refresh:1; url=/compliant_detail.php?type=0&compliant_order_id=1');    
		} else {
		}
	} else {
		header('refresh:1; url=/compliant.php');    
	}
// 	{
// 		$id_audit = $_POST['id_audit'];

// 			$sql_update = "UPDATE Audit_Management SET Id_basic_plant = '$id_plant', Id_basic_product_group = '$id_product_group', Id_type_of_audit = '$id_type_audit', Id_employee_auditor = '$id_auditor', Id_audit_name_of_external_company = '$external', Id_audit_area = '$id_audit_area', 	Id_basic_department = '$id_department', Id_employee_auditee = '$id_auditee', Audit_check_list_format_no = '$format_no', Revision_check_list_format_no = '$revision_check_list_format_no', finding_format_no ='$finding_format', Revision_finding_format_no = '$revision_finding_format_no' WHERE Id_audit_management = '$id_audit'";
			
// 			$result = mysqli_query($con, $sql_update);
		
// 		if($_POST["sl"]){ 
					   	
// 			for($i=0;$i<count($_POST["sl"]); $i++) {

// 				$sl = $_POST["sl"][$i];
// 				$clause = $_POST["clause"][$i];
// 				$point = $_POST["point"][$i];
// 				$clevel = $_POST["clevel"][$i];
// 				$evidance = $_POST["evidance"][$i];
// 				$ftype = $_POST["ftype"][$i];

// 				if($clevel == 'No'){

// 					//create finding 
// 					$finding_created_date = date("y-m-d");

// 					$sql_audit_finding = "INSERT INTO Audit_Management_Findings VALUES ('','$id_audit', '$id_type_audit', '$id_auditor', '$id_audit_area','$id_auditee','$finding_created_date','$ftype', '$id_audit_standard', '$id_department', 'Open')";
// 					$result_finding = mysqli_query($con, $sql_audit_finding);

// 					//Insertar datos 
// 					$sql_agenda_audit_management_check_list = "INSERT INTO Audit_Management_Check_List VALUES ('','$id_audit', '$sl', '$clause', '$point','$clevel','$evidance','$ftype', '')";
// 					$result_audit_management_check_list = mysqli_query($con, $sql_agenda_audit_management_check_list);


// 				}else{
						
// 					//Insertar datos 
// 					if ($_FILES["file_assign"]["size"][$i] > 1000000)
// 					{
// 							echo "el arcvhio es mayor de 10MB";
							
// 					}else{ 
						
// 						$name_image = $_FILES["file_assign"]["name"][$i];
						
// 						$path = "../assets/media/assignchecklist/";
// 						$target_file = $path . basename($_FILES["file_assign"]["name"][$i]);
// 						move_uploaded_file($_FILES["file_assign"]["tmp_name"][$i], $target_file);
// 						//Insertar datos 
						
// 						$sql_agenda_audit_management_check_list = "INSERT INTO Audit_Management_Check_List VALUES ('','$id_audit', '$sl', '$clause', '$point','$clevel','$evidance','$ftype', '$name_image')";
// 						$result_audit_management_check_list = mysqli_query($con, $sql_agenda_audit_management_check_list);

// 						//header("Location: ../audit_edit_schedule.php?audit_id=".$id_audit);
// 						echo "<script type='text/javascript'>alert('Success!');</script>";
// 						header('refresh:1; url=../audit_edit_schedule.php?audit_id='.$id_audit);

// 					}

					

// 				}

// 			}
// 		}else{

// 				echo "<script type='text/javascript'>alert('Success!');</script>";
// 				header('refresh:1; url=../audit_edit_schedule.php?audit_id='.$id_audit);
// 		}
		
		
		
		
// 	}

?>