<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productTypeId = $_POST["productTypeId"];
    $data = array();

    $queryString = "SELECT design_standards.id as id, design_standards.design_standard as name FROM design_standards JOIN product_type_design_std ON product_type_design_std.design_std_id = design_standards.id WHERE design_standards.status = '1' AND product_type_design_std.product_type_id = $productTypeId";
    $queryConnection = mysqli_query($con, $queryString);
    $queryData = mysqli_fetch_all($queryConnection, MYSQLI_ASSOC);
    
    echo json_encode($queryData);
}
