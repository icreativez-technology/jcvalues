<?php

session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productTypeId = $_POST["productTypeId"];
    $sql = "SELECT components.id, components.component FROM product_type_component LEFT JOIN components ON components.id = product_type_component.component_id  where product_type_component.product_type_id = '$productTypeId' AND components.is_deleted = '0' AND components.status ='1'";
    $connect_data = mysqli_query($con, $sql);
    $components =  array();
    while ($row = mysqli_fetch_assoc($connect_data)) {
        array_push($components, $row);
    }

    $msSql = "SELECT id, material_specification FROM material_specifications WHERE is_deleted = 0 AND is_editable = 1";
    mysqli_set_charset($con, "utf8mb4");
    $connect = mysqli_query($con, $msSql);
    $materialSpecifications = mysqli_fetch_all($connect, MYSQLI_ASSOC);

    $mandatorySql = "SELECT components.id, components.component FROM product_type_component LEFT JOIN components ON components.id = product_type_component.component_id  where product_type_component.product_type_id = '$productTypeId' AND components.is_deleted = '0' AND components.status ='1' AND product_type_component.mandatory ='1'";
    $mandatory_connect_data = mysqli_query($con, $mandatorySql);
    $mandatory =  array();
    while ($row = mysqli_fetch_assoc($mandatory_connect_data)) {
        array_push($mandatory, $row);
    }

    $data = array();
    $data['components'] = $components;
    $data['specs'] = $materialSpecifications;
    $data['mandatory'] = $mandatory;
    echo json_encode($data);
}