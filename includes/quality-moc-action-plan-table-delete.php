<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {

        $actionPlanId = $_POST["actionPlanId"];
        $is_deleted = '1';

        if (isset($actionPlanId)) {
            $actionPlanUpdateSql = "UPDATE quality_moc_action_plan SET is_deleted = '$is_deleted' WHERE id = '$actionPlanId'";
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