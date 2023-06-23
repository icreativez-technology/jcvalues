<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET["id"];
    $deleted = date("Y/m/d");

    //eliminar registro
    $consulta = "UPDATE finding_types SET deleted_at = '$deleted' WHERE Id_finding_types = '$id'";
    $consultaBD = mysqli_query($con, $consulta);
    header("Location: ../admin_audit-finding-type.php");
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}