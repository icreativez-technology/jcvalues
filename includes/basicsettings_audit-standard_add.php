<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $created = date("Y/m/d");
    $status = '1';
    $isExists = "SELECT * FROM audit_standard WHERE Title = '$title'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        if ($_FILES["file"]["name"]) {
            $target_dir = "../audit-standard-attachments/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $randomName = substr(str_shuffle(MD5(microtime())), 0, 10);
            $fileName  = $randomName . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $destinationFolder = $target_dir . $fileName;

            if (!is_dir('../audit-standard-attachments/')) {
                mkdir('../audit-standard-attachments/', 0777, true);
            }

            if (is_dir('../audit-standard-attachments/')) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder)) {
                    $sql_add = "INSERT INTO audit_standard (Title, Status, Attachment, created_at) VALUES ('$title','$status','$fileName','$created')";
                    $result = mysqli_query($con, $sql_add);
                    header("Location: ../admin_audit-standard.php");
                }
            }
        } else {
            $sql_add = "INSERT INTO audit_standard (Title, Status, created_at) VALUES ('$title','$status','$created')";
            $result = mysqli_query($con, $sql_add);
            header("Location: ../admin_audit-standard.php");
        }
    } else {
        header("Location: ../admin_audit-standard.php?exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}