<?php
session_start();
unset($_SESSION["usuario"]);
$_SESSION['page']=$_SERVER['HTTP_REFERER'];
header("location:../sign-in.php");
?>