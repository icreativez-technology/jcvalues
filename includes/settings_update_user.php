<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$id = $_POST["pg_id"];
		$email = $_POST["email"];
		$isExists = "SELECT Id_employee FROM Basic_Employee WHERE Email = '$email' AND Id_employee != '$id'";
		$result = mysqli_query($con, $isExists);
		if ($result->num_rows == 0) {

		/*Comprobar EMAIL*/
		$sql_data = "SELECT Id_employee, Email From Basic_Employee WHERE Id_employee = '$id'";
		$connect_data = mysqli_query($con, $sql_data);
 		$result_data = mysqli_fetch_assoc($connect_data);
		 

			
			$first_name = $_POST["first_name"];
			$last_name = $_POST["last_name"];
			$modified = date("Y/m/d");
		
		$sql = "UPDATE Basic_Employee SET First_Name = '$first_name', Last_Name = '$last_name', Modified = '$modified' WHERE Id_employee = '$id' ";
		$result = mysqli_query($con, $sql);
	

		if($_POST['password']){
			$password = $_POST["password"];
			/*UPDATE PASS IF THEY ENTERED A NEW ONE*/
			$sql = "UPDATE Basic_Employee SET Password = '$password' WHERE Id_employee = '$id' ";
			$result = mysqli_query($con, $sql);
		}

		if($_FILES)
		{
			/*UPLOAD AVATAR IMAGE*/
					if ($_FILES["file_avatar"]["size"] > 1000000 OR $_FILES["file_avatar"]["size"] <= 0)
					{
						/*Size too big or inexistent, do nothing*/
					}
					else
					{
						$path = "../assets/media/avatars/";
						$time = md5(time());
						$file_avatar = $first_name.$time.".jpg";
						$completefilenameandpath = $path.$file_avatar;
						move_uploaded_file($_FILES["file_avatar"]["tmp_name"],$completefilenameandpath);
						
						/*Delete old file*/

						 $sql_data = "SELECT Avatar_img From Basic_Employee WHERE Id_employee = '$id'";
						 $connect_data = mysqli_query($con, $sql_data);
						 $result_data = mysqli_fetch_assoc($connect_data);

						 $oldavatar = $result_data['Avatar_img'];

						/*Only delete file if its not the default avatar*/
						if($oldavatar != "blank.png")
						{
						$url = "../assets/media/avatars/".$oldavatar;
						unlink($url);
						}

						/*End delete old file*/

						/*UPDATE IN DATABASE*/
						$sql = "UPDATE Basic_Employee SET Avatar_img = '$file_avatar' WHERE Id_employee = '$id' ";
						$result = mysqli_query($con, $sql);
					}

			/*END UPLOAD*/
			}


		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../settings.php");
			}else{
		header("Location: ../admin_user-edit.php?pg_id=$id&exist");
		}
	}else
	{
		echo "<script type='text/javascript'>alert('Try again');</script>";
	}

?>