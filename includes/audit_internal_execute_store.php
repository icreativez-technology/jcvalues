<?php
session_start();
include('functions.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['usuario']) {
        $audit_id = $_POST["audit_id"];
        $audit_area_check_list_id = $_POST["audit_checklist_id"];
        $objective_evidence = $_POST["objective_evidence"];
        $is_ncr = isset($_POST["isNcr"]) && $_POST["isNcr"] != "" ? 1 : 0;
        $finding_type = $_POST["finding_type"];
        $finding_details = $_POST["finding_details"];
        $product_process_impact = $_POST["product_process_impact"];
        $id = $_POST["audit_execute_id"];
        $fileName = strlen($_FILES["file"]["name"]) != 0 ? null : $_POST['extFileName'];
        $filePath = strlen($_FILES["file"]["name"]) != 0 ? null : $_POST['extFilePath'];
        if ($id == "") {
            if ($_FILES["file"]["name"]) {
                $directory = "../audit_internal_execution/" . $audit_area_check_list_id;
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $fileName = $_FILES["file"]["name"];
                $targetFile = $directory . basename($fileName);
                $destinationFolder = $directory . "/" . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
                $filePath = "audit_internal_execution/" . $audit_area_check_list_id . "/" . $fileName;
            }
            $addFileSql = "INSERT INTO audit_management_execute_check_list (audit_id, audit_area_check_list_id, objective_evidence, is_ncr, file_path, file_name, finding_type, finding_details, product_process_impact) VALUES ('$audit_id', '$audit_area_check_list_id', '$objective_evidence', '$is_ncr', '$filePath', '$fileName', '$finding_type', '$finding_details', '$product_process_impact')";
            $addFileConnect = mysqli_query($con, $addFileSql);
        } else {
            if (strlen($_FILES["file"]["name"]) != 0) {
                unlink("../" . $_POST['extFilePath']);
                if ($_FILES["file"]["name"]) {
                    $directory = "../audit_internal_execution/" . $audit_area_check_list_id;
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);
                    }
                    $fileName = $_FILES["file"]["name"];
                    $targetFile = $directory . basename($fileName);
                    $destinationFolder = $directory . "/" . $fileName;
                    move_uploaded_file($_FILES["file"]["tmp_name"], $destinationFolder);
                    $filePath = "audit_internal_execution/" . $audit_area_check_list_id . "/" . $fileName;
                }
            }
            $updateSql = "UPDATE audit_management_execute_check_list SET objective_evidence = '$objective_evidence', is_ncr = '$is_ncr', file_path = '$filePath', file_name = '$fileName', finding_type = '$finding_type', finding_details = '$finding_details', product_process_impact = '$product_process_impact' WHERE audit_area_check_list_id = '$audit_area_check_list_id' AND id = '$id'";
            $updateResult = mysqli_query($con, $updateSql);
        }

        echo "<script type='text/javascript'>alert('Success!');</script>";
        header("Location: ../audit_management_edit.php?id=$audit_id&view&execute");
    } else {
        $msg = "¡¡You are not logged in, connect to be able to add correctly!!";
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Try again');</script>";
}