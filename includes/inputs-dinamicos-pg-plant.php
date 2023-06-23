<?php
session_start();
include('functions.php');

?>

<?php
$plant_id = $_REQUEST['pg_id'];

if ($plant_id != 0) {

	$sql_data2 = "SELECT * FROM Basic_Plant_Product_Group";
	$connect_data2 = mysqli_query($con, $sql_data2);
	$count = 0;

	while ($result_data2 = mysqli_fetch_assoc($connect_data2)) {
		if ($result_data2['Id_plant'] == $plant_id) {
			$count++;
			$sql_data = "SELECT * FROM Basic_Product_Group WHERE Id_product_group = '$result_data2[Id_product_group]'";
			$connect_data = mysqli_query($con, $sql_data);
			$result_data = mysqli_fetch_assoc($connect_data);
			if ($result_data['Status'] == 'Active') {
				$selected = (isset($_REQUEST['key']) && $_REQUEST['key'] == $result_data['Id_product_group']) ? 'selected' : '';
?>
				<option value="<?php echo $result_data['Id_product_group']; ?>" <?= $selected; ?>><?php echo $result_data['Title']; ?></option>
		<?php
			}
		}
	}
	if ($count == 0) {
		?>
		<option value="">No product group related to this plant</option>
<?php
	}
}


?>