<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST['id'];
        $audit_nc_capa_id = $_POST['audit_nc_capa_ncr_id'];
        $correction = $_POST['correction'];
        if ($id == "") {
            $addSql = "INSERT INTO audit_nc_capa_correction (audit_nc_capa_ncr_details_id, correction) VALUES ('$audit_nc_capa_id', '$correction')";
            $addResult = mysqli_query($con, $addSql);
        } else {
            $updateSql = "UPDATE audit_nc_capa_correction SET correction = '$correction' WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../audit_nc_capa_edit.php?id=$audit_nc_capa_id&correction");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}