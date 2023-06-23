<?php

session_start();
include('functions.php');
$id = $_REQUEST["id"];
$sql_data = "DELETE FROM supplier_nc_capa_token WHERE id LIKE '$id'";
$connect_data = mysqli_query($con, $sql_data);
echo "<script type='text/javascript'>alert('Success!');</script>";
header("Location: ../sign-in.php");