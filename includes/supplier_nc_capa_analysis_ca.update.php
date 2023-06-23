<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $supplier_nc_capa_id = $_POST['supplier_nc_capa_ncr_id'];
    $root_cause_analysis = $_POST['root_cause_analysis'];
    $corrective_action = $_POST['corrective_action'];
    $preventive_action = $_POST['preventive_action'];
    $responsible = $_POST['responsible'];
    $date_of_implementation = $_POST['date_of_implementation'];
    if ($id == "") {
        $addSql = "INSERT INTO supplier_nc_capa_analysis_ca (supplier_nc_capa_ncr_details_id, root_cause_analysis, corrective_action, preventive_action, responsible, date_of_implementation) VALUES ('$supplier_nc_capa_id', '$root_cause_analysis','$corrective_action','$preventive_action','$responsible','$date_of_implementation')";
        $addResult = mysqli_query($con, $addSql);
    } else {
        $updateSql = "UPDATE supplier_nc_capa_analysis_ca SET root_cause_analysis = '$root_cause_analysis',root_cause_analysis = '$root_cause_analysis',corrective_action = '$corrective_action',preventive_action = '$preventive_action',responsible = '$responsible',date_of_implementation = '$date_of_implementation' WHERE id = '$id'";
        $updateResult = mysqli_query($con, $updateSql);
    }
    if ($_POST['supplier_entry'] == "true") {
        $tokenSql = "SELECT * From supplier_nc_capa_token Where supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_id'";
        $fetchToken = mysqli_query($con, $tokenSql);
        $tokenInfo = mysqli_fetch_assoc($fetchToken);
        $token = $tokenInfo['token'];
        header("Location: ../supplier_entry.php?token=$token&analysisCa");
    } else {
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../supplier_nc_capa_edit.php?id=$supplier_nc_capa_id&analysisCa");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}