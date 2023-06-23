<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['id'])) {
		$dataArr = array();
		$id = $_POST['id'];

		$sql = "SELECT nom_comp FROM material_specifications WHERE id = '$id' AND is_deleted = 0";
		$connect = mysqli_query($con, $sql);
		$data = mysqli_fetch_assoc($connect);

		$dataArr['edition'] = $data['nom_comp'];

		echo json_encode($dataArr);
	}
}
