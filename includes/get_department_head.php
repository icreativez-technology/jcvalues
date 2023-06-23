<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plant_id = $_POST["plantId"];
    $department_id = $_POST["departmentId"];
    $sql = "SELECT * FROM Basic_Employee WHERE Id_plant = '$plant_id' AND Id_department = '$department_id' AND Department_Head = 'Yes' LIMIT 1";
    $result = mysqli_query($con, $sql);
    $resultinfo = mysqli_fetch_assoc($result);
    if ($resultinfo != null) {
        $departmentHead = $resultinfo['First_Name'] . " " . $resultinfo['Last_Name'];
        echo $departmentHead;
    }
    echo "";
}