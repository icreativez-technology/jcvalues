<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $title = $_POST["title"];
  $isExists = "SELECT id FROM pmi_spectroscopy_technique WHERE title = '$title' AND id != '$id'";
  $result = mysqli_query($con, $isExists);
  if ($result->num_rows == 0) {
    $updateSql = "UPDATE pmi_spectroscopy_technique SET title = '$title' WHERE id = '$id' ";
    $result = mysqli_query($con, $updateSql);
    echo "<script type='text/javascript'>alert('Success!');</script>";
    header("Location: ../pmi-spectroscopy-technique.php");
  } else {
    header("Location: ../pmi-spectroscopy-technique-edit.php?id=$id&exist");
  }
} else {
  echo "<script type='text/javascript'>alert('Try again');</script>";
}
