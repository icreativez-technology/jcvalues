<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $hod_individual = $_POST["hod-individual"];
        $hod_time = $_POST["hod-time"];
        $hod_proactive = $_POST["hod-proactive"];
        $hod_creativity = $_POST["hod-creativity"];
        $hod_id = $_POST["hod-id"];
        $hod_remarks = $_POST["hod-remarks"];
        $hod_score = $_POST['hod-score'];
        $kaizen_id = $_POST['hod-kaizen-id'];
        if (isset($_POST["hod-id"]) && isset($_POST['hod-kaizen-id'])) {
            if ($hod_id != null) {
                $updateSql = "UPDATE kaizen_hod_evaluation SET criteria1 = '$hod_individual', criteria2 = '$hod_time', criteria3 = '$hod_proactive', criteria4 = '$hod_creativity', score= '$hod_score', remarks = '$hod_remarks' WHERE id = '$hod_id'";
                $updateResult = mysqli_query($con, $updateSql);
            } else {
                $insertSql = "INSERT INTO `kaizen_hod_evaluation` (`kaizen_id`, `criteria1`, `criteria2`, `criteria3`, `criteria4`, `score`, `remarks`) VALUES ('$kaizen_id', '$hod_individual', '$hod_time', '$hod_proactive','$hod_creativity', '$hod_score', '$hod_remarks');";
                $insertResult = mysqli_query($con, $insertSql);
            }
            echo "<script type='text/javascript'>alert('Success!');</script>";
            header("Location: ../kaizen_detail_edit.php?id=" . $kaizen_id);
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}