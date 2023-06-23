<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		
		$id = $_POST["pg_id"];

		$Date_date = $_POST["date_ncr"];
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
		$Analysis_cause = $_POST["indicative_cause_nc"];
		$Correction = $_POST["correction"];
		$Details_correction = $_POST["details_correction"];
		$Disposition = $_POST["disposition"];
		$Details_disposition = $_POST["details_disposition"];
		$Customer_approval = $_POST["customer_approval"];
		$Head_intervention = $_POST["head_intervention"];
		$Status = $_POST["status"];


			$sql = "UPDATE NCR SET Date_date = '$Date_date', Id_plant = '$Id_plant', Id_product_group = '$Id_product_group', Id_department = '$Id_department', Id_ncr_process_type = '$Id_ncr_process_type', Id_ncr_non_conformance_type = '$Id_ncr_non_conformance_type', Non_conformance_details = '$Non_conformance_details', Evidence_details = '$Evidence_details', Similar_nc = '$Similar_nc', Background = '$Background', Recommended_solution = '$Recommended_solution', Assigned_department = '$Assigned_department', Assigned_owner = '$Assigned_owner', Analysis_cause = '$Analysis_cause', Correction = '$Correction', Details_correction = '$Details_correction', Disposition = '$Disposition', Details_disposition = '$Details_disposition', Customer_approval = '$Customer_approval', Head_intervention = '$Head_intervention', Status = '$Status' WHERE Id_ncr = '$id' ";
			
			$result = mysqli_query($con, $sql);

			$Id_this_NCR = $id;

			/**
			 * 
			 * Archivo:
			 * Si existe archivo:
			 * Actualizar la fecha
			 * 
			 * Borrar archivo anterior
			 * 
			 * Subir el nuevo
			 * 
			 * */

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
							/*Delete old File*/

							 $sql_data = "SELECT File_name From NCR WHERE Id_ncr = '$id'";
							 $connect_data = mysqli_query($con, $sql_data);
							 $result_data = mysqli_fetch_assoc($connect_data);

							 $oldfile = $result_data['File_name'];

							$url = "../NCR/".$oldfile;
							unlink($url);
								


							/*End delete old file*/

							/*Add new File*/
							$File_Date = date("Y/m/d");

							$path = "../NCR/";
							$time = md5(time());
							$original_name = $_FILES['file_archivo']['name'];
							$file_archivo_ok = $time.'-'.$original_name;
							$completefilenameandpath = $path.$file_archivo_ok;
							move_uploaded_file($_FILES["file_archivo"]["tmp_name"],$completefilenameandpath);

							/*UPDATE IN DATABASE*/
							$sql_archivo = "UPDATE NCR SET File_name = '$file_archivo_ok', File_date = '$File_Date' WHERE Id_ncr = '$Id_this_NCR' ";
							$result_archivo = mysqli_query($con, $sql_archivo);
						}

				/*END UPLOAD*/
				}
			}
			$custom_id = $_POST["custom_id"];

			$_SESSION['update_ncr'] = $custom_id." has been updated.";

			header("Location: ../ncr_view_list.php");
		
	}

?>