<?php
session_start();
include('functions.php');

?>

<?php
$plant_id = $_REQUEST['pg_id'];

if ($plant_id != 0) {

	$sql_data2 = "SELECT * FROM Basic_Plant_Deparment";
	$connect_data2 = mysqli_query($con, $sql_data2);
	$count = 0;

	while ($result_data2 = mysqli_fetch_assoc($connect_data2)) {
		if ($result_data2['Id_plant'] == $plant_id) {
			$count++;
			$sql_data = "SELECT * FROM Basic_Department WHERE Id_department = '$result_data2[Id_department]'";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);
			if ($result_data['Status'] == 'Active') {
				$selected = (isset($_REQUEST['key']) && $_REQUEST['key'] == $result_data['Id_department']) ? 'selected' : '';
?>
				<option value="<?php echo $result_data['Id_department']; ?>" <?= $selected; ?>><?php echo $result_data['Department']; ?></option>
		<?php
			}
		}
	}
	if ($count == 0) {
		?>
		<option value="">No department related to this plant</option>
<?php
	}
}


?>