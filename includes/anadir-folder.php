<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namefolder = $_POST["namefolder"];

    $isExist = is_dir('../document-manager/' . $namefolder);
    $isValid = preg_match('/[\'^£%()}{~?><>,|=¬!]/', $namefolder);
    if (!$isExist) {
    if ($isValid == 0) {
    if (mkdir('../document-manager/' . $namefolder, 0777, true)) {
    header("Location:../documentation.php");
    }
    } else {
    header("Location: ../documentation_add_folder.php?invalid");
    }
    } else {
    header("Location: ../documentation_add_folder.php?exist");
    }
    }