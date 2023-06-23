<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $status = $_POST["status"];
    $taskUpdateSql = "UPDATE sub_tasks SET status = '$status' WHERE id = '$id'";
    $taskUpdateResult = mysqli_query($con, $taskUpdateSql);
    echo true;
}
