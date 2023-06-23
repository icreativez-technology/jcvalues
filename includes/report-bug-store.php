<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $prefix = "ISSUE-NO-";
    $issueNoSql = "SELECT report_bug.issue_number FROM report_bug order by id DESC LIMIT 1";
    $issueNoConnect = mysqli_query($con, $issueNoSql);
    $issueNoInfo = mysqli_fetch_assoc($issueNoConnect);
    $issueNo = (isset($issueNoInfo['issue_number'])) ? $issueNoInfo['issue_number'] : null;
    $length = 4;
    if (!$issueNo) {
        $og_length = $length - 1;
        $last_number = '1';
    } else {
        $code = substr($issueNo, strlen($prefix));
        $increment_last_number = ((int)$code) + 1;
        $last_number_length = strlen($increment_last_number);
        $og_length = $length - $last_number_length;
        $last_number = $increment_last_number;
    }
    $zeros = "";
    for ($i = 0; $i < $og_length; $i++) {
        $zeros .= "0";
    }
    $issueNumber = $prefix . $zeros . $last_number;
    $issueType = $_POST["issue-type"];
    $priority = $_POST["priority"];
    $issueDescription = $_POST["issue_description"];

    if ($_SESSION['usuario']) {
        $email = $_SESSION['usuario'];
        $sql = "SELECT * From Basic_Employee Where Email = '$email'";
        $fetch = mysqli_query($con, $sql);
        $userInfo = mysqli_fetch_assoc($fetch);
        $userId = $userInfo['Id_employee'];
        $sqlAdd = "INSERT INTO report_bug (issue_number, issue_type, priority, issue_description, created_by) VALUES ('$issueNumber', '$issueType', '$priority','$issueDescription','$userId')";
        $result = mysqli_query($con, $sqlAdd);
        $bugId = mysqli_insert_id($con);
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
                    $addScreenShot = "INSERT INTO report_bug_screenshots (report_bug_id, file_path) VALUES ('$bugId', '$filePath')";
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