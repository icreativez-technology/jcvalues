<?php
session_start();
include('functions.php');

?>

<tr class="campos_agenda">
	<td><input type="text" class="form-control" name="sl[]" placeholder="" required></td>
	<!--<td><input type="text" class="form-control" name="What[]" placeholder="" required></td>-->
	<td><input type="text" class="form-control" name="clause[]" placeholder="" required></td>
	<td><textarea class="form-control" name="point[]" required> </textarea></td>
	<td>
		<select class="form-control" name="clevel[]" required>
			<option>Yes</option>
			<option>No</option>
		</select></td>
	<td><input type="text" class="form-control" name="evidance[]" placeholder="" required></td>
	<td><select class="form-control" name="ftype[]" required>
	<?php 
		$consulta_ftype ="SELECT * FROM Finding_Types";
		$consulta_result_ftype = mysqli_query($con, $consulta_ftype);
		while($result_general_ftype = mysqli_fetch_assoc($consulta_result_ftype)){
	?>
	<option value="<?php echo $result_general_ftype['Id_finding_types']; ?>"><?php echo $result_general_ftype['Title']; ?></option>
	<?php } ?>
	</td>
	<td><input type="file" class="form-check" name="file_assign[]" /></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
