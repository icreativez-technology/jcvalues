<?php
session_start();
include('functions.php');
include('PHPMailer-config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
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
        $prefix = "SNC-";
        $supplierIdSql = "SELECT supplier_nc_capa_id FROM supplier_nc_capa_ncr_details order by id DESC LIMIT 1";
        $supplierIdConnect = mysqli_query($con, $supplierIdSql);
        $supplierIdInfo = mysqli_fetch_assoc($supplierIdConnect);
        $supplierId = (isset($supplierIdInfo['supplier_nc_capa_id'])) ? $supplierIdInfo['supplier_nc_capa_id'] : null;
        $length = 4;
        if (!$supplierId) {
            $og_length = $length - 1;
            $last_number = '1';
        } else {
            $code = substr($supplierId, strlen($prefix));
            $increment_last_number = ((int)$code) + 1;
            $last_number_length = strlen($increment_last_number);
            $og_length = $length - $last_number_length;
            $last_number = $increment_last_number;
        }
        $zeros = "";
        for ($i = 0; $i < $og_length; $i++) {
            $zeros .= "0";
        }
        $supplier_nc_capa_id = $prefix . $zeros . $last_number;
        $addSql = "INSERT INTO `supplier_nc_capa_ncr_details` (`supplier_nc_capa_id`,`supplier_id`, `date`, `delivery_note`, `po_number`, `line_item`, `part_number`, `part_description`, `serial_no`, `material`, `lot_quantity`, `inspected_quantity`, `accepted_quantity`, `qty_nc`,`stock_affected`,`ncr_classification`,`classification_details`,`action_with_nc_material`, `non_conformance_description`) VALUES ('$supplier_nc_capa_id','$supplier_id', '$date', '$delivery_note', '$po_number', '$line_item', '$part_number', '$part_description', '$serial_no', '$material', '$lot_quantity', '$inspected_quantity', '$accepted_quantity', '$qty_nc','$stock_affected','$ncr_classification','$classification_details','$action_with_nc_material','$non_conformance_description');";
        $addResult = mysqli_query($con, $addSql);
        $addedId = mysqli_insert_id($con);

        $description_of_action = $_POST["description_of_action"];
        $responsible = $_POST["responsible"];
        $target_date = $_POST["target_date"];
        foreach ($description_of_action as $key => $val) {
            $addListSql = "INSERT INTO supplier_nc_capa_analysis_ncr_modal (supplier_nc_capa_ncr_details_id, description_of_action, responsible, target_date) VALUES ('$addedId', '$description_of_action[$key]', '$responsible[$key]', '$target_date[$key]')";
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
                    $addFileSql = "INSERT INTO supplier_nc_capa_ncr_details_files (supplier_nc_capa_ncr_details_id, file_path, file_name) VALUES ('$addedId', '$filePath', '$fileName')";
                    $addFileConnect = mysqli_query($con, $addFileSql);
                }
            }
        }

        $supplierSql = "SELECT * From basic_supplier Where Id_Supplier = '$supplier_id'";
        $fetchSupplier = mysqli_query($con, $supplierSql);
        $supplierInfo = mysqli_fetch_assoc($fetchSupplier);
        $suplierEmail = $supplierInfo['Email_Primary'];
        $suplierName = $supplierInfo['Supplier_Name'];

        $token = bin2hex(random_bytes(16));
        // Add a recipient 
        $mail->addAddress($suplierEmail);
        $tokenUrl = $app_url . "supplier_entry.php?token=$token";
        $mail->Subject = 'Supplier Entry Portal';
        $mail->isHTML(true);
        $mailContent = '<body style="background-color: #e1e1e2;"> <div style="width: 100%;height: 100%;">
        <div
            style="padding: 30px;font-size: 20px;font-weight: 700;font-family: system-ui; text-align:center;">
            <span>JC Valves</span>
        </div>
        <div style="margin-left:25%; margin-bottom:20px">
            <div
                style="background-color: #fff;width: 550px;height: 350px; margin-bottom:30px;box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;">
                <div style="padding: 20px;">
                    <h4 style="font-family: system-ui;color: #8d8888">Hello ' . $suplierName . '</h4>
                    <p style="font-family: system-ui;color: #a7a3a3">Welcome to JC Valves!</p>
                    <p style="font-family: system-ui;color: #a7a3a3">Your Supplier entry portal URL has been generated
                        You can access the portal via below URL
                    </p>
                    <p style="font-family: system-ui;color: #a7a3a3">URL : ' . $tokenUrl . '
                    </p>
                </div>
            </div>
            <div
            style="padding: 30px;font-size: 20px;font-weight: 700;font-family: system-ui; text-align:center;">
        </div>
        </div>
    </div></body>';
        $mail->Body = $mailContent;
        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $addToken = "INSERT INTO supplier_nc_capa_token (supplier_nc_capa_ncr_details_id, token) VALUES ('$addedId', '$token')";
            $tokenResult = mysqli_query($con, $addToken);
        }

        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../supplier_nc_capa_view_list.php");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}