<?php
session_start();
include('functions.php');

?>
<option value="blank_option"></option>
<?php
	$plant_id = $_REQUEST['pg_id'];

	if($plant_id != 'blank_option')
	{

		$sql_data2 = "SELECT * FROM Basic_Plant_Product_Group";
		$connect_data2 = mysqli_query($con, $sql_data2);
						
		while ($result_data2 = mysqli_fetch_assoc($connect_data2)) 
		{
			if($result_data2['Id_plant'] == $plant_id)
			{
				$sql_data = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = '$result_data2[Id_product_group]'";
				$connect_data = mysqli_query($con, $sql_data);
				$result_data = mysqli_fetch_assoc($connect_data);
				if($result_data['Status'] == 'Active'){
			?>
				<option value="<?php echo $result_data['Id_product_group']; ?>"><?php echo $result_data['Title']; ?></option>
			<?php
			}
			}
			
		}
	}else{
		$sql_data = "SELECT * FROM Basic_Product_Group";
		$connect_data = mysqli_query($con, $sql_data);
		while ($result_data = mysqli_fetch_assoc($connect_data)) {
			if($result_data['Status'] == 'Active')
			{						
			?>
				<option value="<?php echo $result_data['Id_product_group']; ?>"><?php echo $result_data['Title']; ?></option>
			<?php
			}
		}
	}


?>
