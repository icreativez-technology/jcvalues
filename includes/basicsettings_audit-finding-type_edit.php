<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $title = $_POST["title"];
    $updated = date("Y/m/d");
    $status = $_POST["status"];
    $isExists = "SELECT * FROM finding_types WHERE Title LIKE '$title' AND Id_finding_types != '$id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        $sql_add = "UPDATE finding_types SET Title = '$title', status = '$status', updated_at = '$updated' WHERE  Id_finding_types = '$id'";
        $result = mysqli_query($con, $sql_add);
        header("Location: ../admin_audit-finding-type.php");
    } else {
        header("Location: ../admin_audit-finding-type-edit.php?id=" . $id . "&exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}