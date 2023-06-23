<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_SESSION['usuario']) {
		$email = $_SESSION['usuario'];
		$sql = "SELECT * From Basic_Employee Where Email = '$email'";
		$fetch = mysqli_query($con, $sql);
		$userInfo = mysqli_fetch_assoc($fetch);
		$user_id = $userInfo['Id_employee'];
		$role_id = $_POST["role_id"];
		$module_ids = $_POST["module_ids"];
		$can_view = isset($_POST["can_view"]) ? $_POST["can_view"] : [];
		$can_edit = isset($_POST["can_edit"]) ? $_POST["can_edit"] : [];
		$can_delete = isset($_POST["can_delete"]) ? $_POST["can_delete"] : [];
		foreach ($module_ids as $key => $module_id) {
			$view = (in_array($module_ids[$key], $can_view)) ? 1 : 0;
			$edit = (in_array($module_ids[$key], $can_edit)) ? 1 : 0;
			$delete = (in_array($module_ids[$key], $can_delete)) ? 1 : 0;
			$updateSql = "UPDATE permissions SET can_view = '$view', can_edit = '$edit', can_delete = '$delete', updated_by = '$user_id' WHERE module_id = '$module_id' AND role_id = '$role_id'";
			$updateSqlResult = mysqli_query($con, $updateSql);
		}
		echo "<script type='text/javascript'>alert('Success!');</script>";
		header("Location: ../admin_role-panel.php");
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
