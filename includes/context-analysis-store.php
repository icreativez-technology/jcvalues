<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$year = $_POST["year"];
	$revision = $_POST["revision"];
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$yearExistsSql = "SELECT id FROM context_analysis WHERE year = '$year' AND is_deleted = 0";
	$isYearExists = mysqli_query($con, $yearExistsSql);
	if ($isYearExists->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$listAdd = "INSERT INTO context_analysis (year, revision, created_by, approved_by, is_published, published_at) VALUES ('$year', '$revision', '$created_by', '$approved_by', 0, null)";
			$listAddResult = mysqli_query($con, $listAdd);
			$context_analysis_id = mysqli_insert_id($con);
			$strengthArr = $_POST["strength"];
			$weaknessArr = $_POST["weakness"];
			$opportunitiesArr = $_POST["opportunities"];
			$threatsArr = $_POST["threats"];
			foreach ($strengthArr as $key => $val) {
				$addListSql = "INSERT INTO context_analysis_strength_list (context_analysis_id, strength) VALUES ('$context_analysis_id', '$strengthArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			foreach ($weaknessArr as $key => $val) {
				$addListSql = "INSERT INTO context_analysis_weakness_list (context_analysis_id, weakness) VALUES ('$context_analysis_id', '$weaknessArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			foreach ($opportunitiesArr as $key => $val) {
				$addListSql = "INSERT INTO context_analysis_opportunities_list (context_analysis_id, opportunities) VALUES ('$context_analysis_id', '$opportunitiesArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			foreach ($threatsArr as $key => $val) {
				$addListSql = "INSERT INTO context_analysis_threats_list (context_analysis_id, threats) VALUES ('$context_analysis_id', '$threatsArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../context-analysis-edit.php?id=$context_analysis_id");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../context-analysis-add.php?existyear");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}