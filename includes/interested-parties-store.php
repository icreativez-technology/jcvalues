<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$year = $_POST["year"];
	$revision = $_POST["revision"];
	$created_by = $_POST["created_by"];
	$approved_by = $_POST["approved_by"];
	$yearExistsSql = "SELECT id FROM interested_parties WHERE year = '$year' AND is_deleted = 0";
	$isYearExists = mysqli_query($con, $yearExistsSql);
	if ($isYearExists->num_rows == 0) {
		if ($_SESSION['usuario']) {
			$partyAdd = "INSERT INTO interested_parties (year, revision, created_by, approved_by, is_published, published_at) VALUES ('$year', '$revision', '$created_by', '$approved_by', 0, null)";
			$partyAddResult = mysqli_query($con, $partyAdd);
			$interested_party_id = mysqli_insert_id($con);
			$interested_partyArr = $_POST["interested_party"];
			$requirementsArr = $_POST["requirements"];
			$expectationsArr = $_POST["expectations"];
			$typeArr = $_POST["type"];
			foreach ($interested_partyArr as $key => $val) {
				$addListSql = "INSERT INTO interested_party_list (interested_party_id, interested_party, requirements, expectations, type) VALUES ('$interested_party_id', '$interested_partyArr[$key]', '$requirementsArr[$key]', '$expectationsArr[$key]', '$typeArr[$key]')";
				$addListConnect = mysqli_query($con, $addListSql);
			}
			echo "<script type='text/javascript'>alert('Success!');</script>";
			header("Location: ../interested-parties-edit.php?id=$interested_party_id");
		} else {
			$msg = "¡¡You are not logged in, connect to be able to add correctly!!";
			echo "<script type='text/javascript'>alert('$msg');</script>";
		}
	} else {
		header("Location: ../interested-parties-add.php?existyear");
	}
} else {
	echo "<script type='text/javascript'>alert('Try again');</script>";
}