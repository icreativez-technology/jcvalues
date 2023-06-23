<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $supplier_nc_capa_id = $_POST['supplier_nc_capa_ncr_id'];
    $correction = $_POST['correction'];
    if ($id == "") {
        $addSql = "INSERT INTO supplier_nc_capa_correction (supplier_nc_capa_ncr_details_id, correction) VALUES ('$supplier_nc_capa_id', '$correction')";
        $addResult = mysqli_query($con, $addSql);
    } else {
        $updateSql = "UPDATE supplier_nc_capa_correction SET correction = '$correction' WHERE id = '$id'";
        $updateResult = mysqli_query($con, $updateSql);
    }
    if ($_POST['supplier_entry'] == "true") {
        $tokenSql = "SELECT * From supplier_nc_capa_token Where supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_id'";
        $fetchToken = mysqli_query($con, $tokenSql);
        $tokenInfo = mysqli_fetch_assoc($fetchToken);
        $token = $tokenInfo['token'];
        header("Location: ../supplier_entry.php?token=$token&correction");
    } else {
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../supplier_nc_capa_edit.php?id=$supplier_nc_capa_id&correction");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}