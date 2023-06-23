<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $quality_risk_id = $_POST["quality_risk_id"];
        $mitigationPlanId = $_POST["mitigationPlanId"];
        $correctiveAction = $_POST["correctiveAction"];
        $mitigationStatus = $_POST["mitigationStatus"];
        $mitigationWho = $_POST["mitigationWho"];
        $mitigationWhen = $_POST["mitigationWhen"];
        $is_deleted = '0';

        if ($mitigationPlanId != NULL ||  $mitigationPlanId != "") {
            $mitigationPlanUpdateSql = "UPDATE quality_risk_mitigation_plan SET corrective_action = '$correctiveAction', who = '$mitigationWho', date = '$mitigationWhen', status = '$mitigationStatus', is_deleted = '$is_deleted' WHERE id = '$mitigationPlanId'";
            $mitigatonPlanUpdateResult = mysqli_query($con, $mitigationPlanUpdateSql);
            echo true;
        } else {
            $mitigationPlanUpdateSql = "INSERT INTO `quality_risk_mitigation_plan` (`quality_risk_id`, `corrective_action`, `who`, `date`, `status`, `is_deleted`) VALUES ('$quality_risk_id','$correctiveAction','$mitigationWho','$mitigationWhen','$mitigationStatus','$is_deleted')";
            $mitigatonPlanUpdateResult = mysqli_query($con, $mitigationPlanUpdateSql);
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