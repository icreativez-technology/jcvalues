<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $email = $_SESSION['usuario'];
        $sql = "SELECT * From Basic_Employee Where Email = '$email'";
        $fetch = mysqli_query($con, $sql);
        $userInfo = mysqli_fetch_assoc($fetch);
        $userId = $userInfo['Id_employee'];
        $com_individual = $_POST["com-individual"];
        $com_time = $_POST["com-time"];
        $com_proactive = $_POST["com-proactive"];
        $com_creativity = $_POST["com-creativity"];
        $com_id = $_POST["com-id"];
        $com_remarks = $_POST["com-remarks"];
        $com_score = $_POST['com-score'];
        $kaizen_id = $_POST['com-kaizen-id'];
        if (isset($_POST["com-id"]) && isset($_POST['com-kaizen-id'])) {
            if ($com_id != null) {
                $updateSql = "UPDATE kaizen_committee_evaluation SET criteria1 = '$com_individual', criteria2 = '$com_time', criteria3 = '$com_proactive', criteria4 = '$com_creativity', score= '$com_score', remarks = '$com_remarks', 'created_by' = '$userId' WHERE id = '$com_id'";
                $updateResult = mysqli_query($con, $updateSql);
            } else {
                $insertSql = "INSERT INTO `kaizen_committee_evaluation` (`kaizen_id`, `criteria1`, `criteria2`, `criteria3`, `criteria4`, `score`, `remarks`,  `created_by`) VALUES ('$kaizen_id', '$com_individual', '$com_time', '$com_proactive', '$com_creativity', '$com_score', '$com_remarks', $userId);";
                $insertResult = mysqli_query($con, $insertSql);
            }
            $kaizenUpdateSql = "UPDATE kaizen SET status = 'Evaluated' WHERE id = '$kaizen_id'";
            $kaizenUpdateResult = mysqli_query($con, $kaizenUpdateSql);
            // echo "<script type='text/javascript'>alert('Success!');</script>";
            // header("Location: ../kaizen_view_list.php");
            echo "<script type='text/javascript'>window.location.href=localStorage.getItem('url')</script>";
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}