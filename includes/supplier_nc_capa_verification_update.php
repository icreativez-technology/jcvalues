<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $id = $_POST['id'];
        $supplier_nc_capa_id = $_POST['supplier_nc_capa_ncr_id'];
        $closed_by = $_POST['closed_by'];
        $date = $_POST['date'];
        if ($id == "") {
            $addSql = "INSERT INTO supplier_nc_capa_verification (supplier_nc_capa_ncr_details_id, closed_by, date) VALUES ('$supplier_nc_capa_id', '$closed_by', '$date')";
            $addResult = mysqli_query($con, $addSql);
        } else {
            $updateSql = "UPDATE supplier_nc_capa_verification SET closed_by = '$closed_by', date = $date WHERE id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../supplier_nc_capa_edit.php?id=$supplier_nc_capa_id&verification");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}