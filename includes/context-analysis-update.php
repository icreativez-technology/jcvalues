<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$context_analysis_id = $_POST["id"];
	$action = $_POST["action"];
	$publish = $_POST["publish"];
	$year = $_POST["year"];
	$revision = $_POST["revision"] + 1;
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$strengthArr = $_POST["strength"];
	$weaknessArr = $_POST["weakness"];
	$opportunitiesArr = $_POST["opportunities"];
	$threatsArr = $_POST["threats"];
	if ($_SESSION['usuario']) {
		if ($action == "save" && $publish == "false") {
			$makeViewSql = "UPDATE context_analysis SET is_editable = 0 WHERE year = '$year'";
			$makeViewSqlResult = mysqli_query($con, $makeViewSql);
			$partyAdd = "INSERT INTO context_analysis (year, revision, created_by, approved_by) VALUES ('$year', '$revision', '$created_by', '$approved_by')";
			$partyAddResult = mysqli_query($con, $partyAdd);
			$context_analysis_id = mysqli_insert_id($con);
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
			// echo "<script type='text/javascript'>alert('Success!');</script>";
			// header("Location: ../context-analysis.php");
			echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
		} else {
			$deleteListSql = "DELETE FROM context_analysis_strength_list WHERE context_analysis_id = '$context_analysis_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			$deleteListSql = "DELETE FROM context_analysis_weakness_list WHERE context_analysis_id = '$context_analysis_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			$deleteListSql = "DELETE FROM context_analysis_opportunities_list WHERE context_analysis_id = '$context_analysis_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			$deleteListSql = "DELETE FROM context_analysis_threats_list WHERE context_analysis_id = '$context_analysis_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
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
			if ($action == "save") {
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../context-analysis-edit.php?id=$context_analysis_id");
			} else {
				$date = date("Y-m-d H:i:s");
				$makePublished = "UPDATE context_analysis SET is_published = 1, published_at = '$date' WHERE id = '$context_analysis_id'";
				$makePublishedResult = mysqli_query($con, $makePublished);
				// echo "<script type='text/javascript'>alert('Success!');</script>";
				// header("Location: ../context-analysis.php");
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
