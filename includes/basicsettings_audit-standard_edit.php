<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $updated = date("Y/m/d");
    $status =  $_POST["status"];
    $oldFile = $_POST["oldFile"];
    $isExists = "SELECT * FROM audit_standard WHERE Title = '$title' AND Id_audit_standard != '$id'";
    $result = mysqli_query($con, $isExists);
    if ($result->num_rows == 0) {
        if ($_FILES["file"]["name"]) {
            $target_dir = "../audit-standard-attachments/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $randomName = substr(str_shuffle(MD5(microtime())), 0, 10);
            $fileName  = $randomName . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $destinationFolder = $target_dir . $fileName;

            echo "../audit-standard-attachments/'$oldFile'";
            if (!is_dir('../audit-standard-attachments/')) {
                mkdir('../audit-standard-attachments/', 0777, true);
            }
            if (is_dir('../audit-standard-attachments/')) {
                if (!is_dir('../audit-standard-attachments/' . $oldFile)) {
                    chmod("../audit-standard-attachments/" . $oldFile, 0644);
                    unlink("../audit-standard-attachments/" . $oldFile);
                }
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder)) {
                    $sql_add = "UPDATE audit_standard SET Title = '$title', Status = '$status', Attachment = '$fileName', updated_at = '$updated' WHERE Id_audit_standard = '$id'";
                    $result = mysqli_query($con, $sql_add);
                    header("Location: ../admin_audit-standard.php");
                }
            }
        } else {
            $sql_add = "UPDATE audit_standard SET Title = '$title', Status = '$status', updated_at = '$updated' WHERE Id_audit_standard = '$id'";;
            $result = mysqli_query($con, $sql_add);
            header("Location: ../admin_audit-standard.php");
        }
    } else {
        header("Location: ../admin_audit-standard-edit.php?id=" . $id . "&exist");
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}