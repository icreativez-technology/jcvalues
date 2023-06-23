<?php
session_start();
include('functions.php');
?>
<?php
$department_id = $_REQUEST['id'];

if ($department_id != 0 && $department_id != "") {
	$sql_data2 = "SELECT * FROM Basic_Employee";
	$connect_data2 = mysqli_query($con, $sql_data2);
	$count = 0;
	while ($result_data2 = mysqli_fetch_assoc($connect_data2)) {
		if ($result_data2['Id_department'] == $department_id) {
			$count++;
			if ($result_data2['Status'] == 'Active') {
				$selected = (isset($_REQUEST['key']) && $_REQUEST['key'] == $result_data2['Id_employee']) ? 'selected' : '';
?>
				<option value="<?php echo $result_data2['Id_employee']; ?>" <?= $selected; ?>><?php echo $result_data2['First_Name'] . ' ' . $result_data2['Last_Name']; ?></option>
		<?php
			}
		}
	}
	if ($count == 0) {
		?>
		<option value="">No member related to this department</option>
	<?php
	}
} else {
	?>
	<option value="">Please Select</option>
<?php }
?>