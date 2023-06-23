<?php
session_start();
include('functions.php');

?>
<option value="blank_option"></option>
<?php
	$plant_id = $_REQUEST['pg_id'];

	if($plant_id != 'blank_option')
	{

		$sql_data2 = "SELECT * FROM Basic_Plant_Deparment";
		$connect_data2 = mysqli_query($con, $sql_data2);
						
		while ($result_data2 = mysqli_fetch_assoc($connect_data2)) 
		{
			if($result_data2['Id_plant'] == $plant_id)
			{
				$sql_data = "SELECT * FROM Basic_Department WHERE Id_department = '$result_data2[Id_department]'";
				$connect_data = mysqli_query($con, $sql_data);
				$result_data = mysqli_fetch_assoc($connect_data);
				if($result_data['Status'] == 'Active'){
			?>
				<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
			<?php
			}
			}
			
		}
	}else{
		$sql_data = "SELECT Id_department, Department, Status FROM Basic_Department";
		$connect_data = mysqli_query($con, $sql_data);
		while ($result_data = mysqli_fetch_assoc($connect_data)) {
		if($result_data['Status'] == 'Active')
			{						
			?>
				<option value="<?php echo $result_data['Id_department']; ?>"><?php echo $result_data['Department']; ?></option>
			<?php
			}
		}
	}


?>
