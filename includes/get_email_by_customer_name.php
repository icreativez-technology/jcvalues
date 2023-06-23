<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST["id"];
    $sql = "SELECT Email FROM Basic_Customer WHERE Id_customer = '$customer_id'";
    $result = mysqli_query($con, $sql);
    $resultinfo = mysqli_fetch_assoc($result);
    $email = $resultinfo['Email'];
    echo $email;
}