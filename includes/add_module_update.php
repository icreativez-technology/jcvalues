<?php
session_start();
include('functions.php');

$email = $_SESSION['usuario'];
$empSql = "SELECT * From Basic_Employee Where Email = '$email'";
$fetchEmp = mysqli_query($con, $empSql);
$EmpInfo = mysqli_fetch_assoc($fetchEmp);
$empId = $EmpInfo['Id_employee'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {

        $id =  $_POST["id"];
        $module = $_POST["module"];
        $order = $_POST["order"];
        $description = $_POST["description"];
        $href = $_POST["href"];

        $isModueExists = "SELECT * FROM modules WHERE module = '$module' AND id != '$id'";
        $moduleResult = mysqli_query($con, $isModueExists);

        $isOrderExists = "SELECT * FROM modules WHERE module_order = '$order' AND id != '$id'";
        $orderResult = mysqli_query($con, $isOrderExists);

        if ($moduleResult->num_rows == 0) {
            if ($orderResult->num_rows == 0) {

                $updateSql = "UPDATE `modules` SET `module` = '$module', `module_order` = '$order', `description` = '$description', `href` = '$href' WHERE (`id` = '$id')";
                $updateResult = mysqli_query($con, $updateSql);

                echo "<script type='text/javascript'>alert('Success!');</script>";
                header("Location: ../admin_role-panel.php");
            } else {
                header("Location: ../edit_module.php?orderexist");
            }
        } else {
            header("Location: ../edit_module.php?moduleexist");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}