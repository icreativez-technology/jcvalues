<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$Custom_ncr_no = 'NCR_';
		$Date_date = $_POST["date_ncr"];
		$Created_by = $_POST["created_by"];
		$Id_plant = $_POST["plant"];
		$Id_product_group = $_POST["product_group"];
		$Id_department = $_POST["department"];
		$Id_ncr_process_type = $_POST["process"];
		$Id_ncr_non_conformance_type = $_POST["type"];
		$Non_conformance_details = $_POST["non_conformance_details"];
		$Evidence_details = $_POST["evidence"];
		$Similar_nc = $_POST["similarity"];
		$Background = $_POST["background"];
		$Recommended_solution = $_POST["recommended_solution"];
		$Assigned_department = $_POST["department_assigned"];
		$Assigned_owner = $_POST["owner_assigned"];
		$File_name = 'No file';
		$File_date = date("Y/m/d");
		$Analysis_cause = $_POST["indicative_cause_nc"];
		$Correction = $_POST["correction"];
		$Details_correction = $_POST["details_correction"];
		$Disposition = $_POST["disposition"];
		$Details_disposition = $_POST["details_disposition"];
		$Customer_approval = $_POST["customer_approval"];
		$Head_intervention = $_POST["head_intervention"];
		$Status = "Scheduled";


		//var_dump($_POST);
		//die();


			$sql_add = "INSERT INTO NCR VALUES ('', '$Custom_ncr_no', '$Date_date', '$Created_by', '$Id_plant', '$Id_product_group', '$Id_department', '$Id_ncr_process_type', '$Id_ncr_non_conformance_type', '$Non_conformance_details', '$Evidence_details', '$Similar_nc', '$Background', '$Recommended_solution', '$Assigned_department', '$Assigned_owner', '$File_name', '$File_date', '$Analysis_cause', '$Correction', '$Details_correction', '$Disposition', '$Details_disposition', '$Customer_approval', '$Head_intervention', '$Status')";
			$result = mysqli_query($con, $sql_add);

			$Id_ncr = mysqli_insert_id($con);


			
			if($result){

				if($_FILES)
				{
				/*UPLOAD FILE*/
						if ($_FILES["file_archivo"]["size"] > 1000000 OR $_FILES["file_archivo"]["size"] <= 0)
						{
							/*Size too big or inexistent, do nothing*/
						}
						else
						{
							$path = "../NCR/";
							$time = md5(time());
							$original_name = $_FILES['file_archivo']['name'];
							$file_archivo_ok = $time.'-'.$original_name;
							$completefilenameandpath = $path.$file_archivo_ok;
							move_uploaded_file($_FILES["file_archivo"]["tmp_name"],$completefilenameandpath);


							/*UPDATE IN DATABASE*/
							$sql_archivo = "UPDATE NCR SET File_name = '$file_archivo_ok' WHERE Id_ncr = '$Id_ncr' ";
							$result_archivo = mysqli_query($con, $sql_archivo);
						}

				/*END UPLOAD*/
				}

				//GENERAR CUSTOM ID:
				$sql_data = "SELECT Id_ncr FROM NCR WHERE Id_ncr = '$Id_ncr'";
				$connect_data = mysqli_query($con, $sql_data);
				$result_data = mysqli_fetch_assoc($connect_data);

				$customid_postfix = $result_data['Id_ncr'];

				if($result_data['Id_ncr'] <= 999)
				{ 
					$customid_postfix = "0".$customid_postfix;
					if($result_data['Id_ncr'] <= 99)
					{
						$customid_postfix = "0".$customid_postfix;
						if($result_data['Id_ncr'] <= 9)
						{
							$customid_postfix = "0".$customid_postfix;
						}
					}
				}
				
				$custom_id = 'NCR_'.$customid_postfix;

				$sql_id = "UPDATE NCR SET Custom_ncr_no = '$custom_id' WHERE Id_ncr = '$Id_ncr' ";
				
				$result_id = mysqli_query($con, $sql_id);

				/*FIN CUSTOM ID*/

			}

			header("Location: ../ncr_view_list.php");
		
	}

?>