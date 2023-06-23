
<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productTypeId = $_POST["productTypeId"];
    $data = array();

    $queryString = "SELECT testing_standards.id as id, testing_standards.testing_standard as name FROM testing_standards JOIN product_type_testing_std ON product_type_testing_std.testing_std_id = testing_standards.id WHERE testing_standards.status = '1' AND product_type_testing_std.product_type_id = $productTypeId";
    $queryConnection = mysqli_query($con, $queryString);
    $queryData = mysqli_fetch_all($queryConnection, MYSQLI_ASSOC);
    
    echo json_encode($queryData);
}