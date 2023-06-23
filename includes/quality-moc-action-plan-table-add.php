<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {

        $quality_moc_id = $_POST["quality_moc_id"];
        $actionPlanId = $_POST["actionPlanId"];
        $actionPoint = $_POST["actionPoint"];
        $actionPlanStatus = $_POST["actionPlanStatus"];
        $actionPlanWho = $_POST["actionPlanWho"];
        $actionPlanVerified = $_POST["actionPlanVerified"];
        $actionPlanWhen = $_POST["actionPlanWhen"];
        $is_deleted = '0';

        if ($actionPlanId != NULL ||  $actionPlanId != "") {
            $actionPlanUpdateSql = "UPDATE quality_moc_action_plan SET action_point = '$actionPoint', who = '$actionPlanWho', date = '$actionPlanWhen', status = '$actionPlanStatus', verified = '$actionPlanVerified',is_deleted = '$is_deleted' WHERE id = '$actionPlanId'";
            $actionPlanUpdateResult = mysqli_query($con, $actionPlanUpdateSql);
            echo true;
        } else {
            $actionPlanUpdateSql = "INSERT INTO `quality_moc_action_plan` (`quality_moc_id`, `action_point`, `who`, `date`,`verified`, `status`, `is_deleted`) VALUES ('$quality_moc_id','$actionPoint','$actionPlanWho','$actionPlanWhen','$actionPlanVerified','$actionPlanStatus','$is_deleted')";
            $actionPlanUpdateResult = mysqli_query($con, $actionPlanUpdateSql);
            echo true;
        }
        echo false;
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}