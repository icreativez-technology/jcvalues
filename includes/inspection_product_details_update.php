<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actualArr = $_POST['actualArr'];

    foreach ($actualArr as $item) {
        $updateQuery = "UPDATE inspection_product_details SET actual_qty = '$item[actual_qty]' WHERE id = '$item[id]'";
        $connectData = mysqli_query($con, $updateQuery);
    }
    echo true;
}