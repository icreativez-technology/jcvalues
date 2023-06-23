<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $issueType = $_POST["issue-type"];
    $issueNumber = $_POST["issue-number"];
    $priority = $_POST["priority"];
    $issueDescription = $_POST["issue_description"];
    $updatedDate = date("Y/m/d");
    $deletedItem = json_decode($_POST["deleted-file"]);
    if ($_SESSION['usuario']) {
        $sqlUpdate = "UPDATE report_bug SET issue_type = '$issueType', priority = '$priority' , issue_description = '$issueDescription', updated_at = '$updatedDate' WHERE id= '$id'";
        $result = mysqli_query($con, $sqlUpdate);
        if ($deletedItem != null && count($deletedItem) > 0) {
            foreach ($deletedItem as $row => $item) {
                if (file_exists('../' . $item)) {
                    $sqlDelete = "UPDATE report_bug_screenshots SET is_deleted = 1 WHERE file_path = '$item' AND report_bug_id = '$id'";
                    $delete = mysqli_query($con, $sqlDelete);
                    unlink('../' . $item);
                }
            }
        }
        if (!empty(array_filter($_FILES['files']['name']))) {
            $directory = "../bug-screenshots/" . $issueNumber;
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            foreach ($_FILES['files']['tmp_name'] as $key => $item) {
                if ($item) {
                    $targetFile = $directory . basename($_FILES["files"]["name"][$key]);
                    $fileName = $_FILES["files"]["name"][$key];
                    $destinationFolder = $directory . "/" . $fileName;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
                    $filePath = "bug-screenshots/" . $issueNumber . "/" . $fileName;
                    $addScreenShot = "INSERT INTO report_bug_screenshots (report_bug_id, file_path) VALUES ('$id', '$filePath')";
                    $addScreenShotResult = mysqli_query($con, $addScreenShot);
                }
            }
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../report-bug.php");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}