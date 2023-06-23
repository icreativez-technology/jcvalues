<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$strategy_id = $_POST["id"];
	$action = $_POST["action"];
	$publish = $_POST["publish"];
	$year = $_POST["year"];
	$revision = $_POST["revision"] + 1;
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$strategyArr = $_POST["strategy"];
	$typeArr = $_POST["type"];
	$threatsArr = $_POST["threats"];
	if ($_SESSION['usuario']) {
		if ($action == "save" && $publish == "false") {
			$makeViewSql = "UPDATE strategy SET is_editable = 0 WHERE year = '$year'";
			$makeViewSqlResult = mysqli_query($con, $makeViewSql);
			$listAdd = "INSERT INTO strategy (year, revision, created_by, approved_by) VALUES ('$year', '$revision', '$created_by', '$approved_by')";
			$listAddResult = mysqli_query($con, $listAdd);
			$strategy_id = mysqli_insert_id($con);
			foreach ($strategyArr as $key => $val) {
				$addListSql = "INSERT INTO strategy_list (strategy_id, strategy, type, threats) VALUES ('$strategy_id', '$strategyArr[$key]', '$typeArr[$key]', '$threatsArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			// echo "<script type='text/javascript'>alert('Success!');</script>";
			// header("Location: ../strategy.php");
			echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
		} else {
			$deleteListSql = "DELETE FROM strategy_list WHERE strategy_id = '$strategy_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			foreach ($strategyArr as $key => $val) {
				$addListSql = "INSERT INTO strategy_list (strategy_id, strategy, type, threats) VALUES ('$strategy_id', '$strategyArr[$key]', '$typeArr[$key]', '$threatsArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			if ($action == "save") {
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../strategy-edit.php?id=$strategy_id");
			} else {
				$date = date("Y-m-d H:i:s");
				$makePublished = "UPDATE strategy SET is_published = 1, published_at = '$date' WHERE id = '$strategy_id'";
				$makePublishedResult = mysqli_query($con, $makePublished);
				// echo "<script type='text/javascript'>alert('Success!');</script>";
				// header("Location: ../strategy.php");
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
