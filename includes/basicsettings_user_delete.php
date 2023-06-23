<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$id = $_POST["pg_id"];		

		/*Delete avatar*/

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

		

		//eliminar registro de Rol
		$consulta="DELETE FROM Basic_Role_Employee WHERE Id_employee = '$id'";
		$consultaBD = mysqli_query($con, $consulta);



		//eliminar registro
		$consulta="DELETE FROM Basic_Employee WHERE Id_employee = '$id'";
		$consultaBD = mysqli_query($con, $consulta);

		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header("Location: ../admin_user-panel.php");
		}
		else
		{
			echo "<script type='text/javascript'>alert('Try again');</script>";
		}

?>