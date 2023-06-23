<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $title = $_POST["title"];
    $updated = date("Y/m/d");
    $status = $_POST["status"];
    $isExists = "SELECT * FROM audit_area WHERE Title LIKE '$title' AND Id_audit_area != '$id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "UPDATE audit_area SET Title = '$title', Status = '$status', updated_at = '$updated' WHERE  Id_audit_area = '$id'";
        $result = mysqli_query($con, $sql_add);
        header("Location: ../admin_audit-area.php");
    } else {
        header("Location: ../admin_audit-area-edit.php?id=" . $id . "&exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}