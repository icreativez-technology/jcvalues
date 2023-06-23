<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$objective_id = $_POST["id"];
	$action = $_POST["action"];
	$publish = $_POST["publish"];
	$year = $_POST["year"];
	$revision = $_POST["revision"] + 1;
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$objectiveArr = $_POST["objective"];
	$responsibleArr = $_POST["responsible"];
	$randomNoArr = $_POST["random_no"];
	$comply_levelArr = isset($_POST["comply_level"]) ? $_POST["comply_level"] : [];
	$comply_levels =  array();
	foreach ($comply_levelArr as $key => $val) {
		array_push($comply_levels, $comply_levelArr[$key]);
	}
	if ($_SESSION['usuario']) {
		if ($action == "save" && $publish == "false") {
			$makeViewSql = "UPDATE objective SET is_editable = 0 WHERE year = '$year'";
			$makeViewSqlResult = mysqli_query($con, $makeViewSql);
			$listAdd = "INSERT INTO objective (year, revision, created_by, approved_by) VALUES ('$year', '$revision', '$created_by', '$approved_by')";
			$listAddResult = mysqli_query($con, $listAdd);
			$objective_id = mysqli_insert_id($con);
			foreach ($objectiveArr as $key => $val) {
				$comply_level = (in_array($randomNoArr[$key], $comply_levels)) ? "Yes" : "No";
				$addListSql = "INSERT INTO objective_list (objective_id, objective, responsible, comply_level) VALUES ('$objective_id', '$objectiveArr[$key]', '$responsibleArr[$key]', '$comply_level')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			// echo "<script type='text/javascript'>alert('Success!');</script>";
			// header("Location: ../objective.php");
			echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
		} else {
			$deleteListSql = "DELETE FROM objective_list WHERE objective_id = '$objective_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			foreach ($objectiveArr as $key => $val) {
				$comply_level = (in_array($randomNoArr[$key], $comply_levels)) ? "Yes" : "No";
				$addListSql = "INSERT INTO objective_list (objective_id, objective, responsible, comply_level) VALUES ('$objective_id', '$objectiveArr[$key]', '$responsibleArr[$key]', '$comply_level')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			if ($action == "save") {
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../objective-edit.php?id=$objective_id");
			} else {
				$date = date("Y-m-d H:i:s");
				$makePublished = "UPDATE objective SET is_published = 1, published_at = '$date' WHERE id = '$objective_id'";
				$makePublishedResult = mysqli_query($con, $makePublished);
				// echo "<script type='text/javascript'>alert('Success!');</script>";
				// header("Location: ../objective.php");
				echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
			}
		}
	} else {
		$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
		echo "<script type='text/javascript'>alert('$msg');</script>";
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}
