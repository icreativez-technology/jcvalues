<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $updateSql = "UPDATE supplier_certificates SET is_qr_created = '1' WHERE id = '$id'";
    $result = mysqli_query($con, $updateSql);
    echo true;
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}