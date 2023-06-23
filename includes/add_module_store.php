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
        $module = $_POST["module"];
        $order = $_POST["order"];
        $description = $_POST["description"];
        $href = $_POST["href"];

        $isModueExists = "SELECT * FROM modules WHERE module = '$module'";
        $moduleResult = mysqli_query($con, $isModueExists);

        $isOrderExists = "SELECT * FROM modules WHERE module_order = '$order'";
        $orderResult = mysqli_query($con, $isOrderExists);

        if ($moduleResult->num_rows == 0) {
            if ($orderResult->num_rows == 0) {

                $addSql = "INSERT INTO `modules` (`module`,`module_order`, `description`, `href`) VALUES ('$module','$order','$description','$href')";
                $addResult = mysqli_query($con, $addSql);

                echo "<script type='text/javascript'>alert('Success!');</script>";
                header("Location: ../admin_role-panel.php");
            } else {
                header("Location: ../add_module.php?orderexist");
            }
        } else {
            header("Location: ../add_module.php?moduleexist");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}