<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$interested_party_id = $_POST["id"];
	$action = $_POST["action"];
	$publish = $_POST["publish"];
	$year = $_POST["year"];
	$revision = $_POST["revision"] + 1;
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$interested_partyArr = $_POST["interested_party"];
	$requirementsArr = $_POST["requirements"];
	$expectationsArr = $_POST["expectations"];
	$typeArr = $_POST["type"];
	if ($_SESSION['usuario']) {
		if ($action == "save" && $publish == "false") {
			$makeViewSql = "UPDATE interested_parties SET is_editable = 0 WHERE year = '$year'";
			$makeViewSqlResult = mysqli_query($con, $makeViewSql);
			$partyAdd = "INSERT INTO interested_parties (year, revision, created_by, approved_by) VALUES ('$year', '$revision', '$created_by', '$approved_by')";
			$partyAddResult = mysqli_query($con, $partyAdd);
			$interested_party_id = mysqli_insert_id($con);
			foreach ($interested_partyArr as $key => $val) {
				$addListSql = "INSERT INTO interested_party_list (interested_party_id, interested_party, requirements, expectations, type) VALUES ('$interested_party_id', '$interested_partyArr[$key]', '$requirementsArr[$key]', '$expectationsArr[$key]', '$typeArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			// echo "<script type='text/javascript'>alert('Success!');</script>";
			// header("Location: ../interested-parties.php");
			echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
		} else {
			$deleteListSql = "DELETE FROM interested_party_list WHERE interested_party_id = '$interested_party_id'";
			$deleteListSqlResult = mysqli_query($con, $deleteListSql);
			foreach ($interested_partyArr as $key => $val) {
				$addListSql = "INSERT INTO interested_party_list (interested_party_id, interested_party, requirements, expectations, type) VALUES ('$interested_party_id', '$interested_partyArr[$key]', '$requirementsArr[$key]', '$expectationsArr[$key]', '$typeArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			if ($action == "save") {
				echo "<script type='text/javascript'>alert('Success!');</script>";
				header("Location: ../interested-parties-edit.php?id=$interested_party_id");
			} else {
				$date = date("Y-m-d H:i:s");
				$makePublished = "UPDATE interested_parties SET is_published = 1, published_at = '$date' WHERE id = '$interested_party_id'";
				$makePublishedResult = mysqli_query($con, $makePublished);
				// echo "<script type='text/javascript'>alert('Success!');</script>";
				// header("Location: ../interested-parties.php");
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
