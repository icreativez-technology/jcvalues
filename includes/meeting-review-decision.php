<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $meeting_id = $_POST["meetingId"];
        $dataArr = $_POST["data"];
        $isExists = "DELETE FROM meeting_review_decision WHERE meeting_id = '$meeting_id'";
        $result = mysqli_query($con, $isExists);
        foreach ($dataArr as $data) {
            $addSql = "INSERT INTO meeting_review_decision (meeting_id, employee_id,decision) VALUES ('$meeting_id', '$data[id]','$data[decision]')";
            $addResult = mysqli_query($con, $addSql);
        }
        echo true;
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}