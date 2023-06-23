<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $title = $_POST["title"];
  $isExists = "SELECT id FROM vt_viewing_method WHERE title = '$title' AND id != '$id'";
  $result = mysqli_query($con, $isExists);
  if ($result->num_rows == 0) {
    $updateSql = "UPDATE vt_viewing_method SET title = '$title' WHERE id = '$id' ";
    $result = mysqli_query($con, $updateSql);
    echo "<script type='text/javascript'>alert('Success!');</script>";
    header("Location: ../vt-viewing-method.php");
  } else {
    header("Location: ../vt-viewing-method-edit.php?id=$id&exist");
  }
} else {
  echo "<script type='text/javascript'>alert('Try again');</script>";
}
