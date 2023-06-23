<?php
session_start();
include('functions.php');

?>

<tr class="campos_risk-mp">
	<td style="max-width: 25px !important;"><input type="text" class="form-control" name="sl[]" placeholder="" required></td>
	<!--<td><input type="text" class="form-control" name="What[]" placeholder="" required></td>-->
	<td><textarea class="form-control" name="What[]" required> </textarea></td>
	 <?php
	 	
		$consulta_general_who ="SELECT * FROM Quality_Risk_Mitigation_Plan";
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
		<option value="<?php echo $result_general_who['Id_meeting_co_ordinator']; ?>"><?php echo $result_general_who_name['Email']; ?></option>
									
		<?php } ?>
		</select>
		</td>
	<td><input type="date" class="form-control" name="When[]" placeholder="" required></td>
	<td><input type="number" class="form-control" name="Status[]" min='0' max='100' required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
