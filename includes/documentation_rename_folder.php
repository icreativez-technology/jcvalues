<?php

session_start();
include('functions.php');
$returnVal = "1";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_folder = $_POST["oldName"];
    $new_name_folder = $_POST["newName"];
    if ($old_folder != $new_name_folder) {
        $old_url = "../document-manager/" . $old_folder;
        $new_url = "../document-manager/" . $new_name_folder;
        $isExist = is_dir($new_url);
        $isValid = preg_match('/[\'^£%()}{~?><>,|=¬!]/', $new_name_folder);

    if (!$isExist) {
    if ($isValid == 0) {
    rename($old_url, $new_url);
    $updateSql = "UPDATE Document SET category = '$new_name_folder' WHERE category = '$old_folder' ";
    $result = mysqli_query($con, $updateSql);
    } else {
    $returnVal = "2";
    }
    } else {
    $returnVal = "3";
    }
    }
    }
    echo $returnVal;