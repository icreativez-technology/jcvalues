<?php
session_start();
include('functions.php');

?>

<tr class="campos_ManagementOfChange">
	<td><textarea class="form-control" name="moc_managementofchange[]" required> </textarea></td>
	<td><textarea class="form-control" name="description_managementofchange[]" required> </textarea></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
