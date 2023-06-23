<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $complaint_id = $_POST["why_complaint_id"];
        $id = $_POST["why_id"];
        $root_cause = $_POST["why_root_cause"];
        $why1 = $_POST["why_1"];
        $why2 = $_POST["why_2"];
        $why3 = $_POST["why_3"];
        $why4 = $_POST["why_4"];
        $why5 = $_POST["why_5"];

        $whyUpdateSql = "UPDATE customer_complaint_d4_why_analysis SET why_1 = '$why1', why_2 = '$why2', why_3 = '$why3', why_4 = '$why4', why_5 = '$why5', root_cause = '$root_cause' WHERE id = '$id'";
        $whyUpdateResult = mysqli_query($con, $whyUpdateSql);

        $correctiveActionAddSql = "INSERT INTO customer_complaint_d4_corrective_action_plan (customer_complaint_id, customer_complaint_d4_why_analysis_id, corrective_action, who, when_date, how, moc, risk_assessment, status) VALUES ('$complaint_id', '$id', '$corrective_action', '$who', '$date', '$how', '$moc', '$risk_assessment', '$status')";
        $correctiveActionAddResult = mysqli_query($con, $correctiveActionAddSql);

        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../customer_complaint_edit.php?id=$complaint_id&d4");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}