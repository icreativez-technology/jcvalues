<?php

session_start();
include('functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folderNameArr = $_POST['data'];
    if (count($folderNameArr) > 0) {
        foreach ($folderNameArr as $folderName)
            $url = "../document-manager/" . $folderName['name'];

        $isExist = is_dir($url);
        $isEmpty = dir_is_empty($url);
        if ($isExist) {
            if ($isEmpty) {
                rmdir($url);
            }
        }
    }
    echo  true;
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