<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $title = $_POST["title"];
  $isExists = "SELECT id FROM pt_penetrant_type WHERE title = '$title' AND id != '$id'";
  $result = mysqli_query($con, $isExists);
  if ($result->num_rows == 0) {
    $updateSql = "UPDATE pt_penetrant_type SET title = '$title' WHERE id = '$id' ";
    $result = mysqli_query($con, $updateSql);
    echo "<script type='text/javascript'>alert('Success!');</script>";
    header("Location: ../pt-penetrant-type.php");
  } else {
    header("Location: ../pt-penetrant-type-edit.php?id=$id&exist");
  }
} else {
  echo "<script type='text/javascript'>alert('Try again');</script>";
}
