<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $email = $_SESSION['usuario'];
        $employeeSql = "SELECT * From Basic_Employee Where Email = '$email'";
        $fetch = mysqli_query($con, $employeeSql);
        $userInfo = mysqli_fetch_assoc($fetch);
        $userId = $userInfo['Id_employee'];

        if ($_FILES) {
            if ($_FILES["logo"]["size"] > 1000000 or $_FILES["logo"]["size"] <= 0) {
            } else {
                $directory = "../assets/media/avatars/";
                $target_file = $directory . basename($_FILES["logo"]["name"]);
                $fileName  = $userId . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $destinationFolder = $directory . $fileName;

                if (file_exists($destinationFolder)) {
                    unlink($destinationFolder);
                }
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $destinationFolder)) {
                    $sql = "UPDATE Basic_Employee SET Avatar_img = '$fileName' WHERE Id_employee = '$userId'";
                    $result = mysqli_query($con, $sql);
                }
            }
        }
        header("Location: ../index.php");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}