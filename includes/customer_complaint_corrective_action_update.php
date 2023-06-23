<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $complaint_id = $_POST["cAction_complaint_id"];
        $id = $_POST["cAction_id"];
        $corrective_action = $_POST["cAction_correction_action"];
        $who = $_POST["cAction_who"];
        $date = $_POST["cAction_when"];
        $how = $_POST["cAction_how"];
        $moc = isset($_POST["cAction_moc"]) && $_POST["cAction_moc"] != "" ? 1 : 0;
        $risk_assessment = isset($_POST["cAction_risk_assessment"]) && $_POST["cAction_risk_assessment"] != "" ? 1 : 0;
        $status = $_POST["cAction_status"];

        $correctiveActionUpdateSql = "UPDATE customer_complaint_d4_corrective_action_plan SET corrective_action = '$corrective_action', who = '$who', when_date = '$date', how = '$how', moc = '$moc', risk_assessment = '$risk_assessment', status = '$status' WHERE id = '$id'";
        $correctiveActionUpdateResult = mysqli_query($con, $correctiveActionUpdateSql);

        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../customer_complaint_edit.php?id=$complaint_id&d4");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}