<?php
session_start();
include('includes/functions.php');

$id=$_GET['id'];
//update supplier mtc active status
$qry="UPDATE supplier_certificates SET is_editable = '1' WHERE id = '$id'";
$fetchEmp = mysqli_query($con, $qry);
echo 'successfully executed';