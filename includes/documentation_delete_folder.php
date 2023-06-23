<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $url = "../document-manager/" . $name;

    $isExist = is_dir($url);
    $isEmpty = dir_is_empty($url);
    $resultVal = "1";

    if ($isExist) {
        if ($isEmpty) {
            rmdir($url);
        } else {
            $resultVal = "2";
        }
        echo  $resultVal;
    }
}

function dir_is_empty($dir)
{
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            closedir($handle);
            return false;
        }
    }
    closedir($handle);
    return true;
}