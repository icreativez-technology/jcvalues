<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_id = $_POST["complaint_id"];
    $preliminary_analysis_id = $_POST["preliminary_analysis_id"];
    $indicative_cause_of_non_conformance = $_POST["indicative_cause_of_non_conformance"];
    if ($_SESSION['usuario']) {
        if ($preliminary_analysis_id != null || $preliminary_analysis_id = "") {
            $preliminarySql = "UPDATE preliminary_analysis_d3 SET indicative_cause_of_non_conformance = '$indicative_cause_of_non_conformance' WHERE id = '$preliminary_analysis_id'";
            $res = mysqli_query($con, $preliminarySql);
        } else {
            $preliminarySql = "INSERT INTO `preliminary_analysis_d3` (`customer_complaint_id`, `indicative_cause_of_non_conformance`, `is_deleted`) VALUES ('$complaint_id', '$indicative_cause_of_non_conformance', '0');";
            $res = mysqli_query($con, $preliminarySql);
            $preliminary_analysis_id = mysqli_insert_id($con);
        }
        if ($preliminary_analysis_id != null || $preliminary_analysis_id != "") {
            $deleteSql = "DELETE FROM customer_complaint_correction_d3 WHERE preliminary_analysis_d3_id = '$preliminary_analysis_id '";
            $deleteConnect = mysqli_query($con, $deleteSql);

            $correctionArr = $_POST["correction_d3"];
            $whoArr = $_POST["who_d3"];
            $whenArr = $_POST["when_d3"];
            $howArr = $_POST["how_d3"];
            $statusArr = $_POST["status_d3"];
            foreach ($correctionArr as $key => $val) {
                $addListSql = "INSERT INTO customer_complaint_correction_d3 (preliminary_analysis_d3_id, correction, who, when_date, how, status) VALUES ('$preliminary_analysis_id', '$correctionArr[$key]', '$whoArr[$key]', '$whenArr[$key]', '$howArr[$key]','$statusArr[$key]')";
                $addListConnect = mysqli_query($con, $addListSql);
            }
            echo "<script type='text/javascript'>alert('Success!');</script>";
            header("Location: ../customer_complaint_edit.php?id=$complaint_id&d3");
        }
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}