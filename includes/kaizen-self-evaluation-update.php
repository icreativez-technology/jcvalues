<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $self_individual = $_POST["self-individual"];
        $self_time = $_POST["self-time"];
        $self_proactive = $_POST["self-proactive"];
        $self_creativity = $_POST["self-creativity"];
        $self_id = $_POST["self-id"];
        $self_remarks = $_POST["self-remarks"];
        $self_score = $_POST['self-score'];
        $kaizen_id = $_POST['self-kaizen-id'];
        if (isset($_POST["self-id"]) && isset($_POST['self-kaizen-id'])) {


            if ($self_id != null) {
                $updateSql = "UPDATE kaizen_self_evaluation SET criteria1 = '$self_individual', criteria2 = '$self_time', criteria3 = '$self_proactive', criteria4 = '$self_creativity', score= '$self_score', remarks = '$self_remarks' WHERE id = '$self_id'";
                $updateResult = mysqli_query($con, $updateSql);
            } else {
                $insertSql = "INSERT INTO `kaizen_self_evaluation` (`kaizen_id`, `criteria1`, `criteria2`, `criteria3`, `criteria4`, `score`, `remarks`) VALUES ('$kaizen_id', '$self_individual', '$self_time', '$self_proactive','$self_creativity', '$self_score', '$self_remarks');";
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