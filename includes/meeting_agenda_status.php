<?php

session_start();
include('functions.php');


		$id = $_REQUEST["pg_id"];
		//$modified = date("Y/m/d");
		
		 $sql_data = "SELECT * FROM Meeting_Agenda WHERE Id_meeting_agenda = '$_REQUEST[pg_id]'";
		 $connect_data = mysqli_query($con, $sql_data);
		 $result_data = mysqli_fetch_assoc($connect_data);
		 $id_meeting =  $result_data['Id_meeting'];

		if($result_data['Status'] == "Completed")
		{
			$sql = "UPDATE Meeting_Agenda SET Status = 'Schedule' WHERE Id_meeting_agenda = '$id' ";
		}
		else
		{
			$sql = "UPDATE Meeting_Agenda SET Status = 'Completed' WHERE Id_meeting_agenda = '$id' ";
		}
		
		$result = mysqli_query($con, $sql);

		
		echo "<script type='text/javascript'>alert('Success!');</script>";
		
		header('Location: ../meeting_update.php?'.$id_meeting);

?>