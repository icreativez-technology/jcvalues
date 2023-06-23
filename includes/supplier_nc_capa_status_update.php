<?php

session_start();
include('functions.php');


$id = $_REQUEST["pg_id"];
$sql_data = "SELECT * FROM supplier_nc_capa_ncr_details WHERE id LIKE '$_REQUEST[pg_id]'";
$connect_data = mysqli_query($con, $sql_data);
$result_data = mysqli_fetch_assoc($connect_data);


if ($result_data['status'] == "Open") {
    $sql = "UPDATE supplier_nc_capa_ncr_details SET status = 'Closed' WHERE id = '$id' ";
} else {
    $sql = "UPDATE supplier_nc_capa_ncr_details SET status = 'Open'WHERE id = '$id' ";
}

$result = mysqli_query($con, $sql);

echo "<script type='text/javascript'>alert('Success!');</script>";

header("Location: ../supplier_nc_capa_view_list.php?a=auditNc");