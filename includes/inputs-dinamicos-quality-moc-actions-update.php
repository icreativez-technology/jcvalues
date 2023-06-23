<?php
session_start();
include('functions.php');

?>

<tr class="campos_moc-actions">
	
	<!--<td style="max-width: 25px !important;"><input type="text" class="form-control" name="sno[]" placeholder="" required></td>-->
	<input type="hidden" class="form-control" name="sno[]" placeholder="" value="0" required>
	<!--<td><input type="text" class="form-control" name="What[]" placeholder="" required></td>-->
	<td class='min-w-500px'><input type="text" class="form-control" name="ActionPoint[]" placeholder="" required></td>
	 <?php
	 	
		$consulta_general_who ="SELECT * FROM Basic_Employee WHERE Status = 'Active'";
		$consulta_result_general_who = mysqli_query($con, $consulta_general_who);
		$count = 0;
	?>
	<td class='min-w-50px'>
		<select class="form-control" name="who[]" required>
		<?php while($result_general_who = mysqli_fetch_assoc($consulta_result_general_who)){

		$id_employee = $result_general_who['Id_employee']; 
												    		
   		/*Seleccionar solo Team Informed members*/
   		$sql_data2 = "SELECT * FROM Quality_MoC_TeamMembers WHERE Id_quality_moc = '$_SESSION[Action_Plan_ID]'";
		$connect_data6 = mysqli_query($con, $sql_data2);

																								
		$flag_teamaction = 0;
		
		while ($result_data2_moc_tm = mysqli_fetch_assoc($connect_data6)) 
		{
			if($result_data2_moc_tm['Id_employee'] == $id_employee)
			{
				$flag_teamaction = 1;
				$count++;

			}
		}
		
		if($flag_teamaction == 1){					    		
    	?>
		<option value="<?php echo $result_general_who['Id_employee']; ?>"><?php echo $result_general_who['First_Name']; ?> <?php echo $result_general_who['Last_Name']; ?></option>
									
		<?php }
		} ?>
		</select>
		<?php 
		if($count == 0){
			?>
			<span>You must add Team Members to assign an Action Plan.</span>
			<?php
		}
		?>
		</td>

	<td class='min-w-25px'><input type="date" class="form-control" name="When[]" placeholder="" required></td>
	<td class='min-w-50px'>
		<select class="form-control" name="Verified[]" required>
													<?php 
														$sql_data = "SELECT * FROM Basic_Employee";
														$connect_data = mysqli_query($con, $sql_data);
																								
														while($result_data2 = mysqli_fetch_assoc($connect_data)) 
														{
														/*only print active users*/
														if($result_data2['Status'] == 'Active')
														{
														/*$letra1 = substr($result_data2['First_Name'], 0, 1);
														$letra2 = substr($result_data2['Last_Name'], 0, 1);
														$nombre = $letra1.$letra2;*/	
														?>
															<option value="<?php echo $result_data2['Id_employee']; ?>"><?php echo $result_data2['First_Name']; ?> <?php echo $result_data2['Last_Name']; ?></option>
														<?php
														}
														}
													?>
																
												</select>
	</td>
	<td class='min-w-50px'><input type="number" class="form-control" name="Status[]" min='0' max='100' required></td>
	<td class='min-w-5px'><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
