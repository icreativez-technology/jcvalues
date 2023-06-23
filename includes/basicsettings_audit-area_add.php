<?php

session_start();
include('functions.php');


if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    $title = $_POST["title"];
    $created = date("Y/m/d");
    $modified = date("Y/m/d");
    $status = 1;
    
  $isExists = "SELECT * FROM audit_area WHERE title = '$title'";
  $result = mysqli_query($con, $isExists);
  if ($result->num_rows == 0) {
    $sql_add = "INSERT INTO audit_area (Title, Status, created_at, updated_at)VALUES ('$title', '$status', '$created', '$modified')";
    $result = mysqli_query($con, $sql_add);
    echo "<script type='text/javascript'>alert('Success!');</script>";
    header("Location: ../admin_audit-area.php");
    }
    else {
      header("Location: ../admin_audit-area.php?exist");
    }     
  }else
  {
    echo "<script type='text/javascript'>alert('Try again');</script>";
  }

?>