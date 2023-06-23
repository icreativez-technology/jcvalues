<?php
session_start();
include('functions.php');

?>

<tr class="campos_CorrectivePreventiveAction">
	<td><textarea class="form-control" name="description_correctivepreventiveaction[]" required> </textarea></td>
	<td><select class="form-control" name="auditee_correctivepreventiveaction[]" required>
	<?php 
		$consulta_employee ="SELECT * FROM Basic_Employee";
		$consulta_result_employee = mysqli_query($con, $consulta_employee);
		while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
	?>
	<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
	<?php } ?>
	</td>
	<td><input type="date" class="form-control" name="date_correctivepreventiveaction[]" placeholder="" required></td>
	<td><select class="form-control" name="deparment_correctivepreventiveaction[]" required>
	<?php 
		$consulta_department ="SELECT * FROM Basic_Department";
		$consulta_result_department = mysqli_query($con, $consulta_department);
		while($result_general_department = mysqli_fetch_assoc($consulta_result_department)){
	?>
	<option value="<?php echo $result_general_department['Id_department']; ?>"><?php echo $result_general_department['Department']; ?></option>
	<?php } ?>
	</td>
	<td><input type="date" class="form-control" name="due_data_correctivepreventiveaction[]" placeholder="" required></td>
	
	<td><select class="form-control" name="responsible_correctivepreventiveaction[]" required>
	<?php 
		$consulta_employee ="SELECT * FROM Basic_Employee";
		$consulta_result_employee = mysqli_query($con, $consulta_employee);
		while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
	?>
	<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
	<?php } ?>
	</td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
