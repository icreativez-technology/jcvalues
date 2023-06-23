<?php
session_start();
include('functions.php');

?>

<tr class="campos_why-why">
	<td>
	<select class="form-control" name="Id_ncr_analysis[]" required>	
	<?php
		$sql_datos_ncr_analysis = "SELECT * From NCR_Analysis WHERE Id_ncr = '$_SESSION[ncr_id_inp_din]'";
		$conect_datos_ncr_analysis = mysqli_query($con, $sql_datos_ncr_analysis);

		while ($result_datos_ncr_analysis = mysqli_fetch_assoc($conect_datos_ncr_analysis))
		{
	?>
		<option value="<?php echo $result_datos_ncr_analysis['Id_ncr_analysis']; ?>"><?php echo $result_datos_ncr_analysis['Cause']; ?></option>
	<?php 	
	}
?>
</select>
</td>
	<td><input type="text" class="form-control" name="First_why[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Second_why[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Third_why[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Fourth_why[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Fifth_why[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Root_cause[]" placeholder="" required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
