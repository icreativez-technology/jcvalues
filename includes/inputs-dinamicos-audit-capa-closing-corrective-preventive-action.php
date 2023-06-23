<?php
session_start();
include('functions.php');

?>

<tr class="campos_ClosingCorrectivePreventiveAction">
	<td><textarea class="form-control" name="description_closingcorrectivepreventiveaction[]" required> </textarea></td>
	<td><select class="form-control" name="auditee_closingcorrectivepreventiveaction[]" required>
		<?php 
			$consulta_employee ="SELECT * FROM Basic_Employee";
			$consulta_result_employee = mysqli_query($con, $consulta_employee);
			while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
		?>
		<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
		<?php } ?>
	</select>
	</td>
	<td><input type="date" class="form-control" name="date_closingcorrectivepreventiveaction[]" placeholder="" required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
