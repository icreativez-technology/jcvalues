<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET["id"];
    $deleted = date("Y/m/d");

    //eliminar registro
    $consulta = "UPDATE audit_co_ordinator SET deleted_at = '$deleted' WHERE Id_audit_co_ordinator = '$id'";
    $consultaBD = mysqli_query($con, $consulta);
    header("Location: ../admin_audit-coordinator.php");
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}