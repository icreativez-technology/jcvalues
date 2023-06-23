<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$year = $_POST["year"];
	$revision = $_POST["revision"];
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$yearExistsSql = "SELECT id FROM strategy WHERE year = '$year' AND is_deleted = 0";
	$isYearExists = mysqli_query($con, $yearExistsSql);
	if ($isYearExists->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$listAdd = "INSERT INTO strategy (year, revision, created_by, approved_by, is_published, published_at) VALUES ('$year', '$revision', '$created_by', '$approved_by', 0, null)";
			$listAddResult = mysqli_query($con, $listAdd);
			$strategy_id = mysqli_insert_id($con);
			$strategyArr = $_POST["strategy"];
			$typeArr = $_POST["type"];
			$threatsArr = $_POST["threats"];
			foreach ($strategyArr as $key => $val) {
				$addListSql = "INSERT INTO strategy_list (strategy_id, strategy, type, threats) VALUES ('$strategy_id', '$strategyArr[$key]', '$typeArr[$key]', '$threatsArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../strategy-edit.php?id=$strategy_id");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../strategy-add.php?existyear");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}