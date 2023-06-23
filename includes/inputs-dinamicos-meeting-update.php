<?php
session_start();
include('functions.php');

?>

<tr class="campos_agenda">
	<!--<td><input type="text" class="form-control" name="What[]" placeholder="" required></td>-->
	<td><textarea class="form-control" name="What[]" required> </textarea></td>
	 <?php
	 	
		$consulta_general_who ="SELECT * FROM Basic_Employee";
		$consulta_result_general_who = mysqli_query($con, $consulta_general_who);
	?>
	<td>
		<select class="form-control" name="who[]" required>
		<?php while($result_general_who = mysqli_fetch_assoc($consulta_result_general_who)){ 

		$id_employee = $result_general_who['Id_employee']; 
												    		
		$consulta_general_who_employee ="SELECT * FROM Basic_Employee WHERE Id_employee = $id_employee";
	
   		$consulta_result_general_who_employee = mysqli_query($con, $consulta_general_who_employee);
   		$result_general_who_name = mysqli_fetch_assoc($consulta_result_general_who_employee);
										    		
    	?>
		<option value="<?php echo $result_general_who['Id_employee']; ?>"><?php echo $result_general_who_name['First_Name'].' '.$result_general_who_name['Last_Name']; ?></option>
									
		<?php } ?>
		</select>
		</td>
	<td><input type="date" class="form-control" name="When[]" placeholder="" required></td>
	<td>
		<select class="form-control" name="priority[]">
		
			<option value="Critical">Critical</option>
			<option value="High">High</option>
			<option value="Medium">Medium</option>
			<option value="Low">Low</option>
		</select>
		<input type="hidden" name="id_meeting_agenda[]" value="0">
	</td>
	<td>
		<?php if($result_datos_meeting['Status'] == 'Completed'){ ?>
			<a href="/includes/meeting_status.php?pg_id=<?php echo $result_datos_meeting['Id_meeting']; ?>"><div class="badge badge-light-success">Completed</div></a>
		 <?php } else{ ?>										    	
			<a href="/includes/meeting_status.php?pg_id=<?php echo $result_datos_meeting['Id_meeting']; ?>"><div class="badge badge-light-warning">Schedule</div></a>
		<?php } ?>
	</td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
