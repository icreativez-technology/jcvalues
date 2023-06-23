<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {

        $mitigationPlanId = $_POST["mitigationPlanId"];
        $is_deleted = '1';

        if (isset($mitigationPlanId)) {
            $mitigationPlanUpdateSql = "UPDATE quality_risk_mitigation_plan SET is_deleted = '$is_deleted' WHERE id = '$mitigationPlanId'";
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