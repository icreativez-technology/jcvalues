<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $supplier_nc_capa_ncr_id = $_POST["supplier_nc_capa_ncr_id"];
        $supplier_nc_capa_id = $_POST["supplier_nc_capa_id"];
        $supplier_id = $_POST["supplier_id"];
        $date = $_POST["date"];
        $delivery_note = $_POST["delivery_note"];
        $po_number = $_POST["po_number"];
        $line_item = $_POST["line_item"];
        $part_number = $_POST["part_number"];
        $part_description = $_POST["part_description"];
        $serial_no = $_POST["serial_no"];
        $material = $_POST["material"];
        $lot_quantity = $_POST["lot_quantity"];
        $inspected_quantity = $_POST["inspected_quantity"];
        $accepted_quantity = $_POST["accepted_quantity"];
        $qty_nc = $_POST["qty_nc"];
        $stock_affected = $_POST["stock_affected"];
        $ncr_classification = $_POST["ncr_classification"];
        $classification_details = $_POST["classification_details"];
        $action_with_nc_material = $_POST["action_with_nc_material"];
        $non_conformance_description = $_POST["non_conformance_description"];
        $existingFiles = $_POST["existingFiles"];
        $updateSql = "UPDATE `supplier_nc_capa_ncr_details` SET `supplier_id` = '$supplier_id', `date` = '$date', `delivery_note` = '$delivery_note', `po_number` = '$po_number', `line_item` = '$line_item', `part_number` = '$part_number', `part_description` = '$part_description', `serial_no` = '$serial_no', `material` = '$material', `lot_quantity` = '$lot_quantity', `inspected_quantity` = '$inspected_quantity', `accepted_quantity` = '$accepted_quantity', `qty_nc` = '$qty_nc',  `stock_affected` = '$stock_affected', `ncr_classification` = '$ncr_classification', `classification_details` = '$classification_details', `action_with_nc_material` = '$action_with_nc_material', `non_conformance_description` = '$non_conformance_description' WHERE (`id` = '$supplier_nc_capa_ncr_id')";
        $updateResult = mysqli_query($con, $updateSql);
        $deleteFileSql = "UPDATE supplier_nc_capa_ncr_details_files SET is_deleted = 1 WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id'";
        $deleteFileSqlResult = mysqli_query($con, $deleteFileSql);
        foreach ($existingFiles as $key => $id) {
            $updateFileSql = "UPDATE supplier_nc_capa_ncr_details_files SET is_deleted = 0 WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id' AND id = '$id'";
            $updateFileResult = mysqli_query($con, $updateFileSql);
        }
        $deleteListSql = "UPDATE supplier_nc_capa_analysis_ncr_modal SET is_deleted = 1 WHERE supplier_nc_capa_ncr_details_id = '$supplier_nc_capa_ncr_id'";
        $deleteListSqlResult = mysqli_query($con, $deleteListSql);

        $description_of_action = $_POST["description_of_action"];
        $responsible = $_POST["responsible"];
        $target_date = $_POST["target_date"];
        foreach ($description_of_action as $key => $val) {
            $addListSql = "INSERT INTO supplier_nc_capa_analysis_ncr_modal (supplier_nc_capa_ncr_details_id, description_of_action, responsible, target_date) VALUES ('$supplier_nc_capa_ncr_id', '$description_of_action[$key]', '$responsible[$key]', '$target_date[$key]')";
            $addListConnect = mysqli_query($con, $addListSql);
        }
        if (!empty(array_filter($_FILES['files']['name']))) {
            $directory = "../supplier_nc_capa/" . $supplier_nc_capa_id;
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            foreach ($_FILES['files']['name'] as $key => $item) {
                if ($item) {
                    $fileName = $_FILES["files"]["name"][$key];
                    $targetFile = $directory . basename($fileName);
                    $destinationFolder = $directory . "/" . $fileName;
                    move_uploaded_file($_FILES["files"]["tmp_name"][$key], $destinationFolder);
                    $filePath = "supplier_nc_capa/" . $supplier_nc_capa_id . "/" . $fileName;
                    $addFileSql = "INSERT INTO supplier_nc_capa_ncr_details_files (supplier_nc_capa_ncr_details_id, file_path, file_name) VALUES ('$supplier_nc_capa_ncr_id', '$filePath', '$fileName')";
                    $addFileConnect = mysqli_query($con, $addFileSql);
                }
            }
        }
        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../supplier_nc_capa_edit.php?id=$supplier_nc_capa_ncr_id&ncr");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}