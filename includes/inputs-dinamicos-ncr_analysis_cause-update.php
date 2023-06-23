<?php
session_start();
include('functions.php');

?>

<tr class="campos_analysis-cause">
	<td><input type="text" class="form-control" name="Category[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Cause[]" placeholder="" required></td>
	<td><input type="text" class="form-control" name="Significant[]" placeholder="" required></td>
	<td><input type="checkbox" class="form-check-input" name="item_index[]" /></td>
</tr>
