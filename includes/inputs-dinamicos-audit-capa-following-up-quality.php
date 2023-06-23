<?php
session_start();
include('functions.php');

?>

<tr class="campos_FollowingUpQuality">
	<td><textarea class="form-control" name="description_FollowingUpQuality[]" required> </textarea></td>
	<td><select class="form-control" name="auditee_FollowingUpQuality[]" required>
	<?php 
		$consulta_employee ="SELECT * FROM Basic_Employee";
		$consulta_result_employee = mysqli_query($con, $consulta_employee);
		while($result_general_employee = mysqli_fetch_assoc($consulta_result_employee)){
	?>
	<option value="<?php echo $result_general_employee['Id_employee']; ?>"><?php echo $result_general_employee['Email']; ?></option>
	<?php } ?>
	</td>
	<td><input type="date" class="form-control" name="date_FollowingUpQuality[]" placeholder="" required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
