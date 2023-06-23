<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$year = $_POST["year"];
	$revision = $_POST["revision"];
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$yearExistsSql = "SELECT id FROM objective WHERE year = '$year' AND is_deleted = 0";
	$isYearExists = mysqli_query($con, $yearExistsSql);
	if ($isYearExists->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$listAdd = "INSERT INTO objective (year, revision, created_by, approved_by, is_published, published_at) VALUES ('$year', '$revision', '$created_by', '$approved_by', 0, null)";
			$listAddResult = mysqli_query($con, $listAdd);
			$objective_id = mysqli_insert_id($con);
			$objectiveArr = $_POST["objective"];
			$responsibleArr = $_POST["responsible"];
			$randomNoArr = $_POST["random_no"];
			$comply_levelArr = isset($_POST["comply_level"]) ? $_POST["comply_level"] : [];
			$comply_levels =  array();
			foreach ($comply_levelArr as $key => $val) {
				array_push($comply_levels, $comply_levelArr[$key]);
			}
			foreach ($objectiveArr as $key => $val) {
				$comply_level = (in_array($randomNoArr[$key], $comply_levels)) ? "Yes" : "No";
				$addListSql = "INSERT INTO objective_list (objective_id, objective, responsible, comply_level) VALUES ('$objective_id', '$objectiveArr[$key]', '$responsibleArr[$key]', '$comply_level')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../objective-edit.php?id=$objective_id");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../objective-add.php?existyear");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}