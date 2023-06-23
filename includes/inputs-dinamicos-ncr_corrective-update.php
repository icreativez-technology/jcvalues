<?php
session_start();
include('functions.php');

?>

<tr class="campos_corrective">
	<td>
	<select class="form-control" name="Id_ncr_why_why[]" required>	
	<?php
		$sql_datos_ncr_why_why = "SELECT * From NCR_Why_Why WHERE Id_ncr = '$_SESSION[ncr_id_inp_din]'";
		$conect_datos_ncr_why_why = mysqli_query($con, $sql_datos_ncr_why_why);

		while ($result_datos_ncr_why_why = mysqli_fetch_assoc($conect_datos_ncr_why_why))
		{
	?>
		<option value="<?php echo $result_datos_ncr_why_why['Id_ncr_why_why']; ?>"><?php echo $result_datos_ncr_why_why['Root_cause']; ?></option>
	<?php 	
	}
?>
</select>
</td>
	<td><input type="text" class="form-control" name="Corrective_action[]" placeholder="" required></td>
	<?php
	 	
		$consulta_general_who ="SELECT * FROM Basic_Employee WHERE Status = 'Active'";
		$consulta_result_general_who = mysqli_query($con, $consulta_general_who);
	?>
	<td>
		<select class="form-control" name="Who_emp[]" required>
		<?php while($result_general_who = mysqli_fetch_assoc($consulta_result_general_who)){ 

		$id_employee = $result_general_who['Id_employee']; 
												    		
		$consulta_general_who_employee ="SELECT * FROM Basic_Employee WHERE Id_employee = $id_employee";
	
   		$consulta_result_general_who_employee = mysqli_query($con, $consulta_general_who_employee);
   		$result_general_who_name = mysqli_fetch_assoc($consulta_result_general_who_employee);
										    		
    	?>
		<option value="<?php echo $result_general_who['Id_employee']; ?>"><?php echo $result_general_who_name['Email']; ?></option>
									
		<?php } ?>
		</select>
		</td>
	<td><input type="date" class="form-control" name="When_date[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Review[]" placeholder="" required></td>
	<td><input type="number" class="form-control" name="Status[]" min='0' max='100' required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
