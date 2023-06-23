<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET["id"];
    $deleted = '1';

    //eliminar registro
    $consulta = "UPDATE audit_area SET is_deleted = '$deleted' WHERE Id_audit_area = '$id'";
    $consultaBD = mysqli_query($con, $consulta);
    header("Location: ../admin_audit-area.php");
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}