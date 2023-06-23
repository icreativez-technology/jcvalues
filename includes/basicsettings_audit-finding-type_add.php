<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $created = date("Y/m/d");
    $status = '1';
    $isExists = "SELECT * FROM finding_types WHERE Title LIKE '$title'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "INSERT INTO finding_types (Title, status, created_at) VALUES ('$title','$status','$created')";
        $result = mysqli_query($con, $sql_add);
        header("Location: ../admin_audit-finding-type.php");
    } else {
        header("Location: ../admin_audit-finding-type.php?exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}