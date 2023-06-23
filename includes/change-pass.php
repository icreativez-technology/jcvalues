<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        // get userId
        $email_user = $_SESSION['usuario'];
        $sql_datos_user = "SELECT * From Basic_Employee WHERE Email LIKE '$email_user'";
        $conect_datos_user = mysqli_query($con, $sql_datos_user);
        $result_datos_user = mysqli_fetch_assoc($conect_datos_user);
        $id_user = $result_datos_user['Id_employee'];

        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        if ($password1 == $password2) {
            $mitigationPlanUpdateSql = "UPDATE Basic_Employee SET Password = '$password1' WHERE Id_employee = '$id_user'";
            $mitigatonPlanUpdateResult = mysqli_query($con, $mitigationPlanUpdateSql);
            echo true;
        } else {
            echo false;
        }
        echo false;
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}