<?php
session_start();
include('functions.php');

?>

<tr class="campos_Distribution">
	<td><select class="form-control" name="deparment_distribution[]" required>
	<?php 
		$consulta_department ="SELECT * FROM Basic_Department";
		$consulta_result_department = mysqli_query($con, $consulta_department);
		while($result_general_department = mysqli_fetch_assoc($consulta_result_department)){
	?>
	<option value="<?php echo $result_general_department['Id_department']; ?>"><?php echo $result_general_department['Department']; ?></option>
	<?php } ?>
	</td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
